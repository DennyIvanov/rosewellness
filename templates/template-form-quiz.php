<?php
/**
 * Template Name: Quiz Template
 * Description: A Page Template that display portfolio items.
 *
 * @package Betheme
 * @author Muffin Group
 */

get_header();
?>

<div class="full-width-page-content section_wrapper">
    <div class="container">
        <?php
        if (have_posts()): while (have_posts()): the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
</div>

<?php get_footer();

// Omit Closing PHP Tags