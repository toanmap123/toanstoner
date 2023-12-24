<?php
add_action( 'add_meta_boxes', 'wpvideos_video_metabox_settings' );

function wpvideos_video_metabox_settings() {
    add_meta_box('wpvideos-video-details', 'Video', 'wpvideos_video_details', 'rvs_video', 'normal', 'high');
    add_meta_box('wpvideos-video-information', 'Video Information', 'wpvideos_video_information', 'rvs_video', 'normal', 'high');
    add_meta_box('wpvideos-video-order', 'Video Order', 'wpvideos_video_order', 'rvs_video', 'side', 'low');
}

function wpvideos_video_details() {
    global $wpvs_videos_plugin_version;
    $wpvs_js_editor = wp_enqueue_code_editor( array( 'type' => 'text/javascript') );
    $wpvs_custom_html_editor = wp_enqueue_code_editor( array(
        'type' => 'text/html',
    ) );
    wp_enqueue_style( 'wpvideos-video-post-css', plugins_url( '../css/video-post.css', __FILE__ ),'', $wpvs_videos_plugin_version);
    wp_enqueue_script( 'wpvideos-video-post-js', plugins_url( '../js/video-post.js', __FILE__ ),array('jquery'), $wpvs_videos_plugin_version);
    wp_localize_script( 'wpvideos-video-post-js', 'wpvsvideopost', array( 'code_mirror_video_js' => wp_json_encode( $wpvs_js_editor ), 'code_mirror_video_html' => wp_json_encode( $wpvs_custom_html_editor )));
    wp_enqueue_script( 'wpvideos-video-upload', plugins_url( '../js/admin/rvs-video-upload.js', __FILE__ ),array('jquery'), $wpvs_videos_plugin_version);
    wp_localize_script( 'wpvideos-video-upload', 'wpvsajax', array( 'url' => admin_url( 'admin-ajax.php' )));
    wp_nonce_field( 'rvs_video_meta_save', 'rvs_video_meta_save_nonce' );

    global $post;

    // GET VIDEO TYPE
    $rvs_video_type = get_post_meta($post->ID, '_rvs_video_type', true);
    if(empty($rvs_video_type)) {
        $rvs_video_type = "vimeo";
    }

    wp_add_inline_script('code-editor',
    sprintf(
            'jQuery( function() { wp.codeEditor.initialize( "wpvs-custom-video-js-code", %s ); } );',
            wp_json_encode( $wpvs_js_editor )
        )
    );
    wp_add_inline_script('code-editor',
    sprintf(
            'jQuery( function() { wp.codeEditor.initialize( "custom-video-code", %s ); } );',
            wp_json_encode( $wpvs_custom_html_editor )
        )
    );

    // WORDPRESS
    $rvs_wordpress_id = get_post_meta($post->ID, 'rvs_video_wordpress_id', true);
    $rvs_wordpress_code = get_post_meta($post->ID, 'rvs_video_wordpress_code', true);

    // VIMEO
    $vimeo_id = get_post_meta($post->ID, 'rvs_video_post_vimeo_id', true);
    $vimeo_video_html = get_post_meta($post->ID, 'rvs_video_post_vimeo_html', true);
    $vimeo_video_url = get_post_meta($post->ID, 'wpvs_vimeo_video_url', true);
    if( empty($vimeo_video_url) ) {
        if( ! empty($vimeo_id) ) {
            $vimeo_video_url = 'https://vimeo.com/'.$vimeo_id;
        } else {
            $vimeo_video_url = "";
        }
    }

    // YOUTUBE
    $rvs_youtube_url = get_post_meta($post->ID, 'rvs_youtube_url', true);

    // CUSTOM
    $rvs_custom_video_code = get_post_meta($post->ID, 'rvs_video_custom_code', true);
    if( empty($rvs_custom_video_code) ) {
        $rvs_custom_video_code = "";
    }
    $wpvs_custom_video_js = get_post_meta($post->ID, 'wpvs_custom_video_js', true);
    if( empty($wpvs_custom_video_js) ) {
        $wpvs_custom_video_js = "";
    }

    // SHORTCODE
    $rvs_shortcode_video = get_post_meta($post->ID, 'rvs_shortcode_video', true);
    $rvs_shortcode_video_check = get_post_meta($post->ID, 'rvs_shortcode_video_check', true);

    if( empty($rvs_shortcode_video) ) {
        $rvs_shortcode_video = "";
    }
    if( empty($rvs_shortcode_video_check) ) {
        $rvs_shortcode_video_check = "";
    }

    $wpvs_featured_image = get_post_meta($post->ID, 'wpvs_featured_image', true);
    ?>
    <div id="video-type" class="rvs-container rvs-box rvs-video-container border-box">
        <label class="rvs-label">Select Video Type:</label>
        <select id="select-video-type" name="select-video-type">
            <option value="vimeo" <?php selected("vimeo", $rvs_video_type); ?>>Vimeo</option>
            <option value="wordpress" <?php selected("wordpress", $rvs_video_type); ?>>WordPress</option>
            <option value="youtube" <?php selected("youtube", $rvs_video_type); ?>>YouTube</option>
            <option value="custom" <?php selected("custom", $rvs_video_type); ?>>Custom</option>
            <option value="shortcode" <?php selected("shortcode", $rvs_video_type); ?>>Shortcode</option>
        </select>
    </div>

    <!-- VIMEO -->
    <div id="vimeo-type-option" class="rvs-type-area <?=($rvs_video_type == 'vimeo') ? 'rvs-display-area' : '' ?>">
        <div class="text-align-right rvs-box rvs-video-container border-box">
            <a href="<?php echo admin_url('admin.php?page=rvs-video-design&tab=vimeo'); ?>" class="rvs-button" target="_blank">Edit Vimeo Player</a>
        </div>
        <div class="rvs-container rvs-box rvs-video-container border-box">
        <table class="form-table">
            <tbody>
                <tr>
                <th scope="row"><label class="rvs-label">Enter Vimeo URL:</label></th>
                <td><input type="url" class="wpvs-input-url" name="vimeo-video-url" id="vimeo-video-url" class="regular-text" placeholder="Paste Vimeo link here..." value="<?php echo $vimeo_video_url; ?>" /></td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="rvs-vimeo-id" id="rvs-vimeo-id" value="<?php echo $vimeo_id; ?>" />
        </div>
    </div><!-- END VIMEO -->

    <!-- WORDPRESS -->
    <div id="wordpress-type-option" class="rvs-type-area <?=($rvs_video_type == 'wordpress') ? 'rvs-display-area' : '' ?>">
        <div class="text-align-right rvs-box rvs-video-container border-box">
            <label id="choose-wordpress-video" class="rvs-button">Choose Video</label>
        </div>
        <input type="hidden" value="<?php echo $rvs_wordpress_id; ?>" id="rvs-wordpress-id" name="rvs-wordpress-id" />
        <textarea name="rvs-wordpress-code" id="rvs-wordpress-code" class="rvs-hidden-code"><?php echo $rvs_wordpress_code; ?></textarea>
    </div><!-- END WORDPRESS -->

    <!-- YouTube -->
    <div id="youtube-type-option" class="rvs-type-area <?=($rvs_video_type == 'youtube') ? 'rvs-display-area' : '' ?> ">
        <div class="text-align-right rvs-container rvs-box rvs-video-container border-box">
            <a href="<?php echo admin_url('admin.php?page=rvs-video-design&tab=youtube'); ?>" class="rvs-button" target="_blank">Edit YouTube Player</a>
        </div>
        <div class="rvs-container rvs-box rvs-video-container border-box">
        <table class="form-table">
            <tbody>
                <tr>
                <th scope="row"><label class="rvs-label">Enter YouTube URL:</label></th>
                <td><input type="url" class="wpvs-input-url" name="youtube-video-url" id="youtube-video-url" class="regular-text" placeholder="Paste YouTube link here..." value="<?php echo $rvs_youtube_url; ?>" /></td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" value="?enablejsapi=1" id="rvs-youtube-string" />
        </div>
    </div>

    <!-- Custom -->
    <div id="custom-type-option" class="rvs-type-area <?=($rvs_video_type == 'custom') ? 'rvs-display-area' : '' ?>">
        <div class="rvs-box rvs-video-container border-box">
            <table class="form-table">
                <tbody>
                    <tr>
                    <td>
                        <h4>Paste embed / iframe / html code:</h4>
                        <textarea name="custom-video-code" rows="5" cols="10" id="custom-video-code"><?php echo $rvs_custom_video_code; ?></textarea></td>
                    </tr>
                    <tr>
                    <td>
                        <h4>Custom player javascript (optional):</h4>
                        <p class="description">Javascript code here should be video specific. If you need global JS / CSS files or code for all your custom player videos, add them on the <a href="<?php echo admin_url('admin.php?page=wpvs-custom-player-settings'); ?>" title="Custom Player Settings" >Custom Player</a> page.</p><br>
                        <textarea id="wpvs-custom-video-js-code" name="wpvs-custom-video-js-code" rows="5" cols="20"><?php echo $wpvs_custom_video_js; ?></textarea>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Shortcode -->
    <div id="shortcode-type-option" class="rvs-type-area <?=($rvs_video_type == 'shortcode') ? 'rvs-display-area' : '' ?> ">
        <div class="rvs-container rvs-box rvs-video-container border-box">
        <table class="form-table">
            <tbody>
                <tr>
                <th scope="row"><label class="rvs-label">Enter Video Shortcode:</label></th>
                <td><input type="text" class="wpvs-input-url" name="wpvs-video-shortcode" id="wpvs-video-shortcode" class="regular-text" placeholder="[shortcode attr=example]" value="<?php echo htmlentities($rvs_shortcode_video); ?>" /><br><br>
                <em>Using a shortcode may require custom CSS for your video player.</em>
                </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>

    <div class="rvs-video-container border-box rvs-container rvs-box">
        <h4><?php _e('Video Preview', 'vimeosync'); ?></h4>
        <p>If you are using a <strong>Custom</strong> video player, you may need to Update / Save then refresh the page to see a preview.</p>
        <div id="currentRVSVideo" class="wpvs-responsive-video">
            <?php
                if( $rvs_video_type == "wordpress" && ! empty($rvs_wordpress_code) ) {
                    echo do_shortcode($rvs_wordpress_code);
                }
                if($rvs_video_type == "shortcode" && ! empty($rvs_shortcode_video) ) {
                    if(! empty($rvs_shortcode_video_check) && shortcode_exists($rvs_shortcode_video_check)) {
                        echo do_shortcode($rvs_shortcode_video);
                    } else {
                        _e('Something is wrong with your Shortcode', 'vimeosync');
                    }
                }
                if($rvs_video_type == "custom" && ! empty($rvs_custom_video_code) ) {
                    echo $rvs_custom_video_code;
                }
                if( ($rvs_video_type == "vimeo" || $rvs_video_type == "youtube") && ! empty($vimeo_video_html) ) {
                    echo $vimeo_video_html;
                }
            ?>
        </div>
    </div>
    <textarea name="new-video-html" id="new-video-html" class="rvs-hidden-code"><?php echo $vimeo_video_html; ?></textarea>
<?php if(!has_post_thumbnail($post->ID) && ! empty($wpvs_featured_image)) { ?>
    <script>
        var temp_thumbnail = '<?php echo $wpvs_featured_image; ?>';
        jQuery(document).ready( function() {
            var wpvs_set_temp_featured;
            var wpvs_set_temp_check = 5;
            wpvs_set_temp_featured = setInterval(function() {
                if(wpvs_set_temp_check > 0) {
                    if(jQuery('.editor-post-featured-image').length > 0) {
                        jQuery('.editor-post-featured-image').before('<img id="wpvs-vimeo-featured-image" src="'+temp_thumbnail+'"/>');
                        clearInterval(wpvs_set_temp_featured);
                    } else {
                        wpvs_set_temp_check--;
                    }
                } else {
                     clearInterval(wpvs_set_temp_featured);
                }
            }, 500);

            jQuery('body').delegate('.editor-post-featured-image__toggle', 'click', function() {
                if ( jQuery('#wpvs-vimeo-featured-image').length > 0 ) {
                   jQuery('#wpvs-vimeo-featured-image').remove();
                }
            });
        });

    </script>
<?php }
}

function wpvideos_video_order() {
    global $post;
    $wpvs_video_order = get_post_meta($post->ID, 'rvs_video_post_order', true);
    if( empty($wpvs_video_order) ) {
        $wpvs_video_order = 0;
    }
    wp_nonce_field( 'rvs_video_order_save', 'rvs_video_order_save_nonce' );
?>
    <div class="inside">
        <label><?php _e('Order', 'vimeosync'); ?></label>:<br><br>
        <input name="rvs-video-order" type="number" min="0" max="99999" value="<?php echo $wpvs_video_order; ?>" /><br>
    </div>
<?php
}

function wpvideos_video_information() {
    global $post;
    wp_nonce_field( 'wpvideos_information_save', 'wpvideos_information_save_nonce' );
    $wpvs_video_information = get_post_meta($post->ID, 'wpvs_video_information', true);
    $wpvs_video_length = get_post_meta($post->ID, 'wpvs_video_length', true);

    if( empty($wpvs_video_length) ) {
        $wpvs_video_length = 0;
    }

    $wpvs_video_hours = intval(gmdate("H", $wpvs_video_length));
    $wpvs_video_minutes = intval(gmdate("i", $wpvs_video_length));

    if( empty($wpvs_video_information) ) {
        $wpvs_video_information = array(
            'length' => $wpvs_video_length,
            'hours' => $wpvs_video_hours,
            'minutes' => $wpvs_video_minutes,
            'date_released' => ""
        );
    } else {
        if( ! isset($wpvs_video_information['length']) ) {
            $wpvs_video_information['length'] = $wpvs_video_length;
        }
        if( ! isset($wpvs_video_information['hours']) ) {
            $wpvs_video_information['hours'] = $wpvs_video_hours;
        }
        if( ! isset($wpvs_video_information['minutes']) ) {
            $wpvs_video_information['minutes'] = $wpvs_video_minutes;
        }
        if( ! isset($wpvs_video_information['date_released']) ) {
            $wpvs_video_information['date_released'] = "";
        }
    }
?>
    <div class="border-box rvs-container">
        <div class="col-4">
            <h4>Video Length:</h4>
            <input type="number" min="0" max="100" id="wpvideo-video-hours" name="wpvs_video_information[hours]" value="<?php echo $wpvs_video_information['hours']; ?>" />
            <label>Hour(s):</label>
            <input type="number" min="0" max="59" id="wpvideo-video-minutes" name="wpvs_video_information[minutes]" value="<?php echo $wpvs_video_information['minutes']; ?>" />
            <label>Minutes:</label>
            <input type="hidden" id="wpvideo-video-length" name="wpvs_video_information[length]" value="<?php echo $wpvs_video_information['length']; ?>" />
        </div>
        <div class="col-4">
            <h4>Release Date:</h4>
            <input type="text" id="wpvideo-video-release-date" name="wpvs_video_information[date_released]" value="<?php echo $wpvs_video_information['date_released']; ?>" placeholder="<?php echo date('Y'); ?>" />
        </div>
    </div>
<?php
}

add_action( 'save_post', 'wpvideos_admin_save_video_meta' );

function wpvideos_admin_save_video_meta( $post_id ) {
    if(rvs_save_video_data( $post_id, 'rvs_video_meta_save_nonce', 'rvs_video_meta_save' )) {

        // SAVE VIDEO HTML
        if ( isset( $_POST['new-video-html'] ) ) {
            $new_video_html = $_POST['new-video-html'];
            update_post_meta($post_id, 'rvs_video_post_vimeo_html', $new_video_html);
        }

        // SAVE VIDEO TYPE
        if ( isset( $_POST['select-video-type'] ) ) {
            $save_video_type = $_POST['select-video-type'];
            update_post_meta( $post_id, '_rvs_video_type', $save_video_type);
            if($save_video_type != "vimeo") {
                update_post_meta($post_id, 'rvs_video_post_vimeo_id', null);
            }
        }

        // SAVE VIDEO TYPE
        if ( isset( $_POST['rvs-vimeo-id'] ) ) {
            $save_vimeo_id = $_POST['rvs-vimeo-id'];
            update_post_meta( $post_id, 'rvs_video_post_vimeo_id', $save_vimeo_id);
        }


        if ( isset( $_POST['vimeo-video-url'] ) ) {
            $new_vimeo_url = $_POST['vimeo-video-url'];
            update_post_meta($post_id, 'wpvs_vimeo_video_url', $new_vimeo_url);
        }

        if ( isset( $_POST['youtube-video-url'] ) ) {
            $new_youtube_url = $_POST['youtube-video-url'];
            update_post_meta($post_id, 'rvs_youtube_url', $new_youtube_url);
        }

        if ( isset( $_POST['custom-video-code'] ) ) {
            $new_custom_code = $_POST['custom-video-code'];
            update_post_meta($post_id, 'rvs_video_custom_code', $new_custom_code);
        }

        if ( isset( $_POST['wpvs-custom-video-js-code'] ) ) {
            $new_custom_video_js_code = $_POST['wpvs-custom-video-js-code'];
            update_post_meta($post_id, 'wpvs_custom_video_js', $new_custom_video_js_code);
        }

        if ( isset( $_POST['rvs-wordpress-id'] ) ) {
            $new_wordpress_video_id = $_POST['rvs-wordpress-id'];
            update_post_meta($post_id, 'rvs_video_wordpress_id', $new_wordpress_video_id);
        }

        if ( isset( $_POST['rvs-wordpress-code'] ) ) {
            $new_wordpress_video_code = $_POST['rvs-wordpress-code'];
            update_post_meta($post_id, 'rvs_video_wordpress_code', $new_wordpress_video_code);
        }

        if ( isset( $_POST['wpvs-video-shortcode'] ) ) {
            $new_shortcode_video_text = sanitize_text_field($_POST['wpvs-video-shortcode']);
            update_post_meta($post_id, 'rvs_shortcode_video', $new_shortcode_video_text);
            $new_shortcode_check = explode(" ", $new_shortcode_video_text);
            $shortcode_check_first = $new_shortcode_check[0];
            if (strpos($shortcode_check_first, '[') !== false) {
                $new_shortcode_check = explode("[", $shortcode_check_first);
                if( isset($new_shortcode_check[1]) && ! empty($new_shortcode_check[1])) {
                    $new_shortcode_check = $new_shortcode_check[1];
                    update_post_meta($post_id, 'rvs_shortcode_video_check', $new_shortcode_check);
                }
            }
        }
    }

    if(rvs_save_video_data( $post_id, 'rvs_video_column_save_nonce', 'rvs_video_column_save' )) {
        if ( isset( $_REQUEST['rvs_video_post_order'] ) ) {
            update_post_meta( $post_id, 'rvs_video_post_order', $_REQUEST['rvs_video_post_order'] );
        }
    }

    if(rvs_save_video_data( $post_id, 'rvs_video_order_save_nonce', 'rvs_video_order_save' )) {
        if ( isset( $_REQUEST['rvs-video-order'] ) ) {
            update_post_meta( $post_id, 'rvs_video_post_order', $_REQUEST['rvs-video-order']);
        }
    }

    if(rvs_save_video_data( $post_id, 'wpvideos_information_save_nonce', 'wpvideos_information_save' )) {
        $new_video_length = 0;
        if ( isset( $_POST['wpvs_video_information'] ) ) {
            $new_video_information = $_POST['wpvs_video_information'];
            if ( isset( $new_video_information['hours'] ) ) {
                $new_video_hours = $new_video_information['hours'];
            }
            if ( isset( $new_video_information['minutes'] ) ) {
                $new_video_minutes = $new_video_information['minutes'];
            }
            if( ! empty($new_video_hours) ) {
                $add_hour_seconds = intval($new_video_hours)*3600;
                $new_video_length += $add_hour_seconds;
            }
            if( ! empty($new_video_minutes) ) {
                $add_minute_seconds = intval($new_video_minutes)*60;
                $new_video_length += $add_minute_seconds;
            }
            if( ! empty($new_video_length) ) {
                update_post_meta( $post_id, 'wpvs_video_length', $new_video_length);
                $new_video_information['length'] = $new_video_length;
            } else {
                update_post_meta( $post_id, 'wpvs_video_length', $new_video_length);
                $new_video_information['length'] = 0;
            }
            update_post_meta( $post_id, 'wpvs_video_information', $new_video_information);
        }
    }
}

// ADD VIDEO ORDER COLUMN
function rvs_order_column_head($columns) {
    $wpvs_custom_columns = array(
        'rvs_video_post_order' => __('Order', 'vimeosync')
    );
    return array_merge( $columns,  $wpvs_custom_columns);
}

add_filter('manage_rvs_video_posts_columns', 'rvs_order_column_head');

function wpvideos_video_order_columns_content($column_name, $post_ID) {
    if ($column_name == 'rvs_video_post_order') {
        $wpvs_video_order = get_post_meta($post_ID, 'rvs_video_post_order', true);
        if( empty($wpvs_video_order) )  {
            $wpvs_video_order = 0;
        }
        echo '<div class="wpvs-video-order-column">'.$wpvs_video_order.'</div>';
    }
}

add_action('manage_rvs_video_posts_custom_column', 'wpvideos_video_order_columns_content', 10, 2);

// QUICK EDIT ORDER

add_action( 'quick_edit_custom_box', 'wpvideos_video_order_quickedit_fields', 10, 2 );

function wpvideos_video_order_quickedit_fields( $column_name, $post_type ) {
    if( $post_type == 'rvs_video' ) {
        if ($column_name == 'rvs_video_post_order') { ?>
            <fieldset class="inline-edit-col-right inline-edit-video">
                <?php
                static $printNonce = TRUE;
                    if ( $printNonce ) {
                        $printNonce = FALSE;
                        wp_nonce_field( plugin_basename( __FILE__ ), 'rvs_video_edit_order_nonce' );
                    }
                ?>
            <div class="inline-edit-col column-'rvs_video_post_order_field'">
              <label class="inline-edit-group">
                  <span class="title"><?php _e('Order', 'vimeosync'); ?></span><input type="number" min="0" name="rvs_video_post_order" />
              </label>
            </div>
            </fieldset>
        <?php }
    }
}

add_action( 'save_post', 'wpvideos_admin_save_video_order_quick' );

function wpvideos_admin_save_video_order_quick( $post_id ) {

    $wpvs_video_slug = 'rvs_video';
    if ( isset($_POST['post_type']) && $wpvs_video_slug !== $_POST['post_type'] ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( isset($_POST['rvs_video_edit_order_nonce']) && ! wp_verify_nonce( $_POST['rvs_video_edit_order_nonce'], plugin_basename( __FILE__ ) ) ) {
        return;
    }

    if ( isset( $_REQUEST['rvs_video_post_order'] ) ) {
        update_post_meta( $post_id, 'rvs_video_post_order', $_REQUEST['rvs_video_post_order'] );
    }

}

/* load script in the footer */
if ( ! function_exists('wp_rvs_video_admin_enqueue_scripts') ):
function wp_rvs_video_admin_enqueue_scripts( $hook ) {
	if ( 'edit.php' === $hook &&
		isset( $_GET['post_type'] ) &&
		'rvs_video' === $_GET['post_type'] ) {

		wp_enqueue_script( 'edit-video-order', plugins_url('../js/edit-video-order.js', __FILE__),
			false, null, true );
	}
}
endif;
add_action( 'admin_enqueue_scripts', 'wp_rvs_video_admin_enqueue_scripts' );

/* load scripts for new post */
if ( ! function_exists('rvs_video_new_admin_enqueue_scripts') ):
function rvs_video_new_admin_enqueue_scripts( $hook ) {
    global $wpvs_videos_plugin_version;
	if ( 'post-new.php' === $hook &&
		isset( $_GET['post_type'] ) &&
		'rvs_video' === $_GET['post_type'] ) {
		wp_enqueue_style( 'vimeosync-responsive', plugins_url( '../css/responsive-video.css', __FILE__ ),'', $wpvs_videos_plugin_version);
        wp_enqueue_style( 'vimeosync-video-post', plugins_url( '../css/video-post.css', __FILE__ ),'', $wpvs_videos_plugin_version);
	}

}
endif;
add_action( 'admin_enqueue_scripts', 'rvs_video_new_admin_enqueue_scripts' );

// SAVE FUNCTION
function rvs_save_video_data( $post_id, $save_nonce, $save_nonce_name ) {
    if ( ! isset( $_POST[$save_nonce] ) ) {
        return false;
    }
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST[$save_nonce], $save_nonce_name ) ) {
        return false;
    }
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return false;
    }
    if ( wp_is_post_revision( $post_id ) )
        return false;
    // Check the user's permissions.

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return false;
    }
    return true;
}
