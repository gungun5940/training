<?php

class Logout extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->admin();
    }

    public function admin() {
        
        $url = URL;
        $this->view->setPage('theme', 'login');

        if( empty($this->me) ){
            header('location:' . $url );
        }

        if( !empty($_POST) ){
            Session::init();
            Session::destroy();

            $url = !empty($_REQUEST['next'])
                ? $_REQUEST['next']
                : $url;

            Cookie::clear( COOKIE_KEY_ADMIN );
            Cookie::clear( COOKIE_KEY_TYPE );
            Cookie::clear( 'login_role' );

            // header('location:' . $url);

            $arr['message'] = 'ออกจากระบบเรียบร้อยแล้ว';
            $arr['url'] = $url;

            echo json_encode($arr);
        }
        else{
            $this->view->render('confirm_logout');
        }
    }
}