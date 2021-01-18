<div class="panel" style="display: block">
	<div class="panel-header-rmutl" style="background-color: #8b0000; color:#fff;">
		<i class="fa fa-navicon fa-fw linkss-icon-style" style="color:#fff;"></i>
		<span class="text-white">ข่าวล่าสุด</span>
		<a href="#" title="ข่าวล่าสุด">
			<i class="fa fa-angle-double-right fa-fw pull-right arrow-side-tab"></i>
		</a>
	</div>
	<div class="panel-body-rmutl">
		<ul class="last_post_link nav nav-stacked">
			<?php
			foreach ($this->newsMenu['lists'] as $key => $value) {
				?>
				<li class="dim-li">
					<a href="<?=URL?>blog/<?=$value['primarylink']?>" title="<?=$value['title']?>">
						<i class="fa fa-arrow-circle-right fa-fw" style="color: #8b0000;"></i>&nbsp;
						<?php
						if( mb_strlen($value['title']) > 55 ){
							echo mb_substr($value['title'], 0, 55).'...';
						}
						else{
							echo $value['title'];
						}
						?>
					</a>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
</div>
<hr>
<div class="panel" style="display: block">
	<div class="panel-header-rmutl" style="background-color: #8b0000; color:#fff;">
		<i class="icon-newspaper-o fa-fw linkss-icon-style" style="color:#fff;"></i>
		<span class="text-white">หมวดหมู่ข่าว</span>
		<a href="#" title="หมวดหมู่ข่าว">
			<i class="fa fa-angle-double-right fa-fw pull-right arrow-side-tab"></i>
		</a>
	</div>
	<div class="panel-body-rmutl">
		<ul class="link-rmutl nav nav-pills nav-stacked">
			<?php
			foreach ($this->newsType as $key => $value) {
				$cls = $key%2 ? '' : "dim-li";
				?>
				<li class="<?=$cls?>">
					<a href="<?=URL?>type/<?=$value['primarylink']?>" title="<?=$value['name']?>">
						<i class="fa fa-dot-circle-o fa-fw"></i>&nbsp;<?=$value['name']?>                        
					</a>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
</div>