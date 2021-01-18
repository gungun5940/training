<?php

class Course_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_objTable = "course";
    private $_table = "course";
    private $_field = "*";
    private $_cutNamefield = "course_";

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

        if( !empty($options["q"]) ){
            $where_str .= !empty($where_str) ? " AND " : "";
            $where_str .= "({$this->_cutNamefield}name_th LIKE :q
                            OR {$this->_cutNamefield}name_en LIKE :q
                            OR {$this->_cutNamefield}code LIKE :q)";
            $where_arr[':q'] = "%{$options['q']}%";
        }
        
        if( isset($_REQUEST["status"]) ){
            $options["status"] = $_REQUEST["status"];
        }
        if( isset($options["status"]) && is_numeric($options["status"]) ){
            $where_str .= !empty($where_str) ? " AND " : "";
            $where_str .= "{$this->_cutNamefield}status=:status";
            $where_arr[":status"] = $options['status'];
        }

        if( isset($_REQUEST["open_status"]) ){
            $options["open_status"] = $_REQUEST["open_status"];
        }
        if( isset($options["open_status"]) && is_numeric($options["open_status"]) ){
            $where_str .= !empty($where_str) ? " AND " : "";
            $where_str .= "{$this->_cutNamefield}open_status=:open_status";
            $where_arr[":open_status"] = $options['open_status'];
        }

        $arr['total'] = $options['total'] = $this->db->count($this->_table, $where_str, $where_arr);

        $limit = $this->limited( $options['limit'], $options['pager'] );
        $orderby = $this->orderby( $this->_cutNamefield.$options['sort'], $options['dir'] );
        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $arr['lists'] = $this->buildFrag( $this->db->query("SELECT {$this->_field} FROM {$this->_table} {$where_str} {$orderby} {$limit}", $where_arr ), $options );

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
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ), $options )
            : array();
    }
    public function buildFrag($results, $options=[]) {
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convert( $value , $options );
        }
        return $data;
    }
    public function convert($data, $options=[]){
    	$data = $this->cut( $this->_cutNamefield, $data );
        $data['status_name'] = $this->getStatus( $data['status'] );
        $data['total_reg'] = $this->db->count( "member_register", "reg_course_id={$data['id']}" );
        if( !empty($options['lastopen']) ) $data['open'] = $this->getLastCourseOpen( $data['id'], ['status'=>1] );
        
        $data['permit']['del'] = true;
        if( !empty($data['total_reg']) ) $data['permit']['del'] = false;

        if( !empty($options['open']) ) $data['open'] = $this->CourseOpen( $data['id'] );

    	return $data;
    }

    /* OPEN COURSE */
    private $_openTable = "course_open cp LEFT JOIN course c ON cp.open_course = c.course_id";
    private $_openField = "*";
    private $_cutOpenNamefield = "open_";
    public function listsOpen( $options=[] ){
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

        if( !empty($options["q"]) ){
            $where_str .= !empty($where_str) ? " AND " : "";
            $where_str .= "({$this->_cutNamefield}name_th LIKE :q
                            OR {$this->_cutNamefield}name_en LIKE :q
                            OR {$this->_cutNamefield}code LIKE :q)";
            $where_arr[':q'] = "%{$options['q']}%";
        }

        if( isset($_REQUEST["price"]) ){
            $options["price"] = $_REQUEST["price"];
        }
        if( !empty($options['price']) ){
            $where_str .= !empty($where_str) ? " AND " : "";
            if( $options['price'] == 'free' ){
                $where_str .= "{$this->_cutOpenNamefield}price=:price";
            }
            if( $options['price'] == 'pay' ){
                $where_str .= "{$this->_cutOpenNamefield}price!=:price";
            }
            $where_arr[":price"] = '0.00';
        }
        
        if( isset($_REQUEST["status"]) ){
            $options["status"] = $_REQUEST["status"];
        }
        if( isset($options["status"]) && is_numeric($options["status"]) ){
            $where_str .= !empty($where_str) ? " AND " : "";
            $where_str .= "{$this->_cutOpenNamefield}status=:status";
            $where_arr[":status"] = $options['status'];
        }

        $arr['total'] = $options['total'] = $this->db->count($this->_openTable, $where_str, $where_arr);

        $limit = $this->limited( $options['limit'], $options['pager'] );
        $orderby = $this->orderby( $this->_cutOpenNamefield.$options['sort'], $options['dir'] );
        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $arr['lists'] = $this->buildFragOpen( $this->db->query("SELECT {$this->_openField} FROM {$this->_openTable} {$where_str} {$orderby} {$limit}", $where_arr ), $options );

        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;

        return $arr;
    }
    public function CourseOpen($id=null){
        return $this->buildFragOpen( $this->db->query("SELECT * FROM course_open WHERE open_course={$id} ORDER BY open_startdate DESC") );
    }
    public function getCourseOpen( $id, $options=[] ){
        $condition = "`open_id`=:id";
        $params[':id'] = $id;

        if( isset($options['status']) ){
            $condition .= " AND `open_status`=:status";
            $params[':status'] = $options['status'];
        }
        $sth = $this->db->prepare("SELECT * FROM {$this->_openTable} WHERE {$condition} LIMIT 1");
        $sth->execute( $params );

        return $sth->rowCount()==1
            ? $this->convertOpen( $sth->fetch( PDO::FETCH_ASSOC ), $options )
            : array();
    }
    public function getLastCourseOpen( $id, $options=[] ){
        $condition = "`open_course`=:id";
        $params[':id'] = $id;

        if( isset($options['status']) ){
            $condition .= " AND `open_status`=:status";
            $params[':status'] = $options['status'];
        }
        $sth = $this->db->prepare("SELECT * FROM course_open WHERE {$condition} LIMIT 1");
        $sth->execute( $params );

        return $sth->rowCount()==1
            ? $this->convertOpen( $sth->fetch( PDO::FETCH_ASSOC ), $options )
            : array();
    }
    public function buildFragOpen( $results ){
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convertOpen( $value );
        }
        return $data;
    }
    public function convertOpen( $data ){
        $data = $this->cut($this->_cutOpenNamefield, $data);
        $data['total_reg'] = $this->db->count( "member_register", "reg_open_id={$data['id']}" );
        $data['total_confirm'] = $this->db->count( "member_register", "reg_open_id={$data['id']} AND reg_status=1" );
        $data['status_name'] = $this->getStatusOpen( $data['status'] );
        return $data;
    }
    public function insertOpen(&$data){
        $this->db->insert("course_open", $data);
        $data['id'] = $this->db->lastInsertId();
    }
    public function updateOpen($id, $data){
        $this->db->update("course_open", $data, "open_id={$id}");
    }
    public function deleteOpen($id){
        $this->db->delete("course_open", "open_id={$id}");
    }
    public function getListsRegCourse( $id, $options=[] ){
        $condition = "reg.reg_open_id={$id}";
        if( !empty($options['status']) ){
            $condition .= " AND reg.reg_status={$options['status']}";
        }
        return $this->buildFragReg( 
                        $this->db->query("SELECT reg.* , 
                                                 m.mem_prename, 
                                                 m.mem_firstname, 
                                                 m.mem_lastname 
                                            FROM member_register reg 
                                            LEFT JOIN member m ON reg.mem_id=m.mem_id 
                                        WHERE {$condition}"
                        ) 
                );
    }
    public function getListsReg( $id ){
        return $this->buildFragReg( 
                        $this->db->query("SELECT reg.* , 
                                                 m.mem_prename, 
                                                 m.mem_firstname, 
                                                 m.mem_lastname 
                                        FROM member_register reg 
                                        LEFT JOIN member m ON reg.mem_id=m.mem_id 
                                    WHERE reg.reg_course_id={$id}"
                        ) 
                );
    }
    public function getRegisterCourse($mem_id, $open_id){
        $sth = $this->db->prepare("SELECT reg.* 
                , m.mem_prename
                , m.mem_firstname
                , m.mem_lastname 
            FROM member_register reg 
            LEFT JOIN member m ON reg.mem_id=m.mem_id 
           WHERE reg.mem_id=:mem_id AND reg.reg_open_id=:open_id LIMIT 1");
        $params = [":mem_id"=>$mem_id, ":open_id"=>$open_id];
        $sth->execute( $params );
        return $sth->rowCount()==1
        ? $this->convertReg( $sth->fetch( PDO::FETCH_ASSOC ) )
        : array();
    }
    public function buildFragReg( $results ){
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convertReg( $value );
        }
        return $data;
    }
    public function convertReg( $data ){
        $data = $this->cut('reg_', $data);
        $data['mem_fullname'] = "{$this->load('system')->getPrefixName($data['mem_prename'])}{$data['mem_firstname']} {$data['mem_lastname']}";
        $data['status_name'] = $this->getStatusReg( $data['status'] );
        $data['status_pay_name'] = $this->getStatusPay( $data['pay_status'] );
        return $data;
    }
    public function checkReg($id){
        $data = [];
        $check = $this->db->query("SELECT reg_open_id AS open_id 
                                   FROM member_register 
                                   WHERE mem_id={$id}");
        if( !empty($check) ){
            foreach ($check as $key => $value) {
                $data[] = $value['open_id'];
            }
        }
        return $data;
    }
    public function registerCourse(&$data){
        $this->db->insert("member_register", $data);
    }
    public function updateRegisterCourse($mem_id, $open_id, $data){
        $this->db->update("member_register", $data, "mem_id={$mem_id} AND reg_open_id={$open_id}");
    }
    public function delRegisterCourse($mem_id, $open_id){
        $this->db->delete("member_register", "mem_id={$mem_id} AND reg_open_id={$open_id}");
    }
    public function checkCourseOpen($course){
        return $this->db->count("course_open", "open_course=:course AND open_status=1", [":course"=>$course]);
    }

    /* OPTIONS */
    public function status(){
    	$a = [];
    	$a[] = ['id'=>1, 'name'=>'ปกติ'];
    	$a[] = ['id'=>0, 'name'=>'ยกเลิก'];
    	return $a;
    }
    public function getStatus($id){
    	$data = '';
    	foreach ($this->status() as $key => $value) {
    		if( $id == $value['id'] ){
    			$data = $value['name'];
    			break;
    		}
    	}
    	return $data;
    }
    public function statusOpen(){
        $a = [];
        $a[] = ['id'=>2, 'name'=>'จบหลักสูตร'];
        $a[] = ['id'=>1, 'name'=>'เปิดหลักสูตร'];
        $a[] = ['id'=>0, 'name'=>'ปิดหลักสูตร'];
        return $a;
    }
    public function getStatusOpen($id){
        $data = '';
        foreach ($this->statusOpen() as $key => $value) {
            if( $id == $value['id'] ){
                $data = $value['name'];
                break;
            }
        }
        return $data;
    }
    public function statusReg(){
        $a = [];
        $a[] = ['id'=>0, 'name'=>'รอการอนุมัติ'];
        $a[] = ['id'=>1, 'name'=>'อนุมัติ'];
        $a[] = ['id'=>2, 'name'=>'ยกเลิก'];
        return $a;
    }
    public function getStatusReg($id){
        $data = '';
        foreach ($this->statusReg() as $key => $value) {
            if( $id == $value['id'] ){
                $data = $value['name'];
                break;
            }
        }
        return $data;
    }
    public function statusPay(){
        $a = [];
        $a[] = ['id'=>0, 'name'=>'รอการชำระเงิน'];
        $a[] = ['id'=>1, 'name'=>'อนุมัติการชำระเงิน'];
        $a[] = ['id'=>2, 'name'=>'รอตรวจสอบหลักฐาน'];
        $a[] = ['id'=>3, 'name'=>'การชำระเงินมีปัญหา'];
        $a[] = ['id'=>9, 'name'=>'ไม่มีค่าใช้จ่าย'];
        return $a;
    }
    public function getStatusPay($id){
        $data = '';
        foreach ($this->statusPay() as $key => $value) {
            if( $id == $value['id'] ){
                $data = $value['name'];
                break;
            }
        }
        return $data;
    }
}