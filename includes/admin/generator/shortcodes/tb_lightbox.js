/**
 * Required arguments
 * - link: URL being linked to in the lightbox popup
 * - thumb: Text or Image URL being used for link to lightbox
 *
 * Optional arguments
 * - width: Width of tumbnail image linking to lighbox
 * - title: Title displayed in lightbox link
 * - align: Alignment of thumbnail image
 * - frame: Whether or not to display frame around thumbnail
 * - icon: Icon for thumbnail if in frame - video or image
 */
themeblvdShortcodeAtts={
	attributes:[
		{
			label:"Lightbox Link",
			id:"link",
			help:"Enter the URL of what to display in the lightbox.<br />Ex: http://vimeo.com/123456<br />Ex: http://youtube.com/?watch=123456<br />Ex: http://yoursite.com/uploads/image.jpg"
		},
		{
			label:"Lightbox Title (optional)",
			id:"title",
			help:"Enter a title to display in the lightbox popup."
		},
		{
			label:"Thumbnail",
			id:"thumb",
			help:"Enter the URL to a thumbnail image.<br />Ex: http://yoursite.com/uploads/thumb.jpg"
		},
		{
			label:"Thumbnail Width (optional)",
			id:"width",
			help:"Enter the width of the thumbnail image."
		},
		{
			label:"Thumbnail Alignment",
			id:"align",
			controlType:"select-control", 
			selectValues:['none', 'left', 'right', 'center']
		},
		{
			label:"Thumbnail Frame",
			id:"frame",
			controlType:"select-control", 
			selectValues:['true', 'false']
		},
		{
			label:"Thumbnail Alignment",
			id:"align",
			controlType:"select-control", 
			selectValues:['none', 'left', 'right', 'center']
		},
		{
			label:"Thumbnail Icon",
			id:"icon",
			help:"This is only relevant if you've enabled the frame around the thumbnail image.",
			controlType:"select-control", 
			selectValues:['image', 'video']
		}
	],
	defaultContent:"",
	shortcode:"lightbox"
};