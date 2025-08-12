<?php
/*
Plugin Name: Themesflat Addons For Elementor
Description: The theme's components
Author: Themesflat
Author URI: http://themesflat-addons.com/
Version: 2.2.9
Text Domain: themesflat-addons-for-elementor
Domain Path: /languages

WC tested up to: 10.0
Elementor tested up to: 3.31
Elementor Pro tested up to: 3.31

License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('ABSPATH'))
    exit;

define( 'THEMESFLAT_ADDON_PATH', plugin_dir_path( __FILE__ ) );
define( 'THEMESFLAT_ADDON_URL', plugin_dir_url( __FILE__ ) );

final class ThemesFlat_Addon_For_Elementor_Free {

    const VERSION = '1.9.9';
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const MINIMUM_PHP_VERSION = '5.2';

    private static $_instance = null;
    private static $meta_option;
    private static $current_page_type = null;
    private static $current_page_data = array();
    private static $user_selection;
    private static $location_selection;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {        
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );        
        define('URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE', plugins_url('/', __FILE__)); 
        $ajax_url = admin_url('admin-ajax.php');
        define('TFHF_AJAX_URL_FREE', $ajax_url);
        
        
        add_action( 'elementor/frontend/after_register_styles', [ $this, 'widget_styles' ] , 100 );
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ], 100 );    

        add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] , 100 );  
        add_action( 'admin_action_edit', array( $this, 'initialize_options' ) );
        add_action( 'wp_ajax_tfhf_get_posts_by_query', array( $this, 'tfhf_get_posts_by_query' ) );  
        if ( ! function_exists('is_plugin_active') ){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }    
    }

    public function i18n() {
        load_plugin_textdomain( 'themesflat-addons-for-elementor', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }
    

    public function init() {
        // Check if Elementor installed and activated        
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'tf_admin_notice_missing_main_plugin' ] );
            return;
        }

        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        // Check if  WooCommerce installed and activated 
        /*if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            add_action('admin_notices', [ $this, 'tf_admin_notice_missing_woocommerce_plugin' ] );            
        }else {
            add_action('admin_notices', [ $this, 'tf_admin_notice_compare_quick_view_wishlist' ] );
        }*/


            
        add_action( 'before_woocommerce_init', function() {
            if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
                \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
            }
        } );
       
        require_once( __DIR__ . '/shortcode.php' );

        require_once plugin_dir_path( __FILE__ ).'pagination.php';
        require_once plugin_dir_path( __FILE__ ).'tf-function.php';
        require_once plugin_dir_path( __FILE__ ).'addon-elementor-icon-manager.php';
        // require_once plugin_dir_path( __FILE__ ).'tf-post-format.php';


        
        
        require_once plugin_dir_path( __FILE__ ).'tf-plugin-option.php';
        // require_once plugin_dir_path( __FILE__ ).'tf-plugin-setup.php';


        add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );
        add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );

        add_action( 'elementor/elements/categories_registered', function () {
            $elementsManager = \Elementor\Plugin::instance()->elements_manager;
            $elementsManager->add_category(
                'themesflat_addons',
                array(
                  'title' => 'THEMESFLAT ADDONS',
                  'icon'  => 'fonts',
            ));

            $elementsManager->add_category(
                'themesflat_addons_single_post',
                array(
                  'title' => 'THEMESFLAT ADDONS SINGLE POST',
                  'icon'  => 'fonts',
            ));

            $elementsManager->add_category(
                'themesflat_addons_wc',
                array(
                  'title' => 'THEMESFLAT ADDONS WOO',
                  'icon'  => 'fonts',
            ));
        },5);

        

        add_action( 'init', [ $this, 'tf_header_footer_post_type' ] );
        add_action( 'add_meta_boxes', [ $this, 'tf_header_footer_register_metabox' ] );
        add_action( 'save_post', [ $this, 'tf_header_footer_save_meta' ] );
        add_filter( 'single_template', [ $this, 'tf_header_footer_load_canvas_template' ] );
        add_action( 'wp', [ $this, 'hooks' ],100 ); 
        
        
    }    

    public function tf_admin_notice_missing_main_plugin() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        
        $message = sprintf(
            /* translators:plugin %1$s requires plugin %2$s to be installed and activated*/
            esc_html__( '"%1$s" requires "%2$s" .', 'themesflat-addons-for-elementor' ),
            '<strong>' . esc_html__( 'Themesflat Addons For Elementor', 'themesflat-addons-for-elementor' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'themesflat-addons-for-elementor' ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            /* translators:plugin %1$s requires plugin %2$s version %3$s or greater*/
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'themesflat-addons-for-elementor' ),
            '<strong>' . esc_html__( 'Themesflat Addons For Elementor', 'themesflat-addons-for-elementor' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'themesflat-addons-for-elementor' ) . '</strong>',
             self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

    public function admin_notice_minimum_php_version() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
           /* translators:plugin %1$s requires plugin %2$s version %3$s or greater*/
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'themesflat-addons-for-elementor' ),
            '<strong>' . esc_html__( 'Themesflat Addons For Elementor', 'themesflat-addons-for-elementor' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'themesflat-addons-for-elementor' ) . '</strong>',
             self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

    /*public function tf_admin_notice_missing_woocommerce_plugin(){
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'themesflat-addons-for-elementor' ),
            '<strong>' . esc_html__( 'TF Woo Product Grid Addon For Elementor', 'themesflat-addons-for-elementor' ) . '</strong>',
            '<strong>' . esc_html__( 'WooCommerce', 'themesflat-addons-for-elementor' ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
    public function tf_admin_notice_compare_quick_view_wishlist(){
        $message = sprintf(
            esc_html__( '"%1$s" If you want to use "%2$s" then install the following Plugin.', 'themesflat-addons-for-elementor' ),
            '<strong>' . esc_html__( 'TF Woo Product Grid Addon For Elementor', 'themesflat-addons-for-elementor' ) . '</strong>',
            '<strong>' . esc_html__( 'Compare, Quick View, Wishlist', 'themesflat-addons-for-elementor' ) . '</strong>'
        );

        $button_compare_text = esc_html__( 'Plugin Compare', 'themesflat-addons-for-elementor' );
        $button_link_compare = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=yith-woocommerce-compare' ), 'install-plugin_yith-woocommerce-compare' );
        $button_quick_view_text = esc_html__( 'Plugin Quick View', 'themesflat-addons-for-elementor' );
        $button_link_quick_view = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=yith-woocommerce-quick-view' ), 'install-plugin_yith-woocommerce-quick-view');
        $button_wishlist_text = esc_html__( 'Plugin Wishlist', 'themesflat-addons-for-elementor' );
        $button_link_wishlist = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=yith-woocommerce-wishlist' ), 'install-plugin_yith-woocommerce-wishlist' );

        $btn_install_compare = '<a class="button button-primary" target="_blank" href="'.esc_url( $button_link_compare ).'">'.esc_html( $button_compare_text ).'</a>';
        if( class_exists( 'YITH_WOOCOMPARE' ) ) {            
            $btn_install_compare = '';
        }

        $btn_install_quick_view = '<a class="button button-primary" target="_blank" href="'.esc_url( $button_link_quick_view ).'">'.esc_html( $button_quick_view_text ).'</a>';
        if( class_exists( 'YITH_WCQV' ) ) {            
            $btn_install_quick_view = '';
        }

        $btn_install_wishlist = '<a class="button button-primary" target="_blank" href="'.esc_url( $button_link_wishlist ).'">'.esc_html( $button_wishlist_text ).'</a>';
        if( class_exists( 'YITH_WCWL' ) ) {            
            $btn_install_wishlist = '';
        }

        if ( is_admin() ) {
            if( class_exists( 'YITH_WCWL' ) && class_exists( 'YITH_WOOCOMPARE' ) && class_exists( 'YITH_WCQV' ) ) {
                
            }else {
                printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p> <p>%2$s %3$s %4$s</p></div>', $message, $btn_install_compare, $btn_install_quick_view, $btn_install_wishlist );
            }
        }        
    }*/

    public function init_widgets() {

        if(tf_opt_get_option('wd_image_box') === false || tf_opt_get_option('wd_image_box') === 'on') {
            require_once( __DIR__ . '/widgets/widget-imagebox.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFImageBox_Widget_Free() );
        } elseif (tf_opt_get_option('wd_image_box') !== 'on' ) {

        } 

        if(tf_opt_get_option('wd_carousel') === false || tf_opt_get_option('wd_carousel') === 'on') {
            require_once( __DIR__ . '/widgets/widget-carousel.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFCarousel_Widget_Free() );
        } elseif (tf_opt_get_option('wd_carousel') !== 'on' ) {

        } 

        if(tf_opt_get_option('wd_navmenu') === false || tf_opt_get_option('wd_navmenu') === 'on') {
            require_once( __DIR__ . '/widgets/widget-navmenu.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFNavMenu_Widget_Free() );
        } elseif (tf_opt_get_option('wd_navmenu') !== 'on' ) {

        } 

        if(tf_opt_get_option('wd_search') === false || tf_opt_get_option('wd_search') === 'on') {
            require_once( __DIR__ . '/widgets/widget-search.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFSearch_Widget_Free() );
        } elseif (tf_opt_get_option('wd_search') !== 'on' ) {

        } 


        if(tf_opt_get_option('wd_posts') === false || tf_opt_get_option('wd_posts') === 'on') {
            require_once( __DIR__ . '/widgets/widget-posts.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFPosts_Widget_Free() );
        } elseif (tf_opt_get_option('wd_posts') !== 'on' ) {

        } 

        if(tf_opt_get_option('wd_tabs') === false || tf_opt_get_option('wd_tabs') === 'on') {
            require_once( __DIR__ . '/widgets/widget-tabs.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFTabs_Widget_Free() );
        } elseif (tf_opt_get_option('wd_tabs') !== 'on' ) {

        } 


        if(tf_opt_get_option('wd_simple_slider') === false || tf_opt_get_option('wd_simple_slider') === 'on') {
            require_once( __DIR__ . '/widgets/widget-simple-slide.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFSlide_Widget_Free() );
        } elseif (tf_opt_get_option('wd_simple_slider') !== 'on' ) {

        } 

        if(tf_opt_get_option('wd_e_slider') === false || tf_opt_get_option('wd_e_slider') === 'on') {
            require_once( __DIR__ . '/widgets/widget-flex-slide.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFFlex_Slide_Widget_Free() );
        } elseif (tf_opt_get_option('wd_e_slider') !== 'on' ) {

        } 

        if(tf_opt_get_option('wd_scroll_top') === false || tf_opt_get_option('wd_scroll_top') === 'on') {
            require_once( __DIR__ . '/widgets/widget-scroll-top.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFScrollTop_Widget_Free() );
        } elseif (tf_opt_get_option('wd_scroll_top') !== 'on' ) {

        } 

        if(tf_opt_get_option('wd_preload') === false || tf_opt_get_option('wd_preload') === 'on') {
            require_once( __DIR__ . '/widgets/widget-preload.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFPreload_Widget_Free() );
        } elseif (tf_opt_get_option('wd_preload') !== 'on' ) {

        } 

        if(tf_opt_get_option('wd_post_image') === false || tf_opt_get_option('wd_post_image') === 'on') {
            require_once( __DIR__ . '/widgets/widget-post-image.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFPostImage_Widget_Free() );
        } elseif (tf_opt_get_option('wd_post_image') !== 'on' ) {

        } 

        
        if(tf_opt_get_option('wd_post_title') === false || tf_opt_get_option('wd_post_title') === 'on') {
            require_once( __DIR__ . '/widgets/widget-post-title.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFPostTitle_Widget_Free() );  
        } elseif (tf_opt_get_option('wd_post_title') !== 'on' ) {

        } 

        if(tf_opt_get_option('wd_post_excerpt') === false || tf_opt_get_option('wd_post_excerpt') === 'on') {
            require_once( __DIR__ . '/widgets/widget-post-excerpt.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFPostExcerpt_Widget_Free() );
        } elseif (tf_opt_get_option('wd_post_excerpt') !== 'on' ) {

        } 

        if(tf_opt_get_option('wd_post_content') === false || tf_opt_get_option('wd_post_content') === 'on') {
            require_once( __DIR__ . '/widgets/widget-post-content.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFPostContent_Widget_Free() );
        } elseif (tf_opt_get_option('wd_post_content') !== 'on' ) {

        } 

        if(tf_opt_get_option('wd_author_box') === false || tf_opt_get_option('wd_author_box') === 'on') {
            require_once( __DIR__ . '/widgets/widget-post-author-box.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFPostAuthorBox_Widget_Free() );
        } elseif (tf_opt_get_option('wd_author_box') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_post_comment') === false || tf_opt_get_option('wd_post_comment') === 'on') {
            require_once( __DIR__ . '/widgets/widget-post-comment.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFPostComment_Widget_Free() );
        } elseif (tf_opt_get_option('wd_post_comment') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_post_info') === false || tf_opt_get_option('wd_post_info') === 'on') {
            require_once( __DIR__ . '/widgets/widget-post-info.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFPostInfo_Widget_Free() );
        } elseif (tf_opt_get_option('wd_post_info') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_post_navigation') === false || tf_opt_get_option('wd_post_navigation') === 'on') {
            require_once( __DIR__ . '/widgets/widget-post-navigation.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFPostNavigation_Widget_Free() );
        } elseif (tf_opt_get_option('wd_post_navigation') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_slider_swiper') === false || tf_opt_get_option('wd_slider_swiper') === 'on') {
            require_once( __DIR__ . '/widgets/widget-slide-swiper.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFSlideSwiper_Widget_Free() );
        } elseif (tf_opt_get_option('wd_slider_swiper') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_animated_headline') === false || tf_opt_get_option('wd_animated_headline') === 'on') {
            require_once( __DIR__ . '/widgets/widget-animated-headline.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFAnimated_Headline_Widget_Free() );
        } elseif (tf_opt_get_option('wd_animated_headline') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_team') === false || tf_opt_get_option('wd_team') === 'on') {
            require_once( __DIR__ . '/widgets/widget-team.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFTeam_Widget_Free() ); 
        } elseif (tf_opt_get_option('wd_team') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_icon_box') === false || tf_opt_get_option('wd_icon_box') === 'on') {
            require_once( __DIR__ . '/widgets/widget-iconbox.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFIconBox_Widget_Free() );
        } elseif (tf_opt_get_option('wd_icon_box') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_testimonial_carousel') === false || tf_opt_get_option('wd_testimonial_carousel') === 'on') {
            require_once( __DIR__ . '/widgets/widget-testimonial-carousel.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFTestimonialCarousel_Widget_Free() );
        } elseif (tf_opt_get_option('wd_testimonial_carousel') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_counter') === false || tf_opt_get_option('wd_counter') === 'on') {
            require_once( __DIR__ . '/widgets/widget-counter.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFCounter_Widget_Free() );
        } elseif (tf_opt_get_option('wd_counter') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_slider_before_after') === false || tf_opt_get_option('wd_slider_before_after') === 'on') {
            require_once( __DIR__ . '/widgets/widget-sliderbeforeafter.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFSliderBeforeAfter_Widget_Free() );
        } elseif (tf_opt_get_option('wd_slider_before_after') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_clipping_mask') === false || tf_opt_get_option('wd_clipping_mask') === 'on') {
            require_once( __DIR__ . '/widgets/widget-clipping-mask.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFClipping_Mask_Widget_Free() );
        } elseif (tf_opt_get_option('wd_clipping_mask') !== 'on' ) {

        }
        
        if(tf_opt_get_option('wd_price_table') === false || tf_opt_get_option('wd_price_table') === 'on') {
            require_once( __DIR__ . '/widgets/widget-pricetable.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFPriceTable_Widget_Free() );
        } elseif (tf_opt_get_option('wd_price_table') !== 'on' ) {

        }
       
        if(tf_opt_get_option('wd_accordion') === false || tf_opt_get_option('wd_accordion') === 'on') {
            require_once( __DIR__ . '/widgets/widget-accordion.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFAccordion_Widget_Free() );
        } elseif (tf_opt_get_option('wd_accordion') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_progress_bar') === false || tf_opt_get_option('wd_progress_bar') === 'on') {
            require_once( __DIR__ . '/widgets/widget-progress-bar.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFProgressBars_Widget_Free() );
        } elseif (tf_opt_get_option('wd_progress_bar') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_countdown') === false || tf_opt_get_option('wd_countdown') === 'on') {
            require_once( __DIR__ . '/widgets/widget-countdown.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFCountdown_Widget_Free() );
        } elseif (tf_opt_get_option('wd_countdown') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_pie_chart') === false || tf_opt_get_option('wd_pie_chart') === 'on') {
            require_once( __DIR__ . '/widgets/widget-piechart.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFPieChart_Widget_Free() );
        } elseif (tf_opt_get_option('wd_pie_chart') !== 'on' ) {

        }


        if(tf_opt_get_option('wd_google_maps') === false || tf_opt_get_option('wd_google_maps') === 'on') {
            require_once( __DIR__ . '/widgets/widget-google-maps.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TF_Google_Maps_Widget_Free() );
        } elseif (tf_opt_get_option('wd_google_maps') !== 'on' ) {

        }
       
        
        if(tf_opt_get_option('wd_group_images') === false || tf_opt_get_option('wd_group_images') === 'on') {
            require_once( __DIR__ . '/widgets/widget-tfgroupimage.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TF_Group_Image_Widget_Free() );
        } elseif (tf_opt_get_option('wd_group_images') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_animation_item') === false || tf_opt_get_option('wd_animation_item') === 'on') {
            require_once( __DIR__ . '/widgets/widget-animation-item.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFAnimationitem_Widget_Free() );
        } elseif (tf_opt_get_option('wd_animation_item') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_partner') === false || tf_opt_get_option('wd_partner') === 'on') {
            require_once( __DIR__ . '/widgets/widget-list-image.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TFListImage_Widget_Free() ); 
        } elseif (tf_opt_get_option('wd_partner') !== 'on' ) {

        }

        if(tf_opt_get_option('wd_video') === false || tf_opt_get_option('wd_video') === 'on') {
            require_once( __DIR__ . '/widgets/widget-video.php' );
            \Elementor\Plugin::instance()->widgets_manager->register( new \TF_Addon_Video_Widget_Free() );
        } elseif (tf_opt_get_option('wd_video') !== 'on' ) {

        }
       

        
        if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            if(tf_opt_get_option('wd_woo_product_grid') === false || tf_opt_get_option('wd_woo_product_grid') === 'on') {
                require_once( __DIR__ . '/widgets/widget-woo-product-grid.php' );
                \Elementor\Plugin::instance()->widgets_manager->register( new \TFWooProductGrid_Widget_Free() );
            } elseif (tf_opt_get_option('wd_woo_product_grid') !== 'on' ) {
    
            }
            
            if(tf_opt_get_option('wd_woo_mini_cart') === false || tf_opt_get_option('wd_woo_mini_cart') === 'on') {
                require_once( __DIR__ . '/widgets/widget-mini-cart.php' );
                \Elementor\Plugin::instance()->widgets_manager->register( new \TFMiniCart_Widget_Free() );
            } elseif (tf_opt_get_option('wd_woo_mini_cart') !== 'on' ) {
    
            }
           
        }
        if ( class_exists( 'YITH_WCWL' ) ) {

            // if(tf_opt_get_option('wd_woo_wishlist_count') === false || tf_opt_get_option('wd_woo_wishlist_count') === 'on') {
            //     require_once( __DIR__ . '/widgets/widget-wishlist-count.php' );
            //     \Elementor\Plugin::instance()->widgets_manager->register( new \TFWishlistCount_Widget_Free() );
            // } elseif (tf_opt_get_option('wd_woo_wishlist_count') !== 'on' ) {
    
            // }
            
        }
    }

    public function init_controls() {}    

    public function widget_styles() {
        if ( did_action( 'elementor/loaded' ) ) {
            wp_register_style('tf-font-awesome', ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css', __FILE__);
            wp_register_style('tf-regular', ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/regular.min.css', __FILE__);
            wp_enqueue_style( 'tf-font-awesome' );
            wp_enqueue_style( 'tf-regular' );
        }    
        
        // Header footer
        wp_register_style( 'tf-header-footer', plugins_url( '/assets/css/tf-header-footer.css', __FILE__ ) );
        wp_enqueue_style( 'tf-header-footer' );

        // 
        wp_register_style( 'slide-vegas', plugins_url( '/assets/css/vegas.css', __FILE__ ) );
        
        // 
        wp_register_style( 'slide-ytplayer', plugins_url( '/assets/css/ytplayer.css', __FILE__ ) );

        // flex-slider (E Slider)
        wp_register_style( 'tf-flexslider', plugins_url( '/assets/css/tf-flexslider.css', __FILE__ ) );
        wp_register_style( 'tf-flex-slider', plugins_url( '/assets/css/tf-flex-slider.css', __FILE__ ) );

        // 
        wp_register_style( 'slide-animate', plugins_url( '/assets/css/animate.css', __FILE__ ) );

        // owl carousel min css
        wp_register_style( 'owl-carousel', plugins_url( '/assets/css/owl.carousel.css', __FILE__ ) );

        // counter
        wp_register_style( 'tf-counter', plugins_url( '/assets/css/tf-counter.css', __FILE__ ) );

        // 
        wp_register_style( 'tf-beforeafter', plugins_url( '/assets/css/sliderbeforeafter.css', __FILE__ ) );

        // price table
        wp_register_style( 'tf-price-table', plugins_url( '/assets/css/tf-price-table.css', __FILE__ ) );

        // accordion
        wp_register_style( 'tf-accordion', plugins_url( '/assets/css/tf-accordion.css', __FILE__ ) );

        // progess bar
        wp_register_style( 'tf-progress-bar', plugins_url( '/assets/css/tf-progress-bar.css', __FILE__ ) );

        // count down
        wp_register_style( 'tf-countdown', plugins_url( '/assets/css/tf-countdown.css', __FILE__ ) );

        // piechart
        wp_register_style( 'tf-piechart', plugins_url( '/assets/css/tf-piechart.css', __FILE__ ) );

        // swiper min css
        wp_register_style( 'tf-swiper', plugins_url( '/assets/css/swiper.min.css', __FILE__ ) );

        // partner
        wp_register_style( 'tf-list-image', plugins_url( '/assets/css/tf-list-image.css', __FILE__ ) );

        //  group image
        wp_register_style( 'tf-animation-item', plugins_url( '/assets/css/tf-animation-item.css', __FILE__ ) );     

        // video
        wp_register_style( 'tf-video', plugins_url( '/assets/css/tf-video.css', __FILE__ ) );

        // 3dr
        wp_register_style( 'magnific-popup', plugins_url( '/assets/css/magnific.popup.css', __FILE__ ) );

        // animated-headline
        wp_register_style( 'tf-animated-headline', plugins_url( '/assets/css/tf-animated-headline.css', __FILE__ ) );

        // carousel
        wp_register_style( 'tf-carousel', plugins_url( '/assets/css/tf-carousel.css', __FILE__ ) );

        // clipping-mask
        wp_register_style( 'tf-clipping-mask', plugins_url( '/assets/css/tf-clipping-mask.css', __FILE__ ) );

        // iconbox
        wp_register_style( 'tf-iconbox', plugins_url( '/assets/css/tf-iconbox.css', __FILE__ ) );

         // iconbox
         wp_register_style( 'tf-imagebox', plugins_url( '/assets/css/tf-imagebox.css', __FILE__ ) );

        // minicart
        wp_register_style( 'tf-woo-product-minicart', plugins_url( '/assets/css/tf-woo-product-minicart.css', __FILE__ ) );

        // navmenu
        wp_register_style( 'tf-navmenu', plugins_url( '/assets/css/tf-navmenu.css', __FILE__ ) );

        // author box
        wp_register_style( 'tf-author-box', plugins_url( '/assets/css/tf-author-box.css', __FILE__ ) );

        // post comment
        wp_register_style( 'tf-post-comment', plugins_url( '/assets/css/tf-post-comment.css', __FILE__ ) );
        
        // post infor 
        wp_register_style( 'tf-post-infor', plugins_url( '/assets/css/tf-post-infor.css', __FILE__ ) );

        // post navigation
        wp_register_style( 'tf-post-navi', plugins_url( '/assets/css/tf-post-navi.css', __FILE__ ) );  
        
        // post
        wp_register_style( 'tf-post', plugins_url( '/assets/css/tf-post.css', __FILE__ ) );  
        
        // preload
        wp_register_style( 'tf-preload', plugins_url( '/assets/css/tf-preload.css', __FILE__ ) );  

        // scroll top
        wp_register_style( 'tf-scroll-top', plugins_url( '/assets/css/tf-scroll-top.css', __FILE__ ) );  

        // search
        wp_register_style( 'tf-search', plugins_url( '/assets/css/tf-search.css', __FILE__ ) );  

        // simple slider
        wp_register_style( 'tf-simple-slider', plugins_url( '/assets/css/tf-simple-slider.css', __FILE__ ) );
        
        // slide swiper
        wp_register_style( 'tf-slide-swiper', plugins_url( '/assets/css/tf-slide-swiper.css', __FILE__ ) );
        
        // tab
        wp_register_style( 'tf-tab', plugins_url( '/assets/css/tf-tab.css', __FILE__ ) );  
       
        // team
        wp_register_style( 'tf-team', plugins_url( '/assets/css/tf-team.css', __FILE__ ) );  

        // testimonial
        wp_register_style( 'tf-testimonial', plugins_url( '/assets/css/tf-testimonial.css', __FILE__ ) );  

        // woo product
        wp_register_style( 'tf-woo-product', plugins_url( '/assets/css/tf-woo-product.css', __FILE__ ) );  
        
        // woo wishlist
        wp_register_style( 'tf-woo-wishlist', plugins_url( '/assets/css/tf-woo-wishlist.css', __FILE__ ) );  
        
    }

    public function widget_scripts() {
        wp_enqueue_script('jquery');
  
        //3rd Plugin
        wp_register_script( 'owl-carousel', plugins_url( '/assets/js/owl.carousel.min.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'imagesloaded-pkgd', plugins_url( '/assets/js/imagesloaded.pkgd.min.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'jquery-isotope', plugins_url( '/assets/js/jquery.isotope.min.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'jquery-easing', plugins_url( '/assets/js/jquery.easing.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'slide-vegas', plugins_url( '/assets/js/vegas.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'slide-ytplayer', plugins_url( '/assets/js/ytplayer.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'slide-typed', plugins_url( '/assets/js/typed.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_enqueue_script('tf-swiper', plugins_url( '/assets/js/swiper.min.js', __FILE__ ), [ 'jquery' ], false, true );
        // flex-slider (E Slider)
        wp_register_script( 'tf-flexslider', plugins_url( '/assets/js/jquery.flexslider-min.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'tf-flex-slider', plugins_url( '/assets/js/tf-flexslider.js', __FILE__ ), [ 'jquery' ], false, true );
        
        // hook animation 
        wp_register_script( 'tf-anime', plugins_url( '/assets/js/anime.min.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_enqueue_script( 'tf-anime' );
        wp_register_script( 'textanimation', plugins_url( '/assets/js/textanimation.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_enqueue_script( 'textanimation' );

        // testimonial
        wp_register_script( 'tf-testimonial', plugins_url( '/assets/js/tf-testimonial.js', __FILE__ ), [ 'jquery' ], false, true );

        // counter
        wp_register_script( 'tf-counter', plugins_url( '/assets/js/tf-counter.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'tf-counter-widget', plugins_url( '/assets/js/tf-counter-widget.js', __FILE__ ), [ 'jquery' ], false, true );
        
        // slider before after
        wp_register_script( 'tf-jquery_event_move', plugins_url( '/assets/js/jquery_event_move.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'tf-sliderbeforeafter', plugins_url( '/assets/js/sliderbeforeafter.js', __FILE__ ), [ 'jquery' ], false, true );

        // accordion
        wp_register_script( 'tf-accordion', plugins_url( '/assets/js/tf-accordion.js', __FILE__ ), [ 'jquery' ], false, true );

       //3rd Plugin support progresbar
        wp_register_script( 'appear', plugins_url( '/assets/js/appear.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'tf-progress-bar', plugins_url( '/assets/js/tf-progress-bar.js', __FILE__ ), [ 'jquery' ], false, true );

        // count down
        wp_register_script( '3rd-countdown', plugins_url( '/assets/js/countdown.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'tf-countdown', plugins_url( '/assets/js/tf-countdown.js', __FILE__ ), [ 'jquery' ], false, true );

        // piechart
        wp_register_script( '3rd-piechart', plugins_url( '/assets/js/piechart.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'tf-piechart', plugins_url( '/assets/js/tf-piechart.js', __FILE__ ), [ 'jquery' ], false, true );

        // manific popup min
        wp_register_script( 'magnific-popup', plugins_url( '/assets/js/magnific.popup.min.js', __FILE__ ), [ 'jquery' ], false, true );

        // group image
        wp_register_script( 'simple-parallax', plugins_url( '/assets/js/simple-parallax.min.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'parallax-image', plugins_url( '/assets/js/tf-group-image.js', __FILE__ ), [ 'jquery' ], false, true );
  

        // video
        wp_register_script( 'tf-video', plugins_url( '/assets/js/tf-video.js', __FILE__ ), [ 'jquery' ], false, true );

        // animated-headline
        wp_register_script( 'tf-animated-headline', plugins_url( '/assets/js/tf-animated-headline.js', __FILE__ ), [ 'jquery' ], false, true );

        // carousel
        wp_register_script( 'tf-carousel', plugins_url( '/assets/js/tf-carousel.js', __FILE__ ), [ 'jquery' ], false, true );

        // minicart
        wp_register_script( 'tf-woo-product-minicart', plugins_url( '/assets/js/tf-woo-product-minicart.js', __FILE__ ), [ 'jquery' ], false, true );

        // navmenu
        wp_register_script( 'tf-navmenu', plugins_url( '/assets/js/tf-navmenu.js', __FILE__ ), [ 'jquery' ], false, true );

        // post
        wp_register_script( 'tf-post', plugins_url( '/assets/js/tf-post.js', __FILE__ ), [ 'jquery' ], false, true );
        
        // preload
        wp_register_script( 'tf-preload', plugins_url( '/assets/js/tf-preload.js', __FILE__ ), [ 'jquery' ], false, true );
        
        // scroll top
        wp_register_script( 'tf-scroll-top', plugins_url( '/assets/js/tf-scroll-top.js', __FILE__ ), [ 'jquery' ], false, true );

        // search
        wp_register_script( 'tf-search', plugins_url( '/assets/js/tf-search.js', __FILE__ ), [ 'jquery' ], false, true );

        // simple slider
        wp_register_script( 'tf-simple-slider', plugins_url( '/assets/js/tf-simple-slider.js', __FILE__ ), [ 'jquery' ], false, true );

        // slide swiper
        wp_register_script( 'tf-slide-swiper', plugins_url( '/assets/js/tf-slide-swiper.js', __FILE__ ), [ 'jquery' ], false, true );

        // tab
        wp_register_script( 'tf-tab', plugins_url( '/assets/js/tf-tab.js', __FILE__ ), [ 'jquery' ], false, true );

        // woo product 
        wp_register_script( 'tf-woo-product', plugins_url( '/assets/js/tf-woo-product.js', __FILE__ ), [ 'jquery' ], false, true );
                
    }

    public function admin_scripts() {
        wp_enqueue_style( 'tf-select2', plugins_url( '/assets/css/admin/select2.css', __FILE__ ) );
        
        wp_enqueue_style( 'tf-admin', plugins_url( '/assets/css/admin/admin.css', __FILE__ ) );
     
        wp_enqueue_script( 'tf-select2', plugins_url( '/assets/js/admin/select2.js', __FILE__ ), [ 'jquery' ], false, true );
   
        wp_enqueue_script( 'tf-admin', plugins_url( '/assets/js/admin/admin.js', __FILE__ ), [ 'jquery' ], false, true );
       
        wp_enqueue_script( 'tf-admin-rule', plugins_url( '/assets/js/admin/admin-rule.js', __FILE__ ), [ 'jquery' ], false, true );
   
        $tfhf_localize_vars = array(
            'ajaxurl' => TFHF_AJAX_URL_FREE,
            'search'        => esc_html__( 'Search pages / post / categories', 'themesflat-addons-for-elementor' ),
            'ajax_nonce'    => wp_create_nonce( 'tfhf-get-posts-by-query' ),
        );
        wp_localize_script( 'tf-admin-rule', 'tfhf_localize_vars', $tfhf_localize_vars );        
    }

    static function tf_get_template_elementor($type = null) {
        $args = [
            'post_type' => 'elementor_library',
            'posts_per_page' => -1,
        ];
        if ($type) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'elementor_library_type',
                    'field' => 'slug',
                    'terms' => $type,
                ],
            ];
        }
        $template = get_posts($args);
        $tpl = array();
        if (!empty($template) && !is_wp_error($template)) {
            foreach ($template as $post) {
                $tpl[$post->post_name] = $post->post_title;
            }
        }
        return $tpl;
    }  

    /* Post type header footer */
    public function tf_header_footer_post_type() {
        $labels = array(
            'name'                  => esc_html__( 'TF Header - Footer Template', 'themesflat-addons-for-elementor' ),
            'singular_name'         => esc_html__( 'TF Header - Footer Template', 'themesflat-addons-for-elementor' ),
            'rewrite'               => array( 'slug' => esc_html__( 'TF Header - Footer Template' ) ),
            'menu_name'             => esc_html__( 'TF Header - Footer Template', 'themesflat-addons-for-elementor' ),
            'add_new'               => esc_html__( 'Add New', 'themesflat-addons-for-elementor' ),
            'add_new_item'          => esc_html__( 'Add New Template', 'themesflat-addons-for-elementor' ),
            'new_item'              => esc_html__( 'New Template Item', 'themesflat-addons-for-elementor' ),
            'edit_item'             => esc_html__( 'Edit Template Item', 'themesflat-addons-for-elementor' ),
            'view_item'             => esc_html__( 'View Template', 'themesflat-addons-for-elementor' ),
            'all_items'             => esc_html__( 'All Template', 'themesflat-addons-for-elementor' ),
            'search_items'          => esc_html__( 'Search Template', 'themesflat-addons-for-elementor' ),
            'not_found'             => esc_html__( 'No Template Items Found', 'themesflat-addons-for-elementor' ),
            'not_found_in_trash'    => esc_html__( 'No Template Items Found In Trash', 'themesflat-addons-for-elementor' ),
            'parent_item_colon'     => esc_html__( 'Parent Template:', 'themesflat-addons-for-elementor' ),
            'not_found'             => esc_html__( 'No Template found', 'themesflat-addons-for-elementor' ),
            'not_found_in_trash'    => esc_html__( 'No Template found in Trash', 'themesflat-addons-for-elementor' )

        );
        $args = array(
            'labels'      => $labels,
            'supports'    => array( 'title', 'thumbnail', 'elementor' ),
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => array('slug' => get_theme_mod('tf_header_footer_slug','tf_header_footer')),
            'menu_icon'   => 'dashicons-admin-page',
        );
        register_post_type( 'tf_header_footer', $args );

        flush_rewrite_rules();
    }

    public function tf_header_footer_register_metabox() {
        add_meta_box(
            'tfhf-meta-box',
            esc_html__( 'TF Header Or Footer Options', 'themesflat-addons-for-elementor' ), 
            [ $this, 'tf_header_footer_metabox_render'], 
            'tf_header_footer', 'normal', 'high' );
    }   

    public function tf_header_footer_metabox_render( $post ) {
        $values            = get_post_custom( $post->ID );
        $template_type     = isset( $values['tfhf_template_type'] ) ? esc_attr( $values['tfhf_template_type'][0] ) : '';
        wp_nonce_field( 'tfhf_meta_nounce', 'tfhf_meta_nounce' );
        ?>
        <table class="tfhf-options-table widefat">
            <tbody>
                <tr class="tfhf-options-row type-of-template">
                    <td class="tfhf-options-row-heading">
                        <label for="tfhf_template_type"><?php esc_html_e( 'Type of Template', 'themesflat-addons-for-elementor' ); ?></label>
                    </td>
                    <td class="tfhf-options-row-content">
                        <select name="tfhf_template_type" id="tfhf_template_type">
                            <option value="" <?php selected( $template_type, '' ); ?>><?php esc_html_e( 'Select Option', 'themesflat-addons-for-elementor' ); ?></option>
                            <option value="type_header" <?php selected( $template_type, 'type_header' ); ?>><?php esc_html_e( 'Header', 'themesflat-addons-for-elementor' ); ?></option>
                            <option value="type_footer" <?php selected( $template_type, 'type_footer' ); ?>><?php esc_html_e( 'Footer', 'themesflat-addons-for-elementor' ); ?></option>
                        </select>
                    </td>
                </tr>

                <?php $this->tf_header_footer_metabox_rule(); ?>
            </tbody>
        </table>
        <?php
    }

    public function tf_header_footer_metabox_rule() {  
        $include_locations = get_post_meta( get_the_id(), 'tfhf_template_include_locations', true );
        $exclude_locations = get_post_meta( get_the_id(), 'tfhf_template_exclude_locations', true );
        ?>
        <tr class="tfhf-target-rules-row tfhf-options-row">
            <td class="tfhf-target-rules-row-heading tfhf-options-row-heading">
                <label><?php esc_html_e( 'Display On', 'themesflat-addons-for-elementor' ); ?></label>
            </td>
            <td class="tfhf-target-rules-row-content tfhf-options-row-content">
                <?php
                self::target_rule_settings_field(
                    'tfhf-target-rules-location',
                    [
                        'title'          => esc_html__( 'Display Rules', 'themesflat-addons-for-elementor' ),
                        'value'          => '[{"type":"basic-global","specific":null}]',
                        'tags'           => 'site,enable,target,pages',
                        'rule_type'      => 'display',
                        'add_rule_label' => esc_html__( 'Add Display Rule Group', 'themesflat-addons-for-elementor' ),
                    ],
                    $include_locations
                );
                ?>
            </td>
        </tr>
        <tr class="tfhf-target-rules-row tfhf-options-row">
            <td class="tfhf-target-rules-row-heading tfhf-options-row-heading">
                <label><?php esc_html_e( 'Do Not Display On', 'themesflat-addons-for-elementor' ); ?></label>
            </td>
            <td class="tfhf-target-rules-row-content tfhf-options-row-content">
                <?php
                self::target_rule_settings_field(
                    'tfhf-target-rules-exclusion',
                    [
                        'title'          => esc_html__( 'Exclude On', 'themesflat-addons-for-elementor' ),
                        'value'          => '[]',
                        'tags'           => 'site,enable,target,pages',
                        'add_rule_label' => esc_html__( 'Add Exclusion Rule Group', 'themesflat-addons-for-elementor' ),
                        'rule_type'      => 'exclude',
                    ],
                    $exclude_locations
                );
                ?>
            </td>
        </tr> 
        <?php
    } 

    public function tf_header_footer_save_meta( $post_id ) {

        if ( isset( $_POST['tfhf_template_type'] ) ) {
            update_post_meta( $post_id, 'tfhf_template_type', esc_attr( $_POST['tfhf_template_type'] ) );
        }

        if ( ! isset( $_POST['tfhf_meta_nounce'] ) || ! wp_verify_nonce( $_POST['tfhf_meta_nounce'], 'tfhf_meta_nounce' ) ) {
            return;
        }
        
        if ( ! current_user_can( 'edit_posts' ) ) {
            return;
        }
        $target_locations = self::get_format_rule_value( $_POST, 'tfhf-target-rules-location' );
        update_post_meta( $post_id, 'tfhf_template_include_locations', $target_locations );
        $target_exclusion = self::get_format_rule_value( $_POST, 'tfhf-target-rules-exclusion' );        
        update_post_meta( $post_id, 'tfhf_template_exclude_locations', $target_exclusion );

        return false;
    }

    // public function tf_header_footer_save_meta( $post_id ) {
    //     if ( 'order' === get_post_type( $post_id ) && 'yes' === get_option( 'woocommerce_enable_hpos', 'no' ) ) {
    //         $order = wc_get_order( $post_id );
    //         if ( $order ) {
    //             if ( isset( $_POST['tfhf_template_type'] ) ) {
    //                 $order->update_meta_data( 'tfhf_template_type', esc_attr( $_POST['tfhf_template_type'] ) );
    //             }

    //             $target_locations = self::get_format_rule_value( $_POST, 'tfhf-target-rules-location' );
    //             $order->update_meta_data( 'tfhf_template_include_locations', $target_locations );

    //             $target_exclusion = self::get_format_rule_value( $_POST, 'tfhf-target-rules-exclusion' );
    //             $order->update_meta_data( 'tfhf_template_exclude_locations', $target_exclusion );

    //             $order->save();
    //         }
    //     } else {
    //         if ( isset( $_POST['tfhf_template_type'] ) ) {
    //             update_post_meta( $post_id, 'tfhf_template_type', esc_attr( $_POST['tfhf_template_type'] ) );
    //         }

    //         if ( ! isset( $_POST['tfhf_meta_nounce'] ) || ! wp_verify_nonce( $_POST['tfhf_meta_nounce'], 'tfhf_meta_nounce' ) ) {
    //             return;
    //         }
            
    //         if ( ! current_user_can( 'edit_posts' ) ) {
    //             return;
    //         }

    //         $target_locations = self::get_format_rule_value( $_POST, 'tfhf-target-rules-location' );
    //         update_post_meta( $post_id, 'tfhf_template_include_locations', $target_locations );

    //         $target_exclusion = self::get_format_rule_value( $_POST, 'tfhf-target-rules-exclusion' );        
    //         update_post_meta( $post_id, 'tfhf_template_exclude_locations', $target_exclusion );
    //     }

    //     return false;
    // }


    public function tf_header_footer_load_canvas_template( $single_template ) {
        global $post;

        if ( 'tf_header_footer' == $post->post_type ) {
            $elementor_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

            if ( file_exists( $elementor_canvas ) ) {
                return $elementor_canvas;
            } else {
                return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
            }
        }

        return $single_template;
    }    

    public static function tf_get_header_id() {
        $header_id = self::get_template_id( 'type_header' );

        if ( '' === $header_id ) {
            $header_id = false;
        }

        return apply_filters( 'tf_get_header_id', $header_id );
    }

    public static function tf_get_footer_id() {
        $footer_id = self::get_template_id( 'type_footer' );

        if ( '' === $footer_id ) {
            $footer_id = false;
        }

        return apply_filters( 'tf_get_footer_id', $footer_id );
    }

    public static function get_template_id( $type ) {
        $option = [
            'location'  => 'tfhf_template_include_locations',
            'exclusion' => 'tfhf_template_exclude_locations',
        ];

        $tfhf_templates = ThemesFlat_Addon_For_Elementor_Free::instance()->get_posts_by_conditions( 'tf_header_footer', $option );

        foreach ( $tfhf_templates as $template ) {
            if ( get_post_meta( absint( $template['id'] ), 'tfhf_template_type', true ) === $type ) {
                return $template['id'];
            }
        }

        return '';
        
    }

    public static function get_settings( $setting = '', $default = '' ) {
        if ( 'type_header' == $setting || 'type_footer' == $setting ) {
            $templates = self::get_template_id( $setting );
            $template = ! is_array( $templates ) ? $templates : $templates[0];
            return $template;
        }
    }

    public function hooks() {
        if ( tf_header_enabled() ) { 
            add_action( 'get_header', [ $this, 'tf_override_header' ] ); 
            add_action( 'tf_header', [ $this, 'tf_render_header' ] );             
        }

        if ( tf_footer_enabled() ) {
            add_action( 'get_footer', [ $this, 'tf_override_footer' ] ); 
            add_action( 'tf_footer', [ $this, 'tf_render_footer' ] ); 
        }
    }  

    public function tf_override_header() {
        require_once plugin_dir_path( __FILE__ ).'tf-header.php';
        $templates   = [];
        $templates[] = 'header.php';
        remove_all_actions( 'wp_head' );
        ob_start();
        locate_template( $templates, true );
        ob_get_clean();
    }

    public function tf_override_footer() {
        require_once plugin_dir_path( __FILE__ ).'tf-footer.php';
        $templates   = [];
        $templates[] = 'footer.php';
        remove_all_actions( 'wp_footer' );
        ob_start();
        locate_template( $templates, true );
        ob_get_clean();
    }

    public static function get_header_content() {
        $tf_get_header_id = self::tf_get_header_id();
        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tf_get_header_id);
    }

    public static function get_footer_content() {
        $tf_get_footer_id = self::tf_get_footer_id();
        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tf_get_footer_id);
    }

    public function tf_render_header() {
        ?>        
        <header class="site-header tf-custom-header" role="banner"> 
            <div class="tf-container"> 
                <div class="tf-row">
                    <div class="tf-col">              
                    <?php echo self::get_header_content(); ?>
                    </div>
                </div>
            </div>
        </header>
        <?php
    }

    public function tf_render_footer() {
        ?>
        <footer class="site-footer tf-custom-footer" role="contentinfo">
            <div class="tf-container"> 
                <div class="tf-row">
                    <div class="tf-col">                
                    <?php echo self::get_footer_content(); ?>
                    </div>
                </div>
            </div>
        </footer>
        <?php
    } 

    /*========================================= 
    post 
    ======================================== */
        // static function tf_get_post_types() {
        //     $post_type_args = [
        //         'show_in_nav_menus' => true,
        //     ];
        //     $post_types = get_post_types($post_type_args, 'objects');

        //     foreach ( $post_types as $post_type ) {
        //         $post_type_name[$post_type->name] = $post_type->label;      
        //     }
        //     return $post_type_name;
        // }

        // static function tf_get_taxonomies( $category = 'category' ){
        //     $category_posts = get_terms( 
        //         array(
        //             'taxonomy' => $category,
        //         )
        //     );
            
        //     foreach ( $category_posts as $category_post ) {
        //         $category_posts_name[$category_post->slug] = $category_post->name;      
        //     }
        //     return $category_posts_name;
        // }  

    /*========================================= 
    post 
    ======================================== */
    static function tf_get_post_types() {
        $post_type_args = [
            'show_in_nav_menus' => true,
        ];
        $post_types = get_post_types($post_type_args, 'objects');

        foreach ( $post_types as $post_type ) {
            $post_type_name[$post_type->name] = $post_type->label;      
        }
        return $post_type_name;
    }

    static function tf_get_taxonomies( $category = 'category' ){
        $category_posts_name = [];
        $category_posts = get_terms( 
            array(
                'taxonomy' => $category,
            )
        );            
        if (!empty($category_posts) ) {
            foreach ( $category_posts as $category_post ) {
                $category_posts_name[$category_post->slug] = $category_post->name;                 
            }
            
        }
        return $category_posts_name; 
    }  


   

    /*========================================= 
    Rule Template
    ======================================== */
        public function initialize_options() {
            self::$location_selection = self::get_location_selections();
        }

        public static function get_location_selections() {
            $args = array(
                'public'   => true,
                '_builtin' => true,
            );

            $post_types = get_post_types( $args, 'objects' );
            unset( $post_types['attachment'] );

            $args['_builtin'] = false;
            $custom_post_type = get_post_types( $args, 'objects' );

            $post_types = apply_filters( 'tfhf_location_rule_post_types', array_merge( $post_types, $custom_post_type ) );

            $special_pages = array(
                'special-404'    => esc_html__( '404 Page', 'themesflat-addons-for-elementor' ),
                'special-search' => esc_html__( 'Search Page', 'themesflat-addons-for-elementor' ),
                'special-blog'   => esc_html__( 'Blog / Posts Page', 'themesflat-addons-for-elementor' ),
                'special-front'  => esc_html__( 'Front Page', 'themesflat-addons-for-elementor' ),
                'special-date'   => esc_html__( 'Date Archive', 'themesflat-addons-for-elementor' ),
                'special-author' => esc_html__( 'Author Archive', 'themesflat-addons-for-elementor' ),
            );

            if ( class_exists( 'WooCommerce' ) ) {
                $special_pages['special-woo-shop'] = esc_html__( 'WooCommerce Shop Page', 'themesflat-addons-for-elementor' );
            }

            $selection_options = array(
                'basic'         => array(
                    'label' => esc_html__( 'Basic', 'themesflat-addons-for-elementor' ),
                    'value' => array(
                        'basic-global'    => esc_html__( 'Entire Website', 'themesflat-addons-for-elementor' ),
                        'basic-singulars' => esc_html__( 'All Singulars', 'themesflat-addons-for-elementor' ),
                        'basic-archives'  => esc_html__( 'All Archives', 'themesflat-addons-for-elementor' ),
                    ),
                ),

                'special-pages' => array(
                    'label' => esc_html__( 'Special Pages', 'themesflat-addons-for-elementor' ),
                    'value' => $special_pages,
                ),
            );

            $args = array(
                'public' => true,
            );

            $taxonomies = get_taxonomies( $args, 'objects' );

            if ( ! empty( $taxonomies ) ) {
                foreach ( $taxonomies as $taxonomy ) {

                    if ( 'post_format' == $taxonomy->name ) {
                        continue;
                    }

                    foreach ( $post_types as $post_type ) {
                        $post_opt = self::get_post_target_rule_options( $post_type, $taxonomy );

                        if ( isset( $selection_options[ $post_opt['post_key'] ] ) ) {
                            if ( ! empty( $post_opt['value'] ) && is_array( $post_opt['value'] ) ) {
                                foreach ( $post_opt['value'] as $key => $value ) {
                                    if ( ! in_array( $value, $selection_options[ $post_opt['post_key'] ]['value'] ) ) {
                                        $selection_options[ $post_opt['post_key'] ]['value'][ $key ] = $value;
                                    }
                                }
                            }
                        } else {
                            $selection_options[ $post_opt['post_key'] ] = array(
                                'label' => $post_opt['label'],
                                'value' => $post_opt['value'],
                            );
                        }
                    }
                }
            }

            $selection_options['specific-target'] = array(
                'label' => esc_html__( 'Specific Target', 'themesflat-addons-for-elementor' ),
                'value' => array(
                    'specifics' => esc_html__( 'Specific Pages / Posts / Taxonomies, etc.', 'themesflat-addons-for-elementor' ),
                ),
            );

            return apply_filters( 'tfhf_display_on_list', $selection_options );
        }

        public static function get_location_by_key( $key ) {
            if ( ! isset( self::$location_selection ) || empty( self::$location_selection ) ) {
                self::$location_selection = self::get_location_selections();
            }
            $location_selection = self::$location_selection;

            foreach ( $location_selection as $location_grp ) {
                if ( isset( $location_grp['value'][ $key ] ) ) {
                    return $location_grp['value'][ $key ];
                }
            }

            if ( strpos( $key, 'post-' ) !== false ) {
                $post_id = (int) str_replace( 'post-', '', $key );
                return get_the_title( $post_id );
            }

            if ( strpos( $key, 'tax-' ) !== false ) {
                $tax_id = (int) str_replace( 'tax-', '', $key );
                $term   = get_term( $tax_id );

                if ( ! is_wp_error( $term ) ) {
                    $term_taxonomy = ucfirst( str_replace( '_', ' ', $term->taxonomy ) );
                    return $term->name . ' - ' . $term_taxonomy;
                } else {
                    return '';
                }
            }

            return $key;
        }

        public static function target_rule_settings_field( $name, $settings, $value ) {
            $input_name     = $name;
            $type           = isset( $settings['type'] ) ? $settings['type'] : 'target_rule';
            $class          = isset( $settings['class'] ) ? $settings['class'] : '';
            $rule_type      = isset( $settings['rule_type'] ) ? $settings['rule_type'] : 'target_rule';
            $add_rule_label = isset( $settings['add_rule_label'] ) ? $settings['add_rule_label'] : esc_html__( 'Add Rule', 'themesflat-addons-for-elementor' );
            $saved_values   = $value;
            $output         = '';

            if ( isset( self::$location_selection ) || empty( self::$location_selection ) ) {
                self::$location_selection = self::get_location_selections();
            }
            $selection_options = self::$location_selection;

            $output .= '<script type="text/html" id="tmpl-tfhf-target-rule-' . $rule_type . '-condition">';
            $output .= '<div class="tfhf-target-rule-condition tfhf-target-rule-{{data.id}}" data-rule="{{data.id}}" >';
            $output .= '<span class="target_rule-condition-delete dashicons dashicons-dismiss"></span>';

            $output .= '<div class="target_rule-condition-wrap" >';
            $output .= '<select name="' . esc_attr( $input_name ) . '[rule][{{data.id}}]" class="target_rule-condition form-control tfhf-input">';
            $output .= '<option value="">' . esc_html__( 'Select', 'themesflat-addons-for-elementor' ) . '</option>';

            foreach ( $selection_options as $group => $group_data ) {
                $output .= '<optgroup label="' . $group_data['label'] . '">';
                foreach ( $group_data['value'] as $opt_key => $opt_value ) {
                    $output .= '<option value="' . $opt_key . '">' . $opt_value . '</option>';
                }
                $output .= '</optgroup>';
            }
            $output .= '</select>';
            $output .= '</div>';

            $output .= '</div>';

            $output .= '<div class="target_rule-specific-page-wrap" style="display:none">';
            $output .= '<select name="' . esc_attr( $input_name ) . '[specific][]" class="target-rule-select2 target_rule-specific-page form-control tfhf-input " multiple="multiple">';
            $output .= '</select>';
            $output .= '</div>';

            $output .= '</script>';

            $output .= '<div class="tfhf-target-rule-wrapper tfhf-target-rule-' . $rule_type . '-on-wrap" data-type="' . $rule_type . '">';
            $output .= '<div class="tfhf-target-rule-selector-wrapper tfhf-target-rule-' . $rule_type . '-on">';
            $output .= self::generate_target_rule_selector( $rule_type, $selection_options, $input_name, $saved_values, $add_rule_label );
            $output .= '</div>';

            $output .= '</div>';

            echo $output;
        }

        public static function get_post_target_rule_options( $post_type, $taxonomy ) {
            $post_key    = str_replace( ' ', '-', strtolower( $post_type->label ) );
            $post_label  = ucwords( $post_type->label );
            $post_name   = $post_type->name;
            $post_option = array();
            /* translators:All %s*/
            $all_posts                          = sprintf( esc_html__( 'All %s', 'themesflat-addons-for-elementor' ), $post_label );
            $post_option[ $post_name . '|all' ] = $all_posts;

            if ( 'pages' != $post_key ) {
                /* translators:All %s Archive*/
                $all_archive                                = sprintf( esc_html__( 'All %s Archive', 'themesflat-addons-for-elementor' ), $post_label );
                $post_option[ $post_name . '|all|archive' ] = $all_archive;
            }

            if ( in_array( $post_type->name, $taxonomy->object_type ) ) {
                $tax_label = ucwords( $taxonomy->label );
                $tax_name  = $taxonomy->name;
                /* translators:All %s Archive*/
                $tax_archive = sprintf( esc_html__( 'All %s Archive', 'themesflat-addons-for-elementor' ), $tax_label );

                $post_option[ $post_name . '|all|taxarchive|' . $tax_name ] = $tax_archive;
            }

            $post_output['post_key'] = $post_key;
            $post_output['label']    = $post_label;
            $post_output['value']    = $post_option;

            return $post_output;
        }

        public static function generate_target_rule_selector( $type, $selection_options, $input_name, $saved_values, $add_rule_label ) {
            $output = '<div class="target_rule-builder-wrap">';

            if ( ! is_array( $saved_values ) || ( is_array( $saved_values ) && empty( $saved_values ) ) ) {
                $saved_values                = array();
                $saved_values['rule'][0]     = '';
                $saved_values['specific'][0] = '';
            }

            $index = 0;
           
            foreach ( $saved_values['rule'] as $index => $data ) {            
                $output .= '<div class="tfhf-target-rule-condition tfhf-target-rule-' . $index . '" data-rule="' . $index . '" >';

                $output .= '<span class="target_rule-condition-delete dashicons dashicons-dismiss"></span>';
                $output .= '<div class="target_rule-condition-wrap" >';
                $output .= '<select name="' . esc_attr( $input_name ) . '[rule][' . $index . ']" class="target_rule-condition form-control tfhf-input">';
                $output .= '<option value="">' . esc_html__( 'Select', 'themesflat-addons-for-elementor' ) . '</option>';

                foreach ( $selection_options as $group => $group_data ) {                
                    $output .= '<optgroup label="' . $group_data['label'] . '">';
                    foreach ( $group_data['value'] as $opt_key => $opt_value ) {

                        $selected = '';
                        
                        if ( $data == $opt_key ) {
                            $selected = 'selected="selected"';
                        }

                        $output .= '<option value="' . $opt_key . '" ' . $selected . '>' . $opt_value . '</option>';
                    }
                    $output .= '</optgroup>';
                }
                $output .= '</select>';
                $output .= '</div>';

                $output .= '</div>';

                $output .= '<div class="target_rule-specific-page-wrap" style="display:none">';
                $output .= '<select name="' . esc_attr( $input_name ) . '[specific][]" class="target-rule-select2 target_rule-specific-page form-control tfhf-input " multiple="multiple">';

                if ( 'specifics' == $data && isset( $saved_values['specific'] ) && null != $saved_values['specific'] && is_array( $saved_values['specific'] ) ) {
                    foreach ( $saved_values['specific'] as $data_key => $sel_value ) {

                        if ( strpos( $sel_value, 'post-' ) !== false ) {
                            $post_id    = (int) str_replace( 'post-', '', $sel_value );
                            $post_title = get_the_title( $post_id );
                            $output    .= '<option value="post-' . $post_id . '" selected="selected" >' . $post_title . '</option>';
                        }

                        if ( strpos( $sel_value, 'tax-' ) !== false ) {
                            $tax_data = explode( '-', $sel_value );

                            $tax_id    = (int) str_replace( 'tax-', '', $sel_value );
                            $term      = get_term( $tax_id );
                            $term_name = '';

                            if ( ! is_wp_error( $term ) ) {
                                $term_taxonomy = ucfirst( str_replace( '_', ' ', $term->taxonomy ) );

                                if ( isset( $tax_data[2] ) && 'single' === $tax_data[2] ) {
                                    $term_name = 'All singulars from ' . $term->name;
                                } else {
                                    $term_name = $term->name . ' - ' . $term_taxonomy;
                                }
                            }

                            $output .= '<option value="' . $sel_value . '" selected="selected" >' . $term_name . '</option>';                        
                        }
                    }
                }
                $output .= '</select>';
                $output .= '</div>';
            }

            $output .= '</div>';

            $output .= '<div class="target_rule-add-rule-wrap">';
            $output .= '<a href="#" class="button" data-rule-id="' . absint( $index ) . '" data-rule-type="' . $type . '">' . $add_rule_label . '</a>';
            $output .= '</div>';

            if ( 'display' == $type ) {

                $output .= '<div class="target_rule-add-exclusion-rule">';
                $output .= '<a href="#" class="button">' . esc_html__( 'Add Exclusion Rule Group', 'themesflat-addons-for-elementor' ) . '</a>';
                $output .= '</div>';
            }

            return $output;
        }

        public static function get_format_rule_value( $save_data, $key ) {
            $meta_value = array();

            if ( isset( $save_data[ $key ]['rule'] ) ) {
                $save_data[ $key ]['rule'] = array_unique( $save_data[ $key ]['rule'] );
                if ( isset( $save_data[ $key ]['specific'] ) ) {
                    $save_data[ $key ]['specific'] = array_unique( $save_data[ $key ]['specific'] );
                }

                $index = array_search( '', $save_data[ $key ]['rule'] );
                if ( false !== $index ) {
                    unset( $save_data[ $key ]['rule'][ $index ] );
                }
                $index = array_search( 'specifics', $save_data[ $key ]['rule'] );
                if ( false !== $index ) {
                    unset( $save_data[ $key ]['rule'][ $index ] );

                    if ( isset( $save_data[ $key ]['specific'] ) && is_array( $save_data[ $key ]['specific'] ) ) {
                        array_push( $save_data[ $key ]['rule'], 'specifics' );
                    }
                }

                foreach ( $save_data[ $key ] as $meta_key => $value ) {
                    if ( ! empty( $value ) ) {
                        $meta_value[ $meta_key ] = array_map( 'esc_attr', $value );
                    }
                }
                if ( ! isset( $meta_value['rule'] ) || ! in_array( 'specifics', $meta_value['rule'] ) ) {
                    $meta_value['specific'] = array();
                }

                if ( empty( $meta_value['rule'] ) ) {
                    $meta_value = array();
                }
            }

            return $meta_value;
        }

        public function get_current_page_type() {
            if ( null === self::$current_page_type ) {
                $page_type  = '';
                $current_id = false;

                if ( is_404() ) {
                    $page_type = 'is_404';
                } elseif ( is_search() ) {
                    $page_type = 'is_search';
                } elseif ( is_archive() ) {
                    $page_type = 'is_archive';

                    if ( is_category() || is_tag() || is_tax() ) {
                        $page_type = 'is_tax';
                    } elseif ( is_date() ) {
                        $page_type = 'is_date';
                    } elseif ( is_author() ) {
                        $page_type = 'is_author';
                    } elseif ( function_exists( 'is_shop' ) && is_shop() ) {
                        $page_type = 'is_woo_shop_page';
                    }
                } elseif ( is_home() ) {
                    $page_type = 'is_home';
                } elseif ( is_front_page() ) {
                    $page_type  = 'is_front_page';
                    $current_id = get_the_id();
                } elseif ( is_singular() ) {
                    $page_type  = 'is_singular';
                    $current_id = get_the_id();
                } else {
                    $current_id = get_the_id();
                }

                self::$current_page_data['ID'] = $current_id;
                self::$current_page_type       = $page_type;
            }

            return self::$current_page_type;
        }

        public static function get_meta_option_post( $post_type, $option ) {
            $page_meta = ( isset( $option['page_meta'] ) && '' != $option['page_meta'] ) ? $option['page_meta'] : false;

            if ( false !== $page_meta ) {
                $current_post_id = isset( $option['current_post_id'] ) ? $option['current_post_id'] : false;
                $meta_id         = get_post_meta( $current_post_id, $option['page_meta'], true );

                if ( false !== $meta_id && '' != $meta_id ) {
                    self::$current_page_data[ $post_type ][ $meta_id ] = array(
                        'id'       => $meta_id,
                        'location' => '',
                    );

                    return self::$current_page_data[ $post_type ];
                }
            }

            return false;
        }

        function tfhf_get_posts_by_query() {

            check_ajax_referer( 'tfhf-get-posts-by-query', 'nonce' );

            $search_string = isset( $_POST['q'] ) ? sanitize_text_field( $_POST['q'] ) : '';
            $data          = array();
            $result        = array();

            $args = array(
                'public'   => true,
                '_builtin' => false,
            );

            $output     = 'names';
            $operator   = 'and';
            $post_types = get_post_types( $args, $output, $operator );

            unset( $post_types['tf_header_footer'] );

            $post_types['Posts'] = 'post';
            $post_types['Pages'] = 'page';

            foreach ( $post_types as $key => $post_type ) {
                $data = array();

                add_filter( 'posts_search', array( $this, 'search_only_titles' ), 10, 2 );

                $query = new \WP_Query(
                    array(
                        's'              => $search_string,
                        'post_type'      => $post_type,
                        'posts_per_page' => - 1,
                    )
                );

                if ( $query->have_posts() ) {
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $title  = get_the_title();
                        $title .= ( 0 != $query->post->post_parent ) ? ' (' . get_the_title( $query->post->post_parent ) . ')' : '';
                        $id     = get_the_id();
                        $data[] = array(
                            'id'   => 'post-' . $id,
                            'text' => $title,
                        );
                    }
                }

                if ( is_array( $data ) && ! empty( $data ) ) {
                    $result[] = array(
                        'text'     => $key,
                        'children' => $data,
                    );
                }
            }

            $data = array();

            wp_reset_postdata();

            $args = array(
                'public' => true,
            );

            $output     = 'objects';
            $operator   = 'and';
            $taxonomies = get_taxonomies( $args, $output, $operator );

            foreach ( $taxonomies as $taxonomy ) {
                $terms = get_terms(
                    $taxonomy->name,
                    array(
                        'orderby'    => 'count',
                        'hide_empty' => 0,
                        'name__like' => $search_string,
                    )
                );

                $data = array();

                $label = ucwords( $taxonomy->label );

                if ( ! empty( $terms ) ) {
                    foreach ( $terms as $term ) {
                        $term_taxonomy_name = ucfirst( str_replace( '_', ' ', $taxonomy->name ) );

                        $data[] = array(
                            'id'   => 'tax-' . $term->term_id,
                            'text' => $term->name . ' archive page',
                        );

                        $data[] = array(
                            'id'   => 'tax-' . $term->term_id . '-single-' . $taxonomy->name,
                            'text' => 'All singulars from ' . $term->name,
                        );
                    }
                }

                if ( is_array( $data ) && ! empty( $data ) ) {
                    $result[] = array(
                        'text'     => $label,
                        'children' => $data,
                    );
                }
            }

            wp_send_json( $result );
        }

        function search_only_titles( $search, $wp_query ) {
            if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
                global $wpdb;

                $q = $wp_query->query_vars;
                $n = ! empty( $q['exact'] ) ? '' : '%';

                $search = array();

                foreach ( (array) $q['search_terms'] as $term ) {
                    $search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );
                }

                if ( ! is_user_logged_in() ) {
                    $search[] = "$wpdb->posts.post_password = ''";
                }

                $search = ' AND ' . implode( ' AND ', $search );
            }

            return $search;
        }

        public function parse_layout_display_condition( $post_id, $rules ) {
            $display           = false;
            $current_post_type = get_post_type( $post_id );

            if ( isset( $rules['rule'] ) && is_array( $rules['rule'] ) && ! empty( $rules['rule'] ) ) {
                foreach ( $rules['rule'] as $key => $rule ) {
                    if ( strrpos( $rule, 'all' ) !== false ) {
                        $rule_case = 'all';
                    } else {
                        $rule_case = $rule;
                    }

                    switch ( $rule_case ) {
                        case 'basic-global':
                            $display = true;
                            break;

                        case 'basic-singulars':
                            if ( is_singular() ) {
                                $display = true;
                            }
                            break;

                        case 'basic-archives':
                            if ( is_archive() ) {
                                $display = true;
                            }
                            break;

                        case 'special-404':
                            if ( is_404() ) {
                                $display = true;
                            }
                            break;

                        case 'special-search':
                            if ( is_search() ) {
                                $display = true;
                            }
                            break;

                        case 'special-blog':
                            if ( is_home() ) {
                                $display = true;
                            }
                            break;

                        case 'special-front':
                            if ( is_front_page() ) {
                                $display = true;
                            }
                            break;

                        case 'special-date':
                            if ( is_date() ) {
                                $display = true;
                            }
                            break;

                        case 'special-author':
                            if ( is_author() ) {
                                $display = true;
                            }
                            break;

                        case 'special-woo-shop':
                            if ( function_exists( 'is_shop' ) && is_shop() ) {
                                $display = true;
                            }
                            break;

                        case 'all':
                            $rule_data = explode( '|', $rule );

                            $post_type     = isset( $rule_data[0] ) ? $rule_data[0] : false;
                            $archieve_type = isset( $rule_data[2] ) ? $rule_data[2] : false;
                            $taxonomy      = isset( $rule_data[3] ) ? $rule_data[3] : false;
                            if ( false === $archieve_type ) {
                                $current_post_type = get_post_type( $post_id );

                                if ( false !== $post_id && $current_post_type == $post_type ) {
                                    $display = true;
                                }
                            } else {
                                if ( is_archive() ) {
                                    $current_post_type = get_post_type();
                                    if ( $current_post_type == $post_type ) {
                                        if ( 'archive' == $archieve_type ) {
                                            $display = true;
                                        } elseif ( 'taxarchive' == $archieve_type ) {
                                            $obj              = get_queried_object();
                                            $current_taxonomy = '';
                                            if ( '' !== $obj && null !== $obj ) {
                                                $current_taxonomy = $obj->taxonomy;
                                            }

                                            if ( $current_taxonomy == $taxonomy ) {
                                                $display = true;
                                            }
                                        }
                                    }
                                }
                            }
                            break;

                        case 'specifics':
                            if ( isset( $rules['specific'] ) && is_array( $rules['specific'] ) ) {
                                foreach ( $rules['specific'] as $specific_page ) {
                                    $specific_data = explode( '-', $specific_page );

                                    $specific_post_type = isset( $specific_data[0] ) ? $specific_data[0] : false;
                                    $specific_post_id   = isset( $specific_data[1] ) ? $specific_data[1] : false;
                                    if ( 'post' == $specific_post_type ) {
                                        if ( $specific_post_id == $post_id ) {
                                            $display = true;
                                        }
                                    } elseif ( isset( $specific_data[2] ) && ( 'single' == $specific_data[2] ) && 'tax' == $specific_post_type ) {
                                        if ( is_singular() ) {
                                            $term_details = get_term( $specific_post_id );

                                            if ( isset( $term_details->taxonomy ) ) {
                                                $has_term = has_term( (int) $specific_post_id, $term_details->taxonomy, $post_id );

                                                if ( $has_term ) {
                                                    $display = true;
                                                }
                                            }
                                        }
                                    } elseif ( 'tax' == $specific_post_type ) {
                                        $tax_id = get_queried_object_id();
                                        if ( $specific_post_id == $tax_id ) {
                                            $display = true;
                                        }
                                    }
                                }
                            }
                            break;

                        default:
                            break;
                    }

                    if ( $display ) {
                        break;
                    }
                }
            }

            return $display;
        }

        public function get_posts_by_conditions( $post_type, $option ) {
            global $wpdb;
            global $post;

            $post_type = $post_type ? esc_sql( $post_type ) : esc_sql( $post->post_type );

            if ( is_array( self::$current_page_data ) && isset( self::$current_page_data[ $post_type ] ) ) {
                return apply_filters( 'tfhf_get_display_posts_by_conditions', self::$current_page_data[ $post_type ], $post_type );
            }

            $current_page_type = $this->get_current_page_type();

            self::$current_page_data[ $post_type ] = array();

            $option['current_post_id'] = self::$current_page_data['ID'];
            $meta_header               = self::get_meta_option_post( $post_type, $option );

            if ( false === $meta_header ) {
                $current_post_type = esc_sql( get_post_type() );
                $current_post_id   = false;
                $q_obj             = get_queried_object();

                $location = isset( $option['location'] ) ? esc_sql( $option['location'] ) : '';

                $query = "SELECT p.ID, pm.meta_value FROM {$wpdb->postmeta} as pm
                            INNER JOIN {$wpdb->posts} as p ON pm.post_id = p.ID
                            WHERE pm.meta_key = '{$location}'
                            AND p.post_type = '{$post_type}'
                            AND p.post_status = 'publish'";

                $orderby = ' ORDER BY p.post_date DESC';

                $meta_args = "pm.meta_value LIKE '%\"basic-global\"%'";

                switch ( $current_page_type ) {
                    case 'is_404':
                        $meta_args .= " OR pm.meta_value LIKE '%\"special-404\"%'";
                        break;
                    case 'is_search':
                        $meta_args .= " OR pm.meta_value LIKE '%\"special-search\"%'";
                        break;
                    case 'is_archive':
                    case 'is_tax':
                    case 'is_date':
                    case 'is_author':
                        $meta_args .= " OR pm.meta_value LIKE '%\"basic-archives\"%'";
                        $meta_args .= " OR pm.meta_value LIKE '%\"{$current_post_type}|all|archive\"%'";

                        if ( 'is_tax' == $current_page_type && ( is_category() || is_tag() || is_tax() ) ) {
                            if ( is_object( $q_obj ) ) {
                                $meta_args .= " OR pm.meta_value LIKE '%\"{$current_post_type}|all|taxarchive|{$q_obj->taxonomy}\"%'";
                                $meta_args .= " OR pm.meta_value LIKE '%\"tax-{$q_obj->term_id}\"%'";
                            }
                        } elseif ( 'is_date' == $current_page_type ) {
                            $meta_args .= " OR pm.meta_value LIKE '%\"special-date\"%'";
                        } elseif ( 'is_author' == $current_page_type ) {
                            $meta_args .= " OR pm.meta_value LIKE '%\"special-author\"%'";
                        }
                        break;
                    case 'is_home':
                        $meta_args .= " OR pm.meta_value LIKE '%\"special-blog\"%'";
                        break;
                    case 'is_front_page':
                        $current_id      = esc_sql( get_the_id() );
                        $current_post_id = $current_id;
                        $meta_args      .= " OR pm.meta_value LIKE '%\"special-front\"%'";
                        $meta_args      .= " OR pm.meta_value LIKE '%\"{$current_post_type}|all\"%'";
                        $meta_args      .= " OR pm.meta_value LIKE '%\"post-{$current_id}\"%'";
                        break;
                    case 'is_singular':
                        $current_id      = esc_sql( get_the_id() );
                        $current_post_id = $current_id;
                        $meta_args      .= " OR pm.meta_value LIKE '%\"basic-singulars\"%'";
                        $meta_args      .= " OR pm.meta_value LIKE '%\"{$current_post_type}|all\"%'";
                        $meta_args      .= " OR pm.meta_value LIKE '%\"post-{$current_id}\"%'";

                        $taxonomies = get_object_taxonomies( $q_obj->post_type );
                        $terms      = wp_get_post_terms( $q_obj->ID, $taxonomies );

                        foreach ( $terms as $term ) {
                            $meta_args .= " OR pm.meta_value LIKE '%\"tax-{$term->term_id}-single-{$term->taxonomy}\"%'";
                        }

                        break;
                    case 'is_woo_shop_page':
                        $meta_args .= " OR pm.meta_value LIKE '%\"special-woo-shop\"%'";
                        break;
                    case '':
                        $current_post_id = get_the_id();
                        break;
                }

                $posts  = $wpdb->get_results( "SELECT p.ID, pm.meta_value FROM {$wpdb->postmeta} as pm
                INNER JOIN {$wpdb->posts} as p ON pm.post_id = p.ID
                WHERE pm.meta_key = '{$location}'
                AND p.post_type = '{$post_type}'
                AND p.post_status = 'publish' " . ' AND (' . $meta_args . ')' . ' ORDER BY p.post_date DESC' );            

                foreach ( $posts as $local_post ) {
                    self::$current_page_data[ $post_type ][ $local_post->ID ] = array(
                        'id'       => $local_post->ID,
                        'location' => $local_post->meta_value,
                    );
                }

                $option['current_post_id'] = $current_post_id;

                $this->remove_exclusion_rule_posts( $post_type, $option );
            }

            return apply_filters( 'tfhf_get_display_posts_by_conditions', self::$current_page_data[ $post_type ], $post_type );
        }

        public function remove_exclusion_rule_posts( $post_type, $option ) {
            $exclusion       = isset( $option['exclusion'] ) ? $option['exclusion'] : '';
            $current_post_id = isset( $option['current_post_id'] ) ? $option['current_post_id'] : false;

            foreach ( self::$current_page_data[ $post_type ] as $c_post_id => $c_data ) {
                $exclusion_rules = get_post_meta( $c_post_id, $exclusion, true );
                $is_exclude      = $this->parse_layout_display_condition( $current_post_id, $exclusion_rules );

                if ( $is_exclude ) {
                    unset( self::$current_page_data[ $post_type ][ $c_post_id ] );
                }
            }
        }

    /*========================================= 
    WOO 
    ======================================== */
        static function tf_get_taxonomies_product( $category = 'product_cat' ){
            $category_posts = get_terms( array(
                'taxonomy' => $category,
                'hide_empty' => true,
            ));
            
            if (!empty($category_posts) ) {
                foreach ( $category_posts as $category_post ) {
                    $category_posts_name[$category_post->slug] = $category_post->name;                 
                }
                return $category_posts_name;
            }
            else return '';
        }

        static function themesflat_mini_cart_count(){ 
            if ( class_exists( 'woocommerce' ) ) {       
                if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 
                    if ( ! empty( WC()->cart ) ) {
                        $count = WC()->cart->cart_contents_count;
                        return $count;
                    }else {
                        $count = 0;
                        return $count;
                    }                
                }
            }
        } 
    

}
ThemesFlat_Addon_For_Elementor_Free::instance();