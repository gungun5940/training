<section class="container main-container">
	<div class="row mas">
		<div class="col-md-9">
			<h3 class="fwb"><?=$this->item['title']?></h3>
			<h5><?=$this->fn->q('time')->dateTH( $this->item['created'] )?></h5>
			<div class="pal tac">
				<img src="<?=$this->item['image_url']?>" style="width:80%; height: auto;">
			</div>
			<div class="pbl prl pll" style="font-size: 16px;">
				<div class="post-content editor-content">
					<?=$this->item['detail']?>
				</div>
			</div>
		</div>
		<div class="col-md-3 mtl">
			<?php require_once "sections/menu.php"; ?>
		</div>
	</div>
</section>