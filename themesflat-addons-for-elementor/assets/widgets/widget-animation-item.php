<?php
class TFAnimationitem_Widget_Free extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tf-animation-item';
    }
    
    public function get_title() {
        return esc_html__( 'TF Animation Item', 'themesflat-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-icon-box';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

    public function get_style_depends() {
		return ['tf-animation-item'];
	}

	protected function register_controls() {
		// Start Animation       
			$this->start_controls_section( 'section_tabs',
	            [
	                'label' => esc_html__('Animation', 'themesflat-addons-for-elementor'),
	            ]
	        );

	        $this->add_control(
				'style',
				[
					'label' => esc_html__( 'Style', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default'  => esc_html__( 'Animation Move', 'themesflat-addons-for-elementor' ),
						'style-1'  => esc_html__( 'Animation Mouse move', 'themesflat-addons-for-elementor' ),
					],
				]
			);

            $this->add_control(
				'animation_move',
				[
					'label' => esc_html__( 'Animation Move', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default'  => esc_html__( 'Default', 'themesflat-addons-for-elementor' ),
						'to-top'  => esc_html__( 'top to bottom', 'themesflat-addons-for-elementor' ),
						'to-bottom'  => esc_html__( 'bottom to top', 'themesflat-addons-for-elementor' ),
						'to-left'  => esc_html__( 'left to right', 'themesflat-addons-for-elementor' ),
						'to-right'  => esc_html__( 'right to left', 'themesflat-addons-for-elementor' ),
						'circle-zoom'  => esc_html__( 'Zoom in out', 'themesflat-addons-for-elementor' ),
						'rotate-ani'  => esc_html__( 'Rotate', 'themesflat-addons-for-elementor' ),
						'ribbon-rotate'  => esc_html__( 'Ribbon Rotate', 'themesflat-addons-for-elementor' ),
						'ani-1'  => esc_html__( 'Animation Frames 1', 'themesflat-addons-for-elementor' ),
						'ani-2'  => esc_html__( 'Animation Frames 2', 'themesflat-addons-for-elementor' ),
					],
                    'condition' => [
						'style' => 'default',
					],
				]
			);

			$this->add_control(
				'icon_style',
				[
					'label' => esc_html__( 'Style Item', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'icon' => [
							'title' => esc_html__( 'Icon', 'themesflat-addons-for-elementor' ),
							'icon' => 'fa fa-paint-brush',
						],
						'image' => [
							'title' => esc_html__( 'Image', 'themesflat-addons-for-elementor' ),
							'icon' => 'eicon-image',
						],
					],
					'default' => 'image',
					'toggle' => false,
				]
			);

	        $this->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-angry',
						'library' => 'solid',
					],
					'condition' => [
						'icon_style' => 'icon',
					],
				]
			);

			$this->add_control(
				'image',
				[
					'label' => esc_html__( 'Choose Image', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE."assets/img/placeholder.jpg",
					],
					'condition' => [
						'icon_style' => 'image',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'thumbnail',
					'include' => [],
					'default' => 'large',
                    'condition' => [
						'icon_style' => 'image',
					],
				]
			);

			$this->add_control(
				'layout_align_content_filter',
				[
					'label' => esc_html__( 'Alignment', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'left'    => [
							'title' => esc_html__( 'Left', 'themesflat-addons-for-elementor' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'themesflat-addons-for-elementor' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'themesflat-addons-for-elementor' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tf-animation-item' => 'text-align: {{VALUE}}',
					],
				]
			);



			$this->end_controls_section();
        // /.End Counter  

	    // Start Style Icon
	        $this->start_controls_section( 'section_style_icon',
	            [
	                'label' => esc_html__( 'Icon', 'themesflat-addons-for-elementor' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_responsive_control(
				'icon_size',
				[
					'label' => esc_html__( 'Icon Font Size', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 5,
							'max' => 1000,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tf-animation-item .animation-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tf-animation-item .animation-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);

	        $this->add_control(
				'icon_color',
				[
					'label' => esc_html__( 'Icon Color', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-animation-item .animation-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .tf-animation-item .animation-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);

        	$this->end_controls_section();    
	    // /.End Style Icon

        // Start Style Icon
        $this->start_controls_section( 'section_style_image',
        [
            'label' => esc_html__( 'Image', 'themesflat-addons-for-elementor' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_responsive_control(
        'image_size',
        [
            'label' => esc_html__( 'image Height', 'themesflat-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range' => [
                'px' => [
                    'min' => 5,
                    'max' => 1000,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .tf-animation-item .animation-image img' => 'height: {{SIZE}}{{UNIT}};object-fit: cover;',
            ],
        ]
    );

    $this->add_responsive_control(
        'image_size_w',
        [
            'label' => esc_html__( 'image With', 'themesflat-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range' => [
                'px' => [
                    'min' => 5,
                    'max' => 1000,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .tf-animation-item .animation-image img' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control( 
        'border_radius_mg',
        [
            'label' => esc_html__( 'Border Radius', 'themesflat-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' , '%' ],
            'selectors' => [
                '{{WRAPPER}} .tf-animation-item .animation-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );


            
    $this->end_controls_section();    
// /.End Style Icon

       
	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'tf_counter', ['id' => "tf-animation-item-{$this->get_id()}", 'class' => ['tf-animation-item', $settings['style']], 'data-tabid' => $this->get_id()] );	

		$icon = $image = $animation_move = '';

		$icon = \Elementor\Addon_Elementor_Icon_manager_free::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
        $animation_move = esc_attr($settings['animation_move']);
		if ($settings['image'] != '') {
			$url = esc_url($settings['image']['url']);
			$image = sprintf( '<img src="%1s" alt="image">',$url);
		}

		if (isset($icon)) {
			$animation_icon = sprintf('<div class="animation-icon">%1$s</div>',$icon);
		} 

        if ($settings['style'] == 'style-1') {
            $animation_move = 'animation-mouse';
        }

		if ($settings['icon_style'] == 'icon') {
			$animation_icon = sprintf('<div class="animation-icon %2$s">%1$s</div>',$icon,$animation_move);
		} elseif($settings['icon_style'] == 'image') {
			$animation_icon = sprintf('<div class="animation-image %2$s">%1$s</div>', $image, $animation_move );
		} else {
			$animation_icon = '';
		}

		echo sprintf ( 
			'<div %1$s> 
				%2$s                
            </div>',
            $this->get_render_attribute_string('tf_counter'),
            $animation_icon
        );	
		
	}

}