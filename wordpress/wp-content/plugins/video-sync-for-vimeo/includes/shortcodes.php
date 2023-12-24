<?php

class WPVS_VIDEOS_SHORTCODE_MANAGER {

    public function __construct() {
        add_shortcode('wpvs_video_list', array($this, 'wpvs_plugin_video_list_shortcode'));
        add_shortcode('wpvs_single_video', array($this, 'wpvs_plugin_single_video_shortcode'));
    }

    public function wpvs_plugin_video_list_shortcode( $atts ) {
        wp_enqueue_style('wpvs-videos-list');

        $attributes = shortcode_atts( array(
            'videos_per_page' => 12,
            'categories' => array(),
            'actors' => array(),
            'directors' => array(),
            'tags' => array(),
        ), $atts );

		$wpvs_video_args = array(
	        'post_type' => 'rvs_video',
			'tax_query' => array(),
	    );

		if( isset($attributes['videos_per_page']) && ! empty($attributes['videos_per_page'])) {
			$wpvs_video_args['posts_per_page'] = intval($attributes['videos_per_page']);
	    }

	    if( isset($attributes['categories']) && ! empty($attributes['categories'])) {
			$wpvs_categories = explode(',', $attributes['categories']);
			$wpvs_video_args['tax_query'][] = array(
				'taxonomy' => 'rvs_video_category',
				'field' => 'term_id',
				'terms' => $wpvs_categories
			);
	    }

		if( isset($attributes['actors']) && ! empty($attributes['actors'])) {
			$wpvs_actors = explode(',', $attributes['actors']);
			$wpvs_video_args['tax_query'][] = array(
				'taxonomy' => 'rvs_actors',
				'field' => 'term_id',
				'terms' => $wpvs_actors
			);
	    }

		if( isset($attributes['directors']) && ! empty($attributes['directors'])) {
			$wpvs_directors = explode(',', $attributes['directors']);
			$wpvs_video_args['tax_query'][] = array(
				'taxonomy' => 'rvs_directors',
				'field' => 'term_id',
				'terms' => $wpvs_directors
			);
	    }

		if( isset($attributes['tags']) && ! empty($attributes['tags'])) {
			$wpvs_tags = explode(',', $attributes['tags']);
			$wpvs_video_args['tax_query'][] = array(
				'taxonomy' => 'rvs_video_tags',
				'field' => 'term_id',
				'terms' => $wpvs_tags
			);
	    }

		$wpvs_video_list_filter = new WPVS_VIDEO_LIST_FILTER();
		$wpvs_video_list_filter->set_default_video_args($wpvs_video_args);
		$wpvs_video_list_filter->apply_video_ordering_filters();
		$wpvs_videos = $wpvs_video_list_filter->get_videos();
		$wpvs_block_content = $wpvs_video_list_filter->create_video_list_html($wpvs_videos);
		return $wpvs_block_content;
    }

    public function wpvs_plugin_single_video_shortcode( $atts ) {
        global $wpvs_plugin_text_domain;
        $attributes = shortcode_atts( array(
            'video_id' => null,
        ), $atts );
	    if( isset($attributes['video_id']) && ! empty($attributes['video_id'])) {
			$wpvs_single_video = new WPVS_SINGLE_VIDEO(intval($attributes['video_id']));
			return $wpvs_single_video->get_video_content();
	    } else {
	        return '<div class="wpvs-single-video-error">'.__('Please provide a Video ID.', $wpvs_plugin_text_domain).'</div>';
	    }
	}

}
$wpvs_videos_shortcode_manager = new WPVS_VIDEOS_SHORTCODE_MANAGER();
