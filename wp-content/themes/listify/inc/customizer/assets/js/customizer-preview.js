/* global wp, jQuery */
(function($){

	var _window = $(window),
		api = wp.customize,
		ListifyPreview = {}
	
	// selective refresh
	_window.load( function() {
		var isCustomizeSelectiveRefresh = ( 'undefined' !== typeof wp && wp.customize && wp.customize.selectiveRefresh );

		if ( ! isCustomizeSelectiveRefresh ) {
			return;
		}

		// update salvattore
		wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function() {
			$.each( $( 'div[data-columns]' ), function() {
				if ( ! $(this).data( 'columns' ) ) {
					salvattore[ 'registerGrid' ]( this );
				}
			} );
		} );

		// update single listing map
		wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function( partial ) {
			if ( wp.listify && wp.listify.listing ) {
				wp.listify.listing.map();
			}
		} );

		// update single listing slider
		wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function( partial ) {
			if ( wp.listify && wp.listify.listing ) {
				wp.listify.listing.gallerySlider();
			}
		} );
	} );

})(jQuery);
