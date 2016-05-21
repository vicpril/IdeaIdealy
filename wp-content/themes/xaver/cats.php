<?php

/*
  Template Name: cats-edit
 */

//var_dump(get_template_directory());




$filename = get_template_directory() . '/Cats.txt';

//var_dump($filename);
//die();

$file = file($filename);

$get = array();

foreach ($file as $value) {
    $get[] = explode(';', $value);
}

$cats = array();

foreach ($get as $value) {
    $cats[trim($value[0])] = trim($value[1]);
}

//print_r($cats);

/////////////////////////

    $i = 0;
    $edit = 0;
foreach ($cats as $key => $value) {
    $term = get_term_by('name', $key, 'category');
    if ($term) {
        $i++;
    }
    $old_value = $term->description;
    
    $args = array( 'description' => $value );
    
    $success = wp_update_term($term->term_id, 'category', $args);
    
    $term = get_term_by('name', $key, 'category');
    $new_value = $term->description;
    
    if ($old_value != $new_value) {
        $edit++;
    }
    
    
//    var_dump($term);
}

echo "<br>Найдено $i рубрик из ". count($cats);
echo "<br>Обновлено $edit рубрик из ". count($cats);

$k=0;
for ($index = 0; $index < 191; $index++) {
    $term = get_term_by('id', $index, 'category');
    if ($term) {
        $k++;
    }
}

echo "<br>Всего $k рубрик";







