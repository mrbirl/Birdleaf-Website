<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

/**
 * Background field class.
 *
 * This class is entitled to manage the option/meta background field types.
 *
 * ---
 *
 * The Happy Framework: WordPress Development Framework
 * Copyright 2014, Andrea Gandino & Simone Maranzana
 *
 * Licensed under The MIT License
 * Redistribuitions of files must retain the above copyright notice.
 *
 * @package Core\Fields
 * @author The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright 2014, Andrea Gandino & Simone Maranzana
 * @link http://
 * @since The Happy Framework v 2.0.1
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
if( !class_exists('THB_BlaineBackgroundField') ) {
	class THB_BlaineBackgroundField extends THB_Field {

		/**
		 * The field subkeys.
		 *
		 * @var array
		 **/
		protected $_subKeys = array( 'overlay_color', 'overlay_opacity', 'overlay_display', 'background_color', 'background_format', 'id' );

		/**
		 * Constructor
		 *
		 * @param string $name The field name.
		 * @param integer $context The field context.
		 **/
		public function __construct( $name, $context = null )
		{
			parent::__construct( $name, 'blaine_background', $context );
		}
	}
}

if( ! function_exists( 'thb_admin_background_field_script' ) ) {
	/**
	 * Include the admin script and style for the background field.
	 */
	function thb_admin_background_field_assets() {
		thb_theme()->getAdmin()->addScript( get_template_directory_uri() . '/js/admin_field_background.js', array( 'jquery' ) );
		thb_theme()->getAdmin()->addStyle( get_template_directory_uri() . '/css/blaine_background_field.css' );
	}

	thb_admin_background_field_assets();
}

if( ! function_exists( 'thb_background_get_text_skin' ) ) {
	function thb_background_get_text_skin( $key = '', $post_id = null ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		$overlay_color     = thb_get_post_meta( $post_id, $key . '_overlay_color' );
		$background_color  = thb_get_post_meta( $post_id, $key . '_background_color' );

		if ( ! empty( $overlay_color ) || ! empty( $background_color ) ) {
			$comparison_color = '';

			if ( ! empty( $overlay_color ) ) {
				 $comparison_color = $overlay_color;
			}
			elseif ( ! empty( $background_color ) ) {
				 $comparison_color = $background_color;
			}

			if ( ! empty( $comparison_color ) ) {
				return thb_color_get_opposite_skin( $comparison_color );
			}
		}

		return '';
	}
}

if( ! function_exists( 'thb_background_style' ) ) {
	function thb_background_style( $key = '', $size = 'full', $post_id = null ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		$overlay_display   = thb_get_post_meta( $post_id, $key . '_overlay_display' );
		$overlay_color     = thb_get_post_meta( $post_id, $key . '_overlay_color' );
		$background_color  = thb_get_post_meta( $post_id, $key . '_background_color' );
		$background_format = thb_get_post_meta( $post_id, $key . '_background_format' );
		$background_image = thb_get_post_meta( $post_id, $key . '_id' );

		if ( empty( $background_image ) && empty( $background_color ) && empty( $overlay_color ) ) {
			return;
		}

		if ( $overlay_display == '1' ) {
			$overlay_opacity   = thb_get_post_meta( $post_id, $key . '_overlay_opacity' );

			thb_overlay( $overlay_color, $overlay_opacity, 'thb-background-overlay' );
		}

		$selector = '';

		if ( is_singular( 'works' ) ) {
			$selector = "#thb-external-wrapper";
		}
		elseif( thb_is_page_template( 'template-portfolio-stripe.php' ) ) {
			$selector = ".page-template-template-portfolio-stripe-php #post-" . $post_id;
		}
		elseif ( is_single() ) {
			$selector = ".thb-background-holder";
		}

		if ( get_post_type( $post_id ) == 'page' ) {
			if ( ! empty( $selector ) ) {
				$selector .= ',';
			}

			$selector .= ".thb-background-holder";
		}

		thb_css_start( 'thb-background-style' );

			printf( '.thb-background-overlay { position: absolute; top: 0; left: 0; right: 0; bottom: 0; }' );

			printf( '%s {', $selector );
				if ( ! empty( $background_color ) ) {
					printf( 'background-color: %s;', $background_color );
				}

				if ( ! empty( $background_image ) ) {
					printf( 'background-image: url(%s);', thb_image_get_size( $background_image, $size ) );

					switch( $background_format ) {
						case 'full_scroll':
							echo 'background-size: cover;';
							echo 'background-position: center center;';
							break;
						case 'full_fixed':
							echo 'background-size: cover;';
							echo 'background-attachment: fixed;';
							echo 'background-position: center center;';
							break;
						case 'repeat_all':
							break;
						case 'repeat_y':
							echo 'background-repeat: repeat-y;';
							break;
						case 'repeat_x':
							echo 'background-repeat: repeat-x;';
							break;
						case 'no-repeat':
							echo 'background-repeat: no-repeat;';
							echo 'background-position: center bottom;';
							break;
					}
				}
			echo '}';

			// Mobile media queries
			printf( '.thb-mobile %s {', $selector );

				if ( ! empty( $background_image ) ) {
					switch( $background_format ) {
						case 'full_fixed':
							echo 'background-attachment: scroll;';
							break;
					}
				}

			echo '}';

		thb_css_end();
	}
}

if( ! function_exists( 'thb_display_background_style' ) ) {
	function thb_display_background_style() {
		thb_background_style( 'project_background', 'full-width' );
	}
}

if( ! function_exists( 'thb_background_body_class' ) ) {
	function thb_background_body_class( $classes ) {
		$classes[] = 'thb-skin-' . thb_background_get_text_skin( 'project_background' );

		return $classes;
	}
}

if( ! function_exists( 'thb_display_background_style_page' ) ) {
	function thb_display_background_style_page() {
		thb_background_style( 'header_background', 'full-width', thb_get_page_ID() );
	}
}

if( ! function_exists( 'thb_background_body_class_page' ) ) {
	function thb_background_body_class_page( $classes ) {
		$classes[] = 'thb-skin-' . thb_background_get_text_skin( 'header_background', thb_get_page_ID() );

		return $classes;
	}
}

if( ! function_exists( 'thb_add_background_style' ) ) {
	function thb_add_background_style() {
		if ( is_singular( 'works' ) ) {
			add_action( 'thb_header_before', 'thb_display_background_style' );
			add_filter( 'body_class', 'thb_background_body_class' );
		}
		elseif( thb_is_page_template( 'template-portfolio-stripe.php' ) ) {
			add_action( 'thb_portfolio_stripe_item_start', 'thb_display_background_style' );
			add_filter( 'thb_portfolio_stripe_item_class', 'thb_background_body_class' );
		}

		if( is_page() || is_singular( 'post' ) ) {
			add_action( 'thb_page_header_background_holder', 'thb_display_background_style_page' );

			if ( ! thb_is_pageheader_layout_a() ) {
				add_filter( 'body_class', 'thb_background_body_class_page' );
			}
		}
	}

	add_action( 'wp_head', 'thb_add_background_style' );
}