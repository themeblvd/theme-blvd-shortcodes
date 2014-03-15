/**
 * Optional arguments
 * - title: Title of unit
 * - text_align: How to align text - left, right, center
 * - align: How to align jumbotron - left, right
 * - max_width: Meant to be used with align left/right - 300px, 50%, etc
 * - class: Any additional CSS classes
 * - wpautop: Whether to apply wpautop on content
 */
themeblvdShortcodeAtts={
	attributes:[
		{
			label:"Title Text",
			id:"title",
			help:"Enter the text for the title."
		},
		{
			label:"Text Alignment",
			id:"text_align",
			help:"Select how you\'d like text aligned within the unit.",
			controlType:"select-control",
			selectValues:['left', 'right', 'center']
		},
		{
			label:"Unit Alignment",
			id:"align",
			help:"Select how you\'d like the entire unit aligned. Leave blank for no alignment.",
			controlType:"select-control",
			selectValues:['', 'left', 'right', 'center']
		},
		{
			label:"Unit Maximum Width",
			id:"max_width",
			help:"If you've aligned the entire unit to the left, right or center, it can be helpful to also give the unit a maximum width. Ex: 300px, 50%, etc.",
		}
	],
	defaultContent:"<br>Content for your jumbotron unit goes here...<br>",
	shortcode:"jumbotron"
};