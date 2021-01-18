<?php

$this->pageURL = URL."manage/";

$image = '';
if( !empty($this->me['image_url']) ){
	$image = '<div class="avatar lfloat mrm"><img class="img" src="'.$this->me['image_url'].'" alt="'.$this->me['fullname'].'"></div>';
}
else{
	$image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>';
}

echo '<div class="navigation-main-bg navigation-trigger"></div>';
echo '<nav class="navigation-main" role="navigation"><a class="navigation-btn-trigger navigation-trigger"><span></span></a>';

echo '<div class="navigation-main-header"><div class="anchor clearfix">'.$image.'<div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">'.$this->me['fullname'].'</div><span class="subname">'.$this->me['role_name'].'</span></div></div></div></div>';

echo '<div class="navigation-main-content">';

#manage
$mge[] = array('key'=>'course', 'text'=>'ข้อมูลหลักสูตร', 'link'=>$this->pageURL."course", 'icon'=>'book');
$mge[] = array('key'=>'members', 'text'=>'ข้อมูลสมาชิกหรือผู้เข้าอบรม', 'link'=>$this->pageURL."members", 'icon'=>'users');
$mge[] = array('key'=>'invoice', 'text'=>'ข้อมูลการร้องขอใบกำกับภาษี', 'link'=>$this->pageURL."invoice", 'icon'=>'money');
echo $this->fn->manage_nav($mge, $this->getPage('on'));
#news
$news[] = array('key'=>'news', 'text'=>'ข้อมูลข่าวสาร', 'link'=>$this->pageURL."news", 'icon'=>'newspaper-o');
echo $this->fn->manage_nav($news, $this->getPage('on'));
#webinfo
$webinfo[] = array('key'=>'webinfo', 'text'=>'เกี่ยวกับศูนย์ฯ', 'link'=>$this->pageURL."webinfo", 'icon'=>'info-circle');
echo $this->fn->manage_nav($webinfo, $this->getPage('on'));
#view
$view[] = array('key'=>'website', 'text'=>'กลับหน้าเว็บไซต์', 'link'=>URL, 'icon'=>'eye');
echo $this->fn->manage_nav($view, $this->getPage('on'));
#settings
$cog[] = array('key'=>'settings','text'=>$this->lang->translate('menu','Settings'), 'link'=>$this->pageURL.'settings','icon'=>'cog');
echo $this->fn->manage_nav($cog, $this->getPage('on'));


echo '</div>';

	echo '<div class="navigation-main-footer">';


echo '<ul class="navigation-list">'.

	'<li class="clearfix">'.
		'<div class="navigation-main-footer-cogs">'.
			'<a data-plugins="dialog" href="'.URL.'logout/admin?next='.URL.'"><i class="icon-power-off"></i><span class="visuallyhidden">Log Out</span></a>'.
			// '<a href="'.URL.'logout/admin"><i class="icon-cog"></i><span class="visuallyhidden">Settings</span></a>'.
		'</div>'.
		'<div class="navigation-brand-logo clearfix"><img class="lfloat mrm" src="'.$this->getPage('image-128').'">'.( !empty( $this->system['title'] ) ? $this->system['title']:'' ).'</div>'.
	'</li>'.
'</ul>';

echo '</div>';


echo '</nav>';