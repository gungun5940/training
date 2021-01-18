<?php

$title = "ผู้ใช้งานระบบ";

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert');

$form 	->field("staff_username")
	    ->label('Username*')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['username'])? $this->item['username']:'' );

if( empty($this->item) ){
	$form 	->field("staff_password")
	    	->label('Password*')
        	->autocomplete('off')
        	->addClass('inputtext')
        	->placeholder('')
        	->type('password')
        	->value( '' );
}

$form   ->field("name")
        ->label('ชื่อ-นามสกุล*')
        ->text( $this->fn->q('form')->fullnameTH( !empty($this->item) ? $this->item : array(), array('field_first_name'=>'staff_') ) );

$form 	->field('staff_refno')
		->label("เลขที่ตำแหน่ง (อ้างอิง กจ.)*")
		->addClass('inputtext')
		->placeholder('')
		->autocomplete('off')
		->value( !empty($this->item['refno']) ? $this->item['refno'] : '' );

$form 	->field('staff_level')
		->label("สิทธิ์การใช้งานระบบ*")
		->addClass('inputtext')
		->select( $this->level )
		->autocomplete('off')
		->value( !empty($this->item['level']) ? $this->item['level'] : '' );

$form 	->field('staff_status')
		->label("สถานะ*")
		->addClass('inputtext')
		->select( $this->status )
		->autocomplete('off')
		->value( isset($this->item['status']) ? $this->item['status'] : 1 );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL.'staff/save"></form>';

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
