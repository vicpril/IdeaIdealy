<?php

/*
 * head
 */
require $smarty->template_dir . '/head.htm';



 $postID_arr = array(4552);
if (isset($_POST['post_id'])) {
    $postID_arr = $_POST['post_id'];
}else{
    die('Ошибка: Статьи не выбраны.');
}
//
//
//$postID_arr = array(4552, 4558);

// на русском
$mag_title = 'Журнал «Обработка металлов» ISSN 1994-6309';      // название журнала вместе с ISSN 1994-6309
if (isset($_POST['mag_title'])) {
    $mag_title = $_POST['mag_title'];
}else{
    $mag_title = '--Название журнала-- ISSN хххх-хххх'; 
}

$mag_no = $_POST['mag_no'];                // номер журнала
$mag_f_no = $_POST['mag_f_no'];             // полный порядковый номер журнала
$mag_yarno = $_POST['mag_yarno'];          // год издательства журнала

$smarty->assign('mag_title', $mag_title);
$smarty->assign('mag_no', $mag_no);
$smarty->assign('mag_f_no', $mag_f_no);
$smarty->assign('mag_yarno', $mag_yarno);
$smarty->assign('mag_f_page', $mag_f_page);
$smarty->assign('mag_l_page', $mag_l_page);
$smarty->display('header.tpl');

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
$smarty->display('content.tpl');

// на английском


$smarty->display('footer.tpl');

?>

