<?php
if ( have_rows( 'page_builder' ) ):
	while ( have_rows( 'page_builder' ) ) : the_row();

		//Hero Section
		if( get_row_layout() == 'hero_section' ):
			get_template_part( 'template-parts/acf-section/section/hero', 'section' );
		endif;

		//Image / Text Section
		if( get_row_layout() == 'image_text_section' ):
			get_template_part( 'template-parts/acf-section/section/image-text', 'section' );
		endif;

		//Seo Section
		if( get_row_layout() == 'seo_section' ):
			get_template_part( 'template-parts/acf-section/section/seo', 'section' );
		endif;

		//Team Section
		if( get_row_layout() == 'team_section' ):
			get_template_part( 'template-parts/acf-section/section/team', 'section' );
		endif;

		//Step Section
		if( get_row_layout() == 'step_section' ):
			get_template_part( 'template-parts/acf-section/section/step', 'section' );
		endif;

		//Pricing Section
		if( get_row_layout() == 'pricing_section' ):
			get_template_part( 'template-parts/acf-section/section/pricing', 'section' );
		endif;

		//Logo Section
		if( get_row_layout() == 'logo_section' ):
			get_template_part( 'template-parts/acf-section/section/logo', 'section' );
		endif;

		//Indicators Section
		if( get_row_layout() == 'indicators_section' ):
			get_template_part( 'template-parts/acf-section/section/indicators', 'section' );
		endif;

		//Indicators Section
		if( get_row_layout() == 'analyze_section' ):
			get_template_part( 'template-parts/acf-section/section/analyze', 'section' );
		endif;


	endwhile;
endif;
?>
