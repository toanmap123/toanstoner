var wpvs_vimeo_player = null;
var wpvs_vimeo_trailer_player = null;
jQuery(document).ready(function() {
    if( jQuery('.wpvs-vimeo-video-player').length > 0 ) {
        var wpvs_video_iframe = jQuery('.wpvs-vimeo-video-player');
        if(typeof(wpvs_video_iframe) !== "undefined") {
            var video_src = wpvs_video_iframe.attr('src').indexOf('vimeo');
            if(video_src > -1) {
                wpvs_vimeo_player = new Vimeo.Player(wpvs_video_iframe);
                wpvs_vimeo_player.on('ended', function() {
                    wpvs_load_next_video();
                });
            }
        }
    }
    
    if( jQuery('.wpvs-vimeo-trailer-player').length > 0 ) {
        var wpvs_trailer_iframe = jQuery('.wpvs-vimeo-trailer-player');
        if(typeof(wpvs_trailer_iframe) !== "undefined") {
            var video_src = wpvs_trailer_iframe.attr('src').indexOf('vimeo');
            if(video_src > -1) {
                wpvs_vimeo_trailer_player = new Vimeo.Player(wpvs_trailer_iframe);
            }
        }
    }
});