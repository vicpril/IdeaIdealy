<?php
/*
 *  Plugin Name: _Редколлегия и Редсовет
 *  Version: 1.0.1
 *  Description: Special plugin for ideaidealy.ru
 *  Author: Victor Prilepin
 */

/*
 * Create DB on activate plugin
 */
function ii_redcolegia_activate() {
    global $wpdb;
    global $ii_red_version;

    $table_name = $wpdb->prefix . "journal_editors";
    if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {

        $sql = "CREATE TABLE " . $table_name . " (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                groupe VARCHAR(256) NOT NULL,
                user_id mediumint(5),
                post VARCHAR(256) NOT NULL,
                post_en VARCHAR(256) NOT NULL,
                UNIQUE KEY id (id))
                COLLATE 'utf8_general_ci';
                ";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

//        if (count($jobs) > 0) {
//            foreach ($jobs as $value) {
//                $rows_affected = $wpdb->insert($table_name, $value);
//            }
//        }


        add_option("ii_red_version", $ii_red_version);
    }
}

function ii_redcolegia_deactivate() {
    global $wpdb;
    global $ii_red_version;
    
    $table_name = $wpdb->prefix . "journal_editors";

    if ($wpdb->get_var("show tables like '$table_name'") == $table_name) {

        $sql = "DROP TABLE " . $table_name . ";";

        $wpdb->query($sql);

        add_option("ii_red_version", $ii_red_version);
    }
}

register_activation_hook(__FILE__, 'ii_redcolegia_activate');
// register_deactivation_hook(__FILE__, 'ii_redcolegia_deactivate');

/*
 *  Add template to template page list
 */

require_once 'page-templater.php';
add_action( 'plugins_loaded', array( 'II_PageTemplater', 'get_instance' ) );

/*
 * Add menu
 */

require_once 'ii-red-menu.php';