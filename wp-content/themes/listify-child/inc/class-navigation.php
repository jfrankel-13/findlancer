<?php

class Listify_Navigation {

    public function __construct() {
        add_filter( 'wp_page_menu_args', array( $this, 'always_show_home' ) );

        add_filter( 'nav_menu_css_class', array( $this, 'popup_trigger_class' ), 10, 3 );

        // tertiary
        add_action( 'listify_page_before', array( $this, 'tertiary_menu' ) );

        // avatar
        add_filter( 'walker_nav_menu_start_el', array( $this, 'avatar_item' ), 10, 4 );
        add_filter( 'nav_menu_css_class', array( $this, 'avatar_item_class' ), 10, 3 );

        // search
        add_filter( 'wp_nav_menu_items', array( $this, 'search_icon' ), 1, 2 );

        // megamenu
        add_filter( 'wp_nav_menu_items', array( $this, 'taxonomy_mega_menu' ), 0, 2 );
    }

    /**
     * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
     */
    public function always_show_home( $args ) {
        $args['show_home'] = true;

        return $args;
    }

    /**
     * Custom Account menu item.
     *
     * Look for a menu item with a title of `{{account}}` and replace the
     * content with information about the current account.
     *
     * @since Listify 1.0.0
     *
     * @param string $item_output
     * @param object $item
     * @param int $depth
     * @param array $args
     * @return string $item_output
     */
    public function avatar_item( $item_output, $item, $depth, $args ) {
        if ( '{{account}}' != $item->title ) {
            return $item_output;
        }

        $user = wp_get_current_user();

        if ( ! is_user_logged_in() ) {
            $display_name = apply_filters( 'listify_account_menu_guest_label', __( 'Guest', 'listify' ) );

            $avatar = '';
        } else {
            if ( $user->first_name ) {
                $display_name = $user->first_name;
            } else {
                $display_name = $user->display_name;
            }

            $display_name = apply_filters( 'listify_acount_menu_user_label', $display_name, $user );

            $avatar =
            '<div class="current-account-avatar" data-href="' . esc_url( apply_filters( 'listify_avatar_menu_link', get_author_posts_url( $user->ID, $user->user_nicename ) ) ) .
            '">' .
                    get_avatar( $user->ID, 90 )
            . '</div>';
        }

        $item_output = str_replace( '{{account}}', $avatar . $display_name, $item_output );

        return $item_output;
    }

    /**
     * If the menu item has the `{{account}}` tag add a custom class to the item.
     *
     * @see listify_account_walker_nav_menu_start_el()
     *
     * @since Listify 1.0.0
     *
     * @param array $classes
     * @param object $item
     * @param array $args
     * @return array $classes
     */
    public function avatar_item_class( $classes, $item, $args ) {
        if ( 'primary' != $args->theme_location ) {
            return $classes;
        }

        if ( '{{account}}' != $item->title || ! is_user_logged_in() ) {
            return $classes;
        }

        $classes[] = 'account-avatar';

        return $classes;
    }

    public function popup_trigger_class( $classes, $item, $args ) {
        $popup = array_search( 'popup', $classes );

        if ( false === $popup ) {
            remove_filter( 'nav_menu_link_attributes', array( $this, 'popup_trigger_attributes' ), 10, 3 );

            return $classes;
        } else {
            unset( $classes[ $popup ] );

            add_filter( 'nav_menu_link_attributes', array( $this, 'popup_trigger_attributes' ), 10, 3 );
        }

        return $classes;
    }

    public function popup_trigger_attributes( $atts, $item, $args ) {
        $atts[ 'class' ] = 'popup-trigger-ajax';

        if ( in_array( 'popup-wide', $item->classes ) ) {
            $atts[ 'class' ] .= ' popup-wide';
        }

        return $atts;
    }

    public function search_icon( $items, $args ) {
        if ( 'primary' != $args->theme_location || ! listify_theme_mod( 'nav-search', true ) ) {
            return $items;
        }

        if ( listify_has_integration( 'facetwp' ) ) {
            return '<li class="menu-item menu-type-link"><a href="' . get_post_type_archive_link( 'job_listing' ) . '" class="search-overlay-toggle"></a></li>' . $items;
        } else {
            return '<li class="menu-item menu-type-link"><a href="#search-header" data-toggle="#search-header" class="search-overlay-toggle"></a></li>' . $items;
        }
    }

    function tertiary_menu() {
        global $post, $wp_query, $listify_woocommerce;

        $enabled = (bool) get_post_meta( $post->ID, 'enable_tertiary_navigation', true );
		$is_my_account_page = get_option( 'woocommerce_myaccount_page_id' ) && is_page( get_option( 'woocommerce_myaccount_page_id' ) );

		// force on my account page
		if ( $is_my_account_page ) {
			$enabled = 1;
		}

        if ( ! $enabled ) {
            return;
        }

        // hack based on where our page titles fall
        $wp_query->in_the_loop = false;

        ob_start();

        wp_nav_menu( array(
            'theme_location' => 'tertiary',
            'container_class' => 'navigation-bar tertiary nav-menu',
			'menu_class' => 'tertiary nav-menu',
			'fallback_cb' => false
        ) );

        $menu = ob_get_clean();

        if ( '' == $menu && ! $is_my_account_page ) {
            return;
		} elseif ( listify_has_integration( 'woocommerce' ) && ( '' == $menu ) && $is_my_account_page ) {
			$menu = $listify_woocommerce->template->account->my_account_menu();
		}

		if ( '' == $menu ) {
			return;
		}

        remove_filter( 'the_title', 'wc_page_endpoint_title' );
    ?>
        <nav class="tertiary-navigation">
            <div class="container">
                <a href="#" class="navigation-bar-toggle">
                    <i class="ion-navicon-round"></i>
                    <?php echo listify_get_theme_menu_name( 'tertiary' ); ?>
                </a>
                <div class="navigation-bar-wrapper">
                    <?php echo $menu; ?>
                </div>
            </div>
        </nav><!-- #site-navigation -->
    <?php
        add_filter( 'the_title', 'wc_page_endpoint_title' );
    }

    public function taxonomy_mega_menu( $items, $args ) {
        if ( 'none' == ( $taxonomy = listify_theme_mod( 'nav-megamenu', 'job_listing_category' ) ) ) {
            return $items;
        }

        if ( 'secondary' != $args->theme_location ) {
            return $items;
        }

        $taxonomy = get_taxonomy( $taxonomy );

        if ( is_wp_error( $taxonomy ) ) {
            return $items;
        }

        global $listify_strings;

        $link = sprintf( 
            '<a href="%s">' . __( 'Browse %s', 'listify' ) . '</a>',
            get_post_type_archive_link( 'job_listing' ), 
            str_replace( $listify_strings->label( 'singular' ) . ' ', '', $taxonomy->labels->name )
        );

		$args = apply_filters( 'listify_mega_menu_list', array( 
			'taxonomy' => $taxonomy->name,
			'parent' => 0,
			'orderby' => 'name'
		) );

		if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
			$args[ 'lang' ] = apply_filters( 'wpml_current_language', NULL );
		} elseif ( function_exists( 'pll_current_language' ) ) {
			$args[ 'lang' ] = pll_current_language();
		}

		$terms = listify_get_terms(  );
		$submenu = $dropdown = array();

		if ( empty( $terms ) ) {
			return $items;
		}

		foreach ( $terms as $term ) {
			$submenu[] = sprintf( 
				'<a href="%s" title="%s"><span class="category-count">%d</span>%s</a>',
				get_term_link( $term ),
				sprintf( __( 'View all listings in %s', 'listify' ), $term->name ),
				absint( $term->count ),
				esc_attr( $term->name )
			);

			$dropdown[] = sprintf(
				'<option value="%s">%s&nbsp;(%d)</option>',
				esc_attr( $term->slug ),
				esc_attr( $term->name ),
				absint( $term->count )
			);
		}

		$submenu = '<ul><li>' . implode( '</li><li>', $submenu ) . '</li></ul>';
		$dropdown = '<select class="postform" name="' . $taxonomy->name . '" id="' . $taxonomy->name . '">' . implode( '', $dropdown ) . '</select>';

        $submenu =
            '<ul class="sub-menu category-list">' .
                '<form id="job_listing_tax_mobile" action="' . home_url() . '" method="get">' . $dropdown . '</form>
                <div class="container">
                    <div class="mega-category-list-wrapper">' . $submenu . '</div>
                </div>
            </ul>';

        return '<li id="categories-mega-menu" class="ion-navicon-round menu-item menu-type-link">'. $link . $submenu . '</li>' . $items;
    }
}

$GLOBALS[ 'listify_navigation' ] = new Listify_Navigation();
