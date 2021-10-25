<?php
/**
 * Rosewellness options metaboxes
 */

/**
 * Registers Rosewellness General and Post & Comments options
 */
function rosewellness_admin_init_general() {
    register_setting('general_settings', 'rosewellness_general', 'rosewellness_general_validate');
    register_setting('post_comment_settings', 'rosewellness_post_comments', 'rosewellness_post_comments_validate');
    register_setting('custom_theme_options_settings', 'custom_theme_options', 'rosewellness_custom_theme_options_validate');
}

add_action('admin_init', 'rosewellness_admin_init_general');

/**
 * Custom Scripts for image and clone on theme options page
 */
function rosewellness_theme_options_page_scripts() {
    // WP Enqueue Media
    if (function_exists('wp_enqueue_media')) {
        wp_enqueue_media();
    }
    wp_enqueue_style('jquery-ui-css', ROSEWELLNESS_ADMIN . '/css/jquery-ui.css');
    wp_enqueue_script('jquery-ui', ROSEWELLNESS_ADMIN . '/js/jquery-ui.js');
    wp_enqueue_script('media-uploader', ROSEWELLNESS_ADMIN . '/js/media-uploader.js', 'rosewellness-admin-scripts');
}

add_action('admin_print_scripts-appearance_page_theme_options', 'rosewellness_theme_options_page_scripts', 999);
add_action('admin_head', 'rosewellness_theme_options_page_scripts', 999);

/**
 * Logo Settings Metabox - General Tab
 */
function rosewellness_logo_option_metabox() {
    global $rosewellness_general;
    
    $rosewellness_general['logo_use'] = isset($rosewellness_general['logo_use']) ? $rosewellness_general['logo_use'] : 'site_title';
    $rosewellness_general['favicon_use'] = isset($rosewellness_general['favicon_use']) ? $rosewellness_general['favicon_use'] : 'disable';
    $logo_style = ( 'site_title' == $rosewellness_general['logo_use'] ) ? ' style="display: none"' : '';
    $favicon_style = ( in_array($rosewellness_general['favicon_use'], array('disable', 'logo')) ) ? ' style="display: none"' : '';
    ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="logo_use"><?php _e('For Logo', 'rosewellness'); ?></label></th>
                <td colspan="3">
                    <div class="alignleft">
                        <p style="margin-bottom: 10px;"><input type="radio" name="rosewellness_general[logo_use]" value="site_title" id="use_site_title" class="rosewellness_logo" <?php checked('site_title', $rosewellness_general['logo_use']); ?> />
                            <label for="use_site_title" style="margin-right: 30px;"><?php _e('Use Site Title', 'rosewellness'); ?></label>
                            <input type="radio" name="rosewellness_general[logo_use]" value="image" id="use_logo_image" class="rosewellness_logo" <?php checked('image', $rosewellness_general['logo_use']); ?> />
                            <label for="use_logo_image"><?php _e('Upload Logo', 'rosewellness'); ?></label></p>
                        <input type="file" name="html-upload-logo" id="html-upload-logo"<?php echo $logo_style; ?>>
                        <input type="hidden"  name="rosewellness_general[logo_upload]" id="logo_upload_url" value="<?php if (isset($rosewellness_general['logo_upload'])) echo $rosewellness_general['logo_upload']; ?>" />
                        <input type="hidden"  name="rosewellness_general[logo_id]" id="logo_id" value="<?php if (isset($rosewellness_general['logo_id'])) echo $rosewellness_general['logo_id']; ?>" />
                        <input type="hidden"  name="rosewellness_general[logo_width]" id="logo_width" value="<?php if (isset($rosewellness_general['logo_width'])) echo $rosewellness_general['logo_width']; ?>" />
                        <input type="hidden"  name="rosewellness_general[logo_height]" id="logo_height" value="<?php if (isset($rosewellness_general['logo_height'])) echo $rosewellness_general['logo_height']; ?>" />
                        <p class="login-head"<?php echo $logo_style; ?>>
                            <input type="hidden" name="rosewellness_general[login_head]" value="0" />
                            <input type="checkbox" name="rosewellness_general[login_head]" value="1" id="login_head" <?php checked($rosewellness_general['login_head']); ?> />
                            <span class="description"><label for="login_head"><?php printf(__('Check this box to display logo on <a href="%s" title="Wordpress Login">WordPress Login Screen</a>', 'rosewellness'), site_url('/wp-login.php')); ?></label></span>
                        </p>
                    </div>
                    <div class="image-preview alignright" id="logo_metabox"<?php echo $logo_style; ?>>
                        <img alt="Logo" src="<?php echo $rosewellness_general['logo_upload']; ?>" />
                    </div>
                </td>
            </tr>
            
            <!--tr valign="top">
                <th scope="row"><label for="logo_dark_use"><?php _e('For Dark Logo', 'rosewellness'); ?></label></th>
                <td colspan="3">
                    <div class="alignleft">
                        <input type="file" name="rosewellness_general[logo_dark_upload]" value="<?php if (isset($rosewellness_general['logo_dark_upload'])) echo $rosewellness_general['logo_dark_upload']; ?>" />
                    </div>
                    <div class="image-preview alignright" id="logo_metabox"<?php echo $logo_style; ?>>
                        <img alt="Logo" src="<?php echo $rosewellness_general['logo_dark_upload']; ?>" />
                    </div>
                </td>
            </tr-->
            
            <tr valign="top">
                <th scope="row"><label for="favicon_use"><?php _e('For Favicon', 'rosewellness'); ?></label></th>
                <td rowspan="3">
                    <div class="alignleft">
                        <p style="margin-bottom: 10px;"><input type="radio" name="rosewellness_general[favicon_use]" value="disable" id="favicon_disable" class="rosewellness_favicon" <?php checked('disable', $rosewellness_general['favicon_use']); ?> />
                            <label for="favicon_disable" style="margin-right: 30px;"><?php _e('Disable', 'rosewellness'); ?></label>
                            <input type="radio" name="rosewellness_general[favicon_use]" value="logo" id="use_logo" class="rosewellness_favicon" <?php
                            disabled($rosewellness_general['logo_use'], 'site_title');
                            checked('logo', $rosewellness_general['favicon_use']);
                            ?> />
                            <label for="use_logo"  style="margin-right: 30px;"><?php _e('Resize Logo and use as Favicon', 'rosewellness'); ?></label>
                            <input type="radio" name="rosewellness_general[favicon_use]" value="image" id="use_favicon_image" class="rosewellness_favicon" <?php checked('image', $rosewellness_general['favicon_use']); ?> />
                            <label for="use_favicon_image"><?php _e('Upload Favicon', 'rosewellness'); ?></label></p>
                        <input type="file" name="html-upload-fav" id="html-upload-fav"<?php echo $favicon_style; ?>>
                        <input type="hidden"  name="rosewellness_general[favicon_upload]" id="favicon_upload_url" value="<?php if (isset($rosewellness_general['favicon_upload'])) echo $rosewellness_general['favicon_upload']; ?>" />
                        <input type="hidden"  name="rosewellness_general[favicon_id]" id="favicon_id" value="<?php if (isset($rosewellness_general['favicon_id'])) echo $rosewellness_general['favicon_id']; ?>" />
                    </div>
                    <div class="image-preview alignright" id="favicon_metabox"<?php echo ( 'disable' == $rosewellness_general['favicon_use'] ) ? ' style="display: none"' : ''; ?>>
                        <img alt="Favicon" src="<?php echo $rosewellness_general['favicon_upload']; ?>" />
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rosewellness_submit">
        <?php submit_button('Save All Changes', 'primary', 'rosewellness_submit', false); ?>
        <?php submit_button('Reset Logo & Favicon Settings', 'secondary', 'rosewellness_logo_favicon_reset', false); ?>
        <div class="clear"></div>
    </div>
    <?php
}

/**
 * Custom Styles Metabox - General Tab
 */
function rosewellness_custom_styles_metabox() {
    global $rosewellness_general;
    ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="custom_styles"><?php _e('Add your CSS here &rarr;', 'rosewellness'); ?></label></th>
                <td>
                    <textarea cols="80" rows="5" name="rosewellness_general[custom_styles]" id="custom_styles"><?php echo esc_textarea($rosewellness_general['custom_styles']); ?></textarea><br />
                    <span class="description"><label for="custom_styles"><?php _e('Add your extra CSS rules here. No need to use !important. Rules written above will be loaded last.', 'rosewellness'); ?></label></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rosewellness_submit">
        <?php submit_button('Save All Changes', 'primary', 'rosewellness_submit', false); ?>
        <?php submit_button('Reset Custom Styles', 'secondary', 'rosewellness_custom_styles_reset', false); ?>
        <div class="clear"></div>
    </div>
    <?php
}

/**
 * Rosewellness Options Backup / Restore Metabox - General Tab
 */
function rosewellness_backup_metabox() {
    ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th><label for="rosewellness_export"><?php _e('Export Rosewellness Options', 'rosewellness'); ?></label></th>
                <td>
                    <?php submit_button('Export', 'secondary', 'rosewellness_export', false); ?>
                </td>
            </tr>
            <tr valign="top">
                <th><label for="rosewellness_import"><?php _e('Import Rosewellness Options', 'rosewellness'); ?></label></th>
                <td>
                    <input type="file" id="rosewellness_import" name="rosewellness_import" />
                    <?php submit_button('Import', 'secondary', 'rosewellness_import', false); ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

/**
 * Post Summary Settings Metabox - Post & Comments Tab
 */
function rosewellness_post_summaries_metabox() {
    global $rosewellness_post_comments;
    ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="summary_show"><?php _e('Enable Summary', 'rosewellness'); ?></label></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[summary_show]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[summary_show]" value="1" id="summary_show" <?php checked($rosewellness_post_comments['summary_show']); ?> />
                    <span class="description"><label for="summary_show"><?php _e('Check this to enable excerpts on Archive pages ( Pages with multiple posts on them )', 'rosewellness'); ?></label></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="word_limit"><?php _e('Word Limit', 'rosewellness'); ?></label></th>
                <td>
                    <input  maxlength="4" type="number" value="<?php echo $rosewellness_post_comments['word_limit']; ?>" size="4" name="rosewellness_post_comments[word_limit]" id="word_limit" />
                    <span class="description"><label for="word_limit"><?php _e('Post Content will be cut around Word Limit you will specify here.', 'rosewellness'); ?></label></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="read_text"><?php _e('Read More Text', 'rosewellness'); ?></label></th>
                <td>
                    <input type="text" value="<?php echo esc_attr($rosewellness_post_comments['read_text']); ?>" size="30" name="rosewellness_post_comments[read_text]" id="read_text" />
                    <span class="description"><label for="read_text"><?php _e('This will be added after each post summary. Text added here will be automatically converted into a hyperlink pointing to the respective post.', 'rosewellness'); ?></label></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rosewellness_submit">
        <?php submit_button('Save All Changes', 'primary', 'rosewellness_submit', false); ?>
        <?php submit_button('Reset Post Sumarry Settings', 'secondary', 'rosewellness_summary_reset', false); ?>
        <div class="clear"></div>
    </div><?php
}

/**
 * Post Thumbnail Settings Metabox - Post & Comments Tab
 */
function rosewellness_post_thumbnail_metabox() {
    global $rosewellness_post_comments;
    ?> 
    <br />
    <span class="description post-summary-hide"><strong><?php _e('Enable Summary must be checked on the Post Summary Settings to show these Options', 'rosewellness'); ?></strong></span>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="thumbnail_show"><?php _e('Enable Thumbnails', 'rosewellness'); ?></label></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[thumbnail_show]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[thumbnail_show]" value="1" id="thumbnail_show" <?php checked($rosewellness_post_comments['thumbnail_show']); ?> />
                    <span class="description"><label for="thumbnail_show"><?php _e('Check this to display thumbnails as part of Post Summaries on Archive pages', 'rosewellness'); ?></label></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label><?php _e('Thumbnail Alignment', 'rosewellness'); ?></label></th>
                <td>
                    <div class="alignleft"><input type="radio" name="rosewellness_post_comments[thumbnail_position]" value="None" id="None" <?php checked('None', $rosewellness_post_comments['thumbnail_position']); ?> /><label for="None"><?php _e('None', 'rosewellness'); ?></label></div>
                    <div class="alignleft"><input type="radio" name="rosewellness_post_comments[thumbnail_position]" value="Left" id="Left" <?php checked('Left', $rosewellness_post_comments['thumbnail_position']); ?> /><label for="Left"><?php _e('Left', 'rosewellness'); ?></label></div>
                    <div class="alignleft"><input type="radio" name="rosewellness_post_comments[thumbnail_position]" value="Right" id="Right" <?php checked('Right', $rosewellness_post_comments['thumbnail_position']); ?> /><label for="Right"><?php _e('Right', 'rosewellness'); ?></label></div>
                    <div class="alignleft"><input type="radio" name="rosewellness_post_comments[thumbnail_position]" value="Center" id="Center" <?php checked('Center', $rosewellness_post_comments['thumbnail_position']); ?> /><label for="Center"><?php _e('Center', 'rosewellness'); ?></label></div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="thumbnail_width"><?php _e('Width', 'rosewellness'); ?></label></th>
                <td>
                    <input maxlength="3" type="number" value="<?php echo get_option('thumbnail_size_w'); ?>" size="3" name="rosewellness_post_comments[thumbnail_width]" id="thumbnail_width" /> px
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="thumbnail_height"><?php _e('Height', 'rosewellness'); ?></label></th>
                <td>
                    <input maxlength="3" type="number" value="<?php echo get_option('thumbnail_size_h'); ?>" size="3" name="rosewellness_post_comments[thumbnail_height]" id="thumbnail_height" /> px
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="thumbnail_crop"><?php _e('Crop Thumbnail', 'rosewellness'); ?></label></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[thumbnail_crop]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[thumbnail_crop]" value="1" id="thumbnail_crop" <?php checked(get_option('thumbnail_crop')); ?> />
                    <span class="description"><label for="thumbnail_crop"><?php _e('Crop thumbnail to exact dimensions (normally thumbnails are proportional)', 'rosewellness'); ?></label></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="thumbnail_frame"><?php _e('Add Frame (Border Effect around Image)', 'rosewellness'); ?></label></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[thumbnail_frame]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[thumbnail_frame]" value="1" id="thumbnail_frame" <?php echo checked($rosewellness_post_comments['thumbnail_frame']) ?> />
                    <span class="description"><label for="thumbnail_frame"><?php _e('Check this to display a light shadow border effect for the thumbnails', 'rosewellness'); ?></label></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rosewellness_submit">
        <?php submit_button('Save All Changes', 'primary', 'rosewellness_submit', false); ?>
        <?php submit_button('Reset Post Thumbnail Settings', 'secondary', 'rosewellness_thumbnail_reset', false); ?>
        <div class="clear"></div>
    </div><?php
}

/**
 * Post Meta Settings Metabox - Post & Comments Tab
 */
function rosewellness_post_meta_metabox() {
    global $rosewellness_post_comments;
    $date_format_u = ( $rosewellness_post_comments['post_date_format_u'] != 'F j, Y' && $rosewellness_post_comments['post_date_format_u'] != 'Y/m/d' && $rosewellness_post_comments['post_date_format_u'] != 'm/d/Y' && $rosewellness_post_comments['post_date_format_u'] != 'd/m/Y' ) ? true : false;
    $date_format_l = ( $rosewellness_post_comments['post_date_format_l'] != 'F j, Y' && $rosewellness_post_comments['post_date_format_l'] != 'Y/m/d' && $rosewellness_post_comments['post_date_format_l'] != 'm/d/Y' && $rosewellness_post_comments['post_date_format_l'] != 'd/m/Y' ) ? true : false;
    $args = array('_builtin' => false);
    $taxonomies = get_taxonomies($args, 'objects');
    ?><br />
    <span class="description"><strong><?php _e('This option will allow you to specify the post meta attributes and their position', 'rosewellness'); ?></strong></span><br /><br />
    <strong><?php _e('These Post Meta will be displayed above content', 'rosewellness'); ?></strong>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><p><label for="post_date_u"><?php _e('Post Date', 'rosewellness'); ?></label></p></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[post_date_u]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[post_date_u]" value="1" id="post_date_u" <?php checked($rosewellness_post_comments['post_date_u']); ?> />
                    <span class="description"><label for="post_date_u"><?php _e('Check this box to include Post Dates in meta', 'rosewellness'); ?></label></span>
                    <div class="post-meta-common post_date_format_u">
                        <strong><?php _e('Select a Date Format', 'rosewellness'); ?> :</strong><br />
                        <input type="radio" name="rosewellness_post_comments[post_date_format_u]" id="full-date-u" value="F j, Y" <?php checked('F j, Y', $rosewellness_post_comments['post_date_format_u']); ?> /><label class="full-date-u" for="full-date-u" title="F j, Y"><?php echo date_i18n(__('F j, Y', 'rosewellness')); ?></label><br />
                        <input type="radio" name="rosewellness_post_comments[post_date_format_u]" id="y-m-d-u" value="Y/m/d" <?php checked('Y/m/d', $rosewellness_post_comments['post_date_format_u']); ?> /><label class="y-m-d-u" for="y-m-d-u" title="Y/m/d"><?php echo date_i18n(__('Y/m/d', 'rosewellness')); ?></label><br />
                        <input type="radio" name="rosewellness_post_comments[post_date_format_u]" id="m-d-y-u" value="m/d/Y" <?php checked('m/d/Y', $rosewellness_post_comments['post_date_format_u']); ?> /><label class="m-d-y-u" for="m-d-y-u" title="m/d/Y"><?php echo date_i18n(__('m/d/Y', 'rosewellness')); ?></label><br />
                        <input type="radio" name="rosewellness_post_comments[post_date_format_u]" id="d-m-y-u" value="d/m/Y" <?php checked('d/m/Y', $rosewellness_post_comments['post_date_format_u']); ?> /><label class="d-m-y-u" for="d-m-y-u" title="d/m/Y"><?php echo date_i18n(__('d/m/Y', 'rosewellness')); ?></label><br />
                        <input type="radio" name="rosewellness_post_comments[post_date_format_u]" id="post_date_custom_format_u" value="<?php echo esc_attr($rosewellness_post_comments['post_date_custom_format_u']); ?>" <?php checked($date_format_u); ?> /><label for="custom-date-u" title="<?php echo esc_attr($rosewellness_post_comments['post_date_custom_format_u']); ?>">Custom :<input id="custom-date-u" value="<?php echo esc_attr($rosewellness_post_comments['post_date_custom_format_u']); ?>" type="text" size="5" name="rosewellness_post_comments[post_date_custom_format_u]" /> <span><?php echo date_i18n($rosewellness_post_comments['post_date_custom_format_u']); ?></span><img class="ajax-loading" alt="loading.." src="<?php echo admin_url('/images/wpspin_light.gif'); ?>" /></label><br />
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><p><label for="post_author_u"><?php _e('Post Author', 'rosewellness'); ?></label></p></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[post_author_u]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[post_author_u]" value="1" id="post_author_u" <?php checked($rosewellness_post_comments['post_author_u']); ?> />
                    <span class="description"><label for="post_author_u"><?php _e('Check this box to include Author Name in meta', 'rosewellness'); ?></label></span>
                    <div class="post-meta-common post_author_u-sub">
                        <input type="hidden" name="rosewellness_post_comments[author_count_u]" value="0" />
                        <input type="checkbox" name="rosewellness_post_comments[author_count_u]" value="1" id="author_count_u" <?php checked($rosewellness_post_comments['author_count_u']); ?> /><label for="author_count_u"><?php _e('Show Author Posts Count', 'rosewellness'); ?></label><br />
                        <input type="hidden" name="rosewellness_post_comments[author_link_u]" value="0" />
                        <input type="checkbox" name="rosewellness_post_comments[author_link_u]" value="1" id="author_link_u" <?php checked($rosewellness_post_comments['author_link_u']); ?> /><label for="author_link_u"><?php _e('Link to Author Archive page', 'rosewellness'); ?></label><br />
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><p><label for="post_category_u"><?php _e('Post Categories', 'rosewellness'); ?></label></p></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[post_category_u]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[post_category_u]" value="1" id="post_category_u" <?php checked($rosewellness_post_comments['post_category_u']); ?> />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><p><label for="post_tags_u"><?php _e('Post Tags', 'rosewellness'); ?></label></p></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[post_tags_u]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[post_tags_u]" value="1" id="post_tags_u" <?php checked($rosewellness_post_comments['post_tags_u']); ?> />
                </td>
            </tr><?php
            if (!empty($taxonomies)) {
                foreach ($taxonomies as $key => $taxonomy) {
                    $rosewellness_post_comments['post_' . $key . '_u'] = ( isset($rosewellness_post_comments['post_' . $key . '_u']) ) ? $rosewellness_post_comments['post_' . $key . '_u'] : 0;
                    ?>
                    <tr valign="top">
                        <th scope="row"><p><label for="<?php echo 'post_' . $key . '_u'; ?>"><?php printf(__('%s', 'rosewellness'), $taxonomy->labels->name); ?></label></p></th>
                        <td>
                            <input type="hidden" name="rosewellness_post_comments[<?php echo 'post_' . $key . '_u'; ?>]" value="0" />
                            <input type="checkbox" name="rosewellness_post_comments[<?php echo 'post_' . $key . '_u'; ?>]" value="1" id="<?php echo 'post_' . $key . '_u'; ?>" <?php checked($rosewellness_post_comments['post_' . $key . '_u']); ?> />
                        </td>
                    </tr><?php
                }
            }
            ?>
        </tbody>
    </table>
    <br />
    <strong><?php _e('These Post Meta will be displayed below content', 'rosewellness'); ?></strong>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><p><label for="post_date_l"><?php _e('Post Date', 'rosewellness'); ?></label></p></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[post_date_l]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[post_date_l]" value="1" id="post_date_l" <?php checked($rosewellness_post_comments['post_date_l']); ?> />
                    <span class="description"><label for="post_date_l"><?php _e('Check this box to include Post Dates in meta', 'rosewellness'); ?></label></span>
                    <div class="post-meta-common post_date_format_l">
                        <strong><?php _e('Select a Date Format', 'rosewellness'); ?> :</strong><br />
                        <input type="radio" name="rosewellness_post_comments[post_date_format_l]" id="full-date-l" value="F j, Y" <?php checked('F j, Y', $rosewellness_post_comments['post_date_format_l']); ?> /><label class="full-date-l" for="full-date-l" title="F j, Y"><?php echo date_i18n(__('F j, Y', 'rosewellness')); ?></label><br />
                        <input type="radio" name="rosewellness_post_comments[post_date_format_l]" id="y-m-d-l" value="Y/m/d" <?php checked('Y/m/d', $rosewellness_post_comments['post_date_format_l']); ?> /><label class="y-m-d-l" for="y-m-d-l" title="Y/m/d"><?php echo date_i18n(__('Y/m/d', 'rosewellness')); ?></label><br />
                        <input type="radio" name="rosewellness_post_comments[post_date_format_l]" id="m-d-y-l" value="m/d/Y" <?php checked('m/d/Y', $rosewellness_post_comments['post_date_format_l']); ?> /><label class="m-d-y-l" for="m-d-y-l" title="m/d/Y"><?php echo date_i18n(__('m/d/Y', 'rosewellness')); ?></label><br />
                        <input type="radio" name="rosewellness_post_comments[post_date_format_l]" id="d-m-y-l" value="d/m/Y" <?php checked('d/m/Y', $rosewellness_post_comments['post_date_format_l']); ?> /><label class="d-m-y-l" for="d-m-y-l" title="d/m/Y"><?php echo date_i18n(__('d/m/Y', 'rosewellness')); ?></label><br />
                        <input type="radio" name="rosewellness_post_comments[post_date_format_l]" id="post_date_custom_format_l" value="<?php echo esc_attr($rosewellness_post_comments['post_date_custom_format_l']); ?>" <?php checked($date_format_l); ?> /><label for="custom-date-l" title="<?php echo esc_attr($rosewellness_post_comments['post_date_custom_format_l']); ?>">Custom :<input id="custom-date-l" value="<?php echo esc_attr($rosewellness_post_comments['post_date_custom_format_l']); ?>" type="text" size="5" name="rosewellness_post_comments[post_date_custom_format_l]" /> <span><?php echo date_i18n($rosewellness_post_comments['post_date_custom_format_l']); ?></span><img class="ajax-loading" alt="loading.." src="<?php echo admin_url('/images/wpspin_light.gif'); ?>" /></label><br />
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><p><label for="post_author_l"><?php _e('Post Author', 'rosewellness'); ?></label></p></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[post_author_l]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[post_author_l]" value="1" id="post_author_l" <?php checked($rosewellness_post_comments['post_author_l']); ?> />
                    <span class="description"><label for="post_author_l"><?php _e('Check this box to include Author Name in meta', 'rosewellness'); ?></label></span>
                    <div class="post-meta-common post_author_l-sub">
                        <input type="hidden" name="rosewellness_post_comments[author_count_l]" value="0" />
                        <input type="checkbox" name="rosewellness_post_comments[author_count_l]" value="1" id="author_count_l" <?php checked($rosewellness_post_comments['author_count_l']); ?> /><label for="author_count_l"><?php _e('Show Author Posts Count', 'rosewellness'); ?></label><br />
                        <input type="hidden" name="rosewellness_post_comments[author_link_l]" value="0" />
                        <input type="checkbox" name="rosewellness_post_comments[author_link_l]" value="1" id="author_link_l" <?php checked($rosewellness_post_comments['author_link_l']); ?> /><label for="author_link_l"><?php _e('Link to Author Archive page', 'rosewellness'); ?></label><br />
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><p><label for="post_category_l"><?php _e('Post Categories', 'rosewellness'); ?></label></p></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[post_category_l]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[post_category_l]" value="1" id="post_category_l" <?php checked($rosewellness_post_comments['post_category_l']); ?> />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><p><label for="post_tags_l"><?php _e('Post Tags', 'rosewellness'); ?></label></p></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[post_tags_l]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[post_tags_l]" value="1" id="post_tags_l" <?php checked($rosewellness_post_comments['post_tags_l']); ?> />
                </td>
            </tr><?php
            if (!empty($taxonomies)) {
                foreach ($taxonomies as $key => $taxonomy) {
                    $rosewellness_post_comments['post_' . $key . '_l'] = ( isset($rosewellness_post_comments['post_' . $key . '_l']) ) ? $rosewellness_post_comments['post_' . $key . '_l'] : 0;
                    ?>
                    <tr valign="top">
                        <th scope="row"><p><label for="<?php echo 'post_' . $key . '_l'; ?>"><?php printf(__('%s', 'rosewellness'), $taxonomy->labels->name); ?></label></p></th>
                        <td>
                            <input type="hidden" name="rosewellness_post_comments[<?php echo 'post_' . $key . '_l'; ?>]" value="0" />
                            <input type="checkbox" name="rosewellness_post_comments[<?php echo 'post_' . $key . '_l'; ?>]" value="1" id="<?php echo 'post_' . $key . '_l'; ?>" <?php checked($rosewellness_post_comments['post_' . $key . '_l']); ?> />
                        </td>
                    </tr><?php
                }
            }
            ?>
        </tbody>
    </table>
    <div class="rosewellness_submit">
        <?php submit_button('Save All Changes', 'primary', 'rosewellness_submit', false); ?>
        <?php submit_button('Reset Post Meta Settings', 'secondary', 'rosewellness_meta_reset', false); ?>
        <div class="clear"></div>
    </div><?php
}

/**
 * Pagination Settings Metabox - Post & Comments Tab
 */
function rosewellness_pagination_metabox() {
    global $rosewellness_post_comments;
    ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="pagination_show"><?php _e('Enable Pagination', 'rosewellness'); ?></label></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[pagination_show]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[pagination_show]" value="1" id="pagination_show" <?php checked($rosewellness_post_comments['pagination_show']); ?> />
                    <span class="description"><label for="pagination_show"><?php _e('Check this to enable default WordPress Pagination on Archive pages ( Pages with multiple posts on them )', 'rosewellness'); ?></label></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="prev_text"><?php _e('Prev Text', 'rosewellness'); ?></label></th>
                <td>
                    <input type="text" value="<?php echo esc_attr($rosewellness_post_comments['prev_text']); ?>" size="30" name="rosewellness_post_comments[prev_text]" id="prev_text" />
                    <span class="description"><label for="prev_text"><?php _e('Text to display for Previous Page', 'rosewellness'); ?></label></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="next_text"><?php _e('Next Text', 'rosewellness'); ?></label></th>
                <td>
                    <input type="text" value="<?php echo esc_attr($rosewellness_post_comments['next_text']); ?>" size="30" name="rosewellness_post_comments[next_text]" id="next_text" />
                    <span class="description"><label for="next_text"><?php _e('Text to display for Next Page', 'rosewellness'); ?></label></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="end_size"><?php _e('End Size', 'rosewellness'); ?></label></th>
                <td>
                    <input  maxlength="4" type="number" value="<?php echo $rosewellness_post_comments['end_size']; ?>" size="4" name="rosewellness_post_comments[end_size]" id="end_size" />
                    <span class="description"><label for="end_size"><?php _e('How many numbers on either the start and the end list edges?', 'rosewellness'); ?></label></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="mid_size"><?php _e('Mid Size', 'rosewellness'); ?></label></th>
                <td>
                    <input  maxlength="4" type="number" value="<?php echo $rosewellness_post_comments['mid_size']; ?>" size="4" name="rosewellness_post_comments[mid_size]" id="mid_size" />
                    <span class="description"><label for="mid_size"><?php _e('How many numbers to either side of current page, but not including current page?', 'rosewellness'); ?></label></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rosewellness_submit">
        <?php submit_button('Save All Changes', 'primary', 'rosewellness_submit', false); ?>
        <?php submit_button('Reset Pagination Settings', 'secondary', 'rosewellness_pagination_reset', false); ?>
        <div class="clear"></div>
    </div><?php
}

/**
 * Comment Form Settings Metabox - Post & Comments Tab
 */
function rosewellness_comment_form_metabox() {
    global $rosewellness_post_comments;
    ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><p><label for="compact_form"><?php _e('Enable Compact Form', 'rosewellness'); ?></label></p></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[compact_form]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[compact_form]" value="1" id="compact_form" <?php checked($rosewellness_post_comments['compact_form']); ?> />
                    <span class="description"><label for="compact_form"><?php _e('Check this box to compact comment form. Name, URL & Email Fields will be on same line', 'rosewellness'); ?></label></span>
                    <br />
                    <input type="hidden" name="rosewellness_post_comments[hide_labels]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[hide_labels]" value="1" id="hide_labels" <?php checked($rosewellness_post_comments['hide_labels']); ?> />
                    <span class="description"><label for="hide_labels"><?php _e('Hide Labels for Name, Email & URL. These will be shown inside fields as default text', 'rosewellness'); ?></label></span>
                </td>
            </tr>
            <tr valign="top" class="show-fields-comments">
                <th scope="row"><p><label for="comment_textarea"><?php _e('Extra Settings', 'rosewellness'); ?></label></p></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[comment_textarea]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[comment_textarea]" value="1" id="comment_textarea" <?php checked($rosewellness_post_comments['comment_textarea']); ?> />
                    <span class="description"><label for="comment_textarea"><?php _e('Display Comment textarea above Name, Email, &amp; URL Fields', 'rosewellness'); ?></label></span>
                    <br />
                    <input type="hidden" name="rosewellness_post_comments[comment_separate]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[comment_separate]" value="1" id="comment_separate" <?php checked($rosewellness_post_comments['comment_separate']); ?> />
                    <span class="description"><label for="comment_separate"><?php _e('Separate Comments from Trackbacks &amp; Pingbacks', 'rosewellness'); ?></label></span>
                    <br />
                    <input type="hidden" name="rosewellness_post_comments[attachment_comments]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[attachment_comments]" value="1" id="attachment_comments" <?php checked($rosewellness_post_comments['attachment_comments']); ?> />
                    <span class="description"><label for="attachment_comments"><?php _e('Enable the comment form on Attachments', 'rosewellness'); ?></label></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rosewellness_submit">
        <?php submit_button('Save All Changes', 'primary', 'rosewellness_submit', false); ?>
        <?php submit_button('Reset Comment Form Settings', 'secondary', 'rosewellness_comment_reset', false); ?>
        <div class="clear"></div>
    </div><?php
}

/**
 * Gravatar Settings Metabox - Post & Comments Tab
 */
function rosewellness_gravatar_metabox() {
    global $rosewellness_post_comments;
    ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><p><label for="gravatar_show"><?php _e('Enable Gravatar Support', 'rosewellness'); ?></label></p></th>
                <td>
                    <input type="hidden" name="rosewellness_post_comments[gravatar_show]" value="0" />
                    <input type="checkbox" name="rosewellness_post_comments[gravatar_show]" value="1" id="gravatar_show" <?php checked($rosewellness_post_comments['gravatar_show']); ?> />
                </td>
            </tr>
            <tr valign="top" class="gravatar-size">
                <th scope="row"><p><label for="gravatar_size"><?php _e('Gravatar Size', 'rosewellness'); ?></label></p></th>
                <td>
                    <select name="rosewellness_post_comments[gravatar_size]" id="gravatar_size">
                        <option value="32" <?php selected('32', $rosewellness_post_comments['gravatar_size']); ?>>32px X 32px</option>
                        <option value="40" <?php selected('40', $rosewellness_post_comments['gravatar_size']); ?>>40px X 40px</option>
                        <option value="48" <?php selected('48', $rosewellness_post_comments['gravatar_size']); ?>>48px X 48px</option>
                        <option value="56" <?php selected('56', $rosewellness_post_comments['gravatar_size']); ?>>56px X 56px</option>
                        <option value="64" <?php selected('64', $rosewellness_post_comments['gravatar_size']); ?>>64px X 64px</option>
                        <option value="96" <?php selected('96', $rosewellness_post_comments['gravatar_size']); ?>>96px X 96px</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rosewellness_submit">
        <?php submit_button('Save All Changes', 'primary', 'rosewellness_submit', false); ?>
        <?php submit_button('Reset Gravatar Settings', 'secondary', 'rosewellness_gravatar_reset', false); ?>
        <div class="clear"></div>
    </div><?php
}

/**
 * Extended Banner Section Theme Options Metabox Markup
 */
function banner_section_metabox() {
    global $rosewellness_custom_theme_options;
    $rosewellness_custom_theme_options = ( get_option('custom_theme_options') ) ? get_option('custom_theme_options') : rosewellness_custom_theme_default_values();
    ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row"><label for="banner_heading"><?php _e('Banner Heading', 'rosewellness'); ?></label></th>
                <td>
                    <input type="text" value="<?php echo $rosewellness_custom_theme_options['banner_heading']; ?>" size="50" name="custom_theme_options[banner_heading]" id="banner_heading" />
                </td>
            </tr>
			<tr>
                <th scope="row"><label for="banner_subheading"><?php _e('Banner Subheading', 'rosewellness'); ?></label></th>
                <td>
                    <input type="text" value="<?php echo $rosewellness_custom_theme_options['banner_subheading']; ?>" size="50" name="custom_theme_options[banner_subheading]" id="banner_subheading" />
                </td>
            </tr>
			<tr>
                <th scope="row"><label for="banner_anchor_text"><?php _e('Banner Anchor Text', 'rosewellness'); ?></label></th>
                <td>
                    <input type="text" value="<?php echo $rosewellness_custom_theme_options['banner_anchor_text']; ?>" size="50" name="custom_theme_options[banner_anchor_text]" id="banner_anchor_text" />
                </td>
            </tr>
			<tr>
                <th scope="row"><label for="banner_anchor_url"><?php _e('Banner Anchor Link', 'rosewellness'); ?></label></th>
                <td>
                    <input type="text" value="<?php echo $rosewellness_custom_theme_options['banner_anchor_url']; ?>" size="50" name="custom_theme_options[banner_anchor_url]" id="banner_anchor_url" />
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

/**
 * Extended Footer Details Theme Options Metabox Markup
 */
function footer_details_metabox() {
    global $rosewellness_custom_theme_options;
    $rosewellness_custom_theme_options = ( get_option('custom_theme_options') ) ? get_option('custom_theme_options') : rosewellness_custom_theme_default_values();
    ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row"><label for="header_top_bar"><?php _e('Header Top Bar', 'rosewellness'); ?></label></th>
                <td>
                    <textarea rows="5" cols="52" name="custom_theme_options[header_top_bar]" id="header_top_bar"><?php echo $rosewellness_custom_theme_options['header_top_bar']; ?></textarea>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="header_btn_text_1"><?php _e('Header Button Text 1', 'rosewellness'); ?></label></th>
                <td>
                    <input type="text" value="<?php echo $rosewellness_custom_theme_options['header_btn_text_1']; ?>" size="50" name="custom_theme_options[header_btn_text_1]" id="header_btn_text_1" />
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="header_btn_url_1"><?php _e('Header Button URL 1', 'rosewellness'); ?></label></th>
                <td>
                    <input type="text" value="<?php echo $rosewellness_custom_theme_options['header_btn_url_1']; ?>" size="50" name="custom_theme_options[header_btn_url_1]" id="header_btn_url_1" />
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="header_btn_text_2"><?php _e('Header Button Text 2', 'rosewellness'); ?></label></th>
                <td>
                    <input type="text" value="<?php echo $rosewellness_custom_theme_options['header_btn_text_2']; ?>" size="50" name="custom_theme_options[header_btn_text_2]" id="header_btn_text_2" />
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="header_btn_text_3"><?php _e('Header Button Text 3', 'rosewellness'); ?></label></th>
                <td>
                    <input type="text" value="<?php echo $rosewellness_custom_theme_options['header_btn_text_3']; ?>" size="50" name="custom_theme_options[header_btn_text_3]" id="header_btn_text_3" />
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="header_btn_url_2"><?php _e('Header Button URL 2', 'rosewellness'); ?></label></th>
                <td>
                    <input type="text" value="<?php echo $rosewellness_custom_theme_options['header_btn_url_2']; ?>" size="50" name="custom_theme_options[header_btn_url_2]" id="header_btn_url_2" />
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="popup_title"><?php _e('PopUp Title', 'rosewellness'); ?></label></th>
                <td>
                    <input type="text" value="<?php echo $rosewellness_custom_theme_options['popup_title']; ?>" size="50" name="custom_theme_options[popup_title]" id="popup_title" />
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="popup_subtitle"><?php _e('PopUp Subtitle', 'rosewellness'); ?></label></th>
                <td>
                    <input type="text" value="<?php echo $rosewellness_custom_theme_options['popup_subtitle']; ?>" size="50" name="custom_theme_options[popup_subtitle]" id="popup_subtitle" />
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="copyright_info"><?php _e('Copyright Text', 'rosewellness'); ?></label></th>
                <td>
                    <textarea rows="5" cols="52" name="custom_theme_options[copyright_info]"><?php echo $rosewellness_custom_theme_options['copyright_info']; ?></textarea>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}
