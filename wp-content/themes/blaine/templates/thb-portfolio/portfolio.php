<?php

if ( !isset( $args ) ) {
	$args = array();
}

thb_portfolio_query( $args );

$thb_size = thb_get_grid_image_size( $columns, $images_height );
$classes = thb_get_portfolio_classes( $columns, $gutter );

?>

<?php if( have_posts() ) : ?>

	<ul id="<?php thb_grid_layout_id(); ?>" class="<?php echo $classes; ?>">
		<?php while( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php thb_portfolio_item( array(
				'thb_size' => $thb_size
			)); ?>
		<?php endwhile; ?>
	</ul>

<?php endif; ?>