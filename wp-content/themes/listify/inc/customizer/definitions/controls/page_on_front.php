<?php
/**
 * Page on Front
 *
 * Rename this default control.
 *
 * @uses $wp_customize
 * @since 1.5.0
 */
if ( ! defined( 'ABSPATH' ) || ! $wp_customize instanceof WP_Customize_Manager ) {
	exit; // Exit if accessed directly.
}

$wp_customize->get_control( 'page_on_front' )->label = __( 'Homepage', 'listify' );
