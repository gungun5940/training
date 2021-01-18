<?php 

if( empty($this->me) ){
	$this->menu_nav = [];
	$this->menu_nav[] = ['label'=>'หน้าแรก', 'key'=>'Home', 'icon'=>'home', 'url'=>URL];
	$this->menu_nav[] = ['label'=>'เกี่ยวกับศูนย์', 'key'=>'About', 'icon'=>'info-circle', 'url'=>URL.'about'];
	$this->menu_nav[] = ['label'=>'คู่มือการใช้งาน', 'key'=>'Manual', 'icon'=>'tools', 'url'=>'#'];
	$this->menu_nav[] = ['label'=>'หลักสูตรที่เปิดอบรม', 'key'=>'Training course', 'icon'=>'book', 'url'=>URL.'course'];

	$sub = [];
	$sub[] = ['label'=>'กลุ่มอุตสาหกรรม', 'url'=>'https://bit.ly/3k2Tczp', 'attr'=>'target="_blank"'];
	$sub[] = ['label'=>'กลุ่มทั่วไป', 'url'=>'https://bit.ly/2H55gBX', 'attr'=>'target="_blank"'];
	$sub[] = ['label'=>'กลุ่มการศึกษา', 'url'=>'https://bit.ly/3lQxlM4', 'attr'=>'target="_blank"'];
	$this->menu_nav[] = ['label'=>'แบบสำรวจ', 'key'=>'Survey', 'icon'=>'poll', 'url'=>'#', 'sub'=>$sub];
	$this->menu_nav[] = ['label'=>'สมัครสมาชิก', 'key'=>'Register', 'icon'=>'registered', 'url'=>URL.'register'];
	$this->menu_nav[] = ['label'=>'เข้าสู่ระบบ', 'key'=>'Login', 'icon'=>'user', 'url'=>URL.'login'];
}
else{
	if( $this->me['auth'] == "staff" ){
		$this->menu_nav = [];
		$this->menu_nav[] = ['label'=>'หน้าแรก', 'key'=>'Home', 'icon'=>'home', 'url'=>URL];
		$this->menu_nav[] = ['label'=>'เกี่ยวกับศูนย์', 'key'=>'About', 'icon'=>'info-circle', 'url'=>URL.'about'];
		$this->menu_nav[] = ['label'=>'คู่มือการใช้งาน', 'key'=>'Manual', 'icon'=>'tools', 'url'=>'#'];
		$this->menu_nav[] = ['label'=>'หลักสูตรที่เปิดอบรม', 'key'=>'Training course', 'icon'=>'book', 'url'=>URL.'course'];

		$sub = [];
		$sub[] = ['label'=>'กลุ่มอุตสาหกรรม', 'url'=>'https://bit.ly/3k2Tczp', 'attr'=>'target="_blank"'];
		$sub[] = ['label'=>'กลุ่มทั่วไป', 'url'=>'https://bit.ly/2H55gBX', 'attr'=>'target="_blank"'];
		$sub[] = ['label'=>'กลุ่มการศึกษา', 'url'=>'https://bit.ly/3lQxlM4', 'attr'=>'target="_blank"'];
		$this->menu_nav[] = ['label'=>'แบบสำรวจ', 'key'=>'Survey', 'icon'=>'poll', 'url'=>'#', 'sub'=>$sub];
		$this->menu_nav[] = ['label'=>'จัดการข้อมูลระบบ', 'key'=>'Administrator', 'icon'=>'users-cog', 'url'=>URL.'manage'];
	}
	if( $this->me['auth'] == "member" ){
		$this->menu_nav[] = ['label'=>'หน้าแรก', 'key'=>'Home', 'icon'=>'home', 'url'=>URL];
		$this->menu_nav[] = ['label'=>'หลักสูตรที่เปิดอบรม', 'key'=>'Training course', 'icon'=>'book', 'url'=>URL.'course'];
		$this->menu_nav[] = ['label'=>'ประวัติการอบรม', 'key'=>'Training history', 'icon'=>'history', 'url'=>URL.'history'];

		$sub = [];
		$sub[] = ['label'=>'ข้อมูลส่วนตัว', 'url'=>URL.'profile'];
		$sub[] = ['label'=>'รหัสผ่าน', 'url'=>URL.'profile/password'];
		// $sub[] = ['label'=>'คำยื่นร้องขอ', 'url'=>'#'];
		$this->menu_nav[] = ['label'=>'จัดการข้อมูล', 'key'=>'Profile', 'icon'=>'users-cog', 'url'=>'#', 'sub'=>$sub];
	}
	$this->menu_nav[] = ['label'=>'ออกจากระบบ', 'key'=>'Logout', 'icon'=>'sign-out-alt', 'url'=>URL.'logout', 'attr'=>'data-plugins="dialog"'];
}

