<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Rose Wellness
 * @since Rose Wellness 2.0
 */
 
get_header();

?>
    
     <div class="top_banner_single" style="background-image:url('<?php echo get_stylesheet_directory_uri(); ?>/images/search.jpg')">
        <div class="banner-text">
            <h1>Search Results for:</h1>
            <h2><p><?php echo esc_html(get_search_query()); ?></p></h2>
        </div>
    </div>
    
    <div class="full-width-page-content blog-category">
        <div class="container">
            <?php rosewellness_hook_begin_content(); ?>
            
            <?php rosewellness_hook_begin_post(); ?>
                
                <?php
						
					global $wpdb, $post;
					
					// Post Type
					if(@$_REQUEST['type'] == 'h') {
					    
					   $post_type = array('post', 'page');
					   
					} else {
					    
					    $post_type = array('post');
					}

					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$post_args = array (
						'posts_per_page' => 12,
						'paged'	=> $paged,
						'post_type'   => $post_type,
						'post_status'   => 'publish',
						'orderby' => 'date',
						'order'	=> 'DESC',
						's'	=> get_search_query(),
					);
					
					$post_query = new WP_Query($post_args);
					if ($post_query->have_posts()) {
					    
					    if(@$_REQUEST['type'] == 'h') {
					        
					        echo '<div class="row result_list">';
        						$i = 1;
        						while ($post_query->have_posts()) {
        							$post_query->the_post();
        							$postID =  get_the_id();
        							
        							// Content By length
        							$the_content = get_the_content($postID);
        							$desc_strip = strip_tags(do_shortcode($the_content));
                                    /* Remove empty spaces */
                                    $desc_org = trim(preg_replace('/\s+/',' ', $desc_strip ));

        			                $content_org = wp_trim_words($desc_org, 30, ' [...]');
        							?>
        							<div class="post-item col-md-12">
                        				<a href="<?php echo get_the_permalink($postID); ?>"><h4><?php echo get_the_title($postID); ?></h4></a>
                        				<div class="content_section"><?php echo $content_org; ?></div>
                        				<div class="post-footer">
											<div class="post-links">
												<i class="fa fa-file-text-o"></i> <a href="<?php echo get_the_permalink($postID); ?>" class="post-more">Read more</a>
											</div>
										</div>
                        			</div>
        							<?php
        							$i++;
        						}
    					    echo '</div>';
					        
					        
					    } else {
						
    						echo '<div class="row posts_list">';
        						$i = 1;
        						while ($post_query->have_posts()) {
        							$post_query->the_post();
        							$postID =  get_the_id();
        							
        							// Content By length
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
        							$i++;
        						}
    					    echo '</div>';
    					    
					    }
					    
					} else {
						echo '<h2 class="noResults">Sorry no blogs found for “'.get_search_query().'” with the applied filters. Please modify the search criteria.</h1>';
					}
					
					wp_reset_postdata();
					wp_reset_query();
						
				?>
				
				<div class="blog-pagination">
					<?php
					$big = 999999999; // need an unlikely integer

					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total' => $post_query->max_num_pages
					) );
					?>
    			</div>
            
            <?php rosewellness_hook_end_post(); ?>

            <?php rosewellness_hook_end_content(); ?>
        </div>
    </div>

<?php 
get_footer();