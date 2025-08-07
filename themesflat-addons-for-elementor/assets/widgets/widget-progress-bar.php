<?php
class TFProgressBars_Widget_Free extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tf-progress-bar';
    }
    
    public function get_title() {
        return esc_html__( 'TF Progress Bar', 'themesflat-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-skill-bar';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

    public function get_style_depends() {
		return ['tf-progress-bar'];
	}

	public function get_script_depends() {
		return ['appear', 'tf-progress-bar'];
	}

	protected function register_controls() {
		// Start Tab Setting        
			$this->start_controls_section( 'section_setting',
	            [
	                'label' => esc_html__('Progress Bar', 'themesflat-addons-for-elementor'),
	            ]
	        );			

			$this->add_control(
				'title',
				[
					'label' => esc_html__( 'Title', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::TEXT,					
					'default' => esc_html__( 'Experience Staff', 'themesflat-addons-for-elementor' ),
					'label_block' => true,
				]
			);

			$this->add_control(
				'percent',
				[
					'label' => esc_html__( 'Percentage', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ '%' ],
					'range' => [
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => '%',
						'size' => 97,
					],
				]
			);								
	        
			$this->end_controls_section();
        // /.End Tab Setting         

	    // Start Style Progress Bar
	        $this->start_controls_section( 'section_style_progress',
	            [
	                'label' => esc_html__( 'Progress Bar', 'themesflat-addons-for-elementor' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_control(
				'percentage_type',
				[
					'label' => esc_html__( 'Type', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'outer',
					'options' => [
						'inner'  => esc_html__( 'Inner', 'themesflat-addons-for-elementor' ),
						'outer' => esc_html__( 'Outer', 'themesflat-addons-for-elementor' ),
					],
				]
			);

	        $this->add_control(
				'height_progress',
				[
					'label' => esc_html__( 'Height', 'themesflat-addons-for-elementor' ),
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
						'size' => 6,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-progress-bar .progress-wrap' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'percentage_type' => 'outer',
					],
				]
			);

			$this->add_responsive_control(
				'margin',
				[
					'label' => esc_html__( 'Margin', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'default' => [
						'top' => '14',
						'right' => '0',
						'bottom' => '0',
						'left' => '0',
						'unit' => 'px',
						'isLinked' => false,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-progress-bar .progress-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'percentage_type' => 'outer',
					],
				]
			); 

			$this->add_responsive_control(
				'padding',
				[
					'label' => esc_html__( 'Padding', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'default' => [
						'top' => '0',
						'right' => '15',
						'bottom' => '0',
						'left' => '15',
						'unit' => 'px',
						'isLinked' => false,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-progress-bar .perc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'percentage_type' => 'inner',
					],
				]
			);			

			$this->add_control( 
				'progress_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#3858e9',
					'selectors' => [
						'{{WRAPPER}} .tf-progress-bar .progress-animate' => 'background-color: {{VALUE}}',					
					],
				]
			);	

			$this->add_control( 
				'progress_background',
				[
					'label' => esc_html__( 'Background Color', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => 'rgba(51,185,203,0.2)',
					'selectors' => [
						'{{WRAPPER}} .tf-progress-bar .progress-wrap' => 'background-color: {{VALUE}}',				
					],
				]
			);

			$this->add_control(
				'border_radius_progress',
				[
					'label' => esc_html__( 'Border Radius', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-progress-bar .progress-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tf-progress-bar .progress-animate' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			); 
			        
        	$this->end_controls_section();    
	    // /.End Style Progress Bar

       	// Start Style Text
	        $this->start_controls_section( 'section_style_title',
	            [
	                'label' => esc_html__( 'Text', 'themesflat-addons-for-elementor' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_control(
				'h_title',
				[
					'label' => esc_html__( 'Title', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);
			$this->add_group_control( 
	        	\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'label' => esc_html__( 'Typography', 'themesflat-addons-for-elementor' ),
					'fields_options' => [
				        'typography' => ['default' => 'yes'],
				        'font_family' => [
				            'default' => 'Rubik',
				        ],
				        'font_size' => [
				            'default' => [
				                'unit' => 'px',
				                'size' => '16',
				            ],
				        ],
				        'font_weight' => [
				            'default' => '400',
				        ],
				        'line_height' => [
				            'default' => [
				                'unit' => 'em',
				                'size' => '1',
				            ],
				        ],
				        'text_transform' => [
							'default' => '',
						],
						'letter_spacing' => [
				            'default' => [
				                'unit' => 'px',
				                'size' => '0',
				            ],
				        ],
				    ],
					'selector' => '{{WRAPPER}} .tf-progress-bar .title',
				]
			);
			$this->add_control( 
				'title_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#091D3E',
					'selectors' => [
						'{{WRAPPER}} .tf-progress-bar .title' => 'color: {{VALUE}}',					
					],
				]
			);

			$this->add_control(
				'h_percentage',
				[
					'label' => esc_html__( 'Percentage', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control( 
	        	\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'percentage_typography',
					'label' => esc_html__( 'Typography', 'themesflat-addons-for-elementor' ),
					'fields_options' => [
				        'typography' => ['default' => 'yes'],
				        'font_family' => [
				            'default' => 'Rubik',
				        ],
				        'font_size' => [
				            'default' => [
				                'unit' => 'px',
				                'size' => '16',
				            ],
				        ],
				        'font_weight' => [
				            'default' => '400',
				        ],
				        'line_height' => [
				            'default' => [
				                'unit' => 'em',
				                'size' => '1',
				            ],
				        ],
				        'text_transform' => [
							'default' => '',
						],
						'letter_spacing' => [
				            'default' => [
				                'unit' => 'px',
				                'size' => '0',
				            ],
				        ],
				    ],
					'selector' => '{{WRAPPER}} .tf-progress-bar .number-perc',
				]
			); 
			$this->add_control( 
				'percentage_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#091D3E',
					'selectors' => [
						'{{WRAPPER}} .tf-progress-bar .number-perc' => 'color: {{VALUE}}',					
					],
				]
			);					
			        
        	$this->end_controls_section();    
	    // /.End Style Text 
	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'tf_progress_bar', ['id' => "tf-progress-bar-{$this->get_id()}", 'class' => ['tf-progress-bar', $settings['percentage_type']], 'data-tabid' => $this->get_id()] );
		
		$title = '<span class="title">'. esc_html( $settings['title'] ) .'</span>';

		$percent = '<div class="wrap-perc-title">
						<div class="perc">'.$title.'<span class="number-perc">'.esc_attr($settings['percent']['size']).'%</span></div>
					</div>';
		
		$content = sprintf( '
			%1$s
			<div class="progress-wrap">				
				<div class="progress-animate" data-valuemax="100" data-valuemin="0" data-valuenow="%2$s"></div>
			</div>' , $percent,esc_attr( $settings['percent']['size']) );

		if ($settings['percentage_type'] == 'inner') {
			$content = sprintf( '				
				<div class="progress-wrap">				
					<div class="progress-animate" data-valuemax="100" data-valuemin="0" data-valuenow="%2$s">%1$s</div>
				</div>' , $percent, esc_attr($settings['percent']['size']) );
		}

		echo sprintf ( 
			'<div %1$s> 
				%2$s                
            </div>',
            $this->get_render_attribute_string('tf_progress_bar'),
            $content
        );	
		
	}

}