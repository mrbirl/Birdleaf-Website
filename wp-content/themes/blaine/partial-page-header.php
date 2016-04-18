<?php

$thb_format = '';
$thb_link_url = '';
$thb_quote_url = '';

if ( !isset( $thb_title ) ) {
	$thb_title = get_the_title();
}

if ( !isset( $thb_subtitle ) ) {
	$thb_subtitle = thb_get_page_subtitle();
}

if ( is_single() ) {
	$thb_format = thb_get_post_format();
	$thb_subtitle = get_the_date();

	if ( $thb_format === 'link' ) {
		$thb_link_url = thb_get_post_format_link_url();
	}
	elseif( $thb_format === 'quote' ) {
		$thb_title = thb_get_post_format_quote_text();
		$thb_subtitle = thb_get_post_format_quote_author();
		$thb_quote_url = thb_get_post_format_quote_url();
	}
}

?>

<?php if ( ! thb_is_pageheader_layout_a() ) : ?>
	<?php
		if ( thb_slideshow_has_slides() ) {
			thb_slideshow( 'full-width', 'img', 'rsTHB header-slideshow' );
		}
		else {
			?>
			<div class="thb-background-holder">
				<?php do_action( 'thb_page_header_background_holder' ); ?>
			</div>
			<?php
		}
	?>
<?php endif; ?>

<header id="page-header">

	<?php
		$show_page_header = true;

		if ( thb_is_pageheader_layout_a() ) {
			$show_page_header = ! thb_page_header_disabled();
		}
		elseif ( thb_is_pageheader_layout_b() ) {
			$show_page_header = ! thb_page_header_disabled() && ! thb_slideshow_has_slides();
		}
		elseif ( thb_is_pageheader_layout_c() ) {
			$show_page_header = ! thb_page_header_disabled();
		}
	?>


	<?php if ( $show_page_header ) : ?>

	<div class="thb-page-header-wrapper">

		<h1 class="page-title"><?php echo $thb_title; ?></h1>

		<?php if( !empty($thb_subtitle) ) : ?>
			<h2 class="page-subtitle">
				<?php if( $thb_format === 'quote' ) : ?>
					<span><?php echo !empty($thb_quote_url) ? sprintf('<a href="%s">%s</a>', $thb_quote_url, $thb_subtitle) : $thb_subtitle; ?></span>
				<?php else : ?>
					<span><?php echo $thb_subtitle; ?></span>
				<?php endif; ?>

				<?php if ( is_single() ) : ?>
					<a class="thb-comments-number" href="<?php comments_link(); ?>">
						<?php thb_comments_number( true ); ?>
					</a>
				<?php endif; ?>
			</h2>
		<?php endif; ?>

		<?php if( $thb_format === 'link') : ?>
			<p class="post-format-link-url">
				<a href="<?php echo $thb_link_url; ?>" rel="external">
					<?php echo $thb_link_url; ?>
				</a>
			</p>
		<?php endif; ?>

	</div>

	<?php endif; ?>

</header>