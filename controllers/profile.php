<?php

class Profile extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->view->setPage('on', 'Profile');
        $this->view->setPage('title', 'ข้อมูลส่วนตัว');

        /* Use for DatePicker */
        $this->view->css('jquery-ui.min');
        $this->view->js('jquery/jquery-datepicker-th');
        $this->view->js('jquery/jquery-ui.min');
        /**/

        $this->view->setData('gender', $this->model->load('members')->gender());
        $this->view->setData('province', $this->model->load('system')->province());
        $this->view->render("profile/display");
    }

    public function password(){
        if( !empty($_POST) ){
            if( empty($_POST['old_password']) ) $arr['error']['old_password'] = 'กรุณากรอกรหัสผ่านเดิม';
            if( empty($_POST['new_password']) ) $arr['error']['new_password'] = 'กรุณากรอกรหัสผ่านใหม่';
            if( empty($_POST['confirm_password']) ) $arr['error']['confirm_password'] = 'กรุณากรอกยืนยันรหัสผ่านใหม่';

            if( !empty($_POST["old_password"]) && !empty($_POST['new_password']) && !empty($_POST['confirm_password']) ){

                if( !$this->model->load('members')->login($this->me['username'], $_POST['old_password']) ){
                    $arr['error']['old_password'] = 'รหัสผ่านไม่ถูกต้อง';
                }
                else{
                    if( $_POST["new_password"] != $_POST["confirm_password"] ){
                        $arr['error']['new_password'] = 'รหัสผ่านทั้งสองช่องต้องตรงกัน';
                        $arr['error']['confirm_password'] = 'รหัสผ่านทั้งสองช่องต้องตรงกัน';
                    }
                    else{
                        if( strlen($_POST["new_password"]) < 4 ){
                            $arr['error']['new_password'] = 'รหัสผ่านต้องมี 4 ตัวอักษรขึ้นไป';
                            $arr['error']['confirm_password'] = 'รหัสผ่านต้องมี 4 ตัวอักษรขึ้นไป';
                        }
                    }
                }
            }

            if( empty($arr['error']) ){
                $password = $this->fn->q('password')->PasswordHash( $_POST['new_password'] );
                $this->model->load('members')->update($this->me['id'], ['mem_password'=>$password]);

                $arr['message'] = [
                    'type'=>'success', 
                    'text'=>'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว',
                    'detail' => 'ผู้ใช้ : '.$this->me['username'].' สามารถใช้งานรหัสผ่านใหม่ได้ทันที'
                ];
            }

            echo json_encode($arr);
        }
        else{
            $this->view->setPage('on', 'Profile');
            $this->view->setPage('title', 'แก้ไขรหัสผ่าน');
            $this->view->render("profile/password");
        }
    }
}