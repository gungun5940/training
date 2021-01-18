<?php

$title = "ข้อมูลสมาชิก";
if( !empty($this->item) ){
	$title = "แก้ไข{$title}";
}
else{
	$title = "เพิ่ม{$title}";
}

$form = new Form();
$form = $form 	->create()
				->elem('div')
				->addClass('form-insert form-member');

$form   ->field("name")
        ->label('ชื่อ-นามสกุล <span class="fcr">*</span>')
        ->text( $this->fn->q('form')->fullnameTH( !empty($this->item) ? $this->item : array(), array('field_first_name'=>'mem_', 'addClass'=>'inputtext') ) );

$form 	->field('mem_gender')
		->label('เพศ <span class="fcr">*</span>')
		->addClass('inputtext')
		->autocomplete('off')
		->select( $this->gender )
		->value( !empty($this->item['gender']) ? $this->item['gender'] : '' );

$form 	->field('mem_birth')
		->label('วัน เดือน ปีเกิด <span class="fwb" style="color:blue;">(เลือกเป็น พ.ศ. | ระบบแสดงแบบ ค.ศ.)</span> <span class="fcr">*</span>')
		->attr('data-plugins', 'setDatePicker')
		->attr('readonly', 1)
		->attr('style','background-color:#fff')
		// ->type('date')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['birth']) ? date("d/m/Y", strtotime($this->item['birth'])) : '' );

// $form 	->field('mem_code')
// 		->label('รหัสประจำตัวประชาชน <span class="fcr">*</span>')
// 		->addClass('inputtext')
// 		->autocomplete('off')
// 		->value( !empty($this->item['code']) ? $this->item['code'] : '' );

$form 	->field('mem_job')
		->label('อาชีพ <span class="fcr">*</span>')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['job']) ? $this->item['job'] : '' );

$form 	->field('mem_work_place')
		->label('สถานที่ทำงาน')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['work_place']) ? $this->item['code'] : '' );

/* $form 	->field('mem_address')
		->label('ที่อยู่*')
		->text( $this->fn->q('form')->address( !empty($this->item["address"])? $this->item["address"]:array(), array('city'=>$this->city ) ) ); */

$form 	->field('mem_add_num')
		->label('บ้านเลขที่ หมู่ที่ <span class="fcr">*</span>')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['add_num']) ? $this->item['add_num'] : '' );

$form 	->field('mem_add_street')
		->label('ถนน')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['add_street']) ? $this->item['add_street'] : '' );

$form 	->field('mem_add_province_id')
		->label('จังหวัด <span class="fcr">*</span>')
		->addClass('inputtext js-province')
		->autocomplete('off')
		->select( $this->province, 'id', 'name', '- กรุณาเลือกจังหวัด -' )
		->attr('data-plugins', 'select2')
		->value( !empty($this->item['add_province_id']) ? $this->item['add_province_id'] : '' );

$form 	->field('mem_add_amphure_id')
		->label('เขต / อำเภอ <span class="fcr">*</span>')
		->addClass('inputtext js-amphure')
		->autocomplete('off')
		->attr('data-plugins', 'select2')
		->select( [] );

$form 	->field('mem_add_district_id')
		->label('แขวง / ตำบล <span class="fcr">*</span>')
		->addClass('inputtext js-district')
		->autocomplete('off')
		->attr('data-plugins', 'select2')
		->select( [] );

$form 	->field('mem_add_zipcode')
		->label('รหัสไปรษณีย์ <span class="fcr">*</span>')
		->addClass('inputtext js-zipcode')
		->autocomplete('off')
		->value( !empty($this->item['add_zipcode']) ? $this->item['add_zipcode'] : '' );

$form 	->field('mem_contact')
		->label('Line ID / FB  <span class="fcr">*</span>')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['contact']) ? $this->item['contact'] : '' );

$form 	->field('mem_email')
		->label('Email <span class="fcr">*</span>')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['email']) ? $this->item['email'] : '' );

$form 	->field('mem_startdate')
		->label('วันที่เริ่มศึกษา <span class="fwb" style="color:blue;">(เลือกเป็น พ.ศ. | ระบบแสดงแบบ ค.ศ.)</span> <span class="fcr">*</span>')
		->attr('data-plugins', 'setDatePicker')
		->attr('readonly', 1)
		->attr('style','background-color:#fff')
		// ->type('date')
		->addClass('inputtext')
		->autocomplete('off')
		->value( !empty($this->item['startdate']) ? date("d/m/Y", strtotime($this->item['startdate'])) : '' );

$form 	->field("mem_username")
	    ->label('Username <span class="fcr">*</span>')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['username'])? $this->item['username']:'' );

if( empty($this->item) ){
	$form 	->field("mem_password")
	    	->label('Password <span class="fcr">*</span>')
        	->autocomplete('off')
        	->addClass('inputtext')
        	->placeholder('')
        	->type('password')
        	->value( '' );
}
$form 	->field('mem_status')
		->label("สถานะ*")
		->addClass('inputtext')
		->select( $this->status )
		->autocomplete('off')
		->value( isset($this->item['status']) ? $this->item['status'] : 1 );
?>
<div id="mainContainer" class="report-main clearfix" data-plugins="main">
	<div role="content">
		<div role="main" class="pal">
			<div style="max-width: 750px;">
				<div class="uiBoxWhite pas pam">
					<div class="clearfix">
						<div class="lfloat">
							<h3 class="fwb"><i class="icon-users"></i> <?=$title?></h3>
						</div>
					</div>
				</div>
				<?php
				$options = [
					"amphure" => !empty($this->item['add_amphure_id']) ? $this->item['add_amphure_id'] : "",
					"district" => !empty($this->item['add_district_id']) ? $this->item['add_district_id'] : ""
				];
				?>
				<form class="js-submit-form" method="POST" action="<?=URL?>members/save" data-plugins="formMember" data-options="<?= $this->fn->stringify( $options ) ?>">
					<div class="uiBoxWhite pas pam mts">
						<?=$form->html()?>
					</div>
					<div class="uiBoxWhite pas pam">
						<div class="clearfix">
							<a href="<?=$this->pageURL?>members" class="btn btn-red lfloat">กลับ</a>
							<button class="btn btn-blue js-submit rfloat">บันทึก</button>
						</div>
					</div>
					<?php 
					
					if( !empty($this->item["id"]) ){
						echo '<input type="hidden" name="id" value="'.$this->item["id"].'">';
					}
					?>
					<input type="hidden" name="next" value="<?=URL?>manage/members">
				</form>
			</div>
		</div>
	</div>
</div>