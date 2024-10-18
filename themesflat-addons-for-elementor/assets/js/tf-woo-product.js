;(function($) {

    "use strict";

    var productCarousel = function() {       
        if ( $().owlCarousel ) {
            $('.tf-woo-product.carousel-yes').each(function(){
                var 
                $this = $(this),
                item = $this.data("column"),
                item2 = $this.data("column2"),
                item3 = $this.data("column3"),
                spacer = Number($this.data("spacer")),
                prev_icon = $this.data("prev_icon"),
                next_icon = $this.data("next_icon");

                var loop = false;
                if ($this.data("loop") == 'yes') {
                    loop = true;
                }

                var arrow = false;
                if ($this.data("arrow") == 'yes') {
                    arrow = true;
                } 

                var auto = false;
                if ($this.data("auto") == 'yes') {
                    auto = true;
                }  
                            

                $this.find('.owl-carousel.owl-theme').owlCarousel({
                    loop: loop,
                    margin: spacer,
                    nav: true,
                    pagination: true,
                    autoplay: auto,
                    autoplayTimeout: 5000,
                    smartSpeed: 850,
                    autoplayHoverPause: true,
                    navText: [$('.tf-woo-prev'),$('.tf-woo-next'),],
                    responsive: {
                        0:{
                            items:item3
                        },
                        768:{
                            items:item2
                        },
                        1000:{
                            items:item
                        }
                    }
                });
            });
        }
    }

    var productLoadMore = function() {
        var $container_wrap = $('.tf-woo-product'); 
        var $container = $('.tf-woo-product').find('.products'); 
        var $products = $container.find('.products > .product-item');

        $('.navigation.loadmore a').on('click', function(e) {
            e.preventDefault(); 
            
            $(this).closest('.navigation.loadmore').addClass('loading');

            $.ajax({
                type: "GET",
                url: $(this).attr('href'),
                dataType: "html",
                success: function( out ) {
                    var result = $(out).find('.product-item');  
                    var nextlink = $(out).find('.navigation.loadmore a').attr('href');
                    
                    if (result.length) {
                        for (var index = 0; index < result.length; index++) {
                            $(result[index]).css('animation-delay', index * 100 + 'ms');
                        }
                        result.addClass('soberFadeInUp soberAnimation');
                    }
                    
                    $container.each(function() {
                        $(this).append(result).imagesLoaded(function () {
                            setTimeout(function() {                            
                                $container.isotope('appended', result);
                            }, index * 100);                                                
                        });   
                    });                                       

                    $('.navigation.loadmore').removeClass('loading');

                    if ( nextlink != undefined ) {
                        $('.navigation.loadmore a').attr('href', nextlink);
                    } else {                        
                        $('.navigation.loadmore').remove();
                    }
                }
            });
        });             
    }

    var productFilterForm = function() { 
        $(window).on('load resize', function() {
            $('.tf-woo-product').each(function(){
                if ( $(this).hasClass('show_filter_product') ) {
                    var $wrap_container = $(this);
                    var $container = $(this).find('.products');
                    var loading = '<span class="loading-icon"><span class="bubble"><span class="dot"></span></span><span class="bubble"><span class="dot"></span></span><span class="bubble"><span class="dot"></span></span></span>';
                    
                    $wrap_container.find('.shop-columns').on('click', function() {
                        $(this).siblings('.shop-columns').removeClass('active');
                        $(this).addClass('active');
                        var $data_columns = $(this).attr('data-columns');                        
                        $wrap_container.find('.products').append(loading);
                        $wrap_container.find(".products").attr('class', function(i, c){                            
                            setTimeout(function() {
                                $wrap_container.find('.products .loading-icon').fadeOut('slow', function(){
                                    setTimeout(function() {
                                        $wrap_container.find('.products .loading-icon').remove(); 
                                    }, 500);
                                });                              
                            }, 700); 
                            return c.replace(/(^|\s)columns-\S+/g, ' columns-'+$data_columns);
                        });
                    });
                    
                    $('.toggle-filter-form').on('click', function() {
                        $(this).siblings('.wrap-form-filter').fadeIn();
                    });
                    $('.wrap-form-filter .widget-title .close').on('click', function() {
                        $(this).closest('.wrap-form-filter').fadeOut();
                    });

                    $('#form_filter .filter-button').on('click', function() {
                        $wrap_container.find('.products').append(loading);  
                    });

                    $('#form_filter').submit(function(){
                        var form_filter = $(this);   
                                           
                        $.ajax({
                            url:form_filter.attr('action'),
                            data:form_filter.serialize(), // form data
                            type:form_filter.attr('method'), // POST
                            beforeSend:function(xhr){                                
                                form_filter.find('button').text('Processing...'); // changing the button label
                            },
                            success:function(data){
                                var numItems =  $(data).filter('.product-item').length;
                                $wrap_container.find('.toolbar-control .woocommerce-result-count').text(numItems + ' products');  
                                form_filter.find('button').text('Filter'); // changing the button label back
                                $wrap_container.find('.content-tab .content-tab-inner.active .products').html(data).hide().fadeIn('slow'); // insert data 

                                $wrap_container.find('.products .loading-icon').fadeOut('slow', function(){
                                    setTimeout(function() {
                                        $wrap_container.find('.products .loading-icon').remove(); 
                                    },1000);
                                });                  
                            }
                        });
                        return false;
                    });

                };  
            });
        });         
    };  

    var productFilterTabs = function() {        
        $('.show_filter_product').each(function() {
            var $wrap_container = $(this).closest('.tf-woo-product');
            var loading = '<span class="loading-icon"><span class="bubble"><span class="dot"></span></span><span class="bubble"><span class="dot"></span></span><span class="bubble"><span class="dot"></span></span></span>';
            $(this).children('.content-tab').children().hide();
            $(this).children('.content-tab').children().first().show().addClass('active');            
            $(this).find('.products-filter').children('li').on('click', function(e) {
                $wrap_container.find('.products').append(loading);
                var datafilter = $(this).attr('data-filter');
                $(this).closest('.tf-woo-product').find('#form_filter #product_tab_badge').val(datafilter);

                var liActive = $(this).index(),
                    contentActive = $(this).siblings().removeClass('active').parents('.show_filter_product').children('.content-tab').children().eq(liActive);
                
                contentActive.addClass('active').fadeIn('slow'); 
                var numItems = contentActive.find('.products').children('.product-item').length;                   
                    $(this).closest('.filter-bar').find('.toolbar-control .woocommerce-result-count').text(numItems + ' products');

                contentActive.siblings().removeClass('active');
                $(this).addClass('active').parents('.show_filter_product').children('.content-tab').children().eq(liActive).siblings().hide();
                e.preventDefault();                    

                setTimeout(function() {
                    $wrap_container.find('.products .loading-icon').fadeOut('', function(){
                        setTimeout(function() {
                            $wrap_container.find('.products .loading-icon').remove(); 
                        }, 500);
                    });                              
                }, 700);

            });
        });
    };

$(window).on('elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/tfwooproductgrid.default', productCarousel );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/tfwooproductgrid.default', productLoadMore );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/tfwooproductgrid.default', productFilterForm );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/tfwooproductgrid.default', productFilterTabs );
});

})(jQuery);