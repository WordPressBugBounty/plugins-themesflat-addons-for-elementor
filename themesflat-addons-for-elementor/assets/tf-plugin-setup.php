<?php

define('SETUP_PREFIX', 'tf_setup_');


class tf_plugin_setup {

	private $page_title = 'Themesflat Addons Setups';
	private $menu_title = 'Themesflat Addons Setups';
	private $menu_slug = 'tf-addon-setup';
	private $position = 70;
	private $settings_fields = 'tf-addon-setup';
	private $is_tab = 'horizontal'; // '' | vertical | horizontal
	private $arr_types = array('text', 'select', 'image', 'editor', 'color-picker', 'textarea', 'checkbox','checkbox_slider', 'checkbox_many', 'radio', 'slider');
	
	private $arr_section =
		array(
			array(
				'title' => 'Popular',
				'fields' => 
					array(	
						array(  'id' => 'wd_counter',
								'type' => 'checkbox_slider',
								'label' => 'TF Counter',
								'default' => '1'
						),		
								
						array(  'id' => 'wd_image_box',
								'type' => 'checkbox_slider',
								'label' => 'TF Image Box',
								'default' => '1'
						),
						array(  'id' => 'wd_icon_box',
								'type' => 'checkbox_slider',
								'label' => 'TF Icon Box',
								'default' => '1'
						),
						array(  'id' => 'wd_carousel',
								'type' => 'checkbox_slider',
								'label' => 'TF Carousel',
								'default' => '1'
						),
						array(  'id' => 'wd_navmenu',
								'type' => 'checkbox_slider',
								'label' => 'TF Nav Menu',
								'default' => '1'
						),
						array(  'id' => 'wd_tabs',
								'type' => 'checkbox_slider',
								'label' => 'TF Tabs',
								'default' => '1'
						),
						array(  'id' => 'wd_simple_slider',
								'type' => 'checkbox_slider',
								'label' => 'TF Simple Slider',
								'default' => '1'
						),
						array(  'id' => 'wd_e_slider',
								'type' => 'checkbox_slider',
								'label' => 'TF E Slider',
								'default' => '1'
						),
						array(  'id' => 'wd_scroll_top',
								'type' => 'checkbox_slider',
								'label' => 'TF Scroll Top',
								'default' => '0'
						),
						array(  'id' => 'wd_preload',
								'type' => 'checkbox_slider',
								'label' => 'TF Preload',
								'default' => '0'
						),						
						array(  'id' => 'wd_slider_swiper',
								'type' => 'checkbox_slider',
								'label' => 'TF Slide Swiper',
								'default' => '1'
						),
						array(  'id' => 'wd_animated_headline',
								'type' => 'checkbox_slider',
								'label' => 'TF Animated Headline',
								'default' => '1'
						),
						array(  'id' => 'wd_team',
								'type' => 'checkbox_slider',
								'label' => 'TF Team',
								'default' => '1'
						),
						array(  'id' => 'wd_testimonial_carousel',
								'type' => 'checkbox_slider',
								'label' => 'TF Testimonial Carousel',
								'default' => '1'
						),
						array(  'id' => 'wd_slider_before_after',
								'type' => 'checkbox_slider',
								'label' => 'TF Slider Before After',
								'default' => '1'
						),
						array(  'id' => 'wd_clipping_mask',
								'type' => 'checkbox_slider',
								'label' => 'TF Clipping Mask',
								'default' => '1'
						),
						array(  'id' => 'wd_price_table',
								'type' => 'checkbox_slider',
								'label' => 'TF Price Table',
								'default' => '1'
						),
						array(  'id' => 'wd_accordion',
								'type' => 'checkbox_slider',
								'label' => 'TF Accordion',
								'default' => '1'
						),
						array(  'id' => 'wd_progress_bar',
								'type' => 'checkbox_slider',
								'label' => 'TF Progress Bar',
								'default' => '1'
						),
						array(  'id' => 'wd_countdown',
								'type' => 'checkbox_slider',
								'label' => 'TF Countdown',
								'default' => '1'
						),
						array(  'id' => 'wd_pie_chart',
								'type' => 'checkbox_slider',
								'label' => 'TF Pie Chart',
								'default' => '1'
						),
						array(  'id' => 'wd_google_maps',
								'type' => 'checkbox_slider',
								'label' => 'TF Google Maps',
								'default' => '1'
						),
						array(  'id' => 'wd_group_images',
								'type' => 'checkbox_slider',
								'label' => 'TF Group Images',
								'default' => '1'
						),
						array(  'id' => 'wd_animation_item',
								'type' => 'checkbox_slider',
								'label' => 'TF Animation Item',
								'default' => '1'
						),
						array(  'id' => 'wd_partner',
								'type' => 'checkbox_slider',
								'label' => 'TF Partner',
								'default' => '1'
						),
						array(  'id' => 'wd_video',
								'type' => 'checkbox_slider',
								'label' => 'TF Video',
								'default' => '1'
						),

						array(  'id' => 'wd_search',
								'type' => 'checkbox_slider',
								'label' => 'TF Search',
								'default' => '1'
						),
						array(  'id' => 'wd_posts',
								'type' => 'checkbox_slider',
								'label' => 'TF Posts',
								'default' => '1'
						),
						
					)
			),
			array(
				'title' => 'Single Post',
				'fields' => 
					array(	
						
						array(  'id' => 'wd_post_image',
								'type' => 'checkbox_slider',
								'label' => 'TF Post Image',
								'default' => '0'
						),
						array(  'id' => 'wd_post_title',
								'type' => 'checkbox_slider',
								'label' => 'TF Post Title',
								'default' => '0'
						),
						array(  'id' => 'wd_post_excerpt',
								'type' => 'checkbox_slider',
								'label' => 'TF Post Excerpt',
								'default' => '0'
						),
						array(  'id' => 'wd_post_content',
								'type' => 'checkbox_slider',
								'label' => 'TF Post Content',
								'default' => '0'
						),
						array(  'id' => 'wd_author_box',
								'type' => 'checkbox_slider',
								'label' => 'TF Author Box',
								'default' => '0'
						),
						array(  'id' => 'wd_post_comment',
								'type' => 'checkbox_slider',
								'label' => 'TF Post Comment',
								'default' => '0'
						),
						array(  'id' => 'wd_post_info',
								'type' => 'checkbox_slider',
								'label' => 'TF Post Info',
								'default' => '0'
						),
						array(  'id' => 'wd_post_navigation',
								'type' => 'checkbox_slider',
								'label' => 'TF Post Navigation',
								'default' => '0'
						),
						
						
					)
			),
			array(
				'title' => 'WooCommerce',
				'fields' => 
					array(	
						
						array(  'id' => 'wd_woo_product_grid',
								'type' => 'checkbox_slider',
								'label' => 'TF Woo Product Grid',
								'note' =>  'Only When Install WooCommerce Plugin',
								'default' => '0'
						),
						array(  'id' => 'wd_woo_mini_cart',
								'type' => 'checkbox_slider',
								'label' => 'TF Woo Mini Cart',
								'note' =>  'Only When Install WooCommerce Plugin',
								'default' => '0'
						),
						array(  'id' => 'wd_woo_wishlist_count',
								'type' => 'checkbox_slider',
								'label' => 'TF Woo Wishlist Count',
								'note' =>  'Only When Install YITH Wishlist Plugin',
								'default' => '0'
						),
						
					)
			),
		);
	//Construct
	function __construct() {
		
		// add_action("admin_menu", array( $this, 'InitMenuSetup' ));
		add_action( 'admin_menu', array( $this, 'admin_menu_setup' ) );
		// add_action("admin_init", array( $this, 'show_setup_content_fields' ));
		// add_action( 'admin_enqueue_scripts', array( $this, 'register_css_js_setup' ));
		
   	}

	public function admin_menu_setup() {

		add_submenu_page(
			'',
			__( 'Themesflat Addons Options', 'themesflat-addons-for-elementor' ),
			__( 'Themesflat Addons Options', 'themesflat-addons-for-elementor' ),
			'manage_options',
			'tf-addon-options',
			[ $this, 'page_setup_template' ]
		);
	}

	
	public function register_css_js_setup() { 
		// Css ---------------
		wp_register_style( 'hl_wp_admin_css', plugins_url( '/plugin-option/css/admin-styles.css', __FILE__ ) );
		wp_enqueue_style( 'hl_wp_admin_css' );
		
		// Js ---------------
		wp_enqueue_style( 'wp-color-picker' );
    	wp_enqueue_script( 'wp-color-picker');
		wp_enqueue_media();

        wp_register_script( 'hl_type_image', plugins_url( '/plugin-option/js/image.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'hl_wp_admin_script', plugins_url( '/plugin-option/js/admin-script.js', __FILE__ ), [ 'jquery' ], false, true );

		wp_enqueue_script( 'hl_type_image');
		wp_enqueue_script( 'hl_wp_admin_script');
	}

	
	public function InitMenuSetup(){
		$page_title = $this->page_title;
		$menu_title = $this->menu_title;
		$capability = 'manage_options';
		$menu_slug = $this->menu_slug;
		$function_callback = array($this, 'page_setup_template');
		$icon_url = '';
		$position = $this->position;
		add_menu_page($page_title, $menu_title, $capability, $menu_slug , $function_callback, $icon_url, $position);
	}
	
	
	public function page_setup_template(){
		$arr_section = $this->arr_section;
		?>
		<div id="poststuff" class="tf-opt-options-area">
			<div class="postbox-container">
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox ">
						<h2 class="hndle ui-sortable-handle"><?php echo $this->page_title; ?></h2>
						<div class="inside <?php if($this->is_tab){?>options-tabs <?php echo $this->is_tab; ?> <?php } ?>">
                        	<?php 
							if($this->is_tab){
								
								if($arr_section){
									echo '<h2 class="nav-tab-wrapper wp-clearfix">';
									$i = 0;
									foreach($arr_section as $section => $arr_item){
										$s_clss = '';
										if(!$i){
											$s_clss = 'nav-tab-active';
										}
										$section_title = $arr_item['title'];
										echo '<a id="tab_'.$section.'" class="nav-tab tf-opt-tab-btn '.$s_clss.'" href="#'.$section.'"><span class="dashicons dashicons-arrow-right-alt2"></span>'.$section_title.'</a>';
										$i++;
									}
									echo '</h2>';
								} 
							}
							?>
                            <div class="wle-tab-content">
								<?php 
									$is_tab = $this->is_tab;
									$clss = '';
									if($is_tab){
										$clss = 'is_tab';
									}
								?>
								<form method="post" action="options.php" <?php if($is_tab){?> class="has-tabs" <?php } ?>>
									<?php
										settings_fields( $this->settings_fields );
							
										if($arr_section){
											$i = 0;
											foreach($arr_section as $section => $arr_fields){
												$s_clss = '';
												if(!$i){
													$s_clss = 'first active';
												}
												echo '<section id="'.$section.'" class="section '.$clss.' '.$s_clss.'">';
												do_settings_sections( $section.'-page' ); 
												echo '</section>';
												$i++;
											}
										} 
										submit_button(); 
									?>          
								</form>
                            </div>
						</div>
                        <div style="clear:both;"></div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	

	public function admin_menu() {

		add_submenu_page(
			'Setup',
			__( 'Themesflat Addons Options', 'themesflat-addons-for-elementor' ),
			__( 'Themesflat Addons Options', 'themesflat-addons-for-elementor' ),
			'manage_options',
			'eael-setup-wizard',
			[ $this, 'render_wizard' ]
		);
	}
	
	public function show_setup_content_fields(){
		$arr_section = $this->arr_section;

		if($arr_section){
			foreach($arr_section as $section => $arr_item){
				$section_title = $arr_item['title'];
				$arr_fields = $arr_item['fields'];
				if($arr_fields){
					add_settings_section($this->settings_fields,'' ,null, $section.'-page');
					foreach($arr_fields as $field){
						if( in_array($field['type'], $this->arr_types) ){
							$label = $field['label']; 
							$description = (isset($field['description'])) ? $field['description'] : '';
							if($description){
								$label .= '<br/><small class="wdescription"><i>('.$description.')</i></small>';
								
							}
							$note = !empty($field['note']) ? $field['note'] : '';
							if(!empty($note)) { 
								$label .= '<p class="note">' . $note . '</p>';
							}
							
							$field_id = SETUP_PREFIX . $field['id'];
							$field['id'] = $field_id;
							
							add_settings_field(	$field_id, 
												$label, 
												array($this, 'tf_show_fields_setup'), 
												$section.'-page', 
												$this->settings_fields, $field);
							register_setting($this->settings_fields, $field_id);
						}
					}
				}
			}
		}
	}
	

	
	public function tf_show_fields_setup($field){
		
		$type = $field['type'];
		if($type=='slider'){
			$type = 'image';
			$field['is_multiple'] = true;
			$field['hide_attribute'] = false;
		}
		set_query_var( 'field', $field );
	
		$id = $field['id'];
		$val = get_option($id);
		if($val===false){
			$val = $field['default'];
		}

		
		?>
		<label class="switch" for="<?php echo $id; ?>">
			<input <?php if($val) echo 'checked'; ?> type="checkbox" class="widefat tf-opt-checkbox" name="<?php echo $id; ?>" id="<?php echo $id; ?>" />
			<div class="slider round"></div>
		</label>
		<?php 
		
	}

//---------------End Class-------------------------------------	
}

// Run----------
new tf_plugin_setup();


// if(in_array('themesflat-addon/themesflat-addons-for-elementor.php', apply_filters('active_plugins', get_option('active_plugins')))){ 
// 	wp_redirect( admin_url( 'admin.php?page=tf-addon-options' ) );
// }