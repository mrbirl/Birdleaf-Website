<?php
/**
 * Shortcode Ultimate teaser-loop custom
 */
?>
<div class="su-posts su-posts-teaser-loop">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				$thb_category = get_the_category();

				if( function_exists('thb_portfolio_loop') && get_post_type() === 'works' ) {
					$thb_category = thb_get_portfolio_item_subtitle();
				}
				
				?>
				<div class="thb-su-loop-item posts-teaser-loop-item">
					<?php if ( has_post_thumbnail() ) : ?>
						<a class="su-post-thumbnail item-thumb" href="<?php the_permalink(); ?>">
							<img src="<?php echo thb_get_featured_image( 'micro' , get_the_ID() ); ?>" />
						</a>
					<?php endif; ?>

					<div id="su-post-<?php the_ID(); ?>" class="su-post">
						<h2 class="su-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						
						<p class="pubdate">
							<?php echo get_the_date(); ?>
						</p>

					</div>

				</div>
				<?php
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . __( 'Posts not found', 'su' ) . '</h4>';
		}
	?>
</div>