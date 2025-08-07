;(function($) {

    "use strict";

    var tf_search = function(){
        $('.tf-widget-search').each(function(){
            $(this).find('.tf-icon-search').on('click' , function(){
                $(this).siblings('.tf-modal-search-panel').addClass('show');
            });
        });
        $(document).on('click', '.tf-widget-search .tf-modal-search-panel', function() {
            $(this).removeClass('show');
        });
        $(document).on('click', '.tf-widget-search .tf-search-form', function(e) {
            e.stopImmediatePropagation();
        });
    };

$(window).on('elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/tf-search.default', tf_search );
});

})(jQuery);