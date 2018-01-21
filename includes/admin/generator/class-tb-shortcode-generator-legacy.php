<?php
/**
 * This file contains the shortcode generator
 * for older themes.
 *
 * @package Theme Blvd Shortcodes
 */

/**
 * Shortcode generator legacy compat.
 */
class Theme_Blvd_Shortcode_Generator_Legacy {

	/**
	 * Reference of original shortcode
	 * generator object.
	 *
	 * @since 1.5.0
	 *
	 * @var Theme_Blvd_Shortcode_Generator
	 */
	private $generator = null;

	/**
	 * Constructor.
	 *
	 * @since 1.5.0
	 *
	 * @param Theme_Blvd_Shortcode_Generator $generator A reference of the original generator object.
	 */
	public function __construct( $generator ) {

		$this->generator = $generator;

	}

	/**
	 * Get groups of tabs
	 *
	 * @since 1.5.0
	 */
	public function get_groups() {

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
				),
			),
			array(
				'id'	=> 'display_posts',
				'name'	=> __( 'Display Posts', 'theme-blvd-shortcodes' ),
				'sub'	=> array(
					'post_grid'			=> __( 'Post Grid', 'theme-blvd-shortcodes' ),
					'post_list'			=> __( 'Post List', 'theme-blvd-shortcodes' ),
					'mini_post_grid'	=> __( 'Mini Post Grid', 'theme-blvd-shortcodes' ),
					'mini_post_list'	=> __( 'Mini Post List', 'theme-blvd-shortcodes' ),
				),
			),
			array(
				'id'	=> 'icons',
				'name'	=> __( 'Icons', 'theme-blvd-shortcodes' ),
				'sub'	=> array(
					'vector_icon'	=> __( 'FontAwesome Icon', 'theme-blvd-shortcodes' ),
					'icon'			=> __( 'Image Icon', 'theme-blvd-shortcodes' ),
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
				'id'	=> 'sliders',
				'name'	=> __( 'Sliders', 'theme-blvd-shortcodes' ),
				'sub'	=> array(
					'slider'			=> __( 'Custom Slider', 'theme-blvd-shortcodes' ),
					'gallery_slider'	=> __( 'Gallery Slider', 'theme-blvd-shortcodes' ),
					'post_slider'		=> __( 'Post Slider', 'theme-blvd-shortcodes' ),
					'post_grid_slider'	=> __( 'Post Grid Slider', 'theme-blvd-shortcodes' ),
					'post_list_slider'	=> __( 'Post List Slider', 'theme-blvd-shortcodes' ),
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
		 * Filter tabbed groups of legacy shortcode
		 * generator for older themes.
		 *
		 * @since 1.5.0
		 *
		 * @var array
		 */
		return apply_filters( 'themeblvd_shortcodes_groups_legacy', $groups );

	}

	/**
	 * Get options for shortcodes
	 *
	 * @since 1.5.0
	 *
	 * @param string $type Type of shortcode element to pull options from.
	 */
	public function get_options( $type ) {

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
				),
			),
			'icon_before' => array(
				'name' 		=> __( 'Icon Before Button Text (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>Icon before text of button. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.</p><p><em>Note: Do not prefix icon ID with "fa-"</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon_before',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'icon_after' => array(
				'name' 		=> __( 'Icon After Button Text (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>Icon after text of button. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.</p><p><em>Note: Do not prefix icon ID with "fa-"</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon_after',
				'std' 		=> '',
				'type' 		=> 'text',
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
				'desc'		=> __( 'Choose the number of columns along with the corresponding width configurations. This will give you a starting point for columns arrangement you can insert into your page or post.', 'theme-blvd-shortcodes' ),
				'type'		=> 'columns',
				'std'		=> array(
		           'num' => '3',
		            'width' => array(
	                    '1' => 'grid_12',
	                    '2' => 'grid_6-grid_6',
	                    '3' => 'grid_4-grid_4-grid_4',
	                    '4' => 'grid_3-grid_3-grid_3-grid_3',
	                    '5' => 'grid_fifth_1-grid_fifth_1-grid_fifth_1-grid_fifth_1-grid_fifth_1',
	                ),
				),
				'options'	=> 'element',
			),
			'subgroup_end' => array(
		    	'type'		=> 'subgroup_end',
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
			'style' => array(
				'name' 		=> __( 'Style', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The style of divider line used to breakup your content.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'style',
				'std' 		=> 'solid',
				'type' 		=> 'select',
				'options' 	=> array(
					'solid' 	=> __( 'Solid Line', 'theme-blvd-shortcodes' ),
					'dashed' 	=> __( 'Dashed Line', 'theme-blvd-shortcodes' ),
					'shadow' 	=> __( 'Shadow Line', 'theme-blvd-shortcodes' ),
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
				'desc' 		=> __( '<p>Icon to be applied to each list item. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.</p><p><em>Note: Do not prefix icon ID with "fa-"</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon',
				'std' 		=> 'caret-right',
				'type' 		=> 'text',
			),
			'color' => array(
				'name' 		=> __( 'Icon Color (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'A color for the icons - Ex: #666666', 'theme-blvd-shortcodes' ),
				'id' 		=> 'color',
				'std' 		=> '',
				'type' 		=> 'text',
			),
		);

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
				'desc' 		=> __( '<p>Icon before text of button to popup. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.</p><p><em>Note: Do not prefix icon ID with "fa-"</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon_before',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'icon_after' => array(
				'name' 		=> __( 'Icon After Button Text (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>Icon after text of button to popup. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.</p><p><em>Note: Do not prefix icon ID with "fa-"</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon_after',
				'std' 		=> '',
				'type' 		=> 'text',
			),
		);

		// Progress Bar.
		$options['progress_bar'] = array(
			'percent' => array(
				'name' 		=> __( 'Bar Percent', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'A percentage of how far the bar is – 25, 50, 80, etc.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'percent',
				'std' 		=> '100',
				'type' 		=> 'text',
			),
			'color' => array(
				'name' 		=> __( 'Bar Color', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Color of the bar.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'color',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'default' 	=> __( 'Default (blue)', 'theme-blvd-shortcodes' ),
					'info' 		=> __( 'Info (lighter blue)', 'theme-blvd-shortcodes' ),
					'success' 	=> __( 'Success (green)', 'theme-blvd-shortcodes' ),
					'danger' 	=> __( 'Danger (red)', 'theme-blvd-shortcodes' ),
					'warning' 	=> __( 'Warning (yellow)', 'theme-blvd-shortcodes' ),
				),
			),
			'striped' => array(
				'name' 		=> __( 'Striped', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether the bar has the striped effect or not.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'striped',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'animated' => array(
				'name' 		=> __( 'Animated', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether the bar has the animated effect or not. Note that this does not work in IE8 or IE9.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'animated',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
		);

		// Quote.
		$options['blockquote'] = array(
			'quote' => array(
				'name' 		=> __( 'Quote Text', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The main text of the quote. You can not use HTML here.', 'theme-blvd-shortcodes' ),
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

		/**
		 * Display Posts
		 */

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
				'desc' 		=> __( 'Number of rows in the grid of posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'rows',
				'std' 		=> '3',
				'type' 		=> 'text',
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> 'date',
				'type' 		=> 'select',
				'options' 	=> array(
					'date' 			=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> 'DESC',
				'type' 		=> 'select',
				'options' 	=> array(
					'DESC' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
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
			'crop' => array(
				'name' 		=> __( 'Featured Image Crop Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'You can manually enter a featured image crop size to force on the featured images of the post grid, if you wish.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'crop',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text',
			),
		);

		// Post List.
		$options['post_list'] = array(
			'thumbs' => array(
				'name' 		=> __( 'Thumbnail Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'This determines the size of the featured images. If left to default, it will take the general setting from your Theme Options page.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'thumbs',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'default' 	=> __( 'Default', 'theme-blvd-shortcodes' ),
					'small' 	=> __( 'Small', 'theme-blvd-shortcodes' ),
					'full' 		=> __( 'Full Width', 'theme-blvd-shortcodes' ),
					'hide' 		=> __( 'Hide Thumbnails', 'theme-blvd-shortcodes' ),
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
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'theme-blvd-shortcodes' ),
				'id' 		=> 'portfolio',
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
				'std' 		=> 'date',
				'type' 		=> 'select',
				'options' 	=> array(
					'date' 			=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> 'DESC',
				'type' 		=> 'select',
				'options' 	=> array(
					'DESC' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
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
				'std' 		=> 'date',
				'type' 		=> 'select',
				'options' 	=> array(
					'date' 			=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> 'DESC',
				'type' 		=> 'select',
				'options' 	=> array(
					'DESC' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
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

		// Mini Post List.
		$options['mini_post_list'] = array(
			'thumb' => array(
				'name' 		=> __( 'Thumbnail Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Size of the featured images for the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'thumb',
				'std' 		=> 'smaller',
				'type' 		=> 'select',
				'options' 	=> array(
					'hide' 		=> __( 'Hide', 'theme-blvd-shortcodes' ),
					'small' 	=> __( 'Small', 'theme-blvd-shortcodes' ),
					'smaller' 	=> __( 'Smaller', 'theme-blvd-shortcodes' ),
					'smallest' 	=> __( 'Smallest', 'theme-blvd-shortcodes' ),
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
				'std' 		=> 'date',
				'type' 		=> 'select',
				'options' 	=> array(
					'date' 			=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> 'DESC',
				'type' 		=> 'select',
				'options' 	=> array(
					'DESC' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
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
		);

		/**
		 * Image Icons
		 */

		$options['icon'] = array(
			'image' => array(
				'name' 		=> __( 'Icon', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select an icon. For adding icons, you can create a folder in your child theme called "icons" -- Anything placed in that directory will show here after the 24-hour cache period is over.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'image',
				'std' 		=> 'accepted',
				'type' 		=> 'images',
				'options' 	=> $this->generator->image_icons,
				'img_width'	=> '24', // 1/2 of images' natural widths.
			),
			'align' => array(
				'name' 		=> __( 'Icon Alignment', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How you\'d like to align the icon.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'align',
				'std' 		=> 'left',
				'type' 		=> 'select',
				'options' 	=> array(
					'left' 		=> __( 'Left', 'theme-blvd-shortcodes' ),
					'right' 	=> __( 'Right', 'theme-blvd-shortcodes' ),
					'center' 	=> __( 'Center', 'theme-blvd-shortcodes' ),
					'none' 		=> __( 'None', 'theme-blvd-shortcodes' ),
				),
			),
			'width' => array(
				'name' 		=> __( 'Icon Width', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Display width of the icon -- 48, 24, etc.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'width',
				'std' 		=> '48',
				'type' 		=> 'text',
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
				'desc' 		=> __( '<p>Content to be highlighted.</p><p><em>Note: The content can be further edited from your WordPress editor after being inserted.</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'sc_content',
				'std' 		=> 'This text will be highlighted.',
				'type' 		=> 'textarea',
			),
		);

		// Icon Link.
		$options['icon_link'] = array(
			'icon' => array(
				'name' 		=> __( 'Link Icon', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( '<p>Enter an icon name. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.</p><p><em>Note: Do not prefix icon ID with "fa-"</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon',
				'std' 		=> 'link',
				'type' 		=> 'text',
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
				'type' 		=> 'text',
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
				'desc' 		=> __( '<p>Enter an icon name to appear at the start of the label. This can be any <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome vector icon ID</a>.</p><p><em>Note: Do not prefix icon ID with "fa-"</em></p>', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon',
				'std' 		=> '',
				'type' 		=> 'text',
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
		 * Sliders
		 */

		// Custom Slider.
		$options['slider'] = array(
			'id' => array(
				'name' 		=> __( 'Slider ID', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Select from your your custom-built sliders, using the <a href="http://wordpress.org/plugins/theme-blvd-sliders/" target="_blank">Theme Blvd Sliders plugin</a>.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'id',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> $this->generator->sliders,
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
			'size' => array(
				'name' 		=> __( 'Image Size (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Crop size for images, defaults to displaying raw image sizes.<br />Ex: slider-large', 'theme-blvd-shortcodes' ),
				'id' 		=> 'size',
				'std' 		=> '',
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
					'square_small' 		=> __( 'Small', 'theme-blvd-shortcodes' ),
					'square_smaller' 	=> __( 'Smaller', 'theme-blvd-shortcodes' ),
					'square_smallest' 	=> __( 'Smallest', 'theme-blvd-shortcodes' ),
				),
				'class'		=> 'receiver receiver-true',
			),
			'subgroup_end' => array(
		    	'type'		=> 'subgroup_end',
		    ),
		);

		// Post Slider.
		$options['post_slider'] = array(
			'fx' => array(
				'name' 		=> __( 'Slider Transition', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The transition effect of the slider.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'fx',
				'std' 		=> 'slide',
				'type' 		=> 'select',
				'options' 	=> array(
					'fade' 		=> __( 'Fade', 'theme-blvd-shortcodes' ),
					'slide' 	=> __( 'Slide', 'theme-blvd-shortcodes' ),
				),
			),
			'timeout' => array(
				'name' 		=> __( 'Slider Speed', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Seconds in between transitions, 0 for no auto-advancing.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'timeout',
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
			'pause_play' => array(
				'name' 		=> __( 'Pause/Play Button', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to show pause/play button for slider\'s rotation', 'theme-blvd-shortcodes' ),
				'id' 		=> 'pause_play',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'pause_on_hover' => array(
				'name' 		=> __( 'Pause on Hover', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to pause slider rotation on mouse hover.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'pause_on_hover',
				'std' 		=> 'disable',
				'type' 		=> 'select',
				'options' 	=> array(
					'disable' 		=> __( 'No pause on hover', 'theme-blvd-shortcodes' ),
					'pause_on' 		=> __( 'Pause on hover only', 'theme-blvd-shortcodes' ),
					'pause_on_off' 	=> __( 'Pause on hover, resume on hover off', 'theme-blvd-shortcodes' ),
				),
			),
			'image' => array(
				'name' 		=> __( 'Image Display', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to display featured images from the posts to be used in the slider.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'image',
				'std' 		=> 'full',
				'type' 		=> 'select',
				'options' 	=> array(
					'full' 			=> __( 'Full Width', 'theme-blvd-shortcodes' ),
					'align-right' 	=> __( 'Aligned Right', 'theme-blvd-shortcodes' ),
					'align-left' 	=> __( 'Aligned Left', 'theme-blvd-shortcodes' ),
				),
			),
			'image_size' => array(
				'name' 		=> __( 'Image Crop Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Crop size for featured image used as each slide.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'image_size',
				'std' 		=> 'slider-large',
				'type' 		=> 'text',
			),
			'image_link' => array(
				'name' 		=> __( 'Image Link', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How each image of the slider links.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'image_link',
				'std' 		=> 'permalink',
				'type' 		=> 'select',
				'options' 	=> array(
					'0' 		=> __( 'No link', 'theme-blvd-shortcodes' ),
					'permalink' => __( 'Link to post', 'theme-blvd-shortcodes' ),
					'lightbox' 	=> __( 'Link to enlarged image in lightbox', 'theme-blvd-shortcodes' ),
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
				'std' 		=> 'date',
				'type' 		=> 'select',
				'options' 	=> array(
					'date' 			=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> 'DESC',
				'type' 		=> 'select',
				'options' 	=> array(
					'DESC' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
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
			'mobile_fallback' => array(
				'name' 		=> __( 'Mobile Fallback', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to display on mobile.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'mobile_fallback',
				'std' 		=> 'full_list',
				'type' 		=> 'select',
				'options' 	=> array(
					'full_list' 	=> __( 'List out slides', 'theme-blvd-shortcodes' ),
					'first_slide' 	=> __( 'Display first slide', 'theme-blvd-shortcodes' ),
					'display' 		=> __( 'Attempt to display full slider', 'theme-blvd-shortcodes' ),
				),
			),
		);

		// Post Slider.
		$options['post_grid_slider'] = array(
			'fx' => array(
				'name' 		=> __( 'Slider Transition', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The transition effect of the slider.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'fx',
				'std' 		=> 'slide',
				'type' 		=> 'select',
				'options' 	=> array(
					'fade' 		=> __( 'Fade', 'theme-blvd-shortcodes' ),
					'slide' 	=> __( 'Slide', 'theme-blvd-shortcodes' ),
				),
			),
			'timeout' => array(
				'name' 		=> __( 'Slider Speed', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Seconds in between transitions, 0 for no auto-advancing.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'timeout',
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
			'pause_play' => array(
				'name' 		=> __( 'Pause/Play Button', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to show pause/play button for slider\'s rotation', 'theme-blvd-shortcodes' ),
				'id' 		=> 'pause_play',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
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
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'theme-blvd-shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'columns' => array(
				'name' 		=> __( 'Columns', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Number of posts per row in each slide.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'columns',
				'std' 		=> '3',
				'type' 		=> 'text',
			),
			'rows' => array(
				'name' 		=> __( 'Rows', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Number of rows in each slide.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'rows',
				'std' 		=> '3',
				'type' 		=> 'text',
			),
			'numberposts' => array(
				'name' 		=> __( 'Total Number of Posts', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The total number of posts to display for the slider. Use -1 for no limit, in order to pull all posts queried.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'numberposts',
				'std' 		=> '-1',
				'type' 		=> 'text',
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> 'date',
				'type' 		=> 'select',
				'options' 	=> array(
					'date' 			=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> 'DESC',
				'type' 		=> 'select',
				'options' 	=> array(
					'DESC' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
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
		);

		// Post Slider.
		$options['post_list_slider'] = array(
			'fx' => array(
				'name' 		=> __( 'Slider Transition', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The transition effect of the slider.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'fx',
				'std' 		=> 'slide',
				'type' 		=> 'select',
				'options' 	=> array(
					'fade' 		=> __( 'Fade', 'theme-blvd-shortcodes' ),
					'slide' 	=> __( 'Slide', 'theme-blvd-shortcodes' ),
				),
			),
			'timeout' => array(
				'name' 		=> __( 'Slider Speed', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Seconds in between transitions, 0 for no auto-advancing.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'timeout',
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
			'pause_play' => array(
				'name' 		=> __( 'Pause/Play Button', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Whether to show pause/play button for slider\'s rotation', 'theme-blvd-shortcodes' ),
				'id' 		=> 'pause_play',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __( 'True', 'theme-blvd-shortcodes' ),
					'false' 	=> __( 'False', 'theme-blvd-shortcodes' ),
				),
			),
			'thumbs' => array(
				'name' 		=> __( 'Thumbnail Size', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'This determines the size of the featured images. If left to default, it will take the general setting from your Theme Options page.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'thumbs',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'default' 	=> __( 'Default', 'theme-blvd-shortcodes' ),
					'small' 	=> __( 'Small', 'theme-blvd-shortcodes' ),
					'full' 		=> __( 'Full Width', 'theme-blvd-shortcodes' ),
					'hide' 		=> __( 'Hide Thumbnails', 'theme-blvd-shortcodes' ),
				),
			),
			'post_content' => array(
				'name' 		=> __( 'Post Content', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How the content of posts display. If left to default, it will take the general setting from your Theme Options page.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'post_content',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'default' 	=> __( 'Default', 'theme-blvd-shortcodes' ),
					'content' 	=> __( 'Full Content', 'theme-blvd-shortcodes' ),
					'excerpt' 	=> __( 'Excerpts', 'theme-blvd-shortcodes' ),
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
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'theme-blvd-shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'posts_per_slide' => array(
				'name' 		=> __( 'Number of Posts Per Slide', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The number of posts to display for each slide of the slider.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'posts_per_slide',
				'std' 		=> '3',
				'type' 		=> 'text',
			),
			'numberposts' => array(
				'name' 		=> __( 'Total Number of Posts', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'The total number of posts to display for the slider. Use -1 for no limit, in order to pull all posts queried.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'numberposts',
				'std' 		=> '-1',
				'type' 		=> 'text',
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> 'date',
				'type' 		=> 'select',
				'options' 	=> array(
					'date' 			=> __( 'Date', 'theme-blvd-shortcodes' ),
					'title' 		=> __( 'Title', 'theme-blvd-shortcodes' ),
					'comment_count' => __( 'Number of Comments', 'theme-blvd-shortcodes' ),
					'rand' 			=> __( 'Random', 'theme-blvd-shortcodes' ),
				),
			),
			'order' => array(
				'name' 		=> __( 'Order', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> 'DESC',
				'type' 		=> 'select',
				'options' 	=> array(
					'DESC' 		=> __( 'Descending', 'theme-blvd-shortcodes' ),
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
				'desc' 		=> __( 'Enter an icon name.', 'theme-blvd-shortcodes' ),
				'id' 		=> 'icon',
				'std' 		=> '',
				'type' 		=> 'text',
			),
			'color' => array(
				'name' 		=> __( 'Icon Color (optional)', 'theme-blvd-shortcodes' ),
				'desc' 		=> __( 'Enter a color for the icon - Ex: #666666', 'theme-blvd-shortcodes' ),
				'id' 		=> 'color',
				'std' 		=> '',
				'type' 		=> 'text',
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
		 * Filter array of all options for all shortcodes
		 * in legacy generator.
		 *
		 * @since 1.6.0
		 *
		 * @var array
		 */
		$options = apply_filters( 'themeblvd_shortcodes_options_legacy', $options );

		/**
		 * Filter array of options for a specific type
		 * of shortcode element in legacy generator.
		 *
		 * @since 1.6.0
		 *
		 * @var array
		 */
		return apply_filters( "themeblvd_shortcodes_options_{$type}_legacy", $options[ $type ] );

	}

}
