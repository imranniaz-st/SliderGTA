<?php
/**
 * Main Slider GTA Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class Slider_GTA {
    
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
            'slider-gta-css',
            SLIDER_GTA_URL . 'assets/css/slider-gta.css',
            array(),
            SLIDER_GTA_VERSION
        );
        
        // Swiper JS
        wp_enqueue_script(
            'swiper-js',
            SLIDER_GTA_URL . 'assets/js/swiper-bundle.min.js',
            array(),
            '8.0.0',
            true
        );
        
        // Plugin JS
        wp_enqueue_script(
            'slider-gta-js',
            SLIDER_GTA_URL . 'assets/js/slider-gta.js',
            array('jquery', 'swiper-js'),
            SLIDER_GTA_VERSION,
            true
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        global $post_type;
        
        if ('slider_gta' === $post_type) {
            wp_enqueue_media();
            
            wp_enqueue_style(
                'slider-gta-admin-css',
                SLIDER_GTA_URL . 'assets/css/admin.css',
                array(),
                SLIDER_GTA_VERSION
            );
            
            wp_enqueue_script(
                'slider-gta-admin-js',
                SLIDER_GTA_URL . 'assets/js/admin.js',
                array('jquery'),
                SLIDER_GTA_VERSION,
                true
            );
        }
    }
}
