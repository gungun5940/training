<?php
$form = new Form();
$form = $form 	->create()
				->elem('div')
				->addClass('form-insert form-member');

$form   ->field("name")
        ->label('ชื่อ-นามสกุล <span class="fcr">*</span>')
        ->text( $this->fn->q('form')->fullnameTH( !empty($this->item) ? $this->item : array(), array('field_first_name'=>'mem_', 'addClass'=>'form-control') ) );

$form 	->field('mem_gender')
		->label('เพศ <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off')
		->select( $this->gender );

$form 	->field('mem_birth')
		->label('วัน เดือน ปีเกิด <span class="fwb" style="color:blue;">(เลือกเป็น พ.ศ. | ระบบแสดงแบบ ค.ศ.)</span> <span class="fcr">*</span>')
		->attr('data-plugins', 'setDatePicker')
		->attr('readonly', 1)
		->attr('style','background-color:#fff')
		// ->type('date')
		->addClass('form-control')
		->autocomplete('off');

// $form 	->field('mem_code')
// 		->label('รหัสประจำตัวประชาชน <span class="fcr">*</span>')
// 		->addClass('form-control')
// 		->autocomplete('off');

$form 	->field('mem_job')
		->label('อาชีพ <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off');
		
$form 	->field('mem_work_place')
		->label('สถานที่ทำงาน <span class="fwb" style="color:blue;">(หากไม่มีให้ใส่ -)</span> <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off');

/* $form 	->field('mem_address')
		->label('ที่อยู่*')
		->text( $this->fn->q('form')->address( !empty($this->item["address"])? $this->item["address"]:array(), array('city'=>$this->city ) ) ); */

$form 	->field('mem_add_num')
		->label('บ้านเลขที่ หมู่ที่ <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off');

$form 	->field('mem_add_street')
		->label('ถนน <span class="fwb" style="color:blue;">(หากไม่มีให้ใส่ -)</span> <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off');

$form 	->field('mem_add_province_id')
		->label('จังหวัด <span class="fcr">*</span>')
		->addClass('form-control js-province')
		->autocomplete('off')
		->select( $this->province, 'id', 'name', '- กรุณาเลือกจังหวัด -' )
		->attr('data-plugins', 'select2');

$form 	->field('mem_add_amphure_id')
		->label('เขต / อำเภอ <span class="fcr">*</span>')
		->addClass('form-control js-amphure')
		->autocomplete('off')
		->attr('data-plugins', 'select2')
		->select( [] );

$form 	->field('mem_add_district_id')
		->label('แขวง / ตำบล <span class="fcr">*</span>')
		->addClass('form-control js-district')
		->autocomplete('off')
		->attr('data-plugins', 'select2')
		->select( [] );

$form 	->field('mem_add_zipcode')
		->label('รหัสไปรษณีย์ <span class="fcr">*</span>')
		->addClass('form-control js-zipcode')
		->autocomplete('off');

/* $form 	->field('txtAddress')
		->text('<div class="clearfix fcr">
					--- แสดงข้อมูล ตำบล อำเภอ จังหวัด ---
				</div>'); */

$form 	->field('mem_contact')
		->label('Line ID / FB  <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off')
		->value( !empty($this->item['contact']) ? $this->item['contact'] : '' );

$form 	->field('mem_email')
		->label('Email <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off')
		->value( !empty($this->item['email']) ? $this->item['email'] : '' );

$form 	->field('mem_startdate')
		->label('วันที่เริ่มศึกษา <span class="fwb" style="color:blue;">(เลือกเป็น พ.ศ. | ระบบแสดงแบบ ค.ศ.)</span> <span class="fcr">*</span>')
		->attr('data-plugins', 'setDatePicker')
		->attr('readonly', 1)
		->attr('style','background-color:#fff')
		// ->type('date')
		->addClass('form-control')
		->autocomplete('off')
		->value( !empty($this->item['startdate']) ? date("d/m/Y", strtotime($this->item['startdate'])) : '' );

$form 	->field("mem_username")
	    ->label('Username <span class="fcr">*</span>')
        ->autocomplete('off')
        ->addClass('form-control')
        ->placeholder('')
        ->value( !empty($this->item['username'])? $this->item['username']:'' );

if( empty($this->item) ){
	$form 	->field("mem_password")
	    	->label('Password <span class="fcr">*</span>')
        	->autocomplete('off')
        	->addClass('form-control')
        	->placeholder('')
        	->type('password')
        	->value( '' );
}
?>
<style type="text/css" media="screen">
	.ui-datepicker select.ui-datepicker-month{
		width: 55%
	}
</style>
<section class="container main-container">
	<div class="pal">
		<h3 class="text-center">สมัครสมาชิก</h3>
		<div class="clearfix mts mbs">
			<form class="js-submit-form" action="<?=URL?>members/save" method="POST" data-plugins="formMember">
				<?=$form->html()?>
				<div class="clearfix mtl text-center">
					<button type="reset" class="btn btn-danger btn-jumbo">ล้างข้อมูล</button>
					<button type="submit" class="btn btn-primary btn-submit btn-jumbo">สมัครสมาชิก</button>
				</div>
				<input type="hidden" name="mem_status" value="0">
				<input type="hidden" name="next" value="<?=URL?>">			
				<input type="hidden" name="front" value="1">			
			</form>
		</div>
	</div>
</section>