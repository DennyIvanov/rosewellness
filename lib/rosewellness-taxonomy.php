<?php

/****** Create Taxonomies *********/

add_action( 'init', 'team_regions_init' );

function team_regions_init() {
	// create a new taxonomy
	register_taxonomy(
		'team_roles',
		'team',
		array(
			'label' => __( 'Team Roles' ),
			'rewrite' => array( 'slug' => 'property_regions' ),
			'hierarchical' => true,
		)
	);
}

add_action( 'init', 'team_location_init' );

function team_location_init() {
	register_taxonomy(
		'team_location',
		'team',
		array(
			'label' => __( 'Team Location' ),
			'rewrite' => array( 'slug' => 'team_location' ),
			'hierarchical' => true,
		)
	);
}