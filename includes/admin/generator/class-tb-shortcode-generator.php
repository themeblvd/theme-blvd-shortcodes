<?php
/**
 * Shortcode Generator
 */
class Theme_Blvd_Shortcode_Generator {

	/**
	 * An array of custom slider posts.
	 *
	 * @since 1.4.0
	 */
	public $sliders = array();

	/**
	 * An array of framework's image icons.
	 *
	 * @since 1.4.0
	 */
	public $image_icons = array();

	/**
	 * An array of framework's vector FontAwesome icons.
	 *
	 * @since 1.4.0
	 */
	private $vector_icons = array();

	/**
	 * Legacy object, if neccessary
	 *
	 * @since 1.5.0
	 */
	private $legacy = null;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Set properties
		$this->set();

		// Assets
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );

		// Add button
		add_action( 'media_buttons', array( $this, 'add_button' ), 11 );

		// Add hidden modal window
		add_action( 'admin_footer-post.php', array( $this, 'add_modal' ) );
		add_action( 'admin_footer-post-new.php', array( $this, 'add_modal' ) );

		if ( version_compare(TB_FRAMEWORK_VERSION, '2.5.0', '>=') ) {
			add_action( 'admin_footer-toplevel_page_themeblvd_builder', array( $this, 'add_modal' ) );
		}
	}

	/**
	 * Set properties.
	 *
	 * @since 1.4.0
	 */
	public function set() {

		/*--------------------------------------------*/
		/* Sliders
		/*--------------------------------------------*/

		// Custom built slider from the Theme Blvd Sliders plugin
		$this->sliders = themeblvd_get_select( 'sliders' );

		/*--------------------------------------------*/
		/* Image Icons
		/*--------------------------------------------*/

		$this->image_icons = array();

		if ( function_exists('themeblvd_get_icons') ) { // Framework 2.5+

			$this->image_icons = themeblvd_get_icons( 'image' );

		} else {

			// Check for cached icons
			$this->image_icons = get_transient( 'themeblvd_'.get_template().'_image_icons' );

			if ( ! $this->image_icons ) {

				// Icons from the parent theme
				$icons = array();
				$icons_url = TB_FRAMEWORK_URI.'/assets/images/shortcodes/icons';
				$icons_dir = TB_FRAMEWORK_DIRECTORY.'/assets/images/shortcodes/icons';

				if ( file_exists( $icons_dir ) ) {
					$icons = scandir( $icons_dir );
				}

				// Display icons
				if ( count( $icons ) > 0 ) {
					foreach ( $icons as $icon ) {
						if ( strpos( $icon, '.png' ) !== false ) {
							$id = str_replace( '.png', '', $icon );
							$this->image_icons[$id] = sprintf( '%s/%s.png', $icons_url, $id );
						}
					}
				}

				// Check for icons in the child theme
				$child_icons = array();
				$child_icons_url = get_stylesheet_uri().'/icons';
				$child_icons_dir = get_stylesheet_directory_uri().'/assets/images/shortcodes/icons';

				if ( file_exists( $child_icons_dir ) ) {
					$child_icons = scandir( $child_icons_dir );
				}

				// Display icons
				if ( count( $child_icons ) > 0 ) {
					foreach ( $child_icons as $icon ) {
						if ( strpos( $icon, '.png' ) !== false ) {
							$id = str_replace( '.png', '', $icon );
							$this->image_icons[$id] = sprintf( '%s/%s.png', $child_icons_url, $id );
						}
					}
				}

				// Cache results
				set_transient( 'themeblvd_'.get_template().'_image_icons', $this->image_icons, '86400' ); // 1 day

			}

			/*--------------------------------------------*/
			/* Run legacy?
			/*--------------------------------------------*/

			if ( class_exists('Theme_Blvd_Shortcode_Generator_Legacy') ) {
				$this->legacy = new Theme_Blvd_Shortcode_Generator_Legacy($this);

			}

		}

		/*--------------------------------------------*/
		/* Vector Icons
		/*--------------------------------------------*/

		if ( function_exists('themeblvd_get_icons') ) { // Framework 2.5+

			$this->vector_icons = themeblvd_get_icons( 'vector' );

		} else {

			// Check for cached icons
			$this->vector_icons = get_transient( 'themeblvd_'.get_template().'_vector_icons' );

			if ( ! $this->vector_icons ) {

				$this->vector_icons = array();

				$file_location = TB_FRAMEWORK_DIRECTORY.'/assets/plugins/fontawesome/css/font-awesome.css';
				$fetch_icons = array();

				if ( file_exists( $file_location ) ) {

					$file = fopen( $file_location, "r" );

					while ( !feof( $file ) ) {

						$line = fgets( $file );

						if ( strpos($line, '.fa-') !== false && strpos($line, ':before') !== false ) {
							$icon = str_replace( '.fa-', '', $line );
							$icon = str_replace( ':before {', '', $icon );
							$icon = str_replace( ':before,', '', $icon );
							$fetch_icons[] = trim( $icon );
						}

					}

					// Close file
					fclose( $file );

					// Sort icons alphabetically
					sort( $fetch_icons );

					// Format array for use in options framework -- for compat reasons with framework 2.5+
					foreach ( $fetch_icons as $icon ) {
						$this->vector_icons[$icon] = $icon;
					}

					// Cache results
					set_transient( 'themeblvd_'.get_template().'_vector_icons', $this->vector_icons, '86400' ); // 1 day
				}
			}
		}
	}

	/**
	 * Add assets
	 *
	 * @since 1.4.0
	 */
	public function assets( $hook ) {
		if ( 'post.php' == $hook || 'post-new.php' == $hook || ( $hook == 'toplevel_page_themeblvd_builder' && version_compare(TB_FRAMEWORK_VERSION, '2.5.0', '>=') ) ) {

			// WP Built-in scripts
			wp_enqueue_script( 'jquery-ui-core');
			wp_enqueue_script( 'jquery-ui-slider' );
			wp_enqueue_script( 'wp-color-picker' );

			// WP Built-in styles
			wp_enqueue_style( 'wp-color-picker' );

			// Framework core
			wp_enqueue_style( 'themeblvd_admin', TB_FRAMEWORK_URI . '/admin/assets/css/admin-style.min.css', null, TB_FRAMEWORK_VERSION );
			wp_enqueue_script( 'themeblvd_admin', TB_FRAMEWORK_URI . '/admin/assets/js/shared.min.js', array('jquery'), TB_FRAMEWORK_VERSION );

			wp_enqueue_style( 'themeblvd_options', TB_FRAMEWORK_URI . '/admin/options/css/admin-style.min.css', null, TB_FRAMEWORK_VERSION );

			if ( $this->legacy ) {
				wp_enqueue_style( 'color-picker', TB_FRAMEWORK_URI . '/admin/options/css/colorpicker.min.css' );
				wp_enqueue_script( 'color-picker', TB_FRAMEWORK_URI . '/admin/options/js/colorpicker.min.js', array('jquery') );
			}

			// FontAwesome
			wp_enqueue_style( 'fontawesome', TB_FRAMEWORK_URI . '/assets/plugins/fontawesome/css/font-awesome.min.css', null, TB_FRAMEWORK_VERSION );

			// Generator
			wp_enqueue_style( 'tb_shortcode_generator', TB_SHORTCODES_PLUGIN_URI . '/includes/admin/generator/assets/css/generator.min.css', false, TB_SHORTCODES_PLUGIN_VERSION );
			wp_enqueue_script( 'tb_shortcode_generator', TB_SHORTCODES_PLUGIN_URI . '/includes/admin/generator/assets/js/generator.min.js', false, TB_SHORTCODES_PLUGIN_VERSION );
		}
	}

	/**
	 * Add button for inserting shortcodes,
	 * which brings up modal window of options.
	 *
	 * @since 1.4.0
	 */
	public function add_button( $editor_id ){

		if ( $editor_id != 'content' && $editor_id != 'themeblvd_editor' ) {
			return;
		}

		$screen = get_current_screen();

		if ( $screen->base == 'press-this' ) {
			return;
		}

		$text = __( 'Add Shortcode', 'themeblvd_shortcodes' );

		$button = sprintf( '<a href="#" class="tb-insert-shortcode button" title="%s">', $text );

		if ( version_compare( TB_FRAMEWORK_VERSION, '2.4.0', '>=' ) ) {
			$button .= '<span class="tb-icon"></span>'; // admin icon font added in Framework 2.4
		}

		$button .= $text;
		$button .= '</a>';

		echo apply_filters( 'themeblvd_shortcode_button', $button );
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

				<a class="media-modal-close" href="#" title="Close">
					<span class="media-modal-icon"></span>
				</a>

				<div class="media-modal-content">
					<div class="media-frame wp-core-ui">

						<div class="media-frame-menu">
							<div class="media-menu">
								<?php foreach ( $groups as $key => $group ) : ?>
									<a href="#" data-id="<?php echo $group['id']; ?>" title="<?php echo $group['name']; ?>" class="media-menu-item <?php if ( $key == 0 ) echo ' active'; ?>">
										<?php echo $group['name']; ?>
									</a>
								<?php endforeach; ?>
							</div>
						</div><!-- .media-frame-menu (end) -->

						<div class="media-frame-title">
							<h1><?php echo $groups[0]['name'] ?></h1>
						</div><!-- .media-frame-title (end) -->

						<?php foreach ( $groups as $key => $group ) : ?>
							<?php if ( count( $group['sub'] ) > 0 ) : ?>
								<div class="media-frame-router tb-router-<?php echo $group['id']; ?>" data-group="<?php echo $group['id']; ?>">
									<div class="media-router">
										<?php foreach ( $group['sub'] as $id => $name ) : ?>
											<?php
											$class = 'tb-tab-menu-item';
											if ( reset($group['sub']) == $name ) {
												$class .= ' active';
											}
											?>
											<a href="#" data-sub-group="<?php echo $id; ?>" class="<?php echo $class; ?>"><?php echo $name; ?></a>
										<?php endforeach; ?>
									</div><!-- .media-router (end) -->
								</div><!-- .media-frame-router (end) -->
							<?php endif; ?>
						<?php endforeach; ?>

						<div id="optionsframework" class="media-frame-content">
							<div class="attachments-browser">

								<?php foreach ( $groups as $key => $group ) : ?>

									<?php
									$class = 'tb-group attachments ui-sortable ui-sortable-disabled';

									if ( $key == 0 ) {
										$class .= ' tb-group-show';
									} else {
										$class .= ' tb-group-hide';
									}

									if ( count($group['sub']) > 0 ) {
										$class .= ' group-has-subs';
									}
									?>

									<div id="tb-group-<?php echo $group['id']; ?>" class="<?php echo $class; ?>">

										<?php
										// Switch by group
										switch( $group['id'] )  {

											/*--------------------------------------------*/
											/* Button
											/*--------------------------------------------*/

											case 'button' :

												$options = $this->get_options( 'button' );

												$output = themeblvd_option_fields( 'button', $options, array(), false );

												echo '<div class="shortcode-options" data-type="button">';
												echo '<div class="options-wrap">';
												$this->preview( $group['id'] );

												$color_browser_ags = array(
													'title'	=> __('Button Color', 'themeblvd_shortcodes'),
													'desc' 	=> __('<p>Select a color for your button.</p><p><em>Note: The "default" and "primary" colors may vary from theme-to-theme.</em></p>', 'themeblvd_shortcodes'),
													'std'	=> 'default'
												);
												$this->color_browser( $color_browser_ags );

												echo $output[0];
												echo '</div><!-- .options-wrap (end) -->';
												echo '</div><!-- .shortcode-options (end) -->';

												break;

											/*--------------------------------------------*/
											/* Columns
											/*--------------------------------------------*/

											$options = $this->get_options( 'column' );
											$output = themeblvd_option_fields( 'column', $options, array(), false );

											echo '<div class="shortcode-options shortcode-options-column" data-type="column">';
											$this->preview( 'column' );
											echo '<div class="options-wrap">';
											echo $output[0];
											echo '</div><!-- .options-wrap (end) -->';
											echo '</div><!-- .shortcode-options (end) -->';

											/*--------------------------------------------*/
											/* Icons
											/*--------------------------------------------*/

											case 'icons' :

												// Image Icons
												$options = $this->get_options( 'icon' );

												$output = themeblvd_option_fields( 'icon', $options, array(), false );

												echo '<div class="shortcode-options shortcode-options-icon" data-type="icon">';
												echo '<div class="options-wrap">';
												$this->preview( 'icon' );
												echo $output[0];
												echo '</div><!-- .options-wrap (end) -->';
												echo '</div><!-- .shortcode-options (end) -->';

												// Vector Icons
												$options = $this->get_options( 'vector_icon' );
												$output = themeblvd_option_fields( 'vector_icon', $options, array(), false );

												echo '<div class="shortcode-options shortcode-options-vector_icon hide" data-type="vector_icon">';
												$this->preview( 'vector_icon' );
												$this->icon_browser();
												echo '<div class="options-wrap">';
												echo $output[0];
												echo '</div><!-- .options-wrap (end) -->';
												echo '</div><!-- .shortcode-options (end) -->';

												break;

											/*--------------------------------------------*/
											/* Default
											/*--------------------------------------------*/

											default :

												$hide = '';

												if ( count( $group['sub'] ) > 0 ) {
													foreach ( $group['sub'] as $id => $name ) {

														$options = $this->get_options( $id );
														$output = themeblvd_option_fields( $id, $options, array(), false );

														printf( '<div class="shortcode-options shortcode-options-%s %s" data-type="%s">', $id, $hide, $id );
														$this->preview( $group['id'], $id );
														echo '<div class="options-wrap">';
														echo $output[0];
														echo '</div><!-- .options-wrap (end) -->';
														echo '</div><!-- .shortcode-options (end) -->';

														// Starting with the the second pass, hide clas will be
														$hide = 'hide';

													}

												} else {

													$options = $this->get_options( $group['id'] );

													printf( '<div class="shortcode-options shortcode-options-%1$s" data-type="%1$s">', $group['id'] );
													$this->preview( $group['id'] );
													echo '<div class="options-wrap">';

													if ( $options ) {
														$output = themeblvd_option_fields( $group['id'], $options, array(), false );
														echo $output[0];
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
								<div class="media-toolbar-secondary">

								</div>
								<div class="media-toolbar-primary">
									<button href="#" id="tb-shortcode-to-editor" data-insert="button" class="button media-button button-primary button-large">Insert Shortcode</button>
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
				'name'	=> __( 'Button', 'themeblvd_shortcodes' ),
				'sub'	=> array()
			),
			array(
				'id'	=> 'column',
				'name'	=> __( 'Columns', 'themeblvd_shortcodes' ),
				'sub'	=> array()
			),
			array(
				'id'	=> 'components',
				'name'	=> __( 'Components', 'themeblvd_shortcodes' ),
				'sub'	=> array(
					'alert'				=> __('Alert', 'themeblvd_shortcodes'),
					'divider'			=> __('Divider', 'themeblvd_shortcodes'),
					'icon_list'			=> __('Icon List', 'themeblvd_shortcodes'),
					'jumbotron'			=> __('Jumbotron', 'themeblvd_shortcodes'),
					'panel'				=> __('Panel', 'themeblvd_shortcodes'),
					'popup'				=> __('Popup', 'themeblvd_shortcodes'),
					'progress_bar'		=> __('Progress Bar', 'themeblvd_shortcodes'),
					'blockquote'		=> __('Quote', 'themeblvd_shortcodes'),
					'testimonial'		=> __('Testimonial', 'themeblvd_shortcodes')
				)
			),
			array(
				'id'	=> 'display_posts',
				'name'	=> __( 'Display Posts', 'themeblvd_shortcodes' ),
				'sub'	=> array(
					'blog'				=> __('Blog', 'themeblvd_shortcodes'),
					'post_grid'			=> __('Post Grid', 'themeblvd_shortcodes'),
					'post_showcase'		=> __('Post Showcase', 'themeblvd_shortcodes'),
					'post_list'			=> __('Post List', 'themeblvd_shortcodes'),
					'mini_post_grid'	=> __('Mini Post Grid', 'themeblvd_shortcodes'),
					'mini_post_list'	=> __('Mini Post List', 'themeblvd_shortcodes')
				)
			),
			array(
				'id'	=> 'icons',
				'name'	=> __( 'Icons', 'themeblvd_shortcodes' ),
				'sub'	=> array(
					'icon'			=> __('Image Icon', 'themeblvd_shortcodes'),
					'vector_icon'	=> __('Vector Icon', 'themeblvd_shortcodes')
				)
			),
			array(
				'id'	=> 'inline_elements',
				'name'	=> __( 'Inline Elements', 'themeblvd_shortcodes' ),
				'sub'	=> array(
					'dropcap'		=> __('Dropcap', 'themeblvd_shortcodes'),
					'highlight'		=> __('Highlight Text', 'themeblvd_shortcodes'),
					'icon_link'		=> __('Icon Link', 'themeblvd_shortcodes'),
					'label'			=> __('Label', 'themeblvd_shortcodes'),
					'lead'			=> __('Lead Text', 'themeblvd_shortcodes')
				)
			),
			/*
			array(
				'id'	=> 'lightbox',
				'name'	=> __( 'Lightbox', 'themeblvd_shortcodes' ),
				'sub'	=> array()
			),
			*/
			array(
				'id'	=> 'pricing_table',
				'name'	=> __( 'Pricing Table', 'themeblvd_shortcodes' ),
				'sub'	=> array()
			),
			array(
				'id'	=> 'sliders',
				'name'	=> __( 'Sliders', 'themeblvd_shortcodes' ),
				'sub'	=> array(
					'slider'			=> __('Custom Slider', 'themeblvd_shortcodes'),
					'gallery_slider'	=> __('Gallery Slider', 'themeblvd_shortcodes'),
					'post_slider'		=> __('Post Slider', 'themeblvd_shortcodes'),
					'post_grid_slider'	=> __('Post Grid Slider', 'themeblvd_shortcodes')
				)
			),
			array(
				'id'	=> 'stats',
				'name'	=> __( 'Stats', 'themeblvd_shortcodes' ),
				'sub'	=> array(
					'milestone'			=> __('Milestone', 'themeblvd_shortcodes'),
					'milestone_ring'	=> __('Milestone Ring', 'themeblvd_shortcodes'),
					'progress_bar'		=> __('Progress Bar', 'themeblvd_shortcodes')
				)
			),
			array(
				'id'	=> 'tabs',
				'name'	=> __( 'Tabs', 'themeblvd_shortcodes' ),
				'sub'	=> array()
			),
			array(
				'id'	=> 'toggles',
				'name'	=> __( 'Toggles', 'themeblvd_shortcodes' ),
				'sub'	=> array(
					'toggle'			=> __('Toggle', 'themeblvd_shortcodes'),
					'accordion'			=> __('Accordion', 'themeblvd_shortcodes')
				)
			)
		);
		return apply_filters( 'themeblvd_shortcodes_groups', $groups );
	}

	/**
	 * Get options for a specific type of shortcode.
	 *
	 * @since 1.4.0
	 *
	 * @param $type string Type of icon
	 * @return $options array array of options for a shortcode
	 */
	private function get_options( $type ) {

		if ( $this->legacy ) {
			return $this->legacy->get_options( $type );
		}

		// Note: For utilizeing a shortcode that includes content like:
		// [example]Content...[/example]
		// ... The option ID must be "sc_content"

		$options = array();

		/*--------------------------------------------*/
		/* Option Helpers
		/*--------------------------------------------*/

		$colors = themeblvd_colors();

		/*--------------------------------------------*/
		/* Buttons
		/*--------------------------------------------*/

		$options['button'] = array(
			'color' => array(		// Hidden option, to interact with button's color browser
				'name' 		=> '',
				'desc' 		=> '',
				'id' 		=> 'color',
				'std' 		=> 'default',
				'type' 		=> 'text',
				'class'		=> 'hide'
			),
			'custom' => array(		// Hidden option, to interact with button's color browser
				'name' 		=> __( 'Custom Button Color', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Configure the style of your custom button design.', 'themeblvd_shortcodes' ),
				'id' 		=> 'custom',
				'std' 		=> 'default',
				'type' 		=> 'button',
				'class'		=> 'hide'
			),
			'sc_content' => array(
				'name' 		=> __( 'Button Text', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The text of the button.', 'themeblvd_shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Button Text...',
				'type' 		=> 'text'
			),
			'link' => array(
				'name' 		=> __( 'Link URL', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The full URL of where you want the button to link.<br />Ex: http://yourwebsite.com/example/', 'themeblvd_shortcodes' ),
				'id' 		=> 'link',
				'std' 		=> 'http://yourwebsite.com/example/',
				'type' 		=> 'text'
			),
			'size' => array(
				'name' 		=> __( 'Button Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The size of how the button displays.', 'themeblvd_shortcodes' ),
				'id' 		=> 'size',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'mini' 			=> __('Mini', 'themeblvd_shortcodes'),
					'small' 		=> __('Small', 'themeblvd_shortcodes'),
					'default' 		=> __('Default', 'themeblvd_shortcodes'),
					'large' 		=> __('Large', 'themeblvd_shortcodes')
				)
			),
			'icon_before' => array(
				'name' 		=> __( 'Icon Before Button Text (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Icon before text of button. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.</p><p><em>Note: Do not prefix icon ID with "fa-"</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'icon_before',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'icon_after' => array(
				'name' 		=> __( 'Icon After Button Text (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Icon after text of button. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.</p><p><em>Note: Do not prefix icon ID with "fa-"</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'icon_after',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'target' => array(
				'name' 		=> __( 'Button Target', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How the button opens the link.', 'themeblvd_shortcodes' ),
				'id' 		=> 'target',
				'std' 		=> '_self',
				'type' 		=> 'select',
				'options' 	=> array(
					'_self' 		=> __('Same Window', 'themeblvd_shortcodes'),
					'_blank' 		=> __('New Window', 'themeblvd_shortcodes'),
					'lightbox' 		=> __('Lightbox', 'themeblvd_shortcodes')
				)
			),
			'block' => array(
				'name' 		=> __( 'Block Display', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to display the button as a block-level element or not. As a block-level element, the button will stretch full-width to fill its container, opposed to sitting inline with the content.', 'themeblvd_shortcodes' ),
				'id' 		=> 'block',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 			=> __('True', 'themeblvd_shortcodes'),
					'false' 		=> __('False', 'themeblvd_shortcodes')
				)
			),
			'title' => array(
				'name' 		=> __( 'Button Title (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'For you SEO folks, this controls the button\'s HTML title tag. If left blank, this will just default to the button\'s text.', 'themeblvd_shortcodes' ),
				'id' 		=> 'title',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'class' => array(
				'name' 		=> __( 'Button CSS Class (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'This will allow you to add an extra CSS class for styling to the button.', 'themeblvd_shortcodes' ),
				'id' 		=> 'class',
				'std' 		=> '',
				'type' 		=> 'text'
			)
		);

		/*--------------------------------------------*/
		/* Columns
		/*--------------------------------------------*/

		$options['column'] = array(
			'subgroup_start' => array(
		    	'type'		=> 'subgroup_start',
		    	'class'		=> 'columns'
		    ),
			'setup' => array(
				'id' 		=> 'setup',
				'name'		=> __( 'Setup Columns', 'themeblvd_shortcodes' ),
				'desc'		=> null,
				'type'		=> 'columns',
				'std'		=> '1/3-1/3-1/3',
				'options'	=> 'shortcode'
			),
			'subgroup_end' => array(
		    	'type'		=> 'subgroup_end'
		    ),
		    'wpautop' => array(
		    	'id' 		=> 'wpautop',
				'desc'		=> __( 'Apply WordPress automatic formatting to content of columns.', 'themeblvd_shortcodes' ),
				'type'		=> 'checkbox',
				'std'		=> '1'
			)
		);

		/*--------------------------------------------*/
		/* Components
		/*--------------------------------------------*/

		// Alert
		$options['alert'] = array(
			'style' => array(
				'name' 		=> __( 'Style', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The style of the alert.', 'themeblvd_shortcodes' ),
				'id' 		=> 'style',
				'std' 		=> 'info',
				'type' 		=> 'select',
				'options' 	=> array(
					'info' 		=> __('Info (blue)', 'themeblvd_shortcodes'),
					'success' 	=> __('Success (green)', 'themeblvd_shortcodes'),
					'danger' 	=> __('Danger (red)', 'themeblvd_shortcodes'),
					'warning' 	=> __('Warning (yellow)', 'themeblvd_shortcodes')
				)
			),
			'sc_content' => array(
				'name' 		=> __( 'Content', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>The content of the alert.</p><p><em>Note: The content can be further edited from your WordPress editor after being inserted.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Content here...',
				'type' 		=> 'textarea'
			)
		);

		// Divider
		$options['divider'] = array(
			'style' => array(
				'name' 		=> __( 'Style', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The style of divider line used to breakup your content.', 'themeblvd_shortcodes' ),
				'id' 		=> 'style',
				'std' 		=> 'solid',
				'type' 		=> 'select',
				'options'		=> array(
					'shadow' 		=> __( 'Shadow Line', 'themeblvd_shortcodes' ),
					'solid' 		=> __( 'Solid Line', 'themeblvd_shortcodes' ),
			        'dashed' 		=> __( 'Dashed Line', 'themeblvd_shortcodes' ),
					'double-solid' 	=> __( 'Double Solid Lines', 'themeblvd_shortcodes' ),
					'double-dashed' => __( 'Double Dashed Lines', 'themeblvd_shortcodes' )
				)
			),
			'width' => array(
				'id' 		=> 'width',
				'name'		=> __( 'Divider Width', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'If you\'d like to restrict the width of the divider enter an integer in pixels.<br>Ex: 100', 'themeblvd_shortcodes' ),
				'std' 		=> '',
				'type'		=> 'text'
			),
			'placement' => array(
				'id' 		=> 'placement',
				'name'		=> __( 'Divider Placement', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'Select how you\'d like the divider to separate the content.', 'themeblvd_shortcodes' ),
				'std'		=> 'equal',
				'type'		=> 'select',
				'options'	=> array(
					'equal' 	=> __( 'Divider is in between content', 'themeblvd_shortcodes' ),
					'up' 		=> __( 'Divider is closer to content above', 'themeblvd_shortcodes' ),
					'down' 		=> __( 'Divider is closer to content below', 'themeblvd_shortcodes' )
				)
			)
		);

		// Icon List
		$options['icon_list'] = array(
			'sc_content' => array(
				'name' 		=> __( 'List', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>The HTML list you are wrapping the shortcode in. Each item of this list will appear with an icon.</p><p><em>Note: The content can be further edited from your WordPress editor after being inserted.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> "<ul>\n<li>List item 1</li>\n<li>List item 2</li>\n<li>List item 3</li>\n</ul>",
				'type' 		=> 'textarea'
			),
			'icon' => array(
				'name' 		=> __( 'Icon', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Icon to be applied to each list item. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.</p><p><em>Note: Do not prefix icon ID with "fa-"</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'icon',
				'std' 		=> 'caret-right',
				'type' 		=> 'text'
			),
			'color' => array(
				'name' 		=> __( 'Icon Color (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'A color for the icons - Ex: #666666', 'themeblvd_shortcodes' ),
				'id' 		=> 'color',
				'std' 		=> '',
				'type' 		=> 'color'
			)
		);

		// Jumbotron
		$options['jumbotron'] = array(
			'title' => array(
				'name' 		=> __( 'Title (Optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Enter a title for the unit.', 'themeblvd_shortcodes' ),
				'id' 		=> 'title',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'sc_content' => array(
				'name' 		=> __( 'Content', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>The content of the unit.</p><p><em>Note: The content can be further edited from your WordPress editor after being inserted.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Content here...',
				'type' 		=> 'textarea'
			),
			'bg_color' => array(
				'name' 		=> __( 'Background Color', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select the background color of the unit.', 'themeblvd_shortcodes' ),
				'id' 		=> 'bg_color',
				'std' 		=> '',
				'type' 		=> 'color'
			),
			'title_size' => array(
				'name' 		=> __( 'Title Text Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select the size of the title text in the unit.', 'themeblvd_shortcodes' ),
				'id' 		=> 'title_size',
				'std'		=> '30px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'	=> 'px',
					'min'	=> '10',
					'max'	=> '50',
					'step'	=> '1'
				)
			),
			/*
			'title_color' => array(
				'name' 		=> __( 'Title Text Color', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select the color of the title text in the unit.', 'themeblvd_shortcodes' ),
				'id' 		=> 'title_color',
				'std' 		=> '',
				'type' 		=> 'color'
			),
			*/
			'text_size' => array(
				'name' 		=> __( 'Content Text Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select the size of the content text in the unit.', 'themeblvd_shortcodes' ),
				'id' 		=> 'text_size',
				'std'		=> '18px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'	=> 'px',
					'min'	=> '10',
					'max'	=> '50',
					'step'	=> '1'
				)
			),
			'text_color' => array(
				'name' 		=> __( 'Content Text Color', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select the color of all the text in the unit.', 'themeblvd_shortcodes' ),
				'id' 		=> 'text_color',
				'std' 		=> '',
				'type' 		=> 'color'
			),
			'text_align' => array(
				'name' 		=> __( 'Text Alignment', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How you\'d like all text in the unit aligned.', 'themeblvd_shortcodes' ),
				'id' 		=> 'text_align',
				'std' 		=> 'left',
				'type' 		=> 'select',
				'options' 	=> array(
					'left' 		=> __('Left', 'themeblvd_shortcodes'),
					'right' 	=> __('Right', 'themeblvd_shortcodes'),
					'center' 	=> __('Center', 'themeblvd_shortcodes')
				)
			),
			'subgroup_start' => array(
		    	'type'		=> 'subgroup_start',
		    	'class'		=> 'show-hide-toggle'
		    ),
			'align' => array(
				'name' 		=> __( 'Unit Alignment', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How you\'d like to align the entire unit on the page.', 'themeblvd_shortcodes' ),
				'id' 		=> 'align',
				'std' 		=> 'none',
				'type' 		=> 'select',
				'options' 	=> array(
					'none' 		=> __('None', 'themeblvd_shortcodes'),
					'left' 		=> __('Left', 'themeblvd_shortcodes'),
					'right' 	=> __('Right', 'themeblvd_shortcodes'),
					'center' 	=> __('Center', 'themeblvd_shortcodes')
				),
				'class'		=> 'trigger'
			),
			'max_width' => array(
				'name' 		=> __( 'Maximum Width', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'If you\'ve aligned the entire unit in the previous option, you\'ll need to enter a width for the unit here, or else you won\'t see any effect - 300px, 50%, etc.', 'themeblvd_shortcodes' ),
				'id' 		=> 'max_width',
				'std' 		=> '',
				'type' 		=> 'text',
				'class'		=> 'hide receiver receiver-left receiver-right receiver-center'
			),
			'subgroup_end' => array(
		    	'type'		=> 'subgroup_end'
		    ),
			'wpautop' => array(
				'name' 		=> __( 'WordPress Auto Formatting', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to apply wpautop on content. This shortcode will work best if you leave this set to true and wrap the [jumbotron] shortcode in the [raw] shortcode as shown in the example above. This way, WordPress’s automatic formatting will be applied when the shortcode is rendered <em>only</em>, and will turn out nicer.', 'themeblvd_shortcodes' ),
				'id' 		=> 'wpautop',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			)
		);

		// Panel
		$options['panel'] = array(
			'style' => array(
				'name' 		=> __( 'Style', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Style of the panel.', 'themeblvd_shortcodes' ),
				'id' 		=> 'style',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'default' 	=> __('Default (grey)', 'themeblvd_shortcodes'),
					'primary' 	=> __('Primary (blue)', 'themeblvd_shortcodes'),
					'info' 		=> __('Info (lighter blue)', 'themeblvd_shortcodes'),
					'success' 	=> __('Success (green)', 'themeblvd_shortcodes'),
					'danger' 	=> __('Danger (red)', 'themeblvd_shortcodes'),
					'warning' 	=> __('Warning (yellow)', 'themeblvd_shortcodes')
				)
			),
			'sc_content' => array(
				'name' 		=> __( 'Content', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>The content of the panel.</p><p><em>Note: The content can be further edited from your WordPress editor after being inserted.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Content here...',
				'type' 		=> 'textarea'
			),
			'title' => array(
				'name' 		=> __( 'Title (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The title of the panel.', 'themeblvd_shortcodes' ),
				'id' 		=> 'title',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'footer' => array(
				'name' 		=> __( 'Footer text (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Footer text for the panel.', 'themeblvd_shortcodes' ),
				'id' 		=> 'footer',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'text_align' => array(
				'name' 		=> __( 'Text Alignment', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to align text in panel.', 'themeblvd_shortcodes' ),
				'id' 		=> 'text_align',
				'std' 		=> 'left',
				'type' 		=> 'select',
				'options' 	=> array(
					'left' 		=> __('Left', 'themeblvd_shortcodes'),
					'right' 	=> __('Right', 'themeblvd_shortcodes'),
					'center' 	=> __('Center', 'themeblvd_shortcodes')
				)
			),
			'class' => array(
				'name' 		=> __( 'CSS Class (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Any CSS classes you\'d like to add.', 'themeblvd_shortcodes' ),
				'id' 		=> 'class',
				'std' 		=> '',
				'type' 		=> 'text'
			)
		);

		// Popup
		$options['popup'] = array(
			'header' => array(
				'name' 		=> __( 'Header Text (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Optional header text for the top of the popup.', 'themeblvd_shortcodes' ),
				'id' 		=> 'header',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'sc_content' => array(
				'name' 		=> __( 'Content', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Content of the popup.</p><p><em>Note: The content can be further edited from your WordPress editor after being inserted.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Content here...',
				'type' 		=> 'textarea'
			),
			'animate' => array(
				'name' 		=> __( 'Popup Animation', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether the popup animates in or not, when it shows.', 'themeblvd_shortcodes' ),
				'id' 		=> 'animate',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'text' => array(
				'name' 		=> __( 'Button Text', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Text of the button to bring in the popup.', 'themeblvd_shortcodes' ),
				'id' 		=> 'text',
				'std' 		=> 'Button Text',
				'type' 		=> 'text'
			),
			'color' => array(
				'name' 		=> __( 'Button Color', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Color of button to popup.', 'themeblvd_shortcodes' ),
				'id' 		=> 'color',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> $colors
			),
			'size' => array(
				'name' 		=> __( 'Button Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select the style of the panel.', 'themeblvd_shortcodes' ),
				'id' 		=> 'size',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'mini' 		=> __('Mini', 'themeblvd_shortcodes'),
					'small' 	=> __('Small', 'themeblvd_shortcodes'),
					'default' 	=> __('Default', 'themeblvd_shortcodes'),
					'large' 	=> __('Large', 'themeblvd_shortcodes')
				)
			),
			'icon_before' => array(
				'name' 		=> __( 'Icon Before Button Text (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Icon before text of button to popup. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.</p><p><em>Note: Do not prefix icon ID with "fa-"</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'icon_before',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'icon_after' => array(
				'name' 		=> __( 'Icon After Button Text (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Icon after text of button to popup. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.</p><p><em>Note: Do not prefix icon ID with "fa-"</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'icon_after',
				'std' 		=> '',
				'type' 		=> 'text'
			)
		);

		// Quote
		$options['blockquote'] = array(
			'quote' => array(
				'name' 		=> __( 'Quote Text', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The main text of the quote. You cannot use HTML here.', 'themeblvd_shortcodes' ),
				'id' 		=> 'quote',
				'std' 		=> 'Quote text...',
				'type' 		=> 'textarea'
			),
			'source' => array(
				'name' 		=> __( 'Quote Source (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Optional source for the quote.<br />Ex: John Smith', 'themeblvd_shortcodes' ),
				'id' 		=> 'source',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'source_link' => array(
				'name' 		=> __( 'Quote Source URL (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Optional website URL to the source you entered in the previous option.<br />Ex: http://google.com', 'themeblvd_shortcodes' ),
				'id' 		=> 'source_link',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'subgroup_start' => array(
		    	'type'		=> 'subgroup_start',
		    	'class'		=> 'show-hide-toggle'
		    ),
			'align' => array(
				'name' 		=> __( 'Alignment', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to align the entire quote block.', 'themeblvd_shortcodes' ),
				'id' 		=> 'align',
				'std' 		=> 'none',
				'type' 		=> 'select',
				'options' 	=> array(
					'none' 		=> __('None', 'themeblvd_shortcodes'),
					'left' 		=> __('Left', 'themeblvd_shortcodes'),
					'right' 	=> __('Right', 'themeblvd_shortcodes')
				),
				'class'		=> 'trigger'
			),
			'max_width' => array(
				'name' 		=> __( 'Maximum Width', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'If you\'ve aligned the block quote in the previous option, you\'ll need to enter a width here, or else you won\'t see the proper result - 300px, 50%, etc.', 'themeblvd_shortcodes' ),
				'id' 		=> 'max_width',
				'std' 		=> '',
				'type' 		=> 'text',
				'class'		=> 'hide receiver receiver-left receiver-right'
			),
			'subgroup_end' => array(
		    	'type'		=> 'subgroup_end'
		    ),
			'class' => array(
				'name' 		=> __( 'CSS Class (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Any CSS classes you\'d like to add.', 'themeblvd_shortcodes' ),
				'id' 		=> 'class',
				'std' 		=> '',
				'type' 		=> 'text'
			)
		);

		// Testimonial
		$options['testimonial'] = array(
		    'sc_content' => array(
				'name' 		=> __( 'Testimonial Text', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Enter any text of the testimonial.', 'themeblvd_shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Testimonial here...',
				'type' 		=> 'textarea'
			),
			'name' => array(
				'id' 		=> 'name',
				'name' 		=> __( 'Name', 'themeblvd_shortcodes'),
				'desc'		=> __( 'Enter the name of the person giving the testimonial.', 'themeblvd_shortcodes'),
				'type'		=> 'text'
		    ),
		    'tagline' => array(
				'id' 		=> 'tagline',
				'name' 		=> __( 'Tagline (optional)', 'themeblvd_shortcodes'),
				'desc'		=> __( 'Enter a tagline for the person giving the testimonial.<br>Ex: Founder and CEO', 'themeblvd_shortcodes'),
				'type'		=> 'text'
		    ),
		    'company' => array(
				'id' 		=> 'company',
				'name' 		=> __( 'Company (optional)', 'themeblvd_shortcodes'),
				'desc'		=> __( 'Enter the company the person giving the testimonial belongs to.', 'themeblvd_shortcodes'),
				'type'		=> 'text'
		    ),
		    'company_url' => array(
				'id' 		=> 'company_url',
				'name' 		=> __( 'Company URL (optional)', 'themeblvd_shortcodes'),
				'desc'		=> __( 'Enter the website URL for the company or the person giving the testimonial.', 'themeblvd_shortcodes'),
				'type'		=> 'text',
				'pholder'	=> 'http://'
		    ),
		    /*
		    'image' => array(
				'id' 		=> 'image',
				'name' 		=> __( 'Image (optional)', 'themeblvd_shortcodes'),
				'desc'		=> __( 'Select a small image for the person giving the testimonial. This will look best if you select an image size that is square.', 'themeblvd_shortcodes'),
				'type'		=> 'upload'
		    )
		    */
		    'image' => array(
				'id' 		=> 'image',
				'name' 		=> __( 'Image (optional)', 'themeblvd_shortcodes'),
				'desc'		=> __( 'Enter the URL for an image of the person giving the testimonial. This will look best if you select an image size that is square.<br>Ex: http://yoursite.com/image.jpg', 'themeblvd_shortcodes'),
				'type'		=> 'text',
		    )
		);

		/*--------------------------------------------*/
		/* Display Posts
		/*--------------------------------------------*/

		// Blog
		$options['blog'] = array(
			'category_name' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'themeblvd_shortcodes' ),
				'id' 		=> 'category_name',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'themeblvd_shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'themeblvd_shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'numberposts' => array(
				'name' 		=> __( 'Number of Posts', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The number of posts to display for the post list. If you\'re using filtering, make sure to set this to a high number, or use <code>-1</code> to have no limit on the amount of posts queried.', 'themeblvd_shortcodes' ),
				'id' 		=> 'numberposts',
				'std' 		=> '4',
				'type' 		=> 'text'
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'themeblvd_shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 			=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __('Descending', 'themeblvd_shortcodes'),
					'ASC' 		=> __('Ascending', 'themeblvd_shortcodes')
				)
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'themeblvd_shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text'
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'thumbs' => array(
				'name' 		=> __( 'Featured Images', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Choose whether or not you want featured images to show for each post.', 'themeblvd_shortcodes' ),
				'id' 		=> 'thumbs',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' => array(
					'0' 		=> __( 'Use default blog setting', 'themeblvd_shortcodes' ),
					'show'		=> __( 'Show featured images', 'themeblvd_shortcodes' ), // will be converted to "full" by shortcode
					'hide' 		=> __( 'Hide featured images', 'themeblvd_shortcodes' )
				)
			),
			'meta' => array(
				'name' 		=> __( 'Meta Information', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like the meta information (like date posted, author, etc) to show for each post.', 'themeblvd_shortcodes' ),
				'id' 		=> 'meta',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'Use default blog setting', 'themeblvd_shortcodes' ),
					'show'		=> __( 'Show meta info', 'themeblvd_shortcodes' ),
					'hide' 		=> __( 'Hide meta info', 'themeblvd_shortcodes' )
				)
			)
		);

		// Post Grid
		$options['post_grid'] = array(
			'category_name' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'themeblvd_shortcodes' ),
				'id' 		=> 'category_name',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'themeblvd_shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'themeblvd_shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'columns' => array(
				'name' 		=> __( 'Columns', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Number of posts per row in the grid of posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'columns',
				'std' 		=> '3',
				'type' 		=> 'text'
			),
			'rows' => array(
				'name' 		=> __( 'Rows', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Number of rows in the grid of posts. This does not apply if you\'re using masonry or filtering.', 'themeblvd_shortcodes' ),
				'id' 		=> 'rows',
				'std' 		=> '3',
				'type' 		=> 'text'
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'themeblvd_shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'' 				=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __('Descending', 'themeblvd_shortcodes'),
					'ASC' 		=> __('Ascending', 'themeblvd_shortcodes')
				)
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'themeblvd_shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text'
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'filter' => array(
				'id' 		=> 'filter',
				'name'		=> __( 'Filtering', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'If you want to use filtering, select how the posts should be filtered by the website visitor.', 'themeblvd_shortcodes' ),
				'type'		=> 'select',
				'std'		=> '',
				'options' => array(
					'0'				=> __( 'No filtering', 'themeblvd_shortcodes' ),
					'category'		=> __( 'Filtered by category', 'themeblvd_shortcodes' ),
					'tag'			=> __( 'Filtered by tag', 'themeblvd_shortcodes' ),
					'portfolio'		=> __( 'Filtered by portfolio', 'themeblvd_shortcodes' ),
					'portfolio_tag'	=> __( 'Filtered by portfolio tag', 'themeblvd_shortcodes' )
				)
			),
			'filter_max' => array(
		    	'id' 		=> 'filter_max',
				'name'		=> __( 'Filtering: Max Number of Posts', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'If you\'re using filtering, you can use this option to limit the total number of posts queried. Ex: <code>50</code>', 'themeblvd_shortcodes' ),
				'type'		=> 'text',
				'std'		=> ''
			),
			'masonry' => array(
				'id' 		=> 'masonry',
				'name'		=> __( 'Masonry', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'Select if you\'d like the grid to be display in masonry mode.', 'themeblvd_shortcodes' ),
				'type'		=> 'select',
				'std'		=> '',
				'options' => array(
					'0'			=> __( 'False', 'themeblvd_shortcodes' ),
					'true'		=> __( 'True', 'themeblvd_shortcodes' )
				)
			),
			'masonry_max' => array(
		    	'id' 		=> 'masonry_max',
				'name'		=> __( 'Masonry: Max Number of Posts', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'If using masonry (and not filtering), the maximum number of total posts to pull. Ex: <code>12</code>', 'themeblvd_shortcodes' ),
				'type'		=> 'text',
				'std'		=> ''
			),
			'meta' => array(
				'name' 		=> __( 'Meta Information', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like the meta information (like date posted, author, etc) to show for each post.', 'themeblvd_shortcodes' ),
				'id' 		=> 'meta',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post grid setting', 'themeblvd_shortcodes' ),
					'show'		=> __( 'Show meta info', 'themeblvd_shortcodes' ),
					'hide' 		=> __( 'Hide meta info', 'themeblvd_shortcodes' )
				)
			),
			'excerpt' => array(
				'name' 		=> __( 'Excerpt', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like to show the excerpt or not for each post.', 'themeblvd_shortcodes' ),
				'id' 		=> 'excerpt',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post grid setting', 'themeblvd_shortcodes' ),
					'show'		=> __( 'Show excerpts', 'themeblvd_shortcodes' ),
					'hide' 		=> __( 'Hide excerpts', 'themeblvd_shortcodes' )
				)
			),
			'more' => array(
				'name' 		=> __( 'Read More', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'What would you like to show for each post to lead the reader to the full post?', 'themeblvd_shortcodes' ),
				'id' 		=> 'more',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post grid setting', 'themeblvd_shortcodes' ),
					'text' 		=> __( 'Show text link', 'themeblvd_shortcodes' ),
					'button'	=> __( 'Show button', 'themeblvd_shortcodes' ),
					'none'		=> __( 'Show no button or text link', 'themeblvd_shortcodes' )
				)
			),
			'crop' => array(
				'name' 		=> __( 'Featured Image Crop Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select a custom crop size to be used for the images in the grid. If you select a crop size that doesn\'t have a consistent height, then you may want to enable "Masonry" display from above.<br><br><em>Note: Images are scaled proportionally to fit within their current containers.</em>', 'themeblvd_shortcodes' ),
				'id' 		=> 'crop',
				'std' 		=> 'tb_grid',
				'type'		=> 'select',
				'select'	=> 'crop'
			)
		);

		// Post Showcase
		$options['post_showcase'] = array(
			'category_name' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'themeblvd_shortcodes' ),
				'id' 		=> 'category_name',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'themeblvd_shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'themeblvd_shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'columns' => array(
				'name' 		=> __( 'Columns', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Number of posts per row in the grid of posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'columns',
				'std' 		=> '3',
				'type' 		=> 'text'
			),
			'rows' => array(
				'name' 		=> __( 'Rows', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Number of rows in the grid of posts. This does not apply if you\'re using masonry or filtering.', 'themeblvd_shortcodes' ),
				'id' 		=> 'rows',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'themeblvd_shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'' 				=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __('Descending', 'themeblvd_shortcodes'),
					'ASC' 		=> __('Ascending', 'themeblvd_shortcodes')
				)
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'themeblvd_shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text'
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'filter' => array(
				'id' 		=> 'filter',
				'name'		=> __( 'Filtering', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'If you want to use filtering, select how the posts should be filtered by the website visitor.', 'themeblvd_shortcodes' ),
				'type'		=> 'select',
				'std'		=> '',
				'options' => array(
					'0'				=> __( 'No filtering', 'themeblvd_shortcodes' ),
					'category'		=> __( 'Filtered by category', 'themeblvd_shortcodes' ),
					'tag'			=> __( 'Filtered by tag', 'themeblvd_shortcodes' ),
					'portfolio'		=> __( 'Filtered by portfolio', 'themeblvd_shortcodes' ),
					'portfolio_tag'	=> __( 'Filtered by portfolio tag', 'themeblvd_shortcodes' )
				)
			),
			'filter_max' => array(
		    	'id' 		=> 'filter_max',
				'name'		=> __( 'Filtering: Max Number of Posts', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'If you\'re using filtering, you can use this option to limit the total number of posts queried. Ex: <code>50</code>', 'themeblvd_shortcodes' ),
				'type'		=> 'text',
				'std'		=> ''
			),
			'masonry' => array(
				'id' 		=> 'masonry',
				'name'		=> __( 'Masonry', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'Select if you\'d like the grid to be display in masonry mode.', 'themeblvd_shortcodes' ),
				'type'		=> 'select',
				'std'		=> 'true',
				'options' => array(
					'0'			=> __( 'False', 'themeblvd_shortcodes' ),
					'true'		=> __( 'True', 'themeblvd_shortcodes' )
				)
			),
			'masonry_max' => array(
		    	'id' 		=> 'masonry_max',
				'name'		=> __( 'Masonry: Max Number of Posts', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'If using masonry (and not filtering), the maximum number of total posts to pull. Ex: <code>12</code>', 'themeblvd_shortcodes' ),
				'type'		=> 'text',
				'std'		=> '12'
			),
			'titles' => array(
				'name' 		=> __( 'Titles', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like to show the title or not for each post.', 'themeblvd_shortcodes' ),
				'id' 		=> 'titles',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post showcase setting', 'themeblvd_shortcodes' ),
					'show'		=> __( 'Show titles', 'themeblvd_shortcodes' ),
					'hide' 		=> __( 'Hide titles', 'themeblvd_shortcodes' )
				)
			),
			'excerpt' => array(
				'name' 		=> __( 'Excerpt', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like to show the excerpt or not for each post.', 'themeblvd_shortcodes' ),
				'id' 		=> 'excerpt',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post showcase setting', 'themeblvd_shortcodes' ),
					'show'		=> __( 'Show excerpts', 'themeblvd_shortcodes' ),
					'hide' 		=> __( 'Hide excerpts', 'themeblvd_shortcodes' )
				)
			),
			'crop' => array(
				'name' 		=> __( 'Featured Image Crop Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select a custom crop size to be used for the images in the showcase. If you select a crop size that doesn\'t have a consistent height, then you may want to enable "Masonry" display from above.<br><br><em>Note: Images are scaled proportionally to fit within their current containers.</em>', 'themeblvd_shortcodes' ),
				'id' 		=> 'crop',
				'std' 		=> 'tb_large',
				'type'		=> 'select',
				'select'	=> 'crop'
			)
		);

		// Post List
		$options['post_list'] = array(
			'category_name' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'themeblvd_shortcodes' ),
				'id' 		=> 'category_name',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'themeblvd_shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'themeblvd_shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'numberposts' => array(
				'name' 		=> __( 'Number of Posts', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The number of posts to display for the post list. If you\'re using filtering, make sure to set this to a high number, or use <code>-1</code> to have no limit on the amount of posts queried.', 'themeblvd_shortcodes' ),
				'id' 		=> 'numberposts',
				'std' 		=> '4',
				'type' 		=> 'text'
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'themeblvd_shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 			=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __('Descending', 'themeblvd_shortcodes'),
					'ASC' 		=> __('Ascending', 'themeblvd_shortcodes')
				)
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'themeblvd_shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text'
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'filter' => array(
				'id' 		=> 'filter',
				'name'		=> __( 'Filtering', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'If you want to use filtering, select how the posts should be filtered by the website visitor.', 'themeblvd_shortcodes' ),
				'type'		=> 'select',
				'std'		=> '',
				'options' => array(
					'0'				=> __( 'No filtering', 'themeblvd_shortcodes' ),
					'category'		=> __( 'Filtered by category', 'themeblvd_shortcodes' ),
					'tag'			=> __( 'Filtered by tag', 'themeblvd_shortcodes' ),
					'portfolio'		=> __( 'Filtered by portfolio', 'themeblvd_shortcodes' ),
					'portfolio_tag'	=> __( 'Filtered by portfolio tag', 'themeblvd_shortcodes' )
				)
			),
			'thumbs' => array(
				'name' 		=> __( 'Featured Images', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Choose whether or not you want featured images to show for each post.', 'themeblvd_shortcodes' ),
				'id' 		=> 'thumbs',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' => array(
					'0' 		=> __( 'Use default post list setting', 'themeblvd_shortcodes' ),
					'show'		=> __( 'Show featured images', 'themeblvd_shortcodes' ), // will be converted to "full" by shortcode
					'date'		=> __( 'Show date block', 'themeblvd_shortcodes' ),
					'hide' 		=> __( 'Hide featured images', 'themeblvd_shortcodes' )
				)
			),
			'meta' => array(
				'name' 		=> __( 'Meta Information', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like the meta information (like date posted, author, etc) to show for each post.', 'themeblvd_shortcodes' ),
				'id' 		=> 'meta',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'Use default post list setting', 'themeblvd_shortcodes' ),
					'show'		=> __( 'Show meta info', 'themeblvd_shortcodes' ),
					'hide' 		=> __( 'Hide meta info', 'themeblvd_shortcodes' )
				)
			),
			'more' => array(
				'name' 		=> __( 'Read More', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'What would you like to show for each post to lead the reader to the full post?', 'themeblvd_shortcodes' ),
				'id' 		=> 'more',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'Use default post list setting', 'themeblvd_shortcodes' ),
					'text' 		=> __( 'Show text link', 'themeblvd_shortcodes' ),
					'button'	=> __( 'Show button', 'themeblvd_shortcodes' ),
					'none'		=> __( 'Show no button or text link', 'themeblvd_shortcodes' )
				)
			)
		);

		// Mini Post Grid
		$options['mini_post_grid'] = array(
			'category_name' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'themeblvd_shortcodes' ),
				'id' 		=> 'category_name',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'themeblvd_shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'numberposts' => array(
				'name' 		=> __( 'Number of Posts', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The number of posts to display for the post grid.', 'themeblvd_shortcodes' ),
				'id' 		=> 'numberposts',
				'std' 		=> '4',
				'type' 		=> 'text'
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'themeblvd_shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 			=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __('Descending', 'themeblvd_shortcodes'),
					'ASC' 		=> __('Ascending', 'themeblvd_shortcodes')
				)
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'themeblvd_shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text'
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'align' => array(
				'name' 		=> __( 'Alignment', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to align grid of thumbnails.', 'themeblvd_shortcodes' ),
				'id' 		=> 'align',
				'std' 		=> 'left',
				'type' 		=> 'select',
				'options' 	=> array(
					'left' 		=> __('Left', 'themeblvd_shortcodes'),
					'right' 	=> __('Right', 'themeblvd_shortcodes')
				)
			),
			'gallery' => array(
				'name' 		=> __( 'Galery Override', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'If you’d like to display images from a gallery instead of featured images of standard posts, you can input the ID’s of the attachments to use in the gallery.', 'themeblvd_shortcodes' ),
				'id' 		=> 'gallery',
				'std' 		=> '',
				'type' 		=> 'text'
			)
		);

		// Min Post List
		$options['mini_post_list'] = array(
			'thumb' => array(
				'name' 		=> __( 'Thumbnail Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Size of the featured images for the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'thumb',
				'std' 		=> 'smaller',
				'type' 		=> 'select',
				'options' 	=> array(
					'hide'		=> __('Hide', 'themeblvd_shortcodes' ),
					'small' 	=> __('Small', 'themeblvd_shortcodes'),
					'smaller' 	=> __('Smaller', 'themeblvd_shortcodes'),
					'smallest' 	=> __('Smallest', 'themeblvd_shortcodes'),
					'date'		=> __('Date Block', 'themeblvd_shortcodes' )
				)
			),
			'meta' => array(
				'name' 		=> __( 'Post Meta', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to show post date below post titles.', 'themeblvd_shortcodes' ),
				'id' 		=> 'meta',
				'std' 		=> 'show',
				'type' 		=> 'select',
				'options' 	=> array(
					'show' 		=> __('Show', 'themeblvd_shortcodes'),
					'hide' 		=> __('Hide', 'themeblvd_shortcodes')
				)
			),
			'category_name' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'themeblvd_shortcodes' ),
				'id' 		=> 'category_name',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'themeblvd_shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'numberposts' => array(
				'name' 		=> __( 'Number of Posts', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The number of posts to display for the post list.', 'themeblvd_shortcodes' ),
				'id' 		=> 'numberposts',
				'std' 		=> '4',
				'type' 		=> 'text'
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'themeblvd_shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 			=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __('Descending', 'themeblvd_shortcodes'),
					'ASC' 		=> __('Ascending', 'themeblvd_shortcodes')
				)
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'themeblvd_shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text'
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'columns' => array(
				'name' 		=> __( 'Column Spread', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Here, you can choose to list out your posts separated into columns.<br><br><em>Note: For best results, set your "Number of Posts" option above to a number divisable by the number of columns.</em>', 'themeblvd_shortcodes' ),
				'id' 		=> 'columns',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'1'			=> __( 'Don\'t spread across multiple columns', 'themeblvd_shortcodes' ),
					'2'			=> __( '2 Columns', 'themeblvd_shortcodes' ),
					'3' 		=> __( '3 Columns', 'themeblvd_shortcodes' ),
					'4' 		=> __( '4 Columns', 'themeblvd_shortcodes' ),
					'5' 		=> __( '5 Columns', 'themeblvd_shortcodes' ),
					'6' 		=> __( '6 Columns', 'themeblvd_shortcodes' )
				)
			)
		);

		/*--------------------------------------------*/
		/* Image Icons
		/*--------------------------------------------*/

		$options['icon'] = array(
			'image' => array(
				'name' 		=> __( 'Icon', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select an icon. For adding icons, you can create a folder in your child theme called "icons" -- Anything placed in that directory will show here after the 24-hour cache period is over.', 'themeblvd_shortcodes' ),
				'id' 		=> 'image',
				'std' 		=> 'accepted',
				'type' 		=> 'images',
				'options' 	=> $this->image_icons,
				'img_width'	=> '24' // 1/2 of images' natural widths
			),
			'align' => array(
				'name' 		=> __( 'Icon Alignment', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How you\'d like to align the icon.', 'themeblvd_shortcodes' ),
				'id' 		=> 'align',
				'std' 		=> 'left',
				'type' 		=> 'select',
				'options' 	=> array(
					'left' 		=> __('Left', 'themeblvd_shortcodes'),
					'right' 	=> __('Right', 'themeblvd_shortcodes'),
					'center' 	=> __('Center', 'themeblvd_shortcodes'),
					'none' 		=> __('None', 'themeblvd_shortcodes')
				)
			),
			'width' => array(
				'name' 		=> __( 'Icon Width', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Display width of the icon -- 48, 24, etc.', 'themeblvd_shortcodes' ),
				'id' 		=> 'width',
				'std' 		=> '48',
				'type' 		=> 'text'
			)
		);

		/*--------------------------------------------*/
		/* Inline Elements
		/*--------------------------------------------*/

		// Dropcap
		$options['dropcap'] = array(
			'sc_content' => array(
				'name' 		=> __( 'Dropcap Letter', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The letter you want to appear large, or "dropped."', 'themeblvd_shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'A',
				'type' 		=> 'text'
			)
		);

		// Text Highlight
		$options['highlight'] = array(
			'sc_content' => array(
				'name' 		=> __( 'Content', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Enter a single paragraph of text you\'d like to be highlighted.', 'themeblvd_shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'This text will be highlighted.',
				'type' 		=> 'textarea'
			)
		);

		// Icon Link
		$options['icon_link'] = array(
			'icon' => array(
				'name' 		=> __( 'Link Icon', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Enter an icon name. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.</p><p><em>Note: Do not prefix icon ID with "fa-"</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'icon',
				'std' 		=> 'link',
				'type' 		=> 'text'
			),
			'link' => array(
				'name' 		=> __( 'Link URL', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The full URL of where you want the link to go.<br />Ex: http://google.com', 'themeblvd_shortcodes' ),
				'id' 		=> 'link',
				'std' 		=> 'http://google.com',
				'type' 		=> 'text'
			),
			'sc_content' => array(
				'name' 		=> __( 'Link Text', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The text of the link.', 'themeblvd_shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Link Text...',
				'type' 		=> 'text'
			),
			'color' => array(
				'name' 		=> __( 'Link Icon Color (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Enter a color for the icon, will default to website\'s link color. - Ex: #666666', 'themeblvd_shortcodes' ),
				'id' 		=> 'color',
				'std' 		=> '',
				'type' 		=> 'color'
			),
			'target' => array(
				'name' 		=> __( 'Button Target', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How the button opens the link.', 'themeblvd_shortcodes' ),
				'id' 		=> 'target',
				'std' 		=> '_self',
				'type' 		=> 'select',
				'options' 	=> array(
					'_self' 		=> __('Same Window', 'themeblvd_shortcodes'),
					'_blank' 		=> __('New Window', 'themeblvd_shortcodes'),
					'lightbox' 		=> __('Lightbox', 'themeblvd_shortcodes')
				)
			),
			'title' => array(
				'name' 		=> __( 'Button Title (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'For you SEO folks, this controls the link\'s HTML title tag. If left blank, this will just default to the link\'s text.', 'themeblvd_shortcodes' ),
				'id' 		=> 'title',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'class' => array(
				'name' 		=> __( 'Button CSS Class (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'This will allow you to add an extra CSS class for styling to the link.', 'themeblvd_shortcodes' ),
				'id' 		=> 'class',
				'std' 		=> '',
				'type' 		=> 'text'
			)
		);

		// Label
		$options['label'] = array(
			'sc_content' => array(
				'name' 		=> __( 'Label Text', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The text of the label.', 'themeblvd_shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Label Text...',
				'type' 		=> 'text'
			),
			'style' => array(
				'name' 		=> __( 'Style', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The style of the label.', 'themeblvd_shortcodes' ),
				'id' 		=> 'style',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'default' 	=> __('Default (grey)', 'themeblvd_shortcodes'),
					'info' 		=> __('Info (blue)', 'themeblvd_shortcodes'),
					'success' 	=> __('Success (green)', 'themeblvd_shortcodes'),
					'danger' 	=> __('Danger (red)', 'themeblvd_shortcodes'),
					'warning' 	=> __('Warning (yellow)', 'themeblvd_shortcodes')
				)
			),
			'icon' => array(
				'name' 		=> __( 'Label Icon (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Enter an icon name to appear at the start of the label. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.</p><p><em>Note: Do not prefix icon ID with "fa-"</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'icon',
				'std' 		=> '',
				'type' 		=> 'text'
			)
		);

		// Lead text
		$options['lead'] = array(
			'sc_content' => array(
				'name' 		=> __( 'Lead Text', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Enter a single paragraph of text you\'d like to show a bit larger than the standard body text.', 'themeblvd_shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'This text will show larger than the standard body text.',
				'type' 		=> 'textarea'
			)
		);

		/*--------------------------------------------*/
		/* Pricing Table
		/*--------------------------------------------*/

		$options['pricing_table'] = array();

		/*--------------------------------------------*/
		/* Sliders
		/*--------------------------------------------*/

		// Custom Slider
		$options['slider'] = array(
			'id' => array(
				'name' 		=> __( 'Slider ID', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select from your your custom-built sliders, using the <a href="http://wordpress.org/plugins/theme-blvd-sliders/" target="_blank">Theme Blvd Sliders plugin</a>.', 'themeblvd_shortcodes' ),
				'id' 		=> 'id',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> $this->sliders
			)
		);

		// Gallery Slider
		$options['gallery_slider'] = array(
			'ids' => array(
				'name' 		=> __( 'Image ID\'s', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Comma separated list of attachments ID’s.<br />Ex: 293,294,295', 'themeblvd_shortcodes' ),
				'id' 		=> 'ids',
				'std' 		=> '1,2,3',
				'type' 		=> 'text'
			),
			'title' => array(
				'name' 		=> __( 'Titles', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to display titles of attachments over slides.', 'themeblvd_shortcodes' ),
				'id' 		=> 'title',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'caption' => array(
				'name' 		=> __( 'Captions', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to display captions of attachments over slides.', 'themeblvd_shortcodes' ),
				'id' 		=> 'caption',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'size' => array(
				'name' 		=> __( 'Image Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Crop size for images, use "full" to display uncropped versions of the images.', 'themeblvd_shortcodes' ),
				'id' 		=> 'size',
				'std' 		=> 'slider-large',
				'type' 		=> 'text'
			),
			'interval' => array(
				'name' 		=> __( 'Slider Speed', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Milliseconds between auto slide transitions. For example, 5000 milliseconds = 5 seconds.', 'themeblvd_shortcodes' ),
				'id' 		=> 'interval',
				'std' 		=> '5000',
				'type' 		=> 'text'
			),
			'pause' => array(
				'name' 		=> __( 'Pause on Hover', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to pause slider on mouse hover.', 'themeblvd_shortcodes' ),
				'id' 		=> 'pause',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'frame' => array(
				'name' 		=> __( 'Frame', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to wrap the slider in a frame or not.', 'themeblvd_shortcodes' ),
				'id' 		=> 'frame',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'nav_standard' => array(
				'name' 		=> __( 'Standard Navigation', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to show standard navigation indicator dots.', 'themeblvd_shortcodes' ),
				'id' 		=> 'nav_standard',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'nav_arrows' => array(
				'name' 		=> __( 'Navigation Arrows', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to show standard navigation arrows.', 'themeblvd_shortcodes' ),
				'id' 		=> 'nav_arrows',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'subgroup_start' => array(
		    	'type'		=> 'subgroup_start',
		    	'class'		=> 'show-hide-toggle'
		    ),
			'nav_thumbs' => array(
				'name' 		=> __( 'Thumbnail Navigation', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to include thumbnail images to navigate the slider.', 'themeblvd_shortcodes' ),
				'id' 		=> 'nav_thumbs',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				),
				'class'		=> 'trigger'
			),
			'thumb_size' => array(
				'name' 		=> __( 'Thumbnail Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select the size of the images for the thumbnail navigation.', 'themeblvd_shortcodes' ),
				'id' 		=> 'thumb_size',
				'std' 		=> 'square_smallest',
				'type' 		=> 'select',
				'options' 	=> array(
					'small' 	=> __('Small', 'themeblvd_shortcodes'),
					'smaller' 	=> __('Smaller', 'themeblvd_shortcodes'),
					'smallest' 	=> __('Smallest', 'themeblvd_shortcodes')
				),
				'class'		=> 'receiver receiver-true'
			),
			'subgroup_end' => array(
		    	'type'		=> 'subgroup_end'
		    ),
		    'dark_text' => array(
				'name' 		=> __( 'Dark Text', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to use dark text for titles, captions, and standard nav; use when images are light.', 'themeblvd_shortcodes' ),
				'id' 		=> 'dark_text',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			)
		);

		// Post Slider
		$options['post_slider'] = array(
			'style' => array(
				'name' 		=> __( 'Display Style', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select one of the preset style for how the post slider displays. When referring to "included elements" it\'s referring to post titles, meta, excerpts, and buttons configured in the following options.', 'themeblvd_shortcodes' ),
				'id' 		=> 'style',
				'std' 		=> '1',
				'type' 		=> 'radio',
				'options'	=> apply_filters('themeblvd_post_slider_styles', array(
					'1'			=> __('<strong>Style #1:</strong> Display included elements open and center on each slide.', 'themeblvd_shortcodes'),
					'2'			=> __('<strong>Style #2:</strong> Display included elements in a shaded content area positioned to the side of each slide.', 'themeblvd_shortcodes'),
					'3'			=> __('<strong>Style #3:</strong> An open, more magazine-style post slider.', 'themeblvd_shortcodes')
				))
			),
			'interval' => array(
				'name' 		=> __( 'Slider Speed', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Seconds in between transitions, 0 for no auto-advancing.', 'themeblvd_shortcodes' ),
				'id' 		=> 'interval',
				'std' 		=> '3',
				'type' 		=> 'text'
			),
			'nav_standard' => array(
				'name' 		=> __( 'Navigation Dots', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to show standard navigation dots to control slider.', 'themeblvd_shortcodes' ),
				'id' 		=> 'nav_standard',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'nav_arrows' => array(
				'name' 		=> __( 'Navigation Arrows', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to show navigation arows to control slider.', 'themeblvd_shortcodes' ),
				'id' 		=> 'nav_arrows',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'nav_thumbs' => array(
				'name' 		=> __( 'Navigation Thumbnails', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to show thumbnail navigation to control slider.', 'themeblvd_shortcodes' ),
				'id' 		=> 'nav_thumbs',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'pause' => array(
				'name' 		=> __( 'Pause on Hover', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to pause slider rotation on mouse hover.', 'themeblvd_shortcodes' ),
				'id' 		=> 'pause',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'crop' => array(
				'name' 		=> __( 'Image Crop Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Crop size for featured image used as each slide.', 'themeblvd_shortcodes' ),
				'id' 		=> 'crop',
				'std' 		=> 'slider-large',
				'type' 		=> 'select',
				'select'	=> 'crop'
			),
			'slide_link' => array(
				'name' 		=> __( 'Link Handling', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select how the user interacts with each slide and where they\'re directed to.', 'themeblvd_shortcodes' ),
				'id' 		=> 'slide_link',
				'std' 		=> 'button',
				'type' 		=> 'select',
				'options'	=> array(
					'none'			=> __('No linking', 'themeblvd_shortcodes'),
					'image_post'	=> __('Images link to posts', 'themeblvd_shortcodes'),
					'image_link'	=> __('Images link to each post\'s featured image link setting', 'themeblvd_shortcodes'),
					'button'		=> __('Slides have buttons linking to posts', 'themeblvd_shortcodes'),
				)
			),
			'button_text' => array(
				'name' 		=> __( 'Button Text', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'If you selected to show buttons, here you can set the text of the buttons.', 'themeblvd_shortcodes' ),
				'id' 		=> 'button_text',
				'std' 		=> 'View Post',
				'type' 		=> 'text'
			),
			'button_size' => array(
				'id' 		=> 'button_size',
				'name'		=> __( 'Button Size', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'If you selected to show buttons, here you can set the size of the buttons.', 'themeblvd_shortcodes' ),
				'type'		=> 'select',
				'std'		=> 'default',
				'options'	=> array(
					'mini' 		=> __( 'Mini', 'themeblvd_shortcodes' ),
					'small' 	=> __( 'Small', 'themeblvd_shortcodes' ),
					'default' 	=> __( 'Normal', 'themeblvd_shortcodes' ),
					'large' 	=> __( 'Large', 'themeblvd_shortcodes' ),
					'x-large' 	=> __( 'Extra Large', 'themeblvd_shortcodes' )
				),
				'class'		=> 'hide receiver receiver-button'
			),
			'category' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'themeblvd_shortcodes' ),
				'id' 		=> 'category',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'themeblvd_shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'themeblvd_shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'numberposts' => array(
				'name' 		=> __( 'Number of Posts', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The number of posts to display for the slider.', 'themeblvd_shortcodes' ),
				'id' 		=> 'numberposts',
				'std' 		=> '5',
				'type' 		=> 'text'
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'themeblvd_shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 			=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __('Descending', 'themeblvd_shortcodes'),
					'ASC' 		=> __('Ascending', 'themeblvd_shortcodes')
				)
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'themeblvd_shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text'
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'dark_text'	=> array(
				'name' 		=> __( 'Use Dark Text', 'themeblvd_shortcodes' ),
				'id'		=> 'dark_text',
				'desc'		=> __( 'Use dark navigation elements and dark text for any titles and descriptions.', 'themeblvd_shortcodes'),
				'std'		=> 'false',
				'type'		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'title'	=> array(
				'name' 		=> __( 'Show Post Titles', 'themeblvd_shortcodes' ),
				'id'		=> 'title',
				'desc'		=> __( 'Display title for each post.', 'themeblvd_shortcodes'),
				'std'		=> 'true',
				'type'		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'meta'	=> array(
				'name' 		=> __( 'Show Post Meta', 'themeblvd_shortcodes' ),
				'id'		=> 'meta',
				'desc'		=> __( 'Display meta info for each post.', 'themeblvd_shortcodes'),
				'std'		=> 'true',
				'type'		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'excerpts'	=> array(
				'name' 		=> __( 'Show Post Excerpts', 'themeblvd_shortcodes' ),
				'id'		=> 'excerpts',
				'desc'		=> __( 'Display excerpt for each post.', 'themeblvd_shortcodes'),
				'std'		=> 'false',
				'type'		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			)
		);

		// Post Slider
		$options['post_grid_slider'] = array(
			'timeout' => array(
				'name' 		=> __( 'Slider Speed', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Seconds in between transitions, 0 for no auto-advancing.', 'themeblvd_shortcodes' ),
				'id' 		=> 'timeout',
				'std' 		=> '3',
				'type' 		=> 'text'
			),
			'nav' => array(
				'name' 		=> __( 'Slider Navigation', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to show slider navigation.', 'themeblvd_shortcodes' ),
				'id' 		=> 'nav',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'columns' => array(
				'name' 		=> __( 'Columns', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Number of posts per row in each slide.', 'themeblvd_shortcodes' ),
				'id' 		=> 'columns',
				'std' 		=> '3',
				'type' 		=> 'text'
			),
			'slides' => array(
		    	'id' 		=> 'slides',
				'name'		=> __( 'Maximum Number of Slides', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'Enter in the maximum number of slides you\'d like to show. The number you enter here will be multiplied by the amount of columns you selected in the previous option to figure out how many posts should be showed in the slider. You can leave this option blank if you\'d like to show all posts from your configured query.', 'themeblvd_shortcodes' ),
				'type'		=> 'text',
				'std'		=> '3'
			),
			'category_name' => array(
				'name' 		=> __( 'Option 1: Posts By Category', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Category slug to include posts from.<br />Ex: my-category', 'themeblvd_shortcodes' ),
				'id' 		=> 'category_name',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'tag' => array(
				'name' 		=> __( 'Option 2: Posts By Tag', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Tag to include posts from.<br />Ex: my-tag', 'themeblvd_shortcodes' ),
				'id' 		=> 'tag',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'themeblvd_shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'themeblvd_shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 			=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __('Descending', 'themeblvd_shortcodes'),
					'ASC' 		=> __('Ascending', 'themeblvd_shortcodes')
				)
			),
			'offset' => array(
				'name' 		=> __( 'Offset', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How many posts to offset from the start of the query.', 'themeblvd_shortcodes' ),
				'id' 		=> 'offset',
				'std' 		=> '0',
				'type' 		=> 'text'
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'meta' => array(
				'name' 		=> __( 'Meta Information', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like the meta information (like date posted, author, etc) to show for each post.', 'themeblvd_shortcodes' ),
				'id' 		=> 'meta',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post grid setting', 'themeblvd_shortcodes' ),
					'show'		=> __( 'Show meta info', 'themeblvd_shortcodes' ),
					'hide' 		=> __( 'Hide meta info', 'themeblvd_shortcodes' )
				)
			),
			'excerpt' => array(
				'name' 		=> __( 'Excerpt', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select if you\'d like to show the excerpt or not for each post.', 'themeblvd_shortcodes' ),
				'id' 		=> 'excerpt',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post grid setting', 'themeblvd_shortcodes' ),
					'show'		=> __( 'Show excerpts', 'themeblvd_shortcodes' ),
					'hide' 		=> __( 'Hide excerpts', 'themeblvd_shortcodes' )
				)
			),
			'more' => array(
				'name' 		=> __( 'Read More', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'What would you like to show for each post to lead the reader to the full post?', 'themeblvd_shortcodes' ),
				'id' 		=> 'more',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'0'			=> __( 'Use default post grid setting', 'themeblvd_shortcodes' ),
					'text' 		=> __( 'Show text link', 'themeblvd_shortcodes' ),
					'button'	=> __( 'Show button', 'themeblvd_shortcodes' ),
					'none'		=> __( 'Show no button or text link', 'themeblvd_shortcodes' )
				)
			),
			'crop' => array(
				'name' 		=> __( 'Featured Image Crop Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select a custom crop size to be used for the images in the grid. If you select a crop size that doesn\'t have a consistent height, then you may want to enable "Masonry" display from above.<br><br><em>Note: Images are scaled proportionally to fit within their current containers.</em>', 'themeblvd_shortcodes' ),
				'id' 		=> 'crop',
				'std' 		=> 'tb_grid',
				'type'		=> 'select',
				'select'	=> 'crop'
			)
		);

		/*--------------------------------------------*/
		/* Stats
		/*--------------------------------------------*/

		// Progress Bar
		$options['progress_bar'] = array(
			'label' => array(
				'name' 		=> __( 'Label', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Enter a label for what this bar represents.', 'themeblvd_shortcodes' ),
				'id' 		=> 'label',
				'std' 		=> 'Graphic Design',
				'type' 		=> 'text'
			),
			'percent' => array(
				'name' 		=> __( 'Bar Percent', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'A percentage of how far the bar is.<br>Ex: 25, 50, 80, etc.', 'themeblvd_shortcodes' ),
				'id' 		=> 'percent',
				'std' 		=> '50',
				'type' 		=> 'text'
			),
			'color' => array(
				'name' 		=> __( 'Bar Color', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Color of the bar.', 'themeblvd_shortcodes' ),
				'id' 		=> 'color',
				'std' 		=> '#428bca',
				'type' 		=> 'color'
			),
			'striped' => array(
				'name' 		=> __( 'Striped', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether the bar has the striped effect or not.', 'themeblvd_shortcodes' ),
				'id' 		=> 'striped',
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			)
		);

		// Milestone
		$options['milestone'] = array(
			'milestone' => array(
				'id' 		=> 'milestone',
				'name'		=> __('Milestone', 'themeblvd'),
				'desc'		=> __('Enter the accomplished milestone Optionally, you may include symbols before and/or after the number.<br>Ex: 500, $500, 500+, etc', 'themeblvd'),
				'std'		=> '500',
				'type'		=> 'text'
			),
			'color' => array(
				'id' 		=> 'color',
				'name'		=> __('Milestone Color', 'themeblvd'),
				'desc'		=> __('Text color for the milestone number.', 'themeblvd'),
				'std'		=> '#0c9df0',
				'type'		=> 'color'
			),
			'text' => array(
				'id' 		=> 'text',
				'name'		=> __('Description', 'themeblvd'),
				'desc'		=> __('Enter a very simple description for the milestone number.', 'themeblvd'),
				'std'		=> 'Cups of Coffee',
				'type'		=> 'text'
			),
			'boxed' => array(
				'id' 		=> 'boxed',
				'name'		=> __('Boxed', 'themeblvd'),
				'desc'		=> __('Select whether or not to wrap the milestone in a box.', 'themeblvd'),
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			)
		);

		// Milestone Ring
		$options['milestone_ring'] = array(
			'percent' => array(
				'id' 		=> 'percent',
				'name'		=> __('Milestone Percent', 'themeblvd'),
				'desc'		=> __('Enter an integer that is a fraction of 100. This will be represented as a visual percentage.<br>Ex: 25, 50, 75, etc.', 'themeblvd'),
				'std'		=> '75',
				'type'		=> 'text'
			),
			'color' => array(
				'id' 		=> 'color',
				'name'		=> __('Milestone Color', 'themeblvd'),
				'desc'		=> __('This is the color of the milestone ring, which is a visual representation of the percentage.', 'themeblvd'),
				'std'		=> '#0c9df0',
				'type'		=> 'color'
			),
			'display' => array(
				'id' 		=> 'display',
				'name'		=> __('Display', 'themeblvd'),
				'desc'		=> __('Enter the text to display in the middle of the block.<br>Ex: 25%, 50%, 75%, etc.', 'themeblvd'),
				'std'		=> '75%',
				'type'		=> 'text'
			),
			'title' => array(
				'id' 		=> 'title',
				'name'		=> __('Title (optional)', 'themeblvd'),
				'desc'		=> __('Enter a short title to display below the milestone.', 'themeblvd'),
				'type'		=> 'text'
			),
			'text' => array(
				'id' 		=> 'text',
				'name'		=> __('Description (optional)', 'themeblvd'),
				'desc'		=> __('Enter a short description to display below the milestone.', 'themeblvd'),
				'type'		=> 'textarea',
			),
			'text_align' => array(
				'id' 		=> 'text_align',
				'name'		=> __('Text Alignment', 'themeblvd'),
				'desc'		=> __('If you\'ve entered a title and/or description, select how would you like the text aligned.', 'themeblvd'),
				'std'		=> 'center',
				'type'		=> 'select',
				'options'	=> array(
					'left' 		=> __( 'Left', 'themeblvd_shortcodes' ),
					'right' 	=> __( 'Right', 'themeblvd_shortcodes' ),
					'center' 	=> __( 'Center', 'themeblvd_shortcodes' )
				)
			),
			'boxed' => array(
				'id' 		=> 'boxed',
				'name'		=> __('Boxed', 'themeblvd'),
				'desc'		=> __('Select whether or not to wrap the milestone in a box.', 'themeblvd'),
				'std' 		=> 'false',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			)
		);

		/*--------------------------------------------*/
		/* Tabs
		/*--------------------------------------------*/

		$options['tabs'] = array(
			'num' => array(
				'name' 		=> __( 'Number of Tabs', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Enter the number of tabs. This will help you to setup this example starting point to insert into your page or post.', 'themeblvd_shortcodes' ),
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
					'12' 		=> '12'
				)
			),
			'style' => array(
				'name' 		=> __( 'Style', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The tabs can styled to be framed or open. When the tabs are framed, there will be a box around each tab\'s content.', 'themeblvd_shortcodes' ),
				'id' 		=> 'style',
				'std' 		=> 'pills',
				'type' 		=> 'select',
				'options' 	=> array(
					'framed' 	=> __('Framed', 'themeblvd_shortcodes'),
					'open' 		=> __('Open', 'themeblvd_shortcodes')
				)
			),
			'nav' => array(
				'name' 		=> __( 'Navigation Style', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The "Tabs" style navigation will be the typical choice here, but use "Pills" for different look.', 'themeblvd_shortcodes' ),
				'id' 		=> 'nav',
				'std' 		=> 'tabs',
				'type' 		=> 'select',
				'options' 	=> array(
					'tabs' 		=> __('Tabs', 'themeblvd_shortcodes'),
					'pills' 	=> __('Pills', 'themeblvd_shortcodes')
				)
			)
		);

		/*--------------------------------------------*/
		/* Toggles
		/*--------------------------------------------*/

		$options['accordion'] = array(
			'desc' => array(
				'desc' 		=> __( 'The [accordion] shortcode is simply a way to group your toggles. When one toggle in an accodion is opened, all other toggles within will be closed.', 'themeblvd_shortcodes' ),
				'id' 		=> 'desc',
				'type' 		=> 'info'
			),
			'num' => array(
				'name' 		=> __( 'Number of Toggles', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Enter the number of toggles. This will help you to setup this example starting point to insert into your page or post.', 'themeblvd_shortcodes' ),
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
					'12' 		=> '12'
				)
			)
		);

		$options['toggle'] = array(
			'title' => array(
				'name' 		=> __( 'Toggle Title', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The title text of the toggle, which is clicked to reveal the content.', 'themeblvd_shortcodes' ),
				'id' 		=> 'title',
				'std' 		=> 'Title here...',
				'type' 		=> 'text'
			),
			'sc_content' => array(
				'name' 		=> __( 'Toggle Content', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>The content within the toggle.</p><p><em>Note: The content can be further edited from your WordPress editor after being inserted.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'Content here...',
				'type' 		=> 'textarea'
			)
		);

		/*--------------------------------------------*/
		/* Vector Icons
		/*--------------------------------------------*/

		$options['vector_icon'] = array(
			'icon' => array(
				'name' 		=> __( 'Icon', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Enter an icon name. You can browse available FontAwesome icons in the above browser.', 'themeblvd_shortcodes' ),
				'id' 		=> 'icon',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'color' => array(
				'name' 		=> __( 'Icon Color (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Enter a color for the icon - Ex: #666666', 'themeblvd_shortcodes' ),
				'id' 		=> 'color',
				'std' 		=> '',
				'type' 		=> 'color'
			),
			'size' => array(
				'name' 		=> __( 'Icon Size (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Enter a size for the icon - 20px, 2em, etc.', 'themeblvd_shortcodes' ),
				'id' 		=> 'size',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'rotate' => array(
				'name' 		=> __( 'Icon Rotation (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select how you\'d like to rotate the icon.', 'themeblvd_shortcodes' ),
				'id' 		=> 'rotate',
				'std' 		=> 'none',
				'type' 		=> 'select',
				'options' 	=> array(
					'none' 		=> __('None', 'themeblvd_shortcodes'),
					'90' 		=> '90',
					'180' 		=> '180',
					'270' 		=> '270'
				)
			),
			'flip' => array(
				'name' 		=> __( 'Icon Flip (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Select how you\'d like to flip the icon.', 'themeblvd_shortcodes' ),
				'id' 		=> 'flip',
				'std' 		=> 'none',
				'type' 		=> 'select',
				'options' 	=> array(
					'none' 		=> __('None', 'themeblvd_shortcodes'),
					'horizontal'=> __('Horizontal', 'themeblvd_shortcodes'),
					'vertical' 	=> __('Vertical', 'themeblvd_shortcodes')
				)
			),
			'class' => array(
				'name' 		=> __( 'Icon CSS Class (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'For those that are familiar with FontAwesome, here you can add your own CSS class to the icon, if you want.', 'themeblvd_shortcodes' ),
				'id' 		=> 'class',
				'std' 		=> '',
				'type' 		=> 'text'
			)
		);

		$options = apply_filters( 'themeblvd_shortcodes_options', $options );

		return apply_filters( 'themeblvd_shortcodes_options_'.$type, $options[$type] );
	}

	/**
	 * Display a preview for the shortcode as it's being configured.
	 *
	 * @since 1.4.0
	 */
	private function preview( $group, $subgroup = '' ) {

		$content = 'false';

		// The following shortcodes have their examples
		// wrapped in [raw]
		$raw_items = apply_filters( 'themeblvd_raw_shortcodes', array( 'jumbotron', 'column', 'tabs' ) );

		// Determine if this item should be wrapped in [raw]
		// For example:
		// [raw]
		// [example]
		// Inner content on its own line AND shortcode wrapped in raw ...
		// [/example]
		// [/raw]
		$raw = 'false';

		if ( $subgroup ) {
			if ( in_array($subgroup, $raw_items) ) {
				$raw = 'true';
			}
		} else {
			if ( in_array($group, $raw_items) ) {
				$raw = 'true';
			}
		}

		// The following shortcodes, which should contain
		// wrapped content, will be cleaned up for presentation.
		$clean_items = apply_filters( 'themeblvd_clean_shortcodes', array( 'icon_list', 'popup' ) );

		// Determine if this item should be cleaned in its display.
		// For example:
		// [example]
		// Inner content on its own line ...
		// [/example]
		$clean = 'false';

		if ( $subgroup ) {
			if ( in_array($subgroup, $clean_items) ) {
				$clean = 'true';
			}
		} else {
			if ( in_array($group, $clean_items) ) {
				$clean = 'true';
			}
		}

		// Setup default preview content
		$shortcode = $group;
		if ( $subgroup ) {
			$shortcode = $subgroup;
		}

		$default_content = '';

		if ( $shortcode == 'column' ) {

			$default_content .= '[raw]<br>';

			$default_content .= '[column size="1/3" wpautop="true"]<br>';
			$default_content .= 'Column 1...<br>';
			$default_content .= '[/column]<br>';

			$default_content .= '[column size="1/3" wpautop="true"]<br>';
			$default_content .= 'Column 2...<br>';
			$default_content .= '[/column]<br>';

			if ( version_compare(TB_FRAMEWORK_VERSION, '2.5.0', '<') ) {
				$default_content .= '[column size="1/3" wpautop="true" last]<br>';
			} else {
				$default_content .= '[column size="1/3" wpautop="true"]<br>';
			}

			$default_content .= 'Column 3...<br>';
			$default_content .= '[/column]<br>';

			if ( version_compare(TB_FRAMEWORK_VERSION, '2.5.0', '<') ) {
				$default_content .= '[clear]<br>';
			}

			$default_content .= '[/raw]';

		} else if ( $shortcode == 'tabs' ) {

			$default_content .= '[raw]<br>';

			$default_content .= '[tabs style="framed" nav="tabs" tab_1="Title #1" tab_2="Title #2" tab_3="Title #3"]<br>';
			$default_content .= '[tab_1]Tab 1...[/tab_1]<br>';
			$default_content .= '[tab_2]Tab 2...[/tab_2]<br>';
			$default_content .= '[tab_3]Tab 3...[/tab_3]<br>';
			$default_content .= '[/tabs]<br>';

			$default_content .= '[/raw]';

		} else if ( $shortcode == 'accordion' ) {

			$default_content .= '[accordion]<br>';
			$default_content .= '[toggle title="Toggle #1"]Content of toggle #1.[/toggle]<br>';
			$default_content .= '[toggle title="Toggle #2"]Content of toggle #2.[/toggle]<br>';
			$default_content .= '[toggle title="Toggle #3"]Content of toggle #3.[/toggle]<br>';
			$default_content .= '[/accordion]';

		} else if ( $shortcode == 'pricing_table' ) {

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

			$default_content .= '['.$shortcode;

			$options = $this->get_options($shortcode);

			if ( count($options) > 0 ) {
				foreach( $options as $option ) {

					if ( in_array( $option['type'], array( 'subgroup_start', 'subgroup_end', 'info' ) ) ) {
						continue;
					}

					if ( ! empty( $option['std'] ) && $option['std'] != 'none' && $option['id'] != 'sc_content' ) {
						$default_content .= sprintf( ' %s="%s"', $option['id'], $option['std'] );
					}
				}
			}

			$default_content .= ']';

			if ( isset( $options['sc_content'] ) ) {

				$content = 'true';
				$sc_content = htmlspecialchars( $options['sc_content']['std'] );
				$sc_content = str_replace( "\n", '<br>', $sc_content );

				if ( $raw === 'true' || $clean === 'true' ) {
					$sc_content = sprintf( '<br>%s<br>', $sc_content );
				}

				$default_content .= $sc_content;
				$default_content .= sprintf( '[/%s]', $shortcode );
			}

			if ( $raw === 'true' ) {
				$default_content = sprintf( '[raw]<br>%s</br>[/raw]', $default_content );
			}

		}

		// Output
		echo '<div class="shortcode-preview-wrap">';
		printf( '<div class="shortcode-preview-reset hide">%s</div>', $default_content );
		printf( '<div class="shortcode-preview shortcode-preview-%1$s shortcode-preview-%2$s" data-group="%1$s" data-sub-group="%2$s" data-content="%3$s" data-raw="%4$s" data-clean="%5$s">', $group, $subgroup, $content, $raw, $clean );
		echo $default_content;
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
		echo '<a href="#">'.__('Browse Vector Icons', 'themeblvd_shortcodes').'<i class="fa fa-caret-down"></i></a>';
		echo '</div>';

		echo '<div class="icon-browser-content">';

		echo '<div class="icon-browser-help">'.__('Click an icon to select it for your [vector_icon] shortcode. You can also hover over any icon to see its ID in case you want to use it for another shortcode, as well.', 'themeblvd_shortcodes').'</div>';

		// Display Icons
		foreach ( $this->vector_icons as $icon => $icon_name ) {
			echo '<div class="select-icon-wrap tooltip-wrap">';
			printf( '<a href="#" class="select-icon" data-id="%1$s" data-tooltip-text="%1$s"><i class="fa fa-%1$s fa-2x fa-fw"></i></a>', $icon );
			echo '</div>';
		}

		echo '</div><!-- .icon-browser-content (end) -->';
		echo '</div><!-- .icon-browser (end) -->';
	}

	/**
	 * An interface to browse colors.
	 *
	 * @since 1.4.0
	 */
	private function color_browser( $args ) {

		$class = 'color-browser';

		// Button gradients in this theme?
		if ( in_array( 'tb-btn-gradient', apply_filters( 'body_class', array() ) ) ) {
			$class .= ' tb-btn-gradient';
		}

		// Start output
		printf( '<div class="%s">', $class );

		echo '<div id="section-color-browser" class="section section-select">';
		echo '<h4 class="heading">'.$args['title'].'</h4>';
		echo '<div class="option">';
		echo '<div class="controls">';

		$colors = themeblvd_colors();
		// $colors = array('custom' => $colors['custom']) + $colors; // Shift "custom" from 2nd position to 1st

		foreach ( $colors as $id => $name ) {

			if ( $id == 'custom' || $id == 'default' ) {
				$name = str_replace(' Color', '', $name);
			}

			$wrap_class = 'select-color-wrap tooltip-wrap';
			if ( $id == $args['std'] ) {
				$wrap_class .= ' selected';
			}

			printf('<div class="%s">', $wrap_class );

			$color_class = sprintf( 'color-%1$s %1$s', $id );
			if ( in_array( $id, array( 'default', 'info', 'warning', 'danger', 'success' ) ) ) {
				$color_class = str_replace( ' '.$id, ' btn-'.$id, $color_class );
			}

			printf( '<a href="#" class="select-color" data-color="%1$s" data-tooltip-text="%2$s"><span class="%3$s">%2$s</span></a>', $id, $name, $color_class );

			echo '</div><!-- .select-color-wrap (end) -->';

		}

		echo '</div><!-- .controls (end) -->';
		echo '<div class="explain">'.$args['desc'].'</div>';
		echo '<div class="clear"></div>';
		echo '</div><!-- .option (end) -->';
		echo '</div><!-- .section (end) -->';

		echo '</div><!-- .color-browser (end) -->';

	}
}