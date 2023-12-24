<?php

class WPVS_ADDONS_ACTIVATION_MANAGER {
    public function __construct() {

        add_action( 'wp_ajax_wpvs_vimeosync_activate_customer_access', array($this, 'wpvs_vimeosync_activate_customer_access') );
        add_action( 'wp_ajax_wpvs_vimeosync_deactivate_customer_access', array($this,'wpvs_vimeosync_deactivate_customer_access') );

        if( ! get_option('is-wp-videos-multi-site')) {
            add_action( 'admin_init', array($this,'wpvs_check_customer_license_keys') );
        }
    }

    private function wpvs_activation_request($request_url) {
        if( current_user_can('manage_options') ) {
            $activation_curl = curl_init();
            curl_setopt_array($activation_curl, array(
                CURLOPT_URL => $request_url,
                CURLOPT_RETURNTRANSFER => true
            ));
            $wpvs_license_key_json = curl_exec($activation_curl);
            if(curl_error($activation_curl)){
                $error_message = curl_error($activation_curl);
                return array('error' => $error_message);
            }
            curl_close($activation_curl);
            return json_decode($wpvs_license_key_json, true);
        }
    }

    private function handle_ajax_error($error_message, $error_code) {
        status_header($error_code);
        echo $error_message;
        exit;
    }

    public function wpvs_vimeosync_activate_customer_access() {
        if( current_user_can('manage_options') ) {
            if ( isset($_POST['email']) && ! empty($_POST['email']) && isset($_POST['license_key']) && !empty($_POST['license_key']) ) {
                $wpvs_user_email = urlencode($_POST['email']);
                $wpvs_license_key = urlencode($_POST['license_key']);
                $wpvs_license_key_type = urlencode($_POST['license_type']);
                $this_site_url = urlencode(get_bloginfo('url'));
                $activation_url = 'https://www.wpvideosubscriptions.com/?wpvs-license-key-activation=wpva&wpvs_email='.$wpvs_user_email.'&wpvs_license_key='.$wpvs_license_key.'&site='.$this_site_url;
                $wpvs_license_key_data = $this->wpvs_activation_request($activation_url);


                if( isset($wpvs_license_key_data['license_key_is_valid']) && $wpvs_license_key_data['license_key_is_valid'] ) {
                    if( isset($wpvs_license_key_data['license_key_product']) ) {

                        if( $wpvs_license_key_type == 'plugin' && $wpvs_license_key_data['license_key_product'] != 'vimeo-sync-memberships' ) {
                            $error_message = __('That license key is not for the WP Video Memberships plugin.', 'vimeosync');
                            $this->handle_ajax_error($error_message, 400);
                        }
                    }

                    update_option('wpvs_username_email_activation', sanitize_email($_POST['email']));
                    $new_license_key_data = array(
                        'license_key'  => sanitize_text_field($_POST['license_key']),
                        'is_valid'     => true,
                        'type'         => $wpvs_license_key_type,
                        'product'      => $wpvs_license_key_data['license_key_product'],
                        'expires'      => $wpvs_license_key_data['license_key_expires'],
                        'check_update' =>  false,
                    );
                    if( $wpvs_license_key_type == 'plugin' ) {
                        update_option('wpvs_account_plugin_license_key', $new_license_key_data);
                    }
                } else {
                    $new_license_key_data = array(
                        'license_key'  => sanitize_text_field($_POST['license_key']),
                        'is_valid'     => false,
                        'type'         => $wpvs_license_key_type,
                        'product'      => "",
                        'expires'      => "",
                        'check_update' =>  false
                    );

                    if( $wpvs_license_key_type == 'plugin' ) {
                        update_option('wpvs_account_plugin_license_key', $new_license_key_data);
                    }

                    if( ! empty($wpvs_license_key_data['error']) ) {
                        if($wpvs_license_key_data['error'] == "site_activation_failed") {
                            $error_message = __('Unable to activate your website. Make sure this license key has not already been activated on another URL', 'vimeosync');
                        }

                        if($wpvs_license_key_data['error'] == "user_not_found") {
                            $error_message = __('A user with that Email does not exist', 'vimeosync');
                        }

                        if($wpvs_license_key_data['error'] == "license_key_expired") {
                            $error_message = 'You license key is expired. <a href="https://www.wpvideosubscriptions.com/account/subscriptions" target="_blank">Check you active subscriptions and license keys</a>';
                        }
                    } else {
                        $error_message = __('Something went wrong activating your website', 'vimeosync');
                    }
                    $this->handle_ajax_error($error_message, 400);
                }
            }
        }
        wp_die();
    }


    public function wpvs_vimeosync_deactivate_customer_access() {
        if( current_user_can('manage_options') ) {
            if ( isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['license_key']) && !empty($_POST['license_key']) ) {
                $wpvs_user_email = urlencode($_POST['email']);
                $wpvs_license_key = urlencode($_POST['license_key']);
                $wpvs_license_key_type = urlencode($_POST['license_type']);
                $this_site_url = urlencode(get_bloginfo('url'));
                $deactivation_url = 'https://www.wpvideosubscriptions.com/?wpvs-license-key-activation=wpva&wpvs_email='.$wpvs_user_email.'&wpvs_license_key='.$wpvs_license_key.'&site='.$this_site_url.'&deactivate=1';
                $site_deactivated = $this->wpvs_activation_request($deactivation_url);
                $update_license_key_data = array(
                    'license_key'  => "",
                    'is_valid'     => false,
                    'type'         => $wpvs_license_key_type,
                    'product'      => "",
                    'expires'      => "",
                    'check_update' =>  false
                );

                if( $wpvs_license_key_type == 'plugin' ) {
                    update_option('wpvs_account_plugin_license_key', $update_license_key_data);
                }
            }
        }
        wp_die();
    }

    public function wpvs_check_customer_license_keys() {
        $current_time = current_time('timestamp', 0);
        $wpvs_account_plugin_license = get_option('wpvs_account_plugin_license_key');

        if( ! empty($wpvs_account_plugin_license) ) {
            if( isset($wpvs_account_plugin_license['expires']) && $wpvs_account_plugin_license['expires'] <=  $current_time ) {
                $this->check_wpvs_product_license($wpvs_account_plugin_license);
            }
        }
    }


    private function check_wpvs_product_license($wpvs_license) {
        $error_message = "";
        if( ! isset($wpvs_license['check_update']) || $wpvs_license['check_update'] == false ) {
            $wpvs_license_key_type = $wpvs_license['type'];
            $wpvs_license_key = $wpvs_license['license_key'];
            $wpvs_user_email = urlencode(get_option('wpvs_username_email_activation'));
            $this_site_url = urlencode(get_bloginfo('url'));
            $check_license_url = 'https://www.wpvideosubscriptions.com/?wpvs-license-key-activation=wpva&wpvs_email='.$wpvs_user_email.'&wpvs_license_key='.$wpvs_license_key.'&site='.$this_site_url.'&check=1';

            $wpvs_license_key_data = $this->wpvs_activation_request($check_license_url);
            if( isset($wpvs_license_key_data['license_key_is_valid']) && $wpvs_license_key_data['license_key_is_valid'] ) {
                $wpvs_license['is_valid'] = true;
                $wpvs_license['expires'] = $wpvs_license_key_data['license_key_expires'];
                $wpvs_license['check_update'] = false;
            } else {
                $wpvs_license['is_valid'] = false;
                $wpvs_license['check_update'] = true;
            }

            if( $wpvs_license_key_type == 'plugin' ) {
                update_option('wpvs_account_plugin_license_key', $wpvs_license);
            }
        }
    }
}
$wpvs_addons_activation_manager = new WPVS_ADDONS_ACTIVATION_MANAGER();
