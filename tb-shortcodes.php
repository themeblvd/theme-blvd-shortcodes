<?php
/*
Plugin Name: Theme Blvd Shortcodes
Description: This plugin works in conjuction with the Theme Blvd framework to create shortcodes for many of the framework's internal elements.
Version: 1.6.8
Author: Theme Blvd
Author URI: http://themeblvd.com
License: GPL2

    Copyright 2015  Theme Blvd

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

define( 'TB_SHORTCODES_PLUGIN_VERSION', '1.6.8' );
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

	// Include general functions.
	include_once( TB_SHORTCODES_PLUGIN_DIR . '/includes/general.php' );

	// Check to make sure Theme Blvd Framework 2.2+ is running.
	if ( ! defined( 'TB_FRAMEWORK_VERSION' ) || version_compare( TB_FRAMEWORK_VERSION, '2.2.0', '<' ) ) {

		add_action( 'admin_notices', 'themeblvd_shortcodes_warning' );
		add_action( 'admin_init', 'themeblvd_shortcodes_disable_nag' );

		return;

	}

	if ( is_admin() ) {

		// Add shortcode generator -- Can be disabled from WP > Settings > Writing.
		if ( 'no' !== get_option( 'themeblvd_shortcode_generator' ) ) {

			include_once( TB_SHORTCODES_PLUGIN_DIR . '/includes/admin/generator/class-tb-shortcode-generator.php' );

			if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) {

				include_once( TB_SHORTCODES_PLUGIN_DIR . '/includes/admin/generator/class-tb-shortcode-generator-legacy.php' );

			}

			$_themeblvd_shortcode_generator = new Theme_Blvd_Shortcode_Generator();

		}

		// Auto Lightbox -- Can be disabled from WP > Settings > Writing.
		if ( 'yes' === get_option( 'themeblvd_auto_lightbox' ) ) {

			add_filter( 'image_send_to_editor', 'themeblvd_lightbox_send_to_editor', 10, 8 );

		}

		// Add shortcode options, Settings > General.
		include_once( TB_SHORTCODES_PLUGIN_DIR . '/includes/admin/options/class-tb-shortcode-options.php' );

		$_themeblvd_shortcode_options = new Theme_Blvd_Shortcode_Options();

	}

	if ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {

		// Include shortcodes.
		include_once( TB_SHORTCODES_PLUGIN_DIR . '/includes/shortcodes.php' );
		include_once( TB_SHORTCODES_PLUGIN_DIR . '/includes/class-tb-column-shortcode.php' );
		include_once( TB_SHORTCODES_PLUGIN_DIR . '/includes/class-tb-popup-shortcode.php' );

		// [raw] -- Can be disabled from WP > Settings > Writing
		if ( 'no' !== get_option( 'themeblvd_raw' ) ) {

			remove_filter( 'the_content', 'wptexturize' );
			remove_filter( 'the_content', 'wpautop' );
			remove_filter( 'the_content', 'shortcode_unautop' );
			add_filter( 'the_content', 'themeblvd_content_formatter', 9 ); // Before do_shortcode().

			remove_filter( 'themeblvd_the_content', 'wptexturize' );
			remove_filter( 'themeblvd_the_content', 'wpautop' );
			remove_filter( 'themeblvd_the_content', 'shortcode_unautop' );
			add_filter( 'themeblvd_the_content', 'themeblvd_content_formatter', 9 ); // Framework uses themeblvd_the_content in some areas so plugins filtering the_content do not effect.

		}

		/**
		 * Columns
		 */
		add_shortcode( 'column', 'themeblvd_shortcode_column' );			// All columns.

		add_shortcode( 'one_sixth', 'themeblvd_shortcode_column' );			// 1/6 @deprecated 1.4.2
		add_shortcode( 'one_fourth', 'themeblvd_shortcode_column' );		// 1/4 @deprecated 1.4.2
		add_shortcode( 'one_third', 'themeblvd_shortcode_column' );			// 1/3 @deprecated 1.4.2
		add_shortcode( 'one_half', 'themeblvd_shortcode_column' );			// 1/2 @deprecated 1.4.2
		add_shortcode( 'two_third', 'themeblvd_shortcode_column' );			// 2/3 @deprecated 1.4.2
		add_shortcode( 'three_fourth', 'themeblvd_shortcode_column' );		// 3/4 @deprecated 1.4.2
		add_shortcode( 'one_fifth', 'themeblvd_shortcode_column' );			// 1/5 @deprecated 1.4.2
		add_shortcode( 'two_fifth', 'themeblvd_shortcode_column' );			// 2/5 @deprecated 1.4.2
		add_shortcode( 'three_fifth', 'themeblvd_shortcode_column' );		// 3/5 @deprecated 1.4.2
		add_shortcode( 'four_fifth', 'themeblvd_shortcode_column' );		// 4/5 @deprecated 1.4.2
		add_shortcode( 'three_tenth', 'themeblvd_shortcode_column' );		// 3/10 @deprecated 1.4.2
		add_shortcode( 'seven_tenth', 'themeblvd_shortcode_column' );		// 7/10 @deprecated 1.4.2
		add_shortcode( 'clear', 'themeblvd_shortcode_clear' );				// Clear row @deprecated 1.4.2

		/**
		 * Components
		 */
		add_shortcode( 'icon_list', 'themeblvd_shortcode_icon_list' );
		add_shortcode( 'button', 'themeblvd_shortcode_button' );
		add_shortcode( 'box', 'themeblvd_shortcode_box' );					// @deprecated 1.4.0
		add_shortcode( 'alert', 'themeblvd_shortcode_alert' );
		add_shortcode( 'divider', 'themeblvd_shortcode_divider' );
		add_shortcode( 'popup', 'themeblvd_shortcode_popup' );
		add_shortcode( 'lightbox', 'themeblvd_shortcode_lightbox' );
		add_shortcode( 'lightbox_gallery', 'themeblvd_shortcode_lightbox_gallery' );
		add_shortcode( 'blockquote', 'themeblvd_shortcode_blockquote' );
		add_shortcode( 'jumbotron', 'themeblvd_shortcode_jumbotron' );
		add_shortcode( 'panel', 'themeblvd_shortcode_panel' );
		add_shortcode( 'testimonial', 'themeblvd_shortcode_testimonial' );
		add_shortcode( 'pricing_table', 'themeblvd_shortcode_pricing_table' );

		/**
		 * Inline Elements
		 */
		add_shortcode( 'icon_link', 'themeblvd_shortcode_icon_link' );
		add_shortcode( 'highlight', 'themeblvd_shortcode_highlight' );
		add_shortcode( 'dropcap', 'themeblvd_shortcode_dropcap' );
		add_shortcode( 'label', 'themeblvd_shortcode_label' );
		add_shortcode( 'lead', 'themeblvd_shortcode_lead' );
		add_shortcode( 'vector_icon', 'themeblvd_shortcode_vector_icon' );

		if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) {

			add_shortcode( 'icon', 'themeblvd_shortcode_icon' ); // @deprecated

		}

		/**
		 * Tabs, Toggles, and Accordion
		 */
		add_shortcode( 'tabs', 'themeblvd_shortcode_tabs' );
		add_shortcode( 'accordion', 'themeblvd_shortcode_accordion' );
		add_shortcode( 'toggle', 'themeblvd_shortcode_toggle' );

		/**
		 * Sliders
		 */
		add_shortcode( 'post_grid_slider', 'themeblvd_shortcode_post_grid_slider' );
		add_shortcode( 'post_list_slider', 'themeblvd_shortcode_post_list_slider' );
		add_shortcode( 'gallery_slider', 'themeblvd_shortcode_gallery_slider' );

		if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '>=' ) ) {

			add_shortcode( 'post_slider', 'themeblvd_shortcode_post_slider' );

		}

		/**
		 * Display Posts
		 */
		add_shortcode( 'post_grid', 'themeblvd_shortcode_post_grid' );
		add_shortcode( 'post_showcase', 'themeblvd_shortcode_post_grid' );
		add_shortcode( 'blog', 'themeblvd_shortcode_post_list' );
		add_shortcode( 'post_list', 'themeblvd_shortcode_post_list' );
		add_shortcode( 'mini_post_grid', 'themeblvd_shortcode_mini_post_grid' );
		add_shortcode( 'mini_post_list', 'themeblvd_shortcode_mini_post_list' );

		/**
		 * Stats
		 */
		add_shortcode( 'milestone', 'themeblvd_shortcode_milestone' );
		add_shortcode( 'milestone_ring', 'themeblvd_shortcode_milestone_ring' );
		add_shortcode( 'progress_bar', 'themeblvd_shortcode_progress_bar' );

	}

}
add_action( 'after_setup_theme', 'themeblvd_shortcodes_init' );

/**
 * Register text domain for localization.
 *
 * @since 1.0.0
 */
function themeblvd_shortcodes_textdomain() {

	load_plugin_textdomain( 'theme-blvd-shortcodes' );

}
add_action( 'init', 'themeblvd_shortcodes_textdomain' );
