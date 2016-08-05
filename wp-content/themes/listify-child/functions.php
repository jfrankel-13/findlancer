<?php
/**
 * Listify child theme.
 */

function listify_child_styles() {
    wp_enqueue_style( 'listify-child', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'listify_child_styles', 999 );

/** Place any new code below this line */

/**
 * Scripts and Styles
 *
 * Load Styles and Scripts depending on certain conditions. Not all assets
 * will be loaded on every page.
 *
 * @since Listify 1.0.0
 *
 * @return void
 */
function listify_scripts() {
    /*
     * Collect all the custom styles
     */
    do_action( 'listify_output_customizer_css' );

	/** Output Google fonts if set */
	if ( false !== ( $url = Listify_Customizer::$fonts->get_google_font_url() ) ) {
		wp_enqueue_style( 'listify-fonts', esc_url( $url ) );
	}

    wp_enqueue_style( 'listify', get_template_directory_uri() . '/css/style.min.css', array(), 20160622 );
    wp_style_add_data( 'listify', 'rtl', 'replace' );

    /* Custom CSS */
	wp_add_inline_style( 'listify', Listify_Customizer_CSS::build() );

    /*
     * Scripts
     */

    /* Comments */
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    $deps = array( 'jquery' );

    if ( listify_has_integration( 'wp-job-manager-regions' ) && get_option( 'job_manager_regions_filter' ) ) {
        $deps[] = 'job-regions';
    }

    wp_enqueue_script( 'listify', get_template_directory_uri() . '/js/app.min.js', $deps, 20160622, true );
    wp_enqueue_script( 'salvattore', get_template_directory_uri() . '/js/vendor/salvattore.min.js', array(), '', true );
    wp_enqueue_script( 'flexibility', get_template_directory_uri() . '/js/vendor/salvattore.min.js', array(), '', true );
	wp_script_add_data( 'flexibility', 'conditional', 'lt IE 11' );

    wp_localize_script( 'listify', 'listifySettings', apply_filters( 'listify_js_settings', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'homeurl' => home_url( '/' ),
        'archiveurl' => get_post_type_archive_link( 'job_listing' ),
        'is_job_manager_archive' => listify_is_job_manager_archive(),
		'is_rtl' => is_rtl(),
        'megamenu' => array(
            'taxonomy' => listify_theme_mod( 'nav-megamenu', 'job_listing_category' ) 
        ),
        'l10n' => array(
            'closed' => __( 'Closed', 'listify' ),
			'timeFormat' => get_option( 'time_format' ),
			'magnific' => array(
				'tClose' => __( 'Close', 'listify' ),
				'tLoading' => __( 'Loading...', 'listify' ),
				'tError' => __( 'The content could not be loaded.', 'listify' )
			)
        )
    ) ) );
}
add_action( 'wp_enqueue_scripts', 'listify_scripts' );