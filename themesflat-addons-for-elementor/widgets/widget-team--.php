<?php
class TFTeam_Widget extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tf-team';
    }
    
    public function get_title() {
        return esc_html__( 'TF Team', 'themesflat-elementor' );
    }

    public function get_icon() {
        return 'eicon-person';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

    public function get_style_depends() {
		return ['tf-team'];
	}

	protected function register_controls() {
		// Start Tab Setting        
			$this->start_controls_section( 'section_tabs',
	            [
	                'label' => esc_html__('Setting', 'themesflat-elementor'),
	            ]
	        );

	        $this->add_control(
				'style',
				[
					'label' => esc_html__( 'Style', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'style1',
					'options' => [
						'default'  => esc_html__( 'Default', 'themesflat-elementor' ),
						'style1'  => esc_html__( 'Style 1', 'themesflat-elementor' ),
						'style2' => esc_html__( 'Style 2', 'themesflat-elementor' ),
					],
				]
			);

	        $this->add_control(
				'image',
				[
					'label' => esc_html__( 'Choose Image', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE."assets/img/default-team.jpg",
					], 
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'thumbnail',
					'default' => 'full',
				]
			);

			$this->add_control(
				'title',
				[
					'label' => esc_html__( 'Title', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Watson Mendela', 'themesflat-elementor' ),
					'label_block' => true,
				]
			);

			$this->add_control(
				'position',
				[
					'label' => esc_html__( 'Position', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Design Expert', 'themesflat-elementor' ),
					'label_block' => true,
				]
			);	
	        
			$this->end_controls_section();
        // /.End Tab Setting 

        // Start Social Icons        
			$this->start_controls_section( 'section_social_icon',
	            [
	                'label' => esc_html__('Social Icons', 'themesflat-elementor'),
	            ]
	        );

	        $repeater = new \Elementor\Repeater();

	        $repeater->add_control(
				'social_icon',
				[
					'label' => esc_html__( 'Icon', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'fa4compatibility' => 'social',
					'default' => [
						'value' => 'fab fa-wordpress',
						'library' => 'fa-brands',
					],
					'recommended' => [
						'fa-brands' => [
							'android',
							'apple',
							'behance',
							'bitbucket',
							'codepen',
							'delicious',
							'deviantart',
							'digg',
							'dribbble',
							'elementor',
							'facebook',
							'flickr',
							'foursquare',
							'free-code-camp',
							'github',
							'gitlab',
							'globe',
							'houzz',
							'instagram',
							'jsfiddle',
							'linkedin',
							'medium',
							'meetup',
							'mix',
							'mixcloud',
							'odnoklassniki',
							'pinterest',
							'product-hunt',
							'reddit',
							'shopping-cart',
							'skype',
							'slideshare',
							'snapchat',
							'soundcloud',
							'spotify',
							'stack-overflow',
							'steam',
							'telegram',
							'thumb-tack',
							'tripadvisor',
							'tumblr',
							'twitch',
							'twitter',
							'viber',
							'vimeo',
							'vk',
							'weibo',
							'weixin',
							'whatsapp',
							'wordpress',
							'xing',
							'yelp',
							'youtube',
							'500px',
						],
						'fa-solid' => [
							'envelope',
							'link',
							'rss',
						],
					],
				]
			);

			$repeater->add_control(
				'link',
				[
					'label' => esc_html__( 'Link', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::URL,
					'default' => [
					'url' => '#',
						'is_external' => true,
						'nofollow' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'themesflat-elementor' ),
				]
			);

			$this->add_control(
				'social_icon_list',
				[
					'label' => esc_html__( 'Social Icons', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'social_icon' => [
								'value' => 'fab fa-facebook-f',
								'library' => 'fa-brands',
							],
						],
						[
							'social_icon' => [
								'value' => 'fab fa-twitter',
								'library' => 'fa-brands',
							],
						],
						[
							'social_icon' => [
								'value' => 'fab fa-instagram',
								'library' => 'fa-brands',
							],
						],
					],
					'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( social_icon, social, true, migrated, true ) }}}',
				]
			);
	        
			$this->end_controls_section();
        // /.End Social Icons              

	    // Start Style
	        $this->start_controls_section( 'section_style',
	            [
	                'label' => esc_html__( 'Style', 'themesflat-elementor' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_control(
				'h_general',
				[
					'label' => esc_html__( 'General', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'style' => 'default',
					],
				]
			);

			$this->add_control(
				'align',
				[
					'label' => esc_html__( 'Alignment', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'themesflat-elementor' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'themesflat-elementor' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'themesflat-elementor' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'default' => 'center',
					'toggle' => true,
					'selectors' => [
						'{{WRAPPER}} .tf-team' => 'text-align: {{VALUE}}',					
					],
					'condition' => [
						'style' => 'default',
					],
				]
			);			

	        $this->add_control(
				'h_image',
				[
					'label' => esc_html__( 'Image', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'border_radius_image',
				[
					'label' => esc_html__( 'Border Radius', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'default' => [
						'top' => '5',
						'right' => '5',
						'bottom' => '5',
						'left' => '5',
						'unit' => 'px',
						'isLinked' => true,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .image-team .inner-image, {{WRAPPER}} .tf-team .image-team img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

	        $this->add_control(
				'h_content',
				[
					'label' => esc_html__( 'Content', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control( 
				'bg_content',
				[
					'label' => esc_html__( 'Backround', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .tf-team .content' => 'background: {{VALUE}}',					
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'box_shadow',
					'label' => esc_html__( 'Box Shadow', 'themesflat-elementor' ),
					'selector' => '{{WRAPPER}} .tf-team .content',
				]
			);

			$this->add_control(
				'border_radius_content',
				[
					'label' => esc_html__( 'Border Radius', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'default' => [
						'top' => '5',
						'right' => '5',
						'bottom' => '5',
						'left' => '5',
						'unit' => 'px',
						'isLinked' => true,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'padding_content',
				[
					'label' => esc_html__( 'Padding', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'default' => [
						'top' => '30',
						'right' => '20',
						'bottom' => '18',
						'left' => '20',
						'unit' => 'px',
						'isLinked' => false,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'style' => 'default',
					],
				]
			);

	        $this->add_control(
				'h_title',
				[
					'label' => esc_html__( 'Title', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);			

			$this->add_group_control( 
	        	\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'typography_title',
					'label' => esc_html__( 'Typography', 'themesflat-elementor' ),
					'fields_options' => [
				        'typography' => ['default' => 'yes'],
				        'font_family' => [
				            'default' => 'Rubik',
				        ],
				        'font_size' => [
				            'default' => [
				                'unit' => 'px',
				                'size' => '20',
				            ],
				        ],
				        'font_weight' => [
				            'default' => '700',
				        ],
				        'line_height' => [
				            'default' => [
				                'unit' => 'px',
				                'size' => '30',
				            ],
				        ],
				        'letter_spacing' => [
				            'default' => [
				                'unit' => 'px',
				                'size' => '0',
				            ],
				        ],
				    ],
					'selector' => '{{WRAPPER}} .tf-team .title',
				]
			); 

			$this->add_control( 
				'color_title',
				[
					'label' => esc_html__( 'Color Text Fisrt & Last', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#1F242C',
					'selectors' => [
						'{{WRAPPER}} .tf-team .title' => 'color: {{VALUE}}',					
					],
				]
			);

			$this->add_control(
				'padding_title',
				[
					'label' => esc_html__( 'Padding', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'default' => [
						'top' => '0',
						'right' => '0',
						'bottom' => '0',
						'left' => '0',
						'unit' => 'px',
						'isLinked' => false,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'h_position',
				[
					'label' => esc_html__( 'Position', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control( 
	        	\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'typography_position',
					'label' => esc_html__( 'Typography', 'themesflat-elementor' ),
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
				                'unit' => 'px',
				                'size' => '30',
				            ],
				        ],
				        'letter_spacing' => [
				            'default' => [
				                'unit' => 'px',
				                'size' => '0',
				            ],
				        ],
				    ],
					'selector' => '{{WRAPPER}} .tf-team .position',
				]
			); 

			$this->add_control( 
				'color_position',
				[
					'label' => esc_html__( 'Color Text Fisrt & Last', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#565872',
					'selectors' => [
						'{{WRAPPER}} .tf-team .position' => 'color: {{VALUE}}',					
					],
				]
			);

			$this->add_control(
				'padding_position',
				[
					'label' => esc_html__( 'Padding', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'default' => [
						'top' => '0',
						'right' => '0',
						'bottom' => '0',
						'left' => '0',
						'unit' => 'px',
						'isLinked' => false,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .position' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);	

			$this->add_control(
				'h_social',
				[
					'label' => esc_html__( 'Social', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);	

			$this->add_control( 
				'color_social',
				[
					'label' => esc_html__( 'Color', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#1F242C',
					'selectors' => [
						'{{WRAPPER}} .tf-team .social a' => 'color: {{VALUE}}',					
					],
					'condition' => [
						'style!' => 'style2'
					],
				]
			);

			$this->add_control( 
				'bgcolor_social',
				[
					'label' => esc_html__( 'Background', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#F0F4F9',
					'selectors' => [
						'{{WRAPPER}} .tf-team .social a' => 'background-color: {{VALUE}}',					
					],
					'condition' => [
						'style!' => 'style2'
					],
				]
			);

			$this->add_control( 
				'color_social_hover',
				[
					'label' => esc_html__( 'Color Hover', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .tf-team .social a:hover' => 'color: {{VALUE}}',					
					],
					'condition' => [
						'style!' => 'style2'
					],
				]
			);

			$this->add_control( 
				'bgcolor_social_hover',
				[
					'label' => esc_html__( 'Background Hover', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#57B33E',
					'selectors' => [
						'{{WRAPPER}} .tf-team .social a:hover' => 'background-color: {{VALUE}}',					
					],
					'condition' => [
						'style!' => 'style2'
					],
				]
			);

			$this->add_control( 
				'color_social_style2',
				[
					'label' => esc_html__( 'Color', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .tf-team.style2 .social a' => 'color: {{VALUE}}',					
					],
					'condition' => [
						'style' => 'style2'
					],
				]
			);

			$this->add_control( 
				'bgcolor_social_style2',
				[
					'label' => esc_html__( 'Background', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#57B33E',
					'selectors' => [
						'{{WRAPPER}} .tf-team.style2 .social a' => 'background-color: {{VALUE}}',					
					],
					'condition' => [
						'style' => 'style2'
					],
				]
			);

			$this->add_control( 
				'color_social_hover_style2',
				[
					'label' => esc_html__( 'Color Hover', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#1F242C',
					'selectors' => [
						'{{WRAPPER}} .tf-team.style2 .social .social-item a:hover' => 'color: {{VALUE}}',					
					],
					'condition' => [
						'style' => 'style2'
					],
				]
			);

			$this->add_control( 
				'bgcolor_social_hover_style2',
				[
					'label' => esc_html__( 'Background Hover', 'themesflat-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#F0F4F9',
					'selectors' => [
						'{{WRAPPER}} .tf-team.style2 .social .social-item a:hover' => 'background-color: {{VALUE}}',					
					],
					'condition' => [
						'style' => 'style2'
					],
				]
			);
			        
        	$this->end_controls_section();    
	    // /.End Style 
	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'tf_team', ['id' => "tf-team-{$this->get_id()}", 'class' => ['tf-team', $settings['style']], 'data-tabid' => $this->get_id()] );

		$title = $position = $social_html = $social = $image_html = $content = '';

		if ($settings['title'] != '') {
			$title = '<h3 class="title">'.$settings['title'].'</h3>';
		}

		if ($settings['position'] != '') {
			$position = '<div class="position"> '.$settings['position'].' </div>';
		}		

		foreach ( $settings['social_icon_list'] as $index => $item ) {
			$target = $item['link']['is_external'] ? ' target="_blank"' : '';
			$nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';

			//$social .= '<a href="' . $item['link']['url'] . '" ' . $target . $nofollow . '>'.\Elementor\Addon_Elementor_Icon_manager_free::render_icon( $item['social_icon'] ).'</a>';
		}
		$social_html = '<div class="social">'.$social.'</div>';

		$image =  \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );

		if ($settings['style'] == 'style2') {

			$social_html = '<div class="social"><div class="inner-social"><a href="#" class="hover-social"><i class="fas fa-share-alt"></i></a><div class="social-item">'.$social.'</div></div></div>';

			$image_html = sprintf( '<div class="image-team">
									<div class="inner-image">%1$s %2$s</div>									
								</div>', $image, $social_html );
			$content = sprintf( '<div class="wrap-team">
								%1$s
								<div class="content">
								%2$s
								%3$s
								</div>
							</div>', $image_html, $title, $position );
		}else {
			$image_html = sprintf( '<div class="image-team">
									<div class="inner-image">%1$s</div>									
								</div>', $image );

			$content = sprintf( '<div class="wrap-team">
								%1$s
								<div class="content">
								%2$s
								%3$s
								%4$s
								</div>
							</div>', $image_html, $title, $position, $social_html );
		}

		echo sprintf ( 
			'<div %1$s> 
				%2$s                
            </div>',
            $this->get_render_attribute_string('tf_team'),
            $content
        );	
		
	}

}