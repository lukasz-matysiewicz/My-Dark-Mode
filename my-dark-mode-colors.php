<?php
function my_dark_mode_colors_callback() {
    $bg_color_class = get_option('mdm_bg_color_class', '#content');
    $heading_color_class = get_option('mdm_heading_color_class', 'h1, h2, h3, h4, h5, h6');
    $text_color_class = get_option('mdm_text_color_class', '#content');
    $link_text_color_class = get_option('mdm_link_text_color_class', 'a');
    $btn_bg_color_class = get_option('mdm_btn_bg_color_class', 'button');

    $dark_bg_att = get_option('mdm_dark_bg_color_att', '');
    $dark_bg_color = get_option('mdm_dark_bg_color_picker', '');
    $dark_heading_att = get_option('mdm_dark_heading_color_att', '');
    $dark_heading_color = get_option('mdm_dark_heading_color_picker', '');
    $dark_text_att = get_option('mdm_dark_text_color_att', '');
    $dark_text_color = get_option('mdm_dark_text_color_picker', '');
    $dark_link_text_att = get_option('mdm_dark_link_text_color_att', '');
    $dark_link_text_color = get_option('mdm_dark_link_text_color_picker', '');
    $dark_btn_bg_att = get_option('mdm_dark_btn_bg_color_att', '');
    $dark_btn_bg_color = get_option('mdm_dark_btn_bg_color_picker', '');
    ?>
    <div class="mdm-container colors-group">
        <table>
            <tr>
                <th><h2>Element</h2></th>
                <th><h2>Attribute</h2></th>
                <th><h2>Color in Dark Mode</h2></th>
            </tr>
            <tr class="colors">
                <td id="col1"><h3>First</h3><input type="text" id="mdm_bg_color_class" name="mdm_bg_color_class" value="<?php echo esc_attr($bg_color_class); ?>"></td>
                <td id="col2"><input type="text" id="mdm_dark_bg_color_att" name="mdm_dark_bg_color_att" value="<?php echo esc_attr($dark_bg_att); ?>"></td>
                <td id="col3"><input type="text" id="mdm_dark_bg_color_picker" name="mdm_dark_bg_color_picker" value="<?php echo esc_attr($dark_bg_color); ?>"></td>
            </tr>
            <tr class="colors">
                <td id="col1"><h3>Second</h3><input type="text" id="mdm_heading_color_class" name="mdm_heading_color_class" value="<?php echo esc_attr($heading_color_class); ?>"></td>
                <td id="col2"><input type="text" id="mdm_dark_heading_color_att" name="mdm_dark_heading_color_att" value="<?php echo esc_attr($dark_heading_att); ?>"></td>
                <td id="col3"><input type="text" id="mdm_dark_heading_color_picker" name="mdm_dark_heading_color_picker" value="<?php echo esc_attr($dark_heading_color); ?>"></td>
            </tr>
            <tr class="colors">
                <td id="col1"><h3>Third</h3><input type="text" id="mdm_text_color_class" name="mdm_text_color_class" value="<?php echo esc_attr($text_color_class); ?>"></td>
                <td id="col2"><input type="text" id="mdm_dark_text_color_att" name="mdm_dark_text_color_att" value="<?php echo esc_attr($dark_text_att); ?>"></td>
                <td id="col3"><input type="text" id="mdm_dark_text_color_picker" name="mdm_dark_text_color_picker" value="<?php echo esc_attr($dark_text_color); ?>"></td>
            </tr>
            <tr class="colors">
                <td id="col1"><h3>Fourth</h3><input type="text" id="mdm_link_text_color_class" name="mdm_link_text_color_class" value="<?php echo esc_attr($link_text_color_class); ?>"></td>
                <td id="col2"><input type="text" id="mdm_dark_link_text_color_att" name="mdm_dark_link_text_color_att" value="<?php echo esc_attr($dark_link_text_att); ?>"></td>
                <td id="col3"><input type="text" id="mdm_dark_link_text_color_picker" name="mdm_dark_link_text_color_picker" value="<?php echo esc_attr($dark_link_text_color); ?>"></td>
            </tr>
            <tr class="colors">
                <td id="col1"><h3>Fifth</h3><input type="text" id="mdm_btn_bg_color_class" name="mdm_btn_bg_color_class" value="<?php echo esc_attr($btn_bg_color_class); ?>"></td>
                <td id="col2"><input type="text" id="mdm_dark_btn_bg_color_att" name="mdm_dark_btn_bg_color_att" value="<?php echo esc_attr($dark_btn_bg_att); ?>"></td>
                <td id="col3"><input type="text" id="mdm_dark_btn_bg_color_picker" name="mdm_dark_btn_bg_color_picker" value="<?php echo esc_attr($dark_btn_bg_color); ?>"></td>
            </tr>
        </table>
        <button type="button" id="my_dark_mode_reset_colors" class="button">Reset Colors</button>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('#my_dark_mode_reset_colors').on('click', function() {

                // Reset class input fields to default values
                $('#mdm_bg_color_class').val('#content');
                $('#mdm_heading_color_class').val('h1,h2,h3,h4,h5,h6');
                $('#mdm_text_color_class').val('#content');
                $('#mdm_link_text_color_class').val('a');
                $('#mdm_btn_bg_color_class').val('button');

                // Reset attributes input fields to default values
                $('#mdm_dark_bg_color_att').val('background-color');
                $('#mdm_dark_heading_color_att').val('color');
                $('#mdm_dark_text_color_att').val('color');
                $('#mdm_dark_link_text_color_att').val('color');
                $('#mdm_dark_btn_bg_color_att').val('background-color');

                // Reset color pickers to default values
                $('#mdm_dark_bg_color_picker').wpColorPicker('color', '#333');
                $('#mdm_dark_heading_color_picker').wpColorPicker('color', '#c6751d');
                $('#mdm_dark_text_color_picker').wpColorPicker('color', '#fff');
                $('#mdm_dark_link_text_color_picker').wpColorPicker('color', '#c6751d');
                $('#mdm_dark_btn_bg_color_picker').wpColorPicker('color', '#c6751d');

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

    register_setting('my_dark_mode', 'mdm_dark_bg_color_att');
    register_setting('my_dark_mode', 'mdm_dark_bg_color_picker');
    register_setting('my_dark_mode', 'mdm_dark_heading_color_att');
    register_setting('my_dark_mode', 'mdm_dark_heading_color_picker');
    register_setting('my_dark_mode', 'mdm_dark_text_color_att');
    register_setting('my_dark_mode', 'mdm_dark_text_color_picker');
    register_setting('my_dark_mode', 'mdm_dark_link_text_color_att');
    register_setting('my_dark_mode', 'mdm_dark_link_text_color_picker');
    register_setting('my_dark_mode', 'mdm_dark_btn_bg_color_att');
    register_setting('my_dark_mode', 'mdm_dark_btn_bg_color_picker');
}
add_action('admin_init', 'my_dark_mode_register_settings');


function my_dark_mode_generate_css() {
    $bg_color_class = get_option('mdm_bg_color_class', '#content');
    $heading_color_class = get_option('mdm_heading_color_class', 'h1,h2,h3,h4,h5,h6');
    $text_color_class = get_option('mdm_text_color_class', 'body');
    $link_text_color_class = get_option('mdm_link_text_color_class', 'a');
    $btn_bg_color_class = get_option('mdm_btn_bg_color_class', 'button');

    $dark_bg_att = get_option('mdm_dark_btn_bg_color_att', 'background-color');
    $dark_bg_color = get_option('mdm_dark_bg_color_picker', '#333');
    $dark_heading_att = get_option('mdm_dark_heading_color_att', 'color');
    $dark_heading_color = get_option('mdm_dark_heading_color_picker', '#c6751d');
    $dark_text_att = get_option('mdm_dark_text_color_att', 'color');
    $dark_text_color = get_option('mdm_dark_text_color_picker', '#fff');
    $dark_link_text_att = get_option('mdm_dark_link_text_color_att', 'color');
    $dark_link_text_color = get_option('mdm_dark_link_text_color_picker', '#c6751d');
    $dark_btn_bg_att = get_option('mdm_dark_btn_bg_color_att', 'background-color');
    $dark_btn_bg_color = get_option('mdm_dark_btn_bg_color_picker', '#c6751d');


    $css = "
    body[my-dark-mode='dark'] {$bg_color_class} {
            {$dark_bg_att}: {$dark_bg_color}!important;
        }
    body[my-dark-mode='dark'] {$heading_color_class} {
            {$dark_heading_att}: {$dark_heading_color}!important;
        }
    body[my-dark-mode='dark'] {$text_color_class} {
            {$dark_text_att}: {$dark_text_color}!important;
        }
    body[my-dark-mode='dark'] {$link_text_color_class} {
            {$dark_link_text_att}: {$dark_link_text_color}!important;
        }
    body[my-dark-mode='dark'] {$btn_bg_color_class} {
            {$dark_btn_bg_att}: {$dark_btn_bg_color}!important;
    }   
    ";

    $custom_css = get_option('my_dark_mode_custom_css', '');
    $css .= $custom_css;

    wp_add_inline_style('my-dark-mode-css', $css);
}
add_action('wp_enqueue_scripts', 'my_dark_mode_generate_css', 20);

