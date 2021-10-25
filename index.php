<?php
/**
 * The generic template file
 * 
 * @package rosewellness
 * 
 */
get_header();
?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?php
            if (have_posts()): while (have_posts()): the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>