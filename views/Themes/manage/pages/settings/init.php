<?php

$this->count_nav = 0;

/* System */
$sub = array();
$sub[] = array('text' => 'ระบบเว็บไซต์','key' => 'system','url' => $this->pageURL.'settings/system');
$sub[] = array('text' => 'โปรไฟล์','key' => 'my','url' => $this->pageURL.'settings/my');
if( !empty($sub) ){
	$this->count_nav+=count($sub);
	$menu[] = array('text' => $this->lang->translate('Preferences'), 'url' => $this->pageURL.'settings', 'sub' => $sub);
}

// admin
$sub = array();
$sub[] = array('text'=> 'ผู้จัดการระบบ','key'=>'staff','url'=>$this->pageURL.'settings/accounts/staff');
if( !empty($sub) ){
	$this->count_nav+=count($sub);
	$menu[] = array('text'=> $this->lang->translate('Accounts'),'sub' => $sub, 'url' => $this->pageURL.'settings/accounts');
}

// news
$sub = array();
$sub[] = array('text'=> 'ประเภท/หมวดหมู่ข่าวสาร','key'=>'type','url'=>$this->pageURL.'settings/news/type');
if( !empty($sub) ){
	$this->count_nav+=count($sub);
	$menu[] = array('text'=> 'ข่าวสาร','sub' => $sub, 'url' => $this->pageURL.'settings/news');
}