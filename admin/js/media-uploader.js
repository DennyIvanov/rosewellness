/**
 * Theme Options Scripts
 */
jQuery(document).ready(function () {

    /* WP Media Uploader */
    media_uploader_theme_options('.custom_image_uploader');
    
});


/*Media Uploader*/
function media_uploader_theme_options(button_id) {
    var _nflix_media = true;

    jQuery(button_id).click(function () {

        var button = jQuery(this),
                textbox_id = jQuery(this).attr('data-id');
        _nflix_media = true;

        wp.media.editor.send.attachment = function (props, attachment) {

            if (_nflix_media && (attachment.type === 'image')) {
                jQuery('#' + textbox_id).val(attachment.id);
                button.next().show();
            } else {
                alert('Please select a valid image file');
                return false;
            }
        }
        wp.media.editor.open(button);
        return false;
    });

}