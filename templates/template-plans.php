<?php
/**
 * Template Name: Plan Template
 */
get_header();
?>

<div class="full-width-page-content">
    <div class="container">
        <?php
        if (have_posts()): while (have_posts()): the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
</div>
<script>
    
    jQuery(document).ready(function(){
        
        // Tool Tip
    	jQuery('.tooltip_section_box').tooltip({
    		tooltipClass: "plan-tooltip"
    	});
    	
    	jQuery('#logo').tooltip({
    	    disabled: true
    	});
    	
    });
	
</script>
<?php
get_footer();
