<?php

$files = array(
    'functions',
    'main',
    'uni_table_class',
);

foreach ($files as $name) {
    require_once $name.'.php';
}

function custom_wp_admin_style() {
    
    wp_enqueue_style('job-fields', plugins_url('university-list') . '/job-fields.css');
    
}

add_action('admin_enqueue_scripts', 'custom_wp_admin_style');