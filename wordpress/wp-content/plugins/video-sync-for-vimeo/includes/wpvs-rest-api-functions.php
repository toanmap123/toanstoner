<?php
function wpvs_rest_api_video_meta_fields() {
    register_rest_field( 'rvs_video', 'video_type', array(
        'get_callback' => function( $video_object ) {
            $video_type = get_post_meta($video_object['id'], '_rvs_video_type', true);
            if( empty($video_type)) {
                $video_type = "";
            }
            return (string) $video_type;
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __( 'Video type.' ),
            'type'        => 'string'
        ),
    ) );
    register_rest_field( 'rvs_video', 'images', array(
        'get_callback' => function( $video_object ) {
            $video_id = $video_object['id'];
            $thumbnail_image = get_post_meta($video_id, 'rvs_thumbnail_image', true);
            if(has_post_thumbnail($video_id)) {
                $featured_id = get_post_thumbnail_id($video_id);
                $featured_image = wp_get_attachment_image_src($featured_id, 'rvs-video-size', true)[0];
                if(empty($featured_image)) {
                    $featured_image = wp_get_attachment_image_src($featured_id, 'full', true)[0];
                }
            }
            if(empty($featured_image)) {
                $featured_image = get_post_meta($video_id, 'wpvs_featured_image', true);
            }
            $vimeo_thumbnails = array('thumbnail' => null, 'featured' => null);
            if( ! empty($thumbnail_image) ) {
                $vimeo_thumbnails['thumbnail'] = $thumbnail_image;
            }
            if( ! empty($featured_image) ) {
                $vimeo_thumbnails['featured'] = $featured_image;
            }
            return (array) array($vimeo_thumbnails);
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __( 'Video Images.' ),
            'type'        => 'array'
        ),
    ) );
    register_rest_field( 'rvs_video', 'vimeo', array(
        'get_callback' => function( $video_object ) {
            $video_id = $video_object['id'];
            $vimeo_id = get_post_meta($video_id, 'rvs_video_post_vimeo_id', true);
            $vimeo_video_url = get_post_meta($video_id, 'wpvs_vimeo_video_url', true);
            if( empty($vimeo_id)) {
                $vimeo_id = "";
            }
            if( empty($vimeo_video_url)) {
                $vimeo_video_url = "";
            }
            return (array) array('id' => $vimeo_id, 'url' => $vimeo_video_url);
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __( 'Vimeo details.' ),
            'type'        => 'array'
        ),
    ) );
    register_rest_field( 'rvs_video', 'youtube', array(
        'get_callback' => function( $video_object ) {
            $video_id = $video_object['id'];
            $youtube_url = get_post_meta($video_id, 'rvs_youtube_url', true);
            if( empty($youtube_url)) {
                $youtube_url = "";
            }
            return (array) array('url' => $youtube_url);
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __( 'YouTube details.' ),
            'type'        => 'array'
        ),
    ) );

    register_rest_field( 'rvs_video', 'video_details', array(
        'get_callback' => function( $video_object ) {
            $video_id = $video_object['id'];
            $wpvs_video_information = get_post_meta($video_id, 'wpvs_video_information', true);
            $wpvs_video_length = get_post_meta($video_id, 'wpvs_video_length', true);

            if( empty($wpvs_video_length) ) {
                $wpvs_video_length = 0;
            }

            $wpvs_video_hours = intval(gmdate("H", $wpvs_video_length));
            $wpvs_video_minutes = intval(gmdate("i", $wpvs_video_length));

            if( empty($wpvs_video_information) ) {
                $wpvs_video_information = array(
                    'length' => $wpvs_video_length,
                    'hours' => $wpvs_video_hours,
                    'minutes' => $wpvs_video_minutes,
                    'date_released' => ""
                );
            } else {
                if( ! isset($wpvs_video_information['length']) ) {
                    $wpvs_video_information['length'] = $wpvs_video_length;
                }
                if( ! isset($wpvs_video_information['hours']) ) {
                    $wpvs_video_information['hours'] = $wpvs_video_hours;
                }
                if( ! isset($wpvs_video_information['minutes']) ) {
                    $wpvs_video_information['minutes'] = $wpvs_video_minutes;
                }
                if( ! isset($wpvs_video_information['date_released']) ) {
                    $wpvs_video_information['date_released'] = "";
                }
            }
            return (array) array($wpvs_video_information);
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __( 'Video Details' ),
            'type'        => 'array'
        )
    ) );

    register_rest_field( 'rvs_video', 'actors', array(
        'get_callback' => function( $video_object ) {
            $video_id = $video_object['id'];
            $wpvs_video_actor_ids = wp_get_post_terms($video_id, 'rvs_actors', true);
            $wpvs_video_actors = array();
            if( ! empty($wpvs_video_actor_ids) ) {
                foreach($wpvs_video_actor_ids as $actor) {
                    $wpvs_video_actors[] = array(
                        'name' => $actor->name,
                        'slug' => $actor->slug
                    );
                }
            }
            return (array) array($wpvs_video_actors);
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __( 'Video Actor Names' ),
            'type'        => 'array'
        )
    ) );

    register_rest_field( 'rvs_video', 'directors', array(
        'get_callback' => function( $video_object ) {
            $video_id = $video_object['id'];
            $wpvs_video_director_ids = wp_get_post_terms($video_id, 'rvs_directors', true);
            $wpvs_video_directors = array();
            if( ! empty($wpvs_video_director_ids) ) {
                foreach($wpvs_video_director_ids as $director) {
                    $wpvs_video_directors[] = array(
                        'name' => $director->name,
                        'slug' => $director->slug
                    );
                }
            }
            return (array) array($wpvs_video_directors);
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __( 'Video Director Names' ),
            'type'        => 'array'
        )
    ) );

    if( ! wpvs_check_for_membership_add_on() ) {
        register_rest_field( 'rvs_video', 'video_html', array(
            'get_callback' => function( $video_object ) {
                $video_id = $video_object['id'];
                $video_type = get_post_meta($video_id, '_rvs_video_type', true);
                if($video_type == "vimeo" || $video_type == "youtube") {
                    $video_html = get_post_meta($video_id, 'rvs_video_post_vimeo_html', true);
                }
                if($video_type == "custom") {
                    $video_html = get_post_meta($video_id, 'rvs_video_custom_code', true);
                }
                if( empty($video_html) ) {
                    $video_html = "";
                }
                return (string) $video_html;
            },
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'Video HTML code.' ),
                'type'        => 'string'
            )
        ) );
    }

    register_rest_field( 'rvs_video_category', 'meta', array(
        'get_callback' => function( $term_object ) {
            $term_meta = get_term_meta($term_object['id']);
            if( empty($term_meta)) {
                $term_meta = "";
            }
            if( isset($term_meta['wpvs_category_memberships']) && ! empty($term_meta['wpvs_category_memberships']) ) {
                $display_term_memberships = array();
                foreach($term_meta['wpvs_category_memberships'] as $membership) {
                    $display_term_memberships[] = unserialize($membership);
                }
                $term_meta['wpvs_category_memberships'] = $display_term_memberships;
            }
            return (array) $term_meta;
        },
        'update_callback' => null,
        'schema' => array(
            'description' => __( 'Term meta.' ),
            'type'        => 'array'
        ),
    ) );
}

add_action( 'rest_api_init', 'wpvs_rest_api_video_meta_fields' );
