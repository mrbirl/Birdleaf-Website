(function($) {
	"use strict";

	window.THB_Lightbox = function() {

		/**
		 * Images in galleries.
		 *
		 * @type {string}
		 */
		this.galleriesSelector = ".thb-gallery, .gallery, .thb-images-container";

		/**
		 * Images.
		 *
		 * @type {string}
		 */
		this.imagesSelector = ".thb-lightbox[href$=jpg],.thb-lightbox[href$=png],.thb-lightbox[href$=gif],.thb-lightbox[href$=jpeg],.hentry a[href$=jpg]:not(.nothumb),.hentry a[href$=png]:not(.nothumb),.hentry a[href$=gif]:not(.nothumb),.hentry a[href$=jpeg]:not(.nothumb)";
		this.imagesSelector = this.imagesSelector.replace( /,/g, ':not(.nothumb),' );

		/**
		 * Initialize the lightbox component.
		 */
		this.init = function( target ) {
			this["galleries"] = $( this.galleriesSelector, target );
			this["images"] = $( this.imagesSelector, target ).not( this.galleries.find("a") );
		};

		/**
		 * Add new elements to the target set.
		 *
		 * @param {jQuery|string} new_elements
		 */
		this.add = function( new_elements ) {
			new_elements = $(new_elements);

			this["images"] = this["images"].add( new_elements );
		};

	};
})(jQuery);