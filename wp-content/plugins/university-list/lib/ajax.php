<?php

/*
 *  AJAX
 */

add_action('wp_ajax_show', 'my_action_callback');
add_action('wp_ajax_get-store', 'my_action_callback');
add_action('wp_ajax_new', 'my_action_callback');

function my_action_callback() {

    $action = (isset($_POST['action'])) ? $_POST['action'] : '';

    switch ($action) {
        
        case 'get-store':
            $job_name = $_POST['name'];
            $result = get_data_from_db('', false, false, true);
            if ($result) {
                $res['status'] = true;
                $res['data'] = $result;
            } else {
                $res['status'] = false;
            }

            echo json_encode($res);

            break;
        
        case 'show':
            $job_name = $_POST['name'];
            $result = get_data_from_db($job_name, false, true);
            if ($result) {
                $res['status'] = true;
                $res['data'] = $result;
            } else {
                $res['status'] = false;
            }

            echo json_encode($res);

            break;

        case 'new':
            
            $post['id'] = (isset($_POST['id'])) ? $_POST['id'] : '';
            $post['job_name'] = (isset($_POST['job_name'])) ? $_POST['job_name'] : '';
            $post['city'] = (isset($_POST['job_city'])) ? $_POST['job_city'] : '';
            $post['adress'] = (isset($_POST['job_adress'])) ? $_POST['job_adress'] : '';
            $post['job_name_en'] = (isset($_POST['job_name_en'])) ? $_POST['job_name_en'] : '';
            $post['city_en'] = (isset($_POST['job_city_en'])) ? $_POST['job_city_en'] : '';
            $post['adress_en'] = (isset($_POST['job_adress_en'])) ? $_POST['job_adress_en'] : '';
            $success = update_job($post);

            if ($success) {
                $res['status'] = true;
                $res['data'] = $post;
                $res['data']['id'] = $success['insert_id'];
            } else {
                $res['status'] = false;
            }

            echo json_encode($res);
            break;
    }
    wp_die(); // this is required to terminate immediately and return a proper response
}
