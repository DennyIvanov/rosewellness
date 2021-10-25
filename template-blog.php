<?php
/**
 * Template Name: Blog
 */
get_header();
?>

<div class="full-width-page-content">
    <div class="container">
        <?php
        if (have_posts()): while (have_posts()): the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
</div>
<?php
get_footer();
