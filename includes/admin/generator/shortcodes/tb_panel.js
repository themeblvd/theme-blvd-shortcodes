/**
 * Optional arguments
 *  - style: Color of bar - default, primary, success, info, warning, danger
 *  - title: Optional text for header title
 *  - footer: Optional text for the footer
 *  - text_align: How to align text – left, right, center.
 *  - class: Any additional CSS classes.
 */
themeblvdShortcodeAtts={
	attributes:[
		{
			label:"Style",
			id:"style",
			help:"Select the style of the panel unit.",
			controlType:"select-control",
			selectValues:['default', 'primary', 'success', 'info', 'warning', 'danger']
		},
		{
			label:"Header Text (optional)",
			id:"title",
			help:"Enter the text to appear in the header of the panel unit."
		},
		{
			label:"Footer Text (optional)",
			id:"title",
			help:"Enter the text to appear in the footer of the panel unit."
		},
		{
			label:"Text Alignment",
			id:"text_align",
			help:"Select how you'd like the text aligned in the panel unit.",
			controlType:"select-control",
			selectValues:['left', 'right', 'center']
		}
	],
	defaultContent:"Your panel content here ...",
	shortcode:"panel"
};