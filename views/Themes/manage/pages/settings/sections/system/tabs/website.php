<?php

$form = new Form();
$form = $form->create()
		->url($this->url."settings/system?run=1")
		->addClass('js-submit-form')
		->method('post');

$form  	->field("website_status")
		->label($this->lang->translate('Website maintenance'))
		->addClass('inputtext')
		->autocomplete("off")
		->select( array(
			0 => array("id"=>"normal" , "name"=>"Normal Service"),
			1 => array("id"=>"maintenance", "name"=>"Maintenance Service")
		) )
		->value( !empty($this->system['website_status']) ? $this->system['website_status']:'');

$form  	->submit()
		->addClass("btn-submit btn btn-blue")
		->value($this->lang->translate('Save'));

echo $form->html();
