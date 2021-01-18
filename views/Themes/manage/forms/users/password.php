<?php 

$form = new Form();
$form = $form 	->create()
				->elem('div')
				->addClass('form-insert');

$form 	->field("password")
		->label("รหัสผ่านใหม่")
		->type("password")
		->autocomplete("off")
		->addClass("inputtext")
		->value("");

$form 	->field("confirm_password")
		->label("รหัสผ่านใหม่อีกครั้ง")
		->type("password")
		->autocomplete("off")
		->addClass("inputtext")
		->value("");

$arr["title"] = "เปลี่ยนรหัสผ่าน ({$this->item["login"]})";

$arr["body"] = $form->html();

$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'users/password"></form>';

$arr["hiddenInput"][] = array("name"=>"id", "value"=>$this->item["id"]);

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);