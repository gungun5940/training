<?php

class webinfo_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_objName = "webinfo";
    private $_table = "webinfo";
    private $_field = "*";
    private $_cutNamefield = "info_";

    public function insert(&$data){
    	$this->db->insert($this->_objName, $data);
    	$data["id"] = $this->db->LastInsertId();
    }
    public function update($id, $data){
    	$this->db->update($this->_objName, $data, "{$this->_cutNamefield}id={$id}");
    }
    public function delete($id){
    	$this->db->delete($this->_objName, "{$this->_cutNamefield}id={$id}");
    }
    public function lists( $options=array() ){
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

        if( isset($_REQUEST['status']) ){
        	$options['status'] = $_REQUEST['status'];
        }
        if( !empty($options['status']) ){
        	$where_str .= !empty($where_str) ? " AND " : "";
            $where_str .= "{$this->_cutNamefield}status=:status";
            $where_arr[":status"] = $options['status'];
        }

        $arr['total'] = $this->db->count($this->_table, $where_str, $where_arr);

        $limit = $this->limited( $options['limit'], $options['pager'] );
        $orderby = $this->orderby( $this->_cutNamefield.$options['sort'], $options['dir'] );
        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $arr['lists'] = $this->buildFrag( $this->db->query("SELECT {$this->_field} FROM {$this->_table} {$where_str} {$orderby} {$limit}", $where_arr ) );

        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;

        return $arr;
    }
    public function get($id, $options=array() ){

        $sth = $this->db->prepare("SELECT {$this->_field} FROM {$this->_table} WHERE {$this->_cutNamefield}id=:id LIMIT 1");
        $sth->execute( array(':id'=>$id) );

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ) )
            : array();
    }
    public function primarylink($text, $options=array()) {
        $where_str = "{$this->_cutNamefield}primarylink=:t";
        $where_arr[':t'] = $text;

        if( !empty($options['status']) ){

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "{$this->_cutNamefield}status=:status";
            $where_arr[':status'] = $options['status'];
        }

        $sth = $this->db->prepare("SELECT {$this->_field} FROM {$this->_table} WHERE {$where_str} LIMIT 1");
        $sth->execute( $where_arr );

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ), $options )
            : array();
    }
    public function getTopLists($options=array()) {
    	$where_str = '';
    	$where_arr = [];
        if( !empty($options['status']) ){
            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "{$this->_cutNamefield}status=:status";
            $where_arr[':status'] = $options['status'];
        }
        $where_str = !empty($where_str) ?  "WHERE {$where_str}" : "";
        $sth = $this->db->prepare("SELECT {$this->_field} FROM {$this->_table} {$where_str} ORDER BY info_seq ASC LIMIT 1");
        $sth->execute( $where_arr );

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ), $options )
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
    public function convert( $data ){
    	$data = $this->cut($this->_cutNamefield, $data);
        $data['url'] = URL.'about/'.$data['primarylink'];
    	$data["status"] = $this->getStatus($data["status"]);
    	$data["permit"]["del"] = true; 
    	return $data;
    }
    public function status(){
    	$a[] = array("id"=>1, "name"=>"แสดงผล");
    	$a[] = array("id"=>0, "name"=>"ไม่แสดงผล");

    	return $a;
    }
    public function getStatus($id){
    	$data = array();
    	foreach ($this->status() as $key => $value) {
    		if( $value["id"] == $id ){
    			$data = $value;
    			break;
    		}
    	}
    	return $data;
    }
    public function is_name($name){
    	return $this->db->count($this->_objName, "{$this->_cutNamefield}name=:name", array(":name"=>$name));
    }
}