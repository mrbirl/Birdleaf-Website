<?php

$thb_format = thb_get_post_format();

if( $thb_format === 'gallery' ) {
	thb_post_format_gallery( 'blog_thumb_cropped', 'full', 'rsTHB' );
}

if ( $thb_format != 'image' && $thb_format != 'gallery' ) {
	thb_featured_image( 'blog_thumb_cropped', array(
		'link_class' => 'thb-page-featured-image item-thumb'
	) );
}

if ( $thb_format == 'image' ) {
	thb_post_format_image( 'blog_thumb_cropped', array(
		'link_class' => 'thb-page-featured-image item-thumb'
	) );
}

if ( thb_page_has_video( get_the_ID() ) || thb_page_has_audio( get_the_ID() ) ) {
	echo '<div class="format-embed-wrapper">';
		if( $thb_format === 'video' ) {
			thb_post_format_video();
		} elseif ( $thb_format === 'audio' ) {
			thb_post_format_audio();
		}
	echo '</div>';
}