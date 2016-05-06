<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

/**
 * Theme functionalities.
 *
 * ---
 *
 * The Happy Framework: WordPress Development Framework
 * Copyright 2012, Andrea Gandino & Simone Maranzana
 *
 * Licensed under The MIT License
 * Redistribuitions of files must retain the above copyright notice.
 *
 * @package Config
 * @author The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright 2012, Andrea Gandino & Simone Maranzana
 * @link http://
 * @since The Happy Framework v 1.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

require_once 'helpers.php';
require_once 'fields.php';
require_once 'lib/class.typekit.php';

$thb_theme = thb_theme();
/**
 * Backpack.
 */
$thb_theme->loadModule('backpack', array(
	'layout' => array(
		'grid_columns' => array(
			'3' => array( 'fixed' => 'grid-large-cropped', 'variable' => 'grid-large' ),
			'4' => array( 'fixed' => 'grid-large-cropped', 'variable' => 'grid-large' ),
			'5' => array( 'fixed' => 'grid-small-cropped', 'variable' => 'grid-small' )
		),
		'options_logo_position' => array(
			'logo-left'   => __( 'Left', 'thb_text_domain' ),
			'logo-right'  => __( 'Right', 'thb_text_domain' )
		),
		'meta_options_pageheader_disable' => thb_get_theme_templates(),
	),
	'blog' => array(
		'enable_author_block' => true,
		'sidebars' => true,
		'templates' => array(
			'template-blog.php',
			'template-blog-alt.php'
		)
	),
	'photogallery' => array(
		'templates' => array(
			'template-photogallery.php'
		),
		'templates_columns' => array(
			'template-photogallery.php' => array(
				'3' => '3',
				'4' => '4',
				'5' => '5'
			)
		),
		'force_isotope' => true
	),
	'sidebars' => array(
		'templates' => array(
			'default',
			'template-archives.php',
			'template-blog.php',
			'template-blog-alt.php',
			'single.php'
		)
	),
	'slideshow' => array(
		'templates' => array(
			'default',
			'template-blog.php',
			'template-blog-alt.php',
			'template-portfolio.php',
			'template-portfolio-stripe.php',
			'template-photogallery.php',
			'template-archives.php'
		)
	),
	'like' => array()
));

$thb_theme->loadModule('gravityforms');

if( ! function_exists('thb_blaine_portfolio_config') ) {
	/**
	 * Blaine portfolio configuration.
	 *
	 * @param array $config
	 * @return array
	 */
	function thb_blaine_portfolio_config( $config ) {
		$config['templates'] = array(
			'template-portfolio.php',
			'template-portfolio-stripe.php'
		);
		$config['ajax'] = array('template-portfolio.php');
		$config['work_slides'] = true;
		$config['single'] = false;
		$config['work_details'] = 'keyvalue';
		$config['grid_templates'] = array('template-portfolio.php');
		$config['grid_templates_columns'] = array(
			'template-portfolio.php' => array(
				'3' => '3',
				'4' => '4',
				'5' => '5'
			)
		);

		return $config;
	}

	add_filter( 'thb_portfolio_config', 'thb_blaine_portfolio_config' );
}

if( !function_exists('thb_extend_slideshow_slides') ) {
	/**
	 * Add the required fields to the slideshow modals.
	 *
	 * @param THB_SlideField $slide
	 * @return THB_SlideField
	 */
	function thb_extend_slideshow_slides( $slide ) {
		$thb_modal = $slide->getModal( 'edit_slide_image' );

		$thb_modal_container = $thb_modal->getContainer( 'edit_slide_image_container' );

			$thb_field = new THB_TextareaField( 'heading' );
			$thb_field->setLabel( __( 'Heading', 'thb_text_domain' ) );
			$thb_modal_container->addField( $thb_field, 0 );

			$thb_field = new THB_CheckboxField( 'overlay_display' );
			$thb_field->setLabel( __( 'Overlay display', 'thb_text_domain' ) );
			$thb_modal_container->addField( $thb_field, -1 );

			$thb_field = new THB_ColorField( 'overlay_color' );
			$thb_field->setLabel( __( 'Overlay color', 'thb_text_domain' ) );
			$thb_field->setHelp( 'The color of the overlay (even if not enabled) determines the skin used for texts (e.g. a dark color automatically generates light text).' );
			$thb_modal_container->addField( $thb_field, -1 );

			$thb_field = new THB_NumberField( 'overlay_opacity' );
			$thb_field->setMin( 0 );
			$thb_field->setMax( 1 );
			$thb_field->setStep( 0.05 );
			$thb_field->setLabel( __( 'Overlay opacity', 'thb_text_domain' ) );
			$thb_modal_container->addField( $thb_field, -1 );

			$thb_field = new THB_SelectField( 'caption_alignment' );
			$thb_field->setLabel( __( 'Caption alignment', 'thb_text_domain' ) );
			$thb_field->setDefault( 'thb-caption-left' );
			$thb_field->setOptions(array(
				'thb-caption-left'   => __('Left', 'thb_text_domain'),
				'thb-caption-center' => __('Center', 'thb_text_domain'),
				'thb-caption-right'  => __('Right', 'thb_text_domain')
			));
			$thb_modal_container->addField($thb_field, -1 );

			$thb_field = new THB_TextField( 'call_to_label' );
			$thb_field->setLabel( __( 'Call to action label', 'thb_text_domain' ) );
			$thb_field->setHelp( __('The call to action button label.', 'thb_text_domain'));
			$thb_modal_container->addField( $thb_field, -1 );

			$thb_field = new THB_TextField( 'call_to_url' );
			$thb_field->setLabel( __( 'Call to action URL', 'thb_text_domain' ) );
			$thb_field->setHelp( __('The call to action button URL. You can use a manual URL http:// or a post or page ID.', 'thb_text_domain'));
			$thb_modal_container->addField( $thb_field, -1 );

		/**
		 * Video
		 */

		$thb_modal = $slide->getModal( 'edit_slide_video' );
		$thb_modal_container = $thb_modal->getContainer( 'edit_slide_video_container' );

		$thb_modal_container->setIntroText( __( '<strong>Note</strong>: when using a video from Vimeo, the autoplay feature will only work if the slide is in first position, due to a known problem in their API.<br><br><strong>Recommended setting</strong>: video works better if the slideshow effect is set to "slide".', 'thb_text_domain' ) );

		$thb_field = new THB_TextareaField( 'heading' );
		$thb_field->setLabel( __( 'Heading', 'thb_text_domain' ) );
		$thb_modal_container->addField( $thb_field, 1 );

		$thb_field = new THB_TextField( 'call_to_label' );
		$thb_field->setLabel( __( 'Call to action label', 'thb_text_domain' ) );
		$thb_field->setHelp( __('The call to action button label.', 'thb_text_domain'));
		$thb_modal_container->addField( $thb_field, -1 );

		$thb_field = new THB_TextField( 'call_to_url' );
		$thb_field->setLabel( __( 'Call to action URL', 'thb_text_domain' ) );
		$thb_field->setHelp( __('The call to action button URL. You can use a manual URL http:// or a post or page ID.', 'thb_text_domain'));
		$thb_modal_container->addField( $thb_field, -1 );

		$thb_field = new THB_CheckboxField( 'overlay_display' );
		$thb_field->setLabel( __( 'Overlay display', 'thb_text_domain' ) );
		$thb_modal_container->addField( $thb_field, -1 );

		$thb_field = new THB_ColorField( 'overlay_color' );
		$thb_field->setLabel( __( 'Overlay color', 'thb_text_domain' ) );
		$thb_field->setHelp( 'The color of the overlay (even if not enabled) determines the skin used for texts (e.g. a dark color automatically generates light text).' );
		$thb_modal_container->addField( $thb_field, -1 );

		$thb_field = new THB_NumberField( 'overlay_opacity' );
		$thb_field->setMin( 0 );
		$thb_field->setMax( 1 );
		$thb_field->setStep( 0.05 );
		$thb_field->setLabel( __( 'Overlay opacity', 'thb_text_domain' ) );
		$thb_modal_container->addField( $thb_field, -1 );

		return $slide;
	}

	add_filter( 'thb_slideshow_slide', 'thb_extend_slideshow_slides' );
}

if( ! function_exists( 'thb_blaine_slide_content_data' ) ) {
	/**
	 * Add the skin class to slideshow slides.
	 *
	 * @param array $slide_content_data
	 * @return array
	 */
	function thb_blaine_slide_content_data( $slide_content_data ) {
		$overlay_color = $slide_content_data['slide']['overlay_color'];

		if ( ! empty( $overlay_color ) ) {
			$slide_content_data['slide_attrs']['class'] .= ' thb-skin-' . thb_color_get_opposite_skin( $overlay_color );
		}

		return $slide_content_data;
	}

	add_action( 'thb_slide_content_data', 'thb_blaine_slide_content_data' );
}

if( ! function_exists('thb_blaine_woocommerce_config') ) {
	/**
	 * Blaine WooCommerce configuration.
	 *
	 * @param array $config
	 * @return array
	 */
	function thb_blaine_woocommerce_config( $config ) {
		$config['skin'] = true;
		$config['sidebar_product'] = false;

		return $config;
	}

	add_filter( 'thb_woocommerce_config', 'thb_blaine_woocommerce_config' );
}

/**
 * Theme style customization
 */
require_once "customization.php";