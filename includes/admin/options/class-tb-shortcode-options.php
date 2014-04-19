<?php
/**
 * Shortcode Options. These options get added
 * to Settings > Writing in the WordPress
 * admin panel.
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

	 	// Add options to "Theme Blvd Shortcodes" section.
	 	add_settings_field( 'themeblvd_raw', __('Raw Shortcode', 'themeblvd_shortcodes'), array( $this, 'display_option_raw' ), 'writing', 'themeblvd_shortcodes' );
	 	add_settings_field( 'themeblvd_shortcode_generator', __('Shortcode Generator', 'themeblvd_shortcodes'), array( $this, 'display_option_generator' ), 'writing', 'themeblvd_shortcodes' );
	 	add_settings_field( 'themeblvd_auto_lightbox', __('Auto Lightbox', 'themeblvd_shortcodes'), array( $this, 'display_option_auto_lightbox' ), 'writing', 'themeblvd_shortcodes' );

	 	// Register options
	 	register_setting( 'writing', 'themeblvd_raw', array( $this, 'sanitize_yes_no' ) );
	 	register_setting( 'writing', 'themeblvd_shortcode_generator', array( $this, 'sanitize_yes_no' ) );
	 	register_setting( 'writing', 'themeblvd_auto_lightbox', array( $this, 'sanitize_yes_no' ) );

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
		$desc = __( 'Because the [raw] shortcode isn\'t a standard shortcode, having it enabled does effect the output of your content and may conflict with other plugins.', 'themeblvd_shortcodes' );
		$this->display_yes_no( 'themeblvd_raw', $desc );
	}

	/**
	 * Display option to disable shortcode generator.
	 *
	 * @since 1.0.4
	 */
	public function display_option_generator() {
		$desc = __( 'If our plugin\'s shortcode generator causes any unwanted clutter or doesn\'t fully jive with your WordPress setup, you can disable it here.', 'themeblvd_shortcodes' );
		$this->display_yes_no( 'themeblvd_shortcode_generator', $desc );
	}

	/**
	 * Display option to disable shortcode generator.
	 *
	 * @since 1.1.0
	 */
	public function display_option_auto_lightbox() {
		$desc = __( 'When inserting an image with this enabled, images linked to YouTube, Vimeo, Quicktime files, and image files will be automatically converted to the [lightbox] shortcode.', 'themeblvd_shortcodes' );
		$this->display_yes_no( 'themeblvd_auto_lightbox', $desc );
	}

	/**
	 * Display yes/no type options.
	 *
	 * @since 1.0.4
	 *
	 * @param string $id Registerd ID of option
	 * @param string $desc Description to user of what option does
	 */
	public function display_yes_no( $id, $desc ) {
		$value = get_option($id, 'no');
		echo '<select name="'.$id.'" id="'.$id.'">';
		echo '<option value="yes" '.selected( $value, 'yes', false ).'>'.__('Enabled', 'themeblvd_shortcodes').'</option>';
		echo '<option value="no" '.selected( $value, 'no', false ).'>'.__('Disabled', 'themeblvd_shortcodes').'</option>';
		echo '</select>';
		echo '<p class="description">'.$desc.'</p>';
	}

	/**
	 * Sanitization.
	 *
	 * @since 1.0.4
	 */
	public function sanitize_yes_no( $input ) {

		$output = '';
		$answers = array( 'yes', 'no' );

		if( in_array( $input, $answers ) ) {
			$output = $input;
		}

		return $output;
	}

}