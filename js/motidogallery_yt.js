(function ($) {
    $.fn.motidogallery = function (options) {

        var settings = $.extend({
            ratio: 1.6,
            expand_text: 'EXPAND',
            footnote_text: 'use arrow keys &larr; &rarr; to switch images'
        }, options);

        return this.each(function () {
            var $self = this,
                $this = $($self),
                width = $this.width(),
                img1_height = width / settings.ratio,
                img_cnt = 0,
                first_img = '',
                wwidth = 0,
                wheight = 0,
                ui_status = 1,
                expand = false;
            $this.addClass('motidogallery');

            $this.append(
                '<div class="image1">\
                </div>\
                <div class="thumbnails_holder"></div>\
                <div class="thumbnails_holder_h">\
                    <div class="arr_t"></div>\
                    <div class="slider">\
                        <div class="images"></div>\
                    </div>\
                    <div class="arr_b"></div>\
                </div>\
                <div class="loading"></div>'
            );
            $('.thumbnails_holder', $self).attr('tabindex', '-1');

            $('a', $self).each(function (k, v) {
                var tmp_img = $('img', v),
                    tmp_h2 = $('h2', v).html(),
                    tmp_p = $('p', v).html(),
                    tmp_href = $(v).attr('href'),
                    tmp_gid = $(v).data('gid'),

                    tmp_h2_html = (tmp_h2 !== undefined) ? '<h2>' + tmp_h2 + '</h2>' : '',
                    tmp_p_html = (tmp_p !== undefined) ? '<p>' + tmp_p + '</p>' : '';

                $('.thumbnails_holder', $self).append('<a data-gid="'+tmp_gid+'" href="' + tmp_href + '" ' + (img_cnt === 0 ? 'class="sel"' : '') + '><span>' + tmp_img.wrap("<span></span>").parent().html() + '</span>' + tmp_h2_html + tmp_p_html + '</a>');
                $('.thumbnails_holder_h .slider .images', $self).append('<a href="' + tmp_href + '" ' + (img_cnt === 0 ? 'class="sel"' : '') + '><span>' + tmp_img.wrap("<span></span>").parent().html() + '</span>' + tmp_h2_html + tmp_p_html + '</a>');
                $(v).remove();

                if (img_cnt === 0) {
                    $('.image1', $self).append('<iframe width="100%" height="100%" src="//www.youtube.com/embed/'+tmp_href+'" frameborder="0" allowfullscreen></iframe>');
                }
                img_cnt++;
            });

            $('.thumbnails_holder', $self).on('keydown', function (e) {
                if (e.keyCode === 37) {
                    if ($('.thumbnails_holder a.sel', $self).prev().length)
                        $('.thumbnails_holder a.sel', $self).prev().click();
                    else
                        $('.thumbnails_holder a:last-child', $self).click();
                    return false;
                } else if (e.keyCode == 39) {
                    if ($('.thumbnails_holder a.sel', $self).next().length)
                        $('.thumbnails_holder a.sel', $self).next().click();
                    else
                        $('.thumbnails_holder a:first-child', $self).click();
                    return false;
                }
            });

            $('.image1', $self).css({'height':img1_height+'px'});
            $('.slider .images', $self).css({'height':((img_cnt*135)-10)+'px'});

            setInterval(function(){
                if ($('.image1', $self).length) {
                    width = ($('.thumbnails_holder', $self).css('display') == 'block') ? $this.width() : $this.width()-240 ;
                    img1_height = width / settings.ratio;
                    $('.image1', $self).css({'height':img1_height+'px'});
                    $('.image1', $self).css({'width':width+'px'});

                    $('.thumbnails_holder_h', $self).height(img1_height);
                    $('.thumbnails_holder_h .slider', $self).height(img1_height-50);
                };
            },200);

            $('.thumbnails_holder a, .thumbnails_holder_h a', $self).on('click', function(e){
                e.preventDefault();

                tmp_href = $(this).attr('href');
                var cur_href = '';

                if (tmp_href != cur_href) {

                    $('.thumbnails_holder a.sel, .thumbnails_holder_h a', $self).removeClass('sel');
                    var index = $(this).index();
                    $('.thumbnails_holder a:nth-child('+(index+1)+'), .thumbnails_holder_h a:nth-child('+(index+1)+')', $self).addClass('sel');

                    $('.image1', $self).html('<iframe width="100%" height="100%" src="//www.youtube.com/embed/'+tmp_href+'" frameborder="0" allowfullscreen></iframe>');

                    var scroll_pos = $('.thumbnails_holder', $self).scrollLeft();
                    var sel_pos = $('.thumbnails_holder a.sel', $self).index();
                    var sel_left = sel_pos*110;

                    var max_visible = scroll_pos + width;

                    if ( (sel_left+210) > max_visible ) {
                        $('.thumbnails_holder', $self).scrollLeft( (sel_left+210-width) );
                    } else if ( (sel_left-110) < scroll_pos ) {
                        $('.thumbnails_holder', $self).scrollLeft((sel_left-110));
                    }

                    var slider_h = parseInt($('.thumbnails_holder_h .slider', $self).css('height'));
                    var sel_top = sel_pos*135;
                    var sel_bottom = sel_top+135;
                    var visible_min = -1*parseInt($('.thumbnails_holder_h .slider .images', $self).css('top'));
                    var visible_max = visible_min + slider_h;

                    var new_top = -1*visible_min;
                    if (sel_top < visible_min) {
                        new_top = -1*sel_top;
                    } else if (sel_bottom > visible_max) {
                        new_top = -1*sel_bottom+slider_h;
                    }
                    
                    $('.thumbnails_holder_h .slider .images', $self).stop().animate({
                        'top': new_top+'px'
                    }, 500);

                    /*if (nt < slider_h && sel_top < (slider_h - img_cnt*135) ) {
                        $('.thumbnails_holder_h .slider .images', $self).css('top', ( -1*(img_cnt * 135 - slider_h) )+'px' );
                    } else {
                        $('.thumbnails_holder_h .slider .images', $self).css('top', (sel_top)+'px');
                    }*/
                }

                $('.thumbnails_holder', $self).focus();
            });

            $('.thumbnails_holder_h .arr_b', $self).on('click', function(){
                return move_ud('u');
            });

            $('.thumbnails_holder_h .arr_t', $self).on('click', function(){
                return move_ud('d');
            });

            var next = function(){
                if ($('.thumbnails_holder_h a.sel').next().length) {
                    $('.thumbnails_holder_h a.sel').next().click();
                } else {
                    $('.thumbnails_holder_h a:first-child').click();
                }
                return false;
            }

            var prev = function(){
                if ($('.thumbnails_holder_h a.sel').prev().length) {
                    $('.thumbnails_holder_h a.sel').prev().click();
                } else {
                    $('.thumbnails_holder_h a:last-child').click();
                }
                return false;
            }

            var move_ud = function(d){
                var ct = parseInt($('.thumbnails_holder_h .slider .images', $self).css('top'));
                var sh = $('.thumbnails_holder_h .slider', $self).height();
                var ih = $('.thumbnails_holder_h .slider .images', $self).height();

                if (d == 'd' && (ct + 135) > 0) {

                    $('.thumbnails_holder_h .slider .images', $self).animate({
                        top: '10'
                    }, 100, function(){
                        $('.thumbnails_holder_h .slider .images', $self).animate({
                            top: '0'
                        }, 100);
                    });
                } else if ( d == 'u' && (ct - 135) < (sh - ih) ) {
                    $('.thumbnails_holder_h .slider .images', $self).animate({
                        top: (sh-ih-10)
                    }, 100, function(){
                        $('.thumbnails_holder_h .slider .images', $self).animate({
                            top: (sh-ih)
                        }, 100);
                    });
                } else {
                    $('.thumbnails_holder_h .slider .images', $self).animate({
                        top: (d == 'u' ? '-' : '+' )+'=135'
                    }, 300);
                }

            }
        });
    };
}(jQuery));