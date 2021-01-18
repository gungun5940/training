<?php
# title
$arr['title'] = "ส่งหลักฐานการชำระเงิน";

$form = new Form();
$form = $form 	->create()
				->elem('div')
				->addClass('form-insert mtm');

$form 	->field('reg_slip')
		->label("แนบหลักฐานการจ่ายเงิน / โอนเงิน*")
		->addClass('form-control')
		->attr('accept', '.png, .jpg, .jpeg')
		->type('file');

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL.'course/payregister"></form>';

# body
// <li><span class="fwb">จำนวนชั่วโมง : </span>'.$this->item['hours'].'</li>
$arr['body'] = '
				<div class="clearfix pam uiBoxWhite">
					<div class="fwb mtm"><i class="icon-book"></i> ข้อมูลหลักสูตร</div>
					<ul>
						<li><span class="fwb">ชื่อ (ไทย) : </span>'.$this->item['course_name_th'].'</li>
						<li><span class="fwb">ชื่อ (อังกฤษ) : </span>'.$this->item['course_name_en'].'</li>
						<li><span class="fwb">สถานที่อบรม : </span>'.$this->item['place'].'</li>
						<li><span class="fwb">ระยะเวลาอบรม : </span>'.$this->fn->q('time')->str_event_date($this->item['startdate'], $this->item['enddate'], true).'</li>
					</ul>
				</div>';

$arr['body'] .= $form->html();

$arr['hiddenInput'][] = array('name'=>'open_id','value'=>$this->reg['open_id']);
$arr['hiddenInput'][] = array('name'=>'mem_id','value'=>$this->reg['mem_id']);

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">ส่งหลักฐาน</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

$arr['width'] = 500;
// $arr['is_close_bg'] = true;

echo json_encode($arr);