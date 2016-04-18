<?php
	$thb_title = get_the_title();
	$thb_subtitle = thb_get_portfolio_item_subtitle();
	$thb_item_class = thb_get_grid_layout_item_class();
	$thb_size = thb_get_grid_image_size();
	$thb_slides = thb_get_portfolio_item_slides( get_the_ID() );
	$thb_fi = thb_get_featured_image( $thb_size );

	if( $thb_fi == '' ) {
		$thb_item_class .= ' thb-empty-image';
	} else {
		$thb_item_class .= ' thb-w-image';
	}

	if( post_password_required() ) {
		$thb_title = __('Protected: ', 'thb_text_domain') . get_the_title();
	}

	$args = array(
		'thb_title' => $thb_title,
		'thb_subtitle' => $thb_subtitle,
		'thb_slides' => $thb_slides
	);
?>
<li id="post-<?php the_ID(); ?>" <?php thb_portfolio_post_class( $thb_item_class ); ?> <?php thb_portfolio_item_datafilters(); ?>>
	<div class="work-inner-wrapper">
		<?php if( $thb_fi != '' ) : ?>
			<a href="<?php echo thb_portfolio_item_get_permalink(); ?>" rel="bookmark" class="work-thumb">
				<img src="<?php echo $thb_fi; ?>" alt="">

				<div class="thb-work-overlay">
					<?php if ( thb_is_portfolio_grid_a() ) : ?>
						<span class="thb-work-detail"></span>
					<?php endif; ?>

					<?php if ( thb_is_portfolio_grid_b() || thb_is_portfolio_grid_c() ) : ?>
						<div class="overlay-wrapper">
							<?php thb_get_template_part( 'templates/thb-portfolio/portfolio-item-data', $args ); ?>
						</div>
					<?php endif; ?>

				</div>
			</a>
		<?php endif; ?>

		<?php if ( thb_is_portfolio_grid_a() || $thb_fi == '' ) : ?>
			<?php thb_get_template_part( 'templates/thb-portfolio/portfolio-item-data', $args ); ?>
		<?php endif; ?>
	</div>
</li>