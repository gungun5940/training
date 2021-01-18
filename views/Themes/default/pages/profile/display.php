<?php
$form = new Form();
$form = $form 	->create()
				->elem('div')
				->addClass('form-insert form-member');

$form   ->field("name")
        ->label('ชื่อ-นามสกุล <span class="fcr">*</span>')
        ->text( $this->fn->q('form')->fullnameTH( !empty($this->me) ? $this->me : array(), array('field_first_name'=>'mem_', 'addClass'=>'form-control') ) );

$form 	->field('mem_gender')
		->label('เพศ <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off')
		->select( $this->gender )
		->value( !empty($this->me['gender']) ? $this->me['gender'] : "" );

$form 	->field('mem_birth')
		->label('วัน เดือน ปีเกิด <span class="fwb" style="color:blue;">(เลือกเป็น พ.ศ. | ระบบแสดงแบบ ค.ศ.)</span> <span class="fcr">*</span>')
		->attr('data-plugins', 'setDatePicker')
		->attr('readonly', 1)
		->attr('style','background-color:#fff')
		// ->type('date')
		->addClass('form-control')
		->autocomplete('off')
		->value( !empty($this->me['birth']) ? date("d/m/Y", strtotime($this->me['birth'])) : "" );

// $form 	->field('mem_code')
// 		->label('รหัสประจำตัวประชาชน <span class="fcr">*</span>')
// 		->addClass('form-control')
// 		->autocomplete('off')
// 		->attr('readonly', 1)
// 		->value( !empty($this->me['code']) ? $this->me['code'] : "" );

$form 	->field('mem_job')
		->label('อาชีพ <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off')
		->value( !empty($this->me['job']) ? $this->me['job'] : "" );

$form 	->field('mem_work_place')
		->label('สถานที่ทำงาน <span class="fwb" style="color:blue;">(หากไม่มีให้ใส่ -)</span> <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off')
		->value( !empty($this->me['work_place']) ? $this->me['work_place'] : "" );

/* $form 	->field('mem_address')
		->label('ที่อยู่*')
		->text( $this->fn->q('form')->address( !empty($this->item["address"])? $this->item["address"]:array(), array('city'=>$this->city ) ) ); */

$form 	->field('mem_add_num')
		->label('บ้านเลขที่ หมู่ที่ <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off')
		->value( !empty($this->me['add_num']) ? $this->me['add_num'] : "" );

$form 	->field('mem_add_street')
		->label('ถนน <span class="fwb" style="color:blue;">(หากไม่มีให้ใส่ -)</span> <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off')
		->value( !empty($this->me['add_street']) ? $this->me['add_street'] : "" );

$form 	->field('mem_add_province_id')
		->label('จังหวัด <span class="fcr">*</span>')
		->addClass('form-control js-province')
		->autocomplete('off')
		->select( $this->province, 'id', 'name', '- กรุณาเลือกจังหวัด -' )
		->attr('data-plugins', 'select2')
		->value( !empty($this->me['add_province_id']) ? $this->me['add_province_id'] : "" );

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
		->label('รหัสตำบล (รหัสไปรษณีย์) <span class="fcr">*</span>')
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
		->value( !empty($this->me['contact']) ? $this->me['contact'] : '' );

$form 	->field('mem_email')
		->label('Email <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off')
		->value( !empty($this->me['email']) ? $this->me['email'] : '' );

$form 	->field('mem_startdate')
		->label('วันที่เริ่มศึกษา <span class="fwb" style="color:blue;">(เลือกเป็น พ.ศ. | ระบบแสดงแบบ ค.ศ.)</span> <span class="fcr">*</span>')
		->attr('data-plugins', 'setDatePicker')
		->attr('readonly', 1)
		->attr('style','background-color:#fff')
		// ->type('date')
		->addClass('form-control')
		->autocomplete('off')
		->value( !empty($this->me['startdate']) ? date("d/m/Y", strtotime($this->me['startdate'])) : '' );

$form 	->field("mem_username")
	    ->label('Username <span class="fcr">*</span>')
        ->autocomplete('off')
		->addClass('form-control')
		->attr('readonly', 1)
        ->placeholder('')
        ->value( !empty($this->me['username'])? $this->me['username']:'' );
?>
<style type="text/css" media="screen">
	.ui-datepicker select.ui-datepicker-month{
		width: 55%
	}
</style>
<section class="container main-container">
	<div class="pal">
		<h3 class="text-center">จัดการข้อมูลส่วนตัว</h3>
		<div class="clearfix mts mbs">
			<?php
			$options = [
				"amphure" => !empty($this->me['add_amphure_id']) ? $this->me['add_amphure_id'] : "",
				"district" => !empty($this->me['add_district_id']) ? $this->me['add_district_id'] : ""
			];
			?>
			<form class="js-submit-form" action="<?=URL?>members/save" method="POST" data-plugins="formMember" data-options="<?= $this->fn->stringify( $options ) ?>">
				<?=$form->html()?>
				<div class="clearfix mtl text-center">
					<button type="reset" class="btn btn-danger btn-jumbo">ล้างข้อมูล</button>
					<button type="submit" class="btn btn-primary btn-submit btn-jumbo">บันทึกข้อมูล</button>
				</div>	
				<input type="hidden" name="id" value="<?=$this->me['id']?>">
				<input type="hidden" name="mem_status" value="<?=$this->me['status']?>">			
			</form>
		</div>
	</div>
</section>