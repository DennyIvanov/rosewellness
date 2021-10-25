jQuery(document).ready(function ($) {
    // Rating JS
    jQuery('.star_r').click(function() {
        var star_val = jQuery(this).val();
        jQuery('#sf_Rating').val('');
        jQuery('#sf_Rating').val(star_val);
    });
    
    jQuery('.new-blog-sidebar .select').prepend(new Option('Primary Interest', ''));
    jQuery('.new-blog-sidebar .select').val(jQuery(".new-blog-sidebar .select option:first").val());
	
	jQuery('#team_filter .team_filter_list').change(function($) {
		// fetch the class of the clicked item
		var ourClass = jQuery(this).val();

		if(ourClass == 'all') {
			// show all our items
			jQuery('.team-container').children('.team-item').show();	
			jQuery('.all_staff').show();
		} else {
			jQuery('.all_staff').hide();
    		// hide all elements that don't share ourClass
    		jQuery('.team-container').children('.team-item:not(.' + ourClass + ')').hide();
    		// show all elements that do share ourClass
    		jQuery('.team-container').children('.team-item.' + ourClass).show();
		}
		
		return false;
	});
    
    // Ajax Load More
	jQuery("body").delegate( ".loadlBlog", "click",function() {

		jQuery(".loadlBlog").addClass('disable_btn');
		pageNo   = jQuery(this).data('page');
		cat_id   = jQuery(this).data('cat');
		
		var page = 1 + pageNo; // What page we are on.
		var ppp = 3; // Post per page

		var data = {
			'action'         :  'ajaxBlogLatestLoadMore',
			'offset'         :  (page * ppp),
			'ppp'            :  ppp,
			'page'           :  page,
			'cat_id'         :  cat_id,
		};
			
		console.log(data);
		// The variable ajax_url should be the URL of the admin-ajax.php file
		jQuery.post( ajaxurl, data, function(response) {
			//console.log(response.html);
			jQuery(".blog_load_more").remove();
			jQuery('.blog-latest-container .posts_list').append(response.html);
			jQuery(".blog_load_more").removeClass('disable_btn');
		}, 'json');

	});
	
	// Ajax Load More
	jQuery("body").delegate( ".loadtBlog", "click",function() {

		jQuery(".loadtBlog").addClass('disable_btn');
		pageNo   = jQuery(this).data('page');
		cat_id   = jQuery(this).data('cat');
		
		var page = 1 + pageNo; // What page we are on.
		var ppp = 6; // Post per page

		var data = {
			'action'         :  'ajaxBlogLatestLoadMore',
			'offset'         :  (page * ppp),
			'ppp'            :  ppp,
			'page'           :  page,
			'cat_id'         :  cat_id,
			'tax_type'       :  'post_tag',
		};
			
		console.log(data);
		// The variable ajax_url should be the URL of the admin-ajax.php file
		jQuery.post( ajaxurl, data, function(response) {
			//console.log(response.html);
			jQuery(".blog_load_more").remove();
			jQuery('.blog-latest-container .posts_list').append(response.html);
			jQuery(".blog_load_more").removeClass('disable_btn');
		}, 'json');

	});
	
	// Ajax Load More
	jQuery("body").delegate( ".loadABlog", "click",function() {

		jQuery(".loadABlog").addClass('disable_btn');
		pageNo   = jQuery(this).data('page');
		
		var page = 1 + pageNo; // What page we are on.
		var ppp = 6; // Post per page

		var data = {
			'action'         :  'ajaxBlogAnyLoadMore',
			'offset'         :  (page * ppp),
			'ppp'            :  ppp,
			'page'           :  page,
		};
			
		console.log(data);
		// The variable ajax_url should be the URL of the admin-ajax.php file
		jQuery.post( ajaxurl, data, function(response) {
			//console.log(response.html);
			jQuery(".blog_load_more").remove();
			jQuery('.blog-latest-container .posts_list').append(response.html);
			jQuery(".blog_load_more").removeClass('disable_btn');
		}, 'json');

	});
	
    // Ajax Load More
	jQuery("body").delegate( ".loadBlog", "click",function() {

		jQuery(".loadBlog").addClass('disable_btn');
		pageNo   = jQuery(this).data('page');
		
		var page = 1 + pageNo; // What page we are on.
		var ppp = 3; // Post per page
        
		var data = {
			'action'         :  'ajaxBlogLoadMore',
			'offset'         :  (page * ppp),
			'ppp'            :  ppp,
			'page'           :  page,
		};
			
		// The variable ajax_url should be the URL of the admin-ajax.php file
		jQuery.post( ajaxurl, data, function(response) {
			//console.log(response.html);
			jQuery(".blog_load_more").remove();
			jQuery('.posts_featured_list').append(response.html);
			jQuery(".loadBlog").removeClass('disable_btn');
		}, 'json');

	});
	
	// Ajax Featued Post Load More
	jQuery("body").delegate( ".loadCatFBlog", "click",function() {

		jQuery(".loadCatFBlog").addClass('disable_btn');
		pageNo   = jQuery(this).data('page');
		cat_id   = jQuery(this).data('cat');
		
		var page = 1 + pageNo; // What page we are on.
		var ppp = 3; // Post per page
        
		var data = {
			'action'         :  'ajaxCatBlogLoadMore',
			'offset'         :  (page * ppp),
			'ppp'            :  ppp,
			'page'           :  page,
			'cat_id'           :  cat_id,
		};
			
		// The variable ajax_url should be the URL of the admin-ajax.php file
		jQuery.post( ajaxurl, data, function(response) {
			//console.log(response.html);
			jQuery(".blog_load_more").remove();
			jQuery('.posts_featured_list').append(response.html);
			jQuery(".loadCatFBlog").removeClass('disable_btn');
		}, 'json');

	});
	
	// Ajax Cat Load More
	jQuery("body").delegate( ".loadCat", "click",function() {

		jQuery(".loadCat").addClass('disable_btn');
		pageNo   = jQuery(this).data('page');
		
		var page = 1 + pageNo; // What page we are on.
		var ppp = 4; // Post per page
        
		var data = {
			'action'         :  'ajaxCatLoadMore',
			'offset'         :  (page * ppp),
			'ppp'            :  ppp,
			'page'           :  page,
		};
			
		// The variable ajax_url should be the URL of the admin-ajax.php file
		jQuery.post( ajaxurl, data, function(response) {
			//console.log(response.html);
			jQuery(".cat_load_more").remove();
			jQuery('.widget_cats').append(response.html);
			jQuery(".loadCat").removeClass('disable_btn');
		}, 'json');

	});
	
	// Get URL Parameter
	var getUrlParameter = function getUrlParameter(sParam) {
		var sPageURL = window.location.search.substring(1),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			}
		}
	};
	
	var fname = getUrlParameter('fname');
	var lname = getUrlParameter('lname');
	var email = getUrlParameter('email');
	var phone = getUrlParameter('phone');
	var interest = getUrlParameter('interest');
	
	jQuery('#sf_first_name').val(fname);
	jQuery('#sf_last_name').val(lname);
	jQuery('#sf_email').val(email);
	jQuery('#sf_phone').val(phone);
	jQuery('#sf_Interests__c').val(interest);

    
    // Close Popup
    jQuery('.sales-lead-form .close_btn').click(function() {
        jQuery('.pop-modal-active').hide();
        jQuery('.sales-lead-form').hide('fast'); 
        $.cookie('show_popup', 'current', { expires: 7, path: '/' });
    });
    
    // Navigation Mobile Menu
	jQuery('.navbar-toggle').click(function (e) {
	    e.preventDefault();
        jQuery(this).toggleClass('active');
        jQuery("#sidebar-wrapper").toggleClass("active");
        //jQuery("body").toggleClass("mobile-active");
    });
    jQuery(".navbar-toggle-close").click(function(e) {
        e.preventDefault();
        jQuery("#sidebar-wrapper").toggleClass("active");
        //jQuery("body").toggleClass("mobile-active");
    });
    
    // Sub Menu
    jQuery('#sidebar-wrapper #mainmenu > li.menu-item.menu-item-has-children').click(function(e) {
        if(e.target == e.currentTarget){
            e.preventDefault();
            
            jQuery(this).toggleClass('active');
            jQuery(this).find('.sub-menu').toggleClass('active');
        }
    });
    
    // Header Search button
    jQuery('.search_section').click(function(){
        jQuery('.search_wrapper').fadeToggle();
    });
    
    jQuery('.icon_close').click(function(){
        jQuery('.search_wrapper').hide();
    });
    
    // Category Redirect on Select
    jQuery('.categories_list').on('change', function(){
       var cat_val = jQuery(this).val();
       redirect_cat_url = 'https://www.rosewellness.com/category/' + cat_val;
       window.location = redirect_cat_url;
    });
    
    // Newsletter Placeholder
    jQuery('.footer #sf_email').attr('placeholder', 'Email');
    
    // Single Block Sticky Social And Ads Container
    if (jQuery('.sociallinks').length) {
        var header_height = jQuery('header').height();
        var sticky_sidebars = jQuery('.sociallinks').offset().top - header_height - 20;
        jQuery(window).scroll(function () {
            if (jQuery(window).scrollTop() > sticky_sidebars) {
                var social_share_width = jQuery('.post-social-share-container').width();
                jQuery('.sociallinks').addClass('sticky');
                jQuery('.sociallinks').css('width', social_share_width);

            } else {
                jQuery('.sociallinks').removeClass('sticky');
            }
        });
    }
	
	// Optimise Images
	var imgDefer = document.getElementsByTagName('img');
    for (var i = 0; i < imgDefer.length; i++) {
        if (imgDefer[i].getAttribute('data-src')) {
            imgDefer[i].setAttribute('src', imgDefer[i].getAttribute('data-src'));
        }
    }

	// Smooth Scroll
	jQuery('.banner .btn').click(function (e) {
        //e.preventDefault();
        jQuery("html, body").animate({scrollTop: jQuery('#contact').offset().top - 160}, 1500);
    });

});

// Mobile Move Sections for Responsive
jQuery(function($) {
	if($(window).width() < 992) {
	    $('.move-1 .img-on-top').insertBefore('.move-1 .content-on-top');
	    $('.move-2 .img-on-top').insertBefore('.move-2 .content-on-top');
	    $('.move-3 .img-on-top').insertBefore('.move-3 .content-on-top');
	    $('.move-4 .img-on-top').insertBefore('.move-4 .content-on-top');
	    $('.move-5 .img-on-top').insertBefore('.move-5 .content-on-top');
	    $('.move-6 .img-on-top').insertBefore('.move-6 .content-on-top');
	    $('.move-7 .img-on-top').insertBefore('.move-7 .content-on-top');
	    $('.move-8 .img-on-top').insertBefore('.move-8 .content-on-top');
	    $('.move-9 .img-on-top').insertBefore('.move-9 .content-on-top');
	    $('.move-10 .img-on-top').insertBefore('.move-10 .content-on-top');
	    
	    // Tabs Mobile
	    jQuery('.nav-tab-click').click(function() {
	        // Add Nav Active
	        jQuery('.home-tab-mobile').removeClass('active');
	        jQuery(this).closest('.home-tab-mobile').addClass('active');
	        
	        // Open Content
            var tab_open = jQuery(this).data('tab');
            jQuery('.home-tabs').hide();
            jQuery('.home-tabs.' + tab_open).slideDown();
        });
	}
	
	if($(window).width() < 767) {
	    jQuery('.first_row_ser .sliding-box:nth-child(6)').insertAfter('.second_row_ser .sliding-box:nth-child(6)');
	    jQuery('.third_row_ser .sliding-box:nth-child(6)').insertAfter('.fourth_row_ser .sliding-box:nth-child(6)');
	}
	
});


function teamCarousel() {
    if(jQuery('#team-slider').length > 0){
        jQuery('#team-slider').slick({
            arrows: true,
            dots: false,
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 1000,
            centerMode: false,
            variableWidth: true,
            prevArrow: '<div class="owl-prev fa fa-chevron-left"></div>',
            nextArrow: '<div class="owl-next fa fa-chevron-right"></div>',
            responsive: [
                {
                    breakpoint: 993,
                    settings: {
                        slidesToShow: 3,
                        variableWidth: true,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        variableWidth: false,
                    }
                }
            ]
        });
    }
}

function testCarousel() {
    if(jQuery('#testimonials-slider').length > 0){
        jQuery('#testimonials-slider').slick({
            arrows: false,
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 1000,
            centerMode: false,
            variableWidth: false,
            prevArrow: '<div class="owl-prev"></div>',
            nextArrow: '<div class="owl-next"></div>',
            responsive: [
                {
                    breakpoint: 993,
                    settings: {
                        slidesToShow: 1,
                        adaptiveHeight: true
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        adaptiveHeight: true
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        adaptiveHeight: true
                    }
                }
            ]
        });
    }
}

// Scroll Header
jQuery(window).scroll(function() {  
    
    var scroll = jQuery(window).scrollTop();
    
    if (scroll >= 1) {
        jQuery(".header").addClass("fixed_header");
        jQuery('.top_fixed_header').hide();
    } else {
        jQuery(".header").removeClass("fixed_header");
        jQuery('.top_fixed_header').show();
    }
    
});

jQuery(window).on('load', function($) {
    
    if (typeof jQuery.cookie('show_popup') === 'undefined'){
        
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

// Team Role Filter After load
jQuery( window ).load(function() {
	var searchParams = new URLSearchParams(window.location.search);
	var param_Class = searchParams.get('region');

	if(searchParams.has('region') === true) {
		jQuery('.team_filter_list').val(param_Class);
		
		jQuery('.all_staff').hide();
		jQuery('.team-container').children('.team-item:not(.' + param_Class + ')').hide();
		jQuery('.team-container').children('.team-item.' + param_Class).show();
	} else {
		// show all our items
		jQuery('.team_filter_list').val('all');
		jQuery('.team-container').children('.team-item').show();	
		jQuery('.all_staff').show();
		
	}
});
