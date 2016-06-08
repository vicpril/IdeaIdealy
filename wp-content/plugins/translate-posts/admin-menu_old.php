<?php

add_action('admin_menu', 'register_translate_menu');

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
                    
                    $tag_ru = wp_get_post_tags($id);
                    $tag_en_id = pll_get_term($tag_ru[0]->term_id, 'en');
                    $t = get_term($tag_en_id);
                    $tag_en = $t->name;
                    
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
        
        if ($no_en_title) {
            ?>
            <span>Обнаружено <?=$no_en_title?> статей для заполнения названия на английском.</span> <a href="edit.php">Заполнить</a><br>
            <?php
        }
        
        ?>
    <span>Обнаружено <?=$count?> записей для перевода</span>
    
    <?php if ($count) {
            foreach ($posts_id as $id) {
                ?> <input type="hidden" value="<?=$id?>" name="id[]" /> <?php
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



<!--Рубрики-->
    
<div class="wrap">
    <h1>Перевод рубрик</h1>
    
    <form method="post">
    
    <?php 
        $args = array(
            'taxonomy' => 'category',
            'lang' => 'ru'
        );
    
        $terms = get_terms($args);
        
        $count = 0;
        $terms_id = array();
        $no_desc = 0;
        
        foreach ($terms as $term) {
             if (!$term->description) {
                $no_desc++;
            } else {
                if (!array_key_exists('en', pll_get_term_translations($term->term_id))) {
                    $count++;
                    $terms_id[] = $term->term_id;
                }
            }
        }
        
        if ($no_desc) {
            ?>
            <span>Обнаружено <?=$no_desc?> рубрик для заполнения описания на английском.</span> <a href="edit-tags.php?taxonomy=category">Заполнить</a><br>
            <?php
        }

//        echo count($terms);
        
        ?>
    
        <span>Обнаружено <?=$count?> рубрик для перевода</span>
        
        <?php if ($count) {
            foreach ($terms_id as $id) {
                ?> <input type="hidden" value="<?=$id?>" name="id[]" /> <?php
            }
            
            ?>
                
                <p class="submit">
                    <input type="hidden" name="action" value="tr-cat" />
                    <input type="submit" class="button-primary" value="Перевести рубрики" />
                </p>
            <?php
        }
        ?>
    </form>
    
</div>    
    


<!--Метки-->

<!--<div class="wrap">
    <h1>Перевод меток</h1>
    
    <form method="post">
    -->
    <?php // $args = array(
//            'taxonomy' => 'post_tag',
//        );
//    
//        $terms = get_terms($args);
//        $count = 0;
//        $terms_id = array();
//        $no_desc = 0;
//        
//        foreach ($terms as $term) {
//            if (!$term->description) {
//                $no_desc++;
//            } else {
//                if (!array_key_exists('en', pll_get_term_translations($term->term_id))) {
//                    $count++;
//                    $terms_id[] = $term->term_id;
//                } else {
//                }
//            }
//            
//        }
//            
//        if ($no_desc) {
            ?>
            <!--<span>Обнаружено <?=$no_desc?> меток для заполнения описания на английском.</span> <a href="term.php?taxonomy=post_tag">Заполнить</a><br>-->
            <?php //
        }
    ?>
        
        <!--<span>Обнаружено <?=$count?> меток для перевода</span>-->
        
        <?php // if ($count) {
//            foreach ($terms_id as $id) {
                ?> 
    <!--<input type="hidden" value="<?=$id?>" name="id[]" />-->
 <?php
//            }
            
            ?>
                
<!--                <p class="submit">
                    <input type="hidden" name="action" value="tr-tag" />
                    <input type="submit" class="button-primary" value="Перевести метки" />
                </p>-->
            <?php
//        }
        ?>
<!--    </form>
    
</div>    -->




<?php
//}
