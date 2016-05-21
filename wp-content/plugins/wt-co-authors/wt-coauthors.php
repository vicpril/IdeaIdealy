<?php
/*
  Plugin Name: WT Co-authors
  Description: Displays co-authors of a post.
  Version: 2.0.1
  Author: Eugen Rochko
  Author URI: http://anime2.kokidokom.net/
 */

//require ( ABSPATH . WPINC . '/registration.php' );
//Basic functionality: checks for coauthors, gives them the right textual realisation, returns.
//Input: $postid, usually $post->ID; $dolink, true or false, defines whether there should be linking or not.

$max_authors = get_user_meta('1', 'max_rows_authors', true);
 
if ( empty ( $max_authors) || $max_authors < 1 ) {
 
    $max_authors = 20;
 
}


//$max_authors = 6;

function wt_return_coauthors($postid, $dolink = false) {
    $getcoauthor = get_post_meta($postid, 'coauthor', false);

    //print_r($getcoauthor);

    $coauthor = "";
    if (is_array($getcoauthor)):
        $i = 0;
        $ac = count($getcoauthor);
        foreach ($getcoauthor as $author):
            //if(username_exists($author)):
            $i++;

            $getauthordata = get_user_by_display_name($author); //get_userdatabylogin($author);
            $authorid = $getauthordata->ID;
//				$link = "/author/".$getauthordata->user_login;
            $link = get_author_posts_url($getauthordata->ID, $getauthordata->user_nicename);

            if ($getauthordata) {
                $coauthor .= sprintf('<a href="%1$s" title="%2$s">%3$s</a>', $link, sprintf(__('Posts by %s'), $getauthordata->first_name), $getauthordata->display_name);
            } else {
                $coauthor .= $author;
            }

            if ($i !== $ac):
                $coauthor .= ', ';
            elseif ($i == $ac):
                if ($dolink):
                    $coauthor .= sprintf(' <span class="coauthor-sep">%s</span> ', __('', 'wt-co-authors'));
                else:
                    $coauthor .= sprintf(' %s ', __('', 'wt-co-authors'));
                endif;
            endif;
            //endif;
        endforeach;
        $coauthor = $coauthor;
    endif;
    return $coauthor;
}

function wt_return_editors($postid, $dolink = false) {
    $geteditors = get_post_meta($postid, 'editor', false);
    $editors = "";
    if (is_array($geteditors) && !empty($geteditors)):
        $i = 0;
        foreach ($geteditors as $editor):
            if (username_exists($author)):
                $geteditordata = get_userdatabylogin($editor);
                $editorid = $geteditordata->ID;
                if ($i != 0):
                    $editors .= ", ";
                endif;
                $editors .= $geteditordata->display_name;
                $i++;
            endif;
        endforeach;
        $editors = sprintf("<span title=\"%s %s\">*</span>", __('Editor: ', 'wt-co-authors'), $editors);
    endif;
    return $editors;
}

//Template tag for manual use. Displays the coauthors together with the original author. To replace the_author, the_author_posts_link etc
function wt_the_coauthors_link($before = false, $after = false) {
    global $post;
    $coauthors = wt_return_coauthors($post->ID, true);
    if ($coauthors) {
        echo $before . $coauthors . $content . $after;
    }
//	echo $before.$coauthors.$content.$after;
}

//Filter for the_author template tag, display coauthors automatically.
//Input: $display_name, usually $user_data->display_name
function wt_the_coauthors($display_name) {
    global $post;
    $content = $display_name;
    $coauthors = wt_return_coauthors($post->ID, false);
    return $coauthors . $content;
}

function wt_the_coauthors_link_hack($link) {
    global $authordata, $post;
    $content = sprintf(
            '<a href="%1$s" title="%2$s">%3$s</a>', get_author_posts_url($authordata->ID, $authordata->user_nicename), esc_attr(sprintf(__('Posts by %s'), get_the_author())), get_the_author()
    );
    $coauthors = wt_return_coauthors($post->ID, true);
    return $coauthors . $content;
}

//The filtering, for automatisation.
add_filter('the_author', 'wt_the_coauthors');
add_filter('get_the_author_display_name', 'wt_the_coauthors');

add_filter('the_author_posts_link', 'wt_the_coauthors_link_hack');

$new_meta_boxes = array(
    "coauthors" => array(
        "name" => "coauthors",
        "id" => "coauthor",
        "std" => "",
        "title" => "Cо-авторы",
        "description" => "")
);

function wt_new_meta_boxes() {
    global $post, $new_meta_boxes;

//    foreach ($new_meta_boxes as $meta_box) {
//        $meta_box_value = get_post_meta($post->ID, $meta_box['id'], false);
//        //print_r($meta_box_value);
//        $values = "";
//        $i = 0;
//        foreach ($meta_box_value as $value):
//            if ($i != 0):
//                $values .= ", ";
//            endif;
//            $values .= $value;
//            $i++;
//        endforeach;

    /*
     * new $values
     */
    foreach ($new_meta_boxes as $meta_box) {
        $meta_box_value = get_post_meta($post->ID, $meta_box['id'], false);
        //print_r($meta_box_value);
        $values = array();
//        $i = 0;
        foreach ($meta_box_value as $value):
//            if ($i != 0):
//                $values .= ", ";
//            endif;
            $values[] = $value;
//            $i++;
        endforeach;

        echo'<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
        echo'<h2>' . $meta_box['title'] . '</h2>';
//        echo'<input type="text" name="' . $meta_box['name'] . '__value" value="' . $values . '" size="55" /><br />';

        /*
         * select2  input
         */
        global $max_authors;

        echo '<p style="width: 400px">';

        for ($i = 1; $i <= $max_authors; $i++) {
            $open_tag = '<div class="raw-author" pos="' . $i . '" style="margin-bottom: 15px;">';
            $select_tag_open = '<select type="text" name="' . $meta_box['name'] . '__value' . $i . '" id="sel-authors' . $i . '" class="sel-authors" pos="' . $i . '" style="width: 350px; " />';

            $select_options = '';
            $selected = '';
            $empty_option = '<option user_id="" value="" selected="selected">--Выберите автора--</option>';
            $ar_btn = '<input id="add-authors' . $i . '" type="button" class="add-authors button" pos="' . $i . '" style="margin-left: 20px; margin-right: 20px;" value="+"/>';

            $authors = get_users('role=' . $role);
            $link_to_edit = '';
            $user_id = '';
            
            $select = false;
            foreach ($authors as $author) {
                $selected = '';
                if (!$select) {
                    if ($author->display_name == $values[0]) {
                        $selected = 'selected="selected"';
                        $user_id = $author->ID;
                        $link_to_edit = '<a class="edit-link" href="'.  home_url().'/wp-admin/user-edit.php?user_id='.$user_id.'" target="_blank">Редактировать</a>';
                        $empty_option = '<option user_id="" value="" >--Выберите автора--</option>';
                        array_shift($values);
                        $select = true;
                    }
                }

                $select_options .= '<option user_id="'.$author->ID.'" value="' . $author->display_name . '" ' . $selected . '>' . $author->display_name . '</option>';
            }

            $select_tag_close = '</select>';

            $close_tag = '</div>';
            
            

            echo ($open_tag . $select_tag_open . $empty_option . $select_options . $select_tag_close . $ar_btn . $link_to_edit. $close_tag);
        }

        echo '</p>';

        $l_img = '<img class="waiting"  style="display:none; vertical-align:middle; right:5px;" src="images/loading.gif" alt="" id="au_loading_img" /> ';
        $button_reset = '<input id="refresh-authors" type="button" class="save button" value="Обновить выпадающий список" style="margin-left: 10px;"/>';
        $label = '<label >Нажать, если вы <span style="text-decoration: bold; color: orangered;">СОЗДАЛИ</span> нового автора</label>';
        echo '<p><label for="' . $meta_box['name'] . '_value">' . $meta_box['description'] . '</label>' . $l_img . $label . $button_reset . '</p>';
    }
}

function wt_create_meta_box() {
    global $theme_name;
    if (function_exists('add_meta_box')) {
        add_meta_box('wt-new-meta-boxes', 'Авторы', 'wt_new_meta_boxes', 'post', 'normal', 'high');
    }
}

function wt_save_postdata($post_id) {



    global $post, $new_meta_boxes, $max_authors;

    //$post_id=$_POST["post_ID"];
    $meta_box = $new_meta_boxes["coauthors"];

    if ($post_id) {

        // Verify
        if (!wp_verify_nonce($_POST[$meta_box['name'] . '_noncename'], plugin_basename(__FILE__))) {
            return $post_id;
        }

        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
        } else {
            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }
        $old = get_post_meta($post_id, "coauthor", false);
//         print_r($post_id);
//		print_r($old);
        foreach ($old as $delete):
            //if(!in_array($delete, $datas))
            delete_post_meta($post_id, $meta_box['id'], $delete);
        endforeach;
        $old = get_post_meta($post_id, $meta_box['id'], false);


//        $data = $_POST[$meta_box['name'] . '__value'];
//        $datas = explode(",", $data);
//        foreach ($_POST[$meta_box['name'] . '__value'] as $value) {
//            $datas[] = $value;
//        }
        for ($i = 1; $i <= $max_authors; $i++) {
            if ($_POST[$meta_box['name'] . '__value' . $i]) {
                $datas[] = $_POST[$meta_box['name'] . '__value' . $i];
            }
        }
        
        if (!empty($datas)) {
            foreach ($datas as $update):
            if (!in_array(trim($update), $old) && !empty($update))
                add_post_meta($post_id, $meta_box['id'], trim($update), false);

        endforeach;
        }

        
    }
}

add_action('admin_menu', 'wt_create_meta_box');
add_action('save_post', 'wt_save_postdata');
add_action('admin_init', 'add_main');

function add_main() {

    global $pagenow;

    // apply only to user profile or user edit pages
    if ($pagenow !== 'post.php' && $pagenow !== 'post-new.php') {
        return;
    }
    add_action('admin_footer', 'add_main_js');
    $option = 'rows';
  $args = array(
         'label' => 'Количество строчек для авторов',
         'default' => 10,
         'option' => 'rows_authors'
         );
  add_screen_option( $option, $args );
}

function add_main_js() {
    ?>
    <script type="text/javascript">
        
    <?php require_once 'main.js'; ?>
        
    </script>
    <?php
}

add_action('wp_ajax_get-authors', 'get_all_authors');


function get_all_authors() {

    $action = (isset($_POST['action'])) ? $_POST['action'] : '';
    $role = (isset($_POST['role'])) ? $_POST['role'] : '0';

    if ($action == 'get-authors') {
        $authors = get_users('role=' . $role);

        
        $res['data'] = $authors;

        wp_send_json($res);
    }

    
}

add_action('wp_ajax_get-english-cat', 'get_english_cat');

function get_english_cat() {
    $action = (isset($_POST['action'])) ? $_POST['action'] : '';
    $id = (isset($_POST['id'])) ? $_POST['id'] : '';
    
    if ($id) {
        
        $term = get_term_by('id', $id, 'category');
        $res['status'] = true;
        $res['data'] = $term->description;
        
        echo json_encode($res);
    }
    
    wp_die();
}

/*
 * Add MAX_AUTHORS_ROWS to screen options
 */
add_action('load-post.php', 'add_options_authors_raws');
add_action('load-post-new.php', 'add_options_authors_raws');

function add_options_authors_raws() {
  $option = 'per_page';
  $args = array(
         'label' => 'Максимальное количество строчек для авторов <span style="color: orangered;">(не рекомендуется уменьшать)</span>',
         'default' => 10,
         'option' => 'max_rows_authors'
         );
  add_screen_option( $option, $args );
}


add_filter('set-screen-option', 'authors_rows_set_option', 10, 3);
 
function authors_rows_set_option($status, $option, $value) {
 
    if ( 'max_rows_authors' == $option ) return $value;
 
    return $status;
 
}



?>