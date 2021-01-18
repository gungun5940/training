<?php

$arr['title'] = "เปิดอบรมหลักสูตร รหัส : Tech".$this->course['code'];
if( !empty($this->item) ){
	$arr['title'] = "แก้ไขอบรมหลักสูตร รหัส : Tech".$this->course['code'];
}

$form = new Form();
$form = $form 	->create()
				->elem('div')
				->addClass('form-insert');


$form 	->field('open_date')
		->label('วันที่เริ่มเปิดหลักสูตร <span class="fwb" style="color:blue;">(เลือกเป็น พ.ศ. | ระบบแสดงแบบ ค.ศ.)</span> <span class="fcr">*</span>')
		->addClass('inputtext')
		->autocomplete('off')
		// ->type('date')
		->attr('data-plugins', 'setDatePicker')
		->attr('readonly', 1)
		->value( !empty(date("Y-m-d")) ? date("d/m/Y", strtotime(date("Y-m-d"))) : "" );
		//->value( !empty($this->item['date']) ? date("d/m/Y", strtotime($this->item['date'])) : "" );

$form 	->field('open_startdate_reg')
		->label('วันที่เริ่มเปิดรับสมัคร <span class="fwb" style="color:blue;">(เลือกเป็น พ.ศ. | ระบบแสดงแบบ ค.ศ.)</span> <span class="fcr">*</span>')
		->addClass('inputtext')
		->autocomplete('off')
		// ->type('date')
		->attr('data-plugins', 'setDatePicker')
		->attr('readonly', 1)
		->value( !empty($this->item['startdate_reg']) ? date("d/m/Y", strtotime($this->item['startdate_reg'])) : "" );

$form 	->field('open_enddate_reg')
		->label('วันที่ปิดการรับสมัคร <span class="fwb" style="color:blue;">(เลือกเป็น พ.ศ. | ระบบแสดงแบบ ค.ศ.)</span> <span class="fcr">*</span>')
		->addClass('inputtext')
		->autocomplete('off')
		// ->type('date')
		->attr('data-plugins', 'setDatePicker')
		->attr('readonly', 1)
		->value( !empty($this->item['enddate_reg']) ? date("d/m/Y", strtotime($this->item['enddate_reg'])) : "" );

$form 	->field('open_startdate')
		->label('วันที่เริ่มอบรม <span class="fwb" style="color:blue;">(เลือกเป็น พ.ศ. | ระบบแสดงแบบ ค.ศ.)</span> <span class="fcr">*</span>')
		->addClass('inputtext')
		->autocomplete('off')
		// ->type('date')
		->attr('data-plugins', 'setDatePicker')
		->attr('readonly', 1)
		->value( !empty($this->item['startdate']) ? date("d/m/Y", strtotime($this->item['startdate'])) : "" );

$form 	->field('open_enddate')
		->label('วันที่สิ้นสุดการอบรม <span class="fwb" style="color:blue;">(เลือกเป็น พ.ศ. | ระบบแสดงแบบ ค.ศ.)</span> <span class="fcr">*</span>')
		->addClass('inputtext')
		->autocomplete('off')
		// ->type('date')
		->attr('data-plugins', 'setDatePicker')
		->attr('readonly', 1)
		->value( !empty($this->item['enddate']) ? date("d/m/Y", strtotime($this->item['enddate'])) : "" );
		
$form 	->field('open_member')
		->label('จำนวนผู้เข้าอบรม')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['member']) ? $this->item['member'] : '' );

$form 	->field('open_place')
		->label('สถานที่อบรม')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['place']) ? $this->item['place'] : '' );
		
$form 	->field('open_staff_id')
		->label('วิทยากรหลัก')
		->addClass('inputtext')
		->select($this->staff['lists'],'id','fullname','- เลือกวิทยากร -')
		->attr('data-plugins','select2')
		->autocomplete('off')
		->value( !empty($this->item['staff_id']) ? $this->item['staff_id'] : '' );

$ckPriceStatus[0] = "checked";
$ckPriceStatus[1] = "";

if( !empty($this->item['price']) && $this->item['price'] < 0 ){
	$ckPriceStatus[0] = "";
	$ckPriceStatus[1] = "checked";
}

$form 	->field('open_price_status')
		->label('มีค่าใช้จ่ายในการสมัครหรือไม่ ?')
		->text('
			<div class="clearfix">
				<div class="mts">
					<label class="radio"><input type="radio" class="radio js-price-status" name="open_price_status" value="0" '.$ckPriceStatus[0].'>ไม่มีค่าใช้จ่าย</label>
				</div>
				<div class="mts">
					<label class="radio"><input type="radio" class="radio js-price-status" name="open_price_status" value="1" '.$ckPriceStatus[1].'>มีค่าใช้จ่าย</label>
				</div>
			</div>
			');

$form 	->field('open_price')
		->label('ค่าสมัคร<span class="fwb" style="color:blue;">(กรณีที่เป็นการอบรมไม่เสียค่าใช้จ่าย ไม่ต้องกรอกช่องนี้)</span> <span class="fcr">*</span>')
		->addClass('inputtext js-price')
		->autocomplete('off')
		->value( !empty($this->item['price']) ? $this->item['price'] : '' );

/* $form 	->field('open_status')
		->label('สถานะการอบรม <span class="fcr">*</span>')
		->addClass('inputtext')
		->autocomplete('off')
		->select( $this->status )
		->value( isset($this->item['status']) ? $this->item['status'] : '' );
*/

$form 	->field('open_pdf_file')
		->label('อัพโหลดไฟล์ PDF (รายละเอียดการอบรม)')
		->addClass('inputtext')
		->attr('accept','application/pdf')
		->type('file');

if( !empty($this->item['pdf_file']) ){
	$form 	->field('old_file')
			->text(' <div>
						<a target="_blank" href="'.FILE_PDF.$this->item['pdf_file'].'" class="btn btn-blue"><i class="icon-file-pdf-o"></i> Download File</a>
					</div> ');
}

$arr['hiddenInput'][] = array('name'=>'open_course','value'=>$this->course['id']);
$arr['hiddenInput'][] = array('name'=>'open_status','value'=>1);

if( !empty($this->item['id']) ){
	$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL.'course/save_opencourse" data-plugins="formOpenCourse"></form>';

# body
$arr['body'] = $form->html();

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

// $arr['width'] = 782;
// $arr['is_close_bg'] = true;

echo json_encode($arr);