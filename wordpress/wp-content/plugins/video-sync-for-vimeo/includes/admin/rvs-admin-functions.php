<?php

function wpvideos_create_vimeo_video_post($videoId, $videoName, $videoDescription, $video_thumbnails, $videoOrder, $video_duration) {
    $new_video_added = false;
    $current_time = current_time('timestamp') + ($videoOrder*0.001);
    $added_date = date('Y-m-d H:i:s', $current_time);

    $newiFrameSrc = 'https://player.vimeo.com/video/' . $videoId;
    $videoHtml = '<iframe class="wpvs-vimeo-video-player" src="' . $newiFrameSrc . '" width="1280" height="720" frameborder="0" title="' . $postTitle . '" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" allow="autoplay"></iframe>';
    $vimeo_video_args = array(
        'post_type' => 'rvs_video',
        'post_status' => 'any',
        'posts_per_page' => -1,
        'nopaging' => true,
        'fields' => 'ids',
        'meta_query' => array(
            'relation' => 'AND',
             array(
                 'key' => '_rvs_video_type',
                 'value' => 'vimeo',
                 'compare' => '='

             ),
             array(
                 'key' => 'rvs_video_post_vimeo_id',
                 'value' => $videoId,
                 'compare' => '='
             )
         )
    );
    $rvs_vimeo_videos = get_posts(  $vimeo_video_args );

    if(empty($rvs_vimeo_videos)) {
        if($videoDescription == null) {
            $videoDescription = "";
        }

        $new_rvs_video = array(
          'post_type' => 'rvs_video',
          'post_title'    => $videoName,
          'post_content' => $videoDescription,
          'post_status'   => 'publish',
          'post_date' => date($added_date)
        );
        // Insert the post into the database
        $post_id = wp_insert_post( $new_rvs_video, $wp_error );
        if(is_wp_error($post_id)) {
            $post_id->get_error_message();
            $new_video_added = false;
        } else {
            add_post_meta($post_id, 'rvs_video_post_vimeo_id', $videoId, true);
            add_post_meta($post_id, 'rvs_video_post_vimeo_html', $videoHtml, true);
            add_post_meta($post_id, '_rvs_memberships', array(), true);
            add_post_meta($post_id, 'rvs_video_post_order', $videoOrder, true);
            add_post_meta($post_id, '_rvs_video_type', 'vimeo');
            if( ! empty($video_thumbnails)) {
                if( isset($video_thumbnails['featured']) && ! empty($video_thumbnails['featured']) ) {
                    add_post_meta($post_id, 'wpvs_featured_image', $video_thumbnails['featured']);
                }
                if( isset($video_thumbnails['thumbnail']) && ! empty($video_thumbnails['thumbnail']) ) {
                    add_post_meta($post_id, 'rvs_thumbnail_image', $video_thumbnails['thumbnail']);
                }
            }
            add_post_meta($post_id, 'wpvs_video_length', $video_duration, true);
            $wpvs_video_hours = intval(gmdate("H", $video_duration));
            $wpvs_video_minutes = intval(gmdate("i", $video_duration));
            $wpvs_video_information = array(
                'length' => $video_duration,
                'hours' => $wpvs_video_hours,
                'minutes' => $wpvs_video_minutes,
                'date_released' => ""
            );
            add_post_meta($post_id, 'wpvs_video_information', $wpvs_video_information, true);
            $add_video_count++;
            $new_video_added = true;
        }
    }
    return $new_video_added;
}

function rvs_update_vimeo_player($wpv_video_id, $postTitle) {
    // UPDATE MAIN VIDEO
    $video_id = get_post_meta($wpv_video_id, 'rvs_video_post_vimeo_id', true);
    $newiFrameSrc = 'https://player.vimeo.com/video/' . $video_id;
    $newiFrame = '<iframe class="wpvs-vimeo-video-player" src="' . $newiFrameSrc . '" width="1280" height="720" frameborder="0" title="' . $postTitle . '" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" allow="autoplay"></iframe>';
    update_post_meta($wpv_video_id, 'rvs_video_post_vimeo_html', $newiFrame);

}

function rvs_update_vimeo_trailer($wpv_video_id, $postTitle) {
    // UPDATE TRAILER
    $trailer_vimeo_id = get_post_meta($wpv_video_id, 'rvs_trailer_vimeo_id', true);
    if(!empty($trailer_vimeo_id)) {
        $new_vimeo_src = 'https://player.vimeo.com/video/' . $trailer_vimeo_id;
        $new_vimeo_iframe = '<iframe class="wpvs-vimeo-trailer-player" src="' . $trailer_vimeo_id . '" width="1280" height="720" frameborder="0" title="' . $postTitle . ' Trailer" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" allow="autoplay"></iframe>';
        update_post_meta($wpv_video_id, 'rvs_trailer_html', $new_vimeo_iframe);
    }
}

function rvs_update_youtube_player($wpv_video_id) {
    $youtube_id = null;
    // UPDATE MAIN VIDEO
    $youtube_url = get_post_meta($wpv_video_id, 'rvs_youtube_url', true);

    if( ! empty($youtube_url) ) {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $youtube_url, $matches);
        if( $matches && isset($matches[1]) ) {
            $youtube_id = $matches[1];
            $youtube_id .= '?enablejsapi=1';
        }
        if( ! empty( $youtube_id ) ) {
            $new_iframe_html = '<iframe class="wpvs-youtube-video-player" width="560" height="315" src="//www.youtube.com/embed/' . $youtube_id . '" frameborder="0" allowfullscreen="" allow="autoplay"></iframe>';
            update_post_meta($wpv_video_id, 'rvs_video_post_vimeo_html', $new_iframe_html);
        }
    }

}

function rvs_update_youtube_trailer($wpv_video_id) {
    // UPDATE TRAILER
    $rvs_trailer_youtube_url = get_post_meta($wpv_video_id, 'rvs_trailer_youtube_url', true);
    if(!empty($rvs_trailer_youtube_url)) {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $rvs_trailer_youtube_url, $matches);
        if( $matches && isset($matches[1]) ) {
            $trailer_youtube_id = $matches[1];
            $trailer_youtube_id .= '?enablejsapi=1';
        }
        if( ! empty( $trailer_youtube_id ) ) {
            $new_trailer_iframe_html = '<iframe class="wpvs-youtube-trailer-player" width="560" height="315" src="//www.youtube.com/embed/' . $trailer_youtube_id . '" frameborder="0" allowfullscreen="" allow="autoplay"></iframe>';
            update_post_meta($wpv_video_id, 'rvs_trailer_html', $new_trailer_iframe_html);
        }
    }
}

if( ! function_exists('wpvideos_legacy_version_updates_check') ) {
function wpvideos_legacy_version_updates_check() {
    if( function_exists('wpvs_check_for_membership_add_on') && wpvs_check_for_membership_add_on() ) {
        $wpvs_memberships_current_version = get_option('rvs_memberships_version');
        if( ! empty($wpvs_memberships_current_version) ) {
            $wpvs_membership_updates_version = intval(str_replace(".","",$wpvs_memberships_current_version));
            if($wpvs_membership_updates_version < 314) {
                $wpvs_membership_update_required = true;
                add_action( 'admin_notices', 'wpvs_wpvideos_update_message_314' );
                function wpvs_wpvideos_update_message_314() {
                  echo '<div class="update-nag">';
                  _e( 'IMPORTANT: WP Video Memberships needs an update. Please <a href="'.admin_url('plugins.php').'">upgrade to version 3.1.4</a>', 'vimeosync' );
                  echo '</div>';
                }
            }
            if($wpvs_membership_updates_version < 448) {
                $wpvs_membership_update_required = true;
                add_action( 'admin_notices', 'wpvs_wpvideos_update_message_448' );
                function wpvs_wpvideos_update_message_448() {
                  echo '<div class="update-nag">';
                  _e( 'IMPORTANT: WP Video Memberships needs an update. Please <a href="'.admin_url('plugins.php').'">upgrade to version 4.4.8</a>', 'vimeosync' );
                  echo '</div>';
                }
            }
        }
    }
}
add_action('admin_init', 'wpvideos_legacy_version_updates_check');
}

function wpvs_wp_videos_product_checks() {
    global $wpvs_videos_plugin_version;
    global $wpvs_theme_is_active;
    if( $wpvs_theme_is_active ) {
        $vs_netflix_current_version = get_option('wpvs_theme_current_version');
        $vs_netflix_updates_version = intval(str_replace(".","",$vs_netflix_current_version));
        if($vs_netflix_updates_version >= 500) {
            add_action( 'admin_notices', 'vs_netflix_wp_videos_update_message_500' );
            function vs_netflix_wp_videos_update_message_500() {
                $vs_netflix_admin_notice = '<div class="update-nag">';
                $vs_netflix_admin_notice .= 'IMPORTANT: Version <strong>5.0.0</strong> of the <strong>VS Netflix Theme</strong> no longer requires the WP Videos plugin.';
                $vs_netflix_admin_notice .= ' Please <a href="'.admin_url('plugins.php').'"><strong>deactivate</strong></a> the <strong>WP Videos</strong> plugin if you are using version 5.0.0 or higher of the VS Netflix Theme.';
                $vs_netflix_admin_notice .= '</div>';
                echo $vs_netflix_admin_notice;
            }
        }
    } else {
        $vs_netflix_theme_is_active = get_option('vs_netflix_active');
        $vs_netflix_current_version = get_option('vs_netflix_current_version');
        if( $vs_netflix_theme_is_active && ! empty($vs_netflix_current_version) ) {
            $vs_netflix_updates_version = intval(str_replace(".","",$vs_netflix_current_version));
            if($vs_netflix_updates_version < 500) {
                add_action( 'admin_notices', 'vs_netflix_wp_videos_update_message_500' );
                function vs_netflix_wp_videos_update_message_500() {
                    echo '<div class="update-nag">';
                    _e( 'IMPORTANT: The <strong>VS Netflix Theme</strong> requires an update. Version <strong>5.0.0</strong> of the <strong>VS Netflix Theme</strong> no longer requires the WP Videos plugin. <p><strong>We highly recommend making a backup of your database and website files before updating the VS Netflix Theme.</strong></p>', 'vimeosync' );
                    echo '</div>';
                }
            }
        }
    }
}
add_action('admin_init', 'wpvs_wp_videos_product_checks');

function wpvs_count_total_videos() {
    $count_rvs_videos = 0;
    $rvs_vimeo_video_args = array(
        'post_type' => 'rvs_video',
        'post_status' => 'any',
        'posts_per_page' => -1,
        'nopaging' => true,
        'fields' => 'ids'
    );
    $current_rvs_video_count = get_posts($rvs_vimeo_video_args);
    $count_rvs_videos = count($current_rvs_video_count);
    return $count_rvs_videos;
}

if( ! function_exists('wpvs_generate_secure_random_bytes') ) {
function wpvs_generate_secure_random_bytes($length) {
    if( function_exists('random_bytes') ) {
        return bin2hex(random_bytes(intval($length)));
    } else {
        $cry_strong = true;
        $random_bytes = openssl_random_pseudo_bytes(intval($length), $cry_strong);
        return bin2hex($random_bytes);
    }
}
}
