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
 *		- box				=> @since 1.0.0
 *		- alert				=> @since 1.0.0
 *		- icon_list			=> @since 1.0.0
 *		- divider			=> @since 1.0.0
 * 		- progess_bar		=> @since 1.0.0
 *		- popup				=> @since 1.0.0
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
	if( 'one_sixth' == $tag || 'one-sixth' == $tag )
		$class .= 'grid_2';
	else if( 'one_fourth' == $tag || 'one-fourth' == $tag )
		$class .= 'grid_3';
	else if( 'one_third' == $tag || 'one-third' == $tag )
		$class .= 'grid_4';
	else if( 'one_half' == $tag || 'one-half' == $tag )
		$class .= 'grid_6';
	else if( 'two_third' == $tag || 'two-third' == $tag )
		$class .= 'grid_8';
	else if( 'three_fourth' == $tag || 'three-fourth' == $tag )
		$class .= 'grid_9';
	else if( 'one_fifth' == $tag || 'one-fifth' == $tag )
		$class .= 'grid_fifth_1';
	else if( 'two_fifth' == $tag || 'two-fifth' == $tag )
		$class .= 'grid_fifth_2';
	else if( 'three_fifth' == $tag || 'three-fifth' == $tag )
		$class .= 'grid_fifth_3';
	else if( 'four_fifth' == $tag || 'four-fifth' == $tag )
		$class .= 'grid_fifth_4';
	else if( 'three_tenth' == $tag || 'three-tenth' == $tag )
		$class .= 'grid_tenth_3';
	else if( 'seven_tenth' == $tag || 'seven-tenth' == $tag )
		$class .= 'grid_tenth_7';
	
    // Force wpautop in shortcode? (not relevant if columns not wrapped in [raw])
    if( isset( $atts['wpautop'] ) && trim( $atts['wpautop'] ) == 'true')
        $content = wpautop( $content );

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
    if( $color )
    	$color_css = ' style="color:'.$color.';"';
    
    // Add in fontawesome icon
    $content = str_replace('<ul>', '<ul class="tb-icon-list">', $content );
    $content = str_replace('<li>', '<li><i class="icon-'.$icon.'"'.$color_css.'></i> ', $content );
    
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
        'icon_after' 	=> ''
    );
    extract( shortcode_atts( $default, $atts ) );
    $output = themeblvd_button( $content, $link, $color, $target, $size, $class, $title, $icon_before, $icon_after );
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
    $classes = 'info-box info-box-'.$style;	    
    // Add icon
    if( $icon ) {
    	$classes .= ' info-box-has-icon';
    	$content = '<i class="icon icon-'.$icon.'"></i>'.$content;
    }
    $output = '<div class="'.$classes.'">'.apply_filters('themeblvd_the_content', $content).'</div>';
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
	$output = '';
	$classes = 'alert';
	$default = array(
        'style' => 'blue', // info, success, danger, 'message'
        'close' => 'false' // true, false
    );
    extract( shortcode_atts( $default, $atts ) );
    // CSS classes
    if( in_array( $style, array( 'info', 'success', 'danger', 'message' ) ) )
    	$classes .= ' alert-'.$style;
    if( $close == 'true' ) 
    	$classes .= ' fade in';
    // Start output
    $output = '<div class="'.$classes.'">';
    // Add a close button?
    if( $close == 'true' )
    	$output .= '<button type="button" class="close" data-dismiss="alert">×</button>';
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
    
    $classes = 'progress';
    
    // Color
    if( $color && $color != 'default' )
    	$classes .= ' progress-'.$color;
    
    // Striped?
    if( $striped == 'true' )
    	$classes .= ' progress-striped';
    
    // Animated?
    if( $animate == 'true' )
    	$classes .= ' active';
    
    // Output
    $output = '<div class="'.$classes.'"><div class="bar" style="width: '.$percent.'%;"></div></div>';
    
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
		'color' 		=> '', 			// Color of button, only applies if button style is selected
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
    if( $title )
    	$title = $text;
    $link = themeblvd_button( $text, '#'.$popup_id, $color, null, $size, null, $title, $icon_before, $icon_after, 'data-toggle="modal"' );
	$link = apply_filters('themeblvd_the_content', $link);
    
    // Classes for popup
    $classes = 'modal hide';
    if( $animate == 'true' )
    	$classes .= ' fade';
    
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
    $output .= '<div class="'.$classes.'" id="'.$popup_id.'">';
    $output .= $header_html;
    $output .= '<div class="modal-body">';
    $output .= apply_filters('themeblvd_the_content', $content);
    $output .= '</div><!-- .modal-body (end) -->';
    $output .= '<div class="modal-footer">';
    $output .= '<a href="#" class="btn" data-dismiss="modal">'.themeblvd_get_local('close').'</a>';
    $output .= '</div><!-- .modal-footer (end) -->';
    $output .= '</div><!-- .modal (end) -->';
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
    $image_url = get_template_directory_uri().'/framework/frontend/assets/images/shortcodes/icons/'.$image.'.png';
    if( file_exists( get_stylesheet_directory().'/icons/'.$image.'.png' ) )
    	$image_url = get_stylesheet_directory_uri().'/icons/'.$image.'.png';
    
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
        'icon' 		=> '', // alert, approved, camera, cart, doc, download, media, note, notice, quote, warning
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
    
    if( ! $title ) $title = $content;
    if( $class ) $class = ' '.$class;
    $output  = '<span class="tb-icon-link'.$class.'">'; // Can't use class starting in "icon-" or it will conflict with Bootstrap
    $output .= '<i class="icon-'.$icon.'"></i>';
    $output .= '<a href="'.$link.'" title="'.$title.'" class="icon-link-'.$icon.'" target="'.$target.'">'.$content.'</a>';
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
        'style' => '', // default, success, warning, important, info, inverse
        'icon'	=> ''
    );
    extract( shortcode_atts( $default, $atts ) );
   	$class = 'label'; 
    if( $style && $style != 'default' )
    	$class .= ' label-'.$style;
    if( $icon )
    	$content = '<i class="icon-'.$icon.'"></i> '.$content;
    return '<span class="'.$class.'">'.do_shortcode($content).'</span><!-- .label (end) -->';
}

/**
 * Vector Icon (from Bootstrap and Font Awesome)
 * 
 * <i class="icon-{whatever}"></i>
 *
 * @since 1.0.0
 *
 * @param array $atts Standard WordPress shortcode attributes
 * @param string $content The enclosed content
 */

function themeblvd_shortcode_vector_icon( $atts ) {
   	$default = array(
        'icon' 	=> 'pencil',
        'size'	=> ''
    );
    extract( shortcode_atts( $default, $atts ) );
   	$size_style = '';
   	if( $size )
   		$size_style = ' style="font-size:'.$size.';"';
    return '<i class="icon-'.$icon.'"'.$size_style.'></i>';
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
        'nav'			=> 'tabs_above',	// tabs_above, tabs_right, tabs_below, tabs_left, pills_above, pills_below
        'height' 		=> '' 				// Optional fixed height for inside of tabs
    );
    extract( shortcode_atts( $default, $atts ) );
    if( isset( $atts['style'] ) ) unset( $atts['style'] );
    if( isset( $atts['nav'] ) ) unset( $atts['nav'] );
    if( isset( $atts['height'] ) ) unset( $atts['height'] );
    $id = uniqid( 'tabs_'.rand() );
    $num = count( $atts ) - 1;
	$i = 1;
	$options = array(
    	'setup' => array(
    		'num' 	=> $num,
    		'style' => $style,
    		'nav' 	=> $nav,
    		'names' => array()
    	),
    	'height' => $height
    );
    if( is_array( $atts ) && ! empty( $atts ) ) {
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
		$output = '<div class="element element-tabs'.themeblvd_get_classes( 'element_tabs', true ).'">'.themeblvd_tabs( $id, $options ).'</div><!-- .element (end) -->';
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
	return '<div id="'.$accordion_id.'" class="tb-accordion">'.do_shortcode($content).'</div>';
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
	$last = isset( $atts[0] ) ? $last = ' accordion-group-last' : null;
	$default = array(
        'title' => '',
        'open'  => 'false'
    );
	extract( shortcode_atts( $default, $atts ) );
    // Is toggle open?
    $classes = 'accordion-body collapse';
    $icon = 'icon-plus-sign';
    if( $open == 'true' ) {
        $classes .= ' in';
        $icon = 'icon-minus-sign';
    }
	// Individual toggle ID (NOT the Accordion ID)
	$toggle_id = uniqid( 'toggle_'.rand() );
	// Start output
	$output  = '<div class="accordion-group'.$last.'">';
	$output .= '<div class="accordion-heading">';               
	$output .= '<a class="accordion-toggle" data-toggle="collapse" href="#'.$toggle_id.'"><i class="'.$icon.' switch-me"></i> '.$title.'</a>';
	$output .= '</div><!-- .accordion-heading (end) -->';
	$output .= '<div id="'.$toggle_id.'" class="'.$classes.'">';
	$output .= '<div class="accordion-inner">';
	$output .= apply_filters( 'themeblvd_the_content', $content );
	$output .= '</div><!-- .accordion-inner (end) -->';
	$output .= '</div><!-- .accordion-body (end) -->';
	$output .= '</div><!-- .accordion-group (end) -->';
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
	    'categories' 	=> '',			// @deprecated -- Category slug(s) to include/exclude 
        'cat'           => '',          // cat: Category ID(s) to include/exclude
        'category_name' => '',          // category_name: Category slug(s) to include/exclude
		'tag'           => '',          // tag: Tag(s) to include/exclude
        'numberposts' 	=> 4,			// numberposts: Total number of posts, -1 for all posts         
	    'orderby' 		=> 'date',		// orderby: date, title, comment_count, rand
	    'order' 		=> 'DESC',		// order: DESC, ASC
	    'offset' 		=> 0,			// offset: Number of posts to offset off the start, defaults to 0
	    'query' 		=> '',			// custom query string
	    'thumb' 		=> 'smaller',	// thumbnail size - small, smaller, or smallest
	    'align' 		=> 'left',		// alignment of grid - left, right, or center
	    'gallery' 		=> ''			// post ID to pull gallery attachments from, only used if not blank
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
		$query .= 'offset='.$offset;
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
        'numberposts' 	=> 4,			// numberposts: Total number of posts, -1 for all posts         
	    'orderby' 		=> 'date',		// orderby: date, title, comment_count, rand
	    'order' 		=> 'DESC',		// order: DESC, ASC
	    'offset' 		=> 0,			// offset: Number of posts to offset off the start, defaults to 0
	    'query' 		=> '',			// custom query string
	    'thumb' 		=> 'smaller',	// thumbnail size - small, smaller, smallest, or hide
	    'meta' 			=> 'show'		// show meta or not - show or hide
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
        $query .= 'offset='.$offset;
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