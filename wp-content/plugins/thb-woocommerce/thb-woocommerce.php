<?php
/*
Plugin Name: THB WooCommerce
Plugin URI: http://
Version: 1.0.2
Author: THBThemes
Description: WooCommerce advanced customizations.
Text Domain: thb-woocommerce
*/

if ( ! function_exists( 'thb_is_woocommerce' ) ) {
	/**
	 * Plugin key.
	 * -------------------------------------------------------------------------
	 */
	define( 'THB_WOOCOMMERCE_KEY', 'thb-woocommerce' );

	/**
	 * Plugin base directory.
	 * -------------------------------------------------------------------------
	 */
	define( 'THB_WOOCOMMERCE_DIR', plugin_dir_path( __FILE__ ) );

	/**
	 * Plugin initialization.
	 * -------------------------------------------------------------------------
	 */
	function thb_woocommerce_init() {
		load_plugin_textdomain( THB_WOOCOMMERCE_KEY, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	add_action( 'init', 'thb_woocommerce_init' );

	/**
	 * Plugin configuration.
	 * -------------------------------------------------------------------------
	 */
	function thb_woocommerce_config( $key=null ) {
		$config = apply_filters( 'thb_woocommerce_config', array(
			/**
			 * Enable the creation of an option tab in the main options page.
			 */
			'options' => true,

			/**
			 * Enable the creation of the shop sidebar options
			 */
			'sidebar_shop' => true,

			/**
			 * Enable the creation of the single product sidebar options
			 */
			'sidebar_product' => true,

			/**
			 * Enable the THB custom skin
			 */
			'skin' => false
		) );

		if( !empty($key) && isset($config[$key]) ) {
			return $config[$key];
		}

		return $config;
	}

	/**
	 * THB framework check.
	 * -------------------------------------------------------------------------
	 */
	function thb_woocommerce_framework_check() {
		return class_exists('THB_Theme');
	}

	/**
	 * Is WooCommerce check.
	 * -------------------------------------------------------------------------
	 */
	function thb_is_woocommerce() {
		return function_exists( 'is_woocommerce' );
	}

	/**
	 * Return the WooCommerce version number.
	 * -------------------------------------------------------------------------
	 */
	function thb_get_woocommerce_version() {
		return get_option( 'woocommerce_version', null );
	}

	/**
	 * WooCommerce and framework check.
	 * -------------------------------------------------------------------------
	 */
	function thb_woocommerce_check() {
		if ( thb_is_woocommerce() && thb_woocommerce_framework_check() ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * WooCommerce general options
	 * -------------------------------------------------------------------------
	 */
	require_once dirname(__FILE__) . '/inc/options.php';

	/**
	 * WooCommerce frontend utilities
	 * -------------------------------------------------------------------------
	 */
	require_once dirname(__FILE__) . '/inc/frontend.php';

	/**
	 * Include the theme-woocommerce file
	 * -------------------------------------------------------------------------
	 */
	function thb_include_theme_woocommerce() {
		if ( thb_woocommerce_check() ) {
			if( file_exists( THB_TEMPLATE_DIR . '/woocommerce/theme-woocommerce.php' )) {
				include THB_TEMPLATE_DIR . '/woocommerce/theme-woocommerce.php';
			}
		}
	}
	add_action( 'init', 'thb_include_theme_woocommerce' );

	/**
	 * Add theme support for WooCommerce
	 * -------------------------------------------------------------------------
	 */
	add_theme_support('woocommerce');
}