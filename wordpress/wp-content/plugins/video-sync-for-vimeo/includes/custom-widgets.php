<?php

class WP_Videos_List_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'wp_videos_list_widget', // Base ID
			__( 'Recent Videos', 'vimeosync' ), // Name
			array( 'description' => __( 'Lists recently added videos.', 'vimeosync' ) ) // Args
		);
	}
	public function widget( $args, $instance ) {
        global $post;
        global $wpvs_video_slug_settings;
		global $wpvs_theme_is_active;
        $rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
        $rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
        $wpvs_widget_style = "default";
        $number_of_videos = $instance['number_of_posts'];
        $wpvs_collect_videos = array();
        $wpvs_thumbnail_layout = get_option('thumbnail-layout', 'landscape');
        $wpvs_recent_videos_widget_ouput = $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
			$wpvs_recent_videos_widget_ouput .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
        if ( ! empty( $instance['wpvs_widget_style'] ) ) {
			$wpvs_widget_style = $instance['wpvs_widget_style'];
		}

        $wpvs_get_args = array(
            'post_type' => 'rvs_video',
            'posts_per_page' => $number_of_videos
        );

        if( $post && isset($post->ID) ) {
            $wpvs_get_args['post__not_in'] = array($post->ID);
        }

        if( $rvs_video_order_settings == 'random' ) {
            $wpvs_get_args['orderby'] = 'rand';
            $wpvs_get_args['order'] = 'ASC';
        }
        if($rvs_video_order_settings == 'videoorder') {
            $wpvs_get_args['meta_key'] = 'rvs_video_post_order';
            $wpvs_get_args['orderby'] = 'meta_value_num';
            $wpvs_get_args['order'] = $rvs_video_order_direction;
        }

        if( $rvs_video_order_settings == 'alpha' ) {
            $wpvs_get_args['orderby'] = 'title';
            $wpvs_get_args['order'] = $rvs_video_order_direction;
        }

        if(is_singular('rvs_video')) {
            $post_categories = wp_get_post_terms( $post->ID, 'rvs_video_category', array( 'fields' => 'all', 'orderby' => 'term_id' ));
            if( ! empty($post_categories) ) {
                $parent_cat_position = (count($post_categories) - 1);
                $wpvs_category = $post_categories[$parent_cat_position];
                $wpvs_category_id = $wpvs_category->term_id;
                $video_category_title = $wpvs_category->name;
                $wpvs_get_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'rvs_video_category',
                        'field' => 'term_id',
                        'terms' => $wpvs_category_id
                    ),
                );

                $wpvs_term_videos = get_posts($wpvs_get_args);
                if( ! empty($wpvs_term_videos) ) {
                    foreach($wpvs_term_videos as $term_video) {
                        $video_id = $term_video->ID;
						$wpvs_single_video = new WPVS_SINGLE_VIDEO($video_id);
                        $video_thumbnail = $wpvs_single_video->get_video_thumbnail_image_url();
                        $wpvs_collect_videos[] = array(
                            'video_id' => $video_id,
                            'video_title' => $term_video->post_title,
                            'video_link' => get_permalink($video_id),
                            'video_term_title' => $video_category_title,
                            'video_thumbnail' => $video_thumbnail,
                        );
                        $widget_videos[] = $video_id;
                    }
                }
            }
        }

        if(  count($wpvs_collect_videos) < $number_of_videos ) {
            if( isset($wpvs_get_args['tax_query']) ) {
                unset($wpvs_get_args['tax_query']);
            }
            $wpvs_get_args['posts_per_page'] = $number_of_videos - count($wpvs_collect_videos);
            $wpvs_more_videos = get_posts($wpvs_get_args);
            if( ! empty($wpvs_more_videos) ) {
                foreach($wpvs_more_videos as $wpvs_video) {
                    $video_id = $wpvs_video->ID;
					$wpvs_single_video = new WPVS_SINGLE_VIDEO($video_id);
                    $video_category_title = "";
                    $video_thumbnail = $wpvs_single_video->get_video_thumbnail_image_url();
                    $video_categories = wp_get_post_terms( $video_id, 'rvs_video_category', array( 'fields' => 'names'));
                    if( ! empty($video_categories) ) {
                        $video_category_title = $video_categories[0];
                    }
                    $wpvs_collect_videos[] = array(
                        'video_id' => $video_id,
                        'video_title' => $wpvs_video->post_title,
                        'video_link' => get_permalink($video_id),
                        'video_term_title' => $video_category_title,
                        'video_thumbnail' => $video_thumbnail,
                    );
                    $widget_videos[] = $video_id;
                }
            }
        }

        if( ! empty($wpvs_collect_videos) ) {
            $wpvs_recent_videos_widget_ouput .= '<ul class="recent-videos-side '.$wpvs_widget_style.'">';
            foreach($wpvs_collect_videos as $video) {
                $wpvs_recent_videos_widget_ouput .= '<li><a class="wpvs-recent-video-widget-item" href="'.$video['video_link'].'"><div class="wpvs-recent-video-widget-item-image"><img src="'. $video['video_thumbnail'].'" alt="'.$video['video_title'].'" /></div><div class="wpvs-recent-video-widget-item-info"><h3 class="wpvs-recent-video-widget-item-title">'. $video['video_title'].'</h3><label class="wpvs-recent-video-widet-item-term">'. $video['video_term_title'].'</label></div></a></li>';
            }
           $wpvs_recent_videos_widget_ouput .= '</ul>';
        }
        if(isset($args['after_widget'])) {
            $wpvs_recent_videos_widget_ouput .= $args['after_widget'];
        }
        echo $wpvs_recent_videos_widget_ouput;
	}
	public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Recently Added', 'vimeosync' );
        $number_of_posts = ! empty( $instance['number_of_posts'] ) ? $instance['number_of_posts'] : __( '5', 'vimeosync' );
        $widget_style = ! empty( $instance['wpvs_widget_style'] ) ? $instance['wpvs_widget_style'] : __( 'default', 'vimeosync' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'vimeosync' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
		<label for="<?php echo $this->get_field_id( 'number_of_posts' ); ?>"><?php _e( 'Number of posts', 'vimeosync' ); ?>:</label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_of_posts' ); ?>" type="number" min="1" value="<?php echo esc_attr( $number_of_posts ); ?>">
		</p>
        <p>
		<label for="<?php echo $this->get_field_id( 'wpvs_widget_style' ); ?>"><?php _e( 'Widget Style', 'vimeosync' ); ?>:</label>
		<select id="<?php echo $this->get_field_id( 'wpvs_widget_style' ); ?>" name="<?php echo $this->get_field_name( 'wpvs_widget_style' ); ?>">
            <option value="default" <?php selected('default', $widget_style); ?>><?php _e('Default', 'vimeosync'); ?></option>
            <option value="youtube" <?php selected('youtube', $widget_style); ?>><?php _e('YouTube', 'vimeosync'); ?></option>
        </select>
		</p>

        <p><?php _e('Lists recently added videos', 'vimeosync'); ?>.</p>
        <?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['number_of_posts'] = ( ! empty( $new_instance['number_of_posts'] ) ) ? strip_tags( $new_instance['number_of_posts'] ) : '';
        $instance['wpvs_widget_style'] = ( ! empty( $new_instance['wpvs_widget_style'] ) ) ? strip_tags( $new_instance['wpvs_widget_style'] ) : '';
		return $instance;
	}
}

class WP_Videos_Category_List_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'wp_videos_category_list_widget', // Base ID
			__( 'Video Categories', 'vimeosync' ), // Name
			array( 'description' => __( 'Lists created Video Categories.', 'vimeosync' ), ) // Args
		);
	}
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
        $args = array(
            'hide_empty' => 0,
            'parent'      => 0,
            'meta_key' => 'video_cat_order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        );
        $video_categories = get_terms('rvs_video_category', $args);
        if($video_categories) {
            echo '<ul>';
            foreach($video_categories as $vid_cat) {
                echo '<li><a href="'. home_url('videos') . '/' . $vid_cat->slug .'">'.$vid_cat->name.'</a></li>';
            }
            echo '</ul>';
        }
		if(isset($args['after_widget'])) {
		  echo $args['after_widget'];
        }
	}
	public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Video Categories', 'vimeosync' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'vimeosync' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p><?php _e('Lists created Video Categories.', 'vimeosync'); ?></p>
        <?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}


function register_rvs_custom_widgets() {
    register_widget( 'WP_Videos_List_Widget' );
    register_widget( 'WP_Videos_Category_List_Widget' );
}
add_action( 'widgets_init', 'register_rvs_custom_widgets' );
