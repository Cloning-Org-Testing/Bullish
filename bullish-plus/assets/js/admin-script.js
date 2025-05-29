jQuery(document).ready(function ($) {
    var mediaUploader;

    // Upload button click
    $('#upload_service_icon').on('click', function (e) {
        e.preventDefault();

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media({
            title: 'Select an Icon',
            button: {
                text: 'Use this icon'
            },
            multiple: false
        });

        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            var fileExtension = attachment.url.split('.').pop().toLowerCase();
            var previewHtml = '';

            if (fileExtension === 'svg') {
                previewHtml = '<div id="service_icon">' + '<object type="image/svg+xml" data="' + attachment.url + '" width="100" height="100"></object>' + '</div>';
            } else {
                previewHtml = '<img id="service_icon" src="' + attachment.url + '" style="max-width: 100px; max-height: 100px;" />';
            }

            // Update preview
            $("#service_icon_preview").html(previewHtml);

            // Add remove button if not present
            if (!$('#remove_service_icon').length) {
                $("#service_icon_preview").append('<button type="button" class="button" id="remove_service_icon">Remove Icon</button>');
            }

            // Set hidden field value
            $('input[name="service_icon"]').val(attachment.url);
        });

        mediaUploader.open();
    });

    // Remove button (use delegation in case it's not present on page load)
    $(document).on('click', '#remove_service_icon', function () {
        $('#service_icon_preview').empty();
        $('input[name="service_icon"]').val('');
    });
});
