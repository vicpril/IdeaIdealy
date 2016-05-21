<?php

// THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
function custom_colors() {
    ?>
    '<style type="text/css">
        .post-state {
            font-size: 14px;
            color:#FF3333;
        }

        .empty-fields-false {
            color: green;
            font-weight: bold;
        }
        
        ul.empty-fields-true{
            list-style-type: disc;
            color: orangered;
        }
        
        p#tagcloud-post_tag a{
            font-size: 14px;
        }
    </style>';



    <?php
}

add_action('admin_head', 'custom_colors');

// Ставим фильтры
add_filter('manage_posts_columns', 'new_post_col');

// Заголовки новых колонок для записей
function new_post_col($defaults) {
    unset($defaults['comments']);

    $defaults['post-status'] = 'Статус';
    $defaults['empty_fields'] = 'Незаполненные поля';

    return $defaults;
}

// Устанавливаем новые действия
add_action('manage_posts_custom_column', 'get_item_id_pp', 10, 2);

// Вывод идентификаторов материалов
function get_item_id_pp($column, $post_id) {
    if ($column == 'post-status') {
        if (get_post_status($post_id) == 'draft' || get_post_status($post_id) == 'private') {
            print '<span class="post-state">В работе</span>';
        } else {
            print get_post_status($post_id);
        }
        $unknown_array = array('unknown');

        if (get_post_custom_values('yearno')) {
            $yearno = array_pop(get_post_custom_values('yearno'));
        } else {
            $yearno = $unknown_array;
        }
        if (get_post_custom_values('no')) {
            $no = array_pop(get_post_custom_values('no'));
        } else {
            $no = $unknown_array;
        }if (get_post_custom_values('tom')) {
            $tom = array_pop(get_post_custom_values('tom'));
        } else {
            $tom = $unknown_array;
        }

        $info = '<br>Год: ' . $yearno .
                '<br>Номер: ' . $no .
                '<br>Том: ' . $tom;
        if (get_field('article_order', $post_id)) {
            $info .= '<br>Порядок: ' . get_field('article_order', $post_id);
        };

        print ($info);
    }

    if ($column == 'empty_fields') {
        $post = get_post($post_id);
//        var_dump($post);
        $open_tag = '<ul class="empty-fields-true">';
        $fields = '';
        $close_tag = '</ul>';
        // Название
        if (!$post->post_title) {
            $fields .= '<li>Название</li>';
        }
        // Рубрика
        $cat = get_the_category($post_id);
        if ($cat[0]->name == 'Без рубрики') {
            $fields .= '<li>Без рубрики</li>';
        }
        // Метки
        $tag = get_tags_to_edit($post_id);
        if (!$tag) {
            $fields .= '<li>Метки</li>';
        }

        // Текст
        if (!$post->post_content) {
            $fields .= '<li>Текст статьи</li>';
        }

        $custom_fields = get_field_objects($post_id);
//        var_dump($custom_fields);
        if ($custom_fields) {
            foreach ($custom_fields as $key => $value) {
                if (!empty($key) && empty($value['value'])) {
                    $fields .= '<li>' . $value['label'] . '</li>';
                }
            }
        }

        if (empty($fields)) {
            $info = '<span class="empty-fields-false">Все поля заполнены</span>';
        } else {
            $info = $open_tag . $fields . $close_tag;
        }

        print ($info);
    }
}

// Register the column as sortable
function status_column_register_sortable($columns) {
    $columns['post-status'] = 'Статус';

    return $columns;
}

add_filter('manage_edit-post_sortable_columns', 'status_column_register_sortable');

function status_column_orderby($vars) {
    if (isset($vars['orderby']) && 'post-status' == $vars['orderby']) {
        $vars = array_merge($vars, array(
            'meta_key' => 'post-status',
            'orderby' => 'meta_value_num'
        ));
    }

    return $vars;
}

add_filter('request', 'status_column_orderby');


