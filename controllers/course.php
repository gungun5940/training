<?php

class Course extends Controller {

    function __construct() {
        parent::__construct();
    }

    private $_pathMng = "Themes/manage/pages/course/forms";
    /* Frontend */
    public function index($id=null){
        $this->view->setPage('on', 'Training course');
        $this->view->setPage('title', 'หลักสูตรที่เปิดอบรม');

        if( !empty($id) ){
            $item = $this->model->getCourseOpen($id);
            if( empty($item) ) $this->error();

            $course = $this->model->get($item['course']);
            if( empty($course) ) $this->error();

            $results = $this->model->getListsRegCourse($id);

            $this->view->setData("results", $results);
            $this->view->setData("item", $item);
            $this->view->setData("course", $course);
            $render = 'course/lists';
        }
        else{
            $results = $this->model->listsOpen( ['status'=>1,'limit'=>10, 'sort'=>'startdate'] );
            if( !empty($this->me) ){
                $checkReg = $this->model->checkReg( $this->me['id'] );
                $this->view->setData('checkReg', $checkReg);
            }
            $this->view->setData('results', $results);
            $render = 'course/display';
        }
    	$this->view->render($render);
    }
    public function regconfirm($id=null){
        if( empty($id) ) $this->error();
        
            $item = $this->model->getCourseOpen($id);
            if( empty($item) ) $this->error();

            $course = $this->model->get($item['course']);
            if( empty($course) ) $this->error();

            $results = $this->model->getListsRegCourse($id, ['status'=>1]);

            $this->view->setData("results", $results);
            $this->view->setData("item", $item);
            $this->view->setData("course", $course);
            $this->view->render('course/lists');
    }
    public function register($id=null){
        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $id;
        if( empty($this->me) || empty($id) || $this->format != "json" ) $this->error();

        $item = $this->model->getCourseOpen($id, ['status'=>1]);
        if( empty($item) ) $this->error();

        $course = $this->model->get($item['course']);
        if( empty($course) ) $this->error();

        if( !empty($_POST) ){
            $status = 1;
            $pay_status = 9;
            if( $item['price'] > 0 ) {
                $status = 0;
                $pay_status = 0;
            }
            $postData = [
                "mem_id" => $this->me['id'],
                "reg_course_id" => $item['course'],
                "reg_open_id" => $item['id'],
                "reg_date" => date('c'),
                "reg_status" => $status,
                "reg_pay_status" => $pay_status
            ];
            $this->model->registerCourse( $postData );

            $arr['message'] = 'ลงทะเบียนเรียบร้อยแล้ว';
            $arr['url'] = 'refresh';

            echo json_encode($arr);
        }
        else{
            $this->view->setData("item", $item);
            $this->view->setData("course", $course);
            $this->view->render("course/forms/register");
        }
    }
    public function payregister($mem_id=null, $open_id=null){
        $mem_id = isset($_REQUEST["mem_id"]) ? $_REQUEST["mem_id"] : $mem_id;
        $open_id = isset($_REQUEST["open_id"]) ? $_REQUEST["open_id"] : $open_id;

        if( empty($mem_id) || empty($open_id) || empty($this->me) || $this->format!="json" ) $this->error();

        $reg = $this->model->getRegisterCourse($mem_id, $open_id);
        if( empty($reg) ) $this->error();

        $item = $this->model->load("course")->getCourseOpen( $open_id );
        if( empty($item) ) $this->error();

        if( !empty($_POST) ){
            if( empty($_FILES["reg_slip"]) ){
                $arr['error']['reg_slip'] = "กรุณาแนบหลักฐานการจ่ายเงิน";
            }
            else{
                $typeFile = strtolower(strrchr($_FILES["reg_slip"]["name"],"."));
                if( $typeFile != '.png' && $typeFile != '.jpg' && $typeFile != '.jpeg' ) {
                    $arr["error"]["reg_slip"] = "กรุณาเลือกไฟล์นามสกุล .png, .jpg, .jpeg เท่านั้น";
                }
            }

            if( empty($arr['error']) ){

                if( !empty($reg['slip']) ) unlink( WWW_UPLOADS_SLIP.$reg['slip'] );
                $slipFile = 'Slip_'.$open_id.'_'.sprintf("%04d",$this->me['id']).$typeFile;
                if( move_uploaded_file($_FILES["reg_slip"]["tmp_name"], WWW_UPLOADS_SLIP.$slipFile) ){
                    $this->model->updateRegisterCourse( $mem_id, $open_id, ['reg_slip'=>$slipFile, 'reg_pay_status'=>2] );

                    $arr['message'] = ['text'=>"ส่งหลักฐานเรียบร้อยแล้ว", 'detail'=>'จะใช้เวลาตรวจสอบหลักฐาน 1-2 วันทำการ', 'confirm'=>true];
                    $arr['url'] = "refresh";
                }
                else{
                    $arr['message'] = ['text'=>"เกิดข้อผิดพลาดระหว่างส่งหลักฐาน", 'type'=>'warning', 'confirm'=>true];
                }
            }

            echo json_encode($arr);
        }
        else{
            $this->view->setData("item", $item);
            $this->view->setData("reg", $reg);
            $this->view->render("course/forms/pay");
        }
    }

    /* Manage */
    public function add(){
    	if( empty($this->me) || $this->format != "json" ) $this->error();

        $this->view->setData('status', $this->model->status());
        $this->view->setPage('path', $this->_pathMng);
        $this->view->render('add');
    }
    public function edit($id=null){
        if( empty($id) || empty($this->me) || $this->format != "json" ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        $this->view->setData('item', $item);
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
            $form   ->post('course_code')->val('is_empty')
                    ->post('course_name_th')->val('is_empty')
                    ->post('course_name_en')
                    ->post('course_object')
                    ->post('course_goal')
                    ->post('course_property')
                    ->post('course_hours')->val('numeric')
                    ->post('course_link')
                    ->post('course_status')->val('numeric');
            $form->submit();
            $postData = $form->fetch();

            if( empty($arr['error']) ){
                if( !empty($id) ){
                    $this->model->update($id, $postData);
                }
                else{
                    $postData['course_staff_id'] = $this->me['id'];
                    $this->model->insert($postData);
                }

                $arr['message'] = 'บันทึกข้อมูลเรียบร้อย';
                $arr['url'] = URL.'manage/course';
            }
        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
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
    public function setData($id=null, $field=null){
        if( empty($id) || empty($field) || empty($this->me) ) $this->error();

        $data[$field] = isset($_REQUEST['value'])? $_REQUEST['value']:'';
        $this->model->update($id, $data);

        $arr['message'] = 'บันทึกข้อมูลเรียบร้อย';
        echo json_encode($arr);
    }

    /* OPEN STATUS */
    // public function opencourse($id=null){
    //     $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $id;
    //     if( empty($id) || empty($this->me) || $this->format !="json" ) $this->error();

    //     $item = $this->model->get($id);
    //     if( empty($item) ) $this->error();

    //     if( !empty($_POST) ){

    //         if( empty($id) ) $this->error();
    //         $item = $this->model->get($id);
    //         if( empty($item) ) $this->error();

    //         if( $_POST["open_status"] == 1 ){
    //             /* OPEN COURSE */
    //             try{
    //                 $form = new Form();
    //                 $form   
    //                         ->post('open_date')->val('is_empty')
    //                         ->post('open_startdate')->val('is_empty')
    //                         ->post('open_enddate')->val('is_empty')
    //                         ->post('open_startdate_reg')->val('is_empty')
    //                         ->post('open_enddate_reg')->val('is_empty')
    //                         ->post('open_member')->val('is_empty')
    //                         // ->post('open_hours')->val('is_empty')
    //                         // ->post('open_price')->val('numeric')
    //                         ->post('open_status');
    //                 $form->submit();
    //                 $postData = $form->fetch();

    //                 /* มีค่าใช้จ่าย */
    //                 if( $_POST["open_price_status"] == 1 ){
    //                     if( empty($_POST["open_price"]) ) {
    //                         $arr['error']['open_price'] = 'กรุณากรอกค่าใช้จ่าย';
    //                     }
    //                     elseif( !is_numeric($_POST["open_price"]) ){
    //                         $arr['error']['open_price'] = 'กรุณากรอกเป็นตัวเลข 0-9 เท่านั้น';
    //                     }
    //                     $postData['open_price'] = $_POST['open_price'];
    //                 }
    //                 /**/

    //                 /* ไม่มีค่าใช้จ่าย ปรับให้ open_price = 0 */
    //                 if( $_POST['open_price_status'] == 0 || empty($_POST['open_price_status']) ){
    //                     $postData['open_price'] = 0;
    //                 }
    //                 /**/

    //                 if( empty($arr['error']) ){

    //                     /* SET FOR DB */
    //                     $postData['open_date'] = $this->fn->q('time')->DateJQToPHP( $postData['open_date'] );
    //                     $postData['open_startdate'] = $this->fn->q('time')->DateJQToPHP( $postData['open_startdate'] );
    //                     $postData['open_enddate'] = $this->fn->q('time')->DateJQToPHP( $postData['open_enddate'] );
    //                     $postData['open_startdate_reg'] = $this->fn->q('time')->DateJQToPHP( $postData['open_startdate_reg'] );
    //                     $postData['open_enddate_reg'] = $this->fn->q('time')->DateJQToPHP( $postData['open_enddate_reg'] );
    //                     /**/

    //                     $postData['open_course'] = $item['id'];
    //                     $this->model->insertOpen($postData);

    //                     /* UPDATE COURSE STATUS */
    //                     if( !empty($postData['id']) ){
    //                         $this->model->update($id, ['course_open_status'=>1]);
    //                     }
    //                     /**/

    //                     $arr['message'] = 'เปิดหลักสูตรเรียบร้อยแล้ว';
    //                     $arr['url'] = 'refresh';
    //                 }

    //             } catch (Exception $e) {
    //                 $arr['error'] = $this->_getError($e->getMessage());
    //             }
    //         }
    //         elseif( $_POST['open_status'] == 0 ){
    //             /* CLOSE COURSE */
    //             if( empty($_POST["open_id"]) ) $this->error();
    //             $open = $this->model->getCourseOpen( $_POST["open_id"] );
    //             if( empty($open) ) $this->error();

    //             /* UPDATE course_open */
    //             $this->model->updateOpen($_POST["open_id"], ['open_status'=>$_POST["open_status"]]);

    //             /* UPDATE course */
    //             $this->model->update($id, ['course_open_status'=>$_POST["open_status"]]);

    //             $arr['message'] = 'ปิดหลักสูตรเรียบร้อยแล้ว';
    //             $arr['url'] = 'refresh';
    //         }
    //         else{
    //             $this->error();
    //         }

    //         echo json_encode($arr);
    //     }
    //     else{
    //         $render = !empty($item['open_status']) ? "close_course" : "open_course";

    //         if( $render == "close_course" ){
    //             $this->view->setData("open", $this->model->getLastCourseOpen($id, ['status'=>1]));
    //         }

    //         $this->view->setData("item", $item);
    //         $this->view->setPage( "path", $this->_pathMng );
    //         $this->view->render( $render );
    //     }
    // }

    public function add_opencourse($id=null){
        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $id;
        if( empty($id) || empty($this->me) || $this->format !="json" ) $this->error();

        $course = $this->model->get($id);
        if( empty($course) ) $this->error();
        $staff = $this->model->load('staff')->lists(['level'=>2]);
        $this->view->setData("staff", $staff);
        $this->view->setData("course", $course);
        $this->view->setData('status', $this->model->statusOpen());
        $this->view->setPage( "path", $this->_pathMng );
        $this->view->render( 'open_course' );
    }
    public function edit_opencourse($id=null){
        if( empty($id) || empty($this->me) || $this->format != "json" ) $this->error();

        $item = $this->model->getCourseOpen( $id );
        if( empty($item) ) $this->error();

        $course = $this->model->get($item['course']);
        if( empty($course) ) $this->error();

        $staff = $this->model->load('staff')->lists(['level'=>2]);
        $this->view->setData("staff", $staff);
        $this->view->setData("course", $course);
        $this->view->setData("item", $item);
        $this->view->setData('status', $this->model->statusOpen());
        $this->view->setPage( "path", $this->_pathMng );
        $this->view->render( 'open_course' );
    }
    public function save_opencourse(){
        if( empty($_POST) ) $this->error();

        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        if( !empty($id) ){
            $item = $this->model->getCourseOpen( $id );
            if( empty($item) ) $this->error();
        }

        try{
            $form = new Form();
            $form   
                ->post('open_date')->val('is_empty')
                ->post('open_startdate')->val('is_empty')
                ->post('open_enddate')->val('is_empty')
                ->post('open_startdate_reg')->val('is_empty')
                ->post('open_enddate_reg')->val('is_empty')
                ->post('open_member')->val('is_empty')
                ->post('open_place')->val('is_empty')
                // ->post('open_hours')->val('is_empty')
                // ->post('open_price')->val('numeric')
                ->post('open_staff_id')->val('is_empty')
                ->post('open_status')
                ->post('open_course');
            $form->submit();
            $postData = $form->fetch();

            /* มีค่าใช้จ่าย */
            if( $_POST["open_price_status"] == 1 ){
                if( empty($_POST["open_price"]) ) {
                    $arr['error']['open_price'] = 'กรุณากรอกค่าใช้จ่าย';
                }
                elseif( !is_numeric($_POST["open_price"]) ){
                    $arr['error']['open_price'] = 'กรุณากรอกเป็นตัวเลข 0-9 เท่านั้น';
                }
                $postData['open_price'] = $_POST['open_price'];
            }
            /**/

            /* ไม่มีค่าใช้จ่าย ปรับให้ open_price = 0 */
            if( $_POST['open_price_status'] == 0 || empty($_POST['open_price_status']) ){
                $postData['open_price'] = 0;
            }
            /**/

            if( empty($item['pdf_file']) && empty($_FILES["open_pdf_file"]) ){
                $arr['error']['open_pdf_file'] = 'กรุณาเลือกไฟล์';
            }

            if( !empty($_FILES["open_pdf_file"]) ){
                $typeFile = strrchr($_FILES["open_pdf_file"]["name"],".");
				if( $typeFile != '.pdf' ) $arr["error"]["open_pdf_file"] = "กรุณาเลือกไฟล์นามสกุล .pdf เท่านั้น";
            }

            if( empty($arr['error']) ){

                /* SET FOR DB */
                $postData['open_date'] = $this->fn->q('time')->DateJQToPHP( $postData['open_date'] );
                $postData['open_startdate_reg'] = $this->fn->q('time')->DateJQToPHP( $postData['open_startdate_reg'] );
                $postData['open_enddate_reg'] = $this->fn->q('time')->DateJQToPHP( $postData['open_enddate_reg'] );
                $postData['open_startdate'] = $this->fn->q('time')->DateJQToPHP( $postData['open_startdate'] );
                $postData['open_enddate'] = $this->fn->q('time')->DateJQToPHP( $postData['open_enddate'] );
               
                /**/

                if( !empty($id) ){
                    $this->model->updateOpen($id, $postData);
                }
                else{
                    $this->model->insertOpen($postData);
                    $id = $postData['id'];
                }

                /* UPDATE COURSE STATUS */
                if( !empty($id) ){
                    if( $postData['open_status'] == 1 ) $this->model->update($postData['open_course'], ['course_open_status'=>1]);

                    if( !empty($_FILES["open_pdf_file"]) ){
                        if( !empty($item['file_pdf']) ) unlink( WWW_UPLOADS_PDF.$item['file_pdf'] );

						$typeFile = strrchr($_FILES["open_pdf_file"]["name"],".");
						$pdfFile = 'Course_'.$postData['open_course'].'_'.sprintf("%04d",$id).$typeFile;
                        move_uploaded_file($_FILES["open_pdf_file"]["tmp_name"], WWW_UPLOADS_PDF.$pdfFile);
                        
                        $this->model->updateOpen($id, ['open_pdf_file'=>$pdfFile]);
                    }
                }
                /**/

                $arr['message'] = 'บันทึกข้อมูลอบรมเรียบร้อยแล้ว';
                $arr['url'] = 'refresh';
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }

        echo json_encode($arr);
    }
    public function setOpenStatus($id=null){
        if( empty($id) || empty($this->me) || $this->format != "json" ) $this->error();

        $item = $this->model->getCourseOpen( $id );
        if( empty($item) ) $this->error();

        $course = $this->model->get($item['course']);
        if( empty($course) ) $this->error();

        $this->view->setData("course", $course);
        $this->view->setData("item", $item);
        $this->view->setPage( "path", $this->_pathMng );
        $this->view->render( 'set_openstatus' );
    }
    public function setEndOpen($id=null){
        if( empty($id) || empty($this->me) || $this->format != "json" ) $this->error();

        $item = $this->model->getCourseOpen( $id );
        if( empty($item) ) $this->error();

        $course = $this->model->get($item['course']);
        if( empty($course) ) $this->error();

        $this->view->setData("course", $course);
        $this->view->setData("item", $item);
        $this->view->setPage( "path", $this->_pathMng );
        $this->view->render( 'set_endopen' );
    }
    public function save_openstatus(){
        if( empty($_POST) ) $this->error();

        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        $item = $this->model->getCourseOpen( $id );
        if( empty($item) ) $this->error();

        /* UPDATE course_open */
        $this->model->updateOpen($id, ['open_status'=>$_POST["status"]]);

        /* UPDATE course */
        if( empty( $this->model->checkCourseOpen( $item['course'] ) ) ){
            $this->model->update($item['course'], ['course_open_status'=>0]);
        }
        else{
            $this->model->update($item['course'], ['course_open_status'=>1]);
        }

        $statusName = $this->model->getStatusOpen( $_POST["status"] );

        $arr['message'] = $statusName.' เรียบร้อยแล้ว';
        $arr['url'] = 'refresh';

        echo json_encode($arr);
    }
    /* public function del_opencourse($id=null){

    } */
    public function del_register( $mem_id=null, $open_id=null ){
        $mem_id = isset($_REQUEST["mem_id"]) ? $_REQUEST["mem_id"] : $mem_id;
        $open_id = isset($_REQUEST["open_id"]) ? $_REQUEST["open_id"] : $open_id;

        if( empty($mem_id) || empty($open_id) || empty($this->me) || $this->format!="json" ) $this->error();

        $item = $this->model->getRegisterCourse($mem_id, $open_id);
        if( empty($item) ) $this->error();

        $open = $this->model->getCourseOpen( $open_id );
        if( empty($open) ) $this->error();

        if( !empty($_POST) ){
            $this->model->delRegisterCourse($mem_id, $open_id);

            if( !empty($item['slip']) ) unlink( WWW_UPLOADS_SLIP.$item['slip'] );

            $arr['message'] = 'ดำเนินการลบเรียบร้อยแล้ว';
            $arr['url'] = 'refresh';
            echo json_encode($arr);
        }
        else{
            $this->view->setData("status", $this->model->statusPay());
            $this->view->setData("item", $item);
            $this->view->setData("open", $open);
            $this->view->setPage("path", $this->_pathMng);
            $this->view->render("del_register");
        }
    }
    public function payments( $mem_id=null, $open_id=null ){
        $mem_id = isset($_REQUEST["mem_id"]) ? $_REQUEST["mem_id"] : $mem_id;
        $open_id = isset($_REQUEST["open_id"]) ? $_REQUEST["open_id"] : $open_id;

        if( empty($mem_id) || empty($open_id) || empty($this->me) || $this->format!="json" ) $this->error();

        $item = $this->model->getRegisterCourse($mem_id, $open_id);
        if( empty($item) ) $this->error();

        $open = $this->model->getCourseOpen( $open_id );
        if( empty($open) ) $this->error();

        if( !empty($_POST) ){
            if( empty($_POST["reg_pay_status"]) ){
                $arr['error']['reg_pay_status'] = "กรุณาเลือกอย่างใดอย่างหนึ่ง";
            }
            if( empty($arr['error']) ){
                $status = $item['status'];
                if( $_POST["reg_pay_status"] == 1 ) $status = 1;
                $data = array(
                    'reg_pay_status' => $_POST["reg_pay_status"],
                    'reg_status' => $status
                );
                $this->model->updateRegisterCourse( $item['mem_id'], $item['open_id'], $data );

                $arr['message']['text'] = 'ปรับสถานะเรียบร้อยแล้ว';
                $arr['message']['detail'] = 'สถานะล่าสุดคือ : '.$this->model->getStatusPay( $_POST["reg_pay_status"] );
                $arr['url'] = 'refresh';
            }
            echo json_encode($arr);
        }
        else{
            $this->view->setData("status", $this->model->statusPay());
            $this->view->setData("item", $item);
            $this->view->setData("open", $open);
            $this->view->setPage("path", $this->_pathMng);
            $this->view->render("slip");
        }
    }

    public function openhistory($id=null){
        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $id;
        if( empty($id) || empty($this->me) || $this->format !="json" ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        $open = $this->model->CourseOpen($id);

        $this->view->setData("item", $item);
        $this->view->setData("open", $open);
        $this->view->setPage( "path", $this->_pathMng );
        $this->view->render("course_history");
    }
}