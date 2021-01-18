var __Elem = {
	anchorBucketed: function (data) {
		
		var anchor = $('<div>', {class: 'anchor ui-bucketed clearfix'});
		var avatar = $('<div>', {class: 'avatar lfloat no-avatar mrm'});
		var content = $('<div>', {class: 'content'});
		var icon = '';

		if( !data.image_url || data.image_url=='' ){

			icon = 'user';
			if( data.icon ){
				icon = data.icon;
			}
			icon = '<div class="initials"><i class="icon-'+icon+'"></i></div>';
		}
		else{
			icon = $('<img>', {
				class: 'img',
				src: data.image_url,
				alt: data.text
			});
		}

		avatar.append( icon );

		var massages = $('<div>', {class: 'massages'});

		if( data.text ){
			massages.append( $('<div>', {class: 'text fwb u-ellipsis'}).html( data.text ) );
		}

		if( data.category ){
			massages.append( $('<div>', {class: 'category'}).html( data.category ) );
		}
		
		if( data.subtext ){
			massages.append( $('<div>', {class: 'subtext'}).html( data.subtext ) );
		}

		content.append(
			  $('<div>', {class: 'spacer'})
			, massages
		);
		anchor.append( avatar, content );

        return anchor;
	},
	anchorFile: function ( data ) {
		
		if( data.type=='jpg' ){
			icon = '<div class="initials"><i class="icon-file-image-o"></i></div>';
		}
		else{
			icon = '<div class="initials"><i class="icon-file-text-o"></i></div>';
		}
		
		var anchor = $('<div>', {class: 'anchor clearfix'});
		var avatar = $('<div>', {class: 'avatar lfloat no-avatar mrm'});
		var content = $('<div>', {class: 'content'});
		var meta =  $('<div>', {class: 'subname fsm fcg'});

		if( data.emp ){
			meta.append( 'Added by ',$('<span>', {class: 'mrs'}).text( data.emp.fullname ) );
		}

		if( data.created ){
			var theDate = new Date( data.created );
			meta.append( 'on ', $('<span>', {class: 'mrs'}).text( theDate.getDate() + '/' + (theDate.getMonth()+1) + '/' + theDate.getFullYear() ) );
		}

		avatar.append( icon );

		content.append(
			  $('<div>', {class: 'spacer'})
			, $('<div>', {class: 'massages'}).append(
				  $('<div>', {class: 'fullname u-ellipsis'}).text( data.name )
				, meta
			)
		);
		anchor.append( avatar, content );

        return anchor;
	} 
};

// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var SearchInput = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $( elem );
			self.data = $.extend( {}, $.fn.searchinput.options, options );

			self.url = self.data.url || Event.URL + "customers/search/";

			self.$elem
				.parent()
				.addClass('ui-search')
				.append( 
					  $('<div>', {class: 'loader loader-spin-wrap'}).html( $('<div>', {class: 'loader-spin'}) )
					, $('<div>', {class: 'overlay'}) 
			);


			self.is_focus = false;
			self.is_keycodes = [37,38,39,40,13];
			self.load = false;
			self.is_focus2 = false;

			// Event
			var v;
			self.$elem.keyup(function (e) {
				var $this = $(this);
				var value = $.trim( $this.val() );

				self.is_focus2 = true;

				if( self.is_keycodes.indexOf( e.which )==-1 && !self.has_load ){

					self.$elem.parent().addClass('has-load');
					self.hide();

					clearTimeout( v );

					if(value==''){
						self.$elem.parent().removeClass('has-load');
						return false;
					}

					v = setTimeout(function(argument) {
						self.load = true;
						self.data.options.q = $.trim($this.val());
						self.search();
					}, 500);

				}
			}).keydown(function (e) {
				var keyCode = e.which;

				if( keyCode==40 || keyCode==38 ){

					self.changeUpDown( keyCode==40 ? 'donw':'up' );
					e.preventDefault();
				}

				if( self.$menu ){
					if( keyCode==13 && self.$menu.find('li.selected').length==1 ){
						self.active(self.$menu.find('li.selected').data());
					}
				}
			}).click(function (e) {
				var value = $.trim($(this).val());

				if(value!=''){

					if( self.data.options.q==value ){
						self.setMenu();
					}
					else{

						self.$elem.parent().addClass('has-load');
						self.hide();
						clearTimeout( v );

						self.load = true;
						self.data.options.q = value;
						self.search();
					}
				}

				e.stopPropagation();
			}).blur(function () {
				
				if( !self.is_focus ){
					self.hide();
				}

				self.is_focus2 = false;

			}).focus(function () {
				self.is_focus2 = true;
			});
		},

		search: function () {
			var self = this;

			$.ajax({
				url: self.url,
				data: self.data.options,
				dataType: 'json'
			}).done(function( results ) {

				self.data = $.extend( {}, self.data, results );
				if( results.total==0 || results.error || self.is_focus2==false ){
					return false;
				}

				self.setMenu();

			}).fail(function() {

				self.has_load = false;
				self.$elem.parent().removeClass('has-load');
				
			}).always(function() {

				self.has_load = false;
				self.$elem.parent().removeClass('has-load');
			});
		},

		hide: function () {
			var self = this;

			if( self.$layer ){
				self.$layer.addClass('hidden_elem');
			}
		},

		changeUpDown: function ( active ) {
			var self = this;
			var length = self.$menu.find('li').length;
			var index = self.$menu.find('li.selected').index();

			if( active=='up' ) index--;
			else index++;

			if( index < 0) index=0;
			if( index >= length) index=length-1;

			self.$menu.find('li').eq( index ).addClass('selected').siblings().removeClass('selected');
		},

		setMenu: function () {
			var self = this;

			var $box = $('<div/>', {class: 'uiTypeaheadView selectbox-selectview'});
			self.$menu = $('<ul/>', {class: 'search has-loading', role: "listbox"});

			$box.html( $('<div/>', {class: 'bucketed'}).append( self.$menu ) );

			var settings = self.$elem.offset();
			settings.parent = self.data.parent;
			if( settings.parent ){

				var parentoffset = $(settings.parent).offset();
				settings.left-=parentoffset.left;
				settings.top+=$(settings.parent).parent().scrollTop();
			}

			settings.top += self.$elem.outerHeight();
			settings.$elem = self.$elem;

			uiLayer.get(settings, $box );
			self.$layer = self.$menu.parents('.uiLayer');
			self.$layer.addClass('hidden_elem');

			self.buildFrag( self.data.lists );
			self.display();
		},
		buildFrag: function ( results ) {
			var self = this;

			$.each(results, function (i, obj) {

				var item = $('<a>');
				var li = $('<li/>');


				if( obj.image_url ){

					item.append( $('<div/>', {class:'avatar'}).html( $('<img/>', {calss: 'img', src: obj.image_url}) ) );

					li.addClass('picThumb');
				}

				if( obj.text ){
					item.append( $('<span/>', {class: 'text', text: obj.text}) );
				}

				if( obj.subtext ){
					item.append( $('<span/>', {class: 'subtext', text: obj.subtext}) );
				}

				if( obj.category ){
					item.append( $('<span/>', {class: 'category', text: obj.category}) );
				}

				li.html( item );

				li.data(obj);
				self.$menu.append( li );
			});
		},
		display: function () {
			var self = this;

			if( self.$menu.find('li').length == 0 ){
				return false;
			}

			if( self.$menu.find('li.selected').length==0 ){
				self.$menu.find('li').first().addClass('selected');
			}

			self.$layer.removeClass('hidden_elem');

			self.$menu.delegate('li', 'mouseenter', function() {
				$(this).addClass('selected').siblings().removeClass('selected');
			});
			self.$menu.delegate('li', 'click', function(e) {
				$(this).addClass('selected').siblings().removeClass('selected');
				self.active($(this).data());
				// e.stopPropagation();
			});

			self.$menu.mouseenter(function() {
				self.is_focus = true;
		  	}).mouseleave(function() { 
		  		self.is_focus = false;
		  	});
		},

		active: function ( data ) {
			var self = this;

			if( typeof self.data.onSelected === 'function' ){
				self.data.onSelected( data, self );
			}

			self.hide();
		},
	}
	$.fn.searchinput = function( options ) {
		return this.each(function() {
			var $this = Object.create( SearchInput );
			$this.init( options, this );
			$.data( this, 'searchinput', $this );
		});
	};
	$.fn.searchinput.options = {
		options: { q: '', limit: 5, view_stype: 'bucketed' },
		onSelected: function () {},
		parent: ''
	};

	/**/
	/* RUpload */
	/**/
	var RUpload = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $(elem);
			self.$listsbox = self.$elem.find('[rel=listsbox]');
			self.$add = self.$elem.find('[rel=add]');
			self.data = $.extend( {}, $.fn.rupload.options, options );
			self.up_length = 0;

			self.refresh( 1 );
			self.Events();
		},

		Events: function () {
			var self = this;

			self.$elem.find('.js-upload').click(function (e) {
				e.preventDefault();

				self.change();
			});

			self.$elem.delegate('.js-remove', 'click', function (e) {

				self.loadRemove( $(this).closest('li').data() );
				e.preventDefault();
			});
			// has-loading
		},
		change: function () {
			var self = this;

			var $input = $('<input/>', { type: 'file', accept: "image/*"});
			if( self.data.multiple ){
				$input.attr('multiple', 1);
			}
			$input.trigger('click');

			$input.change(function(){

				self.$add.addClass('disabled').addClass('is-loader').prop('disabled', true);
				
				self.files = this.files;
				
				self.setFile();
			});
		},
		loadRemove: function (data) {
			var self = this;

			Dialog.load( self.data.remove_url, {id: data.id, callback: 1}, {
				onSubmit: function (el) {
					
					$form = el.$pop.find('form');
					Event.inlineSubmit( $form ).done(function( result ) {

						result.onDialog = true;
						result.url = '';
						Event.processForm($form, result);

						if( result.error ){
							return false;
						}
						
						self.$elem.find('[data-id='+ data.id +']').remove();
						self.sort();
						Dialog.close();

					});
				}
			} );
		},

		setFile: function () {
			var self = this;

			$.each( self.files, function (i, file) {
				self.up_length++;
				self.displayFile( file );

				self.sort();
			} );	
		},
		displayFile: function ( file ) {
			var self = this;

			var item = $('<li>', {class: 'has-upload' }).append( __Elem.anchorFile( file ) );
			item.append( self.setBTNRemove() );


			var progress = $('<div>', {class:'progress-bar medium mts'});
			var bar = $('<span>', {class:'blue'});

			progress.append( bar );

			item.find('.massages').append( progress );

			if( self.$listsbox.find('li').length==0 ){
				self.$listsbox.append( item );
			}
			else{
				self.$listsbox.find('li').first().before( item );
			}

			var formData = new FormData();
			formData.append( self.data.name, file);

			$.ajax({
			    type: 'POST',
			    dataType: 'json',
			    url: self.data.upload_url,
			    data: formData,
			    cache: false,
			    processData: false,
			    contentType: false,
			    error: function (xhr, ajaxOptions, thrownError) {

			        /*alert(xhr.responseText);
			        alert(thrownError);*/
			        Event.showMsg({text: 'อัพโหลดไฟล์ไม่ได้', auto: true, load: true, bg: 'red'});
			        item.remove();
			    },

			    xhr: function () {
			        var xhr = new window.XMLHttpRequest();
			        //Download progress
			        xhr.addEventListener("progress", function (evt) {
			            if (evt.lengthComputable) {
			                var percentComplete = evt.loaded / evt.total;
			                bar.css('width', Math.round(percentComplete * 100));
			                // progressElem.html(  + "%");
			            }
			        }, false);
			        return xhr;
			    },
			    beforeSend: function () {
			        // $('#loading').show();
			    },
			    complete: function () {

			    	self.up_length--;
			    	if( self.up_length==0 ){
			    		self.$add.removeClass('disabled').removeClass('is-loader').prop('disabled', false);
			    	}
			        // $("#loading").hide();
			    },
			    success: function (json) {

			    	if( json.error ){

			    		return false;
			    	}

			    	item.attr('data-id', json.id);
			    	item.data( json )
			    	progress.remove();
			    }
			});
		},

		refresh: function ( length ) {
			var self = this;

			if( self.is_loading ) clearTimeout( self.is_loading ); 

			if ( self.$elem.hasClass('has-error') ){
				self.$elem.removeClass('has-error')
			}

			if ( self.$elem.hasClass('has-empty') ){
				self.$elem.removeClass('has-empty')
			}

			self.$elem.addClass('has-loading');

			self.is_loading = setTimeout(function () {

				self.fetch().done(function( results ) {

					self.data = $.extend( {}, self.data, results );

					if( results.error ){

						if( results.message ){
							self.$elem.find('.js-message').text( results.message );
							self.$elem.addClass('has-error');
						}
						return false;
					}

					self.$elem.toggleClass( 'has-empty', parseInt(self.data.total)==0 );

					$.each( results.lists, function (i, obj) {
						self.display( obj );
					} );
				});
			}, length || 1);
			
		},
		fetch: function () {
			var self = this;

			return $.ajax({
				url: self.data.url,
				data: self.data.options,
				dataType: 'json'
			}).always(function () {

				self.$elem.removeClass('has-loading');
				
			}).fail(function() { 
				self.$elem.addClass('has-error');
			});
		},

		display: function ( data ) {
			var self = this;

			var item = $('<li>', {'data-id': data.id}).append( __Elem.anchorFile( data ) );
			item.append( self.setBTNRemove() );
			item.data( data );

			if( self.$listsbox.find('li').length==0 ){
				self.$listsbox.append( item );
			}
			else{
				self.$listsbox.find('li').first().before( item );
			}
		},
		setBTNRemove: function () {
			
			return $('<button>', {type: 'button', class: 'js-remove icon-remove btn-remove'});
		},
		sort: function () {
			var self = this;

			self.$elem.toggleClass('has-empty', self.$listsbox.find('li').length==0 );
		}
	}
	$.fn.rupload = function( options ) {
		return this.each(function() {
			var $this = Object.create( RUpload );
			$this.init( options, this );
			$.data( this, 'rupload', $this );
		});
	};
	$.fn.rupload.options = {
		options: {},
		multiple: false,
		name: 'file1'
	}

	var imageCover = {
		init: function(options, elem) {
			var self = this;
			self.elem = elem;

			self.options = $.extend( {}, $.fn.imageCover.options, options );

			self.initElem();
			self.initEvent();
		},
		initElem: function () {
			var self = this;
			self.$elem = $( self.elem );

			var width = self.$elem.width();
			var height = ( self.options.scaledY * width ) / self.options.scaledX;
			self.$elem.css({
				width: width,
				height: height
			});

			if( self.options.url ){
				self.updateImage();
			}
		},
		initEvent: function () {
			var self = this;
			self.$elem.find('[type=file]').change(function () {
				self.setImage(this.files[0]);
			});
		},

		setImage: function (file) {
			var self = this;

			self.$elem.addClass('has-loading');
			var $progress = self.$elem.find('.progress-bar');
			var $remove = $('<a/>', {class:"preview-remove"}).html( $('<i/>', {class:'icon-remove'}) );

			$remove.click(function (e) {
				e.preventDefault();
				self.clear();
			});

			var $img = $('<div/>',{ class:'image-crop'});
			self.$elem.find('.preview').append( $remove, $img );

			var width = self.$elem.width();

			var reader = new FileReader();
			reader.onload = function (e) {
				var image = new Image();
				image.src = e.target.result;
				$image = $(image).addClass('img img-crop');

				image.onload = function() {
					
					var scaledW = this.width;
					var scaledH = this.height;
					var height = ( scaledH * width ) / scaledW;
					$image.width( width );
					$image.height( height );

					var scaledW = self.options.scaledX;
					var scaledH = self.options.scaledY;
					var height = ( scaledH * width ) / scaledW;
					
					$img.css({ width: width, height: height });
					
					self.$elem.removeClass('has-loading').addClass('has-file');
					$img.html( $image );

					self.cropperImage( self.$elem.find('.preview') );
				}
			}

			reader.onprogress = function(data) {
				if (data.lengthComputable) {                                            
	                var progress = parseInt( ((data.loaded / data.total) * 100), 10 );
	                $progress.find('.bar').width( progress+"%" );
	            }
        	}

			reader.readAsDataURL( file );
		},
		clear:function () {
			var self = this;

			self.$elem.find('[type=file]').val('');
			self.$elem.find('.preview').empty();
			self.$elem.removeClass('has-file');
		},

		cropperImage: function ( $el ) {
			var self = this;

			var $x = $('<input/>', {type: 'hidden', name:'cropimage[x]', value: 0});
			var $y = $('<input/>', {type: 'hidden', name:'cropimage[y]', value: 0});
			var $width = $('<input/>', {type: 'hidden', name:'cropimage[width]', value: 0 });
			var $height = $('<input/>', {type: 'hidden', name:'cropimage[height]', value: 0 });
			var $rotate = $('<input/>', {type: 'hidden', name:'cropimage[rotate]', value: 0 });
			var $scaleX = $('<input/>', {type: 'hidden', name:'cropimage[scaleX]', value: 0 });
			var $scaleY = $('<input/>', {type: 'hidden', name:'cropimage[scaleY]', value: 0 });
			
			$el.find('.image-crop').append($x, $y,$width, $height, $rotate, $scaleX, $scaleY);

			Event.setPlugin( $el.find('img.img-crop'), 'cropper', {
				aspectRatio: self.options.scaledX / self.options.scaledY,
				autoCropArea: .95,
				strict: true,
				guides: true,
				highlight: false,
				dragCrop: false,
				cropBoxMovable: true,
				cropBoxResizable: false,
				crop: function(e) {

					if( $el.find('.image-wrap').length ){

					 	$el.find('.image-wrap').addClass('hidden_elem');
					}

					if( $el.find('.image-crop').hasClass('hidden_elem') ){
					 	$el.find('.image-crop').removeClass('hidden_elem');
					}

				    // Output the result data for cropping image.
				    $x.val(e.x);
				    $y.val(e.y);
				    $width.val(e.width);
				    $height.val(e.height);
				    $rotate.val(e.rotate);
				    $scaleX.val(e.scaleX);
				    $scaleY.val(e.scaleY);

				}
			} );
		},

		updateImage: function() {
			
			var self = this;
			var $remove = $('<a/>', {class:"preview-remove"}).html( $('<i/>', {class:'icon-remove'}) );
			var $img = $('<div/>', { class:'image-crop hidden_elem'});
			var $wrap = $('<div/>',{ class:'image-wrap'});
			var $edit = $('<div/>',{ class:'image-cover-edit', text: 'ปรับตำแหน่ง'});
			self.$elem.addClass('has-file').find('.preview').append( $remove, $edit, $img, $wrap );

			$edit.click(function (e) {

				if( self.$elem.hasClass('has-cropimage') ){
					$edit.text('ปรับตำแหน่ง');
					self.$elem.removeClass('has-cropimage');
					$wrap.removeClass('hidden_elem');
					$img.addClass('hidden_elem').empty();
				}
				else{
					$edit.text('ยกเลิก');
					self.$elem.addClass('has-cropimage');
					setcrop();
					self.cropperImage( self.$elem.find('.preview') );
				}	
			});

			$remove.click(function (e) {
				e.preventDefault();

				Dialog.load( self.options.action_url, {}, {

					onSubmit: function ( data ) {
						$form = data.$pop.find('form.model-content');
						Event.inlineSubmit( $form ).done(function( result ) {
							Event.processForm($form, result);

							if( result.status==1 ){
								self.clear();
							}
						});
					},
					onClose: function () {}
				});
			});

			var scaledW = self.options.scaledX;
			var scaledH = self.options.scaledY;

			var width = self.$elem.width();
			var height = ( scaledH * width ) / scaledW;

			function setcrop() {
				$img.css({
					width: width,
					height: height
				}).append( 
					$('<img>', {class: 'img img-crop',src: self.options.original_url })
				);
			}

			$wrap.css({
				width: width,
				height: height
			}).html( $('<img>', {class: 'img', src: self.options.url }) );
		},

	};

	$.fn.imageCover = function( options ) {
		return this.each(function() {
			var $this = Object.create( imageCover );
			$this.init( options, this );
			$.data( this, 'imageCover', $this );
		});
	};
	$.fn.imageCover.options = {
		scaledX: 640,
		scaledY: 360
	};

	var form_evaluations = {
		init: function(options, elem){
			var self = this;

			self.$elem = $(elem);
			self.options = $.extend( {}, $.fn.form_evaluations.settings, options );

			self.$listsItem = self.$elem.find('[role=listsItem]');

			self.setElem();
			self.Events();
		},
		setElem: function(){
			var self = this;

			if( self.options.category.length==0 ){
				self.getItem();
			}
			else{
				$.each( self.options.category, function(i, obj) {
					self.getItem( obj );
				});
			}
		},
		Events: function(){
			var self = this;

			/* BOX TYPE */
			self.$elem.find('.js-add').click(function(){
				var setItem = self.setItem({});
				self.$listsItem.append( setItem );

				setItem.find(':input').first().focus();
				self.sortItem();
			});
			self.$elem.delegate('.js-del', 'click', function () {
				var box = $(this).closest('.rows');

				var no = 0;
				$.each( self.$listsItem.find('.rows'), function(i, obj){
					no++;
				});

				if( no == 1 ){
					box.find(':input').val('');
					box.find('textarea').val('');
					box.find(':input').first().focus();
				}
				else{
					box.remove();
				}
				self.sortItem();
			});

			/* BOX SUBJECT */
			self.$elem.delegate('.js-add-item', 'click', function(){
				var box = $(this).closest( 'tr' );
				
				if( box.find(':input').first().val()=='' ){
					box.find(':input').first().focus();
					return false;
				}

				var setTable = self.setTable({});
				box.after( setTable );
				setTable.find(':input').first().focus();

				self.sortItem();
			});
			self.$elem.delegate('.js-del-item', 'click', function(){
				var box = $(this).closest( 'tr' );
				var body = $(this).closest( 'tbody' );
				if( body.find('tr').length==1 ){
					box.find(':input').val('');
					box.find(':input').first().focus();
				}
				else{
					box.remove();
				}

				self.sortItem();
			});
		},
		getItem : function( data ){
			var self = this;

			self.$listsItem.append( self.setItem( data || {} ) );
			self.sortItem();
		},
		setItem : function( data ){
			var self = this;

			var $tbody = $('<tbody>');
			if( !data.subject ){
				$tbody.append( self.setTable( {} ) );
			}
			else{
				$.each( data.subject, function(i,obj){
					$tbody.append( self.setTable( obj ) );
				} );
			}

			$div = $('<div>', {class:"uiBoxWhite pam mts rows", style:"border-radius:2mm; border:2px solid #ccc;"});
			$div.append(
				$('<div>', {class:"clearfix"}).append(
					$('<h2>', {class:"fwb lfloat js-sec", text:" JS-Error ! "}),
					$('<span>', {class:"gbtn rfloat mls"}).append(
						$('<a>', {class:"btn btn-red btn-no-padding js-del"}).append(
							$('<i>', {class:"icon-trash"})
						)
					)
				),
				$('<div>', {class:"clearfix mts"}).append(
					$('<input>', {type:"text", class:"inputtext js-cate", value:data.name, placeholder:"ด้านการประเมิน"})
				),
				$('<div>', {class:"clearfix mts js-lists"}).append(
					$('<table>', {class:"table-bordered", width:"100%"}).append(
						$('<thead>', {style:"background-color: #02acec; color:#fff;"}).append(
							$('<th>', {class:"tac pas", width:"10%"}).text("ข้อ"),
							$('<th>', {class:"tac pas", width:"55%"}).text("หัวข้อ"),
							$('<th>', {class:"tac pas", width:"20%"}).text("คะแนนเต็ม"),
							$('<th>', {class:"tac pas", width:"15%"}).text("จัดการ"),
						),
						$tbody
					)
				)
			);

			return $div;
		},
		setTable : function( data ){
			var self = this;

			$tr = $('<tr>');
			$tr.append(
				$('<td>', {class:"tac pas js-num"}).text( "#" ),
				$('<td>', {class:"pas"}).append(
					$('<input>', {type:"text", value:data.name, class:"inputtext js-subject", placeholder:"หัวข้อการประเมิน", autocomplete:"off"})
				),
				$('<td>', {class:"pas"}).append(
					$('<input>', {type:"text", value:data.point || 5, class:"inputtext tac js-point", placeholder:"คะแนน (เต็ม)", autocomplete:"off"})
				),
				$('<td>', {class:"tac"}).append(
					$('<span>', {class:"gbtn"}).append(
						$('<a>', {class:"btn btn-blue btn-no-padding js-add-item"}).append(
							$('<i>', {class:"icon-plus"})
						)
					),
					$('<span>', {class:"gbtn"}).append(
						$('<a>', {class:"btn btn-orange btn-no-padding js-del-item"}).append(
							$('<i>', {class:"icon-remove"})
						)
					)
				)
			)

			Event.plugins( $tr );

			return $tr;
		},
		sortItem: function(){
			var self = this;
			var no = 0;
			$.each( self.$listsItem.find('.rows'), function(i, obj) {
				no++;
				$(this).find('.js-sec').text( "หมวดที่ " + no );
				$(this).find('.js-cate').attr("name",'cate['+no+']');
				$(this).find('.js-lists').attr("data-sec", no);
				$(this).find('.js-subject').attr("name", 'subject['+no+'][]');
				$(this).find('.js-point').attr("name", 'point['+no+'][]');

				var num = 0;
				$.each( $(this).find('tr'), function(i,obj) {
					num++;
					$(this).find('.js-num').text( num );
				});
			});
		}
	};
	$.fn.form_evaluations = function( options ) {
		return this.each(function() {
			var $this = Object.create( form_evaluations );
			$this.init( options, this );
			$.data( this, 'form_evaluations', $this );
		});
	};
	$.fn.form_evaluations.options = {
		items : {}
	};

	var formOpenCourse = {
		init: function(options, elem){
			var self = this;

			self.$elem = $(elem);
			self.options = $.extend( {}, $.fn.formOpenCourse.settings, options );

			self.$inputPrice = self.$elem.find('.js-price');
			self.$selectPriceStatus = self.$elem.find('.js-price-status');

			self.setElem();
			self.Events();
		},
		setElem: function(){
			var self = this;
			self.$inputPrice.closest('fieldset').hide();

			if( self.$selectPriceStatus.is(':checked') == true ){
				if( self.$elem.find('.js-price-status:checked').val() == 1 ){
					self.$inputPrice.closest('fieldset').show();
				}
			}
		},
		Events: function(){
			var self = this;

			self.$selectPriceStatus.click(function(){
				if( $(this).val() == 0 ) self.$inputPrice.closest('fieldset').hide();
				if( $(this).val() == 1 ) self.$inputPrice.closest('fieldset').show();
			});
		}
	};
	$.fn.formOpenCourse = function( options ) {
		return this.each(function() {
			var $this = Object.create( formOpenCourse );
			$this.init( options, this );
			$.data( this, 'formOpenCourse', $this );
		});
	};
	$.fn.formOpenCourse.options = {};

	var ManageCategories = {
		init: function ( options, elem ) {
			var self = this;
			self.elem = elem;
			self.$elem = $(self.elem);
			self.$listsbox = self.$elem.find('[rel=listsbox]');
			self.options = $.extend( {}, $.fn.ManageCategories.options, options );
			
			var ti;
			self.$listsbox.sortable({
				change: function (event, ui) {

					clearTimeout( ti );
					ti = setTimeout( function() {
						self.setSort();
					}, 800 );
					
				}
			}); 
		},
		setSort: function () {
			var self = this;
			
			var ids = [];

			var cSeq = 0;
			$.each( self.$listsbox.find('[data-id]'), function () {
				cSeq++;

				$(this).find('.seq').text( cSeq );

				ids.push( $(this).attr('data-id') );
			} );

			$.post( self.options.url, {
				callback: true,
				ids: ids
			}, function () {
				

			}, 'json');
		},
		setElem: function () {
			var self = this;
			self.$elem = $(self.elem);
			self.$elem.attr('id', 'mainContainer')
			self.$elem.find('[role]').each(function () {
				if( $(this).attr('role') ){
					var role = "$" + $(this).attr('role');
					self[role] = $(this);
				}
				
			});
		},
		resize: function () {
			var self = this;

			var outer = $( window );
			var offset = self.$elem.offset();
			var right = 0;
			var fullw = outer.width() - (offset.left+right);
			var fullh = (outer.height() + outer.scrollTop()) - $('#tobar').height();

			if( self.$right ){
				var rightWPercent = self.$right.attr('data-w-percent') || 30;
				var rightw = (fullw*rightWPercent) / 100;

				if( self.$right.attr('data-width') ){
					rightw = parseInt( self.$right.attr('data-width') );
				}

				self.$right.css({
					width: rightw,
					height: fullh,
					position: 'absolute',
					top: 0,
					right: 0
				});

				self.$content.css({
					marginRight: rightw
				});

				right += rightw;
			}

			if( self.$colRigth ){
				var rightWPercent = self.$colRigth.attr('data-w-percent') || 20;
				var rightw = (fullw*rightWPercent) / 100;

				if( self.$colRigth.attr('data-width') ){
					rightw = parseInt( self.$colRigth.attr('data-width') );
				}


				self.$main.css({
					marginRight: rightw,
				});

				self.$colRigth.css({
					position: 'absolute',
					top: 0,
					right: 0,
					bottom: 0,
					width: rightw
				});
			}

			var left = offset.left;

			if( self.$left ){
				var leftw = (fullw*25) / 100;
				if( self.$left.attr('data-width') ){
					leftw = parseInt( self.$left.attr('data-width') );
				}

				self.$left.css({
					width: leftw,
					height: fullh,
					position: 'absolute',
					top: 0,
					left: 0
				});

				if( self.$leftContent && self.$leftHeader ){
					self.$leftContent.css({
						height: fullh-self.$leftHeader.outerHeight(),
						overflowY: 'auto'
					});
				}
				

				self.$content.css({
					marginLeft: leftw,
				});

				left+=leftw;
			}

			if( self.$topbar ){
				self.$topbar.css({
					height: self.$topbar.outerHeight(),
					position: 'fixed',
					top: offset.top,
					left: offset.left,
					right: right
				});

				
			}

			if( self.$topbar ){
				fullh -= self.$topbar.outerHeight();
				self.$elem.css('padding-top', self.$topbar.outerHeight());

				if( self.$left ){
					self.$left.css('top', self.$topbar.outerHeight());
				}

				if( self.$right ){
					self.$right.css('top', self.$topbar.outerHeight());
				}
			}

			if( self.$toolbar ){
				fullh -= self.$toolbar.outerHeight();

				if( self.$colRigth ){

					self.$colRigth.css({
						top: self.$toolbar.outerHeight(),
					});
				}
			}

			if( self.$footer ){

				self.$footer.css({
					position: 'fixed',
					left: offset.left+leftw,
					right: right,
					backgroundColor: '#f8f8f8',
					// "border-top": "1px soile #efefef"
				});
				fullh -= self.$footer.outerHeight();
			}

			self.$main.css({
				height: fullh,
				overflowY: 'auto'
			});

			if( self.$toolbar && self.$toolbarControls  ){

				self.$toolbarControls.css({
					height: self.$toolbar.outerHeight(),
					position: 'fixed',
					left: offset.left+leftw,
					right: right,
				});
				
			}
		},

		Events: function () {
			var self = this;

			$('.navigation-trigger').click(function () {
				self.resize();
			});
		},

	};

	$.fn.ManageCategories = function( options ) {
		return this.each(function() {
			var $this = Object.create( ManageCategories );
			$this.init( options, this );
			$.data( this, 'ManageCategories', $this );
		});
	};

	$.fn.ManageCategories.options = {};

})( jQuery, window, document );


$(function () {
	
	// navigation
	$('.navigation-trigger').click(function(e){
		e.preventDefault();
		$('body').toggleClass('is-pushed-left', !$('body').hasClass('is-pushed-left'));

		$.get( Event.URL + 'me/navTrigger', {
			'status': $('body').hasClass('is-pushed-left') ? 1:0
		});
	});
	
});