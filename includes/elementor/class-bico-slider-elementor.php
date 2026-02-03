<?php
/**
 * Elementor Integration for Bico Slider
 * Only loads if Elementor is active
 */

if (!defined('ABSPATH')) {
    exit;
}

// Check if Elementor is loaded
if (!did_action('elementor/loaded')) {
    return;
}

class Bico_Slider_Elementor {
    
    private static $_instance = null;
    
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function __construct() {
        add_action('elementor/widgets/register', array($this, 'register_widgets'));
        add_action('elementor/elements/categories_registered', array($this, 'add_elementor_category'));
    }
    
    /**
     * Add custom category for widgets
     */
    public function add_elementor_category($elements_manager) {
        $elements_manager->add_category(
            'bico-slider',
            array(
                'title' => __('Bico Slider', 'bico-slider'),
                'icon' => 'fa fa-images',
            )
        );
    }
    
    /**
     * Register widgets
     */
    public function register_widgets($widgets_manager) {
        require_once BICO_SLIDER_PATH . 'includes/elementor/widgets/slider-widget.php';
        $widgets_manager->register(new \Bico_Slider_Elementor_Widget());
    }
}

// Initialize only if Elementor is loaded
if (did_action('elementor/loaded')) {
    Bico_Slider_Elementor::instance();
}
