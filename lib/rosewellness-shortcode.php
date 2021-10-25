<?php

/* Custom Blog Module Shortcode */

/*add_shortcode('blog_cat_shortcode', 'blog_cat_callback');

function blog_cat_callback($atts) {
    ob_start();
    
	// Blog Category
    if(!empty($atts['cat_id'])) {
        $category_id = $atts['cat_id'];
    } else {
        $category_id = 33;
    }
    
    // Category Object
    $category_object = get_category($category_id);
    
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $blog_args = array (
		'posts_per_page' =>  8,
		'paged'	         =>  $paged,
		'post_type'      =>  'post',
		'post_status'    =>  'publish',
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
	            <h2 class="blog-title">Explore Our Blog</h2>
	        <div class="row filter_list">
	            <div class="col-md-6 col-sm-6 col-xs-12 category_dropdown_list">
	                <label>Explore</label>
	                <select name="categories_list" class="categories_list">
	                    <option value="">Select Category</option>
	                    <?php
	                        if( $categories = get_categories() ) {
								foreach( $categories as $category ) {
								    
								    if($category_object->slug == $category->slug) {
								        $selected = 'selected';
								    } else {
								        $selected = '';
								    }
								    
									echo '<option value="'.$category->slug.'" '.$selected.'>'.$category->name.'</option>';
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
    			
    			$the_content = get_the_content($postID);
    			$content_org = wp_trim_words($the_content, 20, '...');
    			
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
    				<a href="<?php echo get_the_permalink($postID); ?>"><h4><?php echo get_the_title($postID); ?></h4></a>
    			</div>
    			<?php
    		}
    		
    		echo '</div></div>';
	}
	
	wp_reset_postdata();
	wp_reset_query();
	
	echo '<div class="blog-pagination">';
		$big = 999999999; 
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $blog_query->max_num_pages
		) );
	echo '</div>';
	
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
} */

add_shortcode('list_cats', 'widget_categories');

function widget_categories() {
    
    // Get Query Object
    $queried_object = get_queried_object();
    $current_term_id = $queried_object->term_id;
    $current_term_name = $queried_object->name;
    
	// Get Blog Categories
	$args = array(
         'child_of' => $current_term_id
    ); 

    $terms = get_terms('category', $args);
	
	echo '<div class="cats_container">';
	if(!empty($terms) && !empty($current_term_id)) {
	    echo '<h2 class="rosewellness-title">Browse by Sub-Category</h2>';
	    echo '<ul class="widget_cats">';
	    foreach($terms as $term) {
	        $parent_cat_array = load_term_array($term->parent);
	        
	        if($current_term_name == $term->name) {
	            echo '<li class="active"><a href="'.site_url().'/'.$parent_cat_array[0]->slug.'/'.$term->slug.'">'.$term->name.'</a></li>';
	        } else {
	            echo '<li><a href="'.site_url().'/'.$parent_cat_array[0]->slug.'/'.$term->slug.'">'.$term->name.'</a></li>';
	        }
	    }
	    
	    echo '<!--div class="cat_load_more"><a class="loadCat" href="javascript:void(0);" data-page="0"> Load More </a></div-->';
	    
	    echo '</ul>';
	} else if($queried_object->taxonomy == 'category') {
	   
    	// Get Blog Categories
    	$args = array(
             'child_of' => $queried_object->category_parent
        ); 
    
        $terms = get_terms('category', $args);
        
        echo '<h2 class="rosewellness-title">Browse by Sub-Category</h2>';
	    echo '<ul class="widget_cats">';
    	    foreach($terms as $term) {
    	        
    	         if($current_term_name == $term->name) {
    	            echo '<li class="active"><a href="'.site_url().'/category/'.$term->slug.'">'.$term->name.'</a></li>';
    	        } else {
    	            echo '<li><a href="'.site_url().'/category/'.$term->slug.'">'.$term->name.'</a></li>';
    	        }
    	    }
	    echo '</ul>';
	}
	
	
	echo '</div>';
	
}


/********** Category Shortcode *********/
add_shortcode('blog_cat_shortcode', 'blog_cat_callback');

function blog_cat_callback($atts) {
    ob_start();
    
    // Blog Category
    if(!empty($atts['cat_id'])) {
        $category_id = $atts['cat_id'];
    } else {
        $category_id = 33;
    }
    
    // Category Name
    $categoryName = get_cat_name($category_id);
    
    // Category Object
    $category_object = get_category($category_id);
    
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $blog_args = array (
		'posts_per_page' =>  9,
		'paged'	         =>  $paged,
		'post_type'      =>  'post',
		'post_status'    =>  'publish',
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
	    
	    <h2 class="title_heading">Latest Blogs</h2>
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
    			    <div class="post_thubmnail">
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
    		
    		echo '<div class="blog_load_more"><a class="loadlBlog" href="javascript:void(0);" data-cat="'.$category_id.'" data-page="0"> Load More </a></div>';
    		
    		echo '</div></div>';
	}
	
	wp_reset_postdata();
	wp_reset_query();
	
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}


/********** Category Shortcode *********/
add_shortcode('blog_tag_shortcode', 'blog_tag_callback');

function blog_tag_callback($atts) {
    ob_start();
    
    // Blog Category
    if(!empty($atts['cat_id'])) {
        $category_id = $atts['cat_id'];
    } else {
        $category_id = 33;
    }
    
    // Category Name
    $categoryName = get_cat_name($category_id);
    
    // Category Object
    $category_object = get_category($category_id);
    
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $blog_args = array (
		'posts_per_page' =>  9,
		'paged'	         =>  $paged,
		'post_type'      =>  'post',
		'post_status'    =>  'publish',
		'orderby' => 'post_date',		
		'order' => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => 'post_tag',
				'field' => 'term_id',
				'terms' => $category_id,
				'operator' => 'IN' 
			)
		)
	);
	
	$blog_query = new WP_Query($blog_args);
	
	if ($blog_query->have_posts()) { ?>
	    
	    <h2 class="title_heading">Latest Blogs</h2>
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
    			    <div class="post_thubmnail">
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
    		
    		echo '<div class="blog_load_more"><a class="loadtBlog" href="javascript:void(0);" data-cat="'.$category_id.'" data-page="0"> Load More </a></div>';
    		
    		echo '</div></div>';
	}
	 
	wp_reset_postdata();
	wp_reset_query();
	
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}


/********* Bim Calculator ***************/

add_shortcode( 'bim', 'bim_cal' );

function bim_cal( $atts ){ ?>

	<div class="bim">
        <div class="tab">
          <button class="tablinks active" onclick="openbmi(event, 'Standard')">Standard</button>
          <button class="tablinks" onclick="openbmi(event, 'Metric')">Metric</button>
        </div>
        <div id="Standard" class="tabcontent" style="display: block;">
         
         <form name="frmBMIEnglish" id="first_form" method="post" action="">
			<table>
			    <div class="vc_row">
			        <div class="vc_col-sm-4 hed">
			            <b>Your Height:</b>
			        </div>
			        <div class="vc_col-sm-4">
			         <input class="stnd" name="txtFeet" id="txtFeet" type="text" size="5" onchange="calcMeters(frmBMIMetric,this.form.txtFeet.value,this.form.txtInches.value)">
    				<p style="text-align: center;"><b>(Feet)</b>
    				<p id="demo"></p>
    				</p>
    				
			        </div>
			        <div class="vc_col-sm-4">
			        <input class="stnd" name="txtInches" id="txtInches" type="text" size="5" onchange="calcMeters(frmBMIMetric,this.form.txtFeet.value,this.form.txtInches.value)">
    				<p style="text-align: center;"><b>(Inches)</b></p>
    				
			        </div>
			    </div>
			    <div class="vc_row">
			        <div class="vc_col-sm-4 hed">
			            <b>Your Weight:</b>
			        </div>
			        <div class="vc_col-sm-8">
			            <input class="stnd" name="txtPounds" id="txtPounds" type="text" size="5" onchange="calcKilograms(frmBMIMetric, this.form.txtPounds.value)">
    				<p style="text-align: center;"><b>(Pounds)</b></p>
			        </div>
			    </div>
			    <div class="vc_row" style="    margin-bottom: 20px;">
			        <div class="vc_col-sm-4">
			           
			        </div>
			        <div class="vc_col-sm-8">
			         <input  name="submit" type="submit" class=" computebmi1" style="width: auto; " value="Compute BMI" onclick="calcEnglish(this.form,this.form.txtFeet.value,this.form.txtInches.value,this.form.txtPounds.value)">

			        </div>
			    </div>
			    <div class="vc_row" style="margin-top: 22px;">
			        <div class="vc_col-sm-4 hed">
			           <b>Your BMI:</b>
			        </div>
			        <div class="vc_col-sm-8">
			         <input name="txtBMI" type="text" size="5" readonly="" class="buttonBGShade bmiresult1">
			        </div>
			    </div>
			   
			</table>
        </form>
        </div>
        <div id="Metric" class="tabcontent">
         
            <form name="bmiForm" id="first_form_two" method="post" action="">
                <table>
                <div class="vc_row">
			        <div class="vc_col-sm-4 hed">
			           <b class="head1">Your Height(cm):</b>
			        </div>
			        <div class="vc_col-sm-8">
			            <input type="text" id="height" name="height" size="5" class="inputf">
			        </div>
			    </div>
			    <div class="vc_row" style=" margin-top: 15px;">
			        <div class="vc_col-sm-4 hed">
			           <b class="head3">Your Weight(kg):</b>
			        </div>
			        <div class="vc_col-sm-8">
			           <input type="text" id="weight" name="weight" size="5"  class="inputf">
			        </div>
			    </div>
			    <div class="vc_row">
			        <div class="vc_col-sm-4">
			          
			        </div>
			        <div class="vc_col-sm-8">
			             <input type="submit"  value="Compute BMI" onClick="calculateBmi()" style="margin-top: 20px;margin-bottom: 13px;" class="btn computebmi2">
			        </div>
			    </div>
			    <div class="vc_row">
			        <div class="vc_col-sm-4 hed">
			           <b class="head2">Your BMI:</b>
			        </div>
			        <div class="vc_col-sm-8">
			             <input type="text" name="bmi" size="5" class="inputf bmiresult2">
			        </div>
			    </div>
                
                </table>
            </form> 
        </div>

</div>
    
<? }

/********** Back to Shortcode *********/

add_shortcode('back_to_page', 'back_to_callback');

function back_to_callback($atts) {
    ob_start();
    
    // Get Query Object 
    $queried_object = get_queried_object();
    $current_term_id = $queried_object->term_id;
    $current_term_parent = $queried_object->parent;
    
    // Get Current Parent Cat data
    $current_parent_term_array = get_term_by('term_id', $current_term_parent, 'category');
    
    if($current_term_parent != 0) {
        $parent_category_url = site_url().'/category/'.$current_parent_term_array->slug;
        echo '<a href="'.$parent_category_url.'" class="back-to-cat-btn"><i class="fa fa-chevron-left"></i>Back to '.$current_parent_term_array->name.'</a>';
    } else if(($current_term_parent == 0) && ($queried_object->post_type != 'page')){
        echo '<a href="https://www.rosewellness.com/blog/" class="back-to-cat-btn"><i class="fa fa-chevron-left"></i>Back to Blogs</a>';
    } else if($queried_object->post_type == 'page') {
        echo '';
    }
	
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

/********** Bim Popup Shortcode *********/
add_shortcode( 'custom_bim_popup', 'custom_bim_popup' );

function custom_bim_popup(){

    ?>
    <style>

        #mycustommodal {
          display: none; 
          position: fixed;
          z-index: 1111; 
          padding-top: 100px; 
          left: 0;
          top: 0;
          width: 100%; 
          height: 100%; 
          overflow: auto;
          background-color: rgb(0,0,0);
          background-color: rgba(0,0,0,0.4); 
        }
        
        #mycustommodal #custommodal-content{
          background-color: #fefefe;
          margin: auto;
          padding: 20px;
          border: 1px solid #888;
          width: 60%;
        }
        
        #mycustommodal #close {
          color: #aaaaaa;
          float: right;
          font-size: 28px;
          font-weight: bold;
        }
        
        #mycustommodal #close:hover,
        #mycustommodal #close:focus {
          color: #000;
          text-decoration: none;
          cursor: pointer;
        }
        .custom-greentik ul li::before{
            content: '\f00c';
            font-family: 'FontAwesome';
            position: absolute;
            top: 0;
            left: 0;
            color: #5da100;
            font-size: 2rem;
            margin-right: 10px;
            font-weight: 700;
            -webkit-text-stroke: 1px #fff;
        }
        .custom-greentik ul li{
            color: #774c2a;
            font-size: 18px;
            padding-left: 30px;
            position: relative;
            margin-bottom: 5px;
        }
        .customgreenbtn a{
            font-family: 'Muli',sans-serif;
            border: 1px solid #5ca300;
            border-radius: 25px;
            line-height: 35px ;
            font-size: 16px ;
            color: #fff;
            background-color: #5ca300;
            text-align: center ;
            padding: 0px 30px ;
            float:right;
        }
        .customgreenbtn a:hover{
            background-color: #FFFFFF;
            border: 1px solid #5ca300;
            color:#5ca300;
        }
    </style>
    
    
    <div id="mycustommodal" class="modal custommodal">
    
      <div id="custommodal-content">
        <span id="close">&times;</span>
            
<!--            normalrange-->
        <div id="" class="row normalrange">
            <div class="col-sm-12">
                <h3 style="color: #63b50c;text-align: left">Congratulations !!</h3>
                <p>Your BMI score is <span class="pbmiscore" style="font-weight: bold;">(Display BMI Score)</span></p>
                <p>Your BMI is in a normal/healthy range for your height <span class="pheight" style="font-weight: bold;">(Display Entered HEIGHT)</span> and weight <span class="pweight" style="font-weight: bold;">(Display Entered WEIGHT)</span>. You are most likely within the recommended weight range for someone of your height, age, and build and consequently are at a lower risk of developing chronic illnesses.</p>
                <p>To ensure that you remain at a healthy weight, continue to eat a well-balanced diet that includes plenty of fresh vegetables and fruits, healthy fats, whole grains, low fat dairy products, nuts, beans, eggs, fish, poultry, and lean meat. In addition to a healthy diet, get at least 30 minutes of moderate intensity exercise at least five days a week. For best results, also include strength training exercise at least two days a week.</p>
                <img width="100%" src="<?php echo site_url().'/wp-content/uploads/2021/02/bmi-banner-image.jpg'; ?>"/>
            </div>
        </div>
                
<!--            overweight-->   
        <div id="" class="row overweight">
        	<div class="col-sm-12">
				<p>Your BMI score is <span class="pbmiscore" style="font-weight: bold;">(Display BMI Score)</span></p>
				<p>Your BMI is in an Overweight range for your height <span class="pheight" style="font-weight: bold;">(Display Entered HEIGHT)</span> and weight <span class="pweight" style="font-weight: bold;">(Display Entered WEIGHT)</span>.</p>
        		<img style="margin-bottom:10px;" src="<?php echo site_url().'/wp-content/uploads/2021/02/Overweight.jpg'; ?>" width="100%" />	
                <p>Typically, those with a higher BMI have more body fatness. Being overweight, you are at an increased risk of a number of health conditions and diseases, including:</p>                        		
            	<div class="row custom-greentik">
            	    <div class="col-sm-6">
            	        <ul>
            	            <li>Anxiety</li>
            	            <li>Breathing problems</li>
            	            <li>Breast Cancer</li>
            	            <li>Breathing problems</li>
            	            <li>Chronic inflammation</li>
            	            <li>Colon cancer</li>
            	            <li>Coronary heart disease</li>
            	            <li>Depression</li>
            	            <li>Endometrial cancer</li>
            	            <li>Gallbladder cancer</li>
            	            <li>Gallbladder disease</li>
            	       </ul>
            	    </div>    
                    <div class="col-sm-6">
            	        <ul>
            	            <li>Hypertension</li>
            	            <li>Increased bad cholesterol levels</li>
            	            <li>Increased triglycerides</li>
            	            <li>Kidney cancer</li>
            	            <li>Liver cancer</li>
            	            <li>Osteoarthritis</li>
            	            <li>Oxidative stress</li>
            	            <li>Pain</li>
            	            <li>Sleep apnea</li>
            	            <li>Stroke</li>
            	            <li>Type 2 diabetes</li>
            	       </ul>
            	    </div>
            	</div>
            	<p>It is advisable you speak with your <strong><a href="<?php echo site_url().'/functional-medicine-physician/'; ?>">integrative healthcare provider</a></strong> about the best weight loss approach for your unique health, dietary needs, and physical activity levels. Our <strong><a href="<?php echo site_url().'/health-coaching/'; ?>">health coach</a></strong> can work with you to set actionable and realistic goals and help you get started on your journey to optimum health.</p>
            	<img width="100%" src="<?php echo site_url().'/wp-content/uploads/2021/02/bmi-banner-image.jpg'; ?>" style="margin-bottom:10px;"/>
            	<p>For healthy and sustainable weight loss, you may need a combination of increased physical activity and calorie restriction. When substantial weight loss is necessary to reduce the risk of serious illness or death, significant lifestyle changes must be embraced. This includes some stress management techniques like <a href="<?php echo site_url().'/benefits-of-yoga/'; ?>">yoga</a>, tai chi, meditation, deep breathing exercises, and guided imagery.</p>
            	<p>Exercise is essential when it comes to weight loss. As with any activity, you should begin slowly and work your way up to more challenging fitness routines. Experts typically recommend <a href="https://www.webmd.com/fitness-exercise/top-exercises-belly-fat#1">low impact cardio exercises</a> like walking or swimming. In addition to aerobic exercises, try to incorporate strength training exercises into your workout routine.</p>
            	<p>Having an elevated BMI increases your risk of illness and disease. Reducing your weight through diet and exercise decreases your risk of disease. In addition to this, reducing your overall weight increases your energy levels. As your energy levels increase, you will be able to perform more exercise, which will further improve your weight loss efforts, and as you begin to lose weight, you will feel better about yourself and your self-esteem will begin to improve</p>
            	<div class="row">
            	    <div class="col-sm-12 customgreenbtn" >
                        <a href="<?php echo site_url().'/contact-us/'; ?>" title="">Ready to Get Started</a>
            	    </div>
            	</div>
            </div>
        </div>    
 <!--obeserange--> 
        
        <div id="" class="row obeserange">
        	<div class="col-sm-12">
				<p>Your BMI score is <span class="pbmiscore" style="font-weight: bold;">(Display BMI Score)</span></p>
				<p>Your BMI is in a Obese range for your height <span class="pheight" style="font-weight: bold;">(Display Entered HEIGHT)</span> and weight <span class="pweight" style="font-weight: bold;">(Display Entered WEIGHT)</span>.</p>
        		<img style="margin-bottom:10px;" src="<?php echo site_url().'/wp-content/uploads/2021/02/Overweight.jpg'; ?>" width="100%" />	
                <p>Typically, those with a higher BMI have more body fatness. Being obese, you are at an increased risk of a number of health conditions and diseases, including:</p>
        	    <div class="row custom-greentik">
            	    <div class="col-sm-6">
            	        <ul>
            	            <li>Anxiety</li>
            	            <li>Breathing problems</li>
            	            <li>Breast Cancer</li>
            	            <li>Breathing problems</li>
            	            <li>Chronic inflammation</li>
            	            <li>Colon cancer</li>
            	            <li>Coronary heart disease</li>
            	            <li>Depression</li>
            	            <li>Endometrial cancer</li>
            	            <li>Gallbladder cancer</li>
            	            <li>Gallbladder disease</li>
            	       </ul>
            	    </div>    
                    <div class="col-sm-6">
            	        <ul>
            	            <li>Hypertension</li>
            	            <li>Increased bad cholesterol levels</li>
            	            <li>Increased triglycerides</li>
            	            <li>Kidney cancer</li>
            	            <li>Liver cancer</li>
            	            <li>Osteoarthritis</li>
            	            <li>Oxidative stress</li>
            	            <li>Pain</li>
            	            <li>Sleep apnea</li>
            	            <li>Stroke</li>
            	            <li>Type 2 diabetes</li>
            	       </ul>
            	    </div>
                </div>
        	    <p>It is advisable you speak with your <strong><a href="<?php echo site_url().'/functional-medicine-physician/'; ?>">integrative healthcare provider</a></strong> about the best weight loss approach for your unique health, dietary needs, and physical activity levels. Our <strong><a href="<?php echo site_url().'/health-coaching/'; ?>">health coach</a></strong> can work with you to set actionable and realistic goals and help you get started on your journey to optimum health.</p>
        	    <img width="100%" src="<?php echo site_url().'/wp-content/uploads/2021/02/bmi-banner-image.jpg'; ?>" style="margin-bottom:10px;"/>
        	    <p>For healthy and sustainable weight loss, you may need a combination of increased physical activity and calorie restriction. When substantial weight loss is necessary to reduce the risk of serious illness or death, significant lifestyle changes must be embraced. This includes some stress management techniques like <a href="<?php echo site_url().'/benefits-of-yoga/'; ?>">yoga</a>, tai chi, meditation, deep breathing exercises, and guided imagery.</p>
        	    <p>Exercise is essential when it comes to weight loss. As with any activity, you should begin slowly and work your way up to more challenging fitness routines. Experts typically recommend <a href="https://www.webmd.com/fitness-exercise/top-exercises-belly-fat#1">low impact cardio exercises</a> like walking or swimming. In addition to aerobic exercises, try to incorporate strength training exercises into your workout routine.</p>
        	    <p>Having an elevated BMI increases your risk of illness and disease. Reducing your weight through diet and exercise decreases your risk of disease. In addition to this, reducing your overall weight increases your energy levels. As your energy levels increase, you will be able to perform more exercise, which will further improve your weight loss efforts, and as you begin to lose weight, you will feel better about yourself and your self-esteem will begin to improve.</p>
        	    <div class="row">
            	    <div class="col-sm-12 customgreenbtn" >
                        <a href="<?php echo site_url().'/contact-us/';?>" title="">Ready to Get Started</a>
            	    </div>
            	</div>
            </div>    
        </div>        	    
<!-- underweight-->    
        <div id="" class="row underweight">
            <div class="col-sm-12">
                <p>Your BMI score is <span class="pbmiscore" style="font-weight: bold;">(Display BMI Score)</span></p>
                <p>Your BMI is in a Underweight range for your height <span class="pheight" style="font-weight: bold;">(Display Entered HEIGHT)</span> and weight <span class="pweight" style="font-weight: bold;">(Display Entered WEIGHT)</span>.</p>
                <img width="100%" src="<?php echo site_url().'/wp-content/uploads/2021/02/Underweight.jpg'; ?>" style="margin-bottom:10px;"/>
                <p>If is advisable you speak with your <strong><a href="<?php echo site_url().'/functional-medicine-physician/'; ?>">integrative healthcare provider</a></strong> about managing your weight for your unique health, dietary needs, and physical activity levels.</p>
                <p>Our <strong><a href="<?php echo site_url().'/health-coaching/'; ?>">health coach</a></strong> can work with you to set actionable and realistic goals and help you get started on your journey to optimum health.</p>
            </div>
            <div class="col-sm-12 customgreenbtn" >
                <a href="<?php echo site_url().'/contact-us/'; ?>" title="">Ready to Get Started</a>
    	    </div>
        </div>
    </div>
</div>
<?php
    return;
}
