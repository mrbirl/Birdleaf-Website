<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

/**
 * Theme customizations.
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

$thb_theme = thb_theme();

if( ! function_exists('thb_comment_form_fields') ) {
	/**
	 * Customizations for the form
	 */
	function thb_comment_form_fields( $fields ) {
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$args = array(
			'format' => 'xhtml'
		);
		$html5 = 'html5' === $args['format'];
		$args = wp_parse_args( $args );

		if ( ! isset( $args['format'] ) )
			$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

		$fields['author'] = '<p class="comment-form-author">' . '<label for="author">' . __( 'Name','thb_text_domain' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' . '<input id="author" name="author" type="text" placeholder="' . __('Your name *', 'thb_text_domain') . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>';
		$fields['email'] = '<p class="comment-form-email"><label for="email">' . __( 'Email','thb_text_domain' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
						'<input id="email" name="email" placeholder="' . __('Your email *','thb_text_domain') . '" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>';
		$fields['url'] = '<p class="comment-form-url"><label for="url">' . __( 'Website','thb_text_domain' ) . '</label> ' .
						'<input id="url" name="url" placeholder="' . __('Your website url', 'thb_text_domain') . '" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';

		return $fields;
	}

	add_filter('comment_form_default_fields','thb_comment_form_fields');
}

if( !function_exists('thb_password_form') ) {
	/**
	 * THB custom password protection form
	 */
	function thb_password_form() {
		 global $post;
	    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	    $o = '<p class="thb-password-protected-message">' . __( "This content is password protected", 'thb_text_domain') . '<span>' . __("to view it please enter your password below", 'thb_text_domain') . '</span></p>
	    <form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
			<label class="hidden" for="' . $label . '">' . __( "Password:",'thb_text_domain' ) . ' </label>
			<input name="post_password" placeholder="Password" id="' . $label . '" type="password" size="20" maxlength="20" />
			<input id="submit" type="submit" name="Submit" value="' . esc_attr__( "Submit" ) . '" />
		</form>
	    ';
	    return $o;
	}
	add_filter( 'the_password_form', 'thb_password_form' );
}

if( !function_exists('thb_title_format') ) {
	/**
	 * Change the title for the protected content
	 */
	function thb_title_format($content) {
		return '%s';
	}

	add_filter('private_title_format', 'thb_title_format');
	add_filter('protected_title_format', 'thb_title_format');
}

if( ! function_exists( 'thb_get_theme_social_options' ) ) {
	/**
	 * Get the social options for the theme.
	 *
	 * @return array
	 */
	function thb_get_theme_social_options() {
		$thb_page = thb_theme()->getAdmin()->getMainPage();
		$thb_container = $thb_page->getTab('social')->getContainer('social_options');
		$options = array();

		foreach( $thb_container->getFields() as $field ) {
			$options[$field->getName()] = $field->getLabel();
		}

		return $options;
	}
}

if( ! function_exists('thb_theme_layout_options') ) {
	/**
	 * Page extra layout features
	 */
	function thb_theme_layout_options() {
		foreach( thb_theme()->getPublicPostTypes() as $post_type ) {
			if ( ! $thb_metabox = $post_type->getMetabox('layout') ) {
				return;
			}

			$all_templates = thb_get_theme_templates();
			$templates     = thb_get_theme_templates( 'templates' );
			$photogallery  = thb_get_theme_templates( 'photogallery' );

			if( thb_is_admin_template( $all_templates ) ) {

				$thb_container = $thb_metabox->getContainer( 'layout_container' );

				$thb_field = new THB_SelectField( 'blaine_page_header_alignment' );
					$thb_field->setLabel( __( 'Page header alignment', 'thb_text_domain' ) );
					$thb_field->setOptions(array(
						'pageheader-left'   => __('Left', 'thb_text_domain'),
						'pageheader-center' => __('Center', 'thb_text_domain'),
						'pageheader-right'  => __('Right', 'thb_text_domain')
					));
				$thb_container->addField($thb_field);

			}

			if( thb_is_admin_template( $all_templates ) ) {

				$thb_container = $thb_metabox->getContainer( 'layout_container' );

				$thb_field = new THB_GraphicRadioField( 'blaine_pageheader_layout' );
					$thb_field->setLabel( __('Page header layout', 'thb_text_domain') );
					$thb_field->setOptions(array(
						'thb-pageheader-layout-a' => get_template_directory_uri() . '/css/i/options/pageheader-layout-a.png',
						'thb-pageheader-layout-b' => get_template_directory_uri() . '/css/i/options/pageheader-layout-b.png',
						'thb-pageheader-layout-c' => get_template_directory_uri() . '/css/i/options/pageheader-layout-c.png'
					));
				$thb_container->addField($thb_field);

				$thb_field = new THB_BlaineBackgroundField('header_background');
				$thb_field->setLabel( __('Header background', 'thb_text_domain') );
				$thb_field->setHelp( __( 'The color of the overlay (even if not enabled) or background determines the skin used for texts (e.g. a dark color automatically generates light text).<br><br>If present, the slideshow have precedence over this field.', 'thb_text_domain' ) );
				$thb_container->addField($thb_field);

			}

			if( thb_is_admin_template( $photogallery ) ) {

				$thb_field = new THB_GraphicRadioField( 'blaine_photogallery_layout' );
				$thb_field->setLabel( __('Photogallery layout', 'thb_text_domain') );
				$thb_field->setOptions(array(
					'thb-photogallery-grid-a' => get_template_directory_uri() . '/css/i/options/photogallery-grid-a.png',
					'thb-photogallery-grid-b' => get_template_directory_uri() . '/css/i/options/photogallery-grid-b.png'
				));
				$thb_container->addField($thb_field);

			}
		}
	}

	add_action('wp_loaded', 'thb_theme_layout_options');
}

if( ! function_exists( 'thb_theme_portfolio_options' ) ) {
	/**
	 * Theme portfolio options.
	 */
	function thb_theme_portfolio_options() {
		if( thb_is_admin_template( 'template-portfolio.php' ) ) {
			$thb_metabox = thb_theme()->getPostType( 'page' )->getMetabox( 'layout' );
			$thb_tab = $thb_metabox->getTab( 'portfolio_options' );
			$thb_container = $thb_tab->getContainer( 'portfolio_loop_container' );

			$thb_field = new THB_GraphicRadioField( 'blaine_portfolio_layout' );
			$thb_field->setLabel( __('Portfolio layout', 'thb_text_domain') );
			$thb_field->setOptions(array(
				'thb-portfolio-grid-a' => get_template_directory_uri() . '/css/i/options/portfolio-grid-a.png',
				'thb-portfolio-grid-b' => get_template_directory_uri() . '/css/i/options/portfolio-grid-b.png',
				'thb-portfolio-grid-c' => get_template_directory_uri() . '/css/i/options/portfolio-grid-c.png'
			));
			$thb_container->addField($thb_field);
		}

		if( thb_is_admin_template( 'single-works.php' ) ) {
			$thb_metabox = thb_theme()->getPostType( 'works' )->getMetabox( 'layout' );
			$thb_container = $thb_metabox->getContainer( 'layout_container' );

			$thb_field = new THB_GraphicRadioField( 'blaine_single_work_layout' );
			$thb_field->setLabel( __('Single work layout', 'thb_text_domain') );
			$thb_field->setOptions(array(
				'thb-single-work-layout-a' => get_template_directory_uri() . '/css/i/options/single-layout-a.png',
				'thb-single-work-layout-b' => get_template_directory_uri() . '/css/i/options/single-layout-b.png',
				'thb-single-work-layout-c' => get_template_directory_uri() . '/css/i/options/single-layout-c.png'
			));
			$thb_container->addField($thb_field);

			$thb_field = new THB_BlaineBackgroundField( 'project_background' );
				$thb_field->setLabel( __('Background', 'thb_text_domain') );
				$thb_field->setHelp( __( 'The color of the overlay (even if not enabled) or background determines the skin used for texts (e.g. a dark color automatically generates light text).', 'thb_text_domain' ) );
			$thb_container->addField($thb_field);

			$thb_field = new THB_TextField( 'project_short_description' );
				$thb_field->setLabel( __('Project short description', 'thb_text_domain') );
				$thb_field->setHelp( __('You can place here a short description or the tagline for your project.', 'thb_text_domain') );
			$thb_container->addField($thb_field);

			$thb_field = new THB_TextField( 'project_url' );
				$thb_field->setLabel( __('Project URL', 'thb_text_domain') );
			$thb_container->addField($thb_field);

			$thb_field = new THB_CheckboxField( 'disable_work_image_link' );
				$thb_field->setLabel( __( sprintf('Disable images lightbox.') , 'thb_text_domain') );
				$thb_field->setHelp( __('Tick if you want to disable creation of a link that will open the image in a lightbox for this work.', 'thb_text_domain') );
			$thb_container->addField($thb_field);
		}
	}

	if ( function_exists( 'thb_portfolio_loop' ) ) {
		add_action( 'wp_loaded', 'thb_theme_portfolio_options' );
	}
}

if( !function_exists('thb_theme_body_classes') ) {
	/**
	 * THB custom body classes
	 */
	function thb_theme_body_classes( $classes ) {
		$thb_id = thb_get_page_ID();

		$bg_color = get_theme_mod('footer_stripe_bg', '#3f3f3f');
		$skin = 'thb-footersidebar-skin-' . thb_color_get_opposite_skin( $bg_color );
		$classes[] = $skin;

		$bg_color = get_theme_mod('footer_bg', '#333333');
		$skin = 'thb-footer-skin-' . thb_color_get_opposite_skin( $bg_color );
		$classes[] = $skin;

		if ( empty( $thb_id ) ) {
			return $classes;
		}

		$classes[] = thb_get_page_header_alignment();
		$classes[] = thb_get_layout_width();
		$classes[] = thb_get_header_position();
		$classes[] = thb_get_pageheader_layout();

		if( thb_is_page_template( 'template-portfolio.php' ) ) {
			$classes[] = thb_get_portfolio_layout();
		}

		if( thb_is_page_template( 'single-works.php' ) ) {
			$classes[] = thb_get_single_work_layout( $thb_id );
		}

		if( thb_is_page_template( 'template-photogallery.php' ) ) {
			$classes[] = thb_get_photogallery_layout();
		}

		return $classes;
	}

	add_filter('body_class', 'thb_theme_body_classes');
}

if( ! function_exists( 'thb_portfolio_likes_container' ) ) {
	/**
	 * Add a field to the Portfolio tab to activate likes for Portfolio items.
	 */
	function thb_portfolio_likes_container() {
		$portfolio_options_tab = thb_theme()->getAdmin()->getMainPage()->getTab( 'portfolio' );

		if ( $portfolio_options_tab ) {
			$thb_container = $portfolio_options_tab->getContainer( 'single_work_options' );

				$thb_field = new THB_CheckboxField( 'thb_portfolio_likes_active' );
				$thb_field->setLabel( __( 'Activate likes for Portfolio items', 'thb_text_domain' ) );

			$thb_container->addField( $thb_field );
		}
	}

	add_action( 'wp_loaded', 'thb_portfolio_likes_container' );
}

if( !function_exists('thb_portfolio_stripe_filtering_duplicable') ) {
	function thb_portfolio_stripe_filtering_duplicable() {
		if ( thb_is_admin_template( 'template-portfolio-stripe.php' ) ) {
			$thb_metabox = thb_theme()->getPostType( 'page' )->getMetabox( 'layout' );
			$thb_portfolio_options_tab = $thb_container = $thb_metabox->getTab( 'portfolio_options' );

			if ( $thb_portfolio_options_tab ) {

				$thb_container = $thb_portfolio_options_tab->getContainer( 'portfolio_loop_container' );

					$thb_container = $thb_portfolio_options_tab->createDuplicableContainer( __('Order', 'thb_text_domain'), 'portfolio_order_duplicable', 0 );
					$thb_container->setSortable( true );
					$thb_container->setIntroText( __( 'You can manually select which Portfolio items are shown in this page. You can also drag them up and down to determine their order. When using manual ordering, the options in the "Filtering & Ordering" section are ignored.', 'thb_text_domain' ) );

					$thb_container->addControl( __('Add', 'thb_text_domain'), '' );

					$thb_field = new THB_SelectField( 'portfolio_item' );
					$thb_field->addClass( 'big' );
					$thb_field->setLabel( __( 'Portfolio item', 'thb_text_domain' ) );
					$thb_field->setOptions( thb_get_post_type_for_select( 'works' ) );

				$thb_container->setField( $thb_field );

			}
		}
	}

	add_action( 'wp_loaded', 'thb_portfolio_stripe_filtering_duplicable' );
}

if ( ! function_exists( 'thb_blaine_setup_work_slides' ) ) {
	/**
	 * Setup work slides.
	 *
	 * @param THB_SlideField $slide_field
	 * @return THB_SlideField
	 */
	function thb_blaine_setup_work_slides( $slide_field ) {
		$video_modal = $slide_field->getModal( 'edit_slide_video' );

		if ( $video_modal ) {
			$container = $video_modal->getContainer( 'edit_slide_video_container' );

			$container->removeField( 'autoplay' );
			$container->removeField( 'loop' );
			$container->removeField( 'fit' );
		}

		return $slide_field;
	}

	add_filter( 'thb_work_slide', 'thb_blaine_setup_work_slides' );
}

/**
 * Shortcodes ultimate customization
 * -----------------------------------------------------------------------------
 */

if ( function_exists( 'shortcodes_ultimate' ) ) {
	/**
	 * Shortcode ultimate custom skin
	 */

	if( !function_exists('thb_shortcode_ultimate') ) {
	 	function thb_shortcode_ultimate() {
	 		return get_template_directory_uri() . '/css/shortcode-ultimate-skin' ;
		}

		add_filter( 'su/assets/skin', 'thb_shortcode_ultimate', 999 );
	}

	if( ! function_exists( 'thb_shortcode_ultimate_reset' ) ) {
		function thb_shortcode_ultimate_reset() {
			delete_transient( 'su/generator/popup' );
			delete_transient( 'su/generator/settings/colorbox' );
		}

		add_action( 'thb_theme_installation', 'thb_shortcode_ultimate_reset' );
		add_action( 'thb_theme_update', 'thb_shortcode_ultimate_reset' );
		add_action( 'thb_theme_activation', 'thb_shortcode_ultimate_reset' );
	}

	if ( ! function_exists('thb_register_colorbox_shortcode') ) {
		/**
		* Filter to modify original shortcodes data and add custom shortcodes
		*
		* @param array $shortcodes Original plugin shortcodes
		* @return array Modified array
		*/
		function thb_register_colorbox_shortcode( $shortcodes ) {
			// Add new shortcode
			$shortcodes['colorbox'] = array(
				'name' => __( 'Colored box', 'thb_text_domain' ),
				'type' => 'wrap',
				'group' => 'box',
				'atts' => array(
					'style' => array(
						'type' => 'select',
						'values' => array(
							'filled' => __( 'Filled with color', 'thb_text_domain' ),
							'border' => __( 'Only border', 'thb_text_domain' )
						),
						'default' => 'filled',
						'name' => __( 'Style', 'thb_text_domain' ),
						'desc' => __( 'Colored box style', 'thb_text_domain' )
					),
					'image' => array(
						'type' => 'upload',
						'default' => '',
						'name' => __( 'Image', 'thb_text_domain' ),
						'desc' => __( 'Upload an image for the box', 'thb_text_domain' )
					),
					'image_alignment' => array(
						'type' => 'select',
						'values' => array(
							'left' => __( 'Left', 'thb_text_domain' ),
							'right' => __( 'Right', 'thb_text_domain' ),
							'center' => __( 'Centered', 'thb_text_domain' )
						),
						'default' => 'left',
						'name' => __( 'Image alignment', 'thb_text_domain' ),
						'desc' => __( 'Choose the alignement for the image', 'thb_text_domain' )
					),
					'column_size' => array(
						'type' => 'select',
						'values' => array(
							'third' => __( '1/3', 'thb_text_domain' ),
							'fourth' => __( 'One half', 'thb_text_domain' )
						),
						'default' => 'third',
						'name' => __( 'Text column size', 'thb_text_domain' ),
						'desc' => __( 'Choose the size for the text column', 'thb_text_domain' )
					),
					'box_color' => array(
						'type' => 'color',
						'values' => array( ),
						'default' => '#333333',
						'name' => __( 'Background color', 'thb_text_domain' ),
						'desc' => __( 'Color for the box or borders', 'thb_text_domain' )
					),
					'text_color' => array(
						'type' => 'color',
						'values' => array( ),
						'default' => '#FFFFFF',
						'name' => __( 'Text color', 'thb_text_domain' ), 'desc' => __( 'Color for the box text', 'thb_text_domain' )
					),
					'class' => array(
						'default' => '',
						'name' => __( 'Class', 'thb_text_domain' ),
						'desc' => __( 'Extra CSS class', 'thb_text_domain' )
					)
				),
				'usage' => '[colorbox] Content [/colorbox]',
				'content' => __( 'Colored box text', 'thb_text_domain' ),
				'desc' => __( 'Styled Colored box', 'thb_text_domain' ),
				'icon' => 'list-alt',
				'function' => 'thb_colorbox_shortcode'
			);
			return $shortcodes;
		}

		add_filter( 'su/data/shortcodes', 'thb_register_colorbox_shortcode' );
	}

	if ( ! function_exists('thb_colorbox_shortcode') ) {
		/**
		* Custom colored box shortcode function
		*
		* @param array $atts Shortcode attributes
		* @param string $content Shortcode content
		* @return string Shortcode markup
		*/
		function thb_colorbox_shortcode( $atts, $content = null ) {
			$atts = shortcode_atts( array(
				'style' => 'filled',
				'box_color'   => '#333333',
				'text_color' => '#FFFFFF',
				'class' => '',
				'image' => '',
				'image_alignment' => 'left',
				'column_size' => ''
			), $atts );

			$image = '';
			$style = '';
			$column_size = $atts['column_size'];
			$class = $atts['class'];

			if ( $atts['image'] != '' ) {
				$image_url = $atts['image'];
				$image_alignment = $atts['image_alignment'];

				if ( $column_size === 'fourth' ) {
					$column_size = '4';
				} else {
					$column_size = '3';
				}

				if ( $image_alignment === 'left' ) {
					$class .= 'thb-left-image';
				} elseif ( $image_alignment === 'right' ) {
					$class .= 'thb-right-image';
				} elseif ( $image_alignment === 'center' ) {
					$class .= 'thb-center-image';
				}
			}

			if ( $atts['style'] === 'border' ) {
				$style = 'border: 1px solid ' . $atts['box_color'] . ';';
			} else {
				$style = 'background-color:' . $atts['box_color'] . ';color:' . $atts['text_color'] . ';';
			}

			$return = '<div class="thb-color-box thb-color-box-style-' . $atts['style'] . ' ' . $class . '" style="' . $style . '">';
				if ( $atts['image'] != '' ) {
					$return .= '<div class="thb-col thb-col-text thb-col-size-' . $column_size . '">' . su_do_shortcode( $content, 'c' ) . '</div>';
					$return .= '<div class="thb-col thb-col-image thb-col-size-' . $column_size . '"><img src="' . $image_url . '" /></div>';
				} else {
					$return .= su_do_shortcode( $content, 'c' );
				}
			$return .= '</div>';

			return $return;
		}
	}

	if ( ! function_exists('thb_register_featurebox_shortcode') ) {
		/**
		* Filter to modify original shortcodes data and add custom shortcodes
		*
		* @param array $shortcodes Original plugin shortcodes
		* @return array Modified array
		*/
		function thb_register_featurebox_shortcode( $shortcodes ) {
			$shortcodes['featurebox'] = array(
				'name'  => __( 'Feature box', 'thb_text_domain' ),
				'type'  => 'wrap',
				'group' => 'box',
				'atts'  => array(
					'title' => array(
						'values'  => array( ),
						'default' => __( 'Feature name', 'su' ),
						'name'    => __( 'Title', 'su' ),
						'desc'    => __( 'Service name', 'su' )
					),
					'style' => array(
						'type' => 'select',
						'values' => array(
							'standard' => __( 'Icon only', 'thb_text_domain' ),
							'filled' => __( 'Filled circle icon', 'thb_text_domain' ),
							'border' => __( 'Circle border icon', 'thb_text_domain' )
						),
						'default' => 'standard',
						'name' => __( 'Style', 'thb_text_domain' ),
						'desc' => __( 'Icon style', 'thb_text_domain' )
					),
					'icon' => array(
						'type'    => 'icon',
						'default' => '',
						'name'    => __( 'Icon', 'su' ),
						'desc'    => __( 'You can upload custom icon for this box', 'su' )
					),
					'icon_color' => array(
						'type'    => 'color',
						'default' => '#333333',
						'name'    => __( 'Icon color', 'su' ),
						'desc'    => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'su' )
					),
					'icon_alignment' => array(
						'type' => 'select',
						'values' => array(
							'left'   => __( 'Left', 'thb_text_domain' ),
							'right'  => __( 'Right', 'thb_text_domain' ),
							'center' => __( 'Centered', 'thb_text_domain' )
						),
						'default' => 'left',
						'name'    => __( 'Icon alignment', 'thb_text_domain' ),
						'desc'    => __( 'Choose the alignement for the image', 'thb_text_domain' )
					),
					'size' => array(
						'type'    => 'slider',
						'min'     => 10,
						'max'     => 256,
						'step'    => 2,
						'default' => 48,
						'name'    => __( 'Icon size', 'su' ),
						'desc'    => __( 'Size of the uploaded icon in pixels', 'su' )
					),
					'class' => array(
						'default' => '',
						'name'    => __( 'Class', 'thb_text_domain' ),
						'desc'    => __( 'Extra CSS class', 'thb_text_domain' )
					)
				),
				'usage'    => '[featurebox] Content [/featurebox]',
				'content'  => __( 'Feature box text', 'thb_text_domain' ),
				'desc'     => __( 'Styled feature box', 'thb_text_domain' ),
				'icon'     => 'check-square-o',
				'function' => 'thb_featurebox_shortcode'
			);
			// Return modified data
			return $shortcodes;
		}

		add_filter( 'su/data/shortcodes', 'thb_register_featurebox_shortcode' );
	}

	if ( ! function_exists('thb_featurebox_shortcode') ) {
		/**
		* Custom feature box shortcode function
		*
		* @param array $atts Shortcode attributes
		* @param string $content Shortcode content
		* @return string Shortcode markup
		*/
		function thb_featurebox_shortcode( $atts, $content = null ) {
			$atts = shortcode_atts( array(
				'title'          => __( 'Feature name', 'su' ),
				'style'          => 'standard',
				'class'          => '',
				'icon'           => plugins_url( 'assets/images/service.png', SU_PLUGIN_FILE ),
				'icon_color'     => '#333',
				'size'           => 48,
				'icon_alignment' => 'left'
			), $atts );

			$style = '';
			$box_style = '';
			$icon_style = $atts['style'];
			$class = $atts['class'];
			$icon_alignment = $atts['icon_alignment'];

			if ( $icon_style == 'filled' || $icon_style == 'border' ) {
				$icon_size = $atts['size'] + 50;
			} else {
				$icon_size = $atts['size'];
			}

			if ( $icon_alignment != '' ) {

				if ( $icon_alignment === 'left' ) {

					$class .= 'thb-left-icon';
					$box_style .= 'padding-left:' . round( $icon_size + 24 ) . 'px;min-height:' . $icon_size . 'px;';

				} elseif ( $icon_alignment === 'right' ) {

					$class .= 'thb-right-icon';
					$box_style .= 'padding-right:' . round( $icon_size + 24 ) . 'px;min-height:' . $icon_size . 'px;';

				} elseif ( $icon_alignment === 'center' ) {
					$class .= 'thb-center-icon';
				}

			}

			$return = '<div class="thb-feature-box ' . $class . '" style="' . $style . '">';

				if ( $icon_style == 'filled' ) {
					$icon_color = 'border-radius:100%;width:' . $icon_size . 'px;height:' . $icon_size . 'px;line-height:' . $icon_size . 'px;background-color:' . $atts['icon_color'] . ';color:#fff;';
				} elseif ( $icon_style == 'border' ) {
					$icon_color = 'border-radius:100%;width:' . $icon_size . 'px;height:' . $icon_size . 'px;line-height:' . ($icon_size - 10) . 'px;border:5px solid ' . $atts['icon_color'] . ';color:' . $atts['icon_color'] . ';';
				} else {
					$icon_color = 'color:' . $atts['icon_color'];
				}

				// Built-in icon
				if ( strpos( $atts['icon'], 'icon:' ) !== false ) {
					$atts['icon'] = '<i class="fa fa-' . trim( str_replace( 'icon:', '', $atts['icon'] ) ) . '" style="font-size:' . $atts['size'] . 'px; ' . $icon_color . '"></i>';
					su_query_asset( 'css', 'font-awesome' );
				}
				// Uploaded icon
				else {
					$atts['icon'] = '<img class="thb-feature-box-img" src="' . $atts['icon'] . '" width="' . $atts['size'] . '" height="' . $atts['size'] . '" alt="' . $atts['title'] . '" />';
				}
				su_query_asset( 'css', 'su-box-shortcodes' );

				$return .= $atts['icon'];

				$return .= '<div class="thb-feature-box-content" style="' . $box_style .'">';
					$return .= '<h5 class="thb-feature-box-title">' . su_scattr( $atts['title'] ) . '</h5>';
					$return .= do_shortcode( $content );
				$return .= '</div>';

			$return .= '</div>';

			return $return;
		}
	}
}