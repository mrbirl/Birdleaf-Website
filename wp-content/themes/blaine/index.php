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

			<div class="thb-section-container">
				
				<div id="main-content">

					<?php get_template_part('loop/blog', 'classic'); ?>
					
				</div>

				<?php thb_display_sidebar('post-sidebar', 'main'); ?>

			</div>

		</section>

		<?php thb_page_end(); ?>

	<?php thb_page_after(); ?>

<?php get_footer(); ?>