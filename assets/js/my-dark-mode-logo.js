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