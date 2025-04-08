;(function($) {

    "use strict";

    var tf_flexslider = function() {
        $(".flexslider").each(function() {
            var $this = $(this),
            adminBarHeight = 0,
            topBarHeight = 0,
            contentTopMargin = 0,
            adminBar = $('#wpadminbar'),
            topBar = $('#top-bar'),
            headerHeight = $('header').height(),            
            flexsliderHeight = $this.data('height'),
            flexsliderHeightTablet = $this.data('height_tablet'),
            flexsliderHeightMobile = $this.data('height_mobile'),
            flexSliderContent = $this.find('.flex_caption'),            
            contentHeight = flexSliderContent.outerHeight();            
            if ( matchMedia( 'only screen and (max-width: 991px)' ).matches ) {
                flexsliderHeight = flexsliderHeightTablet;
            }
            if ( matchMedia( 'only screen and (max-width: 767px)' ).matches ) {
                flexsliderHeight = flexsliderHeightMobile;
            }

            $this.find('.item-slide').height(flexsliderHeight);
            if (topBar.length) topBarHeight = topBar.height();
            if (adminBar.length) adminBarHeight = adminBar.height();          
            
            if (contentHeight == 0) {
                contentHeight = (flexsliderHeight * 0.5);                
            }

            if ( $this.hasClass('header-absolute') ) {
                contentTopMargin = ((flexsliderHeight + topBarHeight + headerHeight - contentHeight ) / 2);
                flexSliderContent.css("margin-top", (contentTopMargin) + "px");
            } else {
                contentTopMargin = ((flexsliderHeight - contentHeight ) / 2);
                flexSliderContent.css("margin-top", (contentTopMargin) + "px");
            }

            var animation = $this.data('animation_images'),
                autoplay = $this.data('autoplay'),
                slideshowSpeed = $this.data('slideshowSpeed'),
                controlNav = $this.data('controlnav'),
                directionNav = $this.data('directionnav'),
                prevText = $this.data('prevtext'),
                nextText = $this.data('nexttext');
                function escapeHtml(str) {
                    return str.replace(/[&<>"'`=\/]/g, function (s) {
                        return '&#' + s.charCodeAt(0) + ';';
                    });
                }
                
                prevText = escapeHtml(prevText);
                nextText = escapeHtml(nextText);
            $this.flexslider({
                animation: 'fade',
                slideshow: autoplay,
                slideshowSpeed: slideshowSpeed,
                animationSpeed: 1000,
                animationLoop: true,
                controlNav: controlNav,
                directionNav: directionNav,
                prevText: '<i class="' + prevText + '" aria-hidden="true"></i>',
                nextText: '<i class="' + nextText + '" aria-hidden="true"></i>',
                useCCS: false
            });
        });
    }  


$(window).on('elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/flex-slider.default', tf_flexslider ); 
});

})(jQuery);