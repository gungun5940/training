<?php

$title = "ข้อมูลสมาชิก";

$form = new Form();
$form = $form 	->create()
				->elem('div')
				->addClass('form-insert');

$form   ->field("name")
        ->label('ชื่อ-นามสกุล*')
        ->text( $this->fn->q('form')->fullnameTH( !empty($this->item) ? $this->item : array(), array('field_first_name'=>'mem_') ) );

$form 	->field('mem_gender')
		->label('เพศ*')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['gender']) ? $this->item['gender'] : '' );

$form 	->field('mem_birth')
		->label('วัน เดือน ปีเกิด*')
		->type('date')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['birth']) ? $this->item['birth'] : '' );

$form 	->field('mem_code')
		->label('รหัสประจำตัวประชาชน')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['code']) ? $this->item['code'] : '' );

$form 	->field('mem_add1')
		->label('บ้านเลขที่ หมู่ที่')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['add1']) ? $this->item['add1'] : '' );

$form 	->field('mem_add2')
		->label('ถนน')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['add2']) ? $this->item['add2'] : '' );

$form 	->field('mem_add3')
		->label('รหัสตำบล (รหัสไปรษณีย์)')
		->addClass('inputtext js-zipcode')
		->autocomplete('off')
		->value( !empty($this->item['add3']) ? $this->item['add3'] : '' );

$form 	->field('txtAddress')
		->text('<div class="clearfix fcr">
					--- แสดงข้อมูล ตำบล อำเภอ จังหวัด ---
				</div>');

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL.'members/save"></form>';

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
$arr['is_close_bg'] = true;

echo json_encode($arr);