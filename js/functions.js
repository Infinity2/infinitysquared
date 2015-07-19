$(document).ready(function(){

    if (typeof home_slides !== 'undefined') {
        var bg_cnt = 0;
        $('.content.home').backstretch(home_slides[bg_cnt].photo, {fade: 2000});

        $(window)
            .on("backstretch.show", function() {
                var title = home_slides[bg_cnt].title;
                var location = home_slides[bg_cnt].location;
                $(".backstretch-caption-content").html(location + '</br>' + title).show().addClass('animated fadeIn');
            })
            .on("backstretch.before", function(e, instance) {
                $(".backstretch-caption-content").fadeOut();
            });

        var change_bg = setInterval(function(){
            bg_cnt++;

            if (bg_cnt == home_slides.length) {
                bg_cnt = 0;
            }

            $('.content.home').backstretch(home_slides[bg_cnt].photo, { fade: 500 });
        }, 9000);
    }

    $(".fab").fancybox({
        'autoScale'         : true,
        'cyclic'            : true,
        'transitionIn'      : 'fade',
        'transitionOut'     : 'fade',
        'autoDimensions'    : true,
        'titleShow'         : false,
        'overlayColor'      : '#000'
    });

    if ($('.col4').length) {
        $(window).on('resize', function(){
            calcMobileGallery1();
        });

        $('.col4 .arr_r').on('click', function(e){
            e.preventDefault();
            var ww = $(window).width();
            var img_slider_w = ww * $('.col4 img').length;

            var max_left = img_slider_w - ww;
            var next_l = parseInt($('.col4 .img_slider').css('left')) - ww;
            if (next_l < (max_left*(-1))) {
                next_l = 0;
            }

            $('.col4 .img_slider').stop().animate({
                left: next_l+'px'
            },300);
        });

        $('.col4 .arr_l').on('click', function(e){
            e.preventDefault();
            var ww = $(window).width();
            var img_slider_w = ww * $('.col4 img').length;

            var next_l = parseInt($('.col4 .img_slider').css('left')) + ww;
            if (next_l > 0) {
                next_l = (img_slider_w-ww)*(-1);
            }

            $('.col4 .img_slider').stop().animate({
                left: next_l+'px'
            },300);
        });
    }

    if ($('.motidogallery').length) {
        setInterval(function(){
            resizeGalleryHolder();
        }, 200);
    }

    $('.logo3').on('mouseover', function(){
        $(this).attr('src','img/logo4.png');
    });

    $('.logo3').on('mouseout', function(){
        $(this).attr('src','img/logo3.png');
    });

    $('.head1 ul li.gallery').on('mouseenter', function(){
        $('.gallery_dd', this).stop().slideDown(100);
    });

    $('.head1 ul li.gallery').on('mouseleave', function(){
        $('.gallery_dd', this).stop().slideUp(100);
    });

    $('.fmenu_m .purple a.gallery_link').on('click', function(e){
        e.preventDefault();
        if ($('.fmenu_m .purple.gallery').css('display') == 'none') {
            $('.fmenu_m .purple.gallery').slideDown();
        } else {
            $('.fmenu_m .purple.gallery').slideUp();
        }
    });

    if ($('.testimonials').length) {
        $('.testimonials .text.sel').fadeIn();
        $('.testimonials').css('height', $('.testimonials .text.sel').height());

        setInterval(function(){
            var curr = $('.testimonials .text.sel');
            var next = $('.testimonials .text.sel').next('.text');

            curr.removeClass('sel');

            if (next.length) {
                next.addClass('sel');
            } else {
                $('.testimonials .text:first-child').addClass('sel');
            }

            var nextH = $('.testimonials .text.sel').height();

            $('.testimonials').animate({
                height: nextH
            });

            $('.testimonials .text').fadeOut(400, function(){
                $('.testimonials .text.sel').fadeIn(1000);
            });
        }, 7000);
    }
});

$(window).load(function(){
    if ($('.col4').length) {
        calcMobileGallery1();
    }

    if ($('.motidogallery').length) {
        var photo = parseInt($(location).attr('pathname').split('/')[2]);
        if (photo > 0) {
            setTimeout(function(){
                $('a[data-gid="'+photo+'"]').click();
            }, 500);
        }
    }
});

function resizeGalleryHolder() {
    var wh = $(window).height();
    var ww = $(window).width();

    if (ww > 766) {
        var gh = wh - 100;
        var gw = gh*1.6 + 240;

        if (gw > ww) {
            gw = ww - 50;
            gh = (gw-240) / 1.6;
        }

        if (gh > 750) {
            gh = 750;
            gw = 750 * 1.6;
        }

        var mlr = (ww - gw) / 2;

        $('.motidogallery').css({
            'width':gw+'px',
            'marginLeft':mlr+'px',
            'marginRight':mlr+'px'
        });
    } else {
        $('.motidogallery').css({
            'width':'auto',
            'marginLeft':'auto',
            'marginRight':'auto'
        });
    }
}

function calcMobileGallery1() {

    var ww = $(window).width();
    var img_slider_w = ww * $('.col4 img').length;

    $('.col4 .img_slider img').width(ww);
    $('.col4, .col4 .img_slider').height($('.col4 .img_slider img:first-child').height());

    $('.col4 .img_slider').width(img_slider_w);
    $('.col4 .img_slider').css('left','0px');
}
