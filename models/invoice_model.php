<?php

class Invoice_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_objTable = "invoices";
    private $_table = "invoices";
    private $_field = "*";
    private $_cutNamefield = "inv_";

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
            $where_str .= "({$this->_cutNamefield}firstname LIKE :q
                            OR {$this->_cutNamefield}lastname LIKE :q
                            OR {$this->_cutNamefield}code LIKE :q)";
            $where_arr[':q'] = "%{$options['q']}%";
        }
        
        if( isset($_REQUEST["status"]) ){
            $options["status"] = $_REQUEST["status"];
        }
        if( !empty($options["status"]) ){
            $where_str .= !empty($where_str) ? " AND " : "";
            $where_str .= "{$this->_cutNamefield}status=:status";
            $where_arr[":status"] = $options['status'];
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
    public function getInvoiceByRegister( $options=[] ){
        $condition = "";
        $params = array();

        if( !empty($options['member']) ){
            $condition .= !empty($condition) ? " AND " : "";
            $condition .= "{$this->_cutNamefield}mem_id=:member";
            $params[':member'] = $options['member'];
        }
        if( !empty($options['course']) ){
            $condition .= !empty($condition) ? " AND " : "";
            $condition .= "{$this->_cutNamefield}course_id=:course";
            $params[':course'] = $options['course'];
        }
        if( !empty($options['open']) ){
            $condition .= !empty($condition) ? " AND " : "";
            $condition .= "{$this->_cutNamefield}open_id=:open";
            $params[':open'] = $options['open'];
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
        $data['district'] = $this->load("system")->getDistricts( $data['add_district_id'] );
        $data['amphure'] = $this->load("system")->getAmphures( $data['add_amphure_id'] );
        $data['province'] = $this->load("system")->getProvince( $data['add_province_id'] );
    	return $data;
    }

    /* OPTIONS */
    public function status(){
        $a = [];
        $a[] = ['id'=>'waiting', 'name'=>'รอตรวจสอบ'];
        $a[] = ['id'=>'approved', 'name'=>'อนุมัติ'];

        return $a;
    }
    public function getStatus( $id ){
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