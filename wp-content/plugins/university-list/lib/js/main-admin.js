/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function(){
   jQuery(function() {
        // Deactivate all currently active menus
        wp_deactivate_menus();

        // Activate the parent menu with an id #menu-pages, as well as the submenu item with
        // the specific slug "edit.php?post_type=page"
        wp_activate_menu('#menu-pages', 'edit.php?post_type=page');
        wp_activate_menu('#menu-posts', 'edit.php?post_type=post');
        wp_activate_menu('#menu-users', 'users.php');
    }); 
});

// Deactivate all active / expanded Wordpress menus
function wp_deactivate_menus() {
  var $sidebar = jQuery("#adminmenu");
  var $active_menus = $sidebar.children('li.current, li.wp-has-current-submenu, li.wp-menu-open');

  // Close all open menus
  $active_menus.each(function() {
    var $this = jQuery(this);

    // Conditional classes
    if ($this.hasClass('wp-has-current-submenu')) 
      $this.addClass('wp-not-current-submenu');

    // Unconditional classes
    $this
      .removeClass('current')
      .removeClass('wp-menu-open')
      .removeClass('wp-has-current-submenu')
      .addClass('wp-not-current-submenu');

    // Remove "current" from all submenu items, too
    $this.find('ul.wp-submenu li a.current').removeClass('current');
  });
}

// Activate a Wordpress menu and optionally highlight a submenu slug within that category
// menu_id = String, such as "#my-menu-id". (Not necessarily an ID, but a selector to select the <li>) 
// slug = String, such as "edit.php?post-type=page". Must be exactly the same href as the submenus a[href]
function wp_activate_menu( menu_id, slug ) {
  var $sidebar = jQuery("#adminmenu");
  var $menu = $sidebar.find( menu_id );

  if (!$menu || $menu.length < 1) return false;

  // Conditional classes
  if ($menu.hasClass('wp-has-submenu'))
    $menu.addClass('wp-has-current-submenu');

  // Unconditional classes
  $menu
//    .addClass('current')
    .addClass('wp-menu-open')
//    .removeClass('wp-not-current-submenu');

  if (typeof slug == 'undefined') return;

  // Begin activating the submenu
  var $submenu = $menu.find('a[href="' + slug + '"]');

  if (!$submenu || $submenu.length < 1) return;

//  $submenu.parent('li').addClass('current');
}

// getParameterByName function provided by:
// http://stackoverflow.com/questions/901115/how-can-i-get-query-string-values
//if (
//  getParameterByName('taxonomy') == 'directory_category'
//  && getParameterByName('post_type') == 'directory_post'
//)