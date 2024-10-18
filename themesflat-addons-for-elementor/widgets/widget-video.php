<?php
class TF_Addon_Video_Widget_Free extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tf_addon_video_popup';
    }
    
    public function get_title() {
        return esc_html__( 'TF Video', 'themesflat-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-youtube';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

    public function get_style_depends() {
		return ['magnific-popup','tf-video'];
	}

	public function get_script_depends() {
		return ['magnific-popup','tf-video'];
	}

	protected function register_controls() {
		// Start Tab Video        
			$this->start_controls_section( 'section_video',
	            [
	                'label' => esc_html__('Video', 'themesflat-addons-for-elementor'),
	            ]
	        );

	        $this->add_control(
				'video_type',
				[
					'label' => esc_html__( 'Source', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'youtube',
					'options' => [
						'youtube' => esc_html__( 'YouTube', 'themesflat-addons-for-elementor' ),
						'vimeo' => esc_html__( 'Vimeo', 'themesflat-addons-for-elementor' ),
					],
				]
			);
	        $this->add_control(
				'youtube_url',
				[
					'label' => esc_html__( 'Link', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Enter your URL', 'themesflat-addons-for-elementor' ) . ' (YouTube)',
					'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
					'label_block' => true,
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			$this->add_control(
				'vimeo_url',
				[
					'label' => esc_html__( 'Link', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Enter your URL', 'themesflat-addons-for-elementor' ) . ' (Vimeo)',
					'default' => 'https://vimeo.com/235215203',
					'label_block' => true,
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-play',
						'library' => 'theme_icon',
					],
				]
			);
     
	        
			$this->end_controls_section();
        // /.End Tab Video

        // Start General
	        $this->start_controls_section( 'section_general',
	            [
	                'label' => esc_html__( 'General', 'themesflat-addons-for-elementor' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        ); 
	        $this->add_responsive_control(
				'align',
				[
					'label' => esc_html__( 'Alignment', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'flex-start' => [
							'title' => esc_html__( 'Left', 'themesflat-addons-for-elementor' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'themesflat-addons-for-elementor' ),
							'icon' => 'eicon-text-align-center',
						],
						'flex-end' => [
							'title' => esc_html__( 'Right', 'themesflat-addons-for-elementor' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'default' => 'center',
					'toggle' => true,
					'selectors' => [
						'{{WRAPPER}} .tf-video-popup' => 'justify-content: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'default' => [
						'top' => '50',
						'right' => '50',
						'bottom' => '50',
						'left' => '50',
						'unit' => '%',
						'isLinked' => true,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-video-popup .wrap-icon, {{WRAPPER}} .tf-video-popup .video-icon,{{WRAPPER}} .tf-video-popup .wrap-icon::after ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .tf_ani-linear-gradient:before, {{WRAPPER}} .tf_ani-linear-gradient:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .tf_ani-pulsebox-4:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'padding',
				[
					'label' => esc_html__( 'Padding', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tf-video-popup' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'margin',
				[
					'label' => esc_html__( 'Margin', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tf-video-popup .wrap-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);	
			$this->add_control(
				'tf_animation',
				[
					'label' => esc_html__( 'Animation', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'tf_ani-default',
					'options' => [
						'tf_ani-default' => esc_html__( 'No Animation', 'themesflat-addons-for-elementor' ),
						'tf_ani-linear-gradient' => esc_html__( 'Linear Gradient', 'themesflat-addons-for-elementor' ),
					]
				]
			);		

	    	$this->end_controls_section();    
	    // /.End General       

	    // Start Icon Video
	        $this->start_controls_section( 'section_icon_video',
	            [
	                'label' => esc_html__( 'Icon Video', 'themesflat-addons-for-elementor' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
	        $this->add_responsive_control(
				'size',
				[
					'label' => esc_html__( 'Size', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 300,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 70,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-video-popup .video-icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'icon_size',
				[
					'label' => esc_html__( 'Icon Size', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 16,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-video-popup .video-icon' => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .tf-video-popup .video-icon svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'icon_tabs' );				

				$this->start_controls_tab( 
						'icon_normal_tab',
						[
							'label' => esc_html__( 'Normal', 'themesflat-addons-for-elementor' ),						
						]
					);

					$this->add_control( 
						'icon_color',
						[
							'label' => esc_html__( 'Color', 'themesflat-addons-for-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'default' => '#fff',
							'selectors' => [
								'{{WRAPPER}} .tf-video-popup .video-icon' => 'color: {{VALUE}}; fill: {{VALUE}}',
							],
						]
					);

					$this->add_control( 
						'icon_background',
						[
							'label' => esc_html__( 'Background Color', 'themesflat-addons-for-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'default' => '#086AD8',
							'selectors' => [
								'{{WRAPPER}} .tf-video-popup .video-icon' => 'background-color: {{VALUE}};',
							],
						]
					);
					
				$this->end_controls_tab();

				$this->start_controls_tab( 
			    	'icon_hover_tab',
						[
							'label' => esc_html__( 'Hover', 'themesflat-addons-for-elementor' ),
						]
					);

					$this->add_control( 
						'icon_color_hover',
						[
							'label' => esc_html__( 'Color', 'themesflat-addons-for-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'default' => '#fff',
							'selectors' => [
								'{{WRAPPER}} .tf-video-popup .video-icon:hover' => 'color: {{VALUE}}; fill: {{VALUE}}',
							],
						]
					);

					$this->add_control( 
						'icon_background_hover',
						[
							'label' => esc_html__( 'Background Color', 'themesflat-addons-for-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'default' => '#222222',
							'selectors' => [
								'{{WRAPPER}} .tf-video-popup .video-icon:hover' => 'background-color: {{VALUE}};',
							],
						]
					);										
				
				$this->end_controls_tab();

	        $this->end_controls_tabs();   
			        
        	$this->end_controls_section();    
	    // /.End Icon Video 

	}	

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'tf_addon_video_popup', ['id' => "tf-video-popup-{$this->get_id()}", 'class' => ['tf-video-popup'], 'data-tabid' => $this->get_id()] );

		$blurred_text = $icon = $video_url = '';

		$video_url = esc_url($settings[ $settings['video_type'] . '_url' ]);

		$icon = \Elementor\Addon_Elementor_Icon_manager_free::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ]);


        echo sprintf ( 
			'<div %1$s>
				<div class="wrap-icon">				
					<a class="video-icon popup-video %4$s" href="%2$s">%3$s</a>
				</div>				
            </div>',
            $this->get_render_attribute_string('tf_addon_video_popup'),
            $video_url,
            $icon,
            esc_attr($settings['tf_animation'])
        );	
		
	}

}