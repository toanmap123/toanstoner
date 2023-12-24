<?php

class WPVS_VIDEOS_BLOCKS_MANAGER {
	protected $assets_path;
	public function __construct() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}
		$this->assets_path = plugin_dir_url(__FILE__);
		add_action( 'init', array($this, 'create_wpvs_video_block') );
		add_action( 'init', array($this, 'create_wpvs_video_listings_block') );
		add_filter( 'render_block', array($this, 'wpvs_video_block_filter'), 10, 2 );
	}

	public function create_wpvs_video_block() {
		global $wpvs_videos_plugin_version;

		wp_register_script('wpvs-video-block-js', $this->assets_path .'/block.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore' ), $wpvs_videos_plugin_version);

	  	wp_localize_script( 'wpvs-video-block-js', 'wpvsvideoblock',
	      	array(
				'video_list' => $this->create_editor_video_list(),
			)
		);

		wp_register_style(
			'wpvs-video-editor-css',
			$this->assets_path .'/editor.css',
			array( 'wp-edit-blocks' ),
			$wpvs_videos_plugin_version
		);

		wp_register_style(
			'wpvs-video-block-css',
			$this->assets_path .'style.css',
			array(),
			$wpvs_videos_plugin_version
		);

		register_block_type( 'wpvs-blocks/video-block', array(
			'style' => 'wpvs-video-block-css',
			'editor_style' => 'wpvs-video-editor-css',
			'editor_script' => 'wpvs-video-block-js',
	        'attributes'      => array(
	            'video_id'    => array(
	                'type'      => 'number',
	                'default'   => 0,
	            ),
	        ),
			'render_callback' => array($this, 'wpvs_plugin_generate_video_html_code')
		) );
	}

	public function create_wpvs_video_listings_block() {
		global $wpvs_videos_plugin_version;

		wp_register_script('wpvs-video-list-block-js', $this->assets_path .'/listblock.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore' ), $wpvs_videos_plugin_version);

	  	wp_localize_script( 'wpvs-video-list-block-js', 'wpvsvideolistblock',
	      	array(
				'categories' => $this->get_wpvs_taxonomy('rvs_video_category'),
				'actors' => $this->get_wpvs_taxonomy('rvs_actors'),
				'directors' => $this->get_wpvs_taxonomy('rvs_directors'),
				'tags' => $this->get_wpvs_taxonomy('rvs_video_tags'),
			)
		);

		wp_register_style(
			'wpvs-video-list-editor-css',
			$this->assets_path .'/listeditor.css',
			array( 'wp-edit-blocks' ),
			$wpvs_videos_plugin_version
		);

		wp_register_style(
			'wpvs-video-list-block-css',
			$this->assets_path .'liststyle.css',
			array(),
			$wpvs_videos_plugin_version
		);

		register_block_type( 'wpvs-blocks/video-list-block', array(
			'style' => 'wpvs-video-list-block-css',
			'editor_style' => 'wpvs-video-list-editor-css',
			'editor_script' => 'wpvs-video-list-block-js',
	        'attributes'      => array(
				'videos_per_page'    => array(
	                'type'      => 'number',
	                'default'   => 12,
	            ),
	            'categories'    => array(
	                'type'      => 'string',
	                'default'   => '',
	            ),
				'actors'    => array(
					'type'      => 'string',
	                'default'   => '',
	            ),
				'directors'    => array(
					'type'      => 'string',
	                'default'   => '',
	            ),
				'tags'    => array(
					'type'      => 'string',
	                'default'   => '',
	            ),
	        ),
			'render_callback' => array($this, 'wpvs_generate_video_list')
		) );
	}

	public function wpvs_video_block_filter( $block_content, $block ) {
		global $wpvs_plugin_text_domain;

		if ( $block['blockName'] === 'wpvs-blocks/video-block' ) {
			$wpvs_restricted_content = $block_content;
			$video_id = null;
			if( isset($block['attrs']['video_id']) && ! empty($block['attrs']['video_id']) ) {
				$video_id = intval($block['attrs']['video_id']);
			}

			if( ! empty($video_id) ) {
				$wpvs_single_video = new WPVS_SINGLE_VIDEO($video_id);
				return $wpvs_single_video->get_video_content();

			}
			return wp_kses_post($wpvs_restricted_content);
    	} else {
			return $block_content;
		}
	}

	public function wpvs_plugin_generate_video_html_code( $attributes ) {
		global $wpvs_plugin_text_domain;
	    if( isset($attributes['video_id']) && ! empty($attributes['video_id'])) {
			$wpvs_single_video = new WPVS_SINGLE_VIDEO(intval($attributes['video_id']));
			return $wpvs_single_video->get_video_content();
	    } else {
	        return '<div class="wpvs-single-video-error">'.__('Please select a video from the right side menu.', $wpvs_plugin_text_domain).'</div>';
	    }
	}

	public function wpvs_generate_video_list( $attributes ) {
		global $wpvs_plugin_text_domain;

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

	protected function create_editor_video_list() {
		$video_list = array(array(
			'video_id' => 0,
			'video_name' => 'None'
		));
		$wpvs_video_args = array(
			'post_type' => 'rvs_video',
			'posts_per_page' => -1,
			'post_status' => 'publish'
		);
		$wpvs_videos = get_posts($wpvs_video_args);
		if( ! empty($wpvs_videos) ) {
			foreach($wpvs_videos as $video) {
				$video_list[] = array(
					'video_id' => $video->ID,
					'video_name' => $video->post_title
				);
			}
		}
		return $video_list;
	}

	protected function get_wpvs_taxonomy($taxonomy) {
		return get_terms( array(
			'taxonomy' => $taxonomy,
			'fields' => 'id=>name',
		));
	}
}
$wpvs_videos_blocks_manager = new WPVS_VIDEOS_BLOCKS_MANAGER();
