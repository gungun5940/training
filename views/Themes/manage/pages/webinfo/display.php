<?php require_once "init.php"; ?>
<div id="mainContainer" class="Setting clearfix" data-plugins="main">
	<?php 
	if( $this->count_nav >= 1 ){
		require_once 'left.php';
	}
	?>
	<div class="setting-content" role="content">
		<div class="setting-main" role="main"><?php

			if( empty($this->item) ){
				require_once "sections/seq.php";
			}
			else{
				require_once "sections/display.php";
			}

		?></div>
	</div>
</div>