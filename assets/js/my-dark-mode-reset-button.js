document.getElementById('my_dark_mode_reset_button').addEventListener('click', function() {
    var defaultButtonCode = myDarkModeVars.defaultButtonCode;
    myDarkModeEditor.codemirror.setValue(defaultButtonCode);
});
