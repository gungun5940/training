<?php

class Members extends Controller {

    function __construct() {
        parent::__construct();
    }

    private $_pathMng = "Themes/manage/pages/members/forms";

    public function index(){
    	$this->error();
    }

    /* public function add(){
    	if( empty($this->me) || $this->format != "json" ) $this->error();

    	$this->view->setData('gender', $this->model->gender());
    	$this->view->setData('status', $this->model->status());
    	$this->view->setPage('path', $this->_pathMng);
    	$this->view->render('add');
    } */

    public function save(){
    	if( empty($_POST) ) $this->error();

    	$id = isset($_POST['id']) ? $_POST['id'] : null;
    	if( !empty($id) ){
    		$item = $this->model->get($id);
    		if( empty($item) ) $this->error();
    	}

    	try{
    		$form = new Form();
    		$form 	->post('mem_prename')->val('is_empty')
    				->post('mem_firstname')->val('is_empty')
    				->post('mem_lastname')->val('is_empty')
    				->post('mem_gender')->val('is_empty')
    				->post('mem_birth')->val('is_empty')
                    // ->post('mem_code')->val('is_empty')->val('minlength', 13)->val('maxlength', 13)
                    ->post('mem_job')->val('is_empty')
                    ->post('mem_work_place')->val('is_empty')
    			    ->post('mem_add_num')->val('is_empty')
    			    ->post('mem_add_street')->val('is_empty')
                    ->post('mem_add_province_id')->val('is_empty')
                    ->post('mem_add_amphure_id')->val('is_empty')
                    ->post('mem_add_district_id')->val('is_empty')
                    ->post('mem_add_zipcode')->val('is_empty')
                    ->post('mem_contact')->val('is_empty')
                    ->post('mem_email')->val('is_empty')
    				->post('mem_startdate')->val('is_empty')
    				->post('mem_username')->val('is_empty')
    				->post('mem_status')->val('is_select_num');
    		$form->submit();
    		$postData = $form->fetch();

    		if( empty($item) ){
    			$postData['mem_password'] = $_POST['mem_password'];
                if( empty($postData['mem_password']) ){
                    $arr['error']['mem_password'] = 'กรุณากรอกรหัสผ่าน';
                }else if( strlen($postData['mem_password']) < 4 ){
                    $arr['error']['mem_password'] = 'รหัสผ่านของคุณมีจำนวนต่ำกว่า 4 ตัวอักษร';
                }
    		}

    		$checkUser = true;
    		if( !empty($item) ){
    			if( $item['username'] == $postData['mem_username'] ) $checkUser = false;
    		}
    		if( $this->model->is_user($postData['mem_username']) && $checkUser ){
    			$arr['error']['mem_username'] = 'ตรวจสอบพบข้อมูล Username ซ้ำในระบบ';
    		}

            // $checkCode = true;
            // if( !empty($item) ){
            //     if( $item['code'] == $postData['mem_code'] ) $checkCode = false;
            // }
            // if( $this->model->is_code($postData['mem_code']) && $checkCode ){
            //     $arr['error']['mem_code'] = 'ตรวจสอบพบข้อมูล รหัสบัตรประชาชนนี้ ซ้ำในระบบ';
            // }

    		if( empty($arr['error']) ){

                 $postData['mem_birth'] = $this->fn->q('time')->DateJQToPHP( $postData['mem_birth'] );
                if( !empty($postData['mem_startdate']) ) {
                    $postData['mem_startdate'] = $this->fn->q('time')->DateJQToPHP( $postData['mem_startdate'] );
                } 

    			if( empty($item) ){
                    $postData['mem_password'] = $this->fn->q('password')
                                                ->PasswordHash($postData['mem_password']);
    				$this->model->insert($postData);
    			}
    			else{
    				$this->model->update($id, $postData);
    			}

                if (!empty($_POST["front"])) {
    			     $arr['message'] = [
    				    "type" => "success",
    				    "text" => "ลงทะเบียนข้อมูลเรียบร้อยแล้ว",
                        "detail"=> "ผู้ดูแลระบบจะทำการอนุมัติผู้ใช้งานภายใน 1-2 วันทำการ",
                        "confirm"=> true
    			     ];
                }
                else{
                    $arr['message'] = [
                        "type" => "success",
                        "text" => "บันทึกข้อมูลเรียบร้อย",
                     ];
                }
    			$arr['url'] = isset($_POST["next"]) ? $_POST["next"] : "refresh";
    		}


    	} catch (Exception $e) {
    		$arr['error'] = $this->_getError($e->getMessage());
    		if( !empty($arr['error']['mem_firstname']) ){
                $arr['error']['name'] = $arr['error']['mem_firstname'];
            } else if( !empty($arr['error']['mem_lastname']) ){
                $arr['error']['name'] = $arr['error']['mem_lastname'];
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
                $this->model->update($id, ['mem_password'=>$password]);

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
    public function setData($id=null, $field=null){
        if( empty($id) || empty($field) || empty($this->me) ) $this->error();

        $data[$field] = isset($_REQUEST['value'])? $_REQUEST['value']:'';
        $this->model->update($id, $data);

        $arr['message'] = 'บันทึกข้อมูลเรียบร้อย';
        echo json_encode($arr);
    }

    /* JQUERY ZONE */
    public function getProvinceByCode( $code=null ){
        $subCode = substr($code, 0, 2);
        $data = $this->model->load('system')->getProvinceByCode( $subCode );
        echo json_encode($data);
    }
    public function getAmphuresByProvince( $province_id=null ){
        $data = $this->model->load('system')->getAmphuresByProvince( $province_id );
        echo json_encode($data);
    }
    public function getDistrictsByAmphure( $amphure_id=null ){
        $data = $this->model->load('system')->getDistrictsByAmphure( $amphure_id );
        echo json_encode($data);
    }
    public function geteAmphureByZipcode( $zipcode=null ){
        $data = $this->model->load('system')->geteAmphureByZipcode( $zipcode );
        echo json_encode($data);
    }
}