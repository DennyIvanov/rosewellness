<?php
/**
 * Rosewellness Theme Options
 *
 * @package rosewellness
 */

// Includes PHP files located in 'admin/php/' folder
foreach ( glob( get_template_directory() . "/admin/lib/*.php" ) as $lib_filename ) {
    require_once( $lib_filename );
}

/**
 * Rosewellness Theme Class
 *
 * Used to generate the Rosewellness admin Panel Options.
 */
class rosewellness_theme {

    var $theme_pages;

    /**
     * Constructor
     *
     * @return void
     **/
    function rosewellness_theme() {
        $this->theme_pages = apply_filters( 'rosewellness_add_theme_pages', array(
            'rosewellness_general' => array(
                            'menu_title' => __( 'General', 'rosewellness' ),
                            'menu_slug' => 'rosewellness_general'
                            ),
            'rosewellness_post_comments' => array(
                            'menu_title' => __( 'Post &amp; Comments', 'rosewellness' ),
                            'menu_slug' => 'rosewellness_post_comments'
                            ),
            'custom_theme_options' => array(
                            'menu_title' => __( 'Other Options', 'rosewellness' ),
                            'menu_slug' => 'custom_theme_options'
                            ) )
        );

        // Register callback for admin menu  setup
        add_action( 'admin_menu', array( &$this, 'rosewellness_theme_option_page' ) );
    }

    /**
     * Extends the admin menu, to add rosewellness
     **/
    function rosewellness_theme_option_page(  ) {
        // Add options page, you can also add it to different sections or use your own one
        add_theme_page( 'Rose Wellness - ' . $this->theme_pages['rosewellness_general']['menu_title'], '<strong class="rosewellness">Rose Wellness</strong>', 'edit_theme_options', 'rosewellness_general', array( &$this, 'rosewellness_admin_options' ) );
        foreach( $this->theme_pages as $key => $theme_page ) {
            if ( is_array( $theme_page ) )
                add_theme_page( 'Rose Wellness - ' . $theme_page['menu_title'], '--- <em>' . $theme_page['menu_title'] . '</em>', 'edit_theme_options', $theme_page['menu_slug'], array( &$this, 'rosewellness_admin_options' ) );
        }

        $tab = isset( $_GET['page'] )  ? $_GET['page'] : "rosewellness_general";

        /* Register  callback gets call prior the own page gets rendered */
        add_action( 'load-appearance_page_' . $tab, array( &$this, 'rosewellness_on_load_page' ) );
        add_action( 'admin_print_styles-appearance_page_' . $tab, array( &$this, 'rosewellness_admin_page_styles' ) );
        add_action( 'admin_print_scripts-appearance_page_' . $tab, array( &$this, 'rosewellness_admin_page_scripts' ) );
    }

    /**
     * Includes scripts for theme options page
     **/
    function rosewellness_admin_page_scripts() {
        wp_enqueue_script( 'rosewellness-admin-scripts', get_template_directory_uri() . '/admin/js/rosewellness-admin.js' );
        wp_enqueue_script( 'thickbox' );
        
    }

    /**
     * Includes styles for theme options page
     **/
    function rosewellness_admin_page_styles() {
        wp_enqueue_style( 'rosewellness-admin-theme-options', get_template_directory_uri() . '/admin/css/rosewellness-admin-theme-options.css' );
        wp_enqueue_style( 'thickbox'); //thickbox for logo and favicon upload option
    }
 
    /**
     * Rosewellness Tabs
     * 
     * Dividing the page into Tabs ( General, Post & Comments )
     **/
    function rosewellness_admin_options() {
        global $pagenow;
        $tabs = array();

        /* Separate the options page into two tabs - General , Post & Comments */
        foreach( $this->theme_pages as $key=>$theme_page ) {
            if ( is_array( $theme_page ) )
            $tabs[$theme_page['menu_slug']] = $theme_page['menu_title'];
        }
        $links = array();

        // Check to see which tab we are on
        $current = isset( $_GET['page'] )  ? $_GET['page'] : "rosewellness_general";
        foreach ( $tabs as $tab => $name ) {
            if ( $tab == $current ) {
                $links[] = "<a class='nav-tab nav-tab-active' href='?page=$tab'>$name</a>";
            } else {
                $links[] = "<a class='nav-tab' href='?page=$tab'>$name</a>";
            }
        } ?>

        <div class="wrap rosewellness-admin">
            <?php screen_icon( 'rosewellness' ); ?>
            <h2 class="rosewellness-tab-wrapper"><?php foreach ( $links as $link ) echo $link; ?></h2><?php
            if ( $pagenow == 'themes.php' ) {
                foreach( $this->theme_pages as $key=>$theme_page ) {
                    if ( is_array( $theme_page ) ) {
                        switch ( $current ) {
                            case $theme_page['menu_slug'] :
                                if ( function_exists( $theme_page['menu_slug'].'_options_page' ) )
                                call_user_func( $theme_page['menu_slug'].'_options_page', 'appearance_page_' . $current );
                                break;
                        }
                    }
                }
            } ?>
        </div><!-- .wrap --><?php
    }

    /**
     * Applies WordPress metabox funtionality to Rosewellness metaboxes
     **/
    function rosewellness_on_load_page() {
        /* Javascripts loaded to allow drag/drop, expand/collapse and hide/show of boxes. */
        wp_enqueue_script( 'common' );
        wp_enqueue_script( 'wp-lists' );
        wp_enqueue_script( 'postbox' );

        // Check to see which tab we are on
        $tab = isset( $_GET['page'] )  ? $_GET['page'] : "rosewellness_general";
        
        switch ( $tab ) {
            case 'rosewellness_general' :
                // All metaboxes registered during load page can be switched off/on at "Screen Options" automatically, nothing special to do therefore
                add_meta_box( 'logo_options', __( 'Logo & Favicon Settings', 'rosewellness'), 'rosewellness_logo_option_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'custom_styles_options', __( 'Custom Styles', 'rosewellness' ), 'rosewellness_custom_styles_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'backup_options', __( 'Backup / Restore Settings', 'rosewellness' ), 'rosewellness_backup_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                do_action( $tab .'_metaboxes' );
                break;
            case 'rosewellness_post_comments' :
                // All metaboxes registered during load page can be switched off/on at "Screen Options" automatically, nothing special to do therefore
                add_meta_box( 'post_summaries_options', __('Post Summary Settings', 'rosewellness'), 'rosewellness_post_summaries_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'post_thumbnail_options', __('Post Thumbnail Settings', 'rosewellness'), 'rosewellness_post_thumbnail_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'post_meta_options', __('Post Meta Settings', 'rosewellness'), 'rosewellness_post_meta_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'pagination_options', __('Pagination Settings', 'rosewellness'), 'rosewellness_pagination_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'comment_form_options', __('Comment Form Settings', 'rosewellness'), 'rosewellness_comment_form_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'gravatar_options', __('Gravatar Settings', 'rosewellness'), 'rosewellness_gravatar_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                do_action( $tab .'_metaboxes' );
                break;
            case $tab :
                do_action( $tab .'_metaboxes' );
                break;
        }
    }
}

// ★ of the show: Rosewellness ... we ♥ it ;)
$rt_theme = new rosewellness_theme();


/** 
 * Extended Custom Theme Options Metaboxes ( Screen Options )
 */
function rosewellness_custom_theme_options_screen_options() {
    //add_meta_box( 'header-details', __( 'Banner Section', 'rosewellness' ), 'banner_section_metabox', 'appearance_page_custom_theme_options', 'normal', 'core' );
    add_meta_box( 'footer-details', __( 'Header/Footer Details', 'rosewellness' ), 'footer_details_metabox', 'appearance_page_custom_theme_options', 'normal', 'core' );
}
add_action( 'custom_theme_options_metaboxes', 'rosewellness_custom_theme_options_screen_options' );