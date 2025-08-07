;(function($) {

    "use strict";

    var tfProgressBar = function() {
        if ( $().appear ) {
            var $section = $('.tf-progress-bar').appear(function() {
            
            function runBars() {
                var bar = $('.progress-animate');
                var bar_width = $(this);
                $(function(){
                  $(bar).each(function(){
                    bar_width = $(this).attr('data-valuenow');
                    $(this).width(bar_width + '%');

                    $(this).parents('.tf-progress-bar').find('.perc').width(bar_width + '%');
                  });
                });
            }

            runBars();
            });
        }
    };

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/tf-progress-bar.default', tfProgressBar );
    });

})(jQuery);
