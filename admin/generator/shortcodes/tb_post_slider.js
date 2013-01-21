/**
 * Optional Arguments
 *  - fx: Transition of slider - fade, slide
 *  - timeout: Seconds in between transitions, 0 for no auto-advancing
 *  - nav_standard: Show standard nav dots to control slider - true or false
 *  - nav_arrows: Show directional arrows to control slider - true or false
 *  - pause_play: Show pause/play button - true or false
 *  - pause_on_hover: Pause on hover - pause_on, pause_on_off, disable
 *  - image: How to display featured images - full, align-right, align-left
 *  - image_link: Where image link goes - permalink, lightbox, none
 *  - button: Text for button to lead to permalink - leave empty to hide
 *  - tag: Tag to pull posts from
 *  - category: Category slug to pull posts from
 *  - numberposts: Number of posts/slides
 *  - orderby: Orderby param for posts query - date, title, comment_count, rand, etc.
 *  - order: Order param for posts query - DESC, ASC
 *  - query: Custom query string
 *  - mobile_fallback: How to display on mobile - full_list, first_slide, display
 */
themeblvdShortcodeAtts={
	attributes:[
		{
			label:"Transition Effect",
			id:"fx",
			help:"Select what effect you'd like used when each slide transitions to the next.", 
			controlType:"select-control", 
			selectValues:['fade', 'slide']
		},
		{
			label:"Timeout",
			id:"timeout",
			value:"3",
			help:"Input the number of seconds in between transitions. Use 0 for the slider to not auto-advance."
		},
		{
			label:"Standard Navigation",
			id:"nav_standard",
			help:"Show standard nav dots to control slider.", 
			controlType:"select-control", 
			selectValues:['true', 'false']
		},
		{
			label:"Navigation Arrows",
			id:"nav_arrows",
			help:"Show directional arrows to control slider.", 
			controlType:"select-control",
			selectValues:['true', 'false']
		},
		{
			label:"Pause/Play Button",
			id:"pause_play",
			help:"Show pause/play button.", 
			controlType:"select-control",
			selectValues:['true', 'false']
		},
		{
			label:"Pause on Hover Effect",
			id:"pause_on_hover",
			help:"How to enable the pause on hover effect for the slider. pause_on means the slider will pause when the user hovers over it, while pause_on_off means the slider will pause on hover AND start again when the user hovers off it.", 
			controlType:"select-control",
			selectValues:['pause_on', 'pause_on_off', 'disable']
		},
		{
			label:"Image Display",
			id:"image",
			help:"Select how you'd like the featured image of the post displayed in the slider.", 
			controlType:"select-control",
			selectValues:['full', 'align-right', 'align-left']
		},
		{
			label:"Image Link",
			id:"image_link",
			help:"Select where the image link goes.", 
			controlType:"select-control", 
			selectValues:['permalink', 'lightbox', 'none']
		},
		{
			label:"Button linking to post",
			id:"button",
			help:"If you'd like a button inserted on each slide that links to the cooresponding post, enter the text for the button. Ex: Read More"
		},
		{
			label:"Tag to pull posts from",
			id:"tag",
			help:"Enter a tag to pull posts from for the slider. Ex: my-tag"
		},
		{
			label:"Category to pull posts from",
			id:"category_name",
			help:"Enter a category slug to pull posts from for the slider. Ex: my-category"
		},
		{
			label:"Number of Posts",
			id:"numberposts",
			value:"5",
			help:"Total number of posts, -1 for all posts from the category or tag you're pulling from."
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
			label:"Custom Query",
			id:"query",
			value:"",
			help:"Enter a custom WP query string. This is will override numberposts, orderby, and order, setup previously."
		},
		{
			label:"Mobile Fallback",
			id:"fx",
			help:"Select how you'd like the slider to display on mobile devices. If you 'full_list', all slides will be listed out for the mobile user, while 'first_slide' will just display the first slide. The 'display' option will attempt display the full, animated slider to the mobile user; this isn't recommended.", 
			controlType:"select-control", 
			selectValues:['full_list', 'first_slide', 'display']
		}
	],
	defaultContent:"",
	shortcode:"post_slider"
};