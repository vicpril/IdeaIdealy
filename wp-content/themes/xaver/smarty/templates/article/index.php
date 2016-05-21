<?php

/*
 * head
 */
require $smarty->template_dir . '/head.htm';


/*
 * Articles
 */


if (isset($_POST['post_id'])) {
    $postID_arr = $_POST['post_id'];
}else{
    die('Ошибка: Статьи не выбраны.');
}

//$postID_arr = array(4552, 4558);

$i = 1;
foreach ($postID_arr as $postID) {
    $smarty->assign('i', $i);
    $post = get_post($postID);
        
    // if (!get_post_meta($postID, 'coauthor', false)) {
    //     continue;
    // }
    
    $art_pos = $i;
    $category = get_the_category($postID);
    $art_cat = $category[0]->name;
    
        //toggle stol 
    if (array_pop(get_post_custom_values('stol', $postID)) !== 'yes') {
        $stol = false;
    }else{
        $stol = true;
    }

    $smarty->assign('art_pos', $art_pos);
    $smarty->assign('art_cat', $art_cat);
    $smarty->assign('art_stol', $stol);

// Авторы

    $users = get_array_authors_by_post($postID);      // массив всех авторов статьи 
    $jobs = get_array_jobs_with_users($users);       // двойной массив id мест работы и пользовотелей
    
    $art_multy_job = (count($jobs) > 1) ? true : false;     // переключатель режимы для нескольких университетов
    if (isset($_POST['email_on'])) {
        $email_on = $_POST['email_on'];
    }else{
        $email_on = false;
    }

    $smarty->assign('jobs', $jobs);
    $smarty->assign('users', $users);
    $smarty->assign('art_multy_job', $art_multy_job);
    $smarty->assign('email_on', $email_on);

// Статья
    $art_title = $post->post_title;
    $art_notice = get_field('annotation', $postID);
    $art_udk = get_field('udk', $postID);
    $art_doi = get_field('doi', $postID);
    $art_keywords = get_field('keywords', $postID);
    $art_lit = get_field('literatura', $postID);
    $art_lit_en = get_field('literatura_en', $postID);
    $art_date_arrival = get_field('date_arrival', $postID);
    $art_cat_en = get_field('cat_en', $postID);
    $art_title_en = get_field('title_en', $postID);
    $art_notice_en = get_field('annotation_en', $postID);
    $art_key_en = get_field('key_en', $postID);
//    $art_text = get_field('text', $postID);
    $content = $post->post_content;
    $content = str_replace("\n","<p>",$content);
    $art_text = $content;
    $art_fin = get_field('financ', $postID);

    $smarty->assign('art_title', $art_title);
    $smarty->assign('art_notice', $art_notice);
    $smarty->assign('art_udk', $art_udk);
    $smarty->assign('art_doi', $art_doi);
    $smarty->assign('art_keywords', $art_keywords);
    $smarty->assign('art_lit', $art_lit);
    $smarty->assign('art_lit_en', $art_lit_en);
    $smarty->assign('art_date_arrival', $art_date_arrival);
    $smarty->assign('art_cat_en', $art_cat_en);
    $smarty->assign('art_title_en', $art_title_en);
    $smarty->assign('art_notice_en', $art_notice_en);
    $smarty->assign('art_key_en', $art_key_en);
    $smarty->assign('art_text', $art_text);
    $smarty->assign('art_fin', $art_fin);

    $smarty->display('article.tpl');
    
    $i++;


}
$smarty->display('footer.tpl');

?>

