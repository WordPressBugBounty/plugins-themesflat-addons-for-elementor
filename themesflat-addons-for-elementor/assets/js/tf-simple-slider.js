;(function($) {

    "use strict";

    var tf_simple_slider = function() {
        $(".hero-section").each(function() {            
            var            
            contentTopMargin = 0,
            heroHeight = 0,
            customHeight = 0,
            hero = $(this),
            windowHeight = $(window).height(),
            heroContent = hero.find('.vegas-content'),
            contentHeight = heroContent.height(),
            delay = Number(hero.data('delay')),
            spacing = hero.data('content'),
            slide_type = hero.data('slide_type'),
            customHeight = hero.data('height');
            var customHeightTablet = hero.data('height_tablet');
            var customHeightMobile = hero.data('height_mobile');

            if ( slide_type == 'full-height' ) {                
                heroHeight = windowHeight;
            }else {                
                heroHeight = customHeight;
                if ( matchMedia( 'only screen and (max-width: 991px)' ).matches ) {
                    heroHeight = customHeightTablet;
                }
                if ( matchMedia( 'only screen and (max-width: 767px)' ).matches ) {
                    heroHeight = customHeightMobile;
                }
            }
            
            if ( slide_type == 'full-height' ) {
                hero.css({ height: heroHeight + "px" });
                contentTopMargin = ((heroHeight - contentHeight) / 2) + spacing;
                heroContent.css("padding-top", (contentTopMargin) + "px");
            }else {                    
                hero.css({ height: heroHeight + "px" });
                contentTopMargin = ((heroHeight - contentHeight) / 2) + spacing;
                heroContent.css("padding-top", (contentTopMargin) + "px");
            }
            
            if ( $().vegas ) {
                $(".hero-section.slidehero").each(function() {
                    var
                    $this = $(this),
                    count = $this.data('count'),
                    count = parseInt(count,10),
                    effect = $this.data('effect'),
                    images = $this.data('image'),
                    cOverlay = $this.data('overlay'),
                    pOverlay = $this.data('poverlay'),
                    i = 0,
                    slides = [],
                    imgs = images.split('|');
                    while ( i < count ) {
                        slides.push( {src:imgs[i]} );
                        i++;
                    }
                    $this.vegas({
                        slides: slides,
                        overlay: true,
                        transition: effect,
                        delay: delay,
                    });
                    var overlay = $('<div />', {
                        class: 'overlay',
                        style: 'background:' + cOverlay
                    });                   
                    $(this).append(overlay).find('.vegas-overlay').addClass(pOverlay);
                });
            }        
            if ( $().YTPlayer ) {
                $(".hero-section.slidevideo").each(function() {
                    var
                    $this = $(this),
                    cOverlay = $this.data('overlay'),
                    overlay = $('<div />', {
                        class: 'overlay',
                        style: 'position: absolute; width: 100%; height: 100%; background:' + cOverlay
                    });
                    $this.YTPlayer().append(overlay);
                });
            }
            if ( $('.slide-fancy-text').is('.scroll') ) {
                $('.slide-fancy-text.scroll').each(function() {
                    var
                    $this = $(this),
                    current = 1,
                    height = $this.children('.heading').height(),
                    numberDivs = $this.children().length,
                    first = $this.children('.heading:nth-child(1)');
                    $this.height(height);
                    $this.siblings('.prefix-text, .suffix-text').height(height);
                    setInterval(function() {                                    
                        var number = current * -height;                   
                        first.css('margin-top', number + 'px');
                        if ( current === numberDivs ) {
                            first.css('margin-top', '0px');
                            current = 1;
                        } else current++;
                    }, delay);
                });
            }       
            if ( $('.slide-fancy-text').is('.typed') ) {
                if ( $().typed ) {
                    $('.slide-fancy-text.typed').each(function() {
                        var
                        $this = $(this),
                        texts = $this.data('fancy').split(',');
                        $this.find('.text').typed({
                            strings: texts,
                            typeSpeed: 40,
                            loop:true,
                            backDelay: delay
                        });
                    });
                }
            }
        });
        $(".hero-section").each(function() {
            var $this = $(this);
            $this.find('.scroll-target').on('click',function() {
                var anchor = $(this).attr('href').split('#')[1];
                if ( anchor ) {
                    if ( $('#'+anchor).length > 0 ) {
                        var headerHeight = 0;
                        if ( $('body').hasClass('header-sticky') ) {
                            headerHeight = $('#site-header').height();
                        }
                        var target = $('#' + anchor).offset().top - headerHeight;
                        if ( $('body').hasClass('admin-bar') ) {
                            var wpadminbar = $('#wpadminbar').height();
                            target = $('#' + anchor).offset().top - headerHeight - wpadminbar;
                        }
                        $('html,body').animate({scrollTop: target}, 1000, 'easeInOutExpo');
                   }
                }
                return false;
            });
        });
    };

$(window).on('elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/vegas-slider.default', tf_simple_slider );
});

$(window).on('resize', function() {
    tf_simple_slider();       
});

})(jQuery);