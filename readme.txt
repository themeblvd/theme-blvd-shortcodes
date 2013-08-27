=== Theme Blvd Shortcodes ===
Author URI: http://www.jasonbobich.com
Contributors: themeblvd
Tags: shortcodes, bootstrap, Theme Blvd, themeblvd, Jason Bobich
Stable Tag: 1.1.2

This plugin works in conjuction with the Theme Blvd framework to create shortcodes for many of the framework's internal elements.

== Description ==

Within the Theme Blvd framework there are many internal elements and other 3rd party items like [Twitter Bootstrap](http://twitter.github.com/bootstrap/) integration to make use of.  When using a Theme Blvd theme, this plugin gives you an extensive pack of shortcodes to extend the framework's functionality to your pages, posts, and custom layouts via shortcodes.

After activating this plugin, you'll know it's ready to go by viewing the Edit Page or Edit Post screen and seeing the plugin's [shortcode generator](http://shortcodes.themeblvd.com/generator) within your Visual Editor. You'll then have access to the following shortcodes for use within your website.

= Alerts & Info Boxes =

These shortcodes provide you with a quick way to inform your readers of important information within a post or page.

[View Documentation and Examples](http://shortcodes.themeblvd.com/shortcodes/alerts/)

= Buttons =

Use Twitter Bootstrap's button styling along with tons of additional color options added by the Theme Blvd framework.

[View Documentation and Examples](hhttp://shortcodes.themeblvd.com/shortcodes/buttons/)

= Columns =

The column shortcodes allow you to structure your content into rows of various size columns within your pages and posts.

[View Documentation and Examples](http://shortcodes.themeblvd.com/shortcodes/columns/)

= Display Posts =

This group of shortcodes allow you to utilize the Theme Blvd framework's extensive system for displaying posts in both grid and list format.

[View Documentation and Examples](http://shortcodes.themeblvd.com/shortcodes/shortcodes-display-posts/)

= Image Icons =

An oldie, but a classic; use this shortcode to display any of the image icons bundled with the Theme Blvd framework.

[View Documentation and Examples](http://shortcodes.themeblvd.com/shortcodes/shortcodes-icons/)

= Inline Elements =

This group of shortcodes include some classic inline items like labels, icon links, text highlighting, the drop cap, and the newly added vector icon shortcode to take advantage of FontAwesome integration.

[View Documentation and Examples](http://shortcodes.themeblvd.com/shortcodes/inline-element/)

= Sliders =

When using the [Theme Blvd Sliders](http://wordpress.org/extend/plugins/theme-blvd-sliders/) plugin, you've already got access to the `[slider]` shortcode. However, in addition to that you'll also get a fancy post grid slider and post list slider.

[View Documentation and Examples](http://shortcodes.themeblvd.com/shortcodes/shortcodes-sliders/)

= Small Components =

Thanks to Twitter Bootstrap integration, this group of shortcodes adds some extra goodies for your website.

[View Documentation and Examples](http://shortcodes.themeblvd.com/shortcodes/small-components/)

= Tabs & Toggles =

The Theme Blvd shortcodes pack wouldn't be complete without the ability create slick jQuery content control via tabs and toggles.

[View Documentation and Examples](http://shortcodes.themeblvd.com/shortcodes/tabs/)

= Lightbox =

Theme Blvd themes already come with basic lightbox integration, and this plugin will give you a `[lightbox]` shortcode you can use to easily tap into this. You can also wrap a group of `[lightbox]` instances in a `[lightbox_gallery]` for them to be grouped into a gallery within the lightbox.

Additionally, there is a featured called "Auto Lightbox" which will automatically convert images inserted into pages and posts into the `[lightbox]` shortcode when they link to a lightbox-compatible URL. Note that you can disable this functionality from *Settings > Writing* in your WordPress admin.

[View Documentation and Examples](hhttp://shortcodes.themeblvd.com/shortcodes/lightbox/)

= Raw Shortcode =

Any content wrapped in the `[raw]` shortcode will allow you to escape any automatic WordPress formatting. Keep in mind that this is not a standard shortcode, and does modify the content outputted in your site. So, if you find that this conflicts with any other plugins you may be using, you can disable this functionality all together from *Settings > Writing* in your WordPress admin.

**NOTE: For this plugin to do anything, you must have a theme with Theme Blvd framework v2.2+ activated.**

== Installation ==

1. Upload `theme-blvd-shortcodes` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Shortcode Generator

== Changelog ==

= 1.1.2 =

* Another small fix to the `[post_slider]` parameters for shortcode generator.

= 1.1.1 =

* Fixed `[post_slider]` parameters for shortcode generator.

= 1.1.0 =

* Added compatibility for [Portfolios](http://wordpress.org/plugins/portfolios/) plugin. With this plugin activated you can use "portfolio" and "portfolio_tag" parameters with `[post_grid]`, `[post_list]`, `[post_grid_slider]`, `[post_list_slider]`.
* Added `[lightbox]` and `[lightbox_gallery]` shortcode.
* Added "Auto Lightbox" feature when inserting images into pages and posts. -- Can be disabled from WP > Settings > Writing.
* When inserting `[tabs]` shortcode, default example now has `tabs_above`.
* Added fix for `[icon]` shortcode image URL's to work with Theme Blvd framework v2.3+.
* Added optional "class" parameter to all column shortcodes.
* Fixed "Dismiss" link not working on notices for some admin pages.

= 1.0.6 =

* Added "tag" parameter for `[post_list]` and `[post_grid]`.
* Added optional `wpautop=true` parameter on column shortcodes to allow forcing wpautop when wrapping column sets in `[raw]`.

= 1.0.5 =

* Added custom "query" parameter for post list/grid slider shortcodes.
* Added feature to start toggle as open. -- `[toggle open="true"]`
* Fixed wpautop happenning before do_shortcode on "themeblvd_the_content".
* Accounted for framework now adding more filters to "themeblvd_the_content" when adding in `[raw]` shortcode.

= 1.0.4 =

* Added option at WP > Settings > Writing to turn off Shortcode generator from Visual Editor.
* Added CSS classes to `[icon]` shortcode for any potential custom styling.
* Now using "cat" and "category_name" params for `[mini_post_list]`, `[mini_post_grid]`, `[post_list]`, `[post_grid]`, `[post_list_slider]`, and `[post_grid_slider]`.
* Added "tag" parameter for `[mini_post_list]`, `[mini_post_grid]`, `[post_list_slider]`, and `[post_grid_slider]`.
* Updated generator options for modified shortcodes.

= 1.0.3 =

* Added `[post_slider]` to shortcode generator.
* Added custom query option to shortcode generator with applicable shortcodes.
* Changed default `[button]` size to blank, i.e. default Bootstrap button
size.
* Adding missing $size parameter for [popup] shortcode.
* Fixed PHP warning with `[toggle]` shortcode.
* Added compatibility for WPML with `[mini_post_list]` and `[mini_post_grid]`.

= 1.0.2 =

* Added feature to override `[icon]` shortcode images from your Child theme. -- Just create a folder called "icons" in the root of your Child theme and any icons there will take presedence.
* Added "width" parameter to `[icon]` shortcode. -- Defaults to 45px and will make implementing retina icons easier.

= 1.0.1 =

* Fixed option forms not showing up with shortcode generator in ThickBox popup.

= 1.0.0 =

* This is the first release.