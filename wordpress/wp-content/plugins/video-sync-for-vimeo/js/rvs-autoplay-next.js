var wpvs_load_video_count_down = wpvideosinfo.timer;
var wpvs_count_down_interval;
jQuery(document).ready(function() {
    if(typeof(wpvideosinfo) !== "undefined") {
        var wp_video_iframe;
        if( wpvideosinfo.videotype == "wordpress" && jQuery('#wpvs-autoplay-countdown').length > 0 ) {
            if(jQuery('.videoWrapper').length > 0) {
                wp_video_iframe = jQuery('.videoWrapper video').first();
            } else if(jQuery('.wpvs-responsive-video').length > 0) {
                wp_video_iframe = jQuery('.wpvs-responsive-video video').first();
            }
            
            if(typeof(wp_video_iframe) !== "undefined") {
                wp_video_iframe.on('ended', wpvs_load_next_video);
            }
        }
    }
    jQuery('#wpvs-cancel-next-video').click(function() {
        clearInterval(wpvs_count_down_interval);
        jQuery('#wpvs-autoplay-countdown').hide();
        wpvs_load_video_count_down = wpvideosinfo.timer;
        jQuery('#wpvs-autoplay-count').text(wpvs_load_video_count_down);
    });
});

function wpvs_load_next_video() {
    jQuery('#wpvs-next-video-title').html(wpvideosinfo.nextvideotitle);
    jQuery('#wpvs-next-video-title').attr('href', wpvideosinfo.nextvideo);
    jQuery('#wpvs-autoplay-countdown').fadeIn();
    wpvs_count_down_interval = setInterval(wpvs_next_video_countdown, 1000);
}

function wpvs_next_video_countdown() {
    if (wpvs_load_video_count_down < 1) {
        window.location.href = wpvideosinfo.nextvideo;
        clearInterval(wpvs_count_down_interval);
    }
    wpvs_load_video_count_down--;
    if(wpvs_load_video_count_down < 0) {
        wpvs_load_video_count_down = 0;
        clearInterval(wpvs_count_down_interval);
    }
    jQuery('#wpvs-autoplay-count').text(wpvs_load_video_count_down);
}