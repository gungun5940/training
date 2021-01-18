<?php

$url = URL."staff/";

?><div data-load="<?=$this->pageURL?>settings/accounts/staff" class="SettingCol offline">

<div class="SettingCol-header"><div class="SettingCol-contentInner">
	<div class="clearfix">
		<ul class="clearfix lfloat SettingCol-headerActions">

			<li><h2><i class="icon-users mrs"></i><span>ผู้ใช้งานระบบ</span></h2></li>
			<li><a class="btn js-refresh"><i class="icon-refresh"></i></a></li>
			<li class="divider"></li>

			<li><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add"><i class="icon-plus mrs"></i><span>เพิ่ม</span></a></li>

		</ul>
		<ul class="rfloat SettingCol-headerActions clearfix">
			<li id="more-link"></li>
		</ul>


	</div>

	<div class="mtm clearfix">
		<ul class="lfloat SettingCol-headerActions clearfix">
			<li>
				<label for="level">สิทธิ์</label>
				<select ref="selector" name="level" class="inputtext">
					<option value="">- ทั้งหมด -</option>
					<?php
					foreach ($this->level as $key => $value) {
						echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
					}
					?>
				</select>
			</li>

			<li>
				<label for="status">สถานะ</label>
				<select ref="selector" name="status" class="inputtext">
					<option value="">- ทั้งหมด -</option>
					<?php
					foreach ($this->status as $key => $value) {
						echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
					}
					?>
				</select>
			</li>

		</ul>
		<ul class="rfloat SettingCol-headerActions clearfix">
			<li>
				<label for="search-query">ค้นหา</label>
				<form class="form-search" action="#">
				<input class="search-input inputtext" type="text" id="search-query" placeholder="" name="q" autocomplete="off">
				<span class="search-icon">
			 		 <button type="submit" class="icon-search nav-search" tabindex="-1"></button>
				</span>

			</form></li>

		</ul>
	</div>
	<!-- <div class="setting-description mtm uiBoxYellow pam">Manage your personal employee settings.</div> -->
</div></div>

<div class="SettingCol-main">
	<div class="SettingCol-tableHeader"><div class="SettingCol-contentInner">
		<table class="settings-table admin"><thead><tr>
			<th class="number" data-col="0">เลขที่ตำแหน่ง</th>
			<th class="name" data-col="1">ชื่อ-นามสกุล</th>
			<th class="status_th" data-col="2">สิทธิ์</th>
			<th class="status_th" data-col="3">สถานะ</th>
			<th class="actions" data-col="4">จัดการ</th>
		</tr></thead></table>
	</div></div>
	<div class="SettingCol-contentInner">
	<div class="SettingCol-tableBody"></div>
	<div class="SettingCol-tableEmpty empty">
		<div class="empty-loader">
			<div class="empty-loader-icon loader-spin-wrap"><div class="loader-spin"></div></div>
			<div class="empty-loader-text">กำลังเรียกข้อมูล...</div>
		</div>
		<div class="empty-error">
			<div class="empty-icon"><i class="icon-link"></i></div>
			<div class="empty-title">การเชื่อมต่อกับฐานข้อมูลขัดข้อง</div>
		</div>

		<div class="empty-text">
			<div class="empty-icon"><i class="icon-users"></i></div>
			<div class="empty-title">ไม่พบข้อมูล</div>
		</div>
	</div>
	</div>
</div>

</div>
