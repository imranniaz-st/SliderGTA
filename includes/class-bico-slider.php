<?php
/**
 * Main Bico Slider Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class Bico_Slider {
    
    public function init() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }
    
    /**
     * Enqueue frontend assets
     */
    public function enqueue_assets() {
        // Swiper CSS
        wp_enqueue_style(
            'swiper-css',
            'https://unpkg.com/swiper@8/swiper-bundle.min.css',
            array(),
            '8.0.0'
        );
        
        // Plugin CSS
        wp_enqueue_style(
            'bico-slider-css',
            BICO_SLIDER_URL . 'assets/css/slider-gta.css',
            array(),
            BICO_SLIDER_VERSION
        );
        
        // Swiper JS
        wp_enqueue_script(
            'swiper-js',
            BICO_SLIDER_URL . 'assets/js/swiper-bundle.min.js',
            array(),
            '8.0.0',
            true
        );
        
        // Plugin JS
        wp_enqueue_script(
            'bico-slider-js',
            BICO_SLIDER_URL . 'assets/js/slider-gta.js',
            array('jquery', 'swiper-js'),
            BICO_SLIDER_VERSION,
            true
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        global $post_type;
        
        if ('bico_slider' === $post_type) {
            wp_enqueue_media();
            
            wp_enqueue_style(
                'bico-slider-admin-css',
                BICO_SLIDER_URL . 'assets/css/admin.css',
                array(),
                BICO_SLIDER_VERSION
            );
            
            wp_enqueue_script(
                'bico-slider-admin-js',
                BICO_SLIDER_URL . 'assets/js/admin.js',
                array('jquery'),
                BICO_SLIDER_VERSION,
                true
            );
        }
    }
}
