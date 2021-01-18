<?php 
class login extends Controller{
	
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		if (empty($this->me)) {
			header("location:".URL);
		}
		else{
			if ($this->me['auth'] == "staff"){
				header("location:".URL);
			}
			elseif ($this->me['auth'] == "member") {
				header("location:".URL.'course');
			}
		}
		
	}
}