<?php
/**
 * @package WordPress
 * @subpackage Blaine
 * @since Blaine 1.0
 */
$thb_page_id = get_the_ID();

$slides = thb_get_portfolio_item_slides( thb_get_page_ID() );

$slides_config = $featured_image_config = array(
	'overlay'    => true,
	'link'       => true,
	'link_class' => 'item-thumb'
);

if ( thb_get_disable_work_image_link() == 1 ) {
	$slides_config = array(
		'overlay'    => false,
		'link'       => false
	);

	$featured_image_config = array(
		'link'       => false,
		'overlay'    => false
	);
}

$image_size = 'large';

$thb_portfolio_index = thb_portfolio_get_index();

$prj_info = thb_duplicable_get('prj_info', $thb_page_id);
$has_prj_info = !empty($prj_info);

$work_categories = wp_get_object_terms($thb_page_id, 'portfolio_categories');
$cats = array();
foreach( $work_categories as $cat ) {
	$cats[] = $cat->name;
}

get_header(); ?>

<?php thb_post_before(); ?>

	<section id="page-content">

		<?php thb_post_start(); ?>

		<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

			<div class="thb-section-container">

				<article id="single-work-container" <?php post_class( thb_get_single_work_layout() ); ?>>

					<div class="work-data">

						<div class="single-work-main-data">

							<div class="main-data-wrapper">
								<h1 class="work-title"><?php the_title(); ?></h1>

								<?php if ( thb_get_project_short_description() != '' ) : ?>
									<h3 class="work-subtitle"><?php echo thb_get_project_short_description(); ?></h3>
								<?php endif; ?>
							</div>

							<?php if ( thb_is_single_work_layout_a() ) : ?>
								<?php if ( thb_is_portfolio_likes_active() ) : ?>
									<?php thb_like( 'thb-btn' ); ?>
								<?php endif; ?>

								<?php if ( thb_get_project_url() != '' ) : ?>
									<a class="thb-btn launch-btn" href="<?php echo thb_get_project_url(); ?>" title="<?php _e('Launch', 'thb_text_domain'); ?> <?php the_title(); ?>"><?php _e('Launch', 'thb_text_domain'); ?></a>
								<?php endif; ?>
							<?php endif; ?>

						</div>

						<div class="single-work-secondary-data">

							<?php if ( get_the_content() != '' ) : ?>
								<div class="thb-text">
									<?php the_content(); ?>
								</div>
							<?php endif; ?>

							<aside class="thb-project-info">
								<?php if( $has_prj_info ) : ?>
									<?php foreach( $prj_info as $info ) : ?>
										<p>
											<?php if ( thb_text_startsWith( $info['value']['value'], 'http://' ) ) : ?>
												<a href="<?php echo $info['value']['value']; ?>"><?php echo $info['value']['key']; ?></a>
											<?php else : ?>
												<span class="thb-project-label"><?php echo $info['value']['key']; ?></span>
												<?php echo $info['value']['value']; ?>
											<?php endif; ?>
										</p>
									<?php endforeach; ?>
								<?php endif; ?>

								<?php if( ! empty($cats) ) : ?>
									<p><span class="thb-project-label"><?php _e( 'Project categories', 'thb_text_domain' ); ?>: </span><?php echo implode(', ', $cats); ?></p>
								<?php endif; ?>

								<?php if ( thb_portfolio_item_get_external_url() != '' ) : ?>
									<?php $external_url = thb_portfolio_item_get_external_url(); ?>
									<p><span class="thb-project-label"><?php _e( 'External URL', 'thb_text_domain' ); ?>: </span><a href="<?php echo $external_url; ?>"><?php echo $external_url; ?></a></p>
								<?php endif; ?>
							</aside>

							<?php if ( ! thb_is_single_work_layout_a() ) : ?>
								<?php if ( thb_get_project_url() != '' ) : ?>
									<a class="thb-btn launch-btn" href="<?php echo thb_get_project_url(); ?>" title="<?php _e('Launch', 'thb_text_domain'); ?> <?php the_title(); ?>"><?php _e('Launch', 'thb_text_domain'); ?></a>
								<?php endif; ?>

								<?php if ( thb_is_portfolio_likes_active() ) : ?>
									<?php thb_like( 'thb-btn' ); ?>
								<?php endif; ?>
							<?php endif; ?>

						</div>

					</div>

					<div class="work-slides-container thb-images-container">
						<?php
							if ( empty( $slides ) ) {
								thb_featured_image( $image_size, $featured_image_config );
							} else {
								foreach ( $slides as $slide ) {
									echo "<div class='thb-image-wrapper " . $slide['class'] . "'>";
										if ( $slide['type'] == 'image' ) {
											thb_image( $slide['id'], $image_size, $slides_config );
										}
										else {
											echo "<a class='mfp-iframe' href='" . $slide['id'] . "'></a>";
											thb_video( $slide['id'], array( 'holder' => false ) );
										}

										if ( $slide['caption'] != '' ) {
											echo "<div class='thb-caption-content'>";
												echo $slide['caption'];
											echo "</div>";
										}
									echo "</div>";
								}
							}
						?>
					</div>

				</article>

				<?php if ( !empty( $thb_portfolio_index ) ) : ?>
					<div class="back-to-portfolio-container">
						<a class="back-to-portfolio" href="<?php echo get_permalink( $thb_portfolio_index ); ?>"><?php _e('Back to Portfolio', 'thb_text_domain' ); ?></a>
					</div>
				<?php endif; ?>

				<?php
					if( thb_show_pagination() ) {
						thb_pagination(
							array(
								'single_prev'     => __( 'Previous', 'thb_text_domain' ),
								'single_next'     => __( 'Next', 'thb_text_domain' )
							)
						);
					}
				?>

			</div>

		<?php endwhile; endif; ?>

		<?php thb_post_end(); ?>

	</section>

<?php thb_post_after(); ?>

<?php get_footer(); ?>