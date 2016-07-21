<?php

class Listify_FacetWP_Template extends Listify_FacetWP {

    public function __construct() {
		// to avoid loading google twice
		add_filter( 'facetwp_proximity_load_js', array( $this, 'proximity_maybe_load_js' ) );

        // Archive Listings
        remove_all_actions( 'listify_output_results' );
        add_action( 'listify_output_results', array( $this, 'output_results' ), 20 );
        add_action( 'listify_output_results', array( $this, 'output_filters' ) );

        add_action( 'archive_job_listing_layout_before', array( $this, 'archive_job_listing_layout_before' ) );

        if ( 'side' == $this->position() ) {
            add_action( 'listify_sidebar_archive_job_listing_after', array( $this, 'output_filters' ) );
        } else {
            add_action( 'listify_output_results', array( $this, 'output_filters' ), 10 );
        }

        add_filter( 'term_link', array( $this, 'term_link' ), 10, 3 );

		// enqueue scripts when results are loaded
		global $listify_job_manager;
		add_action( 'listify_facetwp_sort', array( $listify_job_manager->map->template, 'enqueue_scripts' ) );
    }

	/**
	 * Maybe Load the Proximity JS
	 *
	 * If we are on a page that has sortable listings then we do not need
	 * to enqueue this. Otherwise allow it to come through so autolocation works.
	 *
	 * @since 1.5.0
	 * @return boolean
	 */
	public function proximity_maybe_load_js() {
		return ! wp_script_is( 'listify-app-map', 'enqueued' );
	}

	/**
	 * Output filters.
	 *
	 * Build HTML around the actual facet outputs. These can either be output above the results
	 * or to the side, depending on the Customizer settings.
	 *
	 * @since unknown
	 * @return void
	 */
    public function output_filters() {
        global $listify_facetwp;

        if ( did_action( 'listify_output_results' ) && 'side' == $this->position() ) {
            return;
        }

		$front = false;
		$key = 'listing-archive-facetwp-defaults';
		$more_facets = $listify_facetwp->get_facets( get_theme_mod( 'listing-archive-facetwp-more', array() ) );

		if ( is_front_page() && is_page_template( 'page-templates/template-home.php' ) ) {
			$front = true;
			$key = 'listing-archive-facetwp-home';
			$more_facets = array();
		}

		$default_facets = $listify_facetwp->get_facets( get_theme_mod( $key, array( 'keyword', 'location', 'category' ) ) );
?>

<a href="#" data-toggle=".job_filters" class="js-toggle-area-trigger"><?php _e( 'Toggle Filters', 'listify' ); ?></a>

<div class="facets job_filters <?php if ( ! $front ) : ?>content-box<?php endif; ?> <?php echo esc_attr( $this->position() ); ?>">
	<?php echo $this->output_facet_html( $default_facets ); ?>

	<?php if ( ! empty( $more_facets ) ) : ?>
		<div class="more-filters">
			<button class="more-filters__toggle js-toggle-more-filters" data-label-show="<?php _e( 'More Filters', 'listify' ); ?>" data-label-hide="<?php _e( 'Fewer Filters', 'listify' ); ?>"><?php _e( 'More Filters', 'listify' ); ?></button>

			<div class="more-filters__filters">
				<?php echo $this->output_facet_html( $more_facets ); ?>
			</div>
		</div>
	<?php endif; ?>
</div>

<?php
    }

	/**
	 * Output sorting options.
	 *
	 * @since unnknown
	 * @return void
	 */
    public function archive_job_listing_layout_before() {
        echo facetwp_display( 'sort' );
    }

	/**
	 * Output results.
	 *
	 * @since unknown
	 * @return void
	 */
    public function output_results() {
        do_action( 'listify_facetwp_sort' );
?>

<div class="facetwp_job_listings">
	<ul class="job_listings">
		<?php echo facetwp_display( 'template', 'listings' ); ?>
	</ul>
</div>

<?php echo facetwp_display( 'pager' ); ?>

<?php
    }

	/**
	 * Output facets with their relevant markup
	 *
	 * @since 1.5.0
	 * @return void
	 */
    public function output_facet_html( $facets = array() ) {
        global $listify_facetwp;

        $output = array();

		if ( empty( $facets ) ) {
			return;
		}

        foreach ( $facets as $key => $facet ) {
			$output[] = '
				<aside class="facetwp-filter facetwp-filter-' . esc_attr( $facet[ 'type' ] ) . ' widget-job_listing-archive">
					<h2 class="widget-title">' . esc_attr( facetwp_i18n( $facet[ 'label' ] ) ) . '</h2>' . 
					facetwp_display( 'facet', $facet['name'] ) . '
				</aside>';
        }

        return implode( '', $output );
    }

	/**
	 * Get the position the facets are output.
	 *
	 * Because you can select "invalid" options in the customizer.
	 *
	 * @since unknown
	 * @return string $position
	 */
    public function position() {
        global $listify_job_manager;

        if ( ! $listify_job_manager ) {
            return false;
        }

        $position = listify_theme_mod( 'listing-archive-facetwp-position', 'side' );

        // Force if the map is already on the side
        if ( ( 'side' == $listify_job_manager->map->template->position() && $listify_job_manager->map->template->display() ) || listify_is_widgetized_page() ) {
            $position = 'top';
        }

        return $position;
    }

	/**
	 * Filter the term links.
	 *
	 * If a facet exists with the taxonmy as a data source then rewrite
	 * the URL to use the FacetWP sorting options.
	 *
	 * @since unknown
	 * @param string $link
	 * @param object $term WP_Term
	 * @param object $taxonomy WP_Taxonomy
	 * @return string $link
	 */
    public function term_link( $link, $term, $taxonomy ) {
        $facets = FWP()->helper->get_facets();
        $taxes  = $sources = array();

        $permalink = FWP()->helper->get_setting( 'term_permalink', 'slug' );
        $permalink_type = FWP()->helper->get_setting( 'permalink_type', 'get' );

        $term = 'term_id' == $permalink ? $term->term_id : $term->slug;

        if ( empty( $facets ) ) {
            return $link;
        }

        foreach ( $facets as $facet ) {
            if ( isset( $facet[ 'source' ] ) ) {
                $sources[ $facet[ 'name' ] ] = $facet[ 'source' ];
            }
        }

        if ( empty( $sources ) ) {
            return $link;
        }

        foreach ( $sources as $name => $source ) {
            $source = str_replace( 'tax/', '', $source );

            if ( $taxonomy == $source ) {
                $post_type = get_post_type_archive_link( 'job_listing' );

                if ( 'get' == $permalink_type ) {
                    $url = add_query_arg( 'fwp_' . $name, $term, $post_type );
                } else {
                    $url = $post_type . '#!/' . $name . '=' . $term;
                }

                return esc_url( $url );
            }
        }

        return $link;
    }

}
