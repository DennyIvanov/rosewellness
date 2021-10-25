<?php

/*** Blog Search Dropdown ***/

//vc_map(array(
//    "name" => __("Search Dropdown"),
//    "base" => "search_dropdown_shortcode",
//    "category" => __('Content'),
//    "params" => array(
//    )
//));

add_shortcode('search_dropdown_shortcode', 'search_dropdown_blog');

function search_dropdown_blog($atts) {
    ob_start();
    ?>
    <div class="blog-search-container">
        <div class="row filter_list">
            <div class="col-md-12 col-sm-12 col-xs-12 category_dropdown_list">
                <label>Categories</label>
                <select name="categories_list" class="categories_list">
                    <option value="">Select Category</option>
                    <?php
                        if( $categories = get_categories() ) {
    						foreach( $categories as $category ) {
    						    
    						    $allowed_cats = array(20, 57, 10, 15, 58);
    						    
    						    if(in_array($category->term_id, $allowed_cats)) {
    						    
                                    // Child Parent Category
                                    $child_terms_array = load_praent_child_terms($category->term_id);
                                     
        							echo '<option value="'.$category->slug.'" '.$selected.' style="font-weight: bold;">'.$category->name.'</option>';
        							
        							if(!empty($child_terms_array)) {
        							    foreach($child_terms_array as $child_term) {
        							        echo '<option value="'.$child_term->slug.'" '.$selected.'>---'.$child_term->name.'</option>';
        							    }
        							}
    							
    						    }
    						}
    					}
                    ?>
                </select>
            </div>
        </div>
    </div>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

/* Custom Team Slider */

//vc_map(array(
//    "name" => __("Team Carousel"),
//    "base" => "team_carousel_shortcode",
//    "category" => __('Content'),
//    "params" => array(
//    )
//));


add_shortcode('team_carousel_shortcode', 'team_carousel_html_block');

function team_carousel_html_block($atts) {
    ob_start();
    ?>
    
    <div id="team-slider">
        <?php
			global $wpdb, $post;

			$post_args = array (
				'posts_per_page' => -1,
				'post_type'   => 'team',
				'post_status'   => 'publish',
				'orderby' => 'date',
				'order'	=> 'DESC',
				'tax_query' => array(
				    array(
                    'taxonomy' => 'team_roles',
                    'field'    => 'slug',
                    'terms'    => array( 'our-supportive-staff' ),
                    'operator' => 'NOT IN',
                    )
                ),
			);
			
			$post_query = new WP_Query($post_args);
			if ($post_query->have_posts()) {
				
				while ($post_query->have_posts()) {
					$post_query->the_post();
					$postID =  get_the_id();
					
					$the_content = strip_shortcodes(get_the_content($postID));
					$team_options = get_post_meta($postID, 'team_options', true);
					$members_desg = $team_options['member_desig'];
					
					if(!empty($members_desg)) {
					?>
					    <div class="team-box">
					        <div class="team-box-inner">
                                <div class="team-img">
                                    <a href="<?php echo get_the_permalink($postID); ?>">
                                        <?php
    										if (has_post_thumbnail()) {
    											echo get_the_post_thumbnail($postID, 'full');
    										}
    									?>
                                    </a>
                                </div>
                                <div class="team-content">
                                    <a href="<?php echo get_the_permalink($postID); ?>">
                                        <h4><?php echo get_the_title($postID); ?></h4>
                                        <p class="member_desg"><?php echo $members_desg; ?></p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php
					}
				}
			}
			
			wp_reset_postdata();
			wp_reset_query();
			
		?>
    </div>

    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

/* Custom Testimonials Slider */

//vc_map(array(
//    "name" => __("Testimonials Carousel"),
//    "base" => "testimonials_carousel_shortcode",
//    "category" => __('Content'),
//    "params" => array(
//    )
//));


add_shortcode('testimonials_carousel_shortcode', 'testimonials_carousel_html_block');

function testimonials_carousel_html_block($atts) {
    ob_start();
    ?>
    
    <div id="testimonials-slider">
        <?php
			global $wpdb, $post;

			$post_args = array (
				'posts_per_page' => -1,
				'post_type'   => 'testimonial',
				'post_status'   => 'publish',
				'orderby' => 'date',
				'order'	=> 'DESC'
			);
			
			$post_query = new WP_Query($post_args);
			if ($post_query->have_posts()) {
				
				while ($post_query->have_posts()) {
					$post_query->the_post();
					$postID =  get_the_id();
					
					// Content Box
					$the_content = get_the_content($postID);
					?>
					    <div class="testimonial-box">
					        <div class="team-box-inner">
                                <div class="team-content">
                                    <?php echo $the_content; ?>
                                </div>
                                <h4><?php echo get_the_title($postID); ?></h4>
                            </div>
                        </div>
                    <?php
				}
			}
			
			wp_reset_postdata();
			wp_reset_query();
		?>
    </div>

    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

// Team Regions
$team_roles = load_terms('team_roles');

$categories_array = array('Select' => '0');
foreach( $team_roles as $member ) {
    $categories_array[$member->name] = $member->term_id;
}

/* Custom Team Role Listing */
//vc_map(array(
//    "name" => __("Team By Role"),
//    "base" => "team_role_shortcode",
//    "category" => __('Content'),
//    "params" => array(
//		array(
//			'param_name'    => 'category_parent_id',
//			'type'          => 'dropdown',
//			'value'         => $categories_array,
//			'heading'       => __('Select Team'),
//		),
//		array(
//		    "type" => "checkbox",
//            "heading" => __( "Show Filter", "rosewellness" ),
//            "param_name" => "show_filter",
//            "value" => __( array('Yes'=>'Yes'), "rosewellness" ),
//		)
//    )
//));

add_shortcode('team_role_shortcode', 'team_role_process');

function team_role_process($atts) {
    ob_start();

	// Property Region Parameters
    $category_parent_id = @$atts['category_parent_id'];
    $show_filter = @$atts['show_filter'];
    
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $team_args = array (
		'posts_per_page' => -1,
		'post_type'   => 'team',
		'post_status'   => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => 'team_roles',
				'field' => 'term_id',
				'terms' => $category_parent_id,
				'operator' => 'IN' 
			)
		)
	);
	
    if($show_filter == 'Yes') {
    
        // Load Team Locations
        $team_location = load_terms('team_location');
        
        ?>
        <div class="team_filter" id="team_filter">
            <div class="row filter_list">
                <div class="col-md-6 col-sm-6 col-xs-12 category_dropdown_list">
                    <label>Filter doctors by locations</label>
                    <select name="team_filter_list" class="team_filter_list">
                        <option value="all">All Locations</option>
                        <?php
                            if(!empty($team_location)) {
    							foreach( $team_location as $location ) {
    								echo '<option value="'.$location->slug.'">'.$location->name.'</option>';
    							}
    						}
                        ?>
                    </select>
                </div>
	        </div>
        </div>
        
    <?php }
	
	$team_query = new WP_Query($team_args);
	
	if ($team_query->have_posts()) {
	    echo '<div class="team-container">';
		while ($team_query->have_posts()) {
			$team_query->the_post();
			$postID =  get_the_id();
			
			$the_content = get_the_content($postID);
			$content_org = wp_trim_words($the_content, 20, '...');
			
			$team_options = get_post_meta($postID, 'team_options', true);
			$members_desg = $team_options['member_desig'];

        	// Get team location			
			if($show_filter == 'Yes') {
    			$team_locaation = wp_get_object_terms( $postID,  'team_location');
			} else {
			    $team_locaation = '';
			}
			
			$team_loc_string = array();
			if(!empty($team_locaation)) {
				foreach($team_locaation as $team_loc){
					$team_loc_string[] = $team_loc->slug;
				}
			}

			// explode strings
			$team_loc_string_text = implode(' ', $team_loc_string);
			?>
			<div class="team-item <?php echo $team_loc_string_text; ?>">
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
		echo '</div>';
	}
	
	wp_reset_postdata();
	wp_reset_query();
	
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

//add_shortcode('team_role_shortcode', 'team_role_process1');

function team_role_process1($atts) {
    ob_start();

	// Property Region Parameters
    $category_parent_id = @$atts['category_parent_id'];
    
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $team_args = array (
		'posts_per_page' => -1,
		'post_type'   => 'team',
		'post_status'   => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => 'team_roles',
				'field' => 'term_id',
				'terms' => $category_parent_id,
				'operator' => 'IN' 
			)
		)
	);
	
	$team_query = new WP_Query($team_args);
	
	if ($team_query->have_posts()) {
	    echo '<div class="team-container">';
		while ($team_query->have_posts()) {
			$team_query->the_post();
			$postID =  get_the_id();
			
			$the_content = get_the_content($postID);
			$content_org = wp_trim_words($the_content, 20, '...');
			
			$team_options = get_post_meta($postID, 'team_options', true);
			$members_desg = $team_options['member_desig'];
			?>
			<div class="team-item">
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
		echo '</div>';
	}
	
	wp_reset_postdata();
	wp_reset_query();
	
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}


/* Custom Blog Module */

$cateogries_list = load_all_terms('category');

$categories_list_array = array('Select' => '0');
foreach( $cateogries_list as $category ) {
    $categories_list_array[$category->name] = $category->term_id;
}

//vc_map(array(
//    "name" => __("Blog Module"),
//    "base" => "blog_list_shortcode",
//    "category" => __('Content'),
//    "params" => array(
//		array(
//			'param_name'    => 'category_parent_id',
//			'type'          => 'dropdown',
//			'value'         => $categories_list_array,
//			'heading'       => __('Select Category'),
//		),
//    )
//));

add_shortcode('blog_list_shortcode', 'blog_list_callback');

function blog_list_callback($atts) {
    ob_start();

	// Blog Category
    $category_parent_id = @$atts['category_parent_id'];
    
    if(!empty($category_parent_id)) {
        $category_id = $category_parent_id;
    } else {
        $category_id = 33;
    }
    
    $blog_args = array (
		'posts_per_page' => 8,
		'post_type'   => 'post',
		'post_status'   => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field' => 'term_id',
				'terms' => $category_id,
				'operator' => 'IN' 
			)
		)
	);
	
	$blog_query = new WP_Query($blog_args);
	
	if ($blog_query->have_posts()) { ?>
	
	    <div class="blog-container">
	        
	        <div class="row filter_list">
	            <div class="col-md-6 col-sm-6 col-xs-12 category_dropdown_list">
	                <label>Explore</label>
	                <select name="categories_list" class="categories_list">
	                    <option value="">Select Category</option>
	                    <?php
	                        if( $categories = get_categories() ) {
								foreach( $categories as $category ) {
								    
								    if($category_id == $category->term_id) {
								        $selcet = 'selected';
								    } else {
								        $selcet = '';
								    }
								    
									echo '<option value="'.$category->slug.'" '.$selcet.'>'.$category->name.'</option>';
								}
							}
	                    ?>
	                </select>
	            </div>
	            
	            <div class="col-md-6 col-sm-6 col-xs-12 form_search">
	                <form method="get" id="searchform" action="<?php echo site_url(); ?>">
						<input type="text" class="field" name="s" id="s" placeholder="Enter your search">			
						<input type="submit" class="submit" value="search">
					</form>
	            </div>
	            
	        </div>
	    
	    <div class="row posts_list">
    	    <?php
    		while ($blog_query->have_posts()) {
    		    $blog_query->the_post();
    			$postID =  get_the_id();
    			
    			$the_content = strip_shortcodes(get_the_content($postID));
    			$excerpt = get_the_excerpt($postID);
    			
    			if(empty($excerpt)) {
    			    $content_org = wp_trim_words($the_content, 20, '...');
    			} else {
    			    $content_org = wp_trim_words($excerpt, 20, '...');
    			}
    			
    			// Get Current Category Slug
                $current_category = get_the_category($postID);
                $category_slug = $current_category[0]->slug;
                $category_name = $current_category[0]->name;
                
                // Get Primary Category
                $primary_cat_id = get_post_meta($postID ,'_yoast_wpseo_primary_category', true);
                $primary_term_array = get_term_by('term_id', $primary_cat_id, 'category');
                $primary_term_name = $primary_term_array->name;
                
                if(!empty($primary_term_name)) {
                    $blog_cat_name = $primary_term_name;
                    $blog_cat_slug = $primary_term_array->slug;
                } else {
                    $blog_cat_name = $category_name;
                    $blog_cat_slug = $category_slug;
                }
    			
    			?>
    			<div class="post-item col-md-3">
    			    <div class="post_thubmnail">
    				    <a href="<?php echo get_the_permalink($postID); ?>">
    				        <?php
        						if (has_post_thumbnail()) {
        							echo get_the_post_thumbnail($postID, 'full');
        						}
        					?>
        				</a>
    				</div>
    				<p class="category_link"><a href="<?php echo site_url().'/category/'.$blog_cat_slug; ?>"><?php echo $blog_cat_name; ?></a></p>
    				<a href="<?php echo get_the_permalink($postID); ?>"><h4 class="nopadding"><?php echo get_the_title($postID); ?></h4></a>
    				<p class="blog_desc custom_desc"><?php echo $content_org; ?></p>
    			</div>
    			<?php
    		}
    		
    		echo '</div></div>';
	}
	
	wp_reset_postdata();
	wp_reset_query();
	
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}


/* Custom Blog List Module */

//vc_map(array(
//    "name" => __("Blog Grid Module"),
//    "base" => "blog_grid_shortcode",
//    "category" => __('Content'),
//    "params" => array(
//    )
//));

add_shortcode('blog_grid_shortcode', 'blog_grid_callback');

function blog_grid_callback($atts) {
    ob_start();

    $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
    $blog_args = array (
		'posts_per_page' =>  12,
		'paged'	         =>  $paged,
		'post_type'      =>  'post',
		'post_status'    =>  'publish',
	);
	
	$blog_query = new WP_Query($blog_args);
	
	if ($blog_query->have_posts()) { ?>
	
	    <div class="blog-container grid_module">
	        
	        <div class="row filter_list">
	            <div class="col-md-6 col-sm-6 col-xs-12 category_dropdown_list">
	                <label>Explore</label>
	                <select name="categories_list" class="categories_list">
	                    <option value="">Select Category</option>
	                    <?php
	                        if( $categories = get_categories() ) {
								foreach( $categories as $category ) {
									echo '<option value="'.$category->slug.'">'.$category->name.'</option>';
								}
							}
	                    ?>
	                </select>
	            </div>
	            
	            <div class="col-md-6 col-sm-6 col-xs-12 form_search">
	                <form method="get" id="searchform" action="<?php echo site_url(); ?>">
						<input type="text" class="field" name="s" id="s" placeholder="Enter your search">			
						<input type="submit" class="submit" value="search">
					</form>
	            </div>
	            
	        </div>
	    
	    <div class="row posts_list">
    	    <?php
    		while ($blog_query->have_posts()) {
    			$blog_query->the_post();
    			$postID =  get_the_id();
    			
    			$the_content = strip_shortcodes(get_the_content($postID));
    			$excerpt = get_the_excerpt($postID);
    			
    			if(empty($excerpt)) {
    			    $content_org = wp_trim_words($the_content, 20, '...');
    			} else {
    			    $content_org = wp_trim_words($excerpt, 20, '...');
    			}
    			
    			// Get Current Category Slug
                $current_category = get_the_category($postID);
                $category_slug = $current_category[0]->slug;
                $category_name = $current_category[0]->name;
                
                // Get Primary Category
                $primary_cat_id = get_post_meta($postID ,'_yoast_wpseo_primary_category', true);
                $primary_term_array = get_term_by('term_id', $primary_cat_id, 'category');
                $primary_term_name = $primary_term_array->name;
                
                if(!empty($primary_term_name)) {
                    $blog_cat_name = $primary_term_name;
                    $blog_cat_slug = $primary_term_array->slug;
                } else {
                    $blog_cat_name = $category_name;
                    $blog_cat_slug = $category_slug;
                }
    			
    			?>
    			<div class="post-item col-md-3">
    			    <div class="post_thubmnail">
    				    <a href="<?php echo get_the_permalink($postID); ?>">
    				        <?php
        						if (has_post_thumbnail()) {
        							echo get_the_post_thumbnail($postID, 'full');
        						}
        					?>
        				</a>
    				</div>
    				<p class="category_link"><a href="<?php echo site_url().'/category/'.$blog_cat_slug; ?>"><?php echo $blog_cat_name; ?></a></p>
    				<a href="<?php echo get_the_permalink($postID); ?>"><h4 class="nopadding"><?php echo get_the_title($postID); ?></h4></a>
    				<p class="blog_desc custom_desc"><?php echo $content_org; ?></p>
    			</div>
    			<?php
    		}
    		
    		echo '</div></div>';
	}
	
	wp_reset_postdata();
	wp_reset_query();
	
	echo '<div class="blog-pagination grid_module">';
    	$big = 999999999; 
    	echo paginate_links( array(
    		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    		'format' => '?page=%#%',
    		'current' => max( 1, get_query_var('page') ),
    		'total' => $blog_query->max_num_pages
    	) );
    echo '</div>';

    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}


/* Custom Methodology */

//vc_map(array(
//    "name" => __("Methodology"),
//    "base" => "custom_methodology_shortcode",
//    "category" => __('Content'),
//    "params" => array(
//        array(
//            "type" => "attach_image",
//            "class" => "rt-custom-elements",
//            "heading" => __("Methodology Image"),
//            "param_name" => "rt_methodology_image",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Center Heading"),
//            "param_name" => "rt_center_heading",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Center Heading Link"),
//            "param_name" => "rt_center_heading_link",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Left Heading 1"),
//            "param_name" => "rt_left_heading1",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Left Heading Link 1"),
//            "param_name" => "rt_left_heading_link1",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Left Heading 2"),
//            "param_name" => "rt_left_heading2",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Left Heading Link 2"),
//            "param_name" => "rt_left_heading_link2",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Left Heading 3"),
//            "param_name" => "rt_left_heading3",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Left Heading Link 3"),
//            "param_name" => "rt_left_heading_link3",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Left Heading 4"),
//            "param_name" => "rt_left_heading4",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Left Heading Link 4"),
//            "param_name" => "rt_left_heading_link4",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Right Heading 1"),
//            "param_name" => "rt_right_heading1",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Right Heading Link 1"),
//            "param_name" => "rt_right_heading_link1",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Right Heading 2"),
//            "param_name" => "rt_right_heading2",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Right Heading Link 2"),
//            "param_name" => "rt_right_heading_link2",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Right Heading 3"),
//            "param_name" => "rt_right_heading3",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Right Heading Link 3"),
//            "param_name" => "rt_right_heading_link3",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Right Heading 4"),
//            "param_name" => "rt_right_heading4",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Right Heading Link 4"),
//            "param_name" => "rt_right_heading_link4",
//        ),
//    )
//));


add_shortcode('custom_methodology_shortcode', 'custom_methodology_html_block');

function custom_methodology_html_block($atts) {
    ob_start();

    $rt_methodology_image = @$atts['rt_methodology_image'];
    $rt_center_heading = @$atts['rt_center_heading'];
    $rt_center_heading_link = @$atts['rt_center_heading_link'];
    $rt_left_heading1 = @$atts['rt_left_heading1'];
    $rt_left_heading_link1 = @$atts['rt_left_heading_link1'];
    $rt_left_heading2 = @$atts['rt_left_heading2'];
    $rt_left_heading_link2 = @$atts['rt_left_heading_link2'];
    $rt_left_heading3 = @$atts['rt_left_heading3'];
    $rt_left_heading_link3 = @$atts['rt_left_heading_link3'];
    $rt_left_heading4 = @$atts['rt_left_heading4'];
    $rt_left_heading_link4 = @$atts['rt_left_heading_link4'];
    $rt_right_heading1 = @$atts['rt_right_heading1'];
    $rt_right_heading_link1 = @$atts['rt_left_heading_link1'];
    $rt_right_heading2 = @$atts['rt_right_heading2'];
    $rt_right_heading_link2 = @$atts['rt_left_heading_link2'];
    $rt_right_heading3 = @$atts['rt_right_heading3'];
    $rt_right_heading_link3 = @$atts['rt_left_heading_link3'];
    $rt_right_heading4 = @$atts['rt_right_heading4'];
    $rt_right_heading_link4 = @$atts['rt_left_heading_link4'];

    $rt_methodology_image = wp_get_attachment_image_src($rt_methodology_image, 'full');
    $background_url = $rt_methodology_image[0];
    ?>

    <div class="methodology-wrapper">
        <div class="methodology_main" style="background: url(<?php echo $background_url; ?>)">
            <div class="center">
                <ul>
                    <li>
                        <a href="<?php echo $rt_center_heading_link; ?>"><?php echo $rt_center_heading; ?></a>
                    </li>
                </ul>
            </div>
            <div class="left">
                <ul>
                    <li>
                        <a href="<?php echo $rt_left_heading_link1; ?>"><?php echo $rt_left_heading1; ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $rt_left_heading_link2; ?>"><?php echo $rt_left_heading2; ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $rt_left_heading_link3; ?>"><?php echo $rt_left_heading3; ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $rt_left_heading_link4; ?>"><?php echo $rt_left_heading4; ?></a>
                    </li>
                </ul>
            </div>
            <div class="right">
                <ul>
                    <li>
                        <a href="<?php echo $rt_right_heading_link1; ?>"><?php echo $rt_right_heading1; ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $rt_right_heading_link2; ?>"><?php echo $rt_right_heading2; ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $rt_right_heading_link3; ?>"><?php echo $rt_right_heading3; ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $rt_right_heading_link4; ?>"><?php echo $rt_right_heading4; ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

/* Submit Review */

//vc_map(array(
//    "name" => __("Submit Review"),
//    "base" => "custom_submit_review_shortcode",
//    "category" => __('Content'),
//    "params" => array(
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Heading"),
//            "param_name" => "rt_heading",
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "rt-custom-elements",
//            "heading" => __("Sub Heading"),
//            "param_name" => "rt_sub_heading",
//        )
//    )
//));


add_shortcode('custom_submit_review_shortcode', 'custom_submit_review_html_block');

function custom_submit_review_html_block($atts) {
    ob_start();

    $rt_heading = @$atts['rt_heading'];
    $rt_sub_heading = @$atts['rt_sub_heading'];
    ?>

    <div class="submit-review-wrapper">
        <h3><?php echo $rt_heading; ?></h3>
        <p><?php echo $rt_sub_heading; ?></p>
        <form action="https://login.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8" method="POST">
            <input name="oid" type="hidden" value="00D41000000dodo" />
            <input name="retURL" type="hidden" value="<?php echo home_url('thank-you-for-your-review'); ?>" />
            <p>
                <label for="00N4100000aJL1u">Patient Name:</label>
                <input id="00N4100000aJL1u" maxlength="50" name="00N4100000aJL1u" size="40" type="text" />
            </p>
            <p>
                <label for="00N4100000aJL1p">Email:</label>
                <input id="00N4100000aJL1p" maxlength="80" name="00N4100000aJL1p" size="20" type="text" />
            </p>
            <p class="rating-label">
                <label for="00N4100000aJL2E">Rating:</label>
            </p>
            <div class="rating-wrapper">
                <fieldset class="rating">
                    <input id="star1" name="rating" type="radio" value="1" /><label title="1 star" for="star1">1 star</label>
                    <input id="star2" name="rating" type="radio" value="2" /><label title="2 star" for="star2">2 stars</label>                
                    <input id="star3" name="rating" type="radio" value="3" /><label title="3 star" for="star3">3 stars</label>
                    <input id="star4" name="rating" type="radio" value="4" /><label title="4 star" for="star4">4 stars</label>
                    <input id="star5" name="rating" type="radio" value="5" /><label title="5 star!" for="star5">5 stars</label>
                </fieldset>
            </div>
            <input id="ratingText" name="00N4100000aJL2E" size="20" type="hidden" />
            <p>
                <label for="00N4100000aJL29">Practitioner:</label>
                <select id="00N4100000aJL29" title="Practitioner" name="00N4100000aJL29">
                    <option value="">--None--</option>
                    <!--<option value="Alex Leon, MD">Alex Leon, MD</option>
                    <option value="Sushma Hirani, MD">Sushma Hirani, MD</option>
                    <option value="Elizabeth McMillan, CNS">Elizabeth McMillan, CNS</option>
                    <option value="Homa Hashime, ND, M.Ac.">Homa Hashime, ND, M.Ac.</option>
                    <option value="Dr. Michael Liss">Dr. Michael Liss</option>-->
					<option value="Sushma Hirani, MD">Sushma Hirani, MD</option>
					<option value="John Reed, MD">John Reed, MD</option>
					<option value="Suzanne Tershak Tither, FNP-BC">Suzanne Tershak Tither, FNP-BC</option>
					<option value="Elizabeth McMillan, CNS"> Elizabeth McMillan, CNS</option>
					<option value="Homa Hashime, ND, M.Ac.">Homa Hashime, ND, M.Ac.</option>
					<option value="Daira Duric, CHC">Daira Duric, CHC</option>
					<option value="Michael Liss">Michael Liss</option>
                </select>
            </p>
            <p>
                <label for="00N4100000aJL1L">Comments:</label>
                <textarea id="00N4100000aJL1L" class="notes" name="00N4100000aJL1L"></textarea>
            </p>
            <input id="00N4100000aJL1Q" style="display: none;" checked="checked" name="00N4100000aJL1Q" type="checkbox" value="1" />
            <div class="btndeff">
                <input name="Clear" type="reset" value="Clear" /><input name="submit" type="submit" value="Submit" />
            </div>
        </form>
    </div>
    <script>
        function setRating() {
            var rates = document.getElementsByName('rating');
            var rate_value;
            for (var i = 0; i < rates.length; i++) {
                if (rates[i].checked) {
                    rate_value = rates[i].value;
                }
            }
            document.getElementById('ratingText').value = rate_value;
        }
    </script>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}



/* Custom Blog Module */

//vc_map(array(
//    "name" => __("Latest Blog"),
//    "base" => "blog_latest_shortcode",
//    "category" => __('Content'),
//    "params" => array()
//));

add_shortcode('blog_latest_shortcode', 'blog_latest_callback');

function blog_latest_callback($atts) {
    ob_start();
    
    $blog_args = array (
		'posts_per_page' => 6,
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'orderby' => 'date',
		'order'	=> 'DESC'
	);
	
	$blog_query = new WP_Query($blog_args);
	
	if ($blog_query->have_posts()) { ?>
	
	    <div class="blog-latest-container">
	    
	    <div class="row posts_list">
    	    <?php
    		while ($blog_query->have_posts()) {
    			$blog_query->the_post();
    			$postID =  get_the_id();
    			
    			$the_content = strip_shortcodes(get_the_content($postID));
    			$excerpt = get_the_excerpt($postID);
    			
    			if(empty($excerpt)) {
    			    $content_org = wp_trim_words($the_content, 20, '...');
    			} else {
    			    $content_org = wp_trim_words($excerpt, 20, '...');
    			}
    			
    			// Get Current Category Slug
                $current_category = get_the_category($postID);
                $category_slug = $current_category[0]->slug;
                $category_name = $current_category[0]->name;
    			
    			?>
    			<div class="post-item col-md-4">
    			    <div class="post_thubmnail featured_img">
    				    <a href="<?php echo get_the_permalink($postID); ?>">
    				        <?php
        						if (has_post_thumbnail()) {
        							echo get_the_post_thumbnail($postID, 'full');
        						}
        					?>
        				</a>
    				</div>
    				<p class="category_info"><a href="<?php echo site_url().'/category/'.$category_slug; ?>"><?php echo $category_name; ?></a></p>
    				<a href="<?php echo get_the_permalink($postID); ?>"><h4><?php echo get_the_title($postID); ?></h4></a>
    				<p class="blog_desc"><?php echo $content_org; ?></p>
    			</div>
    			<?php
    		}

    		echo '<div class="blog_load_more"><a class="loadABlog" href="javascript:void(0);" data-page="0"> Load More </a></div>';
    		
    		echo '</div></div>';
	}
	
	wp_reset_postdata();
	wp_reset_query();
	
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}


/* Custom Featured Blog Module */

//vc_map(array(
//    "name" => __("Featured Blog"),
//    "base" => "blog_featured_shortcode",
//    "category" => __('Content'),
//    "params" => array()
//));

add_shortcode('blog_featured_shortcode', 'blog_featured_callback');

function blog_featured_callback($atts) {
    ob_start();
    
    // Blog Category
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    if(!empty($atts['cat_id'])) {
        
        $blog_args = array (
    		'posts_per_page' => 3,
    		'paged'	=> $paged,
			'orderby' => 'date',
            'order'   => 'DESC',
    		'post_type'   => 'post',
    		'post_status'    => 'publish',
    		'tax_query' => array(
    		    'relation' => 'AND',
    			array(
    				'taxonomy' => 'category',
    				'field' => 'term_id',
    				'terms' => array(35),
    				'operator' => 'IN',
    			),
    			array(
    				'taxonomy' => 'category',
    				'field' => 'term_id',
    				'terms' => array($atts['cat_id']),
    				'operator' => 'IN',
    			)
    		)
    	);
        
    } else {
        
        $blog_args = array (
    		'posts_per_page' => 3,
    		'paged'	=> $paged,
			'orderby' => 'date',
            'order'   => 'DESC',
    		'post_type'   => 'post',
    		'post_status'    => 'publish',
    		'tax_query' => array(
    			array(
    				'taxonomy' => 'category',
    				'field' => 'term_id',
    				'terms' => 35,
    				'operator' => 'IN' 
    			)
    		),
    	);
    	
    }

	$blog_query = new WP_Query($blog_args);
	
	//pr($blog_query);
	
	// Count Posts
    $count_posts = $blog_query->found_posts;
	
	if ($blog_query->have_posts()) { ?>
	
	    <div class="blog-featured-container">
	    
	    <div class="row posts_featured_list">
    	    <?php
    		while ($blog_query->have_posts()) {
    			$blog_query->the_post();
    			$postID =  get_the_id();
    			
    		    $the_content = strip_shortcodes(get_the_content($postID));
    			$excerpt = get_the_excerpt($postID);
    			
    			if(empty($excerpt)) {
    			    $content_org = wp_trim_words($the_content, 20, '...');
    			} else {
    			    $content_org = wp_trim_words($excerpt, 20, '...');
    			}
    			
    			// Get Current Category Slug
                $current_category = get_the_category($postID);
                $category_slug = $current_category[0]->slug;
                $category_name = $current_category[0]->name;
                
                // Get Primary Category
                $primary_cat_id = get_post_meta($postID ,'_yoast_wpseo_primary_category', true);
                $primary_term_array = get_term_by('term_id', $primary_cat_id, 'category');
                $primary_term_name = $primary_term_array->name;
                
                 if(!empty($primary_term_name)) {
                    $blog_cat_name = $primary_term_name;
                    $blog_cat_slug = $primary_term_array->slug;
                } else {
                    $blog_cat_name = $category_name;
                    $blog_cat_slug = $category_slug;
                }
                
                ?>
    			<div class="post-item col-md-4">
    			    <div class="post_thubmnail featured_img">
    				    <a href="<?php echo get_the_permalink($postID); ?>">
    				        <?php
        						if (has_post_thumbnail()) {
        							echo get_the_post_thumbnail($postID, 'full');
        						}
        					?>
        				</a>
    				</div>
    				<p class="category_info"><a href="<?php echo site_url().'/category/'.$blog_cat_slug; ?>"><?php echo $blog_cat_name; ?></a></p>
    				<a href="<?php echo get_the_permalink($postID); ?>"><h4><?php echo get_the_title($postID); ?></h4></a>
    				<p class="blog_desc"><?php echo $content_org; ?></p>
    			</div>
    			<?php
    		}
    		
    		if($count_posts > 2) {
    		    if(!empty($atts['cat_id'])) {
    		        //echo '<div class="blog_load_more"><a class="loadCatFBlog" href="javascript:void(0);" data-cat="'.$atts['cat_id'].'" data-page="0"> Load More </a></div>';
    		    } else {
    		        //echo '<div class="blog_load_more"><a class="loadBlog" href="javascript:void(0);" data-page="0"> Load More </a></div>';
    		    }
    		}
    		
    		echo '</div></div>';
	}
	
	wp_reset_postdata();
	wp_reset_query();
	
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}


/* Custom Featured Blog Module */
//
//vc_map(array(
//    "name" => __("Blog Slider"),
//    "base" => "blog_slider_shortcode",
//    "category" => __('Content'),
//    "params" => array()
//));

add_shortcode('blog_slider_shortcode', 'blog_slider_callback');

function blog_slider_callback($atts) {
    ob_start();
    
	$blog_args = array (
		'posts_per_page' => 10,
		'post_type'   => 'post',
		'post_status'    => 'publish',
		'meta_query' => array(
			array(
				'key' => 'blog_slider_post',
				'value' => 'yes',
				'compare' => '=',
			),
		)
	);
	
	$blog_query = new WP_Query($blog_args);
	
	if ($blog_query->have_posts()) { ?>
	
	    <div id="blog-slider" class="blog-featured-container">
    	    <?php
    		while ($blog_query->have_posts()) {
    			$blog_query->the_post();
    			$postID =  get_the_id();
    			
    			$the_content = strip_shortcodes(get_the_content($postID));
    			$excerpt = get_the_excerpt($postID);
    			
    			if(empty($excerpt)) {
    			    $content_org = wp_trim_words($the_content, 20, '...');
    			} else {
    			    $content_org = wp_trim_words($excerpt, 20, '...');
    			}
    			
    			// Get Current Category Slug
                $current_category = get_the_category($postID);
                $category_slug = $current_category[0]->slug;
                $category_name = $current_category[0]->name;
    			
    			?>
    			 <div class="new-blog-slider">
                    <div class="row">
                        <div class="col-md-6 colxs-12">
                            <div class="slide-content">
                                <h2><a href="<?php echo get_the_permalink($postID); ?>"><?php echo get_the_title($postID); ?></a></h2>
                                <p><?php echo $content_org; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6 colxs-12"> 
                            <a href="<?php echo get_the_permalink($postID); ?>">
                            <?php
        						if (has_post_thumbnail()) {
        							echo get_the_post_thumbnail($postID, 'full');
        						}
        					?>
        					</a>
                        </div>
                    </div>
                </div>
    			<?php
    		}
    	echo '</div>';
	}
	
	wp_reset_postdata();
	wp_reset_query();
	
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}



/* Custom Featured Blog Module */

//vc_map(array(
//    "name" => __("Category Grid"),
//    "base" => "cat_grid_shortcode",
//    "category" => __('Content'),
//    "params" => array()
//));

add_shortcode('cat_grid_shortcode', 'cat_grid_callback');

function cat_grid_callback($atts) {
    ob_start();
    
    // Get Query Object
    $queried_object = get_queried_object();
    $blog_cat_name = $queried_object->name;
    
    // Get Featured Category
    $args = array(
        'hide_empty' => false, 
        'meta_query' => array(
          array(
             'key'       => 'featured_cat',
             'value'     => 'yes',
             'compare'   => '='
          )
     ));
    
    $featured_cats_array = get_terms( 'category', $args );
    
    if(!empty($featured_cats_array)) { ?>
        <div class="blog-icons-sec-row">
            <ul>
                <?php
    	    	foreach($featured_cats_array as $category) {  
        	    	$icon_image = get_term_meta($category->term_id, 'icon-image-id', true);
        	    	$icon_image_url = wp_get_attachment_url($icon_image);
    	    	?>
                    <li>
                        <div class="blog-icons-sec <?php if($blog_cat_name == $category->name) { echo 'active';  } ?>">
                            <a href="<?php echo site_url().'/'.$category->slug; ?>">
                                <img src="<?php echo $icon_image_url; ?>" alt="<?php echo $category->name; ?>">
                                <p><?php echo $category->name; ?></p>
                            </a>
                        </div>
                    </li>
    	    	<?php } ?>
            </ul>
        </div>
    <?php } ?>
    <?php
	
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
} 

/* Custom Self Assessments Module */

//vc_map(array(
//    "name" => __("Self Assessments"),
//    "base" => "assessments_grid_shortcode",
//    "category" => __('Content'),
//    "params" => array()
//));

add_shortcode('assessments_grid_shortcode', 'self_assesments_callback');

function self_assesments_callback($atts) {
    ob_start();
    
    $blog_args = array (
		'posts_per_page' => 6,
		'post_type'   => 'assessments',
		'post_status'    => 'publish'
	);
	
	$blog_query = new WP_Query($blog_args);
	
	if ($blog_query->have_posts()) { ?>
    <div class="blog-featured-container blog-self-assessment-row">
        <h2 class="featured_title">Self Assessments</h2> 
        <div class="row">
            <?php
            while ($blog_query->have_posts()) {
    			$blog_query->the_post();
    			$postID =  get_the_id();
    			
    			$the_content = get_the_content($postID);
    			$post_assessments_options = get_post_meta($postID, 'post_assessments_options', true);
    			$button_url = $post_assessments_options['post_button_url'];
    			?>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="blog-self-assessment-box">
                        <a href="<?php echo $button_url; ?>">
                        <?php
    						if (has_post_thumbnail()) {
    							echo get_the_post_thumbnail($postID, 'full');
    						}
    					?>
    					</a>
                        <h3><a href="<?php echo $button_url; ?>"><?php echo get_the_title($postID); ?></a></h3>
                        <p><?php echo $the_content; ?></p>
                        <!--a href="<?php echo $button_url; ?>" class="green-btns">Start</a-->
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php  }
    
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

/* Contact Map Sortcode */

//vc_map(array(
//    "name" => __("Contact Map"),
//    "base" => "rosewellness_contact_map",
//    "category" => __('Content'),
//    "params" => array()
//));

add_shortcode('rosewellness_contact_map', 'rosewell_dynamic_usa_map_callback');

function rosewell_dynamic_usa_map_callback($atts) {
    ob_start();
    global $wp;
	
	$team_location = load_terms('team_location');
	$location_list = array();
	foreach( $team_location as $category ) {
		$location_list[$category->name] = $category->term_id;
	}
    ?>
    <div class="rt-image-map-wrapper">
        <span id="map-info-box-line"></span>
        <div id="map-info-box"></div>
        <div class="rt-image-map">
            <svg viewBox="174 100 959 593" enable-background="new 174 100 959 593" xml:space="preserve">
            <g>
			<path data-info="Alaska" id="AK" d="M332.1,553.7l-0.3,85.4l1.6,1l3.1,0.2l1.5-1.1h2.6l0.2,2.9l7,6.8l0.5,2.6l3.4-1.9l0.6-0.2l0.3-3.1   l1.5-1.6l1.1-0.2l1.9-1.5l3.1,2.1l0.6,2.9l1.9,1.1l1.1,2.4l3.9,1.8l3.4,6l2.7,3.9l2.3,2.7l1.5,3.7l5,1.8l5.2,2.1l1,4.4l0.5,3.1   l-1,3.4l-1.8,2.3l-1.6-0.8l-1.5-3.1l-2.7-1.5l-1.8-1.1l-0.8,0.8l1.5,2.7l0.2,3.7l-1.1,0.5l-1.9-1.9l-2.1-1.3l0.5,1.6l1.3,1.8   l-0.8,0.8c0,0-0.8-0.3-1.3-1c-0.5-0.6-2.1-3.4-2.1-3.4l-1-2.3c0,0-0.3,1.3-1,1c-0.6-0.3-1.3-1.5-1.3-1.5l1.8-1.9l-1.5-1.5v-5h-0.8   l-0.8,3.4l-1.1,0.5l-1-3.7l-0.6-3.7l-0.8-0.5l0.3,5.7v1.1l-1.5-1.3l-3.6-6l-2.1-0.5l-0.6-3.7l-1.6-2.9l-1.6-1.1v-2.3l2.1-1.3   l-0.5-0.3l-2.6,0.6l-3.4-2.4l-2.6-2.9l-4.8-2.6l-4-2.6l1.3-3.2v-1.6l-1.8,1.6l-2.9,1.1l-3.7-1.1l-5.7-2.4h-5.5l-0.6,0.5l-6.5-3.9   l-2.1-0.3l-2.7-5.8l-3.6,0.3l-3.6,1.5l0.5,4.5l1.1-2.9l1,0.3l-1.5,4.4l3.2-2.7l0.6,1.6l-3.9,4.4l-1.3-0.3l-0.5-1.9l-1.3-0.8   l-1.3,1.1l-2.7-1.8l-3.1,2.1l-1.8,2.1l-3.4,2.1l-4.7-0.2l-0.5-2.1l3.7-0.6v-1.3l-2.3-0.6l1-2.4l2.3-3.9v-1.8l0.2-0.8l4.4-2.3l1,1.3   h2.7l-1.3-2.6l-3.7-0.3l-5,2.7l-2.4,3.4l-1.8,2.6l-1.1,2.3l-4.2,1.5l-3.1,2.6l-0.3,1.6l2.3,1l0.8,2.1l-2.7,3.2l-6.5,4.2l-7.8,4.2   l-2.1,1.1l-5.3,1.1l-5.3,2.3l1.8,1.3l-1.5,1.5l-0.5,1.1l-2.7-1l-3.2,0.2l-0.8,2.3h-1l0.3-2.4l-3.6,1.3l-2.9,1l-3.4-1.3l-2.9,1.9   h-3.2l-2.1,1.3l-1.6,0.8l-2.1-0.3l-2.6-1.1l-2.3,0.6l-1,1l-1.6-1.1v-1.9l3.1-1.3l6.3,0.6l4.4-1.6l2.1-2.1l2.9-0.6l1.8-0.8l2.7,0.2   l1.6,1.3l1-0.3l2.3-2.7l3.1-1l3.4-0.6l1.3-0.3l0.6,0.5h0.8l1.3-3.7l4-1.5l1.9-3.7l2.3-4.5l1.6-1.5l0.3-2.6l-1.6,1.3l-3.4,0.6   l-0.6-2.4l-1.3-0.3l-1,1l-0.2,2.9l-1.5-0.2l-1.5-5.8l-1.3,1.3l-1.1-0.5l-0.3-1.9l-4,0.2l-2.1,1.1l-2.6-0.3l1.5-1.5l0.5-2.6   l-0.6-1.9l1.5-1l1.3-0.2l-0.6-1.8v-4.4l-1-1l-0.8,1.5h-6.1l-1.5-1.3l-0.6-3.9l-2.1-3.6v-1l2.1-0.8l0.2-2.1l1.1-1.1l-0.8-0.5   l-1.3,0.5l-1.1-2.7l1-5l4.5-3.2l2.6-1.6l1.9-3.7l2.7-1.3l2.6,1.1l0.3,2.4l2.4-0.3l3.2-2.4l1.6,0.6l1,0.6h1.6l2.3-1.3l0.8-4.4   c0,0,0.3-2.9,1-3.4c0.6-0.5,1-1,1-1l-1.1-1.9l-2.6,0.8l-3.2,0.8l-1.9-0.5l-3.6-1.8l-5-0.2l-3.6-3.7l0.5-3.9l0.6-2.4l-2.1-1.8   l-1.9-3.7l0.5-0.8l6.8-0.5h2.1l1,1h0.6l-0.2-1.6l3.9-0.6l2.6,0.3l1.5,1.1l-1.5,2.1l-0.5,1.5l2.7,1.6l5,1.8l1.8-1l-2.3-4.4l-1-3.2   l1-0.8l-3.4-1.9l-0.5-1.1l0.5-1.6l-0.8-3.9l-2.9-4.7l-2.4-4.2l2.9-1.9h3.2l1.8,0.6l4.2-0.2l3.7-3.6l1.1-3.1l3.7-2.4l1.6,1l2.7-0.6   l3.7-2.1l1.1-0.2l1,0.8l4.5-0.2l2.7-3.1h1.1l3.6,2.4l1.9,2.1l-0.5,1.1l0.6,1.1l1.6-1.6l3.9,0.3l0.3,3.7l1.9,1.5l7.1,0.6l6.3,4.2   l1.5-1l5.2,2.6l2.1-0.6l1.9-0.8l4.8,1.9L332.1,553.7z M217,582.6l2.1,5.3l-0.2,1l-2.9-0.3l-1.8-4l-1.8-1.5H210l-0.2-2.6l1.8-2.4   l1.1,2.4l1.5,1.5L217,582.6z M214.4,616.1l3.7,0.8l3.7,1l0.8,1l-1.6,3.7l-3.1-0.2l-3.4-3.6L214.4,616.1z M193.7,602l1.1,2.6   l1.1,1.6l-1.1,0.8l-2.1-3.1V602H193.7z M180,675.1l3.4-2.3l3.4-1l2.6,0.3l0.5,1.6l1.9,0.5l1.9-1.9l-0.3-1.6l2.7-0.6l2.9,2.6   l-1.1,1.8l-4.4,1.1l-2.7-0.5l-3.7-1.1l-4.4,1.5l-1.6,0.3L180,675.1z M228.9,670.6l1.6,1.9l2.1-1.6l-1.5-1.3L228.9,670.6z    M231.8,673.6l1.1-2.3l2.1,0.3l-0.8,1.9H231.8z M255.4,671.7l1.5,1.8l1-1.1l-0.8-1.9L255.4,671.7z M264.2,659.2l1.1,5.8l2.9,0.8   l5-2.9l4.4-2.6l-1.6-2.4l0.5-2.4l-2.1,1.3l-2.9-0.8l1.6-1.1l1.9,0.8l3.9-1.8l0.5-1.5l-2.4-0.8l0.8-1.9l-2.7,1.9l-4.7,3.6l-4.8,2.9   L264.2,659.2z M306.5,639.4l2.4-1.5l-1-1.8l-1.8,1L306.5,639.4z"/>
            <path id="FL" data-info="Florida" class="sponsored" d="M929.4,545.5l2.3,7.3l3.7,9.7l5.3,9.4l3.7,6.3l4.8,5.5l4,3.7l1.6,2.9l-1.1,1.3L953,593l2.9,7.4   l2.9,2.9l2.6,5.3l3.6,5.8l4.5,8.2l1.3,7.6l0.5,12l0.6,1.8l-0.3,3.4l-2.4,1.3l0.3,1.9l-0.6,1.9l0.3,2.4l0.5,1.9l-2.7,3.2l-3.1,1.5   l-3.9,0.2l-1.5,1.6l-2.4,1l-1.3-0.5l-1.1-1l-0.3-2.9l-0.8-3.4l-3.4-5.2l-3.6-2.3l-3.9-0.3l-0.8,1.3l-3.1-4.4l-0.6-3.6l-2.6-4   l-1.8-1.1l-1.6,2.1l-1.8-0.3l-2.1-5l-2.9-3.9l-2.9-5.3l-2.6-3.1l-3.6-3.7l2.1-2.4l3.2-5.5l-0.2-1.6l-4.5-1l-1.6,0.6l0.3,0.6l2.6,1   l-1.5,4.5l-0.8,0.5l-1.8-4l-1.3-4.8l-0.3-2.7l1.5-4.7v-9.5L910,585l-1.3-3.1l-5.2-1.3l-1.9-0.6l-1.6-2.6l-3.4-1.6l-1.1-3.4l-2.7-1   l-2.4-3.7l-4.2-1.5l-2.9-1.5h-2.6l-4,0.8l-0.2,1.9l0.8,1l-0.5,1.1l-3.1-0.2l-3.7,3.6l-3.6,1.9h-3.9l-3.2,1.3l-0.3-2.7l-1.6-1.9   l-2.9-1.1l-1.6-1.5l-8.1-3.9l-7.6-1.8l-4.4,0.6l-6,0.5l-6,2.1l-3.5,0.6l-0.2-8l-2.6-1.9l-1.8-1.8l0.3-3.1l10.2-1.3l25.5-2.9   l6.8-0.6l5.4,0.3l2.6,3.9l1.5,1.5l8.1,0.5l10.8-0.6l21.5-1.3l5.4-0.7l4.6,0l0.2,2.9l3.8,0.8l0.3-4.8l-1.6-4.5l1-0.7l5.1,0.5   L929.4,545.5z M941.9,677.9l2.4-0.6l1.3-0.2l1.5-2.3l2.3-1.6l1.3,0.5l1.7,0.3l0.4,1.1l-3.5,1.2l-4.2,1.5l-2.3,1.2L941.9,677.9z    M955.4,672.9l1.2,1.1l2.7-2.1l5.3-4.2l3.7-3.9l2.5-6.6l1-1.7l0.2-3.4l-0.7,0.5l-1,2.8l-1.5,4.6l-3.2,5.3l-4.4,4.2l-3.4,1.9   L955.4,672.9z"/>
            <path id="SC" data-info="South Carolina" d="M935.2,512.9l-1.8,1l-2.6-1.3l-0.6-2.1l-1.3-3.6l-2.3-2.1l-2.6-0.6l-1.6-4.8l-2.7-6l-4.2-1.9   l-2.1-1.9l-1.3-2.6L910,485l-2.3-1.3l-2.3-2.9l-3.1-2.3l-4.5-1.8l-0.5-1.5l-2.4-2.9l-0.5-1.5l-3.4-5.2l-3.4,0.2l-4-2.4l-1.3-1.3   l-0.3-1.8l0.8-1.9l2.3-1l-0.3-2.1l6.1-2.6l9.1-4.5l7.3-0.8l16.5-0.5l2.3,1.9l1.6,3.2l4.4-0.5l12.6-1.5l2.9,0.8l12.6,7.6l10.1,8.1   l-5.4,5.5l-2.6,6.1l-0.5,6.3l-1.6,0.8l-1.1,2.7l-2.4,0.6l-2.1,3.6l-2.7,2.7l-2.3,3.4l-1.6,0.8l-3.6,3.4l-2.9,0.2l1,3.2l-5,5.5   L935.2,512.9z"/>
            <path id="GA" data-info="Georgia" d="M863.6,458l-4.8,0.8l-8.4,1.1l-8.6,0.9v2.2l0.2,2.1l0.6,3.4l3.4,7.9l2.4,9.9l1.5,6.1l1.6,4.8l1.5,7   l2.1,6.3l2.6,3.4l0.5,3.4l1.9,0.8l0.2,2.1l-1.8,4.8l-0.5,3.2l-0.2,1.9l1.6,4.4l0.3,5.3l-0.8,2.4l0.6,0.8l1.5,0.8l0.6,3.4l2.6,3.9   l1.5,1.5l7.9,0.2l10.8-0.6l21.5-1.3l5.4-0.7l4.6,0l0.2,2.9l2.6,0.8l0.3-4.4l-1.6-4.5l1.1-1.6l5.8,0.8l5,0.3l-0.8-6.3l2.3-10   l1.5-4.2l-0.5-2.6l3.3-6.2l-0.5-1.4l-1.9,0.7l-2.6-1.3l-0.6-2.1l-1.3-3.6l-2.3-2.1l-2.6-0.6l-1.6-4.8l-2.9-6.3l-4.2-1.9l-2.1-1.9   l-1.3-2.6l-2.1-1.9l-2.3-1.3l-2.3-2.9l-3.1-2.3l-4.5-1.8l-0.5-1.5l-2.4-2.9l-0.5-1.5l-3.4-4.9l-3.4,0.2l-4.1-3l-1.3-1.3l-0.3-1.8   l0.8-1.9l2.4-1.2l-1.1-1.2l0.1-0.3l-5.8,1l-7,0.8L863.6,458z"/>
            <path id="AL" data-info="Alabama" d="M799.6,566.8l-1.6-15.2l-2.7-18.8l0.2-14.1l0.8-31l-0.2-16.7l0.2-6.4l7.8-0.4l27.8-2.6l8.9-0.7   l-0.1,2.2l0.2,2.1l0.6,3.4l3.4,7.9l2.4,9.9l1.5,6.1l1.6,4.8l1.5,7l2.1,6.3l2.6,3.4l0.5,3.4l1.9,0.8l0.2,2.1l-1.8,4.8l-0.5,3.2   l-0.2,1.9l1.6,4.4l0.3,5.3l-0.8,2.4l0.6,0.8l1.5,0.8l1,2.5h-6.3l-6.8,0.6l-25.5,2.9l-10.4,1.4l-0.1,3.8l1.8,1.8l2.6,1.9l0.6,7.9   l-5.5,2.6l-2.7-0.3l2.7-1.9v-1l-3.1-6l-2.3-0.6l-1.5,4.4l-1.3,2.7l-0.6-0.2H799.6z"/>
            <path id="NC" data-info="North Carolina" d="M1006.1,398.5l1.7,4.7l3.6,6.5l2.4,2.4l0.6,2.3l-2.4,0.2l0.8,0.6l-0.3,4.2l-2.6,1.3l-0.6,2.1   l-1.3,2.9l-3.7,1.6l-2.4-0.3l-1.5-0.2l-1.6-1.3l0.3,1.3v1h1.9l0.8,1.3l-1.9,6.3h4.2l0.6,1.6l2.3-2.3l1.3-0.5l-1.9,3.6l-3.1,4.8   h-1.3l-1.1-0.5l-2.7,0.6l-5.2,2.4l-6.5,5.3l-3.4,4.7l-1.9,6.5l-0.5,2.4l-4.7,0.5l-5.5,1.3l-9.9-8.2l-12.6-7.6l-2.9-0.8l-12.6,1.5   l-4.3,0.8l-1.6-3.2l-3-2.1l-16.5,0.5l-7.3,0.8l-9.1,4.5l-6.1,2.6l-1.6,0.3l-5.8,1l-7,0.8l-6.8,0.5l0.5-4.1l1.8-1.5l2.7-0.6l0.6-3.7   l4.2-2.7l3.9-1.5l4.2-3.6l4.4-2.1l0.6-3.1l3.9-3.9l0.6-0.2c0,0,0,1.1,0.8,1.1c0.8,0,1.9,0.3,1.9,0.3l2.3-3.6l2.1-0.6l2.3,0.3   l1.6-3.6l2.9-2.6l0.5-2.1v-4l4.5,0.7l7.1-1.3l15.8-1.9l17.1-2.6l19.9-4l19.7-4.2l11.4-2.8L1006.1,398.5z M1010,431.5l2.6-2.5   l3.2-2.6l1.5-0.6l0.2-2l-0.6-6.1l-1.5-2.3l-0.6-1.9l0.7-0.2l2.7,5.5l0.4,4.4l-0.2,3.4l-3.4,1.5l-2.8,2.4l-1.1,1.2L1010,431.5z"/>
            <path id="TN" data-info="Tennessee" d="M871.1,420.6l-51.9,5l-15.8,1.8l-4.6,0.5l-3.9,0v3.9l-8.4,0.5l-7,0.6l-11.1,0.1l-0.3,5.8l-2.1,6.3   l-1,3l-1.3,4.4l-0.3,2.6l-4,2.3l1.5,3.6l-1,4.4l-1,0.8l7.3-0.2l24.1-1.9l5.3-0.2l8.1-0.5l27.8-2.6l10.2-0.8l8.4-1l8.4-1.1l4.8-0.8   l-0.1-4.5l1.8-1.5l2.7-0.6l0.6-3.7l4.2-2.7l3.9-1.5l4.2-3.6l4.4-2.1l0.9-3.5l4.3-3.9l0.6-0.2c0,0,0,1.1,0.8,1.1s1.9,0.3,1.9,0.3   l2.3-3.6l2.1-0.6l2.3,0.3l1.6-3.6l2.1-2.2l0.6-1l0.2-3.9l-1.5-0.3l-2.4,1.9l-7.9,0.2l-12,1.9L871.1,420.6z"/>
            <path id="RI" data-info="Rhode Island" d="M1048.1,279.8l-0.5-4.2l-0.8-4.4l-1.7-5.9l5.7-1.5l1.6,1.1l3.4,4.4l2.9,4.4l-2.9,1.5l-1.3-0.2   l-1.1,1.8l-2.4,1.9L1048.1,279.8z"/>
            <path id="CT" data-info="Connecticut" class="sponsored" d="M1047.2,280.1l-0.6-4.2l-0.8-4.4l-1.6-6l-4.2,0.9l-21.8,4.8l0.6,3.3l1.5,7.3v8.1l-1.1,2.3l1.8,2.1   l5-3.4l3.6-3.2l1.9-2.1l0.8,0.6l2.7-1.5l5.2-1.1L1047.2,280.1z"/>
            <path id="MA" data-info="Massachusetts" d="M1074,273.9l2.2-0.7l0.5-1.7l1,0.1l1,2.3l-1.3,0.5l-3.9,0.1L1074,273.9z M1064.6,274.7l2.3-2.6h1.6   l1.8,1.5l-2.4,1l-2.2,1L1064.6,274.7z M1029.8,252.7l17.5-4.2l2.3-0.6l2.1-3.2l3.7-1.7l2.9,4.4l-2.4,5.2l-0.3,1.5l1.9,2.6l1.1-0.8   h1.8l2.3,2.6l3.9,6l3.6,0.5l2.3-1l1.8-1.8l-0.8-2.7l-2.1-1.6l-1.5,0.8l-1-1.3l0.5-0.5l2.1-0.2l1.8,0.8l1.9,2.4l1,2.9l0.3,2.4   l-4.2,1.5l-3.9,1.9l-3.9,4.5l-1.9,1.5v-1l2.4-1.5l0.5-1.8l-0.8-3.1l-2.9,1.5l-0.8,1.5l0.5,2.3l-2.1,1l-2.7-4.5l-3.4-4.4l-2.1-1.8   l-6.5,1.9l-5.1,1.1l-21.8,4.8l-0.4-4.9l0.6-10.6l5.2-0.9L1029.8,252.7z"/>
            <path id="ME" data-info="Maine" d="M1097.2,177.3l1.9,2.1l2.3,3.7v1.9l-2.1,4.7l-1.9,0.6l-3.4,3.1l-4.8,5.5c0,0-0.6,0-1.3,0   c-0.6,0-1-2.1-1-2.1l-1.8,0.2l-1,1.5l-2.4,1.5l-1,1.5l1.6,1.5l-0.5,0.6l-0.5,2.7l-1.9-0.2v-1.6l-0.3-1.3l-1.5,0.3l-1.8-3.2   l-2.1,1.3l1.3,1.5l0.3,1.1l-0.8,1.3l0.3,3.1l0.2,1.6l-1.6,2.6l-2.9,0.5l-0.3,2.9l-5.3,3.1l-1.3,0.5l-1.6-1.5l-3.1,3.6l1,3.2   l-1.5,1.3l-0.2,4.4l-1.1,6.3l-2.5-1.2l-0.5-3.1l-3.9-1.1l-0.3-2.7l-7.3-23.4l-4.2-13.6l1.4-0.1l1.5,0.4v-2.6l0.8-5.5l2.6-4.7l1.5-4   l-1.9-2.4v-6l0.8-1l0.8-2.7l-0.2-1.5l-0.2-4.8l1.8-4.8l2.9-8.9l2.1-4.2h1.3l1.3,0.2v1.1l1.3,2.3l2.7,0.6l0.8-0.8v-1l4-2.9l1.8-1.8   l1.5,0.2l6,2.4l1.9,1l9.1,29.9h6l0.8,1.9l0.2,4.8l2.9,2.3h0.8l0.2-0.5l-0.5-1.1L1097.2,177.3z M1076.3,207.5l1.5-1.5l1.4,1.1   l0.6,2.4l-1.7,0.9L1076.3,207.5z M1083,201.6l1.8,1.9c0,0,1.3,0.1,1.3-0.2s0.2-2,0.2-2l0.9-0.8l-0.8-1.8l-2,0.7L1083,201.6z"/>
            <path id="NH" data-info="New Hampshire" d="M1054.8,242.4l0.9-1.1l1.1-3.3l-2.5-0.9l-0.5-3.1l-3.9-1.1l-0.3-2.7l-7.3-23.4l-4.6-14.5l-0.9,0   l-0.6,1.6l-0.6-0.5l-1-1l-1.5,1.9l0,5l0.3,5.7l1.9,2.7v4l-3.7,5.1l-2.6,1.1v1.1l1.1,1.8v8.6l-0.8,9.2l-0.2,4.8l1,1.3l-0.2,4.5   l-0.5,1.8l1.5,0.9l16.4-4.7l2.3-0.6l1.5-2.6L1054.8,242.4z"/>
            <path id="VT" data-info="Vermont" d="M1018.3,253.7l-0.8-5.7l-2.4-10l-0.6-0.3l-2.9-1.3l0.8-2.9l-0.8-2.1l-2.7-4.6l1-3.9l-0.8-5.2   l-2.4-6.5l-0.8-4.9l26.2-6.7l0.3,5.8l1.9,2.7v4l-3.7,4l-2.6,1.1v1.1l1.1,1.8v8.6l-0.8,9.2l-0.2,4.8l1,1.3l-0.2,4.5l-0.5,1.8   l0.7,1.6l-7,1.4L1018.3,253.7z"/>
            <path id="NY" data-info="New York" d="M1002.6,289.4l-1.1-1l-2.6-0.2l-2.3-1.9l-1.6-6.1l-3.5,0.1l-2.4-2.7l-19.4,4.4l-43,8.7l-7.5,1.2   l-0.7-6.5l1.4-1.1l1.3-1.1l1-1.6l1.8-1.1l1.9-1.8l0.5-1.6l2.1-2.7l1.1-1l-0.2-1l-1.3-3.1l-1.8-0.2l-1.9-6.1l2.9-1.8l4.4-1.5l4-1.3   l3.2-0.5l6.3-0.2l1.9,1.3l1.6,0.2l2.1-1.3l2.6-1.1l5.2-0.5l2.1-1.8l1.8-3.2l1.6-1.9h2.1l1.9-1.1l0.2-2.3l-1.5-2.1l-0.3-1.5l1.1-2.1   v-1.5h-1.8l-1.8-0.8l-0.8-1.1l-0.2-2.6l5.8-5.5l0.6-0.8l1.5-2.9l2.9-4.5l2.7-3.7l2.1-2.4l2.4-1.8l3.1-1.2l5.5-1.3l3.2,0.2l4.5-1.5   l7.6-2.1l0.5,5l2.4,6.5l0.8,5.2l-1,3.9l2.6,4.5l0.8,2.1l-0.8,2.9l2.9,1.3l0.6,0.3l3.1,11l-0.5,5.1l-0.5,10.8l0.8,5.5l0.8,3.6   l1.5,7.3v8.1l-1.1,2.3l1.8,2l0.8,1.7l-1.9,1.8l0.3,1.3l1.3-0.3l1.5-1.3l2.3-2.6l1.1-0.6l1.6,0.6l2.3,0.2l7.9-3.9l2.9-2.7l1.3-1.5   l4.2,1.6l-3.4,3.6l-3.9,2.9l-7.1,5.3l-2.6,1l-5.8,1.9l-4,1.1l-1.2-0.5l-0.2-3.7l0.5-2.7l-0.2-2.1l-2.8-1.7l-4.5-1l-3.9-1.1   L1002.6,289.4z"/>
            <path id="NJ" data-info="New Jersey" class="sponsored"  d="M1002.2,290.3l-2.1,2.4v3.1l-1.9,3.1l-0.2,1.6l1.3,1.3l-0.2,2.4l-2.3,1.1l0.8,2.7l0.2,1.1l2.7,0.3   l1,2.6l3.6,2.4l2.4,1.6v0.8l-3.2,3.1l-1.6,2.3l-1.5,2.7l-2.3,1.3l-1.2,0.7l-0.2,1.2l-0.6,2.6l1.1,2.2l3.2,2.9l4.8,2.3l4,0.6   l0.2,1.5l-0.8,1l0.3,2.7h0.8l2.1-2.4l0.8-4.8l2.7-4l3.1-6.5l1.1-5.5l-0.6-1.1l-0.2-9.4l-1.6-3.4l-1.1,0.8l-2.7,0.3l-0.5-0.5l1.1-1   l2.1-1.9l0.1-1.1l-0.4-3.4l0.5-2.7l-0.2-2.1l-2.6-1.1l-4.5-1l-3.9-1.1L1002.2,290.3z"/>
            <path id="PA" data-info="Pennsylvania" d="M996.2,326.5l1.1-0.6l2.3-0.6l1.5-2.7l1.6-2.3l3.2-3.1v-0.8l-2.4-1.6l-3.6-2.4l-1-2.6l-2.7-0.3   l-0.2-1.1l-0.8-2.7l2.3-1.1l0.2-2.4l-1.3-1.3l0.2-1.6l1.9-3.1v-3.1l2.3-2.4l0.2-1.1l-2.6-0.2l-2.3-1.9l-2.4-5.3l-3-0.9l-2.3-2.1   l-18.6,4l-43,8.7l-8.9,1.5l-0.5-7.1l-5.5,5.6l-1.3,0.5l-4.2,3l2.9,19.1l2.5,9.7l3.6,19.3l3.3-0.6l11.9-1.5l37.9-7.7l14.9-2.8   l8.3-1.6l0.3-0.2l2.1-1.6L996.2,326.5z"/>
            <path id="DE" data-info="Delaware" d="M996.4,330.4l0.6-2.1l0-1.2l-1.3-0.1l-2.1,1.6l-1.5,1.5l1.5,4.2l2.3,5.7l2.1,9.7l1.6,6.3l5-0.2   l6.1-1.2l-2.3-7.4l-1,0.5l-3.6-2.4l-1.8-4.7l-1.9-3.6l-2.3-1l-2.1-3.6L996.4,330.4z"/>
            <path id="MD" data-info="Maryland" class="sponsored" d="M1011,355.3l-6.1,1.3l-5.8,0.2l-1.8-7.1l-2.1-9.7l-2.3-5.7l-1.3-4.4l-7.5,1.6l-14.9,2.8l-37.5,7.6   l1.1,5l1,5.7l0.3-0.3l2.1-2.4l2.3-2.6l2.4-0.6l1.5-1.5l1.8-2.6l1.3,0.6l2.9-0.3l2.6-2.1l2-1.5l1.8-0.5l1.6,1.1l2.9,1.5l1.9,1.8   l1.2,1.5l4.1,1.7v2.9l5.5,1.3l1.1,0.5l1.4-2l2.9,2l-1.3,2.5l-0.8,4l-1.8,2.6v2.1l0.6,1.8l5.1,1.4l4.3-0.1l3.1,1l2.1,0.3l1-2.1   l-1.5-2.1v-1.8l-2.4-2.1l-2.1-5.5l1.3-5.3l-0.2-2.1l-1.3-1.3c0,0,1.5-1.6,1.5-2.3c0-0.6,0.5-2.1,0.5-2.1l1.9-1.3l1.9-1.6l0.5,1   l-1.5,1.6l-1.3,3.7l0.3,1.1l1.8,0.3l0.5,5.5l-2.1,1l0.3,3.6l0.5-0.2l1.1-1.9l1.6,1.8l-1.6,1.3l-0.3,3.4l2.6,3.4l3.9,0.5l1.6-0.8   l3.2,4.2l1.4,0.5l6.7-2.8l2-4L1011,355.3z M994.3,364.3l1.1,2.5l0.2,1.8l1.1,1.9c0,0,0.9-0.9,0.9-1.2c0-0.3-0.7-3.1-0.7-3.1   l-0.7-2.3L994.3,364.3z"/>
            <path id="WV" data-info="West Virginia" d="M930.6,342l1.1,4.9l1.1,6.9l3.6-2.7l2.3-3.1l2.5-0.6l1.5-1.5l1.8-2.6l1.2,0.6l2.9-0.3l2.6-2.1   l2-1.5l1.8-0.5l1.3,1l2.2,1.1l1.9,1.8l1.4,1.3l-0.1,4.7l-5.7-3.1l-4.5-1.8l-0.2,5.3l-0.5,2.1l-1.6,2.7l-0.6,1.6l-3.1,2.4l-0.5,2.3   l-3.4,0.3l-0.3,3.1l-1.1,5.5h-2.6l-1.3-0.8l-1.6-2.7l-1.8,0.2l-0.3,4.4l-2.1,6.6l-5,10.8l0.8,1.3l-0.2,2.7l-2.1,1.9l-1.5-0.3   l-3.2,2.4l-2.6-1l-1.8,4.7c0,0-3.7,0.8-4.4,1c-0.6,0.2-2.4-1.3-2.4-1.3l-2.4,2.3l-2.6,0.6l-2.9-0.8l-1.3-1.3l-2.2-3l-3.1-2   l-2.6-2.7l-2.9-3.7l-0.6-2.3l-2.6-1.5l-0.8-1.6l-0.2-5.3l2.2-0.1l1.9-0.8l0.2-2.7l1.6-1.5l0.2-5l1-3.9l1.3-0.6l1.3,1.1l0.5,1.8   l1.8-1l0.5-1.6l-1.1-1.8v-2.4l1-1.3l2.3-3.4l1.3-1.5l2.1,0.5l2.3-1.6l3.1-3.4l2.3-3.9l0.3-5.7l0.5-5v-4.7l-1.1-3.1l1-1.5l1.3-1.3   l3.5,19.8l4.6-0.8L930.6,342z"/>
            <path id="KY" data-info="Kentucky" d="M895.8,397.8l-2.3,2.7l-4.2,3.6L885,410l-1.8,1.8v2.1l-3.9,2.1l-5.7,3.4l-3.5,0.4l-51.9,4.9   l-15.8,1.8l-4.6,0.5l-3.9,0l-0.2,4.2l-8.2,0.1l-7,0.6l-10.4,0.2l1.9-0.2l2.2-1.8l2.1-1.1l0.2-3.2l0.9-1.8l-1.6-2.5l0.8-1.9l2.3-1.8   l2.1-0.6l2.7,1.3l3.6,1.3l1.1-0.3l0.2-2.3l-1.3-2.4l0.3-2.3l1.9-1.5l2.6-0.6l1.6-0.6l-0.8-1.8l-0.6-1.9l1.1-0.8l1.1-3.3l3-1.7   l5.8-1l3.6-0.5l1.5,1.9l1.8,0.8l1.8-3.2l2.9-1.5l1.9,1.6l0.8,1.1l2.1-0.5l-0.2-3.4l2.9-1.6l1.1-0.8l1.1,1.6h4.7l0.8-2.1l-0.3-2.3   l2.9-3.6l4.7-3.9l0.5-4.5l2.7-0.3l3.9-1.8l2.7-1.9l-0.3-1.9l-1.5-1.5l0.6-2.2l4.1-0.2l2.4-0.8l2.9,1.6l1.6,4.4l5.8,0.3l1.8,1.8   l2.1,0.2l2.4-1.5l3.1,0.5l1.3,1.5l2.7-2.6l1.8-1.3h1.6l0.6,2.7l1.8,1l2.4,2.2l0.2,5.5l0.8,1.6l2.6,1.5l0.6,2.3l2.9,3.7l2.6,2.7   L895.8,397.8z"/>				
            <path id="MI" data-info="Michigan" class="sponsored" d="M755.6,182.1l1.8-2.1l2.2-0.8l5.4-3.9l2.3-0.6l0.5,0.5l-5.1,5.1l-3.3,1.9l-2.1,0.9L755.6,182.1z    M841.8,214.2l0.6,2.5l3.2,0.2l1.3-1.2c0,0-0.1-1.5-0.4-1.6c-0.3-0.2-1.6-1.9-1.6-1.9l-2.2,0.2l-1.6,0.2l-0.3,1.1L841.8,214.2z    M871.9,277.2l-3.2-8.2l-2.3-9.1l-2.4-3.2l-2.6-1.8l-1.6,1.1l-3.9,1.8l-1.9,5l-2.7,3.7l-1.1,0.6l-1.5-0.6c0,0-2.6-1.5-2.4-2.1   c0.2-0.6,0.5-5,0.5-5l3.4-1.3l0.8-3.4l0.6-2.6l2.4-1.6l-0.3-10l-1.6-2.3l-1.3-0.8l-0.8-2.1l0.8-0.8l1.6,0.3l0.2-1.6L850,231   l-1.3-2.6h-2.6l-4.5-1.5l-5.5-3.4h-2.7l-0.6,0.6l-1-0.5l-3.1-2.3l-2.9,1.8l-2.9,2.3l0.3,3.6l1,0.3l2.1,0.5l0.5,0.8l-2.6,0.8   l-2.6,0.3l-1.5,1.8l-0.3,2.1l0.3,1.6l0.3,5.5l-3.6,2.1l-0.6-0.2v-4.2l1.3-2.4l0.6-2.4l-0.8-0.8l-1.9,0.8l-1,4.2l-2.7,1.1l-1.8,1.9   l-0.2,1l0.6,0.8l-0.6,2.6l-2.3,0.5v1.1l0.8,2.4l-1.1,6.1l-1.6,4l0.6,4.7l0.5,1.1l-0.8,2.4l-0.3,0.8l-0.3,2.7l3.6,6l2.9,6.5l1.5,4.8   l-0.8,4.7l-1,6l-2.4,5.2l-0.3,2.7l-3.3,3.1l4.4-0.2l21.4-2.3l7.3-1l0.1,1.7l6.9-1.2l10.3-1.5l3.9-0.5l0.1-0.6l0.2-1.5l2.1-3.7   l2-1.7l-0.2-5.1l1.6-1.6l1.1-0.3l0.2-3.6l1.5-3l1.1,0.6l0.2,0.6l0.8,0.2l1.9-1L871.9,277.2z M741.5,211.2l0.7-0.6l2.7-0.8l3.6-2.3   v-1l0.6-0.6l6-1l2.4-1.9l4.4-2.1l0.2-1.3l1.9-2.9l1.8-0.8l1.3-1.8l2.3-2.3l4.4-2.4l4.7-0.5l1.1,1.1l-0.3,1l-3.7,1l-1.5,3.1   l-2.3,0.8l-0.5,2.4l-2.4,3.2l-0.3,2.6l0.8,0.5l1-1.1l3.6-2.9l1.3,1.3h2.3l3.2,1l1.5,1.1l1.5,3.1l2.7,2.7l3.9-0.2l1.5-1l1.6,1.3   l1.6,0.5l1.3-0.8h1.1l1.6-1l4-3.6l3.4-1.1l6.6-0.3l4.5-1.9l2.6-1.3l1.5,0.2v5.7l0.5,0.3l2.9,0.8l1.9-0.5l6.1-1.6l1.1-1.1l1.5,0.5v7   l3.2,3.1l1.3,0.6l1.3,1l-1.3,0.3l-0.8-0.3l-3.7-0.5l-2.1,0.6l-2.3-0.2l-3.2,1.5h-1.8l-5.8-1.3l-5.2,0.2l-1.9,2.6l-7,0.6l-2.4,0.8   l-1.1,3.1l-1.3,1.1l-0.5-0.2l-1.5-1.6l-4.5,2.4h-0.6l-1.1-1.6l-0.8,0.2l-1.9,4.4l-1,4l-3.2,7l-1.2-1l-1.4-1l-1.9-10.3l-3.5-1.4   l-2.1-2.3l-12.1-2.7l-2.9-1l-8.2-2.2l-7.9-1.1L741.5,211.2z"/>
            <path id="OH" data-info="Ohio" d="M905.4,295l-6.1,4.1l-3.9,2.3l-3.4,3.7l-4,3.9l-3.2,0.8l-2.9,0.5l-5.5,2.6l-2.1,0.2l-3.4-3.1   l-5.2,0.6l-2.6-1.5l-2.4-1.4l-4.9,0.7l-10.2,1.6l-7.8,1.2l1.3,14.6l1.8,13.7l2.6,23.4l0.6,4.8l4.1-0.1l2.4-0.8l3.4,1.5l2.1,4.4   l5.1,0l1.9,2.1l1.8-0.1l2.5-1.3l2.5,0.4l2,1.5l1.7-2.1l2.3-1.3l2.1-0.7l0.6,2.7l1.8,1l3.5,2.3l2.2-0.1l1.1-1.1l-0.1-1.4l1.6-1.5   l0.2-5l1-3.9l1.5-1.4l1.5,0.9l0.8,1.2l1.2-0.2l-0.4-2.4l-0.6-0.6v-2.4l1-1.3l2.3-3.4l1.3-1.5l2.1,0.5l2.3-1.6l3.1-3.4l2.3-3.9   l0.2-5.4l0.5-5v-4.7l-1.1-3.1l1-1.5l0.9-1l-1.4-9.8L905.4,295z"/>
            <path id="WY" data-info="Wyoming" d="M528.3,243.8l-10.5-0.8l-32.1-3.3l-16.2-2.1l-28.3-4.1l-19.9-3l-1.4,11.2l-3.8,24.3l-5.3,30.4   l-1.5,10.5l-1.7,11.9l6.5,0.9l25.9,2.5l20.6,2.3l36.8,4.1l23.8,2.9l4.5-44.2l1.4-25.4L528.3,243.8z"/>
            <path id="MT" data-info="Montana" d="M530.7,222.3l0.6-11.2l2.3-24.8c0.5-5,1.1-8.5,1.4-15.4l0.9-14.6l-30.7-2.8L476,150l-29.3-4   l-32.3-5.3l-18.4-3.4l-32.7-6.9l-4.5,21.3l3.4,7.5l-1.4,4.6l1.8,4.6l3.2,1.4l4.6,10.8l2.7,3.2l0.5,1.1l3.4,1.1l0.5,2.1l-7.1,17.6   v2.5l2.5,3.2h0.9l4.8-3l0.7-1.1l1.6,0.7l-0.2,5.3l2.7,12.6l3,2.5l0.9,0.7l1.8,2.3l-0.5,3.4l0.7,3.4l1.1,0.9l2.3-2.3h2.7l3.2,1.6   l2.5-0.9h4.1l3.7,1.6l2.7-0.5l0.5-3l3-0.7l1.4,1.4l0.5,3.2l1.8,1.4l1.5-11.6l20.7,3l28.2,4l16.6,1.9l31.4,3.5l11,1.5l1.1-15.4   L530.7,222.3z"/>
            <path id="ID" data-info="Idaho" d="M336.1,281c-22.6-4.3-14.1-2.8-21.1-4.4l4.4-17.5l4.3-17.7l1.4-4.2l2.5-5.9l-1.3-2.3l-2.5,0.1   l-0.8-1l0.5-1.1l0.3-3.1l4.5-5.5l1.8-0.5l1.1-1.1l0.6-3.2l0.9-0.7l3.9-5.8l3.9-4.3l0.2-3.8l-3.4-2.6l-1.3-4.4l0.4-9.7l3.7-16.5   l4.5-20.8l3.8-13.5l0.8-3.8l13,2.5l-4.2,21.5l2.9,7.7l-1.1,4.6l2,4.6l3.2,1.7l4.5,9.8l2.7,3.8l0.6,1.1l3.4,1.1l0.5,2.5l-6.9,16.8   l0.3,3.3l2.7,2.9l1.9,0.5l4.8-3.6l0.4-0.5l0.2,0.8l0.3,4.1l2.6,12.9l3.5,2.7l0.4,0.8l2.1,2.4l-0.8,2.8l0.7,3.8l1.9,0.9l2.1-1.6   l2.6-0.5l3.4,1.6l2.5-0.6l3.8-0.2l4,1.6l2.7-0.3l0.9-2.3l2.5-1.6l0.7,1.7l0.6,2.2l2.3,2.5l-3.8,24l-5.1,29l-4.2-0.3l-8.2-1.5   l-9.8-1.8l-12.2-2.4l-12.5-2.5l-8.5-1.8l-9.3-1.7L336.1,281z"/>
            <path id="WA" data-info="Washington" d="M267.6,106.4l4.4,1.5l9.7,2.7l8.6,1.9l20,5.7l23,5.7l15.2,3.4l-1,3.9l-4.1,13.8l-4.5,20.8   l-3.2,16.1l-0.4,9.4l-13.2-3.9l-15.6-3.4l-13.7,0.6l-1.6-1.5l-5.3,1.9l-4-0.3l-2.7-1.8l-1.6,0.5l-4.2-0.2l-1.9-1.4l-4.8-1.7   l-1.4-0.2l-5-1.3l-1.8,1.5l-5.7-0.3l-4.8-3.8l0.2-0.8l0.1-7.9l-2.1-3.9l-4.1-0.7l-0.4-2.4l-2.5-0.6l-2.9-0.5l-1.8,1l-2.3-2.9   l0.3-2.9l2.7-0.3l1.6-4l-2.6-1.1l0.2-3.7l4.4-0.6l-2.7-2.7l-1.5-7.1l0.6-2.9v-7.9l-1.8-3.2l2.3-9.4l2.1,0.5l2.4,2.9l2.7,2.6   l3.2,1.9l4.5,2.1l3.1,0.6l2.9,1.5l3.4,1l2.3-0.2v-2.4l1.3-1.1l2.1-1.3l0.3,1.1l0.3,1.8l-2.3,0.5l-0.3,2.1l1.8,1.5l1.1,2.4l0.6,1.9   l1.5-0.2l0.2-1.3l-1-1.3l-0.5-3.2l0.8-1.8l-0.6-1.5V119l1.8-3.6l-1.1-2.6l-2.4-4.8l0.3-0.8L267.6,106.4z M258.1,112.3l2-0.2   l0.5,1.4l1.5-1.6h2.3l0.8,1.5l-1.5,1.7l0.6,0.8l-0.7,2l-1.4,0.4c0,0-0.9,0.1-0.9-0.2s1.5-2.6,1.5-2.6l-1.7-0.6l-0.3,1.5l-0.7,0.6   l-1.5-2.3L258.1,112.3z"/>
            <path id="TX" data-info="Texas" d="M531.1,433.4l22.7,1.1l31.1,1.1l-2.3,23.5l-0.3,18.2l0.1,2.1l4.3,3.8l1.7,0.8l1.8,0.3l0.7-1.3   l0.9,0.9l1.7,0.5l1.6-0.7l1.1,0.4l-0.3,3.4l4.3,1l2.7,0.8l4,0.5l2.2,1.8l3.2-1.6l2.8,0.4l2,2.8l1.1,0.3l-0.2,2l3.1,1.2l2.8-1.8   l1.5,0.4l2.4,0.2l0.4,1.9l4.6,2l2.7-0.2l2-4.1h0.3l1.1,1.9l4.4,1l3.3,1.2l3.3,0.8l2.1-0.8l0.8-2.5h3.7l1.9,0.8l3.1-1.6h0.7l0.4,1.1   h4.3l2.4-1.3l1.7,0.3l1.4,1.9l2.9,1.7l3.5,1.1l2.7,1.4l2.4,1.6l3.3-0.9l1.9,1l0.5,10.1l0.3,9.7l0.7,9.5l0.5,4l2.7,4.6l1.1,4.1   l3.9,6.3l0.5,2.9l0.5,1l-0.7,7.5l-2.7,4.4l1,2.9l-0.4,2.5l-0.8,7.3l-1.4,2.7l0.6,4.4l-5.7,1.6l-9.9,4.5l-1,1.9l-2.6,1.9l-2.1,1.5   l-1.3,0.8l-5.7,5.3l-2.7,2.1l-5.3,3.2l-5.7,2.4l-6.3,3.4l-1.8,1.5l-5.8,3.6l-3.4,0.6l-3.9,5.5l-4,0.3l-1,1.9l2.3,1.9l-1.5,5.5   l-1.3,4.5l-1.1,3.9l-0.8,4.5l0.8,2.4l1.8,7l1,6.1l1.8,2.7l-1,1.5l-3.1,1.9l-5.7-3.9l-5.5-1.1l-1.3,0.5l-3.2-0.6l-4.2-3.1l-5.2-1.1   l-7.6-3.4l-2.1-3.9l-1.3-6.5l-3.2-1.9l-0.6-2.3l0.6-0.6l0.3-3.4l-1.3-0.6l-0.6-1l1.3-4.4l-1.6-2.3l-3.2-1.3l-3.4-4.4l-3.6-6.6   l-4.2-2.6l0.2-1.9l-5.3-12.3l-0.8-4.2l-1.8-1.9l-0.2-1.5l-6-5.3l-2.6-3.1v-1.1l-2.6-2.1l-6.8-1.1l-7.4-0.6l-3.1-2.3l-4.5,1.8   l-3.6,1.5l-2.3,3.2l-1,3.7l-4.4,6.1l-2.4,2.4l-2.6-1l-1.8-1.1l-1.9-0.6l-3.9-2.3v-0.6l-1.8-1.9l-5.2-2.1l-7.4-7.8l-2.3-4.7v-8.1   l-3.2-6.5l-0.5-2.7l-1.6-1l-1.1-2.1l-5-2.1l-1.3-1.6l-7.1-7.9l-1.3-3.2l-4.7-2.3l-1.5-4.4l-2.6-2.9l-1.9-0.5l-0.6-4.7l8,0.7l29,2.7   l29,1.6l2.3-23.8l3.9-55.6l1.6-18.7l1.4,0 M631.2,667.3l-0.6-7.1l-2.7-7.2l-0.6-7l1.5-8.2l3.3-6.9l3.5-5.4l3.2-3.6l0.6,0.2   l-4.8,6.6l-4.4,6.5l-2,6.6l-0.3,5.2l0.9,6.1l2.6,7.2l0.5,5.2l0.2,1.5L631.2,667.3z"/>
            <path id="CA" data-info="California" d="M310.7,486.8l3.8-0.5l1.5-2l0.7-1.9l-3.2-0.1l-1.1-1.8l0.8-1.7l0-6.2l2.2-1.3l2.7-2.6l0.4-4.9   l1.6-3.5l1.9-2.1l3.3-1.7l1.3-0.7l0.8-1.5l-0.9-0.9l-1-1.5l-0.9-5.3l-2.9-5.2l0.1-2.8l-2.2-3.2l-15-23.2l-19.4-28.7l-22.4-33   l-12.7-19.5l1.8-7.2l6.8-25.9l8.1-31.4l-12.4-3.3l-13.5-3.4l-12.6-4.1l-7.5-2.1l-11.4-3l-7.1-2.4l-1.6,4.7l-0.2,7.4l-5.2,11.8   l-3.1,2.6l-0.3,1.1l-1.8,0.8l-1.5,4.2l-0.8,3.2l2.7,4.2l1.6,4.2l1.1,3.6l-0.3,6.5l-1.8,3.1l-0.6,5.8l-1,3.7l1.8,3.9l2.7,4.5   l2.3,4.8l1.3,4l-0.3,3.2l-0.3,0.5v2.1l5.7,6.3l-0.5,2.4l-0.6,2.3l-0.6,1.9l0.2,8.2l2.1,3.7l1.9,2.6l2.7,0.5l1,2.7l-1.1,3.6   l-2.1,1.6h-1.1l-0.8,3.9l0.5,2.9l3.2,4.4l1.6,5.3l1.5,4.7l1.3,3.1l3.4,5.8l1.5,2.6l0.5,2.9l1.6,1v2.4l-0.8,1.9l-1.8,7.1l-0.5,1.9   l2.4,2.7l4.2,0.5l4.5,1.8l3.9,2.1h2.9l2.9,3.1l2.6,4.8l1.1,2.3l3.9,2.1l4.8,0.8l1.5,2.1l0.6,3.2l-1.5,0.6l0.3,1l3.2,0.8l2.7,0.2   l2.9,4.7l3.9,4.2l0.8,2.3l2.6,4.2l0.3,3.2v9.4l0.5,1.8l10,1.5l19.7,2.7L310.7,486.8z M222.8,437l1.3,1.5l-0.2,1.3l-3.2-0.1   l-0.6-1.2l-0.6-1.5L222.8,437z M224.7,437l1.2-0.6l3.6,2.1l3.1,1.2l-0.9,0.6l-4.5-0.2l-1.6-1.6L224.7,437z M245.4,456.8l1.8,2.3   l0.8,1l1.5,0.6l0.6-1.5l-1-1.8l-2.7-2l-1.1,0.2V456.8z M244,465.5l1.8,3.2l1.2,1.9l-1.5,0.2l-1.3-1.2c0,0-0.7-1.5-0.7-1.9   s0-2.2,0-2.2L244,465.5z"/>
            <path id="AZ" data-info="Arizona" d="M311.7,487.5l-2.6,2.2l-0.3,1.5l0.5,1l18.9,10.7l12.1,7.6l14.7,8.6l16.8,10l12.3,2.4l25.1,2.7   l2.5-12.5l3.8-27.2l7-52.9l4.3-31l-24.6-3.7l-27.2-4.6l-33.4-6.3l-2.9,18.1l-0.5,0.5l-1.7,2.6l-2.5-0.1l-1.3-2.7l-2.7-0.3l-0.9-1.1   h-0.9l-0.9,0.6l-1.9,1l-0.1,7l-0.2,1.7l-0.6,12.6l-1.5,2.2l-0.6,3.3l2.7,4.9l1.3,5.8l0.8,1l1,0.6l-0.1,2.3l-1.6,1.4l-3.4,1.7   l-1.9,1.9l-1.5,3.7l-0.6,4.9l-2.9,2.7l-2.1,0.7l-0.1,5.8l-0.5,1.7l0.5,0.8l3.7,0.6l-0.6,2.7l-1.5,2.2L311.7,487.5z"/>
            <path id="NV" data-info="Nevada" d="M314.7,277.6l21,4.5l9.7,1.9l9.3,1.8l6.6,1.6l-0.6,5.9l-3.5,17.3l-4.1,20l-1.9,9.7l-2.2,13.3   l-3.2,16.4l-3.5,15.7l-2,10.2l-2.5,16.8l-0.5,1.1l-1.1,2.5l-1.9-0.1l-1.1-2.7l-2.7-0.5l-1.4-1l-2,0.3l-0.9,0.7l-1.3,1.3l-0.4,7   l-0.5,1.7l-0.4,12.1l-1.3,1.7l-1.9-2.3l-14.5-22.7l-19.4-29L263.6,349l-12.4-18.6l1.6-6.6l7-25.9l7.9-31.3l33.6,8.1l13.7,3"/>
            <path id="UT" data-info="Utah" d="M427,409.3l-24.6-3.5l-26.6-4.9l-33.8-6l1.6-9.2l3.2-15.2L350,354l2.2-13.6l1.9-8.9l3.8-20.5   l3.5-17.5l1.1-5.6l12.7,2.3l12,2.1l10.3,1.8l8.3,1.4l3.7,0.5l-1.5,10.6l-2.3,13.2l7.8,0.9l16.4,1.8l8.2,0.9l-2.1,22l-3.2,22.6   l-3.8,27.8l-1.7,11.1L427,409.3z"/>
            <path id="CO" data-info="Colorado" d="M552.6,356.8l1.4-21.3l-32.1-3.1l-24.5-2.7l-37.3-4.1l-20.7-2.5l-2.6,22.2l-3.2,22.4l-3.8,28   l-1.5,11.1l-0.3,2.8l33.9,3.8l37.7,4.3l32,3.2l16.6,0.8"/>
            <path id="NM" data-info="New Mexico" d="M456.7,531l-0.7-6.1l8.6,0.5l29.5,3.1l28.4,1.4l2-22.3l3.7-55.9l1.1-19.4l2,0.3l0-11.1l-32.2-2.4   l-36.9-4.4l-34.5-4.1l-4.2,30.8l-7,53.2l-3.8,26.9l-2,13.3l15.5,2l1.3-10l16.7,2.6L456.7,531z"/>
            <path id="OR" data-info="Oregon" d="M314.3,276.7l4.3-17.9l4.7-17.9l1.1-4.2l2.4-5.6l-0.6-1.2l-2.5,0l-1.3-1.7l0.5-1.5l0.5-3.2l4.5-5.5   l1.8-1.1l1.1-1.1l1.5-3.6l4-5.7l3.6-3.9l0.2-3.5l-3.3-2.5l-1.2-4.5l-13.2-3.7l-15.1-3.5l-15.4,0.1l-0.5-1.4l-5.5,2.1l-4.5-0.6   l-2.4-1.6l-1.3,0.7L273,184l-1.7-1.4l-5.3-2.1l-0.8,0.1l-4.3-1.5l-1.9,1.8l-6.2-0.3l-5.9-4.1l0.7-0.8l0.2-7.8l-2.3-3.9l-4.1-0.6   l-0.7-2.5l-2.4-0.5l-5.8,2.1l-2.3,6.5l-3.2,10l-3.2,6.5l-5,14.1l-6.5,13.6l-8.1,12.6l-1.9,2.9l-0.8,8.6l-1.3,6l2.7,3.5l6.7,2.3   l11.6,3.3l7.9,2.5l12.4,3.6l13.3,3.6l13.2,3.6"/>
            <path id="ND" data-info="North Dakota" d="M645.3,227.7l-0.4-7.5l-2-7.3l-1.8-13.6l-0.5-9.8l-2-3.1l-1.6-5.4v-10.3l0.7-3.9l-2.1-5.5   l-28.4-0.6l-18.6-0.6l-26.5-1.3l-24.9-1.9l-1.3,14.2l-1.4,15.1l-2.3,24.9l-0.5,11l56.8,3.8L645.3,227.7z"/>
            <path id="SD" data-info="South Dakota" d="M646.8,303.2l-1-1.1l-1.5-3.6l1.8-3.7l1.1-5.6l-2.6-2.1l-0.3-2.7l0.6-3l2.2-0.8l0.3-5.7l-0.1-30.1   l-0.6-3l-4.1-3.6l-1-2v-1.9l1.9-1.3l1.5-1.9l0.2-2.7l-57.4-1.6l-56.2-3.9l-0.8,5.3l-1.6,15.9l-1.3,17.9l-1.6,24.6l16,1l19.6,1.1   l18,1.3l23.8,1.3l10.7-0.8l2.9,2.3l4.3,3l1,0.8l3.5-0.9l4-0.3l2.7-0.1l3.1,1.2l4.5,1.4l3.1,1.8l0.6,1.9l0.9,1.9l0.7-0.5   L646.8,303.2z"/>
            <path id="NE" data-info="Nebraska" d="M658.2,347l1.4,2.7l0.1,2.1l2.4,3.7l2.7,3.2h-5l-43.5-0.9l-40.8-0.9l-21.2-1l1.1-21.3l-33.4-2.7   l4.3-44l15.5,1L562,290l17.8,1.1l23.8,1.1l10.7-0.5l2.1,2.3l4.8,3l1.1,0.9l4.3-1.4l3.9-0.5l2.7-0.2l1.8,1.4l5,1.6l3,1.6l0.5,1.6   l0.9,2.1h1.8l0.8,0l1,5.2l2.7,8l1.2,4.6l2.1,3.8l0.5,4.9l1.4,4.3l0.5,6.5"/>
            <path id="IA" data-info="Iowa" d="M740.6,301.6l0.2,1.9l2.3,1.1l1.1,1.3l0.3,1.3l3.9,3.2l0.7,2.2l-0.8,2.9l-1.5,3.5l-0.8,2.7   l-2.2,1.6l-1.7,0.6l-5.5,1.5l-0.7,2.3l-0.8,2.3l0.6,1.4l1.7,1.7l0,3.7l-2.2,1.6l-0.5,1.5v2.5l-1.5,0.5l-1.7,1.4l-0.5,1.5l0.5,1.7   l-1.4,1.2l-2.3-2.7l-1.5-2.6l-8.3,0.8l-10.2,0.6l-25,0.7l-13,0.2l-9.4,0.2l-1.3,0.1l-1.7-4.5l-0.2-6.6l-1.6-4.1l-0.7-5.3l-2.3-3.7   l-0.9-4.8l-2.7-7.5l-1.1-5.4l-1.4-2.2l-1.6-2.7l1.8-4.3l1.4-5.7l-2.7-2.1l-0.5-2.7l0.9-2.5h1.7h11.5l49.6-0.7l19.9-0.7l1.9,2.7   l1.8,2.6l0.5,0.8l-1.8,2.7l0.5,4.2l2.5,3.9l3,1.8l2.4,0.2L740.6,301.6z"/>
            <path id="MS" data-info="Mississippi" d="M798.6,567l-0.3,1.3h-5.2l-1.5-0.8l-2.1-0.3l-6.8,1.9l-1.8-0.8l-2.6,4.2l-1.1,0.8l-1.1-2.5   l-1.1-3.9l-3.4-3.2l1.1-7.5l-0.7-0.9l-1.8,0.2l-8.2,0.7l-24.2,0.7l-0.5-1.6l0.7-8l3.4-6.2l5.3-9.1l-0.9-2.1h1.1l0.7-3.2l-2.3-1.8   l0.2-1.8l-2.1-4.6l-0.3-5.3l1.4-2.7l-0.4-4.3l-1.4-3l1.4-1.4l-1.4-2.1l0.5-1.8l0.9-6.2l3-2.7l-0.7-2.1l3.7-5.3l2.7-0.9v-2.5   l-0.7-1.4l2.7-5.3l2.7-1.1l0.1-3.4l8.7-0.1l24.1-1.9l4.6-0.2l0,6.4l0.2,16.7l-0.8,31l-0.2,14.1l2.7,18.8L798.6,567z"/>
            <path id="IN" data-info="Indiana" d="M792.4,400.9l0.1-2.9l0.5-4.5l2.3-2.9l1.8-3.9l2.6-4.2l-0.5-5.8l-1.8-2.7l-0.3-3.2l0.8-5.5l-0.5-7   l-1.3-16l-1.3-15.4l-1-11.7l3.1,0.9l1.5,1l1.1-0.3l2.1-1.9l2.8-1.6l5.1-0.2l22-2.3l5.6-0.5l1.5,16l4.3,36.8l0.6,5.8L843,371   l1.2,1.8l0.1,1.4l-2.5,1.6l-3.5,1.6l-3.2,0.6l-0.6,4.9l-4.6,3.3l-2.8,4l0.3,2.4l-0.6,1.5h-3.3l-1.6-1.6l-2.5,1.3l-2.7,1.5l0.2,3.1   l-1.2,0.3l-0.5-1l-2.2-1.5l-3.3,1.3l-1.6,3l-1.4-0.8l-1.5-1.6l-4.5,0.5l-5.6,1L792.4,400.9z"/>
            <path id="IL" data-info="Illinois" d="M791.8,401.6V398l0.3-4.9l2.4-3.1l1.8-3.8l2.6-3.9l-0.4-5.3l-2-3.5l-0.1-3.3l0.7-5.3l-0.8-7.2   l-1.1-15.8l-1.3-15l-0.9-11.6l-0.3-0.9l-0.8-2.6l-1.3-3.7l-1.6-1.8l-1.5-2.6l-0.2-5.5l-9.9,1.3l-27.2,1.7l-8.7-0.4l0.2,2.4l2.3,0.7   l0.9,1.1l0.5,1.8l3.9,3.4l0.7,2.3l-0.7,3.4l-1.8,3.7l-0.7,2.5l-2.3,1.8l-1.8,0.7l-5.3,1.4l-0.7,1.8L736,330l0.7,1.4l1.8,1.6   l-0.2,4.1l-1.8,1.6l-0.7,1.6v2.7l-1.8,0.5l-1.6,1.1l-0.2,1.4l0.2,2.1l-1.7,1.3l-1,2.8l0.5,3.7l2.3,7.3l7.3,7.5l5.5,3.7l-0.2,4.3   l0.9,1.4l6.4,0.5l2.7,1.4l-0.7,3.7l-2.3,5.9l-0.7,3.2l2.3,3.9l6.4,5.3l4.6,0.7l2.1,5l2.1,3.2l-0.9,3l1.6,4.1l1.8,2.1l1.9-0.8   l0.7-2.2l2-1.4l3.2-1.1l3.1,1.2l2.9,1.1l0.8-0.2l-0.1-1.2l-1.1-2.8l0.4-2.4l2.3-1.6l2.4-1l1.2-0.4l-0.6-1.3l-0.8-2.2l1.2-1.3   L791.8,401.6z"/>
            <path id="MN" data-info="Minnesota" d="M645.9,228.5l-0.5-8.5l-1.8-7.3l-1.8-13.5l-0.5-9.8l-1.8-3.4l-1.6-5v-10.3l0.7-3.9l-1.8-5.5l30.1,0   l0.3-8.2l0.6-0.2l2.3,0.5l1.9,0.8l0.8,5.5l1.5,6.1l1.6,1.6h4.8l0.3,1.5l6.3,0.3v2.1h4.8l0.3-1.3l1.1-1.1l2.3-0.6l1.3,1h2.9l3.9,2.6   l5.3,2.4l2.4,0.5l0.5-1l1.5-0.5l0.5,2.9l2.6,1.3l0.5-0.5l1.3,0.2v2.1l2.6,1h3.1l1.6-0.8l3.2-3.2l2.6-0.5l0.8,1.8l0.5,1.3h1l1-0.8   l8.9-0.3l1.8,3.1h0.6l0.7-1.1l4.4-0.4l-0.6,2.3l-3.9,1.8l-9.2,4.1l-4.8,2l-3.1,2.6l-2.4,3.6l-2.3,3.9l-1.8,0.8l-4.5,5l-1.3,0.2   l-3.8,2.9l-2.8,3.2l-0.2,3l0.2,7.8l-1.6,1.6L704,228l-1.8,5.7l2.5,3.6l0.5,2.5l-1.1,3l-0.2,3.7l0.5,7.1l3.4,4.1h3l2.5,2.3l3.2,1.4   l3.7,5l7.1,5l1.8,2.1l0.2,5.5l-20.6,0.7l-60.2,0.5l-0.3-35.7l-0.5-3l-4.1-3.4l-1.1-1.8v-1.6l2.1-1.6l1.4-1.4L645.9,228.5z"/>
            <path id="WI" data-info="Wisconsin" d="M786.9,297.2l0.4-3l-1.6-4.5l-0.6-6.1l-1.1-2.4l1-3.1l0.8-2.9l1.5-2.6l-0.6-3.4l-0.6-3.6l0.5-1.8   l1.9-2.4l0.2-2.7l-0.8-1.3l0.6-2.6l0.5-3.2l2.7-5.7l2.9-6.8l0.2-2.3l-0.3-1l-0.8,0.5l-4.2,6.3l-2.7,4l-1.9,1.8l-0.8,2.3l-1.5,0.8   l-1.1,1.9l-1.5-0.3l-0.2-1.8l1.3-2.4l2.1-4.7l1.8-1.6l1.1-2.3l-1.6-0.9l-1.4-1.4l-1.6-10.3l-3.7-1.1l-1.4-2.3l-12.6-2.7l-2.5-1.1   l-8.2-2.3l-8.2-1.1l-4.2-5.4l-0.5,1.3l-1.1-0.2l-0.6-1.1l-2.7-0.8l-1.1,0.2l-1.8,1l-1-0.6l0.6-1.9l1.9-3.1l1.1-1.1l-1.9-1.5   l-2.1,0.8l-2.9,1.9l-7.4,3.2l-2.9,0.6l-2.9-0.5l-1-0.9l-2.1,2.8l-0.2,2.7v8.5l-1.1,1.6l-5.3,3.9l-2.3,5.9l0.5,0.2l2.5,2.1l0.7,3.2   l-1.8,3.2v3.9l0.5,6.6l3,3h3.4l1.8,3.2l3.4,0.5l3.9,5.7l7.1,4.1l2.1,2.7l0.9,7.4l0.7,3.3l2.3,1.6l0.2,1.4l-2.1,3.4l0.2,3.2l2.5,3.9   l2.5,1.1l3,0.5l1.3,1.4l9.2,0l26.1-1.5L786.9,297.2z"/>
            <path id="MO" data-info="Missouri" d="M729.8,349.5l-2.5-3.1l-1.1-2.3l-7.8,0.7l-9.8,0.5l-25.4,0.9l-13.5,0.2l-7.9,0.1l-2.3,0.1l1.3,2.5   l-0.2,2.3l2.5,3.9l3.1,4.1l3.1,2.7l2.3,0.2l1.4,0.9v3l-1.8,1.6l-0.5,2.3l2.1,3.4l2.5,3l2.5,1.8l1.4,11.7l-0.7,35.3l0.2,4.7l0.5,5.4   l23.4-0.1l23.2-0.7l20.8-0.8l11.7-0.2l2.2,3.4l-0.7,3.3l-3.1,2.4l-0.6,1.8l5.4,0.5l3.9-0.7l1.7-5.5l0.7-5.9l2.3-2l1.7-1.5l2.1-1   l0.1-2.9l0.6-1.7l-1-1.7l-2.7,0.1l-2.2-2.6l-1.4-4.2l0.8-2.5l-1.9-3.4l-1.8-4.6l-4.8-0.8l-7-5.6l-1.7-4.1l0.8-3.2l2.1-6.1l0.5-2.9   l-1.9-1l-6.9-0.8l-1-1.7l-0.1-4.2l-5.5-3.4l-7-7.8l-2.3-7.3l-0.2-4.2L729.8,349.5z"/>
            <path id="AR" data-info="Arkansas" d="M765,445l-3.8,0.9l-6.2-0.5l0.7-3l3.2-2.7l0.5-2.3l-1.8-3l-11,0.5l-20.8,0.9l-23.3,0.7L679,437   l1.6,6.9v8.2l1.4,11l0.2,37.8l2.3,1.9l3-1.4l2.7,1.1l0.4,10.3l22.9-0.1l18.9-0.8l10.1-0.2l1.1-2.1l-0.3-3.5l-1.8-3l1.6-1.5   l-1.6-2.5l0.7-2.5l1.4-5.6l2.5-2.1l-0.7-2.3l3.7-5.4l2.7-1.4l-0.1-1.5l-0.3-1.8l2.9-5.6l2.4-1.3l0.4-3.4l1.8-1.2l0.9-4.2l-1.3-4   l4-2.4l0.6-2l1.2-4.3L765,445z"/>
            <path id="OK" data-info="Oklahoma" d="M549.3,422.6l-10.7-0.5l-6.4-0.5l0.3,0.2l-0.7,10.4l22,1.4l32.1,1.3l-2.3,24.4l-0.5,17.8l0.2,1.6   l4.3,3.7l2.1,1.1l0.7-0.2l0.7-2.1l1.4,1.8h2.1v-1.4l2.7,1.4l-0.5,3.9l4.1,0.2l2.5,1.1l4.1,0.7l2.5,1.8l2.3-2.1l3.4,0.7l2.5,3.4h0.9   v2.3l2.3,0.7l2.3-2.3l1.8,0.7h2.5l0.9,2.5l4.8,1.8l1.4-0.7l1.8-4.1h1.1l1.1,2.1l4.1,0.7l3.7,1.4l3,0.9l1.8-0.9l0.7-2.5h4.3l2.1,0.9   l2.7-2.1h1.1l0.7,1.6h4.1l1.6-2.1l1.8,0.5l2.1,2.5l3.2,1.8l3.2,0.9l1.9,1.1l-0.4-37.2l-1.4-11l-0.2-8.9l-1.4-6.5l-0.8-7.2l-0.1-3.8   l-12.1,0.3l-46.4-0.5l-45-2.1L549.3,422.6z"/>
            <path id="KS" data-info="Kansas" d="M677.4,425.1l-12.6,0.2l-46.1-0.5l-44.6-2.1l-24.6-1.3l4.1-64.7l21.8,0.8l40.5,1.4l44.1,0.5h5.1   l3.2,3.2l2.8,0.2l0.9,1.1v2l-1.8,1.6l-0.5,2.6l2.2,3.6l2.5,3.1l2.5,2l1.1,11.2L677.4,425.1z"/>
            <path id="LA" data-info="Louisiana" d="M776.2,573l-1-2.6l-1.1-3.1l-3.3-3.5l0.9-6.8l-0.1-1.1l-1.3,0.3l-8.2,0.9l-25,0.5l-0.7-2.4l0.9-8.5   l3.3-5.9l5-8.7l-0.6-2.4l1.3-0.7l0.5-2l-2.3-2.1l-0.1-1.9l-1.8-4.3l-0.5-5.9l-9.7,0.1l-19.2,0.9l-22.2,0l0,9.6l0.7,9.4l0.7,3.9   l2.5,4.1l0.9,5l4.3,5.5l0.2,3.2l0.7,0.7l-0.7,8.5l-3,5l1.6,2.1l-0.7,2.5l-0.7,7.3l-1.4,3.2l0.1,3.6l4.7-1.5l8.1-0.3l10.3,3.6   l6.5,1.1l3.7-1.5l3.2,1.1l3.2,1l0.8-2.1l-3.2-1.1l-2.6,0.5l-2.7-1.6c0,0,0.2-1.3,0.8-1.5c0.6-0.2,3.1-1,3.1-1l1.8,1.5l1.8-1   l3.2,0.6l1.5,2.4l0.3,2.3l4.5,0.3l1.8,1.8l-0.8,1.6l-1.3,0.8l1.6,1.6l8.4,3.6l3.6-1.3l1-2.4l2.6-0.6l1.8-1.5l1.3,1l0.8,2.9   l-2.3,0.8l0.6,0.6l3.4-1.3l2.3-3.4l0.8-0.5l-2.1-0.3l0.8-1.6l-0.2-1.5l2.1-0.5l1.1-1.3l0.6,0.8c0,0-0.2,3.1,0.6,3.1   c0.8,0,4.2,0.6,4.2,0.6l4,1.9l1,1.5h2.9l1.1,1l2.3-3.1v-1.5h-1.3l-3.4-2.7l-5.8-0.8l-3.2-2.3l1.1-2.7l2.3,0.3l0.2-0.6l-1.8-1v-0.5   h3.2l1.8-3.1l-1.3-1.9l-0.3-2.7l-1.5,0.2l-1.9,2.1l-0.6,2.6l-3.1-0.6l-1-1.8l1.8-1.9l2-1.8L776.2,573z"/>
            <path id="VA" data-info="Virginia" class="sponsored" d="M1002.9,369.2l-0.1-1.9l6.5-2.5l-0.8,3.2l-2.9,3.8l-0.4,4.6l0.5,3.4l-1.8,5l-2.2,1.9l-1.5-4.6   l0.4-5.4l1.6-4.2L1002.9,369.2z M1005.2,397.5L947,410.1l-37.4,5.3l-6.7-0.4l-2.6,1.9l-7.3,0.2l-8.4,1l-8.9,1l8.5-4.9l0-2.1   l1.5-2.1l10.6-11.5l3.9,4.5l3.8,1l2.5-1.1l2.2-1.3l2.5,1.3l3.9-1.4l1.9-4.6l2.6,0.5l2.9-2.1l1.8,0.5l2.8-3.7l0.3-2.1l-1-1.3l1-1.9   l5.3-12.3l0.6-5.7l1.2-0.5l2.2,2.4l3.9-0.3l1.9-7.6l2.8-0.6l1-2.7l2.6-2.3l1.3-2.3l1.5-3.4l0.1-5.1l9.8,3.8   c0.7,0.3,0.7-4.8,0.7-4.8l4.1,1.4l-0.5,2.6l8.2,2.9l1.3,1.8l-0.9,3.7l-1.3,1.3l-0.5,1.7l0.5,2.4l2,1.3l3.9,1.4l2.9,1l4.9,0.9   l2.2,2.1l3.2,0.4l0.9,1.2l-0.4,4.7l1.4,1.1l-0.5,1.9l1.2,0.8l-0.2,1.4l-2.7-0.1l0.1,1.6l2.3,1.5l0.1,1.4l1.8,1.8l0.5,2.5l-2.6,1.4   l1.6,1.5l5.8-1.7L1005.2,397.5z"/>
            </g>
            </svg>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery('.sponsored').click(function (e){
                   var link = jQuery(this).attr('data-info').toLowerCase();
				   var link = link.replace(/ /g,'-');
                   link = "https://rosewellness.com/our-team/?region=" + link;
                   window.location.href = link;
                });
                jQuery(".sponsored").hover(function (e) {
					var location = jQuery(this).data('info');
                    jQuery('#map-info-box-line').css('display', 'block');
                    jQuery('#map-info-box').css('display', 'block');
                    jQuery('#map-info-box').html(location);
                });
                jQuery(".sponsored").mouseleave(function (e) {
                    jQuery('#map-info-box-line').css('display', 'none');
                    jQuery('#map-info-box').css('display', 'none');
                });
                jQuery(document).mousemove(function (e) {
                    var parentOffset = jQuery('.rt-image-map-wrapper').offset();
                    var relX = e.pageX - parentOffset.left;
                    var relY = e.pageY - parentOffset.top;
                    jQuery('#map-info-box-line').css('top', relY - 105);
                    jQuery('#map-info-box-line').css('left', relX + 1);

                    jQuery('#map-info-box').css('top', relY - 106);
                    jQuery('#map-info-box').css('left', relX + 1);
                }).mouseover();
            });
        </script>
        <style type="text/css">
            .rt-image-map {
                text-align: center;
                position: relative;
                margin: 0 auto;
            }
            .rt-image-map svg {
                width: 100%;
                height: 100%;
            }
            .rt-image-map svg path {
                fill: #EBEAE9;
            }
            .rt-image-map svg:last-child path {
                fill: #EBEAE9;
				stroke: #D4D4D4;
            }
            .rt-image-map svg:first-child .sponsored {
                fill: #99c43c;
                cursor: pointer;
            }
            .rt-image-map svg:first-child .sponsored:hover {
                fill: #5ea101 !important;
            }
            #map-info-box {
                display: none; 
                position: absolute;
                top: 0px;
                left: 0px;
                z-index: 1;
                color: #FFF;
                background-color: #ec9a1a;
                padding: 3px 5px;
                text-transform: capitalize;
            }
            #map-info-box-line {
                display: none; 
                position: absolute;
                z-index: 1;
                background-color: #D4D4D4;
                width: 1px;
                height: 100px;
            }
            #map-info-box-line:after {
                width: 6px;
                height: 6px;
                content: " ";
                background: #000;
                border-radius: 50%;
                position: absolute;
                left: -2.5px;
                bottom: 0;
            }
            @media screen and (max-width: 500px){
                #map-info-box, #map-info-box-line{
                    display: none !important;
                }
            }
        </style>
    </div>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}