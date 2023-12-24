(function($) {
	var $wp_inline_edit = inlineEditPost.edit;
	inlineEditPost.edit = function( id ) {
		$wp_inline_edit.apply( this, arguments );
		var $post_id = 0;
		if ( typeof( id ) == 'object' ) {
			$post_id = parseInt( this.getId( id ) );
		}

		if ( $post_id > 0 ) {
			var $edit_row = $( '#edit-' + $post_id );
			var $post_row = $( '#post-' + $post_id );
			var $video_order = $( '.column-rvs_video_post_order', $post_row ).text();
			$(':input[name="rvs_video_post_order"]', $edit_row ).val( $video_order );

			//var $episode_video_order = $( '.column-wpvs_video_episode_order', $post_row ).text();
			//$(':input[name="wpvs_video_episode_order"]', $edit_row ).val( $episode_video_order );
		}
	};
})(jQuery);
