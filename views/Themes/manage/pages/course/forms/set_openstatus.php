<?php

$txt = '';
$clr = '';
if( $this->item['status'] == 0 ) {
	$txt = 'เปิดหลักสูตร';
	$clr = 'green';
	$arr['button'] = '<button type="submit" class="btn btn-green btn-submit"><span class="btn-text">เปิดหลักสูตร</span></button>';
	$arr['hiddenInput'][] = array('name'=>'status','value'=>1);
}
if( $this->item['status'] == 1 ) {
	$txt = 'ปิดหลักสูตร';
	$clr = 'red';
	$arr['button'] = '<button type="submit" class="btn btn-danger btn-submit"><span class="btn-text">ปิดหลักสูตร</span></button>';
	$arr['hiddenInput'][] = array('name'=>'status','value'=>0);
}

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
					</ul>
				</div>';

$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

$arr['width'] = 500;

echo json_encode($arr);