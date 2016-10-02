<?php
/*
 * Template RINC
 */

/*
 * head
 */
require $smarty->template_dir . '/head.htm';

// $postID_arr = array(4552);
if (isset($_POST['post_id'])) {
    $postID_arr = $_POST['post_id'];
}else{
    die('Ошибка: Статьи не выбраны.');
}

//$postID_arr = array(4552, 4558);


/*
 * Title
 */
$mag_title = 'Журнал «Обработка металлов» ISSN 1994-6309';      // название журнала вместе с ISSN 1994-6309
if (isset($_POST['mag_title'])) {
    $mag_title = $_POST['mag_title'];
}else{
    $mag_title = '--Название журнала--'; 
}

/*
 * ISSN
 */
if (isset($_POST['mag_issn']) && !empty($_POST['mag_issn'])) {
    $mag_issn = 'ISSN '. $_POST['mag_issn'];
}else{
    $issn = get_ISSN($postID_arr);
    if (!empty($issn)) {
//        $mag_issn = 'ISSN '. $issn;
        $mag_issn = $issn;
    }else{
        $mag_issn = '';
    }
}


$mag_no = $_POST['mag_no'];                // номер журнала
$mag_f_no = $_POST['mag_f_no'];             // полный порядковый номер журнала
$mag_yarno = $_POST['mag_yarno'];          // год издательства журнала
$mag_tom = $_POST['mag_tom'];          // номер тома

// Вычислим страничы из дои

foreach ($postID_arr as $postID) {
    $mag_f_page = get_doi_first_page($postID);
    if (!empty($mag_f_page)) {
        break;
    }
}

for ($index = count($postID_arr)-1; $index >= 0; $index--) {
    $mag_l_page = get_doi_last_page($postID_arr[$index]);
    if (!empty($mag_l_page)) {
        break;
    }
}




$smarty->assign('mag_title', $mag_title);
$smarty->assign('mag_issn', $mag_issn);
$smarty->assign('mag_no', $mag_no);
$smarty->assign('mag_f_no', $mag_f_no);
$smarty->assign('mag_yarno', $mag_yarno);
$smarty->assign('mag_tom', $mag_tom);
$smarty->assign('mag_f_page', $mag_f_page);
$smarty->assign('mag_l_page', $mag_l_page);
$smarty->display('header.tpl');

/*
 * Articles
 */




$i = 1;
foreach ($postID_arr as $postID) {
    $post = get_post($postID);
        
//    if (!get_post_meta($postID, 'coauthor', false)) {
//        continue;
//    }
    
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
    $users = array();
    $users = get_array_authors_by_post($postID);      // массив всех авторов статьи 
//   var_dump($users);
    
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
    $art_keywords = rtrim($art_keywords);
    $art_keywords = rtrim($art_keywords, ' .');
    
    $art_lit = get_field('literatura', $postID);
    $art_date_arrival = get_field('date_arrival', $postID);
    $art_cat_en = get_field('cat_en', $postID);
    $art_title_en = get_field('title_en', $postID);
    $art_notice_en = get_field('annotation_en', $postID);
    $art_fin = get_field('financ', $postID);
    $art_key_en = rtrim(rtrim(get_field('key_en', $postID)), ' .');
    
//    $art_text = get_field('text', $postID);
    $content = $post->post_content;
    $content=str_replace("\n","<p>",$content);
    $art_text = $content;
    
    $art_f_page = get_doi_first_page($postID);
    $art_l_page = get_doi_last_page($postID);
    

    $smarty->assign('art_title', $art_title);
    $smarty->assign('art_notice', $art_notice);
    $smarty->assign('art_udk', $art_udk);
    $smarty->assign('art_doi', $art_doi);
    $smarty->assign('art_keywords', $art_keywords);
    $smarty->assign('art_lit', $art_lit);
    $smarty->assign('art_date_arrival', $art_date_arrival);
    $smarty->assign('art_cat_en', $art_cat_en);
    $smarty->assign('art_title_en', $art_title_en);
    $smarty->assign('art_notice_en', $art_notice_en);
    $smarty->assign('art_key_en', $art_key_en);
    $smarty->assign('art_fin', $art_fin);
    $smarty->assign('art_text', $art_text);
    $smarty->assign('art_f_page', $art_f_page);
    $smarty->assign('art_l_page', $art_l_page);

//    print_r($users);
    
    $smarty->display('article.tpl');
    
    $i++;


}
$smarty->display('footer.tpl');


function get_doi_first_page($postId) {
    $doi = get_field('doi', $postId);

    $doi_str = explode('/', $doi);
    $doi_str[1] = explode('-', $doi_str[1]);


    $mag_f_page = $doi_str[1][4];          // первая страница первой статьи

//    $mag_l_page = $doi_str[1][5];         // последняя страница последней статьи
    
    if ($mag_f_page) {
        return $mag_f_page;
    }else{
        return '';
    }
    
}
function get_doi_last_page($postId) {
    $doi = get_field('doi', $postId);

    $doi_str = explode('/', $doi);
    $doi_str[1] = explode('-', $doi_str[1]);


//    $mag_f_page = $doi_str[1][4];          // первая страница первой статьи

    $mag_l_page = $doi_str[1][5];         // последняя страница последней статьи
    
    if ($mag_l_page) {
        return $mag_l_page;
    }else{
        return '';
    }
}

function get_ISSN($arr){
    foreach ($arr as $id) {
        $doi = get_field('doi', $id);
        if (!empty($doi)) {
            $doi_str = explode('/', $doi);
            $doi_str[1] = explode('-', $doi_str[1]);
            $issn = "ISSN {$doi_str[1][0]}-{$doi_str[1][1]}"; 
            return $issn;
        }
    }
    return '';
}


?>

