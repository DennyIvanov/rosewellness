<?php
/**
 * Rosewellness Custom Widgets
 *
 * A small 'icing on cake' ;)
 *
 * @package rosewellness
 */

/**
 * Custom Widget for FeedBurner RSS Subscription and Social Share
 *
 */
class rosewellness_subscribe_widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     *
     * */
    function rosewellness_subscribe_widget() {
        $widget_ops = array('classname' => 'rosewellness-subscribe-widget-container', 'description' => __('Widget for email subscription form and Social Icons such as Facebook, Twitter, etc.', 'rosewellness'));
        $this->WP_Widget('rt-subscribe-widget', __('Rose Wellness: Social Widget', 'rosewellness'), $widget_ops);
    }

    /**
     * Outputs the HTML
     *
     * @param array An array of standard parameters for widgets in this theme
     * @param array An array of settings for this widget instance
     * @return void Echoes it's output
     *
     * */
    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        $facebook_link = empty($instance['facebook_link']) ? '' : $instance['facebook_link'];
        $twitter_link = empty($instance['twitter_link']) ? '' : $instance['twitter_link'];
        $google_link = empty($instance['google_link']) ? '' : $instance['google_link'];
        $rss_link = empty($instance['rss_link']) ? '' : $instance['rss_link'];
        $linkedin_link = empty($instance['linkedin_link']) ? '' : $instance['linkedin_link'];
        $myspace_link = empty($instance['myspace_link']) ? '' : $instance['myspace_link'];
        $stumbleupon_link = empty($instance['stumbleupon_link']) ? '' : $instance['stumbleupon_link'];
        $rosewellness_link_target = isset($instance['rosewellness_link_target']) ? $instance['rosewellness_link_target'] : true;
        $rosewellness_facebook_show = isset($instance['rosewellness_show_facebook']) ? $instance['rosewellness_show_facebook'] : true;
        $rosewellness_google_show = isset($instance['rosewellness_show_google']) ? $instance['rosewellness_show_google'] : true;
        $rosewellness_twitter_show = isset($instance['rosewellness_show_twitter']) ? $instance['rosewellness_show_twitter'] : true;
        $rosewellness_rss_show = isset($instance['rosewellness_show_rss']) ? $instance['rosewellness_show_rss'] : true;
        $rosewellness_linkedin_show = isset($instance['rosewellness_show_linkedin']) ? $instance['rosewellness_show_linkedin'] : true;
        $rosewellness_myspace_show = isset($instance['rosewellness_show_myspace']) ? $instance['rosewellness_show_myspace'] : true;
        $rosewellness_stumbleupon_show = isset($instance['rosewellness_show_stumbleupon']) ? $instance['rosewellness_show_stumbleupon'] : true;
        $no_options = 0;

        echo $before_widget;
        if ($title)
            echo $before_title . $title . $after_title;
        ?>

        <div class="email-subscription-container"><!-- email-subscription-container begins -->
            <?php
            $target = ( $rosewellness_link_target ) ? ' target="_blank"' : '';
            $fb_image_URL = '<img src="'.get_stylesheet_directory_uri().'/images/iconfb.png">';
            $tw_image_URL = '<img src="'.get_stylesheet_directory_uri().'/images/icontw.png">';
            $p_image_URL = '<img src="'.get_stylesheet_directory_uri().'/images/icongpinterest.png">';
            $insta_image_URL = '<img src="'.get_stylesheet_directory_uri().'/images/iconinsta.png">';
            
            if (( $rosewellness_facebook_show && $facebook_link ) || ( $rosewellness_twitter_show && $twitter_link ) || ( $rosewellness_google_show && $google_link ) || ( $rosewellness_rss_show && $rss_link ) || ( $rosewellness_linkedin_show && $linkedin_link ) || ( $rosewellness_myspace_show && $myspace_link ) || ( $rosewellness_stumbleupon_show && $stumbleupon_link )) {
                $no_options++;
                ?>
                <ul role="list" class="social-icons clearfix"><?php
                    echo ( $rosewellness_facebook_show && $facebook_link ) ? '<li role="listitem"><a role="link" rel="nofollow"' . $target . ' class="facebook" href="' . $facebook_link . '"><i class="fa fa-facebook"></i></a></li>' : '';
                    echo ( $rosewellness_twitter_show && $twitter_link ) ? '<li role="listitem"><a role="link" rel="nofollow"' . $target . ' class="twitter" href="' . $twitter_link . '"><i class="fa fa-twitter"></i></a></li>' : '';
                    echo ( $rosewellness_google_show && $google_link ) ? '<li role="listitem"><a role="link" rel="nofollow"' . $target . ' class="google" href="' . $google_link . '"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>' : '';
                    echo ( $rosewellness_rss_show && $rss_link ) ? '<li role="listitem"><a role="link" rel="nofollow"' . $target . ' class="rss" href="' . $rss_link . '"><i class="fa fa-rss-square" aria-hidden="true"></i></a></li>' : '';
                    echo ( $rosewellness_linkedin_show && $linkedin_link ) ? '<li role="listitem"><a role="link" rel="nofollow"' . $target . ' class="linkedin" href="' . $linkedin_link . '"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>' : '';
                    echo ( $rosewellness_stumbleupon_show && $stumbleupon_link ) ? '<li role="listitem"><a role="link" rel="nofollow"' . $target . ' class="stumbleupon" href="' . $stumbleupon_link . '"><i class="fa fa-instagram"></i></a></li>' : '';
                    echo ( $rosewellness_myspace_show && $myspace_link ) ? '<li role="listitem"><a role="link" rel="nofollow"' . $target . ' class="myspace" href="' . $myspace_link . '"><i class="fa fa-pinterest-p"></i></a></li>' : '';
                    ?>
                </ul><?php
            }

            if (!$no_options) {
                ?>
                <p><?php printf(__('Please configure this widget <a href="%s" target="_blank" title="Configure Subscribe Widget">here</a>.', 'rosewellness'), admin_url('/widgets.php')); ?></p><?php }
            ?>
        </div> <!-- end email-subscription-container -->
        <?php
        echo $after_widget;
    }

    /**
     * Deals with the settings when they are saved by the admin
     *
     * */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['rss_link'] = esc_url_raw($new_instance['rss_link']);
        $instance['twitter_link'] = esc_url_raw($new_instance['twitter_link']);
        $instance['facebook_link'] = esc_url_raw($new_instance['facebook_link']);
        $instance['google_link'] = esc_url_raw($new_instance['google_link']);
        $instance['linkedin_link'] = esc_url_raw($new_instance['linkedin_link']);
        $instance['myspace_link'] = esc_url_raw($new_instance['myspace_link']);
        $instance['stumbleupon_link'] = esc_url_raw($new_instance['stumbleupon_link']);
        $instance['rosewellness_link_target'] = !empty($new_instance['rosewellness_link_target']) ? 1 : 0;
        $instance['rosewellness_show_rss'] = !empty($new_instance['rosewellness_show_rss']) ? 1 : 0;
        $instance['rosewellness_show_facebook'] = !empty($new_instance['rosewellness_show_facebook']) ? 1 : 0;
        $instance['rosewellness_show_twitter'] = !empty($new_instance['rosewellness_show_twitter']) ? 1 : 0;
        $instance['rosewellness_show_google'] = !empty($new_instance['rosewellness_show_google']) ? 1 : 0;
        $instance['rosewellness_show_linkedin'] = !empty($new_instance['rosewellness_show_linkedin']) ? 1 : 0;
        $instance['rosewellness_show_myspace'] = !empty($new_instance['rosewellness_show_myspace']) ? 1 : 0;
        $instance['rosewellness_show_stumbleupon'] = !empty($new_instance['rosewellness_show_stumbleupon']) ? 1 : 0;
        return $instance;
    }

    /**
     * Displays the form on the Widgets page of the WP Admin area
     *
     * */
    function form($instance) {
        $defaults = array('label' => 'Sign up for our email newsletter', 'button' => 'Subscribe', 'rosewellness_show_subscription' => '0', 'rosewellness_show_rss' => '0', 'rosewellness_show_facebook' => '0', 'rosewellness_show_twitter' => '0', 'rosewellness_show_google' => '0', 'rosewellness_show_linkedin' => '0', 'rosewellness_show_myspace' => '0', 'rosewellness_show_stumbleupon' => '0', 'rosewellness_link_target' => '1');
        // update instance's default options
        $instance = wp_parse_args((array) $instance, $defaults);

        $title = isset($instance['title']) ? esc_attr(( $instance['title'])) : '';
        $rss_link = isset($instance['rss_link']) ? esc_url($instance['rss_link']) : '';
        $twitter_link = isset($instance['twitter_link']) ? esc_url($instance['twitter_link']) : '';
        $facebook_link = isset($instance['facebook_link']) ? esc_url($instance['facebook_link']) : '';
        $google_link = isset($instance['google_link']) ? esc_url($instance['google_link']) : '';
        $linkedin_link = isset($instance['linkedin_link']) ? esc_url($instance['linkedin_link']) : '';
        $myspace_link = isset($instance['myspace_link']) ? esc_url($instance['myspace_link']) : '';
        $stumbleupon_link = isset($instance['stumbleupon_link']) ? esc_url($instance['stumbleupon_link']) : '';

        $rosewellness_show_rss = isset($instance['rosewellness_show_rss']) ? (bool) $instance['rosewellness_show_rss'] : false;
        $rosewellness_show_facebook = isset($instance['rosewellness_show_facebook']) ? (bool) $instance['rosewellness_show_facebook'] : false;
        $rosewellness_show_twitter = isset($instance['rosewellness_show_twitter']) ? (bool) $instance['rosewellness_show_twitter'] : false;
        $rosewellness_show_google = isset($instance['rosewellness_show_google']) ? (bool) $instance['rosewellness_show_google'] : false;
        $rosewellness_show_linkedin = isset($instance['rosewellness_show_linkedin']) ? (bool) $instance['rosewellness_show_linkedin'] : false;
        $rosewellness_show_myspace = isset($instance['rosewellness_show_myspace']) ? (bool) $instance['rosewellness_show_myspace'] : false;
        $rosewellness_show_stumbleupon = isset($instance['rosewellness_show_stumbleupon']) ? (bool) $instance['rosewellness_show_stumbleupon'] : false;
        $rosewellness_link_target = isset($instance['rosewellness_link_target']) ? (bool) $instance['rosewellness_link_target'] : false;
        ?>

        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'rosewellness'); ?>: </label><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" role="textbox" value="<?php echo esc_attr($title); ?>" /></p>
        <p><strong><?php _e('Social Share', 'rosewellness'); ?>:</strong></p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name('rosewellness_show_rss'); ?>" id="<?php echo $this->get_field_id('rosewellness_show_rss'); ?>" <?php checked($rosewellness_show_rss); ?> />
            <label for="<?php echo $this->get_field_id('rosewellness_show_rss'); ?>"><?php _e('RSS Feed Link', 'rosewellness'); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id('rss_link'); ?>" name="<?php echo $this->get_field_name('rss_link'); ?>" type="text" role="textbox" value="<?php echo esc_attr($rss_link); ?>" />
        </p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name('rosewellness_show_facebook'); ?>" id="<?php echo $this->get_field_id('rosewellness_show_facebook'); ?>" <?php checked($rosewellness_show_facebook); ?> />
            <label for="<?php echo $this->get_field_id('rosewellness_show_facebook'); ?>"><?php _e('Facebook Link', 'rosewellness'); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id('facebook_link'); ?>" name="<?php echo $this->get_field_name('facebook_link'); ?>" type="text" role="textbox" value="<?php echo esc_attr($facebook_link); ?>" />
        </p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name('rosewellness_show_twitter'); ?>" id="<?php echo $this->get_field_id('rosewellness_show_twitter'); ?>" <?php checked($rosewellness_show_twitter); ?> />
            <label for="<?php echo $this->get_field_id('rosewellness_show_twitter'); ?>"><?php _e('Twitter Link', 'rosewellness'); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id('twitter_link'); ?>" name="<?php echo $this->get_field_name('twitter_link'); ?>" type="text" role="textbox" value="<?php echo esc_attr($twitter_link); ?>" />
        </p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name('rosewellness_show_google'); ?>" id="<?php echo $this->get_field_id('rosewellness_show_google'); ?>" <?php checked($rosewellness_show_google); ?> />
            <label for="<?php echo $this->get_field_id('rosewellness_show_google'); ?>"><?php _e('Google+ Link', 'rosewellness'); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id('google_link'); ?>" name="<?php echo $this->get_field_name('google_link'); ?>" type="text" role="textbox" value="<?php echo esc_attr($google_link); ?>" />
        </p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name('rosewellness_show_linkedin'); ?>" id="<?php echo $this->get_field_id('rosewellness_show_linkedin'); ?>" <?php checked($rosewellness_show_linkedin); ?> />
            <label for="<?php echo $this->get_field_id('rosewellness_show_linkedin'); ?>"><?php _e('LinkedIn Link', 'rosewellness'); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id('linkedin_link'); ?>" name="<?php echo $this->get_field_name('linkedin_link'); ?>" type="text" role="textbox" value="<?php echo esc_attr($linkedin_link); ?>" />
        </p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name('rosewellness_show_myspace'); ?>" id="<?php echo $this->get_field_id('rosewellness_show_myspace'); ?>" <?php checked($rosewellness_show_myspace); ?> />
            <label for="<?php echo $this->get_field_id('rosewellness_show_myspace'); ?>"><?php _e('Pinterest Link', 'rosewellness'); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id('myspace_link'); ?>" name="<?php echo $this->get_field_name('myspace_link'); ?>" type="text" role="textbox" value="<?php echo esc_attr($myspace_link); ?>" />
        </p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name('rosewellness_show_stumbleupon'); ?>" id="<?php echo $this->get_field_id('rosewellness_show_stumbleupon'); ?>" <?php checked($rosewellness_show_stumbleupon); ?> />
            <label for="<?php echo $this->get_field_id('rosewellness_show_stumbleupon'); ?>"><?php _e('Instagram Link', 'rosewellness'); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id('stumbleupon_link'); ?>" name="<?php echo $this->get_field_name('stumbleupon_link'); ?>" type="text" role="textbox" value="<?php echo esc_attr($stumbleupon_link); ?>" />
        </p>
        <p>
            <input class="link_target" id="<?php echo $this->get_field_id('rosewellness_link_target'); ?>" name="<?php echo $this->get_field_name('rosewellness_link_target'); ?>" role="checkbox" role="checkbox" role="checkbox" role="checkbox" type="checkbox" <?php checked($rosewellness_link_target); ?> />
            <label for="<?php echo $this->get_field_id('rosewellness_link_target'); ?>"><?php _e('Open Social Links in New Tab/Window', 'rosewellness'); ?></label>
        </p><?php
    }

}

/**
 * Custom Widget for Footer Menu
 */
class rosewellness_nav_menu_widget extends WP_Widget {

    function __construct() {
        $widget_ops = array('description' => __('Add a custom menu to your footer.'));
        parent::__construct('nav_menu', __('Rose Wellness: Footer Menu'), $widget_ops);
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $title = empty($instance['title']) ? __('Title', 'rosewellness') : apply_filters('widget_title', $instance['title']);
        // Get menu
        $nav_menu = !empty($instance['nav_menu']) ? wp_get_nav_menu_object($instance['nav_menu']) : false;

        if (!$nav_menu)
            return;
        
        if ($title)
			echo '<h5 class="rosewellness-title">'.$title.'</h5>';
            //echo $before_title . $title . $after_title;
            
        echo $args['before_widget'];

        wp_nav_menu(array('container' => '', 'menu_class' => 'footer-nav-menu', 'menu_id' => 'footer-nav-menu', 'menu' => $nav_menu));

        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['nav_menu'] = (int) $new_instance['nav_menu'];
        return $instance;
    }

    function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $nav_menu = isset($instance['nav_menu']) ? $instance['nav_menu'] : '';

        // Get menus
        $menus = wp_get_nav_menus(array('orderby' => 'name'));

        // If no menus exists, direct the user to go and create some.
        if (!$menus) {
            echo '<p>' . sprintf(__('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php')) . '</p>';
            return;
        }
        ?>
        <p style="overflow: hidden;">
            <label for="<?php echo $this->get_field_id('title'); ?>" style="display: block; float: left; padding: 0 0 3px;"><?php _e('Title', 'rosewellness'); ?>: </label>
            <input class="widefat" role="textbox" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
            <select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
                <?php
                foreach ($menus as $menu) {
                    echo '<option value="' . $menu->term_id . '"'
                    . selected($nav_menu, $menu->term_id, false)
                    . '>' . $menu->name . '</option>';
                }
                ?>
            </select>
        </p>
        <?php
    }

}

/**
 * Custom Widget for Footer Menu
 */
class rosewellness_custom_recent_blog_posts extends WP_Widget {

    function __construct() {
        $widget_ops = array('description' => __('Custom Recent Blog Posts'));
        parent::__construct('custom_blog_posts', __('Rose Wellness: Recent Blog Posts'), $widget_ops);
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $title = empty($instance['title']) ? __('Title', 'rosewellness') : apply_filters('widget_title', $instance['title']);
        $number_of_posts = empty($instance['number_of_posts']) ? __('Number of Posts', 'rosewellness') : apply_filters('widget_title', $instance['number_of_posts']);

        echo $args['before_widget'];
		
        if(wp_is_mobile()) { } else {
        if ($title)
            echo $before_title . $title . $after_title;
        ?>
        <div class="recent-blog-posts-wrapper">
            <?php
            if (empty($number_of_posts)) {
                $number_of_posts = 5;
            }
            $recent_posts_args = array('post_type' => 'post', 'posts_per_page' => $number_of_posts);
            $recent_posts_query = new WP_Query($recent_posts_args);
            if ($recent_posts_query->have_posts()) {
                while ($recent_posts_query->have_posts()) {
                    $recent_posts_query->the_post();
                    $postID =  get_the_id();
                    ?>
                    <div class="single-recent-post">
                        <a href="<?php echo get_the_permalink($postID); ?>">
        					<?php
        						if (has_post_thumbnail()) {
        							echo get_the_post_thumbnail($postID, 'full');
        						}
        					?>
        					<h4><?php echo get_the_title($postID); ?></h4>
        				    <p class="member_desg"><?php echo $members_desg; ?></p>
        				</a>
                    </div>
                    <?php
                }
            }
            wp_reset_postdata();
            wp_reset_query();
            ?>
        </div>
		<?php } ?>
        <?php
        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number_of_posts'] = strip_tags($new_instance['number_of_posts']);
        return $instance;
    }

    function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number_of_posts = isset($instance['number_of_posts']) ? esc_attr($instance['number_of_posts']) : '';
        ?>
        <p style="overflow: hidden;">
            <label for="<?php echo $this->get_field_id('title'); ?>" style="display: block; float: left; padding: 0 0 3px;"><?php _e('Title', 'rosewellness'); ?>: </label>
            <input class="widefat" role="textbox" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p style="overflow: hidden;">
            <label for="<?php echo $this->get_field_id('number_of_posts'); ?>" style="display: block; float: left; padding: 0 0 3px;"><?php _e('Number of Posts', 'rosewellness'); ?>: </label>
            <input class="widefat" role="textbox" id="<?php echo $this->get_field_id('number_of_posts'); ?>" name="<?php echo $this->get_field_name('number_of_posts'); ?>" type="number" value="<?php echo esc_attr($number_of_posts); ?>" />
        </p>
        <?php
    }

}

/**
 * Custom Widget for Footer Menu
 */
class rosewellness_testimonial_slider extends WP_Widget {

    function __construct() {
        $widget_ops = array('description' => __('Custom Testimonial Slider'));
        parent::__construct('custom_testimonial_slider', __('Rose Wellness: Testimonials'), $widget_ops);
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $title = empty($instance['title']) ? __('', 'rosewellness') : apply_filters('widget_title', $instance['title']);

        echo $args['before_widget'];
        ?>
        <div class="testimonial-widget-wrapper">
            <div class="cycle-slideshow" data-cycle-fx="fade" data-cycle-auto-height="container" data-cycle-timeout="4000" data-cycle-slides="> div">
                <?php
                $testimonials_args = array(
                    'post_type' => 'testimonial',
                    'posts_per_page' => -1,
                );
                $testimonials_query = new WP_Query($testimonials_args);
                if ($testimonials_query->have_posts()) {
                    while ($testimonials_query->have_posts()) {
                        $testimonials_query->the_post();
                        ?>
                        <div class="testimonial-container">
                            <?php the_content(); ?>
                            <h4><?php the_title(); ?></h4>
                        </div>
                        <?php
                    }
                }
                wp_reset_postdata();
                wp_reset_query();
                ?>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    function form($instance) {
        echo 'No Settings Required :)';
    }

}

/**
 * Registers all Rosewellness Custom Widgets
 * 
 */
function rosewellness_register_widgets() {
//    register_widget('rosewellness_subscribe_widget');
    register_widget('rosewellness_nav_menu_widget');
    register_widget('rosewellness_custom_recent_blog_posts');
    register_widget('rosewellness_testimonial_slider');
}

add_action('widgets_init', 'rosewellness_register_widgets');
