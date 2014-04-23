<?php
/**
 * Theme Blvd Shortcodes
 *
 * (1) Columns
 *		- one_sixth 		=> @since 1.0.0
 *		- one_fourth		=> @since 1.0.0
 *		- one_third			=> @since 1.0.0
 *		- one_half			=> @since 1.0.0
 *		- two_third			=> @since 1.0.0
 *		- three_fourth 		=> @since 1.0.0
 *		- one_fifth			=> @since 1.0.0
 *		- two_fifth			=> @since 1.0.0
 *		- three_fifth		=> @since 1.0.0
 *		- four_fifth		=> @since 1.0.0
 *		- three_tenth		=> @since 1.0.0
 *		- seven_tenth		=> @since 1.0.0
 * (2) Components
 *		- button 			=> @since 1.0.0
 *		- box				=> @since 1.0.0 @deprecated
 *		- alert				=> @since 1.0.0
 *		- icon_list			=> @since 1.0.0
 *		- divider			=> @since 1.0.0
 * 		- progess_bar		=> @since 1.0.0
 *		- popup				=> @since 1.0.0
 *      - lightbox          => @since 1.1.0
 *      - lightbox_gallery  => @since 1.1.0
 *      - blockquote        => @since 1.2.0
 *      - jumbotron         => @since 1.3.0
 *      - panel             => @since 1.3.0
 * (3) Inline Elements
 *		- icon				=> @since 1.0.0
 *		- icon_link 		=> @since 1.0.0
 *		- highlight			=> @since 1.0.0
 *		- dropcap			=> @since 1.0.0
 *		- label				=> @since 1.0.0
 *		- vector_icon		=> @since 1.0.0
 * (3) Tabs, Accordion, & Toggles
 *		- tabs				=> @since 1.0.0
 *		- accordion			=> @since 1.0.0
 *		- toggle			=> @since 1.0.0
 * (5) Sliders
 * 		- slider			=> @since 1.0.0
 *		- post_grid_slider	=> @since 1.0.0
 *		- post_list_slider	=> @since 1.0.0
 *      - gallery_slider    => @since 1.3.0
 * (6) Display Posts
 *		- post_grid			=> @since 1.0.0
 *		- post_list			=> @since 1.0.0
 *		- mini_post_grid	=> @since 1.0.0
 *		- mini_post_list	=> @since 1.0.0
 */

/*-----------------------------------------------------------*/
/* Columns
/*-----------------------------------------------------------*/

/**
 * Columns
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @param string $tag Current shortcode tag
 */
function themeblvd_shortcode_column( $atts, $content = null, $tag = '' ) {

    // Determine if column is last in row
	$last = '';
	if( isset( $atts[0] ) && trim( $atts[0] ) == 'last')
		$last = ' last';

    // Determine width of column
	$class = 'column ';

    switch ( $tag ) {

        case 'one_sixth' :
            $class .= 'grid_2';
            break;

        case 'one_fourth' :
            $class .= 'grid_3';
            break;

        case 'one_third' :
            $class .= 'grid_4';
            break;

        case 'one_half' :
            $class .= 'grid_6';
            break;

        case 'two_third' :
            $class .= 'grid_8';
            break;

        case 'three_fourth' :
            $class .= 'grid_9';
            break;

        case 'one_fifth' :
            $class .= 'grid_fifth_1';
            break;

        case 'two_fifth' :
            $class .= 'grid_fifth_2';
            break;

        case 'three_fifth' :
            $class .= 'grid_fifth_3';
            break;

        case 'four_fifth' :
            $class .= 'grid_fifth_4';
            break;

        case 'three_tenth' :
            $class .= 'grid_tenth_3';
            break;

        case 'seven_tenth' :
            $class .= 'grid_tenth_7';
            break;

    }

    // Is user adding additional classes?
    if ( isset( $atts['class'] ) ) {
        $class .= ' '.$atts['class'];
    }

    // Force wpautop in shortcode? (not relevant if columns not wrapped in [raw])
    if ( isset( $atts['wpautop'] ) && trim( $atts['wpautop'] ) == 'true') {
        $content = wpautop( $content );
    }

    // Return column
	$content = '<div class="'.$class.$last.'">'.$content.'</div><!-- .column (end) -->';
    return do_shortcode( $content );
}

/**
 * Clear Row
 *
 * @since 1.0.0
 */
function themeblvd_shortcode_clear() {
	return '<div class="clear"></div>';
}

/*-----------------------------------------------------------*/
/* Components
/*-----------------------------------------------------------*/

/**
 * Icon List
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_icon_list( $atts, $content = null ) {

    $default = array(
		'style' => '',					// (deprecated) check, crank, delete, doc, plus, star, star2, warning, write
		'icon'	=> 'caret-right',		// Any fontawesome icon
		'color'	=> ''					// Optional color hex for icon - ex: #000000
    );
    extract( shortcode_atts( $default, $atts ) );


    // For those using old "style" method, this will
    // match the old style choices to a fontawesome icon
    // and add in a relevant color.
    if( $style ) {
	    switch( $style ) {
		    case 'check' :
		    	$icon = 'ok-sign';
		    	$color = '#59f059';
		    	break;
		    case 'crank' :
		    	$icon = 'cog';
		    	$color = '#d7d7d7';
		    	break;
		    case 'delete' :
		    	$icon = 'remove-sign';
		    	$color = '#ff7352';
		    	break;
		    case 'doc' :
		    	$icon = 'file';
		    	$color = '#b8b8b8';
		    	break;
		    case 'plus' :
		    	$icon = 'plus-sign';
		    	$color = '#59f059';
		    	break;
		    case 'star' :
		    	$icon = 'star';
		    	$color = '#eec627';
		    	break;
		    case 'star2' :
		    	$icon = 'star';
		    	$color = '#a7a7a7';
		    	break;
		    case 'warning' :
		    	$icon = 'warning-sign';
		    	$color = '#ffd014';
		    	break;
		    case 'write' :
		    	$icon = 'pencil';
		    	$color = '#ffd014';
		    	break;
	    }
    }

    // Color
    $color_css = '';
    if( $color ) {
    	$color_css = ' style="color:'.$color.';"';
    }

    // Add in fontawesome icon
    $content = str_replace('<ul>', '<ul class="tb-icon-list fa-ul">', $content );

    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {
        $content = str_replace('<li>', '<li><i class="fa-li fa fa-'.$icon.'"'.$color_css.'></i> ', $content );
    } else {
        $content = str_replace('<li>', '<li><i class="icon-'.$icon.'"'.$color_css.'></i> ', $content );
    }

    // Output
    $output = do_shortcode($content);
    return $output;
}

/**
 * Button
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_button( $atts, $content = null ) {

    $output = '';

    $default = array(
        'link' 			=> '',
        'color' 		=> 'default',
        'target' 		=> '_self',
        'size' 			=> '',
        'class' 		=> '',
        'title' 		=> '',
        'icon_before' 	=> '',
        'icon_after' 	=> '',
        'block'         => 'false'
    );
    extract( shortcode_atts( $default, $atts ) );

    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

        if ( $block == 'true' ) {
            $block = true;
        } else {
            $block = false;
        }

        $output = themeblvd_button( $content, $link, $color, $target, $size, $class, $title, $icon_before, $icon_after, '', $block );

    } else {

        $output = themeblvd_button( $content, $link, $color, $target, $size, $class, $title, $icon_before, $icon_after );

    }

    return $output;
}

/**
 * Info Boxes
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_box( $atts, $content = null ) {

    $output = '';
    $has_icon = '';

    $default = array(
        'style' 	=> 'blue', // blue, green, grey, orange, purple, red, teal, yellow
        'icon' 		=> ''
    );
    extract( shortcode_atts( $default, $atts ) );

    // Classes
    $classes = sprintf( 'info-box info-box-%s', $style );

    // Add icon
    if( $icon ) {
    	$classes .= ' info-box-has-icon';
        if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {
            $content = sprintf( '<i class="icon fa fa-%s"></i>%s', $icon, $content );
        } else {
            $content = sprintf( '<i class="icon-%s"></i>%s', $icon, $content );
        }
    }

    $output = sprintf( '<div class="%s">%s</div>', $classes, apply_filters( 'themeblvd_the_content', $content ) );

    return $output;
}

/**
 * Alerts (from Bootstrap)
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_alert( $atts, $content = null ) {

    $default = array(
        'style' => 'info', // info, success, danger, warning
        'close' => 'false' // true, false
    );
    extract( shortcode_atts( $default, $atts ) );

    // In Bootstrap 3, 'message' was changed to 'warning'
    if ( 'message' == $style ) {
        $style = 'warning';
    }

    // CSS classes
    $classes = 'alert';

    if( in_array( $style, array( 'info', 'success', 'danger', 'warning' ) ) ) { // Twitter Bootstrap options
    	$classes .= sprintf( ' alert-%s', $style );
    }

    if( $close == 'true' ) {
    	$classes .= ' fade in';
    }

    // Start output
    $output = sprintf( '<div class="%s">', $classes );

    // Add a close button?
    if( $close == 'true' ) {
    	$output .= '<button type="button" class="close" data-dismiss="alert">×</button>';
    }

    // Finish output
    $output .= $content.'</div><!-- .alert (end) -->';

    return $output;
}

/**
 * Divider
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 */
function themeblvd_shortcode_divider( $atts, $content = null ) {

    $default = array(
        'style' => 'solid' // dashed, shadow, solid
    );
    extract( shortcode_atts( $default, $atts ) );

    return themeblvd_divider( $style );
}

/**
 * Progress Bar (from Bootstrap)
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_progress_bar( $atts ) {

    $default = array(
        'color' 	=> '',		// default, danger, success, info, warning
        'percent' 	=> '100',	// Percent of bar - 30, 60, 80, etc.
        'striped' 	=> 'false',	// true, false
        'animate' 	=> 'false'	// true, false
    );
    extract( shortcode_atts( $default, $atts ) );

    $wrap_classes = '';

    // Wrap classes for Bootstrap 3+
    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {
        $wrap_classes = 'progress';
    }

    // Start classes
    $classes = '';

    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

        // Bootstrap 3+
        $classes = 'progress-bar';

    } else {

        // Bootstrap 1 & 2 (@deprecated)
        $classes = 'progress';

    }

    // Color
    if( $color ) {

        if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

            // Bootstrap 3+
            $classes .= ' progress-bar-'.$color;

        } else {

            // Bootstrap 1 & 2 (@deprecated)
            $classes .= ' progress-'.$color;
        }
    }

    // Striped?
    if( $striped == 'true' ) {
    	if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

            // Bootstrap 3+
            $wrap_classes .= ' progress-striped';

        } else {

            // Bootstrap 1 & 2 (@deprecated)
            $classes .= ' progress-striped';

        }
    }

    // Animated?
    if( $animate == 'true' ) {
        if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

            // Bootstrap 3
            $wrap_classes .= ' active';

        } else {

            // Bootstrap 1 & 2 (@deprecated)
            $classes .= ' active';

        }
    }

    // Output
    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

        // Bootstrap 3+
        $output  = '<div class="'.$wrap_classes.'">';
        $output .= '    <div class="'.$classes.'" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percent.'%;">';
        $output .= '        <span class="sr-only">'.$percent.'%</span>';
        $output .= '    </div>';
        $output .= '</div>';

    } else {

        // Bootstrap 1 & 2 (@deprecated)
        $output  = '<div class="'.$classes.'">';
        $output .= '    <div class="bar" style="width: '.$percent.'%;"></div>';
        $output .= '</div>';

    }


    return $output;
}

/**
 * Popup (from Bootstrap)
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content Content in shortcode
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_popup( $atts, $content = null ) {

    $default = array(
    	'text' 			=> 'Link Text', // Text for link or button leading to popup
		'title' 		=> '', 			// Title for anchor, will default to "text" option
		'color' 		=> 'default', 	// Color of button, only applies if button style is selected
		'size'			=> '',			// Size of button,
		'icon_before'	=> '', 			// Icon before button or link's text
		'icon_after' 	=> '', 			// Icon after button or link's text
		'header' 		=> '', 			// Header text for popup
		'animate' 		=> 'false'		// Whether popup slides in or not - true, false
    );
    extract( shortcode_atts( $default, $atts ) );

    // ID for popup
    $popup_id = uniqid( 'popup_'.rand() );

    // Button/Link
    $link = '';
    if( $title ) {
    	$title = $text;
    }

    $link = themeblvd_button( $text, '#'.$popup_id, $color, null, $size, null, $title, $icon_before, $icon_after, 'data-toggle="modal"' );
	$link = apply_filters('themeblvd_the_content', $link);

    // Classes for popup
    $classes = 'modal';
    if( $animate == 'true' ) {
    	$classes .= ' fade';
    }

    // Header
    $header_html = '';
    if( $header ) {
    	$header_html .= '<div class="modal-header">';
    	$header_html .= '<button type="button" class="close" data-dismiss="modal">×</button>';
    	$header_html .= '<h3>'.$header.'</h3>';
    	$header_html .= '</div><!-- modal-header (end) -->';
    }

    // Output
    $output  = $link;
    $output .= '<div class="'.$classes.'" id="'.$popup_id.'" tabindex="-1" role="dialog" aria-hidden="true">';
    $output .= '<div class="modal-dialog">';
    $output .= '<div class="modal-content">';

    $output .= $header_html;

    $output .= '<div class="modal-body">';
    $output .= apply_filters('themeblvd_the_content', $content);
    $output .= '</div><!-- .modal-body (end) -->';
    $output .= '<div class="modal-footer">';

    $close_class = 'btn btn-default';
    if ( apply_filters( 'themeblvd_btn_gradient', false ) ) {
        $close_class .= ' btn-gradient';
    }
    $output .= '<a href="#" class="'.$close_class.'" data-dismiss="modal">'.themeblvd_get_local('close').'</a>';

    $output .= '</div><!-- .modal-footer (end) -->';

    $output .= '</div><!-- .modal-content (end) -->';
    $output .= '</div><!-- .modal-dialog (end) -->';
    $output .= '</div><!-- .modal (end) -->';

    return $output;
}

/**
 * Lightbox
 *
 * @since 1.1.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content Content in shortcode
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_lightbox( $atts, $content = null ) {

    // Shortcode requires framework 2.3+
    if ( ! function_exists( 'themeblvd_is_lightbox_url' ) ) {
        $error = __('You must be using a theme with Theme Blvd framework v2.3+ to use the [lightbox] shortcode.', 'themeblvd_shortcodes' );
        return sprintf( '<div class="alert">%s</div>', $error );
    }

    $default = array(
        'link'      => '',          // URL being linked to in the lightbox popup
        'thumb'     => '',          // Text or Image URL being used for link to lightbox
        'caption'   => '',          // Caption below thumbnail
        'width'     => '',          // Width of tumbnail image linking to lighbox
        'align'     => 'none',      // Alignment of thumbnail image
        'title'     => '',          // Title displayed in lightbox link
        'frame'     => 'true',      // Whether or not to display frame around thumbnail
        'frame_max' => 'true',      // Whether or not the frame takes on the image's width as a max-width (super-secret and not in generator)
        'icon'      => 'image',     // Icon for thumbnail if in frame - video or image
        'class'     => ''           // Class to append to <a>, or frame if enabled
    );
    $atts = shortcode_atts( $default, $atts );

    $output = '';

    // Setup thumbnail, can be image or text string
    $thumb = $atts['thumb'];
    $has_thumb_img = false;
    $thumb_type = wp_check_filetype( $thumb );

    if( substr( $thumb_type['type'], 0, 5 ) == 'image' ) {

        $has_thumb_img = true;

        // Build <img /> HTML for thumbnail
        $thumb = sprintf('<img src="%s" alt="%s"', $thumb, $atts['title'] );

        if( $atts['width'] ) {
            $thumb .= sprintf( ' width="%s"', $atts['width'] );
        }

        if( $atts['frame'] == 'false' && $atts['align'] != 'none' ) {
            // If image is framed, the alignment will be on the frame
            $thumb .= sprintf( ' class="align%s"', $atts['align'] );
        }

        $thumb .= ' />';
    }

    // Add image overlay if framed thumbnail
    if( $atts['frame'] == 'true' && $has_thumb_img ) {
        $thumb .= themeblvd_get_image_overlay();
    }

    // Classes for link's anchor tag
    $anchor_classes = '';

    if ( $atts['frame'] == 'true' ) {
        $anchor_classes .= 'thumbnail '.$atts['icon'];
    }

    if ( $atts['frame'] == 'false' && $atts['class'] ) {
        $anchor_classes .= $atts['class'];
    }

    if( $atts['caption'] ) {
        $anchor_classes .= ' has-caption';
    }

    // Wrap thumbail image/text in link to lightbox
    $args = apply_filters('themeblvd_lightbox_shortcode_args', array(
        'item'      => $thumb,
        'link'      => $atts['link'],
        'title'     => $atts['title'],
        'class'     => $anchor_classes
    ), $atts );

    $output .= themeblvd_get_link_to_lightbox( $args );

    // Wrap link and thumbnail image in frame
    if( $atts['frame'] == 'true' && $has_thumb_img ) {

        // Wrapping CSS classes
        $wrap_classes = 'tb-lightbox-shortcode';

        if ( $atts['align'] != 'none' ) {
            $wrap_classes .= ' align'.$atts['align'];
        }

        if ( $atts['class'] ) {
            $wrap_classes .= ' '.$atts['class'];
        }

        // Force inline styling
        $style = '';
        if( $atts['width'] && $atts['frame_max'] == 'true' ) {
            $style = sprintf('max-width: %spx', $atts['width']);
        }

        $wrap  = '<div class="'.$wrap_classes.'" style="'.$style.'">';
        $wrap .= '<div class="featured-image-wrapper">';
        $wrap .= '<div class="featured-image">';
        $wrap .= '<div class="featured-image-inner">';
        $wrap .= '%s';

        // Caption
        if ( $atts['caption'] ) {
            $wrap .= sprintf( '<p class="wp-caption-text">%s</p>', $atts['caption'] );
        }

        $wrap .= '</div><!-- .featured-image-inner (end) -->';
        $wrap .= '</div><!-- .featured-image (end) -->';
        $wrap .= '</div><!-- .featured-image-wrapper (end) -->';
        $wrap .= '</div>';
        $wrap = apply_filters( 'themeblvd_lightbox_shortcode_thumbnail_wrap', $wrap, $wrap_classes, $style );

        $output = sprintf( $wrap, $output );

    } else if ( $atts['caption'] ) {

        $output .= sprintf( '<p class="wp-caption-text">%s</p>', $atts['caption'] );

    }

    return apply_filters( 'themeblvd_shortcode_lightbox', $output, $atts, $thumb );

}

/**
 * Wrap a set of [lightbox] instances to link as a gallery.
 *
 * @since 1.1.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content Content in shortcode
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_lightbox_gallery( $atts, $content = null ) {

    // Shortcode requires framework 2.3+
    if ( ! function_exists( 'themeblvd_is_lightbox_url' ) ) {
        $error = __('You must be using a theme with Theme Blvd framework v2.3+ to use the [lightbox] shortcode.', 'themeblvd_shortcodes' );
        return sprintf( '<div class="alert">%s</div>', $error );
    }

    $default = array(
       // currently no atts ...
    );
    $atts = shortcode_atts( $default, $atts );

    return sprintf( '<div class="themeblvd-gallery">%s</div>', do_shortcode($content) );

}

/**
 * Blockquote
 *
 * @since 1.2.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 */
function themeblvd_shortcode_blockquote( $atts ) {

    $defaults = array(
        'quote'         => '',
        'source'        => '',      // Source of quote
        'source_link'   => '',      // URL to link source to
        'align'         => '',      // How to align blockquote - left, right
        'max_width'     => '',      // Meant to be used with align left/right - 300px, 50%, etc
        'class'         => ''       // Any additional CSS classes
    );
    $atts = shortcode_atts( $defaults, $atts );

    $output = __('Your theme does not support the [blockquote] shortcode.', 'themeblvd_shortcodes');

    if ( function_exists( 'themeblvd_get_blockquote' ) ) {
        $output = themeblvd_get_blockquote( $atts );
    }

    return $output;
}

/**
 * Jumbotron
 *
 * @since 1.3.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content Content in shortcode
 * @param string $content The enclosed content
 */
function themeblvd_shortcode_jumbotron( $atts, $content = null ) {

    $defaults = array(
        'title'         => '',      // Title of unit
        'text_align'    => 'left',  // How to align text - left, right, center
        'align'         => '',      // How to align jumbotron - left, right
        'max_width'     => '',      // Meant to be used with align left/right - 300px, 50%, etc
        'class'         => '',      // Any additional CSS classes
        'wpautop'       => 'true'   // Whether to apply wpautop on content
    );
    $atts = shortcode_atts( $defaults, $atts );

    $output = __('Your theme does not support the [jumbotron] shortcode.', 'themeblvd_shortcodes');

    if ( function_exists( 'themeblvd_get_jumbotron' ) ) {

        if ( $atts['wpautop'] === 'false' ) {
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
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content Content in shortcode
 * @param string $content The enclosed content
 */
function themeblvd_shortcode_panel( $atts, $content = null ) {

    $defaults = array(
        'style'         => 'default',   // Style of panel - primary, success, info, warning, danger
        'title'         => '',          // Header for panel
        'footer'        => '',          // Footer for panel
        'text_align'    => 'left',      // How to align text - left, right, center
        'align'         => '',          // How to align jumbotron - left, right
        'max_width'     => '',          // Meant to be used with align left/right - 300px, 50%, etc
        'class'         => '',          // Any additional CSS classes
        'wpautop'       => 'true'       // Whether to apply wpautop on content
    );
    $atts = shortcode_atts( $defaults, $atts );

    // CSS classes
    $class = sprintf( 'panel panel-%s text-%s', $atts['style'], $atts['text_align'] );

    if ( $atts['class'] ) {
        $class .= ' '.$atts['class'];
    }

    // WP auto?
    if ( $atts['wpautop'] == 'true' ) {
        $content = wpautop( $content );
    }

    // Construct intial panel
    $output = sprintf( '<div class="%s">', $class );

    if ( $atts['title'] ) {
        $output .= sprintf( '<div class="panel-heading"><h3 class="panel-title">%s</h3></div>', $atts['title'] );
    }

    $output .= sprintf( '<div class="panel-body">%s</div>', do_shortcode( $content ) );

    if ( $atts['footer'] ) {
        $output .= sprintf( '<div class="panel-footer">%s</div>', $atts['footer'] );
    }

    $output .= '</div><!-- .panel (end) -->';

    return $output;
}

/*-----------------------------------------------------------*/
/* Inline Elements
/*-----------------------------------------------------------*/

/**
 * 48px Icon (NOT Font Awesome icons)
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_icon( $atts, $content = null ) {

	$default = array(
        'image' => 'accepted',
        'align' => 'left', // left, right, center, none
        'width'	=> '45'
    );
    extract( shortcode_atts( $default, $atts ) );

    // Icon image URL
    if( file_exists( get_stylesheet_directory().'/icons/'.$image.'.png' ) )
        $image_url = get_stylesheet_directory_uri().'/icons/'.$image.'.png';
    else if( version_compare( TB_FRAMEWORK_VERSION, '2.3.0', '<') )
        $image_url = get_template_directory_uri().'/framework/frontend/assets/images/shortcodes/icons/'.$image.'.png';
    else
        $image_url = get_template_directory_uri().'/framework/assets/images/shortcodes/icons/'.$image.'.png';

    // Alignment
    $align != 'none' ? $align = ' align'.$align : $align = null;

    // Output
    $output = '<img src="'.$image_url.'" class="tb-image-icon '.$image.$align.'" width="'.$width.'" />';

	return $output;
}

/**
 * Icon Link
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_icon_link( $atts, $content = null ) {

    $default = array(
        'icon' 		=> '',      // alert, approved, camera, cart, doc, download, media, note, notice, quote, warning
        'color'     => '',      // text color of icon - Ex: #666
        'link' 		=> '',
        'target' 	=> '_self',
        'class' 	=> '',
        'title' 	=> ''
    );
    extract( shortcode_atts( $default, $atts ) );

    // Convert icons used with older framework versions to fontawesome
    // alert, approved, camera, cart, doc, download, media, note, notice, quote, warning
    // Note: "camera" and "download" work so can be excluded below.
    switch( $icon ) {
	    case 'alert' :
	    	$icon = 'exclamation-sign';
	    	break;
	    case 'approved' :
			$icon = 'check';
	    	break;
	    case 'cart' :
	    	$icon = 'shopping-cart';
	    	break;
	    case 'doc' :
	    	$icon = 'file';
	    	break;
	    case 'media' :
	    	$icon = 'hdd'; // Kind of ironic... The CD icon gets replaced with the harddrive icon in the update for the "media" icon.
	    	break;
	    case 'note' :
	    	$icon = 'pencil';
	    	break;
	    case 'notice' :
	    	$icon = 'exclamation-sign'; // Was always the same as "alert"
	    	break;
	    case 'quote' :
	    	$icon = 'comment';
	    	break;
	    case 'warning' :
	    	$icon = 'warning-sign';
	    	break;
    }

    if( ! $title ) {
        $title = $content;
    }

    if( $class ) {
        $class = ' '.$class;
    }

    $style ='';
    if ( $color ) {
        $style = sprintf( 'color: %s', $color );
    }

    $output  = sprintf( '<span class="tb-icon-link%s">', $class );

    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {
        $output .= sprintf( '<i class="icon fa fa-%s" style="%s"></i>', $icon, $style );
    } else {
        $output .= sprintf( '<i class="icon-%s" style="%s"></i>', $icon, $style );
    }

    $output .= sprintf( '<a href="%s" title="%s" class="icon-link-%s" target="%s">%s</a>', $link, $title, $icon, $target, $content );
    $output .= '</span>';

    return $output;
}

/**
 * Text Highlight
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 */
function themeblvd_shortcode_highlight( $atts, $content = null ) {
    return '<span class="text-highlight">'.do_shortcode($content).'</span><!-- .text-highlight (end) -->';
}

/**
 * Dropcaps
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 */
function themeblvd_shortcode_dropcap( $atts, $content = null ) {
    return '<span class="dropcap">'.do_shortcode($content).'</span><!-- .dropcap (end) -->';
}

/**
 * Labels (straight from Bootstrap)
 *
 * <span class="label label-success">Success</span>
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 */
function themeblvd_shortcode_label( $atts, $content = null ) {

    $default = array(
        'style' => 'default', // default, success, warning, danger, info
        'icon'	=> ''
    );
    extract( shortcode_atts( $default, $atts ) );

    $class = 'label';

    // Convert styles from Bootstrap 1 & 2 to Bootstrap 3.
    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {
        if ( 'important' == $style ) {
            $style = 'danger';
        }
    }

    if ( ! $style ) {
        $style = 'default';
    }

    $class .= ' label-'.$style;

    if ( $icon ) {
    	if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {
            $content = '<i class="fa fa-'.$icon.'"></i> '.$content;
        } else {
            $content = '<i class="icon-'.$icon.'"></i> '.$content;
        }
    }

    return '<span class="'.$class.'">'.do_shortcode($content).'</span><!-- .label (end) -->';
}

/**
 * Vector Icon (from Bootstrap and Font Awesome)
 *
 * <i class="fa fa-{whatever}"></i>
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 */
function themeblvd_shortcode_vector_icon( $atts ) {

    $default = array(
        'icon'      => 'pencil',    // FontAwesome icon id
        'color'     => '',          // Text color of icon - Ex: #666
        'size'      => '',          // Font size for icon - Ex: 1.5em, 20px, etc
        'rotate'    => '',          // Optional rotation of the icon - 90, 180, 270
        'flip'      => '',          // Optional flip of the icon - horizontal, vertical
        'class'     => ''           // CSS class
    );
    extract( shortcode_atts( $default, $atts ) );

    // Remove "fa-" if the user added it to the icon ID
    $icon = str_replace('fa-', '', $icon);

    $style = '';

    if ( $size ) {
        $style .= sprintf( 'font-size: %s;', $size );
    }
    if ( $color ) {
        $style .= sprintf( 'color: %s;', $color );
    }

    $icon_class = sprintf( 'fa fa-%s', $icon ); // FontAwesome 4
    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '<' ) ) {
        $icon_class = sprintf( 'icon-%s', $icon ); // FontAwesome 1-3
    }

    if ( $rotate ) {
        $icon_class .= sprintf( ' fa-rotate-%s', $rotate );
    }

    if ( $flip ) {
        $icon_class .= sprintf( ' fa-flip-%s', $flip );
    }

    if ( $class ) {
        $icon_class .= sprintf( ' %s', $class );
    }

    return sprintf( '<i class="%s" style="%s"></i>', $icon_class, $style );
}

/*-----------------------------------------------------------*/
/* Tabs, Accordion, & Toggles
/*-----------------------------------------------------------*/

/**
 * Tabs
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_tabs( $atts, $content = null ) {

    $default = array(
        'style' 		=> 'framed', 		// framed, open
        'nav'			=> 'tabs',          // tabs, pills
        'height' 		=> '' 				// Fixed height for tabs, true or false
    );
    extract( shortcode_atts( $default, $atts ) );

    // Since we use the $atts to loop through and
    // display the tabs, we need to remove the other
    // data, now that we've extracted it to other
    // variables.
    if( isset( $atts['style'] ) ) {
        unset( $atts['style'] );
    }

    if( isset( $atts['nav'] ) ) {
        unset( $atts['nav'] );
    }

    if( isset( $atts['height'] ) ) {
        unset( $atts['height'] );
    }

    $id = uniqid( 'tabs_'.rand() );
    $num = count( $atts ) - 1;
	$i = 1;

    // Setup options pass
    $options = array(
    	'setup' => array(
    		'num' 	=> $num,
    		'style' => $style,
    		'nav' 	=> $nav,
    		'names' => array()
    	)
    );

    // Add in height to options as true boolean
    if ( ! $height || 'false' === $height ) {
        $height = false;
    } else {
        $height = true;
    }

    $options['height'] = $height;

    if( is_array( $atts ) && count( $atts ) > 0 ) {
		foreach( $atts as $key => $tab ) {
			$options['setup']['names']['tab_'.$i] = $tab;
			$tab_content = explode( '[/'.$key.']', $content );
			$tab_content = explode( '['.$key.']', $tab_content[0] );
			$options['tab_'.$i] = array(
				'type' => 'raw',
				'raw' => $tab_content[1],
			);
			$i++;
		}

		$output  = '<div class="element element-tabs'.themeblvd_get_classes( 'element_tabs', true ).'">';
        $output .= themeblvd_tabs( $id, $options );
        $output .= '</div><!-- .element (end) -->';

	} else {
		$output = '<p class="tb-warning">'.__( 'No tabs found', 'themeblvd_shortcodes' ).'</p>';
	}
    return $output;
}

/**
 * Accordion
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_accordion( $atts, $content = null ) {

    $accordion_id = uniqid( 'accordion_'.rand() );

    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

        // Bootstrap 3
        $output = sprintf( '<div id="%s" class="tb-accordion panel-group">%s</div>', $accordion_id, do_shortcode( $content ) );

    } else {

        // Bootstrap 1 & 2
        $output = sprintf( '<div id="%s" class="tb-accordion">%s</div>', $accordion_id, do_shortcode( $content ) );

    }

    return $output;
}

/**
 * Toggles
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_toggle( $atts, $content = null ) {

	$default = array(
        'title' => '',
        'open'  => 'false'
    );
	extract( shortcode_atts( $default, $atts ) );

    // Individual toggle ID (NOT the Accordion ID)
	$toggle_id = uniqid( 'toggle_'.rand() );

    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

        // Bootstrap 3

        // Last toggle?
        $last = isset( $atts[0] ) ? $last = ' panel-last' : null;

        // Is toggle open?
        $classes = 'panel-collapse collapse';
        $icon = 'plus-circle';
        if( $open == 'true' ) {
            $classes .= ' in';
            $icon = 'minus-circle';
        }

        // Bootstrap color
        $color = apply_filters( 'themeblvd_toggle_shortcode_color', 'default' );

        // Bootstrap 3 output
        $output = '
            <div class="tb-panel panel panel-'.$color.$last.'">
                <div class="panel-heading">
                    <a class="panel-title" data-toggle="collapse" data-parent="" href="#'.$toggle_id.'">
                        <i class="fa fa-'.$icon.' switch-me"></i> '.$title.'
                    </a>
                </div><!-- .panel-heading (end) -->
                <div id="'.$toggle_id.'" class="'.$classes.'">
                    <div class="panel-body">
                        '.apply_filters( 'themeblvd_the_content', $content ).'
                    </div><!-- .panel-body (end) -->
                </div><!-- .panel-collapse (end) -->
            </div><!-- .panel (end) -->';

    } else {

        // Bootstrap 1 & 2 output

        // Last toggle?
        $last = isset( $atts[0] ) ? $last = ' accordion-group-last' : null;

        // Is toggle open?
        $classes = 'accordion-body collapse';
        $icon = 'sign';
        if( $open == 'true' ) {
            $classes .= ' in';
            $icon = 'minus-sign';
        }

        // Output
        $output  = '<div class="accordion-group'.$last.'">';
    	$output .= '<div class="accordion-heading">';
    	$output .= '<a class="accordion-toggle" data-toggle="collapse" href="#'.$toggle_id.'"><i class="icon-'.$icon.' switch-me"></i> '.$title.'</a>';
    	$output .= '</div><!-- .accordion-heading (end) -->';
    	$output .= '<div id="'.$toggle_id.'" class="'.$classes.'">';
    	$output .= '<div class="accordion-inner">';
    	$output .= apply_filters( 'themeblvd_the_content', $content );
    	$output .= '</div><!-- .accordion-inner (end) -->';
    	$output .= '</div><!-- .accordion-body (end) -->';
    	$output .= '</div><!-- .accordion-group (end) -->';

    }

    return $output;
}

/*-----------------------------------------------------------*/
/* Sliders
/*-----------------------------------------------------------*/

/**
 * Post Grid Slider
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 */
function themeblvd_shortcode_post_grid_slider( $atts ) {

    $default = array(
        'fx' 			=> 'slide', 	// fx: Transition of slider - fade, slide
        'timeout' 		=> 0, 			// timeout: Seconds in between transitions, 0 for no auto-advancing
        'nav_standard' 	=> 1, 			// nav_standard: Show standard nav dots to control slider - true or false
        'nav_arrows' 	=> 1, 			// nav_arrows: Show directional arrows to control slider - true or false
        'pause_play' 	=> 1, 			// pause_play: Show pause/play button - true or false
        'categories'    => '',          // @deprecated -- Category slug(s) to include/exclude
        'cat'           => '',          // cat: Category ID(s) to include/exclude
        'category_name' => '',          // category_name: Category slug(s) to include/exclude
        'tag'           => '',          // tag: Tag(s) to include/exclude
        'portfolio'     => '',          // portfolio: Portfolio(s) slugs to include, requires Portfolios plugin
        'portfolio_tag' => '',          // portfolio_tag: Portfolio Tag(s) to include, requires Portfolios plugin
        'columns' 		=> 3,			// columns: Number of posts per row
        'rows' 			=> 3,			// rows: Number of rows per slide
        'numberposts' 	=> -1,			// numberposts: Total number of posts, -1 for all posts
        'orderby' 		=> 'date',		// orderby: date, title, comment_count, rand
        'order' 		=> 'DESC',		// order: DESC, ASC
        'offset' 		=> 0,			// offset: Number of posts to offset off the start, defaults to 0
        'query'         => '',          // query: custom query string
        'crop'			=> ''			// crop: Can manually enter a featured image crop size
    );
    extract( shortcode_atts( $default, $atts ) );

    // Generate unique ID
	$id = uniqid( 'grid_'.rand() );

    // Build $options array compatible to element's function
    $options = array(
        'fx' 			=> $fx,
        'timeout' 		=> $timeout,
        'columns' 		=> $columns,
        'rows' 			=> $rows,
        'numberposts' 	=> $numberposts,
        'orderby' 		=> $orderby,
        'order' 		=> $order,
        'offset' 		=> $offset,
        'query'         => $query,
        'crop' 			=> $crop
    );

    // Add in the booleans
    if( $nav_standard === 'true' )
    	$options['nav_standard'] = 1;
    else if( $nav_standard === 'false' )
    	$options['nav_standard'] = 0;
    else
    	$options['nav_standard'] = $default['nav_standard'];

    if( $nav_arrows === 'true' )
    	$options['nav_arrows'] = 1;
    else if( $nav_arrows === 'false' )
    	$options['nav_arrows'] = 0;
    else
    	$options['nav_arrows'] = $default['nav_arrows'];

    if( $pause_play === 'true' )
    	$options['pause_play'] = 1;
    else if( $pause_play === 'false' )
    	$options['pause_play'] = 0;
    else
    	$options['pause_play'] = $default['pause_play'];

    // Categories
    if( $cat )
        $options['cat'] = $cat;
    elseif( $category_name )
        $options['category_name'] = $category_name;
    elseif( $categories )
        $options['category_name'] = $categories; // @deprecated

    // Tags
    if( $tag )
        $options['tag'] = $tag;

    // Portfolios
    if( $portfolio )
        $options['portfolio'] = $portfolio;

    // Portfolios
    if( $portfolio_tag )
        $options['portfolio_tag'] = $portfolio_tag;

	// Output
	ob_start();
	echo '<div class="element element-post_grid_slider'.themeblvd_get_classes( 'element_post_grid_slider', true ).'">';
	echo '<div class="element-inner">';
	echo '<div class="element-inner-wrap">';
	echo '<div class="grid-protection">';
	themeblvd_post_slider( $id, $options, 'grid', 'primary' );
	echo '</div><!-- .grid-protection (end) -->';
	echo '</div><!-- .element-inner-wrap (end) -->';
	echo '</div><!-- .element-inner (end) -->';
	echo '</div><!-- .element (end) -->';
	return ob_get_clean();
}

/**
 * Post List Slider
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 */
function themeblvd_shortcode_post_list_slider( $atts ) {

    $default = array(
        'fx' 				=> 'slide', 	// fx: Transition of slider - fade, slide
        'timeout' 			=> 0, 			// timeout: Seconds in between transitions, 0 for no auto-advancing
        'nav_standard' 		=> 1, 			// nav_standard: Show standard nav dots to control slider - true or false
        'nav_arrows' 		=> 1, 			// nav_arrows: Show directional arrows to control slider - true or false
        'pause_play' 		=> 1, 			// pause_play: Show pause/play button - true or false
        'categories'        => '',          // @deprecated -- Category slug(s) to include/exclude
        'cat'               => '',          // cat: Category ID(s) to include/exclude
        'category_name'     => '',          // category_name: Category slug(s) to include/exclude
        'tag'               => '',          // tag: Tag(s) to include/exclude
        'portfolio'         => '',          // portfolio: Portfolio(s) slugs to include, requires Portfolios plugin
        'portfolio_tag'     => '',          // portfolio_tag: Portfolio Tag(s) to include, requires Portfolios plugin
        'thumbs' 			=> 'default',	// thumbs: Size of post thumbnails - default, small, full, hide
        'post_content' 		=> 'default',	// content: Show excerpts or full content - default, content, excerpt
        'posts_per_slide'   => 3,			// posts_per_slide: Number of posts per slide.
        'numberposts' 		=> -1,			// numberposts: Total number of posts, -1 for all posts
        'orderby' 			=> 'date',		// orderby: date, title, comment_count, rand
        'order' 			=> 'DESC',		// order: DESC, ASC
        'offset' 			=> 0,			// offset: Number of posts to offset off the start, defaults to 0
        'query'             => ''           // query: custom query string
    );
    extract( shortcode_atts( $default, $atts ) );

    // Generate unique ID
	$id = uniqid( 'list_'.rand() );

    // Build $options array compatible to element's function
    $options = array(
        'fx' 				=> $fx,
        'timeout' 			=> $timeout,
        'thumbs' 			=> $thumbs,
        'content' 			=> $post_content,
        'posts_per_slide' 	=> $posts_per_slide,
        'numberposts' 		=> $numberposts,
        'orderby' 			=> $orderby,
        'order' 			=> $order,
        'offset' 			=> $offset,
        'query'             => $query,
    );

    // Add in the booleans
    if( $nav_standard === 'true' )
    	$options['nav_standard'] = 1;
    else if( $nav_standard === 'false' )
    	$options['nav_standard'] = 0;
    else
    	$options['nav_standard'] = $default['nav_standard'];

    if( $nav_arrows === 'true' )
    	$options['nav_arrows'] = 1;
    else if( $nav_arrows === 'false' )
    	$options['nav_arrows'] = 0;
    else
    	$options['nav_arrows'] = $default['nav_arrows'];

    if( $pause_play === 'true' )
    	$options['pause_play'] = 1;
    else if( $pause_play === 'false' )
    	$options['pause_play'] = 0;
    else
    	$options['pause_play'] = $default['pause_play'];

    // Categories
    if( $cat )
        $options['cat'] = $cat;
    elseif( $category_name )
        $options['category_name'] = $category_name;
    elseif( $categories )
        $options['category_name'] = $categories; // @deprecated

    // Tags
    if( $tag )
        $options['tag'] = $tag;

    // Portfolios
    if( $portfolio )
        $options['portfolio'] = $portfolio;

    // Portfolios
    if( $portfolio_tag )
        $options['portfolio_tag'] = $portfolio_tag;

	// Output
	ob_start();
	echo '<div class="element element-post_list_slider'.themeblvd_get_classes( 'element_post_list_slider', true ).'">';
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
 * @param array $atts Standard WordPress shortcode attributes
 */
function themeblvd_shortcode_gallery_slider( $atts ) {

    // This shortcode requires Theme Blvd Framework 2.4.2+
    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.2', '<' ) ) {
        return __( 'Your theme does not support the [gallery_slider] shortcode. You must be using a theme with Theme Blvd Framework 2.4.2+', 'themeblvd_shortcodes' );
    }

    $default = array(
        'ids'           => '',                  // Comma separated attachments ID's
        'size'          => '',                  // Crop size for images
        'thumb_size'    => 'square_smallest',   // Size of nav thumbnail images
        'interval'      => '5000',              // Milliseconds between transitions
        'pause'         => 'true',              // Whether to pause on hover
        'wrap'          => 'true',              // Whether sliders continues auto rotate after first pass
        'nav_standard'  => 'false',             // Whether to show standard nav indicator dots
        'nav_arrows'    => 'true',              // Whether to show standard nav arrows
        'nav_thumbs'    => 'true'               // Whether to show nav thumbnails (added by Theme Blvd framework)
    );
    $atts = shortcode_atts( $default, $atts );

    // Setup [gallery]
    $gallery = sprintf( '[gallery ids="%s"]', $atts['ids'] );

    // Remove ID's from $atts
    unset( $atts['ids'] );

    // Convert booleans
    foreach( $atts as $key => $value ) {
        if ( $value === 'true' ) {
            $atts[$key] = true;
        } else if ( $value === 'false' ) {
            $atts[$key] = false;
        }
    }

    return themeblvd_get_gallery_slider( $gallery, $atts );
}

/*-----------------------------------------------------------*/
/* Display Posts
/*-----------------------------------------------------------*/

/**
 * Post Grid
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 */
function themeblvd_shortcode_post_grid( $atts ) {

    $default = array(
        'categories'    => '',                  // @deprecated -- Category slug(s) to include/exclude
        'cat'           => '',                  // cat: Category ID(s) to include/exclude
        'category_name' => '',                  // category_name: Category slug(s) to include/exclude
        'tag'           => '',                  // tag: Tag(s) to include/exclude
        'portfolio'     => '',                  // portfolio: Portfolio(s) slugs to include, requires Portfolios plugin
        'portfolio_tag' => '',                  // portfolio_tag: Portfolio Tag(s) to include, requires Portfolios plugin
        'columns' 		=> 3,					// columns: Number of posts per row
        'rows' 			=> 3,					// rows: Number of rows per slide
        'orderby' 		=> 'date',				// orderby: date, title, comment_count, rand
        'order' 		=> 'DESC',				// order: DESC, ASC
        'offset' 		=> 0,					// offset: Number of posts to offset off the start, defaults to 0
        'query' 		=> '',					// custom query string
        'crop'			=> '',					// crop: Can manually enter a featured image crop size
        'link' 			=> 0,					// link: Show link after posts, true or false
        'link_text' 	=> 'View All Posts', 	// link_text: Text for the link
        'link_url' 		=> 'http://google.com',	// link_url: URL where link should go
        'link_target' 	=> '_self' 				// link_target: Where link opens - _self, _blank
    );
    extract( shortcode_atts( $default, $atts ) );

    // Build $options array compatible to element's function
    $options = array(
        'columns' 		=> $columns,
        'rows' 			=> $rows,
        'tag'           => $tag,
        'portfolio'     => $portfolio,
        'portfolio_tag' => $portfolio_tag,
        'orderby' 		=> $orderby,
        'order' 		=> $order,
        'offset' 		=> $offset,
        'crop' 			=> $crop,
        'query' 		=> $query,
        'link_text' 	=> $link_text,
        'link_url' 		=> $link_url,
        'link_target' 	=> $link_target
    );

    // Categories
    if( $cat )
        $options['cat'] = $cat;
    elseif( $category_name )
        $options['category_name'] = $category_name;
    elseif( $categories )
        $options['category_name'] = $categories; // @deprecated

    // Add in the booleans
    if( $link === 'true' )
        $options['link'] = 1;
    else if( $link === 'false' )
        $options['link'] = 0;
    else
        $options['link'] = $default['link'];

	// Output
	ob_start();
	echo '<div class="element element-post_grid'.themeblvd_get_classes( 'element_post_grid', true ).'">';
	echo '<div class="element-inner">';
	echo '<div class="element-inner-wrap">';
	echo '<div class="grid-protection">';
	themeblvd_posts( $options, 'grid', 'primary' );
	echo '</div><!-- .grid-protection (end) -->';
	echo '</div><!-- .element-inner-wrap (end) -->';
	echo '</div><!-- .element-inner (end) -->';
	echo '</div><!-- .element (end) -->';
	return ob_get_clean();
}

/**
 * Post List
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 */
function themeblvd_shortcode_post_list( $atts ) {

    $default = array(
        'categories' 	=> '',					// @deprecated -- Category slug(s) to include/exclude
		'cat'           => '',                  // cat: Category ID(s) to include/exclude
        'category_name' => '',                  // category_name: Category slug(s) to include/exclude
        'tag'           => '',                  // tag: Tag(s) to include/exclude
        'portfolio'     => '',                  // portfolio: Portfolio(s) slugs to include, requires Portfolios plugin
        'portfolio_tag' => '',                  // portfolio_tag: Portfolio Tag(s) to include, requires Portfolios plugin
        'thumbs' 		=> 'default',			// thumbs: Size of post thumbnails - default, small, full, hide
		'post_content' 	=> 'default',			// content: Show excerpts or full content - default, content, excerpt
		'numberposts' 	=> 3,					// numberposts: Total number of posts, -1 for all posts
        'orderby' 		=> 'date',				// orderby: date, title, comment_count, rand
        'order' 		=> 'DESC',				// order: DESC, ASC
        'offset' 		=> 0,					// offset: Number of posts to offset off the start, defaults to 0
        'link'			=> 0,					// link: Show link after posts, true or false
        'link_text' 	=> 'View All Posts', 	// link_text: Text for the link
        'link_url' 		=> 'http://google.com',	// link_url: URL where link should go
        'link_target' 	=> '_self', 			// link_target: Where link opens - _self, _blank
        'query' 		=> '' 					// custom query string
    );
    extract( shortcode_atts( $default, $atts ) );

    // Build $options array compatible to element's function
    $options = array(
        'thumbs' 		=> $thumbs,
        'content' 		=> $post_content,
        'tag'           => $tag,
        'portfolio'     => $portfolio,
        'portfolio_tag' => $portfolio_tag,
        'numberposts' 	=> $numberposts,
        'orderby' 		=> $orderby,
        'order' 		=> $order,
        'offset' 		=> $offset,
        'query' 		=> $query,
        'link_text' 	=> $link_text,
        'link_url' 		=> $link_url,
        'link_target' 	=> $link_target
    );

    // Categories
    if( $cat )
        $options['cat'] = $cat;
    elseif( $category_name )
        $options['category_name'] = $category_name;
    elseif( $categories )
        $options['category_name'] = $categories; // @deprecated

    // Add in the booleans
    if( $link === 'true' )
    	$options['link'] = 1;
    else if( $link === 'false' )
    	$options['link'] = 0;
    else
    	$options['link'] = $default['link'];

	// Output
	ob_start();
	echo '<div class="element element-post_list'.themeblvd_get_classes( 'element_post_list', true ).'">';
	echo '<div class="element-inner">';
	echo '<div class="element-inner-wrap">';
	echo '<div class="grid-protection">';
	themeblvd_posts( $options, 'list', 'primary' );
	echo '</div><!-- .grid-protection (end) -->';
	echo '</div><!-- .element-inner-wrap (end) -->';
	echo '</div><!-- .element-inner (end) -->';
	echo '</div><!-- .element (end) -->';
	return ob_get_clean();
}

/**
 * Mini Post Grid
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_mini_post_grid( $atts ) {

    // Default shortcode atts
	$default = array(
        'categories'    => '',          // @deprecated -- Category slug(s) to include/exclude
        'cat'           => '',          // cat: Category ID(s) to include/exclude
        'category_name' => '',          // category_name: Category slug(s) to include/exclude
        'tag'           => '',          // tag: Tag(s) to include/exclude
        'numberposts'   => 4,           // numberposts: Total number of posts, -1 for all posts
        'orderby'       => 'date',      // orderby: date, title, comment_count, rand
        'order'         => 'DESC',      // order: DESC, ASC
        'offset'        => 0,           // offset: Number of posts to offset off the start, defaults to 0
        'query'         => '',          // custom query string
        'thumb'         => 'smaller',   // thumbnail size - small, smaller, or smallest
        'align'         => 'left',      // alignment of grid - left, right, or center
        'gallery'       => ''           // Comma separated list of attachmentn IDs - 1,2,3,4
	);
	extract( shortcode_atts( $default, $atts ) );

    // Build query
    if( ! $query ) {

        // Categories
        if( $categories ) // @deprecated
            $query .= 'category_name='.$categories.'&';
        if( $cat )
            $query .= 'cat='.$cat.'&';
        if( $category_name )
            $query .= 'category_name='.$category_name.'&';

        // Tags
        if( $tag )
            $query .= 'tag='.$tag.'&';

        // Continue query
        $query .= 'numberposts='.$numberposts.'&';
        $query .= 'orderby='.$orderby.'&';
        $query .= 'order='.$order.'&';
        $query .= 'offset='.$offset.'&';
        $query .= 'suppress_filters=false'; // Mainly for WPML compat

    }

    if ( $gallery ) {
        $gallery = sprintf( '[gallery ids="%s" link="file"]', $gallery );
    }

	// Output
	$output = themeblvd_get_mini_post_grid( $query, $align, $thumb, $gallery );

    return $output;

}

/**
 * Mini Post List
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_mini_post_list( $atts ) {

    // Default shortcode atts
	$default = array(
        'categories'    => '',          // @deprecated -- Category slug(s) to include/exclude
        'cat'           => '',          // cat: Category ID(s) to include/exclude
        'category_name' => '',          // category_name: Category slug(s) to include/exclude
        'tag'           => '',          // tag: Tag(s) to include/exclude
        'numberposts'   => 4,           // numberposts: Total number of posts, -1 for all posts
        'orderby'       => 'date',      // orderby: date, title, comment_count, rand
        'order'         => 'DESC',      // order: DESC, ASC
        'offset'        => 0,           // offset: Number of posts to offset off the start, defaults to 0
        'query'         => '',          // custom query string
        'thumb'         => 'smaller',   // thumbnail size - small, smaller, smallest, or hide
        'meta'          => 'show'       // show meta or not - show or hide
	);
	extract( shortcode_atts( $default, $atts ) );

    // Build query
    if( ! $query ) {

        // Categories
        if( $categories ) // @deprecated
            $query .= 'category_name='.$categories.'&';
        if( $cat )
            $query .= 'cat='.$cat.'&';
        if( $category_name )
            $query .= 'category_name='.$category_name.'&';

        // Tags
        if( $tag )
            $query .= 'tag='.$tag.'&';

        // Continue query
        $query .= 'numberposts='.$numberposts.'&';
        $query .= 'orderby='.$orderby.'&';
        $query .= 'order='.$order.'&';
        $query .= 'offset='.$offset.'&';
        $query .= 'suppress_filters=false'; // Mainly for WPML compat

    }

    // Format thumbnail size
    if( $thumb == 'hide' )
    $thumb = false;

    // Format meta
    $meta == 'show' ? $meta = true : $meta = false;

    // Output
    $output = themeblvd_get_mini_post_list( $query, $thumb, $meta );

    return $output;
}