<?php
/**
 * Admin Interface for Bico Slider
 */

if (!defined('ABSPATH')) {
    exit;
}

class Bico_Slider_Admin {
    
    public function init() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_slider_meta'), 10, 2);
        add_filter('manage_bico_slider_posts_columns', array($this, 'set_custom_columns'));
        add_action('manage_bico_slider_posts_custom_column', array($this, 'custom_column_content'), 10, 2);
        add_filter('plugin_action_links_bico-slider/slider-gta.php', array($this, 'add_plugin_action_links'));
        add_action('admin_menu', array($this, 'add_settings_menu'));
    }
    
    /**
     * Add settings menu
     */
    public function add_settings_menu() {
        add_submenu_page(
            'edit.php?post_type=bico_slider',
            __('Settings', 'bico-slider'),
            __('Settings', 'bico-slider'),
            'manage_options',
            'bico-slider-settings',
            array($this, 'render_settings_page')
        );
    }
    
    /**
     * Render settings page
     */
    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('Bico Slider Settings', 'bico-slider'); ?></h1>
            
            <div class="bico-slider-settings-container">
                <div class="bico-slider-card">
                    <h2><?php _e('Plugin Information', 'bico-slider'); ?></h2>
                    <table class="form-table">
                        <tr>
                            <th><?php _e('Plugin Name', 'bico-slider'); ?></th>
                            <td>Bico Slider</td>
                        </tr>
                        <tr>
                            <th><?php _e('Version', 'bico-slider'); ?></th>
                            <td><?php echo BICO_SLIDER_VERSION; ?></td>
                        </tr>
                        <tr>
                            <th><?php _e('Author', 'bico-slider'); ?></th>
                            <td>
                                <a href="https://bicodev.com" target="_blank">
                                    Bicodev
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th><?php _e('Website', 'bico-slider'); ?></th>
                            <td>
                                <a href="https://bicodev.com" target="_blank">
                                    https://bicodev.com
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <div class="bico-slider-card">
                    <h2><?php _e('Check for Updates', 'bico-slider'); ?></h2>
                    <p><?php _e('Click the button below to check for the latest version of Bico Slider.', 'bico-slider'); ?></p>
                    <p>
                        <a href="<?php echo esc_url(self_admin_url('plugins.php?plugin_status=all')); ?>" 
                           class="button button-primary" style="background-color: #0073aa; border-color: #005a87;">
                            <span class="dashicons dashicons-update" style="margin-right: 5px;"></span>
                            <?php _e('Check for Updates', 'bico-slider'); ?>
                        </a>
                    </p>
                </div>
                
                <div class="bico-slider-card">
                    <h2><?php _e('Documentation', 'bico-slider'); ?></h2>
                    <ul>
                        <li>
                            <a href="<?php echo esc_url(BICO_SLIDER_URL . 'README.md'); ?>" target="_blank">
                                <?php _e('Full Documentation', 'bico-slider'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(BICO_SLIDER_URL . 'INSTALLATION.md'); ?>" target="_blank">
                                <?php _e('Installation Guide', 'bico-slider'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="https://bicodev.com" target="_blank">
                                <?php _e('Visit Official Website', 'bico-slider'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <style>
                .bico-slider-settings-container {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                    gap: 20px;
                    margin-top: 20px;
                }
                
                .bico-slider-card {
                    background: #fff;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    padding: 20px;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                }
                
                .bico-slider-card h2 {
                    margin-top: 0;
                    color: #0073aa;
                }
                
                .bico-slider-card table th {
                    text-align: left;
                    width: 150px;
                    font-weight: 600;
                }
                
                .bico-slider-card ul {
                    list-style: disc;
                    margin-left: 20px;
                }
                
                .bico-slider-card a {
                    color: #0073aa;
                    text-decoration: none;
                }
                
                .bico-slider-card a:hover {
                    text-decoration: underline;
                }
            </style>
        </div>
        <?php
    }
    
    /**
     * Add plugin action links
     */
    public function add_plugin_action_links($links) {
        $settings_link = '<a href="' . esc_url(admin_url('edit.php?post_type=bico_slider&page=bico-slider-settings')) . '">' . __('Settings', 'bico-slider') . '</a>';
        
        $update_link = '<a href="' . esc_url(self_admin_url('plugins.php?plugin_status=all')) . '" class="bico-update-link" style="color: #0073aa; font-weight: bold;"><span class="dashicons dashicons-update" style="margin-right: 3px;"></span>' . __('Update', 'bico-slider') . '</a>';
        
        array_unshift($links, $settings_link);
        
        // Check if update available
        $version_info = get_transient('bico_slider_version_info');
        if ($version_info && version_compare(str_replace('v', '', $version_info['version']), BICO_SLIDER_VERSION, '>')) {
            array_unshift($links, $update_link);
        }
        
        return $links;
    }
    
    /**
     * Add meta boxes
     */
    public function add_meta_boxes() {
        add_meta_box(
            'bico_slider_images',
            __('Slider Images', 'bico-slider'),
            array($this, 'render_images_metabox'),
            'bico_slider',
            'normal',
            'high'
        );
        
        add_meta_box(
            'bico_slider_shortcode',
            __('Shortcode', 'bico-slider'),
            array($this, 'render_shortcode_metabox'),
            'bico_slider',
            'side',
            'default'
        );
    }
    
    /**
     * Render images metabox
     */
    public function render_images_metabox($post) {
        wp_nonce_field('bico_slider_meta_box', 'bico_slider_meta_box_nonce');
        
        $images = get_post_meta($post->ID, '_bico_slider_images', true);
        $images = $images ? $images : array();
        ?>
        <div class="bico-slider-images-wrapper">
            <div class="bico-slider-images-container" id="slider-images-container">
                <?php
                if (!empty($images)) {
                    foreach ($images as $image_id) {
                        $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                        if ($image_url) {
                            echo '<div class="slider-image-item" data-id="' . esc_attr($image_id) . '">';
                            echo '<img src="' . esc_url($image_url) . '" />';
                            echo '<span class="remove-image" title="Remove">&times;</span>';
                            echo '<input type="hidden" name="bico_slider_images[]" value="' . esc_attr($image_id) . '" />';
                            echo '</div>';
                        }
                    }
                }
                ?>
            </div>
            <button type="button" class="button button-primary" id="add-slider-images">
                <?php _e('Add Images', 'bico-slider'); ?>
            </button>
            <p class="description">
                <?php _e('Click to add multiple images to the slider. You can drag and drop to reorder.', 'bico-slider'); ?>
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
            <p><?php _e('Use this shortcode to display the slider:', 'bico-slider'); ?></p>
            <input type="text" readonly value='[bico_slider id="<?php echo $post->ID; ?>"]' onclick="this.select();" style="width: 100%;" />
            <p class="description"><?php _e('Copy and paste this shortcode into any post, page, or widget.', 'bico-slider'); ?></p>
            <?php
        } else {
            echo '<p>' . __('Publish the slider to get the shortcode.', 'bico-slider') . '</p>';
        }
    }
    
    /**
     * Save slider meta
     */
    public function save_slider_meta($post_id, $post) {
        // Check nonce
        if (!isset($_POST['bico_slider_meta_box_nonce']) || !wp_verify_nonce($_POST['bico_slider_meta_box_nonce'], 'bico_slider_meta_box')) {
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
        if ('bico_slider' !== $post->post_type) {
            return;
        }
        
        // Save images
        if (isset($_POST['bico_slider_images'])) {
            $images = array_map('intval', $_POST['bico_slider_images']);
            update_post_meta($post_id, '_bico_slider_images', $images);
        } else {
            delete_post_meta($post_id, '_bico_slider_images');
        }
    }
    
    /**
     * Set custom columns
     */
    public function set_custom_columns($columns) {
        $new_columns = array();
        $new_columns['cb'] = $columns['cb'];
        $new_columns['title'] = $columns['title'];
        $new_columns['images_count'] = __('Images', 'bico-slider');
        $new_columns['shortcode'] = __('Shortcode', 'bico-slider');
        $new_columns['date'] = $columns['date'];
        return $new_columns;
    }
    
    /**
     * Custom column content
     */
    public function custom_column_content($column, $post_id) {
        switch ($column) {
            case 'images_count':
                $images = get_post_meta($post_id, '_bico_slider_images', true);
                echo !empty($images) ? count($images) : '0';
                break;
                
            case 'shortcode':
                echo '<input type="text" readonly value=\'[bico_slider id="' . $post_id . '"]\' onclick="this.select();" style="width: 200px;" />';
                break;
        }
    }
}
