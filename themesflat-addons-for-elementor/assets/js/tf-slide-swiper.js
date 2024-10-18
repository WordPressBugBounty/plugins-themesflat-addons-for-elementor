;(function($) {

    "use strict";

    var tf_slide_swiper = function() {
        $('.tf-slide-swiper').each(function(){
            var container = $(this), 
                swiper_container = container.find('.swiper-container-primary'),
                autoplay_speed = container.data('autoplay_speed'),
                autoplay = (container.data('autoplay') == 'yes') ? { delay: autoplay_speed } : false ,
                pause_on_interaction = container.data('pause_on_interaction'),
                infinite_loop = (container.data('infinite_loop') == 'yes')? true : false ,
                transition_speed = container.data('transition_speed'),
                bullets_type = container.data('bullets_type'),
                direction = container.data('direction'),
                reverse_direction = (container.data('reverse_direction') == 'yes')? true : false ,
                space_between = container.data('space_between'),
                slides_show = container.data('slides_show'),
                slides_show_tablet = container.data('slides_show_tablet'),
                slides_show_mobile = container.data('slides_show_mobile');

                if (reverse_direction) {
                    autoplay = (container.data('autoplay') == 'yes') ? { delay: autoplay_speed, reverseDirection: true } : false ;
                }

            var swiper = new Swiper(swiper_container, {
                // Optional parameters,
                slidesPerView: slides_show,
                direction: direction, //vertica or horizontal                
                spaceBetween: space_between,
                effect: 'slide',
                speed: transition_speed,
                loop: infinite_loop,
                autoplay: autoplay,
                grabCursor: true,  
                reverseDirection: true,       

                // If we need pagination
                pagination: {
                    el: '.swiper-pagination',
                    type: bullets_type /*progressbar, bullets, fraction */,
                    clickable: true,
                },

                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                }, 

                breakpoints: {  
                    '320': {
                      slidesPerView: slides_show_mobile,
                    },
                    '768': {
                      slidesPerView: slides_show_tablet,
                    },
                    '1025': {
                      slidesPerView: slides_show,
                    },
                },               
            });

            if (pause_on_interaction == 'yes') {
                swiper_container.on('mouseenter', function(e){
                    swiper.autoplay.stop();
                });
                swiper_container.on('mouseleave', function(e){
                    swiper.autoplay.start();
                });
            }
        });
    };

$(window).on('elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/tf-slide-swiper.default', tf_slide_swiper );
});

})(jQuery);