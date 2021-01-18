// Utility
if (typeof Object.create !== 'function') {
    Object.create = function(obj) {
        function F() {};
        F.prototype = obj;
        return new F();
    };
}

(function($, window, document, undefined) {
    var formMember = {
        init: function(options, elem) {
            var self = this;

            self.elem = elem
            self.$elem = $(elem);
            self.options = $.extend({}, $.fn.formMember.options, options);

            self.$zipcode = self.$elem.find('.js-zipcode');
            self.$province = self.$elem.find('.js-province');
            self.$amphure = self.$elem.find('.js-amphure');
            self.$district = self.$elem.find('.js-district');

            self.currAmphure = self.options.amphure;
            self.currDistrict = self.options.district;
            self.currZipcode = self.$zipcode.val();

            self.getProvince = null;

            self.setElem();
            self.Events();
        },
        setElem: function() {
            var self = this;

            self.$amphure.empty();
            self.$amphure.append($('<option>', { value: "", text: "- กรุณาเลือกเขต / อำเภอ -" }));

            self.$district.empty();
            self.$district.append($('<option>', { value: "", text: "- กรุณาเลือกแขวง / ตำบล -" }));

            if (self.$province.val() != "") {
                self.setAmphures(self.$province.val());
            }

            /* if( self.$zipcode.val() != "" ){
            	self.setDataByZipcode( self.$zipcode.val() );
            } */
        },
        Events: function() {
            var self = this;

            /* self.$zipcode.change(function(){
            	var zipcode = $(this).val();
            	if( zipcode.length >= 5 ){
            		self.setDataByZipcode( zipcode );
            	}
            }); */

            /* Event for Manual Change */
            self.$province.change(function() {
                self.setAmphures($(this).val());
            });

            self.$amphure.change(function() {
                self.setDistrict($(this).val());
            });

            self.$district.change(function() {
                var zipcode = $("option:selected", this).attr("data-zipcode");
                if (zipcode != "0" && zipcode != undefined) {
                    self.$zipcode.val(zipcode);
                    var fieldset = self.$zipcode.closest('fieldset');
                    fieldset.removeClass('has-error');
                    fieldset.find('notification').text('');
                }
            });

            setTimeout(function() {
                if (self.currZipcode != "") {
                    self.$zipcode.val(self.currZipcode);
                }
            }, 300);
            /**/
        },
        setDataByZipcode: function(zipcode) {
            var self = this;
            /* SET PROVINCE */
            $.get(Event.URL + 'members/getProvinceByCode/' + zipcode, function(res) {
                self.$province.find('[value=' + res.id + ']').prop('selected', 1);
                self.$province.val(res.id).trigger('change');

                /* SET AMPHURES */
                self.setAmphures(res.id);
                /**/

                /* GET DISTRICT By ZIPCODE FOR KNOW AMPHURE */
                setTimeout(function() {
                    $.get(Event.URL + 'members/geteAmphureByZipcode/' + zipcode, function(res) {
                        self.$amphure.val(res.amphure_id).trigger('change');
                        self.setDistrict(res.amphure_id);
                    }, 'json');
                }, 100);
                /**/

            }, 'json');
            /**/
        },
        setAmphures: function(province_id) {
            var self = this;
            $.get(Event.URL + 'members/getAmphuresByProvince/' + province_id, function(res) {
                self.$amphure.empty();
                self.$amphure.append($('<option>', { value: "", text: "- กรุณาเลือกเขต / อำเภอ -" }));
                $.each(res, function(i, obj) {
                    var $option = $('<option>', { value: obj.id, text: obj.name, "code": obj.code });
                    self.$amphure.append($option);
                });
                if (self.currAmphure != "") {
                    self.$amphure.val(self.currAmphure).trigger('change');
                }
            }, 'json');
        },
        setDistrict: function(amphure_id) {
            var self = this;
            $.get(Event.URL + 'members/getDistrictsByAmphure/' + amphure_id, function(res) {
                self.$district.empty();
                self.$district.append($('<option>', { value: "", text: "- กรุณาเลือกแขวง / ตำบล -" }));
                $.each(res, function(i, obj) {
                    var option = $('<option>', { value: obj.id, text: obj.name, "data-zipcode": obj.zip_code });
                    self.$district.append(option);
                });
                if (self.currDistrict != "") {
                    self.$district.val(self.currDistrict).trigger('change');
                }
            }, 'json');
        },

    }

    $.fn.formMember = function(options) {
        return this.each(function() {
            var $this = Object.create(formMember);
            $this.init(options, this);
            $.data(this, 'formMember', $this);
        });
    };

    $.fn.formMember.options = {};
})(jQuery, window, document);