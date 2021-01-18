<?php

class webinfo extends Controller {

	public function __construct() {
		parent::__construct();
	}

	private $_pathMsg = "Themes/manage/pages/webinfo/forms";

	public function index(){
		$this->error();
	}

	public function add(){
		if( empty($this->me) || $this->format!='json' ) $this->error();

		$this->view->setPage("path", $this->_pathMsg);
		$this->view->render("add");
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
			$form 	->post("info_name")->val('is_empty');
			$form->submit();
			$postData = $form->fetch();

			$has_name = true;
			if( !empty($item) ){
				if( $item["name"] == $postData["info_name"] ) $has_name = false;
			}
			if( $this->model->is_name($postData["info_name"]) && $has_name ){
				$arr["error"]["info_name"] = "ตรวจสอบพบชื่อซ้ำในระบบ";
			}
			if( !empty($item) ){
				$postData["info_detail"] = $_POST["info_detail"];
			}

			$postData['info_primarylink'] = $this->fn->q('text')->createPrimarylink($postData['info_name']);
			$postData["info_status"] = isset($_POST["info_status"]) ? $_POST["info_status"] : 0;

			if( empty($arr['error']) ){
				if( !empty($id) ){
					$this->model->update($id, $postData);
					$arr["url"] = "refresh";
				}
				else{
					$this->model->insert($postData);
					$arr["url"] = URL."manage/webinfo/".$postData["id"];

					/* SET PHOTO ALBUM */
                    $this->model->load('photos')->updateAlbumId( $_POST['obj_type'], $_POST['obj_id'], $id );
				}

				$arr["message"] = "บันทึกข้อมูลเรียบร้อย";
			}

		} catch (Exception $e) {
			$arr['error'] = $this->_getError($e->getMessage());
		}
		echo json_encode($arr);
	}
	public function del($id=null){
		$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $id;

		if( !empty($id) ){
			$item = $this->model->get($id);
			if( empty($item) ) $this->error();
		}

		if( !empty($_POST) ){
			if( !empty($item["permit"]["del"]) ){
				$this->model->delete($id);
				$arr["message"] = "ลบข้อมูลเรียบร้อยแล้ว";
				$arr["url"] = URL."manage/webinfo";
			}
			else{
				$arr["message"] = "ไม่มีสิทธิ์ลบข้อมูลดังกล่าว";
			}
			echo json_encode($arr);
		}
		else{
			$this->view->setData("item", $item);
			$this->view->setPage("path", $this->_pathMsg);
			$this->view->render("del");
		}
	}
	public function sort(){
		$ids = isset($_REQUEST['ids']) ? $_REQUEST['ids']: '';
        if( empty($ids) || empty($this->me) ) $this->error();

        $seq = 0;
        foreach ($ids as $id) {
            $seq++;
            $this->model->update($id, array('info_seq'=>$seq));
        }

        $arr['message'] = 'ปรับลำดับเรียบร้อยแล้ว';
	}
}
