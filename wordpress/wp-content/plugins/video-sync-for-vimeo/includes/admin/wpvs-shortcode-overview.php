<div class="wrap">
    <?php include('wpv-admin-menu.php'); ?>
    <div class="vimeosync">
        <h2>WPVS Videos Shortcodes &amp; Gutenberg Blocks</h2>
        <p class="description">This page is an overview of the WPVS Videos plugin Shortcodes and Gutenberg Editor blocks available.</p>
    </div>

    <div class="vimeosync">
        <h2>WPVS Gutenberg Blocks</h2>
        <p class="description">When editing a Page, Post or other content type using the Gutenberg Editor, the following Blocks can be used to display WPVS content.</p>
        <ul class="wpvs-admin-list">
            <li><strong>WPVS Video Block:</strong> Displays a single WPVS Video.</li>
            <li><strong>WPVS Video List:</strong> Displays a list of WPVS Videos.</li>
        </ul>
    </div>

    <div class="vimeosync">
        <h2>WPVS Shortcodes</h2>
        <p class="description">Use the following Shortcodes to display WPVS Videos content across your site.</p>

        <div class="wpvs-admin-shortcode">
            <h3>WPVS Single Video</h3>
            <p class="description">Displays a single WPVS Video.</p>
            <input type="text" value="[wpvs_single_video video_id=Video ID goes here...]" readonly />
            <h4>Shortcode Parameters</h4>
            <ul class="wpvs-admin-list">
                <li><strong>video_id:</strong> The ID of the WPVS Vidoe you want to display. This parameter is required.</li>
            </ul>
        </div>
        <div class="wpvs-admin-shortcode">
            <h3>WPVS Video List</h3>
            <p class="description">Displays a list of WPVS Videos.</p>
            <input type="text" value="[wpvs_video_list]" readonly />
            <h4>Shortcode Parameters</h4>
            <ul class="wpvs-admin-list">
                <li><strong>videos_per_page:</strong> Sets the number of WPVS Videos to display. Default is 12.</li>
                <li><strong>categories:</strong> Filter WPVS Videos by Genre / Category. Comma separated Taxonomy ID values</li>
                <li><strong>actors:</strong> Filter WPVS Videos by Actors. Comma separated Taxonomy ID values</li>
                <li><strong>directors:</strong> Filter WPVS Videos by Directors. Comma separated Taxonomy ID values</li>
                <li><strong>tags:</strong> Filter WPVS Videos by Video Tags. Comma separated Taxonomy ID values</li>
            </ul>
            <h4>Shortcode Examples</h4>
            <div class="wpvs-shortcode-example">
                <h5>Videos Per Page</h5>
                <input type="text" value='[wpvs_video_list videos_per_page="50"]' readonly />
            </div>
            <div class="wpvs-shortcode-example">
                <h5>Genre / Categories</h5>
                <input type="text" value='[wpvs_video_list categories="3,35,26,..."]' readonly />
            </div>
            <div class="wpvs-shortcode-example">
                <h5>Actors</h5>
                <input type="text" value='[wpvs_video_list actors="3,35,26,..."]' readonly />
            </div>
            <div class="wpvs-shortcode-example">
                <h5>Directors</h5>
                <input type="text" value='[wpvs_video_list directors="3,35,26,..."]' readonly />
            </div>
            <div class="wpvs-shortcode-example">
                <h5>Video Tags</h5>
                <input type="text" value='[wpvs_video_list tags="3,35,26,..."]' readonly />
            </div>
        </div>
    </div>


</div>
