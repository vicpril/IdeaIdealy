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

$tom = $_POST['mag_tom'];
$smarty->assign('tom', $tom);

$smarty->display('header_ru.tpl');

$cats = get_array_cats_for_contents($postID_arr);
// print_r($cats);

//$users = get_array_authors_by_post($postID);
$smarty->assign('cats', $cats);
//$smarty->assign('users', $users);
$smarty->display('content_ru.tpl');

// на английском

$smarty->display('header_en.tpl');

$cats_en = get_array_cats_en_for_contents($postID_arr);
//print_r($cats_en);

//$users = get_array_authors_by_post($postID);
$smarty->assign('cats_en', $cats_en);
//$smarty->assign('users', $users);
$smarty->display('content_en.tpl');



$smarty->display('footer.tpl');

?>

