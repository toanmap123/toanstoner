=== WP Videos ===
Contributors: RogueWebDesign
Donate link: https://www.wpvideosubscriptions.com
Tags: video, videos, vimeo, youtube, wp videos, video shortcodes, wordpress videos, video player, video post type
Requires at least: 4.0
Tested up to: 6.2.2
Stable tag: 3.0.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Videos creates Video post types that you can easily add Vimeo, YouTube, WordPress, Shortcode or custom embed (third party) HTML and JS videos to.

== Description ==

<p><strong>NEW:</strong> WPVS Video and WPVS Video List Gutenberg Blocks along with 2 new shortcodes added for displaying WPVS video content on your website.</p>

<p>WP Videos allows you create video post types from YouTube URLs and Vimeo URLs, use WordPress video uploads, other video plugin shortcodes or custom embed HTML and JS players.</p>

<h4>Features</h4>

<ul>
    <li>Add Videos using Vimeo urls</li>
    <li>Add Videos using YouTube urls</li>
    <li>Add Videos using shortcodes</li>
    <li>Add Videos using the default WordPress player</li>
    <li>Add Videos using custom player embed HTML and JS code</li>
    <li>Video Categories / Genres (customizable name, slug and icon)</li>
 	<li>Video Actors (customizable name, slug and icon)</li>
 	<li>Video Directors (customizable name, slug and icon)</li>
    <li>Video Tags</li>
</ul>

<blockquote>
<h4>WP Video Memberships</h4>
<p>Restrict video access to members only using our <a href="https://www.wpvideosubscriptions.com/video-memberships/" target="_blank">WP Video Memberships</a> plugin.</p>
</blockquote>

<blockquote>
<h4>VS Netflix Theme</h4>
<p>Display your videos in a Netflix inspired style - <a href="https://www.wpvideosubscriptions.com/wordpress-netflix-theme/" target="_blank">View Theme</a></p>
</blockquote>

<h4>Support</h4>

<p>Additional support for this plugin at https://wpvideosubscriptions.zendesk.com/hc/en-us</p>


== Installation ==

1. Upload the video-sync-for-vimeo folder to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly. You can also download the the video-sync-for-vimeo.zip file at https://www.wpvideosubscriptions.com/download.
2. Activate the plugin through the 'Plugins' screen in WordPress

== Frequently Asked Questions ==

= Why aren't my video pages working? =

Go to Settings -> Permalinks. Then click the Save Changes button at the bottom of the page.

== Screenshots ==


== Changelog ==

= 3.0.8 =

<ul>
    <li>Video Import feature and Player Design deprecated. You can still add Vimeo / YouTube videos by Copy and Pasting URLs into the Video post type settings</li>
</ul>

= 3.0.7 =

<ul>
    <li>CSS stylesheet loading bug fix.</li>
</ul>

= 3.0.6 =

<ul>
    <li>New Class to handle WPVS Video Post Type content output and filtering.</li>
    <li>Video content restricted and filtered by filters instead of different templates / functions.</li>
    <li>Removed /template/rvs-video-template.php. Replaced with Shortcodes and Blocks. See WordPress Theme Development Handbook to build custom Archive and Taxonomy templates.</li>
    <li>Please Update the WP Video Memberships plugin if you're using it.</li>
</ul>

= 3.0.5 =

Fixed a bug that was displaying custom template file directory in custom themes

= 3.0.4 =

Readme file update for new version of WordPress.

= 3.0.3 =

Activation admin page update for WP Video Membership license keys

= 3.0.2 =

WP Videos is no longer required if you are using a WPVS Theme from wpvideosubscriptions.com.

= 3.0.1 =

Autoplay next video update

= 3.0.0 =

Autoplay next video ordering update for Series and Seasons (VS Netflix Theme only)

= 2.9.9 =

Tested up to WordPress version 5.3.2.

= 2.9.8 =

New Videos Setting under WP Videos -> Video Settings -> Single Video Slug to prevent 404 pages on Videos that have not been added to a Genre or Category.

= 2.9.7 =

Admin CSS input updates

= 2.9.6 =

readme update: tested up to WordPress version 5.3

= 2.9.5 =

Check if Vimeo\Vimeo class exists before loading autoload files.

= 2.9.4 =

Hide / Show Related videos in YouTube Player option readded

= 2.9.3 =

Order videos alphabetically

= 2.9.2 =

Website Activation check security update

= 2.9.1 =

Tested up to WordPress version 5.2.0

= 2.9.0 =

New Widget Style option for Recent Videos Widget

= 2.8.9 =

Removed duplicate post editing script

= 2.8.8 =

Fixed a bug where custom player HTML and JS code editor would not load on multisite

= 2.8.7 =

Fixed a bug where custom player HTML and JS code would not save on new video creation

= 2.8.6 =

Playback updates for Vimeo and YouTube: <strong>WP Videos -> Player Design -> Update All Videos (YouTube and Vimeo)</strong>

= 2.8.5 =

New actors and directors fields in REST API JSON response for videos. The new fields include Actors and Directors Names and Slug.

= 2.8.4 =

Custom Player HTML and JS editor fixes

= 2.8.3 =

= 2.8.2 =

Actor and Director Ordering

= 2.8.1 =

WordPress 5.0 Support
YouTube Player Design updates see <a href="https://developers.google.com/youtube/player_parameters#Revision_History" rel="noopener" target="_blank">YouTube Revisions</a> for more information

= 2.8.0 =

Admin updating box notification fix

= 2.7.9 =

Custom video HTML saving fix on Add New video

= 2.7.8 =

Vimeo input reg ex update to match more video URLs

= 2.7.7 =

Vimeo and YouTube input field update

= 2.7.6 =

REST API Access Tokens for WP Video Memberships

= 2.7.5 =

REST API Video information

= 2.7.4 =

Video Information Meta Data: Video Length and Release Date

= 2.7.3 =

Activation SSL fixes

= 2.7.2 =

YouTube Player Design fixes

= 2.7.1 =

Button CSS line-height update

= 2.7.0 =

WPVS Activation Update

= 2.6.9 =

Vimeo imported thumbnails display for new Gutenberg editor

= 2.6.8 =

Update thumbnails function

= 2.6.7 =

Vimeo import updates and thumbnail updates

= 2.6.6 =

Vimeo import updates and thumbnail updates

= 2.6.5 =

REST API Video JSON data updates

= 2.6.4 =

Custom video player HTML and JS editor updates

= 2.6.3 =

Updates to reflect WP Video Memberships optional download link for membership access

= 2.6.2 =

Admin menu updates

= 2.6.1 =

Video archive padding adjustments

= 2.5.9 =

Custom player settings file

= 2.5.8 =

Custom player settings for JS / CSS files and code
Custom video updates

= 2.5.7 =

Video archive template override for themes
Optionally disabled video archive CSS loading

= 2.5.6 =

Vimeo and YouTube player iframe creation fix

= 2.5.5 =

Autoplay redirect fix

= 2.5.4 =

YouTube Play and Trailer button bind to YouTube API fix

= 2.5.3 =

Improved Autoplay feature (now supports Vimeo, YouTube and WordPress videos)
Add Vimeo videos through Vimeo URL

= 2.5.2 =

Updates for WP Video Memberships genre, category, series and seasons sales

= 2.5.1 =

Activation updates

= 2.5.0 =

Missing thumbnail image updates and sizing

= 2.4.8 =

Admin area show error fix

= 2.4.7 =

NEW SHORTCODE VIDEO TYPE Use shortcodes from other plugins as a video.

= 2.4.6 =

Customize Video slug, Genre / Categories, Actors and Directors

= 2.4.5 =

Admin CSS updates and Video Widget thumbnail bug fix

= 2.4.4 =

Activation updates

= 2.4.3 =

Video order column editing updates

= 2.4.2 =

JS and CSS loading updates

= 2.4.1 =

Vimeo importer and loading updates

= 2.4.0 =

Vimeo importer updates post date fix

= 2.3.9 =

Vimeo importer updates

= 2.3.8 =

WP Video Subscriptions access updates

= 2.3.7 =

Video Order (Ascending or Descending)

= 2.3.6 =

Admin Menu Fix

= 2.3.5 =

Video thumbnail layout updates

= 2.3.4 =

Default WordPress video player support

= 2.3.3 =

WP Video Subscriptions Access Updates

= 2.3.2 =

Taxonomy Tax Install fix

= 2.3.1 =

Custom is Tax function

= 2.3.0 =

Actor and Director ordering updates

= 2.2.9 =

Styling adjustments

= 2.2.8 =

Error details for activating WP Video Subscriptions site

= 2.2.7 =

Display Actors, Directors and Genres below video

= 2.2.6 =

WP Video Subscriptions Activation JS fix

= 2.2.4 =

WP Video Subscriptions Activation

= 2.2.3 =

Admin menu style updates

= 2.2.2 =

Support for additional thumbnail image (VS NETFLIX THEME)

= 2.1.9 =

Video type managment updates. Support for Trailer (Netflix Theme)

= 2.1.7 =

New Video uploading updates, Vimeo video select (search), Single Video edting updates.

= 2.1.5 =
Import update for if videos are missing thumbnails

= 2.1.4 =
Stylesheet enqueue update

= 2.1.3 =
YouTube Video Player Customizer

= 2.1.2 =
Old vimeo id updating

= 2.1.1 =
Improved Vimeo importing

= 2.1.0 =
Check for PHP Version 5.5 before activating

= 2.0.8 =
Bug fix for Vimeo import count
Autoplay next video in series (Vimeo videos only)

= 2.0.7 =
Updated support for VS Netflix theme

= 2.0.4 =
* Video syncing bug fix

= 2.0.3 =
* Fix for PHP 5.3 - sync error fixed

= 2.0.2 =
* Fix for PHP 5.3

= 2.0.1 =
* Activation fix

= 2.0.0 =
* Small adjustments

= 1.2.4 =
* Add a top margin to video gallery pages
* Change the background colour of the video gallery

= 1.2.3 =
* Support for YouTube and custom embed option
* Vimeo Uploader fix

= 1.2.2 =
* Tag and Category archive bug fix

= 1.2.1 =
* Order videos

= 1.1 =
* Automatically syncs video thumbnail images
* Video archive, category and tag pages use grid view for displaying videos

= 1.0 =
* Release

== Upgrade Notice ==

= 3.0.1 =

Autoplay next video update

= 3.0.0 =

Autoplay next video ordering update for Series and Seasons (VS Netflix Theme only)

= 2.9.9 =

Tested up to WordPress version 5.3.2.

= 2.9.8 =

New Videos Setting under WP Videos -> Video Settings -> Single Video Slug to prevent 404 pages on Videos that have not been added to a Genre or Category.

= 2.9.7 =

Admin CSS input updates

= 2.9.6 =

readme update: tested up to WordPress version 5.3

= 2.9.5 =

Check if Vimeo\Vimeo class exists before loading autoload files.

= 2.9.4 =

Hide / Show Related videos in YouTube Player option readded

= 2.9.3 =

Order videos alphabetically

= 2.9.2 =

Website Activation check security update

= 2.9.1 =

Tested up to WordPress version 5.2.0

= 2.9.0 =

New Widget Style option for Recent Videos Widget

= 2.8.9 =

Removed duplicate post editing script

= 2.8.8 =

Fixed a bug where custom player HTML and JS code editor would not load on multisite

= 2.8.7 =

Fixed a bug where custom player HTML and JS code would not save on new video creation

= 2.8.6 =

Playback updates for Vimeo and YouTube: <strong>WP Videos -> Player Design -> Update All Videos (YouTube and Vimeo)</strong>

= 2.8.5 =

New actors and directors fields in REST API JSON response for videos. The new fields include Actors and Directors Names and Slug.

= 2.8.4 =

Custom Player HTML and JS editor fixes

= 2.8.3 =

= 2.8.2 =

Actor and Director Ordering

= 2.8.1 =

WordPress 5.0 Support
YouTube Player Design updates see <a href="https://developers.google.com/youtube/player_parameters#Revision_History" rel="noopener" target="_blank">YouTube Revisions</a> for more information

= 2.8.0 =

Admin updating box notification fix

= 2.7.9 =

Custom video HTML saving fix on Add New video

= 2.7.8 =

Vimeo input reg ex update to match more video URLs

= 2.7.7 =

Vimeo and YouTube input field update

= 2.7.6 =

REST API Access Tokens for WP Video Memberships

= 2.7.5 =

REST API Video information


= 2.7.4 =

Video Information Meta Data: Video Length and Release Date

= 2.7.3 =

Activation SSL fixes

= 2.7.2 =

YouTube Player Design fixes

= 2.7.1 =

Button CSS line-height update

= 2.7.0 =

WPVS Activation Update

= 2.6.9 =

Vimeo imported thumbnails display for new Gutenberg editor

= 2.6.8 =

Update thumbnails function

= 2.6.7 =

Vimeo import updates and thumbnail updates

= 2.6.6 =

Vimeo import updates and thumbnail updates

= 2.6.5 =

REST API Video JSON data updates

= 2.6.4 =

Custom video player HTML and JS editor updates

= 2.6.3 =

Updates to reflect WP Video Memberships optional download link for membership access

= 2.6.2 =

Admin menu updates

= 2.6.1 =

Video archive padding adjustments

= 2.5.9 =

Custom player settings file

= 2.5.8 =

Custom player settings for JS / CSS files and code
Custom video updates

= 2.5.7 =

Video archive template override for themes
Optionally disabled video archive CSS loading

= 2.5.6 =

Vimeo and YouTube player iframe creation fix

= 2.5.5 =

Autoplay redirect fix

= 2.5.4 =

YouTube Play and Trailer button bind to YouTube API fix

= 2.5.3 =

Improved Autoplay feature (now supports Vimeo, YouTube and WordPress videos)
Add Vimeo videos through Vimeo URL

= 2.5.2 =

Updates for WP Video Memberships genre, category, series and seasons sales

= 2.5.1 =

Activation updates

= 2.5.0 =

Missing thumbnail image updates and sizing

= 2.4.8 =

Admin area show error fix

= 2.4.7 =

NEW SHORTCODE VIDEO TYPE Use shortcodes from other plugins as a video.

= 2.4.6 =

Customize Video slug, Genre / Categories, Actors and Directors

= 2.4.5 =

Admin CSS updates and Video Widget thumbnail bug fix

= 2.4.4 =

Activation updates

= 2.4.3 =

Video order column editing updates

= 2.4.2 =

JS and CSS loading updates

= 2.4.1 =

Vimeo importer and loading updates

= 2.4.0 =

Vimeo importer updates post date fix

= 2.3.9 =

Vimeo importer updates

= 2.3.8 =

WP Video Subscriptions access updates

= 2.3.7 =

Video Order (Ascending or Descending)

= 2.3.6 =

Admin Menu Fix

= 2.3.5 =

Video thumbnail layout updates

= 2.3.4 =

Default WordPress video player support

= 2.3.3 =

WP Video Subscriptions Access Updates

= 2.3.2 =

Taxonomy Tax Install fix

= 2.3.1 =

Custom is Tax function

= 2.3.0 =

Actor and Director ordering updates

= 2.2.9 =

Styling adjustments

= 2.2.8 =

Error details for activating WP Video Subscriptions site

= 2.2.7 =

Display Actors, Directors and Genres below video

= 2.2.6 =

WP Video Subscriptions Activation JS fix

= 2.2.4 =

WP Video Subscriptions Activation

= 2.2.3 =

Admin menu style updates

= 2.2.2 =

Support for additional thumbnail image (VS NETFLIX THEME)

= 2.1.9 =

Video type managment updates. Support for Trailer (Netflix Theme)

= 2.1.7 =

New Video uploading updates, Vimeo video select (search), Single Video edting updates.

= 2.1.5 =
Import update for if videos are missing thumbnails

= 2.1.4 =
Stylesheet enqueue update

= 2.1.3 =
YouTube Video Player Customizer

= 2.1.2 =
Old vimeo id updating

= 2.1.1 =
Improved Vimeo importing

= 2.1.0 =
Check for PHP Version 5.5 before activating

= 2.0.8 =
Bug fix for Vimeo import count
Autoplay next video in series (Vimeo videos only)

= 2.0.7 =
Updated support for VS Netflix theme

= 2.0.4 =
* Video syncing bug fix

= 2.0.3 =
* Fix for PHP 5.3 - sync error fixed

= 2.0.2 =
* Fix for PHP 5.3

= 2.0.1 =
* Activation fix

= 2.0.0 =
* Small adjustments

= 1.2.4 =
* Add a top margin to video gallery pages
* Change the background colour of the video gallery

= 1.2.3 =
* Support for YouTube and custom embed option
* Vimeo Uploader fix

= 1.2.2 =
* Order videos

= 1.1 =
Upgrade for a better video layout. NOTE: Re-Sync videos to add thumbnail images to all current videos. No need to delete current videos, just hit the Sync Videos button again and thumbnails will be added to their respective videos.

= 1.0 =
Release

== Features ==

2. Add Videos using Vimeo urls
3. Add Videos using YouTube urls
4. Add Videos using shortcodes
5. Add Videos using the default WordPress player</li>
6. Add Videos using custom player embed HTML and JS code
8. Video Categories / Genres (customizable name, slug and icon)
9. Video Actors (customizable name, slug and icon)
10. Video Directors (customizable name, slug and icon)
12. Video Tags
13. Restrict video access (Requires Membership Add-On)
