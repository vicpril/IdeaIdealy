<?php
/*
 *  Plugin Name: _Posts Export
 *  Version: 1.0.1
 *  Description: Special plugin for ideaidealy.ru
 *  Author: Victor Prilepin
 */
add_action('admin_head', 'my_column_width');

function my_column_width() {
    echo '<style type="text/css">';
    echo '.column-myauthors { text-align: left; width:200px !important; overflow:hidden }';
    echo '</style>';
}


add_action('admin_init', 'pe_add_main');

function pe_add_main() {

    global $pagenow;

    // apply only to user profile or user edit pages
    if ($pagenow !== 'edit.php') {
        return;
    }
    add_action('admin_footer', 'pe_add_main_js');
}

function pe_add_main_js() {
    ?>
    <script type="text/javascript">
        
    <?php require_once 'main.js'; ?>
        
    </script>
    <?php
}

include 'export_table_class.php';

add_action('admin_menu', 'register_export_menu_page');

function register_export_menu_page() {
    $hook = add_submenu_page('post.php', 'Выгрузка', 'Выгрузка', 'manage_options', 'posts-export/posts-export.php', 'export_menu_page');
}

function export_menu_page() {
    global $switchDraftToPublishFeature, $ShowDegubInfo;
    ?>
    <div id="debug_list"<?php if (false == $ShowDegubInfo) echo' style="display:none;"'; ?>></div>
    <div id="" class="wrap">
        <div id="postMash_checkVersion" style="float:right; font-size:.7em; margin-top:5px;">
            version 1.1.0
        </div>
        <h1 style="margin-bottom:0; clear:none;">Выгрузка статей в шаблоны</h1>

        <p>
        <div class="alignleft actions">

            <?php
            // view filters
            if (!is_singular()) {
                global $wpdb, $wp_locale;
                ?>
                <form action="" method="get" enctype="multipart/form-data">
                    <input type="hidden" name="page" value="posts-export/posts-export.php"  />

                    Год: <input name="yearno" type="text" value="<?= $_GET['yearno'] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Номер:<input name="no" type="text" value="<?= $_GET['no'] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Том:<input name="tom" type="text" value="<?= $_GET['tom'] ?>">
                    <!--
                    <?php
                    $cat = $_GET['cat'];
                    $dropdown_options = array('show_option_all' => __('View all categories'), 'hide_empty' => 0, 'hierarchical' => 1,
                        'show_count' => 0, 'orderby' => 'name', 'selected' => $cat);
                    wp_dropdown_categories($dropdown_options);
                    do_action('restrict_manage_posts');
                    ?> -->

                    <input type="submit" id="post-query-submit" value="Вывести статьи" class="button-secondary" />
                </form>
            <?php } ?>
        </div>

    </p>

    <div style="clear:both; height:20px;"> </div>

    <?php export_getPages(); ?>

    </div>

    <?php
}

function export_getPages() {

    global $wpdb, $wp_version, $switchDraftToPublishFeature;

    //get pages from database
    $date = $_GET['m'];
    $mmonth = substr($date, -2);
    $yyear = substr($date, 0, 4);
    $query_post .= "SELECT DISTINCT * FROM $wpdb->posts JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id) ";
    if (isset($_GET['cat']) && $_GET['cat'] != '0') {
        $query_post .= "INNER JOIN $wpdb->term_relationships ON($wpdb->posts.ID = $wpdb->term_relationships.object_id)
													INNER JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
													WHERE $wpdb->term_taxonomy.term_id = " . $_GET['cat'];

        $query_post.=" AND CASE meta_key
	WHEN 'tom' THEN meta_value = '" . $_GET['tom'] . "'

	WHEN 'yearno' THEN meta_value = '" . $_GET['yearno'] . "'

	WHEN 'no' THEN meta_value = '" . $_GET['no'] . "'
	END GROUP BY wp_posts.ID HAVING COUNT(*) = 3 ";

        $query_post .= " AND $wpdb->posts.post_type = 'post' ORDER BY menu_order ";
    } else {
        $query_post .= "WHERE post_type = 'post'";

        $query_post.=" AND CASE meta_key
	WHEN 'tom' THEN meta_value = '" . $_GET['tom'] . "'

	WHEN 'yearno' THEN meta_value = '" . $_GET['yearno'] . "'

	WHEN 'no' THEN meta_value = '" . $_GET['no'] . "'
	END GROUP BY wp_posts.ID HAVING COUNT(*) = 3 ";

        if (isset($_GET['m']) && $_GET['m'] != '0') {
            $query_post .= " AND YEAR(post_date) = " . $yyear . " AND MONTH(post_date) = " . $mmonth;
        }
        $query_post .= " ORDER BY menu_order ";
    }

    $pageposts = $wpdb->get_results("$query_post");
    //echo $query_post;
    if ($pageposts == true) {
        ?>
        <form method="post">


            <?php
            $data = array();
            foreach ($pageposts as $page) {
                if (is_plugin_active('polylang/polylang.php')) {
                    if (pll_get_post_language($page->ID) == false || pll_get_post_language($page->ID) == 'ru' ) {
                        $data[] = (Array) $page;
                    }
                } else {
                    $data[] = (Array) $page;
                }
            }
            $uniListTable = new Export_List_Table();
            $uniListTable->prepare_items($data);
            $uniListTable->display();
            ?>

            <table class="form-table">    
                
                <tr>
                    <th>
                        <label for="export_type">Шаблон выгрузки</label>
                    </th>
                    <td>
                        <select id='export-type' name="export_type" style="width: 250px">
                            <option value="rinc">РИНЦ</option>
                            <option value="contents">Содержание</option>
                            <option value="article">Статья</option>
                            <option value="authors">Наши авторы</option>
                            <option value="emails">Список E-mail'ов</option>
                        </select>
                    </td>
                </tr>

                <tr >
                    <th>
                        <label for="mag_title">Название журнала</label>
                    </th>
                    <td>
                        <input class='for-export for-rinc for-emails' required="" type="text" name="mag_title" style="width: 250px" value="Журнал «Идеи и Идеалы»">
                    </td>
                    <td>
                        <label style="font-size: 12px;">Название журнала<label>
                    </td>
                </tr>

                <tr >
                    <th>
                        <label for="mag_title">ISSN</label>
                    </th>
                    <td>
                        <input class='for-export for-rinc for-emails' type="text" name="mag_issn" style="width: 250px" placeholder="xxxx-xxxx">
                    </td>
                    <td>
                        <label style="font-size: 12px;">Если ISSN не введен, то он будет взят из DOI статей. Если ни одна статья не содержит DOI, то ISSN выводиться не будет.<label>
                    </td>
                </tr>
                
                <tr class='add-field'>
                    <th>
                        <label for="mag_title">Выгружать e-mail</label>
                    </th>
                    <td>
                        <input class='for-export for-rinc' type="checkbox" name="email_on" checked="">
                    </td>
                    <td>
                        <label style="font-size: 12px;">Отображать email у автора, если он редактировался</span>"<label>
                    </td>
                </tr>
                
                <tr class='add-field'>
                    <input formaction="<?php home_url(); ?>/export" type="submit" id="export_submit" class="button-primary" style="font-weight: bold; float:left;" value="Выгрузить" name="submit"/>
                </tr>

            </table>
            
            <input hidden type="text" name="mag_yarno" value="<?php echo $_GET['yearno']; ?>">
            <input hidden type="text" name="mag_no" value="<?php echo $_GET['no']; ?>">
            <input hidden type="text" name="mag_tom" value="<?php echo $_GET['tom']; ?>">
            
                    <?php 
                    



                    ?>
            
            <input hidden type="text" name="mag_f_no" value="<?php echo getNoma(); ?>">


        </form>

        <?php
        return true;
    } else {
        echo '<h3 style="margin-top:30px;" >Извините, подходящих запросу записей не найдено!</h3>';
        return false;
    }
}

function getNoma() {
    query_posts('meta_key=yearno&showposts=-1'); //сначала получим годы всех журналов
// далее по циклу вынесем все их в массив
    $year = Array();
    while (have_posts()) : the_post();
        $mykey_values = get_post_custom_values('yearno');
        foreach ($mykey_values as $key => $value) {
            $nomer = @array_pop(get_post_custom_values('no')); //получаем номер журнала

            $id = (int) $post->ID;
            $year[$value][$nomer][$id] = "";
            $noma[md5($nomer . $value)] = $nomer . $value; //подсчет общего кол-ва журналов для вывода автоматической последовательности номеров -> N1(3) т.3 2010
        }
    endwhile;


    ksort($year);
    $year = array_reverse($year, true);
    $noma = count($noma);
    foreach ($year as $key => $val) {
        foreach ($val as $key2 => $val2) {
            if ($key == $_GET['yearno'] && $key2 == $_GET['no']) {
                return $noma;
            }
            $noma--;
        }
    }
}
