<?php
/**
 * Template Name: Home
 */
get_header();
?>

<div class="full-width-page-content home-page">
    <div class="container">
        <?php
        if (have_posts()): while (have_posts()): the_post();
			get_template_part( 'template-parts/acf-section/section/hero', 'section' );
                the_content();
            endwhile;
        endif;
        ?>
    </div>
</div>
<?php
get_footer();

