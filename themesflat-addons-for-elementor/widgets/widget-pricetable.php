<?php

//namespace PriceTable_Widgets\Widgets;

use Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

//class PriceTable extends Widget_Base
class TFPriceTable_Widget_Free extends \Elementor\Widget_Base {

  public function get_name()
  {
    return 'PriceTable';
  }

  public function get_title()
  {
    return esc_html__('TF Price Table', 'ptable-widgets');
  }

  public function get_icon()
  {
    return 'eicon-price-table';
  }

  public function get_categories()
  {
    return ['themesflat_addons'];
  }

  public function get_style_depends()
  {
    return ['font-awesome', 'tf-price-table'];
  }

  protected function content_controls()
  {
    //Header Sections
    $this->start_controls_section(
      '_section_header',
      [
        'label' => esc_attr__('Header', 'ptable-widgets'),
        'tab' => Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'title',
      [
        'label' => esc_attr__('Title', 'ptable-widgets'),
        'type' => Controls_Manager::TEXT,
        'label_block' => false,
        'default' => esc_attr__('Basic', 'ptable-widgets'),
        'dynamic' => [
          'active' => true
        ]
      ]
    );

    $this->add_control(
      'title_position',
      [
        'label' => esc_attr__('Position', 'ptable-widgets'),
        'type' => Controls_Manager::SELECT,
        'default' => 'before_header',
        'options' => [
          'after_price' => esc_attr__('After Price', 'ptable-widgets'),
          'before_price' => esc_attr__('Before Price', 'ptable-widgets'),
        ],
        'style_transfer' => true,
      ]
    );

    $this->add_control(
      'title_description',
      [
        'label' => esc_attr__('Description', 'ptable-widgets'),
        'type' => Controls_Manager::TEXTAREA,
        'default' => esc_attr__('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.', 'ptable-widgets'),
        'placeholder' => esc_attr__('Type description', 'ptable-widgets'),
        'dynamic' => [
          'active' => true
        ]
      ]
    );

    $this->add_control(
      'media_type',
      [
        'label' => esc_attr__('Media Type', 'ptable-widgets'),
        'type' => Controls_Manager::CHOOSE,
        'label_block' => false,
        'separator' => 'before',
        'options' => [
          'icon' => [
            'title' => esc_attr__('Icon', 'ptable-widgets'),
            'icon' => 'eicon-star',
          ],
          'image' => [
            'title' => esc_attr__('Image', 'ptable-widgets'),
            'icon' => 'eicon-image',
          ],
        ],
        'default' => 'icon',
        'toggle' => false,
        'style_transfer' => true,
      ]
    );

    $this->add_control(
      'icon',
      [
        'label' => esc_attr__('Icon', 'ptable-widgets'),
        'type' => Controls_Manager::ICONS,
        'default' => [
          'value' => 'fa fa-heart',
          'library' => 'solid',
        ],
        'condition' => [
          'media_type' => 'icon'
        ],
      ]
    );

    $this->add_control(
      'image',
      [
        'label' => esc_attr__('Image', 'ptable-widgets'),
        'type' => Controls_Manager::MEDIA,
        'default' => [
          'url' => Utils::get_placeholder_image_src(),
        ],
        'condition' => [
          'media_type' => 'image'
        ],
        'dynamic' => [
          'active' => true,
        ]
      ]
    );

    $this->add_group_control(
      Group_Control_Image_Size::get_type(),
      [
        'name' => 'media_thumbnail',
        'default' => 'full',
        'separator' => 'none',
        'exclude' => [
          'custom',
        ],
        'condition' => [
          'media_type' => 'image'
        ]
      ]
    );

    $this->add_control(
      'icon_position',
      [
        'label' => esc_attr__('Position', 'ptable-widgets'),
        'type' => Controls_Manager::SELECT,
        'default' => 'before_header',
        'options' => [
          'after_header' => esc_attr__('After Title', 'ptable-widgets'),
          'before_header' => esc_attr__('Before Title', 'ptable-widgets'),
          'before_header_over' => esc_attr__('Before Title Over', 'ptable-widgets'),
        ],
        'style_transfer' => true,
      ]
    );

    $this->end_controls_section();

    //Pricing Sections
    $this->start_controls_section(
      '_section_pricing',
      [
        'label' => esc_attr__('Pricing', 'ptable-widgets'),
        'tab' => Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'currency',
      [
        'label' => esc_attr__('Currency', 'ptable-widgets'),
        'type' => Controls_Manager::SELECT,
        'label_block' => false,
        'options' => [
          '' => esc_attr__('None', 'ptable-widgets'),
          'baht' => '&#3647; ' . _x('Baht', 'Currency Symbol', 'ptable-widgets'),
          'bdt' => '&#2547; ' . _x('BD Taka', 'Currency Symbol', 'ptable-widgets'),
          'dollar' => '&#36; ' . _x('Dollar', 'Currency Symbol', 'ptable-widgets'),
          'euro' => '&#128; ' . _x('Euro', 'Currency Symbol', 'ptable-widgets'),
          'franc' => '&#8355; ' . _x('Franc', 'Currency Symbol', 'ptable-widgets'),
          'guilder' => '&fnof; ' . _x('Guilder', 'Currency Symbol', 'ptable-widgets'),
          'krona' => 'kr ' . _x('Krona', 'Currency Symbol', 'ptable-widgets'),
          'lira' => '&#8356; ' . _x('Lira', 'Currency Symbol', 'ptable-widgets'),
          'peseta' => '&#8359 ' . _x('Peseta', 'Currency Symbol', 'ptable-widgets'),
          'peso' => '&#8369; ' . _x('Peso', 'Currency Symbol', 'ptable-widgets'),
          'pound' => '&#163; ' . _x('Pound Sterling', 'Currency Symbol', 'ptable-widgets'),
          'real' => 'R$ ' . _x('Real', 'Currency Symbol', 'ptable-widgets'),
          'ruble' => '&#8381; ' . _x('Ruble', 'Currency Symbol', 'ptable-widgets'),
          'rupee' => '&#8360; ' . _x('Rupee', 'Currency Symbol', 'ptable-widgets'),
          'indian_rupee' => '&#8377; ' . _x('Rupee (Indian)', 'Currency Symbol', 'ptable-widgets'),
          'shekel' => '&#8362; ' . _x('Shekel', 'Currency Symbol', 'ptable-widgets'),
          'won' => '&#8361; ' . _x('Won', 'Currency Symbol', 'ptable-widgets'),
          'yen' => '&#165; ' . _x('Yen/Yuan', 'Currency Symbol', 'ptable-widgets'),
          'custom' => esc_attr__('Custom', 'ptable-widgets'),
        ],
        'default' => 'dollar',
        'dynamic' => [
          'active' => true
        ]
      ]
    );

    $this->add_control(
      'currency_custom',
      [
        'label' => esc_attr__('Custom Symbol', 'ptable-widgets'),
        'type' => Controls_Manager::TEXT,
        'condition' => [
          'currency' => 'custom',
        ],
      ]
    );

    $this->add_control(
      'price',
      [
        'label' => esc_attr__('Price', 'ptable-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => '9.99',
        'dynamic' => [
          'active' => true
        ]
      ]
    );

    $this->add_control(
      'original_price',
      [
        'label' => esc_attr__('Original Price', 'ptable-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => '8.99',
        'dynamic' => [
          'active' => true
        ]
      ]
    );

    $this->add_control(
      'period',
      [
        'label' => esc_attr__('Period', 'ptable-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_attr__('Per Month', 'ptable-widgets'),
        'dynamic' => [
          'active' => true
        ]
      ]
    );

    $this->add_control(
      'price_position',
      [
        'label' => esc_attr__('Position', 'ptable-widgets'),
        'type' => Controls_Manager::SELECT,
        'default' => 'after_header',
        'options' => [
          'after_header' => esc_attr__('After Header', 'ptable-widgets'),
          'before_button' => esc_attr__('Before Button', 'ptable-widgets'),
        ],
        'style_transfer' => true,
      ]
    );

    $this->end_controls_section();


    //Features & Description Sections
    $this->start_controls_section(
      '_section_features_and_description',
      [
        'label' => esc_attr__('Features & Description', 'ptable-widgets'),
      ]
    );

    $this->add_control(
      'features_title',
      [
        'label' => esc_attr__('Title', 'ptable-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_attr__('Features', 'ptable-widgets'),
        'separator' => 'after',
        'dynamic' => [
          'active' => true
        ]
      ]
    );

    $repeater = new Repeater();

    if (self::elementor_version('<', '2.6.0')) {
      $repeater->add_control(
        'icon',
        [
          'label' => esc_attr__('Icon', 'ptable-widgets'),
          'type' => Controls_Manager::ICON,
          'label_block' => false,
          'default' => 'fa fa-check',
          'include' => [
            'fa fa-check',
            'fa fa-close',
          ]
        ]
      );
    } else {
      $repeater->add_control(
        'selected_icon',
        [
          'label' => esc_attr__('Icon', 'ptable-widgets'),
          'type' => Controls_Manager::ICONS,
          'fa4compatibility' => 'icon',
          'default' => [
            'value' => 'fa fa-check',
            'library' => 'fa-solid',
          ],
          'recommended' => [
            'fa-regular' => [
              'check-square',
              'window-close',
            ],
            'fa-solid' => [
              'check',
            ]
          ]
        ]
      );
    }

    $repeater->add_control(
      'text',
      [
        'label' => esc_attr__('Text', 'ptable-widgets'),
        'type' => Controls_Manager::TEXTAREA,
        'default' => esc_attr__('Exciting Feature', 'ptable-widgets'),
        'dynamic' => [
          'active' => true
        ]
      ]
    );

    $repeater->add_control(
      'tooltip_text',
      [
        'label' => esc_attr__('Tooltip Text', 'ptable-widgets'),
        'type' => Controls_Manager::TEXTAREA,
        'dynamic' => [
          'active' => true
        ]
      ]
    );

    $this->add_control(
      'features_list',
      [
        'type' => Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'show_label' => false,
        'prevent_empty' => false,
        'default' => [
          [
            'icon' => 'fa fa-check',
            'text' => esc_attr__('Standard Feature', 'ptable-widgets'),
          ],
          [
            'icon' => 'fa fa-check',
            'text' => esc_attr__('Another Great Feature', 'ptable-widgets'),
            'tooltip_text' => esc_attr__('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'ptable-widgets'),
          ],
          [
            'icon' => 'fa fa-close',
            'text' => esc_attr__('Obsolete Feature', 'ptable-widgets'),
          ],
          [
            'icon' => 'fa fa-check',
            'text' => esc_attr__('Exciting Feature', 'ptable-widgets'),
          ],
        ],
      ]
    );

    $this->add_control(
      'description',
      [
        'label' => esc_attr__('Description', 'ptable-widgets'),
        'type' => Controls_Manager::TEXTAREA,
        'default' => esc_attr__('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.', 'ptable-widgets'),
        'placeholder' => esc_attr__('Type description', 'ptable-widgets'),
        'dynamic' => [
          'active' => true
        ]
      ]
    );

    $this->add_control(
      'features_alignment',
      [
        'label' => esc_attr__('Features Alignment', 'ptable-widgets'),
        'type' => Controls_Manager::CHOOSE,
        'label_block' => false,
        'options' => [
          'left' => [
            'title' => esc_attr__('Left', 'ptable-widgets'),
            'icon' => 'fa fa-align-left',
          ],
          'center' => [
            'title' => esc_attr__('Center', 'ptable-widgets'),
            'icon' => 'fa fa-align-center',
          ],
          'right' => [
            'title' => esc_attr__('Right', 'ptable-widgets'),
            'icon' => 'fa fa-align-right',
          ],
        ],
        'toggle' => false,
        'selectors' => [
          '{{WRAPPER}} .ptable-body' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_section();


    //Footer Section
    $this->start_controls_section(
      '_section_footer',
      [
        'label' => esc_attr__('Footer', 'ptable-widgets'),
        'tab' => Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'button_text',
      [
        'label' => esc_attr__('Button Text', 'ptable-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_attr__('Subscribe', 'ptable-widgets'),
        'placeholder' => esc_attr__('Type button text here', 'ptable-widgets'),
        'label_block' => false,
        'dynamic' => [
          'active' => true
        ]
      ]
    );

    $this->add_control(
      'button_link',
      [
        'label' => esc_attr__('Link', 'ptable-widgets'),
        'type' => Controls_Manager::URL,
        'label_block' => true,
        'placeholder' => 'https://domainname.com/',
        'dynamic' => [
          'active' => true,
        ],
      ]
    );

    $this->add_control(
      'footer_description',
      [
        'label' => esc_attr__('Footer Description', 'ptable-widgets'),
        'show_label' => true,
        'type' => Controls_Manager::TEXTAREA,
        'dynamic' => [
          'active' => true,
        ],
        'separator' => 'before',
      ]
    );

    $this->end_controls_section();


    //Badge Section
    $this->start_controls_section(
      '_section_badge',
      [
        'label' => esc_attr__('Badge', 'ptable-widgets'),
      ]
    );

    $this->add_control(
      'show_badge',
      [
        'label' => esc_attr__('Show', 'ptable-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_attr__('Show', 'ptable-widgets'),
        'label_off' => esc_attr__('Hide', 'ptable-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
        'style_transfer' => true,
      ]
    );

    $this->add_control(
      'badge_text',
      [
        'label' => esc_attr__('Badge Text', 'ptable-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_attr__('SALE OFF', 'ptable-widgets'),
        'placeholder' => esc_attr__('Type badge text', 'ptable-widgets'),
        'condition' => [
          'show_badge' => 'yes'
        ],
        'dynamic' => [
          'active' => true
        ]
      ]
    );

    $this->add_control(
      'badge_position',
      [
        'label' => esc_attr__('Position', 'ptable-widgets'),
        'type' => Controls_Manager::CHOOSE,
        'label_block' => false,
        'options' => [
          'left' => [
            'title' => esc_attr__('Left', 'ptable-widgets'),
            'icon' => 'eicon-h-align-left',
          ],
          'right' => [
            'title' => esc_attr__('Right', 'ptable-widgets'),
            'icon' => 'eicon-h-align-right',
          ],
        ],
        'toggle' => false,
        'default' => 'left',
        'style_transfer' => true,
        'condition' => [
          'show_badge' => 'yes'
        ]
      ]
    );

    $this->end_controls_section();

  }

  protected function style_controls()
  {
    //General Style
    $this->start_controls_section(
      '_section_style_general',
      [
        'label' => esc_attr__('General', 'ptable-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'general_area_padding',
      [
        'label' => esc_attr__('Padding', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'text_color',
      [
        'label' => esc_attr__('Text Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-icon,'
          . '{{WRAPPER}} .ptable-title,'
          . '{{WRAPPER}} .ptable-currency,'
          . '{{WRAPPER}} .ptable-period,'
          . '{{WRAPPER}} .ptable-features-title,'
          . '{{WRAPPER}} .ptable-features-list li,'
          . '{{WRAPPER}} .ptable-price-text,'
          . '{{WRAPPER}} .ptable-description,'
          . '{{WRAPPER}} .ptable-footer-description' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'overflow',
      [
        'label' => esc_attr__('Overflow', 'ptable-widgets'),
        'type' => Controls_Manager::SELECT,
        'label_block' => false,
        'options' => [
          '' => esc_attr__('Default', 'ptable-widgets'),
          'hidden' => esc_attr__('Hidden', 'ptable-widgets'),
        ],
        'toggle' => false,
        'selectors' => [
          '{{WRAPPER}} ' => 'overflow: {{VALUE}}',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Text_Shadow::get_type(),
      [
        'name' => 'general_shadow',
        'selector' => '{{WRAPPER}} ',
      ]
    );

    $this->add_control(
      'alignment',
      [
        'label' => esc_attr__('Alignment', 'ptable-widgets'),
        'type' => Controls_Manager::CHOOSE,
        'label_block' => false,
        'options' => [
          'left' => [
            'title' => esc_attr__('Left', 'ptable-widgets'),
            'icon' => 'fa fa-align-left',
          ],
          'center' => [
            'title' => esc_attr__('Center', 'ptable-widgets'),
            'icon' => 'fa fa-align-center',
          ],
          'right' => [
            'title' => esc_attr__('Right', 'ptable-widgets'),
            'icon' => 'fa fa-align-right',
          ],
        ],
        'toggle' => false,
        'selectors' => [
          '{{WRAPPER}}' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_section();


    //Header Style
    $this->start_controls_section(
      '_section_style_header',
      [
        'label' => esc_attr__('Header', 'ptable-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'header_area_header',
      [
        'label' => esc_attr__('Container', 'ptable-widgets'),
        'type' => Controls_Manager::HEADING,
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name' => 'header_area_background',
        'label' => esc_attr__('Background', 'ptable-widgets'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .ptable-header',
      ]
    );

    $this->add_control(
      'media_style_header',
      [
        'label' => esc_attr__('Media', 'ptable-widgets'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before'
      ]
    );

    $this->add_control(
      'header_area_position_left',
      [
        'label' => esc_attr__('Header Position Left', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', 'em', '%'],
        'range' => [
          'px' => [
            'min' => -1000,
            'max' => 1000,
            'step' => 1,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .ptable-header' => 'position:relative;',
          '{{WRAPPER}} .ptable-header .ptable-media' => 'left: {{SIZE}}{{UNIT}};position:absolute;',
        ],
        'conditions' => array(
          'terms' => array(
            array(
              'name' => 'icon_position',
              'operator' => '==',
              'value' => 'before_header_over',
            ),
          ),
        ),
      ]
    );

    $this->add_control(
      'header_area_position_right',
      [
        'label' => esc_attr__('Header Position Right', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', 'em', '%'],
        'range' => [
          'px' => [
            'min' => -1000,
            'max' => 1000,
            'step' => 1,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .ptable-header' => 'position:relative;',
          '{{WRAPPER}} .ptable-header .ptable-media' => 'right: {{SIZE}}{{UNIT}};position:absolute;',
        ],
        'conditions' => array(
          'terms' => array(
            array(
              'name' => 'icon_position',
              'operator' => '==',
              'value' => 'before_header_over',
            ),
          ),
        ),
      ]
    );

    $this->add_control(
      'header_area_position_top',
      [
        'label' => esc_attr__('Header Position Top', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', 'em', '%'],
        'range' => [
          'px' => [
            'min' => -1000,
            'max' => 1000,
            'step' => 1,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .ptable-header' => 'position:relative;',
          '{{WRAPPER}} .ptable-header .ptable-media' => 'top: {{SIZE}}{{UNIT}};position:absolute;',
        ],
        'conditions' => array(
          'terms' => array(
            array(
              'name' => 'icon_position',
              'operator' => '==',
              'value' => 'before_header_over',
            ),
          ),
        ),
      ]
    );

    $this->add_control(
      'header_area_position_bottom',
      [
        'label' => esc_attr__('Header Position Bottom', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', 'em', '%'],
        'range' => [
          'px' => [
            'min' => -1000,
            'max' => 1000,
            'step' => 1,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .ptable-header' => 'position:relative;',
          '{{WRAPPER}} .ptable-header .ptable-media' => 'bottom: {{SIZE}}{{UNIT}};position:absolute;',
        ],
        'conditions' => array(
          'terms' => array(
            array(
              'name' => 'icon_position',
              'operator' => '==',
              'value' => 'before_header_over',
            ),
          ),
        ),
      ]
    );

    $this->add_control(
      'header_area_padding',
      [
        'label' => esc_attr__('Padding', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'media_title_spacing',
      [
        'label' => esc_attr__('Media Width', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 10000,
            'step' => 1,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .ptable-media' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'media_padding',
      [
        'label' => esc_attr__('Media Padding', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-media' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'header_text_padding',
      [
        'label' => esc_attr__('Header Text Padding', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-txt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name' => 'header_border',
        'label' => esc_attr__('Header Border', 'ptable-widgets'),
        'selector' => '{{WRAPPER}} .ptable-header',
      ]
    );

    $this->add_responsive_control(
      'media_border_radius',
      [
        'label' => esc_attr__('Media Boder Radius', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name' => 'media_bg_color',
        'label' => esc_attr__('Media Background Color', 'ptable-widgets'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .ptable-media',
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name' => 'media_border',
        'label' => esc_attr__('Media Border', 'ptable-widgets'),
        'selector' => '{{WRAPPER}} .ptable-media',
      ]
    );

    $this->add_control(
      'title_style_header',
      [
        'label' => esc_attr__('Title', 'ptable-widgets'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before'
      ]
    );

    $this->add_responsive_control(
      'title_spacing',
      [
        'label' => esc_attr__('Bottom Spacing', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'selectors' => [
          '{{WRAPPER}} .ptable-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name' => 'title_bg_color',
        'label' => esc_attr__('Media Background Color', 'ptable-widgets'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .ptable-txt > h2',
      ]
    );

    $this->add_control(
      'title_color',
      [
        'label' => esc_attr__('Title Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-title' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'title_typography',
        'selector' => '{{WRAPPER}} .ptable-title',
      ]
    );

    $this->add_group_control(
      Group_Control_Text_Shadow::get_type(),
      [
        'name' => 'title_text_shadow',
        'selector' => '{{WRAPPER}} .ptable-title',
      ]
    );

    $this->add_control(
      'description_style_header',
      [
        'label' => esc_attr__('Description', 'ptable-widgets'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before'
      ]
    );

    $this->add_control(
      'description_style_color',
      [
        'label' => esc_attr__('Description Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-title-description' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'description_title_typography',
        'selector' => '{{WRAPPER}} .ptable-title-description',
      ]
    );

    $this->add_group_control(
      Group_Control_Text_Shadow::get_type(),
      [
        'name' => 'description_text_shadow',
        'selector' => '{{WRAPPER}} .ptable-title-description',
      ]
    );

    $this->add_control(
      'icon_style_header',
      [
        'label' => esc_attr__('Media', 'ptable-widgets'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'icon_size',
      [
        'label' => esc_attr__('Size', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'max' => 500,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .ptable-media--icon > i' => 'font-size: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} .ptable-media--icon > svg' => 'width: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} .ptable-media--image > img' => 'width: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'icon_spacing',
      [
        'label' => esc_attr__('Bottom Spacing', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'selectors' => [
          '{{WRAPPER}} .ptable-media' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'icon_color',
      [
        'label' => esc_attr__('Icon Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-media--icon > i' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'media_type' => 'icon',
        ]
      ]
    );

    $this->add_control(
      'show_icon',
      [
        'label' => esc_attr__('Show icon & media', 'ptable-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_attr__('Show', 'ptable-widgets'),
        'label_off' => esc_attr__('Hide', 'ptable-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
        'style_transfer' => true,
      ]
    );

    $this->add_control(
      'header_alignment',
      [
        'label' => esc_attr__('Header Alignment', 'ptable-widgets'),
        'type' => Controls_Manager::CHOOSE,
        'label_block' => false,
        'options' => [
          'left' => [
            'title' => esc_attr__('Left', 'ptable-widgets'),
            'icon' => 'fa fa-align-left',
          ],
          'center' => [
            'title' => esc_attr__('Center', 'ptable-widgets'),
            'icon' => 'fa fa-align-center',
          ],
          'right' => [
            'title' => esc_attr__('Right', 'ptable-widgets'),
            'icon' => 'fa fa-align-right',
          ],
        ],
        'toggle' => false,
        'selectors' => [
          '{{WRAPPER}} .ptable-header' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'title_alignment',
      [
        'label' => esc_attr__('Title Alignment', 'ptable-widgets'),
        'type' => Controls_Manager::CHOOSE,
        'label_block' => false,
        'options' => [
          'left' => [
            'title' => esc_attr__('Left', 'ptable-widgets'),
            'icon' => 'fa fa-align-left',
          ],
          'center' => [
            'title' => esc_attr__('Center', 'ptable-widgets'),
            'icon' => 'fa fa-align-center',
          ],
          'right' => [
            'title' => esc_attr__('Right', 'ptable-widgets'),
            'icon' => 'fa fa-align-right',
          ],
        ],
        'toggle' => false,
        'selectors' => [
          '{{WRAPPER}} .ptable-title' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'description_alignment',
      [
        'label' => esc_attr__('Description Alignment', 'ptable-widgets'),
        'type' => Controls_Manager::CHOOSE,
        'label_block' => false,
        'options' => [
          'left' => [
            'title' => esc_attr__('Left', 'ptable-widgets'),
            'icon' => 'fa fa-align-left',
          ],
          'center' => [
            'title' => esc_attr__('Center', 'ptable-widgets'),
            'icon' => 'fa fa-align-center',
          ],
          'right' => [
            'title' => esc_attr__('Right', 'ptable-widgets'),
            'icon' => 'fa fa-align-right',
          ],
        ],
        'toggle' => false,
        'selectors' => [
          '{{WRAPPER}} .ptable-txt' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_section();


    //Pricing Style
    $this->start_controls_section(
      '_section_style_pricing',
      [
        'label' => esc_attr__('Pricing', 'ptable-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'show_pricing',
      [
        'label' => esc_attr__('Show pricing', 'ptable-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_attr__('Show', 'ptable-widgets'),
        'label_off' => esc_attr__('Hide', 'ptable-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
        'style_transfer' => true,
      ]
    );

    $this->add_control(
      'show_two_pricing',
      [
        'label' => esc_attr__('Show two line pricing', 'ptable-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_attr__('Show', 'ptable-widgets'),
        'label_off' => esc_attr__('Hide', 'ptable-widgets'),
        'return_value' => 'true',
        'default' => '',
      ]
    );

    $this->add_control(
      'price_alignment',
      [
        'label' => esc_attr__('Price Alignment', 'ptable-widgets'),
        'type' => Controls_Manager::CHOOSE,
        'label_block' => false,
        'options' => [
          'left' => [
            'title' => esc_attr__('Left', 'ptable-widgets'),
            'icon' => 'fa fa-align-left',
          ],
          'center' => [
            'title' => esc_attr__('Center', 'ptable-widgets'),
            'icon' => 'fa fa-align-center',
          ],
          'right' => [
            'title' => esc_attr__('Right', 'ptable-widgets'),
            'icon' => 'fa fa-align-right',
          ],
        ],
        'toggle' => false,
        'selectors' => [
          '{{WRAPPER}} .ptable-price' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      '_header_pricing_area',
      [
        'label' => esc_attr__('Pricing Area', 'ptable-widgets'),
        'type' => Controls_Manager::HEADING,
      ]
    );

    $this->add_control(
      'pricing_area_padding',
      [
        'label' => esc_attr__('Padding', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name' => 'pricing_area_background',
        'label' => esc_attr__('Background', 'ptable-widgets'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .ptable-price',
      ]
    );

    $this->add_control(
      '_heading_price',
      [
        'type' => Controls_Manager::HEADING,
        'label' => esc_attr__('Price', 'ptable-widgets'),
        'separator' => 'before'
      ]
    );

    $this->add_responsive_control(
      'price_spacing',
      [
        'label' => esc_attr__('Bottom Spacing', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'selectors' => [
          '{{WRAPPER}} .ptable-price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'price_color',
      [
        'label' => esc_attr__('Text Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-price-text' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'price_typography',
        'selector' => '{{WRAPPER}} .ptable-price-text',
      ]
    );

    $this->add_control(
      '_heading_currency',
      [
        'type' => Controls_Manager::HEADING,
        'label' => esc_attr__('Currency', 'ptable-widgets'),
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'currency_spacing',
      [
        'label' => esc_attr__('Side Spacing', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'selectors' => [
          '{{WRAPPER}} .ptable-currency' => 'margin-right: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'currency_position',
      [
        'label' => esc_attr__('Position', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => -100,
            'max' => 100,
            'step' => 1,
          ]
        ],
        'selectors' => [
          '{{WRAPPER}} .ptable-current-price .ptable-currency' => 'top: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'currency_color',
      [
        'label' => esc_attr__('Text Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-currency' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'currency_typography',
        'selector' => '{{WRAPPER}} .ptable-currency',
      ]
    );

    $this->add_control(
      '_heading_original_price',
      [
        'type' => Controls_Manager::HEADING,
        'label' => esc_attr__('Original Price', 'ptable-widgets'),
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'original_price_spacing',
      [
        'label' => esc_attr__('Side Spacing', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => -100,
            'max' => 100,
            'step' => 1,
          ]
        ],
        'selectors' => [
          '{{WRAPPER}} .ptable-original-price' => 'margin-right: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'original_price_position',
      [
        'label' => esc_attr__('Position', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => -100,
            'max' => 100,
            'step' => 1,
          ]
        ],
        'selectors' => [
          '{{WRAPPER}} .ptable-original-price .ptable-currency,'
          . '{{WRAPPER}} .ptable-original-price .ptable-price-text' => 'top: {{SIZE}}{{UNIT}};position:relative;',
        ],
      ]
    );


    $this->add_control(
      'original_price_color',
      [
        'label' => esc_attr__('Text Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-original-price .ptable-currency' => 'color: {{VALUE}};',
          '{{WRAPPER}} .ptable-original-price .ptable-price-text' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'original_price_typography',
        'selector' => '{{WRAPPER}} .ptable-original-price .ptable-currency,{{WRAPPER}} .ptable-original-price .ptable-price-text',
      ]
    );

    $this->add_control(
      '_heading_period',
      [
        'type' => Controls_Manager::HEADING,
        'label' => esc_attr__('Period', 'ptable-widgets'),
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'period_spacing',
      [
        'label' => esc_attr__('Bottom Spacing', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'selectors' => [
          '{{WRAPPER}} .ptable-price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'period_color',
      [
        'label' => esc_attr__('Text Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-period' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'period_typography',
        'selector' => '{{WRAPPER}} .ptable-period',
      ]
    );

    $this->end_controls_section();


    //Features & Description Style
    $this->start_controls_section(
      '_section_style_features_description',
      [
        'label' => esc_attr__('Features & Description', 'ptable-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'show_features',
      [
        'label' => esc_attr__('Show', 'ptable-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_attr__('Show', 'ptable-widgets'),
        'label_off' => esc_attr__('Hide', 'ptable-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
        'style_transfer' => true,
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name' => 'features_border',
        'selector' => '{{WRAPPER}} .ptable-features-list li',
      ]
    );

    $this->add_control(
      'features_header_alignment',
      [
        'label' => esc_attr__('Header Features Alignment', 'ptable-widgets'),
        'type' => Controls_Manager::CHOOSE,
        'label_block' => false,
        'options' => [
          'left' => [
            'title' => esc_attr__('Left', 'ptable-widgets'),
            'icon' => 'fa fa-align-left',
          ],
          'center' => [
            'title' => esc_attr__('Center', 'ptable-widgets'),
            'icon' => 'fa fa-align-center',
          ],
          'right' => [
            'title' => esc_attr__('Right', 'ptable-widgets'),
            'icon' => 'fa fa-align-right',
          ],
        ],
        'toggle' => false,
        'selectors' => [
          '{{WRAPPER}} .ptable-body' => 'text-align: {{VALUE}}',
        ],
      ]
    );


    $this->add_control(
      '_heading_features',
      [
        'type' => Controls_Manager::HEADING,
        'label' => esc_attr__('Features', 'ptable-widgets'),
      ]
    );

    $this->add_responsive_control(
      'features_container_spacing',
      [
        'label' => esc_attr__('Container Bottom Spacing', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'selectors' => [
          '{{WRAPPER}} .ptable-body' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'features_container_padding',
      [
        'label' => esc_attr__('Container Padding', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      '_heading_features_title',
      [
        'type' => Controls_Manager::HEADING,
        'label' => esc_attr__('Title', 'ptable-widgets'),
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'features_title_spacing',
      [
        'label' => esc_attr__('Bottom Spacing', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'selectors' => [
          '{{WRAPPER}} .ptable-features-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'features_title_color',
      [
        'label' => esc_attr__('Text Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-features-title' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'features_title_typography',
        'selector' => '{{WRAPPER}} .ptable-features-title',
      ]
    );

    $this->add_control(
      '_heading_features_list',
      [
        'type' => Controls_Manager::HEADING,
        'label' => esc_attr__('List', 'ptable-widgets'),
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'features_list_spacing',
      [
        'label' => esc_attr__('Spacing Between', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px'],
        'selectors' => [
          '{{WRAPPER}} .ptable-features-list > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'features_list_padding',
      [
        'label' => esc_attr__('List Padding', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-features-list > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'features_list_color',
      [
        'label' => esc_attr__('Text Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-features-list > li' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name' => 'features_list_bgcolor_odd',
        'label' => esc_attr__('Background Odd', 'ptable-widgets'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .ptable-features-list > li:nth-child(odd)',
        'separator' => 'before',
        'exclude' => [
          'image',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name' => 'features_list_bgcolor_even',
        'label' => esc_attr__('Background Even', 'ptable-widgets'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .ptable-features-list > li:nth-child(even)',
        'separator' => 'before',
        'exclude' => [
          'image',
        ],
      ]
    );

    $this->add_control(
      'features_list_color_icon',
      [
        'label' => esc_attr__('Icon Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-features-list > li i' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'features_list_typography',
        'selector' => '{{WRAPPER}} .ptable-features-list > li',
      ]
    );

    $this->add_control(
      '_heading_description_style',
      [
        'type' => Controls_Manager::HEADING,
        'label' => esc_attr__('Description', 'ptable-widgets'),
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'description_spacing',
      [
        'label' => esc_attr__('Bottom Spacing', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => -1000,
            'max' => 1000,
          ]
        ],
        'selectors' => [
          '{{WRAPPER}} .ptable-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'description__padding',
      [
        'label' => esc_attr__('Padding', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'description_color',
      [
        'label' => esc_attr__('Text Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-description' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'description_typography',
        'selector' => '{{WRAPPER}} .ptable-description',
      ]
    );
    $this->end_controls_section();


    //Features Tooltip Style
    $this->start_controls_section(
      '_section_style_tooltip',
      [
        'label' => esc_attr__('Features Tooltip', 'ptable-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'price_tooltip_padding',
      [
        'label' => esc_attr__('Padding', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-feature-tooltip-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'price_tooltip_border_radius',
      [
        'label' => esc_attr__('Border Radius', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-feature-tooltip-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name' => 'price_tooltip_border',
        'label' => esc_attr__('Border', 'ptable-widgets'),
        'selector' => '{{WRAPPER}} .ptable-feature-tooltip-text',
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name' => 'price_tooltip_background',
        'label' => esc_attr__('Background', 'ptable-widgets'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .ptable-feature-tooltip-text',
        'separator' => 'before',
        'exclude' => [
          'image',
        ],
      ]
    );

    $this->add_control(
      'price_tooltip_color',
      [
        'label' => esc_attr__('Text Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-feature-tooltip-text' => 'color: {{VALUE}};',
        ],
        'separator' => 'before',
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'price_tooltip_typography',
        'selector' => '{{WRAPPER}} .ptable-feature-tooltip-text',
      ]
    );
    $this->end_controls_section();


    //Footer -> Button and Footer Description
    $this->start_controls_section(
      '_section_style_footer',
      [
        'label' => esc_attr__('Footer', 'ptable-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'show_footer',
      [
        'label' => esc_attr__('Show', 'ptable-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_attr__('Show', 'ptable-widgets'),
        'label_off' => esc_attr__('Hide', 'ptable-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
        'style_transfer' => true,
      ]
    );

    $this->add_control(
      'footer_alignment',
      [
        'label' => esc_attr__('Footer Alignment', 'ptable-widgets'),
        'type' => Controls_Manager::CHOOSE,
        'label_block' => false,
        'options' => [
          'left' => [
            'title' => esc_attr__('Left', 'ptable-widgets'),
            'icon' => 'fa fa-align-left',
          ],
          'center' => [
            'title' => esc_attr__('Center', 'ptable-widgets'),
            'icon' => 'fa fa-align-center',
          ],
          'right' => [
            'title' => esc_attr__('Right', 'ptable-widgets'),
            'icon' => 'fa fa-align-right',
          ],
        ],
        'toggle' => false,
        'selectors' => [
          '{{WRAPPER}} .ptable-footer' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name' => 'footer_area_background',
        'label' => esc_attr__('Background Footer', 'ptable-widgets'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .ptable-footer',
      ]
    );

    $this->add_control(
      '_heading_button',
      [
        'type' => Controls_Manager::HEADING,
        'label' => esc_attr__('Button', 'ptable-widgets'),
      ]
    );

    $this->add_responsive_control(
      'button_width',
      [
        'label' => esc_attr__('Width', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', 'em', '%'],
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 10000,
            'step' => 1,
          ],
          'em' => [
            'min' => 0,
            'max' => 1000,
            'step' => 1,
          ],
          '%' => [
            'min' => 0,
            'max' => 100,
            'step' => 1,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .ptable-btn' => 'width: {{SIZE}}{{UNIT}};text-align: center;dispaly:inline-block;',
        ],
      ]
    );


    $this->add_responsive_control(
      'button_margin',
      [
        'label' => esc_attr__('Margin', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'button_padding',
      [
        'label' => esc_attr__('Padding', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name' => 'button_border',
        'selector' => '{{WRAPPER}} .ptable-btn',
      ]
    );

    $this->add_control(
      'button_border_radius',
      [
        'label' => esc_attr__('Border Radius', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name' => 'button_box_shadow',
        'selector' => '{{WRAPPER}} .ptable-btn',
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'button_typography',
        'selector' => '{{WRAPPER}} .ptable-btn',
      ]
    );

    $this->add_responsive_control(
      'button_translate_y',
      [
        'label' => esc_attr__('Offset Y', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => -1000,
            'max' => 1000,
          ]
        ],
        'render_type' => 'ui',
        'selectors' => [
          '(desktop){{WRAPPER}} .ptable-btn' =>
            '-ms-transform:'
            . 'translateY({{button_translate_y.SIZE || 0}}px);'
            . '-webkit-transform:'
            . 'translateY({{button_translate_y.SIZE || 0}}px);'
            . 'transform:'
            . 'translateY({{button_translate_y.SIZE || 0}}px);',
          '(tablet){{WRAPPER}} .ptable-badge' =>
            '-ms-transform:'
            . 'translateY({{button_translate_y_tablet.SIZE || 0}}px);'
            . '-webkit-transform:'
            . 'translateY({{button_translate_y_tablet.SIZE || 0}}px);'
            . 'transform:'
            . 'translateY({{button_translate_y_tablet.SIZE || 0}}px);',
          '(mobile){{WRAPPER}} .ptable-badge' =>
            '-ms-transform:'
            . 'translateY({{button_translate_y_mobile.SIZE || 0}}px);'
            . '-webkit-transform:'
            . 'translateY({{button_translate_y_mobile.SIZE || 0}}px);'
            . 'transform:'
            . 'translateY({{button_translate_y_mobile.SIZE || 0}}px);',
        ]
      ]
    );

    $this->add_control(
      'hr',
      [
        'type' => Controls_Manager::DIVIDER,
        'style' => 'thick',
      ]
    );

    $this->start_controls_tabs('_tabs_button');

    $this->start_controls_tab(
      '_tab_button_normal',
      [
        'label' => esc_attr__('Normal', 'ptable-widgets'),
      ]
    );

    $this->add_control(
      'button_color',
      [
        'label' => esc_attr__('Text Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-btn' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'button_bg_color',
      [
        'label' => esc_attr__('Background Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-btn' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      '_tab_button_hover',
      [
        'label' => esc_attr__('Hover', 'ptable-widgets'),
      ]
    );

    $this->add_control(
      'button_hover_color',
      [
        'label' => esc_attr__('Text Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-btn:hover, {{WRAPPER}} .ptable-btn:focus' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'button_hover_bg_color',
      [
        'label' => esc_attr__('Background Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-btn:hover, {{WRAPPER}} .ptable-btn:focus' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'button_hover_border_color',
      [
        'label' => esc_attr__('Border Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'condition' => [
          'button_border_border!' => '',
        ],
        'selectors' => [
          '{{WRAPPER}} .ptable-btn:hover, {{WRAPPER}} .ptable-btn:focus' => 'border-color: {{VALUE}};',
        ],
      ]
    );

    $this->end_controls_tab();
    $this->end_controls_tabs();

    $this->add_control(
      'footer_description_style_heading',
      [
        'label' => esc_attr__('Footer Description', 'ptable-widgets'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'footer_description_margin',
      [
        'label' => esc_attr__('Margin', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-footer-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'footer_description_padding',
      [
        'label' => esc_attr__('Padding', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-footer-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'footer_description_color',
      [
        'label' => esc_attr__('Text Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-footer-description' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'footer_description_typography',
        'selector' => '{{WRAPPER}} .ptable-footer-description',
      ]
    );
    $this->end_controls_section();


    //Badge Style
    $this->start_controls_section(
      '_section_style_badge',
      [
        'label' => esc_attr__('Badge', 'ptable-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'badge_width',
      [
        'label' => esc_attr__('Width', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', 'em', '%'],
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 10000,
            'step' => 1,
          ],
          'em' => [
            'min' => 0,
            'max' => 1000,
            'step' => 1,
          ],
          '%' => [
            'min' => 0,
            'max' => 100,
            'step' => 1,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .ptable-badge' => 'width: {{SIZE}}{{UNIT}};text-align: center;',
        ],
      ]
    );

    $this->add_responsive_control(
      'badge_padding',
      [
        'label' => esc_attr__('Padding', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'badge_color',
      [
        'label' => esc_attr__('Text Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-badge' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'badge_bg_color',
      [
        'label' => esc_attr__('Background Color', 'ptable-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .ptable-badge' => 'background-color: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name' => 'badge_border',
        'selector' => '{{WRAPPER}} .ptable-badge',
      ]
    );

    $this->add_responsive_control(
      'badge_border_radius',
      [
        'label' => esc_attr__('Border Radius', 'ptable-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
          '{{WRAPPER}} .ptable-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name' => 'badge_box_shadow',
        'selector' => '{{WRAPPER}} .ptable-badge',
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'badge_typography',
        'label' => esc_attr__('Typography', 'ptable-widgets'),
        'selector' => '{{WRAPPER}} .ptable-badge',
      ]
    );

    $this->add_control(
      'badge_translate_toggle',
      [
        'label' => esc_attr__('Offset', 'ptable-widgets'),
        'type' => Controls_Manager::POPOVER_TOGGLE,
        'return_value' => 'yes',
        'condition' => [
          'show_badge' => 'yes'
        ],
      ]
    );

    $this->start_popover();

    $this->add_responsive_control(
      'badge_translate_x',
      [
        'label' => esc_attr__('Offset X', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => -1000,
            'max' => 1000,
          ]
        ],
        'style_transfer' => true,
        'render_type' => 'ui',
        'condition' => [
          'show_badge' => 'yes'
        ],
      ]
    );

    $this->add_responsive_control(
      'badge_translate_y',
      [
        'label' => esc_attr__('Offset Y', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => -1000,
            'max' => 1000,
          ]
        ],
        'style_transfer' => true,
        'render_type' => 'ui',
        'condition' => [
          'show_badge' => 'yes'
        ],
        'selectors' => [
          '(desktop){{WRAPPER}} .ptable-badge' =>
            '-ms-transform:'
            . 'translate({{badge_translate_x.SIZE || 0}}px, {{badge_translate_y.SIZE || 0}}px);'
            . '-webkit-transform:'
            . 'translate({{badge_translate_x.SIZE || 0}}px, {{badge_translate_y.SIZE || 0}}px);'
            . 'transform:'
            . 'translate({{badge_translate_x.SIZE || 0}}px, {{badge_translate_y.SIZE || 0}}px);',
          '(tablet){{WRAPPER}} .ptable-badge' =>
            '-ms-transform:'
            . 'translate({{badge_translate_x_tablet.SIZE || 0}}px, {{badge_translate_y_tablet.SIZE || 0}}px);'
            . '-webkit-transform:'
            . 'translate({{badge_translate_x_tablet.SIZE || 0}}px, {{badge_translate_y_tablet.SIZE || 0}}px);'
            . 'transform:'
            . 'translate({{badge_translate_x_tablet.SIZE || 0}}px, {{badge_translate_y_tablet.SIZE || 0}}px);',
          '(mobile){{WRAPPER}} .ptable-badge' =>
            '-ms-transform:'
            . 'translate({{badge_translate_x_mobile.SIZE || 0}}px, {{badge_translate_y_mobile.SIZE || 0}}px);'
            . '-webkit-transform:'
            . 'translate({{badge_translate_x_mobile.SIZE || 0}}px, {{badge_translate_y_mobile.SIZE || 0}}px);'
            . 'transform:'
            . 'translate({{badge_translate_x_mobile.SIZE || 0}}px, {{badge_translate_y_mobile.SIZE || 0}}px);',
        ]
      ]
    );

    $this->end_popover();

    $this->add_control(
      'badge_rotate_toggle',
      [
        'label' => esc_attr__('Rotate', 'ptable-widgets'),
        'type' => Controls_Manager::POPOVER_TOGGLE,
        'condition' => [
          'show_badge' => 'yes'
        ],
      ]
    );

    $this->start_popover();

    $this->add_responsive_control(
      'badge_rotate_z',
      [
        'label' => esc_attr__('Rotate Z', 'ptable-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
          'px' => [
            'min' => -180,
            'max' => 180,
          ]
        ],
        'style_transfer' => true,
        'render_type' => 'ui',
        'condition' => [
          'show_badge' => 'yes'
        ],
        'selectors' => [
          '(desktop){{WRAPPER}} .ptable-badge' =>
            '-ms-transform:'
            . 'translate({{badge_translate_x.SIZE || 0}}px, {{badge_translate_y.SIZE || 0}}px) '
            . 'rotateZ({{badge_rotate_z.SIZE || 0}}deg);'
            . '-webkit-transform:'
            . 'translate({{badge_translate_x.SIZE || 0}}px, {{badge_translate_y.SIZE || 0}}px) '
            . 'rotateZ({{badge_rotate_z.SIZE || 0}}deg);'
            . 'transform:'
            . 'translate({{badge_translate_x.SIZE || 0}}px, {{badge_translate_y.SIZE || 0}}px) '
            . 'rotateZ({{badge_rotate_z.SIZE || 0}}deg);',
          '(tablet){{WRAPPER}} .ptable-badge' =>
            '-ms-transform:'
            . 'translate({{badge_translate_x_tablet.SIZE || 0}}px, {{badge_translate_y_tablet.SIZE || 0}}px) '
            . 'rotateZ({{badge_rotate_z_tablet.SIZE || 0}}deg);'
            . '-webkit-transform:'
            . 'translate({{badge_translate_x_tablet.SIZE || 0}}px, {{badge_translate_y_tablet.SIZE || 0}}px) '
            . 'rotateZ({{badge_rotate_z_tablet.SIZE || 0}}deg);'
            . 'transform:'
            . 'translate({{badge_translate_x_tablet.SIZE || 0}}px, {{badge_translate_y_tablet.SIZE || 0}}px) '
            . 'rotateZ({{badge_rotate_z_tablet.SIZE || 0}}deg);',
          '(mobile){{WRAPPER}} .ptable-badge' =>
            '-ms-transform:'
            . 'translate({{badge_translate_x_mobile.SIZE || 0}}px, {{badge_translate_y_mobile.SIZE || 0}}px) '
            . 'rotateZ({{badge_rotate_z_mobile.SIZE || 0}}deg);'
            . '-webkit-transform:'
            . 'translate({{badge_translate_x_mobile.SIZE || 0}}px, {{badge_translate_y_mobile.SIZE || 0}}px) '
            . 'rotateZ({{badge_rotate_z_mobile.SIZE || 0}}deg);'
            . 'transform:'
            . 'translate({{badge_translate_x_mobile.SIZE || 0}}px, {{badge_translate_y_mobile.SIZE || 0}}px) '
            . 'rotateZ({{badge_rotate_z_mobile.SIZE || 0}}deg);'
        ]
      ]
    );

    $this->end_popover();
    $this->end_controls_section();
  }

  private static function get_currency_symbol($symbol_name)
  {
    $symbols = [
      'baht' => '&#3647;',
      'bdt' => '&#2547;',
      'dollar' => '&#36;',
      'euro' => '&#128;',
      'franc' => '&#8355;',
      'guilder' => '&fnof;',
      'indian_rupee' => '&#8377;',
      'pound' => '&#163;',
      'peso' => '&#8369;',
      'peseta' => '&#8359',
      'lira' => '&#8356;',
      'ruble' => '&#8381;',
      'shekel' => '&#8362;',
      'rupee' => '&#8360;',
      'real' => 'R$',
      'krona' => 'kr',
      'won' => '&#8361;',
      'yen' => '&#165;',
    ];

    return isset($symbols[$symbol_name]) ? $symbols[$symbol_name] : '';
  }

  function elementor_version($operator = '<', $version = '2.6.0')
  {
    return defined('ELEMENTOR_VERSION') && version_compare(ELEMENTOR_VERSION, $version, $operator);
  }

  function kses_normal($string = '')
  {
    return wp_kses($string, self::allowed_html_tags('basic'));
  }

  function allowed_html_tags($level = 'basic')
  {
    $allowed_html = [
      'b' => [],
      'i' => [],
      'u' => [],
      'em' => [],
      'br' => [],
      'abbr' => [
        'title' => [],
      ],
      'span' => [
        'class' => [],
      ],
      'strong' => [],
    ];

    if ($level === 'extand') {
      $allowed_html['a'] = [
        'href' => [],
        'title' => [],
        'class' => [],
        'id' => [],
      ];
    }

    return $allowed_html;
  }

  function render_icon($settings = [], $old_icon_id = 'icon', $new_icon_id = 'selected_icon', $attributes = [])
  {
    // Check if its already migrated
    $migrated = isset($settings['__fa4_migrated'][$new_icon_id]);
    // Check if its a new widget without previously selected icon using the old Icon control
    $is_new = empty($settings[$old_icon_id]);

    $attributes['aria-hidden'] = 'true';

    if (self::elementor_version('>=', '2.6.0') && ($is_new || $migrated)) {
      \Elementor\Icons_Manager::render_icon($settings[$new_icon_id], $attributes);
    } else {
      if (empty($attributes['class'])) {
        $attributes['class'] = $settings[$old_icon_id];
      } else {
        if (is_array($attributes['class'])) {
          $attributes['class'][] = $settings[$old_icon_id];
        } else {
          $attributes['class'] .= ' ' . $settings[$old_icon_id];
        }
      }
      printf('<i %s></i>', \Elementor\Utils::render_html_attributes($attributes));
    }
  }

  function kses_extand($string = '')
  {
    return wp_kses($string, self::allowed_html_tags('extand'));
  }

  protected function register_controls()
  {
    $this->content_controls();
    $this->style_controls();
  }

  protected function render($instance = [])
  {
    $settings = $this->get_settings_for_display();

    $this->add_render_attribute('badge_text', 'class',
      [
        'ptable-badge',
        'ptable-badge--' . $settings['badge_position']
      ]
    );

    $this->add_inline_editing_attributes('title', 'basic');
    $this->add_render_attribute('title', 'class', 'ptable-title');

    $this->add_inline_editing_attributes('title_description', 'basic');
    $this->add_render_attribute('title_description', 'class', 'ptable-title-description');

    $this->add_inline_editing_attributes('price', 'basic');
    $this->add_render_attribute('price', 'class', 'ptable-price-text');

    $this->add_inline_editing_attributes('original_price', 'basic');
    $this->add_render_attribute('original_price', 'class', 'ptable-price-text');

    $this->add_inline_editing_attributes('period', 'basic');
    $this->add_render_attribute('period', 'class', 'ptable-period');

    $this->add_inline_editing_attributes('features_title', 'basic');
    $this->add_render_attribute('features_title', 'class', 'ptable-features-title');

    $this->add_inline_editing_attributes('description', 'intermediate');
    $this->add_render_attribute('description', 'class', 'ptable-description');

    $this->add_inline_editing_attributes('button_text', 'none');
    $this->add_render_attribute('button_text', 'class', 'ptable-btn');

    $this->add_inline_editing_attributes('footer_description', 'intermediate');
    $this->add_render_attribute('footer_description', 'class', 'ptable-footer-description');

    $this->add_render_attribute('button_text', 'href', esc_url($settings['button_link']['url']));
    if (!empty($settings['button_link']['is_external'])) {
      $this->add_render_attribute('button_text', 'target', '_blank');
    }
    if (!empty($settings['button_link']['nofollow'])) {
      $this->add_render_attribute('button_text', 'rel', 'nofollow');
    }

    if ($settings['currency'] === 'custom') {
      $currency = $settings['currency_custom'];
    } else {
      $currency = self::get_currency_symbol($settings['currency']);
    }
    ?>

    <?php if ($settings['show_badge']) : ?>
    <span <?php $this->print_render_attribute_string('badge_text'); ?>><?php echo esc_html($settings['badge_text']); ?></span>
  <?php endif; ?>

    <?php if ('before_price' == $settings['title_position']) : ?>
    <div class="ptable-header">
      <?php if ('before_header' == $settings['icon_position'] || 'before_header_over' == $settings['icon_position']) : ?>
        <?php if ($settings['media_type'] === 'image' && ($settings['image']['url'] || $settings['image']['id'])) :
          $settings['hover_animation'] = 'disable-animation'; // hack to prevent image hover animation
          ?>
          <?php if ($settings['show_icon']) : ?>
          <div class="ptable-media ptable-media--image">
            <?php echo Group_Control_Image_Size::get_attachment_image_html($settings, 'media_thumbnail', 'image'); ?>
          </div>
        <?php endif; ?>
        <?php elseif (!empty($settings['icon']) && !empty($settings['icon']['value'])) : ?>
          <?php if ($settings['show_icon']) : ?>
            <div class="ptable-media ptable-media--icon">
              <?php Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
      <div class="ptable-txt">
        <?php if ($settings['title']) : ?>
          <h2 <?php $this->print_render_attribute_string('title'); ?>><?php echo self::kses_normal($settings['title']); ?></h2>
        <?php endif; ?>
        <?php if ($settings['title_description']) : ?>
          <span <?php $this->print_render_attribute_string('title_description'); ?>><?php echo self::kses_normal($settings['title_description']); ?></span>
        <?php endif; ?>
      </div>
      <?php if ('after_header' == $settings['icon_position']) : ?>
        <?php if ($settings['media_type'] === 'image' && ($settings['image']['url'] || $settings['image']['id'])) :
          $settings['hover_animation'] = 'disable-animation'; // hack to prevent image hover animation
          ?>
          <?php if ($settings['show_icon']) : ?>
          <div class="ptable-media ptable-media--image">
            <?php echo Group_Control_Image_Size::get_attachment_image_html($settings, 'media_thumbnail', 'image'); ?>
          </div>
        <?php endif; ?>
        <?php elseif (!empty($settings['icon']) && !empty($settings['icon']['value'])) : ?>
          <?php if ($settings['show_icon']) : ?>
            <div class="ptable-media ptable-media--icon">
              <?php Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>

    <?php if ('after_header' == $settings['price_position']) : ?>
    <?php if ($settings['show_pricing']) : ?>
      <div class="ptable-price<?php echo esc_attr($settings['show_two_pricing']) == "true" ? " ptable-price--twoLine" : ""; ?>">
        <div class="ptable-price-tag">
          <?php if ($settings['original_price']): ?>

            <div class="ptable-original-price">
            <span
              class="ptable-currency"><?php echo esc_html($currency); ?></span><span <?php $this->print_render_attribute_string('original_price'); ?>><?php echo self::kses_normal($settings['original_price']); ?></span>
            </div>

          <?php endif; ?>

          <div class="ptable-current-price">
          <span
            class="ptable-currency"><?php echo esc_html($currency); ?></span><span <?php $this->print_render_attribute_string('price'); ?>><?php echo self::kses_normal($settings['price']); ?></span>
          </div>
        </div>

        <?php if ($settings['period']) : ?>
          <div <?php $this->print_render_attribute_string('period'); ?>><?php echo self::kses_normal($settings['period']); ?></div>
        <?php endif; ?>
      </div>

    <?php endif; ?>
  <?php endif; ?>


    <?php if ('after_price' == $settings['title_position']) : ?>
    <div class="ptable-header">
      <?php if ('before_header' == $settings['icon_position'] || 'before_header_over' == $settings['icon_position']) : ?>
        <?php if ($settings['media_type'] === 'image' && ($settings['image']['url'] || $settings['image']['id'])) :
          $settings['hover_animation'] = 'disable-animation'; // hack to prevent image hover animation
          ?>
          <?php if ($settings['show_icon']) : ?>
          <div class="ptable-media ptable-media--image">
            <?php echo Group_Control_Image_Size::get_attachment_image_html($settings, 'media_thumbnail', 'image'); ?>
          </div>
        <?php endif; ?>
        <?php elseif (!empty($settings['icon']) && !empty($settings['icon']['value'])) : ?>
          <?php if ($settings['show_icon']) : ?>
            <div class="ptable-media ptable-media--icon">
              <?php Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
      <div class="ptable-txt">
        <?php if ($settings['title']) : ?>
          <h2 <?php $this->print_render_attribute_string('title'); ?>><?php echo self::kses_normal($settings['title']); ?></h2>
        <?php endif; ?>
        <?php if ($settings['title_description']) : ?>
          <span <?php $this->print_render_attribute_string('title_description'); ?>><?php echo self::kses_normal($settings['title_description']); ?></span>
        <?php endif; ?>
      </div>
      <?php if ('after_header' == $settings['icon_position']) : ?>
        <?php if ($settings['media_type'] === 'image' && ($settings['image']['url'] || $settings['image']['id'])) :
          $settings['hover_animation'] = 'disable-animation'; // hack to prevent image hover animation
          ?>
          <?php if ($settings['show_icon']) : ?>
          <div class="ptable-media ptable-media--image">
            <?php echo Group_Control_Image_Size::get_attachment_image_html($settings, 'media_thumbnail', 'image'); ?>
          </div>
        <?php endif; ?>
        <?php elseif (!empty($settings['icon']) && !empty($settings['icon']['value'])) : ?>
          <?php if ($settings['show_icon']) : ?>
            <div class="ptable-media ptable-media--icon">
              <?php Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>

    <?php if ($settings['show_features']) : ?>
    <div class="ptable-body">
      <?php if ($settings['features_title']) : ?>
        <h3 <?php $this->print_render_attribute_string('features_title'); ?>><?php echo self::kses_normal($settings['features_title']); ?></h3>
      <?php endif; ?>

      <?php if (is_array($settings['features_list']) && 0 != count($settings['features_list'])) : ?>
        <ul class="ptable-features-list">
          <?php foreach ($settings['features_list'] as $index => $feature) :
            $name_key = $this->get_repeater_setting_key('text', 'features_list', $index);
            $this->add_inline_editing_attributes($name_key, 'intermediate');
            $this->add_render_attribute($name_key, 'class', 'ptable-feature-text');
            if ($feature['tooltip_text']) {
              $this->add_render_attribute($name_key, 'class', 'ptable-feature-tooltip');
            }
            ?>

            <li class="<?php echo esc_attr('elementor-repeater-item-' . $feature['_id']); ?>">
              <?php if (!empty($feature['icon']) || !empty($feature['selected_icon'])) :
                self::render_icon($feature, 'icon', 'selected_icon');
              endif; ?>
              <div <?php $this->print_render_attribute_string($name_key); ?>>
                <?php echo self::kses_extand($feature['text']); ?>
                <?php if ($feature['tooltip_text']) : ?>
                  <span class="ptable-feature-tooltip-text"><?php echo esc_html($feature['tooltip_text']); ?></span>
                <?php endif; ?>
              </div>
            </li>

          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>

    <?php if ($settings['description']) : ?>
      <div <?php $this->print_render_attribute_string('description'); ?>><?php echo self::kses_extand($settings['description']); ?></div>
    <?php endif; ?>
  <?php endif; ?>

    <?php if ('before_button' == $settings['price_position']) : ?>
    <?php if ($settings['show_pricing']) : ?>
      <div class="ptable-price<?php echo esc_attr($settings['show_two_pricing']) == "true" ? " ptable-price--twoLine" : ""; ?>">
        <div class="ptable-price-tag">
          <?php if ($settings['original_price']): ?>
            <div class="ptable-original-price">
              <span
                class="ptable-currency"><?php echo esc_html($currency); ?></span><span <?php $this->print_render_attribute_string('original_price'); ?>><?php echo self::kses_normal($settings['original_price']); ?></span>
            </div>
          <?php endif; ?>
          <div class="ptable-current-price">
            <span
              class="ptable-currency"><?php echo esc_html($currency); ?></span><span <?php $this->print_render_attribute_string('price'); ?>><?php echo self::kses_normal($settings['price']); ?></span>
          </div>
        </div>
        <?php if ($settings['period']) : ?>
          <div <?php $this->print_render_attribute_string('period'); ?>><?php echo self::kses_normal($settings['period']); ?></div>
        <?php endif; ?>
      </div>

    <?php endif; ?>
  <?php endif; ?>

    <?php if ($settings['show_footer']) : ?>
    <div class="ptable-footer">
      <?php if ($settings['button_text']) : ?>
        <a <?php $this->print_render_attribute_string('button_text'); ?>><?php echo self::kses_normal($settings['button_text']); ?></a>
      <?php endif; ?>

      <?php if ($settings['footer_description']) : ?>
        <div <?php $this->print_render_attribute_string('footer_description'); ?>><?php echo self::kses_extand($settings['footer_description']); ?></div>
      <?php endif; ?>

    </div>
  <?php endif; ?>
    <?php
  }
}