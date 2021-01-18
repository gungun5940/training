<?php 

$title = "ตำแหน่ง";

$form = new Form();
$form = $form 	->create()
				->elem("div")
				->addClass("form-insert");

$form 	->field("role_name")
		->label("ชื่อตำแหน่ง")
		->autocomplete("off")
		->addClass("inputtext")
		->value( !empty($this->item["name"]) ? $this->item["name"] : "" );

if( !empty($this->item) ){
	$title = "แก้ไข{$title}";
	$arr["hiddenInput"][] = array("name"=>"id", "value"=>$this->item["id"]);
}
else{
	$title = "เพิ่ม{$title}";
}

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'users/save_role"></form>';

# set title
$arr['title'] = $title;

# set body
$arr['body'] = $form->html();

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

// $arr['width'] = 782;
$arr['is_close_bg'] = true;

echo json_encode($arr);