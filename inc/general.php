<?php
/**
 * This file contains all general-use helper
 * functions.
 *
 * @package Theme Blvd Shortcodes
 */

/**
 * Display warning telling the user they must have a
 * theme with Theme Blvd framework v2.2+ installed in
 * order to run this plugin.
 *
 * @since 1.0.0
 */
function themeblvd_shortcodes_warning() {

	global $current_user;

	if ( ! get_user_meta( $current_user->ID, 'tb-nag-shortcodes-no-framework' ) ) {

		echo '<div class="updated">';
		echo '<p><strong>Theme Blvd Shortcodes: </strong>' . esc_html__( 'You are not using a theme with the Theme Blvd Framework v2.2+, and so this plugin will not do anything.', 'theme-blvd-shortcodes' ) . '</p>';
		echo '<p><a href="' . esc_url( themeblvd_shortcodes_disable_url( 'shortcodes-no-framework' ) ) . '">' . esc_html__( 'Dismiss this notice', 'theme-blvd-shortcodes' ) . '</a> | <a href="http://www.themeblvd.com" target="_blank">' . esc_html__( 'Visit ThemeBlvd.com', 'theme-blvd-shortcodes' ) . '</a></p>';
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

	if ( ! isset( $_GET['nag-ignore'] ) ) { // WPCS: input var okay.

		return;

	}

	if ( strpos( wp_unslash( $_GET['nag-ignore'] ), 'tb-nag-' ) !== 0 ) { // WPCS: input var okay. sanitization ok.

		return;

	}

	if ( isset( $_GET['security'] ) && wp_verify_nonce( wp_unslash( $_GET['security'] ), 'themeblvd-shortcodes-nag' ) ) { // WPCS: input var okay. sanitization ok.

		add_user_meta( $current_user->ID, wp_unslash( $_GET['nag-ignore'] ), 'true', true ); // WPCS: input var okay. sanitization ok.

	}
}

/**
 * Disable admin notice URL.
 *
 * @since 1.1.0
 *
 * @param string $id ID of nag to disable.
 */
function themeblvd_shortcodes_disable_url( $id ) {

	global $pagenow;

	$url = admin_url( $pagenow );

	if ( ! empty( $_SERVER['QUERY_STRING'] ) ) { // WPCS: input var okay.

		$url .= sprintf( '?%s&nag-ignore=%s', wp_unslash( $_SERVER['QUERY_STRING'] ), 'tb-nag-' . $id ); // WPCS: input var okay. sanitization ok.

	} else {

		$url .= sprintf( '?nag-ignore=%s', 'tb-nag-' . $id );

	}

	$url .= sprintf( '&security=%s', wp_create_nonce( 'themeblvd-shortcodes-nag' ) );

	return $url;
}

/**
 * Content formatter.
 *
 * @since 1.0.0
 *
 * @param sting $content Content.
 */
function themeblvd_content_formatter( $content ) {

	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split( $pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE );

	foreach ( $pieces as $piece ) {

		if ( preg_match( $pattern_contents, $piece, $matches ) ) {

			$new_content .= $matches[1];

		} else {

			$new_content .= shortcode_unautop( wpautop( wptexturize( $piece ) ) );

		}
	}

	return $new_content;

}

/**
 * Grab image being sent to editor and transform it into
 * the [lightbox] shortcode if image is linked to Vimeo,
 * YouTube, Quicktime files, or image files.
 *
 * @since 1.1.0
 *
 * @param string $html HTML markup for image to be converted.
 * @param string $id Attachment ID of image.
 * @param string $caption Image's caption.
 * @param string $title Title of <img /> tag, should be blank as WP doesn't use any more.
 * @param string $align How to align image - none, right, left.
 * @param string $url URL being linked to in the lightbox popup.
 * @param string $size WP crop size for image.
 * @param string $alt Title of the image, which we'll put through to the title of the <a> for prettyPhoto.
 * @return string $html Modified <img /> output into [lightbox] shortcode.
 */
function themeblvd_lightbox_send_to_editor( $html, $id, $caption, $title, $align, $url, $size, $alt ) {

	if ( ! function_exists( 'themeblvd_is_lightbox_url' ) ) {

		return $html;

	}

	$atts = array();

	if ( $icon = themeblvd_is_lightbox_url( $url ) ) {

		// We can handle the caption, so we'll remove WP's filter for it.
		remove_filter( 'image_send_to_editor', 'image_add_caption', 20 );

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
			'icon'		=> $icon, 	// video or image.
		);

		$html = sprintf(
			'[lightbox link="%s" thumb="%s" width="%s" align="%s" title="%s" frame="%s" icon="%s" caption="%s"]',
			$atts['link'],
			$atts['thumb'],
			$atts['width'],
			$atts['align'],
			$atts['title'],
			$atts['frame'],
			$atts['icon'],
			$caption
		);

		// Restore admin content width.
		$content_width = $original_content_width;

	}

	/**
	 * Filter the returned output of what we've modified
	 * in the HTML being sent back to the editor.
	 *
	 * @since 1.1.0
	 *
	 * @var bool
	 * @param array $atts Attributes generated for [lightbox] shortcode.
	 */
	return apply_filters( 'themeblvd_lightbox_to_editor', $html, $atts );

}
