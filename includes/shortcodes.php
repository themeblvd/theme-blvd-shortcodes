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
 *		- button 			=> @since 1.0.0
 *		- box				=> @since 1.0.0 @deprecated 1.4.0
 *		- alert				=> @since 1.0.0
 *		- icon_list			=> @since 1.0.0
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
        'include_bg'        => 1,
        'include_border'    => 1
    );
    extract( shortcode_atts( $default, $atts ) );

    $final_class = 'btn-shortcode';

    if ( $class ) {
        $final_class .= ' '.$class;
    }

    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

        $addon = '';

        if ( $color == 'custom' && version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '>=' ) ) {

            if ( $include_bg != 'true' ) {
                $bg = 'transparent';
            }

            if ( $include_border != 'true' ) {
               $border = 'transparent';
            }

            $addon = sprintf( 'style="background-color: %1$s; border-color: %2$s; color: %3$s;" data-bg="%1$s" data-bg-hover="%4$s" data-text="%3$s" data-text-hover="%5$s"', $bg, $border, $text, $bg_hover, $text_hover );
        }

        if ( $block == 'true' ) {
            $block = true;
        } else {
            $block = false;
        }

        $output = themeblvd_button( $content, $link, $color, $target, $size, $final_class, $title, $icon_before, $icon_after, $addon, $block );

    } else {

        $output = themeblvd_button( $content, $link, $color, $target, $size, $final_class, $title, $icon_before, $icon_after );

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
        'style'     => 'shadow',    // Style of divider - dashed, shadow, solid, double-solid, double-dashed
        'width'     => '',          // A width for the divider in pixels
        'placement' => 'equal'      // Where the divider sits between the content - equal, above (closer to content above), below (closer to content below)
    );
    $atts = shortcode_atts( $default, $atts );

    if ( function_exists('themeblvd_get_divider') ) {
        $atts['type'] = $atts['style'];
        $output = themeblvd_get_divider( $atts );
    } else {
        $output = themeblvd_divider( $atts['style'] );
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

        if( $atts['frame'] === 'false' && $atts['align'] != 'none' ) {
            // If image is framed, the alignment will be on the frame
            $thumb .= sprintf( ' class="align%s"', $atts['align'] );
        }

        $thumb .= ' />';
    }

    // Classes for link's anchor tag
    $anchor_classes = 'tb-thumb-link '.$atts['icon'];

    if ( $atts['frame'] === 'true' ) {
        $anchor_classes .= ' thumbnail';
    }

    if ( $atts['frame'] === 'false' && $atts['class'] ) {
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
    if( $atts['frame'] === 'true' && $has_thumb_img ) {

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
        $wrap .= '%s';

        // Caption
        if ( $atts['caption'] ) {
            $wrap .= sprintf( '<p class="wp-caption-text">%s</p>', $atts['caption'] );
        }

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
        'bg_color'      => '',      // Background hex color value
        'text_color'    => '',      // Text hex color value
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
 * @param string $output The enclosed content
 */
function themeblvd_shortcode_panel( $atts, $content = null ) {

    $defaults = array(
        'style'         => 'default',   // Style of panel - primary, success, info, warning, danger
        'title'         => '',          // Header for panel
        'footer'        => '',          // Footer for panel
        'text_align'    => 'left',      // How to align text - left, right, center
        'align'         => '',          // How to align panel - left, right
        'max_width'     => '',          // Meant to be used with align left/right - 300px, 50%, etc
        'class'         => '',          // Any additional CSS classes
        'wpautop'       => 'true'       // Whether to apply wpautop on content
    );
    $atts = shortcode_atts( $defaults, $atts );

    // WP auto?
    if ( $atts['wpautop'] == 'true' ) {
        $content = wpautop( $content );
    }

    if ( function_exists('themeblvd_get_panel') ) { // framework 2.5+

        $output = themeblvd_get_panel( $atts, $content );

    } else {

        // CSS classes
        $class = sprintf( 'panel panel-%s text-%s', $atts['style'], $atts['text_align'] );

        if ( $atts['class'] ) {
            $class .= ' '.$atts['class'];
        }

        // Construct panel
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
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content Content in shortcode
 * @param string $output The enclosed content
 */
function themeblvd_shortcode_testimonial( $atts, $content = null ) {

    // This shortcode requires Theme Blvd Framework 2.5+
    if ( ! function_exists('themeblvd_get_team_member') ) {
        return __( 'Your theme does not support the [testimonial] shortcode. You must be using a theme with Theme Blvd Framework 2.5+', 'themeblvd_shortcodes' );
    }

    $defaults = array(
        'text'          => '',      // Text for testimonial
        'name'          => '',      // Name of person giving testimonial
        'tagline'       => '',      // Tagline or position of person giving testimonial
        'company'       => '',      // Company of person giving testimonial
        'company_url'   => '',      // Company URL of person giving testimonial
        'image'         => array()  // Image of person giving testimonial
    );
    $atts = shortcode_atts( $defaults, $atts );

    // Re-format image
    $image = $atts['image'];

    $atts['image'] = array();

    if ( $image ) {
        $atts['image']['src'] = $image;
        $atts['image']['title'] = $atts['name'];
    }

    // Content
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
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content Content in shortcode
 * @param string $output The enclosed content
 */
function themeblvd_shortcode_pricing_table( $atts, $content = null ) {

    // This shortcode requires Theme Blvd Framework 2.5+
    if ( ! function_exists('themeblvd_get_pricing_table') ) {
        return __( 'Your theme does not support the [pricing_table] shortcode. You must be using a theme with Theme Blvd Framework 2.5+', 'themeblvd_shortcodes' );
    }

    $defaults = array(
        'currency'              => '$',         // Symbol to represent currency
        'currency_placement'    => 'before'     // Whether to place the currency symbol before or after prices
    );
    $atts = shortcode_atts( $defaults, $atts );

    $cols = array();
    $pattern = str_replace( 'pricing_table', 'pricing_table|pricing_column', get_shortcode_regex() );

    if ( preg_match_all( '/'. $pattern .'/s', $content, $m ) ) {

        if ( ! empty( $m[0] ) ) {
            foreach ( $m[0] as $key => $val ) {
                $cols[$key] = shortcode_parse_atts( $m[3][$key] );
                $cols[$key]['features'] = trim( $m[5][$key] );

                if ( ! empty( $cols[$key]['button_text'] ) ) {
                    $cols[$key]['button'] = true;
                }
            }
        }


    }

    return themeblvd_get_pricing_table( $cols, $atts );
}

/**
 * Build data for the column of a pricing table to
 * pass back to [pricing_table] shortcode.
 *
 * @since 1.5.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content Content in shortcode
 * @param string $output The enclosed content
 */
function themeblvd_shortcode_pricing_columns( $m ) {

    $cols = array();

    // echo '<pre>'; print_r($m); echo '</pre>';




    $atts = shortcode_parse_atts( $m[3] );

    echo '<pre>'; print_r($atts); echo '</pre>';


    // $features = $m[5];

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

/**
 * Lead text (from Bootstrap)
 *
 * @since 1.5.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 */
function themeblvd_shortcode_lead( $atts, $content = null ) {

    $default = array(
        'size'      => 0   // Optional font size, 20px, 1.5em, etc.
    );
    extract( shortcode_atts( $default, $atts ) );

    $output = '<p class="lead"';

    if ( $size ) {
        $output .= sprintf( ' style="font-size: %s"', $size );
    }

    $output .= '>';
    $output .= $content;
    $output .= '</p>';

    return $output;

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

    $output = '';

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

    // Verify style
    if ( $style != 'framed' && $style != 'open' ) {
        $style = 'framed';
    }

    // For those using old method for tabs
    if ( in_array( $nav, array( 'tabs_above', 'tabs_above', 'tabs_right', 'tabs_left' ) ) ) {
        $nav = 'tabs';
    } else if ( in_array( $nav, array( 'pills_above', 'pills_above' ) ) ) {
        $nav = 'pills';
    }

    // Verify tabs
    if ( $nav != 'tabs' && $nav != 'pills' ) {
        $nav = 'tabs';
    }

    // Height
    if ( $height == 'true' ) {
        $height = 1;
    } else {
        $height = 0;
    }

    $id = uniqid( 'tabs_'.rand() );
    $num = count( $atts ) - 1;
	$i = 1;
    $tabs = array();
    $names = array();

    // Setup options
    if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '>=' ) ) {
        $options = array(
            'nav'     => $nav,
    		'style'   => $style,
    		'height'  => $height,
            'tabs'    => array()
        );
    } else {
        $options = array(
            'setup' => array(
                'num'   => $num,
                'style' => $style,
                'nav'   => $nav,
                'names' => array()
            ),
            'height'  => $height,
        );
    }

    if( is_array( $atts ) && count( $atts ) > 0 ) {
        foreach( $atts as $key => $tab ) {
            $names['tab_'.$i] = $tab; // for theme framework prior to v2.5
            $tab_content = explode( '[/'.$key.']', $content );
            $tab_content = explode( '['.$key.']', $tab_content[0] );
            $tabs['tab_'.$i] = array(
                'title' => $tab,
                'type'  => 'raw', // for theme framework prior to v2.5
                'raw'   => $tab_content[1], // for theme framework prior to v2.5
                'content' => array(
                    'type' => 'raw',
                    'raw' => $tab_content[1],
                    'raw_format' => 1
                )
            );
            $i++;
        }
    } else {
        $output .= '<p class="tb-warning">'.__( 'No tabs found', 'themeblvd_shortcodes' ).'</p>';
    }

    if ( ! $output ) {

        if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '>=' ) ) {

             $options['tabs'] = $tabs;
             $output .= themeblvd_get_tabs( $id, $options );

        } else {

            $options['setup']['names'] = $names;
            foreach ( $tabs as $tab_id => $tab ) {
                $options[$tab_id] = $tab;
            }

            $output .= '<div class="element element-tabs'.themeblvd_get_classes( 'element_tabs', true ).'">';
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

    if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '>=' ) ) {

        $args = array(
            'title'     => $title,
            'open'      => $open,
            'content'   => $content,
            'last'      => isset($atts[0]) ? true : false
        );

        $output = themeblvd_get_toggle( $args );

    } else if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

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
 * Post Slider
 *
 * @since 1.5.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 */
function themeblvd_shortcode_post_slider( $atts ) {

    $default = array(
        'style'             => '1',             // Display style - 1, 2, 3
        'interval'          => '0',             // Time between auto trasitions in seconds
        'nav_standard'      => 'true',          // Show standard nav - true, false
        'nav_arrows'        => 'true',          // Show nav arrows - true, false
        'nav_thumbs'        => 'false',         // Show nav thumbnails - true, false
        'pause'             => 'false',         // Pause on hover - true, false
        'crop'              => 'slider-large',  // Crop size for full-size images
        'slide_link'        => 'button',        // Where image link goes - none, image_post, image_link, button
        'button_text'       => 'View Post',     // Text for button (if button)
        'button_size'       => 'default',       // Size of button (if button) - mini, small, default, large, x-large
        'tag'               => '',              // Tag(s) to include/exclude
        'category'          => '',              // Category slug(s) to include
        'cat'               => '',              // Category ID(s) to include/exclude
        'portfolio'         => '',              // Portfolio(s) slugs to include, requires Portfolios plugin
        'portfolio_tag'     => '',              // Portfolio Tag(s) to include, requires Portfolios plugin
        'numberposts'       => '5',             // Number of posts/slides
        'orderby'           => 'date',          // Orderby param for posts query
        'order'             => 'DESC',          // Order param for posts query
        'query'             => '',              // Custom query string
        'thumb_link'        => 'true',          // Whether linked images have animation
        'dark_text'         => 'false',         // Whether to use dark text
        'title'             => 'true',          // Whether to show titles
        'meta'              => 'true',          // Whether to shoe meta
        'excerpts'          => 'false'          // Whether to show excerpts
    );
    $atts = shortcode_atts( $default, $atts );

    // display style
    if ( intval($atts['style']) ) {
        $atts['style'] = 'style-'.$atts['style'];
    }

    // Provide compat with some older options
    if ( ! empty($atts['timeout']) ) {
        $atts['interval'] = $atts['timeout'];
    }

    if ( ! empty($atts['pause_on_hover']) ) {
        if ( $atts['pause_on_hover'] == 'pause_on' || $atts['pause_on_hover'] == 'pause_on_off' ) {
            $atts['pause'] = 'true';
        }
    }

    if ( ! empty($atts['image_size']) ) {
        $atts['crop'] = $atts['image_size'];
    }

    if ( ! empty($atts['button']) ) {
        $atts['button_text'] = $atts['button'];
    }

    // Handle booleans
    foreach ( $atts as $key => $value ) {
        if ( $value === 'true' ) {
            $atts[$key] = true;
        } else if ( $value === 'false' ) {
            $atts[$key] = false;
        }
    }

    // Handle any query-related atts
    if ( $atts['category'] ) {
        $atts['category_name'] = $atts['category'];
    }

    $atts['posts_per_page'] = $atts['numberposts'];

    return themeblvd_get_post_slider($atts);
}

/**
 * Post Grid Slider
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 */
function themeblvd_shortcode_post_grid_slider( $atts ) {

    $default = array(
        // query params
        'cat'           => '',          // cat: Category ID(s) to include/exclude
        'category_name' => '',          // category_name: Category slug(s) to include/exclude
        'tag'           => '',          // tag: Tag(s) to include/exclude
        'portfolio'     => '',          // portfolio: Portfolio(s) slugs to include, requires Portfolios plugin
        'portfolio_tag' => '',          // portfolio_tag: Portfolio Tag(s) to include, requires Portfolios plugin
        'columns' 		=> '3',			// columns: Number of posts per row
        'orderby' 		=> 'date',		// orderby: date, title, comment_count, rand
        'order' 		=> 'DESC',		// order: DESC, ASC
        'offset' 		=> 0,			// offset: Number of posts to offset off the start, defaults to 0
        'query'         => '',          // query: custom query string

        // slider stuff
        'slides'        => '3',         // slides: number of slides
        'timeout'       => 0,           // timeout: Seconds in between transitions, 0 for no auto-advancing
        'nav'           => 'true',      // Whether to show nav

        // post grid display
        'thumbs'        => '',          // thumbs: show, hide
        'meta'          => '',          // meta: show, hide
        'excerpt'       => '',          // excerpt: show, hide
        'more'          => '',          // more: hide, text, button
        'crop'			=> 'tb_grid',	// crop: Can manually enter a featured image crop size

        // @deprecated
        'fx'            => 'slide',     // fx: Transition of slider - fade, slide
        'nav_standard'  => 1,           // nav_standard: Show standard nav dots to control slider - true or false
        'nav_arrows'    => 1,           // nav_arrows: Show directional arrows to control slider - true or false
        'pause_play'    => 1,           // pause_play: Show pause/play button - true or false
        'categories'    => '',          // @deprecated -- Category slug(s) to include/exclude
        'rows'          => 3,            // rows: Number of rows per slide
        'numberposts'   => '-1',        // numberposts: Total number of posts, -1 for all posts
    );
    $atts = shortcode_atts( $default, $atts );

    // Generate unique ID
	$id = uniqid( 'grid_'.rand() );

    // Slider display
    $atts['display'] = 'slider';
    $atts['context'] = 'grid';
    $atts['shortcode'] = true;

    // bool
    if ( $atts['nav'] === 'true' ) {
        $atts['nav'] = 1;
    } else {
        $atts['nav'] = 0;
    }

    if ( function_exists('themeblvd_loop') ) {

        ob_start();
        themeblvd_loop($atts);
        $output = ob_get_clean();

    } else {

        if ( $atts['nav_standard'] === 'true' ) {
            $atts['nav_standard'] = 1;
        } else if ( $atts['nav_standard'] === 'false' ) {
            $atts['nav_standard'] = 0;
        }

        if ( $atts['nav_arrows'] === 'true' ) {
            $atts['nav_arrows'] = 1;
        } else if ( $atts['nav_arrows'] === 'false' ) {
            $atts['nav_arrows'] = 0;
        }

        if ( $atts['pause_play'] === 'true' ) {
            $atts['pause_play'] = 1;
        } else if ( $atts['pause_play'] === 'false' ) {
            $atts['pause_play'] = 0;
        }

    	// Output
    	ob_start();
    	echo '<div class="element element-post_grid_slider'.themeblvd_get_classes( 'element_post_grid_slider', true ).'">';
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
 * @param array $atts Standard WordPress shortcode attributes
 */
function themeblvd_shortcode_post_list_slider( $atts ) {

    if ( version_compare(TB_FRAMEWORK_VERSION, '2.5.0', '>=') ) {
        $msg = 'The [<span>post_list_slider</span>] shortcode is no longer supported in your theme. Use [<span>post_slider</span>] or [<span>post_grid_slider</span>] instead.';
        return '<p>[post_list_slider]</p>'.themeblvd_get_alert( array('style' => 'warning', 'content' => $msg) );
    }

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
        'title'         => 'false',             // Whether to show titles
        'caption'       => 'false',             // Whether to show captions
        'size'          => 'slider-large',      // Crop size for images
        'interval'      => '5000',              // Milliseconds between transitions
        'pause'         => 'true',              // Whether to pause on hover
        'wrap'          => 'true',              // Whether sliders continues auto rotate after first pass
        'nav_standard'  => 'false',             // Whether to show standard nav indicator dots
        'nav_arrows'    => 'true',              // Whether to show standard nav arrows
        'nav_thumbs'    => 'true',              // Whether to show nav thumbnails (added by Theme Blvd framework)
        'thumb_size'    => 'smallest',          // Size of nav thumbnail images - small, smaller, smallest or custom int
        'dark_text'     => 'false',             // Whether to use dark text for title/descriptions/standard nav, use when images are light
        'frame'         => 'false'              // Whether to wrap gallery slider in frame
    );
    $atts = shortcode_atts( $default, $atts );

    // Setup [gallery]
    $gallery = sprintf( '[gallery ids="%s"]', $atts['ids'] );

    // Remove ID's from $atts
    unset( $atts['ids'] );

    // Backup for those using old square_* crop sizes
    if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '>=' ) ) {
        $atts['thumb_size'] = str_replace( 'square_', '', $atts['thumb_size'] );
    }

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
 * Post Grid and Post Showcase
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 */
function themeblvd_shortcode_post_grid( $atts, $content = null, $tag = '' ) {

    $default = array(

        // shared between both shortcodes
        'categories'    => '',                  // @deprecated -- Category slug(s) to include/exclude
        'cat'           => '',                  // cat: Category ID(s) to include/exclude
        'category_name' => '',                  // category_name: Category slug(s) to include/exclude
        'tag'           => '',                  // tag: Tag(s) to include/exclude
        'portfolio'     => '',                  // portfolio: Portfolio(s) slugs to include, requires Portfolios plugin
        'portfolio_tag' => '',                  // portfolio_tag: Portfolio Tag(s) to include, requires Portfolios plugin
        'columns' 		=> '3',					// columns: Number of posts per row
        'rows' 			=> '3',					// rows: Number of rows per slide
        'orderby' 		=> 'date',				// orderby: date, title, comment_count, rand
        'order' 		=> 'DESC',				// order: DESC, ASC
        'offset' 		=> '0',					// offset: Number of posts to offset off the start, defaults to 0
        'query' 		=> '',					// query: custom query string
        'filter'        => 'false',             // filter: Whether to use filtering - false or taxonomy name to filter by
        'filter_max'    => '-1',                // filter_max: Maximum posts to pull when using filtering
        'masonry'       => 'false',             // masonry: Whether to use masonry or not
        'masonry_max'   => '12',                // masonry_max: Number of posts if using masonry
        'excerpt'       => '',                  // excerpt: show, hide
        'crop'          => '',                  // crop: Can manually enter a featured image crop size

        // [post_grid]
        'thumbs'        => '',                  // thumbs: show, hide
        'meta'          => '',                  // meta: show, hide
        'more'          => '',                  // more: hide, text, button

        // [post_showcase]
        'titles'        => ''                   // titles: Whether to show post titles when items are hovered on
    );
    $atts = shortcode_atts( $default, $atts );

    // Convert booleans
    foreach( $atts as $key => $value ) {
        if ( $value === 'true' ) {
            $atts[$key] = true;
        } else if ( $value === 'false' ) {
            $atts[$key] = false;
        }
    }

    // Display and context
    if ( $tag == 'post_showcase' ) {
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
            $atts['filter_max'] = '-1'; // just to be safe
        }

    } else if ( $atts['masonry'] ) {

        $display = 'masonry';

    }

    // Allow user to use "tag" instead of "post_tag"
    if ( $atts['filter'] == 'tag' ) {
        $atts['filter'] = 'post_tag';
    }

    // Build $options array compatible to element's function
    $options = array(
        'display'       => $display,
        'columns' 		=> $atts['columns'],
        'rows' 			=> $atts['rows'],
        'tag'           => $atts['tag'],
        'portfolio'     => $atts['portfolio'],
        'portfolio_tag' => $atts['portfolio_tag'],
        'orderby' 		=> $atts['orderby'],
        'order' 		=> $atts['order'],
        'offset' 		=> $atts['offset'],
        'crop' 			=> $atts['crop'],
        'query' 		=> $atts['query'],
        'filter'        => $atts['filter'],
        'filter_max'    => $atts['filter_max'],
        'posts_per_page'=> $atts['masonry_max'],
        'thumbs'        => $atts['thumbs'],
        'meta'          => $atts['meta'],
        'excerpt'       => $atts['excerpt'],
        'titles'        => $atts['titles'],
        'more'          => $atts['more'],
        'context'       => $context,
        'shortcode'     => true,
        'class'         => "shortcode-{$context}-wrap"
    );

    // Categories
    if( $atts['cat'] ) {
        $options['cat'] = $atts['cat'] ;
    } else if( $atts['category_name'] ) {
        $options['category_name'] = $atts['category_name'] ;
    } else if( $atts['categories'] ) {
        $options['category_name'] = $atts['categories']; // @deprecated
    }

    // Thumbs
    if ( $options['thumbs'] == 'show' ) {
        $options['thumbs'] = 'full';
    }

    if ( function_exists('themeblvd_loop') ) {

        ob_start();
        themeblvd_loop($options);
        $output = ob_get_clean();

    } else {

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
    	$output = ob_get_clean();

    }

    return $output;
}

/**
 * Post List and Blog
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 */
function themeblvd_shortcode_post_list( $atts, $content = '', $tag = '' ) {

    $default = array(
        'categories' 	=> '',					// @deprecated -- Category slug(s) to include/exclude
		'cat'           => '',                  // cat: Category ID(s) to include/exclude
        'category_name' => '',                  // category_name: Category slug(s) to include/exclude
        'tag'           => '',                  // tag: Tag(s) to include/exclude
        'portfolio'     => '',                  // portfolio: Portfolio(s) slugs to include, requires Portfolios plugin
        'portfolio_tag' => '',                  // portfolio_tag: Portfolio Tag(s) to include, requires Portfolios plugin
		'numberposts' 	=> '3',					// numberposts: Total number of posts, -1 for all posts
        'orderby' 		=> 'date',				// orderby: date, title, comment_count, rand
        'order' 		=> 'DESC',				// order: DESC, ASC
        'offset' 		=> '0',					// offset: Number of posts to offset off the start, defaults to 0
        'query' 		=> '', 					// custom query string
        'filter'        => 'false',             // filter: Whether to use filtering - false or taxonomy name to filter by
        'thumbs'        => '',                  // thumbs: show, hide, or date
        'meta'          => '',                  // meta: show, hide
        'more'          => ''                   // more: hide, text, button
    );
    $atts = shortcode_atts( $default, $atts );

    if ( $tag == 'blog' ) {
        $display = $context = 'blog';
    } else {
        $display = $context = 'list';
    }

    // Convert booleans
    foreach( $atts as $key => $value ) {
        if ( $value === 'true' ) {
            $atts[$key] = true;
        } else if ( $value === 'false' ) {
            $atts[$key] = false;
        }
    }

    // Allow user to use "tag" instead of "post_tag"
    if ( $atts['filter'] == 'tag' ) {
        $atts['filter'] = 'post_tag';
    }

    // Build $options array compatible to element's function
    $options = array(
        'display'       => $display,
        'thumbs' 		=> $atts['thumbs'],
        'content' 		=> 'excerpt',
        'tag'           => $atts['tag'],
        'portfolio'     => $atts['portfolio'],
        'portfolio_tag' => $atts['portfolio_tag'],
        'posts_per_page'=> $atts['numberposts'],
        'orderby' 		=> $atts['orderby'],
        'order' 		=> $atts['order'],
        'offset' 		=> $atts['offset'],
        'query' 		=> $atts['query'],
        'filter'        => $atts['filter'],
        'thumbs'        => $atts['thumbs'],
        'meta'          => $atts['meta'],
        'more'          => $atts['more'],
        'context'       => $context,
        'shortcode'     => true,
        'class'         => "shortcode-{$context}-wrap"
    );

    // Categories
    if( $atts['cat'] ) {
        $options['cat'] = $atts['cat'] ;
    } else if( $atts['category_name'] ) {
        $options['category_name'] = $atts['category_name'] ;
    } else if( $atts['categories'] ) {
        $options['category_name'] = $atts['categories']; // @deprecated
    }

    // Thumbs
    if ( $options['thumbs'] == 'show' ) {
        $options['thumbs'] = 'full';
    }

    if ( function_exists('themeblvd_loop') ) {

        ob_start();
        themeblvd_loop($options);
        $output = ob_get_clean();

    } else {

        // @deprecated
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
    	$output = ob_get_clean();

    }

    return $output;
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
	$atts = shortcode_atts( $default, $atts );

    if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) {

        // Build query
        if( ! $atts['query'] ) {

            $query = '';

            // Categories
            if( $atts['categories'] ) { // @deprecated
                $query .= 'category_name='.$atts['categories'].'&';
            }

            if( $atts['cat'] ) {
                $query .= 'cat='.$atts['cat'].'&';
            }

            if( $atts['category_name'] ) {
                $query .= 'category_name='.$atts['category_name'].'&';
            }

            // Tags
            if( $atts['tag'] ) {
                $query .= 'tag='.$atts['tag'].'&';
            }

            // Continue query
            $query .= 'numberposts='.$atts['numberposts'].'&';
            $query .= 'orderby='.$atts['orderby'].'&';
            $query .= 'order='.$atts['order'].'&';
            $query .= 'offset='.$atts['offset'].'&';
            $query .= 'suppress_filters=false'; // Mainly for WPML compat

        } else {

            $query = $atts['query'];

        }
    }

    if ( $atts['gallery'] ) {
        $atts['gallery'] = sprintf( '[gallery ids="%s" link="file"]', $atts['gallery'] );
    }

    $atts['posts_per_page'] = $atts['numberposts'];

    $atts['shortcode'] = true;

	// Output
    if ( version_compare ( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) {
        // @deprecated
        $output = themeblvd_get_mini_post_grid( $query, $atts['align'], $atts['thumb'], $atts['gallery'] );
    } else {
        $output = themeblvd_get_mini_post_grid( $atts, $atts['align'], $atts['thumb'], $atts['gallery'] );
    }
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
        'thumb'         => 'smaller',   // thumbnail size - small, smaller, smallest, date, or hide
        'meta'          => 'show',      // show meta or not - show or hide
        'columns'       => '0'          // Optional number of columns to spread posts among
	);
	$atts = shortcode_atts( $default, $atts );

    if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) {

        // Build query
        if( ! $atts['query'] ) {

            $query = '';

            // Categories
            if( $atts['categories'] ) { // @deprecated
                $query .= 'category_name='.$atts['categories'] .'&';
            }

            if( $atts['cat'] ) {
                $query .= 'cat='.$atts['cat'].'&';
            }

            if( $atts['category_name'] ) {
                $query .= 'category_name='.$atts['category_name'].'&';
            }

            // Tags
            if( $atts['tag'] ) {
                $query .= 'tag='.$atts['tag'].'&';
            }

            // Continue query
            $query .= 'numberposts='.$atts['numberposts'].'&';
            $query .= 'orderby='.$atts['orderby'].'&';
            $query .= 'order='.$atts['order'].'&';
            $query .= 'offset='.$atts['offset'].'&';
            $query .= 'suppress_filters=false'; // Mainly for WPML compat

        } else {

            $query = $atts['query'];

        }
    }

    // Format thumbnail size
    if( $thumb == 'hide' ) {
        $thumb = false;
    }

    // Format meta
    $meta == 'show' ? $meta = true : $meta = false;

    // Number of posts
    $atts['posts_per_page'] = $atts['numberposts'];

    $atts['shortcode'] = true;

    // Output
    if ( version_compare ( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) {
        // @deprecated
        $output = themeblvd_get_mini_post_list( $query, $atts['thumb'], $atts['meta'] );
    } else {
        $output = themeblvd_get_mini_post_list( $atts, $atts['thumb'], $atts['meta'] );
    }

    return $output;
}

/*-----------------------------------------------------------*/
/* Stats
/*-----------------------------------------------------------*/

/**
 * Milestone
 *
 * @since 1.5.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_milestone( $atts ) {

    if ( ! function_exists('themeblvd_get_milestone') ) {
        return __('Your theme does not support the [milestone] shortcode.', 'themeblvd_shortcodes');
    }

    $default = array(
        'milestone'     => '100',       // The number for the milestone
        'color'         => '#0c9df0',   // Color of text for milestone number
        'text'          => '',          // Brief text to describe milestone
        'boxed'         => 'false'      // Whether to wrap milestone in borered box
    );
    $atts = shortcode_atts( $default, $atts );

    if ( $atts['boxed'] === 'true' ) {
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
 * @param array $atts Standard WordPress shortcode attributes
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_milestone_ring( $atts ) {

    if ( ! function_exists('themeblvd_get_milestone_ring') ) {
        return __('Your theme does not support the [milestone_ring] shortcode.', 'themeblvd_shortcodes');
    }

    $default = array(
        'percent'       => '75',        // Percentage for pie chart
        'color'         => '#0c9df0',   // Color of the milestone percentage
        'track_color'   => '#eeeeee',   // Color track containing milestone ring (currently no option in builder, may add in the future)
        'display'       => '',          // Text in the middle of the pie chart
        'title'         => '',          // Title below pie chart
        'text'          => '',          // Description below title
        'text_align'    => 'center',    // Text alignment - left, right, or center
        'boxed'         => 'false'      // Whether to wrap milestone in borered box
    );
    $atts = shortcode_atts( $default, $atts );

    if ( $atts['boxed'] === 'true' ) {
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
 * @param array $atts Standard WordPress shortcode attributes
 * @return string $output Content to output for shortcode
 */
function themeblvd_shortcode_progress_bar( $atts ) {

    $default = array(
        'color'         => '',          // default, danger, success, info, warning, or custom hex
        'percent'       => '100',       // Percent of bar - 30, 60, 80, etc.
        'striped'       => 'false',     // true, false
        'label'         => ''           // Label of what this bar represents, like "Graphic Design"
    );
    $atts = shortcode_atts( $default, $atts );


    // Bootstrap 3 and Theme Blvd framework 2.5+
    if ( function_exists( 'themeblvd_get_progress_bar' ) ) {

        $atts['value'] = $atts['percent'];
        unset($atts['percent']);

        if ( $atts['striped'] === 'true' ) {
            $atts['striped'] = '1';
        } else {
            $atts['striped'] = '0';
        }

        $atts['label_value'] = $atts['value'].'%';

        return themeblvd_get_progress_bar( $atts );
    }

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
    if( $atts['color'] ) {

        if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

            // Bootstrap 3+
            $classes .= ' progress-bar-'.$atts['color'];

        } else {

            // Bootstrap 1 & 2 (@deprecated)
            $classes .= ' progress-'.$atts['color'];
        }
    }

    // Striped?
    if( $atts['striped'] == 'true' ) {
        if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

            // Bootstrap 3+
            $wrap_classes .= ' progress-striped';

        } else {

            // Bootstrap 1 & 2 (@deprecated)
            $classes .= ' progress-striped';

        }
    }

    // Output
    if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

        // Bootstrap 3+
        $output  = '<div class="'.$wrap_classes.'">';
        $output .= '    <div class="'.$classes.'" role="progressbar" aria-valuenow="'.$atts['percent'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$atts['percent'].'%;">';
        $output .= '        <span class="sr-only">'.$atts['percent'].'%</span>';
        $output .= '    </div>';
        $output .= '</div>';

    } else {

        // Bootstrap 1 & 2 (@deprecated)
        $output  = '<div class="'.$classes.'">';
        $output .= '    <div class="bar" style="width: '.$atts['percent'].'%;"></div>';
        $output .= '</div>';

    }

    return $output;
}