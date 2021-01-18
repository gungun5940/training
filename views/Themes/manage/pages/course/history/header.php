<div ref="header" class="mll clearfix">

	<div ref="actions" class="listpage2-actions">
		<div class="clearfix mbs mtm">

			<ul class="lfloat" ref="actions">
				<li class="mt">
					<h2><i class="icon-list mrs"></i><span>รายการอบรม</span></h2>
				</li>

				<!-- <li class="mt"><a class="btn js-refresh" data-plugins="tooltip" data-options="<?=$this->fn->stringify(array('text'=>'refresh'))?>"><i class="icon-refresh"></i></a></li> -->

				<li class="divider"></li>

				<li class="mt">
					<a class="btn btn-blue" data-plugins="dialog" href="<?=URL?>course/add_opencourse/<?=$this->item['id']?>">
						<i class="icon-plus mrs"></i><span>เพิ่มข้อมูล</span>
					</a>
				</li>
            </ul>

            <ul class="rfloat mrl" ref="actions">
            	<li class="mt">
					<a class="btn btn-red" href="<?=$this->pageURL?>course">
						<i class="icon-remove mrs"></i><span>กลับ</span>
					</a>
				</li>
            </ul>
            
        </div>
    </div>

</div>