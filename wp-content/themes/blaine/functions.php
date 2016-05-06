<?php
/**
 * Functions and definitions.
 *
 * @package WordPress
 * @subpackage Blaine
 * @since Blaine 1.0
 */

/**
 * Framework.
 * PLEASE LEAVE THIS AREA UNTOUCHED, IN ORDER NOT TO BREAK CORE FUNCTIONALITY.
 * -----------------------------------------------------------------------------
 */
if( !defined('THB_THEME_KEY') ) define( 'THB_THEME_KEY', 'blaine' ); // Required, not displayed anywhere.

/**
 * Framework.
 */
require_once 'framework/boot.php';

/**
 * General configuration.
 */
require_once 'config/config-general.php';

/**
 * Theme functionalities.
 */
require_once 'config/config-functionalities.php';

/**
 * Theme options.
 */
require_once 'config/config-options.php';

/**
 * Theme customizations.
 */
require_once 'config/config-custom.php';

/**
 * Theme plugins.
 */
require_once 'config/config-plugins.php';

/**
 * Custom functions.
 */
thb_require_custom_functions();

/**
 * You can start adding your custom functions from here!
 * -----------------------------------------------------------------------------
 */

if( !isset($content_width) ) $content_width = 960;