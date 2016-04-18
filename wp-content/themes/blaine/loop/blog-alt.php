<?php
	thb_post_query();
?>

<?php if( have_posts() ) : $i=1; while( have_posts() ) : the_post(); ?>
	<?php thb_loop_post_before(); ?>
	<?php
		$thb_post_id = get_the_ID();
		$thb_post_classes = thb_get_post_classes( $i, array('item list'), 2 );
		$thb_post_classes[] = 'alt';
		$thb_get_page_sidebar = thb_get_page_sidebar();
		$thb_thumb_size = 'large-cropped';

		if ( !empty($thb_get_page_sidebar) ) {
			$thb_thumb_size = 'medium-cropped';
		}
	?>

	<div id="post-<?php echo $thb_post_id; ?>" <?php post_class( $thb_post_classes ); ?>>
		<?php thb_loop_post_start(); ?>
			<?php thb_get_template_part( 'loop/formats/alt', array( 'thb_thumb_size' => $thb_thumb_size ) ); ?>
		<?php thb_loop_post_end(); ?>
	</div>

	<?php thb_loop_post_after(); ?>
<?php $i++; endwhile; ?>

<?php else : ?>

	<div class="notice warning">
		<p><?php _e( 'Sorry, there aren\'t posts to be shown!', 'thb_text_domain' ); ?></p>
	</div>

<?php endif; ?>

<?php thb_numeric_pagination(); ?>