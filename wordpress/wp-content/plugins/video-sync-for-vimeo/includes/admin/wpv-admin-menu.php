<?php $wpv_screen = $_GET['page']; ?>
<label id="rvs-dropdown-menu" for="rvs-menu-checkbox"><span class="dashicons dashicons-menu"></span> Menu</label>
<div id="rvs-admin-menu" class="border-box">
    <?php if( ! get_option('is-wp-videos-multi-site')) { ?>
        <a href="<?php echo admin_url('admin.php?page=rvs-activation'); ?>" title="Activate Website" class="rvs-tab <?=($wpv_screen == "rvs-activation") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-star-filled"></span> Activate Website</a>
    <?php } ?>
    <a href="<?php echo admin_url('admin.php?page=wpvs-video-settings'); ?>" title="WP Video Settings" class="rvs-tab <?=($wpv_screen == "wpvs-video-settings") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-admin-generic"></span> Video Settings</a>
    <a href="<?php echo admin_url('admin.php?page=wpvs-custom-player-settings'); ?>" title="Custom Player Settings" class="rvs-tab <?=($wpv_screen == "wpvs-custom-player-settings") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-editor-code"></span> Custom Player</a>
    <a href="<?php echo admin_url('admin.php?page=wpvs-shortcodes-blocks'); ?>" title="WPVS Shortcodes / Blocks" class="rvs-tab <?=($wpv_screen == "wpvs-shortcodes-blocks") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-shortcode"></span> Shortcodes / Blocks</a>
    <?php do_action( 'rvs_membership_admin_items' ); ?>
</div>
