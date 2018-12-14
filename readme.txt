=== Theme Blvd Shortcodes ===
Author URI: http://www.themeblvd.com
Contributors: themeblvd
Tags: shortcodes, bootstrap, Theme Blvd, themeblvd, Jason Bobich
Stable Tag: 1.6.8
Tested up to: 5.0

This plugin works in conjunction with the Theme Blvd framework to create shortcodes for many of the framework's internal elements.

== Description ==

Within themes using the Theme Blvd framework, there are many internal elements and other 3rd-party items integrated, like [Twitter Bootstrap](http://twitter.github.com/bootstrap/) and [FontAwesome](http://fortawesome.github.io/Font-Awesome/), to make use of.  When using a [Theme Blvd theme](http://themeblvd.com/themes/), this plugin gives you an extensive pack of shortcodes to extend the framework's functionality to your pages, posts, and custom layouts via shortcodes.

After activating this plugin, you'll know it's ready to go by viewing the Edit Page or Edit Post screen and seeing the plugin's [shortcode generator](https://wordpress.org/plugins/theme-blvd-shortcodes/screenshots/) button above your WordPress Editor. You'll then have access to our shortcodes for use within your website.

= Theme Compatibility =

This plugin works with the following themes only.

**Theme Blvd Framework 2.5+ Themes**

* [Jump Start](http://wpjumpstart.com)
* [Denali](http://themeblvd.com/links/buy-denali)
* [Gnar](http://themeblvd.com/links/buy-gnar)

**Theme Blvd Framework 2.2-2.4 Themes**

* [Akita](http://themeforest.net/item/akita-responsive-wordpress-theme/1530025?ref=themeblvd)
* [Alyeska](http://themeforest.net/item/alyeska-responsive-wordpress-theme/164366?ref=themeblvd)
* [Arcadian](http://themeforest.net/item/the-arcadian-responsive-wordpress-theme/1266406?ref=themeblvd)
* [Barely Corporate](http://themeforest.net/item/barely-corporate-responsive-wordpress-theme/93069?ref=themeblvd)
* [Breakout](http://www.mojo-themes.com/item/breakout-premium-wordpress-theme/?r=themeblvd)
* [Commodore](http://themeforest.net/item/commodore-responsive-wordpress-theme/111713?ref=themeblvd)
* [Swagger](http://themeforest.net/item/swagger-responsive-wordpress-theme/930581?ref=themeblvd)

Full shortcodes and compatibility table: [See Table](http://demoblvd.com/plugins/shortcodes/theme-compatibility/)

= Documentation and Usage Examples =

Theme Blvd Framework 2.5+ Themes: [View Documentation and Examples](http://shortcodes.themeblvd.com)

Theme Blvd Framework 2.2-2.4 Themes: [View Documentation and Examples](http://demoblvd.com/legacy/shortcodes)

**NOTE: For this plugin to do anything, you must have a theme with Theme Blvd framework v2.2+ activated.**

== Installation ==

1. Upload `theme-blvd-shortcodes` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Having problems with content formatting, when combined with some complex third-party plugins?  =

Any content wrapped in the `[raw]` shortcode will allow you to escape any automatic WordPress formatting. Keep in mind that this is not a standard shortcode, and does modify the content outputted in your site. So, if you find that this conflicts with any other plugins you may be using, you can disable this functionality all together from *Settings > Writing* in your WordPress admin.

== Screenshots ==

1. Button leading to Shortcode Generator, which can be used from Visual or Text tab.
2. Shortcode Generator interface.

== Changelog ==

= 1.6.8 - 12/14/2018 =

* Fixed: "Add Shortcode" button not working when editing custom layouts with [Theme Blvd Layout Builder](https://wordpress.org/plugins/theme-blvd-layout-builder) v2.3+.

= 1.6.7 - 02/06/2018 =

* Fixed: "Add Shortcode" button not usable with elements within a Columns element of the [layout builder](http://wordpress.org/plugins/theme-blvd-layout-builder) (for framework 2.7 themes).
* Fixed: Configuration of `[column]` shortcode combinations not working properly in shortcode generator (for framework 2.7 themes).

= 1.6.6 - 01/29/2018 =

* Fixed: Custom colors not getting applied to icons of `[icon_list]` shortcode.
* Fixed: Restored support for the theme's thumbnail icons to work with the `[lightbox]` shortcode (for framework 2.7 themes).
* Fixed: Make sure icon browser search data doesn't get printed in the source code more than once (for framework 2.7 themes).

= 1.6.5 - 01/18/2018 =

* New: Added support for the shortcode generator (framework 2.7 themes).

= 1.6.4 - 01/16/2018 =

* Improvement: Added compatibility for FontAwesome 5 (for framework 2.7+ themes).
* Fixed: Minor admin styling issues with WordPress 4.8+.
* Fixed: Custom classes added to `[lightbox]` shortcode not always being appended correctly.
* Removed: No more "striped" option for progress bars (for framework 2.5+ themes).

= 1.6.3 - 03/08/2017 =

* Improvement: Better support for using variable width carousel with `[gallery_slider]` in Theme Blvd Framework 2.5+ themes. -- You can now pass in `carousel="true"` or `carousel="false"` to force the variable width carousel and override global gallery slider option set on theme options page. Also, now appropriate default image crop size will be used, depending on slider being displayed. [See documentation](http://demoblvd.com/plugins/shortcodes/generator/shortcodes-sliders/gallery-slider/).

= 1.6.2 - 02/25/2017 =

* Fixed: Transparent background and border on `[button]` shortcode using `include_bg` and `include_border` parameters not working properly.

= 1.6.1 - 02/17/2017 =

* Fixed: Theme Options page being covered by shortcode generator popup.
* Fixed: Fatal PHP error when using `[lead]` shortcode.
* Fixed: "Add Shortcode" button not displaying in editor popups on Theme Options page and Layout Builder.

= 1.6.0 - 02/16/2017 =

* New: Added optional "stack" parameter to `[column]` shortcode for responsive stacking; you can pass in `xs`, `sm`, `md` or `lg` (requires Theme Blvd Framework 2.5+).
* Fixed: Selecting a style for `[post_slider]` in shortcode generator wasn't working.
* Improvement: All PHP code has been reformatted to pass [WordPress Coding Standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) through PHP_CodeSniffer.

= 1.5.9.1 - 11/11/2015 =

* Allow `[popup]` shortcode to work more consistently, when nested within more complex areas.

= 1.5.9 - 09/28/2015 =

* Fixed: Background color not getting applied to `[jumbotron]` with Theme Blvd Framework 2.5+ themes.

= 1.5.8 - 08/24/2015 =

* Fixed: Minor admin styling issues with shortcode generator modal in WordPress 4.3.
* Fixed: Child theme image icons not being listed in shortcode generator in Theme Blvd Framework 2.4- themes.
* Removed: The `[icon]` shortcode has been removed in Theme Blvd Framework 2.5+ themes. Use `[vector_icon]` instead.

= 1.5.7 - 05/29/2015 =

* Updated `[jumbotron]` to work with Theme Blvd framework 2.5 updates.
* Added x-large, xx-large, and xxx-large sizes to generator for `[button]` shortcode (requires Theme Blvd Framework 2.5+).

= 1.5.6 - 04/18/2015 =

* Added support for `gutters="hide"` in `[post_showcase]` (requires Theme Blvd Framework 2.5+).
* Added more options to `[divider]` shortcode, similar to Layout Builder (requires Theme Blvd Framework 2.5+).
* Allow `more_text` param to work for `[post_grid]` and `[post_list]`, even though it's not in the generator (requires Theme Blvd Framework 2.5+).
* Fixed: In shortcode generator, `[post_grid]` and `[post_showcase]` outputting incorrect parameter for displaying excerpts.
* Fixed: In shortcode generator, options with a value of "none" weren't getting inserted when selected.

= 1.5.5 - 02/1/2015 =

* Fixed: When publishing a new page with shortcode generator active, there was a side effect of `$post->post_excerpt` getting saved as `0`, from an unrelated option in the generator with id "excerpt".

= 1.5.4 - 01/3/2015 =

* Fixes to `[mini_post_list]` options.

= 1.5.3 - 12/9/2015 =

* Minor fixes to options in shortcode generator.
* Minor security fix.

= 1.5.2 - 11/24/2014 =

* Fixed "numberposts" attribute with `[post_list]` shortcode.

= 1.5.1 - 11/19/2014 =

* Fixed issues with "last" attribute not closing rows properly.
* GlotPress compatibility (for 2015 wordpress.org release).

= 1.5.0 - 11/17/2014 =

* Added `[column]` shortcode; other column shortcodes are now deprecated.
* Added `[lead]` shortcode.
* Added `[pricing_table]` shortcode (requires Theme Blvd Framework 2.5+).
* Added `[testimonial]` shortcode (requires Theme Blvd Framework 2.5+).
* Added `[milestone]` and `[milestone_ring]` shortcode (requires Theme Blvd Framework 2.5+).
* Added `[post_showcase]` shortcode (requires Theme Blvd Framework 2.5+).
* Added `[blog]` shortcode; this is similar to previous `[post_list]`.
* Added custom color selection for `[button]` shortcode (requires Theme Blvd Framework 2.5+).
* Added custom text/background color selection for `[jumbotron]` shortcode (requires Theme Blvd Framework 2.5+).
* Added titles and captions to `[gallery_slider]` (requires Theme Blvd Framework 2.5+).
* Added filter option to post lists and post grids (requires Theme Blvd Framework 2.5+).
* Added masonry option to post grids (requires Theme Blvd Framework 2.5+).
* Added options to `[jumbotron]` shortcode (requires Theme Blvd Framework 2.5+).
* Improvements to `[divider]` shortcode (requires Theme Blvd Framework 2.5+).
* Improvements to `[progress_bar]` shortcode (requires Theme Blvd Framework 2.5+).
* Adjustments to allow shortcodes to work with Ajax requests on the frontend of the site.
* Better handling of default option values at *Settings > Writing > Theme Blvd Shortcodes*.
* Fixed issues with inserting `[icon_list]` from shortcode generator.
* Removed `[post_list_slider]` for newer themes, use `[post_slider]` or `[post_grid_slider]` instead.

= 1.4.1 - 04/23/2014 =

* Fixes for `[box]`, `[icon_link]`, and `[label]` shortcodes' icon to work with older themes using FontAwesome 3.
* Added "caption" parameter to [lightbox] shortcode.
* Auto Lightbox feature will now work when image has a caption.
* Auto Lightbox feature now disabled by default. Go to *WP Admin > Settings > Writing > Theme Blvd Shortcodes* to enable.

= 1.4.0 - 04/16/2014 =

* All new shortcode generator.

= 1.3.0 - 03/23/2014 =

* Added `[gallery_slider]` shortcode (requires Theme Blvd Framework 2.4.2+).
* Added `[jumbotron]` shortcode (requires Theme Blvd Framework 2.4.2+).
* Added `[panel]` shortcode (requires Theme Blvd Framework 2.4.0+).
* Added "gallery" option to Mini Post Grid - Ex: `[mini_post_grid gallery="1,2,3,4"]`
* Added "color" option to `[icon_link]` for color of the icon.
* Added "color", "rotate", "flip", and "class" options to `[vector_icon]` shortcode.
* Fixed "icon" option for `[label]` with FontAwesome 4.
* Updated `[icon_list]` to use FontAwesome 4's "fa-ul" and "fa-li" classes.

= 1.2.0 - 02/18/14 =

* Added `[blockquote]` shortcode for easier Bootstrap quote formatting.
* `[vector_icon]` shortcode fix for FontAwesome 4.
* `[icon_list]` shortcode fix for FontAwesome 4.
* `[icon_link]` shortcode fix for FontAwesome 4.
* `[label]` shortcode fix for Bootstrap 3.
* `[toggle]` shortcode fix for Bootstrap 3.
* `[alert]` and `[info]` shortcodes fix for Bootstrap 3 and FontAwesome 4.
* `[progress_bar]` shortcode fix for Bootstrap 3.
* Because of Bootstrap 3, `[tabs]` shortcode no longer has below, right, or left nav options.

= 1.1.2 - 08/27/13 =

* Another small fix to the `[post_slider]` parameters for shortcode generator.

= 1.1.1 - 08/06/13 =

* Fixed `[post_slider]` parameters for shortcode generator.

= 1.1.0 - 08/02/13 =

* Added compatibility for [Portfolios](http://wordpress.org/plugins/portfolios/) plugin. With this plugin activated you can use "portfolio" and "portfolio_tag" parameters with `[post_grid]`, `[post_list]`, `[post_grid_slider]`, `[post_list_slider]`.
* Added `[lightbox]` and `[lightbox_gallery]` shortcode.
* Added "Auto Lightbox" feature when inserting images into pages and posts. -- Can be disabled from WP > Settings > Writing.
* When inserting `[tabs]` shortcode, default example now has `tabs_above`.
* Added fix for `[icon]` shortcode image URL's to work with Theme Blvd framework v2.3+.
* Added optional "class" parameter to all column shortcodes.
* Fixed "Dismiss" link not working on notices for some admin pages.

= 1.0.6 - 04/19/13 =

* Added "tag" parameter for `[post_list]` and `[post_grid]`.
* Added optional `wpautop=true` parameter on column shortcodes to allow forcing wpautop when wrapping column sets in `[raw]`.

= 1.0.5 - 03/23/13 =

* Added custom "query" parameter for post list/grid slider shortcodes.
* Added feature to start toggle as open. -- `[toggle open="true"]`
* Fixed wpautop happenning before do_shortcode on "themeblvd_the_content".
* Accounted for framework now adding more filters to "themeblvd_the_content" when adding in `[raw]` shortcode.

= 1.0.4 - 01/16/13 =

* Added option at WP > Settings > Writing to turn off Shortcode generator from Visual Editor.
* Added CSS classes to `[icon]` shortcode for any potential custom styling.
* Now using "cat" and "category_name" params for `[mini_post_list]`, `[mini_post_grid]`, `[post_list]`, `[post_grid]`, `[post_list_slider]`, and `[post_grid_slider]`.
* Added "tag" parameter for `[mini_post_list]`, `[mini_post_grid]`, `[post_list_slider]`, and `[post_grid_slider]`.
* Updated generator options for modified shortcodes.

= 1.0.3 - 12/28/12 =

* Added `[post_slider]` to shortcode generator.
* Added custom query option to shortcode generator with applicable shortcodes.
* Changed default `[button]` size to blank, i.e. default Bootstrap button
size.
* Adding missing $size parameter for [popup] shortcode.
* Fixed PHP warning with `[toggle]` shortcode.
* Added compatibility for WPML with `[mini_post_list]` and `[mini_post_grid]`.

= 1.0.2 - 12/25/12 =

* Added feature to override `[icon]` shortcode images from your Child theme. -- Just create a folder called "icons" in the root of your Child theme and any icons there will take presedence.
* Added "width" parameter to `[icon]` shortcode. -- Defaults to 45px and will make implementing retina icons easier.

= 1.0.1 - 09/18/12 =

* Fixed option forms not showing up with shortcode generator in ThickBox popup.

= 1.0.0 - 09/06/12 =

* This is the first release.
