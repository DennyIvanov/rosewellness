<?php
if (!class_exists('Category_Metaboxes')) {

    class Category_Metaboxes {

        public function __construct() {
            //
        }

        /**
         * Initialize the class and start calling our hooks and filters
         */
        public function init() {
            // Image actions
            add_action('category_add_form_fields', array($this, 'add_category_metaboxes'), 10, 2);
            add_action('created_category', array($this, 'save_category_metaboxes'), 10, 2);
            add_action('category_edit_form_fields', array($this, 'update_category_metaboxes'), 10, 2);
            add_action('edited_category', array($this, 'updated_category_metaboxes'), 10, 2);
            add_action('admin_enqueue_scripts', array($this, 'load_media'));
            add_action('admin_footer', array($this, 'add_script'));
        }

        public function load_media() {
            if (!isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'agents') {
                return;
            }
            wp_enqueue_media();
        }

        /**
         * Add a form field in the new category page
         * @since 1.0.0
         */
        public function add_category_metaboxes($taxonomy) {
            ?>
            <div class="form-field term-group">
                <label for="banner-image-id"><?php _e('Banner Image', 'rosewellness'); ?></label>
                <input type="hidden" id="banner-image-id" name="banner-image-id" class="custom_media_url" value="">
                <div id="banner-image-wrapper"></div>
                <p>
                    <input type="button" class="button button-secondary banner_media_button" id="banner_media_button" name="banner_media_button" value="<?php _e('Add Image', 'rosewellness'); ?>" />
                    <input type="button" class="button button-secondary banner_media_remove" id="banner_media_remove" name="banner_media_remove" value="<?php _e('Remove Image', 'rosewellness'); ?>" />
                </p>
            </div>
            
            <div class="form-field term-group">
                <label for="icon-image-id"><?php _e('Category Icon', 'rosewellness'); ?></label>
                <input type="hidden" id="icon-image-id" name="icon-image-id" class="custom_media_url" value="">
                <div id="icon-image-wrapper"></div>
                <p>
                    <input type="button" class="button button-secondary icon_media_button" id="icon_media_button" name="icon_media_button" value="<?php _e('Add Image', 'rosewellness'); ?>" />
                    <input type="button" class="button button-secondary icon_media_remove" id="icon_media_remove" name="icon_media_remove" value="<?php _e('Remove Image', 'rosewellness'); ?>" />
                </p>
            </div>
            <?php
        }

        /**
         * Save the form field
         * @since 1.0.0
         */
        public function save_category_metaboxes($term_id, $tt_id) {
            
            db($_POST);die;
            
            if (isset($_POST['banner-image-id']) && '' !== $_POST['banner-image-id']) {
                add_term_meta($term_id, 'banner-image-id', absint($_POST['banner-image-id']), true);
            }
        }

        /**
         * Edit the form field
         * @since 1.0.0
         */
        public function update_category_metaboxes($term, $taxonomy) {
            
            $featured_cat = get_term_meta($term->term_id, 'featured_cat', true);
            
            if($featured_cat == 'yes') {
                $checkbox = 'checked';
            } else {
                $checkbox = '';
            }
            
            ?>
            <tr class="form-field term-group-wrap">
                <th scope="row">
                    <label for="banner-image-id"><?php _e('Banner Image', 'rosewellness'); ?></label>
                </th>
                <td>
                    <?php $image_id = get_term_meta($term->term_id, 'banner-image-id', true); ?>
                    <input type="hidden" id="banner-image-id" name="banner-image-id" value="<?php echo esc_attr($image_id); ?>">
                    <div id="banner-image-wrapper">
                        <?php if ($image_id) { ?>
                            <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                        <?php } ?>
                    </div>
                    <p>
                        <input type="button" class="button button-secondary banner_media_button" data-id="banner-image-id" name="banner_media_button" value="<?php _e('Add Image', 'rosewellness'); ?>" />
                        <input type="button" class="button button-secondary banner_media_remove" data-id="banner-image-id" name="banner_media_remove" value="<?php _e('Remove Image', 'rosewellness'); ?>" />
                    </p>
                </td>
            </tr>
            <tr class="form-field term-group-wrap">
                <th scope="row">
                    <label for="icon-image-id"><?php _e('Select Blog Category', 'rosewellness'); ?></label>
                </th>
                <td>
                    <input type="checkbox" id="featured_cat" name="featured_cat" value="yes" <?php echo $checkbox; ?> />
                </td>
            </tr>
            <tr class="form-field term-group-wrap">
                <th scope="row">
                    <label for="icon-image-id"><?php _e('Category Icon', 'rosewellness'); ?></label>
                </th>
                <td>
                    <?php $image_id = get_term_meta($term->term_id, 'icon-image-id', true); ?>
                    <input type="hidden" id="icon-image-id" name="icon-image-id" value="<?php echo esc_attr($image_id); ?>">
                    <div id="icon-image-wrapper">
                        <?php if ($image_id) { ?>
                            <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                        <?php } ?>
                    </div>
                    <p>
                        <input type="button" class="button button-secondary icon_media_button" data-id="icon-image-id" name="icon_media_button" value="<?php _e('Add Image', 'rosewellness'); ?>" />
                        <input type="button" class="button button-secondary icon_media_remove" data-id="icon-image-id" name="icon_media_remove" value="<?php _e('Remove Image', 'rosewellness'); ?>" />
                    </p>
                </td>
            </tr>
            <?php
        }

        /**
         * Update the form field value
         * @since 1.0.0
         */
        public function updated_category_metaboxes($term_id, $tt_id) {
            if (isset($_POST['banner-image-id']) && '' !== $_POST['banner-image-id']) {
                update_term_meta($term_id, 'banner-image-id', absint($_POST['banner-image-id']));
            } else {
                update_term_meta($term_id, 'banner-image-id', '');
            }
            
            if (isset($_POST['icon-image-id']) && '' !== $_POST['icon-image-id']) {
                update_term_meta($term_id, 'icon-image-id', absint($_POST['icon-image-id']));
            } else {
                update_term_meta($term_id, 'icon-image-id', '');
            }
            
            if (!empty($_POST['featured_cat'])) {
                update_term_meta($term_id, 'featured_cat', $_POST['featured_cat']);
            } else {
                update_term_meta($term_id, 'featured_cat', '');
            }
        }

        /**
         * Enqueue styles and scripts
         * @since 1.0.0
         */
        public function add_script() {
            if (!isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'category') {
                return;
            }
            ?>
            <script> jQuery(document).ready(function ($) {
                    _wpMediaViewsL10n.insertIntoPost = '<?php _e("Insert", "rosewellness"); ?>';
                    function ct_media_upload(button_class) {
                        var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
                        $('body').on('click', button_class, function (e) {
                            var button_id = '#' + $(this).attr('data-id');
                            var send_attachment_bkp = wp.media.editor.send.attachment;
                            var button = $(button_id);
                            _custom_media = true;
                            wp.media.editor.send.attachment = function (props, attachment) {
                                if (_custom_media) {
                                    $(button_id).val(attachment.id);
                                    $('#video-cat-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                                    $('#video-cat-image-wrapper .custom_media_image').attr('src', attachment.url).css('display', 'block');
                                } else {
                                    return _orig_send_attachment.apply(button_id, [props, attachment]);
                                }
                            }
                            wp.media.editor.open(button);
                            return false;
                        });
                    }
                    ct_media_upload('.banner_media_button.button');
                    ct_media_upload('.icon_media_button.button');
                    $('body').on('click', '.banner_media_remove', function () {
                        var button_id = '#' + $(this).attr('data-id');
                        $(button_id).val('');
                        $('#video-cat-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                    });

                    $(document).ajaxComplete(function (event, xhr, settings) {
                        var queryStringArr = settings.data.split('&');
                        if ($.inArray('action=add-tag', queryStringArr) !== -1) {
                            var xml = xhr.responseXML;
                            $response = $(xml).find('term_id').text();
                            if ($response != "") {
                                // Clear the thumb image
                                $('#video-cat-image-wrapper').html('');
                            }
                        }
                    });
                });
            </script>
            <?php
        }

    }

    $Category_Metaboxes = new Category_Metaboxes();
    $Category_Metaboxes->init();
}