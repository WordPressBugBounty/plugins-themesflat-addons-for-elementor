<?php
class TFListImage_Widget_Free extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tf-list-image';
    }
    
    public function get_title() {
        return esc_html__( 'TF Partner', 'themesflat-addons-for-elementor' );
    }

    public function get_icon() {
		return 'eicon-slider-push';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

    public function get_style_depends() {
		return ['tf-list-image'];
	}

	protected function register_controls() {
		// Start List Setting        
			$this->start_controls_section( 'section_setting',
	            [
	                'label' => esc_html__('Setting', 'themesflat-addons-for-elementor'),
	            ]
	        );

			$this->add_control(
				'partner_style',
				[
					'label' => esc_html__( 'Partner Style', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'style-text' => [
							'title' => esc_html__( 'Style Text', 'themesflat-addons-for-elementor' ),
							'icon' => 'fa fa-edit',
						],
						'style-image' => [
							'title' => esc_html__( 'Style Image', 'themesflat-addons-for-elementor' ),
							'icon' => 'fa fa-image',
						],
					],
					'default' => 'style-image',
					'toggle' => false,
				]
			);

			$repeater = new \Elementor\Repeater();
			$repeater2 = new \Elementor\Repeater();

			$repeater->add_control(
				'image',
				[
					'label' => esc_html__( 'Choose Image', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE."assets/img/placeholder.jpg",
					],
				]
			);

			$repeater->add_control(
				'link_image',
				[
					'label' => esc_html__( 'Link', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'themesflat-addons-for-elementor' ),
					'default' => [
						'url' => '#',
						'is_external' => false,
						'nofollow' => false,
					],
				]
			);

			$repeater2->add_control(
				'partner_text',
				[
					'label' => esc_html__( 'Content Text', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'IT Services', 'themesflat-addons-for-elementor' ),
				]
			);

			$repeater2->add_control(
				'icon_text',
				[
					'label' => esc_html__( 'Icon', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-star-of-life',
						'library' => 'theme_icon',
					],
				]
			);

			$repeater2->add_control(
				'link_text',
				[
					'label' => esc_html__( 'Content Link', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'themesflat-addons-for-elementor' ),
					'default' => [
						'url' => '#',
						'is_external' => false,
						'nofollow' => false,
					],
				]
			);

			$this->add_control(
				'list2',
				[
					'label' => esc_html__( 'List', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater2->get_controls(),
					'default' => [
						[
							'partner_text' => esc_html__( 'IT Services', 'themesflat-addons-for-elementor' ),
							'link_text' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
						[
							'partner_text' => esc_html__( 'Cyber Security', 'themesflat-addons-for-elementor' ),
							'link_text' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
						[
							'partner_text' => esc_html__( 'Data Security', 'themesflat-addons-for-elementor' ),
							'link_text' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
						[
							'partner_text' => esc_html__( 'IT Services', 'themesflat-addons-for-elementor' ),
							'link_text' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
						[
							'partner_text' => esc_html__( 'Cyber Security', 'themesflat-addons-for-elementor' ),
							'link_text' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
						[
							'partner_text' => esc_html__( 'Data Security', 'themesflat-addons-for-elementor' ),
							'link_text' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
						[
							'partner_text' => esc_html__( 'IT Services', 'themesflat-addons-for-elementor' ),
							'link_text' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
						[
							'partner_text' => esc_html__( 'Cyber Security', 'themesflat-addons-for-elementor' ),
							'link_text' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
					],
					'condition' => [
						'partner_style' => 'style-text'
					]
				]
			);

			$this->add_control(
				'list',
				[
					'label' => esc_html__( 'List', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'image' =>  URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE."assets/img/placeholder.jpg",
							'link' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
						[
							'image' =>  URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE."assets/img/placeholder.jpg",
							'link' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
						[
							'image' =>  URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE."assets/img/placeholder.jpg",
							'link' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
						[
							'image' =>  URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE."assets/img/placeholder.jpg",
							'link' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
						[
							'image' =>  URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE."assets/img/placeholder.jpg",
							'link' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
						[
							'image' =>  URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE."assets/img/placeholder.jpg",
							'link' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
						[
							'image' =>  URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE."assets/img/placeholder.jpg",
							'link' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
						[
							'image' =>  URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE."assets/img/placeholder.jpg",
							'link' => esc_html__( '#', 'themesflat-addons-for-elementor' ),
						],
					],
					'condition' => [
						'partner_style' => 'style-image'
					]
				]
			);

			$this->add_control(
				'hover_image',
				[
					'label' => esc_html__( 'Enable Hover Filter', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'On', 'themesflat-addons-for-elementor' ),
					'label_off' => esc_html__( 'Off', 'themesflat-addons-for-elementor' ),
					'return_value' => 'yes',
					'default' => 'no',
					'condition' => [
						'partner_style' => 'style-image'
					]
				]
			);

			$this->add_control(
				'hover_stop',
				[
					'label' => esc_html__( 'Hover Stop', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'On', 'themesflat-addons-for-elementor' ),
					'label_off' => esc_html__( 'Off', 'themesflat-addons-for-elementor' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);

	        
			$this->end_controls_section();
        // /.End List Setting              

	    // Start Style
	        $this->start_controls_section( 'section_style',
	            [
	                'label' => esc_html__( 'Style', 'themesflat-addons-for-elementor' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

			$this->add_control(
				'h_image',
				[
					'label' => esc_html__( 'Image', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'condition' => [
						'partner_style' => 'style-image'
					]
				]
			);

			$this->add_responsive_control( 
	        	'image_size',
				[
					'label' => esc_html__( 'Image Width', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tf-list-image .box-item .item  ' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'partner_style' => 'style-image'
					]
				]
			);

			$this->add_responsive_control( 
	        	'image_size_h',
				[
					'label' => esc_html__( 'Image Height', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tf-list-image .box-item .item  ' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'partner_style' => 'style-image'
					]
				]
			);

			$this->add_control(
				'heading_spacing',
				[
					'label' => esc_html__( 'Spacing Item', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_responsive_control( 
	        	'image_size_spc',
				[
					'label' => esc_html__( 'Spacing', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tf-list-image .box-item .item' => 'padding-left: {{SIZE}}{{UNIT}};padding-right: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'heading_icon',
				[
					'label' => esc_html__( 'Icon', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'partner_style' => 'style-text'
					]
				]
			);

			$this->add_responsive_control( 
	        	'size_icon',
				[
					'label' => esc_html__( 'Icon Size', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tf-list-image .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tf-list-image .icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'partner_style' => 'style-text'
					]
				]
			);

			$this->add_control( 
				'icon_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-list-image .icon i' => 'color: {{VALUE}}',
						'{{WRAPPER}} .tf-list-image .icon svg path' => 'fill: {{VALUE}}',
					],
					'condition' => [
						'partner_style' => 'style-text'
					]
				]
			); 

			$this->add_responsive_control( 
	        	'icon_text_spacing',
				[
					'label' => esc_html__( 'Icon Spacing', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tf-list-image .list-text .icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'partner_style' => 'style-text'
					]
				]
			);

			$this->add_control(
				'heading_text',
				[
					'label' => esc_html__( 'Text', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'partner_style' => 'style-text'
					]
				]
			);

	        $this->add_group_control( 
	        	\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'text_typography',
					'label' => esc_html__( 'Text Typography', 'themesflat-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .tf-list-image .list-text a',
					'condition' => [
						'partner_style' => 'style-text'
					]
				]
			);
			
			$this->add_control( 
				'text_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-list-image .list-text a' => 'color: {{VALUE}}',
					],
					'condition' => [
						'partner_style' => 'style-text'
					]
				]
			); 

			$this->add_control( 
				'text_color_hover',
				[
					'label' => esc_html__( 'Color Hover', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-list-image .list-text a:hover' => 'color: {{VALUE}}',
						'{{WRAPPER}} .tf-list-image .list-text a:hover i' => 'color: {{VALUE}}',
						'{{WRAPPER}} .tf-list-image .list-text a:hover svg path' => 'fill: {{VALUE}}',
					],
					'condition' => [
						'partner_style' => 'style-text'
					]
				]
			); 

			$this->add_responsive_control( 
	        	'line_hover_hieght',
				[
					'label' => esc_html__( 'Height Line Bottom Hover', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tf-list-image .list-text a .text::after' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'partner_style' => 'style-text'
					]
				]
			);

        	$this->end_controls_section();    
	    // /.End Style 
	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();

		$hover_image = $settings['hover_image'] == 'yes' ? 'hover-image' : '';
		$hover_stop = $settings['hover_stop'] == 'yes' ? 'hover-stop' : '';

		$this->add_render_attribute( 'tf_list-image', ['id' => "tf-list-image-{$this->get_id()}", 'class' => ['tf-list-image', $hover_image, $hover_stop], 'data-tabid' => $this->get_id()] );	

		$content = $content2 = $title = $before_title = $hover_image = '';	

		if($settings['partner_style'] == 'style-image') {
		foreach ( $settings['list'] as $index => $item ) {
			$link_image = esc_url($item['link_image']['url']);
			$target = esc_attr($item['link_image']['is_external']) ? ' target="_blank"' : '';
			$nofollow = esc_attr($item['link_image']['nofollow']) ? ' rel="nofollow"' : '';
			$url = esc_url($item['image']['url']);

			if ($item['image'] != '') {
				$image = sprintf( '<div class="image">
					<a href="%2$s" %3$s %4$s><img src="%1$s" alt="image"></a>
				</div>',$url, $link_image, $target, $nofollow);
			}
			$content .= sprintf( '
								
									<div class="item">
										%1$s
									</div>
								', $image);
		}	
		}else {
			foreach ( $settings['list2'] as $index => $item2 ) {
				$link_text = esc_url($item2['link_text']['url']);
				$target = esc_attr($item2['link_text']['is_external']) ? ' target="_blank"' : '';
				$nofollow = esc_attr($item2['link_text']['nofollow']) ? ' rel="nofollow"' : '';
				$text = esc_attr($item2['partner_text']);
				$icon_text = \Elementor\Addon_Elementor_Icon_manager_free::render_icon( $item2['icon_text'], [ 'aria-hidden' => 'true' ]);
				if ($item2['partner_text'] != '') {
					$text_render = sprintf( '<div class="image">
						<a href="%2$s" %3$s %4$s> <span class="icon"> %5$s </span> <span class="text"> %1$s </span> </a>
					</div>',$text, $link_text, $target, $nofollow, $icon_text);
				}
				$content2 .= sprintf( '
									
										<div class="item list-text">
											%1$s
										</div>
									', $text_render);
			}
		}


		if($settings['partner_style'] == 'style-image') {
			echo sprintf ( 
				'<div %1$s> 
					<div class="box-item">
					%2$s   
					</div>
					<div class="box-item">
					%2$s   
					</div>	
				</div>',
				$this->get_render_attribute_string('tf_list-image'),
				$content
			);	
		} else {
			echo sprintf ( 
				'<div %1$s> 
					<div class="box-item">
					%2$s   
					</div>
					<div class="box-item">
					%2$s   
					</div>	
				</div>',
				$this->get_render_attribute_string('tf_list-image'),
				$content2
			);	
		}
		
	}

}