<?php
/**
 * The template for displaying Sidebar
 *
 * @package rosewellness
 * 
 */
$sidebar_id = rosewellness_get_sidebar_id();
$class_name = "";
?>

<div id="sidebar" class="col-sm-3 col-xs-12 pull-right<?php echo $class_name; ?>" role="complementary">
    <div class="row">
        <?php rosewellness_hook_begin_sidebar(); ?>

        <?php
        // Default Widgets ( Fallback )
        if (!($sidebar_id && dynamic_sidebar($sidebar_id))) {
            ?>
            <div class="widget col-lg-12 sidebar-widget"><h3 class="widgettitle"><?php _e('Search', 'rosewellness'); ?></h3><?php get_search_form(); ?></div>
            <?php }
            ?>

        <?php rosewellness_hook_end_sidebar(); ?>
    </div>
</div><!-- #sidebar -->