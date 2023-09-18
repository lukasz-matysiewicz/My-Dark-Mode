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

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

function my_custom_head_script() {
    wp_enqueue_script('my-dark-mode-switcher', plugins_url('assets/js/my-dark-mode-switcher.js', __FILE__), array(), '1.0.0', false);
}
add_action('wp_head', 'my_custom_head_script', 1);

function my_dark_mode_enqueue_scripts() {
    // Enqueue the dark-mode.css file
    wp_enqueue_style('my-dark-mode-css', plugin_dir_url(__FILE__) . 'assets/css/my-dark-mode.css', array(), '1.0', 'all');

    // Enqueue the switchers.css file for both admin and front-end
    wp_enqueue_style('my-dark-mode-switchers-css', plugin_dir_url(__FILE__) . 'assets/css/my-dark-mode-switchers.css', array(), '1.0', 'all');

    wp_enqueue_script('my-dark-mode-js', plugin_dir_url(__FILE__) . 'assets/js/my-dark-mode-save.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'my_dark_mode_enqueue_scripts', 1);

// create setting page
function my_dark_mode_admin_menu() {
    add_menu_page(
        '<h1>My Dark Mode Settings</h1>',
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
    <div class="my-dark-mode-container">
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
    </div>
    <?php
}

function my_dark_mode_save_settings() {
    check_admin_referer('my_dark_mode_nonce');

    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    update_option('my_dark_mode_switcher', intval($_POST['my_dark_mode_switcher']));
    update_option('my_dark_mode_button_code', sanitize_text_field($_POST['my_dark_mode_button_code']));
    update_option('my_dark_mode_custom_css', wp_strip_all_tags($_POST['my_dark_mode_custom_css']));
    update_option('my_dark_mode_license', sanitize_text_field($_POST['my_dark_mode_license']));

    if (is_numeric($_POST['switcher1_width'])) {
        update_option('switcher1_width', $_POST['switcher1_width']);
    }

    if (is_numeric($_POST['switcher1_height'])) {
        update_option('switcher1_height', $_POST['switcher1_height']);
    }

    if (is_numeric($_POST['switcher2_width'])) {
        update_option('switcher2_width', $_POST['switcher2_width']);
    }

    if (is_numeric($_POST['switcher2_height'])) {
        update_option('switcher2_height', $_POST['switcher2_height']);
    }

    wp_redirect(admin_url('admin.php?page=my-dark-mode&settings-updated=true'));
    exit;
}
add_action('admin_post_save_my_dark_mode_settings', 'my_dark_mode_save_settings');


function my_dark_mode_custom_css_callback() {
    $raw_css = get_option('my_dark_mode_custom_css');

    ?>
    <div class="premium-label">Premium Feature</div>
    <div class="mdm-container premium">
    <div>Prefix: <strong>html[my-dark-mode='dark']</strong> will be added automatically before your class just leave end of line with "{", attributes move to next line. </strong></div>
    <textarea id="my_dark_mode_custom_css" name="my_dark_mode_custom_css" rows="5" cols="50"><?php echo esc_textarea($raw_css); ?></textarea>  
    </div>
    <?php
}

function print_dark_mode_css() {
    $raw_css = get_option('my_dark_mode_custom_css');
    $custom_css = wrap_custom_css_with_dark_mode_selector($raw_css);
    $safe_css = wp_strip_all_tags($custom_css);

    echo '<style>' . $safe_css . '</style>';
}
function wrap_custom_css_with_dark_mode_selector($css) {
    $lines = explode("\n", trim($css));
    $wrapped_css = "";
    $rule_start = "";  // This will store the selector for the CSS rule
    $rule_body = "";  // This will store the content of the CSS rule

    foreach ($lines as $line) {
        $trimmed = trim($line);

        if ($trimmed) {
            // If the line is the start of a rule.
            if (substr($trimmed, -1) === '{') {
                // If rule_body is not empty, then it's time to wrap the previous rule.
                if ($rule_body) {
                    $wrapped_css .= "html[my-dark-mode='dark'] " . $rule_start . " {" . $rule_body . "\n";
                    $rule_body = "";  // Reset rule_body
                }
                $rule_start = substr($trimmed, 0, -1);  // Store the selector without the '{'
            } else {
                $rule_body .= $line . "\n";
            }
        }
    }

    // Handle the last rule if there's any.
    if ($rule_body) {
        $wrapped_css .= "html[my-dark-mode='dark'] " . $rule_start . " {" . $rule_body;
    }

    return $wrapped_css;
}




function my_dark_mode_section_callback() {
    ?>
    <div>Use those fields to customize My Dark Mode Styles.</div>
    <?php
}


//global variables
function get_dark_mode_settings() {
    $switcher = get_option('my_dark_mode_switcher', 'no_switcher');
    $default_button_code = '<div class="mode-single-switch-border"><input type="checkbox" id="mode-switch-single" data-dark-mode-toggle aria-label="Toggle Dark Mode"><label for="mode-switch-single" class="mode-label-single"><div class="toggle"></div><div class="names"><div class="light">Light</div><div class="dark">Dark</div></div></label></div>';
    $button_code = get_option('my_dark_mode_button_code', $default_button_code);
    
    $switcher1_width = get_option('switcher1_width', 90);
    $switcher1_height = get_option('switcher1_height', 40);

    $switcher2_width = get_option('switcher2_width', 40);
    $switcher2_height = get_option('switcher2_height', 40);

    $switcher1_html = '
    <div class="mode-switch-border" style="width:'.$switcher1_width.'px; height:'.$switcher1_height.'px;">
        <input type="checkbox" id="mode-switch" data-dark-mode-toggle aria-label="Toggle Dark Mode">
        <label for="mode-switch" class="mode-label">
        <div class="toggle"></div>
        <div class="names">
            <div class="light">Light</div>
            <div class="dark">Dark</div>
        </div>
        </label>
    </div>';

    $switcher2_html = '
    <div class="circle-switch-border" style="width:'.$switcher2_width.'px; height:'.$switcher2_height.'px;">
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
        'switcher2_html' => $switcher2_html,
        'switcher1_width' => $switcher1_width,
        'switcher1_height' => $switcher1_height,
        'switcher2_width' => $switcher2_width,
        'switcher2_height' => $switcher2_height
    );
}

function my_dark_mode_button_code_callback() {
    $settings = get_dark_mode_settings();
    $button_code = $settings['button_code'];
    $default_button_code = $settings['default_button_code'];
    ?>
    <div class="premium-label">Premium Feature</div>
    <div class="mdm-container premium">
    <div><strong>IMPORTANT:</strong> please use button attribute: <strong>data-dark-mode-toggle</strong></br></br>
    To use dark mode button on your website use <strong>widget</strong> or this shortcode: <strong>[my_dark_mode_toggle_button]</strong></br></br>If you are not fluent with html,css and need help customize button please use this customizer: <a href="https://codebeautify.org/html-button-generator" target="_blank" rel="noopener noreferrer">https://codebeautify.org/html-button-generator</a></div>
    <textarea id="my_dark_mode_button_code" name="my_dark_mode_button_code" rows="5" cols="50"><?php echo esc_textarea($button_code); ?></textarea>
    <br>
    <button type="button" id="my_dark_mode_reset_button" class="button">Reset Button Code</button>
    </div>
    <?php
        wp_enqueue_script('my-dark-mode-reset-button', plugins_url('assets/js/my-dark-mode-reset-button.js', __FILE__), array(), '1.0.0', true);
}


function my_dark_mode_switcher_section_callback(){
    $settings = get_dark_mode_settings();
    $switcher = $settings['switcher'];
    $button_code = $settings['button_code'];
    ?> 
    <div class="mdm-container">
        <p class=switcher-info>To use dark mode button on your website use <strong>widget</strong> or this shortcode: <strong>[my_dark_mode_toggle_button]</strong></p>
    <?php 
    ?>
        <div class="no-switcher">
            <label>
                <input class="premium-value" type="radio" name="my_dark_mode_switcher" value="no_switcher" disabled <?php checked($switcher, 'no_switcher'); ?>>
                No Switcher (use custom button code)
            </label>
        </div>
        <div class="switcher">
            <label>
                <input type="radio" name="my_dark_mode_switcher" value="switcher1" <?php checked($switcher, 'switcher1'); ?>>
                Switcher 1
            </label>
            <div class="prev">
                Preview:
                <?php echo wp_kses_post($settings['switcher1_html']);
     ?>
                
            </div>
            <div>
                Width: <input type="number" class="switch_input" name="switcher1_width" value="<?php echo wp_kses_post($settings['switcher1_width']); ?>">
                Height: <input type="number" class="switch_input" name="switcher1_height" value="<?php echo wp_kses_post($settings['switcher1_height']); ?>">
            </div>
        </div>
        <div class="switcher">
            <label> 
                <input type="radio" name="my_dark_mode_switcher" value="switcher2" <?php checked($switcher, 'switcher2'); ?>>
                Switcher 2
            </label>
            <div class="prev">
                Preview:
                <?php echo wp_kses_post($settings['switcher2_html']); ?>
            </div>
            <div>
                Width: <input type="number" class="switch_input" name="switcher2_width" value="<?php echo wp_kses_post($settings['switcher2_width']); ?>">
                Height: <input type="number" class="switch_input" name="switcher2_height" value="<?php echo wp_kses_post($settings['switcher2_height']); ?>">
            </div>
        </div>
    </div>
<?php
}

function my_dark_mode_logo_callback() {
    $light_logo = get_option('my_dark_mode_light_logo', '');
    $dark_logo = get_option('my_dark_mode_dark_logo', '');
    ?>
    <div class="premium-label">Premium Feature</div>
    <div class="mdm-container logo-upload-container premium">
        <div class="logo-upload">
            <input type="button" class="button premium-value" id="my_dark_mode_light_logo_button" value="Upload Light Logo" disabled>
            <input type="hidden" id="my_dark_mode_light_logo" name="my_dark_mode_light_logo" value="<?php echo esc_attr($light_logo); ?>">
            <div id="my_dark_mode_light_logo_preview" style="display: inline-block; vertical-align: top;">
                <?php if (!empty($light_logo)): ?>
                    <button type="button" class="remove_image_button" data-target-id="my_dark_mode_light_logo" style="display: block;">X</button>
                    <img src="<?php echo esc_url($light_logo); ?>">
                <?php endif; ?>
            </div>
        </div>
        <div class="logo-upload">
            <input type="button" class="button premium-value" id="my_dark_mode_dark_logo_button" value="Upload Dark Logo" disabled>
            <input type="hidden" id="my_dark_mode_dark_logo" name="my_dark_mode_dark_logo" value="<?php echo esc_attr($dark_logo); ?>">
            <div id="my_dark_mode_dark_logo_preview" style="display: inline-block; vertical-align: top;">
                <?php if (!empty($dark_logo)): ?>
                    <button type="button" class="remove_image_button" data-target-id="my_dark_mode_dark_logo" style="display: block;">X</button>
                    <img src="<?php echo esc_url($dark_logo); ?>">
                <?php endif; ?>
        </div>
        </div>
    </div>
    <?php
    wp_enqueue_script('my-dark-mode-logo', plugins_url('assets/js/my-dark-mode-logo.js', __FILE__), array(), '1.0.0', true);
}


function replace_default_logo_with_custom_logo() {
    $light_logo_url = get_option('my_dark_mode_light_logo', '');
    $dark_logo_url = get_option('my_dark_mode_dark_logo', '');

    if (!empty($light_logo_url) || !empty($dark_logo_url)) {
        wp_enqueue_script('my-dark-mode-logo-replace', plugins_url('assets/js/my-dark-mode-logo-replace.js', __FILE__), array(), '1.0.0', true);
    }
}

add_action('wp_footer', 'replace_default_logo_with_custom_logo');



// Register the settings field to store the custom button code
function my_dark_mode_settings_init() {
    register_setting('my_dark_mode', 'my_dark_mode_button_code');
    register_setting('my_dark_mode', 'my_dark_mode_switcher');
    register_setting('my_dark_mode', 'my_dark_mode_custom_css');
    register_setting('my_dark_mode', 'my_dark_mode_light_logo');
    register_setting('my_dark_mode', 'my_dark_mode_dark_logo');
    register_setting('my_dark_mode', 'switcher1_width');
    register_setting('my_dark_mode', 'switcher1_height');
    register_setting('my_dark_mode', 'switcher2_width');
    register_setting('my_dark_mode', 'switcher2_height');
    register_setting('my_dark_mode', 'my_dark_mode_license');
    //list of fields
    require_once plugin_dir_path(__FILE__) . 'my-dark-mode-fields.php';
    
}
add_action('admin_init', 'my_dark_mode_settings_init');




// Create a shortcode for the dark mode toggle button
function my_dark_mode_toggle_button_shortcode($atts) {
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
    wp_enqueue_script('my-dark-mode-validate-js', plugin_dir_url(__FILE__) . 'assets/js/my-dark-mode-validate.js', array('jquery'), '1.0', true);
    wp_localize_script('my-dark-mode-validate-js', 'my_dark_mode_vars', array(
        'nonce' => wp_create_nonce('my_dark_mode_nonce'),
    ));

}
add_action('admin_enqueue_scripts', 'my_dark_mode_enqueue_admin_scripts', 1);


//Add color pickers
require_once plugin_dir_path(__FILE__) . 'my-dark-mode-colors.php';

//Validate license
require_once plugin_dir_path(__FILE__) . 'my-dark-mode-license.php';
