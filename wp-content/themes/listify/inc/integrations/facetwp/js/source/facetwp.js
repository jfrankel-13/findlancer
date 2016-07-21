(function($) {
	'use strict';

	var listifyFacetWP = {
		cache: {
			$document: $(document),
			$window: $(window)
		},

		init: function() {
			this.bindEvents();
		},

		bindEvents: function() {
			var self = this;

			$(document).on( 'ready', function() {
				self.megamenu();
				self.sorting();
				self.moreFilters();
			});
		},

		megamenu: function() {
			$( 'body.facetwp .category-list a' ).click(function() {
				window.location.hash = '';
				window.location.href = $(this).attr( 'href' );
				window.location.reload();
			});

			$( 'body.facetwp #job_listing_tax_mobile select' ).change(function(e) {
        if ( ! FWP.length ) {
          return;
        }
        var selected = $(this).find( ':selected' ).val();

				if ('get' == FWP.permalink_type) {
					var url = listifySettings.archiveurl + '?' + listifySettings.megamenu.facet + '=' + selected;
				} else {
				  var url = listifySettings.archiveurl + '#!/' + listifySettings.megamenu.facet + '=' + selected;
				}

        window.location.href = url;
			});
		},

		sorting: function() {
			var self = this;

			this.cache.$document.on( 'facetwp-loaded facetwp-refresh', function() {
				$( '.facetwp-sort-select' ).wrap( '<span class="select"></span>' );
			});
		},

		moreFilters: function() {
			this.cache.$document.on( 'click', '.js-toggle-more-filters', function() {
				var hideText = $(this).data( 'label-hide' );
				var showText = $(this).data( 'label-show' );

				var $button = $(this);
				var $filters = $( '.more-filters__filters' );

				$filters.slideToggle( 'fast', function() {
					$button.text( $filters.is( ':visible' ) ? hideText : showText );
				}	);
			});
		}
	};

	listifyFacetWP.init();

})(jQuery);
