<?php

/*
 * head
 */
require $smarty->template_dir . '/head.htm';



$postID_arr = array(4552);
if (isset($_POST['post_id'])) {
    $postID_arr = $_POST['post_id'];
} else {
    die('Ошибка: Статьи не выбраны.');
}
//
//
//$postID_arr = array(4341, 4345, 4347, 4357, 4360, 4362);
// на русском


foreach ($postID_arr as $postID) {
    $arr[$postID] = get_array_authors_by_post($postID);
}

foreach ($arr as $users) {
    if ($users) {
        foreach ($users as $id => $user) {
            if ($id != null) {
                $users_arr[$id] = $user;
            }
        }
    }
}

// сортируем по алфавиту
function my_sort($a, $b) {
    return strcmp($a["us_last_name"], $b["us_last_name"]);
}

usort($users_arr, "my_sort");

//print_r($users_arr);

$smarty->assign('users', $users_arr);

// на английском

$smarty->display('authors.tpl');

//$cats_en = get_array_cats_en_for_contents($postID_arr);
//var_dump($cats_en);


$smarty->display('footer.tpl');

function get_users_from_cats($cats) {
    foreach ($cats as $key => $value) {
        
    }



    return $users;
}
?>

