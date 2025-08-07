;(function($) {

    "use strict";

var tf_minicart = function() { 
    $('#mini-cart-click, #mini-cart-click a, .products .ajax_add_to_cart').on('click', function(e){            
        $('#canvas-mini-cart').addClass('canvas-cart-open');
        $('.mini-cart .overlay-mini-cart').addClass('canvas-overlay-open');
        e.preventDefault();       
    });

    $('.mini-cart .overlay-mini-cart, #canvas-mini-cart .cart-close').on('click', function(e){            
        $('#canvas-mini-cart').removeClass('canvas-cart-open');
        $('.mini-cart .overlay-mini-cart').removeClass('canvas-overlay-open');
        e.preventDefault();
    });
} 

$(window).on('elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/tf-mini-cart.default', tf_minicart ); 
});

})(jQuery);