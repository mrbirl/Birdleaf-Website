<?php
/**
 * Shortcode Ultimate default-loop custom
 */
?>
<div class="su-posts su-posts-default-loop">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				$thb_category = get_the_category();
				?>

				<div class="thb-su-loop-item posts-teaser-loop-item">

					<div id="su-post-<?php the_ID(); ?>" class="su-post">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php thb_featured_image('medium-cropped', array( 'link_class' => 'su-post-thumbnail item-thumb' ), get_the_ID() ); ?>
						<?php endif; ?>

						<h2 class="su-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

						<p class="pubdate">
							<?php the_date(); ?>
						</p>

						<div class="su-post-excerpt">
							<?php the_excerpt(); ?>
						</div>

						<div class="su-post-meta">
							<?php if( !empty($thb_category) ) : ?>
								<span class="category">
									<?php _e( 'on', 'thb_text_domain' ); ?> <?php the_category(', '); ?>
								</span>
							<?php endif; ?>
							 | <a href="<?php comments_link(); ?>" class="su-post-comments-link"><?php comments_number( __( '0 comments', 'su' ), __( '1 comment', 'su' ), __( '%n comments', 'su' ) ); ?></a>
						</div>
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