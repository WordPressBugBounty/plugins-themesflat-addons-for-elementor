;(function($) {

    "use strict";

    var tf_counter = function() {    	
        $(window).scroll(function() {
        	var oTop = $('.counter').offset().top - window.innerHeight;
            if ($(window).scrollTop() > oTop) {
                var odo = $(".odometer");
	            odo.each(function() {
	                var countNumber = $(this).data("count");
	                $(this).html(countNumber);                                    
	            });
        	}            
    	});
    }


    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/tfcounter.default', tf_counter );
    });

})(jQuery);