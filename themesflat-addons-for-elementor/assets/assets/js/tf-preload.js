;(function($) {

    "use strict";

    var tf_preload = function() {  
        setTimeout(function() {  
            $(".tf-preloader").fadeOut('slow',function(){
                $(this).remove(); 
            });
        }, 1000); 
    };

$(window).on('elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/tf-preload.default', tf_preload );
});

})(jQuery);