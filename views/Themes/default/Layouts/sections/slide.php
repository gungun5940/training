<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="margin-bottom : 20px">
	<ol style="list-style-type: square" class="carousel-indicators slide-btn">
		<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		<li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
		<li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
		<li data-target="#carousel-example-generic" data-slide-to="3" class=""></li>
	</ol>
	<div class="carousel-inner" role="listbox">
		<div class="item active">
			<center>
				<a href="#" target="_blank" title="">
					<img src="<?=VIEW?>Themes/<?=$this->getPage('theme')?>/assets/images/imgslider/01.png" style="height: 300px; padding-top: 60px;" class="img-responsive" alt="">
				</a>
			</center>
		</div>
		<div class="item ">
			<center>
				<a href="#" target="_blank" title="">
					<img src="<?=VIEW?>Themes/<?=$this->getPage('theme')?>/assets/images/imgslider/02.jpg" style="height: 300px; padding-top: 60px;" class="img-responsive" alt="">
				</a>
			</center>
		</div>
		<div class="item ">
			<center>
				<a href="#" target="_blank" title="">
					<img src="<?=VIEW?>Themes/<?=$this->getPage('theme')?>/assets/images/imgslider/03.jpg" style="height: 300px; padding-top: 60px;" class="img-responsive" alt="">
				</a>
			</center>
		</div>
		<div class="item ">
			<center>
				<a href="#" title="">
					<img src="<?=VIEW?>Themes/<?=$this->getPage('theme')?>/assets/images/imgslider/04.jpg" style="height: 300px; padding-top: 60px;" class="img-responsive" alt="">
				</a>
			</center>
		</div>
	</div>

	<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		<span class="fa fa-chevron-circle-left icon-sidebar-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
		<span class="fa fa-chevron-circle-right icon-sidebar-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>