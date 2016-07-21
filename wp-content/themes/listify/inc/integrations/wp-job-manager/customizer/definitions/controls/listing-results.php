<?php
/**
 * Listing Results
 *
 * Lazy in one file for now.
 *
 * @uses $wp_customize
 * @since 1.5.0
 */

// output
$wp_customize->add_setting( 'listing-archive-output', array(
	'default' => 'map-results'
) );

$wp_customize->add_control( 'listing-archive-output', array(
	'label' => __( 'Display', 'listify' ),
	'type' => 'select',
	'choices' => array(
		'results' => __( 'Results Only', 'listify' ),
		'map-results' => __( 'Map & Results', 'listify' )
	),
	'priority' => 10,
	'section' => 'listing-results'
) );

// position
$wp_customize->add_setting( 'listing-archive-map-position', array(
	'default' => 'side'
) );

$wp_customize->add_control( 'listing-archive-map-position', array(
	'label' => __( 'Map Position', 'listify' ),
	'type' => 'select',
	'choices' => array(
		'side' => __( 'Side (fixed)', 'listify' ),
		'top'  => __( 'Top', 'listify' )
	),
	'priority' => 20,
	'section' => 'listing-results'
) );

// display style
$wp_customize->add_setting( 'listing-archive-display-style', array(
	'default' => 'grid'
) );

$wp_customize->add_control( 'listing-archive-display-style', array(
	'label' => __( 'Listing Card Default Style', 'listify' ),
	'type' => 'select',
	'choices' => array(
		'grid' => __( 'Grid', 'listify' ),
		'list' => __( 'List', 'listify' )
	),
	'priority' => 30,
	'section' => 'listing-results'
) );

// featured style
$wp_customize->add_setting( 'listing-archive-feature-style', array(
	'default' => 'outline'
) );

$wp_customize->add_control( 'listing-archive-feature-style', array(
	'label' => __( 'Featured Listing Style', 'listify' ),
	'type' => 'select',
	'choices' => array(
		'outline' => __( 'Outline', 'listify' ),
		'badge' => __( 'Badge', 'listify' )
	),
	'priority' => 30,
	'section' => 'listing-results'
) );

// company image
$wp_customize->add_setting( 'listing-archive-card-avatar', array(
	'default' => 'none'
) );

$wp_customize->add_control( 'listing-archive-card-avatar', array(
	'label' => __( 'Listing Card Secondary Image', 'listify' ),
	'type' => 'select',
	'choices' => array(
		'none' => __( 'None', 'listify' ),
		'avatar' => __( 'Listing Owner Avatar', 'listify' ),
		'logo' => __( 'Company Logo', 'listify' )
	),
	'priority' => 40,
	'section' => 'listing-results'
) );

// company image style
$wp_customize->add_setting( 'listing-archive-card-avatar-style', array(
	'default' => 'circle'
) );

$wp_customize->add_control( 'listing-archive-card-avatar-style', array(
	'label' => __( 'Listing Card Secondary Image Style', 'listify' ),
	'type' => 'select',
	'choices' => array(
		'square' => __( 'Square', 'listify' ),
		'circle' => __( 'Circle', 'listify' )
	),
	'priority' => 50,
	'section' => 'listing-results'
) );

// new window
$wp_customize->add_setting( 'listing-archive-window', array(
	'default' => false
) );

$wp_customize->add_control( 'listing-archive-window', array(
	'label' => __( 'Open listings in a new tab/window', 'listify' ),
	'type' => 'checkbox',
	'priority' => 60,
	'section' => 'listing-results'
) );
