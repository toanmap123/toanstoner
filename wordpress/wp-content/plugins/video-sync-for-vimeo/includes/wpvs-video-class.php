<?php

class WPVS_SINGLE_VIDEO {
    public $video_id;
    public $wpvs_memberships_active;
	public function __construct($video_id) {
        $this->video_id = $video_id;
        $this->wpvs_memberships_active = wpvs_check_for_membership_add_on();
	}

    public function viewer_can_watch() {
        $viewer_can_watch = true;
        return apply_filters('wpvs_view_can_watch_filter', $viewer_can_watch, $this->video_id);
    }

    public function get_video_content() {
        if( $this->viewer_can_watch() ) {
            global $wpvs_genre_slug_settings;
            global $wpvs_actor_slug_settings;
            global $wpvs_director_slug_settings;
            $wpvs_autoplay = get_option('rvs_video_autoplay', 0);
            $wpvs_video_type = get_post_meta($this->video_id, '_rvs_video_type', true);
            if(empty($wpvs_video_type)) {
                $wpvs_video_type = "vimeo";
            }

            $tags = get_the_terms($this->video_id, 'rvs_video_tags');
            $genres = get_the_terms($this->video_id, 'rvs_video_category');

            $actor_term_args = array(
                'order' => 'ASC',
            );

            if( isset($wpvs_actor_slug_settings['ordering']) && $wpvs_actor_slug_settings['ordering'] == 'order' ) {
                $actor_term_args['meta_key'] = 'wpvs_display_order';
                $actor_term_args['orderby']  =  'meta_value_num';
            }

            $actors = wp_get_post_terms($this->video_id, 'rvs_actors', $actor_term_args);

            $director_term_args = array(
                'order' => 'ASC',
            );

            if( isset($wpvs_director_slug_settings['ordering']) && $wpvs_director_slug_settings['ordering'] == 'order' ) {
                $director_term_args['meta_key'] = 'wpvs_display_order';
                $director_term_args['orderby']  =  'meta_value_num';
            }

            $directors = wp_get_post_terms($this->video_id, 'rvs_directors', $director_term_args);

            $wpvs_video_information = get_post_meta($this->video_id, 'wpvs_video_information', true);
            $video_download_link = null;
            $members_can_download = null;
            if( $this->wpvs_memberships_active ) {
                $video_download_link = get_post_meta( $this->video_id, 'rvs_video_download_link', true );
                $members_can_download = get_post_meta( $this->video_id, 'wpvs_members_can_download', true );
                $download_link_text = get_post_meta( $this->video_id, 'wpvs_download_link_text', true );
                if( empty($download_link_text) ) {
                    $download_link_text = __('Download', 'vimeosync');
                }
            }

            $video_content = '<div class="wpvs-responsive-video">';

            if( $wpvs_video_type == "wordpress") {
                $rvs_wordpress_code = get_post_meta($this->video_id, 'rvs_video_wordpress_code', true);
            }
            if( $wpvs_video_type == "shortcode") {
                $rvs_shortcode_video = get_post_meta($this->video_id, 'rvs_shortcode_video', true);
                $rvs_shortcode_video_check = get_post_meta($this->video_id, 'rvs_shortcode_video_check', true);
            }

            if( $wpvs_video_type == "wordpress" && ! empty($rvs_wordpress_code) ) {
                $video_content .= do_shortcode($rvs_wordpress_code);
            }

            if($wpvs_video_type == "shortcode" && ! empty($rvs_shortcode_video) ) {
                if(! empty($rvs_shortcode_video_check) && shortcode_exists($rvs_shortcode_video_check)) {
                    $video_content .= do_shortcode($rvs_shortcode_video);
                } else {
                    $video_content .= __('Something is wrong with this videos Shortcode', 'vimeosync');
                }
            }

            if($wpvs_video_type == "vimeo" || $wpvs_video_type == "youtube") {
                $rvs_video_html = get_post_meta($this->video_id, 'rvs_video_post_vimeo_html', true);
                $video_content .= $rvs_video_html;
            }

            if($wpvs_video_type == "custom") {
                $video_content .= get_post_meta($this->video_id, 'rvs_video_custom_code', true);
            }

            if( $wpvs_autoplay ) {
                $wpvs_autoplay_timer = get_option('wpvs_autoplay_timer', 5);
                $seconds_label = sprintf(__('starts in <span id="wpvs-autoplay-count">%d</span> seconds', 'vimeosync'), $wpvs_autoplay_timer);
                $video_content .= '<div id="wpvs-autoplay-countdown"><label id="wpvs-cancel-next-video"><span class="dashicons dashicons-no-alt"></span></label><a href="" id="wpvs-next-video-title"></a>'.$seconds_label.'</div>';
            }
            $video_content .= '</div>';

            if( ! empty($wpvs_video_information) ) {
                if( ( isset($wpvs_video_information['hours']) && ! empty($wpvs_video_information['hours']) ) || ( isset($wpvs_video_information['minutes']) && ! empty($wpvs_video_information['minutes']) ) ) {
                    $video_content .= '<div id="wpvs-length-info-section" class="rvs-info-section"><span class="dashicons dashicons-clock"></span>';
                    if( isset($wpvs_video_information['hours']) && ! empty($wpvs_video_information['hours']) ) {
                        $video_content .= $wpvs_video_information['hours'].'h ';

                    }
                    if( isset($wpvs_video_information['minutes']) && ! empty($wpvs_video_information['minutes']) ) {
                        $video_content .= $wpvs_video_information['minutes'].'m';
                    }
                    $video_content .= '</div>';
                }

                if( isset($wpvs_video_information['date_released']) && ! empty($wpvs_video_information['date_released']) ) {
                    $video_content .= '<div id="wpvs-date-info-section" class="rvs-info-section"><span class="dashicons dashicons-calendar-alt"></span>'.$wpvs_video_information['date_released'].'</div>';
                }
            }

            if( ! empty($actors) ) {
                $video_content .= '<div id="wpvs-actor-info-section" class="rvs-info-section"><span class="dashicons dashicons-'.$wpvs_actor_slug_settings['icon'].'"></span>'.$wpvs_actor_slug_settings['name-plural'].': ';
                foreach($actors as $actor) {
                    $video_content .= '<a href="'.get_site_url().'/'.$wpvs_actor_slug_settings['slug'].'/'.$actor->slug.'">'.$actor->name.'</a>';
                    if ($actor != end($actors)) {
                        $video_content .= ', ';
                    }
                }
                $video_content .= '</div>';
            }

            if( ! empty($directors) ) {
                $video_content .= '<div id="wpvs-director-info-section" class="rvs-info-section"><span class="dashicons dashicons-'.$wpvs_director_slug_settings['icon'].'"></span>'.$wpvs_director_slug_settings['name-plural'].': ';
                foreach($directors as $director) {
                    $video_content .= '<a href="'.get_site_url().'/'.$wpvs_director_slug_settings['slug'].'/'.$director->slug.'">'.$director->name.'</a>';
                    if ($director != end($directors)) {
                        $video_content .= ', ';
                    }
                }
                $video_content .= '</div>';
            }

            if( ! empty($genres) ) {
                $video_content .= '<div id="wpvs-genre-info-section" class="rvs-info-section"><span class="dashicons dashicons-'.$wpvs_genre_slug_settings['icon'].'"></span>'.$wpvs_genre_slug_settings['name-plural'].': ';
                foreach($genres as $genre) {
                    $video_content .= '<a href="'.get_site_url().'/'.$wpvs_genre_slug_settings['slug'].'/'.$genre->slug.'">'.$genre->name.'</a>';
                    if ($genre != end($genres)) {
                        $video_content .= ', ';
                    }
                }
                $video_content .= '</div>';
            }


            if( ! empty($tags) ) {
                $video_content .= '<div id="wpvs-tag-info-section" class="rvs-info-section"><span class="dashicons dashicons-tag"></span>';
                foreach($tags as $tag) {
                    $video_content .= '<a href="'.get_site_url().'/video-tag/'.$tag->slug.'">'.$tag->name.'</a>';
                    if ($tag != end($tags)) {
                        $video_content .= ', ';
                    }
                }
                $video_content .= '</div>';
            }

            if( $members_can_download && ! empty($video_download_link) ) {
                $video_content .= '<div id="wpvs-download-info-section" class="rvs-info-section"><span class="dashicons dashicons-download"></span>';
                $video_content .= '<a href="'.$video_download_link.'" download>'.$download_link_text.'</a>';
                $video_content .= '</div>';
            }
        } else {
            $wpvs_restricted_content_message = apply_filters('wpvs_restricted_content_message', __('Sorry, this content is restricted', 'vimeosync'), $this->video_id);
            $video_content = '<div class="wpvs-restricted-content">';
            $video_content .= $wpvs_restricted_content_message;
            $video_content .= '</div>';
        }

        return $video_content;
    }

    public function get_video_player() {
        if( $this->viewer_can_watch() ) {
            $wpvs_video_type = get_post_meta($this->video_id, '_rvs_video_type', true);
            if(empty($wpvs_video_type)) {
                $wpvs_video_type = "vimeo";
            }

            $video_content = '<div class="wpvs-responsive-video">';

            if( $wpvs_video_type == "wordpress") {
                $rvs_wordpress_code = get_post_meta($this->video_id, 'rvs_video_wordpress_code', true);
            }
            if( $wpvs_video_type == "shortcode") {
                $rvs_shortcode_video = get_post_meta($this->video_id, 'rvs_shortcode_video', true);
                $rvs_shortcode_video_check = get_post_meta($this->video_id, 'rvs_shortcode_video_check', true);
            }

            if( $wpvs_video_type == "wordpress" && ! empty($rvs_wordpress_code) ) {
                $video_content .= do_shortcode($rvs_wordpress_code);
            }

            if($wpvs_video_type == "shortcode" && ! empty($rvs_shortcode_video) ) {
                if(! empty($rvs_shortcode_video_check) && shortcode_exists($rvs_shortcode_video_check)) {
                    $video_content .= do_shortcode($rvs_shortcode_video);
                } else {
                    $video_content .= __('Something is wrong with this videos Shortcode', 'vimeosync');
                }
            }

            if($wpvs_video_type == "vimeo" || $wpvs_video_type == "youtube") {
                $rvs_video_html = get_post_meta($this->video_id, 'rvs_video_post_vimeo_html', true);
                $video_content .= $rvs_video_html;
            }

            if($wpvs_video_type == "custom") {
                $video_content .= get_post_meta($this->video_id, 'rvs_video_custom_code', true);
            }
            $video_content .= '</div>';

        } else {
            $wpvs_restricted_content_message = apply_filters('wpvs_restricted_content_message', __('Sorry, this content is restricted', 'vimeosync'), $this->video_id);
            $video_content = '<div class="wpvs-restricted-content">';
            $video_content .= $wpvs_restricted_content_message;
            $video_content .= '</div>';
        }
        return $video_content;
    }

    public function get_video_thumbnail_image_url() {
        if( has_post_thumbnail($this->video_id) ) {
            $image_id = get_post_thumbnail_id($this->video_id);
            $thumbnail_image = wp_get_attachment_image_src($image_id, 'rvs-video-size', true)[0];
        } else {
            $thumbnail_image = get_post_meta($this->video_id, 'rvs_thumbnail_image', true);
            if( empty($thumbnail_image) ) {
                $rvs_thumbnails = get_post_meta($this->video_id, '_rvs_video_thumbnails', true);
                if(isset($rvs_thumbnails[3])) {
                    $thumbnail_image = $rvs_thumbnails[3];
                }
                if( empty($thumbnail_image) && isset($rvs_thumbnails[2]) ) {
                    $thumbnail_image = $rvs_thumbnails[2];
                }
                if(empty($thumbnail_image)) {
                    $thumbnail_image = WPVS_VIDEOS_PLUGIN_URL . 'image/missing-image.png';
                }
            }
        }
        return esc_url($thumbnail_image);
    }
}

class WPVS_VIDEO_LIST_FILTER {
    public $video_args;
    public function __construct() {
    }

    public function set_default_video_args($video_args) {
        if( is_array($video_args) ) {
            $this->video_args = $video_args;
        }
    }

    public function apply_video_ordering_filters() {
        if( is_array($this->video_args) ) {
            $rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
            $rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
            if( $rvs_video_order_settings == 'random' ) {
                $this->video_args['orderby'] = 'rand';
                $this->video_args['order'] = 'ASC';
            }
            if($rvs_video_order_settings == 'videoorder') {
                $this->video_args['meta_key'] = 'rvs_video_post_order';
                $this->video_args['orderby'] = 'meta_value_num';
                $this->video_args['order'] = $rvs_video_order_direction;
            }
            if( $rvs_video_order_settings == 'alpha' ) {
                $this->video_args['orderby'] = 'title';
                $this->video_args['order'] = $rvs_video_order_direction;
            }
        }
    }

    public function create_video_list_html($wpvs_videos) {
        $wpvs_block_content = '<div class="wpvs-videos-list">';
        if( ! empty($wpvs_videos) ) {
			foreach($wpvs_videos as $video_item) {
				$video_link = get_the_permalink($video_item->ID);
				$video_title = get_the_title($video_item->ID);
				$wpvs_single_video = new WPVS_SINGLE_VIDEO($video_item->ID);
				$wpvs_block_content .= '<div class="wpvs-video-item border-box">';
				$wpvs_block_content .= '<a href="'.$video_link.'" class="wpvs-thumbnail">';
				$wpvs_block_content .= '<img src="'.$wpvs_single_video->get_video_thumbnail_image_url().'" alt="'.$video_title.'"/>';
				$wpvs_block_content .= '</a><a href="'.$video_link.'"><div class="wpvs-video-item-details"><h4 class="wpvs-video-item-title">'.$video_title.'</h4>
				</div></a></div>';
			}
		}
        $wpvs_block_content .= '</div>';
        return $wpvs_block_content;
    }

    public function get_videos() {
        return get_posts($this->video_args);
    }
}
