<?php

$options = array(
    'url' => URL.'media/set',
    'data' => array(
        'album_name'=>'profile',
        'obj_type'=>'profile', 
        'obj_id'=>2,
        'minimize'=> array(128,128),
        'has_quad'=> true,
     ),
    'autosize' => true,
    'show'=>'quad_url',
    'remove' => true
);

if( !empty($this->item['id']) ){
    $options['setdata_url'] = URL.'users/setdata/'.$this->item['id'].'/user_image_id/?has_image_remove';
}

$image_url = '';
$hasfile = false;
if( !empty($this->item['image_url']) ){
    $hasfile = true;
    $image_url = '<img class="img" src="'.$this->item['image_url'].'?rand='.rand(100, 1).'">';

    $options['remove_url'] = URL.'media/del/'.$this->item['image_id'];
    
}

$picture_box = '<div class="anchor"><div class="clearfix">'.

        '<div class="ProfileImageComponent lfloat size80 radius mrm is-upload'.($hasfile ? ' has-file':' has-empty').'" data-plugins="uploadProfile" data-options="'.$this->fn->stringify( $options ).'">'.
            '<div class="ProfileImageComponent_image">'.$image_url.'</div>'.
            '<div class="ProfileImageComponent_overlay"><i class="icon-camera"></i></div>'.
            '<div class="ProfileImageComponent_empty"><i class="icon-camera"></i></div>'.
            '<div class="ProfileImageComponent_uploader"><div class="loader-spin-wrap"><div class="loader-spin"></div></div></div>'.
            '<button type="button" class="ProfileImageComponent_remove"><i class="icon-remove"></i></button>'.
        '</div>'.
    '</div>'.

'</div>';

$title = "ผู้ใช้งาน";

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert form-emp');

$form   ->field("image")
        ->text( $picture_box );

	$form 	->field("user_login")
	    	->label('Username*')
        	->autocomplete('off')
        	->addClass('inputtext')
        	->placeholder('')
        	->value( !empty($this->item['login'])? $this->item['login']:'' );
if( empty($this->item) ){
	$form 	->field("user_pass")
	    	->label('Password*')
        	->autocomplete('off')
        	->addClass('inputtext')
        	->placeholder('')
        	->type('password')
        	->value( !empty($this->item['pass'])? $this->item['pass']:'' );
 }

	$form   ->field("name")
        	->label(Translate::Val('Name'))
        	->text( $this->fn->q('form')->fullname( !empty($this->item) ? $this->item : array(), array('field_first_name'=>'user_') ) );

	$form 	->field("user_email")
			->label($this->lang->translate('E-mail').'*')
			->autocomplete('off')
			->addClass('inputtext')
			->placeholder('')
			->value( !empty($this->item['email'])? $this->item['email']:'' );

	$form 	->field("user_phone_number")
			->label("เบอร์โทรศัพท์")
			->addClass("inputtext")
			->autocomplete("off")
			->value( !empty($this->item["phone_number"]) ? $this->item["phone_number"] : "" );

	$form 	->field("user_line_id")
			->label("Line ID")
			->addClass("inputtext")
			->autocomplete("off")
			->value( !empty($this->item["line_id"]) ? $this->item["line_id"] : "" );

	$form 	->field("user_role_id")
			->label("ตำแหน่ง")
			->autocomplete("off")
			->select( $this->roles )
			->addClass("inputtext")
			->value( !empty($this->item["role_id"]) ? $this->item["role_id"] : "" );

    $form   ->field('user_sch_id')
            ->label("สถานศึกษา")
            ->autocomplete('off')
            ->select( $this->school )
            ->addClass('inputtext')
            ->value( !empty($this->item['sch_id']) ? $this->item['sch_id'] : "" );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'users/save" data-plugins="form_accounts"></form>';

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
