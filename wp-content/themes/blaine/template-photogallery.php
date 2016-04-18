<?php
/**
 * @package WordPress
 * @subpackage Blaine
 * @since Blaine 1.0
 * Template name: Photogallery
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

					<?php if ( get_the_content() != '') : ?>
						<div class="thb-text">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>

				</div>

			<?php endwhile; endif; ?>

			</div>

			<?php thb_photogallery(); ?>

		</section>

		<?php thb_page_end(); ?>

	<?php thb_page_after(); ?>

<?php get_footer(); ?>