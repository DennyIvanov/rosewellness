<?php

/**
 * Rosewellness Hooks
 *
 * @package rosewellness
 * 
 */

/**
 * Adds styles or scripts after wp_head()
 *
 */
function rosewellness_head() {
    do_action('rosewellness_head');
}

/**
 * Adds content at the beginning of body
 *
 */
function rosewellness_hook_begin_body() {
    do_action('rosewellness_hook_begin_body');
}

/**
 * Adds content at the end of body
 *
 */
function rosewellness_hook_end_body() {
    do_action('rosewellness_hook_end_body');
}

/**
 * Adds content at the beginning of #main-wrapper
 *
 */
function rosewellness_hook_begin_main_wrapper() {
    do_action('rosewellness_hook_begin_main_wrapper');
}

/**
 * Adds content at the end of #main-wrapper
 *
 */
function rosewellness_hook_end_main_wrapper() {
    do_action('rosewellness_hook_end_main_wrapper');
}

/**
 * Adds content before #header
 *
 */
function rosewellness_hook_before_header() {
    do_action('rosewellness_hook_before_header');
}

/**
 * Adds content after #header
 *
 */
function rosewellness_hook_after_header() {
    do_action('rosewellness_hook_after_header');
}

/**
 * Adds content before site logo
 *
 */
function rosewellness_hook_before_logo() {
    do_action('rosewellness_hook_before_logo');
}

/**
 * Adds content after site logo
 *
 */
function rosewellness_hook_after_logo() {
    do_action('rosewellness_hook_after_logo');
}

/**
 * Adds content at the beginning of #content-wrapper
 *
 */
function rosewellness_hook_begin_content_wrapper() {
    do_action('rosewellness_hook_begin_content_wrapper');
}

/**
 * Adds content at the end of #content-wrapper
 *
 */
function rosewellness_hook_end_content_wrapper() {
    do_action('rosewellness_hook_end_content_wrapper');
}

/**
 * Adds content at the beginning of #content
 *
 */
function rosewellness_hook_begin_content() {
    do_action('rosewellness_hook_begin_content');
}

/**
 * Adds content at the end of #content
 *
 */
function rosewellness_hook_end_content() {
    do_action('rosewellness_hook_end_content');
}

/**
 * Adds content at the beginning of .post
 *
 */
function rosewellness_hook_begin_post() {
    do_action('rosewellness_hook_begin_post');
}

/**
 * Adds content at the end of .post
 *
 */
function rosewellness_hook_end_post() {
    do_action('rosewellness_hook_end_post');
}

/**
 * Adds content before post's title
 *
 */
function rosewellness_hook_begin_post_title() {
    do_action('rosewellness_hook_begin_post_title');
}

/**
 * Adds content after post's title
 *
 */
function rosewellness_hook_end_post_title() {
    do_action('rosewellness_hook_end_post_title');
}

/**
 * Adds Post Meta Box (default behavior)
 *
 */
function rosewellness_hook_post_meta($placement) {
    if ($placement == 'bottom')
        do_action('rosewellness_hook_post_meta_bottom', $placement);
    else
        do_action('rosewellness_hook_post_meta_top', $placement);
}

/**
 * Adds content before Top Post Meta Box
 *
 */
function rosewellness_hook_begin_post_meta_top() {
    do_action('rosewellness_hook_begin_post_meta_top');
}

/**
 * Adds content after Top Post Meta Box
 *
 */
function rosewellness_hook_end_post_meta_top() {
    do_action('rosewellness_hook_end_post_meta_top');
}

/**
 * Adds content before Bottom Post Meta Box
 *
 */
function rosewellness_hook_begin_post_meta_bottom() {
    do_action('rosewellness_hook_begin_post_meta_bottom');
}

/**
 * Adds content after Bottom Post Meta Box
 *
 */
function rosewellness_hook_end_post_meta_bottom() {
    do_action('rosewellness_hook_end_post_meta_bottom');
}

/**
 * Adds content to the beginning of .post-content
 *
 */
function rosewellness_hook_begin_post_content() {
    do_action('rosewellness_hook_begin_post_content');
}

/**
 * Adds content at the end of .post-content
 *
 */
function rosewellness_hook_end_post_content() {
    do_action('rosewellness_hook_end_post_content');
}

/**
 * Basically used for displaying the comment form and comments.
 *
 */
function rosewellness_hook_comments() {
    do_action('rosewellness_hook_comments');
}

/**
 * Basically used for displaying the sidebar.
 *
 */
function rosewellness_hook_sidebar() {
    do_action('rosewellness_hook_sidebar');
}

/**
 * Adds content at the beginning of #sidebar
 *
 */
function rosewellness_hook_begin_sidebar() {
    do_action('rosewellness_hook_begin_sidebar');
}

/**
 * Adds content at the end of #sidebar
 *
 */
function rosewellness_hook_end_sidebar() {
    do_action('rosewellness_hook_end_sidebar');
}

/**
 * Adds content before #footer
 *
 */
function rosewellness_hook_before_footer() {
    do_action('rosewellness_hook_before_footer');
}

/**
 * Adds content after #footer
 *
 */
function rosewellness_hook_after_footer() {
    do_action('rosewellness_hook_after_footer');
}

/**
 * Hook used basically for pagination on single posts
 *
 */
function rosewellness_hook_single_pagination() {
    do_action('rosewellness_hook_single_pagination');
}

/**
 * Hook used basically for pagination on archive listings
 *
 */
function rosewellness_hook_archive_pagination() {
    do_action('rosewellness_hook_archive_pagination');
}

/**
 * Hook used basically for breadcrumb
 *
 */
function rosewellness_hook_breadcrumb() {
    do_action('rosewellness_hook_breadcrumb');
}
