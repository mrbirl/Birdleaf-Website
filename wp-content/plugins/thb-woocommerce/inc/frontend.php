<?php

/**
 * WooCommerce frontend functions.
 *
 * ---
 *
 * The Happy Framework: WordPress Development Framework
 * Copyright 2012, Andrea Gandino & Simone Maranzana
 *
 * Licensed under The MIT License
 * Redistribuitions of files must retain the above copyright notice.
 *
 * @package THB WooCommerce
 * @author The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright 2012, Andrea Gandino & Simone Maranzana
 * @link http://
 * @since The Happy Framework v 1.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Return the page title without markup
 * @return string
 */
function thb_woo_get_page_title() {
	if ( !thb_woocommerce_check() ) {
		return;
	}

	ob_start();
	woocommerce_page_title();
	$woo_title = ob_get_contents();
	ob_end_clean();
	return $woo_title;
}