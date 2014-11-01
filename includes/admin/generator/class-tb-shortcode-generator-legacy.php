<?php
/**
 * Shortcode generator legacy compat.
 */
class Theme_Blvd_Shortcode_Generator_Legacy {

	/**
	 * Constructor.
	 *
	 * @since 1.5.0
	 */
	public function __construct($generator) {
		// Reference for standard generator object
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
					'blockquote'		=> __('Quote', 'themeblvd_shortcodes')
				)
			),
			array(
				'id'	=> 'display_posts',
				'name'	=> __( 'Display Posts', 'themeblvd_shortcodes' ),
				'sub'	=> array(
					'post_grid'			=> __('Post Grid', 'themeblvd_shortcodes'),
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
				'id'	=> 'sliders',
				'name'	=> __( 'Sliders', 'themeblvd_shortcodes' ),
				'sub'	=> array(
					'slider'			=> __('Custom Slider', 'themeblvd_shortcodes'),
					'gallery_slider'	=> __('Gallery Slider', 'themeblvd_shortcodes'),
					'post_slider'		=> __('Post Slider', 'themeblvd_shortcodes'),
					'post_grid_slider'	=> __('Post Grid Slider', 'themeblvd_shortcodes'),
					'post_list_slider'	=> __('Post List Slider', 'themeblvd_shortcodes')
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

		return apply_filters( 'themeblvd_shortcodes_groups_legacy', $groups );
	}

	/**
	 * Get options for shortcodes
	 *
	 * @since 1.5.0
	 */
	public function get_options( $type ) {

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
				'desc'		=> __( 'Choose the number of columns along with the corresponding width configurations. This will give you a starting point for columns arrangement you can insert into your page or post.', 'themeblvd_shortcodes' ),
				'type'		=> 'columns',
				'std'		=> array(
		           'num' => '3',
		            'width' => array(
	                    '1' => 'grid_12',
	                    '2' => 'grid_6-grid_6',
	                    '3' => 'grid_4-grid_4-grid_4',
	                    '4' => 'grid_3-grid_3-grid_3-grid_3',
	                    '5' => 'grid_fifth_1-grid_fifth_1-grid_fifth_1-grid_fifth_1-grid_fifth_1'
	                )
				),
				'options'	=> 'element'
			),
			/*
			'col_1' => array(
				'id' 		=> 'col_1',
				'name'		=> __( 'Column #1', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'Configure the content for the first column.', 'themeblvd_shortcodes' ),
				'std'		=> 'Column #1...',
				'type'		=> 'textarea',
				'class'		=> 'col_1 section-content'
			),
			'col_2' => array(
				'id' 		=> 'col_2',
				'name'		=> __( 'Column #2', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'Configure the content for the second column.', 'themeblvd_shortcodes' ),
				'std'		=> 'Column #2...',
				'type'		=> 'textarea',
				'class'		=> 'col_2 section-content'
			),
			'col_3' => array(
				'id' 		=> 'col_3',
				'name'		=> __( 'Column #3', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'Configure the content for the third column.', 'themeblvd_shortcodes' ),
				'std'		=> 'Column #3...',
				'type'		=> 'textarea',
				'class'		=> 'col_3 section-content'
			),
			'col_4' => array(
				'id' 		=> 'col_4',
				'name'		=> __( 'Column #4', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'Configure the content for the fourth column.', 'themeblvd_shortcodes' ),
				'std'		=> 'Column #4...',
				'type'		=> 'textarea',
				'class'		=> 'col_4 section-content'
			),
			'col_5' => array(
				'id' 		=> 'col_5',
				'name'		=> __( 'Column #5', 'themeblvd_shortcodes' ),
				'desc'		=> __( 'Configure the content for the fifth column.', 'themeblvd_shortcodes' ),
				'std'		=> 'Column #5...',
				'type'		=> 'textarea',
				'class'		=> 'col_5 section-content'
			),
			*/
			'subgroup_end' => array(
		    	'type'		=> 'subgroup_end'
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
				'options' 	=> array(
					'solid' 	=> __('Solid Line', 'themeblvd_shortcodes'),
					'dashed' 	=> __('Dashed Line', 'themeblvd_shortcodes'),
					'shadow' 	=> __('Shadow Line', 'themeblvd_shortcodes')
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
				'type' 		=> 'text'
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

		// Progress Bar
		$options['progress_bar'] = array(
			'percent' => array(
				'name' 		=> __( 'Bar Percent', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'A percentage of how far the bar is – 25, 50, 80, etc.', 'themeblvd_shortcodes' ),
				'id' 		=> 'percent',
				'std' 		=> '100',
				'type' 		=> 'text'
			),
			'color' => array(
				'name' 		=> __( 'Bar Color', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Color of the bar.', 'themeblvd_shortcodes' ),
				'id' 		=> 'color',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'default' 	=> __('Default (blue)', 'themeblvd_shortcodes'),
					'info' 		=> __('Info (lighter blue)', 'themeblvd_shortcodes'),
					'success' 	=> __('Success (green)', 'themeblvd_shortcodes'),
					'danger' 	=> __('Danger (red)', 'themeblvd_shortcodes'),
					'warning' 	=> __('Warning (yellow)', 'themeblvd_shortcodes')
				)
			),
			'striped' => array(
				'name' 		=> __( 'Striped', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether the bar has the striped effect or not.', 'themeblvd_shortcodes' ),
				'id' 		=> 'striped',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'animated' => array(
				'name' 		=> __( 'Animated', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether the bar has the animated effect or not. Note that this does not work in IE8 or IE9.', 'themeblvd_shortcodes' ),
				'id' 		=> 'animated',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			)
		);

		// Quote
		$options['blockquote'] = array(
			'quote' => array(
				'name' 		=> __( 'Quote Text', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The main text of the quote. You can not use HTML here.', 'themeblvd_shortcodes' ),
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

		/*--------------------------------------------*/
		/* Display Posts
		/*--------------------------------------------*/

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
				'desc' 		=> __( 'Number of rows in the grid of posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'rows',
				'std' 		=> '3',
				'type' 		=> 'text'
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'themeblvd_shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> 'date',
				'type' 		=> 'select',
				'options' 	=> array(
					'date' 			=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> 'DESC',
				'type' 		=> 'select',
				'options' 	=> array(
					'DESC' 		=> __('Descending', 'themeblvd_shortcodes'),
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
			'crop' => array(
				'name' 		=> __( 'Featured Image Crop Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'You can manually enter a featured image crop size to force on the featured images of the post grid, if you wish.', 'themeblvd_shortcodes' ),
				'id' 		=> 'crop',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'query' => array(
				'name' 		=> __( 'Custom Query', 'themeblvd_shortcodes' ),
				'desc' 		=> __( '<p>Custom query string to include posts.<br />Ex: foo=bar&foo2=bar2</p><p><em>Note: This is for advanced users and will override all other query-related options above.</em></p>', 'themeblvd_shortcodes' ),
				'id' 		=> 'query',
				'std' 		=> '',
				'type' 		=> 'text'
			)
		);

		// Post List
		$options['post_list'] = array(
			'thumbs' => array(
				'name' 		=> __( 'Thumbnail Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'This determines the size of the featured images. If left to default, it will take the general setting from your Theme Options page.', 'themeblvd_shortcodes' ),
				'id' 		=> 'thumbs',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'default' 	=> __('Default', 'themeblvd_shortcodes'),
					'small' 	=> __('Small', 'themeblvd_shortcodes'),
					'full' 		=> __('Full Width', 'themeblvd_shortcodes'),
					'hide' 		=> __('Hide Thumbnails', 'themeblvd_shortcodes')
				)
			),
			'post_content' => array(
				'name' 		=> __( 'Post Content', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How the content of posts display. If left to default, it will take the general setting from your Theme Options page.', 'themeblvd_shortcodes' ),
				'id' 		=> 'post_content',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'default' 	=> __('Default', 'themeblvd_shortcodes'),
					'content' 	=> __('Full Content', 'themeblvd_shortcodes'),
					'excerpt' 	=> __('Excerpts', 'themeblvd_shortcodes')
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
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'themeblvd_shortcodes' ),
				'id' 		=> 'portfolio',
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
				'std' 		=> 'date',
				'type' 		=> 'select',
				'options' 	=> array(
					'date' 			=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> 'DESC',
				'type' 		=> 'select',
				'options' 	=> array(
					'DESC' 		=> __('Descending', 'themeblvd_shortcodes'),
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
				'std' 		=> 'date',
				'type' 		=> 'select',
				'options' 	=> array(
					'date' 			=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> 'DESC',
				'type' 		=> 'select',
				'options' 	=> array(
					'DESC' 		=> __('Descending', 'themeblvd_shortcodes'),
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
					'small' 	=> __('Small', 'themeblvd_shortcodes'),
					'smaller' 	=> __('Smaller', 'themeblvd_shortcodes'),
					'smallest' 	=> __('Smallest', 'themeblvd_shortcodes')
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
				'std' 		=> 'date',
				'type' 		=> 'select',
				'options' 	=> array(
					'date' 			=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> 'DESC',
				'type' 		=> 'select',
				'options' 	=> array(
					'DESC' 		=> __('Descending', 'themeblvd_shortcodes'),
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
				'options' 	=> $this->generator->image_icons,
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
				'desc' 		=> __( '<p>Content to be highlighted.</p><p><em>Note: The content can be further edited from your WordPress editor after being inserted.</em></p>', 'themeblvd_shortcodes' ),
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
				'options' 	=> $this->generator->sliders
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
			'size' => array(
				'name' 		=> __( 'Image Size (optional)', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Crop size for images, defaults to displaying raw image sizes.<br />Ex: slider-large', 'themeblvd_shortcodes' ),
				'id' 		=> 'size',
				'std' 		=> '',
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
					'square_small' 		=> __('Small', 'themeblvd_shortcodes'),
					'square_smaller' 	=> __('Smaller', 'themeblvd_shortcodes'),
					'square_smallest' 	=> __('Smallest', 'themeblvd_shortcodes')
				),
				'class'		=> 'receiver receiver-true'
			),
			'subgroup_end' => array(
		    	'type'		=> 'subgroup_end'
		    )
		);

		// Post Slider
		$options['post_slider'] = array(
			'fx' => array(
				'name' 		=> __( 'Slider Transition', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The transition effect of the slider.', 'themeblvd_shortcodes' ),
				'id' 		=> 'fx',
				'std' 		=> 'slide',
				'type' 		=> 'select',
				'options' 	=> array(
					'fade' 		=> __('Fade', 'themeblvd_shortcodes'),
					'slide' 	=> __('Slide', 'themeblvd_shortcodes')
				)
			),
			'timeout' => array(
				'name' 		=> __( 'Slider Speed', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Seconds in between transitions, 0 for no auto-advancing.', 'themeblvd_shortcodes' ),
				'id' 		=> 'timeout',
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
			'pause_play' => array(
				'name' 		=> __( 'Pause/Play Button', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to show pause/play button for slider\'s rotation', 'themeblvd_shortcodes' ),
				'id' 		=> 'pause_play',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'pause_on_hover' => array(
				'name' 		=> __( 'Pause on Hover', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to pause slider rotation on mouse hover.', 'themeblvd_shortcodes' ),
				'id' 		=> 'pause_on_hover',
				'std' 		=> 'disable',
				'type' 		=> 'select',
				'options' 	=> array(
					'disable' 		=> __('No pause on hover', 'themeblvd_shortcodes'),
					'pause_on' 		=> __('Pause on hover only', 'themeblvd_shortcodes'),
					'pause_on_off' 	=> __('Pause on hover, resume on hover off', 'themeblvd_shortcodes')
				)
			),
			'image' => array(
				'name' 		=> __( 'Image Display', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to display featured images from the posts to be used in the slider.', 'themeblvd_shortcodes' ),
				'id' 		=> 'image',
				'std' 		=> 'full',
				'type' 		=> 'select',
				'options' 	=> array(
					'full' 			=> __('Full Width', 'themeblvd_shortcodes'),
					'align-right' 	=> __('Aligned Right', 'themeblvd_shortcodes'),
					'align-left' 	=> __('Aligned Left', 'themeblvd_shortcodes')
				)
			),
			'image_size' => array(
				'name' 		=> __( 'Image Crop Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Crop size for featured image used as each slide.', 'themeblvd_shortcodes' ),
				'id' 		=> 'image_size',
				'std' 		=> 'slider-large',
				'type' 		=> 'text'
			),
			'image_link' => array(
				'name' 		=> __( 'Image Link', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How each image of the slider links.', 'themeblvd_shortcodes' ),
				'id' 		=> 'image_link',
				'std' 		=> 'permalink',
				'type' 		=> 'select',
				'options' 	=> array(
					'none' 		=> __('No link', 'themeblvd_shortcodes'),
					'permalink' => __('Link to post', 'themeblvd_shortcodes'),
					'lightbox' 	=> __('Link to enlarged image in lightbox', 'themeblvd_shortcodes')
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
				'std' 		=> 'date',
				'type' 		=> 'select',
				'options' 	=> array(
					'date' 			=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> 'DESC',
				'type' 		=> 'select',
				'options' 	=> array(
					'DESC' 		=> __('Descending', 'themeblvd_shortcodes'),
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
			'mobile_fallback' => array(
				'name' 		=> __( 'Mobile Fallback', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to display on mobile.', 'themeblvd_shortcodes' ),
				'id' 		=> 'mobile_fallback',
				'std' 		=> 'full_list',
				'type' 		=> 'select',
				'options' 	=> array(
					'full_list' 	=> __('List out slides', 'themeblvd_shortcodes'),
					'first_slide' 	=> __('Display first slide', 'themeblvd_shortcodes'),
					'display' 		=> __('Attempt to display full slider', 'themeblvd_shortcodes'),
				)
			)
		);

		// Post Slider
		$options['post_grid_slider'] = array(
			'fx' => array(
				'name' 		=> __( 'Slider Transition', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The transition effect of the slider.', 'themeblvd_shortcodes' ),
				'id' 		=> 'fx',
				'std' 		=> 'slide',
				'type' 		=> 'select',
				'options' 	=> array(
					'fade' 		=> __('Fade', 'themeblvd_shortcodes'),
					'slide' 	=> __('Slide', 'themeblvd_shortcodes')
				)
			),
			'timeout' => array(
				'name' 		=> __( 'Slider Speed', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Seconds in between transitions, 0 for no auto-advancing.', 'themeblvd_shortcodes' ),
				'id' 		=> 'timeout',
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
			'pause_play' => array(
				'name' 		=> __( 'Pause/Play Button', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to show pause/play button for slider\'s rotation', 'themeblvd_shortcodes' ),
				'id' 		=> 'pause_play',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
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
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'themeblvd_shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'columns' => array(
				'name' 		=> __( 'Columns', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Number of posts per row in each slide.', 'themeblvd_shortcodes' ),
				'id' 		=> 'columns',
				'std' 		=> '3',
				'type' 		=> 'text'
			),
			'rows' => array(
				'name' 		=> __( 'Rows', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Number of rows in each slide.', 'themeblvd_shortcodes' ),
				'id' 		=> 'rows',
				'std' 		=> '3',
				'type' 		=> 'text'
			),
			'numberposts' => array(
				'name' 		=> __( 'Total Number of Posts', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The total number of posts to display for the slider. Use -1 for no limit, in order to pull all posts queried.', 'themeblvd_shortcodes' ),
				'id' 		=> 'numberposts',
				'std' 		=> '-1',
				'type' 		=> 'text'
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'themeblvd_shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> 'date',
				'type' 		=> 'select',
				'options' 	=> array(
					'date' 			=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> 'DESC',
				'type' 		=> 'select',
				'options' 	=> array(
					'DESC' 		=> __('Descending', 'themeblvd_shortcodes'),
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
			)
		);

		// Post Slider
		$options['post_list_slider'] = array(
			'fx' => array(
				'name' 		=> __( 'Slider Transition', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The transition effect of the slider.', 'themeblvd_shortcodes' ),
				'id' 		=> 'fx',
				'std' 		=> 'slide',
				'type' 		=> 'select',
				'options' 	=> array(
					'fade' 		=> __('Fade', 'themeblvd_shortcodes'),
					'slide' 	=> __('Slide', 'themeblvd_shortcodes')
				)
			),
			'timeout' => array(
				'name' 		=> __( 'Slider Speed', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Seconds in between transitions, 0 for no auto-advancing.', 'themeblvd_shortcodes' ),
				'id' 		=> 'timeout',
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
			'pause_play' => array(
				'name' 		=> __( 'Pause/Play Button', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Whether to show pause/play button for slider\'s rotation', 'themeblvd_shortcodes' ),
				'id' 		=> 'pause_play',
				'std' 		=> 'true',
				'type' 		=> 'select',
				'options' 	=> array(
					'true' 		=> __('True', 'themeblvd_shortcodes'),
					'false' 	=> __('False', 'themeblvd_shortcodes')
				)
			),
			'thumbs' => array(
				'name' 		=> __( 'Thumbnail Size', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'This determines the size of the featured images. If left to default, it will take the general setting from your Theme Options page.', 'themeblvd_shortcodes' ),
				'id' 		=> 'thumbs',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'default' 	=> __('Default', 'themeblvd_shortcodes'),
					'small' 	=> __('Small', 'themeblvd_shortcodes'),
					'full' 		=> __('Full Width', 'themeblvd_shortcodes'),
					'hide' 		=> __('Hide Thumbnails', 'themeblvd_shortcodes')
				)
			),
			'post_content' => array(
				'name' 		=> __( 'Post Content', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How the content of posts display. If left to default, it will take the general setting from your Theme Options page.', 'themeblvd_shortcodes' ),
				'id' 		=> 'post_content',
				'std' 		=> 'default',
				'type' 		=> 'select',
				'options' 	=> array(
					'default' 	=> __('Default', 'themeblvd_shortcodes'),
					'content' 	=> __('Full Content', 'themeblvd_shortcodes'),
					'excerpt' 	=> __('Excerpts', 'themeblvd_shortcodes')
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
			'portfolio' => array(
				'name' 		=> __( 'Option 3: Posts By Portfolio', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'Portfolio to include posts from, requires <a href="http://wordpress.org/plugins/portfolios/" target="_blank">Portfolios plugin</a>.<br />Ex: my-portfolio', 'themeblvd_shortcodes' ),
				'id' 		=> 'portfolio',
				'std' 		=> '',
				'type' 		=> 'text'
			),
			'posts_per_slide' => array(
				'name' 		=> __( 'Number of Posts Per Slide', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The number of posts to display for each slide of the slider.', 'themeblvd_shortcodes' ),
				'id' 		=> 'posts_per_slide',
				'std' 		=> '3',
				'type' 		=> 'text'
			),
			'numberposts' => array(
				'name' 		=> __( 'Total Number of Posts', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'The total number of posts to display for the slider. Use -1 for no limit, in order to pull all posts queried.', 'themeblvd_shortcodes' ),
				'id' 		=> 'numberposts',
				'std' 		=> '-1',
				'type' 		=> 'text'
			),
			'orderby' => array(
				'name' 		=> __( 'Order By', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'What to order the posts by.', 'themeblvd_shortcodes' ),
				'id' 		=> 'orderby',
				'std' 		=> 'date',
				'type' 		=> 'select',
				'options' 	=> array(
					'date' 			=> __('Date', 'themeblvd_shortcodes'),
					'title' 		=> __('Title', 'themeblvd_shortcodes'),
					'comment_count' => __('Number of Comments', 'themeblvd_shortcodes'),
					'rand' 			=> __('Random', 'themeblvd_shortcodes')
				)
			),
			'order' => array(
				'name' 		=> __( 'Order', 'themeblvd_shortcodes' ),
				'desc' 		=> __( 'How to order the posts.', 'themeblvd_shortcodes' ),
				'id' 		=> 'order',
				'std' 		=> 'DESC',
				'type' 		=> 'select',
				'options' 	=> array(
					'DESC' 		=> __('Descending', 'themeblvd_shortcodes'),
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
				'type' 		=> 'text'
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

		return apply_filters( 'themeblvd_shortcodes_options_'.$type.'_type', $options[$type] );
	}

}