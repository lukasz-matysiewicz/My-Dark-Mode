var nonce = my_dark_mode_vars.nonce;

window.checkAndSaveLicense = function() {
    var license = jQuery('#my_dark_mode_license').val();

    // First check the license
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'check_license',
            license: license,
            nonce: my_dark_mode_vars.nonce 
        },
        success: function(response) {
            //console.log("Response: " + response);  // NEW
            jQuery('#license-check-result').text(response);
            var status = response.trim() === 'The license is valid.' ? 'Active' : 'Not Active';
            //console.log("Status: " + status);  // NEW
            
            var $licenseStatus = jQuery('#license-status');
            $licenseStatus.text(status);

            if(status === 'Active'){
                $licenseStatus.removeClass('license-inactive').addClass('license-active');

                // Save the license key
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'save_license',
                        license: license,
                        nonce: my_dark_mode_vars.nonce 
                    },
                    success: function(response) {
                        // handle success
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // handle error
                    }
                });
                
                jQuery('.premium').css('opacity', '1');
                jQuery('.premium-value').prop('disabled', false);

                // Set CodeMirror instances to be editable
                myDarkModeEditor.codemirror.setOption('readOnly', false);
                customCssEditor.codemirror.setOption('readOnly', false);
            } else {
                $licenseStatus.removeClass('license-active').addClass('license-inactive');

                jQuery('.premium').css('opacity', '0.5');
                jQuery('.premium-value').prop('disabled', true);

                // Set CodeMirror instances to be read-only
                myDarkModeEditor.codemirror.setOption('readOnly', 'nocursor');
                customCssEditor.codemirror.setOption('readOnly', 'nocursor');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            jQuery('#license-check-result').text('An error occurred while checking the license.');

            // Set CodeMirror instances to be read-only in case of error
            myDarkModeEditor.codemirror.setOption('readOnly', 'nocursor');
            customCssEditor.codemirror.setOption('readOnly', 'nocursor');
        }
    });
}



window.removeLicense = function() {
    var nonce = jQuery('#my_dark_mode_nonce_field').val();

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'remove_license',
            nonce: nonce
        },
        success: function(response) {
            jQuery('#license-check-result').text(response);
            jQuery('#my_dark_mode_license').val('');  // Clear the license input
            jQuery('#license-status').text('Not Active');  // Update the license status
            checkAndSaveLicense();

            // Set CodeMirror instances to be read-only
            myDarkModeEditor.codemirror.setOption('readOnly', 'nocursor');
            customCssEditor.codemirror.setOption('readOnly', 'nocursor');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            jQuery('#license-check-result').text('An error occurred while removing the license.');
        }
    });
}



window.saveLicense = function(license) {

    // Save the license
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'save_license',
            license: license,
            nonce: my_dark_mode_vars.nonce
        },
        success: function(response) {
            // Now we have to update the license status right after saving
            jQuery('#license-status').text('Active');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            jQuery('#license-check-result').text('An error occurred while saving the license.');
        }
    });
}





jQuery(document).ready(function($) {
    $('#add-license-button').click(function() {
        checkAndSaveLicense();
    });

    $('#remove-license-button').click(function() {
        removeLicense();
    });
});
jQuery(document).ready(function() {
    checkAndSaveLicense();  
});