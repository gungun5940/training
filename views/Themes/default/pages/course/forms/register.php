<?php
# title
$arr['title'] = "ยืนยันการลงทะเบียนหลักสูตร";

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL.'course/register"></form>';

# body
// <li><span class="fwb">จำนวนชั่วโมง : </span>'.$this->item['hours'].'</li>
$arr['body'] = '<h4 class="text-center" style="margin-top:-10px !important;">
					<span class="fwb" style="color:blue;">คุณต้องการลงทะเบียนหลักสูตรนี้ ใช่หรือไม่ ?</span>
				</h4>
				<div class="clearfix pam uiBoxWhite">
					<div class="fwb mtm"><i class="icon-book"></i> ข้อมูลหลักสูตร</div>
					<ul>
						<li><span class="fwb">ชื่อ (ไทย) : </span>'.$this->course['name_th'].'</li>
						<li><span class="fwb">ชื่อ (อังกฤษ) : </span>'.$this->course['name_en'].'</li>
						<li><span class="fwb">สถานที่อบรม : </span>'.$this->item['place'].'</li>
						<li><span class="fwb">ระยะเวลาอบรม : </span>'.$this->fn->q('time')->str_event_date($this->item['startdate'], $this->item['enddate'], true).'</li>
						<p class="fcr tac mts">*ในกรณีคอร์สมีค่าใช้จ่ายต้องแนบสลิปการโอนเงิน*</p>
					</ul>
				</div>';

$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">ลงทะเบียน</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

$arr['width'] = 500;
// $arr['is_close_bg'] = true;

echo json_encode($arr);