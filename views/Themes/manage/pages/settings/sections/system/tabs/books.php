<?php

$form = new Form();
$form = $form->create()
		->url(URL."system/set")
		->addClass('js-submit-form')
		->method('post');

$form  	->field("book")
		->label("เลขหนังสือกองบริการการศึกษา")
		->addClass('inputtext')
		->autocomplete("off")
		->value( !empty($this->system['book']) ? $this->system['book']:'' );

$form  	->submit()
		->addClass("btn-submit btn btn-blue")
		->value($this->lang->translate('Save'));

echo $form->html();