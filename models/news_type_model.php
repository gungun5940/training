<?php

class News_Type_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_objTable = "news_type";
    private $_table = "news_type";
    private $_field = "*";
    private $_cutNamefield = "type_";

    public function check_name($text){
        $c = $this->db->count($this->_objTable, "({$this->_cutNamefield}name=:txt AND {$this->_cutNamefield}name!='')", array(':txt'=>$text));
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

            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'id',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'DESC',
            
            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
            
            'q' => isset($_REQUEST['q'])? $_REQUEST['q']:null,

        ), $options);

        $date = date('Y-m-d H:i:s', $options['time']);

        $where_str = "";
        $where_arr = array();

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
        $where_str = $this->_cutNamefield."primarylink=:text";
        $where_arr[':text'] = $text;
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
    	$data['total_news'] = $this->db->count('news', 'new_type_id=:id', [':id'=>$data['id']]);
        $data['permit']['del'] = true;
        if( !empty($data['total_news']) ){
        	$data['permit']['del'] = false;
        }
    	return $data;
    }
}