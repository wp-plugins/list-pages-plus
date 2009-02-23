=== List Pages Plus ===
Contributors: devbit
Donate link: http://skullbit.com/donate
Tags: pages, list, wp_list_pages
Requires at least: 2.5
Tested up to: 2.7.1
Stable tag: 1.2

Alter the output of the wp_list_pages() function's HTML.  Set default arguments in Settings Panel using wp_list_pages_plus() replacement function.

== Description ==

Alter the output of the wp_list_pages() function's HTML.  Add in your own classes, insert text into link title, add additional tags surrounding title.  Parents and Children are set seperately for greater flexibility.

Set default arguments in Settings Panel using `wp_list_pages_plus();` replacement function. Instead of adding commonly used arguments to your `wp_list_pages();` function, you can set these as defaults and update them easily without altering templates.  The `wp_list_pages_plus();` function mirrors the `wp_list_pages();` function exactly and additional arguments may be added directly within the function call, direct arguments will also override default arguments for multiple location use and greater flexibility.  Just edit your `sidebar.php` template (or wherever your Page menu list is output) by changing `wp_list_pages('args');` to `wp_list_pages_plus();`

== Installation ==

1. Upload the `list-pages-plus` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Set the options in the Settings Panel
1. Alter your template files to use `wp_list_pages_plus()` instead of `wp_list_pages('args')`

== Frequently Asked Questions ==

= Why aren't the settings for the Override Arguments aren't affecting my page menu? =

You will need to alter your template files to use `wp_list_pages_plus()` instead of `wp_list_pages('args')`.  This is usually located within your themes `sidebar.php` template.

= How can I include only a couple of pages in my menu? =

Although the Settings Panel allow you to **Exclude** pages through the multiple select field, sometimes it's better to use an include.  This can be set within the function's template call.  Find your themes template file that contains the `wp_list_pages_plus();` call, usually `sidebar.php` and edit the function like so, `wp_list_pages_plus('include=2,4');` to include only pages with an ID of 2 and 4 in the menu.  For more advanced arguments that are also available for use see [wp list pages](http://codex.wordpress.org/Template_Tags/wp_list_pages).

== Screenshots ==

1. Settings Panel for List Pages Plus