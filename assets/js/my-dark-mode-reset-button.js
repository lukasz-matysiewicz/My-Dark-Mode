document.getElementById('my_dark_mode_reset_button').addEventListener('click', function() {
    var defaultButtonCode = '<?php echo addslashes(str_replace("\n", "", $default_button_code)); ?>';
        myDarkModeEditor.codemirror.setValue(defaultButtonCode);
});