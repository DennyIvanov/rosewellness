<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Rose Wellness
 * @since Rose Wellness 2.0
 */
 
get_header(); 

// Get Query Object
$queried_object = get_queried_object();
$blog_cat_id = $queried_object->term_id;

// Tag Category Name
$tagCategory = $queried_object->name;

?>
    
    <div class="full-width-page-content blog-category new-blog-content-row">
        <div class="container">
            <div class="row blog_title_info">
                <div class="col-md-8 col-sm-8 col-xs-12 blog-latest-container gray-border-rt">
                    <?php echo do_shortcode('[cat_grid_shortcode]'); ?>
                    
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
                    						    
                    						    if($blog_cat_id == $category->term_id) {
                    						        $selected = 'selected';
                    						    } else {
                    						        $selected = '';
                    						    }
                    						    
                    						    if(in_array($category->term_id, $allowed_cats)) {
                    						    
                                                    // Child Parent Category
                                                    $child_terms_array = load_praent_child_terms($category->term_id);
                                                     
                        							echo '<option value="'.$category->slug.'" '.$selected.' style="font-weight: bold;">'.$category->name.'</option>';
                        							
                        							if(!empty($child_terms_array)) {
                        							    foreach($child_terms_array as $child_term) {
                        							        
                        							        if($blog_cat_id == $child_term->term_id) {
                                                                $selected = 'selected';
                                                            } else {
                                                                $selected = '';
                                                            }

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
                    
                    <?php if(!empty($tagCategory)) { ?>
                    <?php echo '<h2 class="title_heading subCat_heading">'.ucwords($tagCategory).'</h2>'; ?>
                    <?php } ?> 
                    <?php echo do_shortcode('[blog_tag_shortcode cat_id="'.$blog_cat_id.'"]'); ?>
                </div>
                
                <div class="col-md-4 col-sm-4 col-xs-12 new-blog-sidebar">
                    <?php dynamic_sidebar('custom-blog'); ?>
                </div>
            </div>
        </div>
        
        <div class="blog-cta" style="background-image:url('<?php echo site_url(); ?>/wp-content/uploads/2020/06/Footer-CTA-Background.jpg')">
            <div class="container">
                <h2>Find out why Rose Wellness is perfect for you</h2>
                <p>Schedule a free call with one of our wellness coordinators.</p>
                <a class="blog-cta-btn" href="<?php echo site_url(); ?>/contact-us/" title="">SCHEDULE A CALL</a>
            </div>
        </div>
                
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 blog-featured-container m-t-30">
                    <?php echo do_shortcode('[assessments_grid_shortcode]'); ?>
                </div>
            </div>
        </div>
    </div>
	
<?php 
get_footer();