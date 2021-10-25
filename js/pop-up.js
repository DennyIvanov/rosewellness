jQuery(window).on('load', function($) {
    
    if (typeof $.cookie('show_popup') === 'undefined'){
        
        if(jQuery("#lead_popup").length > 0) {
            jQuery('body').on('touchmove DOMMouseScroll mousewheel', function() {
                if( window.scrollY >= 600 && showModal){
                    showModal = false
                    clearTimeout(ShowWindow);
                    jQuery('.pop-modal-active').show();
                    jQuery('.sales-lead-form').show('slow');
                }
            });
            var showModal = true,
                ShowWindow = setTimeout(function(){
                showModal = false;
                clearTimeout(ShowWindow);
                jQuery('.pop-modal-active').show();
                jQuery('.sales-lead-form').show('slow');
            }, 15000);            
        }  
    }
    
    // Footer Subscriptions Form
    jQuery('.footer .sf_type_select select').prepend('<option value="" selected>Primary Interest</option>');
    jQuery('.sf_type_email input').attr('placeholder', 'Email');
    
    jQuery('.home-deserve-it-bg, .footer-cta-bg').addClass('lazy-load');
    
});
