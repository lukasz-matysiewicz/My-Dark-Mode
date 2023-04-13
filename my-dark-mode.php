<?php
/*
Plugin Name: My Dark Mode
Plugin URI: https://matysiewicz.studio/my-dark-mode
Description: A Lightweight plugin to enable dark mode on your WordPress site.
Version: 1.0
Author: Matys
Author URI: https://matysiewicz.studio
License: GPL2
*/


//register assets
function my_dark_mode_enqueue_scripts() {

    // Enqueue the dark-mode.css file
    wp_enqueue_style('my-dark-mode-css', plugin_dir_url(__FILE__) . 'assets/css/dark-mode.css', array(), '1.0', 'all');

    // Enqueue the switchers.css file for both admin and front-end
    wp_enqueue_style('my-dark-mode-switchers-css', plugin_dir_url(__FILE__) . 'assets/css/switchers.css', array(), '1.0', 'all');

    wp_enqueue_script('my-dark-mode-js', plugin_dir_url(__FILE__) . 'assets/js/dark-mode.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'my_dark_mode_enqueue_scripts', 1);

// create setting page
function my_dark_mode_admin_menu() {
    add_menu_page(
        '<h1>My Dark Mode Settings<h1>',
        'My Dark Mode',
        'manage_options',
        'my-dark-mode',
        'my_dark_mode_settings_page',
        plugin_dir_url( __FILE__ ) . 'assets/img/my-dark-mode.svg',
        6
    );
}
add_action('admin_menu', 'my_dark_mode_admin_menu');

function my_dark_mode_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_GET['settings-updated'])) {
        add_settings_error('my_dark_mode_messages', 'my_dark_mode_message', __('Settings Saved', 'my-dark-mode'), 'updated');
    }

    settings_errors('my_dark_mode_messages');
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="<?php echo admin_url('options.php'); ?>" method="post">
            <input type="hidden" name="action" value="admin_post_save_my_dark_mode_settings">
            <?php wp_nonce_field('my_dark_mode_nonce'); ?>
            <?php
            settings_fields('my_dark_mode');
            do_settings_sections('my_dark_mode');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

function my_dark_mode_save_settings() {
    check_admin_referer('my_dark_mode_nonce');

    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    update_option('my_dark_mode_button_code', $_POST['my_dark_mode_button_code']);
    update_option('my_dark_mode_custom_css', $_POST['my_dark_mode_custom_css']);

    wp_redirect(admin_url('admin.php?page=my-dark-mode&settings-updated=true'));
    exit;
}
add_action('admin_post_save_my_dark_mode_settings', 'my_dark_mode_save_settings');


function my_dark_mode_custom_css_callback() {
    $custom_css = get_option('my_dark_mode_custom_css');
    ?>
    <div>Use this prefix to target elements: <strong>body[my-dark-mode='light'].your_class</strong> or <strong>body[my-dark-mode='dark'].your_class</strong></div>
    <textarea id="my_dark_mode_custom_css" name="my_dark_mode_custom_css" rows="5" cols="50"><?php echo esc_textarea($custom_css); ?></textarea>
    <?php
}

function my_dark_mode_section_callback() {
    ?>
    <div>Use those fields to customize My Dark Mode Styles.</div>
    <?php
}

//global variables
function get_dark_mode_settings() {
    $switcher = get_option('my_dark_mode_switcher', 'no_switcher');
    $default_button_code = '<div class="mode-single-switch-border"><input type="checkbox" id="mode-switch-single" data-dark-mode-toggle aria-label="Toggle Dark Mode"><label for="mode-switch-single" class="mode-label-single"><div class="toggle"></div><div class="names"><p class="light">Light</p><p class="dark">Dark</p></div></label></div>';
    $button_code = get_option('my_dark_mode_button_code', $default_button_code);

    $switcher1_html = '
    <div class="mode-switch-border">
        <input type="checkbox" id="mode-switch" data-dark-mode-toggle aria-label="Toggle Dark Mode">
        <label for="mode-switch" class="mode-label">
        <div class="toggle"></div>
        <div class="names">
            <p class="light">Light</p>
            <p class="dark">Dark</p>
        </div>
        </label>
    </div>';

    $switcher2_html = '
    <div class="circle-switch-border">
        <input type="checkbox" id="circle-switch" data-dark-mode-toggle aria-label="Toggle Dark Mode">
        <label for="circle-switch" class="circle-label">
        <div class="circle">
            <div class="crescent"></div>
        </div>
        </label>
    </div>';

    return array(
        'switcher' => $switcher,
        'default_button_code' => $default_button_code,
        'button_code' => $button_code,
        'switcher1_html' => $switcher1_html,
        'switcher2_html' => $switcher2_html
    );
}

function my_dark_mode_button_code_callback() {
    $settings = get_dark_mode_settings();
    $button_code = $settings['button_code'];
    $default_button_code = $settings['default_button_code'];
    ?>
    <div><strong>IMPORTANT:</strong> please use button attribute: <strong>data-dark-mode-toggle</strong></br></br>
    To use dark mode button on your website use <strong>widget</strong> or this shortcode: <strong>[my_dark_mode_toggle_button]</strong></br></br>If you are not fluent with html,css and need help customize button please use this customizer: <a href="https://codebeautify.org/html-button-generator">https://codebeautify.org/html-button-generator</a></div>
    <textarea id="my_dark_mode_button_code" name="my_dark_mode_button_code" rows="5" cols="50"><?php echo esc_textarea($button_code); ?></textarea>
    <br>
    <button type="button" id="my_dark_mode_reset_button" class="button">Reset Button Code</button>
    <script>
    document.getElementById('my_dark_mode_reset_button').addEventListener('click', function() {
        var defaultButtonCode = '<?php echo addslashes(str_replace("\n", "", $default_button_code)); ?>';
            myDarkModeEditor.codemirror.setValue(defaultButtonCode);
    });
    </script>
    <?php
}

function my_dark_mode_switcher_section_callback(){
    $settings = get_dark_mode_settings();
    $switcher = $settings['switcher'];
    $button_code = $settings['button_code'];
    ?>
    <div>
        Current button look:
    </div>
    <?php

    if($switcher == 'no_switcher'){
        echo $settings['button_code'];
    }
    if($switcher == 'switcher1'){
        echo $settings['switcher1_html'];
    }
    if($switcher == 'switcher2'){
        echo $settings['switcher2_html'];
    }


    ?>
    <div>
        <label>
            <input type="radio" name="my_dark_mode_switcher" value="no_switcher" <?php checked($switcher, 'no_switcher'); ?>>
            No Switcher (use custom button code)
        </label>
    </div>
    <div>
        <label>
            <input type="radio" name="my_dark_mode_switcher" value="switcher1" <?php checked($switcher, 'switcher1'); ?>>
            Switcher 1
        </label>
        <div>
            Preview:
            <?php echo $settings['switcher1_html']; ?>
        </div>
    </div>
    <div>
        <label> 
            <input type="radio" name="my_dark_mode_switcher" value="switcher2" <?php checked($switcher, 'switcher2'); ?>>
            Switcher 2
        </label>
        <div>
            Preview:
            <?php echo $settings['switcher2_html']; ?>
        </div>
    </div>
<?php
}

function my_dark_mode_logo_callback() {
    $light_logo = get_option('my_dark_mode_light_logo', '');
    $dark_logo = get_option('my_dark_mode_dark_logo', '');
    ?>
    <div>
        <input type="button" class="button" id="my_dark_mode_light_logo_button" value="Upload Light Logo">
        <input type="hidden" id="my_dark_mode_light_logo" name="my_dark_mode_light_logo" value="<?php echo esc_attr($light_logo); ?>">
    </div>
    <div id="my_dark_mode_light_logo_preview" style="display: inline-block; vertical-align: top;">
        <?php if (!empty($light_logo)): ?>
            <img src="<?php echo esc_url($light_logo); ?>" style="max-width: 100px;">
            <button type="button" class="remove_image_button" data-target-id="my_dark_mode_light_logo" style="display: block;">X</button>
        <?php endif; ?>
    </div>
    <br>
    <div>
        <input type="button" class="button" id="my_dark_mode_dark_logo_button" value="Upload Dark Logo">
        <input type="hidden" id="my_dark_mode_dark_logo" name="my_dark_mode_dark_logo" value="<?php echo esc_attr($dark_logo); ?>">
    </div>
    <div id="my_dark_mode_dark_logo_preview" style="display: inline-block; vertical-align: top;">
        <?php if (!empty($dark_logo)): ?>
            <img src="<?php echo esc_url($dark_logo); ?>" style="max-width: 100px;">
            <button type="button" class="remove_image_button" data-target-id="my_dark_mode_dark_logo" style="display: block;">X</button>
        <?php endif; ?>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var custom_uploader_light, custom_uploader_dark;

        // Function to remove the image preview
        function removeImagePreview(target_input_id) {
            $('#' + target_input_id + '_preview').html('');
            $('#' + target_input_id).val('');
        }

        // Click event handler for the remove image button
        $('.remove_image_button').click(function(e) {
            e.preventDefault();
            var target_input_id = $(this).data('target-id');
            removeImagePreview(target_input_id);
        });

        // Function for handling the upload button click event
        function handleUploadButtonClick(target_input_id, custom_uploader) {
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });

            custom_uploader.on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#' + target_input_id).val(attachment.url);
                $('#' + target_input_id + '_preview').html('<img src="' + attachment.url + '" style="max-width: 100px;"><button type="button" class="remove_image_button" data-target-id="' + target_input_id + '" style="display: block;">X</button>');

                $('.remove_image_button').unbind('click');
                $('.remove_image_button').click(function(e) {
                    e.preventDefault();
                    var target_input_id = $(this).data('target-id');
                    removeImagePreview(target_input_id);
                });
            });

            custom_uploader.open();
        }

        // Click event handler for the light logo upload button
        $('#my_dark_mode_light_logo_button').click(function(e) {
            e.preventDefault();
            handleUploadButtonClick('my_dark_mode_light_logo', custom_uploader_light);
        });

        // Click event handler for the dark logo upload button
        $('#my_dark_mode_dark_logo_button').click(function(e) {
            e.preventDefault();
            handleUploadButtonClick('my_dark_mode_dark_logo', custom_uploader_dark);
        });
    });
    </script>
    <?php
}
register_setting('my_dark_mode', 'my_dark_mode_light_logo');
register_setting('my_dark_mode', 'my_dark_mode_dark_logo');

function replace_default_logo_with_custom_logo() {
    $light_logo_url = get_option('my_dark_mode_light_logo', '');
    $dark_logo_url = get_option('my_dark_mode_dark_logo', '');

    if (!empty($light_logo_url) || !empty($dark_logo_url)) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var logoImage = document.querySelector('.custom-logo');
            var originalLogoSrc = logoImage ? logoImage.src : '';
            var body = document.querySelector('body');

            function updateLogoSrc() {
                if (logoImage) {
                    var darkMode = body.getAttribute('my-dark-mode') === 'dark';

                    if (darkMode && '<?php echo esc_url($dark_logo_url); ?>' !== '') {
                        logoImage.src = '<?php echo esc_url($dark_logo_url); ?>';
                    } else if (!darkMode && '<?php echo esc_url($light_logo_url); ?>' !== '') {
                        logoImage.src = '<?php echo esc_url($light_logo_url); ?>';
                    } else {
                        logoImage.src = originalLogoSrc;
                    }
                }
            }

            updateLogoSrc();

            if (window.MutationObserver) {
                var observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.attributeName === 'my-dark-mode') {
                            updateLogoSrc();
                        }
                    });
                });

                observer.observe(body, { attributes: true });
            }
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'replace_default_logo_with_custom_logo');



// Register the settings field to store the custom button code
function my_dark_mode_settings_init() {
    register_setting('my_dark_mode', 'my_dark_mode_button_code');
    register_setting('my_dark_mode', 'my_dark_mode_switcher');
    //list of fields
    require_once plugin_dir_path(__FILE__) . 'my-dark-mode-fields.php';
    
}
add_action('admin_init', 'my_dark_mode_settings_init');
register_setting('my_dark_mode', 'my_dark_mode_custom_css');



// Create a shortcode for the dark mode toggle button
function my_dark_mode_toggle_button_shortcode() {
    $settings = get_dark_mode_settings();
    $switcher = $settings['switcher'];
    $button_code = $settings['button_code'];
    $default_button_code = $settings['default_button_code'];

    if ($switcher == 'no_switcher') {
        return $button_code;
    }
    if ($switcher == 'switcher1') {
        return $settings['switcher1_html'];
    }
    if ($switcher == 'switcher2') {
        return $settings['switcher2_html'];
    }
}
add_shortcode('my_dark_mode_toggle_button', 'my_dark_mode_toggle_button_shortcode');

//Added button to widgets area
require_once plugin_dir_path(__FILE__) . 'my-dark-mode-widget.php';

//Add code editor instead of textarea
function my_dark_mode_enqueue_admin_scripts($hook) {
    if ('toplevel_page_my-dark-mode' !== $hook) {
        return;
    }

    // Enqueue the custom admin CSS file
    wp_enqueue_style('my-dark-mode-admin-css', plugin_dir_url(__FILE__) . 'assets/css/my-dark-mode-admin.css', array(), '1.0', 'all');

    // Enqueue the custom admin JS file
    wp_enqueue_code_editor(array('type' => 'text/html'));
    wp_enqueue_script('my-dark-mode-admin-js', plugin_dir_url(__FILE__) . 'assets/js/my-dark-mode-admin.js', array('jquery'), '1.0', true);


}
add_action('admin_enqueue_scripts', 'my_dark_mode_enqueue_admin_scripts', 1);


//Add color pickers
require_once plugin_dir_path(__FILE__) . 'my-dark-mode-colors.php';
