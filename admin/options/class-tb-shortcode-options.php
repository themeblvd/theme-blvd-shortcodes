<?php
/**
 * Shortcode Options
 */
class Theme_Blvd_Shortcode_Options {
	
	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		
		// Go, go Settings API.
		add_action( 'admin_init', array( $this, 'register' ) );
	
	}
	
	/**
	 * Register setting.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		
		// Add the section to General settings
	 	add_settings_section( 'themeblvd_shortcodes', __('Theme Blvd Shortcodes', 'themeblvd_shortcodes'), array( $this, 'display_section' ), 'writing' );
	 	
	 	// Add [raw] option to "Theme Blvd Shortcodes" section.
	 	add_settings_field( 'themeblvd_raw', __('Raw Shortcode', 'themeblvd_shortcodes'), array( $this, 'display_option_raw' ), 'writing', 'themeblvd_shortcodes' );
	 	
	 	// Register [raw] option setting.
	 	register_setting( 'writing', 'themeblvd_raw', array( $this, 'sanitize_option_raw' ) );
	 	
	}
	
	/**
	 * Display shortcodes options section.
	 *
	 * @since 1.0.0
	 */
	public function display_section() {
		// do nothing - @todo Possibly add description here later if we have more options to add.
	}
	
	/**
	 * Display option to disable [raw] shortcode.
	 *
	 * @since 1.0.0
	 */
	public function display_option_raw() {
		$value = get_option('themeblvd_raw');
		echo '<select name="themeblvd_raw" id="themeblvd_raw">';
		echo '<option value="yes" '.selected( $value, 'yes', false ).'>'.__('Enabled', 'themeblvd_shortcodes').'</option>';
		echo '<option value="no" '.selected( $value, 'no', false ).'>'.__('Disabled', 'themeblvd_shortcodes').'</option>';
		echo '</select>';
		echo '<p class="description">'.__( 'Because the [raw] shortcode isn\'t a standard shortcode, having it enabled does effect the output of your content and may conflict with other plugins.', 'themeblvd_shortcode' ).'</p>';
	}
	
	/**
	 * Sanitization.
	 *
	 * @since 1.0.0
	 */
	public function sanitize_option_raw( $input ) {
		$output = '';
		$answers = array( 'yes', 'no' );
		if( in_array( $input, $answers ) )
			$output = $input;
		return $output;
	}
	
}