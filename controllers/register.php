<?php

class Register extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index(){
    	$this->view->setPage('on', 'Register');
    	$this->view->setPage('title', 'สมัครสมาชิก');

        if( !empty($this->me) ) $this->error();

        /* Use for DatePicker */
        $this->view->css('jquery-ui.min');
        $this->view->js('jquery/jquery-datepicker-th');
        $this->view->js('jquery/jquery-ui.min');
        /**/

    	$this->view->setData('gender', $this->model->load('members')->gender());
        $this->view->setData('province', $this->model->load('system')->province());
    	$this->view->render('register');
    }
}