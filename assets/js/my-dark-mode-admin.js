(function($) {
    $(document).ready(function() {
        // Initialize the WordPress color picker for the Color Class or ID input field with the default color palette
        $('#mdm_dark_bg_color_picker, #mdm_dark_heading_color_picker, #mdm_dark_text_color_picker, #mdm_dark_link_text_color_picker, #mdm_dark_btn_bg_color_picker').wpColorPicker({
            palettes: true
        });
    });
})(jQuery);
