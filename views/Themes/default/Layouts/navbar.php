<style type="text/css" media="screen">
	.img-banner {
		position: relative;
		text-align: right;
		color: white;
	}
	.img-banner > .img-banner-text {
		width : 100%;
		max-height: 600px;
		position: absolute;
		top: 50%;
		left: 45%;
		transform: translate(-50%, -50%);
	}
	.img-banner-text > div.text-th{
		font-size: 2.5vw;
	}
	.img-banner-text > div.text-en{
		font-size: 1.75vw;
	}
	span.manu-name.active {
		color:#d6463f;
	}
</style>
<section class="container">
	<div class="row img-banner">
		<img src="<?=VIEW?>Themes/<?=$this->getPage('theme')?>/assets/images/logo.png" alt="โลโก้เว็บไซต์ ศูนย์ถ่ายทอดวิศวกรรมและเทคโนโลยี" class="img-responsive" />
		
	</div>
	<div class="row">
		<nav class="navbar main-menu">
			<ul class="nav navbar-nav main-menu-ul">
				<?php
				include("menu-nav.php");
				foreach ($this->menu_nav as $key => $value) {
					$cls = "";
					$attr = "";
					$dropdown = '';
					$icondropdown = '';
					if( !empty($value["sub"]) ){
						$cls = "dropdown";
						$attr = 'class="dropdown-toggle" data-toggle="dropdown"';
						$icondropdown = '<span aria-hidden="true" data-icon=""><i class="fas fa-chevron-circle-down"></i></span>';
						foreach ($value["sub"] as $sub) {
							$icon = '';
							if( !empty($sub['icon']) ) $icon = '<i class="fas fa-'.$sub['icon'].'"></i>';

							$subAttr = '';
							if( !empty($sub['attr']) ) $subAttr = $sub['attr'];

							$dropdown .= '<li>
                                    		<a href="'.$sub['url'].'" '.$subAttr.'>'.$icon.' '.$sub['label'].'</a>
                                    	</li>';
						}

						$dropdown = '<ul class="dropdown-menu dropdown-menu-modify">
										'.$dropdown.'
									</ul>';
					}

					$active = '';
					if( $this->getPage('on') == $value['key'] ) $active = 'active';
					echo '<li class="'.$cls.'">
                        	<a href="'.$value['url'].'" '.( !empty($value['attr']) ? $value['attr'] : "" ).' '.$attr.'>
                            	<span class="manu-name '.$active.'"><i class="fas fa-'.$value['icon'].' mr10"></i>'.$value['label'].''.$icondropdown.'</span><br>
                            	<span class="manu-subline">'.$value['key'].'</span>
                        	</a>
                        	'.$dropdown.'
                    	</li>';
				}
				?>
			</ul>
		</nav>
	</div>
</section>