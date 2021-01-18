<?php

class History extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->view->setPage('on', 'Training history');
        $this->view->setPage('title', 'ประวัติการอบรม');

        if( empty($this->me) || $this->me['auth'] != "member" ) $this->error();

        $results = $this->model->load("members")->listsRegister( ['member'=>$this->me['id'], 'sort'=>'open_startdate', 'invoice'=>true] );
        $this->view->setData("results", $results);
        $this->view->render("history");
    }
}