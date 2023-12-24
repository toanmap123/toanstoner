<?php

class WPVS_VIDEOS_ADMIN_PAGES_MANAGER {
    protected $assets_path;
    public $wpvs_memberships_active;
    public function __construct() {
        $this->assets_path = plugin_dir_url(__FILE__);
        $this->wpvs_memberships_active = wpvs_check_for_membership_add_on();
        add_action( 'admin_init', array($this, 'register_wpvs_plugin_settings' ) );
        add_action( 'admin_menu', array($this, 'register_wpvs_plugin_admin_pages' ) );

        add_action('update_option_wpvs-video-slug-settings', array($this, 'wpvs_slug_changes_check'), 10, 2);
        add_action('update_option_wpvs-genre-slug-settings', array($this, 'wpvs_slug_changes_check'), 10, 2);
        add_action('update_option_wpvs-actor-slug-settings', array($this, 'wpvs_slug_changes_check'), 10, 2);
        add_action('update_option_wpvs-director-slug-settings', array($this, 'wpvs_slug_changes_check'), 10, 2);

        add_action( 'wpvs_run_flush_rewrite_event', array($this, 'wpvs_flush_rewrite_on_slug_changes') );
	}

    public function register_wpvs_plugin_settings() {

        register_setting( 'wpvs-rest-api-keys', 'wpvs_rest_api_client_id' );
        register_setting( 'wpvs-rest-api-keys', 'wpvs_rest_api_secret' );

        register_setting( 'wpvs-video-settings', 'rvs_video_position' );
        register_setting( 'wpvs-video-settings', 'rvs_video_ordering' );
        register_setting( 'wpvs-video-settings', 'rvs_video_order_direction' );
        register_setting( 'wpvs-video-settings', 'rvs_video_autoplay' );
        register_setting( 'wpvs-video-settings', 'wpvs_autoplay_timer' );
        register_setting( 'wpvs-video-settings', 'rvs_load_template_css' );
        register_setting( 'wpvs-video-settings', 'wpvs_videos_thumbnail_size' );

        register_setting( 'wpvs-video-settings', 'wpvs-video-slug-settings' );
        register_setting( 'wpvs-video-settings', 'wpvs-genre-slug-settings' );
        register_setting( 'wpvs-video-settings', 'wpvs-actor-slug-settings' );
        register_setting( 'wpvs-video-settings', 'wpvs-director-slug-settings' );

        register_setting( 'vimeo-sync-access', 'rvs-username-access' );
        register_setting( 'vimeo-sync-access', 'wpvs-access-check-token' );
        register_setting( 'vimeo-sync-access', 'rvs-activated' );
        register_setting( 'vimeo-sync-access', 'rvs-access-check-time' );
        register_setting( 'wpvs-custom-player-settings', 'wpvs-custom-player' );
    }

    public function register_wpvs_plugin_admin_pages() {
        add_menu_page( 'WP Videos', 'WP Videos', 'manage_options', 'vimeo-sync', array($this,'wpvs_display_plugin_home'),
    'dashicons-video-alt3');
        add_submenu_page( 'vimeo-sync', 'Activation', 'Activation', 'manage_options', 'rvs-activation', array($this, 'wpvs_activation' ) );
        add_submenu_page( 'vimeo-sync', 'Video Settings', 'Video Settings', 'manage_options', 'wpvs-video-settings', array($this, 'wpvs_video_settings') );
        add_submenu_page( 'vimeo-sync', 'Custom Player', 'Custom Player', 'manage_options', 'wpvs-custom-player-settings', array($this, 'wpvs_custom_player_settings') );
        add_submenu_page( 'vimeo-sync', 'Shortcodes/Blocks', 'Shortcodes/Blocks', 'manage_options', 'wpvs-shortcodes-blocks', array($this, 'wpvs_shortcodes_blocks') );
        if( ! $this->wpvs_memberships_active ) {
            add_submenu_page( 'vimeo-sync', 'Subscriptions', 'Subscriptions', 'manage_options', 'rvs-membership-add-on', array($this, 'wpvs_membership_add_on' ) );
        } else {
            do_action( 'rvs_add_membership_menu_items' );
        }
        remove_submenu_page('vimeo-sync','vimeo-sync');
    }

    public function wpvs_display_plugin_home() {

    }

    public function wpvs_membership_add_on() {
        require_once('rvs-membership-add-on.php');
    }

    public function wpvs_shortcodes_blocks() {
        require_once('wpvs-shortcode-overview.php');
    }

    public function wpvs_video_settings() {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script('wp-color-picker' );
        require_once('wp-videos-setup.php');
    }

    public function wpvs_custom_player_settings() {
        $js_editor = wp_enqueue_code_editor( array( 'type' => 'text/javascript') );
        $css_editor = wp_enqueue_code_editor( array( 'type' => 'text/css') );
        $js_file_editor = wp_enqueue_code_editor( array( 'type' => 'text/html') );
        $css_file_editor = wp_enqueue_code_editor( array( 'type' => 'text/html') );
        wp_add_inline_script('code-editor',
        sprintf(
                'jQuery( function() { wp.codeEditor.initialize( "wpvs-js-editor", %s ); } );',
                wp_json_encode( $js_editor )
            )
        );
        wp_add_inline_script('code-editor',
        sprintf(
                'jQuery( function() { wp.codeEditor.initialize( "wpvs-css-editor", %s ); } );',
                wp_json_encode( $css_editor )
            )
        );
        wp_add_inline_script('code-editor',
        sprintf(
                'jQuery( function() { wp.codeEditor.initialize( "wpvs-js-file-editor", %s ); } );',
                wp_json_encode( $js_file_editor )
            )
        );
        wp_add_inline_script('code-editor',
        sprintf(
                'jQuery( function() { wp.codeEditor.initialize( "wpvs-css-file-editor", %s ); } );',
                wp_json_encode( $css_file_editor )
            )
        );
        require_once('wp-videos-custom-player-settings.php');
    }

    public function wpvs_activation() {
        require_once('rvs-activation.php');
    }

    public function wpvs_slug_changes_check($old_value, $new_value) {
        if($old_value['slug'] != $new_value['slug']) {
            wp_schedule_single_event(time(), 'wpvs_run_flush_rewrite_event');
        }
    }

    public function wpvs_flush_rewrite_on_slug_changes() {
        flush_rewrite_rules();
    }
}
$wpvs_videos_admin_pages_manager = new WPVS_VIDEOS_ADMIN_PAGES_MANAGER();
