<?php
/**
 * Listing
 *
 * @uses $wp_customize
 * @since 1.5.0
 */
global $listify_strings;

$wp_customize->add_section( 'single-listing', array(
	'title' => sprintf( __( '%s Layout', 'listify' ), $listify_strings->label( 'singular' ) ),
	'panel' => 'listings',
	'priority' => 30
) );
