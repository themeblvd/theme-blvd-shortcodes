<?php
/**
 * Display warning telling the user they must have a
 * theme with Theme Blvd framework v2.2+ installed in
 * order to run this plugin.
 *
 * @since 1.0.0
 */
function themeblvd_shortcodes_warning() {
	global $current_user;
	// DEBUG: delete_user_meta( $current_user->ID, 'tb_shortcode_no_framework' )
	if( ! get_user_meta( $current_user->ID, 'tb_shortcode_no_framework' ) ){
		echo '<div class="updated">';
		echo '<p>'.__( 'You currently have the "Theme Blvd Shortcodes" plugin activated, however you are not using a theme with Theme Blvd Framework v2.2+, and so this plugin will not do anything.', 'themeblvd_shortcodes' ).'</p>';
		echo '<p><a href="'.themeblvd_shortcodes_disable_url('tb_shortcode_no_framework').'">'.__('Dismiss this notice', 'themeblvd_shortcodes').'</a> | <a href="http://www.themeblvd.com" target="_blank">'.__('Visit ThemeBlvd.com', 'themeblvd_shortcodes').'</a></p>';
		echo '</div>';
	}
}

/**
 * Dismiss an admin notice.
 *
 * @since 1.0.6
 */
function themeblvd_shortcodes_disable_nag() {
	global $current_user;
    if ( isset( $_GET['tb_nag_ignore'] ) )
         add_user_meta( $current_user->ID, $_GET['tb_nag_ignore'], 'true', true );
}

/**
 * Disable admin notice URL.
 *
 * @since 1.0.7
 */
function themeblvd_shortcodes_disable_url( $id ) {

	global $pagenow;

	$url = admin_url( $pagenow );

	if( ! empty( $_SERVER['QUERY_STRING'] ) )
		$url .= sprintf( '?%s&tb_nag_ignore=%s', $_SERVER['QUERY_STRING'], $id );
	else
		$url .= sprintf( '?tb_nag_ignore=%s', $id );

	return $url;
}

/**
 * Content formatter.
 *
 * @since 1.0.0
 *
 * @param sting $content Content
 */
function themeblvd_content_formatter( $content ) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split( $pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE );
	foreach( $pieces as $piece ) {
		if( preg_match( $pattern_contents, $piece, $matches ) )
			$new_content .= $matches[1];
		else
			$new_content .= shortcode_unautop( wpautop( wptexturize( $piece ) ) );
	}
	return $new_content;
}

/**
 * Grab image being sent to editor and transform it into
 * the [lightbox] shortcode if image is linked to Vimeo,
 * YouTube, Quicktime files, or image files.
 *
 * @since 1.0.7
 *
 * @param string $html HTML markup for image to be converted
 * @param string $id Attachment ID of image
 * @param string $caption Image's caption, get out of here if this exists
 * @param string $title Title of <img /> tag, should be blank as WP doesn't use any more
 * @param string $align How to align image - none, right, left
 * @param string $url URL being linked to in the lightbox popup
 * @param string $size WP crop size for image
 * @param string $alt Title of the image, which we'll put through to the title of the <a> for prettyPhoto
 * @return string $html Modified <img /> output into [lightbox] shortcode
 */
function themeblvd_lightbox_send_to_editor( $html, $id, $caption, $title, $align, $url, $size, $alt ){
	if( ! $caption && $icon = themeblvd_prettyphoto_supported_link( $url ) ) {

		global $content_width;
		$original_content_width = $content_width;
		$content_width = 0;

		list( $img_src, $width, $height ) = image_downsize( $id, $size );

		$atts = array(
			'link'		=> $url,
			'thumb'		=> $img_src,
			'width'		=> $width,
			'align'		=> $align,
			'title'		=> $alt,
			'frame'		=> 'true',
			'icon'		=> $icon 	// video or image
		);
		$html = sprintf('[lightbox link="%s" thumb="%s" width="%s" align="%s" title="%s" frame="%s" icon="%s"]', $atts['link'], $atts['thumb'], $atts['width'], $atts['align'], $atts['title'], $atts['frame'], $atts['icon']);

		// Restore admin content width
		$content_width = $original_content_width;
	}

	return apply_filters( 'themeblvd_lightbox_to_editor', $html, $atts );
}

if( ! function_exists( 'themeblvd_prettyphoto_supported_link' ) ) :
/**
 * Determine if prettyPhoto can take the current URL and
 * display in the lightbox.
 * (Pluggable because also added to Theme Blvd framework)
 *
 * @since 1.0.7
 *
 * @param string $url URL string to check
 * @return string $icon Type of URL (video or image) or blank if URL not supported
 */
function themeblvd_prettyphoto_supported_link( $url ) {

	$icon = '';

	if( $url ) {

		// Link to Vimeo or YouTube page?
		if( strpos( $url, 'vimeo.com' ) !== false ||
			strpos( $url, 'youtube.com' ) !== false ||
			strpos( $url, 'youtu.be' ) !== false )
		$icon = 'video';

		if( ! $icon ) {
			$parsed_url = parse_url( $url );
			$type = wp_check_filetype( $parsed_url['path'] );
			// Link to .mov file?
			if( $type['ext'] == 'mov' )
				$icon = 'video';
			// Link to image file?
			if( substr( $type['type'], 0, 5 ) == 'image' )
				$icon = 'image';
		}
	}

	return apply_filters( 'themeblvd_prettyphoto_supported_link', $icon, $url );
}
endif;