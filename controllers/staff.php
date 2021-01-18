<?php

class Staff extends Controller {

    function __construct() {
        parent::__construct();
    }

    private $_pathMng = "Themes/manage/forms/staff";

    public function index(){
    	$this->error();
    }

    public function add(){
    	if( empty($this->me) || $this->format != "json" ) $this->error();

    	$this->view->setData('level', $this->model->level());
    	$this->view->setData('status', $this->model->status());
    	$this->view->setPage('path', $this->_pathMng);
    	$this->view->render('add');
    }
    public function edit($id=null){
    	$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $id;
    	if( empty($id) || empty($this->me) || $this->format != "json" ) $this->error();

    	$item = $this->model->get($id);
    	if( empty($item) ) $this->error();

    	$this->view->setData('item', $item);
    	$this->view->setData('level', $this->model->level());
    	$this->view->setData('status', $this->model->status());
    	$this->view->setPage('path', $this->_pathMng);
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
    		$form 	->post('staff_username')->val('is_empty')
    				->post('staff_prename')->val('is_empty')
    				->post('staff_firstname')->val('is_empty')
    				->post('staff_lastname')->val('is_empty')
    				->post('staff_refno')
    				->post('staff_level')->val('is_empty')
    				->post('staff_status')->val('is_select_num');
    		$form->submit();
    		$postData = $form->fetch();

    		if( empty($item) ){
    			$postData['staff_password'] = $_POST['staff_password'];
                if( empty($postData['staff_password']) ){
                    $arr['error']['staff_password'] = 'กรุณากรอกรหัสผ่าน';
                }else if( strlen($postData['staff_password']) < 4 ){
                    $arr['error']['staff_password'] = 'รหัสผ่านของคุณมีจำนวนต่ำกว่า 4 ตัวอักษร';
                }
    		}

    		$checkUser = true;
    		if( !empty($item) ){
    			if( $item['username'] == $postData['staff_username'] ) $checkUser = false;
    		}

    		if( $this->model->is_user($postData['staff_username']) && $checkUser ){
    			$arr['error']['staff_username'] = 'ตรวจสอบพบข้อมูล Username ซ้ำในระบบ';
    		}

    		if( empty($arr['error']) ){

    			if( empty($item) ){
                    $postData['staff_password'] = $this->fn->q('password')
                                                ->PasswordHash($postData['staff_password']);
    				$this->model->insert($postData);
    			}
    			else{
    				$this->model->update($id, $postData);
    			}

    			$arr['message'] = [
    				"type" => "success",
    				"text" => "บันทึกข้อมูลเรียบร้อยแล้ว"
    			];
    			$arr['url'] = "refresh";
    		}

    	} catch (Exception $e) {
    		$arr['error'] = $this->_getError($e->getMessage());
    		if( !empty($arr['error']['staff_firstname']) ){
                $arr['error']['name'] = $arr['error']['staff_firstname'];
            } else if( !empty($arr['error']['staff_lastname']) ){
                $arr['error']['name'] = $arr['error']['staff_lastname'];
            }
    	}
    	echo json_encode($arr);
    }
    public function del($id=null){
        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $id;
        if( empty($id) || $this->format != "json" ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        if( !empty($_POST) ){
            if( !empty($item['permit']['del']) ){
                $this->model->delete($id);

                $arr['message'] = "ลบข้อมูลเรียบร้อยแล้ว";
                $arr['url'] = 'refresh';
            }
            else{
                $arr['message'] = ['type'=>'error', 'text'=>'ไม่สามารถลบข้อมูลได้'];
            }
            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->setPage('path', $this->_pathMng);
            $this->view->render('del');
        }
    }
    public function password($id=null){
        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $id;
        if( empty($id) || $this->format != "json" ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        if( !empty($_POST) ){

            if( empty($_POST['password']) ) $arr['error']['password'] = 'กรุณากรอกรหัสผ่าน';
            if( empty($_POST['confirm_password']) ) $arr['error']['confirm_password'] = 'กรุณากรอกยืนยันรหัสผ่าน';

            if( !empty($_POST['password']) && !empty($_POST['confirm_password']) ){
                if( $_POST["password"] != $_POST["confirm_password"] ){
                    $arr['error']['password'] = 'รหัสผ่านทั้งสองช่องต้องตรงกัน';
                    $arr['error']['confirm_password'] = 'รหัสผ่านทั้งสองช่องต้องตรงกัน';
                }
                else{
                    if( strlen($_POST["password"]) < 4 ){
                        $arr['error']['password'] = 'รหัสผ่านต้องมี 4 ตัวอักษรขึ้นไป';
                        $arr['error']['confirm_password'] = 'รหัสผ่านต้องมี 4 ตัวอักษรขึ้นไป';
                    }
                }
            }

            if( empty($arr['error']) ){
                $password = $this->fn->q('password')->PasswordHash( $_POST['password'] );
                $this->model->update($id, ['staff_password'=>$password]);

                $arr['message'] = [
                    'type'=>'success', 
                    'text'=>'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว',
                    'detail' => 'ผู้ใช้ : '.$item['username'].' สามารถใช้งานรหัสผ่านใหม่ได้ทันที'
                ];
            }

            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->setPage('path', $this->_pathMng);
            $this->view->render('password');
        }
    }
}