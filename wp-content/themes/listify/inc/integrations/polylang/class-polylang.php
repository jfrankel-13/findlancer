<?php
/**
 * Polylang
 */

class Listify_Polylang extends Listify_Integration {

    public function __construct() {
        $this->includes = array();
        $this->integration = 'polylang';

        parent::__construct();
    }

    public function setup_actions() {
        if ( is_admin() ) {
            return;
        }

        if ( ! function_exists( 'pll_default_language' ) ) {
            return;
        }

        add_filter( 'get_job_listings_query_args', array( $this, 'shim_untranslated' ), 9999, 2 );
    }

    public function shim_untranslated( $query_args, $args ) {
        $def_lang = pll_default_language();
        $cur_lang = pll_current_language();
        $mixed    = $cur_lang != $def_lang;

        if ( apply_filters( 'listify_polylang_only_selected', false ) ) {
            return $query_args;
        }

        if ( isset( $query_args[ 'tax_query' ] ) && $mixed ) {
            $taxes = $query_args[ 'tax_query' ];

            foreach ( $taxes as $key => $tax ) {
                $terms = $tax[ 'terms' ];
                $trans = array();

                if ( is_array( $terms ) ) {
                    foreach ( $terms as $term ) {
                        // annoying since we have slugs but get an id but need back to slugs
                        $obj   = get_term_by( 'slug', $term, $tax[ 'taxonomy' ] );
                        $trans = pll_get_term( $obj->term_id, $def_lang );
                        $trans = get_term_by( 'id', $trans, $tax[ 'taxonomy' ] );

                        $query_args[ 'tax_query' ][ $key ][ 'terms' ] = array_merge( $terms, array( $trans->slug ) );
                    }
                }
            }
        }

        $terms   = get_terms( 'post_translations' );
        $exclude = array();

        foreach( $terms as $translation ){
            $trans = unserialize( $translation->description );

            if ( $mixed && isset( $trans[ $def_lang ] ) ) {
                $exclude[] = $trans[ $def_lang ];
            }
        }

        if ( $mixed ) {
            if ( isset( $query_args[ 'post__in' ] ) ) {
                $query_args[ 'post__in' ] = array_diff( $query_args[ 'post__in' ], $exclude );
                unset( $query_args[ 'post__not_in' ] );
            } else {
                $query_args[ 'post__not_in' ] = $exclude;
            }
        }

        return $query_args;
    }

}

$GLOBALS[ 'listify_polylang' ] = new Listify_Polylang();
