var wpvs_youtube_player = null;
var wpvs_youtube_trailer_player = null;
if (typeof(YT) == 'undefined' || typeof(YT.Player) == 'undefined') { 
  jQuery.getScript('//www.youtube.com/iframe_api');
}
function onYouTubeIframeAPIReady() {
    var wpvs_youtube_iframe;
    var wpvs_youtube_trailer_iframe;
    if(jQuery('.wpvs-youtube-video-player').length > 0) {
        wpvs_youtube_iframe = jQuery('.wpvs-youtube-video-player');
    }
    
    if(typeof(wpvs_youtube_iframe) !== "undefined") {
        wpvs_youtube_iframe.attr('id', 'wpvs-youtube-video');
        wpvs_youtube_player = new YT.Player('wpvs-youtube-video', {
            events: {
				'onReady': onPlayerReady,
				'onStateChange': onPlayerStateChange
			}
        });
        jQuery( document ).trigger( "wpvsYouTubePlayerReady" );
    }
    
    if(jQuery('.wpvs-youtube-trailer-player').length > 0) {
        wpvs_youtube_trailer_iframe = jQuery('.wpvs-youtube-trailer-player');
    }
    
    if(typeof(wpvs_youtube_trailer_iframe) !== "undefined") {
        wpvs_youtube_trailer_iframe.attr('id', 'wpvs-youtube-trailer-video');
        wpvs_youtube_trailer_player = new YT.Player('wpvs-youtube-trailer-video');
        jQuery( document ).trigger( "wpvsYouTubeTrailerPlayerReady" );
    }
}
function onPlayerReady(event) {}
function onPlayerError(event) {}
function onPlayerStateChange(event) {
    if(wpvsyoutubeplayer.autoplay && event.data == 0 && typeof wpvs_load_next_video == 'function') {
        wpvs_load_next_video();
    }
}

jQuery( document ).on( "wpvsYouTubePlayerReady", function() {});

jQuery( document ).on( "wpvsYouTubeTrailerPlayerReady", function() {});