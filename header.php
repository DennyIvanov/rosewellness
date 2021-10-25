<?php
/**
 * The Header for rosewellness
 *
 * Displays all of the <head> section and everything up till <div id="content-wrapper">
 *
 * @package rosewellness
 *
 */

global $rosewellness_general;
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"/>
	<meta name="ahrefs-site-verification" content="6facd1b607e15f588f2588e00ebdc528e47500a614fcd207f7b15712ca931ce0"/>
	<title><?php wp_title(''); ?></title>

	<?php

	global $wp_query;

	// Current Page ID
	$current_page_ID = $wp_query->post->ID;
	//            $checkCat = $wp_query->query['category_name'];
	$category_name = $wp_query->query_vars['category_name'];

	// Current Meta Desc
	$meta_desc = get_post_meta($current_page_ID, '_yoast_wpseo_metadesc', true);

	if (empty($meta_desc)) { ?>
		<meta name="description" content="<?php if (is_single()) {
			single_post_title($current_page_ID);
		} else {
			bloginfo('name');
			echo " - ";
			echo get_the_title($current_page_ID);
		}

		?>"/>
	<?php }

	if (!empty($checkCat)) {
		echo '<meta name="description" content="' . $meta_desc . '"/>';
	}

	?>

	<!-- Mobile Viewport Fix ( j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag ) -->
	<meta name="viewport"
		  content="<?php echo apply_filters('rosewellness_viewport', 'width=device-width, initial-scale=1.0, maximum-scale=2.0'); ?>"/>

	<link rel="profile" href="http://gmpg.org/xfn/11"/>
	<?php if ('disable' != $rosewellness_general['favicon_use']) { ?>
		<link rel="shortcut icon" type="image/x-icon"
			  href="<?php echo $rosewellness_general['favicon_upload']; ?>" /><?php } ?>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>

	<link rel="preconnect"
		  href="https://fonts.gstatic.com"
		  crossorigin/>

	<link rel="preload"
		  as="style"
		  href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700&display=swap"/>

	<link rel="stylesheet"
		  href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700&display=swap"
		  media="print"
		  onload="this.media='all'"/>

	<noscript>
		<link rel="stylesheet"
			  href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700&display=swap"/>
	</noscript>

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all"/>

	<!--[if lt IE 9]>
            <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
        <![endif]-->

	<script type="text/javascript">
		(function (i, s, o, g, r, a, m) {
			i['GoogleAnalyticsObject'] = r;
			i[r] = i[r] || function () {
				(i[r].q = i[r].q || []).push(arguments)
			}, i[r].l = 1 * new Date();
			a = s.createElement(o),
				m = s.getElementsByTagName(o)[0];
			a.async = 1;
			a.src = g;
			m.parentNode.insertBefore(a, m)
		})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

		ga('create', 'UA-55630992-1', 'auto');
		ga('send', 'pageview');

	</script>

	<?php wp_head(); ?>

	<?php rosewellness_head(); ?>

	<!--Ajax Refrence URL-->
	<script type="text/javascript">
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		var homeurl = '<?php echo home_url('/'); ?>';
		var styleurl = '<?php echo get_stylesheet_directory_uri(); ?>';
	</script>

	<?php echo do_shortcode('[custom_bim_popup]'); ?>


</head>
<body <?php body_class(); ?>>

<?php rosewellness_hook_begin_body(); ?>

<?php rosewellness_hook_begin_main_wrapper(); ?>

<?php rosewellness_hook_before_header(); ?>

<?php

// Get header Top bar
$header_options = get_option('custom_theme_options');
$footer_options = get_option('custom_theme_options');

$header_btn_text_1 = $footer_options['header_btn_text_1'];
$header_btn_url_1 = $footer_options['header_btn_url_1'];

$header_btn_text_2 = $footer_options['header_btn_text_2'];
$header_btn_url_2 = $footer_options['header_btn_url_2'];

if (!empty($header_options['header_top_bar'])) { ?>
	<div class="top_fixed_header">
		<?php echo trim($header_options['header_top_bar']); ?>
	</div>
<?php } ?>


<header class="header">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-8 col-md-7 col-sm-8 col-xs-12 logo-header">

				<?php rosewellness_hook_before_logo(); ?>
				<a role="link" class="navbar-brand logo" href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?>">
					<?php echo ('image' == $rosewellness_general['logo_use']) ? '<img class="img-responsive" role="img" alt="' . get_bloginfo('name') . '" src="' . $rosewellness_general['logo_upload'] . '" />' : get_bloginfo('name'); ?>
				</a>
				<?php rosewellness_hook_after_logo(); ?>

				<a class="cntct_btn orange_btn mobile_btn hidden-lg" href="<?php echo $header_btn_url_2; ?>">
					<?php echo $header_btn_text_2; ?>
				</a>


				<div class="search_section mobile_search hidden-lg hidden-md">
					<a id="search_button" href="javascript:void(0);">
						<i class="fa fa-search"></i>
					</a>
				</div>

				<nav class="navbar navbar-expand-md navbar-light">
					<button type="button"
							class="navbar-toggle"
							data-toggle="collapse"
							data-target=".navbar-main-collapse"
							aria-expanded="false"
							aria-label="Toggle navigation">
						<i class="fa fa-bars"></i>
					</button>

					<div class="collapse navbar-collapse navbar-main-collapse">

						<?php
						wp_nav_menu(
								array(
										'theme_location' => 'primary',
										'container' => false,
										'menu_class' => 'nav navbar-nav',
										'menu_id' => 'mainmenu'
								)
						);
						?>

					</div>
				</nav>

				<!----------- Mobile Menu ----------------->
				<div class="mobile_menu hidden-lg hidden-md">
					<nav id="sidebar-wrapper">
						<div class="header-buttons">
							<!--a class="patient_btn white_btn" target="_blank" href="<?php echo $header_btn_url_1; ?>"><?php echo $header_btn_text_1; ?></a>
            			                <a class="call_btn green_btn" target="_self" href="tel:571.529.6699">Call Us</a-->

							<ul class="mobile_list_item">
								<li><a role="link" class="navbar-brand logo" href="<?php echo home_url('/'); ?>"
									   title="<?php bloginfo('name'); ?>"><?php echo ('image' == $rosewellness_general['logo_use']) ? '<img class="img-responsive" role="img" alt="' . get_bloginfo('name') . '" src="' . $rosewellness_general['logo_upload'] . '" />' : get_bloginfo('name'); ?></a>
								</li>
								<li><a class="cntct_btn orange_btn" target="_self"
									   href="<?php echo $header_btn_url_2; ?>"><?php echo $header_btn_text_2; ?></a>
								</li>
							</ul>

						</div>
						<ul class="sidebar-nav">
							<button type="button" class="navbar-toggle-close">
								<i class="fa fa-close"></i>
							</button>
							<?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav navbar-nav', 'menu_id' => 'mainmenu'));
							?>
						</ul>
					</nav>
				</div>
			</div>

			<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12 menu-header hidden-xs hidden-sm">
				<div class="top-bar-right">
					<div class="search_section">
						<a id="search_button" href="javascript:void(0);"><i class="fa fa-search"></i></a>
					</div>
					<div class="header-buttons">
						<?php

						// Get header Buttons
						$footer_options = get_option('custom_theme_options');

						$header_btn_text_1 = $footer_options['header_btn_text_1'];
						$header_btn_url_1 = $footer_options['header_btn_url_1'];

						$header_btn_text_2 = $footer_options['header_btn_text_2'];
						$header_btn_url_2 = $footer_options['header_btn_url_2'];

						$header_btn_text_3 = $footer_options['header_btn_text_3'];

						?>
						<a class="patient_btn white_btn" target="_blank"
						   href="<?php echo $header_btn_url_1; ?>"><?php echo $header_btn_text_1; ?></a>
						<a class="cntct_btn orange_btn" target="_self"
						   href="<?php echo $header_btn_url_2; ?>"><?php echo $header_btn_text_2; ?></a>
						<a class="contact-num" target="_self"
						   href="tel:<?php echo $header_btn_text_3; ?>"><?php echo $header_btn_text_3; ?></a>
					</div>
				</div>
			</div>
		</div>
		<!--------- Search Form ------------->
		<div class="row">
			<div class="search_wrapper" style="display:none;">
				<form method="get" id="searchform" action="<?php echo site_url(); ?>">
					<i class="fa fa-search"></i>
					<a href="javascript:void(0);" class="icon_close"><i class="fa fa-close"></i></a>
					<input type="text" class="field" name="s" id="s" placeholder="Enter your search">
					<input type="hidden" class="field" name="type" value="h">
					<input type="submit" class="submit" value="" style="display:none;">
				</form>
			</div>
		</div>

	</div>
</header>

<?php rosewellness_hook_after_header(); ?>

<?php rosewellness_hook_begin_content_wrapper(); ?>
