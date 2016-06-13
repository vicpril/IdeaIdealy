<?php

add_action('admin_menu', 'register_translate_menu');

function ii_translate_category($id, $cat_en ) {
    $check = term_exists($cat_en);
    if (!$check) {
        $new_term_id = wp_insert_term($cat_en, 'category');
        pll_save_term_translations(array( 'en' => $new_term_id['term_id'], 'ru' => $id ));
        pll_set_term_language($new_term_id['term_id'], 'en');
        return $new_term_id['term_id'];
    } else {
        if (is_array($check)) {
            return $check['term_id'];
        }else{
            return $check;
        }
        
    }
    
}

function register_translate_menu() {
    $hook = add_submenu_page('edit.php', 'Перевод', 'Перевод', 'manage_options', 'translate', 'translate_menu_page');
}

function translate_menu_page() {
    global $polylang;

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'tr-post':
                foreach ($_POST['id'] as $id) {
                    $post_ru = get_post($id);
                    $title_en = get_field('title_en', $id);
                    
                    $cat_ru = $post_ru->post_category;
                    $cat_en_id =  pll_get_term($cat_ru[0], 'en');
//                    $c = get_term($cat_en_id);
//                    $cat_en = $c->name;
                    
                    if (empty($cat_en_id)) {
                        $cat_en_field = get_field('cat_en', $id);
                        if ($cat_en_field) {
                            $cat_en_id = ii_translate_category($cat_ru[0], $cat_en_field);
                        }
                    }
                    
                    $tag_ru = wp_get_post_tags($id);
                    $tag_en_id = pll_get_term($tag_ru[0]->term_id, 'en');
//                    $t = get_term($tag_en_id);
//                    $tag_en = $t->name;
                    
                    $args = array(
                        'post_title' 	=> $title_en,
                        'post_status'  	=> $post_ru->post_status,
                        'post_category'  => array($cat_en_id),
                        'tags_input'  => array($tag_en_id)
                            );
                    
                    $new_post_id = wp_insert_post($args);
                    
                    
                    if (is_int($new_post_id)) {
                        pll_save_post_translations(array('ru' => $id , 'en' => $new_post_id));
                        pll_set_post_language($new_post_id, 'en');
                    }
                    
                }
                echo '<div id="message" class="updated notice is-dismissible">
                    <p>Статьи добавлены.</p>
                    <button class="notice-dismiss" type="button">
                    </div>';
                break;
            
            case 'tr-cat':
                foreach ($_POST['id'] as $id) {
                    $term_ru = get_term($id, 'category');
                    if ($term_ru->description == $term_ru->name) {
                        $desc = $term_ru->description . '_en';
                    } else {
                        $desc = $term_ru->description;
                    }
                    $new_term_id = wp_insert_term($desc, 'category');
                    pll_save_term_translations(array('ru' => $id , 'en' => $new_term_id['term_id']));
                    pll_set_term_language($new_term_id['term_id'], 'en');
                }
                echo '<div id="message" class="updated notice is-dismissible">
                    <p>Рубрики добавлены.</p>
                    <button class="notice-dismiss" type="button">
                    </div>';
                break;
            
            case 'tr-tag':
                foreach ($_POST['id'] as $id) {
                    $term_ru = get_term($id, 'post_tag');
                    $new_term_id = wp_insert_term($term_ru->description, 'post_tag');
                    pll_save_term_translations(array('ru' => $id , 'en' => $new_term_id['term_id']));
                    pll_set_term_language($new_term_id['term_id'], 'en');
                }
                echo '<div id="message" class="updated notice is-dismissible">
                    <p>Метки добавлены.</p>
                    <button class="notice-dismiss" type="button">
                    </div>';
                break;

            default:
                break;
        }
    }
    
    
    
    
    ?>

<!--Статьи-->

<div class="wrap">
    <h1>Перевод записей</h1>
    
    <form method="post">
        <?php 
        
        $args = array(
            'post_type' => 'post',
            'orderby' => 'post_date',
            'order' => 'desc',
//            'post_status' => 'publish',
            'posts_per_page' => -1,
            'lang' => 'ru'
          );
        query_posts($args);
        
        $count = 0;
        $posts_id = array();
        $no_en_title = 0;
        
        while ( have_posts() ) : the_post();
            
            $ru_post_id = get_the_ID();
            $en_title = get_field('title_en', $ru_post_id);
            
            if (empty($en_title)) {
                $no_en_title++;
            } else {
                if (!array_key_exists('en', pll_get_post_translations($ru_post_id))) {
                    $count++;
                    $posts_id[] = $ru_post_id;
                } else {
//                    pll_save_post_translations(array('ru' => $ru_post_id));
                }
            }
            
//            the_title();
            
        endwhile;
        
//        if ($no_en_title) {
            ?>
            <!--<span>Обнаружено <?=$no_en_title?> статей для заполнения названия на английском.</span> <a href="edit.php">Заполнить</a><br>-->
            <?php
//        }
        
        ?>
    <span>Обнаружено <?=$count?> записей для перевода:</span>
    
    <?php if ($count) {
            foreach ($posts_id as $id) {
                ?> 
                    <input type="hidden" value="<?=$id?>" name="id[]" />
                    <li style="font-style: italic">"<?php echo get_post($id)->post_title; ?>"</li>
                <?php
            }
            
            ?>
                
                <p class="submit">
                    <input type="hidden" name="action" value="tr-post" />
                    <input type="submit" class="button-primary" value="Перевести статьи" />
                </p>
            <?php
        }
        ?>
    </form>
    
</div>    




<?php

}

?>