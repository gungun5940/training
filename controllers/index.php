<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();

        $this->model = new Model();
        $this->system = $this->model->load('system')->get();
        if( !empty($this->system) ){
            $this->setSystem();
            $this->view->setData('system', $this->system);
        }
        $this->handleLogin();
        $this->_modify(); 
    }

    public function index(){
        $this->view->setPage('on', 'Home');
        $this->view->setPage('title', 'หน้าแรก');

        $this->view->setData('newsType', $this->model->load('news')->type());

        $this->view->render("index");
    }
    public function search($param=null) {
        // print_r($param); die;
        $this->_getURL();
        if( $this->_url[0] == "blog" && !empty($this->_url[1]) ){
            $this->_searchNews( $this->_url[1] );
            exit;
        }
        if( $this->_url[0] == "type" && !empty($this->_url[1]) ){
            $this->_searchType( $this->_url[1] );
            exit;
        }
        if( $this->_url[0] == "about" ){
            $this->_url[1] = !empty($this->_url[1]) ? $this->_url[1] : null;
            $this->_searchAbout( $this->_url[1] );
            exit;
        }
        $this->error();
    }
    public function _searchNews( $primarylink=null ){
        $this->view->setPage('on', 'news');

        $item = $this->model->load("news")->primarylink( $primarylink, ['status'=>'enabled'] );
        if( empty($item) ) $this->error();

        $this->view->setData('newsType', $this->model->load('news')->type());
        $this->view->setData('newsMenu', $this->model->load("news")->lists(['limit'=>6]));
        $this->view->setPage('title', $item['title']);
        $this->view->setData("item", $item);
        $this->view->render("news/display");
    }
    public function _searchType( $primarylink=null ){
        $this->view->setPage('on', 'news');

        $item = $this->model->load("news_type")->primarylink( $primarylink, ['status'=>'enabled'] );
        if( empty($item) ) $this->error();

        $results = $this->model->load("news")->lists( ['type'=>$item['id'],'status'=>'enabled'] );

        $this->view->setData('newsType', $this->model->load('news')->type());
        $this->view->setData('newsMenu', $this->model->load("news")->lists(['limit'=>6]));
        $this->view->setPage('title', $item['name']);
        $this->view->setData("item", $item);
        $this->view->setData("results", $results);
        $this->view->render("news/lists");
    }
    public function _searchAbout( $primarylink = null ){
        if( empty($primarylink) ){
            $data = $this->model->load("webinfo")->getTopLists( ['status'=>1] );
        }
        else{
            $data = $this->model->load("webinfo")->primarylink( $primarylink, ['status'=>1] );
        }

        $this->view->setPage('on', 'about');
        $this->view->setPage("title", $data['name']);

        $lists = $this->model->load("webinfo")->lists( ["sort"=>"seq", "dir"=>"ASC", 'status'=>1] );
        $this->view->setData("data", $data);
        $this->view->setData("aboutLists", $lists);
        $this->view->render("about/display");
    }
}