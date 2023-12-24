jQuery(document).ready(function() {
    jQuery('#rvs-dropdown-menu').click( function() {
        jQuery('#rvs-admin-menu').slideToggle();
    });

    jQuery('body').delegate('.wpvs-activate-site-button', 'click',  function() {
        wpvs_admin_js_activate_website_request(jQuery(this));
    });

    jQuery('.wpvs-open-icon-set').click(function() {
        var this_update_button = jQuery(this);
        var icon_box = this_update_button.next('.wpvs-icon-set').slideDown();
    });

    jQuery('.wpvs-dashicon-option').click(function() {
        var selected_icon = jQuery(this);
        var parent_icon_box = selected_icon.parents('.wpvs-icon-set');
        var icon_input = parent_icon_box.find('.wpvs-icon-update-input');
        var update_icon_box = parent_icon_box.prev('.wpvs-open-icon-set').find('.wpvs-icon-update');
        var set_new_icon = selected_icon.find('.badge').html();
        var new_span_icon_html = '<span class="dashicons dashicons-'+set_new_icon+'"></span>';
        icon_input.val(set_new_icon);
        update_icon_box.html(new_span_icon_html);
    });

});

function wpvs_admin_js_activate_website_request(activate_button) {
    jQuery('.rvs-activation-errors').html("").hide();
    var activation_update_box = activate_button.parent();
    var activate_product_type = activate_button.data('type');
    var activation_action = activate_button.data('action');
    var wpvs_do_activation_ajax = 'wpvs_vimeosync_activate_customer_access';

    if( activation_action == 'deactivate' ) {
        wpvs_do_activation_ajax = 'wpvs_vimeosync_deactivate_customer_access';
    }

    if( ! wpvs_check_customer_site_activation_fields(activate_product_type) ) {
        if( activation_action == 'activate' ) {
            activate_button.html('<span class="rvs-spin dashicons dashicons-update"></span> Activating...');
        }
        if( activation_action == 'deactivate' ) {
            activate_button.html('<span class="rvs-spin dashicons dashicons-update"></span> Deactivating...');
        }

        var wpvs_user_email = jQuery('#wpvs-user-email-address').val();

        if( activate_product_type == 'plugin' ) {
            var wpvs_license_key = jQuery('#wpvs-enter-plugin-license-key').val();
        }

        jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                'action': wpvs_do_activation_ajax,
                'email': wpvs_user_email,
                'license_key': wpvs_license_key,
                'license_type': activate_product_type
            },
            success:function(response) {
                activate_button.remove();
                if( activation_action == 'activate' ) {
                    activation_update_box.html('<label class="wpvs-activate-site-button rvs-button rvs-error-button" data-type="'+activate_product_type+'" data-action="deactivate">Deactivate</label>');
                }
                if( activation_action == 'deactivate' ) {
                    activation_update_box.html('<label class="wpvs-activate-site-button rvs-button" data-type="'+activate_product_type+'" data-action="activate">Activate</label>');
                }
            },
            error: function(response){
                show_rvs_error(response.responseText);
                jQuery('.rvs-activation-errors').html(response.responseText).show();
                if( activation_action == 'activate' ) {
                    activation_update_box.html('<label class="wpvs-activate-site-button rvs-button" data-type="'+activate_product_type+'" data-action="activate">Activate</label>');
                }
                if( activation_action == 'deactivate' ) {
                    activation_update_box.html('<label class="wpvs-activate-site-button rvs-button rvs-error-button" data-type="'+activate_product_type+'" data-action="deactivate">Deactivate</label>');
                }
            }
        });
    }
}

function wpvs_check_customer_site_activation_fields(product_type) {
    var field_errors = false;

    jQuery('.rvs-edit-form input').removeClass('rvs-field-error');

    var wpvs_user_email = jQuery('#wpvs-user-email-address');

    if( product_type == 'plugin' ) {
        var wpvs_license_key = jQuery('#wpvs-enter-plugin-license-key');
    }

    if(wpvs_user_email.val() == "") {
        wpvs_user_email.addClass('rvs-field-error');
        field_errors = true;
    }

    if(wpvs_license_key.val() == "") {
        wpvs_license_key.addClass('rvs-field-error');
        field_errors = true;
    }

    return field_errors;
}
