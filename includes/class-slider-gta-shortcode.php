<?php
/**
 * Shortcode Handler for Slider GTA
 */

if (!defined('ABSPATH')) {
    exit;
}

class Slider_GTA_Shortcode {
    
    public function init() {
        add_shortcode('slider_gta', array($this, 'render_slider'));
    }
    
    /**
     * Render slider shortcode
     */
    public function render_slider($atts) {
        $atts = shortcode_atts(array(
            'id' => 0,
        ), $atts);
        
        $slider_id = intval($atts['id']);
        
        if (!$slider_id) {
            return '<p>' . __('Please provide a valid slider ID.', 'slider-gta') . '</p>';
        }
        
        // Get slider post
        $slider = get_post($slider_id);
        
        if (!$slider || $slider->post_type !== 'slider_gta' || $slider->post_status !== 'publish') {
            return '<p>' . __('Slider not found.', 'slider-gta') . '</p>';
        }
        
        // Get slider images
        $images = get_post_meta($slider_id, '_slider_gta_images', true);
        
        if (empty($images)) {
            return '<p>' . __('No images found in this slider.', 'slider-gta') . '</p>';
        }
        
        // Generate unique ID for this slider instance
        $unique_id = 'slider-gta-' . $slider_id . '-' . rand(1000, 9999);
        
        ob_start();
        ?>
        <div class="slider-gta-wrapper" id="<?php echo esc_attr($unique_id); ?>">
            <section id="trending">
                <div class="swiper trending-slider">
                    <div class="swiper-wrapper">
                        <?php foreach ($images as $image_id): ?>
                            <?php
                            $image_url = wp_get_attachment_image_url($image_id, 'full');
                            if ($image_url):
                            ?>
                            <div class="swiper-slide">
                                <div class="trending-slide-img">
                                    <div class="image-overlay"></div>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', true)); ?>" />
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="trending-slider-control-1">
                        <button class="swiper-button-prev slider-arrow"></button>
                        <button class="swiper-button-next slider-arrow"></button>
                    </div>
                    
                    <div class="trending-slider-control">
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </section>
        </div>
        
        <script>
        (function($) {
            $(document).ready(function() {
                if (typeof Swiper !== 'undefined') {
                    const swiperInstance<?php echo $slider_id; ?> = new Swiper('#<?php echo esc_js($unique_id); ?> .trending-slider', {
                        effect: "coverflow",
                        grabCursor: true,
                        centeredSlides: true,
                        loop: true,
                        slidesPerView: "auto",
                        coverflowEffect: {
                            rotate: 50,
                            stretch: 0,
                            depth: 150,
                            modifier: 1.5,
                            slideShadows: false,
                        },
                        autoplay: {
                            delay: 3000,
                            disableOnInteraction: false,
                        },
                        pagination: {
                            el: '#<?php echo esc_js($unique_id); ?> .swiper-pagination',
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '#<?php echo esc_js($unique_id); ?> .swiper-button-next',
                            prevEl: '#<?php echo esc_js($unique_id); ?> .swiper-button-prev',
                        },
                    });
                }
            });
        })(jQuery);
        </script>
        <?php
        
        return ob_get_clean();
    }
}
