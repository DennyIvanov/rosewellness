/**
 * Rosewellness Admin Scripts
 *
 * @package rosewellness
 */
jQuery(document).ready(function() {
    
    if (jQuery(".datepicker").length) {
        jQuery(".datepicker").datepicker({dateFormat: 'dd-mm-yy'});
    }    
   
    var expand = false;
    var post_date_u = jQuery('#post_date_u').attr('checked');
    var post_date_l = jQuery('#post_date_l').attr('checked');
    var post_author_u = jQuery('#post_author_u').attr('checked');
    var post_author_l = jQuery('#post_author_l').attr('checked');
    var gravatar_fields = jQuery('#gravatar_show').attr('checked');
    var logo_show = jQuery('#logo_show').attr('checked');
    var favicon_show = jQuery('#favicon_show').attr('checked');
    var summary_show = jQuery('#summary_show').attr('checked');

    jQuery('input[name=rosewellness_reset]').click( function(){
        if ( !confirm('Are you sure you want to reset all the options?'))
            return false;
    });

    jQuery('.expand-collapse').live( 'click', function(){
        expand = false;
        jQuery('#normal-sortables .postbox').each( function() {
            if( jQuery(this).hasClass('closed') ) {
                expand = true;
            }
        });

        jQuery('#normal-sortables .postbox').each( function(){
            if ( expand ) {
                if( jQuery(this).hasClass('closed') ) {
                    jQuery(this).children('h2').trigger('click');
                }
            } else {
                if( !jQuery(this).hasClass('closed') ) {
                    jQuery(this).children('h2').trigger('click');
                }
            }
        });
        return false;
    } );

    date_format('u');
    date_format('l');

    jQuery('strong.rosewellness').parent().addClass('current');
    jQuery('strong.rosewellness').parent().parent().addClass('current');
    jQuery('.postbox .inside h3').remove();

    jQuery('.rosewellness_logo').change(function(){
        if (jQuery(this).val()=='site_title') {
            jQuery('#html-upload-logo').hide();
            jQuery('.login-head').hide();
            jQuery('#logo_metabox').hide();
            if ( jQuery('#use_logo').is(':checked') ){
                jQuery('#use_logo').removeAttr('checked');
                jQuery('#favicon_disable').attr('checked','checked');
                jQuery('#favicon_metabox').hide();
            }
            jQuery('#use_logo').attr('disabled','disabled');
            jQuery('.show-fields-logo').hide();
        } else {
            jQuery('#html-upload-logo').show();
            jQuery('.login-head').show();
            jQuery('#logo_metabox').show();
            jQuery('#use_logo').removeAttr('disabled');
            jQuery('.show-fields-logo').show();
        }
    })
    
    jQuery('.rosewellness_favicon').change(function(){
        if (jQuery(this).val()=='disable') {
            jQuery('#html-upload-fav').hide();
            jQuery('#favicon_metabox').hide();
        } else if( jQuery(this).val()=='logo' ) {
            jQuery('#html-upload-fav').hide();
            jQuery('#favicon_metabox').show();
        } else {
            jQuery('#html-upload-fav').show();
            jQuery('#favicon_metabox').show();
        }
    })
 
    toggle_handler( post_date_u, '.post_date_format_u', '#post_date_u' );
    toggle_handler( post_date_l, '.post_date_format_l', '#post_date_l' );
    toggle_handler( post_author_u, '.post_author_u-sub', '#post_author_u' );
    toggle_handler( post_author_l, '.post_author_l-sub', '#post_author_l' );
    toggle_handler( gravatar_fields, '.gravatar-size', '#gravatar_show' );
    toggle_handler( favicon_show, '.show-fields-favicon', '#favicon_show' );

    if (typeof summary_show !== 'undefined' && summary_show !== false) {
        jQuery('#post_thumbnail_options .inside .form-table').show();
        jQuery('#post_thumbnail_options .inside .rosewellness_submit').show();
        jQuery('#post_thumbnail_options .inside .post-summary-hide').hide();

        jQuery('#summary_show').click(function() {
            jQuery('#post_thumbnail_options .inside .form-table').toggle();
            jQuery('#post_thumbnail_options .inside .rosewellness_submit').toggle();
            jQuery('#post_thumbnail_options .inside .post-summary-hide').toggle();
        });
    } else {
        jQuery('#post_thumbnail_options .inside .form-table').hide();
        jQuery('#post_thumbnail_options .inside .rosewellness_submit').hide();
        jQuery('#post_thumbnail_options .inside .post-summary-hide').show();
        
        jQuery('#summary_show').click(function() {
            jQuery('#post_thumbnail_options .inside .form-table').toggle();
            jQuery('#post_thumbnail_options .inside .rosewellness_submit').toggle();
            jQuery('#post_thumbnail_options .inside .post-summary-hide').toggle();
        });
    }

    init_content('#post_summaries_options');
    init_content('#post_thumbnail_options');
    init_content('#pagination_options');
    contentshow_table('#post_summaries_options .inside .form-table tr.custom', '#summary_show');
    contentshow_table('#post_thumbnail_options .inside .form-table tr.custom', '#thumbnail_show');
    contentshow_table('#pagination_options .inside .form-table tr.custom', '#pagination_show');

});

/* Show and hide sections on checked */
function init_content( container ) {
    jQuery(container+' .inside .form-table tr:first').css('visibility','visible');
    jQuery(container+' .inside .form-table tr:first').css('display', 'block');
    jQuery(container+' .inside .form-table tr').addClass('custom');
    jQuery(container+' .inside .form-table tr:first').removeClass('custom');
}

function contentshow_table( container, event_handler ) {
    if( typeof jQuery(event_handler).attr('checked') !== 'undefined' && jQuery(event_handler).attr('checked') != false ) {
        jQuery( jQuery(container) ).css('visibility','visible');
        jQuery( jQuery(container) ).css('display','block');
    } else {
        jQuery( jQuery(container) ).css('visibility','hidden');
        jQuery( jQuery(container) ).css('display','none');
    }
    jQuery(event_handler).click(function () {
        if (( jQuery(container+':hidden').length > 1)) {
            jQuery( jQuery(container) ).css('visibility','visible');
            jQuery( jQuery(container) ).css('display','block');
        } else {
            jQuery( jQuery(container) ).css('visibility','hidden');
            jQuery( jQuery(container) ).css('display','none');
        }
        });
}
    
/* Format date according to changes in custom date field */
function date_format( position ) {
    jQuery('input[name="rosewellness_post_comments[post_date_format_'+position+']"]').click(function(){
        if ( 'post_date_custom_format_'+position != jQuery(this).attr('id') ) {
            if ( 'full-date-'+position == jQuery(this).attr('id') ) {
                jQuery('input[name="rosewellness_post_comments[post_date_custom_format_'+position+']"]').val( jQuery(this).val() ).siblings('span').text( jQuery(this).siblings('.full-date-'+position).text() );
            } else if ( 'y-m-d-'+position == jQuery(this).attr('id') ) {
                jQuery('input[name="rosewellness_post_comments[post_date_custom_format_'+position+']"]').val( jQuery(this).val() ).siblings('span').text( jQuery(this).siblings('.y-m-d-'+position).text() );
            } else if ( 'm-d-y-'+position == jQuery(this).attr('id') ) {
                jQuery('input[name="rosewellness_post_comments[post_date_custom_format_'+position+']"]').val( jQuery(this).val() ).siblings('span').text( jQuery(this).siblings('.m-d-y-'+position).text() );
            } else if ( 'd-m-y-'+position == jQuery(this).attr('id') ) {
                jQuery('input[name="rosewellness_post_comments[post_date_custom_format_'+position+']"]').val( jQuery(this).val() ).siblings('span').text( jQuery(this).siblings('.d-m-y-'+position).text() );
            }
            jQuery('#post_date_custom_format_'+position).val(jQuery(this).val());
            jQuery('#post_date_custom_format_'+position).siblings('label').attr('title', jQuery(this).val());
        }
    });

    jQuery('#custom-date-'+position).keyup(function () {
        jQuery('#post_date_custom_format_'+position).val(jQuery(this).val());
        jQuery('#post_date_custom_format_'+position).siblings('label').attr('title', jQuery(this).val());
    });

    jQuery('input[name="rosewellness_post_comments[post_date_custom_format_'+position+']"]').focus(function(){
        jQuery('#post_date_custom_format_'+position).attr('checked', 'checked');
    });

    jQuery('input[name="rosewellness_post_comments[post_date_custom_format_'+position+']"]').change( function() {
        var format = jQuery(this);
        format.siblings('img').css('visibility','visible');
        jQuery.post(ajaxurl, { action: 'date_format', date : format.val() }, function(d) { format.siblings('img').css('visibility','hidden'); format.siblings('span').text(d); } );
    });
}

/* Function to handle toggling of sub options */
function toggle_handler( the_option, the_class, the_id ) {
    if (typeof the_option !== 'undefined' && the_option !== false) {
        jQuery(the_class).show();
        jQuery(the_id).click(function(){
            jQuery(the_class).toggle();
        });
    } else {
        jQuery(the_class).hide();
        jQuery(the_id).click(function(){
            jQuery(the_class).toggle();
        });
    }
}

