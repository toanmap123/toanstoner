<?php
add_action( 'wp_ajax_wpvs_create_video_html_request', 'wpvs_create_video_html_request' );

function wpvs_create_video_html_request() {
    if ( isset($_POST['videosrc']) && ! empty($_POST['videosrc']) && isset($_POST['videowidth']) && ! empty($_POST['videowidth']) && isset($_POST['videoheight']) && ! empty($_POST['videoheight']) && isset($_POST['videotype']) && ! empty($_POST['videotype'])) {
        $video_src = $_POST['videosrc'];
        $video_width = $_POST['videowidth'];
        $video_height = $_POST['videoheight'];
        $video_type = $_POST['videotype'];
        $video_shortcode = '[video width="'.$video_width.'" height="'.$video_height.'" '.$video_type.'="'.$video_src.'"][/video]';
        echo do_shortcode( $video_shortcode );
    }
    wp_die();
}

if( ! function_exists('wpvs_gather_vimeo_thumbnails') ) {
function wpvs_gather_vimeo_thumbnails($vimeo_thumbnail_images) {
    $vimeo_featured_image = null;
    $prev_width = 0;
    $vimeo_thumbnail_image = null;
    if( ! empty($vimeo_thumbnail_images) ) {
        foreach($vimeo_thumbnail_images as $thumbnail) {
            if( ($thumbnail['width'] > $prev_width) && ($thumbnail['width'] <= 1920) )  {
                $vimeo_featured_image = $thumbnail['link'];
            }
            if( ($thumbnail['width'] > $prev_width) && ($thumbnail['width'] <= 640) )  {
                $vimeo_thumbnail_image = $thumbnail['link'];
            }

            $prev_width = $thumbnail['width'];
        }
    }
    return array('featured' => $vimeo_featured_image, 'thumbnail' => $vimeo_thumbnail_image);
}
}
