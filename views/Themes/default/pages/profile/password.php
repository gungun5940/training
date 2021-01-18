<?php 

$form = new Form();
/*$form = $form->create()
		->url(URL."")
		->addClass('js-submit-form form-insert')
		->method('post');
*/
$form = $form 	->create()
				->elem('div')
				->addClass('form-insert');

$form 	->field("old_password")
        ->label($this->lang->translate('Password'))
        ->type('password')
        ->addClass('form-control')
        ->maxlength(30)
        ->required(true)
        ->autocomplete("off")

        ->field("new_password")
        ->label($this->lang->translate('New Password'))
        ->type('password')
        ->addClass('form-control')
        ->maxlength(30)
        ->required(true)
        ->autocomplete("off")

    	->field("confirm_password")
        ->label($this->lang->translate('Confirm Password'))
        ->type('password')
        ->addClass('form-control')
        ->maxlength(30)
        ->required(true)
        ->autocomplete("off");

?>

<section class="container main-container">
	<div class="pal">
		<h3 class="text-center">เปลี่ยนรหัสผ่าน</h3>
		<div class="clearfix mts mbs">
			<form class="js-submit-form" action="<?=URL?>profile/password" method="POST">
				<?=$form->html()?>
				<div class="clearfix mtl text-center">
					<button type="reset" class="btn btn-danger btn-jumbo">ล้างข้อมูล</button>
					<button type="submit" class="btn btn-primary btn-submit btn-jumbo">บันทึก</button>
				</div>
			</form>
		</div>
	</div>
</section>