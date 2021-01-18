<?php
$form = new Form();
$form = $form 	->create()
				->elem('div')
				->addClass('form-insert');

$form 	->field('inv_name')
		->label('ชื่อผู้เสียภาษี <span class="fcr">*</span>')
		->addClass("form-control")
		->autocomplete('off')
		->value( !empty($this->item['name']) ? $this->item['name'] : '' );

$form 	->field('inv_code')
		->label('รหัสประจำตัวประชาชน / เลขที่เสียภาษี <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off')
		->value( !empty($this->item['code']) ? $this->item['code'] : '' );

$form 	->field('inv_add_num')
		->label('เลขที่ หมู่ที่ <span class="fcr">*</span>')
		->addClass('form-control')
		->autocomplete('off')
		->value( !empty($this->item['add_num']) ? $this->item['add_num'] : '' );

$form 	->field('inv_add_street')
		// ->label('ถนน <span class="fwb" style="color:blue;">(หากไม่มีให้ใส่ -)</span> <span class="fcr">*</span>')
		->label('ถนน')
		->addClass('form-control')
		->autocomplete('off')
		->value( !empty($this->item['add_street']) ? $this->item['add_street'] : '' );

$form 	->field('inv_add_province_id')
		->label('จังหวัด <span class="fcr">*</span>')
		->addClass('form-control js-province')
		->autocomplete('off')
		->select( $this->province, 'id', 'name', '- กรุณาเลือกจังหวัด -' )
		->attr('data-plugins', 'select2')
		->value( !empty($this->item['add_province_id']) ? $this->item['add_province_id'] : '' );

$form 	->field('inv_add_amphure_id')
		->label('เขต / อำเภอ <span class="fcr">*</span>')
		->addClass('form-control js-amphure')
		->autocomplete('off')
		->attr('data-plugins', 'select2')
		->select( [] );

$form 	->field('inv_add_district_id')
		->label('แขวง / ตำบล <span class="fcr">*</span>')
		->addClass('form-control js-district')
		->autocomplete('off')
		->attr('data-plugins', 'select2')
		->select( [] );

$form 	->field('inv_add_zipcode')
		->label('รหัสตำบล (รหัสไปรษณีย์) <span class="fcr">*</span>')
		->addClass('form-control js-zipcode')
		->autocomplete('off');

$title = "กรอกคำร้อง";
if( !empty($this->item) ){
	$title = "แก้ไขคำร้อง";
}
?>
<section class="container main-container">
	<div class="pal">
		<h3 class="text-center"><?=$title?> ขอใบกำกับภาษี</h3>
		<div class="clearfix mts mbl">
			<div class="uiBoxWhite pas pam">
				<ul style="margin-bottom: 0px;">
					<li class="fwb"><h4>ข้อมูลหลักสูตร</h4></li>
					<li><span class="fwb">ชื่อหลักสูตร (ภาษาไทย) : </span> <?=$this->results['course_name_th']?></li>
					<li><span class="fwb">ชื่อหลักสูตร (ภาษาอังกฤษ) : </span> <?=$this->results['course_name_en']?></li>
					<li><span class="fwb">ระยะเวลาอบรม : </span> <?=$this->fn->q('time')->str_event_date($this->results['open_startdate'], $this->results['open_enddate'], true)?></li>
					<li><span class="fwb">สถานที่ : </span> <?=$this->results['open_place']?></li>
				</ul>
			</div>
		</div>
		<div class="clearfix mts mbs">
			<?php
			$options = [
				"amphure" => !empty($this->item['add_amphure_id']) ? $this->item['add_amphure_id'] : "",
				"district" => !empty($this->item['add_district_id']) ? $this->item['add_district_id'] : ""
			];
			?>
			<form class="js-submit-form" action="<?=URL?>invoice/save" method="POST" data-plugins="formMember" data-options="<?= $this->fn->stringify( $options ) ?>">
				<?=$form->html()?>
				<div class="clearfix mtl text-center">
					<button type="reset" class="btn btn-danger btn-jumbo">ล้างข้อมูล</button>
					<button type="submit" class="btn btn-primary btn-submit btn-jumbo">บันทึก</button>
				</div>

				<input type="hidden" name="inv_course_id" value="<?=$this->results['course_id']?>">
				<input type="hidden" name="inv_open_id" value="<?=$this->results['open_id']?>">
				<?php
				if( !empty($this->item) ){
					echo '<input type="hidden" name="id" value="'.$this->item['id'].'">';
				}
				?>
			</form>
		</div>
	</div>
</section>