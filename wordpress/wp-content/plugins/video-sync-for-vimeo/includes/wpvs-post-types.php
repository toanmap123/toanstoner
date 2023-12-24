<?php

class WPVS_REGISTER_POST_TYPES_MANAGER {
	public function __construct() {
        add_action( 'init', array($this, 'create_video_post_type' ) );
        add_action( 'init', array($this, 'create_video_categories'), 0 );
        add_action( 'init', array($this, 'create_video_actors'), 0 );
        add_action( 'init', array($this, 'create_video_directors'), 0 );
        add_action( 'init', array($this, 'create_video_tags'), 0 );
        add_filter('post_link',  array($this, 'structure_video_permalink'), 1, 3 );
        add_filter('post_type_link',  array($this, 'structure_video_permalink'), 1, 3);
	}

    public function create_video_post_type() {
        global $wpvs_video_slug_settings;
        $labels = array(
            'name'               => _x( 'Videos', 'post type general name' ),
            'singular_name'      => _x( 'Video', 'post type singular name' ),
            'add_new'            => _x( 'Add New', 'video' ),
            'add_new_item'       => __( 'Add New Video' ),
            'edit_item'          => __( 'Edit Video' ),
            'new_item'           => __( 'New Video' ),
            'all_items'          => __( 'All Videos' ),
            'view_item'          => __( 'View Video' ),
            'search_items'       => __( 'Search Videos' ),
            'not_found'          => __( 'No videos found' ),
            'not_found_in_trash' => __( 'No videos found in the Trash' ),
            'parent_item_colon'  => '',
            'menu_name'          => 'Videos'
        );
        $args = array(
            'labels'        => $labels,
            'description'   => 'WP Videos',
            'public'        => true,
            'menu_position' => 10,
            'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author' ),
            'rewrite'            => array( 'slug' => $wpvs_video_slug_settings['slug'].'/%rvs_video_category%','with_front' => true ),
            'taxonomies'    => array('rvs_video_category'),
            'has_archive'   => $wpvs_video_slug_settings['slug'],
            'menu_icon'          => 'dashicons-video-alt2',
            'show_in_rest' => true,
            'rest_base' => 'wpvsvideos'
        );
        register_post_type( 'rvs_video', $args );
    }

    public function create_video_categories() {
        global $wpvs_genre_slug_settings;
        $labels = array(
            'name'              => _x( $wpvs_genre_slug_settings['name-plural'], 'taxonomy general name' ),
            'singular_name'     => _x( $wpvs_genre_slug_settings['name'], 'taxonomy singular name' ),
            'search_items'      => __( 'Search '.$wpvs_genre_slug_settings['name-plural'] ),
            'all_items'         => __( 'All '.$wpvs_genre_slug_settings['name-plural'] ),
            'parent_item'       => __( 'Parent '.$wpvs_genre_slug_settings['name'] ),
            'parent_item_colon' => __( 'Parent '.$wpvs_genre_slug_settings['name'].':' ),
            'edit_item'         => __( 'Edit '.$wpvs_genre_slug_settings['name'] ),
            'update_item'       => __( 'Update '.$wpvs_genre_slug_settings['name'] ),
            'add_new_item'      => __( 'Add New '.$wpvs_genre_slug_settings['name'] ),
            'new_item_name'     => __( 'New '.$wpvs_genre_slug_settings['name'] ),
            'parent_item_colon'  => '',
            'menu_name'         => __( $wpvs_genre_slug_settings['name-plural'] ),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'rewrite'            => array( 'slug' => $wpvs_genre_slug_settings['slug'] ),
            'show_in_nav_menus' => true,
            'show_in_rest' => true,
            'rest_base' => 'wpvsgenres'
            );
            register_taxonomy( 'rvs_video_category', 'rvs_video', $args );
    }

    public function create_video_actors() {
        global $wpvs_actor_slug_settings;
        $labels = array(
            'name'              => _x( $wpvs_actor_slug_settings['name-plural'], 'taxonomy general name' ),
            'singular_name'     => _x( $wpvs_actor_slug_settings['name'], 'taxonomy singular name' ),
            'search_items'      => __( 'Search '.$wpvs_actor_slug_settings['name-plural'] ),
            'all_items'         => __( 'All '.$wpvs_actor_slug_settings['name-plural'] ),
            'parent_item'       => __( 'Parent '.$wpvs_actor_slug_settings['name'] ),
            'parent_item_colon' => __( 'Parent '.$wpvs_actor_slug_settings['name'].':' ),
            'edit_item'         => __( 'Edit '.$wpvs_actor_slug_settings['name'] ),
            'update_item'       => __( 'Update '.$wpvs_actor_slug_settings['name'] ),
            'add_new_item'      => __( 'Add New '.$wpvs_actor_slug_settings['name'] ),
            'new_item_name'     => __( 'New '.$wpvs_actor_slug_settings['name'] ),
            'parent_item_colon'  => '',
            'menu_name'         => __( $wpvs_actor_slug_settings['name-plural'] ),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'rewrite'            => array( 'slug' => $wpvs_actor_slug_settings['slug'] ),
            'show_in_nav_menus' => true,
            'show_in_rest' => true,
            'rest_base' => 'wpvsactors'
        );
      register_taxonomy( 'rvs_actors', 'rvs_video', $args );
    }

    public function create_video_directors() {
        global $wpvs_director_slug_settings;
        $labels = array(
            'name'              => _x( $wpvs_director_slug_settings['name-plural'], 'taxonomy general name' ),
            'singular_name'     => _x( $wpvs_director_slug_settings['name'], 'taxonomy singular name' ),
            'search_items'      => __( 'Search '.$wpvs_director_slug_settings['name-plural'] ),
            'all_items'         => __( 'All '.$wpvs_director_slug_settings['name-plural'] ),
            'parent_item'       => __( 'Parent '.$wpvs_director_slug_settings['name'] ),
            'parent_item_colon' => __( 'Parent '.$wpvs_director_slug_settings['name'].':' ),
            'edit_item'         => __( 'Edit '.$wpvs_director_slug_settings['name'] ),
            'update_item'       => __( 'Update '.$wpvs_director_slug_settings['name'] ),
            'add_new_item'      => __( 'Add New '.$wpvs_director_slug_settings['name'] ),
            'new_item_name'     => __( 'New '.$wpvs_director_slug_settings['name'] ),
            'parent_item_colon'  => '',
            'menu_name'         => __( $wpvs_director_slug_settings['name-plural'] ),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'rewrite'            => array( 'slug' => $wpvs_director_slug_settings['slug'] ),
            'show_in_nav_menus' => true,
            'show_in_rest' => true,
            'rest_base' => 'wpvsdirectors'
        );
        register_taxonomy( 'rvs_directors', 'rvs_video', $args );
    }

    public function create_video_tags() {
        $labels = array(
            'name'              => _x( 'Video Tags', 'taxonomy general name' ),
            'singular_name'     => _x( 'Video Tags', 'taxonomy singular name' ),
            'search_items'      => __( 'Search Video Tags' ),
            'all_items'         => __( 'All Video Tags' ),
            'edit_item'         => __( 'Edit Video Tag' ),
            'update_item'       => __( 'Update Video Tag' ),
            'add_new_item'      => __( 'Add New Video Tag' ),
            'new_item_name'     => __( 'New Video Tag' ),
            'parent_item_colon'  => '',
            'menu_name'         => __( 'Video Tags' ),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'rewrite'            => array( 'slug' => 'video-tag' ),
            'show_in_rest' => true,
            'rest_base' => 'wpvsvideotags'
        );
        register_taxonomy( 'rvs_video_tags', 'rvs_video', $args );
    }

    public function structure_video_permalink($permalink, $post_id, $leavename) {
        global $wpvs_video_slug_settings;

        if (strpos($permalink, '%rvs_video_category%') === FALSE) {
            return $permalink;
        }
        $post = get_post($post_id);
        if (!$post) return $permalink;
        $terms = wp_get_object_terms($post->ID, 'rvs_video_category');
        if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0])) {
            $taxonomy_slug = $terms[0]->slug;
        } else {
            $taxonomy_slug = $wpvs_video_slug_settings['single-slug'];
        }
        return str_replace('%rvs_video_category%', $taxonomy_slug, $permalink);
    }

}
$wpvs_register_post_types_manager = new WPVS_REGISTER_POST_TYPES_MANAGER();
