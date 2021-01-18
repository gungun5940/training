<?php

class News_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_objTable = "news";
    private $_table = "news n LEFT JOIN news_type nt ON n.new_type_id=nt.type_id
    						  LEFT JOIN staff s ON n.new_user_id=s.staff_id";
    private $_field = "n.*, nt.type_name, s.staff_prename, s.staff_firstname, s.staff_lastname";
    private $_cutNamefield = "new_";

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

        if( isset($_REQUEST['type']) ){
        	$options['type'] = $_REQUEST['type'];
        }
        if( !empty($options['type']) ){
        	$where_str .= !empty($where_str) ? " AND " : "";
            $where_str .= "{$this->_cutNamefield}type_id=:type";
            $where_arr[":type"] = $options['type'];
        }

        if( isset($_REQUEST['status']) ){
        	$options['status'] = $_REQUEST['status'];
        }
        if( !empty($options['status']) ){
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
        $sth = $this->db->prepare("SELECT {$this->_field} FROM {$this->_table} WHERE {$condition} LIMIT 1");
        $sth->execute( $params );

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ) )
            : array();
    }
    public function primarylink($text, $options=array()) {
        $where_str = "n.new_primarylink=:text";
        $where_arr[':text'] = $text;

        if( !empty($options['status']) ){

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "n.new_status=:status";
            $where_arr[':status'] = $options['status'];
        }

        $sth = $this->db->prepare("SELECT {$this->_field} FROM {$this->_table} WHERE {$where_str} LIMIT 1");
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
    public function convert($data){
    	$data = $this->cut( $this->_cutNamefield, $data );
    	$data['status_name'] = $this->getStatus( $data['status'] );
        if( !empty($data['image_id']) ){
            $image = $this->load('media')->get($data['image_id']);
            if( !empty($image) ){
                $data['image_arr'] = $image;
                $data['image_url'] = $image['url'];
            }
        }
        else{
            $data['image_url'] = IMAGES.'error/image-not-found.png';
        }
    	return $data;
    }

    /* OPTIONS */
    public function type(){
        return $this->db->query("SELECT type_id AS id, type_name AS name, type_primarylink AS primarylink FROM news_type ORDER BY id ASC");
    }
    public function status(){
    	$a = [];
    	$a[] = ['id'=>'enabled', 'name'=>'แสดงผล'];
    	$a[] = ['id'=>'disabled', 'name'=>'ไม่แสดงผล'];
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
}