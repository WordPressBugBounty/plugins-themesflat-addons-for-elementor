;(function($) {
    
    var themesflat_animation_fadeup = function (container, item) {
        $(window).scroll(function () {
            var windowBottom = $(this).scrollTop() + $(this).innerHeight();
            $(container).each(function (index, value) {
                var objectBottom = $(this).offset().top + $(this).outerHeight() * 0.1;
                
                if (objectBottom < windowBottom) { 
                    var seat = $(this).find(item);
                    for (var i = 0; i < seat.length; i++) {
                        (function (index) {
                            setTimeout(function () {
                                seat.eq(index).addClass('tf-animate');
                            }, 200 * index);
                        })(i);
                    }
                }
            });
        }).scroll();
    };


    var tf_group_image = function() {
        var elements = document.querySelectorAll(".tf-image-group-widget .tf-image-item");
        
        for (let index = 0; index < elements.length; index++) {
            var image = elements[index].querySelector('img');
            var orientationParallax = image.getAttribute('data-parallax-orientation');
            var scale = image.getAttribute('data-parallax-scale');
            var delay = image.getAttribute('data-parallax-delay');
            var transitionType = image.getAttribute('data-parallax-transition'); 
            var transitionDuration = image.getAttribute('data-parallax-duration');
            new simpleParallax(image, {
                orientation: orientationParallax,
                scale: scale,
                delay: delay,
                overflow: true,
            });   
            image.style.transition = 'transform ' + transitionDuration + 's ' + transitionType;
        }
        themesflat_animation_fadeup(".tf-image-group-widget", ".inner-animate");
    }

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/tf-group-image.default', tf_group_image );
    });
})(jQuery);