<?php
/**
 * Rosewellness default functions
 *
 * @package rosewellness
 *
 */

/**
 * Checks whether the post meta div needs to be displayed or not
 *
 * @uses $rosewellness_post_comments Post Comments DB array
 * @uses $post Post Data
 * @param string $position Specify the position of the post meta (u/l)
 *
 */
function rosewellness_has_postmeta($position = 'u') {
    global $post, $rosewellness_post_comments;
    $can_edit = ( get_edit_post_link() ) ? 1 : 0;
    $flag = 0;
    // Show Author?
    if ($rosewellness_post_comments['post_author_' . $position]) {
        $flag++;
    }
    // Show Date?
    elseif ($rosewellness_post_comments['post_date_' . $position]) {
        $flag++;
    }
    // Show Category?
    elseif (get_the_category_list() && $rosewellness_post_comments['post_category_' . $position]) {
        $flag++;
    }
    // Show Tags?
    elseif (get_the_tag_list() && $rosewellness_post_comments['post_tags_' . $position]) {
        $flag++;
    }
    // Checked if logged in and post meta top
    else if ($can_edit && $position == 'u') {
        $flag++;
    } elseif (( has_action('rosewellness_hook_begin_post_meta_top') || ( has_action('rosewellness_hook_end_post_meta_top') && $can_edit ) ) && $position == 'u') {
        $flag++;
    } elseif (( has_action('rosewellness_hook_begin_post_meta_bottom') || has_action('rosewellness_hook_end_post_meta_bottom') ) && $position == 'l') {
        $flag++;
    } else {
        // Show Custom Taxonomies?
        $args = array('_builtin' => false);
        $taxonomies = get_taxonomies($args, 'names');
        foreach ($taxonomies as $taxonomy) {
            if (get_the_terms($post->ID, $taxonomy) && isset($rosewellness_post_comments['post_' . $taxonomy . '_' . $position]) && $rosewellness_post_comments['post_' . $taxonomy . '_' . $position]) {
                $flag++;
            }
        }
    }

    return $flag;
}

/**
 * Default post meta
 *
 * @uses $rosewellness_post_comments Post Comments DB array
 * @uses $post Post Data
 * @param string $placement Specify the position of the post meta (top/bottom)
 *
 */
function rosewellness_default_post_meta($placement = 'top') {

    if ('post' == get_post_type()) {
        global $post, $rosewellness_post_comments;
        $position = ( 'bottom' == $placement ) ? 'l' : 'u'; // l = Lower/Bottom , u = Upper/Top

        if (rosewellness_has_postmeta($position)) {
            if ($position == 'l') {
                echo '<footer class="post-footer">';
            }
            ?>
            <div class="clearfix post-meta post-meta-<?php echo $placement; ?>"><?php
                if ('bottom' == $placement)
                    rosewellness_hook_begin_post_meta_bottom();
                else
                    rosewellness_hook_begin_post_meta_top();

                // Author Link
                if ($rosewellness_post_comments['post_author_' . $position] || $rosewellness_post_comments['post_date_' . $position]) {
                    ?>
                    <p class="post-publish alignleft"><?php
                        if ($rosewellness_post_comments['post_author_' . $position]) {
                            printf(__('By <span class="author vcard">%s |</span>', 'rosewellness'), (!$rosewellness_post_comments['author_link_' . $position] ? get_the_author() . ( $rosewellness_post_comments['author_count_' . $position] ? '(' . get_the_author_posts() . ')' : '' ) : sprintf(__('<a class="fn" href="%1$s" title="%2$s">%3$s</a>', 'rosewellness'), get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')), esc_attr(sprintf(__('Posts by %s', 'rosewellness'), get_the_author())), get_the_author()) . ( $rosewellness_post_comments['author_count_' . $position] ? '(' . get_the_author_posts() . ')' : '' )));
                        }
                        echo ( $rosewellness_post_comments['post_author_' . $position] && $rosewellness_post_comments['post_date_' . $position] ) ? ' ' : '';
                        if ($rosewellness_post_comments['post_date_' . $position]) {
                            printf(__('<time class="published" datetime="%s">%s |</time>', 'rosewellness'), get_the_date('c'), get_the_time($rosewellness_post_comments['post_date_format_' . $position]));
                        }

                        // Post Categories
                        echo ( get_the_category_list() && $rosewellness_post_comments['post_category_' . $position] ) ? '&nbsp;' . __('', 'rosewellness') . ' <span>' . get_the_category_list(', ') . '</span>' : '';
                        ?>
                    <!--<span class="alignright rosewellness-post-comment-count"><?php rosewellness_default_comment_count(); ?></span>-->
                    </p><?php
                }

                // Post Tags
                echo ( get_the_tag_list() && $rosewellness_post_comments['post_tags_' . $position] ) ? '<p class="post-tags alignleft">' . get_the_tag_list(__('Tagged', 'rosewellness') . ': <span>', ', ', '</span>') . '</p>' : '';

                // Post Custom Taxonomies
                $args = array('_builtin' => false);
                $taxonomies = get_taxonomies($args, 'objects');
                foreach ($taxonomies as $key => $taxonomy) {
                    ( get_the_terms($post->ID, $key) && isset($rosewellness_post_comments['post_' . $key . '_' . $position]) && $rosewellness_post_comments['post_' . $key . '_' . $position] ) ? the_terms($post->ID, $key, '<p class="post-custom-tax post-' . $key . '">' . $taxonomy->labels->singular_name . ': ', ', ', '</p>') : '';
                }

                if ('bottom' == $placement)
                    rosewellness_hook_end_post_meta_bottom();
                else
                    rosewellness_hook_end_post_meta_top();
                ?>

            </div><!-- .post-meta --><?php
            if ($position == 'l') {
                echo '</footer>';
            }
        }
    }
}

add_action('rosewellness_hook_post_meta_top', 'rosewellness_default_post_meta'); // Post Meta Top
add_action('rosewellness_hook_post_meta_bottom', 'rosewellness_default_post_meta'); // Post Meta Bottom

/**
 * Default Navigation Menu
 *
 */
function rosewellness_default_nav_menu() {
    /* Call wp_nav_menu() for Wordpress Navigaton with fallback wp_list_pages() if menu not set in admin panel */
    if (function_exists('wp_nav_menu') && has_nav_menu('primary')) {
        wp_nav_menu(array('container' => '', 'menu_id' => 'rosewellness-primary-menu', 'menu_class' => 'rosewellness-primary-menu', 'theme_location' => 'primary', 'depth' => apply_filters('rosewellness_nav_menu_depth', 4)));
    } else {
        echo '<ul id="rosewellness-primary-menu" class="rosewellness-primary-menu">';
        wp_list_pages(array('title_li' => '', 'sort_column' => 'menu_order', 'number' => '5', 'depth' => apply_filters('rosewellness_nav_menu_depth', 4)));
        echo '</ul>';
    }
}

//add_action('rosewellness_hook_after_logo', 'rosewellness_default_nav_menu'); // Adds default nav menu after #header

/**
 * 'Edit' link for post/page
 *
 */
function rosewellness_edit_link() {
    // Call Edit Link
    edit_post_link(__('[ edit ]', 'rosewellness'), '<p class="rosewellness-edit-link alignleft">', '&nbsp;</p>');
}

add_action('rosewellness_hook_begin_post_meta_top', 'rosewellness_edit_link');

/**
 * Adds breadcrumb support to the theme.
 *
 */
function rosewellness_breadcrumb_support($text) {
    // Breadcrumb Support
    if (function_exists('bcn_display')) {
        bcn_display();
    }
}

add_action('rosewellness_hook_breadcrumb', 'rosewellness_breadcrumb_support');

/**
 * Adds Site Description
 *
 */
function rosewellness_blog_description() {
    if (get_bloginfo('description')) {
        ?>
        <h2 class="tagline"><?php bloginfo('description'); ?></h2><?php
    }
}

//add_action('rosewellness_hook_after_logo', 'rosewellness_blog_description');

/**
 * Adds pagination to single
 *
 */
function rosewellness_default_single_pagination() {
    if (is_single() && ( get_adjacent_post('', '', true) || get_adjacent_post('', '', false) )) {
        ?>
        <div class="rosewellness-navigation clearfix">
            <?php if (get_adjacent_post('', '', true)) { ?><?php previous_post_link('%link', __('<i class="fa fa-angle-left"></i> Previous', 'rosewellness')); ?><?php } ?>
            <?php if (get_adjacent_post('', '', false)) { ?><?php next_post_link('%link', __('Next <i class="fa fa-angle-right"></i>', 'rosewellness')); ?><?php } ?>
        </div><!-- .rosewellness-navigation --><?php
    }
}

add_action('rosewellness_hook_single_pagination', 'rosewellness_default_single_pagination');

/**
 * Adds pagination to archives
 *
 */
function rosewellness_default_archive_pagination() {
    /* Page-Navi Plugin Support with WordPress Default Pagination */
    if (!is_singular()) {
        global $wp_query, $rosewellness_post_comments;
        if (isset($rosewellness_post_comments['pagination_show']) && $rosewellness_post_comments['pagination_show']) {
            if (( $wp_query->max_num_pages > 1)) {
                ?>
                <nav class="wp-pagenavi col-lg-12"><?php
                    echo paginate_links(array(
                        'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'format' => '?paged=%#%',
                        'current' => max(1, get_query_var('paged')),
                        'total' => $wp_query->max_num_pages,
                        'prev_text' => esc_attr($rosewellness_post_comments['prev_text']),
                        'next_text' => esc_attr($rosewellness_post_comments['next_text']),
                        'end_size' => $rosewellness_post_comments['end_size'],
                        'mid_size' => $rosewellness_post_comments['mid_size']
                    ));
                    ?>
                </nav><?php
            }
        } elseif (function_exists('wp_pagenavi')) {
            wp_pagenavi();
        } elseif (get_next_posts_link() || get_previous_posts_link()) {
            ?>
            <nav class="rosewellness-navigation clearfix">
                <?php if (get_next_posts_link()) { ?><div class="alignleft"><?php next_posts_link(__('&larr; Older Entries', 'rosewellness')); ?></div><?php } ?>
                <?php if (get_previous_posts_link()) { ?><div class="alignright"><?php previous_posts_link(__('Newer Entries &rarr;', 'rosewellness')); ?></div><?php } ?>
            </nav><!-- .rosewellness-navigation --><?php
        }
    }
}

add_action('rosewellness_hook_archive_pagination', 'rosewellness_default_archive_pagination');

/**
 * Displays the sidebar.
 *
 */
function rosewellness_default_sidebar() {
    get_sidebar();
}

add_action('rosewellness_hook_sidebar', 'rosewellness_default_sidebar');

/**
 * Displays the comments and comment form.
 *
 */
function rosewellness_default_comments() {
    if (is_singular()) {
        comments_template('', true);
    }
}

add_action('rosewellness_hook_comments', 'rosewellness_default_comments');

/**
 * Outputs the comment count linked to the comments of the particular post/page
 *
 */
function rosewellness_default_comment_count() {
    global $rosewellness_post_comments;
    // Comment Count
    add_filter('get_comments_number', 'rosewellness_only_comment_count', 11, 2);
    if (( ( get_comments_number() || @comments_open() ) && !is_attachment()) || ( is_attachment() && $rosewellness_post_comments['attachment_comments'] )) { // If post meta is set to top then only display the comment count. 
        comments_popup_link(_x('<span>0</span> Comments', 'comments number', 'rosewellness'), _x('<span>1</span> Comment', 'comments number', 'rosewellness'), _x('<span>%</span> Comments', 'comments number', 'rosewellness'), 'rosewellness-post-comment rosewellness-common-link');
    }
    remove_filter('get_comments_number', 'rosewellness_only_comment_count', 11, 2);
}

//add_action('rosewellness_hook_end_post_title', 'rosewellness_default_comment_count');

/**
 * Get the sidebar ID for current page.
 *
 */
function rosewellness_get_sidebar_id() {
    global $rosewellness_general;
    $sidebar_id = "sidebar-widgets";

    if (function_exists('bp_current_component') && bp_current_component()) {

        if ($rosewellness_general['buddypress_sidebar'] === "buddypress-sidebar") {
            $sidebar_id = "buddypress-sidebar-widgets";
        } else if ($rosewellness_general['buddypress_sidebar'] === "no-sidebar") {
            $sidebar_id = 0;
        }
    } else if (function_exists('is_bbpress') && is_bbpress()) {

        if ($rosewellness_general['bbpress_sidebar'] === "bbpress-sidebar") {
            $sidebar_id = "bbpress-sidebar-widgets";
        } else if ($rosewellness_general['bbpress_sidebar'] === "no-sidebar") {
            $sidebar_id = 0;
        }
    }

    return $sidebar_id;
}

/**
 * Adds custom css through theme options
 *
 */
function rosewellness_custom_css() {
    global $rosewellness_general;
    echo ( $rosewellness_general['custom_styles'] ) ? '<style>' . $rosewellness_general['custom_styles'] . '</style>' . "\r\n" : '';
}

add_action('rosewellness_head', 'rosewellness_custom_css');
