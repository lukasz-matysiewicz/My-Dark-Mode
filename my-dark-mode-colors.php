<?php
function my_dark_mode_colors_callback() {
    $bg_color_class = get_option('mdm_bg_color_class', 'body');
    $heading_color_class = get_option('mdm_heading_color_class', 'h1,h2,h3,h4,h5,h6');
    $text_color_class = get_option('mdm_text_color_class', 'body');
    $link_text_color_class = get_option('mdm_link_text_color_class', 'a');
    $btn_bg_color_class = get_option('mdm_btn_bg_color_class', 'button');

    $light_bg_color = get_option('mdm_light_bg_color_picker', '');
    $dark_bg_color = get_option('mdm_dark_bg_color_picker', '');
    $light_heading_color = get_option('mdm_light_heading_color_picker', '');
    $dark_heading_color = get_option('mdm_dark_heading_color_picker', '');
    $light_text_color = get_option('mdm_light_text_color_picker', '');
    $dark_text_color = get_option('mdm_dark_text_color_picker', '');
    $light_link_text_color = get_option('mdm_light_link_text_color_picker', '');
    $dark_link_text_color = get_option('mdm_dark_link_text_color_picker', '');
    $light_btn_bg_color = get_option('mdm_light_btn_bg_color_picker', '');
    $dark_btn_bg_color = get_option('mdm_dark_btn_bg_color_picker', '');
    ?>
    <div class="mdm-container colors-group">
        <table>
            <tr>
                <th><h2>Element</h2></th>
                <th><h2>Color in Light Mode</h2></th>
                <th><h2>Color in Dark Mode</h2></th>
            </tr>
            <tr class="colors">
                <td id="col1"><h3>Background Color</h3><input type="text" id="mdm_bg_color_class" name="mdm_bg_color_class" value="<?php echo esc_attr($bg_color_class); ?>"></td>
                <td id="col2"><input type="text" id="mdm_light_bg_color_picker" name="mdm_light_bg_color_picker" value="<?php echo esc_attr($light_bg_color); ?>"></td>
                <td id="col3"><input type="text" id="mdm_dark_bg_color_picker" name="mdm_dark_bg_color_picker" value="<?php echo esc_attr($dark_bg_color); ?>"></td>
            </tr>
            <tr class="colors">
                <td id="col1"><h3>Heading Text Color</h3><input type="text" id="mdm_heading_color_class" name="mdm_heading_color_class" value="<?php echo esc_attr($heading_color_class); ?>"></td>
                <td id="col2"><input type="text" id="mdm_light_heading_color_picker" name="mdm_light_heading_color_picker" value="<?php echo esc_attr($light_heading_color); ?>"></td>
                <td id="col3"><input type="text" id="mdm_dark_heading_color_picker" name="mdm_dark_heading_color_picker" value="<?php echo esc_attr($dark_heading_color); ?>"></td>
            </tr>
            <tr class="colors">
                <td id="col1"><h3>Text Color</h3><input type="text" id="mdm_text_color_class" name="mdm_text_color_class" value="<?php echo esc_attr($text_color_class); ?>"></td>
                <td id="col2"><input type="text" id="mdm_light_text_color_picker" name="mdm_light_text_color_picker" value="<?php echo esc_attr($light_text_color); ?>"></td>
                <td id="col3"><input type="text" id="mdm_dark_text_color_picker" name="mdm_dark_text_color_picker" value="<?php echo esc_attr($dark_text_color); ?>"></td>
            </tr>
            <tr class="colors">
                <td id="col1"><h3>Link Text Color</h3><input type="text" id="mdm_link_text_color_class" name="mdm_link_text_color_class" value="<?php echo esc_attr($link_text_color_class); ?>"></td>
                <td id="col2"><input type="text" id="mdm_light_link_text_color_picker" name="mdm_light_link_text_color_picker" value="<?php echo esc_attr($light_link_text_color); ?>"></td>
                <td id="col3"><input type="text" id="mdm_dark_link_text_color_picker" name="mdm_dark_link_text_color_picker" value="<?php echo esc_attr($dark_link_text_color); ?>"></td>
            </tr>
            <tr class="colors">
                <td id="col1"><h3>Button Background Color</h3><input type="text" id="mdm_btn_bg_color_class" name="mdm_btn_bg_color_class" value="<?php echo esc_attr($btn_bg_color_class); ?>"></td>
                <td id="col2"><input type="text" id="mdm_light_btn_bg_color_picker" name="mdm_light_btn_bg_color_picker" value="<?php echo esc_attr($light_btn_bg_color); ?>"></td>
                <td id="col3"><input type="text" id="mdm_dark_btn_bg_color_picker" name="mdm_dark_btn_bg_color_picker" value="<?php echo esc_attr($dark_btn_bg_color); ?>"></td>
            </tr>
        </table>
        <button type="button" id="my_dark_mode_reset_colors" class="button">Reset Colors</button>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('#my_dark_mode_reset_colors').on('click', function() {
                // Reset color pickers to default values
                $('#mdm_light_bg_color_picker').wpColorPicker('color', '#fff');
                $('#mdm_dark_bg_color_picker').wpColorPicker('color', '#333');
                $('#mdm_light_heading_color_picker').wpColorPicker('color', '#006faf');
                $('#mdm_dark_heading_color_picker').wpColorPicker('color', '#c6751d');
                $('#mdm_light_text_color_picker').wpColorPicker('color', '#333');
                $('#mdm_dark_text_color_picker').wpColorPicker('color', '#fff');
                $('#mdm_light_link_text_color_picker').wpColorPicker('color', '#006faf');
                $('#mdm_dark_link_text_color_picker').wpColorPicker('color', '#c6751d');
                $('#mdm_light_btn_bg_color_picker').wpColorPicker('color', '#006faf');
                $('#mdm_dark_btn_bg_color_picker').wpColorPicker('color', '#c6751d');

                // Reset class input fields to default values
                $('#mdm_bg_color_class').val('body');
                $('#mdm_heading_color_class').val('h1,h2,h3,h4,h5,h6');
                $('#mdm_text_color_class').val('body');
                $('#mdm_link_text_color_class').val('a');
                $('#mdm_btn_bg_color_class').val('button');
            });
        });
    </script>
    <?php
}

function my_dark_mode_register_settings() {
    register_setting('my_dark_mode', 'mdm_bg_color_class');
    register_setting('my_dark_mode', 'mdm_heading_color_class');
    register_setting('my_dark_mode', 'mdm_text_color_class');
    register_setting('my_dark_mode', 'mdm_link_text_color_class');
    register_setting('my_dark_mode', 'mdm_btn_bg_color_class');

    register_setting('my_dark_mode', 'mdm_light_bg_color_picker');
    register_setting('my_dark_mode', 'mdm_dark_bg_color_picker');
    register_setting('my_dark_mode', 'mdm_light_heading_color_picker');
    register_setting('my_dark_mode', 'mdm_dark_heading_color_picker');
    register_setting('my_dark_mode', 'mdm_light_text_color_picker');
    register_setting('my_dark_mode', 'mdm_dark_text_color_picker');
    register_setting('my_dark_mode', 'mdm_light_link_text_color_picker');
    register_setting('my_dark_mode', 'mdm_dark_link_text_color_picker');
    register_setting('my_dark_mode', 'mdm_light_btn_bg_color_picker');
    register_setting('my_dark_mode', 'mdm_dark_btn_bg_color_picker');
}
add_action('admin_init', 'my_dark_mode_register_settings');


function my_dark_mode_generate_css() {
    $bg_color_class = get_option('mdm_bg_color_class', 'body');
    $heading_color_class = get_option('mdm_heading_color_class', 'h1,h2,h3,h4,h5,h6');
    $text_color_class = get_option('mdm_text_color_class', 'body');
    $link_text_color_class = get_option('mdm_link_text_color_class', 'a');
    $btn_bg_color_class = get_option('mdm_btn_bg_color_class', 'button');

    $light_bg_color = get_option('mdm_light_bg_color_picker', '#fff');
    $dark_bg_color = get_option('mdm_dark_bg_color_picker', '#333');
    $light_heading_color = get_option('mdm_light_heading_color_picker', '#006faf');
    $dark_heading_color = get_option('mdm_dark_heading_color_picker', '#c6751d');
    $light_text_color = get_option('mdm_light_text_color_picker', '#333');
    $dark_text_color = get_option('mdm_dark_text_color_picker', '#fff');
    $light_link_text_color = get_option('mdm_light_link_text_color_picker', '#006faf');
    $dark_link_text_color = get_option('mdm_dark_link_text_color_picker', '#c6751d');
    $light_btn_bg_color = get_option('mdm_light_btn_bg_color_picker', '#006faf');
    $dark_btn_bg_color = get_option('mdm_dark_btn_bg_color_picker', '#c6751d');


    $css = "
    body[my-dark-mode='light']{$bg_color_class} {
            background-color: {$light_bg_color}!important;
    }
    body[my-dark-mode='light']{$heading_color_class} {
            color: {$light_heading_color}!important;
    }
    body[my-dark-mode='light']{$text_color_class} {
            color: {$light_text_color}!important;
    }
    body[my-dark-mode='light']{$link_text_color_class} {
            color: {$light_link_text_color}!important;
    }
    body[my-dark-mode='light']{$btn_bg_color_class} {
            background-color: {$light_btn_bg_color}!important;
    }
    body[my-dark-mode='dark']{$bg_color_class} {
            background-color: {$dark_bg_color}!important;
        }
    body[my-dark-mode='dark']{$heading_color_class} {
            color: {$dark_heading_color}!important;
        }
    body[my-dark-mode='dark']{$text_color_class} {
            color: {$dark_text_color}!important;
        }
    body[my-dark-mode='dark']{$link_text_color_class} {
            color: {$dark_link_text_color}!important;
        }
    body[my-dark-mode='dark']{$btn_bg_color_class} {
            background-color: {$dark_btn_bg_color}!important;
    }
    ";

    wp_register_style( 'dark-mode', plugin_dir_url( __FILE__ ) . 'assets/css/my-dark-mode.css' );
    wp_enqueue_style( 'dark-mode' );
    wp_add_inline_style('dark-mode', $css);
}
add_action('wp_enqueue_scripts', 'my_dark_mode_generate_css', 20);

