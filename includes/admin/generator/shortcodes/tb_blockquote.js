/**
 * Required arguments
 *  - quote: The quote text

 * Optional arguments
 *  - source: Source of the quote
 *  - source_link: A URL to link the source to. Ex: http://google.com
 *  - align: How to align quote, defaults to no alignment. Use left, right, or leave blank.
 *  - max_width: Set a maximum width for the quote, to be used with align left or right. Ex: 300px, 50%, etc.
 *  - class: Any additional CSS classes you want to add to the blockquote.
 */
themeblvdShortcodeAtts={
	attributes:[
		{
			label:"Quote Text",
			id:"quote",
			help:"Enter the text for the quote.",
			controlType:"textarea-control"
		},
		{
			label:"Quote Source",
			id:"source",
			help:"Enter the source of the quote."
		},
		{
			label:"Quote Source Link",
			id:"source_link",
			help:"If you'd like the source to link somewhere enter a URL. Ex: http://google.com"
		},
		{
			label:"Quote Alignment",
			id:"align",
			help:"Select how you'd like to align the quote.",
			controlType:"select-control",
			selectValues:['none', 'left', 'right']
		},
		{
			label:"Quote Max Width",
			id:"max_width",
			help:"Enter a max width for the quote. This works well when combined with aligning the quote to the right or left. Ex: 300px, 50%, etc.",
		}
	],
	defaultContent:"",
	shortcode:"blockquote"
};