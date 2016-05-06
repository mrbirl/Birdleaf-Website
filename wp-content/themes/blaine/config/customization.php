<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

$thb_customizer = thb_theme()->setCustomizer( new THB_Customizer() );

	/**
	 * Logo
	 * -------------------------------------------------------------------------
	 */

	$thb_logo = $thb_customizer->addSection( 'logo', __( 'Logo', 'thb_text_domain' ) );

		$thb_logo
			->addSetting( new THB_CustomizerFontSetting( 'logo', __( 'Logo', 'thb_text_domain' ) ) )
				->setDefault( 'Lobster' )
				->setDefaultVariants( array( '400' ) )
				->addRule( 'font-family', '#logo .thb-logo' );

		$thb_logo
			->addSetting( new THB_CustomizerSelectSetting( 'logo_case', __( 'Logo text transform', 'thb_text_domain' ) ) )
				->setDefault( 'capitalize' )
				->setOptions( array(
					'lowercase' => __( 'Lowercase', 'thb_text_domain' ),
					'uppercase' => __( 'Uppercase', 'thb_text_domain' ),
					'capitalize' => __( 'Capitalize', 'thb_text_domain' )
				) )
				->addRule( 'text-transform', '#logo .thb-logo' );


		$thb_logo
			->addSetting( new THB_CustomizerFontSetting( 'tagline', __( 'Tagline', 'thb_text_domain' ) ) )
				->setDefault( 'Source+Sans+Pro' )
				->setDefaultVariants( array( 'regular' ) )
				->addRule( 'font-family', '#logo .thb-logo-tagline' );

		$thb_logo
			->addSetting( new THB_CustomizerSelectSetting( 'tagline_case', __( 'Tagline text transform', 'thb_text_domain' ) ) )
				->setDefault( 'capitalize' )
				->setOptions( array(
					'lowercase' => __( 'Lowercase', 'thb_text_domain' ),
					'uppercase' => __( 'Uppercase', 'thb_text_domain' ),
					'capitalize' => __( 'Capitalize', 'thb_text_domain' )
				) )
				->addRule( 'text-transform', '#logo .thb-logo-tagline' );

	/**
	 * Theme style
	 * -------------------------------------------------------------------------
	 */

	$thb_main = $thb_customizer->addSection( 'main', __( 'Theme style', 'thb_text_domain' ) );

		// Fonts ---------------------------------------------------------------

		$thb_main->addDivider( __( 'Fonts', 'thb_text_domain' ) );

		// Primary font

		$montserrat = '#main-nav, #page-header .page-title, .thb-slide-caption .thb-caption-inner-wrapper > div.thb-heading h1, #thb-stripe-portfolio li .single-work-main-data h3, .single-work-main-data .work-title, .page-template-template-archives-php .thb-archives-container h3, .thb-text h1, .thb-text h2, .thb-text h3, .thb-text h4, .thb-text h5, .thb-text h6, .comment_body h1, .comment_body h2, .comment_body h3, .comment_body h4, .comment_body h5, .comment_body h6, .thb-caption h1, .thb-caption h2, .thb-caption h3, .thb-caption h4, .thb-caption h5, .thb-caption h6, .thb-related h3, #comments #comments-title, #respond .comment-reply-title, .widget .widgettitle';

		if ( function_exists( 'is_woocommerce' ) && function_exists( 'thb_woocommerce_check' ) ) {
			$montserrat .= ', .woocommerce-page .upsells.products h2, .woocommerce-page .related.products h2, .woocommerce .upsells.products h2, .woocommerce .related.products h2, .woocommerce-page .thb-cart-totals .cart_totals h2, .woocommerce .thb-cart-totals .cart_totals h2, .woocommerce-page .thb-cart-totals .shipping_calculator h2, .woocommerce .thb-cart-totals .shipping_calculator h2, .woocommerce-page .thb-checkout-billing h3, .woocommerce-page .thb-checkout-shipping h3, .woocommerce-page #payment h3, .woocommerce .thb-checkout-billing h3, .woocommerce .thb-checkout-shipping h3, .woocommerce #payment h3, .woocommerce-page #order_review_heading, .woocommerce #order_review_heading, .woocommerce-page .cross-sells h2, .woocommerce .cross-sells h2, .woocommerce-page.woocommerce-account .thb-text .woocommerce h2, .woocommerce-page.woocommerce-account .thb-text .woocommerce h3, .woocommerce.woocommerce-account .thb-text .woocommerce h2, .woocommerce.woocommerce-account .thb-text .woocommerce h3, .woocommerce-page.single-product .summary .thb-product-header .product_title';
		}

		$thb_main
			->addSetting( new THB_CustomizerFontSetting( 'primary_font', __( 'Primary Font', 'thb_text_domain' ) ) )
				->setDefault( 'Montserrat' )
				->setDefaultVariants( array( 'regular', '700' ) )
				->addRule( 'font-family', $montserrat );

		// Secondary font
		
		$source_sans = '#page-header .page-subtitle, body, form input, form button, form textarea';

		if ( function_exists( 'is_woocommerce' ) && function_exists( 'thb_woocommerce_check' ) ) {
			$source_sans .= ', #main-nav ul.cart_list li a, #main-nav ul.product_list_widget li a';
		}

		$thb_main
			->addSetting( new THB_CustomizerFontSetting( 'secondary_font', __( 'Secondary Font', 'thb_text_domain' ) ) )
				->setDefault( 'Source+Sans+Pro' )
				->setDefaultVariants( array( 'regular', 'italic', '600', '700' ) )
				->addRule( 'font-family', $source_sans );

		// Colors --------------------------------------------------------------

		$thb_main->addDivider( __( 'Colors', 'thb_text_domain' ) );

		$background_color = '#main-nav ul li a:before, .thb-navigation.numeric li .current, #page-links span, #page-header .page-subtitle, .thb-work-overlay, .su-tabs-nav span.su-tabs-current';
		$border_color = '.thb-navigation.numeric li .current, #page-links span';

		if ( function_exists( 'is_woocommerce' ) && function_exists( 'thb_woocommerce_check' ) ) {
			$background_color .= ', .thb-product-numbers, .woocommerce-page .woocommerce-pagination li .current, .woocommerce .woocommerce-pagination li .current, .woocommerce-page .woocommerce-tabs .tabs li.active a, .woocommerce .woocommerce-tabs .tabs li.active a';
			$border_color .= ', .woocommerce-page .woocommerce-pagination li .current, .woocommerce .woocommerce-pagination li .current';
		}

		$thb_main
			->addSetting( new THB_CustomizerColorSetting( 'highlight_color', __( 'Highlight color', 'thb_text_domain' ) ) )
				->setDefault( '#ef5248' )
				->addRule( 'background-color', $background_color )
				->addRule( 'border-left-color', '.comment.bypostauthor .comment_rightcol .comment_head, #nprogress .spinner .spinner-icon' )
				->addRule( 'border-top-color', '#nprogress .spinner .spinner-icon' )
				->addRule( 'border-color', $border_color );

		$thb_main
			->addSetting( new THB_CustomizerColorSetting( 'body_bg', __( 'Background', 'thb_text_domain' ) ) )
				->setDefault( '#fff' )
				->addRule( 'background-color', '#thb-external-wrapper' );

		$thb_main
			->addSetting( new THB_CustomizerColorSetting( 'boxed_body_bg', __( 'Boxed Background', 'thb_text_domain' ) ) )
				->setDefault( '#dadada' )
				->addRule( 'background-color', '#thb-external-wrapper' );

		$thb_main
			->addSetting( new THB_CustomizerColorSetting( 'footer_stripe_bg', __( 'Footer sidebar background color', 'thb_text_domain' ) ) )
				->setDefault( '#3f3f3f' )
				->addRule( 'background-color', '#footer-sidebar' );

		$thb_main
			->addSetting( new THB_CustomizerColorSetting( 'footer_bg', __( 'Footer background color', 'thb_text_domain' ) ) )
				->setDefault( '#333333' )
				->addRule( 'background-color', '#footer' );