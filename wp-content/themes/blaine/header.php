<?php
/**
 * @package WordPress
 * @subpackage Blaine
 * @since Blaine 1.0
 */
thb_before_doctype();
?>
<!doctype html>
<html <?php language_attributes(); ?> <?php thb_html_class(); ?>>
	<head>
		<?php thb_head_meta(); ?>

		<title><?php thb_title(); ?></title>

		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<?php thb_body_start(); ?>

		<div id="mobile-menu-container">
			<nav id="mobile-nav" class="main-navigation primary">
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav>
		</div>

		<div id="thb-external-wrapper">

			<?php thb_header_before(); ?>
				<header id="header">
					<div class="thb-section-container">

						<?php thb_header_start(); ?>

						<?php thb_logo(); ?>

						<?php get_template_part('partial-navigation'); ?>

						<a href="#" class="mobile-menu-trigger">open</a>

						<?php thb_header_end(); ?>

					</div>
				</header>
			<?php thb_header_after(); ?>