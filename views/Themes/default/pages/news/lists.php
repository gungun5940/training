<section class="container main-container">
	<div class="row" style="margin-top: 15px; margin-bottom: 15px;">
		<div class="col-lg-9 col-md-9 col-ms-9">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<h1 class="page-header-category"><i class="icon-newspaper-o fa-fw"></i>&nbsp;หมวดหมู่ข่าว : <?=$this->item['name']?></h1>
				</div>
			</div>
			<?php
			if( !empty($this->results['lists']) ){
				?>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<?php
						foreach ($this->results['lists'] as $key => $value) {
							?>
							<section class="row">
								<div class="col-lg-4 col-md-4 col-sm-4">
									<a href="<?=URL.'blog/'.$value['primarylink']?>" title="<?=$value['title']?>">
										<img class="img-thumbnail img-responsive" src="<?=$value['image_url']?>" alt="รูปภาพ : <?=$value['title']?>">
									</a>                
								</div>
								<div class="col-lg-8 col-md-8 col-sm-8">
									<a class="blog-title-link" href="<?=URL.'blog/'.$value['primarylink']?>" title="<?=$value['title']?>">
										<?=$value['title']?>                      
									</a>
									<br>
									<span><?= $this->fn->q('time')->dateTH( $value['created'] ) ?></span>
									<br>
									<hr style="margin-top:10px;margin-bottom:10px;">
									<p class="blog-content"><?=$value['desc']?> 
									<div class="list-activity-all" style="margin-top:80px;">
										<a href="<?=URL.'blog/'.$value['primarylink']?>" class="pull-right btn btn-danger btn-sm">ดูเพิ่มเติม</a>
									</div>
								</p>
							</div>
						</section>
						<hr>
						<?php
					}
					?>
					<div class="clearfix">
						<?php 
						echo $this->fn->Paginate($this->results['options'], ['shownum' => true, 'short' => false, 'warp' => false]);
						?>
					</div>
				</div>
			</div>
		<?php }else{
			?>
			<div class="text-center" style="margin-top:50px;">
			<i class="fas fa-exclamation-circle fa-7x" style="color:red;"></i>
			<br>
			<h3 class="fcr">ไม่พบข้อมูล</h3>
			</div>
			<?php
		}
		?>
	</div>
	<div class="col-lg-3 col-md-3 col-ms-3">
		<?php require_once "sections/menu.php"; ?>
	</div>
</div>
</section>