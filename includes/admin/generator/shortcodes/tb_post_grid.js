/**
 * Optional arguments
 * - categories: Categories to include, category slugs separated by commas (no spaces!), or blank for all categories
 * - columns: Number of posts per row
 * - rows: Number of rows
 * - orderby: date, title, comment_count, rand
 * - order: DESC, ASC
 * - offset: Number of posts to offset off the start, defaults to 0
 * - query: Custom query string
 * - link: Show link after posts, true or false
 * - link_text: Text for the link
 * - link_url: URL where link should go
 * - link_target: Where link opens - _self, _blank
 */
themeblvdShortcodeAtts={
	attributes:[
		{
			label:"Columns",
			id:"columns",
			value:"3",
			help:"Enter in the number of posts per row you'd like in the grid."
		},
		{
			label:"Rows",
			id:"rows",
			value:"3",
			help:"Enter in the number of rows you'd like in the grid."
		},
		{
			label:"Categories",
			id:"category_name",
			help:"List any category slugs you want to include separated by commas."
		},
		{
			label:"Tags",
			id:"tag",
			help:"List any tags you want to include separated by commas."
		},
		{
			label:"Order by",
			id:"orderby",
			help:"What to order the posts displayed by.", 
			controlType:"select-control", 
			selectValues:['date', 'title', 'comment_count', 'rand']
		},
		{
			label:"Order",
			id:"order",
			help:"How to order the posts displayed.", 
			controlType:"select-control", 
			selectValues:['DESC', 'ASC']
		},
		{
			label:"Offset",
			id:"offset",
			value:"0",
			help:"Number of posts to offset off the start, defaults to 0"
		},
		{
			label:"Custom Query",
			id:"query",
			value:"",
			help:"Enter a custom WP query string. This is will override numberposts, orderby, order, and offset, setup previously."
		}
	],
	defaultContent:"",
	shortcode:"post_grid"
};