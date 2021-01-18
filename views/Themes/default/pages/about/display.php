<style type="text/css">
	.flex-row {
  -webkit-box-orient: horizontal !important;
  -webkit-box-direction: normal !important;
  -ms-flex-direction: row !important;
  flex-direction: row !important;
}

.flex-column {
  -webkit-box-orient: vertical !important;
  -webkit-box-direction: normal !important;
  -ms-flex-direction: column !important;
  flex-direction: column !important;
}
</style>

<section class="container main-container">
    <div role="content" style="padding-top: 20px">
        <div class="col-md-12">
	        <div class="row">
	            <div class="col-md-3">
	                <div class="panel" style="display: block">
						<div class="panel-header-rmutl" style="background-color: #8b0000; color:#fff;">
							<i class="fa fa-navicon fa-fw linkss-icon-style" style="color:#fff;"></i>
							<span class="text-white">เกี่ยวกับศูนย์</span>
						</div>
						<div class="panel-body-rmutl">
							<?php include("menu.php"); ?>
						</div>
					</div>
	            </div>
	            <div class="col-md-9">
	                <div class="w-25 p-3"></div>
	                <h4 class="fwb tac pas fcr"><?=$this->data['name']?></h4>
	                <div class="clearfix post-content editor-content">
	                    <?=$this->data['detail']?>
	                </div>
	            </div>
	        </div>
        </div>
    </div>
</section>