<?php
/**
 * FacetWP
 *
 * @uses $wp_customize
 * @since 1.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! listify_has_integration( 'facetwp' ) ) {
	return;
}

$wp_customize->add_section( 'facetwp', array(
	'title' => _x( 'FacetWP', 'customizer section title', 'listify' ),
	'panel' => 'listings',
	'priority' => 15
) );
