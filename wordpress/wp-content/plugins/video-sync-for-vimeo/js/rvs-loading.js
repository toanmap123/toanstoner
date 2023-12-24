jQuery(document).ready(function() {
    jQuery('body').append('<div id="wpvs-updating-box" class="rvs-fixed-box"><div id="rvs-error" class="rvs-fixed-error wpvs-update-content"><p id="rvs-error-message">This is an error message</p><label id="rvs-close-error"><span class="dashicons dashicons-no-alt"></span></label></div><div id="wpvs-updating-text" class="wpvs-update-content"><span id="wpvs-update-text" class="wpvs-loading-text">Updating...</span><span class="loadingCircle"></span><span class="loadingCircle"></span><span class="loadingCircle"></span><span class="loadingCircle"></span></div></div>');
    
    jQuery('body').delegate('#rvs-close-error', 'click', function() {
        jQuery('#wpvs-updating-box').fadeOut('fast');
    });
});

function show_rvs_error(error_message) {
    jQuery('#rvs-error-message').html(error_message);
    jQuery('#wpvs-updating-text').hide();
    jQuery('#rvs-error').show();
    jQuery('#wpvs-updating-box').fadeIn('fast');
}

function show_rvs_updating(update_message) {
    if(update_message == null || update_message == "") {
        update_message = "Updating...";
    }
    jQuery('#rvs-error').hide();
    jQuery('#wpvs-updating-text').find('#wpvs-update-text').html(update_message);
    jQuery('#wpvs-updating-text').show();
    jQuery('#wpvs-updating-box').fadeIn('fast');
}

