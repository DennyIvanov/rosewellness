<?php
/**
 * The template for displaying the footer
 *
 * @package rosewellness
 *
 */
global $rosewellness_general; ?>

		<?php rosewellness_hook_end_content_wrapper(); ?>
		
		<?php rosewellness_hook_before_footer(); ?>
		
		<section class="footer">
			<div class="container">
				
				<div class="row top-footer hidden-xs">
				    <div class="col-md-2 col-sm-2 col-xs-6 widget-section">
						<?php
                        if ( is_active_sidebar( 'custom-footer-widget-1' ) ) : ?>
                            <?php dynamic_sidebar( 'custom-footer-widget-1' ); ?>
                        <?php endif; ?>
					</div>
					
					<div class="col-md-2 col-sm-2 col-xs-6 widget-section">
						<?php
                        if ( is_active_sidebar( 'custom-footer-widget-2' ) ) : ?>
                            <?php dynamic_sidebar( 'custom-footer-widget-2' ); ?>
                        <?php endif; ?>
					</div>
					
					<div class="col-md-2 col-sm-2 col-xs-6 widget-section">
						<?php
                        if ( is_active_sidebar( 'custom-footer-widget-3' ) ) : ?>
                            <?php dynamic_sidebar( 'custom-footer-widget-3' ); ?>
                        <?php endif; ?>
					</div>
					
					<div class="col-md-2 col-sm-2 col-xs-6 widget-section">
						<?php
                        if ( is_active_sidebar( 'custom-footer-widget-4' ) ) : ?>
                            <?php dynamic_sidebar( 'custom-footer-widget-4' ); ?>
                        <?php endif; ?>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 widget-section">
						<?php
                        if ( is_active_sidebar( 'custom-footer-widget-5' ) ) : ?>
                            <?php dynamic_sidebar( 'custom-footer-widget-5' ); ?>
                        <?php endif; ?>
					</div>
				</div>
				
	        	<!--------- Mobile Footer ------------------------------->		
				<div class="row top-footer visible-xs">
				    <div class="col-md-4 col-sm-4 col-xs-12 widget-section">
						<?php
                        if ( is_active_sidebar( 'custom-footer-widget-5' ) ) : ?>
                            <?php dynamic_sidebar( 'custom-footer-widget-5' ); ?>
                        <?php endif; ?>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-2 col-sm-2 col-xs-6 widget-section">
						<?php
                        if ( is_active_sidebar( 'custom-footer-widget-3' ) ) : ?>
                            <?php dynamic_sidebar( 'custom-footer-widget-3' ); ?>
                        <?php endif; ?>
					</div>
					
					<div class="col-md-2 col-sm-2 col-xs-6 widget-section">
						<?php
                        if ( is_active_sidebar( 'custom-footer-widget-4' ) ) : ?>
                            <?php dynamic_sidebar( 'custom-footer-widget-4' ); ?>
                        <?php endif; ?>
					</div>
					<div class="clearfix"></div>
				    <div class="col-md-2 col-sm-2 col-xs-6 widget-section">
						<?php
                        if ( is_active_sidebar( 'custom-footer-widget-1' ) ) : ?>
                            <?php dynamic_sidebar( 'custom-footer-widget-1' ); ?>
                        <?php endif; ?>
					</div>
					
					<div class="col-md-2 col-sm-2 col-xs-6 widget-section">
						<?php
                        if ( is_active_sidebar( 'custom-footer-widget-2' ) ) : ?>
                            <?php dynamic_sidebar( 'custom-footer-widget-2' ); ?>
                        <?php endif; ?>
					</div>
					
				</div>
		        <!--------- Mobile Footer ------------------------------->		
				
				<div class="row bottom-footer">
    			    <?php
    			    
    			        // Footer Text
    					$footer_options = get_option('custom_theme_options');
    					$copyright_text = $footer_options['copyright_info'];
    				?>
    				<div class="col-md-6 col-sm-6 col-xs-12 copyright">
    					<p><?php echo $copyright_text; ?></p>
    				</div>
    				<div class="col-md-6 col-sm-6 col-xs-12 info_text">
    					<?php
                        if ( is_active_sidebar( 'custom-footer-widget-6' ) ) : ?>
                            <?php dynamic_sidebar( 'custom-footer-widget-6' ); ?>
                        <?php endif; ?>
    				</div>
    			</div>
    			
			</div>
		</section>
		
		<!---------- Mobile Sticky Footer ---------------->
		<div class="bottom-fix-contact visible-xs">
            <div class="row">
                <div class="col-xs-6">
                    <a href="tel:571.529.6699"><i class="fa fa-phone"></i> Call</a>
                </div>
                <div class="col-xs-6">
                    <a href="<?php echo site_url(); ?>/contact-us/"><i class="fa fa-envelope"></i> Contact</a>
                </div>
            </div>
        </div>
        
        <!---------- Pop Sales Lead Form -------------------->
        
        <?php //if(is_front_page()) { ?>
            <div class="pop-modal-active" style="display:none"></div>
            <div id="lead_popup" class="sales-lead-form">
                <span class="close_btn"><i class="fa fa-close"></i></span>
                <div class="row">
                    <div class="col-xs-3">
                        <img src="<?php echo site_url(); ?>/wp-content/uploads/2020/06/pop.jpg">
                    </div>
                    <div class="col-xs-9">
                        <h4 class="title"><?php echo $footer_options['popup_title']; ?></h4>
                        <h4 class="subtitle"><strong><?php echo $footer_options['popup_subtitle']; ?></strong></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <?php echo do_shortcode('[salesforce form="4"]'); ?>
                    </div>
                </div>
            </div>
        <?php //} ?>

		<?php rosewellness_hook_after_footer(); ?>

		<?php rosewellness_hook_end_main_wrapper(); ?>

        <?php wp_footer(); ?>

        <?php rosewellness_hook_end_body(); ?>
        
        <script type="text/javascript">
          WebFontConfig = {
            google: { families: [ 'Muli:300;400;500;600;700;800;900' ] }
          };
          (function() {
            var wf = document.createElement('script');
            wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
          })();
        </script>
<script>
  window.addEventListener('load', function(){
    if(window.location.href.indexOf('#sf_form_salesforce_w2l_lead_4') != -1){
      ga('send', 'event','form','submit','popup');
    }
    if(window.location.href.indexOf('#sf_form_salesforce_w2l_lead_1') != -1){
      ga('send', 'event','form','submit','footer');
    }
  });
</script> 
    </body>
</html>