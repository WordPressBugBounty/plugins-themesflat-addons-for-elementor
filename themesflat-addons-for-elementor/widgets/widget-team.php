<?php
class TFTeam_Widget_Free extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tfteam';
    }
    
    public function get_title() {
        return esc_html__( 'TF Team', 'themesflat-addons-for-elementor' );
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
        // Start Team Setting        
			$this->start_controls_section( 
				'section_team',
	            [
	                'label' => esc_html__('Information Team', 'themesflat-addons-for-elementor'),
	            ]
	        );

			$this->add_control(
				'image',
				[
					'label' => esc_html__( 'Choose Image', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[	
					'name' => 'thumbnail',
					'include' => [],
					'default' => 'large',
				]
			);  

			$this->add_control(
				'team_name',
				[
					'label' => esc_html__( 'Name', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => 'Suri Team Name',
					'label_block' => true,
				]
			);

			$this->add_control(
				'team_position',
				[
					'label' => esc_html__( 'Position', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => 'Developer',
					'label_block' => true,
				]
			);  

			$this->add_control(
				'team_description',
				[
					'label' => esc_html__( 'Short Description', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'default' => '',
					'label_block' => true,
				]
			);	

			$this->add_control(
				'team_link',
				[
					'label' => esc_html__( 'Link', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'themesflat-addons-for-elementor' ),
					'show_external' => true,
					'default' => [
						'url' => '#',
						'is_external' => true,
						'nofollow' => true,
					],
				]
			);

	        $this->end_controls_section();
        // /.End Team Setting

        // Start Team Social        
			$this->start_controls_section( 
				'section_team_social',
	            [
	                'label' => esc_html__('Social', 'themesflat-addons-for-elementor'),
	            ]
	        );
	        $this->add_control(
				'show_social',
				[
					'label' => esc_html__( 'Show Social', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-addons-for-elementor' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-addons-for-elementor' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

	        $repeater = new \Elementor\Repeater();

			/*$repeater->add_control(
				'social_icon',
				[
					'label' => esc_html__( 'Social Icon', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'facebook',
					'options' => [
						'500px' => esc_html__( '500px', 'themesflat-addons-for-elementor' ),
			            'apple' => esc_html__( 'Apple', 'themesflat-addons-for-elementor' ),
			            'behance' => esc_html__( 'Behance', 'themesflat-addons-for-elementor' ),
			            'bitbucket' => esc_html__( 'BitBucket', 'themesflat-addons-for-elementor' ),
			            'codepen' => esc_html__( 'CodePen', 'themesflat-addons-for-elementor' ),
			            'delicious' => esc_html__( 'Delicious', 'themesflat-addons-for-elementor' ),
			            'deviantart' => esc_html__( 'DeviantArt', 'themesflat-addons-for-elementor' ),
			            'digg' => esc_html__( 'Digg', 'themesflat-addons-for-elementor' ),
			            'dribbble' => esc_html__( 'Dribbble', 'themesflat-addons-for-elementor' ),
			            'email' => esc_html__( 'Email', 'themesflat-addons-for-elementor' ),
			            'facebook' => esc_html__( 'Facebook', 'themesflat-addons-for-elementor' ),
			            'flickr' => esc_html__( 'Flicker', 'themesflat-addons-for-elementor' ),
			            'foursquare' => esc_html__( 'FourSquare', 'themesflat-addons-for-elementor' ),
			            'github' => esc_html__( 'Github', 'themesflat-addons-for-elementor' ),
			            'houzz' => esc_html__( 'Houzz', 'themesflat-addons-for-elementor' ),
			            'instagram' => esc_html__( 'Instagram', 'themesflat-addons-for-elementor' ),
			            'jsfiddle' => esc_html__( 'JS Fiddle', 'themesflat-addons-for-elementor' ),
			            'linkedin' => esc_html__( 'LinkedIn', 'themesflat-addons-for-elementor' ),
			            'medium' => esc_html__( 'Medium', 'themesflat-addons-for-elementor' ),
			            'pinterest' => esc_html__( 'Pinterest', 'themesflat-addons-for-elementor' ),
			            'product-hunt' => esc_html__( 'Product Hunt', 'themesflat-addons-for-elementor' ),
			            'reddit' => esc_html__( 'Reddit', 'themesflat-addons-for-elementor' ),
			            'slideshare' => esc_html__( 'Slide Share', 'themesflat-addons-for-elementor' ),
			            'snapchat' => esc_html__( 'Snapchat', 'themesflat-addons-for-elementor' ),
			            'soundcloud' => esc_html__( 'SoundCloud', 'themesflat-addons-for-elementor' ),
			            'spotify' => esc_html__( 'Spotify', 'themesflat-addons-for-elementor' ),
			            'stack-overflow' => esc_html__( 'StackOverflow', 'themesflat-addons-for-elementor' ),
			            'tripadvisor' => esc_html__( 'TripAdvisor', 'themesflat-addons-for-elementor' ),
			            'tumblr' => esc_html__( 'Tumblr', 'themesflat-addons-for-elementor' ),
			            'twitch' => esc_html__( 'Twitch', 'themesflat-addons-for-elementor' ),
			            'twitter' => esc_html__( 'Twitter', 'themesflat-addons-for-elementor' ),
			            'vimeo' => esc_html__( 'Vimeo', 'themesflat-addons-for-elementor' ),
			            'vk' => esc_html__( 'VK', 'themesflat-addons-for-elementor' ),
			            'website' => esc_html__( 'Website', 'themesflat-addons-for-elementor' ),
			            'whatsapp' => esc_html__( 'WhatsApp', 'themesflat-addons-for-elementor' ),
			            'wordpress' => esc_html__( 'WordPress', 'themesflat-addons-for-elementor' ),
			            'xing' => esc_html__( 'Xing', 'themesflat-addons-for-elementor' ),
			            'yelp' => esc_html__( 'Yelp', 'themesflat-addons-for-elementor' ),
			            'youtube' => esc_html__( 'YouTube', 'themesflat-addons-for-elementor' ),
					],
				]
			);*/

			$repeater->add_control(
				'social_icon',
				[
					'label' => esc_html__( 'Social Icon', 'elementor' ),
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
				'social_link',
				[
					'label' => esc_html__( 'Link', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::URL,
					'default' => [
						'is_external' => 'true',
					],
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'themesflat-addons-for-elementor' ),
				]
			);		

			$repeater->add_responsive_control(
				'social_icon_size_tab',
				[
					'label' => esc_html__( 'Font Size', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
						
					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-box-social {{CURRENT_ITEM}}.social' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tf-team .team-box-social {{CURRENT_ITEM}}.social svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);	


			$repeater->add_responsive_control(
				'social_padding_tab',
				[
					'label' => esc_html__( 'Padding', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-box-social {{CURRENT_ITEM}}.social' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$repeater->start_controls_tabs( 
				'social_tabs' 
				);		


				$repeater->start_controls_tab( 
					'social_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'themesflat-addons-for-elementor' ),						
					]
				);

				$repeater->add_control(
					'icon_background_color',
					[
						'label' => esc_html__( 'Background Color', 'themesflat-addons-for-elementor' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .team-box-social {{CURRENT_ITEM}}.social' => 'background-color: {{VALUE}};',
						],
					]
				);

				$repeater->add_control(
					'icon_color',
					[
						'label' => esc_html__( 'Icon Color', 'themesflat-addons-for-elementor' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '#7A7A7A',
						'selectors' => [
							'{{WRAPPER}} .team-box-social {{CURRENT_ITEM}}.social' => 'color: {{VALUE}};',
						],
					]
				);

				$repeater->end_controls_tab();

				$repeater->start_controls_tab( 
			    	'social_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'themesflat-addons-for-elementor' ),
					]
				);

				$repeater->add_control(
					'icon_background_color_hover',
					[
						'label' => esc_html__( 'Background Color', 'themesflat-addons-for-elementor' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .team-box-social {{CURRENT_ITEM}}.social:hover' => 'background-color: {{VALUE}};',
						],
					]
				);

				$repeater->add_control(
					'icon_color_hover',
					[
						'label' => esc_html__( 'Icon Color', 'themesflat-addons-for-elementor' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .team-box-social {{CURRENT_ITEM}}.social:hover' => 'color: {{VALUE}};',
							'{{WRAPPER}} .team-box-social {{CURRENT_ITEM}}.social:hover svg' => 'fill: {{VALUE}};',
						],
					]
				);
				
				$repeater->end_controls_tab();

	        $repeater->end_controls_tabs();

	        $this->add_control( 
	        	'social_icon_list',
				[					
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[	
							'social_icon' => [
								'value' => 'fab fa-facebook',
								'library' => 'fa-brands',
							],
							'social_link' => ['url' => 'https://facebook.com/'],
							'icon_background_color' => '#3b5998',
							'icon_color' => '#ffffff',
							'icon_background_color_hover' => '#000000',
						],
						[
							'social_icon' => [
								'value' => 'fab fa-twitter',
								'library' => 'fa-brands',
							],
							'social_link' => ['url' => 'https://twitter.com/'],
							'icon_background_color' => '#1da1f2',
							'icon_color' => '#ffffff',
							'icon_background_color_hover' => '#000000',
						],
						[
							'social_icon' => [
								'value' => 'fab fa-youtube',
								'library' => 'fa-brands',
							],
							'social_link' => ['url' => 'https://www.youtube.com/'],
							'icon_background_color' => '#cd201f',
							'icon_color' => '#ffffff',
							'icon_background_color_hover' => '#000000',
						],
					],
					'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( social_icon, social, true, migrated, true ) }}}',
				]
			);
	        $this->end_controls_section();
        // /.End Team Social

        // Start Team General        
			$this->start_controls_section( 
				'section_team_style',
	            [
	                'label' => esc_html__('General', 'themesflat-addons-for-elementor'),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_control(
				'style',
				[
					'label' => esc_html__( 'Style', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' => esc_html__( 'Style 1 ( Default )', 'themesflat-addons-for-elementor' ),
						'style-2' => esc_html__( 'Style 2 ( Content Absolute )', 'themesflat-addons-for-elementor' ),
						'style-3' => esc_html__( 'Style 3 ( Image Left )', 'themesflat-addons-for-elementor' ),
					],
				]
			);			
			
	        $this->add_responsive_control(
				'align',
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
					'default' => 'center',
					'selectors' => [
						'{{WRAPPER}} .tf-team, {{WRAPPER}} .tf-team' => 'text-align: {{VALUE}};text-align: -webkit-{{VALUE}};',
					],
				]
			);

	        $this->add_responsive_control( 
	        	'padding',
				[
					'label' => esc_html__( 'Padding', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'default' => [
						'top' => '20',
						'right' => '20',
						'bottom' => '20',
						'left' => '20',
						'unit' => 'px',
						'isLinked' => 'true',
					],
					'selectors' => [
						'{{WRAPPER}} .tf-team' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);	

			$this->add_responsive_control( 
				'margin',
				[
					'label' => esc_html__( 'Margin', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .tf-team' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);  

			$this->add_group_control( 
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'box_shadow',
					'label' => esc_html__( 'Box Shadow', 'themesflat-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .tf-team',
				]
			);

			$this->add_group_control( 
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'border',
					'label' => esc_html__( 'Border', 'themesflat-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .tf-team',
				]
			);    

			$this->add_responsive_control( 
				'border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' , '%' ],
					'selectors' => [
						'{{WRAPPER}} .tf-team' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			); 

			$this->add_control( 
				'background_color',
				[
					'label' => esc_html__( 'Background Color', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .tf-team' => 'background-color: {{VALUE}}',
					],
				]
			);

	        $this->end_controls_section();
        // /.End Team General

	    // Start Avatar Style 
		    $this->start_controls_section( 
		    	'section_style_image',
	            [
	                'label' => esc_html__( 'Avatar', 'themesflat-addons-for-elementor' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_responsive_control(
				'image_width',
				[
					'label' => esc_html__( 'Width', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-image' => 'width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tf-team.style-3 .team-content' => 'width: calc( 100% - {{SIZE}}{{UNIT}} );',
					],
				]
			);

			$this->add_responsive_control(
				'image_bottom_spacing',
				[
					'label' => esc_html__( 'Bottom Spacing', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

	        $this->add_group_control( 
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'image_border',
					'label' => esc_html__( 'Border', 'themesflat-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .tf-team .team-image',
				]
			);

	        $this->add_responsive_control( 
				'image_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' , '%' ],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-image, {{WRAPPER}} .tf-team .team-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			); 

			$this->add_control( 
				'image_padding',
				[
					'label' => esc_html__( 'Padding', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control( 
				'image_margin',
				[
					'label' => esc_html__( 'Margin', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'image_overlay',
				[
					'label' => esc_html__( 'Overlay', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'show_image_overlay',
				[
					'label' => esc_html__( 'Show Overlay', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-addons-for-elementor' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-addons-for-elementor' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);

			$this->add_control(
				'image_overlay_background_color',
				[
					'label' => esc_html__( 'Background Color', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => 'rgba(0, 0, 0, 0.5)',
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-image .image-overlay' => 'background-color: {{VALUE}};',
					],
					'condition' => [
	                    'show_image_overlay'	=> 'yes',
	                ]
				]
			);

			$this->add_control(
				'image_overlay_effect',
				[
					'label' => esc_html__( 'Effect Overlay', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default' => esc_html__( 'Default', 'themesflat-addons-for-elementor' ),
						'fade-in' => esc_html__( 'Fade In', 'themesflat-addons-for-elementor' ),
						'fade-in-up' => esc_html__( 'Fade In Up', 'themesflat-addons-for-elementor' ),
						'fade-in-down' => esc_html__( 'Fade In Down', 'themesflat-addons-for-elementor' ),
						'fade-in-left' => esc_html__( 'Fade In Left', 'themesflat-addons-for-elementor' ),
						'fade-in-right' => esc_html__( 'Fade In Right', 'themesflat-addons-for-elementor' ),
					],
					'condition' => [
	                    'show_image_overlay'	=> 'yes',
	                ]
				]
			);			

		    $this->end_controls_section();
	    // /.End Avatar Style

	    // Start Content Style        
			$this->start_controls_section( 
				'section_team_content',
	            [
	                'label' => esc_html__('Content', 'themesflat-addons-for-elementor'),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
	        $this->add_responsive_control( 
	        	'content_padding',
				[
					'label' => esc_html__( 'Padding', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'default' => [
						'top' => '30',
						'right' => '30',
						'bottom' => '35',
						'left' => '30',
						'unit' => 'px',
						'isLinked' => 'false',
					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);	

			$this->add_responsive_control( 
				'content_margin',
				[
					'label' => esc_html__( 'Margin', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);  

			$this->add_group_control( 
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'content_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'themesflat-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .tf-team .team-content',
				]
			);

			$this->add_group_control( 
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'content_border',
					'label' => esc_html__( 'Border', 'themesflat-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .tf-team .team-content',
				]
			);    

			$this->add_responsive_control( 
				'content_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' , '%' ],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			); 

			$this->add_control( 
				'content_background_color',
				[
					'label' => esc_html__( 'Background Color', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => 'rgba(122, 122, 122, 0.05)',
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-content' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'content_effect',
				[
					'label' => esc_html__( 'Effect', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'fade-in',
					'options' => [
						'default' => esc_html__( 'Default', 'themesflat-addons-for-elementor' ),
						'fade-in' => esc_html__( 'Fade In', 'themesflat-addons-for-elementor' ),
						'fade-in-up' => esc_html__( 'Fade In Up', 'themesflat-addons-for-elementor' ),
						'fade-in-down' => esc_html__( 'Fade In Down', 'themesflat-addons-for-elementor' ),
						'fade-in-left' => esc_html__( 'Fade In Left', 'themesflat-addons-for-elementor' ),
						'fade-in-right' => esc_html__( 'Fade In Right', 'themesflat-addons-for-elementor' ),
					],
					'condition' => [
	                    'style'	=> 'style-2',
	                ]
				]
			);	

	        $this->end_controls_section();
        // /.End Content Style
	    
	    // Start Name Position Description Style 
		    $this->start_controls_section( 
		    	'section_style_name_position_description',
	            [
	                'label' => esc_html__( 'Name, Position & Description', 'themesflat-addons-for-elementor' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );	

	        $this->add_control(
				'name_html_tag',
				[
					'label' => esc_html__( 'Html Tag', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'h5',
					'options' => [
						'h1'  => esc_html__( 'H1', 'themesflat-addons-for-elementor' ),
						'h2'  => esc_html__( 'H2', 'themesflat-addons-for-elementor' ),
						'h3'  => esc_html__( 'H3', 'themesflat-addons-for-elementor' ),
						'h4'  => esc_html__( 'H4', 'themesflat-addons-for-elementor' ),
						'h5'  => esc_html__( 'H5', 'themesflat-addons-for-elementor' ),
						'h6'  => esc_html__( 'H6', 'themesflat-addons-for-elementor' ),
					],
				]
			);

	        $this->add_control( 
				'heading_name',
				[
					'label' => esc_html__( 'Name', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);

	        $this->add_group_control( 
	        	\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'name_typography',
					'label' => esc_html__( 'Typography', 'themesflat-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .tf-team .team-name',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Text_Shadow::get_type(),
				[
					'name' => 'name_text_shadow',
					'label' => esc_html__( 'Text Shadow', 'themesflat-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .tf-team .team-name',
				]
			);

			$this->add_control( 
				'name_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000000',
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-name a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control( 
				'name_color_hover',
				[
					'label' => esc_html__( 'Color Hover', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#1da1f2',
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-name a:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'name_spacer',
				[
					'label' => esc_html__( 'Spacer', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 10

					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control( 
				'heading_position',
				[
					'label' => esc_html__( 'Position', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control( 
	        	\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'position_typography',
					'label' => esc_html__( 'Typography', 'themesflat-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .tf-team .team-position',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Text_Shadow::get_type(),
				[
					'name' => 'position_text_shadow',
					'label' => esc_html__( 'Text Shadow', 'themesflat-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .tf-team .team-position',
				]
			);

			$this->add_control( 
				'position_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000000',
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-position' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'position_spacer',
				[
					'label' => esc_html__( 'Spacer', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 10

					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-position' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control( 
				'heading_description',
				[
					'label' => esc_html__( 'Description', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control( 
	        	\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'description_typography',
					'label' => esc_html__( 'Typography', 'themesflat-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .tf-team .team-desc',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Text_Shadow::get_type(),
				[
					'name' => 'description_text_shadow',
					'label' => esc_html__( 'Text Shadow', 'themesflat-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .tf-team .team-desc',
				]
			);

			$this->add_control( 
				'description_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000000',
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-desc' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'description_spacer',
				[
					'label' => esc_html__( 'Spacer', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 10

					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

		    $this->end_controls_section();
	    // /.End Name Position Description Style		

		// Start Social Style 
		    $this->start_controls_section( 
		    	'section_style_social',
	            [
	                'label' => esc_html__( 'Social', 'themesflat-addons-for-elementor' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );	

	        $this->add_control(
				'social_inner_avatar',
				[
					'label' => esc_html__( 'Social Inner Avatar', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'themesflat-addons-for-elementor' ),
					'label_off' => esc_html__( 'No', 'themesflat-addons-for-elementor' ),
					'return_value' => 'yes',
					'default' => 'no',
					'condition' => [
						'style!' => 'style-2',
					],
				]
			);	

			$this->add_control(
				'social_h_v',
				[
					'label' => esc_html__( 'Social Style', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'horizontal',
					'options' => [
						'horizontal' => esc_html__( 'Horizontal', 'themesflat-addons-for-elementor' ),
						'vertical' => esc_html__( 'Vertical', 'themesflat-addons-for-elementor' )
					],
					'condition' => [
						'style!' => 'style-2',
						'social_inner_avatar' => 'yes'
					],
				]
			);

			$this->add_control(
				'social_h_v_align',
				[
					'label' => esc_html__( 'Social Vertical Alignment', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'themesflat-addons-for-elementor' ),
							'icon' => 'fa fa-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'themesflat-addons-for-elementor' ),
							'icon' => 'fa fa-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'themesflat-addons-for-elementor' ),
							'icon' => 'fa fa-align-right',
						],
					],
					'default' => 'center',
					'toggle' => false,
					'condition' => [
						'style!' => 'style-2',
						'social_inner_avatar' => 'yes',
						'social_h_v' => 'vertical'
					],
				]
			);

		  	$this->add_responsive_control(
				'social_icon_size',
				[
					'label' => esc_html__( 'Font Size', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
						
					],
					'default' => [
						'unit' => 'px',
						'size' => 20,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-box-social .social' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tf-team .team-box-social .social svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'social_padding',
				[
					'label' => esc_html__( 'Padding', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 15,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-box-social .social' => 'padding: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'social_spacer',
				[
					'label' => esc_html__( 'Spacer', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-box-social .social' => 'margin: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tf-team .team-box-social' => 'margin: 0px -{{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control( 
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'social_border',
					'label' => esc_html__( 'Border', 'themesflat-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .tf-team .team-box-social .social',
				]
			);

	        $this->add_responsive_control( 
				'social_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'themesflat-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' , '%' ],
					'selectors' => [
						'{{WRAPPER}} .tf-team .team-box-social .social' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		    $this->end_controls_section();
	    // /.End Social Style

	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();	
		$target = $settings['team_link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $settings['team_link']['nofollow'] ? ' rel="nofollow"' : '';

		$fallback_defaults = [
			'fa fa-facebook',
			'fa fa-twitter',
			'fa fa-google-plus',
		];
		$migration_allowed = \Elementor\Icons_Manager::is_migration_allowed();	
		?>
		<div class="tf-team <?php echo esc_attr($settings['style']) ?>">
			<div class="team-image">
				<a href="<?php echo esc_url($settings['team_link']['url']); ?>" <?php echo esc_attr($target); ?> <?php echo esc_attr($nofollow); ?>>
				<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' ); ?>
				<div class="image-overlay <?php echo esc_attr($settings['image_overlay_effect']); ?>"></div>
				</a>
				
				<?php if ($settings['show_social'] == 'yes') : ?>
					<?php if( $settings['social_inner_avatar'] == 'yes' ) : ?>
						<ul class="team-box-social <?php echo esc_attr($settings['social_h_v']) ?> <?php echo esc_attr($settings['social_h_v_align']) ?> ">
							<?php
								foreach ( $settings['social_icon_list'] as $index => $value ) {
									$class_icon = 'social elementor-repeater-item-' . $value['_id'];

									$migrated = isset( $value['__fa4_migrated']['social_icon'] );
									$is_new = empty( $value['social'] ) && $migration_allowed;
									$social = '';
									// add old default
									if ( empty( $value['social'] ) && ! $migration_allowed ) {
										$value['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
									}
									if ( ! empty( $value['social'] ) ) {
										$social = str_replace( 'fa fa-', '', $value['social'] );
									}
									if ( ( $is_new || $migrated ) && 'svg' !== $value['social_icon']['library'] ) {
										$social = explode( ' ', $value['social_icon']['value'], 2 );
										if ( empty( $social[1] ) ) {
											$social = '';
										} else {
											$social = str_replace( 'fa-', '', $social[1] );
										}
									}
									if ( 'svg' === $value['social_icon']['library'] ) {
										$social = get_post_meta( $value['social_icon']['value']['id'], '_wp_attachment_image_alt', true );
									}
									?>
									<li><a href="<?php echo esc_url($value['social_link']['url']) ?>" class="<?php echo esc_attr($class_icon); ?>">
										<?php
											\Elementor\Icons_Manager::render_icon( $value['social_icon'] ); ?>
									
									</a></li>
							<?php } ?>
						</ul>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<div class="team-content <?php echo esc_attr($settings['content_effect']) ?>">
				<?php if ($settings['team_name'] != ''): ?>
					<<?php echo \Elementor\Utils::validate_html_tag($settings['name_html_tag']) ?> class="team-name">
					<a href="<?php echo esc_url($settings['team_link']['url']); ?>" <?php echo esc_attr($target); ?> <?php echo esc_attr($nofollow); ?>><?php echo esc_attr($settings['team_name']); ?></a>
					</<?php echo \Elementor\Utils::validate_html_tag($settings['name_html_tag']) ?>>
				<?php endif ?>
				<?php if ($settings['team_position'] != ''): ?>
					<div class="team-position"><?php echo esc_attr($settings['team_position']); ?></div>
				<?php endif ?>				
				<?php if ($settings['team_description'] != ''): ?>
					<div class="team-desc"><?php echo esc_attr($settings['team_description']); ?></div>
				<?php endif ?>				
				<?php if ($settings['show_social'] == 'yes') : ?>
					<?php if( $settings['social_inner_avatar'] != 'yes' || $settings['style'] == 'style-2' ) : ?>
						<ul class="team-box-social">
							<?php
								foreach ( $settings['social_icon_list'] as $index => $value ) {
									$class_icon = 'social elementor-repeater-item-' . $value['_id'];

									$migrated = isset( $value['__fa4_migrated']['social_icon'] );
									$is_new = empty( $value['social'] ) && $migration_allowed;
									$social = '';
									// add old default
									if ( empty( $value['social'] ) && ! $migration_allowed ) {
										$value['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
									}
									if ( ! empty( $value['social'] ) ) {
										$social = str_replace( 'fa fa-', '', $value['social'] );
									}
									if ( ( $is_new || $migrated ) && 'svg' !== $value['social_icon']['library'] ) {
										$social = explode( ' ', $value['social_icon']['value'], 2 );
										if ( empty( $social[1] ) ) {
											$social = '';
										} else {
											$social = str_replace( 'fa-', '', $social[1] );
										}
									}
									if ( 'svg' === $value['social_icon']['library'] ) {
										$social = get_post_meta( $value['social_icon']['value']['id'], '_wp_attachment_image_alt', true );
									}
									?>
									<li><a href="<?php echo esc_url($value['social_link']['url']) ?>" class="<?php echo esc_attr($class_icon); ?>">
										<?php
											\Elementor\Icons_Manager::render_icon( $value['social_icon'] ); ?>
									
									</a></li>
							<?php } ?>
						</ul>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}