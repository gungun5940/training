<?php

class Staff_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_objTable = "staff";
    private $_table = "staff";
    private $_field = "*";
    private $_cutNamefield = "staff_";

    public function is_user($text){
        $c = $this->db->count('staff', "(staff_username=:txt AND staff_username!='')", array(':txt'=>$text));
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

        if( isset($_REQUEST["level"]) ){
            $options["level"] = $_REQUEST["level"];
        }
        if( !empty($options["level"]) ){
            $where_str .= !empty($where_str) ? " AND " : "";
            $where_str .= "{$this->_cutNamefield}level=:level";
            $where_arr[":level"] = $options['level'];
        }
        
        if( isset($_REQUEST["status"]) ){
            $options["status"] = $_REQUEST["status"];
        }
        if( isset($options["status"]) ){
            $where_str .= !empty($where_str) ? " AND " : "";
            $where_str .= "{$this->_cutNamefield}status=:status";
            $where_arr[":status"] = $options['status'];
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
    	$data['role_name'] = $this->getLevel( $data['level'] );

        $data['permit']['del'] = true;
        if( !empty($data['owner']) ) $data['permit']['del'] = false;

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

    /* OPTION */
    public function level(){
    	return $this->db->query("SELECT lev_id AS id, lev_name AS name FROM staff_level");
    }
    public function getLevel( $id ){
    	$sth = $this->db->prepare("SELECT lev_name AS name FROM staff_level WHERE lev_id=:id");

        $sth->execute( array(
            ':id' => $id
        ) );

        $fdata = $sth->fetch( PDO::FETCH_ASSOC );
        return $fdata['name'];
    }

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
}