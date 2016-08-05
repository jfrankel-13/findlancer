<?php
/**
 * Menu Settings
 *
 * @uses $wp_customize
 * @since 1.5.0
 */

// cart icon
$wp_customize->add_setting( 'nav-cart', array(
	'default' => true
) );

$wp_customize->add_control( 'nav-cart', array(
	'label' => __( 'Display cart icon', 'listify' ),
	'type' => 'checkbox',
	'priority' => 10,
	'section' => 'nav-menus'
) );

// search icon
$wp_customize->add_setting( 'nav-search', array(
	'default' => true
) );

$wp_customize->add_control( 'nav-search', array(
	'label' => __( 'Display search icon', 'listify' ),
	'type' => 'checkbox',
	'priority' => 20,
	'section' => 'nav-menus'
) );

// secondary menu
$wp_customize->add_setting( 'nav-secondary', array(
	'default' => true
) );

$wp_customize->add_control( 'nav-secondary', array(
	'label' => __( 'Display secondary menu', 'listify' ),
	'type' => 'checkbox',
	'priority' => 30,
	'section' => 'nav-menus'
) );

// megamenu
$wp_customize->add_setting( 'nav-megamenu', array(
	'default' => 'job_listing_category'
) );

$wp_customize->add_control( 'nav-megamenu', array(
	'label' => __( 'Secondary Mega Menu', 'listify' ),
	'type' => 'select',
	'choices' => array_merge( array( 'none' => __( 'None', 'listify' ) ), Listify_Customizer_Utils::get_taxonomy_choices() ),
	'priority' => 40,
	'section' => 'nav-menus'
) );
