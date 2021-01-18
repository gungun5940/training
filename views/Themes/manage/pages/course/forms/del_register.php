<?php

$arr['title'] = "ยืนยันการลบการลงทะเบียนอบรม";
$arr['form'] = '<form class="js-submit-form" action="'.URL.'course/del_register"></form>';
$arr['hiddenInput'][] = array('name'=>'open_id','value'=>$this->item['open_id']);
$arr['hiddenInput'][] = array('name'=>'mem_id','value'=>$this->item['mem_id']);
$arr['body'] = "คุณต้องการลบ <span class=\"fwb\">\"{$this->item['mem_fullname']}\" </span> ออกจากการอบรมใช่หรือไม่ ?";
$arr['body'] .= '<div class="mtm"><span class="fcr">* การลบจะเป็นเสมือนผู้ใช้งานนี้ยังไม่เคยลงทะเบียน ผู้ใช้งานจะสามารถกลับมาลงทะเบียนได้อีกครั้ง</span></div>';

$arr['button'] = '<button type="submit" class="btn btn-danger btn-submit"><span class="btn-text">ลบ</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);
