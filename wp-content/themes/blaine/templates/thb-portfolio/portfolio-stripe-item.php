<?php
	$thb_title = get_the_title();
	$thb_subtitle = thb_get_portfolio_item_subtitle();
	$thb_project_short_description = thb_get_project_short_description( get_the_ID() );
	$thb_fi = thb_get_featured_image( 'large' );
	$thb_item_class = array();

	if ( $thb_project_short_description != '' ) {
		$thb_subtitle = $thb_project_short_description;
	}

	if( $thb_fi == '' ) {
		$thb_item_class[] = 'thb-empty-image';
	} else {
		$thb_item_class[] = 'thb-w-image';
	}

	$thb_item_class[] = thb_get_single_work_layout( get_the_ID() );
	$thb_item_class = apply_filters( 'thb_portfolio_stripe_item_class', $thb_item_class );

	if( post_password_required() ) {
		$thb_title = __('Protected: ', 'thb_text_domain') . get_the_title();
	}

	$args = array(
		'thb_title' => $thb_title,
		'thb_subtitle' => $thb_subtitle
	);

?>
<li id="post-<?php the_ID(); ?>" <?php thb_portfolio_post_class( $thb_item_class ); ?>>

	<?php do_action('thb_portfolio_stripe_item_start'); ?>

	<div class="work-inner-wrapper">

		<div class="work-data">
			<div class="single-work-main-data">

				<div class="main-data-wrapper">
					<h3 class="work-title">
						<a href="<?php the_permalink(); ?>">
							<?php echo $thb_title; ?>
						</a>
					</h3>
					<?php if( $thb_subtitle != "" ) : ?>
						<p class="work-subtitle"><?php echo $thb_subtitle; ?></p>
					<?php endif; ?>
				</div>

			</div>

			<div class="single-work-secondary-data">
				<?php if ( thb_is_single_work_layout_a( get_the_ID() ) ) : ?>
					<?php if ( thb_is_portfolio_likes_active() ) : ?>
						<?php thb_like( 'thb-btn' ); ?>
					<?php endif; ?>
				<?php endif; ?>

				<a class="thb-btn thb-read-more" href="<?php the_permalink(); ?>">
					<span><?php _e( 'View', 'thb_text_domain' ); ?></span>
				</a>

				<?php if ( ! thb_is_single_work_layout_a( get_the_ID() ) ) : ?>
					<?php if ( thb_is_portfolio_likes_active() ) : ?>
						<?php thb_like( 'thb-btn' ); ?>
					<?php endif; ?>
				<?php endif; ?>

			</div>
		</div>

		<?php if( $thb_fi != '' ) : ?>
			<div class="work-slides-container">
				<img src="<?php echo $thb_fi; ?>" alt="">
			</div>
		<?php endif; ?>

	</div>
</li>