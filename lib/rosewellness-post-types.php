<?php
/**
 * Registers Team Post Type
 */
function create_team_post_types() {
    /* Custom Posts */
    register_post_type('team', array(
        'labels' => array(
            'name' => _x('Team', 'post type general name', 'rosewellness'),
            'singular_name' => _x('Team', 'post type singular name', 'rosewellness'),
            'add_new' => _x('Add New Member', 'custom post', 'rosewellness'),
            'add_new_item' => __('Add New Member', 'rosewellness'),
            'edit_item' => __('Edit Member', 'rosewellness'),
            'new_item' => __('New Member', 'rosewellness'),
            'view_item' => __('View Members', 'rosewellness'),
            'search_items' => __('Search Members', 'rosewellness'),
            'not_found' => __('No Members found.', 'rosewellness'),
            'not_found_in_trash' => __('No Members found in Trash.', 'rosewellness'),
            'parent_item_colon' => array(null, __('Members', 'rosewellness')),
            'all_items' => __('All Members', 'rosewellness')),
        'description' => __('Members', 'rosewellness'),
        'publicly_queryable' => null,
        'exclude_from_search' => null,
        'capability_type' => 'post',
        'capabilities' => array(),
        'map_meta_cap' => null,
        '_builtin' => false,
        '_edit_link' => 'post.php?post=%d',
        'hierarchical' => false,
        'public' => true,
        'rewrite' => true,
        'has_archive' => true,
        'query_var' => true,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        'register_meta_box_cb' => null,
        'taxonomies' => array(),
        'show_ui' => null,
        'menu_position' => null,
        'menu_icon' => 'dashicons-groups',
        'permalink_epmask' => EP_PERMALINK,
        'can_export' => true,
        'show_in_nav_menus' => null,
        'show_in_menu' => null,
        'show_in_admin_bar' => null)
    );
}

add_action('init', 'create_team_post_types');


/**
 * Registers Testimonials Post Type
 */
function create_testimonials_post_types() {
    /* Custom Posts */
    register_post_type('testimonial', array(
        'labels' => array(
            'name' => _x('Testimonials', 'post type general name', 'rosewellness'),
            'singular_name' => _x('Testimonials', 'post type singular name', 'rosewellness'),
            'add_new' => _x('Add New Testimonial', 'custom post', 'rosewellness'),
            'add_new_item' => __('Add New Testimonial', 'rosewellness'),
            'edit_item' => __('Edit Testimonial', 'rosewellness'),
            'new_item' => __('New Testimonial', 'rosewellness'),
            'view_item' => __('View Testimonials', 'rosewellness'),
            'search_items' => __('Search Testimonials', 'rosewellness'),
            'not_found' => __('No Testimonials found.', 'rosewellness'),
            'not_found_in_trash' => __('No Testimonials found in Trash.', 'rosewellness'),
            'parent_item_colon' => array(null, __('Testimonials', 'rosewellness')),
            'all_items' => __('All Testimonials', 'rosewellness')),
        'description' => __('Testimonials', 'rosewellness'),
        'publicly_queryable' => null,
        'exclude_from_search' => null,
        'capability_type' => 'post',
        'capabilities' => array(),
        'map_meta_cap' => null,
        '_builtin' => false,
        '_edit_link' => 'post.php?post=%d',
        'hierarchical' => false,
        'public' => true,
        'rewrite' => true,
        'has_archive' => true,
        'query_var' => true,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        'register_meta_box_cb' => null,
        'taxonomies' => array(),
        'show_ui' => null,
        'menu_position' => null,
        'menu_icon' => 'dashicons-format-quote',
        'permalink_epmask' => EP_PERMALINK,
        'can_export' => true,
        'show_in_nav_menus' => null,
        'show_in_menu' => null,
        'show_in_admin_bar' => null)
    );
}

add_action('init', 'create_testimonials_post_types');


/**
 * Registers Self Assements Post Type
 */
function create_assessments_post_types() {
    /* Custom Posts */
    register_post_type('assessments', array(
        'labels' => array(
            'name' => _x('Assessments', 'post type general name', 'rosewellness'),
            'singular_name' => _x('Assessments', 'post type singular name', 'rosewellness'),
            'add_new' => _x('Add New Assessment', 'custom post', 'rosewellness'),
            'add_new_item' => __('Add New Assessment', 'rosewellness'),
            'edit_item' => __('Edit Assessment', 'rosewellness'),
            'new_item' => __('New Assessment', 'rosewellness'),
            'view_item' => __('View Assessments', 'rosewellness'),
            'search_items' => __('Search Assessments', 'rosewellness'),
            'not_found' => __('No Assessments found.', 'rosewellness'),
            'not_found_in_trash' => __('No Assessments found in Trash.', 'rosewellness'),
            'parent_item_colon' => array(null, __('Assessments', 'rosewellness')),
            'all_items' => __('All Assessments', 'rosewellness')),
        'description' => __('Assessments', 'rosewellness'),
        'publicly_queryable' => null,
        'exclude_from_search' => null,
        'capability_type' => 'post',
        'capabilities' => array(),
        'map_meta_cap' => null,
        '_builtin' => false,
        '_edit_link' => 'post.php?post=%d',
        'hierarchical' => false,
        'public' => true,
        'rewrite' => true,
        'has_archive' => true,
        'query_var' => true,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        'register_meta_box_cb' => null,
        'taxonomies' => array(),
        'show_ui' => null,
        'menu_position' => null,
        'menu_icon' => 'dashicons-database-import',
        'permalink_epmask' => EP_PERMALINK,
        'can_export' => true,
        'show_in_nav_menus' => null,
        'show_in_menu' => null,
        'show_in_admin_bar' => null)
    );
}

add_action('init', 'create_assessments_post_types');


add_filter('manage_post_posts_columns', function($columns) {
	return array_merge($columns, ['show_sidebar' => __('Sidebar', 'rosewellness')]);
});
 
add_action('manage_post_posts_custom_column', function($column_key, $post_id) {
	if ($column_key == 'show_sidebar') {
		$show_sidebar = get_post_meta($post_id, 'show_sidebar', true);
		if($show_sidebar == 'yes') {
			echo '<span style="color:green;">'; _e('Yes', 'rosewellness'); echo '</span>';
		} else {
			echo '<span style="color:red;">'; _e('-', 'rosewellness'); echo '</span>';
		}
	}
}, 10, 2);