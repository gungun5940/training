<?php

if( isset($_REQUEST['next']) ){
	$arr['hiddenInput'][] = array('name'=>'next','value'=>$_REQUEST['next']);
}

$arr['hiddenInput'][] = array('name'=>'ref','value'=>'mb');
$arr['hiddenInput'][] = array('name'=>'h','value'=>'AfcbKa6ETzqgrsz2');

$arr['title'] = 'ยืนยันการออกจากระบบ';
$arr['body'] = "คุณต้องการออกจากระบบหรือไม่?";


$arr['form'] = '<form class="js-submit-form" action="'.URL.'logout/admin" method="post">';
$arr['button'] = '<a href="#" class="btn btn-link btn-cancel" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';
$arr['button'] .= '<button type="submit" class="btn btn-danger btn-submit">ออกจากระบบ</button>';

echo json_encode($arr);