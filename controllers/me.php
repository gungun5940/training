<?php

class Me extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        
        // print_r($this->me); die;
        $this->error();
        // header('location:'.URL.'manage/products');
    }

    public function navTrigger() {
        if( $this->format!='json' ) $this->error();
        

        if( isset($_REQUEST['status']) ){

            Session::init();                          
            Session::set('isPushedLeft', $_REQUEST['status']);
        }
    }

    /* updated */
    /**/
    public function updated($avtive='') {

        if( empty($_POST) || empty($this->me) || $this->format!='json' || $avtive=="" ) $this->error();
        
        /**/
        /* account */
        if( $avtive=='account' ){
            try {
                $form = new Form();
                $form   ->post('user_login')->val('is_empty')
                        ->post('user_lang');

                $form->submit();
                $dataPost = $form->fetch();

                if( $this->model->load('users')->is_user( $dataPost['user_login'] ) && $this->me['login']!=$dataPost['user_login'] ){
                    $arr['error']['user_login'] = 'ชื่อผู้ใช้นี้ถูกใช้ไปแล้ว';
                }

                // Your login must be longer than 4 characters.
                if( empty($arr['error']) ){

                    $this->model->load('users')->update( $this->me['id'], $dataPost );
  
                    $arr['url'] = 'refresh';
                    $arr['message'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
                }
                
            } catch (Exception $e) {
                $arr['error'] = $this->_getError($e->getMessage());
            }

            echo json_encode($arr);
            exit;
        }
        /**/
        /* basic */
        else if( $avtive=='basic' ){

            try {
                $form = new Form();
                $form   ->post('staff_prename')
                        ->post('staff_firstname')->val('is_empty')
                        ->post('staff_lastname')
                        ->post('staff_descrip')
                        ->post('staff_mode');

                $form->submit();
                $dataPost = $form->fetch();

                if( empty($arr['error']) ){

                    $this->model->load('staff')->update( $this->me['id'], $dataPost );
  
                    $arr['url'] = 'refresh';
                    $arr['message'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
                }
                
            } catch (Exception $e) {
                $arr['error'] = $this->_getError($e->getMessage());
                if( !empty($arr['error']['staff_firstname']) ){
                    $arr['error']['name'] = $arr['error']['staff_firstname'];
                } 
                else if( !empty($arr['error']['staff_lastname']) ){
                    $arr['error']['name'] = $arr['error']['staff_lastname'];
                }
            }

            echo json_encode($arr);
            exit;
        }

        /**/
        /* password */
        if( $avtive=='password' ){

            $data = $_POST;
            $arr = array();
            if( !$this->model->load('staff')->login($this->me['username'], $data['password_old']) ){
                $arr['error']['password_old'] = "รหัสผ่านไม่ถูกต้อง";
            } elseif ( strlen($data['password_new']) < 4 ){
                $arr['error']['password_new'] = "รหัสผ่านสั้นเกินไป อย่างน้อย 4 ตัวอักษรขึ้นไป";

            } elseif ($data['password_new'] == $data['password_old']){
                $arr['error']['password_new'] = "รหัสผ่านต้องต่างจากรหัสผ่านเก่า";

            } elseif ($data['password_new'] != $data['password_confirm']){
                $arr['error']['password_confirm'] = "คุณต้องใส่รหัสผ่านที่เหมือนกันสองครั้งเพื่อเป็นการยืนยัน";
            }

            if( !empty($arr['error']) ){
                $this->view->error = $arr['error'];
            }
            else{
                $this->model->load('staff')->update($this->me['id'], array(
                    'staff_password' => $this->fn->q('password')->PasswordHash( $data['password_new'] )
                ));

                $arr['url'] = 'refresh';
                $arr['message'] = 'บันทึกรหัสผ่านเรียบร้อยแล้ว';
            }

            echo json_encode($arr);
            exit;
        }

        $this->error();
    }

    public function del_image_cover($id=null){
        if( empty($this->me) || $this->format!='json') $this->error();

        $item = $this->model->load('users')->get($this->me['id']);
        if( empty($item) ) $this->error();

        if( !empty($_POST) ){

            $this->model->load('media')->del( $item['image_id'] );
            $this->model->load('users')->update($id, array('user_image_id'=>0));

            $arr['message'] = "ลบเรียบร้อย";
            $arr['status'] = 1;
            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->render("profile/forms/del_image_cover");
        } 
    }

}