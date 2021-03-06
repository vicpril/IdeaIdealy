=== WP Hide Dashboard ===
Contributors: kpdesign
Donate link: http://www.kpdesign.net/wp-plugins/wp-hide-dashboard/
Tags: admin, administration, dashboard, hide
Requires at least: 2.5
Tested up to: 2.9.x
Stable tag: 1.5

Hide the Dashboard link (2.5+), Tools menu and Help link (2.7+) from your blog subscribers when they are logged in.

== Description ==

This plugin removes the Dashboard menu, the Tools menu, and the Help link on the Profile page, and prevents Dashboard access to users assigned to the <em>Subscriber</em> role. Useful if you allow your subscribers to edit their own profiles, but don't want them wandering around your WordPress admin section.

Users belonging to any of the other WordPress roles will continue to see the Dashboard link and the Tools menu, and have access to the other sections of the WordPress admin that corresponds to their role's capabilities.

Based on the [IWG Hide Dashboard](http://www.im-web-gefunden.de/wordpress-plugins/iwg-hide-dashboard/ "IWG Hide Dashboard") plugin by Thomas Schneider, which requires having the Role Manager plugin activated in order for it to function.

This plugin relies only on core WordPress capabilities.

= Works With: =

The following is a list of role/content management plugins that work well (no conflicts) with the WP Hide Dashboard plugin:

* [Members](http://wordpress.org/extend/plugins/members/ "Members") by Justin Tadlock
* [wpNamedUsers](http://wordpress.sundskard.dk/archives/category/wpnamedusers "wpNamedUsers") by Andrias Sundskard

= Known Conflicts: =

The following is a list of role/content management plugins that are known to have conflicts with the WP Hide Dashboard plugin:

* [Role Manager](http://www.im-web-gefunden.de/wordpress-plugins/role-manager/ "Role Manager") (Use the [IWG Hide Dashboard](http://www.im-web-gefunden.de/wordpress-plugins/iwg-hide-dashboard/ "IWG Hide Dashboard") plugin to hide the dashboard link.)
* [Role Scoper](http://wordpress.org/extend/plugins/role-scoper/ "Role Scoper")
* [Flutter](http://wordpress.org/extend/plugins/fresh-page/ "Flutter")

Note: Please let me know if there are other plugins that conflict with WP Hide Dashboard, and I'll add them to the list.

= Support: =

Support is provided at: http://www.kpdesign.net/wp-plugins/wp-hide-dashboard/

== Installation ==

= Installation Instructions: =

1. Download the plugin and unzip it to a folder on your computer.
2. Upload the `wp-hide-dashboard` folder to the `wp-content/plugins/` directory.
3. Activate the plugin through the Plugins section in WordPress.
4. That's it! There is no configuration necessary.

== Frequently Asked Questions ==

Below are a couple of the most frequently asked questions.

Check out http://www.kpdesign.net/wp-plugins/wp-hide-dashboard/ for the full FAQ.

**Q. How do I change this to hide the Dashboard link, Tools menu and Help options from other roles besides Subscriber?**

A. To hide these from other roles, you will need to edit the plugin in a plain text editor and make the following changes:

**Version 1.5**

You will need to change the capability in lines 44:

`/* Plugin config - user capability for the top level you want to hide everything from */
$wphd_user_capability = 'edit_posts'; /* [default for subscriber level = edit_posts] */`

* Subscriber -> Contributor: Change `edit_posts` to `upload_files`
* Subscriber -> Author: Change `edit_posts` to `manage_categories`
* Subscriber -> Editor: Change `edit_posts` to `manage_options`

**Version 1.4 and below:**

There are 3 instances of this code in the plugin - make sure you change all of them.

* Subscriber -> Contributor: Change `!current_user_can('edit_posts')` to `!current_user_can('upload_files')`
* Subscriber -> Author: Change `!current_user_can('edit_posts')` to `!current_user_can('manage_categories')`
* Subscriber -> Editor: Change `!current_user_can('edit_posts')` to `!current_user_can('manage_options')`

**Q. Will you be creating an admin option page to allow specifying what role we want to hide these from?**

A. I have this on the to-do list for the plugin, to be included in a future release. In the meantime, you will still need to edit the plugin manually.

== Screenshots ==

1. Upper-left portion of 2.7/2.8/2.9 admin section

== Changelog ==

= Version 1.5: =
* Added code to make it easier to configure plugin if you want to change the role/capability level.
* Added code to remove Tools menu.
* Added code to remove Settings, Media and Comments menus for Contributors+ if needed
* Added code to remove WordPress upgrade nag notice (admin will still see the notice).

= Version 1.4: =
* Added code to remove Tools menu in 2.8.x (menu numbering changed in core).
* Added Frequently Asked Questions and proper Changelog sections to readme.txt file.

= Version 1.3: =
* Fixed error in WordPress version checking.

= Version 1.2: =
* Added removal of Help link on Profile page.

= Version 1.1: =
* Added WordPress version checking.
* Added code for defining path to /wp-content/plugins/ if outside the WordPress directory.
* Added removal of Tools menu and collapsible arrow from the menu area in 2.7.x.

= Version 1.0: =
* Initial release

== Upgrade Notice ==

= Version 1.5: =
Added code to enable easier configuration, remove other menus per user requests.
