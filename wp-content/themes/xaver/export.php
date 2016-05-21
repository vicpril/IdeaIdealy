<?php

/*
  Template Name: Export
 */

//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
//ini_set('display_errors', 1);
if (is_user_logged_in()) {

    ob_start();

    header("Content-Type: text/html; charset=utf-8");

    date_default_timezone_set('Asia/Novosibirsk');

    /*
     * export method
     */
    if (isset($_POST['export_type'])) {
        define(DIR_EXPORT, '/' . $_POST['export_type']);
    } else {
        die('Не выбран метод выгрузки');
    }

//define(DIR_EXPORT, '/authors');

    $project_root = get_template_directory();
    $smarty_dir = $project_root . '/smarty/';
    $smarty_export_dir = $project_root . '/smarty/export/';

// put full path to Smarty.class.php
    require_once (realpath($smarty_dir . '/libs/Smarty.class.php'));
    $smarty = new Smarty();

    $smarty->compile_check = true;
    $smarty->debugging = false;

    $smarty->template_dir = $smarty_dir . 'templates' . DIR_EXPORT;
    $smarty->compile_dir = $smarty_dir . 'templates_c' . DIR_EXPORT;
    $smarty->cache_dir = $smarty_dir . 'cache';
    $smarty->config_dir = $smarty_dir . 'configs';

    $smarty->security_settings['MODIFIER_FUNCS'] = array('count', 'strlen', 'explode');
    $smarty->security = true;

    require_once ($smarty->template_dir . '/index.php');


    /*
     * set filename
     */
    if ($_POST['export_type'] != 'article') {
        $file_name = $smarty_export_dir . 'export_' . $_POST['export_type'] . '_' . date('d-m-Y') . '.htm';
    } else {

        if (isset($_POST['post_id'])) {
            $postID_arr = $_POST['post_id'];
        } else {
            die('Ошибка: Статьи не выбраны.');
        }
        
        if (count($postID_arr) == 1) {
            $authors = get_array_authors_by_post($postID);
            $authors = array_values($authors);
            
            if (count($authors) == 0) {
                $name = 'no_authors_' . $_POST['export_type'] . '_' . date('d-m-Y') . '.htm';
            }else{
                $author1 = $authors[0]['id'];
                $user = get_user_meta($author1);
                $user_name = $user['us_last-name'][0] . '-' . $user['us_initials'][0];
                $name = '_' . $user_name.'_'.$_POST['export_type'] . '_' . date('d-m-Y') . '.htm';
            }
        }else{
            $name = 'export_' . $_POST['export_type'] . '_' . date('d-m-Y') . '.htm';
        }


        $file_name = $smarty_export_dir . $name;
    }





    file_put_contents($file_name, ob_get_contents());
    ob_end_clean();

    file_force_download($file_name);
} else {
    echo 'У вас нет доступа к этой странице';
}

function file_force_download($file) {
    if (file_exists($file)) {
        // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
        // если этого не сделать файл будет читаться в память полностью!
        if (ob_get_level()) {
            ob_end_clean();
        }
        // заставляем браузер показать окно сохранения файла
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        // читаем файл и отправляем его пользователю
        readfile($file);

        // удаляем файл с сервера
        unlink($file);
        exit;
    }
}
?>


