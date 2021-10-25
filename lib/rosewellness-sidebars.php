<?php

/**
 * Rosewellness sidebars
 *
 * @package rosewellness
 *
 */

/**
 * Registers sidebars
 *
 */
function rosewellness_widgets_init() {

    // Sidebar Widget
    register_sidebar(array(
        'name' => __('Sidebar Widgets', 'rosewellness'),
        'id' => 'sidebar-widgets',
        'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar( array(
        'name'          => 'Single Blog Sidebar',
        'id'            => 'custom-single-blog',
        'before_widget' => '<div id="%1$s" class="rosewellness-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rosewellness-title">',
        'after_title'   => '</h2>',
    ) );
    
    register_sidebar( array(
        'name'          => 'Blog Sidebar',
        'id'            => 'custom-blog',
        'before_widget' => '<div id="%1$s" class="rosewellness-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rosewellness-title">',
        'after_title'   => '</h2>',
    ) );

    // Footer Widget
    register_sidebar( array(
        'name'          => 'Footer Widget 1',
        'id'            => 'custom-footer-widget-1',
        'before_widget' => '<div id="%1$s" class="rosewellness-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rosewellness-title">',
        'after_title'   => '</h2>',
    ) );
    
    register_sidebar( array(
        'name'          => 'Footer Widget 2',
        'id'            => 'custom-footer-widget-2',
        'before_widget' => '<div id="%1$s" class="rosewellness-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rosewellness-title">',
        'after_title'   => '</h2>',
    ) );
    
    register_sidebar( array(
        'name'          => 'Footer Widget 3',
        'id'            => 'custom-footer-widget-3',
        'before_widget' => '<div id="%1$s" class="rosewellness-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rosewellness-title">',
        'after_title'   => '</h2>',
    ) );
    
    register_sidebar( array(
        'name'          => 'Footer Widget 4',
        'id'            => 'custom-footer-widget-4',
        'before_widget' => '<div id="%1$s" class="rosewellness-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rosewellness-title">',
        'after_title'   => '</h2>',
    ) );
    
    register_sidebar( array(
        'name'          => 'Footer Widget 5',
        'id'            => 'custom-footer-widget-5',
        'before_widget' => '<div id="%1$s" class="rosewellness-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rosewellness-title">',
        'after_title'   => '</h2>',
    ) );
    
    register_sidebar( array(
        'name'          => 'Footer Social Widget',
        'id'            => 'custom-footer-widget-6',
        'before_widget' => '<div id="%1$s" class="rosewellness-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rosewellness-title">',
        'after_title'   => '</h2>',
    ) );
}

add_action('widgets_init', 'rosewellness_widgets_init');
