<?php

/*
  Template Name: Modify
 */

//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
//ini_set('display_errors', 1);
header("Content-Type: text/html; charset=utf-8");

date_default_timezone_set('Asia/Novosibirsk');

global $wpdb;

$users = get_users();

//var_dump($users);

echo "Найдено " . count($users) . " пользовотелей. <br>";

echo "<a href='" . get_page_link() . "?action=do'>Обновить</a>";

if (isset($_GET['action']) && $_GET['action'] == 'do') {

    $ef = array(
            'us_full-name',
            'us_last-name',
            'us_first-name',
            'us_patronymic',
            'us_initials',
            'us_name_en',
            'us_initials_en'
        );
    
    $count_success_users = 0;
    
    
    foreach ($users as $user) {
        $user_id = $user->ID;
        $name = get_user_meta($user_id, 'first_name');
        $login_name = $user->user_login;
//
//        var_dump($name);
//        var_dump($login_name);
        
        $new['us_full-name'] = $name[0];
        $name = explode(' ', $name[0], 3);
//        var_dump($name);
        switch(count($name)){
            
            case 1:
                $l_name = $name[0];
                break;
            case 2:
                $l_name = $name[0];
                $name[1] = explode('.', $name[1]);
                if (strlen($name[1][0]) == 1) {
                    $f_name = $name[1][0];
                    $i = str_split($f_name);
                    $ini = $i[0] . '.';
                } else {
                    $f_name = $name[1][0];
                    $pat = $name[1][1];
                    $i = mb_substr($f_name, 0, 1);
                    $k = mb_substr($pat, 0, 1);
                    if ($k) {
                        $ini = $i . '.' . $k . '.';
                    }else{
                        $ini = $i . '.';
                    }
                }
                break;
            case 3:
                $l_name = $name[0];
                $f_name = $name[1];
                $pat = $name[2];
                $i = mb_substr($f_name, 0, 1);
                $k = mb_substr($pat, 0, 1);
                    if ($k) {
                        $ini = $i . '.' . $k . '.';
                    }else{
                        $ini = $i . '.';
                    }
                break;
        }
        
        if ($f_name) {
            $new['us_first-name'] = $f_name;
        }else{
            $new['us_first-name'] = '';
        }
        
        if ($pat) {
            $new['us_patronymic'] = $pat;
        }else{
            $new['us_patronymic'] = '';
        }
        
        if ($l_name) {
            $new['us_last-name'] = $l_name;
            $name_en = tranaslate($l_name);
        }else{
            $new['us_last-name'] = '';
            $name_en = '';
            
        }
        
        if ($ini) {
            $new['us_initials'] = $ini;
            $ini_en = tranaslate($ini);
        }else{
            $new['us_initials'] = '';
            $ini_en = '';
        }
        
        
        
        if ($name_en) {
            $new['us_name_en'] = $name_en;
        }else{
            $new['us_name_en'] = '';
        }
        if ($ini_en) {
            $new['us_initials_en'] = $ini_en;
        }else{
            $new['us_initials_en'] = '';
        }
        
        $success_user = true;
        
        foreach ($new as $key => $value) {
            $success = update_user_meta($user_id, $key, $value);
            if (!$success) {
                $success_user = false;
            }
        }
        
        if ($success_user) {
            $count_success_users++;
        }
        
    }
    
    echo '<br>Успешно обновлено '.$count_success_users.' авторов';
}

function tranaslate($title) {
                $gost1 = array(
                    "Є" => "EH", "І" => "I", "і" => "i", "№" => "#", "є" => "eh",
                    "А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D",
                    "Е" => "E", "Ё" => "JO", "Ж" => "ZH",
                    "З" => "Z", "И" => "I", "Й" => "JJ", "К" => "K", "Л" => "L",
                    "М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R",
                    "С" => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "KH",
                    "Ц" => "C", "Ч" => "CH", "Ш" => "Sh", "Щ" => "Shh", "Ъ" => "'",
                    "Ы" => "Y", "Ь" => "", "Э" => "EH", "Ю" => "YU", "Я" => "YA",
                    "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d",
                    "е" => "e", "ё" => "jo", "ж" => "zh",
                    "з" => "z", "и" => "i", "й" => "jj", "к" => "k", "л" => "l",
                    "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
                    "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "kh",
                    "ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "shh", "ъ" => "",
                    "ы" => "y", "ь" => "", "э" => "eh", "ю" => "yu", "я" => "ya", "«" => "", "»" => "", "—" => "-"
                );
                return strtr($title, $gost1);
            }
