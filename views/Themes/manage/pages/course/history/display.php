<div id="mainContainer" class="clearfix" data-plugins="main">
	<div role="content">
		<div role="main">
			<?php include_once("header.php"); ?>
			
			<div class="clearfix pll prl">
				<div class="uiBoxWhite pam">
					<ul>
						<li><h2 class="fwb mbs">ข้อมูลหลักสูตร</h2></li>
						<li><span class="fwb">ชื่อหลักสูตร (ภาษาไทย) : </span><?=$this->item['name_th']?></li>
						<li><span class="fwb">ชื่อหลักสูตร (ภาษาอังกฤษ) : </span><?=$this->item['name_en']?></li>
					</ul>
					
					<div class="clearfix mtm">
						<select class="inputtext" name="open_id" data-plugins="select2">
							<option value="">- เลือกระยะเวลาหลักสูตร -</option>
							<?php
							foreach($this->open AS $key => $value){
								$sel = '';
								if( !empty($_GET['open']) ){
									if( $_GET['open'] == $value['id'] ) $sel = 'selected';
								}
								echo '<option value="'.$value['id'].'" '.$sel.'>'.$this->fn->q('time')->str_event_date($value['startdate'], $value['enddate'], true).' | ('.$value['status_name'].')</option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class="uiBoxWhite pam mtm">
					<?php if( !empty($this->currOpen) ){ ?>
						<div class="clearfix">
							<ul class="lfloat">
								<li class="mt"><span class="fwb">ระยะเวลา : </span><?=$this->fn->q('time')->str_event_date($this->currOpen['startdate'], $this->currOpen['enddate'], true)?></li>
								<li class="mt"><span class="fwb">สถานที่ : </span><?= !empty($this->currOpen['place']) ? $this->currOpen['place'] : "-" ?></li>
								<li class="mt"><span class="fwb">ค่าใช้จ่าย : </span><?= $this->currOpen['price'] == 0.00 ? "ไม่เสียค่าใช้จ่าย (ฟรี)" : number_format($this->currOpen['price']).' บาท'?></li>
								<li class="mt">
									<?php
									if( $this->currOpen['status'] == 0 ) $clr = 'red';
									if( $this->currOpen['status'] == 1 ) $clr = 'green';
									if( $this->currOpen['status'] == 2 ) $clr = 'blue';
									?>
									<span class="fwb">สถานะหลักสูตร : </span><a class="btn btn-<?=$clr?>"><?=$this->currOpen['status_name']?></a>
								</li>
							</ul>
							<div class="rfloat">
								<?php
								if( $this->currOpen['status'] != 2 ){
									?>
									<a class="btn btn-orange" href="<?=URL?>course/edit_opencourse/<?=$this->currOpen['id']?>" data-plugins="dialog"><i class="icon-pencil"></i> แก้ไข</a>
									<?php
									if( $this->currOpen['status'] == 1 ){
										echo '<a class="btn btn-red" href="'.URL.'course/setOpenStatus/'.$this->currOpen['id'].'" data-plugins="dialog"><i class="icon-remove"></i> ปิดหลักสูตร</a>';
									}
									else{
										echo '<a class="btn btn-green" href="'.URL.'course/setOpenStatus/'.$this->currOpen['id'].'" data-plugins="dialog"><i class="icon-check"></i> เปิดหลักสูตร</a>';
									}
									echo '<a class="btn btn-blue" href="'.URL.'course/setEndOpen/'.$this->currOpen['id'].'" data-plugins="dialog"><i class="icon-file-text"></i> จบหลักสูตร</a>';
								}
								?>
							</div>
						</div>
						<?php
					}

					if( !empty($this->listsReg) ){
						?>
						<table class="table-bordered mts" width="100%">
							<thead>
								<tr style="background-color:#8b0000 !important; color:#fff;">
									<th width="5%" class="pas pam">#</th>
									<th width="50%" class="pas">ชื่อ-นามสกุล</th>
									<th width="15%" class="pas">วันที่สมัคร</th>
									<th width="5%" class="pas">หลักฐาน</th>
									<th width="10%" class="pas">สถานะการชำระเงิน</th>
									<th width="10%" class="pas">สถานะ</th>
									<th width="5%" class="pas">ลบ</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no=1;
								foreach ($this->listsReg as $key => $value) {
									?>
									<tr>
										<td class="tac pas pam"><?=$no?></td>
										<td class="pas pam"><?=$value['mem_fullname']?></td>
										<td class="tac pas pam"><?=$this->fn->q('time')->dateTH( $value['date'] )?></td>
										<td class="tac pas pam">
											<?php
											if( !empty($value['slip']) ){
												$cls = "btn-blue";
												if( $value['pay_status'] == 1 ) $cls = "btn-green";
												if( $value['pay_status'] == 3 ) $cls = "btn-red";
												?>
												<span class="gbtn">
													<a href="<?=URL?>course/payments/<?=$value['mem_id']?>/<?=$value['open_id']?>" data-plugins="dialog" class="btn btn-no-padding <?=$cls?>"><i class="icon-file-text"></i></a>
												</span>
												<?php
											}
											else{
												echo '-';
											}
											?>
										</td>
										<td class="tac pas pam"><?=$value['status_pay_name']?></td>
										<td class="tac pas pam"><?=$value['status_name']?></td>
										<td class="tac pas pam">
											<!-- <span class="gbtn">
												<a class="btn btn-orange btn-no-padding" data-plugins="dialog" href="#"><i class="icon-pencil"></i></a>
											</span> -->
											<?php 
											if( ($value['pay_status'] == 1 || $value['pay_status'] == 2) && $value['status'] == 1 ){
												?>
												<span class="gbtn">
													<a class="btn btn-red btn-no-padding disabled"><i class="icon-lock"></i></a>
												</span>
												<?php
											}
											else{
												?>
												<span class="gbtn">
													<a class="btn btn-red btn-no-padding" data-plugins="dialog" href="<?=URL?>course/del_register/<?=$value['mem_id']?>/<?=$value['open_id']?>"><i class="icon-remove"></i></a>
												</span>
												<?php
											}
											?>
										</td>
									</tr>
									<?php
									$no++;
								}
								?>
							</tbody>
						</table>
						<?php
					}
					else{
						?>
						<h1 class="tac fcr">ไม่พบข้อมูล</h1>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("[name=open_id]").change(function(event) {
		var url = window.location.href.split('?')[0];
		window.location = url + '?open=' + $(this).val();
	});
</script>