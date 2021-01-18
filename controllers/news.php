<?php

class News extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index(){
    	$this->error();
    }

    public function save(){
    	if( empty($_POST) ) $this->error();

    	$id = isset($_POST['id']) ? $_POST['id']: null;
        $media_id = null;
        if( !empty($id) ){
            $item = $this->model->get($id);
            if( empty($item) ) $this->error();
            $media_id = $item["image_id"];
        }

        try{
        	$form = new Form();
            $form   ->post('new_type_id')->val('is_empty')
					->post('new_title')->val('is_empty')
					->post('new_desc')
            		->post('new_detail')->val('is_empty')
                    ->post('new_status')->val('is_empty');
            $form->submit();
            $postData = $form->fetch();

            $cropimage = null;
            if( !empty($_POST['cropimage']) ){
                $cropimage = $_POST['cropimage'];
            }

            if( empty($arr['error']) ){
                $postData['new_primarylink'] = $this->fn->q('text')->createPrimarylink($postData['new_title']);
            	if( !empty($id) ){
                    $this->model->update($id, $postData);
                }
                else{
                    $postData['new_user_id'] = $this->me['id'];
                    $this->model->insert($postData);
                    $id = $postData['id'];

                    /* SET PHOTO ALBUM */
                    $this->model->load('photos')->updateAlbumId( $_POST['obj_type'], $_POST['obj_id'], $id );
                }

                if( !empty($id) ){
                	//Image Manage
                	if( !empty($_FILES['image_cover']) ){
                		$userfile = $_FILES['image_cover'];

                    	// set Album
                		$album_options = array(
                			'album_obj_type' => 'news',
                			'album_obj_id' => 4,
                		);
                		$album = $this->model->load('media')->searchAlbum( $album_options );

                		if( empty($album) ){

                			$this->model->load('media')->setAlbum( $album_options );
                			$album = $album_options;
                		}

                    	// set Media
                		$media = array(
                			'media_album_id' => $album['album_id'],
                			'media_type' => isset($_REQUEST['media_type']) ? $_REQUEST['media_type']: strtolower(substr(strrchr($userfile['name'],"."),1))
                		);
                		$media_options = array(
                			'folder' => $album['album_id'],
                		);

                		$this->model->load('media')->set( $_FILES['image_cover'], $media , $media_options);

                    	// update id image to Model
                		if( !empty($media['media_id']) ){
                        // remove delete image old
                			if( !empty($item['image_id']) ){
                				$this->model->load('media')->del($item['image_id']);
                			}
                        // $item['image_cover'] = $media['media_id'];
                			$this->model->update( $id, array('new_image_id'=>$media['media_id'] ) );

                			$media_id = $media["media_id"];
                		}
                	}
                	// resize 
                	if( !empty($_POST['cropimage']) && !empty($media_id) ){
                		$this->model->load('media')->resize($media_id, $_POST['cropimage']);
                	}
                }

                $arr['message'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
                $arr['url'] = URL.'manage/news';
            }       

        } catch (Exception $e) {
        	$arr['error'] = $this->_getError($e->getMessage());
        }
        echo json_encode($arr);
    }
    public function del($id=null){
    	$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $id;
    	if( empty($id) || empty($this->me) || $this->format!='json' ) $this->error();

    	$item = $this->model->get($id);
    	if( empty($item) ) $this->error();

    	if( !empty($_POST) ){
    		$this->model->delete($id);

    		/* Delete Image Cover */
    		if( !empty($item['image_id']) ){
    			$this->model->load('media')->del($item['image_id']);
    		}
    		/**/

    		/* Delete photos in editor */
    		$album = $this->model->load('photos')->album( ['obj_id'=>$id, 'obj'=>'news'] );
    		if( !empty($album) ){
    			$photos = $this->model->load('photos')->lists( ['album'=>$album['id']] );
    			foreach ($photos['lists'] as $key => $value) {
    				$this->model->load('photos')->delete( $value['id'] );
    			}

    			$this->model->load("photos")->delAlbum( $album['id'] );
    		}
    		/**/

    		$arr['message'] = 'ลบข้อมูลเรียบร้อย';
    		$arr['url'] = 'refresh';

            echo json_encode($arr);
    	}
    	else{
    		$this->view->setData('item', $item);
    		$this->view->setPage('path', 'Themes/manage/pages/news/forms');
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

    /*JSON*/
    public function loadIndex($id=null){
        $results = [];
        $type = [];
        if( !empty($id) ){
            $type = $this->model->load("news_type")->get($id);
            $results = $this->model->lists( ['type'=>$id, 'limit'=>6, 'status'=>'enabled'] );
        }
        $this->view->setData("type", $type);
        $this->view->setData("results", $results);
        $this->view->render("sections/json/newslists");
    }
}