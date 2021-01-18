<?php

class News_type extends Controller {

    function __construct() {
        parent::__construct();
    }

    private $_pathSett = "Themes/manage/forms/news";

    public function index(){
    	$this->error();
    }

    public function add(){
    	if( empty($this->me) || $this->format != "json" ) $this->error();
    	$this->view->setPage('path', $this->_pathSett);
    	$this->view->render('add');
    }
    public function edit($id=null){
    	if( empty($id) || empty($this->me) || $this->format != "json" ) $this->error();

    	$item = $this->model->get($id);
    	if( empty($item) ) $this->error();

    	$this->view->setData('item', $item);
    	$this->view->setPage('path', $this->_pathSett);
    	$this->view->render('add');
    }
    public function save(){
    	if( empty($_POST) ) $this->error();

    	$id = isset($_POST["id"]) ? $_POST["id"] : null;
    	if( !empty($id) ){
    		$item = $this->model->get($id);
    		if( empty($item) ) $this->error();
    	}

    	try{
    		$form = new Form();
    		$form 	->post('type_name')->val('is_empty');
    		$form->submit();
    		$postData = $form->fetch();

    		$checkName = true;
    		if( !empty($item) ){
    			if( $item['name'] == $postData['type_name'] ) $checkName = false;
    		}
    		if( $this->model->check_name( $postData['type_name'] ) && $checkName ){
    			$arr['error']['type_name'] = 'ตรวจพบชื่อประเภท / หมวดหมู่ซ้ำในระบบ';
    		}

    		if( empty($arr['error']) ){
                $postData['type_primarylink'] = $this->fn->q('text')->createPrimarylink($postData['type_name']);
    			if( !empty($id) ){
    				$this->model->update($id, $postData);
    			}
    			else{
    				$this->model->insert($postData);
    			}

    			$arr['message'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
    			$arr['url'] = 'refresh';
    		}

    	} catch (Exception $e) {
    		$arr['error'] = $this->_getError($e->getMessage());
    	}
    	echo json_encode($arr);
    }
    public function del($id=null){
    	$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $id;
    	if( empty($id) || empty($this->me) || $this->format != "json" ) $this->error();

    	$item = $this->model->get($id);
    	if( empty($item) ) $this->error();

    	if( !empty($_POST) ){
    		if( !empty($item['permit']['del']) ){
    			$this->model->delete($id);

    			$arr['message'] = 'ลบข้อมูลเรียบร้อยแล้ว';
    			$arr['url'] = 'refresh';
     		}
    		else{
    			$arr['message'] = ['type'=>'warning', 'text'=>'ไม่สามารถลบข้อมูลได้'];
    		}
    		echo json_encode($arr);
    	}
    	else{
    		$this->view->setData("item", $item);
    		$this->view->setPage('path', $this->_pathSett);
    		$this->view->render('del');
    	}
    }
}