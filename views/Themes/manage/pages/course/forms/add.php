<?php

$title = "ข้อมูลหลักสูตร";
if( !empty($this->item) ){
	$title = "แก้ไข{$title}";
}
else{
	$title = "เพิ่ม{$title}";
}

$form = new Form();
$form = $form 	->create()
				->elem('div')
				->addClass('form-insert');

$form 	->field('course_code')
		->label('รหัสหลักสูตร * <label class="fcr fwb"> Ex. Tech-xxxx </label>')
		->addClass('inputtext')
		->autocomplete('off')
		->placeholder('Tech-xxxx')
		->value( !empty($this->item['code']) ? $this->item['code'] : '' );

$form 	->field('course_name_th')
		->label('ชื่อ (ภาษาไทย) *')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['name_th']) ? $this->item['name_th'] : '' );

$form 	->field('course_name_en')
		->label('ชื่อ (ภาษาอังกฤษ) *')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['name_en']) ? $this->item['name_en'] : '' );

$form 	->field('course_object')
		->label('วัตถุประสงค์*')
		->addClass('inputtext')
		->autocomplete('off')
		->type('textarea')
		->attr('data-plugins', 'autosize')
		->value( !empty($this->item['object']) ? $this->item['object'] : '' );

$form 	->field('course_goal')
		->label('เป้าหมายหลักสูตร*')
		->addClass('inputtext')
		->autocomplete('off')
		->type('textarea')
		->attr('data-plugins', 'autosize')
		->value( !empty($this->item['goal']) ? $this->item['goal'] : '' );

$form 	->field('course_property')
		->label('คุณสมบัติผู้เข้าร่วมอบรม*')
		->addClass('inputtext')
		->autocomplete('off')
		->type('textarea')
		->attr('data-plugins', 'autosize')
		->value( !empty($this->item['property']) ? $this->item['property'] : '' );

$form 	->field('course_hours')
		->label('จำนวนชั่วโมง*')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['hours']) ? $this->item['hours'] : '' );

$form 	->field('course_link')
		->label('ไฟล์ประชาสัมพันธ์ (URL)')
		->addClass('inputtext')
		->autocomplete('off')
		->type('url')
		->placeholder('https://www.lpru.ac.th/')
		->value( !empty($this->item['link']) ? $this->item['link'] : '' );

$form 	->field('course_status')
		->label('สถานะ*')
		->addClass('inputtext')
		->autocomplete('off')
		->select( $this->status )
		->value( isset($this->item['status']) ? $this->item['status'] : 1 );

if( !empty($this->item) ){
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL.'course/save"></form>';

# body
$arr['body'] = $form->html();

# title
$arr['title'] = $title;

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

$arr['width'] = 782;
// $arr['is_close_bg'] = true;

echo json_encode($arr);