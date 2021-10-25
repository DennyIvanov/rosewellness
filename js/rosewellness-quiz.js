jQuery(document).ready(function () {
    
	// Move Last Prev Button
	jQuery('.last_prev').insertBefore('.wpforms-submit');
	
	// Last Step Hide Fixed Header
	jQuery('.last_step .wpforms-page-next').click(function(){
		jQuery('.fixed-header').hide();
		jQuery('.page-template-template-form-quiz .quiz_small_desc').hide();
	});
	
	// Prev/Next Step Toxicity Hide description  
	jQuery('#wpforms-form-10366 .wpforms-page-next').click(function(){
		jQuery('.quiz_small_desc').hide();
	});
	
	jQuery('.page-id-8795 .wpforms-page-prev').click(function(){
		jQuery('.quiz_small_desc').hide();
	});
	
	jQuery('.last_prev').click(function() {
		jQuery('.fixed-header').show();
	});
	
	// Click li box to select the radio button
	jQuery('.wpforms-field-radio ul li').click(function(){
		jQuery(this).find('input[type=radio]').prop("checked", true);
	});
	
	// Media For Mobile
	if(jQuery(window).width() < 767) {
		
		// Move Plans for Mobile
		jQuery('.mob-hide .one-third:first-child').insertAfter('.mob-hide .one-third:nth-child(2)');
		
		// Health Quiz Form
		jQuery('#wpforms-form-10367 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-10367 .wpforms-field-radio ul').first().show();
		
		jQuery('#wpforms-form-10367 .wpforms-page-2 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-10367 .wpforms-page-2 .wpforms-field-radio ul').first().show();
		
		jQuery('#wpforms-form-10367 .wpforms-page-3 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-10367 .wpforms-page-3 .wpforms-field-radio ul').first().show();
		
		jQuery('#wpforms-form-10367 .wpforms-page-4 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-10367 .wpforms-page-4 .wpforms-field-radio ul').first().show();
		
		jQuery('#wpforms-form-10367 .wpforms-page-5 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-10367 .wpforms-page-5 .wpforms-field-radio ul').first().show();

		jQuery('#wpforms-form-10367 .wpforms-page-6 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-10367 .wpforms-page-6 .wpforms-field-radio ul').first().show();

		jQuery('#wpforms-form-10367 .wpforms-page-7 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-10367 .wpforms-page-7 .wpforms-field-radio ul').first().show();

		// Mobile WP Forms
		jQuery('#wpforms-form-10367 .wpforms-field-radio label').click(function() {
		
			jQuery(this).toggleClass('active');
			jQuery(this).next('ul').slideToggle();
		
		});
		
		
		jQuery('#wpforms-form-10367 .wpforms-field-radio ul li').click(function() {
			jQuery(this).find('input[type=radio]').prop("checked", true);
			jQuery(this).parent().prev('.wpforms-field-label').addClass('valid_active');
			jQuery(this).parent().prev('.wpforms-field-label').removeClass('active');
			jQuery(this).parent().slideUp();
                        
			jQuery(this).parents('.wpforms-field-radio').next('.wpforms-field-radio').find('label').addClass('active');
			jQuery(this).parents('.wpforms-field-radio').next('.wpforms-field-radio').find('ul').slideDown();
                        
		});
		
		// Insomnia Quiz Form

		jQuery('#wpforms-form-12396 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-12396 .wpforms-field-radio ul').first().show();

		// Mobile WP Forms

		jQuery('#wpforms-form-12396 .wpforms-field-radio label').click(function() {

			jQuery(this).toggleClass('active');
			jQuery(this).next('ul').slideToggle();
		});

	
		jQuery('#wpforms-form-12396 .wpforms-field-radio ul li').click(function() {

			jQuery(this).find('input[type=radio]').prop("checked", true);
			jQuery(this).parent().prev('.wpforms-field-label').addClass('valid_active');
			jQuery(this).parent().prev('.wpforms-field-label').removeClass('active');
			jQuery(this).parent().slideUp();

			jQuery(this).parents('.wpforms-field-radio').next('.wpforms-field-radio').find('label').addClass('active');
			jQuery(this).parents('.wpforms-field-radio').next('.wpforms-field-radio').find('ul').slideDown();

		});
		
		// Toxicity Questionnaire Form
		jQuery('#wpforms-form-10366 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-10366 .wpforms-field-radio ul').first().show();
		
		jQuery('#wpforms-form-10366 #wpforms-10366-field_125-container label').addClass('active');
		jQuery('#wpforms-form-10366 #wpforms-10366-field_125-container ul').show();
		
		jQuery('#wpforms-form-10366 #wpforms-10366-field_126-container label').addClass('active');
		jQuery('#wpforms-form-10366 #wpforms-10366-field_126-container ul').show();
		
		jQuery('#wpforms-form-10366 #wpforms-10366-field_130-container label').addClass('active');
		jQuery('#wpforms-form-10366 #wpforms-10366-field_130-container ul').show();
		
		jQuery('#wpforms-form-10366 #wpforms-10366-field_135-container label').addClass('active');
		jQuery('#wpforms-form-10366 #wpforms-10366-field_135-container ul').show();
		
		jQuery('#wpforms-form-10366 #wpforms-10366-field_140-container label').addClass('active');
		jQuery('#wpforms-form-10366 #wpforms-10366-field_140-container ul').show();
		
		jQuery('#wpforms-form-10366 #wpforms-10366-field_154-container label').addClass('active');
		jQuery('#wpforms-form-10366 #wpforms-10366-field_154-container ul').show();
		
		jQuery('#wpforms-form-10366 #wpforms-10366-field_160-container label').addClass('active');
		jQuery('#wpforms-form-10366 #wpforms-10366-field_160-container ul').show();
		
		jQuery('#wpforms-form-10366 #wpforms-10366-field_165-container label').addClass('active');
		jQuery('#wpforms-form-10366 #wpforms-10366-field_165-container ul').show();
		
		jQuery('#wpforms-form-10366 #wpforms-10366-field_185-container label').addClass('active');
		jQuery('#wpforms-form-10366 #wpforms-10366-field_185-container ul').show();
		
		jQuery('#wpforms-form-10366 #wpforms-10366-field_193-container label').addClass('active');
		jQuery('#wpforms-form-10366 #wpforms-10366-field_193-container ul').show();
		
		jQuery('#wpforms-form-10366 #wpforms-10366-field_199-container label').addClass('active');
		jQuery('#wpforms-form-10366 #wpforms-10366-field_199-container ul').show();
		
		jQuery('#wpforms-form-10366 #wpforms-10366-field_204-container label').addClass('active');
		jQuery('#wpforms-form-10366 #wpforms-10366-field_204-container ul').show();
		
		jQuery('#wpforms-form-10366 #wpforms-10366-field_216-container label').addClass('active');
		jQuery('#wpforms-form-10366 #wpforms-10366-field_216-container ul').show(); 
		
		jQuery('#wpforms-form-10366 #wpforms-10366-field_220-container label').addClass('active');
		jQuery('#wpforms-form-10366 #wpforms-10366-field_220-container ul').show();
		
		
		jQuery('#wpforms-form-10366 .wpforms-page-2 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-10366 .wpforms-page-2 .wpforms-field-radio ul').first().show();
		
		jQuery('#wpforms-form-10366 .wpforms-page-3 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-10366 .wpforms-page-3 .wpforms-field-radio ul').first().show();
		
		jQuery('#wpforms-form-10366 .wpforms-page-4 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-10366 .wpforms-page-4 .wpforms-field-radio ul').first().show();
		
		jQuery('#wpforms-form-10366 .wpforms-page-5 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-10366 .wpforms-page-5 .wpforms-field-radio ul').first().show();

		// Mobile WP Forms
		jQuery('#wpforms-form-10366 .wpforms-field-radio label').click(function() {
		
			jQuery(this).toggleClass('active');
			jQuery(this).next('ul').slideToggle();
		
		});
		
		
		jQuery('#wpforms-form-10366 .wpforms-field-radio ul li').click(function() {
			jQuery(this).find('input[type=radio]').prop("checked", true);
			jQuery(this).parent().prev('.wpforms-field-label').addClass('valid_active');
			jQuery(this).parent().prev('.wpforms-field-label').removeClass('active');
			jQuery(this).parent().slideUp();
                        
			jQuery(this).parents('.wpforms-field-radio').next('.wpforms-field-radio').find('label').addClass('active');
			jQuery(this).parents('.wpforms-field-radio').next('.wpforms-field-radio').find('ul').slideDown();
                        
		});
		
		
		// Male Quiz Form
		jQuery('#wpforms-form-15063 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-15063 .wpforms-field-radio ul').first().show();

		// Mobile WP Forms

		jQuery('#wpforms-form-15063 .wpforms-field-radio label').click(function() {

			jQuery(this).toggleClass('active');
			jQuery(this).next('ul').slideToggle();
		});

	
		jQuery('#wpforms-form-15063 .wpforms-field-radio ul li').click(function() {

			jQuery(this).find('input[type=radio]').prop("checked", true);
			jQuery(this).parent().prev('.wpforms-field-label').addClass('valid_active');
			jQuery(this).parent().prev('.wpforms-field-label').removeClass('active');
			jQuery(this).parent().slideUp();

			jQuery(this).parents('.wpforms-field-radio').next('.wpforms-field-radio').find('label').addClass('active');
			jQuery(this).parents('.wpforms-field-radio').next('.wpforms-field-radio').find('ul').slideDown();

		});
		
		// FeMale Quiz Form
		jQuery('#wpforms-form-15062 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-15062 .wpforms-field-radio ul').first().show();

		// Mobile WP Forms

		jQuery('#wpforms-form-15062 .wpforms-field-radio label').click(function() {

			jQuery(this).toggleClass('active');
			jQuery(this).next('ul').slideToggle();
		});

	
		jQuery('#wpforms-form-15062 .wpforms-field-radio ul li').click(function() {

			jQuery(this).find('input[type=radio]').prop("checked", true);
			jQuery(this).parent().prev('.wpforms-field-label').addClass('valid_active');
			jQuery(this).parent().prev('.wpforms-field-label').removeClass('active');
			jQuery(this).parent().slideUp();

			jQuery(this).parents('.wpforms-field-radio').next('.wpforms-field-radio').find('label').addClass('active');
			jQuery(this).parents('.wpforms-field-radio').next('.wpforms-field-radio').find('ul').slideDown();

		});
		
		// FeMale Estrogen Quiz Form
		jQuery('#wpforms-form-15061 .wpforms-field-radio label').first().addClass('active');
		jQuery('#wpforms-form-15061 .wpforms-field-radio ul').first().show();

		// Mobile WP Forms

		jQuery('#wpforms-form-15061 .wpforms-field-radio label').click(function() {

			jQuery(this).toggleClass('active');
			jQuery(this).next('ul').slideToggle();
		});

	
		jQuery('#wpforms-form-15061 .wpforms-field-radio ul li').click(function() {

			jQuery(this).find('input[type=radio]').prop("checked", true);
			jQuery(this).parent().prev('.wpforms-field-label').addClass('valid_active');
			jQuery(this).parent().prev('.wpforms-field-label').removeClass('active');
			jQuery(this).parent().slideUp();

			jQuery(this).parents('.wpforms-field-radio').next('.wpforms-field-radio').find('label').addClass('active');
			jQuery(this).parents('.wpforms-field-radio').next('.wpforms-field-radio').find('ul').slideDown();

		});
	}
	
	if(jQuery(window).width() > 767) {
		 
		// Health Quiz Form jS
		var formHTML = '<div class="form-label-row fixed-header"><div class="left-box"><label>Symptom </label></div><div class="right-box"><ul><li><label>None</label></li><li><label>Mild</label></li><li><label>Moderate</label></li><li><label>Severe</label></li></ul></div></div>';
		
		jQuery('#wpforms-form-10367 .wpforms-page-indicator-page-progress-wrap').after(formHTML);
		
		// Toxicity Quiz Form jS
		var formHTML1 = '<div class="form-label-row fixed-header"><div class="left-box"><label>Symptom </label></div><div class="right-box"><ul><li><label>Never</label></li><li><label>Occasionally but not severe</label></li><li><label>Occasionally and severe</label></li><li><label>Frequently but not severe</label></li><li><label>Frequently and severe</label></li></ul></div></div>';
		
		jQuery('#wpforms-form-10366 .wpforms-page-indicator-page-progress-wrap').after(formHTML1);
		
		// Male Quiz Form jS
		var maleformHTML = '<div class="form-label-row fixed-header"><div class="left-box"><label></label></div><div class="right-box"><ul><li><label>Yes</label></li><li><label>No</label></li></ul></div></div>';
		var femaleformHTML = '<div class="form-label-row fixed-header"><div class="left-box"><label></label></div><div class="right-box"><ul><li><label>Yes</label></li><li><label>No</label></li></ul></div></div>';
		var femaleEstrogenformHTML = '<div class="form-label-row fixed-header"><div class="left-box"><label></label></div><div class="right-box"><ul><li><label>Yes</label></li><li><label>No</label></li></ul></div></div>';
		
		jQuery('#wpforms-form-15063 .wpforms-page-indicator-page-progress-wrap').after(maleformHTML);
		jQuery('#wpforms-form-15062 .wpforms-page-indicator-page-progress-wrap').after(femaleformHTML);
		jQuery('#wpforms-form-15061 .wpforms-page-indicator-page-progress-wrap').after(femaleEstrogenformHTML);
		
	}

});


// Fixed Header
jQuery(function($) {
	
	if($(window).width() > 767) {

		$(window).scroll(function fix_element() {
			$('.wpforms-page-indicator').css(
			  $(window).scrollTop() > 200
				? { 'position': 'fixed', 'top': '110px', 'width' : '90.2%' } 
				: { 'position': 'relative', 'top': 'auto', 'width' : '100%' }
			);
			
			return fix_element;
		}());
	}
});