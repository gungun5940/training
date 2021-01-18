<?php 
$form = new Form();
$form = $form 	->create()
				->elem('div')
				->addClass('form-insert');

$form 	->field("info_name")
		->label("หัวข้อ")
		->addClass("inputtext")
		->autocomplete("off")
		->value("");


$arr['title'] = "เพิ่มหัวข้อใหม่";

$arr['body'] = $form->html();

$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL.'webinfo/save"></form>';

$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);