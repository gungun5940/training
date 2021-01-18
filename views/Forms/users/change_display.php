<?php

$arr['title'] = $this->lang->translate('Confirm');
	
$arr['form'] = '<form class="js-submit-form" action="'.URL.'users/display"></form>';
$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
$arr['hiddenInput'][] = array('name'=>'status','value'=>$this->status);

$status = $this->status=="enabled" ? "เปิดการใช้งาน" : "ปิดการใช้งาน";
$arr['body'] = "ต้องการเปลี่ยนสถานะ <span class=\"fwb\">{$this->item['fullname']}</span> เป็น <span class=\"fwb fcr\">{$status}</span>";

$arr['button'] = '<button type="submit" class="btn btn-blue btn-submit"><span class="btn-text">Save</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">Cancel</span></a>';

echo json_encode($arr);