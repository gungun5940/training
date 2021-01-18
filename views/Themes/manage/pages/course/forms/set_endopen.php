<?php

$txt = '';
$clr = '';
$txt = 'จบหลักสูตร';
$clr = 'blue';
$arr['button'] = '<button type="submit" class="btn btn-blue btn-submit"><span class="btn-text">จบหลักสูตร</span></button>';
$arr['hiddenInput'][] = array('name'=>'status','value'=>2);
$arr['title'] = "ยืนยันการ{$txt} รหัส Tech{$this->course['code']}";

$arr['form'] = '<form class="js-submit-form" action="'.URL.'course/save_openstatus"></form>';
$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
$arr['body'] = '<div class="clearfix pas pam uiBoxWhite">
					<div class="tac">
						<span class="fwb">คุณต้องการ <span style="color:'.$clr.';"> '.$txt.' </span> รหัส : Tech'.$this->course['code'].' ใช่หรือไม่ ?</span>
					</div>
					<div class="fwb mts"><i class="icon-book"></i> ข้อมูลหลักสูตร</div>
					<ul>
						<li><span class="fwb">ชื่อ (ไทย) : </span>'.$this->course['name_th'].'</li>
						<li><span class="fwb">ชื่อ (อังกฤษ) : </span>'.$this->course['name_en'].'</li>
						<li><span class="fwb">ปีที่เปิดหลักสูตร : </span>'.$this->item['startyear'].'</li>
						<li><span class="fwb">ปีที่สิ้นสุดหลักสูตร : </span>'.$this->item['endyear'].'</li>
						<li><span class="fwb">ระยะเวลาที่กำหนด : </span>'.$this->fn->q('time')->str_event_date($this->item['startdate'], $this->item['enddate'], true).'</li>
						<p class="fcr tac mts">**หากจบหลักสูตรแล้วจะไม่สามารถแก้ไขข้อมูลทั้งหมดได้**</p>
					</ul>
				</div>';

$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

$arr['width'] = 500;

echo json_encode($arr);