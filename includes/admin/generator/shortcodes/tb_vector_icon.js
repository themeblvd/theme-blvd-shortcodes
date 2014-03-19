/**
 * Required arguments
 * - icon: Icon code to display before text
 *
 * Optinal arguments
 * - size: A font-size declaration. Ex: 20px
 */
themeblvdShortcodeAtts={
	attributes:[
		{
			label:"Icon",
			id:"icon",
			help:"Enter an ID of a supported icon. <a href=\"http://fortawesome.github.io/Font-Awesome/icons/\" target=\"_blank\">See Icons<a/>.<br />Note: Do not prefix icon ID with \"fa-\"."
		},
		{
			label:"Size (optional)",
			id:"size",
			help:"Enter in a size. Since these icons are web fonts,<br />they adhere to standard font-sizes. Ex: 20px, 2em, etc."
		},
		{
			label:"Icon Color (optional)",
			id:"color",
			help:"Color of the icon – Ex: #660000"
		},
		{
			label:"Icon Rotation (optional)",
			id:"rotate",
			controlType:"select-control",
			selectValues:['', '90', '180', '270']
		},
		{
			label:"Icon Flip (optional)",
			id:"flip",
			controlType:"select-control",
			selectValues:['', 'vertical', 'horizontal']
		}
	],
	defaultContent:"",
	shortcode:"vector_icon"
};
