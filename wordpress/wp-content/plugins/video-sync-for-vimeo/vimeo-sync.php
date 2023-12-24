<?php
/*
Plugin Name: WP Videos
Plugin URI:  https://www.wpvideosubscriptions.com
Description: Creates video post types for Vimeo videos, YouTube urls or custom video embed / iframe code.
Version:     3.0.8
Author:      Rogue Web Design
Author URI:  https://roguewebdesign.ca
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: vimeosync
*/

/*
WP Videos is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

WP Videos is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with WP Videos. If not, see WP Videos.
*/

const WPVS_VIMEO_REDIRECT_URI = 'https://www.wpvideosubscriptions.com/callback/';

if(!defined('WPVS_VIDEOS_PLUGIN_URL')) {
	define('WPVS_VIDEOS_PLUGIN_URL', plugin_dir_url(__FILE__));
}
if(!defined('WPVS_VIDEOS_PLUGIN_DIR')) {
	define('WPVS_VIDEOS_PLUGIN_DIR', dirname(__FILE__));
}

if ( ! defined('WP_VIDEOS_VERSION') ) {
    define('WP_VIDEOS_VERSION', '3.0.8');
}

global $wpvs_plugin_text_domain;
global $wpvs_videos_plugin_version;
global $wpvs_vimeo_api_key;
global $wpvs_custom_player;
global $wpvs_theme_is_active;
$wpvs_plugin_text_domain = 'vimeosync';
$wpvs_custom_player = get_option('wpvs-custom-player');
$wpvs_vimeo_api_key = esc_attr(get_option('rvs_user_api_key'));
$wpvs_videos_plugin_version = get_option('wpv_vimeosync_current_version');
$wpvs_theme_is_active = get_option('wpvs_theme_active');

function wpvideos_plugin_install() {
	$wpvs_theme_is_active = get_option('wpvs_theme_active');
    if (version_compare(PHP_VERSION, '5.5') < 0) {
        $upgrade_message = 'You need to upgrade to at least PHP version 5.5 to use the WP Videos plugin. <br><br><a href="'.admin_url('plugins.php').'">&laquo; Return to Plugins</a>';
        wp_die($upgrade_message, 'PHP Version Update Required');
    }
    update_option('wpv_vimeosync_current_version', '3.0.8');
	if( ! $wpvs_theme_is_active ) {
    	flush_rewrite_rules();
	}
}
register_activation_hook( __FILE__, 'wpvideos_plugin_install' );

function wpvideos_plugin_uninstall() {
    delete_option('wpv_vimeosync_current_version');
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'wpvideos_plugin_uninstall' );

function run_wpvideos_plugin_update() {
    global $wpvs_videos_plugin_version;
    $current_version_number = intval(str_replace(".","",$wpvs_videos_plugin_version));
	if( $current_version_number < 306 ) {
		$wpvs_videos_thumbnail_size = get_option('wpvs_videos_thumbnail_size');
		if( empty($wpvs_videos_thumbnail_size) ) {
			update_option('wpvs_videos_thumbnail_size', array('width' => 640, 'height' => 360));
		}
	}
    update_option('wpv_vimeosync_current_version', '3.0.8');
}

if( ! function_exists('wpvideos_update_version_check')) {
	function wpvideos_update_version_check() {
	    global $wpvs_videos_plugin_version;
	    if(WP_VIDEOS_VERSION !== $wpvs_videos_plugin_version) {
	        run_wpvideos_plugin_update();
	    }
	}
}

add_action( 'wp_loaded', 'wpvideos_update_version_check' );

function wpvs_plugin_init_setup() {
	$wpvs_videos_thumbnail_size = get_option('wpvs_videos_thumbnail_size');
	if( empty($wpvs_videos_thumbnail_size) ) {
		$wpvs_videos_thumbnail_size = array(
			'width' => 640,
			'height' => 360
		);
	}
	add_image_size('rvs-video-size', $wpvs_videos_thumbnail_size['width'], $wpvs_videos_thumbnail_size['height'], true);
}
add_action( 'init', 'wpvs_plugin_init_setup' );

if( ! function_exists('wpvs_check_for_membership_add_on')) {
	function wpvs_check_for_membership_add_on() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if( is_plugin_active('vimeo-sync-memberships/vimeo-sync-memberships.php') ) {
			return true;
		}
		return false;
	}
}

if( ! $wpvs_theme_is_active ) {
	require_once('includes/wpvs-scripts.php');
	require_once('includes/wpvs-slug-settings.php');
	require_once('includes/admin/admin-pages.php');
	require_once('includes/wpvs-post-types.php');
	require_once('includes/rvs-post-options.php');
	require_once('includes/wpvs-video-class.php');
	require_once('includes/wpvs-rest-api-functions.php');
	require_once('includes/wpvs-functions.php');
	require_once('includes/custom-widgets.php');
	require_once('blocks/index.php');
	require_once('includes/shortcodes.php');

	if(is_admin()) {
	    require_once('includes/admin/wp-videos-term-meta.php');
	    require_once('includes/admin/rvs-admin-functions.php');
		require_once('includes/admin/activation-manager.php');
	    require_once('includes/rvs-ajax.php');
	}
} else {
	if( ! function_exists('wpvs_themes_500_update_admin_notice') ) {
		function wpvs_themes_500_update_admin_notice() {
            add_action( 'admin_notices', 'vs_netflix_wp_videos_update_message_500' );
            function vs_netflix_wp_videos_update_message_500() {
                $vs_netflix_admin_notice = '<div class="update-nag">';
                $vs_netflix_admin_notice .= 'IMPORTANT: Version <strong>5.0.0</strong> of the <strong>VS Netflix Theme</strong> no longer requires the WP Videos plugin.';
                $vs_netflix_admin_notice .= ' Please <a href="'.admin_url('plugins.php').'"><strong>deactivate</strong></a> the <strong>WP Videos</strong> plugin if you are using version 5.0.0 or higher of the VS Netflix Theme.';
                $vs_netflix_admin_notice .= '</div>';
                echo $vs_netflix_admin_notice;
            }
		}
		add_action('admin_init', 'wpvs_themes_500_update_admin_notice');
	}
}
