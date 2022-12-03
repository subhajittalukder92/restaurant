/* <![CDATA[ */
(jQuery)(function ($) {
    'use strict';

    // MAIN NAVIGATION
    $('.nav').on({
        mouseenter: function () {
            $(this).find('ul:first').css({
                visibility: "visible",
                display: "none"
            }).fadeIn(300);
        },
        mouseleave: function () {
            $(this).find('ul:first').css({
                display: "none"
            });
        }}, ".dropdown");

    // RESPONSIVE NAVIGATION
    $(function () {
        $('#dl-menu').dlmenu({
            animationClasses: {
                classin: 'dl-animate-in-2',
                classout: 'dl-animate-out-2'
            }
        });
    });

   

    // FULL SCREEN PAGE
    (function () {
        $(window).on('load', function () {
            fullscreenOnResize();
        });

        $(window).on('resize', function () {
            fullscreenOnResize();
        });

        function fullscreenOnResize() {
            var screenHeight = $(window).height();
            $('.full-screen, .full-screen-content-wrapper').height(screenHeight);
            if ($(window).height() < 500) {

                $('.bottom-element-wrapper').css('bottom', '-170px');
            } else {
                $('.bottom-element-wrapper').css('bottom', 0);
            }
        }
    })();


    //ACCORDION
    (function () {
        'use strict';
        $('.accordion').on('click', '.title', function (event) {
            event.preventDefault();
            $(this).siblings('.accordion .active').next().slideUp('normal');
            $(this).siblings('.accordion .title').removeClass("active");

            if ($(this).next().is(':hidden') === true) {
                $(this).next().slideDown('normal');
                $(this).addClass("active");
            }
        });
        $('.accordion .content').hide();
        $('.accordion .active').next().slideDown('normal');
    })();

    // SCROLL TO TOP 
    $(window).scroll(function () {
        if ($(this).scrollTop() > 600) {
            $('.scroll-up').removeClass('hide-scroll').addClass('show-scroll');
        } else {
            $('.scroll-up').removeClass('show-scroll').addClass('hide-scroll');
        }
    });

    $('.scroll-up').on('click', function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });




    // function to check is user is on touch device
    if (!is_touch_device()) {

        // ANIMATED CONTENT
        if ($(".animated")[0]) {
            jQuery('.animated').css('opacity', '0');
        }

        var currentRow = -1;
        var counter = 1;

        $('.triggerAnimation').waypoint(function () {
            var $this = $(this);
            var rowIndex = $('.row').index($(this).closest('.row'));
            if (rowIndex !== currentRow) {
                currentRow = rowIndex;
                $('.row').eq(rowIndex).find('.triggerAnimation').each(function (i, val) {
                    var element = $(this);
                    setTimeout(function () {
                        var animation = element.attr('data-animate');
                        element.css('opacity', '1');
                        element.addClass("animated " + animation);
                    }, (i * 250));
                });

            }

            //counter++;

        },
                {
                    offset: '70%',
                    triggerOnce: true
                }
        );
    }
    ;

    // function to check is user is on touch device
    function is_touch_device() {
        return Modernizr.touch;
    }

    // Placeholder fix for old browsers
    $('input, textarea').placeholder();

    // RESIZE HEADER ON SCROLL
    $(function () {
        $(window).on('scroll', function () {
            resizeHeader();
        });
        $(window).resize('scroll', function () {
            resizeHeader();
        });
        function resizeHeader() {
            var position = $(window).scrollTop();
            var windowWidth = $(window).width();
            if (position > 70 && windowWidth > 1169) {
                $('#header-wrapper').addClass('resize-header');
            }
            else {
                $('#header-wrapper').removeClass('resize-header');
            }
        }
    });

 
});
/* ]]> */