<?php

/*
 *  Plugin Name: _University List
 *  Version: 1.0.1
 *  Description: Special plugin for ideaidealy.ru
 *  Author: Victor Prilepin
 */

require_once 'jobs/index.php';
require_once 'lib/index.php';

// install plugin
function universitylist_activate() {
    global $wpdb;
    global $jal_db_version;

    $jobs = array(  array('job_name' => 'Новосибирский Государственный Технический Университет', 'city' => 'Новосибирск', 'adress' => '630073, Новосибирск, пр-т К.Маркса, 20','job_name_en' => 'Novosibirsk State Technical University' ,'city_en' => 'Novosibirsk' ,'adress_en' => '360073, 20 Prospekt K. Marksa, Novosibirsk'),
                    array('job_name' => 'Томский Государственный Университет', 'city' => 'Томск', 'adress' => '634050, Томск, пр. Ленина, 36','job_name_en' => 'Tomsk State University' ,'city_en' => 'Tomsk' ,'adress_en' => '634050, Tomsk, Lenina Avenue, 36'),
                    array('job_name' => 'Рубцовский индустриальный институт АлтГТУ', 'city' => 'Рубцовск', 'adress' => 'ул. Тракторная, 2/6, г. Рубцовск, 658207, Россия', 'job_name_en' => 'Rubtsovsk Industrial Institute, Branch of I.I. Polzunov Altai State Technical University', 'city_en' => 'Rubtsovsk', 'adress_en' => '2/6, Traktornaya str., Rubtsovsk, 658207, Russian Federation'),
    );
    
    $table_name = $wpdb->prefix . "job_places";
    if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {

        $sql = "CREATE TABLE " . $table_name . " (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                job_name VARCHAR(256) NOT NULL,
                city VARCHAR(40) NOT NULL,
                adress text NOT NULL,
                job_name_en VARCHAR(256) NOT NULL,
                city_en VARCHAR (40) NOT NULL,
                adress_en text NOT NULL,
                UNIQUE KEY id (id))
                COLLATE 'utf8_general_ci';
                ";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        

        if (count($jobs) > 0) {
            foreach ($jobs as $value) {
                $rows_affected = $wpdb->insert($table_name, $value);
            }
        }


        add_option("jal_db_version", $jal_db_version);
    }
}

function universitylist_deactivate() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . "job_places";
    if ($wpdb->get_var("show tables like '$table_name'") == $table_name) {

        $sql = "DROP TABLE " . $table_name . ";";

        $wpdb->query($sql);

        add_option("jal_db_version", $jal_db_version);
    }
}

register_activation_hook(__FILE__, 'universitylist_activate');
// register_deactivation_hook(__FILE__, 'universitylist_deactivate');


?>