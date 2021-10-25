<?php
/**
 * Custom Metaboxes for Posts/Pages/Custom Posts
 */
/* Define the custom box */
// WP 3.0+
add_action('add_meta_boxes', 'rosewellness_adding_posttype_metaboxes');
// backwards compatible
add_action('admin_init', 'rosewellness_adding_posttype_metaboxes', 1);
/* Do something with the data entered */
add_action('save_post', 'rosewellness_saving_posttype_metaboxes');

/**
 *  Adds a box to the main column on the Post and Page edit screens
 */
function rosewellness_adding_posttype_metaboxes() {
    @$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
    $template_file = get_post_meta($post_id, '_wp_page_template', TRUE);
    
    add_meta_box('service-details', __('Member Details', 'rosewellness'), 'rosewellness_member_details_metabox', 'team', 'normal', 'high');
    add_meta_box('post-banner-details', __('Banner Details', 'rosewellness'), 'rosewellness_banner_details_metabox', 'post', 'normal', 'high');
    add_meta_box('post-layout-details', __('Layout Settings', 'rosewellness'), 'rosewellness_layout_metabox', 'post', 'side', 'high');
    
    add_meta_box('post-featured-details', __('Featured Post', 'rosewellness'), 'rosewellness_featured_metabox', 'post', 'side', 'high');
    
    add_meta_box('post-cta-details', __('CTA Details', 'rosewellness'), 'rosewellness_cta_details_metabox', 'post', 'normal', 'high');
    
    add_meta_box('assessments-cta-details', __('Assessments Details', 'rosewellness'), 'rosewellness_assessments_metabox', 'assessments', 'normal', 'high');
    
    if($post_id == 8785) {
		add_meta_box('threshold-section', __('Threshold Messages', 'rosewellness'), 'rosewellness_results_threshold_metaboxes', 'page', 'normal', 'high');
	}
	
	if($post_id == 8834) {
		add_meta_box('toxicity-section', __('Threshold Messages & Scores', 'rosewellness'), 'rosewellness_toxicity_threshold_metaboxes', 'page', 'normal', 'high');
	}
	
	if($post_id == 12398) {
		add_meta_box('insomnia-section', __('Threshold Messages & Scores', 'rosewellness'), 'rosewellness_toxicity_insomnia_metaboxes', 'page', 'normal', 'high');
	}
	
	if($template_file == 'templates/template-female-estrogen-dominance-results.php') {
	   add_meta_box('female-estrogen-section', __('Threshold Messages', 'rosewellness'), 'rosewellness_female_estrogen_metaboxes', 'page', 'normal', 'high');
	}
	
	if($template_file == 'templates/template-male-hormone-results.php') {
	   add_meta_box('male-hormone-section', __('Threshold Messages', 'rosewellness'), 'rosewellness_male_hormone_metaboxes', 'page', 'normal', 'high');
	}
	
	if($template_file == 'templates/template-female-hormone-results.php') {
	   add_meta_box('female-hormone-section', __('Threshold Messages', 'rosewellness'), 'rosewellness_female_hormone_metaboxes', 'page', 'normal', 'high');
	}
}


/**
 * Male Hormmone Results
 * Prints the box content
 */
function rosewellness_male_hormone_metaboxes($post) {
    wp_nonce_field(plugin_basename(__FILE__), $post->post_type . '_noncename');
    $male_hormone_threshold_message = get_post_meta($post->ID, 'male_hormone_threshold_message', true);
    ?>
    <table class="form-table" >
        <tbody>
            
            <tr valign="top">
                <th scope="row"><label for="post_cta_bg_img_id" class="selectit">Background Image:</label></th>
                <td>
                    <input type="button" value="<?php _e('Upload', 'rosewellness'); ?>" data-id="post_cta_bg_img_id" class="button custom_image_uploader" id="wpts_post_cta_bg_img_id" />
                    <input type="hidden"  name="male_hormone_threshold_message[post_cta_bg_img]" id="post_cta_bg_img_id" value="<?php if (isset($male_hormone_threshold_message['post_cta_bg_img'])) echo $male_hormone_threshold_message['post_cta_bg_img']; ?>" />
                    <?php $image_uploader = wp_get_attachment_image_src(@$male_hormone_threshold_message['post_cta_bg_img'], 'full'); ?>
                    <img src="<?php echo @$image_uploader[0] ?>" alt="Custom Image"<?php echo ( isset($image_uploader[0]) ? 'style="max-width: 150px; width: 100%;"' : 'style="max-width: 150px; width: 100%; display: none;"' ); ?> />
                </td>
            </tr>
		
			<tr valign="top">
                <th scope="row"><label for="subheading_text" class="selectit">Subheading Text</label></th>
                <td>
                    <?php
                    $content = @$male_hormone_threshold_message['subheading_text'];
                    $editor_settings = array('textarea_name' => 'male_hormone_threshold_message[subheading_text]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'subheading_text';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="threshold_level_score_1" class="selectit">Threshold Level 1 Score</label></th>
                <td>
					<input type="number" id="threshold_level_score_1" name="male_hormone_threshold_message[threshold_level_score_1]" value="<?php
                    if (isset($male_hormone_threshold_message['threshold_level_score_1'])) {
                        echo $male_hormone_threshold_message['threshold_level_score_1'];
                    }
                    ?>" />
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="threshold_level_score_2" class="selectit">Threshold Level 2 Score</label></th>
                <td>
					<input type="number" id="threshold_level_score_2" name="male_hormone_threshold_message[threshold_level_score_2]" value="<?php
                    if (isset($male_hormone_threshold_message['threshold_level_score_2'])) {
                        echo $male_hormone_threshold_message['threshold_level_score_2'];
                    }
                    ?>" />
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="threshold_level_score_3" class="selectit">Threshold Level 3 Score</label></th>
                <td>
					<input type="number" id="threshold_level_score_3" name="male_hormone_threshold_message[threshold_level_score_3]" value="<?php
                    if (isset($male_hormone_threshold_message['threshold_level_score_3'])) {
                        echo $male_hormone_threshold_message['threshold_level_score_3'];
                    }
                    ?>" />
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="threshold_level_1_message" class="selectit">Threshold Level 1 Message</label></th>
                <td>
                    <?php
                    $content = @$male_hormone_threshold_message['threshold_level_1_message'];
                    $editor_settings = array('textarea_name' => 'male_hormone_threshold_message[threshold_level_1_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_1_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="threshold_level_2_message" class="selectit">Threshold Level 2 Message</label></th>
                <td>
                    <?php
                    $content = @$male_hormone_threshold_message['threshold_level_2_message'];
                    $editor_settings = array('textarea_name' => 'male_hormone_threshold_message[threshold_level_2_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_2_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="threshold_level_3_message" class="selectit">Threshold Level 3 Message</label></th>
                <td>
                    <?php
                    $content = @$male_hormone_threshold_message['threshold_level_3_message'];
                    $editor_settings = array('textarea_name' => 'male_hormone_threshold_message[threshold_level_3_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_3_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
        </tbody>
    </table>
    <?php
}

/**
 * Male Hormmone Results
 * Prints the box content
 */
function rosewellness_female_hormone_metaboxes($post) {
    wp_nonce_field(plugin_basename(__FILE__), $post->post_type . '_noncename');
    $female_hormone_threshold_message = get_post_meta($post->ID, 'female_hormone_threshold_message', true);
    ?>
    <table class="form-table" >
        <tbody>
            
            <tr valign="top">
                <th scope="row"><label for="post_cta_bg_img_id" class="selectit">Background Image:</label></th>
                <td>
                    <input type="button" value="<?php _e('Upload', 'rosewellness'); ?>" data-id="post_cta_bg_img_id" class="button custom_image_uploader" id="wpts_post_cta_bg_img_id" />
                    <input type="hidden"  name="female_hormone_threshold_message[post_cta_bg_img]" id="post_cta_bg_img_id" value="<?php if (isset($female_hormone_threshold_message['post_cta_bg_img'])) echo $female_hormone_threshold_message['post_cta_bg_img']; ?>" />
                    <?php $image_uploader = wp_get_attachment_image_src(@$female_hormone_threshold_message['post_cta_bg_img'], 'full'); ?>
                    <img src="<?php echo @$image_uploader[0] ?>" alt="Custom Image"<?php echo ( isset($image_uploader[0]) ? 'style="max-width: 150px; width: 100%;"' : 'style="max-width: 150px; width: 100%; display: none;"' ); ?> />
                </td>
            </tr>
		
			<tr valign="top">
                <th scope="row"><label for="subheading_text" class="selectit">Subheading Text</label></th>
                <td>
                    <?php
                    $content = @$female_hormone_threshold_message['subheading_text'];
                    $editor_settings = array('textarea_name' => 'female_hormone_threshold_message[subheading_text]', 'media_buttons' => true, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'subheading_text';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="threshold_level_score_1" class="selectit">Threshold Level 1 Score</label></th>
                <td>
					<input type="number" id="threshold_level_score_1" name="female_hormone_threshold_message[threshold_level_score_1]" value="<?php
                    if (isset($female_hormone_threshold_message['threshold_level_score_1'])) {
                        echo $female_hormone_threshold_message['threshold_level_score_1'];
                    }
                    ?>" />
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="threshold_level_score_2" class="selectit">Threshold Level 2 Score</label></th>
                <td>
					<input type="number" id="threshold_level_score_2" name="female_hormone_threshold_message[threshold_level_score_2]" value="<?php
                    if (isset($female_hormone_threshold_message['threshold_level_score_2'])) {
                        echo $female_hormone_threshold_message['threshold_level_score_2'];
                    }
                    ?>" />
                </td>
            </tr>
        
			<tr valign="top">
                <th scope="row"><label for="threshold_level_score_3" class="selectit">Threshold Level 3 Score</label></th>
                <td>
					<input type="number" id="threshold_level_score_3" name="female_hormone_threshold_message[threshold_level_score_3]" value="<?php
                    if (isset($female_hormone_threshold_message['threshold_level_score_3'])) {
                        echo $female_hormone_threshold_message['threshold_level_score_3'];
                    }
                    ?>" />
                </td>
            </tr>
            
			<tr valign="top">
                <th scope="row"><label for="threshold_level_1_message" class="selectit">Threshold Level 1 Message</label></th>
                <td>
                    <?php
                    $content = @$female_hormone_threshold_message['threshold_level_1_message'];
                    $editor_settings = array('textarea_name' => 'female_hormone_threshold_message[threshold_level_1_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_1_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="threshold_level_2_message" class="selectit">Threshold Level 2 Message</label></th>
                <td>
                    <?php
                    $content = @$female_hormone_threshold_message['threshold_level_2_message'];
                    $editor_settings = array('textarea_name' => 'female_hormone_threshold_message[threshold_level_2_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_2_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="threshold_level_3_message" class="selectit">Threshold Level 3 Message</label></th>
                <td>
                    <?php
                    $content = @$female_hormone_threshold_message['threshold_level_3_message'];
                    $editor_settings = array('textarea_name' => 'female_hormone_threshold_message[threshold_level_3_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_3_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="threshold_level_4_message" class="selectit">Threshold Level 4 Message</label></th>
                <td>
                    <?php
                    $content = @$female_hormone_threshold_message['threshold_level_4_message'];
                    $editor_settings = array('textarea_name' => 'female_hormone_threshold_message[threshold_level_4_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_4_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="threshold_level_5_message" class="selectit">Threshold Level 5 Message</label></th>
                <td>
                    <?php
                    $content = @$female_hormone_threshold_message['threshold_level_5_message'];
                    $editor_settings = array('textarea_name' => 'female_hormone_threshold_message[threshold_level_5_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_5_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
        </tbody>
    </table>
    <?php
}

/**
 * Insomnia Results
 * Prints the box content
 */
function rosewellness_female_estrogen_metaboxes($post) {
    wp_nonce_field(plugin_basename(__FILE__), $post->post_type . '_noncename');
    $female_estrogen_threshold_message = get_post_meta($post->ID, 'female_estrogen_threshold_message', true);
    ?>
    <table class="form-table" >
        <tbody>
            
            <tr valign="top">
                <th scope="row"><label for="post_cta_bg_img_id" class="selectit">Background Image:</label></th>
                <td>
                    <input type="button" value="<?php _e('Upload', 'rosewellness'); ?>" data-id="post_cta_bg_img_id" class="button custom_image_uploader" id="wpts_post_cta_bg_img_id" />
                    <input type="hidden"  name="female_estrogen_threshold_message[post_cta_bg_img]" id="post_cta_bg_img_id" value="<?php if (isset($female_estrogen_threshold_message['post_cta_bg_img'])) echo $female_estrogen_threshold_message['post_cta_bg_img']; ?>" />
                    <?php $image_uploader = wp_get_attachment_image_src(@$female_estrogen_threshold_message['post_cta_bg_img'], 'full'); ?>
                    <img src="<?php echo @$image_uploader[0] ?>" alt="Custom Image"<?php echo ( isset($image_uploader[0]) ? 'style="max-width: 150px; width: 100%;"' : 'style="max-width: 150px; width: 100%; display: none;"' ); ?> />
                </td>
            </tr>
		    
			<tr valign="top">
                <th scope="row"><label for="subheading_text" class="selectit">Subheading Text</label></th>
                <td>
                    <?php
                    $content = @$female_estrogen_threshold_message['subheading_text'];
                    $editor_settings = array('textarea_name' => 'female_estrogen_threshold_message[subheading_text]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'subheading_text';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="threshold_level_score_1" class="selectit">Threshold Level 1 Score</label></th>
                <td>
					<input type="number" id="threshold_level_score_1" name="female_estrogen_threshold_message[threshold_level_score_1]" value="<?php
                    if (isset($female_estrogen_threshold_message['threshold_level_score_1'])) {
                        echo $female_estrogen_threshold_message['threshold_level_score_1'];
                    }
                    ?>" />
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="threshold_level_score_2" class="selectit">Threshold Level 2 Score</label></th>
                <td>
					<input type="number" id="threshold_level_score_2" name="female_estrogen_threshold_message[threshold_level_score_2]" value="<?php
                    if (isset($female_estrogen_threshold_message['threshold_level_score_2'])) {
                        echo $female_estrogen_threshold_message['threshold_level_score_2'];
                    }
                    ?>" />
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="threshold_level_score_3" class="selectit">Threshold Level 3 Score</label></th>
                <td>
					<input type="number" id="threshold_level_score_3" name="female_estrogen_threshold_message[threshold_level_score_3]" value="<?php
                    if (isset($female_estrogen_threshold_message['threshold_level_score_3'])) {
                        echo $female_estrogen_threshold_message['threshold_level_score_3'];
                    }
                    ?>" />
                </td>
            </tr>
            
			<tr valign="top">
                <th scope="row"><label for="threshold_level_1_message" class="selectit">Threshold Level 1 Message</label></th>
                <td>
                    <?php
                    $content = @$female_estrogen_threshold_message['threshold_level_1_message'];
                    $editor_settings = array('textarea_name' => 'female_estrogen_threshold_message[threshold_level_1_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_1_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="threshold_level_2_message" class="selectit">Threshold Level 2 Message</label></th>
                <td>
                    <?php
                    $content = @$female_estrogen_threshold_message['threshold_level_2_message'];
                    $editor_settings = array('textarea_name' => 'female_estrogen_threshold_message[threshold_level_2_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_2_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="threshold_level_3_message" class="selectit">Threshold Level 3 Message</label></th>
                <td>
                    <?php
                    $content = @$female_estrogen_threshold_message['threshold_level_3_message'];
                    $editor_settings = array('textarea_name' => 'female_estrogen_threshold_message[threshold_level_3_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_3_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
        </tbody>
    </table>
    <?php
}

/**
 * CTA Results
 * Prints the box content
 */
function rosewellness_assessments_metabox($post) {
    wp_nonce_field(plugin_basename(__FILE__), $post->post_type . '_noncename');
    $post_assessments_options = get_post_meta($post->ID, 'post_assessments_options', true);
    ?>
    
    <table class="form-table" >
        <tbody>
		
			<tr valign="top">
                <th scope="row"><label for="post_button_url" class="selectit">Button URL:</label></th>
                <td>
                    <input type="text" id="post_button_url" name="post_assessments_options[post_button_url]" value="<?php
                    if (isset($post_assessments_options['post_button_url'])) {
                        echo $post_assessments_options['post_button_url'];
                    }
                    ?>" size="80" />
                </td>
            </tr>
			
        </tbody>
    </table>
    <?php
}

/**
 * Featured Post
 * Prints the box content
 */
function rosewellness_featured_metabox($post) {
    wp_nonce_field(plugin_basename(__FILE__), $post->post_type . '_noncename');
    $show_sidebar = get_post_meta($post->ID, 'show_sidebar', true);
    $blog_slider_post = get_post_meta($post->ID, 'blog_slider_post', true);
    
    if($show_sidebar == 'yes') {
        $checkbox = 'checked';
    } else {
        $checkbox = '';
    }
    
    if($blog_slider_post == 'yes') {
        $slider_checkbox = 'checked';
    } else {
        $slider_checkbox = '';
    }
    
    ?>
    <table class="form-table" >
        <tbody>
            <tr valign="top">
                <td>
                    <input type="checkbox" id="show_sidebar" name="show_sidebar" value="yes" <?php echo $checkbox; ?> /> Show Sidebar
                </td>
            </tr>
            
            <tr valign="top">
                <td>
                    <input type="checkbox" id="blog_slider_post" name="blog_slider_post" value="yes" <?php echo $slider_checkbox; ?> /> Select Blog Slider Post
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

/**
 * CTA Results
 * Prints the box content
 */
function rosewellness_cta_details_metabox($post) {
    wp_nonce_field(plugin_basename(__FILE__), $post->post_type . '_noncename');
    $post_cta_options = get_post_meta($post->ID, 'post_cta_options', true);
    
    // CTA Right
    if($post_cta_options['cta_right'] == 'yes') {
        $right_cta = 'checked';
    } else {
        $right_cta = '';
    }
    
    ?>
    <table class="form-table" >
        <tbody>
		
			<tr valign="top">
                <th scope="row"><label for="post_cta_heading" class="selectit">CTA Heading:</label></th>
                <td>
                    <input type="text" id="post_cta_heading" name="post_cta_options[post_cta_heading]" value="<?php
                    if (isset($post_cta_options['post_cta_heading'])) {
                        echo $post_cta_options['post_cta_heading'];
                    }
                    ?>" size="80" />
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="post_cta_content" class="selectit">CTA Content</label></th>
                <td>
                    <?php
                    $content = @$post_cta_options['post_cta_content'];
                    $editor_settings = array('textarea_name' => 'post_cta_options[post_cta_content]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'post_cta_content';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="cta_btn_text" class="selectit">CTA Button Text:</label></th>
                <td>
                    <input type="text" id="cta_btn_text" name="post_cta_options[cta_btn_text]" value="<?php
                    if (isset($post_cta_options['cta_btn_text'])) {
                        echo $post_cta_options['cta_btn_text'];
                    }
                    ?>" size="80" />
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="post_cta_url" class="selectit">CTA Button URL:</label></th>
                <td>
                    <input type="text" id="post_cta_url" name="post_cta_options[post_cta_url]" value="<?php
                    if (isset($post_cta_options['post_cta_url'])) {
                        echo $post_cta_options['post_cta_url'];
                    }
                    ?>" size="80" />
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="cta_right" class="selectit">Move CTA Text Right:</label></th>
                <td>
                    <input type="checkbox" id="cta_right" name="post_cta_options[cta_right]" value="yes" <?php echo $right_cta; ?> />
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="post_cta_bg_img_id" class="selectit">Background Image:</label></th>
                <td>
                    <input type="button" value="<?php _e('Upload', 'rosewellness'); ?>" data-id="post_cta_bg_img_id" class="button custom_image_uploader" id="wpts_post_cta_bg_img_id" />
                    <input type="hidden"  name="post_cta_options[post_cta_bg_img]" id="post_cta_bg_img_id" value="<?php if (isset($post_cta_options['post_cta_bg_img'])) echo $post_cta_options['post_cta_bg_img']; ?>" />
                    <?php $image_uploader = wp_get_attachment_image_src(@$post_cta_options['post_cta_bg_img'], 'full'); ?>
                    <img src="<?php echo @$image_uploader[0] ?>" alt="Custom Image"<?php echo ( isset($image_uploader[0]) ? 'style="max-width: 150px; width: 100%;"' : 'style="max-width: 150px; width: 100%; display: none;"' ); ?> />
                </td>
            </tr>
			
        </tbody>
    </table>
    <?php
}


/**
 * Insomnia Results
 * Prints the box content
 */
function rosewellness_toxicity_insomnia_metaboxes($post) {
    wp_nonce_field(plugin_basename(__FILE__), $post->post_type . '_noncename');
    $insomnia_threshold_message = get_post_meta($post->ID, 'insomnia_threshold_message', true);
    ?>
    <table class="form-table" >
        <tbody>
		    
		    <tr valign="top">
                <th scope="row"><label for="post_cta_bg_img_id" class="selectit">Background Image:</label></th>
                <td>
                    <input type="button" value="<?php _e('Upload', 'rosewellness'); ?>" data-id="post_cta_bg_img_id" class="button custom_image_uploader" id="wpts_post_cta_bg_img_id" />
                    <input type="hidden"  name="insomnia_threshold_message[post_cta_bg_img]" id="post_cta_bg_img_id" value="<?php if (isset($insomnia_threshold_message['post_cta_bg_img'])) echo $insomnia_threshold_message['post_cta_bg_img']; ?>" />
                    <?php $image_uploader = wp_get_attachment_image_src(@$insomnia_threshold_message['post_cta_bg_img'], 'full'); ?>
                    <img src="<?php echo @$image_uploader[0] ?>" alt="Custom Image"<?php echo ( isset($image_uploader[0]) ? 'style="max-width: 150px; width: 100%;"' : 'style="max-width: 150px; width: 100%; display: none;"' ); ?> />
                </td>
            </tr>
            
			<tr valign="top">
                <th scope="row"><label for="subheading_text" class="selectit">Subheading Text</label></th>
                <td>
                    <?php
                    $content = @$insomnia_threshold_message['subheading_text'];
                    $editor_settings = array('textarea_name' => 'insomnia_threshold_message[subheading_text]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'subheading_text';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="threshold_level_1_message" class="selectit">Threshold Level 1 Message</label></th>
                <td>
                    <?php
                    $content = @$insomnia_threshold_message['threshold_level_1_message'];
                    $editor_settings = array('textarea_name' => 'insomnia_threshold_message[threshold_level_1_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_1_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="threshold_level_2_message" class="selectit">Threshold Level 2 Message</label></th>
                <td>
                    <?php
                    $content = @$insomnia_threshold_message['threshold_level_2_message'];
                    $editor_settings = array('textarea_name' => 'insomnia_threshold_message[threshold_level_2_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_2_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="threshold_level_3_message" class="selectit">Threshold Level 3 Message</label></th>
                <td>
                    <?php
                    $content = @$insomnia_threshold_message['threshold_level_3_message'];
                    $editor_settings = array('textarea_name' => 'insomnia_threshold_message[threshold_level_3_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_3_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="threshold_level_4_message" class="selectit">Threshold Level 4 Message</label></th>
                <td>
                    <?php
                    $content = @$insomnia_threshold_message['threshold_level_4_message'];
                    $editor_settings = array('textarea_name' => 'insomnia_threshold_message[threshold_level_4_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'threshold_level_4_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
        </tbody>
    </table>
    <?php
}

/**
 * Prints the box content
 */
function rosewellness_layout_metabox($post) {
    wp_nonce_field(plugin_basename(__FILE__), $post->post_type . '_noncename');
    $post_options = get_post_meta($post->ID, 'post_options', true);
    
    // Disable Cat
    if($post_options['disable_cat'] == 'yes') {
        $checkbox = 'checked';
    } else {
        $checkbox = '';
    }
    
    
    // Hide CTA
    if($post_options['disable_cta'] == 'yes') {
        $disable_cta = 'checked';
    } else {
        $disable_cta = '';
    }
    
    
    ?>
    <table class="form-table" >
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="disable_cat" class="selectit">Hide Category:</label></th>
                <td>
                    <input type="checkbox" id="disable_cat" name="post_options[disable_cat]" value="yes" <?php echo $checkbox; ?> />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="disable_cta" class="selectit">Hide CTA:</label></th>
                <td>
                    <input type="checkbox" id="disable_cta" name="post_options[disable_cta]" value="yes" <?php echo $disable_cta; ?> />
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

/**
 * Prints the box content
 */
function rosewellness_banner_details_metabox($post) {
    wp_nonce_field(plugin_basename(__FILE__), $post->post_type . '_noncename');
    $post_options = get_post_meta($post->ID, 'post_options', true);
    ?>
    <table class="form-table" >
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="post_banner_image_id" class="selectit">Banner Image:</label></th>
                <td>
                    <input type="button" value="<?php _e('Upload', 'rosewellness'); ?>" data-id="post_banner_image_id" class="button custom_image_uploader" id="wpts_post_banner_image_id" />
                    <input type="hidden"  name="post_options[post_banner_image_id]" id="post_banner_image_id" value="<?php if (isset($post_options['post_banner_image_id'])) echo $post_options['post_banner_image_id']; ?>" />
                    <?php $image_uploader = wp_get_attachment_image_src(@$post_options['post_banner_image_id'], 'full'); ?>
                    <img src="<?php echo @$image_uploader[0] ?>" alt="Custom Image"<?php echo ( isset($image_uploader[0]) ? 'style="max-width: 150px; width: 100%;"' : 'style="max-width: 150px; width: 100%; display: none;"' ); ?> />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="post_heading_title" class="selectit">Banner SubHeading:</label></th>
                <td>
                    <input type="text" id="post_heading_title" name="post_options[post_heading_title]" value="<?php
                    if (isset($post_options['post_heading_title'])) {
                        echo $post_options['post_heading_title'];
                    }
                    ?>" size="80" />
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

/**
 * Prints the box content
 */
function rosewellness_member_details_metabox($post) {
    wp_nonce_field(plugin_basename(__FILE__), $post->post_type . '_noncename');
    $team_options = get_post_meta($post->ID, 'team_options', true);
    ?>
    <table class="form-table" >
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="member_desig" class="selectit">Member Designation</label></th>
                <td>
                    <input class="full_width" type="text" id="member_desig" name="team_options[member_desig]" value="<?php
                    if (isset($team_options['member_desig'])) {
                        echo $team_options['member_desig'];
                    }
                    ?>" />
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}


/**
 * Banner Info Section
 * Prints the box content
 */
function rosewellness_toxicity_threshold_metaboxes($post) {
    wp_nonce_field(plugin_basename(__FILE__), $post->post_type . '_noncename');
    $toxicity_threshold_message = get_post_meta($post->ID, 'toxicity_threshold_message', true);
    ?>
    <table class="form-table" >
        <tbody>
            
            <tr valign="top">
                <th scope="row"><label for="post_cta_bg_img_id" class="selectit">Background Image:</label></th>
                <td>
                    <input type="button" value="<?php _e('Upload', 'rosewellness'); ?>" data-id="post_cta_bg_img_id" class="button custom_image_uploader" id="wpts_post_cta_bg_img_id" />
                    <input type="hidden"  name="toxicity_threshold_message[post_cta_bg_img]" id="post_cta_bg_img_id" value="<?php if (isset($toxicity_threshold_message['post_cta_bg_img'])) echo $toxicity_threshold_message['post_cta_bg_img']; ?>" />
                    <?php $image_uploader = wp_get_attachment_image_src(@$toxicity_threshold_message['post_cta_bg_img'], 'full'); ?>
                    <img src="<?php echo @$image_uploader[0] ?>" alt="Custom Image"<?php echo ( isset($image_uploader[0]) ? 'style="max-width: 150px; width: 100%;"' : 'style="max-width: 150px; width: 100%; display: none;"' ); ?> />
                </td>
            </tr>
            
			<tr valign="top">
                <th scope="row"><label for="head_threshold_level_score_1" class="selectit">Threshold Level 1 Score</label></th>
                <td>
					<input type="number" id="head_threshold_level_score_1" name="toxicity_threshold_message[head_threshold_level_score_1]" value="<?php
                    if (isset($toxicity_threshold_message['head_threshold_level_score_1'])) {
                        echo $toxicity_threshold_message['head_threshold_level_score_1'];
                    }
                    ?>" />
                </td>
            </tr>
			<tr valign="top">
                <th scope="row"><label for="head_threshold_level_score_2" class="selectit">Threshold Level 2 Score</label></th>
                <td>
					<input type="number" id="head_threshold_level_score_2" name="toxicity_threshold_message[head_threshold_level_score_2]" value="<?php
                    if (isset($toxicity_threshold_message['head_threshold_level_score_2'])) {
                        echo $toxicity_threshold_message['head_threshold_level_score_2'];
                    }
                    ?>" />
                </td>
            </tr>
			<tr valign="top">
                <th scope="row"><label for="head_threshold_level_score_3" class="selectit">Threshold Level 3 Score</label></th>
                <td>
					<input type="number" id="head_threshold_level_score_3" name="toxicity_threshold_message[head_threshold_level_score_3]" value="<?php
                    if (isset($toxicity_threshold_message['head_threshold_level_score_3'])) {
                        echo $toxicity_threshold_message['head_threshold_level_score_3'];
                    }
                    ?>" />
                </td>
            </tr>
			<tr valign="top">
                <th scope="row"><label for="head_threshold_level_score_4" class="selectit">Threshold Level 4 Score</label></th>
                <td>
					<input type="number" id="head_threshold_level_score_4" name="toxicity_threshold_message[head_threshold_level_score_4]" value="<?php
                    if (isset($toxicity_threshold_message['head_threshold_level_score_4'])) {
                        echo $toxicity_threshold_message['head_threshold_level_score_4'];
                    }
                    ?>" />
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="head_threshold_level_1_message" class="selectit">Threshold Level 1 Message</label></th>
                <td>
                    <?php
                    $content = @$toxicity_threshold_message['head_threshold_level_1_message'];
                    $editor_settings = array('textarea_name' => 'toxicity_threshold_message[head_threshold_level_1_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'head_threshold_level_1_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="head_threshold_level_2_message" class="selectit">Threshold Level 2 Message</label></th>
                <td>
                    <?php
                    $content = @$toxicity_threshold_message['head_threshold_level_2_message'];
                    $editor_settings = array('textarea_name' => 'toxicity_threshold_message[head_threshold_level_2_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'head_threshold_level_2_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="head_threshold_level_3_message" class="selectit">Threshold Level 3 Message</label></th>
                <td>
                    <?php
                    $content = @$toxicity_threshold_message['head_threshold_level_3_message'];
                    $editor_settings = array('textarea_name' => 'toxicity_threshold_message[head_threshold_level_3_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'head_threshold_level_3_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="head_threshold_level_4_message" class="selectit">Threshold Level 4 Message</label></th>
                <td>
                    <?php
                    $content = @$toxicity_threshold_message['head_threshold_level_4_message'];
                    $editor_settings = array('textarea_name' => 'toxicity_threshold_message[head_threshold_level_4_message]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'head_threshold_level_4_message';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

/**
 * Banner Info Section
 * Prints the box content
 */
function rosewellness_results_threshold_metaboxes($post) {
    wp_nonce_field(plugin_basename(__FILE__), $post->post_type . '_noncename');
    $threshold_message = get_post_meta($post->ID, 'threshold_message', true);
    ?>
    <table class="form-table" >
        <tbody>
            
            <tr valign="top">
                <th scope="row"><label for="post_cta_bg_img_id" class="selectit">Background Image:</label></th>
                <td>
                    <input type="button" value="<?php _e('Upload', 'rosewellness'); ?>" data-id="post_cta_bg_img_id" class="button custom_image_uploader" id="wpts_post_cta_bg_img_id" />
                    <input type="hidden"  name="threshold_message[post_cta_bg_img]" id="post_cta_bg_img_id" value="<?php if (isset($threshold_message['post_cta_bg_img'])) echo $threshold_message['post_cta_bg_img']; ?>" />
                    <?php $image_uploader = wp_get_attachment_image_src(@$threshold_message['post_cta_bg_img'], 'full'); ?>
                    <img src="<?php echo @$image_uploader[0] ?>" alt="Custom Image"<?php echo ( isset($image_uploader[0]) ? 'style="max-width: 150px; width: 100%;"' : 'style="max-width: 150px; width: 100%; display: none;"' ); ?> />
                </td>
            </tr>
            
			<tr valign="top">
                <th scope="row"><label for="immune_threshold_level_score_1" class="selectit"> Immune Health Threshold Level 1 Score</label></th>
                <td>
					<input type="number" id="immune_threshold_level_score_1" name="threshold_message[immune_threshold_level_score_1]" value="<?php
                    if (isset($threshold_message['immune_threshold_level_score_1'])) {
                        echo $threshold_message['immune_threshold_level_score_1'];
                    }
                    ?>" />
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="immune_threshold_level_score_2" class="selectit">Immune Health Threshold Level 2 Score</label></th>
                <td>
					<input type="number" id="immune_threshold_level_score_2" name="threshold_message[immune_threshold_level_score_2]" value="<?php
                    if (isset($threshold_message['immune_threshold_level_score_2'])) {
                        echo $threshold_message['immune_threshold_level_score_2'];
                    }
                    ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="immune_threshold_level_1" class="selectit">Immune Health Threshold Level 1</label></th>
                <td>
                    <?php
                    $content = @$threshold_message['immune_threshold_level_1'];
                    $editor_settings = array('textarea_name' => 'threshold_message[immune_threshold_level_1]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'immune_threshold_level_1';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="immune_threshold_level_2" class="selectit">Immune Health Threshold Level 2</label></th>
                <td>
                    <?php
                    $content = @$threshold_message['immune_threshold_level_2'];
                    $editor_settings = array('textarea_name' => 'threshold_message[immune_threshold_level_2]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'immune_threshold_level_2';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="immune_threshold_level_0" class="selectit">Immune Health Default Message</label></th>
                <td>
                    <?php
                    $content = @$threshold_message['immune_threshold_level_0'];
                    $editor_settings = array('textarea_name' => 'threshold_message[immune_threshold_level_0]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'immune_threshold_level_0';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="gut_threshold_level_score_1" class="selectit">Gut Health Threshold Level 1 Score</label></th>
                <td>
					<input type="number" id="gut_threshold_level_score_1" name="threshold_message[gut_threshold_level_score_1]" value="<?php
                    if (isset($threshold_message['gut_threshold_level_score_1'])) {
                        echo $threshold_message['gut_threshold_level_score_1'];
                    }
                    ?>" />
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="gut_threshold_level_score_2" class="selectit">Gut Health Threshold Level 2 Score</label></th>
                <td>
					<input type="number" id="gut_threshold_level_score_2" name="threshold_message[gut_threshold_level_score_2]" value="<?php
                    if (isset($threshold_message['gut_threshold_level_score_2'])) {
                        echo $threshold_message['gut_threshold_level_score_2'];
                    }
                    ?>" />
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="gut_threshold_level_1" class="selectit">Gut Health Threshold Level 1</label></th>
                <td>
                    <?php
                    $content = @$threshold_message['gut_threshold_level_1'];
                    $editor_settings = array('textarea_name' => 'threshold_message[gut_threshold_level_1]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'gut_threshold_level_1';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="gut_threshold_level_2" class="selectit">Gut Health Threshold Level 2</label></th>
                <td>
                    <?php
                    $content = @$threshold_message['gut_threshold_level_2'];
                    $editor_settings = array('textarea_name' => 'threshold_message[gut_threshold_level_2]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'gut_threshold_level_2';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="gut_threshold_level_0" class="selectit">Gut Health Default Message</label></th>
                <td>
                    <?php
                    $content = @$threshold_message['gut_threshold_level_0'];
                    $editor_settings = array('textarea_name' => 'threshold_message[gut_threshold_level_0]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'gut_threshold_level_0';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="thyroid_threshold_level_score_1" class="selectit">Thyroid Health Threshold Level 1 Score</label></th>
                <td>
					<input type="number" id="thyroid_threshold_level_score_1" name="threshold_message[thyroid_threshold_level_score_1]" value="<?php
                    if (isset($threshold_message['thyroid_threshold_level_score_1'])) {
                        echo $threshold_message['thyroid_threshold_level_score_1'];
                    }
                    ?>" />
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="thyroid_threshold_level_score_2" class="selectit">Thyroid Health Threshold Level 2 Score</label></th>
                <td>
					<input type="number" id="thyroid_threshold_level_score_2" name="threshold_message[thyroid_threshold_level_score_2]" value="<?php
                    if (isset($threshold_message['thyroid_threshold_level_score_2'])) {
                        echo $threshold_message['thyroid_threshold_level_score_2'];
                    }
                    ?>" />
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="thyroid_threshold_level_1" class="selectit">Thyroid Health Threshold Level 1</label></th>
                <td>
                    <?php
                    $content = @$threshold_message['thyroid_threshold_level_1'];
                    $editor_settings = array('textarea_name' => 'threshold_message[thyroid_threshold_level_1]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'thyroid_threshold_level_1';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="thyroid_threshold_level_2" class="selectit">Thyroid Health Threshold Level 2</label></th>
                <td>
                    <?php
                    $content = @$threshold_message['thyroid_threshold_level_2'];
                    $editor_settings = array('textarea_name' => 'threshold_message[thyroid_threshold_level_2]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'thyroid_threshold_level_2';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="thyroid_threshold_level_0" class="selectit">Thyroid Health Default Message</label></th>
                <td>
                    <?php
                    $content = @$threshold_message['thyroid_threshold_level_0'];
                    $editor_settings = array('textarea_name' => 'threshold_message[thyroid_threshold_level_0]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'thyroid_threshold_level_0';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="adrenal_threshold_level_score_1" class="selectit">Adrenal Health Threshold Level 1 Score</label></th>
                <td>
					<input type="number" id="adrenal_threshold_level_score_1" name="threshold_message[adrenal_threshold_level_score_1]" value="<?php
                    if (isset($threshold_message['adrenal_threshold_level_score_1'])) {
                        echo $threshold_message['adrenal_threshold_level_score_1'];
                    }
                    ?>" />
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="adrenal_threshold_level_score_2" class="selectit">Adrenal Health Threshold Level 2 Score</label></th>
                <td>
					<input type="number" id="adrenal_threshold_level_score_2" name="threshold_message[adrenal_threshold_level_score_2]" value="<?php
                    if (isset($threshold_message['adrenal_threshold_level_score_2'])) {
                        echo $threshold_message['adrenal_threshold_level_score_2'];
                    }
                    ?>" />
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row"><label for="adrenal_threshold_level_1" class="selectit">Adrenal Health Threshold Level 1</label></th>
                <td>
                    <?php
                    $content = @$threshold_message['adrenal_threshold_level_1'];
                    $editor_settings = array('textarea_name' => 'threshold_message[adrenal_threshold_level_1]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'adrenal_threshold_level_1';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="adrenal_threshold_level_2" class="selectit">Adrenal Health Threshold Level 2</label></th>
                <td>
                    <?php
                    $content = @$threshold_message['adrenal_threshold_level_2'];
                    $editor_settings = array('textarea_name' => 'threshold_message[adrenal_threshold_level_2]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'adrenal_threshold_level_2';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><label for="adrenal_threshold_level_0" class="selectit">Adrenal Health Default Message</label></th>
                <td>
                    <?php
                    $content = @$threshold_message['adrenal_threshold_level_0'];
                    $editor_settings = array('textarea_name' => 'threshold_message[adrenal_threshold_level_0]', 'media_buttons' => false, 'tinymce' => true, 'textarea_rows' => 3);
                    $editor_id = 'adrenal_threshold_level_0';
                    wp_editor($content, $editor_id, $editor_settings);
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

/**
 * When the post is saved, saves our custom data 
 */
function rosewellness_saving_posttype_metaboxes($post_id) {
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if (!wp_verify_nonce(@$_POST[$_POST['post_type'] . '_noncename'], plugin_basename(__FILE__)))
        return;
    // OK,nonce has been verified and now we can save the data according the the capabilities of the user
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        } else {
            update_post_meta($post_id, 'post_options', $_POST['post_options']);
            update_post_meta($post_id, 'team_options', $_POST['team_options']);
            update_post_meta($post_id, 'threshold_message', $_POST['threshold_message']);
            update_post_meta($post_id, 'toxicity_threshold_message', $_POST['toxicity_threshold_message']);
            update_post_meta($post_id, 'insomnia_threshold_message', $_POST['insomnia_threshold_message']);
            update_post_meta($post_id, 'post_cta_options', $_POST['post_cta_options']);
            update_post_meta($post_id, 'show_sidebar', $_POST['show_sidebar']);
            update_post_meta($post_id, 'blog_slider_post', $_POST['blog_slider_post']);
            update_post_meta($post_id, 'post_assessments_options', $_POST['post_assessments_options']);
            update_post_meta($post_id, 'female_hormone_threshold_message', $_POST['female_hormone_threshold_message']);
            update_post_meta($post_id, 'male_hormone_threshold_message', $_POST['male_hormone_threshold_message']);
            update_post_meta($post_id, 'female_estrogen_threshold_message', $_POST['female_estrogen_threshold_message']);
            
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        } else {
            update_post_meta($post_id, 'post_options', $_POST['post_options']);
            update_post_meta($post_id, 'team_options', $_POST['team_options']);
            update_post_meta($post_id, 'threshold_message', $_POST['threshold_message']);
            update_post_meta($post_id, 'toxicity_threshold_message', $_POST['toxicity_threshold_message']);
			update_post_meta($post_id, 'insomnia_threshold_message', $_POST['insomnia_threshold_message']);
            update_post_meta($post_id, 'post_cta_options', $_POST['post_cta_options']);
            update_post_meta($post_id, 'show_sidebar', $_POST['show_sidebar']);
            update_post_meta($post_id, 'blog_slider_post', $_POST['blog_slider_post']);
            update_post_meta($post_id, 'post_assessments_options', $_POST['post_assessments_options']);
            update_post_meta($post_id, 'female_hormone_threshold_message', $_POST['female_hormone_threshold_message']);
            update_post_meta($post_id, 'male_hormone_threshold_message', $_POST['male_hormone_threshold_message']);
            update_post_meta($post_id, 'female_estrogen_threshold_message', $_POST['female_estrogen_threshold_message']);
        }
    }
}