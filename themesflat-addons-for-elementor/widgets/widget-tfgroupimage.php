<?php 
    class TF_Group_Image_Widget_Free extends \Elementor\Widget_Base {
        /**
         * Get widget name.
         *
         * Retrieve widget name.
         *
         * @since 1.0.0
         * @access public
         * @return string Widget name.
         */
        public function get_name() {
            return 'tf-group-image';
        }
    
        public function get_title() {
            return esc_html__( 'TF Group Images', 'themesflat-addons-for-elementor' );
        }

        public function get_script_depends(){
            return ['simple-parallax','parallax-image'];
        }

        public function get_style_depends()
        {
            return ['tf-animation-item'];
        }
    
        public function get_icon() {
            return 'eicon-hotspot';
        }

        /**
         * Get widget categories.
         *
         * Retrieve the list of categories the tf-contact-form7 widget belongs to.
         *
         * @since 1.0.0
         * @access public
         * @return array Widget categories.
        */
        public function get_categories() {
            return [ 'themesflat_addons' ];
        }

        protected function register_controls() {
                $repeater = new \Elementor\Repeater(); 
                // select image
                $repeater->add_control(
                    'image',
                    [
                        'label' => __( 'Image', 'themesflat-addons-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                        
                    ]
                );
                // image set width
                $repeater->add_responsive_control(
                    'image_width',
                    [
                        'label' => __( 'Image Width', 'themesflat-addons-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => [ 'px', '%', 'rem', 'em' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 1000,
                                'step' => 1,
                            ],
                            '%' => [
                                'min' => 0,
                                'max' => 100,
                                'step' => 1,
                            ],
                            'rem' => [
                                'min' => 0,
                                'max' => 10,
                                'step' => 0.1,
                            ],
                            'em' => [
                                'min' => 0,
                                'max' => 10,
                                'step' => 0.1,
                            ],
                        ],
                        'selectors' => [
                                                        
                            '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: {{SIZE}}{{UNIT}}',                        
                        ],	
                    ]
                );          

                // image set height
                $repeater->add_responsive_control(
                    'image_height',
                    [
                        'label' => __( 'Image Height', 'themesflat-addons-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => [ 'px', '%', 'rem', 'em' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 1000,
                                'step' => 1,
                            ],
                            '%' => [
                                'min' => 0,
                                'max' => 100,
                                'step' => 1,
                            ],
                            'rem' => [
                                'min' => 0,
                                'max' => 10,
                                'step' => 0.1,
                            ],
                            'em' => [
                                'min' => 0,
                                'max' => 10,
                                'step' => 0.1,
                            ],
                        ],
                        'selectors' => [
                                                        
                            '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',                        
                        ],	
                    ]
                ); 

                // set offset left
                $repeater->add_responsive_control(
                    'offset_x',
                    [
                        'label' => __( 'Left Offset', 'themesflat-addons-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => [ 'px', 'rem', 'em' ],
                        'range' => [
                            'px' => [
                                'min' => -1000, 
                                'max' => 1000,
                                'step' => 1,
                            ],
                            'rem' => [
                                'min' => -10,
                                'max' => 10,
                                'step' => 0.1,
                            ],
                            'em' => [
                                'min' => -10,
                                'max' => 10,
                                'step' => 0.1,
                            ],
                        ],
                        'selectors' => [                                                                                                    
                            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'position: absolute; left: {{SIZE}}{{UNIT}};',                       
                        ],	
                        'separator' => 'before',
                    ]
                );
                
                // set offset top
                $repeater->add_responsive_control(
                    'offset_y',
                    [
                        'label' => __( 'Top Offset', 'themesflat-addons-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => [ 'px', 'rem', 'em' ],
                        'range' => [
                            'px' => [
                                'min' => -2000, 
                                'max' => 2000,
                                'step' => 1,
                            ],
                            'rem' => [
                                'min' => -10,
                                'max' => 10,
                                'step' => 0.1,
                            ],
                            'em' => [
                                'min' => -10,
                                'max' => 10,
                                'step' => 0.1,
                            ],
                        ],
                        'selectors' => [                                                                                                    
                            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'position: absolute; top: {{SIZE}}{{UNIT}};',                       
                        ],
                        
                        'separator' => 'before',
                    ]
                );

                $repeater->add_responsive_control( 
                    'img_border_radius',
                    [
                        'label' => esc_html__( 'Border Radius', 'themesflat-addons-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::DIMENSIONS,
                        'size_units' => [ 'px', '%', 'em' ],
                        'selectors' => [
                            '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ]
                );

                $repeater->add_group_control( 
                    \Elementor\Group_Control_Border::get_type(),
                    [
                        'name' => 'img_border_border',
                        'label' => esc_html__( 'Border', 'themesflat-addons-for-elementor' ),
                        'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} img',
                    ]
                );
        
                $repeater->add_group_control( 
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'img_border_box_shadow',
                        'label' => esc_html__( 'Box Shadow', 'themesflat-addons-for-elementor' ),
                        'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} img',
                    ]
                );

                $repeater->add_control( 
					'zindex_item',
		            [
		                'label' => esc_html__( 'Z=index Item', 'themesflat-addons-for-elementor' ),
		                'type' => \Elementor\Controls_Manager::NUMBER,
                        'selectors' => [                                                                                                    
                            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'z-index: {{VALUE}};',                       
                        ],
		            ]
		        );

                // on/off parallax
                $repeater->add_control(
                    'parallax_enable',
                    [
                        'label' => __( 'Enable Parallax', 'themesflat-addons-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::SWITCHER,
                        'label_on' => __( 'On', 'themesflat-addons-for-elementor' ),
                        'label_off' => __( 'Off', 'themesflat-addons-for-elementor' ),
                        'default' => 'no',
                        'return_value' => 'yes',
                        
                    ]
                );          
                
                // choose animation
                $repeater->add_control(
                    'animation',
                    [
                        'label' => __( 'Animation Scroll', 'themesflat-addons-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'default' => '',
                        'options' => [
                            '' => __( 'None', 'themesflat-addons-for-elementor' ),
                            'fade-in' => __( 'Fade In', 'themesflat-addons-for-elementor' ),
                            'fade-in-up' => __( 'Fade In Up', 'themesflat-addons-for-elementor' ),
                            'fade-in-down' => __( 'Fade In Down', 'themesflat-addons-for-elementor' ),
                            'fade-in-left' => __( 'Fade In Left', 'themesflat-addons-for-elementor' ),
                            'fade-in-right' => __( 'Fade In Right', 'themesflat-addons-for-elementor' ),
                            'slide-in-right' => __( 'Slide In Right', 'themesflat-addons-for-elementor' ),
                            'zoom-slide' => __( 'Slide In Right Blur', 'themesflat-addons-for-elementor' ),
                            'slide-up' => __( 'Slide Up', 'themesflat-addons-for-elementor' ),
                            'rotate' => __( 'Rotate In', 'themesflat-addons-for-elementor' ),
                        ],
                        'condition' => [
                            'parallax_enable!' => 'yes',
                        ],
                    ]
                );

                // set delay
                $repeater->add_control(
                    'parallax_delay',
                    [
                        'label' => __( 'Parallax Delay', 'themesflat-addons-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'default' => [
                            'size' => 0,
                        ],
                        'range' => [
                            's' => [
                                'min' => 0,
                                'max' => 2,
                                'step' => 0.1,
                            ],
                        ],
                        'condition' => [
                            'parallax_enable' => 'yes',
                        ],                              
                                       
                    ]
                );
            
                // set scale
                $repeater->add_control(
                    'parallax_scale',
                    [
                        'label' => __( 'Parallax Scale', 'themesflat-addons-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'default' => [
                            'size' => 1.6,
                        ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 3,
                                'step' => 0.1,
                            ],
                        ],
                        'condition' => [
                            'parallax_enable' => 'yes',
                        ],                        
                    ]
                );
            
                // set orientation
                $repeater->add_control(
                    'parallax_orientation',
                    [
                        'label' => __( 'Parallax Orientation', 'themesflat-addons-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => [
                            'up' => __( 'Up', 'themesflat-addons-for-elementor' ),
                            'down' => __( 'Down', 'themesflat-addons-for-elementor' ),
                            'left' => __( 'Left', 'themesflat-addons-for-elementor' ),
                            'right' => __( 'Right', 'themesflat-addons-for-elementor' ),
                        ],
                        'default' => 'left',
                        'condition' => [
                            'parallax_enable' => 'yes',
                        ],                       
                    ]
                );

                //set transition
                $repeater->add_control(
                    'parallax_transition',
                    [
                        'label' => __( 'Transition', 'themesflat-addons-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'default' => 'cubic-bezier(0.25, 0.1, 0.25, 1)',
                        'options' => [
                            'linear' => __( 'Linear', 'themesflat-addons-for-elementor' ),
                            'ease-in' => __( 'Ease In', 'themesflat-addons-for-elementor' ),
                            'ease-out' => __( 'Ease Out', 'themesflat-addons-for-elementor' ),
                            'ease-in-out' => __( 'Ease In Out', 'themesflat-addons-for-elementor' ),                            
                        ],
                        'condition' => [
                            'parallax_enable' => 'yes',
                        ],                        

                    ]
                );

                // set duration
                $repeater->add_control(
                    'transition_duration',
                    [
                        'label' => __( 'Transition Duration', 'themesflat-addons-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::NUMBER,
                        'default' => 0.4,
                        'min' => 0,  
                        'step' => 0.1,  
                        'condition' => [
                            'parallax_enable' => 'yes',
                        ],
                    ]
                );

            $this->start_controls_section(
                'content_section',
                [
                    'label' => esc_html__( 'Content', 'themesflat-addons-for-elementor' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );
        
                $this->add_control(
                    'images_list',
                    [
                        'label' => __( 'Images List', 'themesflat-addons-for-elementor' ),
                        'type' => \Elementor\Controls_Manager::REPEATER,
                        'fields' => $repeater->get_controls(),
                        'default' => [
                            [
                                'image' => [
                                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                                ],
                                'animation' => '',
                                'transition_duration' => 0.4,
                                'parallax_transition' => 'cubic-bezier(0.25, 0.1, 0.25, 1)'
                            ],                            
                        ],
                    ]
                );

            $this->end_controls_section();

        }

        protected function render() {

            $settings = $this->get_settings_for_display();               
            ?>
                <div class="tf-image-group-widget">
                    <?php foreach ($settings['images_list'] as $index => $item) { 
                        if ( ! empty( $item['image']['url'] ) ) {
                            $animation = isset( $item['animation'] ) ? esc_attr($item['animation']) : '';
                            $parallax_scale = isset( $item['parallax_scale'] ) ? esc_attr($item['parallax_scale']['size'])  : '';
                            $parallax_delay = isset( $item['parallax_delay'] ) ? esc_attr($item['parallax_delay']['size'])  : '';
                            $parallax_orientation = isset( $item['parallax_orientation'] ) ? esc_attr($item['parallax_orientation'])  : '';
                            $parallax_transition = isset( $item['parallax_transition'] ) ? esc_attr($item['parallax_transition']) : '';
                            $parallaxx_duration = isset( $item['transition_duration'] ) ? esc_attr($item['transition_duration']) : '0.4';
                            $show_animation = isset( $item['parallax_enable'] ) ? $animation : '';
                            
                    ?>
                        <div class="elementor-repeater-item-<?php echo esc_attr($item['_id']); ?> <?php echo $show_animation; ?>  tf-image-item tf-image-group-widget-item-<?php echo ($index + 1); ?>">                            
                            <div class="inner-animate">
                                <img src="<?php echo esc_url($item['image']['url']); ?>" data-parallax-transition="<?php echo $parallax_transition; ?>" data-parallax-duration="<?php echo $parallaxx_duration; ?>" data-parallax-scale="<?php echo $parallax_scale; ?>" data-parallax-delay="<?php echo $parallax_delay; ?>" data-parallax-orientation="<?php echo $parallax_orientation; ?>"  alt="">
                            </div>
                        </div>
                    <?php }} ?>
                    
                </div>
            <?php 
        
        }              
                
    }
