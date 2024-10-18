;(function($) {

    "use strict";

    var tf_scrolltop = function() { 
        $(window).scroll(function() {
            if ( $(this).scrollTop() > 200 ) {
                $('#tf-scroll-top').addClass('show');
            } else {
                $('#tf-scroll-top').removeClass('show');
            }
        });

        $('#tf-scroll-top .inner-scroll-top').on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, 1000 , 'easeInOutExpo');
            return false;
        });
    } 

$(window).on('elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/tf-scroll-top.default', tf_scrolltop );
});

})(jQuery);