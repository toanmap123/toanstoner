var video_uploader = null;
jQuery(document).ready(function() {
    jQuery('#choose-wordpress-video').click( function( event ) {
        wpvs_upload_wordpress_video();
    });
});
function wpvs_upload_wordpress_video() {
    video_uploader = wp.media({
        frame:    'select',
        library: {
            type: ['video']
        },
        button: {
            text: 'Select video'
        },
        multiple:  false
    });
    video_uploader.on( 'select', function() {
        var video_details = video_uploader.state().get('selection').first().toJSON();
        var video_type = video_details.subtype;
        if(video_type == "quicktime") {
            alert('Please try another video type.');
            video_uploader.open();
        } else {
            var video_id = video_details.id;
            var video_width = video_details.width;
            var video_height = video_details.height;
            var video_src = video_details.url;
            var video_shortcode = '[video width="'+video_width+'" height="'+video_height+'" '+video_type+'="'+video_src+'"][/video]';
            jQuery('#rvs-wordpress-id').val(video_id);
            jQuery('#rvs-wordpress-code').html(video_shortcode);
            wpvs_create_video_html('main', video_src, video_width, video_height, video_type);
        }
    });
    video_uploader.open();
}

function wpvs_create_video_html(videoarea, src, width, height, type) {
    jQuery.ajax({
        url: wpvsajax.url,
        type: "POST",
        data: {
            'action': 'wpvs_create_video_html_request',
            'videosrc': src,
            'videowidth': width,
            'videoheight': height,
            'videotype': type
        },
        success:function(response) {
            if(videoarea == "main") {
                jQuery('#currentRVSVideo').html(response);
            }
            if(videoarea == "trailer") {
                jQuery('#rvs-trailer-video-holder').html(response);
            }
            
        },
        error: function(response){
            
        }
    });
}