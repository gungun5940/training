<div class="tab-content-panel-post tab-content">
	<div role="tabpanel" class="tab-panel">
		<?php
		if( !empty($this->results['lists']) ){
			?>
			<div class="row">
				<div class="col-md-12">
					<?php
					foreach ($this->results['lists'] as $key => $value) {
						?>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="bg-block-post">
								<div class="row">
									<div class="col-lg-12 col-md-12" style="padding-right: 5px;padding-left: 5px;">
										<div class="col-lg-4 col-md-4 col-sm-4 bg-block-post-img">
											<a href="<?=URL."blog/".$value['primarylink']?>">
												<img class="img-responsive thumbnail bg-post-img" src="<?=$value['image_url']?>">
											</a>
										</div>
										<a href="<?=URL."blog/".$value['primarylink']?>">
											<div class="col-lg-8 col-md-8 bg-block-post-detail" style="padding-right: 5px;padding-left: 5px;">
												<h3><?php
												if( mb_strlen($value['title']) > 55 ){
													echo mb_substr($value['title'], 0, 55).'...';
												}
												else{
													echo $value['title'];
												}
												?></h3>
												<span><?=$this->fn->q('time')->dateTH($value['created'])?></span>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<div class="col-md-12">
					<a href="<?=URL?>type/<?=$this->type['primarylink']?>" class="see-all-post btn btn-danger btn-sm">ดูเพิ่มเติม</a>
				</div>
			</div>
			<?php 
		}
		else{
			echo '<h4 class="fcr tac">ไม่พบข้อมูล</h4>';
		}
		?>
	</div>
</div>