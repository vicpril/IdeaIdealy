<?php
/*
Plugin Name: WP Hide Dashboard
Plugin URI: http://www.kpdesign.net/wp-plugins/wp-hide-dashboard/
Description: Simple plugin that removes the Dashboard menu, the Tools menu, and the Help link on the Profile page, and prevents Dashboard access to users assigned to the <em>Subscriber</em> role. Useful if you allow your subscribers to edit their own profiles, but don't want them wandering around your WordPress admin section. Based on the <a title="IWG Hide Dashboard" href="http://www.im-web-gefunden.de/wordpress-plugins/iwg-hide-dashboard/">IWG Hide Dashboard</a> plugin by Thomas Schneider.
Author: Kim Parsell
Author URI: http://www.kpdesign.net/
Version: 1.5
License: MIT License - http://www.opensource.org/licenses/mit-license.php

Copyright (c) 2008-2010 Kim Parsell

Permission is hereby granted, free of charge, to any person obtaining a copy of this
software and associated documentation files (the "Software"), to deal in the Software
without restriction, including without limitation the rights to use, copy, modify, merge,
publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons
to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or
substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

/* Disallow direct access to the plugin file */
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
	die('Sorry, but you cannot access this page directly.');
}

/* Define path to /wp-content/plugins/ */
if (!defined('WP_CONTENT_URL')) define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
if (!defined('WP_CONTENT_DIR')) define('WP_CONTENT_DIR', ABSPATH.'wp-content');

if (!defined('WP_PLUGIN_URL')) define('WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins');
if (!defined('WP_PLUGIN_DIR')) define('WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins');

/* Plugin config - user capability for the top level you want to hide everything from */
$wphd_user_capability = 'edit_posts'; /* [default for subscriber level = edit_posts] */

/* WordPress actions */
add_action('admin_head', 'wphd_hide_help_link', 0);
add_action('admin_head', 'wphd_hide_dashboard', 0);
add_action('admin_head', 'wphd_admin_redirect', 0);

/* Hide Help menu, Favorites menu, Upgrade notice, Keyboard shortcuts link (for Contributors+)) */
function wphd_hide_help_link() {
	global $current_user, $wphd_user_capability;

	if (!current_user_can(''.$wphd_user_capability.'')) {
		echo "\n" . '<style type="text/css" media="screen">#update-nag, #screen-meta, .turbo-nag, #favorite-actions, #your-profile .form-table a { display: none; }</style>' . "\n";
	}
}

/* Check for current WordPress version */
function wphd_hide_dashboard_version($test_version) {
	$wp_version = get_bloginfo('version');
	return version_compare($test_version, $wp_version);
}

/* Hide the Dashboard link (2.5+) and the Tools menu (2.7+) for Subscribers; Settings, Media and Comments menu for Contributors+. */
function wphd_hide_dashboard() {
	global $menu, $current_user, $wphd_user_capability;

	if (!current_user_can(''.$wphd_user_capability.'')) {
		if (0 <= wphd_hide_dashboard_version('2.6')) {
			unset($menu[0]);
		} else if (0 >= wphd_hide_dashboard_version('2.7')) {
			unset($menu[0]);		/* Hides Dashboard menu */
			unset($menu[4]);		/* Hides arrow separator under Dashboard link in 2.7+ */
			unset($menu[10]);		/* Hides Media menu (contributors +) */
			unset($menu[25]);		/* Hides Comments menu (contributors +) */
			unset($menu[55]);		/* Hides Tools menu in 2.7 and 2.7.1 */
			unset($menu[75]);		/* Hides Tools menu in 2.8 */
			unset($menu[80]);		/* Hides Settings menu (contributors +) */
			unset($menu[9999]);	/* Hides top-level menu for Pods plugin */
		}
	}
}

/* Redirect unauthorized users to their profile page if attempting to access dashboard with direct url */
function wphd_admin_redirect() {
	global $parent_file, $current_user, $wphd_user_capability;

	if (!current_user_can(''.$wphd_user_capability.'') && $parent_file == 'index.php') {
		if (!headers_sent()) {
			wp_redirect('profile.php');
			exit();
		} else {
			$wphd_hide_dashboard_url = get_option('siteurl').'/wp-admin/profile.php';
?>
<meta http-equiv="refresh" content="0; url=<?php echo $wphd_hide_dashboard_url; ?>">
<script type="text/javascript">document.location.href="<?php echo $wphd_hide_dashboard_url; ?>"</script>
</head>

<body></body>
</html>
<?php
			exit();
		}
	}
}

?>