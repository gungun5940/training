<?php

class Members_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_objTable = "member";
    private $_table = "member";
    private $_field = "*";
    private $_cutNamefield = "mem_";

    public function is_user($text){
        $c = $this->db->count($this->_objTable, "(mem_username=:txt AND mem_username!='')", array(':txt'=>$text));
        return $c;
    }
    public function is_code($text){
        $c = $this->db->count($this->_objTable, "(mem_code=:txt AND mem_code!='')", array(':txt'=>$text));
        return $c;
    }
    public function insert(&$data) {
        $this->db->insert($this->_objTable, $data);
        $data['id'] = $this->db->lastInsertId();

        $data = $this->cut($this->_cutNamefield, $data);
    }
    public function update($id, $data) {
        $this->db->update($this->_objTable, $data, "{$this->_cutNamefield}id={$id}");
    }
    public function delete($id) {
        $this->db->delete($this->_objTable, "{$this->_cutNamefield}id={$id}");
    }
    public function lists( $options=array() ) {

        $options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,
            'more' => true,

            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'created',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'DESC',
            
            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
            
            'q' => isset($_REQUEST['q'])? $_REQUEST['q']:null,

        ), $options);

        $date = date('Y-m-d H:i:s', $options['time']);

        $where_str = "";
        $where_arr = array();
        
        if( isset($_REQUEST["status"]) ){
            $options["status"] = $_REQUEST["status"];
        }
        if( isset($options["status"]) && is_numeric($options["status"]) ){
            $where_str .= !empty($where_str) ? " AND " : "";
            $where_str .= "{$this->_cutNamefield}status=:status";
            $where_arr[":status"] = $options['status'];
        }

        if( isset($_REQUEST["gender"]) ){
            $options["gender"] = $_REQUEST["gender"];
        }
        if( !empty($options["gender"]) ){
            $where_str .= !empty($where_str) ? " AND " : "";
            $where_str .= "{$this->_cutNamefield}gender=:gender";
            $where_arr[":gender"] = $options['gender'];
        }

        $arr['total'] = $options['total'] = $this->db->count($this->_table, $where_str, $where_arr);

        $limit = $this->limited( $options['limit'], $options['pager'] );
        $orderby = $this->orderby( $this->_cutNamefield.$options['sort'], $options['dir'] );
        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $arr['lists'] = $this->buildFrag( $this->db->query("SELECT {$this->_field} FROM {$this->_table} {$where_str} {$orderby} {$limit}", $where_arr ) );

        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;

        return $arr;
    }
    public function get($id, $options=array() ){

        $condition = "`{$this->_cutNamefield}id`=:id";
        $params[':id'] = $id;

        if( isset($options['status']) ){
            $condition .= " AND `{$this->_cutNamefield}status`=:status";
            $params[':status'] = $options['status'];
        }
        $sth = $this->db->prepare("SELECT {$this->_field} FROM {$this->_table} WHERE {$condition} LIMIT 1");
        $sth->execute( $params );

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ) )
            : array();
    }
    public function buildFrag($results) {
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convert( $value );
        }

        return $data;
    }
    public function convert($data){
    	$data = $this->cut( $this->_cutNamefield, $data );
    	$data['fullname'] = "{$this->load('system')->getPrefixName($data['prename'])}{$data['firstname']} {$data['lastname']}";
        $data['status_name'] = $this->getStatus( $data['status'] );

        $data['permit']['del'] = true;

    	return $data;
    }
    public function login($user, $pass){
    	$sth = $this->db->prepare("SELECT {$this->_cutNamefield}id AS id,
                                          {$this->_cutNamefield}password AS password 
                                   FROM {$this->_table} 
                                   WHERE {$this->_cutNamefield}username=:login");

        $sth->execute( array(
            ':login' => $user
        ) );

        $fdata = $sth->fetch( PDO::FETCH_ASSOC );
        if( $sth->rowCount()==1 ){
            if( password_verify($pass, $fdata['password']) ){
                return $fdata['id'];
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    private $_tableRegiter = "member_register mr 
                                LEFT JOIN course c ON mr.reg_course_id=c.course_id
                                LEFT JOIN course_open co ON mr.reg_open_id=co.open_id
                                LEFT JOIN staff s ON co.open_staff_id=s.staff_id";
    private $_objRegister = "member_register";
    private $_fieldRegister = "mr.*
                                , c.course_name_th
                                , c.course_name_en

                                , co.*

                                , s.staff_prename
                                , s.staff_firstname
                                , s.staff_lastname";
    private $_cutRegFirstName = "reg_";
    public function listsRegister( $options = [] ){
        $options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,
            'more' => true,

            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: $this->_cutRegFirstName.'date',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'DESC',
            
            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
            
            'q' => isset($_REQUEST['q'])? $_REQUEST['q']:null,

        ), $options);

        $date = date('Y-m-d H:i:s', $options['time']);

        $where_str = "";
        $where_arr = array();

        if( !empty($options['member']) ){
            $where_str .= !empty($where_str) ? " AND " : "";
            $where_str .= "mem_id=:member";
            $where_arr[':member'] = $options['member'];
        }

        if( !empty($options["q"]) ){
            $where_str .= !empty($where_str) ? " AND " : "";
            $where_str .= "(course_name_th LIKE :q
                            OR course_name_en LIKE :q
                            OR course_code LIKE :q)";
            $where_arr[':q'] = "%{$options['q']}%";
        }

        if( isset($_REQUEST["price"]) ){
            $options["price"] = $_REQUEST["price"];
        }
        if( !empty($options['price']) ){
            $where_str .= !empty($where_str) ? " AND " : "";
            if( $options['price'] == 'free' ){
                $where_str .= "open_price=:price";
            }
            if( $options['price'] == 'pay' ){
                $where_str .= "open_price!=:price";
            }
            $where_arr[":price"] = '0.00';
        }

        $arr['total'] = $options['total'] = $this->db->count($this->_tableRegiter, $where_str, $where_arr);

        $limit = $this->limited( $options['limit'], $options['pager'] );
        $orderby = $this->orderby( $options['sort'], $options['dir'] );
        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $arr['lists'] = $this->buildFragReg( $this->db->query("SELECT {$this->_fieldRegister} FROM {$this->_tableRegiter} {$where_str} {$orderby} {$limit}", $where_arr ), $options );

        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;

        return $arr;
    }
    public function getRegister($mem_id, $course_id, $open_id, $options=[]){

        $condition = "`mem_id`=:mem_id AND `reg_course_id`=:course_id AND `reg_open_id`=:open_id";
        $params[':mem_id'] = $mem_id;
        $params[':course_id'] = $course_id;
        $params[':open_id'] = $open_id;

        if( isset($options['status']) ){
            $condition .= " AND `{$this->_cutRegFirstName}status`=:status";
            $params[':status'] = $options['status'];
        }
        if( isset($options['pay_status']) ){
            $condition .= " AND `{$this->_cutRegFirstName}pay_status`=:pay_status";
            $params[':pay_status'] = $options['pay_status'];
        }
        $sth = $this->db->prepare("SELECT {$this->_fieldRegister} FROM {$this->_tableRegiter} WHERE {$condition} LIMIT 1");
        $sth->execute( $params );

        return $sth->rowCount()==1
            ? $this->convertReg( $sth->fetch( PDO::FETCH_ASSOC ), $options )
            : array();
    }
    public function buildFragReg( $results, $options = [] ){
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convertReg( $value, $options );
        }

        return $data;
    }
    public function convertReg($data, $options = []){
        $data = $this->cut( $this->_cutRegFirstName, $data );
        $data['staff_fullname'] = "{$this->load('system')->getPrefixName($data['staff_prename'])}{$data['staff_firstname']} {$data['staff_lastname']}";
        $data['status_name'] = $this->load("course")->getStatusReg( $data['status'] );
        $data['status_pay_name'] = $this->load("course")->getStatusPay( $data['pay_status'] );

        if( !empty($options['invoice']) ){
            $data['invoice'] = $this->load("invoice")->getInvoiceByRegister( ['member'=>$data['mem_id'], 'course'=>$data['course_id'], 'open'=>$data['open_id']] );
        }

        return $data;
    }

    /* OPTION */
    public function status(){
        $a = [];
        $a[] = ['id'=>0, 'name'=>'ร้องขอ'];
        $a[] = ['id'=>1, 'name'=>'อนุมัติ'];
        $a[] = ['id'=>2, 'name'=>'ยกเลิก'];
        return $a;
    }
    public function getStatus($id){
        $data = [];
        foreach ($this->status() as $key => $value) {
            if( $id == $value['id'] ){
                $data = $value['name'];
                break;
            }
        }
        return $data;
    }

    public function gender(){
        $a = [];
        $a[] = ['id'=>1, 'name'=>'ชาย'];
        $a[] = ['id'=>2, 'name'=>'หญิง'];
        return $a;
    }
    public function getGender($id){
        $data = [];
        foreach ($this->gender() as $key => $value) {
            if( $id == $value['id'] ){
                $data = $value['name'];
                break;
            }
        }
        return $data;
    }
}