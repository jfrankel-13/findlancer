<?php
/**
 * Listings Results
 *
 * @uses $wp_customize
 * @since 1.5.0
 */
global $listify_strings;

$wp_customize->add_section( 'listing-results', array(
	'title' => sprintf( __( '%s Results', 'listify' ), $listify_strings->label( 'singular' ) ),
	'panel' => 'listings',
	'priority' => 20
) );
