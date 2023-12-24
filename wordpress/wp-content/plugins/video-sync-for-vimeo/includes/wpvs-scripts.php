<?php

add_action('wp_enqueue_scripts', 'rvs_wp_videos_load_js_scripts');

function rvs_wp_videos_load_js_scripts() {
    global $wpvs_videos_plugin_version;
    global $post;
    global $wpvs_theme_is_active;
    wp_register_script( 'youtube-player-js', '//www.youtube.com/iframe_api','','',true);
    wp_register_script( 'vimeo-player-js', '//player.vimeo.com/api/player.js','','',true);
    wp_register_script('wpvs-vimeo-player', plugins_url( '../js/wpvs-load-vimeo-player.js', __FILE__ ), array('jquery', 'vimeo-player-js'), $wpvs_videos_plugin_version, true);
    wp_register_script('wpvs-youtube-player', plugins_url( '../js/wpvs-load-youtube-player.js', __FILE__ ), array('jquery', 'youtube-player-js'), $wpvs_videos_plugin_version, true);

    if( ! empty($post) && is_singular('rvs_video') ) {
        $rvs_autoplay = get_option('rvs_video_autoplay', 0);
        $rvs_video_type = get_post_meta($post->ID, '_rvs_video_type', true);
        $wpvs_video_trailer_type = get_post_meta($post->ID, '_rvs_trailer_type', true);
        $play_next_video = false;
        if($rvs_autoplay && ($rvs_video_type == 'vimeo' || $rvs_video_type == 'youtube' || $rvs_video_type == 'wordpress') ) {
            $rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
            $rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
            $wpvs_autoplay_timer = get_option('wpvs_autoplay_timer', 5);
            $current_video_order = get_post_meta($post->ID, 'rvs_video_post_order', true);
            $video_categories = wp_get_post_terms($post->ID, 'rvs_video_category', array( 'fields' => 'id=>parent', 'orderby' => 'term_id' ));
            $video_terms = array();
            $video_parent_terms = array();

            if( $wpvs_theme_is_active && class_exists('WPVS_TV_Series') && ! empty($video_categories) ) {
                foreach($video_categories as $video_term_id => $parent_term_id) {
                    $category_has_seasons = get_term_meta($parent_term_id, 'cat_has_seasons', true);
                    if( $category_has_seasons ) {
                        $tv_series_id = $parent_term_id;
                        break;
                    }
                }
                if( ! empty($tv_series_id) ) {
                    $wpvs_series_manager = new WPVS_TV_Series($tv_series_id);
                    $season_term_ids = array_keys($video_categories);
                    // GET SEAONS FOR THIS SERIES
                    $series_seasons = $wpvs_series_manager->get_series_seasons();

                    // GET VIDEOS IN ORDER FOR EACH SEASON
                    if( ! empty($series_seasons) ) {
                        $no_more_episodes = false;
                        foreach($series_seasons as $key => $season) {
                            $wpvs_series_manager->set_season($season->term_id);
                            if( in_array($season->term_id, $season_term_ids) ) {
                                $next_video_id = $wpvs_series_manager->get_next_episode_id($post->ID);
                                if( empty($next_video_id) ) {
                                    $no_more_episodes = true;
                                    continue;
                                } else {
                                    break;
                                }
                            }
                            if( $no_more_episodes ) {
                                $next_video_id = $wpvs_series_manager->get_first_episode_id();
                                if( ! empty($next_video_id) ) {
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            if( empty($next_video_id) ) {
                $wp_video_args = array(
                    'post_type' => 'rvs_video',
                    'posts_per_page' => -1,
                    'nopaging' => true,
                    'fields' => 'ids',
                    'post__not_in' => array($post->ID),
                    'meta_query' => array(
                        'key' => 'rvs_video_post_order',
                        'value' => intval($current_video_order),
                        'type' => 'numeric',
                        'compare' => '>'
                    )
                );

                if( $rvs_video_order_settings == 'random' ) {
                    $wp_video_args['orderby'] = 'rand';
                    $wp_video_args['order'] = 'ASC';
                }
                if($rvs_video_order_settings == 'videoorder') {
                    $wp_video_args['meta_key'] = 'rvs_video_post_order';
                    $wp_video_args['orderby'] = 'meta_value_num';
                    $wp_video_args['order'] = $rvs_video_order_direction;
                }
                if($rvs_video_order_settings == 'alpha') {
                    $wp_video_args['orderby'] = 'title';
                    $wp_video_args['order'] = $rvs_video_order_direction;
                }

                if( ! empty($video_categories) ) {
                    foreach($video_categories as $term_id => $parent_term) {
                        $video_terms[] = intval($term_id);
                        if( ! empty($parent_term) ) {
                            $video_parent_terms[] = intval($parent_term);
                        }
                    }
                    $wp_video_args['tax_query'] = array(
                        array(
                            'taxonomy' => 'rvs_video_category',
                            'field' => 'term_id',
                            'terms' => $video_terms
                        )
                    );
                }
                $next_videos = get_posts($wp_video_args);

                if( empty($next_videos) && ! empty($video_parent_terms) ) {
                    $wp_video_args['tax_query'] = array(
                        array(
                            'taxonomy' => 'rvs_video_category',
                            'field' => 'term_id',
                            'terms' => $video_parent_terms
                        )
                    );
                    $next_videos = get_posts($wp_video_args);
                }
                if( ! empty($next_videos) ) {
                    $next_video_id = $next_videos[0];
                }
            }

            if( ! empty($next_video_id) ) {
                $next_video_link = get_permalink($next_video_id);
                $next_video_title = get_the_title($next_video_id);
            }

            if( ! empty($next_video_link) && ! empty($next_video_title) ) {
                wp_enqueue_script( 'rvs-wp-videos-autoplay', WPVS_VIDEOS_PLUGIN_URL .'js/rvs-autoplay-next.js','','',true );
                wp_localize_script('rvs-wp-videos-autoplay', 'wpvideosinfo', array(
                    'nextvideo' => $next_video_link,
                    'nextvideotitle' => $next_video_title,
                    'videotype' => $rvs_video_type,
                    'timer' => $wpvs_autoplay_timer
                )
                );
            }
        }

        if( $rvs_video_type == 'vimeo' || $wpvs_video_trailer_type == 'vimeo' ) {
            wp_enqueue_script( 'vimeo-player-js');
            wp_enqueue_script( 'wpvs-vimeo-player' );
            wp_localize_script('wpvs-vimeo-player', 'wpvsvimeoplayer', array(
                'autoplay' => $rvs_autoplay)
            );
        }

        if( $rvs_video_type == 'youtube' || $wpvs_video_trailer_type = 'youtube' ) {
            wp_enqueue_script( 'youtube-player-js' );
            wp_enqueue_script( 'wpvs-youtube-player' );
            wp_localize_script('wpvs-youtube-player', 'wpvsyoutubeplayer', array(
                'autoplay' => $rvs_autoplay)
            );
        }

    }
}


if( ! function_exists('wpvs_load_custom_player_js_files') ) {
function wpvs_load_custom_player_js_files() {
    global $post;
    global $wpvs_custom_player;
    if( isset($wpvs_custom_player['jsfiles']) && ! empty($wpvs_custom_player['jsfiles']) ) {
        echo $wpvs_custom_player['jsfiles'].PHP_EOL;
    }
    if( isset($wpvs_custom_player['customjs']) && ! empty($wpvs_custom_player['customjs']) ) {
        echo '<script>'.PHP_EOL;
        echo $wpvs_custom_player['customjs'].PHP_EOL;
        echo '</script>'.PHP_EOL;
    }
    if( ! empty($post) && $post->post_type == 'rvs_video' ) {
        $wpvs_custom_video_js = get_post_meta($post->ID, 'wpvs_custom_video_js', true);
        if( ! empty($wpvs_custom_video_js) ) {
            echo '<script>'.PHP_EOL;
            echo $wpvs_custom_video_js.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }
    }

}
global $wpvs_custom_player;
$wpvs_custom_player_js_output = 'footer';
if( ! empty($wpvs_custom_player) && isset($wpvs_custom_player['jsfileoutput']) ) {
    $wpvs_custom_player_js_output = $wpvs_custom_player['jsfileoutput'];
}
if($wpvs_custom_player_js_output == 'footer') {
    add_action('wp_footer', 'wpvs_load_custom_player_js_files');
    add_action('admin_footer', 'wpvs_load_custom_player_js_files');
}
if($wpvs_custom_player_js_output == 'head') {
    add_action('wp_head', 'wpvs_load_custom_player_js_files');
    add_action('admin_head', 'wpvs_load_custom_player_js_files');
}
}

if( ! function_exists('wpvs_load_custom_player_css_files') ) {
function wpvs_load_custom_player_css_files() {
    global $wpvs_custom_player;
    if( isset($wpvs_custom_player['cssfiles']) && ! empty($wpvs_custom_player['cssfiles']) ) {
        echo $wpvs_custom_player['cssfiles'].PHP_EOL;
    }

    if( isset($wpvs_custom_player['customcss']) && ! empty($wpvs_custom_player['customcss']) ) {
        echo '<style type="text/css">'.PHP_EOL;
        echo $wpvs_custom_player['customcss'].PHP_EOL;
        echo '</style>'.PHP_EOL;
    }
}
global $wpvs_custom_player;
if( ! empty($wpvs_custom_player) ) {
    add_action('wp_head', 'wpvs_load_custom_player_css_files');
    add_action('admin_head', 'wpvs_load_custom_player_css_files');
}
}

/* ==== ADMIN SCRIPTS AND CSS ==== */

function wpvs_load_admin_css_files() {
    global $wpvs_videos_plugin_version;
    $current_admin_screen = get_current_screen();
    global $post_type;
    wp_register_style( 'wp-videos-admin', plugins_url( '../css/admin.css', __FILE__ ),'', $wpvs_videos_plugin_version);
    wp_register_style('wpvs-videos-style', plugins_url( '../css/wpvs-styles.css', __FILE__ ),'', $wpvs_videos_plugin_version);
    wp_enqueue_style('wp-videos-admin');
    wp_enqueue_style('wpvs-videos-style' );

}

function wpvs_load_admin_js_scripts() {
    global $wpvs_videos_plugin_version;
    wp_register_script('wpvs-update-loading', plugins_url( '../js/rvs-loading.js', __FILE__ ), array('jquery'), $wpvs_videos_plugin_version, true);
    wp_register_script('wpvs-rest-api-setup', plugins_url( '../js/admin/wpvs-rest-api-setup.js', __FILE__ ), array('jquery'), $wpvs_videos_plugin_version, true);
    wp_register_script('wpvs-video-admin-settings', plugins_url( '../js/admin/rvs-video-settings.js' , __FILE__ ), array('jquery'), $wpvs_videos_plugin_version, true);
    wp_enqueue_script('wpvs-update-loading');
    wp_register_script( 'rvs-admin-js', plugins_url( '../js/admin/rvs-admin.js', __FILE__ ),array('jquery'), $wpvs_videos_plugin_version);
    wp_enqueue_script('rvs-admin-js');
}

add_action('admin_enqueue_scripts', 'wpvs_load_admin_css_files' );
add_action('admin_enqueue_scripts', 'wpvs_load_admin_js_scripts');
