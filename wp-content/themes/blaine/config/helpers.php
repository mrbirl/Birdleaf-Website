<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

if( ! function_exists( 'thb_page_password_protected' ) ) {
	/**
	 * Handle password-protected pages and posts.
	 */
	function thb_page_password_protected() {
		if ( post_password_required() ) {
			get_template_part('partial-pass-protected');
			get_footer();
			die();
		}
	}

	add_action( 'thb_page_before', 'thb_page_password_protected' );
	add_action( 'thb_post_before', 'thb_page_password_protected' );
}

if( ! function_exists( 'thb_get_social_networks' ) ) {
	/**
	 * Get a list of the defined social networks available for the theme.
	 * Filters empty social networks.
	 *
	 * @return array
	 */
	function thb_get_social_networks() {
		$social_networks = thb_get_option('social_networks');

		if ( ! empty( $social_networks ) ) {
			$social_networks_array = array();

			foreach ( explode( ',', $social_networks ) as $social_network ) {
				if ( thb_get_social_network_url( $social_network ) != '' ) {
					$social_networks_array[] = $social_network;
				}
			}

			return $social_networks_array;
		}

		return array();
	}
}

if( ! function_exists( 'thb_get_social_network_url' ) ) {
	/**
	 * Get the URL of a specific social network service.
	 *
	 * @param string $social_network The social network key.
	 * @return string
	 */
	function thb_get_social_network_url( $social_network ) {
		return thb_get_option( $social_network );
	}
}

if( ! function_exists( 'thb_get_page_header_alignment' ) ) {
	/**
	 * Get the 'blaine_page_header_alignment' post meta value
	 *
	 * @return string
	 */
	function thb_get_page_header_alignment() {
		$thb_get_page_header_alignment = thb_get_post_meta( thb_get_page_ID(), 'blaine_page_header_alignment' );

		if( empty( $thb_get_page_header_alignment ) ) {
			return 'pageheader-left';
		}

		return $thb_get_page_header_alignment;
	}
}

if( !function_exists('thb_get_portfolio_layout') ) {
	/**
	 * Get the 'blaine_portfolio_layout' portfolio meta value
	 *
	 * @return string
	 */
	function thb_get_portfolio_layout() {
		$thb_get_portfolio_layout = thb_get_post_meta( thb_get_page_ID(), 'blaine_portfolio_layout' );

		if( empty( $thb_get_portfolio_layout ) ) {
			return 'thb-portfolio-grid-a';
		}

		return $thb_get_portfolio_layout;
	}
}

if( !function_exists('thb_is_portfolio_grid_a') ) {
	/**
	 * Check if the portfolio grid layout is A
	 * @return boolean
	 */
	function thb_is_portfolio_grid_a() {
		if ( thb_get_portfolio_layout() == 'thb-portfolio-grid-a' ) {
			return true;
		}
		return false;
	}
}

if( !function_exists('thb_is_portfolio_grid_b') ) {
	/**
	 * Check if the portfolio grid layout is B
	 * @return boolean
	 */
	function thb_is_portfolio_grid_b() {
		if ( thb_get_portfolio_layout() == 'thb-portfolio-grid-b' ) {
			return true;
		}
		return false;
	}
}

if( !function_exists('thb_is_portfolio_grid_c') ) {
	/**
	 * Check if the portfolio grid layout is C
	 * @return boolean
	 */
	function thb_is_portfolio_grid_c() {
		if ( thb_get_portfolio_layout() == 'thb-portfolio-grid-c' ) {
			return true;
		}
		return false;
	}
}

if( !function_exists('thb_is_portfolio_grid') ) {
	/**
	 * Check if the portfolio is a grid layout
	 * @return boolean
	 */
	function thb_is_portfolio_grid() {
		if ( thb_is_portfolio_grid_a() || thb_is_portfolio_grid_b() || thb_is_portfolio_grid_c() ) {
			return true;
		}
		return false;
	}
}

if( !function_exists('thb_get_single_work_layout') ) {
	/**
	 * Get the 'blaine_single_work_layout' single work meta value
	 *
	 * @return string
	 */
	function thb_get_single_work_layout( $id = null ) {
		if ( ! $id ) {
			global $post;
			$id = thb_get_page_ID();
		}

		$thb_get_single_work_layout = thb_get_post_meta( $id, 'blaine_single_work_layout' );
		$thb_get_single_work_layout = apply_filters( 'thb_get_single_work_layout', $thb_get_single_work_layout );
		
		if( empty( $thb_get_single_work_layout ) ) {
			return 'thb-single-work-layout-a';
		}

		return $thb_get_single_work_layout;
	}
}

if( !function_exists('thb_is_single_work_layout_a') ) {
	/**
	 * Check if the single work layout is A
	 * @return boolean
	 */
	function thb_is_single_work_layout_a( $id = null ) {
		if ( ! $id ) {
			global $post;
			$id = thb_get_page_ID();
		}

		if ( thb_get_single_work_layout( $id ) == 'thb-single-work-layout-a' ) {
			return true;
		}
		return false;
	}
}

if( !function_exists('thb_is_single_work_layout_b') ) {
	/**
	 * Check if the single work layout is B
	 * @return boolean
	 */
	function thb_is_single_work_layout_b( $id = null ) {
		if ( ! $id ) {
			global $post;
			$id = thb_get_page_ID();
		}

		if ( thb_get_single_work_layout( $id ) == 'thb-single-work-layout-b' ) {
			return true;
		}
		return false;
	}
}

if( !function_exists('thb_is_single_work_layout_c') ) {
	/**
	 * Check if the single work layout is C
	 * @return boolean
	 */
	function thb_is_single_work_layout_c( $id = null ) {
		if ( ! $id ) {
			global $post;
			$id = thb_get_page_ID();
		}

		if ( thb_get_single_work_layout( $id ) == 'thb-single-work-layout-c' ) {
			return true;
		}
		return false;
	}
}

if( !function_exists('thb_get_project_short_description') ) {
	/**
	 * Get the project short description
	 *
	 * @return string
	 */
	function thb_get_project_short_description( $id = null ) {
		if ( ! $id ) {
			global $post;
			$id = thb_get_page_ID();
		}
		
		return thb_get_post_meta( $id, 'project_short_description' );
	}
}

if( !function_exists('thb_get_project_url') ) {
	/**
	 * Get the project URL
	 *
	 * @return string
	 */
	function thb_get_project_url() {
		return thb_get_post_meta( thb_get_page_ID(), 'project_url' );
	}
}

if( !function_exists('thb_get_photogallery_layout') ) {
	/**
	 * Get the 'blaine_photogallery_layout' photogallery meta value
	 *
	 * @return string
	 */
	function thb_get_photogallery_layout() {
		$thb_get_photogallery_layout = thb_get_post_meta( thb_get_page_ID(), 'blaine_photogallery_layout' );

		if( empty( $thb_get_photogallery_layout ) ) {
			return 'thb-photogallery-grid-a';
		}

		return $thb_get_photogallery_layout;
	}
}

if( !function_exists('thb_is_photogallery_grid_a') ) {
	/**
	 * Check if the photogallery grid layout is A
	 * @return boolean
	 */
	function thb_is_photogallery_grid_a() {
		if ( thb_get_photogallery_layout() == 'thb-photogallery-grid-a' ) {
			return true;
		}
		return false;
	}
}

if( !function_exists('thb_is_photogallery_grid_b') ) {
	/**
	 * Check if the photogallery grid layout is B
	 * @return boolean
	 */
	function thb_is_photogallery_grid_b() {
		if ( thb_get_photogallery_layout() == 'thb-photogallery-grid-b' ) {
			return true;
		}
		return false;
	}
}

if( !function_exists('thb_get_layout_width') ) {
	/**
	 * Get the layout_width option value
	 * @return string
	 */
	function thb_get_layout_width() {
		$thb_layout_width = thb_get_option('layout_width');
		$thb_layout_width = apply_filters( 'thb_get_layout_width', $thb_layout_width );

		if ( empty( $thb_layout_width ) ) {
			return 'layout-width-extended';
		}

		return $thb_layout_width;
	}
}

if( !function_exists('thb_is_layout_boxed') ) {
	/**
	 * Check if the layout width option is "boxed"
	 * @return boolean
	 */
	function thb_is_layout_boxed() {
		if ( thb_get_layout_width() === 'layout-width-boxed' ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_is_layout_extended') ) {
	/**
	 * Check if the layout width option is "extended"
	 * @return boolean
	 */
	function thb_is_layout_extended() {
		if ( thb_get_layout_width() === 'layout-width-extended' ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_get_header_position') ) {
	/**
	 * Get the header_position option value
	 * @return string
	 */
	function thb_get_header_position() {
		$thb_header_position = thb_get_option('header_position');
		$thb_header_position = apply_filters( 'thb_get_header_position', $thb_header_position );

		if ( empty( $thb_header_position ) ) {
			return 'header-static';
		}

		return $thb_header_position;
	}
}

if( !function_exists('thb_is_header_position_fixed') ) {
	/**
	 * Check if the header position option is "fixed"
	 * @return boolean
	 */
	function thb_is_header_position_fixed() {
		if ( thb_get_header_position() === 'header-fixed' ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_get_pageheader_layout') ) {
	/**
	 * Get the pageheader_layout post meta value
	 * @return string
	 */
	function thb_get_pageheader_layout() {
		$thb_pageheader_layout = thb_get_post_meta( thb_get_page_ID(), 'blaine_pageheader_layout');

		if ( empty( $thb_pageheader_layout ) ) {
			return 'thb-pageheader-layout-a';
		}

		return $thb_pageheader_layout;
	}
}

if( !function_exists('thb_is_pageheader_layout_a') ) {
	/**
	 * Check if the pageheader layout option is A
	 * @return boolean
	 */
	function thb_is_pageheader_layout_a() {
		if ( thb_get_pageheader_layout() === 'thb-pageheader-layout-a' ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_is_pageheader_layout_b') ) {
	/**
	 * Check if the pageheader layout option is B
	 * @return boolean
	 */
	function thb_is_pageheader_layout_b() {
		if ( thb_get_pageheader_layout() === 'thb-pageheader-layout-b' ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_is_pageheader_layout_c') ) {
	/**
	 * Check if the pageheader layout option is C
	 * @return boolean
	 */
	function thb_is_pageheader_layout_c() {
		if ( thb_get_pageheader_layout() === 'thb-pageheader-layout-c' ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_is_enable_social_share') ) {
	/**
	 * Check if the social share option is checked
	 * @return boolean
	 */
	function thb_is_enable_social_share() {
		if ( thb_get_option( 'enable_social_share' ) == 1 ) {
			return true;
		}
		return false;
	}
}

if( ! function_exists( 'thb_is_portfolio_likes_active' ) ) {
	/**
	 * Check if likes have been activated for Portfolio items.
	 *
	 * @return boolean
	 */
	function thb_is_portfolio_likes_active() {
		return (int) thb_get_option( 'thb_portfolio_likes_active' ) == 1;
	}
}

if( ! function_exists( 'thb_is_blog_likes_active' ) ) {
	/**
	 * Check if likes have been activated for Blog posts.
	 *
	 * @return boolean
	 */
	function thb_is_blog_likes_active() {
		return (int) thb_get_option( 'thb_blog_likes_active' ) == 1;
	}
}

if( !function_exists('thb_portfolio_stripe_page_order') ) {
	/**
	 * Get the Portfolio Stripe page custom order.
	 * 
	 * @param integer $id
	 * @return array
	 */
	function thb_portfolio_stripe_page_order( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}
		
		$order = thb_duplicable_get( 'portfolio_item', $id );

		return $order;
	}
}

if( !function_exists('thb_portfolio_stripe_is_custom_order') ) {
	/**
	 * Check if the Portfolio Stripe page has a custom order.
	 * 
	 * @param integer $id
	 * @return boolean
	 */
	function thb_portfolio_stripe_is_custom_order( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}
		
		$order = thb_duplicable_get( 'portfolio_item', $id );

		return ! empty( $order );
	}
}

if( !function_exists('thb_get_disable_work_image_link') ) {
	function thb_get_disable_work_image_link( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		return thb_get_post_meta( $id, 'disable_work_image_link' );
	}
}