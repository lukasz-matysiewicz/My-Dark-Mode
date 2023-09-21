<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

function my_dark_mode_license_callback() {
    // Retrieve the license from the database
    $license = get_option('my_dark_mode_license');

    // Get the license status
    $license_status = my_dark_mode_get_license_status($license);

    // Nonce field
    $nonce = wp_create_nonce('my_dark_mode_nonce');

    // Start the HTML output
    ?>
    <div class="mdm-container">
        <!-- License input and status -->
        <div>
            <input id="my_dark_mode_license" name="my_dark_mode_license" type="text" value="<?php echo esc_attr($license); ?>" placeholder="Enter License" />
            <span id="license-status"><?php echo esc_html($license_status); ?></span>
        </div>

        <!-- Buttons -->
        <div>
            <input type="button" id="add-license-button" class="button" value="Add License" />
            <input type="button" id="remove-license-button" class="button" value="Remove License" />
        </div>

        <!-- Result -->
        <div>
            <span id="license-check-result"></span>
        </div>

        <!-- Nonce Field -->
        <input type="hidden" id="my_dark_mode_nonce_field" value="<?php echo esc_attr($nonce); ?>" />
    </div>
    <?php
}


function my_dark_mode_get_license_status($license) {
    // Assume the license is invalid
    $status = 'Not Active';

    // Check the license validity via API call
    $response = wp_remote_post( 'https://wpspacecrafters.com/wp-json/my-dark-mode/v1/check-license/', array(
        'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
        'body' => json_encode(array('license' => $license)),
        'method' => 'POST',
        'data_format' => 'body',
    ));

    // If the API call was successful, check the response
    if ( !is_wp_error( $response ) ) {
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body );
        if ( $data->status === 'valid' ) {
            $status = 'Active';

            // Check if the license has expired
            if (isset($data->expiry_date)) {
                $current_date = new DateTime();
                $expiry_date = new DateTime($data->expiry_date);

                if ($current_date > $expiry_date) {
                    $status = 'Expired';
                }
            }
        }
    }

    return $status;
}


function my_dark_mode_check_license_ajax() {
    // Check nonce validity
    check_ajax_referer('my_dark_mode_nonce', 'nonce', true);


    // Retrieve the license from the request
    $license = sanitize_text_field($_POST['license']);

    // Assume the license is invalid
    $is_valid = false;

    // Check the license validity via API call
    $response = wp_remote_post( 'https://wpspacecrafters.com/wp-json/my-dark-mode/v1/check-license/', array(
        'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
        'body' => json_encode(array(
            'license' => $license,
            'user_id' => get_current_user_id() // Or however you're determining the user on the client side
        )),
        'method' => 'POST',
        'data_format' => 'body',
    ));

        // If the API call was successful, check the response
        // If the API call was successful, check the response
    if ( !is_wp_error( $response ) ) {
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body );

        // Check if the 'status' property exists in the $data object.
        $is_valid = isset($data->status) && $data->status === 'valid';

        if ($is_valid) {
            // You can now handle the additional data from the server
            $expiry_date = isset($data->expiry_date) ? $data->expiry_date : null;
            $active_websites_count = isset($data->active_websites_count) ? $data->active_websites_count : null;

            // Display the data or store it, as required
            // ...

            echo 'The license is valid.';
        } else {
            echo 'The license is invalid.';

            if (isset($data->expiry_date)) {
                $current_date = new DateTime();
                $expiry_date = new DateTime($data->expiry_date);

                if ($current_date > $expiry_date) {
                    echo ' The license has expired.';
                }
            }
        }
    } else {
        echo 'An error occurred while checking the license.';
    }
    

    // Always die in functions echoing AJAX content
    wp_die();
}

add_action('wp_ajax_check_license', 'my_dark_mode_check_license_ajax');

function my_dark_mode_remove_license_ajax() {
    // Check nonce validity
    check_ajax_referer('my_dark_mode_nonce', 'nonce', true);
    delete_option('my_dark_mode_license');

    echo 'The license has been removed.';
    die();
}

add_action('wp_ajax_remove_license', 'my_dark_mode_remove_license_ajax');


function my_dark_mode_save_license_ajax() {
    // Check nonce validity
    check_ajax_referer('my_dark_mode_nonce', 'nonce', true);

    // Check if 'license' is set in $_POST
    if (isset($_POST['license'])) {
        $license = sanitize_text_field($_POST['license']);

        // Save the license to the database
        update_option('my_dark_mode_license', $license);
        echo 'License key saved.';
    } else {
        echo 'License key not provided.';
    }

    // Always die in functions echoing AJAX content
    wp_die();
}


add_action('wp_ajax_save_license', 'my_dark_mode_save_license_ajax');
