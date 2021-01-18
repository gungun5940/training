// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {
	var setDatePicker = {
		init: function( options, elem ){
			var self = this;

			self.elem = elem
			self.$elem = $(elem);
			self.options = $.extend( {}, $.fn.setDatePicker.options, options );

			self.setElem();
		},
		setElem: function(){
			var self = this;
			self.$elem.datepicker({
				changeMonth: self.options.changeMonth || true,
				changeYear: self.options.changeYear || true,
				showButtonPanel: self.options.showButtonPanel || true,
				yearRange:  self.options.yearRange || "-100:+15",
				dateFormat: self.options.dateFormat || 'dd/mm/yy',
				autoSize : true,
				monthNamesShort: $.datepicker.regional["th"].monthNames,
				beforeShow:function(){
					setTimeout(function(){
						$.each($(".ui-datepicker-year option"),function(j,k){
							var textYear=parseInt($(".ui-datepicker-year option").eq(j).val())+543;
							$(".ui-datepicker-year option").eq(j).text(textYear);
						});
					},10);
				},
				onChangeMonthYear: function(){
					setTimeout(function(){
						$.each($(".ui-datepicker-year option"),function(j,k){
							var textYear=parseInt($(".ui-datepicker-year option").eq(j).val())+543;
							$(".ui-datepicker-year option").eq(j).text(textYear);
						});
					},10);
				}
			}); 
		}
	}

	$.fn.setDatePicker = function( options ) {
		return this.each(function() {
			var $this = Object.create( setDatePicker );
			$this.init( options, this );
			$.data( this, 'setDatePicker', $this );
		});
	};

	$.fn.setDatePicker.options = {};
})( jQuery, window, document );