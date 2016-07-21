<?php
/**
 * Steps for the setup guide.
 * @since 1.5.0
 */

/** Create the steps */
$steps = array();

$steps[ 'install-plugins' ] = array(
	'title' => __( 'Install Required &amp; Recommended Plugins', 'listify' ),
	'completed' => class_exists( 'WP_Job_Manager' ) && class_exists( 'WooCommerce' )
);

$steps[ 'import-content' ] = array(
	'title' => __( 'Import Demo Content', 'listify' ),
	'completed' => get_page_by_path( 'my-account' )
);

$steps[ 'import-widgets' ] = array(
	'title' => __( 'Import Widgets', 'listify' ),
	'completed' => is_active_sidebar( 'widget-area-home' )
);

$mods = get_theme_mods();

$steps[ 'setup-menus' ] = array(
	'title' => __( 'Setup Menus', 'listify' ),
	'completed' => isset( $mods[ 'nav_menu_locations' ] )
);

$steps[ 'setup-homepage' ] = array(
	'title' => __( 'Setup Static Homepage', 'listify' ),
	'completed' => get_option( 'page_on_front' )
);

$steps[ 'setup-widgets' ] = array(
	'title' => __( 'Setup Widgets', 'listify' ),
	'completed' => is_active_sidebar( 'widget-area-home' )
);

$steps[ 'customize-theme' ] = array(
	'title' => __( 'Customize', 'listify' ),
	'completed' => $mods
);

$steps[ 'support-us' ] = array(
	'title' => __( 'Get Involved', 'listify' ),
	'completed' => 'n/a'
);

return $steps;
