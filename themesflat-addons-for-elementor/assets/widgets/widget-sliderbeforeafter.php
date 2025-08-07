<?php

//namespace SliderBeforeAfter_Widgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class TFSliderBeforeAfter_Widget_Free extends \Elementor\Widget_Base {

  public function get_name()
  {
    return 'SliderBeforeAfter';
  }

  public function get_title()
  {
    return esc_html__('TF Slider Before After', 'themesflat-addons-for-elementor');
  }

  public function get_icon()
  {
    return 'eicon-image-before-after';
  }

  public function get_categories()
  {
    return ['themesflat_addons'];
  }

  public function get_script_depends()
  {
    return [ 'imagesloaded','tf-jquery_event_move','tf-sliderbeforeafter'];
  }

  public function get_style_depends()
  {
    return ['font-awesome', 'tf-beforeafter'];
  }

  protected function get_image_src($position)
  {
    if ('' === $position) {
      return;
    }

    $url = '';
    $settings = $this->get_settings_for_display();

    if ('media' === $settings[$position . '_src']) {

      if ('' !== $settings[$position . '_image']['id']) {

        $url = Group_Control_Image_Size::get_attachment_image_src($settings[$position . '_image']['id'], $position . '_image', $settings);
      } else {
        $url = $settings[$position . '_image']['url'];
      }
    } else {

      $url = $settings[$position . '_img_url'];
    }

    return $url;
  }

  protected function register_controls()
  {
    $this->start_controls_section(
      'section_before',
      array(
        'label' => esc_html__('Before', 'themesflat-addons-for-elementor'),
      )
    );

    $this->add_control(
      'before_src',
      array(
        'label' => esc_html__('Before Image Source', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::SELECT,
        'default' => 'media',
        'label_block' => true,
        'options' => array(
          'media' => esc_html__('Media', 'themesflat-addons-for-elementor'),
          'url' => esc_html__('URL', 'themesflat-addons-for-elementor'),
        ),
      )
    );

    $this->add_control(
      'before_image',
      array(
        'label' => esc_html__('Before Photo', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::MEDIA,
        'default' => array(
          'url' => Utils::get_placeholder_image_src(),
        ),
        'dynamic' => array(
          'active' => true,
        ),
        'condition' => array(
          'before_src' => 'media',
        ),
      )
    );

    $this->add_group_control(
      Group_Control_Image_Size::get_type(),
      array(
        'name' => 'before_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `before_image_size` and `before_image_custom_dimension`.
        'default' => 'large',
        'separator' => 'none',
        'condition' => array(
          'before_src' => 'media',
        ),
      )
    );

    $this->add_control(
      'before_img_url',
      array(
        'label' => esc_html__('Before Photo URL', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::TEXT,
        'label_block' => true,
        'separator' => 'before',
        'condition' => array(
          'before_src' => 'url',
        ),
      )
    );

    $this->add_control(
      'before_text',
      array(
        'label' => esc_html__('Before Label', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::TEXT,
        'selector' => '{{WRAPPER}} .fel-infobox-title-prefix',
        'default' => esc_html__('Before', 'themesflat-addons-for-elementor'),
        'dynamic' => array(
          'active' => true,
        ),
        'selectors' => array(
          '{{WRAPPER}} .twentytwenty-before-label:before' => 'content: "{{VALUE}}";',
        ),
      )
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'section_after',
      array(
        'label' => esc_html__('After', 'themesflat-addons-for-elementor'),
      )
    );

    $this->add_control(
      'after_src',
      array(
        'label' => esc_html__('After Image Source', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::SELECT,
        'default' => 'media',
        'label_block' => true,
        'options' => array(
          'media' => esc_html__('Media', 'themesflat-addons-for-elementor'),
          'url' => esc_html__('URL', 'themesflat-addons-for-elementor'),
        ),
      )
    );

    $this->add_control(
      'after_image',
      array(
        'label' => esc_html__('After Photo', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::MEDIA,
        'default' => array(
          'url' => Utils::get_placeholder_image_src(),
        ),
        'dynamic' => array(
          'active' => true,
        ),
        'condition' => array(
          'after_src' => 'media',
        ),
      )
    );

    $this->add_group_control(
      Group_Control_Image_Size::get_type(),
      array(
        'name' => 'after_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `after_image_size` and `after_image_custom_dimension`.
        'default' => 'large',
        'separator' => 'none',
        'condition' => array(
          'after_src' => 'media',
        ),
      )
    );

    $this->add_control(
      'after_img_url',
      array(
        'label' => esc_html__('After Photo URL', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::TEXT,
        'label_block' => true,
        'separator' => 'before',
        'condition' => array(
          'after_src' => 'url',
        ),
      )
    );

    $this->add_control(
      'after_text',
      array(
        'label' => esc_html__('After Label', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::TEXT,
        'selector' => '{{WRAPPER}} .fel-infobox-title-prefix',
        'default' => esc_html__('After', 'themesflat-addons-for-elementor'),
        'dynamic' => array(
          'active' => true,
        ),
        'selectors' => array(
          '{{WRAPPER}} .twentytwenty-after-label:before' => 'content: "{{VALUE}}";',
        ),
      )
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'section_style',
      array(
        'label' => esc_html__('Orientation', 'themesflat-addons-for-elementor'),
        'tab' => Controls_Manager::TAB_LAYOUT,
      )
    );

    $this->add_control(
      'orientation',
      array(
        'label' => esc_html__('Slider Before After Orientation', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::CHOOSE,
        'options' => array(
          'vertical' => array(
            'title' => esc_html__('Vertical', 'themesflat-addons-for-elementor'),
            'icon' => 'eicon-section',
          ),
          'horizontal' => array(
            'title' => esc_html__('Horizontal', 'themesflat-addons-for-elementor'),
            'icon' => 'fa fa-columns',
          ),
        ),
        'default' => 'horizontal',
        'toggle' => false,
      )
    );

    $this->add_responsive_control(
      'alignment',
      array(
        'label' => esc_html__('Alignment', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::CHOOSE,
        'options' => array(
          '-right' => array(
            'title' => esc_html__('Left', 'themesflat-addons-for-elementor'),
            'icon' => 'fa fa-align-left',
          ),
          ' ' => array(
            'title' => esc_html__('Center', 'themesflat-addons-for-elementor'),
            'icon' => 'fa fa-align-center',
          ),
          '-left' => array(
            'title' => esc_html__('Right', 'themesflat-addons-for-elementor'),
            'icon' => 'fa fa-align-right',
          ),
        ),
        'default' => '-right',
        'selectors' => array(
          '{{WRAPPER}}' => 'margin{{VALUE}}:auto;',
        ),
        'toggle' => false,
      )
    );

    $this->add_control(
      'move_on_hover',
      array(
        'label' => esc_html__('Move on Hover', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'no',
        'return_value' => 'yes',
        'label_on' => esc_html__('Yes', 'themesflat-addons-for-elementor'),
        'label_off' => esc_html__('No', 'themesflat-addons-for-elementor'),
      )
    );

    $this->add_control(
      'overlay_color',
      array(
        'label' => esc_html__('Overlay Color', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::COLOR,
        'default' => 'rgba(0, 0, 0, 0.5)',
        'selectors' => array(
          '{{WRAPPER}} .twentytwenty-overlay' => 'background-color: {{VALUE}};',
        ),
      )
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'section_handle',
      array(
        'label' => esc_html__('Comparison Handle', 'themesflat-addons-for-elementor'),
        'tab' => Controls_Manager::TAB_LAYOUT,
      )
    );

    $this->add_control(
      'initial_offset',
      array(
        'label' => esc_html__('Handle Initial Offset', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => array('%'),
        'default' => array(
          'size' => 50,
        ),
        'range' => array(
          '%' => array(
            'min' => 0,
            'max' => 100,
          ),
        ),
        'label_block' => true,
        'options' => array(
          '0.0' => esc_html__('0.0', 'themesflat-addons-for-elementor'),
          '0.1' => esc_html__('0.1', 'themesflat-addons-for-elementor'),
          '0.2' => esc_html__('0.2', 'themesflat-addons-for-elementor'),
          '0.3' => esc_html__('0.3', 'themesflat-addons-for-elementor'),
          '0.4' => esc_html__('0.4', 'themesflat-addons-for-elementor'),
          '0.5' => esc_html__('0.5', 'themesflat-addons-for-elementor'),
          '0.6' => esc_html__('0.6', 'themesflat-addons-for-elementor'),
          '0.7' => esc_html__('0.7', 'themesflat-addons-for-elementor'),
          '0.8' => esc_html__('0.8', 'themesflat-addons-for-elementor'),
          '0.9' => esc_html__('0.9', 'themesflat-addons-for-elementor'),
        ),
      )
    );

    $this->add_control(
      'handle_color',
      array(
        'label' => esc_html__('Handle Color', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::COLOR,
        'default' => '#ffffff',
        'selectors' => array(
          '{{WRAPPER}} .twentytwenty-handle' => 'border-color: {{VALUE}};',
          '{{WRAPPER}} .twentytwenty-handle::before' => 'background:  {{VALUE}};',
          '{{WRAPPER}} .twentytwenty-handle::after' => 'background: {{VALUE}};',
          '{{WRAPPER}} .twentytwenty-handle .twentytwenty-left-arrow' => 'border-right-color:  {{VALUE}};',
          '{{WRAPPER}} .twentytwenty-handle .twentytwenty-right-arrow' => 'border-left-color: {{VALUE}};',
          '{{WRAPPER}} .twentytwenty-handle .twentytwenty-up-arrow' => 'border-bottom-color:  {{VALUE}};',
          '{{WRAPPER}} .twentytwenty-handle .twentytwenty-down-arrow' => 'border-top-color: {{VALUE}};',
        ),
      )
    );

    $this->add_control(
      'thickness',
      array(
        'label' => esc_html__('Handle Thickness', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => array('px'),
        'default' => array(
          'size' => 5,
        ),
        'range' => array(
          'px' => array(
            'max' => 15,
          ),
        ),
        'selectors' => array(
          '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle::before' => 'width: {{SIZE}}{{UNIT}}; margin-left:calc( -{{SIZE}}{{UNIT}}/2 );',
          '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle::after' => 'width: {{SIZE}}{{UNIT}}; margin-left:calc( -{{SIZE}}{{UNIT}}/2 );',
          '{{WRAPPER}} .twentytwenty-handle' => 'border-width: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle::before' => 'height: {{SIZE}}{{UNIT}}; margin-top:calc( -{{SIZE}}{{UNIT}}/2 );',
          '{{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle::after' => 'height: {{SIZE}}{{UNIT}}; margin-top:calc( -{{SIZE}}{{UNIT}}/2 );',
        ),
      )
    );

    $this->add_control(
      'circle_width',
      array(
        'label' => esc_html__('Circle Width', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => array('px'),
        'default' => array(
          'size' => 40,
        ),
        'range' => array(
          'px' => array(
            'max' => 150,
          ),
        ),
        'selectors' => array(
          '{{WRAPPER}} .twentytwenty-handle' => 'width: {{SIZE}}{{UNIT}}; height:{{SIZE}}{{UNIT}}; margin-left:calc( -{{SIZE}}{{UNIT}}/2 - {{thickness.size}}{{thickness.unit}} ); margin-top:calc( -{{SIZE}}{{UNIT}}/2 - {{thickness.size}}{{thickness.unit}} );',
          '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:before' => 'margin-bottom: calc( ( {{SIZE}}{{UNIT}} + ( {{thickness.size}}{{thickness.unit}} * 2 ) ) / 2 );',
          '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:after' => 'margin-top: calc( ( {{SIZE}}{{UNIT}} + ( {{thickness.size}}{{thickness.unit}} * 2 ) ) / 2 );',
          '{{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:before' => 'margin-left: calc( ( {{SIZE}}{{UNIT}} + ( {{thickness.size}}{{thickness.unit}} * 2 ) ) / 2 );',
          '{{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:after' => 'margin-right: calc( ( {{SIZE}}{{UNIT}} + ( {{thickness.size}}{{thickness.unit}} * 2 ) ) / 2 );',
        ),
      )
    );

    $this->add_control(
      'circle_radius',
      array(
        'label' => esc_html__('Circle Radius', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => array('%'),
        'default' => array(
          'size' => 100,
          'unit' => '%',
        ),
        'range' => array(
          '%' => array(
            'max' => 100,
          ),
        ),
        'selectors' => array(
          '{{WRAPPER}} .twentytwenty-handle' => 'border-radius: {{SIZE}}{{UNIT}};',
        ),
      )
    );

    $this->add_control(
      'triangle_size',
      array(
        'label' => esc_html__('Triangle Size', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => array('px'),
        'default' => array(
          'size' => 6,
        ),
        'range' => array(
          'px' => array(
            'max' => 50,
          ),
        ),
        'selectors' => array(
          '{{WRAPPER}} .twentytwenty-handle .twentytwenty-left-arrow' => 'border-right-width: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} .twentytwenty-handle .twentytwenty-right-arrow' => 'border-left-width: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} .twentytwenty-left-arrow, {{WRAPPER}} .twentytwenty-right-arrow, {{WRAPPER}} .twentytwenty-up-arrow, {{WRAPPER}} .twentytwenty-down-arrow' => 'border-width: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} .twentytwenty-handle .twentytwenty-left-arrow' => 'margin-right: calc({{SIZE}}{{UNIT}}/2);',
          '{{WRAPPER}} .twentytwenty-handle .twentytwenty-right-arrow' => 'margin-left: calc({{SIZE}}{{UNIT}}/2);',
        ),
      )
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'style_section',
      array(
        'label' => esc_html__('Before/After Label', 'themesflat-addons-for-elementor'),
        'tab' => Controls_Manager::TAB_STYLE,
      )
    );

    $this->add_control(
      'typography',
      array(
        'label' => esc_html__('Before/After Label', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::HEADING,
      )
    );

    $this->add_control(
      'show_on',
      array(
        'label' => esc_html__('Show Label On', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::SELECT,
        'default' => 'hover',
        'label_block' => true,
        'options' => array(
          'hover' => esc_html__('Hover Only', 'themesflat-addons-for-elementor'),
          'normal' => esc_html__('Normal Only', 'themesflat-addons-for-elementor'),
          'both' => esc_html__('Hover & Normal', 'themesflat-addons-for-elementor'),
        ),
        'prefix_class' => 'fel-ba-label-',
      )
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      array(
        'name' => 'label_typography',
        'selector' => '{{WRAPPER}} .twentytwenty-before-label:before, {{WRAPPER}} .twentytwenty-after-label:before',
      )
    );

    $this->add_control(
      'label_color',
      array(
        'label' => esc_html__('Color', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::COLOR,
        'default' => '',
        'selectors' => array(
          '{{WRAPPER}} .twentytwenty-before-label:before, {{WRAPPER}} .twentytwenty-after-label:before' => 'color: {{VALUE}};',
        ),
      )
    );

    $this->add_control(
      'label_bg_color',
      array(
        'label' => esc_html__('Background Color', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::COLOR,
        'default' => '',
        'selectors' => array(
          '{{WRAPPER}} .twentytwenty-before-label:before, {{WRAPPER}} .twentytwenty-after-label:before' => 'background-color: {{VALUE}};',
        ),
      )
    );

    $this->add_responsive_control(
      'label_padding',
      array(
        'label' => esc_html__('Padding', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => array('px', 'em', '%'),
        'selectors' => array(
          '{{WRAPPER}} .twentytwenty-before-label:before, {{WRAPPER}} .twentytwenty-after-label:before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ),
        'separator' => 'before',
      )
    );

    $this->add_responsive_control(
      'vertical_alignment',
      array(
        'label' => esc_html__('Alignment', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::CHOOSE,
        'options' => array(
          'flex-start' => array(
            'title' => esc_html__('Left', 'themesflat-addons-for-elementor'),
            'icon' => 'fa fa-align-left',
          ),
          'center' => array(
            'title' => esc_html__('Center', 'themesflat-addons-for-elementor'),
            'icon' => 'fa fa-align-center',
          ),
          'flex-end' => array(
            'title' => esc_html__('Right', 'themesflat-addons-for-elementor'),
            'icon' => 'fa fa-align-right',
          ),
        ),
        'default' => 'flex-start',
        'selectors' => array(
          '{{WRAPPER}} .twentytwenty-before-label, {{WRAPPER}} .twentytwenty-after-label' => 'justify-content: {{VALUE}};',
        ),
        'toggle' => false,
        'condition' => array(
          'orientation' => 'vertical',
        ),
        'prefix_class' => 'fel%s-ba-valign-',
      )
    );

    $this->add_responsive_control(
      'horizontal_alignment',
      array(
        'label' => esc_html__('Alignment', 'themesflat-addons-for-elementor'),
        'type' => Controls_Manager::CHOOSE,
        'options' => array(
          'flex-start' => array(
            'title' => esc_html__('Top', 'themesflat-addons-for-elementor'),
            'icon' => 'fa fa-long-arrow-up',
          ),
          'center' => array(
            'title' => esc_html__('Center', 'themesflat-addons-for-elementor'),
            'icon' => 'fa fa-arrows-v',
          ),
          'flex-end' => array(
            'title' => esc_html__('Bottom', 'themesflat-addons-for-elementor'),
            'icon' => 'fa fa-long-arrow-down',
          ),
        ),
        'default' => 'flex-start',
        'selectors' => array(
          '{{WRAPPER}} .twentytwenty-before-label, {{WRAPPER}} .twentytwenty-after-label' => 'align-items: {{VALUE}};',
        ),
        'prefix_class' => 'fel%s-ba-halign-',
        'toggle' => false,
        'condition' => array(
          'orientation' => 'horizontal',
        ),
      )
    );

    $this->end_controls_section();
  }

  protected function render($instance = [])
  {
    $settings = $this->get_settings();
    $node_id = $this->get_id();
    $before_img = $this->get_image_src('before');
    $after_img = $this->get_image_src('after');
    ?>
    <div class="fel-slider-before-after">
      <div class="fel-sba-container" data-move-on-hover="<?php echo esc_attr($settings['move_on_hover']); ?>"
           data-orientation="<?php echo esc_attr($settings['orientation']); ?>"
           data-offset="<?php echo esc_attr(($settings['initial_offset']['size'] / 100)); ?>">
        <img class="fel-before-img" style="position: absolute;" src="<?php echo esc_attr($before_img); ?>"
             alt="<?php echo esc_attr($settings['before_text']); ?>"/>
        <img class="fel-after-img" src="<?php echo esc_attr($after_img); ?>"
             alt="<?php echo esc_attr($settings['after_text']); ?>"/>
      </div>
    </div>
    <?php
  }

  protected function content_template()
  {
    ?>
    <#
      var before_img = '';
      var after_img = '';

      if( 'media' == settings.before_src ) {

      var before_image = {
      id: settings.before_image.id,
      url: settings.before_image.url,
      size: settings.before_image_size,
      dimension: settings.before_image_custom_dimension,
      model: view.getEditModel()
      };
      before_img = elementor.imagesManager.getImageUrl( before_image );
      } else {
      before_img = settings.before_img_url;
      }

      if( 'media' == settings.after_src ) {
      var after_image = {
      id: settings.after_image.id,
      url: settings.after_image.url,
      size: settings.after_image_size,
      dimension: settings.after_image_custom_dimension,
      model: view.getEditModel()
      };
      after_img = elementor.imagesManager.getImageUrl( after_image );
      } else {
      after_img = settings.after_img_url;
      }

      if ( ! before_img || ! after_img ) {
      return;
      }

      #>
      <div class="fel-slider-before-after">
        <div class="fel-sba-container" data-move-on-hover="{{settings.move_on_hover}}"
             data-orientation="{{settings.orientation}}" data-offset="{{settings.initial_offset.size/100}}">
          <img class="fel-before-img" style="position: absolute;" src="{{before_img}}" alt="{{settings.before_text}}"/>
          <img class="fel-after-img" src="{{after_img}}" alt="{{settings.after_text}}"/>
        </div>
      </div>
      <# elementorFrontend.hooks.doAction( 'frontend/element_ready/SliderBeforeAfter.default' ); #>
    <?php
  }
}