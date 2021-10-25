<?php

add_filter('use_block_editor_for_post', '__return_false');
remove_filter('template_redirect', 'redirect_canonical');

/**
 * Rosewellness functions and definitions
 *
 * @package rosewellness
 *
 */
define('ROSEWELLNESS_VERSION', '1.0');

/* Define Directory Constants */
define('ROSEWELLNESS_CSS', get_template_directory() . '/css');
define('ROSEWELLNESS_JS', get_template_directory() . '/js');
define('ROSEWELLNESS_IMG', get_template_directory() . '/img');

/* Define Directory URL Constants */
define('ROSEWELLNESS_TEMPLATE_URL', get_template_directory_uri());
define('ROSEWELLNESS_ADMIN', get_template_directory_uri() . '/admin');
define('ROSEWELLNESS_CSS_FOLDER_URL', get_template_directory_uri() . '/css');
define('ROSEWELLNESS_JS_FOLDER_URL', get_template_directory_uri() . '/js');
define('ROSEWELLNESS_IMG_FOLDER_URL', get_template_directory_uri() . '/images');

$rosewellness_general = get_option('rosewellness_general'); // Rosewellness General Options
$rosewellness_post_comments = get_option('rosewellness_post_comments'); // Rosewellness Post & Comments Options
$rosewellness_version = get_option('rosewellness_version'); // Rosewellness Version

/* Check if default values are present in the database else force defaults - Since Rosewellness v2.1 */
$rosewellness_general['pagination_show'] = isset($rosewellness_general['pagination_show']) ? $rosewellness_general['pagination_show'] : 0;
$rosewellness_post_comments['prev_text'] = isset($rosewellness_post_comments['prev_text']) ? $rosewellness_post_comments['prev_text'] : __('&laquo; Previous', 'rosewellness');
$rosewellness_post_comments['next_text'] = isset($rosewellness_post_comments['next_text']) ? $rosewellness_post_comments['next_text'] : __('Next &raquo;', 'rosewellness');
$rosewellness_post_comments['end_size'] = isset($rosewellness_post_comments['end_size']) ? $rosewellness_post_comments['end_size'] : 1;
$rosewellness_post_comments['mid_size'] = isset($rosewellness_post_comments['mid_size']) ? $rosewellness_post_comments['mid_size'] : 2;
$rosewellness_post_comments['attachment_comments'] = isset($rosewellness_post_comments['attachment_comments']) ? $rosewellness_post_comments['attachment_comments'] : 0;

/* Includes PHP files located in 'lib' folder */
foreach (glob(get_template_directory() . "/lib/*.php") as $lib_filename) {
	require_once($lib_filename);
}

/* Includes Rosewellness Theme Options */
require_once(get_template_directory() . "/admin/rosewellness-theme-options.php");

/* Front-end Styles and Scripts */
add_action('wp_enqueue_scripts', 'rosewellness_enqueue_and_register_my_scripts');

function rosewellness_enqueue_and_register_my_scripts()
{

	//wp_register_script('jQuery', get_stylesheet_directory_uri() . '/js/jQuery.js', '', '', TRUE);
	//wp_enqueue_script('jQuery');

	wp_enqueue_script('jquery');

	if (is_page_template('templates/template-plans.php')) {

		wp_enqueue_script('rosewellness-tooltip-js', get_stylesheet_directory_uri() . '/js/jquery-ui.js');
		wp_enqueue_style('rosewellness-tooltip-css', get_stylesheet_directory_uri() . '/css/jquery-ui.css');

	}

	wp_register_script('cookie-JS', get_stylesheet_directory_uri() . '/js/jquery_cookie.js');
	wp_enqueue_script('cookie-JS');

	wp_register_script('rosewelness-custom', get_stylesheet_directory_uri() . '/js/rosewellness-custom-front-end.js');
	wp_enqueue_script('rosewelness-custom');

	if (is_page_template('templates/template-form-quiz.php')) {

		wp_register_script('rosewelness-quiz-js', get_stylesheet_directory_uri() . '/js/rosewellness-quiz.js');
		wp_enqueue_script('rosewelness-quiz-js');

		wp_register_style('quiz-css', get_stylesheet_directory_uri() . '/css/quiz.css');
		wp_enqueue_style('quiz-css');

	}

	//wp_register_script('simple-slider', get_stylesheet_directory_uri() . '/js/slick.min.js');
	//wp_enqueue_script('simple-slider');

	wp_register_script('bim-js', get_stylesheet_directory_uri() . '/js/bimjs.js');
	wp_enqueue_script('bim-js');

	wp_register_style('bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap-3.min.css');
	wp_enqueue_style('bootstrap-css');

	wp_register_style('slider-css', get_stylesheet_directory_uri() . '/css/slick.css');
	wp_enqueue_style('slider-css');

	wp_register_style('fontawesome-icons', get_stylesheet_directory_uri() . '/css/font-awesome.min.css');
	wp_enqueue_style('fontawesome-icons');

	wp_register_style('bim-css', get_stylesheet_directory_uri() . '/css/bimstyle.css');
	wp_enqueue_style('bim-css');

	wp_register_style('rt-css', get_stylesheet_directory_uri() . '/css/rt.css');
	wp_enqueue_style('rt-css');


}


/**
 * Custom Blog Loop Using ShortCode
 */
function rosewellness_title_for_home($title)
{
	if (empty($title) && (is_home() || is_front_page())) {
		$title = __('Rose Wellness Center for Integrative Medicine, Oakton, Virginia', 'rosewellness');
	}
	return $title;
}

add_filter('wp_title', 'rosewellness_title_for_home');


/* For Development Purpose Only ! Can Be Deleted */

function pr($data)
{
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}


/**
 * Allow SVG upload WordPress media
 */
function rosewellness_allow_svg_uploads($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

add_filter('upload_mimes', 'rosewellness_allow_svg_uploads');

add_action('wp_ajax_ajaxCatLoadMore', 'ajaxCatLoadMore');
add_action('wp_ajax_nopriv_ajaxCatLoadMore', 'ajaxCatLoadMore');

function ajaxCatLoadMore()
{
	ob_start();
	global $post, $wpdb;

	$pageNo = $_REQUEST['page'];
	$ppp = $_REQUEST["ppp"];
	$offset = $_REQUEST["offset"];

	if ($_REQUEST["offset"] == '') {
		$msgEmpty = '<h2 class="no-blog-post">No Records Found.</h2>';
	} else {
		$msgEmpty = '';
	}

	$terms = get_terms(array(
		'paged' => $paged,
		'taxonomy' => 'category',
		'orderby' => 'id',
		'parent' => 0,
		'hide_empty' => false,
		'number' => $ppp,
		'offset' => $offset
	));

	// The Loop
	$html = '';
	if (!empty($terms)) {
		foreach ($terms as $term) {
			$html .= '<li><a href="' . site_url() . '/category/' . $term->slug . '">' . $term->name . '</a></li>';
		}

		$html .= '<div class="cat_load_more"><a class="loadCat" href="javascript:void(0);" data-page="' . $pageNo . '"> Load More </a></div>';

	} else {

		$html .= $msgEmpty;

	}

	echo json_encode(array('html' => $html));
	die;
}


add_action('wp_ajax_ajaxCatBlogLoadMore', 'ajaxCatBlogLoadMore');
add_action('wp_ajax_nopriv_ajaxCatBlogLoadMore', 'ajaxCatBlogLoadMore');

function ajaxCatBlogLoadMore()
{
	ob_start();
	global $post, $wpdb;

	$pageNo = $_REQUEST['page'];
	$ppp = $_REQUEST["ppp"];
	$offset = $_REQUEST["offset"];
	$cat_id = $_REQUEST["cat_id"];

	if ($_REQUEST["offset"] == '') {
		$msgEmpty = '<h2 class="no-blog-post">No Records Found.</h2>';
	} else {
		$msgEmpty = '';
	}

	$args = array(
		'posts_per_page' => $ppp,
		'offset' => $offset,
		'paged' => $paged,
		'post_type' => 'post',
		'post_status' => 'publish',
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'category',
				'field' => 'term_id',
				'terms' => array(35),
				'operator' => 'IN',
			),
			array(
				'taxonomy' => 'category',
				'field' => 'term_id',
				'terms' => array($cat_id),
				'operator' => 'IN',
			)
		)
	);

	// The Query
	$the_query = new WP_Query($args);

	// The Loop
	$html = '';
	if ($the_query->have_posts()) {

		while ($the_query->have_posts()) {
			$the_query->the_post();
			$postID = get_the_id();

			$the_content = strip_shortcodes(get_the_content($postID));
			$excerpt = get_the_excerpt($postID);

			if (empty($excerpt)) {
				$content_org = wp_trim_words($the_content, 20, '...');
			} else {
				$content_org = wp_trim_words($excerpt, 20, '...');
			}

			// Get Current Category Slug
			$current_category = get_the_category($postID);
			$category_slug = $current_category[0]->slug;
			$category_name = $current_category[0]->name;

			// Get Primary Category
			$primary_cat_id = get_post_meta($postID, '_yoast_wpseo_primary_category', true);
			$primary_term_array = get_term_by('term_id', $primary_cat_id, 'category');
			$primary_term_name = $primary_term_array->name;

			if (!empty($primary_term_name)) {
				$blog_cat_name = $primary_term_name;
				$blog_cat_slug = $primary_term_array->slug;
				$category_url = site_url() . '/category/' . $blog_cat_slug;
			} else {
				$blog_cat_name = $category_name;
				$blog_cat_slug = $category_slug;
				$category_url = site_url() . '/category/' . $category_slug;
			}

			$html .= '<div class="post-item col-md-4">
			    <div class="post_thubmnail">
				    <a href="' . get_the_permalink($postID) . '">';
			if (has_post_thumbnail()) {
				$html .= get_the_post_thumbnail($postID, 'full');
			}
			$html .= '</a>
				</div>
				<p class="category_info"><a href="' . $category_url . '">' . $blog_cat_name . '</a></p>
				<a href="' . get_the_permalink($postID) . '"><h4>' . get_the_title($postID) . '</h4></a>
				<p class="blog_desc">' . $content_org . '</p>
			</div>';
		}

		$html .= '<div class="blog_load_more"><a class="loadCatFBlog" href="javascript:void(0);" data-cat="' . $cat_id . '" data-page="' . $pageNo . '"> Load More</a></div>';

		wp_reset_postdata();

	} else {
		$html .= $msgEmpty;
	}

	echo json_encode(array('html' => $html));
	die;
}

add_action('wp_ajax_ajaxBlogLoadMore', 'ajaxBlogLoadMore');
add_action('wp_ajax_nopriv_ajaxBlogLoadMore', 'ajaxBlogLoadMore');

function ajaxBlogLoadMore()
{
	ob_start();
	global $post, $wpdb;

	$pageNo = $_REQUEST['page'];
	$ppp = $_REQUEST["ppp"];
	$offset = $_REQUEST["offset"];

	if ($_REQUEST["offset"] == '') {
		$msgEmpty = '<h2 class="no-blog-post">No Records Found.</h2>';
	} else {
		$msgEmpty = '';
	}

	$args = array(
		'posts_per_page' => $ppp,
		'offset' => $offset,
		'paged' => $paged,
		'post_type' => 'post',
		'post_status' => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field' => 'term_id',
				'terms' => array(35),
				'operator' => 'IN',
			)
		)
	);

	// The Query
	$the_query = new WP_Query($args);

	// The Loop
	$html = '';
	if ($the_query->have_posts()) {

		while ($the_query->have_posts()) {
			$the_query->the_post();
			$postID = get_the_id();

			$the_content = strip_shortcodes(get_the_content($postID));
			$excerpt = get_the_excerpt($postID);

			if (empty($excerpt)) {
				$content_org = wp_trim_words($the_content, 20, '...');
			} else {
				$content_org = wp_trim_words($excerpt, 20, '...');
			}

			// Get Current Category Slug
			$current_category = get_the_category($postID);
			$category_slug = $current_category[0]->slug;
			$category_name = $current_category[0]->name;

			// Get Primary Category
			$primary_cat_id = get_post_meta($postID, '_yoast_wpseo_primary_category', true);
			$primary_term_array = get_term_by('term_id', $primary_cat_id, 'category');
			$primary_term_name = $primary_term_array->name;

			if (!empty($primary_term_name)) {
				$blog_cat_name = $primary_term_name;
				$blog_cat_slug = $primary_term_array->slug;
				$category_url = site_url() . '/category/' . $blog_cat_slug;
			} else {
				$blog_cat_name = $category_name;
				$blog_cat_slug = $category_slug;
				$category_url = site_url() . '/category/' . $category_slug;
			}

			$html .= '<div class="post-item col-md-4">
			    <div class="post_thubmnail">
				    <a href="' . get_the_permalink($postID) . '">';
			if (has_post_thumbnail()) {
				$html .= get_the_post_thumbnail($postID, 'full');
			}
			$html .= '</a>
				</div>
				<p class="category_info"><a href="' . $category_url . '">' . $blog_cat_name . '</a></p>
				<a href="' . get_the_permalink($postID) . '"><h4>' . get_the_title($postID) . '</h4></a>
				<p class="blog_desc">' . $content_org . '</p>
			</div>';
		}

		$html .= '<div class="blog_load_more"><a class="loadBlog" href="javascript:void(0);" data-page="' . $pageNo . '"> Load More</a></div>';

		wp_reset_postdata();

	} else {
		$html .= $msgEmpty;
	}

	echo json_encode(array('html' => $html));
	die;
}

add_action('wp_ajax_ajaxBlogLatestLoadMore', 'ajaxBlogLatestLoadMore');
add_action('wp_ajax_nopriv_ajaxBlogLatestLoadMore', 'ajaxBlogLatestLoadMore');

function ajaxBlogLatestLoadMore()
{
	ob_start();
	global $post, $wpdb;

	$pageNo = $_REQUEST['page'];
	$ppp = $_REQUEST["ppp"];
	$offset = $_REQUEST["offset"];
	$category_id = $_REQUEST["cat_id"];

	if ($_REQUEST["offset"] == '') {
		$msgEmpty = '<h2 class="no-blog-post">No Records Found.</h2>';
	} else {
		$msgEmpty = '';
	}

	$tax_type = $_REQUEST['tax_type'];

	if ($tax_type == 'post_tag') {
		$args = array(
			'posts_per_page' => $ppp,
			'offset' => $offset,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_type' => 'post',
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'post_tag',
					'field' => 'term_id',
					'terms' => $category_id,
					'operator' => 'IN'
				)
			)
		);
	} else {
		$args = array(
			'posts_per_page' => $ppp,
			'offset' => $offset,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_type' => 'post',
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field' => 'term_id',
					'terms' => $category_id,
					'operator' => 'IN'
				)
			)
		);
	}

	// The Query
	$the_query = new WP_Query($args);

	// The Loop
	$html = '';
	if ($the_query->have_posts()) {

		while ($the_query->have_posts()) {
			$the_query->the_post();
			$postID = get_the_id();

			$the_content = strip_shortcodes(get_the_content($postID));
			$excerpt = get_the_excerpt($postID);

			if (empty($excerpt)) {
				$content_org = wp_trim_words($the_content, 20, '...');
			} else {
				$content_org = wp_trim_words($excerpt, 20, '...');
			}

			// Get Current Category Slug
			$current_category = get_the_category($postID);
			$category_slug = $current_category[0]->slug;
			$category_name = $current_category[0]->name;

			if (!empty($primary_term_name)) {
				$blog_cat_name = $primary_term_name;
				$blog_cat_slug = $primary_term_array->slug;
				$category_url = site_url() . '/category/' . $blog_cat_slug;
			} else {
				$blog_cat_name = $category_name;
				$blog_cat_slug = $category_slug;
				$category_url = site_url() . '/category/' . $category_slug;
			}

			$html .= '<div class="post-item col-md-4">
			    <div class="post_thubmnail featured_img">
				    <a href="' . get_the_permalink($postID) . '">';
			if (has_post_thumbnail()) {
				$html .= get_the_post_thumbnail($postID, 'full');
			}
			$html .= '</a>
				</div>
				<p class="category_info"><a href="' . $category_url . '">' . $blog_cat_name . '</a></p>
				<a href="' . get_the_permalink($postID) . '"><h4>' . get_the_title($postID) . '</h4></a>
				<p class="blog_desc">' . $content_org . '</p>
			</div>';
		}

		$html .= '<div class="blog_load_more"><a class="loadtBlog" href="javascript:void(0);" data-page="' . $pageNo . '" data-cat="' . $category_id . '"> Load More</a></div>';

		wp_reset_postdata();

	} else {
		$html .= $msgEmpty;
	}

	echo json_encode(array('html' => $html));
	die;
}


add_action('wp_ajax_ajaxBlogAnyLoadMore', 'ajaxBlogAnyLoadMore');
add_action('wp_ajax_nopriv_ajaxBlogAnyLoadMore', 'ajaxBlogAnyLoadMore');

function ajaxBlogAnyLoadMore()
{
	ob_start();
	global $post, $wpdb;

	$pageNo = $_REQUEST['page'];
	$ppp = $_REQUEST["ppp"];
	$offset = $_REQUEST["offset"];
	$category_id = $_REQUEST["cat_id"];

	if ($_REQUEST["offset"] == '') {
		$msgEmpty = '<h2 class="no-blog-post">No Records Found.</h2>';
	} else {
		$msgEmpty = '';
	}

	$args = array(
		'posts_per_page' => $ppp,
		'offset' => $offset,
		'paged' => $paged,
		'post_type' => 'post',
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC'
	);

	// The Query
	$the_query = new WP_Query($args);

	// The Loop
	$html = '';
	if ($the_query->have_posts()) {

		while ($the_query->have_posts()) {
			$the_query->the_post();
			$postID = get_the_id();

			$the_content = strip_shortcodes(get_the_content($postID));
			$excerpt = get_the_excerpt($postID);

			if (empty($excerpt)) {
				$content_org = wp_trim_words($the_content, 20, '...');
			} else {
				$content_org = wp_trim_words($excerpt, 20, '...');
			}

			// Get Current Category Slug
			$current_category = get_the_category($postID);
			$category_slug = $current_category[0]->slug;
			$category_name = $current_category[0]->name;
			$category_url = site_url() . '/category/' . $category_slug;

			$html .= '<div class="post-item col-md-4">
			    <div class="post_thubmnail featured_img">
				    <a href="' . get_the_permalink($postID) . '">';
			if (has_post_thumbnail()) {
				$html .= get_the_post_thumbnail($postID, 'full');
			}
			$html .= '</a>
				</div>
				<p class="category_info"><a href="' . $category_url . '">' . $category_name . '</a></p>
				<a href="' . get_the_permalink($postID) . '"><h4>' . get_the_title($postID) . '</h4></a>
				<p class="blog_desc">' . $content_org . '</p>
			</div>';
		}

		$html .= '<div class="blog_load_more"><a class="loadABlog" href="javascript:void(0);" data-page="' . $pageNo . '"> Load More</a></div>';

		wp_reset_postdata();

	} else {
		$html .= $msgEmpty;
	}

	echo json_encode(array('html' => $html));
	die;
}

/**
 * Get Taxonomy
 **/

function load_terms($taxonomy)
{
	global $wpdb;
	$query = "SELECT DISTINCT
                  t.*
              FROM
                wp_terms t
              INNER JOIN
                wp_term_taxonomy tax
              ON
                tax.term_id = t.term_id
              WHERE
                  ( tax.taxonomy = '" . $taxonomy . "' and tax.parent = 0)";
	$result = $wpdb->get_results($query);
	return $result;
}

function load_praent_child_terms($parent_id)
{
	global $wpdb;
	$query = "SELECT DISTINCT
                  t.*
              FROM
                wp_terms t
              INNER JOIN
                wp_term_taxonomy tax
              ON
                tax.term_id = t.term_id
              WHERE
                  ( tax.taxonomy = 'category' and tax.parent = '" . $parent_id . "')";
	$result = $wpdb->get_results($query);
	return $result;
}

function load_all_terms($taxonomy)
{
	global $wpdb;
	$query = "SELECT DISTINCT
                  t.*
              FROM
                wp_terms t
              INNER JOIN
                wp_term_taxonomy tax
              ON
                tax.term_id = t.term_id
              WHERE
                  ( tax.taxonomy = '" . $taxonomy . "')";
	$result = $wpdb->get_results($query);
	return $result;
}

function load_child_terms($taxonomy)
{
	global $wpdb;
	$query = "SELECT DISTINCT
                  t.*
              FROM
                wp_terms t
              INNER JOIN
                wp_term_taxonomy tax
              ON
                tax.term_id = t.term_id
              WHERE
                  ( tax.taxonomy = '" . $taxonomy . "')";
	$result = $wpdb->get_results($query);
	return $result;
}

function load_term_array($term_id)
{
	global $wpdb;
	$query = "SELECT *
              FROM
                wp_terms WHERE term_id = " . $term_id;
	$result = $wpdb->get_results($query);
	return $result;
}

/**
 * Speed Optmisation
 * */


/********** WP Forms Update Value ***************/

add_filter('wpforms_process_filter', 'rosewellness_wpforms_update_total_field', 10, 3);

function rosewellness_wpforms_update_total_field($fields, $entry, $form_data)
{

	// Only run on my form with ID = 10367
	if (10367 != $form_data['id'])
		return $fields;

	$sumScore = 0;
	$immuneScore = 0;
	$gutScore = 0;
	$thyroidScore = 0;
	$adrenalScore = 0;

	$candidaScore = 0;
	$femaleHormonesScore = 0;
	$maleHormonesScore = 0;


	$immuneArray = array(1, 5, 6, 7, 20, 18, 19, 17, 16);
	$gutArray = array(14, 9, 10, 11, 12, 13, 119, 120, 121, 122, 123);
	$thyroidArray = array(8, 21, 35, 34, 33, 32, 31, 30, 29, 28, 27);
	$adrenalArray = array(22, 36, 37, 43, 42, 41, 40, 39, 38, 44, 115, 118, 117, 116);

	$candidaArray = array(145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155);
	$femaleHormonesArray = array(125, 126, 127, 128, 129, 130, 131, 132, 133);
	$maleHormonesArray = array(135, 136, 137, 138, 139, 140, 141, 142, 143);

	if (!empty($fields)) {

		foreach ($fields as $field) {

			// Multiplier
			// Will review and update multipliers later)
			if (($field['id'] == 15) || ($field['id'] == 29)) {

				$multiply = 1;

			} else if (($field['id'] == 24) || ($field['id'] == 11) || ($field['id'] == 42)) {

				$multiply = 1;

			} else {

				$multiply = 1;

			}


			// Immune Total
			if (in_array($field['id'], $immuneArray)) {

				if ($field['value'] == 'Severe') {

					$immuneScore += $multiply * 3;

				} else if ($field['value'] == 'Moderate') {

					$immuneScore += $multiply * 2;

				} else if ($field['value'] == 'Mild') {

					$immuneScore += $multiply * 1;

				} else {

					$immuneScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $gutArray)) {

				if ($field['value'] == 'Severe') {

					$gutScore += $multiply * 3;

				} else if ($field['value'] == 'Moderate') {

					$gutScore += $multiply * 2;

				} else if ($field['value'] == 'Mild') {

					$gutScore += $multiply * 1;

				} else {

					$gutScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $thyroidArray)) {

				if ($field['value'] == 'Severe') {

					$thyroidScore += $multiply * 3;

				} else if ($field['value'] == 'Moderate') {

					$thyroidScore += $multiply * 2;

				} else if ($field['value'] == 'Mild') {

					$thyroidScore += $multiply * 1;

				} else {

					$thyroidScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $adrenalArray)) {

				if ($field['value'] == 'Severe') {

					$adrenalScore += $multiply * 3;

				} else if ($field['value'] == 'Moderate') {

					$adrenalScore += $multiply * 2;

				} else if ($field['value'] == 'Mild') {

					$adrenalScore += $multiply * 1;

				} else {

					$adrenalScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $candidaArray)) {

				if ($field['value'] == 'Severe') {

					$candidaScore += $multiply * 3;

				} else if ($field['value'] == 'Moderate') {

					$candidaScore += $multiply * 2;

				} else if ($field['value'] == 'Mild') {

					$candidaScore += $multiply * 1;

				} else {

					$candidaScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $femaleHormonesArray)) {

				if ($field['value'] == 'Severe') {

					$femaleHormonesScore += $multiply * 3;

				} else if ($field['value'] == 'Moderate') {

					$femaleHormonesScore += $multiply * 2;

				} else if ($field['value'] == 'Mild') {

					$femaleHormonesScore += $multiply * 1;

				} else {

					$femaleHormonesScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $maleHormonesArray)) {

				if ($field['value'] == 'Severe') {

					$maleHormonesScore += $multiply * 3;

				} else if ($field['value'] == 'Moderate') {

					$maleHormonesScore += $multiply * 2;

				} else if ($field['value'] == 'Mild') {

					$maleHormonesScore += $multiply * 1;

				} else {

					$maleHormonesScore += $multiply * 0;
				}

			}

			// Total Score
			if ($field['value'] == 'Severe') {

				$sumScore += $multiply * 3;

			} else if ($field['value'] == 'Moderate') {

				$sumScore += $multiply * 2;

			} else if ($field['value'] == 'Mild') {

				$sumScore += $multiply * 1;

			} else {

				$sumScore += $multiply * 0;

			}

		}

	}

	// Set Total Score Value
	$fields[90]['value'] = $sumScore;
	$fields[92]['value'] = $immuneScore;
	$fields[93]['value'] = $gutScore;
	$fields[94]['value'] = $thyroidScore;
	$fields[95]['value'] = $adrenalScore;

	$fields[156]['value'] = $candidaScore;
	$fields[157]['value'] = $femaleHormonesScore;
	$fields[158]['value'] = $maleHormonesScore;

	return $fields;
}


add_filter('wpforms_process_filter', 'rosewellness_wpforms_toxicity_update_total_field', 10, 3);

function rosewellness_wpforms_toxicity_update_total_field($fields, $entry, $form_data)
{

	// Only run on my form with ID = 10366
	if (10366 != $form_data['id'])
		return $fields;

	$sumScore = 0;
	$headScore = 0;
	$eyesScore = 0;
	$earsScore = 0;
	$noseScore = 0;
	$mouthScore = 0;
	$skinScore = 0;
	$heartScore = 0;
	$lungsScore = 0;
	$tractScore = 0;
	$jointsScore = 0;
	$weightScore = 0;
	$activityScore = 0;
	$mindScore = 0;
	$emotionsScore = 0;
	$otherScore = 0;

	$headArray = array(1, 119, 120, 121);
	$eyesArray = array(122, 123, 124, 125);
	$earsArray = array(126, 127, 128, 129);
	$noseArray = array(130, 131, 132, 133, 134);
	$mouthArray = array(135, 136, 137, 138, 139);
	$skinArray = array(140, 141, 142, 143, 144);
	$heartArray = array(154, 155, 156);
	$lungsArray = array(160, 161, 162, 163);
	$tractArray = array(164, 165, 166, 167, 168, 169, 170);
	$jointsArray = array(185, 186, 187, 188, 189);
	$weightArray = array(193, 194, 195, 196, 197, 198);
	$activityArray = array(199, 200, 201, 202);
	$mindArray = array(204, 209, 210, 211, 212, 213, 214, 215);
	$emotionsArray = array(216, 217, 218, 219);
	$otherArray = array(220, 221, 222);

	if (!empty($fields)) {

		foreach ($fields as $field) {

			// Multiplier
			$multiply = 1;

			// Immune Total
			if (in_array($field['id'], $headArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$headScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$headScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$headScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$headScore += $multiply * 4;

				} else {

					$headScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $eyesArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$eyesScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$eyesScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$eyesScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$eyesScore += $multiply * 4;

				} else {

					$eyesScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $earsArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$earsScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$earsScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$earsScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$earsScore += $multiply * 4;

				} else {

					$earsScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $noseArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$noseScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$noseScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$noseScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$noseScore += $multiply * 4;

				} else {

					$noseScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $mouthArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$mouthScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$mouthScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$mouthScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$mouthScore += $multiply * 4;

				} else {

					$mouthScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $skinArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$skinScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$skinScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$skinScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$skinScore += $multiply * 4;

				} else {

					$skinScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $heartArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$heartScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$heartScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$heartScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$heartScore += $multiply * 4;

				} else {

					$heartScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $lungsArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$lungsScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$lungsScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$lungsScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$lungsScore += $multiply * 4;

				} else {

					$lungsScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $tractArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$tractScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$tractScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$tractScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$tractScore += $multiply * 4;

				} else {

					$tractScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $jointsArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$jointsScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$jointsScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$jointsScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$jointsScore += $multiply * 4;

				} else {

					$jointsScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $weightArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$weightScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$weightScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$weightScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$weightScore += $multiply * 4;

				} else {

					$weightScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $activityArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$activityScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$activityScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$activityScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$activityScore += $multiply * 4;

				} else {

					$activityScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $mindArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$mindScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$mindScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$mindScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$mindScore += $multiply * 4;

				} else {

					$mindScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $emotionsArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$emotionsScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$emotionsScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$emotionsScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$emotionsScore += $multiply * 4;

				} else {

					$emotionsScore += $multiply * 0;
				}

			} else if (in_array($field['id'], $otherArray)) {

				if ($field['value'] == 'Occasionally but not severe') {

					$otherScore += $multiply * 1;

				} else if ($field['value'] == 'Occasionally and severe') {

					$otherScore += $multiply * 2;

				} else if ($field['value'] == 'Frequently but not severe') {

					$otherScore += $multiply * 3;

				} else if ($field['value'] == 'Frequently and severe') {

					$otherScore += $multiply * 4;

				} else {

					$otherScore += $multiply * 0;
				}

			}

			// Total Score
			if ($field['value'] == 'Occasionally but not severe') {

				$sumScore += $multiply * 1;

			} else if ($field['value'] == 'Occasionally and severe') {

				$sumScore += $multiply * 2;

			} else if ($field['value'] == 'Frequently but not severe') {

				$sumScore += $multiply * 3;

			} else if ($field['value'] == 'Frequently and severe') {

				$sumScore += $multiply * 4;

			} else {

				$sumScore += $multiply * 0;
			}

		}

	}

	// Set Total Score Value
	$fields[90]['value'] = $sumScore;
	$fields[92]['value'] = $headScore;
	$fields[93]['value'] = $eyesScore;
	$fields[94]['value'] = $earsScore;
	$fields[95]['value'] = $noseScore;
	$fields[174]['value'] = $mouthScore;
	$fields[175]['value'] = $skinScore;
	$fields[176]['value'] = $heartScore;
	$fields[177]['value'] = $lungsScore;
	$fields[178]['value'] = $tractScore;
	$fields[179]['value'] = $jointsScore;
	$fields[180]['value'] = $weightScore;
	$fields[181]['value'] = $activityScore;
	$fields[182]['value'] = $mindScore;
	$fields[183]['value'] = $emotionsScore;
	$fields[184]['value'] = $otherScore;

	return $fields;
}


add_filter('wpforms_process_filter', 'rosewellness_wpforms_insomnia_update_total_field', 10, 3);

function rosewellness_wpforms_insomnia_update_total_field($fields, $entry, $form_data)
{

	// Only run on my form with ID = 12396
	if (12396 != $form_data['id'])
		return $fields;

	$sumScore = 0;
	$quizArray = array(161, 162, 163, 1, 5, 159, 160);

	if (!empty($fields)) {
		foreach ($fields as $field) {

			// Multiplier
			$multiply = 1;

			// Insomnia Total
			if (in_array($field['id'], $quizArray)) {

				if (($field['value'] == 'None') || ($field['value'] == 'Very Satisfied') || ($field['value'] == 'Not at all Noticeable') || ($field['value'] == 'Not Worried at all') || ($field['value'] == 'Not At All Interfering')) {

					$sumScore += $multiply * 0;

				} else if (($field['value'] == 'Mild') || ($field['value'] == 'Satisfied') || ($field['value'] == 'A Little')) {

					$sumScore += $multiply * 1;

				} else if (($field['value'] == 'Moderate') || ($field['value'] == 'Moderately Satisfied') || ($field['value'] == 'Somewhat')) {

					$sumScore += $multiply * 2;

				} else if (($field['value'] == 'Severe') || ($field['value'] == 'Dissatisfied') || ($field['value'] == 'Much')) {

					$sumScore += $multiply * 3;

				} else if (($field['value'] == 'Very Severe') || ($field['value'] == 'Very Dissatisfied') || ($field['value'] == 'Very Much Noticeable') || ($field['value'] == 'Very Much Worried') || ($field['value'] == 'Very Much Interfering')) {

					$sumScore += $multiply * 4;
				}

			}
		}
	}

	// Set Total Score Value
	$fields[90]['value'] = $sumScore;

	return $fields;
}


add_filter('wpforms_process_filter', 'rosewellness_wpforms_male_update_total_field', 10, 3);

function rosewellness_wpforms_male_update_total_field($fields, $entry, $form_data)
{

	// Only run on my form with ID = 15063
	if (15063 != $form_data['id'])
		return $fields;

	$sumScore = 0;

	if (!empty($fields)) {
		foreach ($fields as $field) {

			if ($field['value'] == 'Yes') {
				$sumScore += 1;
			}
		}
	}

	// Set Total Score Value
	$fields[90]['value'] = $sumScore;

	return $fields;
}


add_filter('wpforms_process_filter', 'rosewellness_wpforms_female_estrogen_update_total_field', 10, 3);

function rosewellness_wpforms_female_estrogen_update_total_field($fields, $entry, $form_data)
{

	// Only run on my form with ID = 15062
	if (15062 != $form_data['id'])
		return $fields;

	$sumScore = 0;

	if (!empty($fields)) {
		foreach ($fields as $field) {

			if ($field['value'] == 'Yes') {
				$sumScore += 1;
			}
		}
	}

	// Set Total Score Value
	$fields[90]['value'] = $sumScore;

	return $fields;
}


add_filter('wpforms_process_filter', 'rosewellness_wpforms_female_update_total_field', 10, 3);

function rosewellness_wpforms_female_update_total_field($fields, $entry, $form_data)
{

	// Only run on my form with ID = 15061
	if (15061 != $form_data['id'])
		return $fields;

	$sumScore = 0;

	if (!empty($fields)) {
		foreach ($fields as $field) {

			if ($field['value'] == 'Yes') {
				$sumScore += 1;
			}
		}
	}

	// Set Total Score Value
	$fields[90]['value'] = $sumScore;

	return $fields;
}

/* WP Tech #4711 - RS */

add_filter('posts_search', 'wp_tech_search_by_title', 10, 2);

function wp_tech_search_by_title($search, $wp_query)
{
	if (is_admin() && !empty($search) && !empty($wp_query->query_vars['search_terms'])) {
		global $wpdb;

		$q = $wp_query->query_vars;
		$n = !empty($q['exact']) ? '' : '%';

		$search = array();

		foreach (( array )$q['search_terms'] as $term)
			$search[] = $wpdb->prepare("$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like($term) . $n);


		if (!is_user_logged_in())
			$search[] = "$wpdb->posts.post_password = ''";


		$search = ' AND ' . implode(' AND ', $search);
	}

	return $search;
}


/******** Preload the CSS ****************/
function add_rel_preload($html, $handle, $href, $media)
{
	if (is_admin())
		return $html;

	$html = <<<EOT
<link rel='preload' as='style' onload="this.onload=null;this.rel='stylesheet'"
id='$handle' href='$href' type='text/css' media='all' />
EOT;

	return $html;
}

add_filter('style_loader_tag', 'add_rel_preload', 10, 4);

/* Ajax Response - Home Page */

add_action('wp_ajax_rosewellness_homepage_section_team', 'rosewellness_homepage_section_team');
add_action('wp_ajax_nopriv_rosewellness_homepage_section_team', 'rosewellness_homepage_section_team');

function rosewellness_homepage_section_team()
{
	$html = do_shortcode('[team_carousel_shortcode]');

	echo json_encode(array('html' => $html));
	die;
}

add_action('wp_ajax_rosewellness_homepage_section_blog', 'rosewellness_homepage_section_blog');
add_action('wp_ajax_nopriv_rosewellness_homepage_section_blog', 'rosewellness_homepage_section_blog');

function rosewellness_homepage_section_blog()
{
	$html = do_shortcode('[blog_list_shortcode]');

	echo json_encode(array('html' => $html));
	die;
}

add_action('wp_ajax_rosewellness_homepage_section_testimonial', 'rosewellness_homepage_section_testimonial');
add_action('wp_ajax_nopriv_rosewellness_homepage_section_testimonial', 'rosewellness_homepage_section_testimonial');

function rosewellness_homepage_section_testimonial()
{
	$html = do_shortcode('[testimonials_carousel_shortcode]');

	echo json_encode(array('html' => $html));
	die;
}

/********* Speed Optimisation ********/

function remove_query_strings()
{
	if (!is_admin()) {
		add_filter('script_loader_src', 'remove_query_strings_split', 15);
		add_filter('style_loader_src', 'remove_query_strings_split', 15);
	}
}

function remove_query_strings_split($src)
{
	$output = preg_split("/(&ver|\?ver)/", $src);
	return $output[0];
}

add_action('init', 'remove_query_strings');
/* WP Tech #6409 */
add_action('wp_head', 'disable_link');
function disable_link()
{
	if (is_page(36)) {
		echo "<script>jQuery(document).ready(function(){
			jQuery('.team-stuff-section a').each(function(){
					jQuery(this).removeAttr('href');

			});
		});</script>";
	}
}

/* WP Tech #6409 */

function exclude_post_categories($excl = '', $spacer = ', ')
{
	$categories = get_the_category($post->ID);
	if (!empty($categories)) {
		$exclude = $excl;
		$exclude = explode(",", $exclude);
		$thecount = count(get_the_category()) - count($exclude);
		foreach ($categories as $cat) {
			$html = '';
			if (!in_array($cat->cat_ID, $exclude)) {
				$html .= '<a href="' . get_category_link($cat->cat_ID) . '" ';
				$html .= 'title="' . $cat->cat_name . '">' . $cat->cat_name . '</a>';
				if ($thecount > 0) {
					$html .= $spacer;
				}
				$thecount--;
				echo $html;
			}
		}
	}
}

function dequeue_gutenberg_theme_css()
{
	wp_dequeue_style('wp-block-library');
}

add_action('wp_enqueue_scripts', 'dequeue_gutenberg_theme_css', 100);

/* Infinite Media Scrolling WP Admin - RT */
add_filter('media_library_infinite_scrolling', '__return_true');
