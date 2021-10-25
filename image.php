<?php
/**
 * The template for displaying Image Attachments
 *
 * @package rosewellness
 * 
 */
get_header(); ?>

<?php global $rosewellness_post_comments; ?>

    <section id="content" class="rosewellness-image-attachment rosewellness-grid-12">
        <?php rosewellness_hook_begin_content(); ?>

        <?php 
        while( have_posts() ) {
            the_post();
            if ( $post->post_parent ) { ?>
                <div class="rosewellness-navigation clearfix">
                    <div class="alignleft"><a role="link" href="<?php echo get_permalink( $post->post_parent ); ?>">&larr; <?php echo get_the_title( $post->post_parent ); ?></a></div>
                </div><?php
            } ?>

            <article <?php post_class( 'rosewellness-image-box' ); ?>>
                <?php rosewellness_hook_begin_post(); ?>

                <header class="post-header clearfix">
                    <?php rosewellness_hook_begin_post_title(); ?>

                    <h1 class="post-title<?php echo $rosewellness_post_comments['attachment_comments'] ? '' : ' rosewellness-has-comments' ?>"><?php the_title(); ?></h1>

                    <?php rosewellness_hook_end_post_title(); ?>

                    <?php rosewellness_hook_post_meta( 'top' ); ?>

                </header><!-- .post-title -->

                <div class="post-content clearfix">
                    <?php rosewellness_hook_begin_post_content(); ?>

                    <?php $img_info = wp_get_attachment_image_src( '', 'full' ); ?>

                    <figure role="img" class="wp-caption aligncenter" aria-describedby="figcaption_attachment_<?php echo get_the_ID(); ?>"<?php echo ( $img_info[1] < $max_content_width ) ? ' style="width: ' . ((int) $img_info[1]) . 'px";' : ''; ?>>
                        <a role="link" href="<?php echo $img_info[0]; ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php echo wp_get_attachment_image( '', 'full' ); ?></a><?php
                        echo ( get_the_excerpt() ) ? '<figcaption id="figcaption_attachment_' . get_the_ID() . '" class="wp-caption-text">' . get_the_excerpt() . '</figcaption>' : ''; ?>
                    </figure>

                    <?php the_content(); ?>

                    <?php 
                        if ( $post->post_parent > 0 ) {
                            $args = array(
                                'numberposts'   => apply_filters( 'rosewellness_image_sibling_count', 10 ),
                                'order'         => 'ASC',
                                'post_mime_type'=> 'image',
                                'post_parent'   => $post->post_parent,
                                'post_status'   => 'inherit',
                                'post_type'     => 'attachment'
                            );

                            $attachments = get_children( $args );

                            if ( $attachments ) { ?>
                                <ul role="list" class="rosewellness-sibling-attachments rosewellness-container-12 rosewellness-alpha rosewellness-omega clearfix"><?php
                                    $count = 1;
                                    foreach( $attachments as $attachment ) {
                                        if ( get_the_ID() != $attachment->ID ) {
                                            $alpha_omega = NULL;
                                            if ( $count % 6 == 1 ) {
                                                $alpha_omega = ' rosewellness-alpha';
                                            } elseif ( $count %6 == 0 ) {
                                                $alpha_omega = ' rosewellness-omega';
                                            }
                                            echo '<li role="listitem" class="rosewellness-grid-2' . $alpha_omega . '">' . wp_get_attachment_link( $attachment->ID, 'thumbnail', true ) . '</li>';
                                            $count++;
                                        }
                                    } ?>
                                </ul><?php
                            }
                        } ?>

                    <?php rosewellness_hook_end_post_content(); ?>

                </div><!-- .post-content -->

                <?php rosewellness_hook_post_meta( 'bottom' ); ?>

                <?php rosewellness_hook_end_post(); ?>
            </article><!-- .rosewellness-post-box --><?php
            rosewellness_hook_comments();
        } ?>

        <?php rosewellness_hook_end_content(); ?>
    </section><!-- #content -->

<?php get_footer(); ?>