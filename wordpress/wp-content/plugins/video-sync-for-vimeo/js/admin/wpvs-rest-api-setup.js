jQuery(document).ready(function() {
    jQuery('#show-wpvs-rest-secret').click( function() {
        var show_button = jQuery(this);
        if( show_button.hasClass('show') ) {
            jQuery('#wpvs_rest_api_secret').attr('type', 'password');
            show_button.removeClass('show').text('Show Secret');
        } else {
            jQuery('#wpvs_rest_api_secret').attr('type', 'text');
            show_button.addClass('show').text('Hide Secret');
        }
    });
});
