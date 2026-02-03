<?php
/**
 * Admin Interface for Slider GTA
 */

if (!defined('ABSPATH')) {
    exit;
}

class Slider_GTA_Admin {
    
    public function init() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_slider_meta'), 10, 2);
        add_filter('manage_slider_gta_posts_columns', array($this, 'set_custom_columns'));
        add_action('manage_slider_gta_posts_custom_column', array($this, 'custom_column_content'), 10, 2);
    }
    
    /**
     * Add meta boxes
     */
    public function add_meta_boxes() {
        add_meta_box(
            'slider_gta_images',
            __('Slider Images', 'slider-gta'),
            array($this, 'render_images_metabox'),
            'slider_gta',
            'normal',
            'high'
        );
        
        add_meta_box(
            'slider_gta_shortcode',
            __('Shortcode', 'slider-gta'),
            array($this, 'render_shortcode_metabox'),
            'slider_gta',
            'side',
            'default'
        );
    }
    
    /**
     * Render images metabox
     */
    public function render_images_metabox($post) {
        wp_nonce_field('slider_gta_meta_box', 'slider_gta_meta_box_nonce');
        
        $images = get_post_meta($post->ID, '_slider_gta_images', true);
        $images = $images ? $images : array();
        ?>
        <div class="slider-gta-images-wrapper">
            <div class="slider-gta-images-container" id="slider-images-container">
                <?php
                if (!empty($images)) {
                    foreach ($images as $image_id) {
                        $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                        if ($image_url) {
                            echo '<div class="slider-image-item" data-id="' . esc_attr($image_id) . '">';
                            echo '<img src="' . esc_url($image_url) . '" />';
                            echo '<span class="remove-image" title="Remove">&times;</span>';
                            echo '<input type="hidden" name="slider_gta_images[]" value="' . esc_attr($image_id) . '" />';
                            echo '</div>';
                        }
                    }
                }
                ?>
            </div>
            <button type="button" class="button button-primary" id="add-slider-images">
                <?php _e('Add Images', 'slider-gta'); ?>
            </button>
            <p class="description">
                <?php _e('Click to add multiple images to the slider. You can drag and drop to reorder.', 'slider-gta'); ?>
            </p>
        </div>
        <?php
    }
    
    /**
     * Render shortcode metabox
     */
    public function render_shortcode_metabox($post) {
        if ($post->post_status === 'publish') {
            ?>
            <p><?php _e('Use this shortcode to display the slider:', 'slider-gta'); ?></p>
            <input type="text" readonly value='[slider_gta id="<?php echo $post->ID; ?>"]' onclick="this.select();" style="width: 100%;" />
            <p class="description"><?php _e('Copy and paste this shortcode into any post, page, or widget.', 'slider-gta'); ?></p>
            <?php
        } else {
            echo '<p>' . __('Publish the slider to get the shortcode.', 'slider-gta') . '</p>';
        }
    }
    
    /**
     * Save slider meta
     */
    public function save_slider_meta($post_id, $post) {
        // Check nonce
        if (!isset($_POST['slider_gta_meta_box_nonce']) || !wp_verify_nonce($_POST['slider_gta_meta_box_nonce'], 'slider_gta_meta_box')) {
            return;
        }
        
        // Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        // Check permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Check post type
        if ('slider_gta' !== $post->post_type) {
            return;
        }
        
        // Save images
        if (isset($_POST['slider_gta_images'])) {
            $images = array_map('intval', $_POST['slider_gta_images']);
            update_post_meta($post_id, '_slider_gta_images', $images);
        } else {
            delete_post_meta($post_id, '_slider_gta_images');
        }
    }
    
    /**
     * Set custom columns
     */
    public function set_custom_columns($columns) {
        $new_columns = array();
        $new_columns['cb'] = $columns['cb'];
        $new_columns['title'] = $columns['title'];
        $new_columns['images_count'] = __('Images', 'slider-gta');
        $new_columns['shortcode'] = __('Shortcode', 'slider-gta');
        $new_columns['date'] = $columns['date'];
        return $new_columns;
    }
    
    /**
     * Custom column content
     */
    public function custom_column_content($column, $post_id) {
        switch ($column) {
            case 'images_count':
                $images = get_post_meta($post_id, '_slider_gta_images', true);
                echo !empty($images) ? count($images) : '0';
                break;
                
            case 'shortcode':
                echo '<input type="text" readonly value=\'[slider_gta id="' . $post_id . '"]\' onclick="this.select();" style="width: 200px;" />';
                break;
        }
    }
}
