<?php

class Manage extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index(){
    	$this->course();
    }

    /* public function staff(){
    	$this->view->setPage("on", "staff");
        $this->view->setPage("title", "จัดการทีมงาน");

        if( $this->format=="json" ){
            $this->view->setData("results", $this->model->load("staff")->lists());
            $render = "staff/lists/json";
        }
        else{
            $this->view->setData("level", $this->model->load("staff")->level());
            $render = "staff/lists/display";
        }
        $this->view->render( $render );
    } */

    public function course($page=null, $id=null){
        $this->view->setPage('on', 'course');
        $this->view->setPage('title', 'จัดการข้อมูลหลักสูตร');

        /* Use for DatePicker */
        $this->view->css('jquery-ui.min');
        $this->view->js('jquery/jquery-datepicker-th');
        $this->view->js('jquery/jquery-ui.min');
        /**/

        if( empty($page)){
            if( $this->format=="json" ){
                $this->view->setData('results', $this->model->load('course')->lists());
                $render = "course/lists/json";
            }
            else{
                $render = "course/lists/display";
            }
        }
        else{
            if( $page=="history" ){
                $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $id;
                if( empty($id) || empty($this->me) ) $this->error();

                $item = $this->model->load("course")->get($id);
                if( empty($item) ) $this->error();

                if( !empty($_GET["open"]) ){
                    $currOpen = $this->model->load("course")->getCourseOpen( $_GET["open"] );
                    $listsReg = $this->model->load("course")->getListsRegCourse( $_GET["open"] );
                    $this->view->setData("currOpen", $currOpen);
                    $this->view->setData("listsReg", $listsReg);
                }

                $open = $this->model->load("course")->CourseOpen($id);
                $this->view->setData("item", $item);
                $this->view->setData("open", $open);
                $render = "course/history/display";
            }
        }
    
        $this->view->setData("status", $this->model->load("course")->status());
        $this->view->render( $render );
    }

    public function members($page=null, $id=null){
        $this->view->setPage('on', 'members');
        $this->view->setPage('title', 'จัดการสมาชิกหรือผู้เข้าอบรม');

        if( !empty($page) ){

            /* Use for DatePicker */
            $this->view->css('jquery-ui.min');
            $this->view->js('jquery/jquery-datepicker-th');
            $this->view->js('jquery/jquery-ui.min');
            /**/

            if( $page == "add" ){
                $render = "members/forms/add";
            }
            elseif( $page == "edit" ){
                $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $id;
                if( empty($id) ) $this->error();

                $item = $this->model->load("members")->get($id);
                if( empty($id) ) $this->error();

                $this->view->setData('item', $item);
                $render = "members/forms/add";
            }
            else{
                $this->error();
            }
        }
        else{
            if( $this->format=="json" ){
                $this->view->setData('results', $this->model->load('members')->lists());
                $render = "members/lists/json";
            }
            else{
                $render = "members/lists/display";
            } 
        }
        
        $this->view->setData('province', $this->model->load('system')->province());
        $this->view->setData('gender', $this->model->load('members')->gender());
        $this->view->setData('status', $this->model->load('members')->status());
        $this->view->render( $render );
    }

    public function invoice(){
        $this->view->setPage('on', 'invoice');
        $this->view->setPage('title', 'จัดการข้อมูลการร้องขอใบกำกับภาษี');

        if( $this->format=="json" ){
            $this->view->setData('results', $this->model->load('invoice')->lists());
            $render = "invoice/lists/json";
        }
        else{
            $render = "invoice/lists/display";
        } 

        $this->view->setData("status", $this->model->load("invoice")->status());
        $this->view->render($render);
    }

    public function news($page=null, $id=null){
        $this->view->setPage('on', 'news');
        $this->view->setPage('title', 'จัดการข้อมูลข่าวสาร');

        if( !empty($page) ){

            $this->view
                ->js( 'plugins/loadImage')
                ->js( 'plugins/lightbox')
                ->js( 'plugins/mediaGallery')
                ->js( 'tinymce/jquery.tinymce.min')
                ->js( 'tinymce/tinymce.min')
                ->css( 'codepen.min' );

            if( $page == "add" ){
                $render = "news/forms/set";
            }
            elseif( $page == "edit" ){
                if( empty($id) ) $this->error();

                $item = $this->model->load("news")->get($id);
                if( empty($id) ) $this->error();

                $this->view->setData('item', $item);
                $render = "news/forms/set";
            }
            else{
                $this->error();
            }
        }
        else{
            if( $this->format=="json" ){
                $this->view->setData('results', $this->model->load('news')->lists());
                $render = "news/lists/json";
            }
            else{
                $render = "news/lists/display";
            }
        }

        $this->view->setData('status', $this->model->load('news')->status());
        $this->view->setData('type', $this->model->load('news')->type());
        $this->view->render( $render );
    }

    public function webinfo( $id='seq' ){

        $this->view->setPage('title', 'จัดการข้อมูลเกี่ยวกับศูนย์');
        $this->view->setPage('on', 'webinfo');

        if( is_numeric($id) ){
            $item = $this->model->load('webinfo')->get($id);
            if( empty($item) ) $this->error();

            $this->view
                ->js( 'plugins/loadImage')
                ->js( 'plugins/lightbox')
                ->js( 'plugins/mediaGallery')
                ->js( 'tinymce/jquery.tinymce.min')
                ->js( 'tinymce/tinymce.min');

            $this->view->setData('status', $this->model->load('webinfo')->status());
            $this->view->setData('item', $item);
        }
        elseif( $id == 'seq' ){
            $this->view->js('jquery/jquery-ui.min');
        }
        else{
            $this->error();
        }

        $this->view->setData('tap', $id);
        $this->view->setData('info', $this->model->load("webinfo")->lists( array("sort"=>"seq", "dir"=>"ASC") ));
        $this->view->render( "webinfo/display" );
    }

    public function settings($section='my',$tap=''){
        $this->view->setPage('on', 'settings' );
        $this->view->setPage('title', 'ตั้งค่า');
        $this->view->setData('section', $section);

        if( !empty($tap) ) $this->view->setData('tap', $tap);
        if( $section=='my' ){

            if( empty($tap) ) $tap = 'basic';

            $this->view->setPage('on', 'settings' );
            $this->view->setData('section', 'my');
            $this->view->setData('tap', 'display');
            $this->view->setData('_tap', $tap);

            if( $tap=='basic' ){

                $this->view
                ->js(  VIEW .'Themes/'.$this->view->getPage('theme').'/assets/js/bootstrap-colorpicker.min.js', true)
                ->css( VIEW .'Themes/'.$this->view->getPage('theme').'/assets/css/bootstrap-colorpicker.min.css', true);

                $this->view->setData('prefixName', $this->model->load('system')->prefixName());
            }
        }
        elseif( $section=='system' ){

            if( empty($tap) ) $tap = 'basic';

            $this->view->setPage('on', 'settings' );
            $this->view->setData('section', 'system');

            // if( empty($this->permit['system']['view']) ) $this->error();

            if( !empty($_POST) && $this->format=='json' ){

                foreach ($_POST as $key => $value) {
                    $this->model->load('system')->set( $key, $value);
                }

                $arr['url'] = 'refresh';
                $arr['message'] = ['type'=>'success', 'text'=>'ปรับปรุงข้อมูลเรียบร้อยแล้ว'];

                echo json_encode($arr); die;
            }

            if( empty($tap) ) $tap = 'basic';
            if( $tap=='locations' ){
                $this->view->setData('city', $this->model->load('system')->province());
            }
            if( $tap=='fonts' ){
                $this->view->setData('results', $this->model->load('font')->lists());
            }

            $this->view->setData('tap', 'display');
            $this->view->setData('_tap', $tap);
        }
        elseif( $section=='accounts' ){

            if($tap=='staff'){

                $data = array();
                if( $this->format=="json" ){
                    $this->view->setData('results', $this->model->load('staff')->lists());
                    $render = 'settings/sections/accounts/staff/json';
                }
                $this->view->setData("status", $this->model->load("staff")->status());
                $this->view->setData("level", $this->model->load("staff")->level());
                // print_r($data); die;
            }
            else{
                $this->error();
            }

            $this->view->setData('data', $data);
        }
        elseif( $section=='news' ){

            if($tap=='type'){

                $data = array();
                if( $this->format=="json" ){
                    $this->view->setData('results', $this->model->load('news_type')->lists());
                    $render = 'settings/sections/news/type/json';
                }
            }
            else{
                $this->error();
            }

            $this->view->setData('data', $data);
        }
        else{
            $this->error();
        }

        $this->view->render( !empty($render) ? $render : "settings/display");
    }
}