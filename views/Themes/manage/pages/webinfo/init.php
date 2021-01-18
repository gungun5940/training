<?php

$this->count_nav = 0;

$sub = array();
$sub[] = array('text'=>'จัดลำดับ', 'key'=>'seq', 'url'=>$this->pageURL.'webinfo/seq');
if( !empty($sub) ){
	$this->count_nav+=count($sub);
	$menu[] = array('text'=>'การแสดงผล', 'url'=>$this->pageURL.'webinfo', 'sub'=>$sub);
}

$sub = array();
foreach ($this->info["lists"] as $key => $value) {
	$sub[] = array('text'=>$value["name"], 'key'=>$value["id"], 'url'=>$this->pageURL.'webinfo/'.$value["id"]);
}
if( !empty($sub) ){
	$this->count_nav+=count($sub);
	$menu[] = array('text'=>'ข้อมูลสหกิจ', 'url'=>$this->pageURL.'webinfo', 'sub'=>$sub);
}
