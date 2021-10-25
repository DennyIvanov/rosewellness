<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Rose Wellness
 * @since Rose Wellness 2.0
 */

global $post;

// Get Current Category Slug
$current_category = get_the_category($post->ID);
$category_slug = $current_category[0]->slug;
$category_name = $current_category[0]->name;

// Get Primary Category
$primary_cat_id = get_post_meta($post->ID ,'_yoast_wpseo_primary_category', true);
$primary_term_array = get_term_by('term_id', $primary_cat_id, 'category');
$primary_term_name = $primary_term_array->name;

if(!empty($primary_cat_id)) {
    $related_cat_id = $primary_cat_id;
} else {
    $related_cat_id = $current_category[0]->term_id;
}

// Post Object
$featured_image_src = get_post_meta($post->ID, 'post_options', true);
$post_cta_options = get_post_meta($post->ID, 'post_cta_options', true);
$banner_image_url_src = wp_get_attachment_image_src($featured_image_src['post_banner_image_id'], 'full');

if(!empty($banner_image_url_src)) {
    $banner_image_url = $banner_image_url_src[0];
} else {
    $banner_image_url = get_stylesheet_directory_uri().'/images/blog-banner.jpg';
}

// Show Sidebar
$show_sidebar = get_post_meta($post->ID, 'show_sidebar', true);

get_header(); ?>
    
    <div class="top_banner_single" style="background-image:url('<?php echo $banner_image_url; ?>')">
    </div>
    
    <div class="full-width-page-content">
        <div class="container">
            
            <div class="row blog_title_info">
                
                <?php if(!empty($show_sidebar)) { ?>
    		    <div class="col-md-9 col-sm-9 col-xs-12">
    		    <?php } else { ?>
    		    <div class="col-md-12 col-sm-12 col-xs-12">
    		    <?php } ?>
    		        
                    <!--p class="category_info"><?php echo $category_name; ?></p-->
                    
                    <div class="sociallinks">
                        <p class="sharetext">Share</p>
                        <ul>
                            <li> 
                                <a href="https://www.facebook.com/share.php?u=<?php echo get_the_permalink(); ?>" target="_blank" rel="nofollow">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/intent/tweet?text=<?php echo get_the_permalink(); ?>&amp;text=<?php echo esc_attr(get_the_title()); ?>" target="_blank" rel="nofollow">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo get_the_permalink(); ?>" target="_blank" rel="nofollow">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                            <li>
                                <a href="http://pinterest.com/pin/create/button/?url=<?php echo get_the_permalink(); ?>&amp;description==<?php echo esc_attr(get_the_title()); ?>" target="_blank" rel="nofollow">
                                    <i class="fa fa-pinterest-p"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <h1 class="archive-title">
                		<?php
                		    echo get_the_title();
                		?>
            		</h1>
            		<span class="date"><?php echo get_the_date('F j, Y'); ?></span>
            		
            		<?php

                        // Check if there are any posts to display
                        if ( have_posts() ) :
                         
                            // The Loop
                            while ( have_posts() ) : the_post();
                                global $post;
                                ?>
                    			<div class="post-content">
                    				<?php
                    					the_content();
                    				?>
                    			</div>
                    			<?php
            			     endwhile;
            			 endif;
            	    ?>
            	    
            	    <?php if($featured_image_src['disable_cat'] == 'yes') { } else { ?>
            	        <p class="category_info"><a href="<?php echo site_url().'/category/'.$category_slug; ?>"><?php echo $category_name; ?></a></p>
            	    <?php } ?>
            	    
            	    <div class="sociallinks">
                        <p class="sharetext">Share</p>
                        <ul>
                            <li> 
                                <a href="https://www.facebook.com/share.php?u=<?php echo get_the_permalink(); ?>" target="_blank" rel="nofollow">
                                    <i class="fa fa-facebook"></i>
                                </a> 
                            </li>
                            <li>
                                <a href="https://twitter.com/intent/tweet?text=<?php echo get_the_permalink(); ?>&amp;text=<?php echo esc_attr(get_the_title()); ?>" target="_blank" rel="nofollow">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo get_the_permalink(); ?>" target="_blank" rel="nofollow">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                            <li>
                                <a href="http://pinterest.com/pin/create/button/?url=<?php echo get_the_permalink(); ?>&amp;description==<?php echo esc_attr(get_the_title()); ?>" target="_blank" rel="nofollow">
                                    <i class="fa fa-pinterest-p"></i>
                                </a>
                            </li>
                        </ul>
        
                    </div>
					
                    <div class="wp-post-meta" style="margin-top: 40px; text-align: left; color: #aaa; clear:both;">
						<?php 
						
						    $post_tags = get_the_tags();
							if ( $post_tags ) { ?>
						    <div><strong>Tags: </strong>
						    <?php 
								
								foreach( $post_tags as $tag ) {
								    echo '<a href="'.site_url().'/tag/'.$tag->slug.'" target="_self">'.ucwords($tag->name).'</a>, ';
								}
								
							?> 
							</div> 
							<?php	} 
							
						?>
										
	
						<div><strong>Categories: </strong><?php exclude_post_categories("33, 35"); ?></div>							
						
					
					</div>
            	</div>
            	
            	<?php if(!empty($show_sidebar)) { ?>
            	<div class="col-md-3 col-sm-3 col-xs-12 new-blog-sidebar">
                    <?php dynamic_sidebar('custom-single-blog'); ?>
                </div>
                <?php } ?>
            </div>
            
            
            
        </div>
        
        <?php if($featured_image_src['disable_cta'] == 'yes') { } else {  ?>
            <?php if(!empty($post_cta_options['post_cta_heading'])) {

                $image_uploader = wp_get_attachment_image_src(@$post_cta_options['post_cta_bg_img'], 'full'); 
                $bg = isset( $image_uploader[0] ) ? $image_uploader[0] : site_url() . '/wp-content/uploads/2020/06/Footer-CTA-Background.jpg';
            
                if(!empty($post_cta_options['cta_right'])) { ?>
                    
                    <div class="blog-cta" style="background-image:url('<?php echo $bg; ?>'); background-repeat: no-repeat;">
                        <div class="container">
                            <h2 style="text-align:right !important;float:right;"><?php echo $post_cta_options['post_cta_heading']; ?></h2>
                            <p style="text-align:right !important;float:right;"><?php echo nl2br($post_cta_options['post_cta_content']); ?></p>
                            <a style="float:right !important;clear: both;" class="blog-cta-btn" href="<?php echo $post_cta_options['post_cta_url']; ?>" title="<?php echo $post_cta_options['cta_btn_text']; ?>"><?php echo $post_cta_options['cta_btn_text']; ?></a>
                        </div>
                    </div>
                    
                <?php } else { ?>
                    
                    <div class="blog-cta" style="background-image:url('<?php echo $bg; ?>'); background-repeat: no-repeat;">
                        <div class="container">
                            <h2><?php echo $post_cta_options['post_cta_heading']; ?></h2>
                            <p><?php echo nl2br($post_cta_options['post_cta_content']); ?></p>
                            <a class="blog-cta-btn" href="<?php echo $post_cta_options['post_cta_url']; ?>" title="<?php echo $post_cta_options['cta_btn_text']; ?>"><?php echo $post_cta_options['cta_btn_text']; ?></a>
                        </div>
                    </div>
                        
                <?php }
                
            } else { ?>
                
                <div class="blog-cta" style="background-image:url('<?php echo site_url(); ?>/wp-content/uploads/2020/06/Footer-CTA-Background.jpg')">
                    <div class="container">
					    <h2>Find out if Rose Wellness is perfect for you</h2>
                        <p>Call us at (571)529-6699 or schedule a free call<br>with one of our health care advisors.</p>
                        <a class="blog-cta-btn" href="https://www.rosewellness.com/contact-us/" title="Schedule a Call">Schedule a Call</a>
                    </div>
                </div>
                
            <?php } ?>
        
        <?php } ?>
        
        <div class="container">
            <div class="row related-single">
    		    <div class="col-md-12 col-sm-12 col-xs-12">
    		        <h2>Related Posts</h2>
    		        <?php
    		            
    		            // Get Related Posts
                        $related_query = new WP_Query(array(
                                                'posts_per_page' => 8, 
                                                'post__not_in' => array($post->ID),
                                                'tax_query' => array(
                                                array(
                                                    'taxonomy' => 'category',
                                                    'field'    => 'term_id',
                                                    'terms'    => $related_cat_id,
                                                    ),
                                                ),
                                            ));
                        if ($related_query->have_posts()) {
                            while ($related_query->have_posts()) {
                                $related_query->the_post();
                                $postID = get_the_id();
                                
                                // Content By length
                                $the_content = strip_shortcodes(get_the_content($postID));
    			                $content_org = wp_trim_words($the_content, 20, '...');
                                
                                // Post Object
                                $featured_image_src = get_the_post_thumbnail_url($postID);
                                
                                if(!empty($featured_image_src)) {
                                    $banner_image_url = $featured_image_src;
                                } else {
                                    $banner_image_url = get_stylesheet_directory_uri().'/images/blog-banner.jpg';
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
            
                                <div class="related-post col-md-3">
                                    <a href="<?php echo get_the_permalink($postID); ?>" class="post-link"> 
                                        <div class="post-image" style="background-image: url(<?php echo $banner_image_url; ?>)"></div>
                                    </a>
                                    <div class="post-details">
                                        <p class="category_link"><a href="<?php echo site_url().'/category/'.$blog_cat_slug; ?>"><?php echo $blog_cat_name; ?></a></p>
                                        <a href="<?php echo get_the_permalink($postID); ?>"><h4><?php echo get_the_title($postID); ?></h4></a>
                        				<p class="blog_desc"><?php echo $content_org; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    ?>
    		    </div>  
    		</div>    
    		  
        </div>
    </div>
    
<?php
get_footer();