<?php 
$form = new Form();
$form = $form 	->create()
				->elem('div')
				->addClass("form-insert");

$form 	->field("info_name")
		->label("หัวข้อ")
		->addClass('inputtext')
		->autocomplete("off")
		->value( !empty($this->item["name"]) ? $this->item["name"] : "" );

$form 	->field("info_detail")
		->label("รายละเอียด / ข้อมูล")
		->addClass("inputtext")
		->type("textarea")
		->autocomplete("off")
		->attr("data-plugins", "editor2")
		->attr('data-options', $this->fn->stringify(array(
            'getData' => array(
                'obj' => 'about',
                'obj_id' => !empty($this->item['id']) ? $this->item['id'] : 'u-'.$this->me['id']
            )
        )))
		->value( !empty($this->item["detail"]) ? $this->fn->q('text')->strip_tags_editor( $this->item["detail"] ) : "" );

$form   ->field('hidden')
        ->text('<input type="hidden" name="obj_type" value="about">
                <input type="hidden" name="obj_id" value="u-'.$this->me['id'].'">');

$status = '';
foreach ($this->status as $key => $value) {
	$sel = '';
	if( $this->item["status"]["id"] == $value["id"] ) $sel='checked="1"';
	$status .= '<div>
					<label class="radio"><input type="radio" '.$sel.' name="info_status" value="'.$value["id"].'"> '.$value["name"].'</label>
				</div>';
}
$form 	->field("info_status")
		->label("สถานะ")
		->text( $status );
?>
<div class="pal" style="max-width: 1024px;">
	<div class="clearfix">
		<h3 class="fwb lfloat">จัดการข้อมูลสหกิจ</h3>
		<a href="<?=URL?>webinfo/del/<?=$this->item["id"]?>" data-plugins="dialog" class="btn btn-red rfloat"><i class="icon-trash"></i> ลบ</a>
	</div>
	<form class="js-submit-form" action="<?=URL?>webinfo/save">
		<div class="uiBoxWhite pas pam mts">
			<?=$form->html();?>
		</div>
		<div class="uiBoxWhite pas pam mts">
			<button class="btn btn-blue js-submit rfloat"><i class="icon-floppy-o"></i> บันทึก</button> 
			<a href="<?=$this->pageURL?>webinfo" class="btn btn-red"><i class="icon-arrow-left"></i> กลับ</a>
		</div>
		<input type="hidden" name="id" value="<?=$this->item["id"]?>"/>
	</form>
</div>