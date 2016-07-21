<?php
/**
 * Page for Posts
 *
 * Move this default control to a new section and rename it.
 *
 * @uses $wp_customize
 * @since 1.5.0
 */
if ( ! defined( 'ABSPATH' ) || ! $wp_customize instanceof WP_Customize_Manager ) {
	exit; // Exit if accessed directly.
}

$wp_customize->get_control( 'page_for_posts' )->label = __( 'Blog Page', 'listify' );
$wp_customize->get_control( 'page_for_posts' )->section = 'content-blog';
$wp_customize->get_control( 'page_for_posts' )->priority = 5;
