<div class="wrap">
    <?php include('wpv-admin-menu.php'); ?>
    <div class="vimeosync">
        <form method="post" action="options.php">
            <?php
                settings_fields( 'wpvs-custom-player-settings' );
                $wpvs_custom_player = get_option('wpvs-custom-player');
                if( ! isset($wpvs_custom_player['jsfiles']) ) {
                    $wpvs_custom_player['jsfiles'] = "";
                }
                if( ! isset($wpvs_custom_player['jsfileoutput']) ) {
                    $wpvs_custom_player['jsfileoutput'] = "footer";
                }
                if( ! isset($wpvs_custom_player['cssfiles']) ) {
                    $wpvs_custom_player['cssfiles'] = "";
                }
                if( ! isset($wpvs_custom_player['customjs']) ) {
                    $wpvs_custom_player['customjs'] = "";
                }
                if( ! isset($wpvs_custom_player['customcss']) ) {
                    $wpvs_custom_player['customcss'] = "";
                }
            ?>
            <h2>Custom Player Settings</h2>
            <p>Use the following fields to add additional JS and CSS files required for your third party video player.</p>
            <div class="rvs-container rvs-box">
                <div class="col-12">
                    <h3>Additional Script (JS) Files</h3>
                    <p>One script tag per line <strong>(HTML also accepted such as <?php echo htmlentities('<div id="fb-root"></div>'); ?>)</strong></p>
                    <textarea id="wpvs-js-file-editor" name="wpvs-custom-player[jsfiles]" rows="5" cols="20" id="custom-video-code" class="large-text code" placeholder='<script src="//link-to-script-file.js"></script>'><?php echo $wpvs_custom_player['jsfiles']; ?></textarea>
                    <br>
                    <label>Output Location:</label>
                    <select name="wpvs-custom-player[jsfileoutput]">
                        <option value="head" <?php selected("head", $wpvs_custom_player['jsfileoutput']); ?>>Head</option>
                        <option value="footer" <?php selected("footer", $wpvs_custom_player['jsfileoutput']); ?>>Footer</option>
                    </select>
                </div>
            </div>

            <div class="rvs-container rvs-box">
                <div class="col-12">
                    <h3>Additional Style (CSS) Files</h3>
                    <p>One style tag per line</p>
                    <textarea id="wpvs-css-file-editor" name="wpvs-custom-player[cssfiles]" rows="5" cols="20" id="custom-video-code" class="large-text code" placeholder='<link rel="stylesheet" href="external-styles.css" />'><?php echo $wpvs_custom_player['cssfiles']; ?></textarea>
                </div>
            </div>

            <div class="rvs-container rvs-box">
                <div class="col-12">
                    <h3>Custom JS</h3>
                    <p>Enter custom Javascript</p>
                    <textarea id="wpvs-js-editor" name="wpvs-custom-player[customjs]" rows="5" cols="20" id="custom-video-code" class="large-text code" placeholder='var player = playerObject;'><?php echo $wpvs_custom_player['customjs']; ?></textarea>
                </div>
            </div>

            <div class="rvs-container rvs-box">
                <div class="col-12">
                    <h3>Custom CSS</h3>
                    <p>Enter custom CSS</p>
                    <textarea id="wpvs-css-editor" name="wpvs-custom-player[customcss]" rows="5" cols="20" id="custom-video-code" class="large-text code" placeholder='.playerClass { margin: 0; }'><?php echo $wpvs_custom_player['customcss']; ?></textarea>
                </div>
            </div>

            <div class="rvs-container">
            <?php submit_button(); ?>
            </div>
        </form>

    </div>
</div>
