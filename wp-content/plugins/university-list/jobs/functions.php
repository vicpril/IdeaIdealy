<?php

// delete job
if (!function_exists('delete_job')) {

    function delete_job($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . "job_places";

        foreach ($id as $value) {
            $success['status'] = $wpdb->query(
                    $wpdb->prepare("DELETE FROM $table_name WHERE id = %d", $value)
            );
            if (!$success['status']) {
                die('Ошибка удаления из БД');
            }
        }
        return $success;
    }

}

// edit job
if (!function_exists('update_job')) {

    function update_job($post) {
        global $wpdb;
        $table_name = $wpdb->prefix . "job_places";

        $id = (isset($post['id'])) ? $post['id'] : '';

        foreach ($post as $value) {
            $value = $wpdb->escape($value);
        }
        if ($id == '') {
            $success ['status'] = $wpdb->insert($table_name, $post);
            $success ['insert_id'] = $wpdb->insert_id;
            $success ['message'] = 'add';
        } else {
            $success ['status'] = $wpdb->update($table_name, $post, array('ID' => $id));
            $success ['message'] = 'update';
        }
        if (!$success['status']) {
            die('Ошибка записи в БД');
        }
        return $success;
    }

}

//get data from db
function get_data_from_db($search = '', $field = false, $equal = false, $sort = false) {
    global $wpdb;
    
    $field = ($field)? $field : '*';

    $search = $wpdb->escape($search);
    if ($search == '') {
        $where = '';
    } else {
        if (!$equal) {
            $where = 'WHERE `job_name` LIKE "%' . $search . '%" '
                    . 'OR `city` LIKE "%' . $search . '%" '
                    . 'OR `adress` LIKE "%' . $search . '%"'
//                    . 'OR `id` LIKE "%' . $search . '%"'
                    . 'OR `city_en` LIKE "%' . $search . '%"'
                    . 'OR `adress_en` LIKE "%' . $search . '%"'
                    . 'OR `job_name_en` LIKE "%' . $search . '%"';
        } else {
            $where = 'WHERE `job_name` = "' . $search . '" ';
        }
    }

    $table_name = $wpdb->prefix . "job_places";

    $jobs = $wpdb->get_results("SELECT ". $field ." FROM " . $table_name . " " . $where, ARRAY_A);
    
    if ($sort) {
        usort($jobs, "my_sort_alph");
    }
    
    return $jobs;
}

// сортируем по алфавиту
function my_sort_alph($a, $b) {
    return strcmp($a["job_name"], $b["job_name"]);
}



// get adress from wp_job_places by ID
if (!function_exists('get_job_adress')) {

    function get_job_adress($id) {
        $field = 'adress';
        return get_job_from_db($id, $field);
    }

}
// for en
if (!function_exists('get_job_adress_en')) {

    function get_job_adress_en($id) {
        $field = 'adress_en';
        return get_job_from_db($id, $field);
    }

}

// get city from wp_job_places by ID
if (!function_exists('get_job_city')) {

    function get_job_city($id) {
        $field = 'city';
        return get_job_from_db($id, $field);
    }

}
// for en
if (!function_exists('get_job_city_en')) {

    function get_job_city_en($id) {
        $field = 'city_en';
        return get_job_from_db($id, $field);
    }

}

// get job_name from wp_job_places by ID
if (!function_exists('get_job_name')) {

    function get_job_name($id) {
        $field = 'job_name';
        return get_job_from_db($id, $field);
    }

}
// foe en
if (!function_exists('get_job_name_en')) {

    function get_job_name_en($id) {
        $field = 'job_name_en';
        return get_job_from_db($id, $field);
    }

}

// get from wp_job_places by ID
if (!function_exists('get_job_from_db')) {

    function get_job_from_db($id, $field) {
        global $wpdb;
        return $wpdb->get_var("SELECT " . $field . " FROM wp_job_places WHERE id = " . $id);
    }

}