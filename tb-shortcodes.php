<?php
/*
Plugin Name: Theme Blvd Shortcodes
Plugin URI: 
Description: This plugin works in conjuction with the Theme Blvd framework to create shortcodes for many of the framework's internal elements.
Version: 1.0.6
Author: Jason Bobich
Author URI: http://jasonbobich.com
License: GPL2

    Copyright 2012  Jason Bobich

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/
define( 'TB_SHORTCODES_PLUGIN_VERSION', '1.0.6' );
define( 'TB_SHORTCODES_PLUGIN_DIR', dirname( __FILE__ ) ); 
define( 'TB_SHORTCODES_PLUGIN_URI', plugins_url( '' , __FILE__ ) );

/**
 * Run Shortcodes
 *
 * @since 1.0.0
 */
 
function themeblvd_shortcodes_init() {
	
	global $_themeblvd_shortcode_generator;
	global $_themeblvd_shortcode_options;

	// Check to make sure Theme Blvd Framework 2.2+ is running
	if( ! defined( 'TB_FRAMEWORK_VERSION' ) || version_compare( TB_FRAMEWORK_VERSION, '2.2.0', '<' ) ) {
		add_action( 'admin_notices', 'themeblvd_shortcodes_warning' );
		add_action( 'admin_init', 'themeblvd_shortcodes_disable_nag' );
		return;
	}
	
	if( is_admin() ) {
		
		// Add shortcode generator -- Can be disabled from WP > Settings > Writing
		if( get_option( 'themeblvd_shortcode_generator' ) != 'no' ) {
			include_once( TB_SHORTCODES_PLUGIN_DIR . '/admin/generator/class-tb-shortcode-generator.php' );
			$_themeblvd_shortcode_generator = new Theme_Blvd_Shortcode_Generator();
		}
		
		// Add shortcode options - Currently this consists of one option 
		// that allows the [raw] shortcode to be disabled added to 
		// Settings > General.
		include_once( TB_SHORTCODES_PLUGIN_DIR . '/admin/options/class-tb-shortcode-options.php' );
		$_themeblvd_shortcode_options = new Theme_Blvd_Shortcode_Options();
	
	} else {
		
		// Include shortcodes
		include_once( TB_SHORTCODES_PLUGIN_DIR . '/shortcodes/shortcodes.php' );
		
		// Raw -- Can be disabled from WP > Settings > Writing
		if( get_option( 'themeblvd_raw' ) != 'no' ) {
			
			remove_filter( 'the_content', 'wptexturize' );
			remove_filter( 'the_content', 'wpautop' );
			remove_filter( 'the_content', 'shortcode_unautop' );
			add_filter( 'the_content', 'themeblvd_content_formatter', 9 );

			remove_filter( 'themeblvd_the_content', 'wptexturize' );
			remove_filter( 'themeblvd_the_content', 'wpautop' );
			remove_filter( 'themeblvd_the_content', 'shortcode_unautop' );
			add_filter( 'themeblvd_the_content', 'themeblvd_content_formatter', 9 ); // Framework uses themeblvd_the_content in some areas so plugins filtering the_content do not effect.
		
		}
		
		// Columns
		add_shortcode( 'one_sixth', 'themeblvd_shortcode_column' ); 		// 1/6
		add_shortcode( 'one-sixth', 'themeblvd_shortcode_column' );			// 1/6 (depricated)
		add_shortcode( 'one_fourth', 'themeblvd_shortcode_column' ); 		// 1/4
		add_shortcode( 'one-fourth', 'themeblvd_shortcode_column' );		// 1/4 (depricated)
		add_shortcode( 'one_third', 'themeblvd_shortcode_column' );			// 1/3
		add_shortcode( 'one-third', 'themeblvd_shortcode_column' );			// 1/3 (depricated)
		add_shortcode( 'one_half', 'themeblvd_shortcode_column' );			// 1/2
		add_shortcode( 'one-half', 'themeblvd_shortcode_column' );			// 1/2 (depricated)
		add_shortcode( 'two_third', 'themeblvd_shortcode_column' );			// 2/3
		add_shortcode( 'two-third', 'themeblvd_shortcode_column' );			// 2/3 (depricated)
		add_shortcode( 'three_fourth', 'themeblvd_shortcode_column' );		// 3/4
		add_shortcode( 'three-fourth', 'themeblvd_shortcode_column' );		// 3/4 (depricated)
		add_shortcode( 'one_fifth', 'themeblvd_shortcode_column' );			// 1/5
		add_shortcode( 'one-fifth', 'themeblvd_shortcode_column' );			// 1/5 (depricated)
		add_shortcode( 'two_fifth', 'themeblvd_shortcode_column' );			// 2/5
		add_shortcode( 'two-fifth', 'themeblvd_shortcode_column' );			// 2/5 (depricated)
		add_shortcode( 'three_fifth', 'themeblvd_shortcode_column' );		// 3/5
		add_shortcode( 'three-fifth', 'themeblvd_shortcode_column' );		// 3/5 (depricated)
		add_shortcode( 'four_fifth', 'themeblvd_shortcode_column' );		// 4/5
		add_shortcode( 'four-fifth', 'themeblvd_shortcode_column' );		// 4/5 (depricated)
		add_shortcode( 'three_tenth', 'themeblvd_shortcode_column' );		// 3/10
		add_shortcode( 'three-tenth', 'themeblvd_shortcode_column' );		// 3/10 (depricated)
		add_shortcode( 'seven_tenth', 'themeblvd_shortcode_column' );		// 7/10
		add_shortcode( 'seven-tenth', 'themeblvd_shortcode_column' );		// 7/10 (depricated)
		add_shortcode( 'clear', 'themeblvd_shortcode_clear' );				// Clear row
		
		// Components
		add_shortcode( 'icon_list', 'themeblvd_shortcode_icon_list' );
		add_shortcode( 'button', 'themeblvd_shortcode_button' );
		add_shortcode( 'box', 'themeblvd_shortcode_box' );
		add_shortcode( 'alert', 'themeblvd_shortcode_alert' );
		add_shortcode( 'divider', 'themeblvd_shortcode_divider' );
		add_shortcode( 'progress_bar', 'themeblvd_shortcode_progress_bar' );
		add_shortcode( 'popup', 'themeblvd_shortcode_popup' );
		
		// Inline Elements
		add_shortcode( 'icon', 'themeblvd_shortcode_icon' );
		add_shortcode( 'icon_link', 'themeblvd_shortcode_icon_link' );
		add_shortcode( 'highlight', 'themeblvd_shortcode_highlight' );
		add_shortcode( 'dropcap', 'themeblvd_shortcode_dropcap' );
		add_shortcode( 'label', 'themeblvd_shortcode_label' );
		add_shortcode( 'vector_icon', 'themeblvd_shortcode_vector_icon' );
		
		// Tabs, Toggles, and Accordion
		add_shortcode( 'tabs', 'themeblvd_shortcode_tabs' );
		add_shortcode( 'accordion', 'themeblvd_shortcode_accordion' );
		add_shortcode( 'toggle', 'themeblvd_shortcode_toggle' );
		
		// Sliders
		add_shortcode( 'post_grid_slider', 'themeblvd_shortcode_post_grid_slider' );
		add_shortcode( 'post_list_slider', 'themeblvd_shortcode_post_list_slider' );
		
		// Display Posts
		add_shortcode( 'post_grid', 'themeblvd_shortcode_post_grid' );
		add_shortcode( 'post_list', 'themeblvd_shortcode_post_list' );
		add_shortcode( 'mini_post_grid', 'themeblvd_shortcode_mini_post_grid' );
		add_shortcode( 'mini_post_list', 'themeblvd_shortcode_mini_post_list' );
		
	}
	
}
add_action( 'after_setup_theme', 'themeblvd_shortcodes_init' );

/**
 * Register text domain for localization.
 *
 * @since 1.0.0
 */

function themeblvd_shortcodes_textdomain() {
	load_plugin_textdomain( 'themeblvd_shortcodes', false, TB_SHORTCODES_PLUGIN_DIR . '/lang' );
}
add_action( 'plugins_loaded', 'themeblvd_shortcodes_textdomain' );

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
		echo '<p><a href="?tb_nag_ignore=tb_shortcode_no_framework">'.__('Dismiss this notice', 'themeblvd').'</a> | <a href="http://www.themeblvd.com" target="_blank">Visit ThemeBlvd.com</a></p>';
		echo '</div>';
	}
}

/**
 * Dismiss an admin notice.
 *
 * An admin notice could be setup something like this:
 *
 * function my_admin_notice(){
 *		global $current_user;
 * 		if( ! get_user_meta( $current_user->ID, 'example_message' ) ){
 * 			echo '<div class="updated">';
 *			echo '<p>Some message to the user.</p>';
 * 			echo '<p><a href="?tb_nag_ignore=example_message">Dismiss this notice</a></p>';
 *			echo '</div>';
 * 		}
 * }
 * add_action( 'admin_notices', 'my_admin_notice' );
 *
 * @since 1.0.6
 */

function themeblvd_shortcodes_disable_nag() {
	global $current_user;
    if ( isset( $_GET['tb_nag_ignore'] ) )
         add_user_meta( $current_user->ID, $_GET['tb_nag_ignore'], 'true', true );
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