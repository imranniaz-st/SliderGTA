<?php
/**
 * Bico Slider Plugin Update Checker
 */

if (!defined('ABSPATH')) {
    exit;
}

class Bico_Slider_Updates {
    
    private static $_instance = null;
    private $update_url = 'https://bicodev.com/api/updates/bico-slider';
    
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function __construct() {
        add_filter('plugins_api', array($this, 'plugin_info'), 20, 3);
        add_filter('site_transient_update_plugins', array($this, 'push_update'));
        add_action('admin_init', array($this, 'add_admin_notice'));
        add_action('admin_head', array($this, 'admin_styles'));
    }
    
    /**
     * Get latest version info
     */
    public function get_version_info() {
        $transient = get_transient('bico_slider_version_info');
        
        if (!$transient) {
            $response = wp_remote_get('https://api.github.com/repos/imranniaz-st/SliderGTA/releases/latest', array(
                'timeout' => 10,
                'sslverify' => true,
            ));
            
            if (is_wp_error($response)) {
                return null;
            }
            
            $data = json_decode(wp_remote_retrieve_body($response), true);
            
            if ($data && !isset($data['message'])) {
                $transient = array(
                    'version' => $data['tag_name'],
                    'download_url' => $data['zipball_url'],
                    'body' => $data['body'],
                    'published_at' => $data['published_at'],
                );
                set_transient('bico_slider_version_info', $transient, 12 * HOUR_IN_SECONDS);
                return $transient;
            }
        }
        
        return $transient;
    }
    
    /**
     * Push update notification
     */
    public function push_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }
        
        $version_info = $this->get_version_info();
        
        if (!$version_info) {
            return $transient;
        }
        
        $current_version = BICO_SLIDER_VERSION;
        $remote_version = str_replace('v', '', $version_info['version']);
        
        if (version_compare($remote_version, $current_version, '>')) {
            $update = new stdClass();
            $update->slug = 'bico-slider';
            $update->plugin = plugin_basename(BICO_SLIDER_PATH . 'slider-gta.php');
            $update->new_version = $remote_version;
            $update->url = 'https://bicodev.com';
            $update->package = $version_info['download_url'];
            $update->tested = '6.4';
            $update->requires = '5.0';
            $update->requires_php = '7.0';
            
            $transient->response['bico-slider/slider-gta.php'] = $update;
        }
        
        return $transient;
    }
    
    /**
     * Plugin info for details popup
     */
    public function plugin_info($res, $action, $args) {
        if ($action === 'plugin_information' && isset($args->slug) && $args->slug === 'bico-slider') {
            $version_info = $this->get_version_info();
            
            if ($version_info) {
                $res = new stdClass();
                $res->name = 'Bico Slider';
                $res->slug = 'bico-slider';
                $res->version = str_replace('v', '', $version_info['version']);
                $res->author = 'Bicodev';
                $res->author_profile = 'https://bicodev.com';
                $res->homepage = 'https://bicodev.com';
                $res->requires = '5.0';
                $res->requires_php = '7.0';
                $res->tested = '6.4';
                $res->sections = array(
                    'description' => 'Beautiful image slider for WordPress with Swiper.js, multiple sliders, shortcodes, and Elementor support.',
                    'changelog' => $version_info['body'],
                );
                $res->download_link = $version_info['download_url'];
            }
        }
        
        return $res;
    }
    
    /**
     * Add admin notice for updates
     */
    public function add_admin_notice() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        $current_version = BICO_SLIDER_VERSION;
        $version_info = $this->get_version_info();
        
        if (!$version_info) {
            return;
        }
        
        $remote_version = str_replace('v', '', $version_info['version']);
        
        if (version_compare($remote_version, $current_version, '>')) {
            add_action('admin_notices', array($this, 'render_update_notice'));
        }
    }
    
    /**
     * Render update notice
     */
    public function render_update_notice() {
        $version_info = $this->get_version_info();
        if (!$version_info) {
            return;
        }
        
        $remote_version = str_replace('v', '', $version_info['version']);
        ?>
        <div class="notice notice-info is-dismissible bico-slider-notice">
            <div class="bico-slider-notice-content">
                <h3 style="margin-top: 0;">
                    <span class="dashicons dashicons-update"></span>
                    Bico Slider Update Available
                </h3>
                <p>
                    <strong>New Version:</strong> <?php echo esc_html($remote_version); ?><br>
                    <strong>Current Version:</strong> <?php echo esc_html(BICO_SLIDER_VERSION); ?>
                </p>
                <p>
                    <a href="<?php echo esc_url(self_admin_url('plugins.php?plugin_status=upgrade')); ?>" 
                       class="button button-primary bico-slider-update-btn">
                        Update Now
                    </a>
                    <a href="https://bicodev.com/changelog" target="_blank" class="button button-secondary">
                        View Changelog
                    </a>
                </p>
            </div>
        </div>
        <?php
    }
    
    /**
     * Admin styles
     */
    public function admin_styles() {
        ?>
        <style>
            .bico-slider-notice {
                border-left: 4px solid #0073aa !important;
                background-color: #f0f8ff !important;
                padding: 15px !important;
            }
            
            .bico-slider-notice-content {
                padding: 10px 0;
            }
            
            .bico-slider-notice h3 {
                color: #0073aa;
                font-size: 16px;
                margin-bottom: 10px;
            }
            
            .bico-slider-notice .dashicons {
                vertical-align: middle;
                margin-right: 8px;
            }
            
            .bico-slider-update-btn {
                background-color: #0073aa;
                border-color: #005a87;
            }
            
            .bico-slider-update-btn:hover {
                background-color: #005a87;
                border-color: #003d5c;
            }
        </style>
        <?php
    }
}

// Initialize updates
Bico_Slider_Updates::instance();
