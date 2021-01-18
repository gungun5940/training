<?php

$arr['title'] = "ตรวจสอบหลักฐานของ {$this->item['mem_fullname']}";

$form = new Form();
$form = $form 	->create()
				->elem('div')
				->addClass('form-insert mtm');

$chk1 = '';
$chk3 = '';
if( $this->item['pay_status'] == 1 ) $chk1 = 'checked';
if( $this->item['pay_status'] == 3 ) $chk3 = 'checked';
$form 	->field("reg_pay_status")
		->label("อนุมัติหลักฐานการชำระเงิน")
		->text(
			'<div class="mts">
				<label class="radio fwb" style="color:green;"><input type="radio" name="reg_pay_status" value="1" '.$chk1.'> อนุมัติการชำระเงิน</label>
			</div>
			<div class="mts">
				<label class="radio fwb" style="color:red;"><input type="radio" name="reg_pay_status" value="3"  '.$chk3.'> การชำระเงินมีปัญหา <br>(ระบบจะให้ผู้สมัคร ส่งหลักฐานใหม่)</label>
			</div>'
		);

$arr['body'] = '<div class="clearfix">
					<div style="width:100%">
						<div style="width:50%" class="lfloat pas">
							<span><i class="icon-picture-o"></i> รูปหลักฐาน</span>
							<img class="mts" src="'.FILE_SLIP.$this->item['slip'].'" style="width:100%; height:auto;">
						</div>
						<div style="width:50%" class="rfloat pas">
							<div class="clearfix pam uiBoxWhite">
								<div><i class="icon-user"></i> ข้อมูลผู้สมัคร</div>
								<ul>
									<li><span>ชื่อ-นามสกุล : </span>'.$this->item['mem_fullname'].'</li>
								</ul>
								<div class=" mtm"><i class="icon-book"></i> ข้อมูลหลักสูตร</div>
								<ul>
									<li><span>ชื่อ (ไทย) : </span>'.$this->open['course_name_th'].'</li>
									<li><span>ชื่อ (อังกฤษ) : </span>'.$this->open['course_name_en'].'</li>
									<li><span>ค่าสมัคร : </span>'.number_format($this->open['price']).' บาท</li>
								</ul>
							</div>
							'.$form->html().'
						</div>
					</div>
				</div>
				';

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL.'course/payments"></form>';

$arr['hiddenInput'][] = array('name'=>'open_id','value'=>$this->item['open_id']);
$arr['hiddenInput'][] = array('name'=>'mem_id','value'=>$this->item['mem_id']);

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

$arr['width'] = 782;
echo json_encode($arr);