<?php
/**
 * Rosewellness Admin Functions
 */
global $rosewellness_general, $rosewellness_custom_theme_options, $rosewellness_post_comments, $rosewellness_hooks, $rosewellness_version;

/**
 * Data validation for Rosewellness General Options
 * 
 * @uses $rosewellness_general array
 * @return Array
 */
function rosewellness_general_validate($input) {
    global $rosewellness_general;
    require_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php' );
    require_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php' );
    //@$file_object = new WP_Filesystem_Direct;
    $default = rosewellness_theme_setup_values();

    if (isset($_POST['rosewellness_submit'])) {
        add_filter('intermediate_image_sizes_advanced', 'rosewellness_create_favicon');
        if ('image' == $input['logo_use'] && !empty($_FILES) && isset($_FILES['html-upload-logo']) && $_FILES['html-upload-logo']['size']) {
            if (substr($_FILES['html-upload-logo']['type'], 0, 5) == 'image') {
                $id = media_handle_upload('html-upload-logo', 0);
                if (is_wp_error($id)) {
                    if (!empty($id->errors['upload_error']))
                        $logo_errors = $id->errors['upload_error'];
                    if (!empty($logo_errors)) {
                        foreach ($logo_errors as $logo_error) {
                            add_settings_error('html-upload-logo', 'html-upload-logo', $logo_error, 'error');
                        }
                    }
                } else {
                    $img_src = wp_get_attachment_image_src($id, 'full', true);
                    $input['logo_upload'] = $img_src[0];
                    $input['logo_id'] = $id;
                    $input['logo_width'] = $img_src[1];
                    $input['logo_height'] = $img_src[2];
                    add_settings_error('html-upload-logo', 'html-upload-logo', __('Logo & Favicon Settings Updated', 'rosewellness'), 'updated');
                }
            } else {
                add_settings_error('html-upload-logo', 'html-upload-logo', __('Please upload a valid image file.', 'rosewellness'), 'error');
            }
        }
        if ('image' == $input['favicon_use'] && !empty($_FILES) && isset($_FILES['html-upload-fav']) && $_FILES['html-upload-fav']['size']) {
            // Upload File button was clicked
            if (substr($_FILES['html-upload-fav']['type'], 0, 5) == 'image') {
                $id = media_handle_upload('html-upload-fav', 0);
                if (is_wp_error($id)) {
                    if (!empty($id->errors['upload_error']))
                        $fav_errors = $id->errors['upload_error'];
                    if (!empty($fav_errors)) {
                        foreach ($fav_errors as $fav_error) {
                            add_settings_error('html-upload-fav', 'html-upload-fav', $fav_error, 'error');
                        }
                    }
                } else {
                    $img_src = wp_get_attachment_image_src($id, 'favicon', true);
                    $input['favicon_upload'] = $img_src[0];
                    $input['favicon_id'] = $id;
                    add_settings_error('html-upload-fav', 'html-upload-fav', __('Logo & Favicon Settings Updated', 'rosewellness'), 'updated');
                }
            } else {
                add_settings_error('html-upload-fav', 'html-upload-fav', __('Please upload a valid image file.', 'rosewellness'), 'error');
            }
        } elseif ('logo' == $input['favicon_use']) {
            if (ROSEWELLNESS_IMG_FOLDER_URL . '/rosewellness-logo.png' == $input['logo_upload']) {
                $input['favicon_upload'] = ROSEWELLNESS_IMG_FOLDER_URL . '/favicon.png';
                $input['favicon_id'] = 0;
            } else {
                $img_src = wp_get_attachment_image_src($input['logo_id'], 'favicon', true);
                $input['favicon_upload'] = $img_src[0];
                $input['favicon_id'] = $input['logo_id'];
            }
        }
        remove_filter('intermediate_image_sizes_advanced', 'rosewellness_create_favicon');

        if ('image' != $input['logo_use']) {
            $input['login_head'] = $rosewellness_general['login_head'];
        }
    } elseif (isset($_POST['rosewellness_logo_favicon_reset'])) {
        $options = maybe_unserialize($rosewellness_general);
        unset($input);

        foreach ($options as $option => $value)
            $input[$option] = $value;

        $input['logo_use'] = $default[0]['logo_use'];
        $input['logo_upload'] = $default[0]['logo_upload'];
        $input['logo_id'] = $default[0]['logo_id'];
        $input['logo_width'] = $default[0]['logo_width'];
        $input['logo_height'] = $default[0]['logo_height'];
        $input['login_head'] = $default[0]['login_head'];
        $input['favicon_use'] = $default[0]['favicon_use'];
        $input['favicon_upload'] = $default[0]['favicon_upload'];
        $input['favicon_id'] = $default[0]['favicon_id'];
        add_settings_error('logo_favicon_settings', 'logo_favicon_reset', __('The Logo Settings have been restored to Default.', 'rosewellness'), 'updated');
    } elseif (isset($_POST['rosewellness_custom_styles_reset'])) {
        $options = maybe_unserialize($rosewellness_general);
        unset($input);

        foreach ($options as $option => $value)
            $input[$option] = $value;

        $input['custom_styles'] = $default[0]['custom_styles'];
        add_settings_error('custom_styles', 'reset_custom_styles', __('Custom Styles has been restored to Default.', 'rosewellness'), 'updated');
    } elseif (isset($_POST['rosewellness_export'])) {
        rosewellness_export();
        die();
    } elseif (isset($_POST['rosewellness_import'])) {
        $general = rosewellness_import($_FILES['rosewellness_import']);
        if ($general && $general != 'ext') {
            unset($input);
            $input = maybe_unserialize($general);
            add_settings_error('rosewellness_import', 'import', __('Rosewellness Options have been imported successfully', 'rosewellness'), 'updated');
        } elseif ($general == 'ext') {
            add_settings_error('rosewellness_import', 'no_import', __('Not a valid LD file', 'rosewellness'));
        } else {
            add_settings_error('rosewellness_import', 'no_import', __('The file is corrupt. There was an error while importing. Please Try Again', 'rosewellness'));
        }
    } elseif (isset($_POST['rosewellness_reset'])) {
        $input = $default[0];
        add_settings_error('rosewellness_general', 'reset_general_options', __('All the Rosewellness General Settings have been restored to default.', 'rosewellness'), 'updated');
    }
    return $input; // Return validated input.
}

/**
 * Data validation for Rosewellness Post & Comments Options
 * 
 * @uses $rosewellness_post_comments array
 * @param array $input all post & comments options inputs.
 * @return Array
 */
function rosewellness_post_comments_validate($input) {
    global $rosewellness_post_comments;
    $default = rosewellness_theme_setup_values();

    if (isset($_POST['rosewellness_submit'])) {
        $input['notices'] = $rosewellness_post_comments['notices'];
        if ($input['summary_show']) {
            $updated = 0;
            if (trim($input['read_text']) != $rosewellness_post_comments['read_text']) {
                $input['read_text'] = trim($input['read_text']);
                $updated++;
            }
            if (!preg_match('/^[0-9]{1,3}$/i', $input['word_limit'])) {
                $input['word_limit'] = $rosewellness_post_comments['word_limit'];
                add_settings_error('word_limit', 'invalid_word_limit', __('The Word Limit provided is invalid. Please provide a proper value.', 'rosewellness'));
            } elseif (trim($input['word_limit']) != $rosewellness_post_comments['word_limit']) {
                $updated++;
            }
            if ($updated) {
                add_settings_error('post_summary_settings', 'post_summary_settings', __('The Post Summary Settings have been updated.', 'rosewellness'), 'updated');
            }
            if ($input['thumbnail_show']) {
                $updated = 0;
                if (!preg_match('/^[0-9]{1,3}$/i', $input['thumbnail_width'])) {
                    $input['thumbnail_width'] = get_option('thumbnail_size_w');
                    add_settings_error('thumbnail_width', 'invalid_thumbnail_width', __('The Thumbnail Width provided is invalid. Please provide a proper value.', 'rosewellness'));
                } elseif (get_option('thumbnail_size_w') != $input['thumbnail_width']) {
                    $input['notices'] = '1';
                    update_option('thumbnail_size_w', $input['thumbnail_width']);
                    $updated++;
                }

                if (!preg_match('/^[0-9]{1,3}$/i', $input['thumbnail_height'])) {
                    $input['thumbnail_height'] = get_option('thumbnail_size_h');
                    add_settings_error('thumbnail_height', 'invalid_thumbnail_height', __('The Thumbnail Height provided is invalid. Please provide a proper value.', 'rosewellness'));
                } elseif (get_option('thumbnail_size_h') != $input['thumbnail_height']) {
                    $input['notices'] = '1';
                    update_option('thumbnail_size_h', $input['thumbnail_height']);
                    $updated++;
                }

                if ($input['thumbnail_crop'] != get_option('thumbnail_crop')) {
                    $input['notices'] = '1';
                    update_option('thumbnail_crop', $input['thumbnail_crop']);
                    $updated++;
                }
                if ($updated) {
                    add_settings_error('post_thumbnail_settings', 'post_thumbnail_settings', __('The Post Thumbnail Settings have been updated', 'rosewellness'), 'updated');
                }
            } else {
                $input['thumbnail_position'] = $rosewellness_post_comments['thumbnail_position'];
                $input['thumbnail_frame'] = $rosewellness_post_comments['thumbnail_frame'];
            }
        } else {
            $input['thumbnail_show'] = $rosewellness_post_comments['thumbnail_show'];
            $input['word_limit'] = $rosewellness_post_comments['word_limit'];
            $input['read_text'] = $rosewellness_post_comments['read_text'];
            $input['thumbnail_position'] = $rosewellness_post_comments['thumbnail_position'];
            $input['thumbnail_frame'] = $rosewellness_post_comments['thumbnail_frame'];
        }

        if (!in_array($input['post_date_format_u'], array($rosewellness_post_comments['post_date_format_u'], 'F j, Y', 'Y/m/d', 'm/d/Y', 'd/m/Y'))) {
            $input['post_date_format_u'] = str_replace('<', '', $input['post_date_format_u']);
            $input['post_date_format_l'] = str_replace('<', '', $input['post_date_format_l']);
            $input['post_date_custom_format_u'] = str_replace('<', '', $input['post_date_custom_format_u']);
            $input['post_date_custom_format_l'] = str_replace('<', '', $input['post_date_custom_format_l']);
        }

        if (!$input['post_date_u']) {
            $input['post_date_format_u'] = $rosewellness_post_comments['post_date_format_u'];
            $input['post_date_custom_format_u'] = $rosewellness_post_comments['post_date_custom_format_u'];
        }

        if (!$input['post_date_l']) {
            $input['post_date_format_l'] = $rosewellness_post_comments['post_date_format_l'];
            $input['post_date_custom_format_l'] = $rosewellness_post_comments['post_date_custom_format_l'];
        }

        if (!$input['post_author_u']) {
            $input['author_count_u'] = $rosewellness_post_comments['author_count_u'];
            $input['author_link_u'] = $rosewellness_post_comments['author_link_u'];
        }

        if (!$input['post_author_l']) {
            $input['author_count_l'] = $rosewellness_post_comments['author_count_l'];
            $input['author_link_l'] = $rosewellness_post_comments['author_link_l'];
        }

        if ($input['pagination_show']) {
            $updated = 0;
            if (trim($input['prev_text']) != $rosewellness_post_comments['prev_text']) {
                $input['prev_text'] = trim($input['prev_text']);
                $updated++;
            }
            if (trim($input['next_text']) != $rosewellness_post_comments['next_text']) {
                $input['next_text'] = trim($input['next_text']);
                $updated++;
            }
            if (!preg_match('/^[0-9]{1,3}$/i', $input['end_size'])) {
                $input['end_size'] = $rosewellness_post_comments['end_size'];
                add_settings_error('end_size', 'invalid_end_size', __('The End Size provided is invalid. Please provide a proper value.', 'rosewellness'));
            }
            if (!preg_match('/^[0-9]{1,3}$/i', $input['mid_size'])) {
                $input['mid_size'] = $rosewellness_post_comments['mid_size'];
                add_settings_error('mid_size', 'invalid_mid_size', __('The Mid Size provided is invalid. Please provide a proper value.', 'rosewellness'));
            }
            if ($updated) {
                add_settings_error('pagination_settings', 'pagination_settings', __('The Pagination Settings have been updated.', 'rosewellness'), 'updated');
            }
        } else {
            $input['prev_text'] = $rosewellness_post_comments['prev_text'];
            $input['next_text'] = $rosewellness_post_comments['next_text'];
            $input['end_size'] = $rosewellness_post_comments['end_size'];
            $input['mid_size'] = $rosewellness_post_comments['mid_size'];
        }

        if (!$input['gravatar_show']) {
            $input['gravatar_size'] = $rosewellness_post_comments['gravatar_size'];
        }
    } elseif (isset($_POST['rosewellness_summary_reset'])) {
        $options = maybe_unserialize($rosewellness_post_comments);
        unset($input);

        foreach ($options as $option => $value)
            $input[$option] = $value;

        $input['notices'] = $rosewellness_post_comments['notices'];
        $input['summary_show'] = $default[1]['summary_show'];
        $input['word_limit'] = $default[1]['word_limit'];
        $input['read_text'] = $default[1]['read_text'];
        add_settings_error('summary', 'reset_summary', __('The Post Summary Settings have been restored to default.', 'rosewellness'), 'updated');
    } elseif (isset($_POST['rosewellness_thumbnail_reset'])) {
        $options = maybe_unserialize($rosewellness_post_comments);
        unset($input);

        foreach ($options as $option => $value)
            $input[$option] = $value;

        $input['notices'] = $rosewellness_post_comments['notices'];
        $input['thumbnail_show'] = $default[1]['thumbnail_show'];
        $input['thumbnail_position'] = $default[1]['thumbnail_position'];
        $input['thumbnail_frame'] = $default[1]['thumbnail_frame'];
        add_settings_error('thumbnail', 'reset_thumbnail', __('The Post Thumbnail Settings have been restored to default.', 'rosewellness'), 'updated');
    } elseif (isset($_POST['rosewellness_meta_reset'])) {
        $options = maybe_unserialize($rosewellness_post_comments);
        unset($input);

        foreach ($options as $option => $value)
            $input[$option] = $value;

        $input['notices'] = $rosewellness_post_comments['notices'];
        $input['post_date_u'] = $default[1]['post_date_u'];
        $input['post_date_format_u'] = $default[1]['post_date_format_u'];
        $input['post_date_custom_format_u'] = $default[1]['post_date_custom_format_u'];
        $input['post_author_u'] = $default[1]['post_author_u'];
        $input['author_count_u'] = $default[1]['author_count_u'];
        $input['author_link_u'] = $default[1]['author_link_u'];
        $input['post_category_u'] = $default[1]['post_category_u'];
        $input['post_tags_u'] = $default[1]['post_tags_u'];
        $input['post_date_l'] = $default[1]['post_date_l'];
        $input['post_date_format_l'] = $default[1]['post_date_format_l'];
        $input['post_date_custom_format_l'] = $default[1]['post_date_custom_format_l'];
        $input['post_author_l'] = $default[1]['post_author_l'];
        $input['author_count_l'] = $default[1]['author_count_l'];
        $input['author_link_l'] = $default[1]['author_link_l'];
        $input['post_category_l'] = $default[1]['post_category_l'];
        $input['post_tags_l'] = $default[1]['post_tags_l'];
        $args = array('_builtin' => false);
        $taxonomies = get_taxonomies($args, 'names');

        if (!empty($taxonomies)) {
            foreach ($taxonomies as $taxonomy) {
                $input['post_' . $taxonomy . '_u'] = '0';
                $input['post_' . $taxonomy . '_l'] = '0';
            }
        }
        add_settings_error('post_meta', 'reset_post_meta', __('The Post Meta Settings have been restored to default.', 'rosewellness'), 'updated');
    } elseif (isset($_POST['rosewellness_pagination_reset'])) {
        $options = maybe_unserialize($rosewellness_post_comments);
        unset($input);

        foreach ($options as $option => $value)
            $input[$option] = $value;

        $input['notices'] = $rosewellness_post_comments['notices'];
        $input['pagination_show'] = $default[1]['pagination_show'];
        $input['prev_text'] = $default[1]['prev_text'];
        $input['next_text'] = $default[1]['next_text'];
        $input['end_size'] = $default[1]['end_size'];
        $input['mid_size'] = $default[1]['mid_size'];
        add_settings_error('pagination', 'reset_pagination', __('The Pagination Settings have been restored to default.', 'rosewellness'), 'updated');
    } elseif (isset($_POST['rosewellness_comment_reset'])) {
        $options = maybe_unserialize($rosewellness_post_comments);
        unset($input);

        foreach ($options as $option => $value)
            $input[$option] = $value;

        $input['notices'] = $rosewellness_post_comments['notices'];
        $input['compact_form'] = $default[1]['compact_form'];
        $input['hide_labels'] = $default[1]['hide_labels'];
        $input['comment_textarea'] = $default[1]['comment_textarea'];
        $input['comment_separate'] = $default[1]['comment_separate'];
        add_settings_error('comment', 'reset_comment', __('The Comment Form Settings have been restored to default.', 'rosewellness'), 'updated');
    } elseif (isset($_POST['rosewellness_gravatar_reset'])) {
        $options = maybe_unserialize($rosewellness_post_comments);
        unset($input);

        foreach ($options as $option => $value)
            $input[$option] = $value;

        $input['notices'] = $rosewellness_post_comments['notices'];
        $input['gravatar_show'] = $default[1]['gravatar_show'];
        $input['gravatar_size'] = $default[1]['gravatar_size'];
        add_settings_error('gravatar', 'reset_gravatar', __('The Gravatar Settings have been restored to default.', 'rosewellness'), 'updated');
    } elseif (isset($_POST['rosewellness_reset'])) {
        $input = $default[1];
        $input['notices'] = $rosewellness_post_comments['notices'];
        $args = array('_builtin' => false);
        $taxonomies = get_taxonomies($args, 'names');
        if (!empty($taxonomies)) {
            foreach ($taxonomies as $taxonomy) {
                $input['post_' . $taxonomy . '_u'] = '0';
                $input['post_' . $taxonomy . '_l'] = '0';
            }
        }
        add_settings_error('rosewellness_post_comments', 'reset_post_comments_options', __('All the Rosewellness Post & Comments Settings have been restored to default.', 'rosewellness'), 'updated');
    }
    return $input; // return validated input
}

/**
 * Setup Default Values for rosewellness
 *
 * This function sets up default values for 'rosewellness' and creates
 * 2 options in the WordPress options table: 'rosewellness_general' &
 * 'rosewellness_post_comments', where the values for the 'General' and
 * 'Post & Comments' tabs are stored respectively
 *
 * @return array.
 */
function rosewellness_theme_setup_values() {
    global $rosewellness_general, $rosewellness_post_comments, $rosewellness_version;

    $default_general = array(
        'logo_use' => 'image',
        'logo_upload' => ROSEWELLNESS_IMG_FOLDER_URL . '/rosewellness-logo.png',
        'logo_id' => 0,
        'logo_width' => 224,
        'logo_height' => 51,
        'login_head' => '0',
        'favicon_use' => 'image',
        'favicon_upload' => ROSEWELLNESS_IMG_FOLDER_URL . '/favicon.png',
        'favicon_id' => 0,
        'custom_styles' => '',
    );

    $default_post_comments = array(
        'notices' => isset($rosewellness_post_comments['notices']) ? $rosewellness_post_comments['notices'] : 0,
        'summary_show' => '1',
        'word_limit' => 55,
        'read_text' => __('Read More&hellip;', 'rosewellness'),
        'thumbnail_show' => '1',
        'thumbnail_position' => 'Right',
        'thumbnail_width' => get_option('thumbnail_size_w'),
        'thumbnail_height' => get_option('thumbnail_size_h'),
        'thumbnail_crop' => get_option('thumbnail_crop'),
        'thumbnail_frame' => '0',
        'post_date_u' => '1',
        'post_date_format_u' => 'F j, Y',
        'post_date_custom_format_u' => 'F j, Y',
        'post_author_u' => '1',
        'author_count_u' => '0',
        'author_link_u' => '1',
        'post_category_u' => '1',
        'post_tags_u' => '0',
        'post_date_l' => '0',
        'post_date_format_l' => 'F j, Y',
        'post_date_custom_format_l' => 'F j, Y',
        'post_author_l' => '0',
        'author_count_l' => '0',
        'author_link_l' => '1',
        'post_category_l' => '0',
        'post_tags_l' => '0',
        'pagination_show' => '1',
        'prev_text' => '&laquo; Previous',
        'next_text' => 'Next &raquo;',
        'end_size' => '1',
        'mid_size' => '2',
        'compact_form' => '1',
        'hide_labels' => '1',
        'comment_textarea' => '0',
        'comment_separate' => '1',
        'attachment_comments' => '0',
        'gravatar_show' => '1',
        'gravatar_size' => '64',
    );

    $args = array('_builtin' => false);
    $taxonomies = get_taxonomies($args, 'names');
    if (!empty($taxonomies)) {
        foreach ($taxonomies as $taxonomy) {
            $default_post_comments['post_' . $taxonomy . '_u'] = '0';
            $default_post_comments['post_' . $taxonomy . '_l'] = '0';
        }
    }

    if (!get_option('rosewellness_general')) {
        update_option('rosewellness_general', $default_general);
        $blog_users = get_users();

        foreach ($blog_users as $blog_user) {
            $blog_user_id = $blog_user->ID;
            if (!get_user_meta($blog_user_id, 'screen_layout_appearance_page_rosewellness_general'))
                update_user_meta($blog_user_id, 'screen_layout_appearance_page_rosewellness_general', 1, NULL);
        }
    }
    if (!get_option('rosewellness_post_comments')) {
        update_option('rosewellness_post_comments', $default_post_comments);
        $blog_users = get_users();

        foreach ($blog_users as $blog_user) {
            $blog_user_id = $blog_user->ID;
            if (!get_user_meta($blog_user_id, 'screen_layout_appearance_page_rosewellness_post_comments'))
                update_user_meta($blog_user_id, 'screen_layout_appearance_page_rosewellness_post_comments', 1, NULL);
        }
    }

    $rosewellness_version = rosewellness_export_version();
    if (!get_option('rosewellness_version') || ( get_option('rosewellness_version') != $rosewellness_version )) {
        update_option('rosewellness_version', $rosewellness_version);
        $updated_general = wp_parse_args($rosewellness_general, $default_general);
        $updated_post_comments = wp_parse_args($rosewellness_post_comments, $default_post_comments);
        update_option('rosewellness_general', $updated_general);
        update_option('rosewellness_post_comments', $updated_post_comments);
    }

    return array($default_general, $default_post_comments);
}

// Redirect to Rosewellness on theme activation //
function rosewellness_theme_activation($themename, $theme = false) {
    global $rosewellness_general;
    $update = 0;
    if (isset($rosewellness_general['logo_show']) && $rosewellness_general['logo_show']) {
        $update++;
        $rosewellness_general['logo_use'] = 'image';
        unset($rosewellness_general['logo_show']);
    } elseif (isset($rosewellness_general['logo_show'])) {
        $update++;
        $rosewellness_general['logo_use'] = 'site_title';
        unset($rosewellness_general['logo_show']);
    }
    if (isset($rosewellness_general['use_logo']) && ( $rosewellness_general['logo_use'] == 'use_logo_url' )) {
        $update++;
        $rosewellness_general['logo_upload'] = $rosewellness_general['logo_url'];
        $id = rosewellness_get_attachment_id_from_src($rosewellness_general['logo_upload'], true);
        $img_dimensions = rosewellness_get_image_dimensions($rosewellness_general['logo_upload'], true, '', $id);
        $rosewellness_general['logo_id'] = $id;
        $rosewellness_general['logo_width'] = $img_dimensions['width'];
        $rosewellness_general['logo_height'] = $img_dimensions['height'];
        unset($rosewellness_general['use_logo']);
        unset($rosewellness_general['logo_url']);
    } elseif (isset($rosewellness_general['use_logo']) && ( $rosewellness_general['use_logo'] == 'use_logo_upload' )) {
        $update++;
        $id = rosewellness_get_attachment_id_from_src($rosewellness_general['logo_upload'], true);
        $img_dimensions = rosewellness_get_image_dimensions($rosewellness_general['logo_upload'], true, '', $id);
        $rosewellness_general['logo_id'] = $id;
        $rosewellness_general['logo_width'] = $img_dimensions['width'];
        $rosewellness_general['logo_height'] = $img_dimensions['height'];
        unset($rosewellness_general['use_logo']);
    }
    if (isset($rosewellness_general['favicon_show']) && $rosewellness_general['favicon_show']) {
        $update++;
        $rosewellness_general['favicon_use'] = 'image';
        unset($rosewellness_general['favicon_show']);
    } elseif (isset($rosewellness_general['favicon_show'])) {
        $update++;
        $rosewellness_general['favicon_use'] = 'disable';
        unset($rosewellness_general['favicon_show']);
    }
    if (isset($rosewellness_general['use_favicon']) && ( $rosewellness_general['use_favicon'] == 'use_favicon_url' )) {
        $update++;
        $rosewellness_general['favicon_upload'] = $rosewellness_general['favicon_url'];
        $id = rosewellness_get_attachment_id_from_src($rosewellness_general['favicon_upload'], true);
        $img_dimensions = rosewellness_get_image_dimensions($rosewellness_general['favicon_upload'], true, '', $id);
        $rosewellness_general['favicon_id'] = $id;
        unset($rosewellness_general['use_favicon']);
    } elseif (isset($rosewellness_general['use_favicon']) && ( $rosewellness_general['use_favicon'] == 'use_favicon_upload' )) {
        $update++;
        $rosewellness_general['favicon_id'] = rosewellness_get_attachment_id_from_src($rosewellness_general['favicon_upload'], true);
        unset($rosewellness_general['use_favicon']);
        unset($rosewellness_general['favicon_url']);
    }
    if ($update) {
        update_option('rosewellness_general', $rosewellness_general);
    }
}

add_action('after_switch_theme', 'rosewellness_theme_activation', '', 2);


/* condition to check Admin Login Logo option */
if (isset($rosewellness_general['logo_use']) && isset($rosewellness_general['login_head']) && ( 'image' == $rosewellness_general['logo_use'] ) && $rosewellness_general['login_head']) {
    add_action('login_head', 'rosewellness_custom_login_logo');
    add_filter('login_headerurl', 'rosewellness_login_site_url');
}

/**
 * Dislays custom logo on Login Page
 *
 * @uses $rosewellness_general array
 */
function rosewellness_custom_login_logo() {
    global $rosewellness_general;
    $custom_logo = $rosewellness_general['logo_upload'];
    if (isset($rosewellness_general['logo_width']) && !empty($rosewellness_general['logo_width']) && isset($rosewellness_general['logo_height']) && !empty($rosewellness_general['logo_height'])) {
        $rosewellness_logo_width = $rosewellness_general['logo_width'];
        $rosewellness_logo_height = $rosewellness_general['logo_height'];
    } else {
        $dimensions = rosewellness_get_image_dimensions($custom_logo, true);
        if (isset($dimensions['width']) && isset($dimensions['height'])) {
            $rosewellness_logo_width = $dimensions['width'];
            $rosewellness_logo_height = $dimensions['height'];
        } else {
            $rosewellness_logo_width = $rosewellness_logo_height = 0;
        }
    }
    $rosewellness_wp_loginbox_width = 312;
    if ($rosewellness_logo_width > $rosewellness_wp_loginbox_width) {
        $ratio = $rosewellness_logo_height / $rosewellness_logo_width;
        $rosewellness_logo_height = ceil($ratio * $rosewellness_wp_loginbox_width);
        $rosewellness_logo_width = $rosewellness_wp_loginbox_width;
        $rosewellness_background_size = 'contain';
    } else {
        $rosewellness_background_size = 'auto';
    }

    echo '<style type="text/css">
        .login h1 { margin-left: 8px; }
        .login h1 a { background: url(' . $custom_logo . ') no-repeat 50% 0;
                background-size: ' . $rosewellness_background_size . ';';
    if ($rosewellness_logo_width && $rosewellness_logo_height) {
        echo 'height: ' . $rosewellness_logo_height . 'px;
              width: ' . $rosewellness_logo_width . 'px; margin: 0 auto 15px; padding: 0; }';
    }
    echo '</style>';
}

/**
 * Returns Home URL, to be used by custom logo
 * 
 * @return string
 */
function rosewellness_login_site_url() {
    return home_url('/');
}

/**
 * Adds Rosewellness Contextual help
 *
 * @return string
 */
function rosewellness_theme_options_help() {

    $general_help = '<p>';
    $general_help .= __('Rosewellness is the most easy to use WordPress Theme. You will find many state of the art options and widgets with rosewellness.', 'rosewellness');
    $general_help .= '</p><p>';
    $general_help .= __('By using rosewellness, users can specify settings for basic functions (like date format, excerpt word count etc.) directly from theme options. ', 'rosewellness');
    $general_help .= __('Rosewellness provides theme options to manage some basic settings for your theme. ', 'rosewellness');
    $general_help .= __('Below are the options provided for your convenience.', 'rosewellness');
    $general_help .= '</p><p>';
    $general_help .= __('<strong>Logo Settings:</strong> Theme\'s logo can be managed from this setting.', 'rosewellness');
    $general_help .= '</p><p>';
    $general_help .= __('<strong>Favicon Settings:</strong> Theme\'s favicon can be managed from this setting.', 'rosewellness');
    $general_help .= '</p><p>';
    $general_help .= __('<strong>Custom Styles:</strong> You can specify your own CSS styles in this option to override the default Style.', 'rosewellness');
    $general_help .= '</p><p>';
    $general_help .= __('<strong>Backup Rosewellness Options:</strong> Export or import all settings that you have configured in rosewellness.', 'rosewellness');
    $general_help .= '</p>';
    $general_help .= '<p>' . __('Remember to click "<strong>Save All Changes</strong>" to save any changes you have made to the theme options.', 'rosewellness') . '</p>';

    $post_comment_help = '<p>';
    $post_comment_help .= __('Rosewellness is the most easy to use WordPress Theme Framework. You will find many state of the art options and widgets with rosewellness.', 'rosewellness');
    $post_comment_help .= '</p><p>';
    $post_comment_help .= __('Rosewellness framework is used worldwide and keeping this in mind we have made it localization ready. ', 'rosewellness');
    $post_comment_help .= __('Developers can use Rosewellness as a basic and stripped to bones theme framework for developing their own creative and wonderful WordPress Themes.', 'rosewellness');
    $post_comment_help .= '</p><p>';
    $post_comment_help .= __('By using rosewellness, developers and users can specify settings for basic functions (like date format, excerpt word count etc.) directly from theme options. ', 'rosewellness');
    $post_comment_help .= __('Rosewellness provides theme options to manage some basic settings for your theme. ', 'rosewellness');
    $post_comment_help .= __('Below are the options provided for your convenience.', 'rosewellness');
    $post_comment_help .= '</p><p>';
    $post_comment_help .= __('<strong>Post Summaries Settings:</strong> Specify the different excerpt parameters like word count etc.', 'rosewellness');
    $post_comment_help .= '</p><p>';
    $post_comment_help .= __('<strong>Post Thumbnail Settings:</strong> Specify the post thumbnail options like position, size etc.', 'rosewellness');
    $post_comment_help .= '<br />';
    $post_comment_help .= __('<small><strong><em>NOTE:</em></strong> If you are using this option to change height or width of the thumbnail, then please use \'Regenerate Thumbnails\' plugin, to apply the new dimension settings to your thumbnails.</small>', 'rosewellness');
    $post_comment_help .= '</p><p>';
    $post_comment_help .= __('<strong>Post Meta Settings:</strong> You can specify the post meta options like post date format, display or hide author name and their positions in relation with the content.', 'rosewellness');
    $post_comment_help .= '</p><p>';
    $post_comment_help .= __('<strong>Pagination Settings:</strong> Enable this setting to use default WordPress pagination.', 'rosewellness');
    $post_comment_help .= '</p><p>';
    $post_comment_help .= __('<strong>Comment Form Settings:</strong> You can specify the comment form settings from this option.', 'rosewellness');
    $post_comment_help .= '</p><p>';
    $post_comment_help .= __('<strong>Gravtar Settings:</strong> Specify the general Gravtar support from this option.', 'rosewellness');
    $post_comment_help .= '</p>';
    $post_comment_help .= '<p>' . __('Remember to click "<strong>Save All Changes</strong>" to save any changes you have made to the theme options.', 'rosewellness') . '</p>';


    $screen = get_current_screen();
    $screen->add_help_tab(array('title' => __('General', 'rosewellness'), 'id' => 'rosewellness-general-help', 'content' => $general_help));
    $screen->add_help_tab(array('title' => __('Post &amp; Comment', 'rosewellness'), 'id' => 'post-comments-help', 'content' => $post_comment_help));
    $screen->set_help_sidebar($sidebar);
}

add_action('load-appearance_page_rosewellness_general', 'rosewellness_theme_options_help');
add_action('load-appearance_page_rosewellness_post_comments', 'rosewellness_theme_options_help');

/**
 * Show Rosewellness only to Admin Users ( Admin-Bar only !!! )
 */
//function rosewellness_admin_bar_init() {
//    // Is the user sufficiently leveled, or has the bar been disabled?
//    if (!is_super_admin() || !is_admin_bar_showing()) {
//        return;
//    }
//    // Good to go, let's do this!
//    add_action('admin_bar_menu', 'rosewellness_admin_bar_links', 500);
//}
//
//add_action('admin_bar_init', 'rosewellness_admin_bar_init');

/**
 * Adds Rosewellness links to Admin Bar
 *
 * @uses object $wp_admin_bar
 */
//function rosewellness_admin_bar_links() {
//    global $wp_admin_bar, $rt_theme;
//
//    // Links to add, in the form: 'Label' => 'URL'
//    foreach ($rt_theme->theme_pages as $key => $theme_page) {
//        if (is_array($theme_page))
//            $links[$theme_page['menu_title']] = array('url' => admin_url('themes.php?page=' . $theme_page['menu_slug']), 'slug' => $theme_page['menu_slug']);
//    }
//
//    //  Add parent link
//    $wp_admin_bar->add_menu(array(
//        'title' => 'Rose Wellness',
//        'href' => admin_url('themes.php?page=rosewellness_general'),
//        'id' => 'rt_links',
//    ));
//
//    // Add submenu links
//    foreach ($links as $label => $menu) {
//        $wp_admin_bar->add_menu(array(
//            'title' => $label,
//            'href' => $menu['url'],
//            'parent' => 'rt_links',
//            'id' => $menu['slug']
//        ));
//    }
//}

/**
 * Creates Rosewellness Options backup file
 * 
 * @uses $wpdb object
 */
function rosewellness_export() {
    global $wpdb;
    $sitename = sanitize_key(get_bloginfo('name'));

    if (!empty($sitename))
        $sitename .= '.';

    $filename = $sitename . 'rosewellness.' . date('Y-m-d') . '.rosewellness';

    $general = "WHERE option_name = 'rosewellness_general'";
    $post_comments = "WHERE option_name = 'rosewellness_post_comments'";
    $hooks = "WHERE option_name = 'rosewellness_hooks'";
    $args['rosewellness_general'] = $wpdb->get_var("SELECT option_value FROM {$wpdb->options} $general");
    $args['rosewellness_post_comments'] = $wpdb->get_var("SELECT option_value FROM {$wpdb->options} $post_comments");
    $args['rosewellness_hooks'] = $wpdb->get_var("SELECT option_value FROM {$wpdb->options} $hooks");

    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename=' . $filename);
    header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);
    ?>
    <rosewellness>
        <rosewellness_version><?php echo maybe_serialize(rosewellness_export_version()); ?></rosewellness_version>
        <rosewellness_general><?php echo $args['rosewellness_general']; ?></rosewellness_general>
        <rosewellness_post_comments><?php echo $args['rosewellness_post_comments']; ?></rosewellness_post_comments>
    </rosewellness>
    <?php
}

/**
 * Restores Rosewellness Options
 *
 * @uses $rosewellness_general array
 * @uses $rosewellness_post_comments array
 * @uses $rosewellness_hooks array
 * @param string $file The
 * @return bool|array
 */
function rosewellness_import($file) {
    global $rosewellness_general, $rosewellness_post_comments;
    require_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php' );
    require_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php' );
    require_once( ABSPATH . '/wp-admin/includes/file.php' );

    @$file_object = new WP_Filesystem_Direct;
    $overrides = array('test_form' => false, 'test_type' => false);
    $import_file = wp_handle_upload($file, $overrides);
    extract(wp_check_filetype($import_file['file'], array('rosewellness' => 'txt/rosewellness')));
    $data = wp_remote_get($import_file['url']);
    $file_object->delete($import_file['file']);
    if ($ext != 'rosewellness') {
        return 'ext';
    }
    if (is_wp_error($data)) {
        return false;
    } else {
        preg_match('/\<rosewellness_general\>(.*)<\/rosewellness_general\>/is', $data['body'], $general);
        preg_match('/\<rosewellness_post_comments\>(.*)<\/rosewellness_post_comments\>/is', $data['body'], $post_comments);
        if (!empty($post_comments[1])) {
            update_option('rosewellness_post_comments', maybe_unserialize($post_comments[1]));
        }
        return $general[1];
    }
}

/**
 * Adds Custom Logo to Admin Dashboard ;)
 */
function rosewellness_custom_admin_logo() {
    echo '<style type="text/css"> #header-logo { background: url("' . ROSEWELLNESS_IMG_FOLDER_URL . '/rosewellness-logo.png") no-repeat scroll center center transparent !important; max-width: 16px; height: auto; } </style>';
}

add_action('admin_head', 'rosewellness_custom_admin_logo');

/**
 * Gets Rosewellness and WordPress version
 */
function rosewellness_export_version() {
    global $wp_version;
    require_once( ABSPATH . '/wp-admin/includes/update.php' );
    /* Backward Compatability for version prior to WordPress 3.4 */
    $theme_info = function_exists('wp_get_theme') ? wp_get_theme() : get_theme(get_current_theme());
    if (is_child_theme()) {
        $theme_info = function_exists('wp_get_theme') ? wp_get_theme('rosewellness') : get_theme($theme_info['Parent Theme']);
    }
    $theme_version = array('wp' => $wp_version, 'rosewellness' => $theme_info['Version']);
    return $theme_version;
}

/**
 * Gets Rosewellness and WordPress version (in text) for footer
 */
function rosewellness_version($update_footer) {
    global $rosewellness_version;
    $update_footer .= ' ' . __('Rose Wellness Center ', 'rosewellness') . $rosewellness_version['rosewellness'];
    return $update_footer;
}

add_filter('update_footer', 'rosewellness_version', 9999);

/**
 * Adds Styles dropdown to TinyMCE Editor
 */
function rosewellness_mce_editor_buttons($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}

add_filter('mce_buttons_2', 'rosewellness_mce_editor_buttons');

/**
 * Adds Non Semantic Helper classes/styles dropdown to TinyMCE Editor
 */
function rosewellness_mce_before_init($settings) {

    $style_formats = array(
        array(
            'title' => 'Clean',
            'block' => 'p',
            'classes' => 'clean',
            'wrapper' => false
        ),
        array(
            'title' => 'Alert',
            'block' => 'p',
            'classes' => 'alert',
            'wrapper' => false
        ),
        array(
            'title' => 'Info',
            'block' => 'p',
            'classes' => 'info',
            'wrapper' => false
        ),
        array(
            'title' => 'Success',
            'block' => 'p',
            'classes' => 'success',
            'wrapper' => false
        ),
        array(
            'title' => 'Warning',
            'block' => 'p',
            'classes' => 'warning',
            'wrapper' => false
        ),
        array(
            'title' => 'Error',
            'block' => 'p',
            'classes' => 'error',
            'wrapper' => false
        )
    );

    $settings['style_formats'] = json_encode($style_formats);
    return $settings;
}

add_filter('tiny_mce_before_init', 'rosewellness_mce_before_init');

/**
 * Adds favicon image to the list of generated images ( For Logo/Favicon Settings )
 */
function rosewellness_create_favicon($sizes) {
    $sizes['favicon'] = array('width' => 16, 'height' => 16, 'crop' => 1);
    return $sizes;
}

/**
 * Default Values for the extended custom theme options
 */
function rosewellness_custom_theme_default_values() {
    $default_values = array(
        'contact_number' => '',
        'copyright_info' => '',
    );

    if (!get_option('custom_theme_options')) {
        update_option('custom_theme_options', $default_values);
        $blog_users = get_users();

        /* Set screen layout to 1 by default for all users */
        foreach ($blog_users as $blog_user) {
            $blog_user_id = $blog_user->ID;
            if (!get_user_meta($blog_user_id, 'screen_layout_appearance_page_custom_theme_options'))
                update_user_meta($blog_user_id, 'screen_layout_appearance_page_custom_theme_options', 1, NULL);
        }
    }

    return $default_values;
}

/**
 * Extended Custom Theme Options Validation Callback
 */
function rosewellness_custom_theme_options_validate($input) {
    if (isset($_POST['rosewellness_submit'])) {
        $input['contact_number'] = trim($input['contact_number']);
        $input['copyright_info'] = trim($input['copyright_info']);
    } elseif (isset($_POST['rosewellness_reset'])) {
        $input = rosewellness_custom_theme_default_values();
        add_settings_error('custom_theme_options', 'reset_custom_theme_options', __('All Custom Theme Options have been restored to default.', 'rosewellness'), 'updated');
    }
    return $input;
}