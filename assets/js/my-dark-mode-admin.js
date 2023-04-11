var myDarkModeEditor;

(function($) {
    $(document).ready(function() {
        // Initialize the CodeMirror editor for the Button Code textarea
        var buttonCodeEditorSettings = wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {};
        buttonCodeEditorSettings.codemirror = _.extend({}, buttonCodeEditorSettings.codemirror, {
            indentUnit: 2,
            tabSize: 2,
        });
        myDarkModeEditor = wp.codeEditor.initialize($('#my_dark_mode_button_code'), buttonCodeEditorSettings);

        // Initialize the CodeMirror editor for the Custom CSS textarea
        var customCssEditorSettings = wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {};
        customCssEditorSettings.codemirror = _.extend({}, customCssEditorSettings.codemirror, {
            indentUnit: 2,
            tabSize: 2,
            mode: 'css',
        });
        var customCssEditor = wp.codeEditor.initialize($('#my_dark_mode_custom_css'), customCssEditorSettings);
    });
})(jQuery);


(function($) {
    $(document).ready(function() {
        // Initialize the WordPress color picker for the Color Class or ID input field with the default color palette
        $('#mdm_light_bg_color_picker, #mdm_light_heading_color_picker, #mdm_light_text_color_picker, #mdm_light_link_text_color_picker,#mdm_light_btn_bg_color_picker, #mdm_dark_bg_color_picker, #mdm_dark_heading_color_picker, #mdm_dark_text_color_picker, #mdm_link_dark_text_color_picker, #mdm_dark_btn_bg_color_picker').wpColorPicker({
            palettes: true
        });
    });
})(jQuery);

