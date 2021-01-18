<?php

$title = "ประเภท/หมวดหมู่ข่าวสาร";

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert');

$form 	->field("type_name")
	    ->label('ชื่อประเภท / หมวดหมู่*')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['name'])? $this->item['name']:'' );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL.'news_type/save"></form>';

# body
$arr['body'] = $form->html();

# title
if( !empty($this->item) ){
    $arr['title']= "แก้ไข {$title}";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "เพิ่ม {$title}";
}

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

// $arr['width'] = 782;
// $arr['is_close_bg'] = true;

echo json_encode($arr);
