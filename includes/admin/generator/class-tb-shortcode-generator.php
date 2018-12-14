<?php
/**
 * This file contains the shortcode generator
 * for newer themes.
 *
 * @package Theme Blvd Shortcodes
 */

/**
 * Shortcode Generator
 */
class Theme_Blvd_Shortcode_Generator {

	/**
	 * An array of custom slider posts.
	 *
	 * @since 1.4.0
	 *
	 * @var array
	 */
	public $sliders = array();

	/**
	 * An array of framework's image icons.
	 *
	 * @since 1.4.0
	 *
	 * @var array
	 */
	public $image_icons = array();

	/**
	 * An array of framework's vector FontAwesome icons.
	 *
	 * @since 1.4.0
	 *
	 * @var array
	 */
	private $vector_icons = array();

	/**
	 * Legacy object, if neccessary
	 *
	 * @since 1.5.0
	 *
	 * @var array
	 */
	private $legacy = null;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->set();

		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );

		add_action( 'media_buttons', array( $this, 'add_button' ), 11 );

		add_action( 'admin_footer-post.php', array( $this, 'add_modal' ) );

		add_action( 'admin_footer-post-new.php', array( $this, 'add_modal' ) );

		add_action( 'admin_footer-toplevel_page_themeblvd_builder', array( $this, 'add_modal' ) );

		add_action( 'admin_footer-admin_page_tb-edit-layout', array( $this, 'add_modal' ) );

		// Add icon browser into editing posts, and pages when
		// layout builder isn't presetn.
		add_action( 'current_screen', array( $this, 'add_icon_browser' ) );

	}

	/**
	 * Set properties.
	 *
	 * @since 1.4.0
	 */
	public function set() {

		/**
		 * Sliders
		 */

		// Custom built slider from the Theme Blvd Sliders plugin.
		$this->sliders = themeblvd_get_select( 'sliders' );

		/**
		 * Image Icons
		 */

		$this->image_icons = array();

		if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) { // Image icons only supported prior to framework 2.5.

			// Check for cached icons.
			$this->image_icons = get_transient( 'themeblvd_' . get_template() . '_image_icons' );

			if ( ! $this->image_icons ) {

				// Icons from the parent theme.
				$icons = array();
				$icons_url = TB_FRAMEWORK_URI . '/assets/images/shortcodes/icons';
				$icons_dir = TB_FRAMEWORK_DIRECTORY . '/assets/images/shortcodes/icons';

				if ( file_exists( $icons_dir ) ) {

					$icons = scandir( $icons_dir );

				}

				// Display icons.
				if ( count( $icons ) > 0 ) {

					foreach ( $icons as $icon ) {

						if ( strpos( $icon, '.png' ) !== false ) {

							$id = str_replace( '.png', '', $icon );
							$this->image_icons[ $id ] = sprintf( '%s/%s.png', $icons_url, $id );

						}
					}
				}

				// Check for icons in the child theme.
				$child_icons = array();
				$child_icons_url = get_stylesheet_directory_uri() . '/icons';
				$child_icons_dir = get_stylesheet_directory() . '/assets/images/shortcodes/icons';

				if ( file_exists( $child_icons_dir ) ) {

					$child_icons = scandir( $child_icons_dir );

				}

				// Display icons.
				if ( count( $child_icons ) > 0 ) {

					foreach ( $child_icons as $icon ) {

						if ( strpos( $icon, '.png' ) !== false ) {

							$id = str_replace( '.png', '', $icon );
							$this->image_icons[ $id ] = sprintf( '%s/%s.png', $child_icons_url, $id );

						}
					}
				}

				// Cache results
				set_transient( 'themeblvd_' . get_template() . '_image_icons', $this->image_icons, '86400' ); // 1-day cache.

			}
		}

		/**
		 * Vector Icons
		 */
		if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) {

			// Check for cached icons.
			$this->vector_icons = get_transient( 'themeblvd_' . get_template() . '_vector_icons' );

			if ( ! $this->vector_icons ) {

				$this->vector_icons = array();

				$file_location = TB_FRAMEWORK_DIRECTORY . '/assets/plugins/fontawesome/css/font-awesome.css';
				$fetch_icons = array();

				if ( file_exists( $file_location ) ) {

					$file = fopen( $file_location, 'r' );

					while ( ! feof( $file ) ) {

						$line = fgets( $file );

						if ( false !== strpos( $line, '.fa-' ) && false !== strpos( $line, ':before' ) ) {

							$icon = str_replace( '.fa-', '', $line );
							$icon = str_replace( ':before {', '', $icon );
							$icon = str_replace( ':before,', '', $icon );
							$fetch_icons[] = trim( $icon );

						}
					}

					// Close file.
					fclose( $file );

					// Sort icons alphabetically.
					sort( $fetch_icons );

					// Format array for use in options framework -- for compat reasons with framework 2.5+.
					foreach ( $fetch_icons as $icon ) {

						$this->vector_icons[ $icon ] = $icon;

					}

					// Cache results
					set_transient( 'themeblvd_' . get_template() . '_vector_icons', $this->vector_icons, '86400' ); // 1-day cache.

				}
			}
		}

		/**
		 * Run legacy generator for older themes?
		 */
		if ( class_exists( 'Theme_Blvd_Shortcode_Generator_Legacy' ) ) {

			$this->legacy = new Theme_Blvd_Shortcode_Generator_Legacy( $this );

		}

	}

	/**
	 * Add assets.
	 *
	 * @since 1.4.0
	 *
	 * @param string $hook The current WordPress admin page.
	 */
	public function assets( $hook ) {

		$pages_to_add_assets = array(
			'post.php',
			'post-new.php',
			'admin_page_tb-edit-layout',
			'toplevel_page_themeblvd_builder'
		);

		if ( in_array( $hook, $pages_to_add_assets ) ) {

			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			if ( function_exists( 'themeblvd_admin_assets' ) ) { // Framework 2.7+.

				themeblvd_admin_assets();

				$icon_file = themeblvd_get_icon_js_file();

				wp_enqueue_script( $icon_file );

			} else {

				wp_enqueue_script( 'jquery-ui-core');

				wp_enqueue_script( 'jquery-ui-sortable' );

				wp_enqueue_script( 'jquery-ui-slider' );

				wp_enqueue_script( 'wp-color-picker' );

				wp_enqueue_style( 'wp-color-picker' );

				wp_enqueue_media();

				wp_enqueue_style( 'themeblvd_admin', esc_url( TB_FRAMEWORK_URI . "/admin/assets/css/admin-style{$suffix}.css" ), null, TB_FRAMEWORK_VERSION );

				wp_enqueue_style( 'themeblvd_options', esc_url( TB_FRAMEWORK_URI . "/admin/options/css/admin-style{$suffix}.css" ), null, TB_FRAMEWORK_VERSION );

				wp_enqueue_script( 'themeblvd_admin', esc_url( TB_FRAMEWORK_URI . "/admin/assets/js/shared{$suffix}.js" ), array('jquery'), TB_FRAMEWORK_VERSION );

				wp_enqueue_style( 'fontawesome', esc_url( TB_FRAMEWORK_URI . "/assets/plugins/fontawesome/css/font-awesome{$suffix}.css" ), null, TB_FRAMEWORK_VERSION );

			}

			if ( $this->legacy ) {

				wp_enqueue_style( 'color-picker', esc_url( TB_FRAMEWORK_URI . "/admin/options/css/colorpicker{$suffix}.css" ) );

				wp_enqueue_script( 'color-picker', esc_url( TB_FRAMEWORK_URI . "/admin/options/js/colorpicker{$suffix}.js" ), array( 'jquery' ) );

			}

			// Include Generator.
			wp_enqueue_style(
				'themeblvd-shortcode-generator',
				esc_url( TB_SHORTCODES_PLUGIN_URI . "/includes/admin/generator/assets/css/generator{$suffix}.css" ),
				false,
				TB_SHORTCODES_PLUGIN_VERSION
			);

			wp_enqueue_script(
				'themeblvd-shortcode-generator',
				esc_url( TB_SHORTCODES_PLUGIN_URI . "/includes/admin/generator/assets/js/generator{$suffix}.js" ),
				false,
				TB_SHORTCODES_PLUGIN_VERSION
			);

		}

	}

	/**
	 * Add button for inserting shortcodes,
	 * which brings up modal window of options.
	 *
	 * @since 1.4.0
	 *
	 * @param string $editor_id ID of current WP editor; it should be equal to "content" or "themeblvd_content".
	 */
	public function add_button( $editor_id ) {

		if ( 'content' !== $editor_id && 'themeblvd_editor' !== $editor_id ) {

			return;

		}

		$screen = get_current_screen();

		if ( 'press-this' === $screen->base ) {

			return;

		}

		$text = __( 'Add Shortcode', 'theme-blvd-shortcodes' );

		$button = sprintf( '<a href="#" class="tb-insert-shortcode button" title="%s">', $text );

		if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {

			$button .= '<span class="tb-icon"></span>'; // Admin icon font added in Framework 2.4.

		}

		$button .= $text;
		$button .= '</a>';

		/**
		 * Filter the HTML output of the button
		 * that leads to the shortcode generator.
		 *
		 * @since 1.4.0
		 *
		 * @var string
		 */
		echo wp_kses( apply_filters( 'themeblvd_shortcode_button', $button ), themeblvd_allowed_tags() );

	}

	/**
	 * Add modal window.
	 *
	 * @since 1.4.0
	 */
	public function add_modal() {

		$groups = $this->get_groups();

		?>
		<div id="tb-shortcode-generator" class="tb-hide">
			<div class="media-modal wp-core-ui">

				<button type="button" class="media-modal-close">
					<span class="media-modal-icon">
						<span class="screen-reader-text">Close media panel</span>
					</span>
				</button>

				<div class="media-modal-content">
					<div class="media-frame wp-core-ui">

						<div class="media-frame-menu">
							<div class="media-menu">

								<?php foreach ( $groups as $key => $group ) : ?>

									<a href="#" data-id="<?php echo esc_attr( $group['id'] ); ?>" title="<?php echo esc_attr( $group['name'] ); ?>" class="media-menu-item <?php if ( 0 === $key ) { echo ' active'; } ?>">
										<?php echo esc_html( $group['name'] ); ?>
									</a>

								<?php endforeach; ?>

							</div>
						</div><!-- .media-frame-menu (end) -->

						<div class="media-frame-title">

							<h1><?php echo esc_html( $groups[0]['name'] ); ?></h1>

						</div><!-- .media-frame-title (end) -->

						<?php foreach ( $groups as $key => $group ) : ?>

							<?php if ( count( $group['sub'] ) > 0 ) : ?>

								<div class="media-frame-router tb-router-<?php echo esc_attr( $group['id'] ); ?>" data-group="<?php echo esc_attr( $group['id'] ); ?>">
									<div class="media-router">

										<?php foreach ( $group['sub'] as $id => $name ) : ?>

											<?php
											$class = 'tb-tab-menu-item';

											if ( reset( $group['sub'] ) === $name ) {

												$class .= ' active';

											}
											?>

											<a href="#" data-sub-group="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>"><?php echo esc_html( $name ); ?></a>

										<?php endforeach; ?>

									</div><!-- .media-router (end) -->
								</div><!-- .media-frame-router (end) -->

							<?php endif; ?>

						<?php endforeach; ?>

						<div id="optionsframework" class="tb-options-wrap media-frame-content">
							<div class="attachments-browser">

								<?php foreach ( $groups as $key => $group ) : ?>

									<?php
									$class = 'tb-group attachments ui-sortable ui-sortable-disabled';

									if ( 0 === $key ) {

										$class .= ' tb-group-show';

									} else {

										$class .= ' tb-group-hide';

									}

									if ( count( $group['sub'] ) > 0 ) {

										$class .= ' group-has-subs';

									}
									?>

									<div id="tb-group-<?php echo esc_attr( $group['id'] ); ?>" class="<?php echo esc_attr( $class ); ?>">

										<?php
										switch ( $group['id'] ) {

											/**
											 * Buttons
											 */
											case 'button' :

												$options = $this->get_options( 'button' );

												$output = themeblvd_option_fields( 'button', $options, array(), false );

												echo '<div class="shortcode-options" data-type="button">';
												echo '<div class="options-wrap">';

												$this->preview( $group['id'] );

												$color_browser_args = array(
													'title'	=> __( 'Button Color', 'theme-blvd-shortcodes' ),
													'desc' 	=> __( '<p>Select a color for your button.</p><p><em>Note: The "default" and "primary" colors may vary from theme-to-theme.</em></p>', 'theme-blvd-shortcodes' ),
													'std'	=> 'default',
												);

												$this->color_browser( $color_browser_args );

												echo $output[0]; // WPCS: sanitization ok.

												echo '</div><!-- .options-wrap (end) -->';
												echo '</div><!-- .shortcode-options (end) -->';

												break;

											/**
											 * Icons
											 */
											case 'icons' :

												// Vector Icons.
												$options = $this->get_options( 'vector_icon' );
												$output = themeblvd_option_fields( 'vector_icon', $options, array(), false );

												echo '<div class="shortcode-options shortcode-options-vector_icon" data-type="vector_icon">';

												$this->preview( 'vector_icon' );

												if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) {
													$this->icon_browser();
												}

												echo '<div class="options-wrap">';

												echo $output[0]; // WPCS: sanitization ok.

												echo '</div><!-- .options-wrap (end) -->';
												echo '</div><!-- .shortcode-options (end) -->';

												// Image Icons.
												if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) {

													$options = $this->get_options( 'icon' );

													$output = themeblvd_option_fields( 'icon', $options, array(), false );

													echo '<div class="shortcode-options shortcode-options-icon hide" data-type="icon">';
													echo '<div class="options-wrap">';

													$this->preview( 'icon' );

													echo $output[0]; // WPCS: sanitization ok.

													echo '</div><!-- .options-wrap (end) -->';
													echo '</div><!-- .shortcode-options (end) -->';

												}

												break;

											/**
											 * Default, i.e. all other types of shortcode options.
											 */
											default :

												$hide = '';

												if ( count( $group['sub'] ) > 0 ) {

													foreach ( $group['sub'] as $id => $name ) {

														$options = $this->get_options( $id );

														$output = themeblvd_option_fields( $id, $options, array(), false );
														$output = str_replace( 'id="excerpt"', 'id="excerpt-option"', $output[0] );

														printf( '<div class="shortcode-options shortcode-options-%s %s" data-type="%s">', esc_attr( $id ), esc_attr( $hide ), esc_attr( $id ) );

														$this->preview( $group['id'], $id );

														echo '<div class="options-wrap">';
														echo $output; // WPCS: sanitization ok.

														echo '</div><!-- .options-wrap (end) -->';
														echo '</div><!-- .shortcode-options (end) -->';

														$hide = 'hide'; // Starting with the the second pass, hide clas will be.

													}
												} else {

													$options = $this->get_options( $group['id'] );

													printf( '<div class="shortcode-options shortcode-options-%1$s" data-type="%1$s">', esc_attr( $group['id'] ) );

													$this->preview( $group['id'] );

													echo '<div class="options-wrap">';

													if ( $options ) {

														$output = themeblvd_option_fields( $group['id'], $options, array(), false );
														$output = str_replace( 'id="excerpt"', 'id="excerpt-option"', $output[0] );

														echo $output; // WPCS: sanitization ok.

													}

													echo '</div><!-- .options-wrap (end) -->';
													echo '</div><!-- .shortcode-options (end) -->';

												}
										}
										?>


									</div>

								<?php endforeach; ?>

							</div><!-- .attachments-browser (end) -->
						</div><!-- .media-frame-content (end) -->

						<div class="media-frame-toolbar">
							<div class="media-toolbar">

								<div class="media-toolbar-secondary"></div>

								<div class="media-toolbar-primary">
									<button href="#" id="tb-shortcode-to-editor" data-insert="button" class="button media-button button-primary button-large">
										<?php esc_html_e( 'Insert Shortcode', 'theme-blvd-shortcodes' ); ?>
									</button>
								</div>

							</div><!-- .media-toolbar (end) -->
						</div><!-- .media-frame-toolbar (end) -->

					</div><!-- .media-frame (end) -->
				</div><!-- .media-modal-content (end) -->

			</div><!-- .media-modal (end) -->

			<div class="media-modal-backdrop"></div>

		</div>
		<?php

	}

	/**
	 * Get groups of shortcodes for generator.
	 *
	 * @since 1.4.0
	 */
	private function get_groups() {

		if ( $this->legacy ) {

			return $this->legacy->get_groups();

		}

		$groups = array(
			array(
				'id'	=> 'button',
				'name'	=> __( 'Button', 'theme-blvd-shortcodes' ),
				'sub'	=> array(),
			),
			array(
				'id'	=> 'column',
				'name'	=> __( 'Columns', 'theme-blvd-shortcodes' ),
				'sub'	=> array(),
			),
			array(
				'id'	=> 'components',
				'name'	=> __( 'Components', 'theme-blvd-shortcodes' ),
				'sub'	=> array(
					'alert'				=> __( 'Alert', 'theme-blvd-shortcodes' ),
					'divider'			=> __( 'Divider', 'theme-blvd-shortcodes' ),
					'icon_list'			=> __( 'Icon List', 'theme-blvd-shortcodes' ),
					'jumbotron'			=> __( 'Jumbotron', 'theme-blvd-shortcodes' ),
					'panel'				=> __( 'Panel', 'theme-blvd-shortcodes' ),
					'popup'				=> __( 'Popup', 'theme-blvd-shortcodes' ),
					'progress_bar'		=> __( 'Progress Bar', 'theme-blvd-shortcodes' ),
					'blockquote'		=> __( 'Quote', 'theme-blvd-shortcodes' ),
					'testimonial'		=> __( 'Testimonial', 'theme-blvd-shortcodes' ),
				),
			),
			array(
				'id'	=> 'display_posts',
				'name'	=> __( 'Display Posts', 'theme-blvd-shortcodes' ),
				'sub'	=> array(
					'blog'				=> __( 'Blog', 'theme-blvd-shortcodes' ),
					'post_grid'			=> __( 'Post Grid', 'theme-blvd-shortcodes' ),
					'post_showcase'		=> __( 'Post Showcase', 'theme-blvd-shortcodes' ),
					'post_list'			=> __( 'Post List', 'theme-blvd-shortcodes' ),
					'mini_post_grid'	=> __( 'Mini Post Grid', 'theme-blvd-shortcodes' ),
					'mini_post_list'	=> __( 'Mini Post List', 'theme-blvd-shortcodes' ),
				),
			),
			array(
				'id'	=> 'icons',
				'name'	=> __( 'Icons', 'theme-blvd-shortcodes' ),
				'sub'	=> array(
					'vector_icon'		=> __( 'FontAwesome Icon', 'theme-blvd-shortcodes' ),
				),
			),
			array(
				'id'	=> 'inline_elements',
				'name'	=> __( 'Inline Elements', 'theme-blvd-shortcodes' ),
				'sub'	=> array(
					'dropcap'		=> __( 'Dropcap', 'theme-blvd-shortcodes' ),
					'highlight'		=> __( 'Highlight Text', 'theme-blvd-shortcodes' ),
					'icon_link'		=> __( 'Icon Link', 'theme-blvd-shortcodes' ),
					'label'			=> __( 'Label', 'theme-blvd-shortcodes' ),
					'lead'			=> __( 'Lead Text', 'theme-blvd-shortcodes' ),
				),
			),
			array(
				'id'	=> 'pricing_table',
				'name'	=> __( 'Pricing Table', 'theme-blvd-shortcodes' ),
				'sub'	=> array(),
			),
			array(
				'id'	=> 'sliders',
				'name'	=> __( 'Sliders', 'theme-blvd-shortcodes' ),
				'sub'	=> array(
					'gallery_slider'	=> __( 'Gallery Slider', 'theme-blvd-shortcodes' ),
					'post_slider'		=> __( 'Post Slider', 'theme-blvd-shortcodes' ),
					'post_grid_slider'	=> __( 'Post Grid Slider', 'theme-blvd-shortcodes' ),
				),
			),
			array(
				'id'	=> 'stats',
				'name'	=> __( 'Stats', 'theme-blvd-shortcodes' ),
				'sub'	=> array(
					'milestone'			=> __( 'Milestone', 'theme-blvd-shortcodes' ),
					'milestone_ring'	=> __( 'Milestone Ring', 'theme-blvd-shortcodes' ),
					'progress_bar'		=> __( 'Progress Bar', 'theme-blvd-shortcodes' ),
				),
			),
			array(
				'id'	=> 'tabs',
				'name'	=> __( 'Tabs', 'theme-blvd-shortcodes' ),
				'sub'	=> array(),
			),
			array(
				'id'	=> 'toggles',
				'name'	=> __( 'Toggles', 'theme-blvd-shortcodes' ),
				'sub'	=> array(
					'toggle'			=> __( 'Toggle', 'theme-blvd-shortcodes' ),
					'accordion'			=> __( 'Accordion', 'theme-blvd-shortcodes' ),
				),
			),
		);

		/**
		 * Filter tabbed groups of shortcode generator.
		 *
		 * @since 1.4.0
		 *
		 * @var array
		 */
		return apply_filters( 'themeblvd_shortcodes_groups', $groups );

	}

	/**
	 * Get options for a specific type of shortcode.
	 *
	 * @since 1.4.0
	 *
	 * @param string $type Type of icon.
	 * @return array $options array of options for a shortcode.
	 */
	private function get_options( $type ) {

		if ( $this->legacy ) {

			return $this->legacy->get_options( $type );

		}

		// Note: For utilizing a shortcode that includes content
		// like [example]Content...[/example], the option ID
		// must be "sc_content".
		$options = array();

		/**
		 * Option Helpers
		 */

		$colors = themeblvd_colors();

		/**
		 * Buttons
		 */

		$options['button'] = array(
			'color' => array( // Hidden option, to interact with button's color browser.
				'name' 		=> '',
				'desc' 		=> '',
				'id' 		=> 'color',
				'std' 		=> 'default',
				'type' 		=> 'text',
				'class'		=> 'hide',
			),
			'custom' => array( // Hidden option, to interact with button's color browser.
				'name' 		=> __( 'Custom Button Color', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Configure the style of your custom button design.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'custom',
				'std' 		=> 'default',
				'type' 		=> 'button',
				'class'		=> 'hide',
			),
			'sc_content' => array(
				'name' 		=> __( 'Button Text', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The text of the button.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Button Text...',
				'type' 		=> 'text',
			),
			'link' => array(
				'name' 		=> __( 'Link URL', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The full URL of where you want the button to link.<br />Ex: http://yourwebsite.com/example/', 'theme-blvd-shortcodes' ),
				'id' 		=> 'link',
				'std' 		=> 'http://yourwebsite.com/example/',
				'type' 		=> 'text',
			),
			'size' => array(
				'name' 		=> __( 'Button Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The size of how the button displays.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'size',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'mini' 			=> __( 'Mini', 'theme-blvd-shortcodes' ),
					'small' 		=> __( 'Small', 'theme-blvd-shortcodes' ),
					'default' 		=> __( 'Default', 'theme-blvd-shortcodes' ),
					'large' 		=> __( 'Large', 'theme-blvd-shortcodes' ),
					'x-large' 		=> __( 'X-Large', 'theme-blvd-shortcodes' ),
					'xx-large' 		=> __( 'XX-Large', 'theme-blvd-shortcodes' ),
					'xxx-large' 	=> __( 'XXX-Large', 'theme-blvd-shortcodes' ),
				),
			),
			'icon_before' => array(
				'name' 		=> __( 'Icon Before Button Text (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Icon before text of button. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon_before',
				'std' 		=> '',
				'type' 		=> 'text',
				'icon'      => 'vector',
			),
			'icon_after' => array(
				'name' 		=> __( 'Icon After Button Text (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Icon after text of button. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon_after',
				'std' 		=> '',
				'type' 		=> 'text',
				'icon'      => 'vector',
			),
			'target' => array(
				'name' 		=> __( 'Button Target', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How the button opens the link.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'target',
				'std' 		=> '_self',
				'type' 		=> 'select',
				'options' 	=> array(
					'_self' 		=> __( 'Same Window', 'theme-blvd-shortcodes' ),
					'_blank' 		=> __( 'New Window', 'theme-blvd-shortcodes' ),
					'lightbox' 		=> __( 'Lightbox', 'theme-blvd-shortcodes' ),
				),
			),
			'block' => array(
				'name' 		=> __( 'Block Display', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to display the button as a block-level element or not. As a block-level element, the button will stretch full-width to fill its container, opposed to sitting inline with the content.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'block',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 			=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 		=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'title' => array(
				'name' 		=> __( 'Button Title (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'For you SEO folks, this controls the button\'s HTML title tag. If left blank, this will just default to the button\'s text.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'title',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'class' => array(
				'name' 		=> __( 'Button CSS Class (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'This will allow you to add an extra CSS class for styling to the button.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'class',
				'std' 		=> '',
				'type' 		=> 'text',
			),
		);

		/**
		 * Columns
		 */

		$options['column'] = array(
			'subgroup_start' => array(
		    	'type'		=> 'subgroup_start',
		    	'class'		=> 'columns',
		    ),
			'setup' => array(
				'id' 		=> 'setup',
				'name'		=> __( 'Setup Columns', 'theme-blvd-shortcodes' ),
				'desc'		=> null,
				'type'		=> 'columns',
				'std'		=> '1/3-1/3-1/3',
				'options'	=> 'shortcode',
			),
			'subgroup_end' => array(
		    	'type'		=> 'subgroup_end',
		    ),
		    'wpautop' => array(
		    	'id' 		=> 'wpautop',
				'desc'		=> __( 'Apply WordPress automatic formatting to content of columns.', 'theme-blvd-shortcodes' ),
				'type'		=> 'checkbox',
				'std'		=> '1',
			),
		);

		/**
		 * Components
		 */

		// Alert.
		$options['alert'] = array(
			'style' => array(
				'name' 		=> __( 'Style', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The style of the alert.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'style',
				'std' 		=> 'info',
				'type' 		=> 'select',
				'options' 	=> array(
					'info' 		=> __( 'Info (blue)', 'theme-blvd-shortcodes' ),
					'success' 	=> __( 'Success (green)', 'theme-blvd-shortcodes' ),
					'danger' 	=> __( 'Danger (red)', 'theme-blvd-shortcodes' ),
					'warning' 	=> __( 'Warning (yellow)', 'theme-blvd-shortcodes' ),
				),
			),
			'sc_content' => array(
				'name' 		=> __( 'Content', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>The content of the alert.</p><p><em>Note: The content can be further edited from your WordPress editor after being inserted.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Content here...',
				'type' 		=> 'textarea',
			),
		);

		// Divider.
		$options['divider'] = array(
			'sub_group_start_1' => array(
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide-toggle',
			),
			'style' => array(
				'id' 		=> 'style',
				'name'		=> __( 'Divider Type', 'theme-blvd-layout-builder' ),
				'desc'		=> __( 'Select which style of divider you\'d like to use here.', 'theme-blvd-layout-builder' ),
				'type'		=> 'select',
				'std'		=> 'solid',
				'options'		=> array(
					'shadow' 		=> __( 'Shadow Line', 'theme-blvd-layout-builder' ),
					'solid' 		=> __( 'Solid Line', 'theme-blvd-layout-builder' ),
			        'dashed' 		=> __( 'Dashed Line', 'theme-blvd-layout-builder' ),
			        'thick-solid' 	=> __( 'Thick Solid Line', 'theme-blvd-layout-builder' ),
			        'thick-dashed' 	=> __( 'Thick Dashed Line', 'theme-blvd-layout-builder' ),
					'double-solid' 	=> __( 'Double Solid Lines', 'theme-blvd-layout-builder' ),
					'double-dashed' => __( 'Double Dashed Lines', 'theme-blvd-layout-builder' ),
				),
				'class'		=> 'trigger',
			),
			'color' => array(
				'id' 		=> 'color',
				'name'		=> __( 'Divider Color', 'theme-blvd-layout-builder' ),
				'desc'		=> __( 'Select a custom color for your divider.', 'theme-blvd-layout-builder' ),
				'std'		=> '#cccccc',
				'type'		=> 'color',
				'class'		=> 'hide receiver receiver-solid receiver-dashed receiver-thick-solid receiver-thick-dashed receiver-double-solid receiver-double-dashed',
			),
			'opacity' => array(
				'id' 		=> 'opacity',
				'name'		=> __( 'Divider Opacity', 'theme-blvd-layout-builder' ),
				'desc'		=> __( 'Select an opacity for your divider. Selecting "1.0" means that the divider is not transparent, at all.', 'theme-blvd-layout-builder' ),
				'std'		=> '1',
				'type'		=> 'select',
				'options'	=> array(
					'0.1'	=> '0.1',
					'0.2'	=> '0.2',
					'0.3'	=> '0.3',
					'0.4'	=> '0.4',
					'0.5'	=> '0.5',
					'0.6'	=> '0.6',
					'0.7'	=> '0.7',
					'0.8'	=> '0.8',
					'0.9'	=> '0.9',
					'1'		=> '1.0',
				),
				'class'		=> 'hide receiver receiver-solid receiver-dashed receiver-thick-solid receiver-thick-dashed receiver-double-solid receiver-double-dashed',
			),
			'icon' => array(
				'id' 		=> 'icon',
				'name'		=> __( 'Divider Icon', 'theme-blvd-layout-builder' ),
				'desc'		=> __( 'Enter the icon placed in the middle of the divider line. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.', 'theme-blvd-layout-builder' ),
				'std'		=> '',
				'type'		=> 'text',
				'icon'      => 'vector',
				'class'		=> 'hide receiver receiver-solid receiver-dashed receiver-thick-solid receiver-thick-dashed receiver-double-solid receiver-double-dashed',
			),
			'icon_color' => array(
				'id' 		=> 'icon_color',
				'name'		=> __( 'Icon', 'theme-blvd-layout-builder' ),
				'desc'		=> __( '<p>If you entered an icon, select a color.</p><p><em>Note: You must enter an icon above for this to take effect.</em></p>', 'theme-blvd-layout-builder' ),
				'std'		=> '#666666',
				'type'		=> 'color',
				'class'		=> 'hide receiver receiver-solid receiver-dashed receiver-thick-solid receiver-thick-dashed receiver-double-solid receiver-double-dashed',
			),
			'icon_size' => array(
				'id' 		=> 'icon_size',
				'name'		=> __( 'Icon Size', 'theme-blvd-layout-builder' ),
				'desc'		=> __( '<p>If you ented an icon, enter the size in pixels. Ex: 15</p><p><em>You must enter an icon above for this to take effect.</em></p>', 'theme-blvd-layout-builder' ),
				'std'		=> '15',
				'type'		=> 'text',
				'class'		=> 'hide receiver receiver-solid receiver-dashed receiver-thick-solid receiver-thick-dashed receiver-double-solid receiver-double-dashed',
			),
			'sub_group_end_1' => array(
				'type' 		=> 'subgroup_end',
			),
			'width' => array(
				'id' 		=> 'width',
				'name'		=> __( 'Divider Width', 'theme-blvd-layout-builder' ),
				'desc'		=> __( 'If you\'d like to restrict the width of the divider enter an integer in pixels.<br>Ex: 100', 'theme-blvd-layout-builder' ),
				'type'		=> 'text',
			),
			'placement' => array(
				'id' 		=> 'placement',
				'name'		=> __( 'Divider Placement', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'Select how you\'d like the divider to separate the content.', 'theme-blvd-shortcodes' ),
				'std'		=> 'equal',
				'type'		=> 'select',
				'options'	=> array(
					'equal' 	=> __( 'Divider is in between content', 'theme-blvd-shortcodes' ),
					'up' 		=> __( 'Divider is closer to content above', 'theme-blvd-shortcodes' ),
					'down' 		=> __( 'Divider is closer to content below', 'theme-blvd-shortcodes' ),
				),
			),
		);

		// Icon List.
		$options['icon_list'] = array(
			'sc_content' => array(
				'name' 		=> __( 'List', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>The HTML list you are wrapping the shortcode in. Each item of this list will appear with an icon.</p><p><em>Note: The content can be further edited from your WordPress editor after being inserted.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> "<ul>\n<li>List item 1</li>\n<li>List item 2</li>\n<li>List item 3</li>\n</ul>",
				'type' 		=> 'textarea',
			),
			'icon' => array(
				'name' 		=> __( 'Icon', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Icon to be applied to each list item. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon',
				'std' 		=> 'fas fa-caret-right',
				'type' 		=> 'text',
				'icon'      => 'vector',
			),
			'color' => array(
				'name' 		=> __( 'Icon Color (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'A color for the icons - Ex: #666666', 'theme-blvd-shortcodes' ),
				'id' 		=> 'color',
				'std' 		=> '',
				'type' 		=> 'color',
			),
		);

		if ( version_compare( TB_FRAMEWORK_VERSION, '2.7.0', '<' ) ) {
			$options['icon_list']['icon']['std'] = 'caret-right';
		}

		// Jumbotron.
		$options['jumbotron'] = array(
			'title' => array(
				'name' 		=> __( 'Title (Optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Enter a title for the unit.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'title',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'sc_content' => array(
				'name' 		=> __( 'Content', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>The content of the unit.</p><p><em>Note: The content can be further edited from your WordPress editor after being inserted.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Content here...',
				'type' 		=> 'textarea',
			),
			'bg_color' => array(
				'name' 		=> __( 'Background Color', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select the background color of the unit.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'bg_color',
				'std' 		=> '',
				'type' 		=> 'color',
			),
			'title_size' => array(
				'name' 		=> __( 'Title Text Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select the size of the title text in the unit.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'title_size',
				'std'		=> '30px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'	=> 'px',
					'min'	=> '10',
					'max'	=> '50',
					'step'	=> '1',
				),
			),
			'text_size' => array(
				'name' 		=> __( 'Content Text Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select the size of the content text in the unit.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'text_size',
				'std'		=> '18px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'	=> 'px',
					'min'	=> '10',
					'max'	=> '50',
					'step'	=> '1',
				),
			),
			'text_color' => array(
				'name' 		=> __( 'Content Text Color', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select the color of all the text in the unit.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'text_color',
				'std' 		=> '',
				'type' 		=> 'color',
			),
			'text_align' => array(
				'name' 		=> __( 'Text Alignment', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How you\'d like all text in the unit aligned.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'text_align',
				'std' 		=> 'left',
				'type' 		=> 'select',
				'options' 	=> array(
					'left' 		=> __( 'Left', 'theme-blvd-shortcodes' ),
					'right' 	=> __( 'Right', 'theme-blvd-shortcodes' ),
					'center' 	=> __( 'Center', 'theme-blvd-shortcodes' ),
				),
			),
			'subgroup_start' => array(
		    	'type'		=> 'subgroup_start',
		    	'class'		=> 'show-hide-toggle',
		    ),
			'align' => array(
				'name' 		=> __( 'Unit Alignment', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How you\'d like to align the entire unit on the page.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'align',
				'std' 		=> '0',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'None', 'theme-blvd-shortcodes' ),
					'left' 		=> __( 'Left', 'theme-blvd-shortcodes' ),
					'right' 	=> __( 'Right', 'theme-blvd-shortcodes' ),
					'center' 	=> __( 'Center', 'theme-blvd-shortcodes' ),
				),
				'class'		=> 'trigger',
			),
			'max_width' => array(
				'name' 		=> __( 'Maximum Width', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'If you\'ve aligned the entire unit in the previous option, you\'ll need to enter a width for the unit here, or else you won\'t see any effect - 300px, 50%, etc.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'max_width',
				'std' 		=> '',
				'type' 		=> 'text',
				'class'		=> 'hide receiver receiver-left receiver-right receiver-center',
			),
			'subgroup_end' => array(
		    	'type'		=> 'subgroup_end',
		    ),
			'wpautop' => array(
				'name' 		=> __( 'WordPress Auto Formatting', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to apply wpautop on content. This shortcode will work best if you leave this set to true and wrap the [jumbotron] shortcode in the [raw] shortcode as shown in the example above. This way, WordPress’s automatic formatting will be applied when the shortcode is rendered <em>only</em>, and will turn out nicer.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'wpautop',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
		);

		// Panel.
		$options['panel'] = array(
			'style' => array(
				'name' 		=> __( 'Style', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Style of the panel.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'style',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'default' 	=> __( 'Default (grey)', 'theme-blvd-shortcodes' ),
					'primary' 	=> __( 'Primary (blue)', 'theme-blvd-shortcodes' ),
					'info' 		=> __( 'Info (lighter blue)', 'theme-blvd-shortcodes' ),
					'success' 	=> __( 'Success (green)', 'theme-blvd-shortcodes' ),
					'danger' 	=> __( 'Danger (red)', 'theme-blvd-shortcodes' ),
					'warning' 	=> __( 'Warning (yellow)', 'theme-blvd-shortcodes' ),
				),
			),
			'sc_content' => array(
				'name' 		=> __( 'Content', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>The content of the panel.</p><p><em>Note: The content can be further edited from your WordPress editor after being inserted.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Content here...',
				'type' 		=> 'textarea',
			),
			'title' => array(
				'name' 		=> __( 'Title (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The title of the panel.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'title',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'footer' => array(
				'name' 		=> __( 'Footer text (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Footer text for the panel.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'footer',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'text_align' => array(
				'name' 		=> __( 'Text Alignment', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to align text in panel.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'text_align',
				'std' 		=> 'left',
				'type' 		=> 'select',
				'options' 	=> array(
					'left' 		=> __( 'Left', 'theme-blvd-shortcodes' ),
					'right' 	=> __( 'Right', 'theme-blvd-shortcodes' ),
					'center' 	=> __( 'Center', 'theme-blvd-shortcodes' ),
				),
			),
			'class' => array(
				'name' 		=> __( 'CSS Class (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Any CSS classes you\'d like to add.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'class',
				'std' 		=> '',
				'type' 		=> 'text',
			),
		);

		// Popup.
		$options['popup'] = array(
			'header' => array(
				'name' 		=> __( 'Header Text (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Optional header text for the top of the popup.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'header',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'sc_content' => array(
				'name' 		=> __( 'Content', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>Content of the popup.</p><p><em>Note: The content can be further edited from your WordPress editor after being inserted.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Content here...',
				'type' 		=> 'textarea',
			),
			'animate' => array(
				'name' 		=> __( 'Popup Animation', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether the popup animates in or not, when it shows.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'animate',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'text' => array(
				'name' 		=> __( 'Button Text', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Text of the button to bring in the popup.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'text',
				'std' 		=> 'Button Text',
				'type' 		=> 'text',
			),
			'color' => array(
				'name' 		=> __( 'Button Color', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Color of button to popup.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'color',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> $colors,
			),
			'size' => array(
				'name' 		=> __( 'Button Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select the style of the panel.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'size',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'mini' 		=> __( 'Mini', 'theme-blvd-shortcodes' ),
					'small' 	=> __( 'Small', 'theme-blvd-shortcodes' ),
					'default' 	=> __( 'Default', 'theme-blvd-shortcodes' ),
					'large' 	=> __( 'Large', 'theme-blvd-shortcodes' ),
				),
			),
			'icon_before' => array(
				'name' 		=> __( 'Icon Before Button Text (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Icon before text of button to popup. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon_before',
				'std' 		=> '',
				'type' 		=> 'text',
				'icon'      => 'vector',
			),
			'icon_after' => array(
				'name' 		=> __( 'Icon After Button Text (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Icon after text of button to popup. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon_after',
				'std' 		=> '',
				'type' 		=> 'text',
				'icon'      => 'vector',
			),
		);

		// Quote.
		$options['blockquote'] = array(
			'quote' => array(
				'name' 		=> __( 'Quote Text', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The main text of the quote. You cannot use HTML here.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'quote',
				'std' 		=> 'Quote text...',
				'type' 		=> 'textarea',
			),
			'source' => array(
				'name' 		=> __( 'Quote Source (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Optional source for the quote.<br />Ex: John Smith', 'theme-blvd-shortcodes' ),
				'id' 		=> 'source',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'source_link' => array(
				'name' 		=> __( 'Quote Source URL (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Optional website URL to the source you entered in the previous option.<br />Ex: http://google.com', 'theme-blvd-shortcodes' ),
				'id' 		=> 'source_link',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'subgroup_start' => array(
		    	'type'		=> 'subgroup_start',
		    	'class'		=> 'show-hide-toggle',
		    ),
			'align' => array(
				'name' 		=> __( 'Alignment', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to align the entire quote block.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'align',
				'std' 		=> '0',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'None', 'theme-blvd-shortcodes' ),
					'left' 		=> __( 'Left', 'theme-blvd-shortcodes' ),
					'right' 	=> __( 'Right', 'theme-blvd-shortcodes' ),
				),
				'class'		=> 'trigger',
			),
			'max_width' => array(
				'name' 		=> __( 'Maximum Width', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'If you\'ve aligned the block quote in the previous option, you\'ll need to enter a width here, or else you won\'t see the proper result - 300px, 50%, etc.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'max_width',
				'std' 		=> '',
				'type' 		=> 'text',
				'class'		=> 'hide receiver receiver-left receiver-right',
			),
			'subgroup_end' => array(
		    	'type'		=> 'subgroup_end',
		    ),
			'class' => array(
				'name' 		=> __( 'CSS Class (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Any CSS classes you\'d like to add.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'class',
				'std' 		=> '',
				'type' 		=> 'text',
			),
		);

		// Testimonial.
		$options['testimonial'] = array(
		    'sc_content' => array(
				'name' 		=> __( 'Testimonial Text', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Enter any text of the testimonial.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Testimonial here...',
				'type' 		=> 'textarea',
			),
			'name' => array(
				'id' 		=> 'name',
				'name' 		=> __( 'Name', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'Enter the name of the person giving the testimonial.', 'theme-blvd-shortcodes' ),
				'type'		=> 'text',
		    ),
		    'tagline' => array(
				'id' 		=> 'tagline',
				'name' 		=> __( 'Tagline (optional)', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'Enter a tagline for the person giving the testimonial.<br>Ex: Founder and CEO', 'theme-blvd-shortcodes' ),
				'type'		=> 'text',
		    ),
		    'company' => array(
				'id' 		=> 'company',
				'name' 		=> __( 'Company (optional)', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'Enter the company the person giving the testimonial belongs to.', 'theme-blvd-shortcodes' ),
				'type'		=> 'text',
		    ),
		    'company_url' => array(
				'id' 		=> 'company_url',
				'name' 		=> __( 'Company URL (optional)', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'Enter the website URL for the company or the person giving the testimonial.', 'theme-blvd-shortcodes' ),
				'type'		=> 'text',
				'pholder'	=> 'http://',
		    ),
		    'image' => array(
				'id' 		=> 'image',
				'name' 		=> __( 'Image (optional)', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'Enter the URL for an image of the person giving the testimonial. This will look best if you select an image size that is square.<br>Ex: http://yoursite.com/image.jpg', 'theme-blvd-shortcodes' ),
				'type'		=> 'text',
		    ),
		);

		/**
		 * Display Posts
		 */

		// Blog.
		$options['blog'] = array(
			'category_name' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'theme-blvd-shortcodes' ),
				'id' 		=> 'category_name',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'theme-blvd-shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'theme-blvd-shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'numberposts' => array(
				'name' 		=> __( 'Number of Posts', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The number of posts to display for the post list. If you\'re using filtering, make sure to set this to a high number, or use <code>-1</code> to have no limit on the amount of posts queried.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'numberposts',
				'std' 		=> '4',
				'type' 		=> 'text',
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 			=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
					'ASC' 		=> __( 'Ascending', 'theme-blvd-shortcodes' ),
				),
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text',
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'thumbs' => array(
				'name' 		=> __( 'Featured Images', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Choose whether or not you want featured images to show for each post.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'thumbs',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' => array(
					'0' 		=> __( 'Use default blog setting', 'theme-blvd-shortcodes' ),
					'show'		=> __( 'Show featured images', 'theme-blvd-shortcodes' ), // Will be converted to "full" by shortcode.
					'hide' 		=> __( 'Hide featured images', 'theme-blvd-shortcodes' ),
				),
			),
			'meta' => array(
				'name' 		=> __( 'Meta Information', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like the meta information (like date posted, author, etc) to show for each post.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'meta',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'Use default blog setting', 'theme-blvd-shortcodes' ),
					'show'		=> __( 'Show meta info', 'theme-blvd-shortcodes' ),
					'hide' 		=> __( 'Hide meta info', 'theme-blvd-shortcodes' ),
				),
			),
		);

		// Post Grid.
		$options['post_grid'] = array(
			'category_name' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'theme-blvd-shortcodes' ),
				'id' 		=> 'category_name',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'theme-blvd-shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'theme-blvd-shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'columns' => array(
				'name' 		=> __( 'Columns', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Number of posts per row in the grid of posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'columns',
				'std' 		=> '3',
				'type' 		=> 'text',
			),
			'rows' => array(
				'name' 		=> __( 'Rows', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Number of rows in the grid of posts. This does not apply if you\'re using masonry or filtering.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'rows',
				'std' 		=> '3',
				'type' 		=> 'text',
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'' 				=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
					'ASC' 		=> __( 'Ascending', 'theme-blvd-shortcodes' ),
				),
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text',
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'filter' => array(
				'id' 		=> 'filter',
				'name'		=> __( 'Filtering', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'If you want to use filtering, select how the posts should be filtered by the website visitor.', 'theme-blvd-shortcodes' ),
				'type'		=> 'select',
				'std'		=> '',
				'options' => array(
					'0'				=> __( 'No filtering', 'theme-blvd-shortcodes' ),
					'category'		=> __( 'Filtered by category', 'theme-blvd-shortcodes' ),
					'tag'			=> __( 'Filtered by tag', 'theme-blvd-shortcodes' ),
					'portfolio'		=> __( 'Filtered by portfolio', 'theme-blvd-shortcodes' ),
					'portfolio_tag'	=> __( 'Filtered by portfolio tag', 'theme-blvd-shortcodes' ),
				),
			),
			'filter_max' => array(
		    	'id' 		=> 'filter_max',
				'name'		=> __( 'Filtering: Max Number of Posts', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'If you\'re using filtering, you can use this option to limit the total number of posts queried. Ex: <code>50</code>', 'theme-blvd-shortcodes' ),
				'type'		=> 'text',
				'std'		=> '',
			),
			'masonry' => array(
				'id' 		=> 'masonry',
				'name'		=> __( 'Masonry', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'Select if you\'d like the grid to be display in masonry mode.', 'theme-blvd-shortcodes' ),
				'type'		=> 'select',
				'std'		=> '',
				'options' => array(
					'0'			=> __( 'False', 'theme-blvd-shortcodes' ),
					'true'		=> __( 'True', 'theme-blvd-shortcodes' ),
				),
			),
			'masonry_max' => array(
		    	'id' 		=> 'masonry_max',
				'name'		=> __( 'Masonry: Max Number of Posts', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'If using masonry (and not filtering), the maximum number of total posts to pull. Ex: <code>12</code>', 'theme-blvd-shortcodes' ),
				'type'		=> 'text',
				'std'		=> '',
			),
			'meta' => array(
				'name' 		=> __( 'Meta Information', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like the meta information (like date posted, author, etc) to show for each post.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'meta',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post grid setting', 'theme-blvd-shortcodes' ),
					'show'		=> __( 'Show meta info', 'theme-blvd-shortcodes' ),
					'hide' 		=> __( 'Hide meta info', 'theme-blvd-shortcodes' ),
				),
			),
			'excerpt' => array(
				'name' 		=> __( 'Excerpt', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like to show the excerpt or not for each post.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'excerpt',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post grid setting', 'theme-blvd-shortcodes' ),
					'show'		=> __( 'Show excerpts', 'theme-blvd-shortcodes' ),
					'hide' 		=> __( 'Hide excerpts', 'theme-blvd-shortcodes' ),
				),
			),
			'more' => array(
				'name' 		=> __( 'Read More', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'What would you like to show for each post to lead the reader to the full post?', 'theme-blvd-shortcodes' ),
				'id' 		=> 'more',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post grid setting', 'theme-blvd-shortcodes' ),
					'text' 		=> __( 'Show text link', 'theme-blvd-shortcodes' ),
					'button'	=> __( 'Show button', 'theme-blvd-shortcodes' ),
					'none'		=> __( 'Show no button or text link', 'theme-blvd-shortcodes' ),
				),
			),
			'crop' => array(
				'name' 		=> __( 'Featured Image Crop Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select a custom crop size to be used for the images in the grid. If you select a crop size that doesn\'t have a consistent height, then you may want to enable "Masonry" display from above.<br><br><em>Note: Images are scaled proportionally to fit within their current containers.</em>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'crop',
				'std' 		=> 'tb_grid',
				'type'		=> 'select',
				'select'	=> 'crop',
			),
		);

		// Post Showcase.
		$options['post_showcase'] = array(
			'category_name' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'theme-blvd-shortcodes' ),
				'id' 		=> 'category_name',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'theme-blvd-shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'theme-blvd-shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'columns' => array(
				'name' 		=> __( 'Columns', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Number of posts per row in the grid of posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'columns',
				'std' 		=> '3',
				'type' 		=> 'text',
			),
			'rows' => array(
				'name' 		=> __( 'Rows', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Number of rows in the grid of posts. This does not apply if you\'re using masonry or filtering.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'rows',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'' 				=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
					'ASC' 		=> __( 'Ascending', 'theme-blvd-shortcodes' ),
				),
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text',
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'filter' => array(
				'id' 		=> 'filter',
				'name'		=> __( 'Filtering', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'If you want to use filtering, select how the posts should be filtered by the website visitor.', 'theme-blvd-shortcodes' ),
				'type'		=> 'select',
				'std'		=> '',
				'options' => array(
					'0'				=> __( 'No filtering', 'theme-blvd-shortcodes' ),
					'category'		=> __( 'Filtered by category', 'theme-blvd-shortcodes' ),
					'tag'			=> __( 'Filtered by tag', 'theme-blvd-shortcodes' ),
					'portfolio'		=> __( 'Filtered by portfolio', 'theme-blvd-shortcodes' ),
					'portfolio_tag'	=> __( 'Filtered by portfolio tag', 'theme-blvd-shortcodes' ),
				),
			),
			'filter_max' => array(
		    	'id' 		=> 'filter_max',
				'name'		=> __( 'Filtering: Max Number of Posts', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'If you\'re using filtering, you can use this option to limit the total number of posts queried. Ex: <code>50</code>', 'theme-blvd-shortcodes' ),
				'type'		=> 'text',
				'std'		=> '',
			),
			'masonry' => array(
				'id' 		=> 'masonry',
				'name'		=> __( 'Masonry', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'Select if you\'d like the grid to be display in masonry mode.', 'theme-blvd-shortcodes' ),
				'type'		=> 'select',
				'std'		=> 'true',
				'options' => array(
					'0'			=> __( 'False', 'theme-blvd-shortcodes' ),
					'true'		=> __( 'True', 'theme-blvd-shortcodes' ),
				),
			),
			'masonry_max' => array(
		    	'id' 		=> 'masonry_max',
				'name'		=> __( 'Masonry: Max Number of Posts', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'If using masonry (and not filtering), the maximum number of total posts to pull. Ex: <code>12</code>', 'theme-blvd-shortcodes' ),
				'type'		=> 'text',
				'std'		=> '12',
			),
			'titles' => array(
				'name' 		=> __( 'Titles', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like to show the title or not for each post.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'titles',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post showcase setting', 'theme-blvd-shortcodes' ),
					'show'		=> __( 'Show titles', 'theme-blvd-shortcodes' ),
					'hide' 		=> __( 'Hide titles', 'theme-blvd-shortcodes' ),
				),
			),
			'excerpt' => array(
				'name' 		=> __( 'Excerpt', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like to show the excerpt or not for each post.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'excerpt',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post showcase setting', 'theme-blvd-shortcodes' ),
					'show'		=> __( 'Show excerpts', 'theme-blvd-shortcodes' ),
					'hide' 		=> __( 'Hide excerpts', 'theme-blvd-shortcodes' ),
				),
			),
			'crop' => array(
				'name' 		=> __( 'Featured Image Crop Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select a custom crop size to be used for the images in the showcase. If you select a crop size that doesn\'t have a consistent height, then you may want to enable "Masonry" display from above.<br><br><em>Note: Images are scaled proportionally to fit within their current containers.</em>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'crop',
				'std' 		=> 'tb_large',
				'type'		=> 'select',
				'select'	=> 'crop',
			),
		);

		// Post List.
		$options['post_list'] = array(
			'category_name' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'theme-blvd-shortcodes' ),
				'id' 		=> 'category_name',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'theme-blvd-shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'theme-blvd-shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'numberposts' => array(
				'name' 		=> __( 'Number of Posts', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The number of posts to display for the post list. If you\'re using filtering, make sure to set this to a high number, or use <code>-1</code> to have no limit on the amount of posts queried.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'numberposts',
				'std' 		=> '4',
				'type' 		=> 'text',
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 			=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
					'ASC' 		=> __( 'Ascending', 'theme-blvd-shortcodes' ),
				),
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text',
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'filter' => array(
				'id' 		=> 'filter',
				'name'		=> __( 'Filtering', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'If you want to use filtering, select how the posts should be filtered by the website visitor.', 'theme-blvd-shortcodes' ),
				'type'		=> 'select',
				'std'		=> '',
				'options' => array(
					'0'				=> __( 'No filtering', 'theme-blvd-shortcodes' ),
					'category'		=> __( 'Filtered by category', 'theme-blvd-shortcodes' ),
					'tag'			=> __( 'Filtered by tag', 'theme-blvd-shortcodes' ),
					'portfolio'		=> __( 'Filtered by portfolio', 'theme-blvd-shortcodes' ),
					'portfolio_tag'	=> __( 'Filtered by portfolio tag', 'theme-blvd-shortcodes' ),
				),
			),
			'thumbs' => array(
				'name' 		=> __( 'Featured Images', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Choose whether or not you want featured images to show for each post.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'thumbs',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' => array(
					'0' 		=> __( 'Use default post list setting', 'theme-blvd-shortcodes' ),
					'show'		=> __( 'Show featured images', 'theme-blvd-shortcodes' ), // Will be converted to "full" by shortcode.
					'date'		=> __( 'Show date block', 'theme-blvd-shortcodes' ),
					'hide' 		=> __( 'Hide featured images', 'theme-blvd-shortcodes' ),
				),
			),
			'meta' => array(
				'name' 		=> __( 'Meta Information', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like the meta information (like date posted, author, etc) to show for each post.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'meta',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'Use default post list setting', 'theme-blvd-shortcodes' ),
					'show'		=> __( 'Show meta info', 'theme-blvd-shortcodes' ),
					'hide' 		=> __( 'Hide meta info', 'theme-blvd-shortcodes' ),
				),
			),
			'more' => array(
				'name' 		=> __( 'Read More', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'What would you like to show for each post to lead the reader to the full post?', 'theme-blvd-shortcodes' ),
				'id' 		=> 'more',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'Use default post list setting', 'theme-blvd-shortcodes' ),
					'text' 		=> __( 'Show text link', 'theme-blvd-shortcodes' ),
					'button'	=> __( 'Show button', 'theme-blvd-shortcodes' ),
					'none'		=> __( 'Show no button or text link', 'theme-blvd-shortcodes' ),
				),
			),
		);

		// Mini Post Grid.
		$options['mini_post_grid'] = array(
			'category_name' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'theme-blvd-shortcodes' ),
				'id' 		=> 'category_name',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'theme-blvd-shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'numberposts' => array(
				'name' 		=> __( 'Number of Posts', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The number of posts to display for the post grid.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'numberposts',
				'std' 		=> '4',
				'type' 		=> 'text',
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 			=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
					'ASC' 		=> __( 'Ascending', 'theme-blvd-shortcodes' ),
				),
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text',
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'align' => array(
				'name' 		=> __( 'Alignment', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to align grid of thumbnails.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'align',
				'std' 		=> 'left',
				'type' 		=> 'select',
				'options' 	=> array(
					'left' 		=> __( 'Left', 'theme-blvd-shortcodes' ),
					'right' 	=> __( 'Right', 'theme-blvd-shortcodes' ),
				),
			),
			'gallery' => array(
				'name' 		=> __( 'Galery Override', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'If you’d like to display images from a gallery instead of featured images of standard posts, you can input the ID’s of the attachments to use in the gallery.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'gallery',
				'std' 		=> '',
				'type' 		=> 'text',
			),
		);

		// Min Post List.
		$options['mini_post_list'] = array(
			'thumb' => array(
				'name' 		=> __( 'Thumbnail Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Size of the featured images for the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'thumb',
				'std' 		=> 'smaller',
				'type' 		=> 'select',
				'options' 	=> array(
					'hide'		=> __( 'Hide', 'theme-blvd-shortcodes' ),
					'small' 	=> __( 'Small', 'theme-blvd-shortcodes' ),
					'smaller' 	=> __( 'Smaller', 'theme-blvd-shortcodes' ),
					'smallest' 	=> __( 'Smallest', 'theme-blvd-shortcodes' ),
					'date'		=> __( 'Date Block', 'theme-blvd-shortcodes' ),
				),
			),
			'meta' => array(
				'name' 		=> __( 'Post Meta', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to show post date below post titles.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'meta',
				'std' 		=> 'show',
				'type' 		=> 'select',
				'options' 	=> array(
					'show' 		=> __( 'Show', 'theme-blvd-shortcodes' ),
					'hide' 		=> __( 'Hide', 'theme-blvd-shortcodes' ),
				),
			),
			'category_name' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'theme-blvd-shortcodes' ),
				'id' 		=> 'category_name',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'theme-blvd-shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'numberposts' => array(
				'name' 		=> __( 'Number of Posts', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The number of posts to display for the post list.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'numberposts',
				'std' 		=> '4',
				'type' 		=> 'text',
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 			=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
					'ASC' 		=> __( 'Ascending', 'theme-blvd-shortcodes' ),
				),
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text',
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'columns' => array(
				'name' 		=> __( 'Column Spread', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Here, you can choose to list out your posts separated into columns.<br><br><em>Note: For best results, set your "Number of Posts" option above to a number divisable by the number of columns.</em>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'columns',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'1'			=> __( 'Don\'t spread across multiple columns', 'theme-blvd-shortcodes' ),
					'2'			=> __( '2 Columns', 'theme-blvd-shortcodes' ),
					'3' 		=> __( '3 Columns', 'theme-blvd-shortcodes' ),
					'4' 		=> __( '4 Columns', 'theme-blvd-shortcodes' ),
					'5' 		=> __( '5 Columns', 'theme-blvd-shortcodes' ),
					'6' 		=> __( '6 Columns', 'theme-blvd-shortcodes' ),
				),
			),
		);

		/**
		 * Inline Elements
		 */

		// Dropcap.
		$options['dropcap'] = array(
			'sc_content' => array(
				'name' 		=> __( 'Dropcap Letter', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The letter you want to appear large, or "dropped."', 'theme-blvd-shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'A',
				'type' 		=> 'text',
			),
		);

		// Text Highlight.
		$options['highlight'] = array(
			'sc_content' => array(
				'name' 		=> __( 'Content', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Enter a single paragraph of text you\'d like to be highlighted.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'This text will be highlighted.',
				'type' 		=> 'textarea',
			),
		);

		// Icon Link.
		$options['icon_link'] = array(
			'icon' => array(
				'name' 		=> __( 'Link Icon', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Enter an icon name. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon',
				'std' 		=> 'link',
				'type' 		=> 'text',
				'icon'      => 'vector',
			),
			'link' => array(
				'name' 		=> __( 'Link URL', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The full URL of where you want the link to go.<br />Ex: http://google.com', 'theme-blvd-shortcodes' ),
				'id' 		=> 'link',
				'std' 		=> 'http://google.com',
				'type' 		=> 'text',
			),
			'sc_content' => array(
				'name' 		=> __( 'Link Text', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The text of the link.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Link Text...',
				'type' 		=> 'text',
			),
			'color' => array(
				'name' 		=> __( 'Link Icon Color (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Enter a color for the icon, will default to website\'s link color. - Ex: #666666', 'theme-blvd-shortcodes' ),
				'id' 		=> 'color',
				'std' 		=> '',
				'type' 		=> 'color',
			),
			'target' => array(
				'name' 		=> __( 'Button Target', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How the button opens the link.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'target',
				'std' 		=> '_self',
				'type' 		=> 'select',
				'options' 	=> array(
					'_self' 		=> __( 'Same Window', 'theme-blvd-shortcodes' ),
					'_blank' 		=> __( 'New Window', 'theme-blvd-shortcodes' ),
					'lightbox' 		=> __( 'Lightbox', 'theme-blvd-shortcodes' ),
				),
			),
			'title' => array(
				'name' 		=> __( 'Button Title (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'For you SEO folks, this controls the link\'s HTML title tag. If left blank, this will just default to the link\'s text.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'title',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'class' => array(
				'name' 		=> __( 'Button CSS Class (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'This will allow you to add an extra CSS class for styling to the link.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'class',
				'std' 		=> '',
				'type' 		=> 'text',
			),
		);

		// Label.
		$options['label'] = array(
			'sc_content' => array(
				'name' 		=> __( 'Label Text', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The text of the label.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Label Text...',
				'type' 		=> 'text',
			),
			'style' => array(
				'name' 		=> __( 'Style', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The style of the label.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'style',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'default' 	=> __( 'Default (grey)', 'theme-blvd-shortcodes' ),
					'info' 		=> __( 'Info (blue)', 'theme-blvd-shortcodes' ),
					'success' 	=> __( 'Success (green)', 'theme-blvd-shortcodes' ),
					'danger' 	=> __( 'Danger (red)', 'theme-blvd-shortcodes' ),
					'warning' 	=> __( 'Warning (yellow)', 'theme-blvd-shortcodes' ),
				),
			),
			'icon' => array(
				'name' 		=> __( 'Label Icon (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Enter an icon name to appear at the start of the label. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon',
				'std' 		=> '',
				'type' 		=> 'text',
				'icon'      => 'vector',
			),
		);

		// Lead text.
		$options['lead'] = array(
			'sc_content' => array(
				'name' 		=> __( 'Lead Text', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Enter a single paragraph of text you\'d like to show a bit larger than the standard body text.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'This text will show larger than the standard body text.',
				'type' 		=> 'textarea',
			),
		);

		/**
		 * Pricing Table
		 */

		$options['pricing_table'] = array();

		/**
		 * Siders
		 */

		// Custom Slider.
		$options['slider'] = array(
			'id' => array(
				'name' 		=> __( 'Slider ID', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select from your your custom-built sliders, using the <a href="http://wordpress.org/plugins/theme-blvd-sliders/" target="_blank">Theme Blvd Sliders plugin</a>.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'id',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> $this->sliders,
			),
		);

		// Gallery Slider.
		$options['gallery_slider'] = array(
			'ids' => array(
				'name' 		=> __( 'Image ID\'s', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Comma separated list of attachments ID’s.<br />Ex: 293,294,295', 'theme-blvd-shortcodes' ),
				'id' 		=> 'ids',
				'std' 		=> '1,2,3',
				'type' 		=> 'text',
			),
			'title' => array(
				'name' 		=> __( 'Titles', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to display titles of attachments over slides.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'title',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'caption' => array(
				'name' 		=> __( 'Captions', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to display captions of attachments over slides.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'caption',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'size' => array(
				'name' 		=> __( 'Image Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Crop size for images, use "full" to display uncropped versions of the images.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'size',
				'std' 		=> 'slider-large',
				'type' 		=> 'text',
			),
			'interval' => array(
				'name' 		=> __( 'Slider Speed', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Milliseconds between auto slide transitions. For example, 5000 milliseconds = 5 seconds.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'interval',
				'std' 		=> '5000',
				'type' 		=> 'text',
			),
			'pause' => array(
				'name' 		=> __( 'Pause on Hover', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to pause slider on mouse hover.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'pause',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'frame' => array(
				'name' 		=> __( 'Frame', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to wrap the slider in a frame or not.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'frame',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'nav_standard' => array(
				'name' 		=> __( 'Standard Navigation', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to show standard navigation indicator dots.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'nav_standard',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'nav_arrows' => array(
				'name' 		=> __( 'Navigation Arrows', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to show standard navigation arrows.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'nav_arrows',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'subgroup_start' => array(
		    	'type'		=> 'subgroup_start',
		    	'class'		=> 'show-hide-toggle',
		    ),
			'nav_thumbs' => array(
				'name' 		=> __( 'Thumbnail Navigation', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to include thumbnail images to navigate the slider.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'nav_thumbs',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
				'class'		=> 'trigger',
			),
			'thumb_size' => array(
				'name' 		=> __( 'Thumbnail Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select the size of the images for the thumbnail navigation.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'thumb_size',
				'std' 		=> 'square_smallest',
				'type' 		=> 'select',
				'options' 	=> array(
					'small' 	=> __( 'Small', 'theme-blvd-shortcodes' ),
					'smaller' 	=> __( 'Smaller', 'theme-blvd-shortcodes' ),
					'smallest' 	=> __( 'Smallest', 'theme-blvd-shortcodes' ),
				),
				'class'		=> 'receiver receiver-true',
			),
			'subgroup_end' => array(
		    	'type'		=> 'subgroup_end',
		    ),
		    'dark_text' => array(
				'name' 		=> __( 'Dark Text', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to use dark text for titles, captions, and standard nav; use when images are light.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'dark_text',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
		);

		// Post Slider.
		$options['post_slider'] = array(
			'style' => array(
				'name' 		=> __( 'Display Style', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select one of the preset style for how the post slider displays. When referring to "included elements" it\'s referring to post titles, meta, excerpts, and buttons configured in the following options.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'style',
				'std' 		=> '1',
				'type' 		=> 'select',
				'options'	=> apply_filters('themeblvd_post_slider_styles', array(
					'1'			=> __( 'Style #1', 'theme-blvd-shortcodes' ),
					'2'			=> __( 'Style #2', 'theme-blvd-shortcodes' ),
					'3'			=> __( 'Style #3', 'theme-blvd-shortcodes' ),
				)),
			),
			'interval' => array(
				'name' 		=> __( 'Slider Speed', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Seconds in between transitions, 0 for no auto-advancing.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'interval',
				'std' 		=> '3',
				'type' 		=> 'text',
			),
			'nav_standard' => array(
				'name' 		=> __( 'Navigation Dots', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to show standard navigation dots to control slider.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'nav_standard',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'nav_arrows' => array(
				'name' 		=> __( 'Navigation Arrows', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to show navigation arows to control slider.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'nav_arrows',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'nav_thumbs' => array(
				'name' 		=> __( 'Navigation Thumbnails', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to show thumbnail navigation to control slider.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'nav_thumbs',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'pause' => array(
				'name' 		=> __( 'Pause on Hover', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to pause slider rotation on mouse hover.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'pause',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'crop' => array(
				'name' 		=> __( 'Image Crop Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Crop size for featured image used as each slide.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'crop',
				'std' 		=> 'slider-large',
				'type' 		=> 'select',
				'select'	=> 'crop',
			),
			'slide_link' => array(
				'name' 		=> __( 'Link Handling', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select how the user interacts with each slide and where they\'re directed to.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'slide_link',
				'std' 		=> 'button',
				'type' 		=> 'select',
				'options'	=> array(
					'0'				=> __( 'No linking', 'theme-blvd-shortcodes' ),
					'image_post'	=> __( 'Images link to posts', 'theme-blvd-shortcodes' ),
					'image_link'	=> __( 'Images link to each post\'s featured image link setting', 'theme-blvd-shortcodes' ),
					'button'		=> __( 'Slides have buttons linking to posts', 'theme-blvd-shortcodes' ),
				),
			),
			'button_text' => array(
				'name' 		=> __( 'Button Text', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'If you selected to show buttons, here you can set the text of the buttons.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'button_text',
				'std' 		=> 'View Post',
				'type' 		=> 'text',
			),
			'button_size' => array(
				'id' 		=> 'button_size',
				'name'		=> __( 'Button Size', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'If you selected to show buttons, here you can set the size of the buttons.', 'theme-blvd-shortcodes' ),
				'type'		=> 'select',
				'std'		=> 'default',
				'options'	=> array(
					'mini' 		=> __( 'Mini', 'theme-blvd-shortcodes' ),
					'small' 	=> __( 'Small', 'theme-blvd-shortcodes' ),
					'default' 	=> __( 'Normal', 'theme-blvd-shortcodes' ),
					'large' 	=> __( 'Large', 'theme-blvd-shortcodes' ),
					'x-large' 	=> __( 'Extra Large', 'theme-blvd-shortcodes' ),
				),
				'class'		=> 'hide receiver receiver-button',
			),
			'category' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'theme-blvd-shortcodes' ),
				'id' 		=> 'category',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'theme-blvd-shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'theme-blvd-shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'numberposts' => array(
				'name' 		=> __( 'Number of Posts', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The number of posts to display for the slider.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'numberposts',
				'std' 		=> '5',
				'type' 		=> 'text',
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 			=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
					'ASC' 		=> __( 'Ascending', 'theme-blvd-shortcodes' ),
				),
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text',
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'dark_text'	=> array(
				'name' 		=> __( 'Use Dark Text', 'theme-blvd-shortcodes' ),
				'id'		=> 'dark_text',
				'desc'		=> __( 'Use dark navigation elements and dark text for any titles and descriptions.', 'theme-blvd-shortcodes' ),
				'std'		=> 'false',
				'type'		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'title'	=> array(
				'name' 		=> __( 'Show Post Titles', 'theme-blvd-shortcodes' ),
				'id'		=> 'title',
				'desc'		=> __( 'Display title for each post.', 'theme-blvd-shortcodes' ),
				'std'		=> 'true',
				'type'		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'meta'	=> array(
				'name' 		=> __( 'Show Post Meta', 'theme-blvd-shortcodes' ),
				'id'		=> 'meta',
				'desc'		=> __( 'Display meta info for each post.', 'theme-blvd-shortcodes' ),
				'std'		=> 'true',
				'type'		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'excerpts'	=> array(
				'name' 		=> __( 'Show Post Excerpts', 'theme-blvd-shortcodes' ),
				'id'		=> 'excerpts',
				'desc'		=> __( 'Display excerpt for each post.', 'theme-blvd-shortcodes' ),
				'std'		=> 'false',
				'type'		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
		);

		// Post Slider.
		$options['post_grid_slider'] = array(
			'timeout' => array(
				'name' 		=> __( 'Slider Speed', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Seconds in between transitions, 0 for no auto-advancing.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'timeout',
				'std' 		=> '3',
				'type' 		=> 'text',
			),
			'nav' => array(
				'name' 		=> __( 'Slider Navigation', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to show slider navigation.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'nav',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'columns' => array(
				'name' 		=> __( 'Columns', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Number of posts per row in each slide.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'columns',
				'std' 		=> '3',
				'type' 		=> 'text',
			),
			'slides' => array(
		    	'id' 		=> 'slides',
				'name'		=> __( 'Maximum Number of Slides', 'theme-blvd-shortcodes' ),
				'desc'		=> __( 'Enter in the maximum number of slides you\'d like to show. The number you enter here will be multiplied by the amount of columns you selected in the previous option to figure out how many posts should be showed in the slider. You can leave this option blank if you\'d like to show all posts from your configured query.', 'theme-blvd-shortcodes' ),
				'type'		=> 'text',
				'std'		=> '3',
			),
			'category_name' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'theme-blvd-shortcodes' ),
				'id' 		=> 'category_name',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'theme-blvd-shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'theme-blvd-shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 			=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
					'ASC' 		=> __( 'Ascending', 'theme-blvd-shortcodes' ),
				),
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text',
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'meta' => array(
				'name' 		=> __( 'Meta Information', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like the meta information (like date posted, author, etc) to show for each post.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'meta',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post grid setting', 'theme-blvd-shortcodes' ),
					'show'		=> __( 'Show meta info', 'theme-blvd-shortcodes' ),
					'hide' 		=> __( 'Hide meta info', 'theme-blvd-shortcodes' ),
				),
			),
			'excerpt' => array(
				'name' 		=> __( 'Excerpt', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like to show the excerpt or not for each post.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'excerpt',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post grid setting', 'theme-blvd-shortcodes' ),
					'show'		=> __( 'Show excerpts', 'theme-blvd-shortcodes' ),
					'hide' 		=> __( 'Hide excerpts', 'theme-blvd-shortcodes' ),
				),
			),
			'more' => array(
				'name' 		=> __( 'Read More', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'What would you like to show for each post to lead the reader to the full post?', 'theme-blvd-shortcodes' ),
				'id' 		=> 'more',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post grid setting', 'theme-blvd-shortcodes' ),
					'text' 		=> __( 'Show text link', 'theme-blvd-shortcodes' ),
					'button'	=> __( 'Show button', 'theme-blvd-shortcodes' ),
					'none'		=> __( 'Show no button or text link', 'theme-blvd-shortcodes' ),
				),
			),
			'crop' => array(
				'name' 		=> __( 'Featured Image Crop Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select a custom crop size to be used for the images in the grid. If you select a crop size that doesn\'t have a consistent height, then you may want to enable "Masonry" display from above.<br><br><em>Note: Images are scaled proportionally to fit within their current containers.</em>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'crop',
				'std' 		=> 'tb_grid',
				'type'		=> 'select',
				'select'	=> 'crop',
			),
		);

		/**
		 * Stats
		 */

		// Progress Bar.
		$options['progress_bar'] = array(
			'label' => array(
				'name' 		=> __( 'Label', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Enter a label for what this bar represents.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'label',
				'std' 		=> 'Graphic Design',
				'type' 		=> 'text',
			),
			'percent' => array(
				'name' 		=> __( 'Bar Percent', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'A percentage of how far the bar is.<br>Ex: 25, 50, 80, etc.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'percent',
				'std' 		=> '50',
				'type' 		=> 'text',
			),
			'color' => array(
				'name' 		=> __( 'Bar Color', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Color of the bar.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'color',
				'std' 		=> '#428bca',
				'type' 		=> 'color',
			),
		);

		// Milestone.
		$options['milestone'] = array(
			'milestone' => array(
				'id' 		=> 'milestone',
				'name'		=> __( 'Milestone', 'themeblvd' ),
				'desc'		=> __( 'Enter the accomplished milestone Optionally, you may include symbols before and/or after the number.<br>Ex: 500, $500, 500+, etc', 'themeblvd' ),
				'std'		=> '500',
				'type'		=> 'text',
			),
			'color' => array(
				'id' 		=> 'color',
				'name'		=> __( 'Milestone Color', 'themeblvd' ),
				'desc'		=> __( 'Text color for the milestone number.', 'themeblvd' ),
				'std'		=> '#0c9df0',
				'type'		=> 'color',
			),
			'text' => array(
				'id' 		=> 'text',
				'name'		=> __( 'Description', 'themeblvd' ),
				'desc'		=> __( 'Enter a very simple description for the milestone number.', 'themeblvd' ),
				'std'		=> 'Cups of Coffee',
				'type'		=> 'text',
			),
			'boxed' => array(
				'id' 		=> 'boxed',
				'name'		=> __( 'Boxed', 'themeblvd' ),
				'desc'		=> __( 'Select whether or not to wrap the milestone in a box.', 'themeblvd' ),
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
		);

		// Milestone Ring.
		$options['milestone_ring'] = array(
			'percent' => array(
				'id' 		=> 'percent',
				'name'		=> __( 'Milestone Percent', 'themeblvd' ),
				'desc'		=> __( 'Enter an integer that is a fraction of 100. This will be represented as a visual percentage.<br>Ex: 25, 50, 75, etc.', 'themeblvd' ),
				'std'		=> '75',
				'type'		=> 'text',
			),
			'color' => array(
				'id' 		=> 'color',
				'name'		=> __( 'Milestone Color', 'themeblvd' ),
				'desc'		=> __( 'This is the color of the milestone ring, which is a visual representation of the percentage.', 'themeblvd' ),
				'std'		=> '#0c9df0',
				'type'		=> 'color',
			),
			'display' => array(
				'id' 		=> 'display',
				'name'		=> __( 'Display', 'themeblvd' ),
				'desc'		=> __( 'Enter the text to display in the middle of the block.<br>Ex: 25%, 50%, 75%, etc.', 'themeblvd' ),
				'std'		=> '75%',
				'type'		=> 'text',
			),
			'title' => array(
				'id' 		=> 'title',
				'name'		=> __( 'Title (optional)', 'themeblvd' ),
				'desc'		=> __( 'Enter a short title to display below the milestone.', 'themeblvd' ),
				'type'		=> 'text',
			),
			'text' => array(
				'id' 		=> 'text',
				'name'		=> __( 'Description (optional)', 'themeblvd' ),
				'desc'		=> __( 'Enter a short description to display below the milestone.', 'themeblvd' ),
				'type'		=> 'textarea',
			),
			'text_align' => array(
				'id' 		=> 'text_align',
				'name'		=> __( 'Text Alignment', 'themeblvd' ),
				'desc'		=> __( 'If you\'ve entered a title and/or description, select how would you like the text aligned.', 'themeblvd' ),
				'std'		=> 'center',
				'type'		=> 'select',
				'options'	=> array(
					'left' 		=> __( 'Left', 'theme-blvd-shortcodes' ),
					'right' 	=> __( 'Right', 'theme-blvd-shortcodes' ),
					'center' 	=> __( 'Center', 'theme-blvd-shortcodes' ),
				),
			),
			'boxed' => array(
				'id' 		=> 'boxed',
				'name'		=> __( 'Boxed', 'themeblvd' ),
				'desc'		=> __( 'Select whether or not to wrap the milestone in a box.', 'themeblvd' ),
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
		);

		/**
		 * Tabs
		 */

		$options['tabs'] = array(
			'num' => array(
				'name' 		=> __( 'Number of Tabs', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Enter the number of tabs. This will help you to setup this example starting point to insert into your page or post.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'num',
				'std' 		=> '3',
				'type' 		=> 'select',
				'options' 	=> array(
					'1' 		=> '1',
					'2' 		=> '2',
					'3' 		=> '3',
					'4' 		=> '4',
					'5' 		=> '5',
					'6' 		=> '6',
					'7' 		=> '7',
					'8' 		=> '8',
					'9' 		=> '9',
					'10' 		=> '10',
					'11' 		=> '11',
					'12' 		=> '12',
				),
			),
			'style' => array(
				'name' 		=> __( 'Style', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The tabs can styled to be framed or open. When the tabs are framed, there will be a box around each tab\'s content.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'style',
				'std' 		=> 'pills',
				'type' 		=> 'select',
				'options' 	=> array(
					'framed' 	=> __( 'Framed', 'theme-blvd-shortcodes' ),
					'open' 		=> __( 'Open', 'theme-blvd-shortcodes' ),
				),
			),
			'nav' => array(
				'name' 		=> __( 'Navigation Style', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The "Tabs" style navigation will be the typical choice here, but use "Pills" for different look.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'nav',
				'std' 		=> 'tabs',
				'type' 		=> 'select',
				'options' 	=> array(
					'tabs' 		=> __( 'Tabs', 'theme-blvd-shortcodes' ),
					'pills' 	=> __( 'Pills', 'theme-blvd-shortcodes' ),
				),
			),
		);

		/**
		 * Toggles
		 */

		$options['accordion'] = array(
			'desc' => array(
				'desc' 		=> __( 'The [accordion] shortcode is simply a way to group your toggles. When one toggle in an accodion is opened, all other toggles within will be closed.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'desc',
				'type' 		=> 'info',
			),
			'num' => array(
				'name' 		=> __( 'Number of Toggles', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Enter the number of toggles. This will help you to setup this example starting point to insert into your page or post.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'num',
				'std' 		=> '3',
				'type' 		=> 'select',
				'options' 	=> array(
					'2' 		=> '2',
					'3' 		=> '3',
					'4' 		=> '4',
					'5' 		=> '5',
					'6' 		=> '6',
					'7' 		=> '7',
					'8' 		=> '8',
					'9' 		=> '9',
					'10' 		=> '10',
					'11' 		=> '11',
					'12' 		=> '12',
				),
			),
		);

		$options['toggle'] = array(
			'title' => array(
				'name' 		=> __( 'Toggle Title', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The title text of the toggle, which is clicked to reveal the content.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'title',
				'std' 		=> 'Title here...',
				'type' 		=> 'text',
			),
			'sc_content' => array(
				'name' 		=> __( 'Toggle Content', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>The content within the toggle.</p><p><em>Note: The content can be further edited from your WordPress editor after being inserted.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Content here...',
				'type' 		=> 'textarea',
			),
		);

		/**
		 * Vector Icons
		 */

		$options['vector_icon'] = array(
			'icon' => array(
				'name' 		=> __( 'Icon', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Enter an icon name. You can browse available FontAwesome icons in the above browser.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon',
				'std' 		=> '',
				'type' 		=> 'text',
				'icon'      => 'vector',
			),
			'color' => array(
				'name' 		=> __( 'Icon Color (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Enter a color for the icon - Ex: #666666', 'theme-blvd-shortcodes' ),
				'id' 		=> 'color',
				'std' 		=> '',
				'type' 		=> 'color',
			),
			'size' => array(
				'name' 		=> __( 'Icon Size (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Enter a size for the icon - 20px, 2em, etc.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'size',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'rotate' => array(
				'name' 		=> __( 'Icon Rotation (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select how you\'d like to rotate the icon.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'rotate',
				'std' 		=> '0',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'None', 'theme-blvd-shortcodes' ),
					'90' 		=> '90',
					'180' 		=> '180',
					'270' 		=> '270',
				),
			),
			'flip' => array(
				'name' 		=> __( 'Icon Flip (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select how you\'d like to flip the icon.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'flip',
				'std' 		=> '0',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 			=> __( 'None', 'theme-blvd-shortcodes' ),
					'horizontal'	=> __( 'Horizontal', 'theme-blvd-shortcodes' ),
					'vertical' 		=> __( 'Vertical', 'theme-blvd-shortcodes' ),
				),
			),
			'class' => array(
				'name' 		=> __( 'Icon CSS Class (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'For those that are familiar with FontAwesome, here you can add your own CSS class to the icon, if you want.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'class',
				'std' 		=> '',
				'type' 		=> 'text',
			),
		);

		/**
		 * Filter array of all options for all shortcodes.
		 *
		 * @since 1.5.0
		 *
		 * @var array
		 */
		$options = apply_filters( 'themeblvd_shortcodes_options', $options );

		/**
		 * Filter array of options for a specific type
		 * of shortcode element.
		 *
		 * @since 1.6.0
		 *
		 * @var array
		 */
		return apply_filters( "themeblvd_shortcodes_options_{$type}", $options[ $type ] );

	}

	/**
	 * Display a preview for the shortcode as it's
	 * being configured.
	 *
	 * @since 1.4.0
	 *
	 * @param string $group The group in generator tabs that is open.
	 * @param string $subgroup The subgroup (if any) in generator tabs that is open.
	 */
	private function preview( $group, $subgroup = '' ) {

		$content = 'false';

		/**
		 * Filter the shortcodes that have their examples
		 * wrapped in [raw].
		 *
		 * @since 1.4.0
		 *
		 * @var array
		 */
		$raw_items = apply_filters( 'themeblvd_raw_shortcodes', array( 'jumbotron', 'column', 'tabs' ) );

		// Determine if this item should be wrapped in [raw] shortcode.
		$raw = 'false';

		if ( $subgroup ) {

			if ( in_array( $subgroup, $raw_items, true ) ) {

				$raw = 'true';

			}
		} else {

			if ( in_array( $group, $raw_items, true ) ) {

				$raw = 'true';

			}
		}

		/**
		 * Filter array of shortcodes, which should contain
		 * wrapped content, and will be cleaned up for presentation.
		 * By "cleaned" it means the inner content will have a line
		 * break between opening and closing shortcode tags.
		 *
		 * @since 1.4.0
		 *
		 * @var array
		 */
		$clean_items = apply_filters( 'themeblvd_clean_shortcodes', array( 'icon_list', 'popup' ) );

		$clean = 'false';

		if ( $subgroup ) {

			if ( in_array( $subgroup, $clean_items, true ) ) {

				$clean = 'true';

			}
		} else {

			if ( in_array( $group, $clean_items, true ) ) {

				$clean = 'true';

			}
		}

		/**
		 * Setup default preview content.
		 */

		$shortcode = $group;

		if ( $subgroup ) {

			$shortcode = $subgroup;

		}

		$default_content = '';

		if ( 'column' === $shortcode ) {

			$default_content .= '[raw]<br>';

			$default_content .= '[column size="1/3" wpautop="true"]<br>';
			$default_content .= 'Column 1...<br>';
			$default_content .= '[/column]<br>';

			$default_content .= '[column size="1/3" wpautop="true"]<br>';
			$default_content .= 'Column 2...<br>';
			$default_content .= '[/column]<br>';

			if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) {

				$default_content .= '[column size="1/3" wpautop="true" last]<br>';

			} else {

				$default_content .= '[column size="1/3" wpautop="true"]<br>';

			}

			$default_content .= 'Column 3...<br>';
			$default_content .= '[/column]<br>';

			if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) {

				$default_content .= '[clear]<br>';

			}

			$default_content .= '[/raw]';

		} elseif ( 'tabs' === $shortcode ) {

			$default_content .= '[raw]<br>';

			$default_content .= '[tabs style="framed" nav="tabs" tab_1="Title #1" tab_2="Title #2" tab_3="Title #3"]<br>';
			$default_content .= '[tab_1]Tab 1...[/tab_1]<br>';
			$default_content .= '[tab_2]Tab 2...[/tab_2]<br>';
			$default_content .= '[tab_3]Tab 3...[/tab_3]<br>';
			$default_content .= '[/tabs]<br>';

			$default_content .= '[/raw]';

		} elseif ( 'accordion' === $shortcode ) {

			$default_content .= '[accordion]<br>';
			$default_content .= '[toggle title="Toggle #1"]Content of toggle #1.[/toggle]<br>';
			$default_content .= '[toggle title="Toggle #2"]Content of toggle #2.[/toggle]<br>';
			$default_content .= '[toggle title="Toggle #3"]Content of toggle #3.[/toggle]<br>';
			$default_content .= '[/accordion]';

		} elseif ( 'pricing_table' === $shortcode ) {

			$default_content .= '[raw]<br>';
			$default_content .= '[pricing_table currency="$" currency_placement="before"]<br><br>';

			$default_content .= '[pricing_column title="Bronze" price="40" price_subline="Per Month" button_text="Buy Now" button_url="#"]<br>';
			$default_content .= 'Feature 1<br>';
			$default_content .= 'Feature 2<br>';
			$default_content .= 'Feature 3<br>';
			$default_content .= '[/pricing_column]<br><br>';

			$default_content .= '[pricing_column title="Silver" title_subline="Best Value" price="60" price_subline="Per Month" highlight="royal" popout="true" button_color="royal" button_text="Buy Now" button_url="#"]<br>';
			$default_content .= 'Feature 1<br>';
			$default_content .= 'Feature 2<br>';
			$default_content .= 'Feature 3<br>';
			$default_content .= '[/pricing_column]<br><br>';

			$default_content .= '[pricing_column title="Gold" price_subline="Per Month" price="80" price_subline="Per Month" button_text="Buy Now" button_url="#"]<br>';
			$default_content .= 'Feature 1<br>';
			$default_content .= 'Feature 2<br>';
			$default_content .= 'Feature 3<br>';
			$default_content .= '[/pricing_column]<br><br>';

			$default_content .= '[pricing_column title="Platinum" price_subline="Per Month" price="100" price_subline="Per Month" button_text="Buy Now" button_url="#"]<br>';
			$default_content .= 'Feature 1<br>';
			$default_content .= 'Feature 2<br>';
			$default_content .= 'Feature 3<br>';
			$default_content .= '[/pricing_column]<br><br>';

			$default_content .= '[/pricing_table]<br>';
			$default_content .= '[/raw]';

		} else {

			$default_content .= '[' . $shortcode;

			$options = $this->get_options( $shortcode );

			if ( count( $options ) > 0 ) {

				foreach ( $options as $option ) {

					if ( in_array( $option['type'], array( 'subgroup_start', 'subgroup_end', 'info' ), true ) ) {

						continue;

					}

					if ( ! empty( $option['std'] ) && 'sc_content' !== $option['id'] ) {

						$default_content .= sprintf( ' %s="%s"', $option['id'], $option['std'] );

					}
				}
			}

			$default_content .= ']';

			if ( isset( $options['sc_content'] ) ) {

				$content = 'true';
				$sc_content = htmlspecialchars( $options['sc_content']['std'] );
				$sc_content = str_replace( "\n", '<br>', $sc_content );

				if ( 'true' === $raw || 'true' === $clean ) {

					$sc_content = sprintf( '<br>%s<br>', $sc_content );

				}

				$default_content .= $sc_content;
				$default_content .= sprintf( '[/%s]', $shortcode );

			}

			if ( 'true' === $raw ) {

				$default_content = sprintf( '[raw]<br>%s</br>[/raw]', $default_content );

			}
		}

		echo '<div class="shortcode-preview-wrap">';
		printf( '<div class="shortcode-preview-reset hide">%s</div>', $default_content ); // WPCS: sanitization ok.
		printf( '<div class="shortcode-preview shortcode-preview-%1$s shortcode-preview-%2$s" data-group="%1$s" data-sub-group="%2$s" data-content="%3$s" data-raw="%4$s" data-clean="%5$s">', esc_attr( $group ), esc_attr( $subgroup ), esc_attr( $content ), esc_attr( $raw ), esc_attr( $clean ) );

		echo $default_content; // WPCS: sanitization ok.

		echo '</div><!-- .shortcode-preview (end) -->';
		echo '</div><!-- .shortcode-preview-wrap (end) -->';

	}

	/**
	 * An interface to browse FontAwesome icons.
	 *
	 * @since 1.4.0
	 */
	private function icon_browser() {

		echo '<div class="icon-browser">';

		echo '<div class="icon-browser-title">';
		echo '<a href="#">' . esc_html__( 'Browse Vector Icons', 'theme-blvd-shortcodes' ) . '<i class="fa fa-caret-down"></i></a>';
		echo '</div>';

		echo '<div class="icon-browser-content">';

		echo '<div class="icon-browser-help">' . esc_html__( 'Click an icon to select it for your [vector_icon] shortcode. You can also hover over any icon to see its ID in case you want to use it for another shortcode, as well.', 'theme-blvd-shortcodes' ) . '</div>';

		foreach ( $this->vector_icons as $icon => $icon_name ) {

			echo '<div class="select-icon-wrap tooltip-wrap">';

			printf( '<a href="#" class="select-icon" data-id="%1$s" data-tooltip-text="%1$s"><i class="fa fa-%1$s fa-2x fa-fw"></i></a>', esc_attr( $icon ) );

			echo '</div>';

		}

		echo '</div><!-- .icon-browser-content (end) -->';
		echo '</div><!-- .icon-browser (end) -->';

	}

	/**
	 * An interface to browse colors.
	 *
	 * @since 1.4.0
	 *
	 * @param array $args Arguments for color browser.
	 */
	private function color_browser( $args ) {

		$class = 'color-browser';

		// Button gradients in this theme?
		if ( in_array( 'tb-btn-gradient', apply_filters( 'body_class', array() ), true ) ) {

			$class .= ' tb-btn-gradient';

		}

		printf( '<div class="%s">', esc_attr( $class ) );

		echo '<div id="section-color-browser" class="section section-select">';

		echo '<h4 class="heading">' . esc_html( $args['title'] ) . '</h4>';

		echo '<div class="option">';

		echo '<div class="controls">';

		$colors = themeblvd_colors();

		foreach ( $colors as $id => $name ) {

			if ( 'custom' === $id || 'default' === $id ) {

				$name = str_replace( ' Color', '', $name );

			}

			$wrap_class = 'select-color-wrap tooltip-wrap';

			if ( $id === $args['std'] ) {

				$wrap_class .= ' selected';

			}

			printf( '<div class="%s">', esc_attr( $wrap_class ) );

			$color_class = sprintf( 'color-%1$s %1$s', $id );

			if ( in_array( $id, array( 'default', 'info', 'warning', 'danger', 'success' ), true ) ) {

				$color_class = str_replace( ' ' . $id, ' btn-' . $id, $color_class );

			}

			printf( '<a href="#" class="select-color" data-color="%1$s" data-tooltip-text="%2$s"><span class="%3$s">%2$s</span></a>', esc_attr( $id ), esc_attr( $name ), esc_attr( $color_class ) );

			echo '</div><!-- .select-color-wrap (end) -->';

		}

		echo '</div><!-- .controls (end) -->';

		echo '<div class="explain">' . wp_kses( $args['desc'], themeblvd_allowed_tags() ) . '</div>';

		echo '<div class="clear"></div>';

		echo '</div><!-- .option (end) -->';

		echo '</div><!-- .section (end) -->';

		echo '</div><!-- .color-browser (end) -->';

	}

	/**
	 * Hook in hidden icon browser modal.
	 *
	 * @since 1.6.5
	 */
	public function add_icon_browser() {

		// Requires Framework 2.5+
		if ( function_exists( 'themeblvd_icon_browser' ) ) {

			$page = get_current_screen();

			if ( $page->base == 'post' ) {

				// Only insert when layout builder hasn't already.
				if ( ! defined( 'TB_BUILDER_PLUGIN_VERSION' ) || $page->id != 'page' ) {

					add_action( 'in_admin_header', array( $this, 'display_icon_browser' ) );

				}
			}
		}
	}
	public function display_icon_browser() {
		themeblvd_icon_browser( array( 'type' => 'vector' ) );
	}

}
