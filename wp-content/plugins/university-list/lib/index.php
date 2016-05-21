<?php

$libs = array(
    'user-fields_add',
    'user-fields_autocomplete',
    'user-fields_hide',
    'user-new_autocomplete',
    'custom-post-edit',
    'ajax',
);

foreach ($libs as $name) {
    require_once $name . '.php';
}

function load_custom_wp_admin_style() {
    define('SELECT_DIR', plugins_url('university-list').'/lib/js/select2/');
    define('MULTI_SELECT_DIR', plugins_url('university-list').'/lib/js/multi-select/');
    define('QS_DIR', plugins_url('university-list').'/lib/js/quicksearch/');
    
    
    wp_enqueue_style('select2', SELECT_DIR . 'select2.min.css');
    wp_enqueue_style('multi-select', MULTI_SELECT_DIR . 'multi-select.css');
    
    wp_register_script('bootstrap', SELECT_DIR . '../bootstrap.min.js', array('jquery'));
    wp_register_script('select2', SELECT_DIR . 'select2.full.min.js', 'bootstrap', array('bootstrap'));
    wp_register_script('multi-select', MULTI_SELECT_DIR . 'jquery.multi-select.js', 'bootstrap', array('bootstrap'));
    wp_register_script('quicksearch', QS_DIR . 'jquery.quicksearch.js', 'bootstrap', array('bootstrap'));
    wp_register_script('main-admin', SELECT_DIR . '../main-admin.js', array('jquery'));


    // Enqueue_scripts
    wp_enqueue_script('bootstrap');
    wp_enqueue_script('select2');
    wp_enqueue_script('multi-select');
    wp_enqueue_script('quicksearch');
    wp_enqueue_script('main-admin');

}

add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');

//add_action('admin_init', 'add_tag_to_list');
//
//function add_tag_to_list() {
//
//    global $pagenow;
//
//    // apply only to user profile or user edit pages
//    if ($pagenow !== 'post.php' && $pagenow !== 'post-new.php') {
//        return;
//    }
//    add_action('admin_footer', 'add_tag_to_list_js');
//}