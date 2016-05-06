<?php
	if ( thb_is_pageheader_layout_a() ) {
		if ( thb_slideshow_has_slides() ) {
			thb_slideshow( 'large-cropped', 'img', 'rsTHB page-content-slideshow' );
		}
		else {
			thb_featured_image( 'large-cropped', array(
				'link_class' => 'thb-page-featured-image item-thumb'
			) );
		}
	}
	else {
		thb_featured_image( 'large-cropped', array(
			'link_class' => 'thb-page-featured-image item-thumb'
		) );
	}
?>