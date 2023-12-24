<?php

if( ! function_exists('wpvs_video_actor_add_meta_data') ) {
function wpvs_video_actor_add_meta_data() {
    global $wpvs_actor_slug_settings;
	?>
    <div class="form-field term-slug-wrap">
        <label><strong><?php _e('Order', 'vimeo-sync-memberships'); ?></strong></label>
        <p>Sets the <strong>Order</strong> for this <?php echo $wpvs_actor_slug_settings['name']; ?></p>
        <input type="number" min="0" name="wpvs_video_display_order" value="" />
    </div>
<?php
}
add_action( 'rvs_actors_add_form_fields', 'wpvs_video_actor_add_meta_data', 10, 2 );
add_action( 'rvs_directors_add_form_fields', 'wpvs_video_actor_add_meta_data', 10, 2 );
}

if( ! function_exists('wpvs_video_actor_edit_meta_data') ) {
function wpvs_video_actor_edit_meta_data($term) {
    global $wpvs_actor_slug_settings;
    $wpvs_display_order = get_term_meta($term->term_id, 'wpvs_display_order', true);
    if( empty($wpvs_display_order) ) {
        $wpvs_display_order = "0";
    }
    ?>
    <tr>
        <th scope="row" valign="top"><label><strong><?php _e('Order', 'vimeo-sync-memberships'); ?></strong></label></th>
            <td>
                <input type="number" min="0" name="wpvs_video_display_order" value="<?php echo $wpvs_display_order; ?>" /><br><br>
                <p class="description">Sets the <strong>Order</strong> for this <?php echo $wpvs_actor_slug_settings['name']; ?></p>
            </td>
        </tr>
	<tr>   
	<?php
}
add_action( 'rvs_actors_edit_form_fields', 'wpvs_video_actor_edit_meta_data', 10, 2 );
add_action( 'rvs_directors_edit_form_fields', 'wpvs_video_actor_edit_meta_data', 10, 2 );
}

if( ! function_exists('wpvs_video_actor_save_meta_data') ) {
    function wpvs_video_actor_save_meta_data( $term_id ) {
        if ( isset( $_POST['wpvs_video_display_order'] ) ) {
            update_term_meta($term_id, 'wpvs_display_order', $_POST['wpvs_video_display_order']);
        } 
    }
}
add_action( 'edited_rvs_actors', 'wpvs_video_actor_save_meta_data', 10, 2 );  
add_action( 'create_rvs_actors', 'wpvs_video_actor_save_meta_data', 10, 2 );
add_action( 'edited_rvs_directors', 'wpvs_video_actor_save_meta_data', 10, 2 );  
add_action( 'create_rvs_directors', 'wpvs_video_actor_save_meta_data', 10, 2 );