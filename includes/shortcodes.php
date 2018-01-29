<?php
/**
 * Theme Blvd Shortcodes
 *
 * (1) Columns
 *      - column            => @since 1.5.0
 *		- one_sixth 		=> @since 1.0.0 @deprecated 1.5.0
 *		- one_fourth		=> @since 1.0.0 @deprecated 1.5.0
 *		- one_third			=> @since 1.0.0 @deprecated 1.5.0
 *		- one_half			=> @since 1.0.0 @deprecated 1.5.0
 *		- two_third			=> @since 1.0.0 @deprecated 1.5.0
 *		- three_fourth 		=> @since 1.0.0 @deprecated 1.5.0
 *		- one_fifth			=> @since 1.0.0 @deprecated 1.5.0
 *		- two_fifth			=> @since 1.0.0 @deprecated 1.5.0
 *		- three_fifth		=> @since 1.0.0 @deprecated 1.5.0
 *		- four_fifth		=> @since 1.0.0 @deprecated 1.5.0
 *		- three_tenth		=> @since 1.0.0 @deprecated 1.5.0
 *		- seven_tenth		=> @since 1.0.0 @deprecated 1.5.0
 * (2) Components
 *		- icon_list			=> @since 1.0.0
 *		- button 			=> @since 1.0.0
 *		- box				=> @since 1.0.0 @deprecated 1.4.0
 *		- alert				=> @since 1.0.0
 *		- divider			=> @since 1.0.0
 *		- popup				=> @since 1.0.0
 *      - lightbox          => @since 1.1.0
 *      - lightbox_gallery  => @since 1.1.0
 *      - blockquote        => @since 1.2.0
 *      - jumbotron         => @since 1.3.0
 *      - panel             => @since 1.3.0
 *      - testimonial       => @since 1.5.0
 *      - pricing_table     => @since 1.5.0
 * (3) Inline Elements
 *		- icon				=> @since 1.0.0
 *		- icon_link 		=> @since 1.0.0
 *		- highlight			=> @since 1.0.0
 *		- dropcap			=> @since 1.0.0
 *		- label				=> @since 1.0.0
 *		- vector_icon		=> @since 1.0.0
 *      - lead              => @since 1.5.0
 * (3) Tabs, Accordion, & Toggles
 *		- tabs				=> @since 1.0.0
 *		- accordion			=> @since 1.0.0
 *		- toggle			=> @since 1.0.0
 * (5) Sliders
 *      - post_slider       => @since 1.5.0 (moved from Sliders plugin)
 *		- post_grid_slider	=> @since 1.0.0
 *		- post_list_slider	=> @since 1.0.0
 *      - gallery_slider    => @since 1.3.0
 * (6) Display Posts
 *      - blog              => @since 1.5.0
 *		- post_grid			=> @since 1.0.0
 *      - post_showcase     => @since 1.5.0
 *		- post_list			=> @since 1.0.0
 *		- mini_post_grid	=> @since 1.0.0
 *		- mini_post_list	=> @since 1.0.0
 * (7) Stats
 *      - progess_bar       => @since 1.0.0
 *      - milestone         => @since 1.5.0
 *      - milestone_ring    => @since 1.5.0
 *
 * @package Theme Blvd Shortcodes
 */

/**
 * Columns
 *
 * @since 1.0.0
 *
 * @param array  $atts Shortcode attributes..
 * @param string $content The enclosed content.
 * @param string $tag Current shortcode tag.
 * @return string Content to output for shortcode.
 */
function themeblvd_shortcode_column( $atts, $content = null, $tag = '' ) {

	$column = Theme_Blvd_Column_Shortcode::get_instance();

	return $column->get( $atts, $content, $tag );

}

/**
 * Clear Row
 *
 * @deprecated 1.5.0
 * @since 1.0.0
 */
function themeblvd_shortcode_clear() {
	return '<div class="clear"></div>';
}

/**
 * Icon List
 *
 * @since 1.0.0
 *
 * @param  array  $atts Shortcode attributes.
 * @param  string $content The enclosed content.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_icon_list( $atts, $content = null ) {

	$atts = shortcode_atts( array(
		'style' => '',					// @deprecated check, crank, delete, doc, plus, star, star2, warning, write
		'icon'	=> 'caret-right',		// Any fontawesome icon.
		'color'	=> '',					// Optional color hex for icon - ex: #000000
	), $atts );

	/**
	 * For those using old "style" method, this will
	 * match the old style choices to a fontawesome icon
	 * and add in a relevant color.
	 */
	if ( $atts['style'] ) {

		switch ( $atts['style'] ) {

		    case 'check' :

		    	$atts['icon'] = 'ok-sign';
		    	$atts['color'] = '#59f059';
		    	break;

		    case 'crank' :

		    	$atts['icon'] = 'cog';
		    	$atts['color'] = '#d7d7d7';
		    	break;

		    case 'delete' :

		    	$atts['icon'] = 'remove-sign';
		    	$atts['color'] = '#ff7352';
		    	break;

		    case 'doc' :

		    	$atts['icon'] = 'file';
		    	$atts['color'] = '#b8b8b8';
		    	break;

		    case 'plus' :

		    	$atts['icon'] = 'plus-sign';
		    	$atts['color'] = '#59f059';
		    	break;

		    case 'star' :

		    	$atts['icon'] = 'star';
		    	$atts['color'] = '#eec627';
		    	break;

		    case 'star2' :

		    	$atts['icon'] = 'star';
		    	$atts['color'] = '#a7a7a7';
		    	break;

		    case 'warning' :

		    	$atts['icon'] = 'warning-sign';
		    	$atts['color'] = '#ffd014';
		    	break;

		    case 'write' :

		    	$atts['icon'] = 'pencil';
		    	$atts['color'] = '#ffd014';
		    	break;

	    }
	}

	// Setup color.
	$color_css = '';

	if ( $atts['color'] ) {

		$color_css = ' style="color:' . esc_attr( $atts['color'] ) . ';"';

	}

	$content = str_replace( '<ul>', '<ul class="tb-icon-list fa-ul">', $content );

	if ( function_exists( 'themeblvd_get_icon_class' ) ) { // Framework 2.7+

		$content = str_replace( '<li>', '<li><span class="fa-li" ' . $color_css . '><i class="' . esc_attr( themeblvd_get_icon_class( $atts['icon'] ) ) . '"></i></span> ', $content );

	} elseif ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

		$content = str_replace( '<li>', '<li><i class="fa-li fa fa-' . esc_attr( $atts['icon'] ) . '"' . $color_css . '></i> ', $content );

	} else {

		$content = str_replace( '<li>', '<li><i class="icon-' . esc_attr( $atts['icon'] ) . '"' . $color_css . '></i> ', $content );

	}

	return do_shortcode( $content );

}

/**
 * Button
 *
 * @since 1.0.0
 *
 * @param  array  $atts Shortcode attributes.
 * @param  string $content The enclosed content.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_button( $atts, $content = null ) {

	$output = '';

	$atts = shortcode_atts( array(
		'link'              => '',
		'color'             => 'default',
		'target'            => '_self',
		'size'              => '',
		'class'             => '',
		'title'             => '',
		'icon_before'       => '',
		'icon_after'        => '',
		'block'             => 'false',
		'bg'                => '#ffffff',
		'bg_hover'          => '#ebebeb',
		'border'            => '#cccccc',
		'text'              => '#333333',
		'text_hover'        => '#333333',
		'include_bg'        => 'true',
		'include_border'    => 'true',
	), $atts );

	$class = 'btn-shortcode';

	if ( $atts['class'] ) {

		$class .= ' ' . $atts['class'];

	}

	if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

		$addon = '';

		if ( 'custom' === $atts['color'] && version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '>=' ) ) {

			if ( 'true' !== $atts['include_bg']  ) {

				$atts['bg'] = 'transparent';

			}

			if ( 'true' !== $atts['include_border'] ) {

				$atts['border'] = 'transparent';

			}

			$addon = sprintf(
				'style="background-color: %1$s; border-color: %2$s; color: %3$s;" data-bg="%1$s" data-bg-hover="%4$s" data-text="%3$s" data-text-hover="%5$s"',
				$atts['bg'],
				$atts['border'],
				$atts['text'],
				$atts['bg_hover'],
				$atts['text_hover']
			);

		}

		if ( 'true' === $atts['block'] ) {

			$block = true;

		} else {

			$block = false;

		}

		$output = themeblvd_button(
			$content,
			$atts['link'],
			$atts['color'],
			$atts['target'],
			$atts['size'],
			$class,
			$atts['title'],
			$atts['icon_before'],
			$atts['icon_after'],
			$addon,
			$block
		);

	} else {

		$output = themeblvd_button(
			$content,
			$atts['link'],
			$atts['color'],
			$atts['target'],
			$atts['size'],
			$class,
			$atts['title'],
			$atts['icon_before'],
			$atts['icon_after']
		);

	}

	return $output;

}

/**
 * Info Boxes
 *
 * @since 1.0.0
 *
 * @param  array  $atts Shortcode attributes.
 * @param  string $content The enclosed content.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_box( $atts, $content = null ) {

	$atts = shortcode_atts( array(
		'style'	=> 'blue', // Possible Values: blue, green, grey, orange, purple, red, teal, yellow.
		'icon' 	=> '',
	), $atts );

	$class = sprintf( 'info-box info-box-%s', $atts['style'] );

	if ( $atts['icon'] ) {

		$class .= ' info-box-has-icon';

		if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

			$content = sprintf( '<i class="icon fa fa-%s"></i>%s', $atts['icon'], $content );

		} else {

			$content = sprintf( '<i class="icon-%s"></i>%s', $atts['icon'], $content );

		}
	}

	return sprintf(
		'<div class="%s">%s</div>',
		$class,
		/**
		 * Standard filter in Theme Blvd Framework, where
		 * sanitization is applied.
		 *
		 * @since 1.1.0
		 *
		 * @var string
		 */
		apply_filters( 'themeblvd_the_content', $content )
	);

}

/**
 * Alerts (from Bootstrap)
 *
 * @since 1.0.0
 *
 * @param  array  $atts Shortcode attributes.
 * @param  string $content The enclosed content.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_alert( $atts, $content = null ) {

	$atts = shortcode_atts( array(
		'style' => 'info',  // Possible Values: info, success, danger, warning.
		'close' => 'false', // Possible Values: true, false.
	), $atts );

	// In Bootstrap 3, 'message' was changed to 'warning'.
	if ( 'message' === $atts['style'] ) {

		$atts['style'] = 'warning';

	}

	$class = 'alert';

	if ( in_array( $atts['style'], array( 'info', 'success', 'danger', 'warning' ), true ) ) { // Twitter Bootstrap options.

		$class .= sprintf( ' alert-%s', $atts['style'] );

	}

	if ( 'true' === $atts['close'] ) {

		$class .= ' fade in';

	}

	$output = sprintf( '<div class="%s">', $class );

	if ( 'true' === $atts['close'] ) {

		$output .= '<button type="button" class="close" data-dismiss="alert">×</button>';

	}

	$output .= $content . '</div><!-- .alert (end) -->';

	return $output;
}

/**
 * Divider
 *
 * @since 1.0.0
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content The enclosed content.
 */
function themeblvd_shortcode_divider( $atts, $content = null ) {

	$atts = shortcode_atts( array(
		'style'         => 'solid',     // Style of divider - shadow, solid, dashed, thick-solid, thick-dashed, double-solid, double-dashed.
		'color'         => '#cccccc',   // Hex color of divider (not for shadow style).
		'opacity'       => '1',         // Opacity of divider (not for shadow style).
		'icon'          => '',          // Icon placed in middle of devider, FontAwesome ID (not for shadow style).
		'icon_color'    => '#666666',   // Color of icon (not for shadow style).
		'icon_size'     => '15',        // Font size of icon (not for shadow style).
		'width'         => '',          // A width for the divider in pixels.
		'placement'     => 'equal',      // Where the divider sits between the content - equal, above (closer to content above), below (closer to content below).
	), $atts );

	if ( function_exists( 'themeblvd_get_divider' ) ) { // Framework 2.5+.

		$atts['type'] = $atts['style'];

		if ( $atts['icon'] ) {

		    $atts['insert'] = 'icon';
		    $atts['text_color'] = $atts['icon_color'];
		    $atts['text_size'] = $atts['icon_size'];

		}

		$output = themeblvd_get_divider( $atts );

	} else {

	    $output = themeblvd_divider( $atts['style'] ); // @deprecated

	}

	return $output;

}

/**
 * Popup (from Bootstrap)
 *
 * @since 1.0.0
 *
 * @param  array  $atts Shortcode attributes.
 * @param  string $content Enclosed content.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_popup( $atts, $content = null ) {

	$atts = shortcode_atts( array(
		'text' 			=> 'Link Text', // Text for link or button leading to popup.
		'title' 		=> '', 			// Title for anchor, will default to "text" option.
		'color' 		=> 'default', 	// Color of button, only applies if button style is selected.
		'size'			=> '',			// Size of button.
		'icon_before'	=> '', 			// Icon before button or link's text.
		'icon_after' 	=> '', 			// Icon after button or link's text.
		'header' 		=> '', 			// Header text for popup.
		'animate' 		=> 'false',		// Whether popup slides in or not - true, false.
	), $atts );

	$atts['id'] = uniqid( 'popup_' . rand() );

	$atts['content'] = $content;

	$popups = Theme_Blvd_Popup_Shortcode::get_instance();
	$popups->add( $atts );

	/**
	 * Standard filter in Theme Blvd Framework, where
	 * sanitization is applied.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	return apply_filters( 'themeblvd_the_content', themeblvd_button(
		$atts['text'],
		'#' . $atts['id'],
		$atts['color'],
		null,
		$atts['size'],
		null,
		$atts['text'],
		$atts['icon_before'],
		$atts['icon_after'],
		'data-toggle="modal"'
	));
}

/**
 * Lightbox
 *
 * @since 1.1.0
 *
 * @param  array  $atts Shortcode attributes.
 * @param  string $content Content in shortcode.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_lightbox( $atts, $content = null ) {

	// Shortcode requires framework 2.3+.
	if ( ! function_exists( 'themeblvd_is_lightbox_url' ) ) {

	    return sprintf(
			'<div class="alert">%s</div>',
			__( 'You must be using a theme with Theme Blvd framework v2.3+ to use the [lightbox] shortcode.', 'theme-blvd-shortcodes' )
		);

	}

	$atts = shortcode_atts( array(
	    'link'      => '',          // URL being linked to in the lightbox popup.
	    'thumb'     => '',          // Text or Image URL being used for link to lightbox.
	    'caption'   => '',          // Caption below thumbnail.
	    'width'     => '',          // Width of tumbnail image linking to lighbox.
	    'align'     => 'none',      // Alignment of thumbnail image.
	    'title'     => '',          // Title displayed in lightbox link.
	    'frame'     => 'true',      // Whether or not to display frame around thumbnail.
	    'frame_max' => 'true',      // Whether or not the frame takes on the image's width as a max-width (super-secret and not in generator).
	    'icon'      => 'image',     // Icon for thumbnail if in frame - video or image.
	    'class'     => '',          // Class to append to <a>, or frame if enabled.
	), $atts );

	$output = '';

	$thumb = $atts['thumb'];
	$has_thumb_img = false;
	$thumb_type = wp_check_filetype( $thumb );

	if ( 'image' === substr( $thumb_type['type'], 0, 5 ) ) {

	    $has_thumb_img = true;

	    $thumb = sprintf( '<img src="%s" alt="%s"', $thumb, $atts['title'] );

	    if ( $atts['width'] ) {

	        $thumb .= sprintf( ' width="%s"', $atts['width'] );

	    }

	    if ( 'false' === $atts['frame'] && 'none' !== $atts['align'] ) {

	        // If image is framed, the alignment will be on the frame.
	        $thumb .= sprintf( ' class="align%s"', $atts['align'] );

	    }

	    $thumb .= ' />';

		if ( function_exists( 'themeblvd_get_thumbnail_link_icon' ) ) {

			$thumb .= themeblvd_get_thumbnail_link_icon( $atts['icon'] );

		}
	}

	$anchor_classes = 'tb-thumb-link ' . $atts['icon'];

	if ( 'true' === $atts['frame'] ) {

	    $anchor_classes .= ' thumbnail';

	}

	if ( 'false' === $atts['frame'] && $atts['class'] ) {

	    $anchor_classes .= ' ' . $atts['class'];

	}

	if ( $atts['caption'] ) {

	    $anchor_classes .= ' has-caption';

	}

	/**
	 * Filter arguments used to wrap thumbnail image/text
	 * in a link to a lightbox, which are passed to
	 * themeblvd_get_link_to_lightbox().
	 *
	 * @since 1.1.0
	 *
	 * @var array
	 * @param array $atts All attributes for shortcode.
	 */
	$args = apply_filters( 'themeblvd_lightbox_shortcode_args', array(
	    'item'      => $thumb,
	    'link'      => $atts['link'],
	    'title'     => $atts['title'],
	    'class'     => $anchor_classes,
	), $atts );

	$output .= themeblvd_get_link_to_lightbox( $args );

	// Wrap link and thumbnail image in frame.
	if ( 'true' === $atts['frame'] && $has_thumb_img ) {

	    $wrap_classes = 'tb-lightbox-shortcode';

	    if ( 'none' !== $atts['align'] ) {

	        $wrap_classes .= ' align' . $atts['align'];

	    }

	    if ( $atts['class'] ) {

	        $wrap_classes .= ' ' . $atts['class'];

	    }

	    // Force inline styling.
	    $style = '';

	    if ( $atts['width'] && 'true' === $atts['frame_max'] ) {

	        $style = sprintf( 'max-width: %spx', $atts['width'] );

	    }

	    $wrap  = '<div class="' . $wrap_classes . '" style="' . $style . '">';
	    $wrap .= '%s';

	    if ( $atts['caption'] ) {

	        $wrap .= sprintf( '<p class="wp-caption-text">%s</p>', $atts['caption'] );

	    }

	    $wrap .= '</div>';

		/**
		 * Filter the wrapping thumbnail template
		 * used with sprintf().
		 *
		 * @since 1.1.0
		 *
		 * @var string
		 * @param string $wrap_classes CSS classes incorporated into wrapping HTML.
		 * @param string $style        Inline styles incorporated into wrapping HTML.
		 */
	    $wrap = apply_filters( 'themeblvd_lightbox_shortcode_thumbnail_wrap', $wrap, $wrap_classes, $style );

	    $output = sprintf( $wrap, $output );

	} elseif ( $atts['caption'] ) {

	    $output .= sprintf( '<p class="wp-caption-text">%s</p>', $atts['caption'] );

	}

	/**
	 * Filter the wrapping thumbnail template
	 * used with sprintf().
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 * @param array  $atts  All attributes for shortcode.
	 * @param string $thumb HTML for thumbnail image only.
	 */
	return apply_filters( 'themeblvd_shortcode_lightbox', $output, $atts, $thumb );

}

/**
 * Wrap a set of [lightbox] instances to link as a gallery.
 *
 * @since 1.1.0
 *
 * @param array  $atts Shortcode attributes (currently uses no attrbutes).
 * @param string $content Content in shortcode.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_lightbox_gallery( $atts, $content = null ) {

	// Shortcode requires framework 2.3+.
	if ( ! function_exists( 'themeblvd_is_lightbox_url' ) ) {

	    return sprintf(
			'<div class="alert">%s</div>',
			__( 'You must be using a theme with Theme Blvd framework v2.3+ to use the [lightbox] shortcode.', 'theme-blvd-shortcodes' )
		);

	}

	return sprintf( '<div class="themeblvd-gallery">%s</div>', do_shortcode( $content ) );

}

/**
 * Blockquote
 *
 * @since 1.2.0
 *
 * @param array $atts Shortcode attributes.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_blockquote( $atts ) {

	$atts = shortcode_atts( array(
	    'quote'         => '',
	    'source'        => '',      // Source of quote.
	    'source_link'   => '',      // URL to link source to.
	    'align'         => '',      // How to align blockquote - left, right.
	    'max_width'     => '',      // Meant to be used with align left/right - 300px, 50%, etc.
	    'class'         => '',      // Any additional CSS classes.
	), $atts );

	$output = __( 'Your theme does not support the [blockquote] shortcode.', 'theme-blvd-shortcodes' );

	if ( function_exists( 'themeblvd_get_blockquote' ) ) { // Framework 2.4+.

	    $output = themeblvd_get_blockquote( $atts );

	}

	return $output;
}

/**
 * Jumbotron
 *
 * @since 1.3.0
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content Content in shortcode.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_jumbotron( $atts, $content = null ) {

	$atts = shortcode_atts( array(
	    'title'         => '',      // Title of unit.
	    'bg_color'      => '',      // Background hex color value (framework 2.5+).
	    'title_size'    => '30px',  // Title text size (framework 2.5+).
	    'title_color'   => '',      // Title text hex color value (framework 2.5+).
	    'text_size'     => '18px',  // Content text size (framework 2.5+).
	    'text_color'    => '',      // Content text hex color value (framework 2.5+).
	    'text_align'    => 'left',  // How to align text - left, right, center.
	    'align'         => '',      // How to align jumbotron - left, right, center.
	    'max_width'     => '',      // Meant to be used with align left/right - 300px, 50%, etc.
	    'class'         => '',      // Any additional CSS classes.
	    'wpautop'       => 'true',  // Whether to apply wpautop on content.
	), $atts );

	$output = __( 'Your theme does not support the [jumbotron] shortcode.', 'theme-blvd-shortcodes' );

	if ( function_exists( 'themeblvd_get_jumbotron' ) ) { // Framework 2.4.2.

	    // Format content for framework 2.5+.
	    if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '>=' ) ) {

	        $atts['blocks'] = array();

	        if ( $atts['title'] ) {

	            $atts['blocks']['block_1'] = array(
					'text'				=> $atts['title'],
				    'size'				=> $atts['title_size'],
				    'color'				=> $atts['title_color'],
				    'apply_bg_color'	=> '0',
				    'bg_color'			=> '#f2f2f2',
				    'bg_opacity'		=> '1',
				    'bold'				=> '1',
				    'italic'			=> '0',
				    'caps'				=> '0',
				    'wpautop'			=> '1',
				);

	        }

	        $atts['blocks']['block_2'] = array(
	            'text'				=> $content,
	            'size'				=> $atts['text_size'],
	            'color'				=> $atts['text_color'],
	            'apply_bg_color'	=> '0',
	            'bg_color'			=> '#f2f2f2',
	            'bg_opacity'		=> '1',
	            'bold'				=> '0',
	            'italic'			=> '0',
	            'caps'				=> '0',
	            'wpautop'			=> '1',
	        );

	        $content = null; // Content blocks above replace $content in framework 2.5+.

	    }

	    if ( $atts['bg_color'] ) {

	        $atts['apply_bg_color'] = '1';
	        $atts['apply_content_bg'] = '1'; // Framework 2.5+.
	        $atts['content_bg_color'] = $atts['bg_color']; // Framework 2.5+.

	    }

	    $atts['max'] = $atts['max_width'];

	    if ( 'false' === $atts['wpautop'] ) {

	        $atts['wpautop'] = false;

	    } else {

	        $atts['wpautop'] = true;

	    }

	    $output = themeblvd_get_jumbotron( $atts, $content );

	}

	return $output;
}

/**
 * Panel
 *
 * @since 1.3.0
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content Content in shortcode.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_panel( $atts, $content = null ) {

	$atts = shortcode_atts( array(
	    'style'         => 'default',   // Style of panel - primary, success, info, warning, danger.
	    'title'         => '',          // Header for panel.
	    'footer'        => '',          // Footer for panel.
	    'text_align'    => 'left',      // How to align text - left, right, center.
	    'align'         => '',          // How to align panel - left, right.
	    'max_width'     => '',          // Meant to be used with align left/right - 300px, 50%, etc.
	    'class'         => '',          // Any additional CSS classes.
	    'wpautop'       => 'true',      // Whether to apply wpautop on content.
	), $atts );

	if ( 'true' === $atts['wpautop'] ) {

	    $content = wpautop( $content );

	}

	if ( function_exists( 'themeblvd_get_panel' ) ) { // Framework 2.5+.

	    $output = themeblvd_get_panel( $atts, $content );

	} else {

	    $class = sprintf( 'panel panel-%s text-%s', $atts['style'], $atts['text_align'] );

	    if ( $atts['class'] ) {

	        $class .= ' ' . $atts['class'];

	    }

	    $output = sprintf( '<div class="%s">', $class );

	    if ( $atts['title'] ) {

	        $output .= sprintf( '<div class="panel-heading"><h3 class="panel-title">%s</h3></div>', $atts['title'] );

	    }

	    $output .= sprintf( '<div class="panel-body">%s</div>', do_shortcode( $content ) );

	    if ( $atts['footer'] ) {

	        $output .= sprintf( '<div class="panel-footer">%s</div>', $atts['footer'] );

	    }

	    $output .= '</div><!-- .panel (end) -->';

	}

	return $output;

}

/**
 * Testimonial
 *
 * @since 1.5.0
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content Content in shortcode.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_testimonial( $atts, $content = null ) {

	// This shortcode requires Theme Blvd Framework 2.5+.
	if ( ! function_exists( 'themeblvd_get_team_member' ) ) {

	    return __( 'Your theme does not support the [testimonial] shortcode. You must be using a theme with Theme Blvd Framework 2.5+', 'theme-blvd-shortcodes' );

	}

	$atts = shortcode_atts( array(
	    'text'          => '',      // Text for testimonial.
	    'name'          => '',      // Name of person giving testimonial.
	    'tagline'       => '',      // Tagline or position of person giving testimonial.
	    'company'       => '',      // Company of person giving testimonial.
	    'company_url'   => '',      // Company URL of person giving testimonial.
	    'image'         => array(), // Image of person giving testimonial.
	), $atts );

	$image = $atts['image'];

	$atts['image'] = array();

	if ( $image ) {

	    $atts['image']['src'] = $image;
	    $atts['image']['title'] = $atts['name'];

	}

	if ( $content ) {

	    $atts['text'] = $content;

	}

	return themeblvd_get_testimonial( $atts );

}

/**
 * Pricing table
 *
 * @since 1.5.0
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content Content in shortcode.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_pricing_table( $atts, $content = null ) {

	// This shortcode requires Theme Blvd Framework 2.5+.
	if ( ! function_exists( 'themeblvd_get_pricing_table' ) ) {

	    return __( 'Your theme does not support the [pricing_table] shortcode. You must be using a theme with Theme Blvd Framework 2.5+', 'theme-blvd-shortcodes' );

	}

	$atts = shortcode_atts( array(
	    'currency'              => '$',         // Symbol to represent currency.
	    'currency_placement'	=> 'before',    // Whether to place the currency symbol before or after prices.
	), $atts );

	$cols = array();
	$pattern = str_replace( 'pricing_table', 'pricing_table|pricing_column', get_shortcode_regex() );

	if ( preg_match_all( '/' . $pattern . '/s', $content, $m ) ) {

	    if ( ! empty( $m[0] ) ) {

	        foreach ( $m[0] as $key => $val ) {

	            $cols[ $key ] = shortcode_parse_atts( $m[3][ $key ] );
	            $cols[ $key ]['features'] = trim( $m[5][ $key ] );

	            if ( ! empty( $cols[ $key ]['button_text'] ) ) {

	                $cols[ $key ]['button'] = true;

	            }
	        }
	    }
	}

	return themeblvd_get_pricing_table( $cols, $atts );
}

/**
 * 48px Icon (NOT Font Awesome icons)
 *
 * @since 1.0.0
 * @deprecated 1.5.8
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content The enclosed content.
 * @return string Content to output for shortcode.
 */
function themeblvd_shortcode_icon( $atts, $content = null ) {

	$atts = shortcode_atts( array(
	    'image' => 'accepted',
	    'align' => 'left', // left, right, center, none.
	    'width'	=> '45',
	), $atts );

	if ( file_exists( get_stylesheet_directory() . 'icons' . $atts['image'] . '.png' ) ) {

	    $image_url = get_stylesheet_directory_uri() . 'icons' . $atts['image'] . '.png';

	} elseif ( version_compare( TB_FRAMEWORK_VERSION, '2.3.0', '<' ) ) {

	    $image_url = get_template_directory_uri() . '/framework/frontend/assets/images/shortcodes/icons/' . $atts['image'] . '.png';

	} else {

	    $image_url = get_template_directory_uri() . '/framework/assets/images/shortcodes/icons/' . $atts['image'] . '.png';

	}

	$align = 'none' !== $atts['align'] ? ' align' . $atts['align'] : null;

	return '<img src="' . $image_url . '" class="tb-image-icon ' . $atts['image'] . $align . '" width="' . $atts['width'] . '" />';

}

/**
 * Icon Link
 *
 * @since 1.0.0
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content The enclosed content.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_icon_link( $atts, $content = null ) {

	$atts = shortcode_atts( array(
	    'icon' 		=> '',      // Possible Values: alert, approved, camera, cart, doc, download, media, note, notice, quote, warning.
	    'color'     => '',      // Text color of icon - Ex: #666.
	    'link' 		=> '',
	    'target' 	=> '_self',
	    'class' 	=> '',
	    'title' 	=> '',
	), $atts );

	// Convert icons used with older framework versions to fontawesome
	// alert, approved, camera, cart, doc, download, media, note, notice, quote, warning
	// Note: "camera" and "download" work so can be excluded below.
	switch ( $atts['icon'] ) {

	    case 'alert' :
	    	$atts['icon'] = 'exclamation-sign';
	    	break;

	    case 'approved' :
			$atts['icon'] = 'check';
	    	break;

	    case 'cart' :
	    	$atts['icon'] = 'shopping-cart';
	    	break;

	    case 'doc' :
	    	$atts['icon'] = 'file';
	    	break;

	    case 'media' :
	    	$atts['icon'] = 'hdd'; // Kind of ironic... The CD icon gets replaced with the harddrive icon in the update for the "media" icon.
	    	break;

	    case 'note' :
	    	$atts['icon'] = 'pencil';
	    	break;

	    case 'notice' :
	    	$atts['icon'] = 'exclamation-sign'; // Was always the same as "alert".
	    	break;

	    case 'quote' :
	    	$atts['icon'] = 'comment';
	    	break;

	    case 'warning' :
	    	$atts['icon'] = 'warning-sign';

	}

	if ( ! $atts['title'] ) {

	    $atts['title'] = $content;

	}

	$style = '';

	if ( $atts['color'] ) {

	    $style = sprintf( 'color: %s', $atts['color'] );

	}

	$output  = sprintf( '<span class="tb-icon-link %s">', esc_attr( $atts['class'] ) );

	if ( function_exists( 'themeblvd_get_icon_class' ) ) { // Framework 2.7+

		$output .= sprintf(
			'<i class="icon %s" style="%s"></i>',
			esc_attr( themeblvd_get_icon_class( $atts['icon'], array( 'fa-fw' ) ) ),
			esc_attr( $style )
		);

	} elseif ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

	    $output .= sprintf(
			'<i class="icon fa fa-%s" style="%s"></i>',
			esc_attr( $atts['icon'] ),
			esc_attr( $style )
		);

	} else {

	    $output .= sprintf(
			'<i class="icon-%s" style="%s"></i>',
			esc_attr( $atts['icon'] ),
			esc_attr( $style )
		);

	}

	$output .= sprintf(
		'<a href="%s" title="%s" class="icon-link-%s" target="%s">%s</a>',
		esc_url( $atts['link'] ),
		esc_attr( $atts['title'] ),
		esc_attr( $atts['icon'] ),
		esc_attr( $atts['target'] ),
		$content
	);

	$output .= '</span>';

	return $output;

}

/**
 * Text Highlight
 *
 * @since 1.0.0
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content The enclosed content.
 * @return string Content to output for shortcode.
 */
function themeblvd_shortcode_highlight( $atts, $content = null ) {

	return '<span class="text-highlight">' . do_shortcode( $content ) . '</span><!-- .text-highlight (end) -->';

}

/**
 * Dropcaps
 *
 * @since 1.0.0
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content The enclosed content.
 * @return string Content to output for shortcode.
 */
function themeblvd_shortcode_dropcap( $atts, $content = null ) {

	return '<span class="dropcap">' . do_shortcode( $content ) . '</span><!-- .dropcap (end) -->';

}

/**
 * Labels (straight from Bootstrap)
 *
 * <span class="label label-success">Success</span>
 *
 * @since 1.0.0
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content The enclosed content.
 * @return string Content to output for shortcode.
 */
function themeblvd_shortcode_label( $atts, $content = null ) {

	$atts = shortcode_atts( array(
	    'style' => 'default', // Possible Values: default, success, warning, danger, info.
	    'icon'	=> '',
	), $atts );

	$class = 'label';

	// Convert styles from Bootstrap 1 & 2 to Bootstrap 3.
	if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

	    if ( 'important' === $atts['style'] ) {

	        $atts['style'] = 'danger';

	    }
	}

	if ( ! $atts['style'] ) {

	    $atts['style'] = 'default';

	}

	$class .= ' label-' . $atts['style'];

	if ( $atts['icon'] ) {

		if ( function_exists( 'themeblvd_get_icon_class' ) ) { // Framework 2.7+

			$content = '<i class="' . esc_attr( themeblvd_get_icon_class( $atts['icon'] ) ) . '"></i> ' . $content;

		} else if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

	        $content = '<i class="fa fa-' . esc_attr( $atts['icon'] ) . '"></i> ' . $content;

	    } else {

	        $content = '<i class="icon-' . esc_attr( $atts['icon'] ) . '"></i> ' . $content;

	    }
	}

	return sprintf(
		'<span class="%s">%s</span><!-- .label (end) -->',
		$class,
		do_shortcode( $content )
	);

}

/**
 * Vector Icon (from Bootstrap and Font Awesome)
 *
 * <i class="fa fa-{whatever}"></i>
 *
 * @since 1.0.0
 *
 * @param array $atts Shortcode attributes.
 * @return string Content to output for shortcode.
 */
function themeblvd_shortcode_vector_icon( $atts ) {

	$atts = shortcode_atts( array(
	    'icon'      => 'pencil',    // FontAwesome icon id.
	    'color'     => '',          // Text color of icon - Ex: #666.
	    'size'      => '',          // Font size for icon - Ex: 1.5em, 20px, etc.
	    'rotate'    => '',          // Optional rotation of the icon - 90, 180, 270.
	    'flip'      => '',          // Optional flip of the icon - horizontal, vertical.
	    'class'     => '',          // CSS class.
	), $atts );

	// Remove "fa-" if the user added it to the icon ID.
	$icon = str_replace( 'fa-', '', $atts['icon'] );

	$style = '';

	if ( $atts['size'] ) {

	    $style .= sprintf( 'font-size: %s;', $atts['size'] );

	}

	if ( $atts['color'] ) {

	    $style .= sprintf( 'color: %s;', $atts['color'] );

	}

	$class = sprintf( 'fa fa-%s', $icon ); // FontAwesome 4.

	if ( function_exists( 'themeblvd_get_icon_class' ) ) { // Framework 2.7+

		$class = themeblvd_get_icon_class( $icon ); // FontAwesome 5.

	} else if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '<' ) ) {

	    $class = sprintf( 'icon-%s', $icon ); // FontAwesome 1-3.

	}

	if ( $atts['rotate'] ) {

	    $class .= sprintf( ' fa-rotate-%s', $atts['rotate'] );

	}

	if ( $atts['flip'] ) {

	    $class .= sprintf( ' fa-flip-%s', $atts['flip'] );

	}

	if ( $atts['class'] ) {

	    $class .= sprintf( ' %s', $atts['class'] );

	}

	return sprintf( '<i class="%s" style="%s"></i>', $class, $style );

}

/**
 * Lead text (from Bootstrap)
 *
 * @since 1.5.0
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content The enclosed content.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_lead( $atts, $content = null ) {

	$atts = shortcode_atts( array(
		'size' => 0, // Optional font size, 20px, 1.5em, etc.
	), $atts );

	$output = '<p class="lead"';

	if ( $atts['size'] ) {

	    $output .= sprintf( ' style="font-size: %s"', $atts['size'] );

	}

	$output .= '>' . $content . '</p>';

	return $output;

}

/**
 * Tabs
 *
 * @since 1.0.0
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content The enclosed content.
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_tabs( $atts, $content = null ) {

	$default = array(
	    'style' 		=> 'framed', 		// Possible Values: framed, open.
	    'nav'			=> 'tabs',          // Possible Values: tabs, pills.
	    'height' 		=> '', 				// Fixed height for tabs - true or false.
	);
	extract( shortcode_atts( $default, $atts ) ); // Need to use extract() here.

	$output = '';

	// Since we use the $atts to loop through and
	// display the tabs, we need to remove the other
	// data, now that we've extracted it to other
	// variables.
	if ( isset( $atts['style'] ) ) {

	    unset( $atts['style'] );

	}

	if ( isset( $atts['nav'] ) ) {

	    unset( $atts['nav'] );

	}

	if ( isset( $atts['height'] ) ) {

	    unset( $atts['height'] );

	}

	if ( 'framed' !== $style && 'open' !== $style ) {

	    $style = 'framed';

	}

	// For those using old method for tabs.
	if ( in_array( $nav, array( 'tabs_above', 'tabs_above', 'tabs_right', 'tabs_left' ), true ) ) {

	    $nav = 'tabs';

	} elseif ( in_array( $nav, array( 'pills_above', 'pills_above' ), true ) ) {

	    $nav = 'pills';

	}

	if ( 'tabs' !== $nav && 'pills' !== $nav ) {

	    $nav = 'tabs';

	}

	if ( 'true' === $height ) {

	    $height = 1;

	} else {

	    $height = 0;

	}

	$id = uniqid( 'tabs_' . rand() );
	$num = count( $atts ) - 1;
	$i = 1;
	$tabs = array();
	$names = array();

	if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '>=' ) ) {

	    $options = array(
	        'nav'     => $nav,
			'style'   => $style,
			'height'  => $height,
	        'tabs'    => array(),
	    );

	} else {

	    $options = array(
	        'setup' => array(
	            'num'   => $num,
	            'style' => $style,
	            'nav'   => $nav,
	            'names' => array(),
	        ),
	        'height'  => $height,
	    );

	}

	if ( is_array( $atts ) && count( $atts ) > 0 ) {

	    foreach ( $atts as $key => $tab ) {

			$names[ 'tab_' . $i ] = $tab; // For theme framework prior to v2.5.

			$tab_content = explode( '[/' . $key . ']', $content );
	        $tab_content = explode( '[' . $key . ']', $tab_content[0] );

			$tabs[ 'tab_' . $i ] = array(
	            'title' => $tab,
	            'type'  => 'raw', // for theme framework prior to v2.5.
	            'raw'   => $tab_content[1], // For theme framework prior to v2.5.
	            'content' => array(
	                'type'			=> 'raw',
	                'raw' 			=> $tab_content[1],
	                'raw_format' 	=> 1,
	            ),
	        );

	        $i++;

	    }
	} else {

	    $output .= '<p class="tb-warning">' . __( 'No tabs found', 'theme-blvd-shortcodes' ) . '</p>';

	}

	if ( ! $output ) {

	    if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '>=' ) ) {

	         $options['tabs'] = $tabs;
	         $output .= themeblvd_get_tabs( $id, $options );

	    } else {

	        $options['setup']['names'] = $names;

	        foreach ( $tabs as $tab_id => $tab ) {

	            $options[ $tab_id ] = $tab;

	        }

	        $output .= '<div class="element element-tabs' . themeblvd_get_classes( 'element_tabs', true ) . '">';

	        $output .= themeblvd_tabs( $id, $options );

	        $output .= '</div><!-- .element (end) -->';

	    }
	}

	return $output;

}

/**
 * Accordion
 *
 * @since 1.0.0
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content The enclosed content.
 * @return string Content to output for shortcode.
 */
function themeblvd_shortcode_accordion( $atts, $content = null ) {

	$accordion_id = uniqid( 'accordion_' . rand() );

	if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

	    // Bootstrap 3.
	    return sprintf(
			'<div id="%s" class="tb-accordion panel-group">%s</div>',
			$accordion_id,
			do_shortcode( $content )
		);

	} else {

	    // Bootstrap 1-2.
	    return sprintf(
			'<div id="%s" class="tb-accordion">%s</div>',
			$accordion_id,
			do_shortcode( $content )
		);

	}

}

/**
 * Toggles
 *
 * @since 1.0.0
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content The enclosed content.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_toggle( $atts, $content = null ) {

	$atts = shortcode_atts( array(
	    'title' => '',
	    'open'  => 'false',
	), $atts );

	// Individual toggle ID (NOT the Accordion ID).
	$toggle_id = uniqid( 'toggle_' . rand() );

	if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '>=' ) ) { // Output handled in theme.

	    $output = themeblvd_get_toggle( array(
	        'title'     => $atts['title'],
	        'open'      => $atts['open'],
	        'content'   => $content,
	        'last'      => isset( $atts[0] ) ? true : false,
	    ));

	} elseif ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) { // Bootstrap 3.

	    // Last toggle?
	    $last = isset( $atts[0] ) ? $last = ' panel-last' : null;

	    // Is toggle open?
	    $class = 'panel-collapse collapse';
	    $icon = 'plus-circle';

	    if ( 'true' === $atts['open'] ) {

	        $class .= ' in';
	        $icon = 'minus-circle';

	    }

		/**
		 * Filter the Bootstrap color class used in
		 * displaying the toggle.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
	    $color = apply_filters( 'themeblvd_toggle_shortcode_color', 'default' );

	    $output = '
	        <div class="tb-panel panel panel-' . $color . $last . '">
	            <div class="panel-heading">
	                <a class="panel-title" data-toggle="collapse" data-parent="" href="#' . $toggle_id . '">
	                    <i class="fa fa-' . $icon . ' switch-me"></i> ' . $atts['title'] . '
	                </a>
	            </div><!-- .panel-heading (end) -->
	            <div id="' . $toggle_id . '" class="' . $class . '">
	                <div class="panel-body">
	                    ' . apply_filters( 'themeblvd_the_content', $content ) . '
	                </div><!-- .panel-body (end) -->
	            </div><!-- .panel-collapse (end) -->
	        </div><!-- .panel (end) -->';

	} else { // Bootstrap 1 & 2 output.

	    // Last toggle?
	    $last = isset( $atts[0] ) ? $last = ' accordion-group-last' : null;

	    // Is toggle open?
	    $class = 'accordion-body collapse';
	    $icon = 'sign';

	    if ( 'true' === $atts['open'] ) {

	        $class .= ' in';
	        $icon = 'minus-sign';

	    }

	    $output  = '<div class="accordion-group' . $last . '">';
		$output .= '<div class="accordion-heading">';
		$output .= '<a class="accordion-toggle" data-toggle="collapse" href="#' . $toggle_id . '"><i class="icon-' . $icon . ' switch-me"></i> ' . $atts['title'] . '</a>';
		$output .= '</div><!-- .accordion-heading (end) -->';
		$output .= '<div id="' . $toggle_id . '" class="' . $class . '">';
		$output .= '<div class="accordion-inner">';

		/**
		 * Standard filter in Theme Blvd Framework, where
		 * sanitization is applied.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		$output .= apply_filters( 'themeblvd_the_content', $content );

		$output .= '</div><!-- .accordion-inner (end) -->';
		$output .= '</div><!-- .accordion-body (end) -->';
		$output .= '</div><!-- .accordion-group (end) -->';

	}

	return $output;

}

/**
 * Post Slider
 *
 * @since 1.5.0
 *
 * @param array $atts Shortcode attributes.
 * @return string Content to output for shortcode.
 */
function themeblvd_shortcode_post_slider( $atts ) {

	$atts = shortcode_atts( array(
	    'style'             => '1',             // The display style - 1, 2, 3.
	    'interval'          => '0',             // Time between auto trasitions in seconds.
	    'nav_standard'      => 'true',          // Show standard nav - true, false.
	    'nav_arrows'        => 'true',          // Show nav arrows - true, false.
	    'nav_thumbs'        => 'false',         // Show nav thumbnails - true, false.
	    'pause'             => 'false',         // Pause on hover - true, false.
	    'crop'              => 'slider-large',  // Crop size for full-size images.
	    'slide_link'        => 'button',        // Where image link goes - none, image_post, image_link, button.
	    'button_text'       => 'View Post',     // Text for button (if button).
	    'button_size'       => 'default',       // Size of button (if button) - mini, small, default, large, x-large.
	    'tag'               => '',              // Tag(s) to include/exclude.
	    'category'          => '',              // Category slug(s) to include.
	    'cat'               => '',              // Category ID(s) to include/exclude.
	    'portfolio'         => '',              // Portfolio(s) slugs to include, requires Portfolios plugin.
	    'portfolio_tag'     => '',              // Portfolio Tag(s) to include, requires Portfolios plugin.
	    'numberposts'       => '5',             // Number of posts/slides.
	    'orderby'           => 'date',          // Orderby param for posts query.
	    'order'             => 'DESC',          // Order param for posts query.
	    'query'             => '',              // Custom query string.
	    'thumb_link'        => 'true',          // Whether linked images have animation.
	    'dark_text'         => 'false',         // Whether to use dark text.
	    'title'             => 'true',          // Whether to show titles.
	    'meta'              => 'true',          // Whether to shoe meta.
	    'excerpts'          => 'false',         // Whether to show excerpts.
	), $atts );

	if ( intval( $atts['style'] ) ) {

	    $atts['style'] = 'style-' . $atts['style'];

	}

	// Provide compat with some older options.
	if ( ! empty( $atts['timeout'] ) ) {

	    $atts['interval'] = $atts['timeout'];

	}

	if ( ! empty( $atts['pause_on_hover'] ) ) {

	    if ( 'pause_on' === $atts['pause_on_hover'] || 'pause_on_off' === $atts['pause_on_hover'] ) {

	        $atts['pause'] = 'true';
	    }
	}

	if ( ! empty( $atts['image_size'] ) ) {

	    $atts['crop'] = $atts['image_size'];

	}

	if ( ! empty( $atts['button'] ) ) {

	    $atts['button_text'] = $atts['button'];

	}

	// Convert booleans.
	foreach ( $atts as $key => $value ) {

	    if ( 'true' === $value ) {

	        $atts[ $key ] = true;

	    } elseif ( 'false' === $value ) {

	        $atts[ $key ] = false;

	    }
	}

	if ( $atts['category'] ) {

	    $atts['category_name'] = $atts['category'];

	}

	$atts['posts_per_page'] = $atts['numberposts'];

	return themeblvd_get_post_slider( $atts );

}

/**
 * Post Grid Slider
 *
 * @since 1.0.0
 *
 * @param array $atts Shortcode attributes.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_post_grid_slider( $atts ) {

	$atts = shortcode_atts( array(
	    // query params
	    'cat'           => '',          // cat: Category ID(s) to include/exclude.
	    'category_name' => '',          // category_name: Category slug(s) to include/exclude.
	    'tag'           => '',          // tag: Tag(s) to include/exclude.
	    'portfolio'     => '',          // portfolio: Portfolio(s) slugs to include, requires Portfolios plugin.
	    'portfolio_tag' => '',          // portfolio_tag: Portfolio Tag(s) to include, requires Portfolios plugin.
	    'columns' 		=> '3',			// columns: Number of posts per row.
	    'orderby' 		=> 'date',		// orderby: date, title, comment_count, rand.
	    'order' 		=> 'DESC',		// order: DESC, ASC.
	    'offset' 		=> 0,			// offset: Number of posts to offset off the start, defaults to 0.
	    'query'         => '',          // query: custom query string.

	    // slider stuff
	    'slides'        => '3',         // slides: number of slides.
	    'timeout'       => 0,           // timeout: Seconds in between transitions, 0 for no auto-advancing.
	    'nav'           => 'true',      // Whether to show nav.

	    // post grid display
	    'thumbs'        => '',          // thumbs: show, hide.
	    'meta'          => '',          // meta: show, hide.
	    'excerpt'       => '',          // excerpt: show, hide.
	    'more'          => '',          // more: hide, text, button.
	    'crop'			=> 'tb_grid',	// crop: Can manually enter a featured image crop size.

	    // @deprecated
	    'fx'            => 'slide',     // fx: Transition of slider - fade, slide.
	    'nav_standard'  => 1,           // nav_standard: Show standard nav dots to control slider - true or false.
	    'nav_arrows'    => 1,           // nav_arrows: Show directional arrows to control slider - true or false.
	    'pause_play'    => 1,           // pause_play: Show pause/play button - true or false.
	    'categories'    => '',          // @deprecated -- Category slug(s) to include/exclude.
	    'rows'          => 3,           // rows: Number of rows per slide.
	    'numberposts'   => '12',        // numberposts: Total number of posts, -1 for all posts.
	), $atts );

	$id = uniqid( 'grid_' . rand() );

	// Extra attributes for post grid slider display.
	$atts['display'] = 'slider';
	$atts['context'] = 'grid';
	$atts['shortcode'] = true;

	if ( 'true' === $atts['nav'] ) {

	    $atts['nav'] = 1;

	} else {

	    $atts['nav'] = 0;

	}

	if ( function_exists( 'themeblvd_loop' ) ) {

	    ob_start();
	    themeblvd_loop( $atts );
	    $output = ob_get_clean();

	} else {

	    if ( 'true' === $atts['nav_standard'] ) {

	        $atts['nav_standard'] = 1;

	    } elseif ( 'false' === $atts['nav_standard'] ) {

	        $atts['nav_standard'] = 0;

	    }

	    if ( 'true' === $atts['nav_arrows'] ) {

	        $atts['nav_arrows'] = 1;

	    } elseif ( 'false' === $atts['nav_arrows'] ) {

	        $atts['nav_arrows'] = 0;

	    }

	    if ( 'true' === $atts['pause_play'] ) {

		    $atts['pause_play'] = 1;

		} elseif ( 'false' === $atts['pause_play'] ) {

		    $atts['pause_play'] = 0;

		}

		ob_start();

		echo '<div class="element element-post_grid_slider' . esc_attr( themeblvd_get_classes( 'element_post_grid_slider', true ) ) . '">';
		echo '<div class="element-inner">';
		echo '<div class="element-inner-wrap">';
		echo '<div class="grid-protection">';

		themeblvd_post_slider( $id, $atts, 'grid', 'primary' );

		echo '</div><!-- .grid-protection (end) -->';
		echo '</div><!-- .element-inner-wrap (end) -->';
		echo '</div><!-- .element-inner (end) -->';
		echo '</div><!-- .element (end) -->';

		$output = ob_get_clean();

	}

	return $output;

}

/**
 * Post List Slider
 *
 * @since 1.0.0
 *
 * @param array $atts Shortcode attributes.
 * @return string $output Content to output for shortcode.
 */
function themeblvd_shortcode_post_list_slider( $atts ) {

	if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '>=' ) ) {

		return sprintf(
			'<div class="alert">%s</div>',
			__( 'The [<span>post_list_slider</span>] shortcode is no longer supported in your theme. Use [<span>post_slider</span>] or [<span>post_grid_slider</span>] instead.', 'theme-blvd-shortcodes' )
		);

	}

	$atts = shortcode_atts( array(
	    'fx' 				=> 'slide', 	// fx: Transition of slider - fade, slide.
	    'timeout' 			=> 0, 			// timeout: Seconds in between transitions, 0 for no auto-advancing.
	    'nav_standard' 		=> 1, 			// nav_standard: Show standard nav dots to control slider - true or false.
	    'nav_arrows' 		=> 1, 			// nav_arrows: Show directional arrows to control slider - true or false.
	    'pause_play' 		=> 1, 			// pause_play: Show pause/play button - true or false.
	    'categories'        => '',          // @deprecated -- Category slug(s) to include/exclude.
	    'cat'               => '',          // cat: Category ID(s) to include/exclude.
	    'category_name'     => '',          // category_name: Category slug(s) to include/exclude.
	    'tag'               => '',          // tag: Tag(s) to include/exclude.
	    'portfolio'         => '',          // portfolio: Portfolio(s) slugs to include, requires Portfolios plugin.
	    'portfolio_tag'     => '',          // portfolio_tag: Portfolio Tag(s) to include, requires Portfolios plugin.
	    'thumbs' 			=> 'default',	// thumbs: Size of post thumbnails - default, small, full, hide.
	    'post_content' 		=> 'default',	// content: Show excerpts or full content - default, content, excerpt.
	    'posts_per_slide'   => 3,			// posts_per_slide: Number of posts per slide.
	    'numberposts' 		=> 10,			// numberposts: Total number of posts, -1 for all posts.
	    'orderby' 			=> 'date',		// orderby: date, title, comment_count, rand.
	    'order' 			=> 'DESC',		// order: DESC, ASC.
	    'offset' 			=> 0,			// offset: Number of posts to offset off the start, defaults to 0.
	    'query'             => '',          // query: custom query string.
	), $atts );

	$id = uniqid( 'list_' . rand() );

	$options = array(
	    'fx' 				=> $atts['fx'],
	    'timeout' 			=> $atts['timeout'],
	    'thumbs' 			=> $atts['thumbs'],
	    'content' 			=> $atts['post_content'],
	    'posts_per_slide' 	=> $atts['posts_per_slide'],
	    'numberposts' 		=> $atts['numberposts'],
	    'orderby' 			=> $atts['orderby'],
	    'order' 			=> $atts['order'],
	    'offset' 			=> $atts['offset'],
	    'query'             => $atts['query'],
	);

	if ( 'true' === $atts['nav_standard'] ) {

		$options['nav_standard'] = 1;

	} elseif ( 'false' === $atts['nav_standard'] ) {

		$options['nav_standard'] = 0;

	} else {

		$options['nav_standard'] = $atts['nav_standard'];
	}

	if ( 'true' === $atts['nav_arrows'] ) {

		$options['nav_arrows'] = 1;

	} elseif ( 'false' === $atts['nav_arrows'] ) {

		$options['nav_arrows'] = 0;

	} else {

		$options['nav_arrows'] = $atts['nav_arrows'];

	}

	if ( 'true' === $atts['pause_play'] ) {

		$options['pause_play'] = 1;

	} elseif ( 'false' === $atts['pause_play'] ) {

		$options['pause_play'] = 0;

	} else {

		$options['pause_play'] = $atts['pause_play'];

	}

	if ( $atts['cat'] ) {

	    $options['cat'] = $atts['cat'];

	} elseif ( $atts['category_name'] ) {

	    $options['category_name'] = $atts['category_name'];

	} elseif ( $atts['categories'] ) { // @deprecated

	    $options['category_name'] = $atts['categories'];

	}

	if ( $atts['tag'] ) {

	    $options['tag'] = $atts['tag'];

	}

	if ( $atts['portfolio'] ) {

	    $options['portfolio'] = $atts['portfolio'];

	}

	if ( $atts['portfolio_tag'] ) {

	    $options['portfolio_tag'] = $atts['portfolio_tag'];

	}

	ob_start();

	echo '<div class="element element-post_list_slider' . esc_attr( themeblvd_get_classes( 'element_post_list_slider', true ) ) . '">';
	echo '<div class="element-inner">';
	echo '<div class="element-inner-wrap">';
	echo '<div class="grid-protection">';

	themeblvd_post_slider( $id, $options, 'list', 'primary' );

	echo '</div><!-- .grid-protection (end) -->';
	echo '</div><!-- .element-inner-wrap (end) -->';
	echo '</div><!-- .element-inner (end) -->';
	echo '</div><!-- .element (end) -->';

	return ob_get_clean();

}

/**
 * Gallery Slider
 *
 * @since 1.3.0
 *
 * @param array $atts Shortcode attributes.
 * @return string Content to output for shortcode.
 */
function themeblvd_shortcode_gallery_slider( $atts ) {

	// This shortcode requires Theme Blvd Framework 2.4.2+.
	if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.2', '<' ) ) {

		return sprintf(
			'<div class="alert">%s</div>',
			__( 'Your theme does not support the [gallery_slider] shortcode. You must be using a theme with Theme Blvd Framework 2.4.2+', 'theme-blvd-shortcodes' )
		);

	}

	$atts = shortcode_atts( array(
	    'ids'           => '',                  // Comma separated attachments ID's.
		'carousel'		=> '',					// Whether to use variable width owl carousel or not.
	    'title'         => 'false',             // Whether to show titles.
	    'caption'       => 'false',             // Whether to show captions.
	    'size'          => '',      			// Crop size for images.
	    'interval'      => '5000',              // Milliseconds between transitions.
	    'pause'         => 'true',              // Whether to pause on hover.
	    'wrap'          => 'true',              // Whether sliders continues auto rotate after first pass.
	    'nav_standard'  => 'false',             // Whether to show standard nav indicator dots.
	    'nav_arrows'    => 'true',              // Whether to show standard nav arrows.
	    'nav_thumbs'    => 'true',              // Whether to show nav thumbnails (added by Theme Blvd framework).
	    'thumb_size'    => 'smallest',          // Size of nav thumbnail images - small, smaller, smallest or custom integer.
	    'dark_text'     => 'false',             // Whether to use dark text for title/descriptions/standard nav, use when images are light.
	    'frame'         => 'false',             // Whether to wrap gallery slider in frame.
	), $atts );

	$gallery = sprintf( '[gallery ids="%s"]', $atts['ids'] );

	unset( $atts['ids'] );

	// Backup for those using old square_* crop sizes.
	if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '>=' ) ) {

	    $atts['thumb_size'] = str_replace( 'square_', '', $atts['thumb_size'] );

	}

	// Are we using variable-with owl carousel?
	if ( empty( $atts['carousel'] ) ) {

		if ( themeblvd_get_option( 'gallery_carousel' ) ) {

			$atts['carousel'] = 'true';

		} else {

			$atts['carousel'] = 'false';

		}
	}

	foreach ( $atts as $key => $val ) {

	    if ( 'true' === $val ) {

		    $atts[ $key ] = true;

		} elseif ( 'false' === $val ) {

		    $atts[ $key ] = false;

		}
	}

	return themeblvd_get_gallery_slider( $gallery, $atts );

}

/**
 * Post Grid and Post Showcase
 *
 * @since 1.0.0
 *
 * @param array  $atts Shortcode attributes..
 * @param string $content The enclosed content.
 * @param string $tag Current shortcode tag.
 * @return string Content to output for shortcode.
 */
function themeblvd_shortcode_post_grid( $atts, $content = null, $tag = '' ) {

	$atts = shortcode_atts( array(

	    // The following are shared between both [post_grid] and [post_shwocase].
	    'categories'    => '',                  // @deprecated -- Category slug(s) to include/exclude.
	    'cat'           => '',                  // cat: Category ID(s) to include/exclude.
	    'category_name' => '',                  // category_name: Category slug(s) to include/exclude.
	    'tag'           => '',                  // tag: Tag(s) to include/exclude.
	    'portfolio'     => '',                  // portfolio: Portfolio(s) slugs to include, requires Portfolios plugin.
	    'portfolio_tag' => '',                  // portfolio_tag: Portfolio Tag(s) to include, requires Portfolios plugin.
	    'columns' 		=> '3',					// columns: Number of posts per row.
	    'rows' 			=> '3',					// rows: Number of rows per slide.
	    'orderby' 		=> 'date',				// orderby: date, title, comment_count, rand.
	    'order' 		=> 'DESC',				// order: DESC, ASC.
	    'offset' 		=> '0',					// offset: Number of posts to offset off the start, defaults to 0.
	    'query' 		=> '',					// query: custom query string.
	    'filter'        => 'false',             // filter: Whether to use filtering - false or taxonomy name to filter by.
	    'filter_max'    => '-1',                // filter_max: Maximum posts to pull when using filtering.
	    'masonry'       => 'false',             // masonry: Whether to use masonry or not.
	    'masonry_max'   => '12',                // masonry_max: Number of posts if using masonry.
	    'excerpt'       => '',                  // excerpt: show, hide.
	    'crop'          => '',                  // crop: Can manually enter a featured image crop size.

	    // [post_grid] only.
	    'thumbs'        => '',                  // thumbs: show, hide.
	    'meta'          => '',                  // meta: show, hide.
	    'more'          => '',                  // more: hide, text, button.
	    'more_text'     => '',                  // more_text: Text for more button (not in generator).

	    // [post_showcase] only.
	    'titles'        => '',                  // titles: Whether to show post titles when items are hovered on.
	    'gutters'       => '',                 	// gutters: Whether to have spacing between posts.

	), $atts );

	foreach ( $atts as $key => $val ) {

	    if ( 'true' === $val ) {

	        $atts[ $key ] = true;

	    } elseif ( 'false' === $val ) {

	        $atts[ $key ] = false;

	    }
	}

	if ( 'post_showcase' === $tag ) {

	    $display = $context = 'showcase';

	} else {

	    $display = $context = 'grid';

	}

	if ( $atts['filter'] ) {

	    if ( $atts['masonry'] ) {

	        $display = 'masonry_filter';

	    } else {

	        $display = 'filter';

	    }

	    if ( ! $atts['filter_max'] ) {

	        $atts['filter_max'] = '-1'; // Just to be safe.

	    }
	} elseif ( $atts['masonry'] ) {

	    $display = 'masonry';

	}

	if ( 'tag' === $atts['filter'] ) { // Simply allows user to input "tag" instead of "post_tag" for taxonomy.

	    $atts['filter'] = 'post_tag';

	}

	$options = array(
	    'display'       	=> $display,
	    'columns' 			=> $atts['columns'],
	    'rows' 				=> $atts['rows'],
	    'tag'           	=> $atts['tag'],
	    'portfolio'     	=> $atts['portfolio'],
	    'portfolio_tag' 	=> $atts['portfolio_tag'],
	    'orderby' 			=> $atts['orderby'],
	    'order' 			=> $atts['order'],
	    'offset' 			=> $atts['offset'],
	    'crop' 				=> $atts['crop'],
	    'query' 			=> $atts['query'],
	    'filter'        	=> $atts['filter'],
	    'filter_max'    	=> $atts['filter_max'],
	    'posts_per_page'	=> $atts['masonry_max'],
	    'thumbs'        	=> $atts['thumbs'],
	    'meta'          	=> $atts['meta'],
	    'excerpt'       	=> $atts['excerpt'],
	    'titles'        	=> $atts['titles'],
	    'more'          	=> $atts['more'],
	    'more_text'     	=> $atts['more_text'],
	    'context'       	=> $context,
	    'shortcode'     	=> true,
	    'class'         	=> "shortcode-{$context}-wrap",
	);

	if ( $atts['cat'] ) {

	    $options['cat'] = $atts['cat'] ;

	} elseif ( $atts['category_name'] ) {

	    $options['category_name'] = $atts['category_name'] ;

	} elseif ( $atts['categories'] ) {

	    $options['category_name'] = $atts['categories']; // @deprecated

	}

	if ( 'show' === $options['thumbs'] ) {

	    $options['thumbs'] = 'full';

	}

	if ( function_exists( 'themeblvd_loop' ) ) {

	    ob_start();
	    themeblvd_loop( $options );
	    $output = ob_get_clean();

	} else {

		ob_start();
		echo '<div class="element element-post_grid' . esc_attr( themeblvd_get_classes( 'element_post_grid', true ) ) . '">';
		echo '<div class="element-inner">';
		echo '<div class="element-inner-wrap">';
		echo '<div class="grid-protection">';

		themeblvd_posts( $options, 'grid', 'primary' );

		echo '</div><!-- .grid-protection (end) -->';
		echo '</div><!-- .element-inner-wrap (end) -->';
		echo '</div><!-- .element-inner (end) -->';
		echo '</div><!-- .element (end) -->';

		$output = ob_get_clean();

	}

	return $output;

}

/**
 * Post List and Blog
 *
 * @since 1.0.0
 *
 * @param array  $atts Shortcode attributes..
 * @param string $content The enclosed content.
 * @param string $tag Current shortcode tag.
 * @return string Content to output for shortcode.
 */
function themeblvd_shortcode_post_list( $atts, $content = '', $tag = '' ) {

	$atts = shortcode_atts( array(
	    'categories' 	=> '',					// @deprecated -- Category slug(s) to include/exclude.
		'cat'           => '',                  // cat: Category ID(s) to include/exclude.
	    'category_name' => '',                  // category_name: Category slug(s) to include/exclude.
	    'tag'           => '',                  // tag: Tag(s) to include/exclude.
	    'portfolio'     => '',                  // portfolio: Portfolio(s) slugs to include, requires Portfolios plugin.
	    'portfolio_tag' => '',                  // portfolio_tag: Portfolio Tag(s) to include, requires Portfolios plugin.
		'numberposts' 	=> '3',					// numberposts: Total number of posts, -1 for all posts.
	    'orderby' 		=> 'date',				// orderby: date, title, comment_count, rand.
	    'order' 		=> 'DESC',				// order: DESC, ASC.
	    'offset' 		=> '0',					// offset: Number of posts to offset off the start, defaults to 0.
	    'query' 		=> '', 					// custom query string.
	    'filter'        => 'false',             // filter: Whether to use filtering - false or taxonomy name to filter by.
	    'thumbs'        => '',                  // thumbs: show, hide, or date.
	    'meta'          => '',                  // meta: show, hide.
	    'more'          => '',                  // more: hide, text, button.
	    'more_text'     => '',                  // more_text: Text for more button (not in generator).
	), $atts );

	if ( 'blog' === $tag ) {

	    $display = $context = 'blog';

	} else {

	    $display = $context = 'list';

	}

	foreach ( $atts as $key => $val ) {

	    if ( 'true' === $val ) {

	        $atts[ $key ] = true;

	    } elseif (  'false' === $val ) {

	        $atts[ $key ] = false;

	    }
	}

	if ( 'tag' === $atts['filter'] ) {

	    $atts['filter'] = 'post_tag'; // Simply allows user to input "tag" instead of "post_tag" for taxonomy.

	}

	$options = array(
	    'display'       	=> $display,
	    'thumbs' 			=> $atts['thumbs'],
	    'content' 			=> 'excerpt',
	    'tag'           	=> $atts['tag'],
	    'portfolio'     	=> $atts['portfolio'],
	    'portfolio_tag' 	=> $atts['portfolio_tag'],
	    'posts_per_page'	=> $atts['numberposts'],
	    'numberposts'   	=> $atts['numberposts'], // @deprecated
	    'orderby' 			=> $atts['orderby'],
	    'order' 			=> $atts['order'],
	    'offset' 			=> $atts['offset'],
	    'query' 			=> $atts['query'],
	    'filter'        	=> $atts['filter'],
	    'thumbs'        	=> $atts['thumbs'],
	    'meta'          	=> $atts['meta'],
	    'more'          	=> $atts['more'],
	    'more_text'     	=> $atts['more_text'],
	    'context'       	=> $context,
	    'shortcode'     	=> true,
	    'class'         	=> "shortcode-{$context}-wrap",
	);

	if ( $atts['cat'] ) {

	    $options['cat'] = $atts['cat'] ;

	} elseif ( $atts['category_name'] ) {

	    $options['category_name'] = $atts['category_name'] ;

	} elseif ( $atts['categories'] ) {

	    $options['category_name'] = $atts['categories']; // @deprecated

	}

	if ( 'show' === $options['thumbs'] ) {

	    $options['thumbs'] = 'full';

	}

	if ( function_exists( 'themeblvd_loop' ) ) {

	    ob_start();
	    themeblvd_loop( $options );
	    $output = ob_get_clean();

	} else { // @deprecated

		ob_start();

		echo '<div class="element element-post_list' . esc_attr( themeblvd_get_classes( 'element_post_list', true ) ) . '">';
		echo '<div class="element-inner">';
		echo '<div class="element-inner-wrap">';
		echo '<div class="grid-protection">';

		themeblvd_posts( $options, 'list', 'primary' );

		echo '</div><!-- .grid-protection (end) -->';
		echo '</div><!-- .element-inner-wrap (end) -->';
		echo '</div><!-- .element-inner (end) -->';
		echo '</div><!-- .element (end) -->';

		$output = ob_get_clean();

	}

	return $output;

}

/**
 * Mini Post Grid
 *
 * @since 1.0.0
 *
 * @param array $atts Shortcode attributes.
 * @return string Content to output for shortcode
 */
function themeblvd_shortcode_mini_post_grid( $atts ) {

	$atts = shortcode_atts( array(
	    'categories'    => '',          // @deprecated -- Category slug(s) to include/exclude.
	    'cat'           => '',          // cat: Category ID(s) to include/exclude.
	    'category_name' => '',          // category_name: Category slug(s) to include/exclude.
	    'tag'           => '',          // tag: Tag(s) to include/exclude.
	    'numberposts'   => 4,           // numberposts: Total number of posts, -1 for all posts.
	    'orderby'       => 'date',      // orderby: date, title, comment_count, rand.
	    'order'         => 'DESC',      // order: DESC, ASC.
	    'offset'        => 0,           // offset: Number of posts to offset off the start, defaults to 0.
	    'query'         => '',          // custom query string.
	    'thumb'         => 'smaller',   // thumbnail size - small, smaller, or smallest.
	    'align'         => 'left',      // alignment of grid - left, right, or center.
	    'gallery'       => '',          // A comma separated list of attachmentn IDs - 1,2,3,4.
	), $atts );

	if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) {

	    if ( ! $atts['query'] ) {

	        $query = '';

	        // Categories
	        if ( $atts['categories'] ) { // @deprecated.

	            $query .= 'category_name=' . $atts['categories'] . '&';

	        }

	        if ( $atts['cat'] ) {

	            $query .= 'cat=' . $atts['cat'] . '&';

	        }

	        if ( $atts['category_name'] ) {

	            $query  .= 'category_name=' . $atts['category_name'] . '&';

			}

	        if ( $atts['tag'] ) {

	            $query .= 'tag=' . $atts['tag'] . '&';

	        }

	        $query .= 'numberposts=' . $atts['numberposts'] . '&';
	        $query .= 'orderby=' . $atts['orderby'] . '&';
	        $query .= 'order=' . $atts['order'] . '&';
	        $query .= 'offset=' . $atts['offset'] . '&';
	        $query .= 'suppress_filters=false'; // Mainly for WPML compat.

	    } else {

	        $query = $atts['query'];

	    }
	}

	if ( $atts['gallery'] ) {
	    $atts['gallery'] = sprintf( '[gallery ids="%s" link="file"]', $atts['gallery'] );
	}

	$atts['posts_per_page'] = $atts['numberposts'];

	$atts['shortcode'] = true;

	if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) { // @deprecated.

	    return themeblvd_get_mini_post_grid( $query, $atts['align'], $atts['thumb'], $atts['gallery'] );

	} else {

	    return themeblvd_get_mini_post_grid( $atts, $atts['align'], $atts['thumb'], $atts['gallery'] );

	}

}

/**
 * Mini Post List
 *
 * @since 1.0.0
 *
 * @param array $atts Shortcode attributes.
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_mini_post_list( $atts ) {

	$atts = shortcode_atts( array(
	    'categories'    => '',          // @deprecated -- Category slug(s) to include/exclude
	    'cat'           => '',          // cat: Category ID(s) to include/exclude
	    'category_name' => '',          // category_name: Category slug(s) to include/exclude
	    'tag'           => '',          // tag: Tag(s) to include/exclude
	    'numberposts'   => 4,           // numberposts: Total number of posts, -1 for all posts
	    'orderby'       => 'date',      // orderby: date, title, comment_count, rand
	    'order'         => 'DESC',      // order: DESC, ASC
	    'offset'        => 0,           // offset: Number of posts to offset off the start, defaults to 0
	    'query'         => '',          // custom query string
	    'thumb'         => 'smaller',   // thumbnail size - small, smaller, smallest, date, or hide
	    'meta'          => 'show',      // show meta or not - show or hide
	    'columns'       => '0',          // Optional number of columns to spread posts among
	), $atts );

	if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) {

	    if ( ! $atts['query'] ) {

	        if ( $atts['categories'] ) { // @deprecated.

	            $query .= 'category_name=' . $atts['categories'] . '&';

			}

	        if ( $atts['cat'] ) {

			    $query .= 'cat=' . $atts['cat'] . '&';

			}

	        if ( $atts['category_name'] ) {

			    $query .= 'category_name=' . $atts['category_name'] . '&';

			}

	        if ( $atts['tag'] ) {

			    $query .= 'tag=' . $atts['tag'] . '&';

			}

	        $query .= 'numberposts=' . $atts['numberposts'] . '&';
	        $query .= 'orderby=' . $atts['orderby'] . '&';
	        $query .= 'order=' . $atts['order'] . '&';
	        $query .= 'offset=' . $atts['offset'] . '&';
	        $query .= 'suppress_filters=false'; // Mainly for WPML compat.

	    } else {

	        $query = $atts['query'];

	    }
	}

	$thumb = $atts['thumb'];

	if ( ! $thumb || 'hide' === $thumb ) {

	    $thumb = false;

	}

	if ( $thumb ) {

	    $check = array( 'small', 'smaller', 'smallest' );

	    if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '>=' ) ) {

	        $check[] = 'date';

	    }

	    if ( ! in_array( $thumb, $check, true ) ) {

	        $thumb = 'smaller';

		}
	}

	$meta = false;

	if ( 'show' === $atts['meta'] ) {

	    $meta = true;

	}

	$atts['posts_per_page'] = $atts['numberposts'];

	$atts['shortcode'] = true;

	if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) { // @deprecated.

	    if ( ! $thumb ) { // A crazy asinine hack for older themes.

	        add_filter( 'themeblvd_mini_post_list_thumb_size', 'themeblvd_shortcode_mini_post_list_hack' );

	    }

	    $output = themeblvd_get_mini_post_list( $query, $thumb, $meta );

	    if ( ! $thumb ) { // Finish the crazy, asinine hack for older themes.

	        remove_filter( 'themeblvd_mini_post_list_thumb_size', 'themeblvd_shortcode_mini_post_list_hack' );

	    }
	} else {

	    $output = themeblvd_get_mini_post_list( $atts, $thumb, $meta );

	}

	return $output;

}

/**
 * When we want to hide the thumbnails, temporarily filter
 * in a thumbnail size, just to avoid PHP warning in
 * older themes. Yeah, it's weird and makes no sense...
 *
 * @since 1.5.4
 */
function themeblvd_shortcode_mini_post_list_hack() {

	return 'tb_small';

}

/**
 * Milestone
 *
 * @since 1.5.0
 *
 * @param array $atts Shortcode attributes.
 * @return string Content to output for shortcode
 */
function themeblvd_shortcode_milestone( $atts ) {

	if ( ! function_exists( 'themeblvd_get_milestone' ) ) {

		return sprintf(
			'<div class="alert">%s</div>',
			__( 'Your theme does not support the [milestone] shortcode.', 'theme-blvd-shortcodes' )
		);

	}

	$atts = shortcode_atts( array(
	    'milestone'     => '100',       // The number for the milestone.
	    'color'         => '#0c9df0',   // Color of text for milestone number.
	    'text'          => '',          // Brief text to describe milestone.
	    'boxed'         => 'false',     // Whether to wrap milestone in borered box.
	), $atts );

	if ( 'true' === $atts['boxed'] ) {

	    $atts['boxed'] = '1';

	} else {

	    $atts['boxed'] = '0';

	}

	return themeblvd_get_milestone( $atts );

}

/**
 * Milestone Ring
 *
 * @since 1.5.0
 *
 * @param array $atts Shortcode attributes.
 * @return string Content to output for shortcode
 */
function themeblvd_shortcode_milestone_ring( $atts ) {

	if ( ! function_exists( 'themeblvd_get_milestone_ring' ) ) {

		return sprintf(
			'<div class="alert">%s</div>',
			__( 'Your theme does not support the [milestone_ring] shortcode.', 'theme-blvd-shortcodes' )
		);

	}

	$atts = shortcode_atts( array(
	    'percent'       => '75',        // Percentage for pie chart.
	    'color'         => '#0c9df0',   // Color of the milestone percentage.
	    'track_color'   => '#eeeeee',   // Color track containing milestone ring (currently no option in builder, may add in the future).
	    'display'       => '',          // Text in the middle of the pie chart.
	    'title'         => '',          // Title below pie chart.
	    'text'          => '',          // Description below title.
	    'text_align'    => 'center',    // Text alignment - left, right, or center.
	    'boxed'         => 'false',     // Whether to wrap milestone in borered box.
	), $atts );

	if ( 'true' === $atts['boxed'] ) {

	    $atts['boxed'] = '1';

	} else {

	    $atts['boxed'] = '0';

	}

	return themeblvd_get_milestone_ring( $atts );

}

/**
 * Progress Bar (from Bootstrap)
 *
 * @since 1.0.0
 *
 * @param array $atts Shortcode attributes.
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_progress_bar( $atts ) {

	$atts = shortcode_atts( array(
	    'color'         => '',          // Possible Values: default, danger, success, info, warning, or custom hex.
	    'percent'       => '100',       // Percent of bar - 30, 60, 80, etc.
	    'striped'       => 'false',     // Possible Values: true, false.
	    'label'         => '',          // Label of what this bar represents, like "Graphic Design".
	), $atts );

	/**
	 * Bootstrap 3 and Theme Blvd framework 2.5+.
	 */
	if ( function_exists( 'themeblvd_get_progress_bar' ) ) {

	    $atts['value'] = $atts['percent'];

		unset( $atts['percent'] );

	    $atts['label_value'] = $atts['value'] . '%';

		unset( $atts['striped'] ); // Removed from framework in 2.7.0.

	    return themeblvd_get_progress_bar( $atts );

	}

	/**
	 * All of the following is the deprecated fallback
	 * when using a theme prior to framework 2.5 and the
	 * themeblvd_get_progress_bar() function doesn't exist.
	 */

	$wrap_class = '';

	// Wrap classes for Bootstrap 3+.
	if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

	    $wrap_class = 'progress';

	}

	$class = '';

	if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

	    $class = 'progress-bar'; // For Bootstrap 3+.

	} else {

	    $class = 'progress'; // For Bootstrap 1-2.

	}

	if ( $atts['color'] ) {

	    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

	        $class .= ' progress-bar-' . $atts['color']; // For Bootstrap 3+.

	    } else {

	        $class .= ' progress-' . $atts['color']; // For Bootstrap 1 & 2.

	    }
	}

	if ( 'true' === $atts['striped'] ) {

	    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

	        $wrap_class .= ' progress-striped'; // For Bootstrap 3+.

	    } else {

	        $class .= ' progress-striped'; // For Bootstrap 1 & 2.

	    }
	}

	if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

	    // Bootstrap 3+.
	    $output  = '<div class="' . $wrap_class . '">';
	    $output .= '    <div class="' . $class . '" role="progressbar" aria-valuenow="' . $atts['percent'] . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $atts['percent'] . '%;">';
	    $output .= '        <span class="sr-only">' . $atts['percent'] . '%</span>';
	    $output .= '    </div>';
	    $output .= '</div>';

	} else {

	    // Bootstrap 1 & 2 (@deprecated).
	    $output  = '<div class="' . $classes . '">';
	    $output .= '    <div class="bar" style="width: ' . $atts['percent'] . '%;"></div>';
	    $output .= '</div>';

	}

	return $output;

}
