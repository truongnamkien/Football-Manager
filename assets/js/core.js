(function($) {
    $.fn.invoiceForm = function() {
        $(this).each(function() {
            var _this = this;
            var calculate = function(item) {
                if (item != undefined) {
                    var current = $('.item_cnt', item).val() * $('.item_price', item).val();
                    $('.detail', item).html(number_format(current));
                }
                
                var total = 0;
                $('.value', _this).each(function() {
                    if ($(this).children('.item_name').children('input').is(':checked')) {
                        total += $(this).children('.item_cnt').val() * $(this).children('.item_price').val();
                    }
                });
                
                var discount = 0;
                $('.percent', _this).each(function() {
                    if ($(this).children('.item_name').children('input').is(':checked')) {
                        discount += total * $(this).children('.item_price').val() / 100;
                    }
                });
                
                var ext = parseFloat($('.extra_price_wrapper', _this).children('input').val());
                if (ext > 0)
                    $('.extra_price_wrapper .detail', _this).html(number_format(ext)).show();
                else
                    $('.extra_price_wrapper .detail', _this).hide();
                
                total = total + discount + ext;
                $('.total', _this).html(number_format(total));
                $('.total_price', _this).val(total);
            };
            
            var number_format = function(num) {
                var str = new String(num), tmp = '000';
                str = str.split('.');
                if (str[1] != undefined) {
                    tmp = str[1] + '000';
                    tmp = tmp.substr(0, 3);
                }
                str = '' + str[0] + '.' + tmp;
                return str;
            };
            
            $('.item', _this).each(function() {
                var __this = $(this);
                
                $('label', __this).click(function() {
                    calculate(__this);
                    if ($('.item_name', __this).find('input').is(':checked')) {
                        $(this).parent().addClass('checked');
                        $('.detail', __this).show();
                    } else {
                        $(this).parent().removeClass('checked');
                        $('.detail', __this).hide();
                    }
                });
                
                $('.item_cnt', __this).each(function() {
                    $(this)
                        .click(function() {
                            $(this).select();
                        })
                        .keyup(function() {
                            calculate(__this);
                            $(this).select();
                        });
                });
            });
            
            $('.extra_price_wrapper input', _this).each(function() {
                $(this)
                    .click(function() {
                        $(this).select();
                    })
                    .keyup(function() {
                        calculate();
                    });
            });
            
            $('.toggle', _this).click(function() {
                var target = $(this).attr('class').split(' ');
                target = '.' + target[1] + '_wrapper';
                if ($(target, _this).is(':visible')) $(target, _this).hide(); 
                else $(target, _this).show();
                return false;
            });

            $('button[type="submit"]', _this).click(function() {
                var total = $('.total_price', _this).val();
                if (isNaN(total) || total == 0) return false;
                $(this).attr('disabled','disabled')
                    .parent().append('<img src="' + _asset_url + 'images/loading.gif" />');
            });
        });
    };
})(jQuery);