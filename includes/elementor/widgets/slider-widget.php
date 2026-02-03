<?php
/**
 * Elementor Widget Class for Bico Slider
 */

if (!defined('ABSPATH')) {
    exit;
}

class Bico_Slider_Elementor_Widget extends \Elementor\Widget_Base {
    
    /**
     * Get widget name
     */
    public function get_name() {
        return 'bico_slider';
    }
    
    /**
     * Get widget title
     */
    public function get_title() {
        return __('Bico Slider', 'bico-slider');
    }
    
    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-slider-album';
    }
    
    /**
     * Get widget categories
     */
    public function get_categories() {
        return array('bico-slider');
    }
    
    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return array('slider', 'carousel', 'images', 'gallery', 'bico');
    }
    
    /**
     * Register widget controls
     */
    protected function register_controls() {
        
        // Content Section
        $this->start_controls_section(
            'content_section',
            array(
                'label' => __('Slider Settings', 'bico-slider'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );
        
        // Get all published sliders
        $sliders = get_posts(array(
            'post_type' => 'bico_slider',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
        ));
        
        $slider_options = array();
        if (!empty($sliders)) {
            foreach ($sliders as $slider) {
                $slider_options[$slider->ID] = $slider->post_title;
            }
        }
        
        if (empty($slider_options)) {
            $this->add_control(
                'no_sliders_notice',
                array(
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __('No sliders found. Please create a slider first from Dashboard > Sliders.', 'bico-slider'),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                )
            );
        } else {
            $this->add_control(
                'slider_id',
                array(
                    'label' => __('Select Slider', 'bico-slider'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => $slider_options,
                    'default' => array_key_first($slider_options),
                )
            );
        }
        
        $this->end_controls_section();
        
        // Style Section
        $this->start_controls_section(
            'style_section',
            array(
                'label' => __('Style', 'bico-slider'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );
        
        $this->add_responsive_control(
            'slider_height',
            array(
                'label' => __('Slider Height', 'bico-slider'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array('px', 'vh'),
                'range' => array(
                    'px' => array(
                        'min' => 200,
                        'max' => 1000,
                        'step' => 10,
                    ),
                    'vh' => array(
                        'min' => 10,
                        'max' => 100,
                    ),
                ),
                'default' => array(
                    'unit' => 'px',
                    'size' => 500,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .swiper-slide' => 'height: {{SIZE}}{{UNIT}};',
                ),
            )
        );
        
        $this->end_controls_section();
    }
    
    /**
     * Render widget output
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        if (empty($settings['slider_id'])) {
            echo '<p>' . __('Please select a slider.', 'bico-slider') . '</p>';
            return;
        }
        
        // Use the shortcode to render the slider
        echo do_shortcode('[bico_slider id="' . intval($settings['slider_id']) . '"]');
    }
    
    /**
     * Render widget output in the editor
     */
    protected function content_template() {
        ?>
        <# if (settings.slider_id) { #>
            <div class="elementor-bico-slider-placeholder">
                <i class="eicon-slider-album" style="font-size: 48px; color: #0073aa;"></i>
                <p><?php _e('Bico Slider Widget', 'bico-slider'); ?></p>
                <p style="font-size: 12px; color: #666;"><?php _e('Preview available on frontend', 'bico-slider'); ?></p>
            </div>
        <# } else { #>
            <p><?php _e('Please select a slider.', 'bico-slider'); ?></p>
        <# } #>
        <?php
    }
}
