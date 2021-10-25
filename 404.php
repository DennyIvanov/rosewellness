<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package rosewellness
 * 
 */
get_header();

?>

    <div class="top_banner_single" style="background-image:url('<?php echo get_stylesheet_directory_uri(); ?>/images/404-page.jpg')">
        <div class="banner-text">
            <h1><span>Ooops...</span></h1>
            <h2><p>The requested page does not exist. We will automatically redirect you to the homepage in 10 seconds.</p></h2>
        </div>
    </div>

    <div class="full-width-page-content blog-category">
        <div class="container">
            <?php rosewellness_hook_begin_content(); ?>
            
            <?php rosewellness_hook_begin_post(); ?>
                
                <div class="post-content clearfix rosewellness-not-found">
                    <p><?php _e('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'rosewellness'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            
            <?php rosewellness_hook_end_post(); ?>

            <?php rosewellness_hook_end_content(); ?>
        </div>
    </div>

<?php get_footer(); ?>
<script>
    // Redirect to Home
    window.setTimeout(function() {
        window.location.href = '<?php echo site_url(); ?>';
    },  10000);
</script>