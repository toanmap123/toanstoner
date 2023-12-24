<?php

class WPVS_VIDEOS_CONTENT_MANAGER {
	protected $assets_path;
    public $wpvs_memberships_active;
    public $load_wpvs_archive_css;
	public function __construct() {
        global $wpvs_theme_is_active;
		$this->assets_path = plugin_dir_url(__FILE__);
        $this->wpvs_memberships_active = wpvs_check_for_membership_add_on();
        $this->load_wpvs_archive_css = get_option('rvs_load_template_css', 1);
        add_action( 'wp_enqueue_scripts', array($this, 'add_plugin_css') );
		add_action( 'wp_enqueue_scripts', array($this, 'add_plugin_js') );
        add_action( 'pre_get_posts', array($this, 'wpvs_order_video_posts') );
        if( ! $wpvs_theme_is_active ) {
            add_filter( 'single_template', array($this, 'wpvs_video_post_type_template') );
        }

	}

    public function add_plugin_css() {
        global $wpvs_videos_plugin_version;
		global $wpvs_videos_plugin_version;
	    wp_register_style('wpvs-videos-style', $this->assets_path.'../css/wpvs-styles.css','', $wpvs_videos_plugin_version);
		wp_register_style('wpvs-videos-list', $this->assets_path.'../blocks/liststyle.css','', $wpvs_videos_plugin_version);
		wp_enqueue_style('wpvs-videos-style');
        if( $this->load_wpvs_archive_css && $this->is_wpvs_taxonomy() ) {
            wp_enqueue_style('wpvs-videos-list');
        }
    }

	public function add_plugin_js() {
	    global $wpvs_videos_plugin_version;
	    wp_register_script('wpvs-update-loading', plugins_url( '../js/rvs-loading.js', __FILE__ ), array('jquery'), $wpvs_videos_plugin_version, true);
	    wp_enqueue_script('wpvs-update-loading');
	}

    public function filter_wpvs_content( $content ) {
        global $post;
        $custom_content = "";
        if(get_option('rvs_video_position') == "below") {
            $custom_content = $content;
        }
        $wpvs_single_video = new WPVS_SINGLE_VIDEO($post->ID);
        $custom_content .= $wpvs_single_video->get_video_content();

        if(get_option('rvs_video_position') == "above") {
            $custom_content .= $content;
        }
        return $custom_content;
    }

    public function wpvs_video_post_type_template($single_template) {
         global $post;
         if ($post->post_type == 'rvs_video') {
            wp_enqueue_style( 'dashicons' );
            add_filter( 'the_content', array($this, 'filter_wpvs_content') );
         }
        return $single_template;
    }

    public function is_wpvs_taxonomy() {
        $is_wpvs_taxonomy = false;
        if( is_post_type_archive('rvs_video') || is_tax('rvs_video_category') || is_tax('rvs_video_tags') || is_tax('rvs_actors') || is_tax('rvs_directors') ) {
            $is_wpvs_taxonomy = true;
        }
        return $is_wpvs_taxonomy;
    }

    public function wpvs_order_video_posts( $query ) {
        if( ! is_admin() && $this->is_wpvs_taxonomy() ) {
            $rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
            $rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
            if( $rvs_video_order_settings == 'random' ) {
                set_query_var('orderby', 'rand');
                set_query_var('order', 'ASC');
            }
            if($rvs_video_order_settings == 'videoorder') {
                set_query_var('meta_key', 'rvs_video_post_order');
                set_query_var('orderby', 'meta_value_num');
                set_query_var('order', $rvs_video_order_direction);
            }
            if($rvs_video_order_settings == 'alpha') {
                set_query_var('orderby', 'title');
                set_query_var('order', $rvs_video_order_direction);
            }
        }
    }
}
$wpvs_videos_content_manager = new WPVS_VIDEOS_CONTENT_MANAGER();
