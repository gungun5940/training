<?php

$arr['title'] = "ประวัติการเปิด-ปิดหลักสูตร | รหัส Tech{$this->item['code']}";

$tbody = '';
$no = 1;
if( !empty($this->open) ){
	foreach ($this->open as $key => $value) {

		if( $value['status'] == 0 ) $cls = 'btn-red';
		if( $value['status'] == 1 ) $cls = 'btn-green';

		$tbody .= '<tr>
						<td class="tac pam">'.$no.'</td>
						<td class="tac pam">'.$value['startyear'].'</td>
						<td class="tac pam">'.$value['endyear'].'</td>
						<td class="pam">'.$this->fn->q('time')->str_event_date($value['startdate'], $value['enddate'], true).'</td>
						<td class="pam tac"><a class="btn '.$cls.' btn-small">'.$value['status_name'].'</a></td>
			   		</tr>';
		$no++;
	}
}
else{
	$tbody = '<tr><td class="tac pal" colspan="5"><h4 class="fwb fcr">ไม่พบประวัติการเปิด-ปิดหลักสูตร</h4></td></tr>';
}


// $arr['body'] = "คุณต้องการปิดหลักสูตร <span class=\"fwb\">\"{$this->item['name_th']}\" </span> ใช่หรือไม่?";
$arr['body'] = '<div class="clearfix pas pam uiBoxWhite">
					<div class="fwb"><i class="icon-book"></i> ข้อมูลหลักสูตร</div>
					<ul>
						<li><span class="fwb">ชื่อ (ไทย) : </span>'.$this->item['name_th'].'</li>
						<li><span class="fwb">ชื่อ (อังกฤษ) : </span>'.$this->item['name_en'].'</li>
					</ul>
				</div>
				<div class="clearfix mts">
					<table class="table-bordered" width="100%">
						<thead style="background-color:#6d1c1c; color:#fff;">
							<tr>
								<th class="pas" width="5%">#</th>
								<th class="pas" width="15%">ปีที่เปิด</th>
								<th class="pas" width="15%">ปีที่ปิด</th>
								<th class="pas" width="35%">ระยะเวลาหลักสูตร</th>
								<th class="pas" width="20%">สถานะ</th>
							</tr>
						</thead>
						<tbody>
							'.$tbody.'
						</tbody>
					</table>
				</div>';

$arr['width'] = 800;

$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ปิดหน้าต่าง</span></a>';

$arr['is_close_bg'] = true;

echo json_encode($arr);