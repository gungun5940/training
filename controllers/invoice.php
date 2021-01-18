<?php

class Invoice extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index(){
    	$this->error();
    }

    public function request( $course=null, $open=null ){
    	if( empty($course) || empty($open) || empty($this->me) ) $this->error();

    	$this->view->setPage("title", "ร้องขอใบกำกับภาษี");
    	$this->view->setPage("on", "Training history");

    	$results = $this->model->load("members")->getRegister( $this->me['id'], $course, $open );
    	if( empty($results) ) $this->error();

    	$item = $this->model->getInvoiceByRegister( ['mem_id'=>$this->me['id'], 'course'=>$course, 'open'=>$open] );

    	$this->view->setData('province', $this->model->load('system')->province());

    	$this->view->setData("results", $results);
    	$this->view->setData("item", $item);
    	$this->view->render("profile/invoice");
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
            $form   ->post('inv_name')->val('is_empty')
                    ->post('inv_code')->val('is_empty')
                    ->post('inv_add_num')->val('is_empty')
                    ->post('inv_add_street')
                    ->post('inv_add_province_id')->val('is_empty')
                    ->post('inv_add_amphure_id')->val('is_empty')
                    ->post('inv_add_district_id')->val('is_empty')
                    ->post('inv_add_zipcode')->val('is_empty')
                    ->post('inv_course_id')
                    ->post('inv_open_id');
            $form->submit();
            $postData = $form->fetch();

            if( empty($arr['error']) ){
                if( !empty($id) ){
                    $this->model->update($id, $postData);
                }
                else{
                    $postData['inv_status'] = 'waiting'; //รออนุมัติ , รอการตรวจสอบ
                    $postData['inv_mem_id'] = $this->me['id'];
                    $this->model->insert($postData);
                }

                $arr['message'] = 'ส่งคำร้องขอใบกำกับภาษีเรียบร้อยแล้ว';
                $arr['url'] = URL.'history';
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }
        echo json_encode($arr);
    }
    public function setData($id=null, $field=null){
        if( empty($id) || empty($field) || empty($this->me) ) $this->error();

        $data[$field] = isset($_REQUEST['value'])? $_REQUEST['value']:'';
        $this->model->update($id, $data);

        $arr['message'] = 'บันทึกข้อมูลเรียบร้อย';
        echo json_encode($arr);
    }
}