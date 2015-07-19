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
                    <div class="expand">' + settings.expand_text + '</div>\
                    <div class="arr arr_l"><span></span></div>\
                    <div class="arr arr_r"><span></span></div>\
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
                    $('.image1', $self).append('<img src="' + tmp_href + '" />');
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

            if (this.expand) {
                $('.image1', $self).on('mouseenter', function(e){
                    $('.image1 .expand', $self).stop().animate({opacity:1},50);
                });

                $('.image1', $self).on('mouseleave', function(e){
                    $('.image1 .expand', $self).stop().animate({opacity:0},50);
                });
            }

            $('.thumbnails_holder a, .thumbnails_holder_h a', $self).on('click', function(e){
                e.preventDefault();

                tmp_href = $(this).attr('href');
                var cur_href = $('.image1 img', $self).attr('src');

                if (tmp_href != cur_href) {
                    $('.loading', $self).stop().animate({opacity:0.6}, 500);

                    $('.thumbnails_holder a.sel, .thumbnails_holder_h a', $self).removeClass('sel');
                    var index = $(this).index();
                    $('.thumbnails_holder a:nth-child('+(index+1)+'), .thumbnails_holder_h a:nth-child('+(index+1)+')', $self).addClass('sel');

                    $('.image1 img', $self).attr('src', tmp_href).load(function(){
                        $('.loading', $self).stop().animate({opacity:0}, 200);
                    });
                    $('.image1 img', $self).css({'width':'auto', 'height':'auto'});

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

                    // console.log(sel_top+' '+sel_bottom+' '+slider_h);

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

            $('.image1 .arr', $self).on('click', function(){

                if ($(this).hasClass('arr_l'))
                    return prev();
                else
                    return next();
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

            if (this.expand ) {
                $('.image1', $self).on('click', function(e){
                    e.preventDefault();

                    var next = function(){
                        if ($('.motidogallery_full .thumbnails_holder a.sel').next().length) {
                            $('.motidogallery_full .thumbnails_holder a.sel').next().click();
                        } else {
                            $('.motidogallery_full .thumbnails_holder a:first-child').click();
                        }
                        return false;
                    }

                    var prev = function(){
                        if ($('.motidogallery_full .thumbnails_holder a.sel').prev().length) {
                            $('.motidogallery_full .thumbnails_holder a.sel').prev().click();
                        } else {
                            $('.motidogallery_full .thumbnails_holder a:last-child').click();
                        }
                        return false;
                    }

                    var load_image = function(t, i) {
                        if (t) {
                            var a = $(t);
                        } else if (i !== undefined) {
                            var a = $('.motidogallery_full .thumbnails_holder a:nth-child('+(i+1)+')');
                        }

                        var tmp_href = a.attr('href');
                        var cur_href = $('.motidogallery_full .image2 img').attr('src');

                        if (tmp_href != cur_href) {
                            $('.motidogallery_full .thumbnails_holder a.sel').removeClass('sel');
                            a.addClass('sel');
                            var tmp_h2 = $('h2', a).html();
                            var tmp_p = $('p', a).html();

                            $('.motidogallery_full .image2 .text').remove();
                            
                            if (tmp_h2 || tmp_p) {
                                $('.motidogallery_full .image2').append('<div class="text" style="'+(ui_status == 0 ? 'bottom:-500px; display:none;' : 'display:none;')+'"></div>');
                            }
                            if (tmp_h2) {
                                $('.motidogallery_full .image2 .text').append('<h2>'+tmp_h2+'</h2>');
                            }
                            if (tmp_p) {
                                $('.motidogallery_full .image2 .text').append('<p>'+tmp_p+'</p>');
                            }

                            $('.motidogallery_full .loading').stop().animate({opacity:0.6}, 500);
                            $('.motidogallery_full .image2 img').attr('src', tmp_href).load(function(){
                                $('.motidogallery_full .loading').stop().animate({opacity:0}, 200);
                                $('.motidogallery_full .image2 .text').show();
                            });

                            var scroll_pos = $('.motidogallery_full .thumbnails_holder').scrollLeft();
                            var sel_pos = $('.motidogallery_full .thumbnails_holder a.sel').index();
                            var sel_left = sel_pos*96;

                            var max_visible = scroll_pos + wwidth;

                            if ( (sel_left+192) > max_visible ) {
                                $('.motidogallery_full .thumbnails_holder').scrollLeft( (sel_left+192-wwidth) );
                            } else if ( (sel_left-96) < scroll_pos ) {
                                $('.motidogallery_full .thumbnails_holder').scrollLeft((sel_left-96));
                            }
                        }
                        $('.motidogallery_full .thumbnails_holder').focus();
                    }

                    var html = '<div class="motidogallery_full_bg"></div><div class="motidogallery_full"><div class="loading"></div><div class="remark">'+settings.footnote_text+'</div><div class="close"></div><div class="prev"></div><div class="next"></div><div class="image2"><img src="" /></div><div class="thumbnails_holder">'+$('.thumbnails_holder', $self).html()+'</div></div>';
                    $('body').append(html);

                    var index = $('.thumbnails_holder a.sel', $self).index();
                    $('.motidogallery_full .thumbnails_holder').attr('tabindex','-1');

                    load_image(false, index);

                    setInterval(function(){
                        if ($('.motidogallery_full .image2').length) {
                            wheight = $(window).height();
                            wwidth = $(window).width();
                        
                            $('.motidogallery_full .image2').css({'height':(wheight)+'px'});
                        }
                    },200);

                    $('.motidogallery_full .thumbnails_holder').focus();

                    $('.motidogallery_full .close').on('click', function(){
                        $('.motidogallery_full_bg, .motidogallery_full').remove();
                    });
                    
                    $('.motidogallery_full .image2').on('click', function(){
                        var cur_l = parseInt($('.motidogallery_full .close').css('right'));

                        if ( cur_l < 0 ) {
                            ui_status = 1;

                            $('.motidogallery_full .close, .motidogallery_full .next').stop().animate({
                                right: '0px'
                            },100);

                            $('.motidogallery_full .prev').stop().animate({
                                left: '0px'
                            },100);

                            $('.motidogallery_full .thumbnails_holder').stop().animate({
                                bottom: '0px'
                            },100);

                            $('.motidogallery_full .image2 .text').stop().animate({
                                bottom: '110px'
                            },200);

                            $('.motidogallery_full .remark').stop().animate({
                                bottom: '-80px'
                            },300);
                        } else {
                            ui_status = 0;

                            $('.motidogallery_full .close, .motidogallery_full .next').stop().animate({
                                right: '-35px'
                            },100);

                            $('.motidogallery_full .prev').stop().animate({
                                left: '-35px'
                            },100);

                            $('.motidogallery_full .thumbnails_holder').stop().animate({
                                bottom: '-102px'
                            },100);

                            $('.motidogallery_full .image2 .text').stop().animate({
                                bottom: '-500px'
                            },300);

                            if (wwidth > 640) {
                                $('.motidogallery_full .remark').stop().animate({
                                    bottom: '0px'
                                },300).delay(2000).animate({
                                    bottom: '-80px'
                                });
                            }
                        }

                        $('.motidogallery_full .thumbnails_holder').focus();
                    });

                    $('.motidogallery_full .thumbnails_holder a').on('click', function(e){
                        e.preventDefault();
                        load_image(this);
                    });

                    $('.motidogallery_full .thumbnails_holder').on('keydown', function(e){
                        if (e.keyCode == 37) {
                            return prev();
                        } else if (e.keyCode == 39) {
                            return next();
                        } else if (e.keyCode == 27) { 
                            $('.motidogallery_full .close').click();
                            return false;
                        }
                    });

                    $('.motidogallery_full .next').on('click', function(){
                        return next();
                    });

                    $('.motidogallery_full .prev').on('click', function(){
                        return prev();
                    });
                });
            }
        });
    };
}(jQuery));