<?php
	$thb_post_id = get_the_ID();
	$thb_category = get_the_category();
	$thb_tags = get_the_tags();
	$thb_link_url = thb_get_post_format_link_url();
	$thb_format = thb_get_post_format();
	$thb_title = get_the_title();
	$wrapper_classes = 'post-wrapper';

	if( thb_get_post_format() === 'quote' ) {
		$thb_title = thb_get_post_format_quote_text();
		$thb_subtitle = thb_get_post_format_quote_author();
	}

	if( post_password_required() ) {
		$thb_title = __('Protected: ', 'thb_text_domain') . get_the_title();
	}

	$feature_image_src = '';

	if( $thb_format === 'image' ) {
		$feature_image_src = thb_get_post_format_image_src( $thb_thumb_size );
	}
	elseif( $thb_format !== 'gallery' && $thb_format !== 'aside' ) {
		$feature_image_src = thb_get_featured_image( $thb_thumb_size );
	}

	if ( !empty( $feature_image_src ) ) {
		$wrapper_classes .= ' w-image';
	}
?>

<div class="<?php echo $wrapper_classes; ?>">
	<div class="loop-post-meta">
		<ul>
			<li><?php echo get_the_date(); ?></li>
			<li><?php _e('by', 'thb_text_domain'); ?> <?php the_author_posts_link(); ?></li>
			<li class="comments">
				<a href="<?php comments_link(); ?>">
					<?php thb_comments_number(); ?>
				</a>
			</li>
		</ul>
	</div>

	<div class="loop-post-content">

		<header class="item-header">
			<?php if ( !empty( $thb_title ) && $thb_format != 'aside' ) : ?>
			<h1>
				<a href="<?php the_permalink(); ?>">
					<?php echo $thb_title; ?>
				</a>
			</h1>
			<?php endif; ?>

			<?php if( thb_get_post_format() === 'link') : ?>
				<span class="post-format-link-url">
					<a href="<?php echo $thb_link_url; ?>" rel="external">
						<?php echo $thb_link_url; ?>
					</a>
				</span>
			<?php endif; ?>

			<?php if( thb_get_post_format() === 'quote' ) : ?>
				<span class="quote-author">
					<?php
						if ( ( $thb_quote_url = thb_get_post_format_quote_url() ) != '' ) {
							printf( '<a href="%s">%s</a>', $thb_quote_url, $thb_subtitle );
						} else {
							echo $thb_subtitle;
						}
					?>
				</span>
			<?php endif; ?>
		</header>

		<?php
			if ( $thb_format != 'video' ) {

				if ( !empty( $feature_image_src ) ) {
					if( $thb_format === 'image' ) {
						thb_post_format_image( $thb_thumb_size );
					}
					elseif( $thb_format !== 'gallery' && $thb_format !== 'aside' ) {
						thb_featured_image( $thb_thumb_size );
					}
				}

				if( $thb_format === 'gallery' ) {
					thb_post_format_gallery( $thb_thumb_size, 'full', 'rsTHB' );
				}

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
		?>

		<?php if( thb_get_post_format() != 'quote') : ?>
			<div class="item-content">
				<?php if( get_the_excerpt() != '' ) : ?>
					<div class="thb-text">
						<?php if( !post_password_required() ) : ?>
							<?php the_excerpt(); ?>
						<?php else : ?>
							<?php _e('This post is password protected.', 'thb_text_domain'); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<a class="thb-btn thb-read-more" href="<?php the_permalink(); ?>">
			<span><?php _e( 'Read more', 'thb_text_domain' ); ?></span>
		</a>

	</div>

</div>