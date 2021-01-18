<div id="mainContainer" class="profile clearfix" data-plugins="main">

	<div data-plugins="ManageCategories" data-options="<?=$this->fn->stringify( array(
		'url' => URL.'webinfo/sort'
	) )?>">
		<div role="main" class="pal">

			<div style="max-width: 750px">

				<div class="mbm clearfix">
					<div class="lfloat">
						<h2><i class="icon-database mrs"></i>เกี่ยวกับศูนย์</h2>
						<!-- <span style="color:blue;" class="fwb mts">* Click on the name of the category and drag up or down as you like.</span> -->
					</div>
					<div class="rfloat">
						<a href="<?=URL?>webinfo/add" class="btn btn-blue" data-plugins="dialog"><i class="icon-plus"></i> Add</a>
					</div>
				</div>
				<!-- <div class="uiBoxYellow pam mbm">กดลากเพื่อจัดลำดับ ประเภทโปรแกรมทัวร์</div> -->

				<ul class="listsdata-table-lists">
					<li class="head">
						<div class="ID"><label class="label">ลำดับ</label></div>
						<div class="name"><label class="label">ชื่อหัวข้อ</label></div>
						<div class="role"><label class="label">สถานะ</label></div>
					</li>
				</ul>
				<ul class="listsdata-table-lists" rel="listsbox">
					<?php
					$seq = 0;
					foreach ($this->info['lists'] as $key => $value) {
						$seq++;

						?>
						<li class="list seq-item" data-id="<?=$value['id']?>">
							<div class="ID fwb"><span class="seq"><?=$seq?></span></div>
							<div class="name"><span class="fwb"><a class="fwb"><?=$value['name']?></span></a></div>
							<div class="role">
								<?= $value["status"]["name"] ?>
							</div>
						</li>
						<?php }?>

					</ul>
				</div>

			</div>


		<!-- <div role="footer">
			<div class="pal clearfix" style="max-width: 750px">
				<div class="rfloat"><a class="btn btn-blue">Save</a></div>
			</div>
		</div> -->

	</div>
</div>
