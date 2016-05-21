<?php

// Убираем пункты меню
function remove_menus() {
   global $menu;
// Массив разделов меню, которые мы планируем удалить
//   $restricted = array(__('Links'), __('Tools'), __('Comments'), __('Plugins'), __('Updates'));
   $restricted = array();
   end($menu);

   while (prev($menu)) {
       $value = explode(' ', $menu[key($menu)][0]);
       if (in_array($value[0] != NULL ? $value[0] : "", $restricted)) {
           unset($menu[key($menu)]);
       }
   }
}

add_action('admin_menu', 'remove_menus');
