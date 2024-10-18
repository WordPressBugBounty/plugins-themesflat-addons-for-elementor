;(function($) {

    "use strict";

    var tf_video = function(){
        $('.tf-video-popup .popup-video').magnificPopup({
            fixedContentPos: true,
            closeOnContentClick: true,
            closeBtnInside: false,    
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
        });
    }

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/tf_addon_video_popup.default', tf_video );
    });

})(jQuery);
