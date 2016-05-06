<?php
/**
 * @package WordPress
 * @subpackage Blaine
 * @since Blaine 1.0
 */
get_header(); ?>

	<?php thb_page_before(); ?>

		<?php thb_page_start(); ?>

		<section id="page-content">

			<?php thb_get_template_part('partial-page-header'); ?>

			<div class="thb-section-container">

				<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

					<div id="main-content">

						<?php thb_get_template_part('partial-featured-image'); ?>

						<div class="thb-text">
							<?php the_content(); ?>
						</div>

						<?php if( thb_show_comments() ) : ?>
							<section class="secondary">
								<?php thb_comments( array('title_reply' => '<span>' . __('Leave a reply', 'thb_text_domain') . '</span>' )); ?>
							</section>
						<?php endif; ?>

					</div>

				<?php endwhile; endif; ?>

				<?php thb_page_sidebar(); ?>

			</div>

		</section>

		<?php thb_page_end(); ?>

	<?php thb_page_after(); ?>

<?php get_footer(); ?>