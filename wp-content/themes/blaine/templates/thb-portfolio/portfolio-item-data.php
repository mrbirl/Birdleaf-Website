<?php
$thb_size = thb_get_grid_image_size();
$thb_fi = thb_get_featured_image( $thb_size );
?>

<div class="work-data">
	<h3>
		<?php if ( thb_is_portfolio_grid_a() || $thb_fi == '' ) : ?>
			<a href="<?php echo thb_portfolio_item_get_permalink(); ?>"><?php echo $thb_title; ?></a>
		<?php else : ?>
			<?php echo $thb_title; ?>
		<?php endif; ?>
	</h3>

	<?php if( $thb_subtitle != "" ) : ?>
		<p><?php echo $thb_subtitle; ?></p>
	<?php endif; ?>

	<?php if ( thb_is_portfolio_grid_b() || thb_is_portfolio_grid_c() ) : ?>
		<span class="thb-work-detail"></span>
	<?php endif; ?>
</div>