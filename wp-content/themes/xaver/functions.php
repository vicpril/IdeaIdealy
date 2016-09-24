<?php

/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
//update_option('siteurl', 'http://ideaidealy.loc');
//update_option('home', 'http://ideaidealy.loc');
// update_option ('siteurl', 'http://ideaidealy.ru');
// update_option ('home', 'http://ideaidealy.ru');

//activate_plugin('polylang/polylang.php');

if (is_plugin_active('polylang/polylang.php')) {
    
    require_once 'string-translate.php';

    define('LANG', pll_current_language());

}
//remove_filter('pre_user_description', 'wp_filter_kses');  
//add_filter( 'pre_user_description', 'wp_filter_post_kses' ); 

function register_xaver_menus() {
    register_nav_menus(array(
        'top-menu' => __('Top Menu', 'xaver'),
    ));
}

add_action('init', 'register_xaver_menus');


automatic_feed_links();

if (function_exists('register_sidebar'))
    register_sidebar(array(
        'before_widget' => '<div id="%1$s" class="right-box ukazatel">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));

function register_scripts() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory() . '/js/jquery.js', array(), '1.11.1', true);

    // Enqueue_scripts
    wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'register_scripts');

//authors
function wp_list_authors2($args = '') {
    global $wpdb;
    

    $defaults = array(
        'optioncount' => false, 'exclude_admin' => true,
        'show_fullname' => false, 'hide_empty' => true,
        'feed' => '', 'feed_image' => '', 'feed_type' => '', 'echo' => true,
        'style' => 'list', 'html' => true
    );

    $r = wp_parse_args($args, $defaults);
    extract($r, EXTR_SKIP);
    $return = '';

    /** @todo Move select to get_authors().

      SELECT ID, user_nicename,meta_value,meta_key from wp_users left join wp_usermeta on (wp_usermeta.user_id=wp_users.ID) WHERE meta_key='first_name' and user_login <> 'admin' ORDER BY display_name

     */
    $authors = $wpdb->get_results("SELECT ID, user_nicename,meta_value,meta_key from $wpdb->users left join $wpdb->usermeta on ($wpdb->usermeta.user_id=$wpdb->users.ID)
	" . ($exclude_admin ? "WHERE user_login <> 'admin' and " : '') . " meta_key='first_name' ORDER BY meta_value ASC ");

    $author_count = array();
    foreach ((array) $wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type = 'post' AND " . get_private_posts_cap_sql('post') . " GROUP BY post_author") as $row) {
        $author_count[$row->post_author] = $row->count;
    }

    foreach ((array) $authors as $author) {

        $link = '';

        $author = get_userdata($author->ID);
        $posts = (isset($author_count[$author->ID])) ? $author_count[$author->ID] : 0;
//        $name = $author->display_name;

        //if ( $show_fullname && ($author->first_name != '' && $author->last_name != '') )
//        $name = "$author->first_name $author->last_name";
        $name = get_user_meta($author->ID, 'us_last-name', true) . " $author->us_initials";

        if (!$html) {
            if ($posts == 0) {
                if (!$hide_empty)
                    $return .= $name . ', ';
            } else
                $return .= $name . ', ';

            // No need to go further to process HTML.
            continue;
        }

        if (!($posts == 0 && $hide_empty) && 'list' == $style)
            $return .= '<li>';
        if ($posts == 0) {
            if (!$hide_empty)
                $link = '<a href="/author/' . $author->user_nicename . '" title="' . $author->first_name . '">' . $name . '</a>';
        } else {
            $link = '<a href="' . get_author_posts_url($author->ID, $author->user_nicename) . '" title="' . esc_attr(sprintf(__("Posts by %s"), $author->display_name)) . '">' . $name . '</a>';
        }

        if (!($posts == 0 && $hide_empty) && 'list' == $style)
            $return .= $link . '</li>';
        else if (!$hide_empty)
            $return .= $link . ', ';
    }

    $return = trim($return, ', ');

    if (!$echo)
        return $return;
    echo $return;
}


//authors EN
function wp_list_authors2_en($args = '') {
    global $wpdb;
    

    $defaults = array(
        'optioncount' => false, 'exclude_admin' => true,
        'show_fullname' => false, 'hide_empty' => true,
        'feed' => '', 'feed_image' => '', 'feed_type' => '', 'echo' => true,
        'style' => 'list', 'html' => true
    );

    $r = wp_parse_args($args, $defaults);
    extract($r, EXTR_SKIP);
    $return = '';

    /** @todo Move select to get_authors().

      SELECT ID, user_nicename,meta_value,meta_key from wp_users left join wp_usermeta on (wp_usermeta.user_id=wp_users.ID) WHERE meta_key='first_name' and user_login <> 'admin' ORDER BY display_name

     */
    $authors = $wpdb->get_results("SELECT ID, user_nicename,meta_value,meta_key from $wpdb->users left join $wpdb->usermeta on ($wpdb->usermeta.user_id=$wpdb->users.ID)
	" . ($exclude_admin ? "WHERE user_login <> 'admin' and " : '') . " meta_key='first_name' ORDER BY meta_value ASC ");

    $author_count = array();
    foreach ((array) $wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type = 'post' AND " . get_private_posts_cap_sql('post') . " GROUP BY post_author") as $row) {
        $author_count[$row->post_author] = $row->count;
    }

    foreach ((array) $authors as $author) {

        $link = '';

        $author = get_userdata($author->ID);
        $posts = (isset($author_count[$author->ID])) ? $author_count[$author->ID] : 0;
//        $name = $author->display_name;

        //if ( $show_fullname && ($author->first_name != '' && $author->last_name != '') )
//        $name = "$author->first_name $author->last_name";
        $name = get_user_meta($author->ID, 'us_name_en', true) . " $author->us_initials_en";

        if (!$html) {
            if ($posts == 0) {
                if (!$hide_empty)
                    $return .= $name . ', ';
            } else
                $return .= $name . ', ';

            // No need to go further to process HTML.
            continue;
        }

        if (!($posts == 0 && $hide_empty) && 'list' == $style)
            $return .= '<li>';
        if ($posts == 0) {
            if (!$hide_empty)
                $link = '<a href="author/' . $author->user_nicename . '" title="' . $author->nickname . '">' . $name . '</a>';
        } else {
            $link = '<a href="' . get_author_posts_url($author->ID, $author->user_nicename) . '" title="' . esc_attr(sprintf(__("Posts by %s"), $author->nickname)) . '">' . $name . '</a>';
        }

        if (!($posts == 0 && $hide_empty) && 'list' == $style)
            $return .= $link . '</li>';
        else if (!$hide_empty)
            $return .= $link . ', ';
    }

    $return = trim($return, ', ');

    if (!$echo)
        return $return;
    echo $return;
}

function new_excerpt_length($length) {
    return 0;
}

add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more($more) {
    return '';
}

add_filter('excerpt_more', 'new_excerpt_more');

// redirect after add new user
add_filter('wp_redirect', 'wp_redirect_after_user_new', 1, 1);

function wp_redirect_after_user_new($location) {
    global $pagenow;

    if (is_admin() && 'user-new.php' == $pagenow) {
        $user_details = get_user_by('email', $_REQUEST['email']);
        $user_id = $user_details->ID;

        if ($location == 'users.php?update=add&id=' . $user_id)
            return add_query_arg(array('user_id' => $user_id), 'user-edit.php');
    }

    return $location;
}

//require_once 'lib/index.php';

/*
 * functions for export
 */

if (!function_exists('get_array_authors_by_post')) {

    function get_array_authors_by_post($postID) {
        global $wpdb;

        $authors = get_post_meta($postID, 'coauthor', false);

        $index = 0;
        if ($authors) {
            foreach ($authors as $author) {
                $i = get_user_by_display_name($author)->ID;
                if ($i) {
                    $users[$i] = get_author_fields($author, $index);
                } else {
//                    $users[$i] = 'no user';
                }

                $index++;
            }
        } else {
            return false;
        }


        return $users;
    }

}

//достать автора
function get_author_fields($author, $index = 0) {
    if (true) {

        $i = get_user_by_display_name($author)->ID;
        $user['index'] = $index;
        $user['email'] = get_user_by_display_name($author)->user_email;
        $user['email_host'] = explode('@', $user['email']);
        $user['email_host'] = $user['email_host'][1];
        $user['id'] = $i;
        $meta = get_user_meta($user['id']);
        $user['us_full_name'] = $meta['us_full-name'][0];
        $user['us_last_name'] = $meta['us_last-name'][0];
        $user['us_first_name'] = $meta['us_first-name'][0];
        $user['us_patronymic'] = $meta['us_patronymic'][0];
        $user['us_initials'] = $meta['us_initials'][0];
        $user['us_name_en'] = $meta['us_name_en'][0];
        $user['us_initials_en'] = $meta['us_initials_en'][0];
        $user['job_id'] = $meta['job_id'][0];
        $user['job_name'] = get_job_name($user['job_id']);
        $user['job_city'] = get_job_city($user['job_id']);
        $user['job_adress'] = get_job_adress($user['job_id']);
        $user['job_name_en'] = get_job_name_en($user['job_id']);
        $user['job_city_en'] = get_job_city_en($user['job_id']);
        $user['job_adress_en'] = get_job_adress_en($user['job_id']);
        $user['post'] = $meta['us_post'][0];

        return $user;
    } else {
        return false;
    }
}

// сортировка по имени
function cmp_by_name($a, $b) {
    return strcmp($a["us_last_name"], $b["us_last_name"]);
}

// сортировка по названию работы
function cmp_by_job($a, $b) {
    return strcmp($b["job_name"], $a["job_name"]);
}

if (!function_exists('get_array_jobs_with_users')) {

    function get_array_jobs_with_users($users) {
        $jobs = array();
        $k = 0;
        if ($users) {
            foreach ($users as $value) {
                if ($value) {
                    $jobs[$k]['job_name'] = $value['job_name'];
                    $jobs[$k]['job_city'] = $value['job_city'];
                    $jobs[$k]['job_adress'] = $value['job_adress'];
                    $jobs[$k]['job_name_en'] = $value['job_name_en'];
                    $jobs[$k]['job_city_en'] = $value['job_city_en'];
                    $jobs[$k]['job_adress_en'] = $value['job_adress_en'];

                    $jobs[$k]['id'] = $value['job_id'];
                    $k++;
                }
            }
        
        // убираем повторяющиеся значения
        $jobs = array_map("unserialize", array_unique(array_map("serialize", $jobs)));

        // сортируем в алфавитном порядке
//        if (count($jobs) > 1) {
//            usort($jobs, 'cmp_by_job');
//        }

        foreach ($jobs as $i => $job) {
            foreach ($users as $user) {
                if ($user['job_id'] == $jobs[$i]['id']) {
                    $jobs[$i]['user'][] = $user['id'];
//                    $jobs[$i]['user_name'][] = $user['us_last-name'];
                }
            }
        }
        }
        return $jobs;
    }

}
/*
 * Массив рубрик и статей для содержания
 */
if (!function_exists('get_array_cats_for_contents')) {

    function get_array_cats_for_contents($posts) {
        global $wpdb;

        $cats = array();

        if (!empty($posts)) {
            foreach ($posts as $post_id) {
                $category = get_the_category($post_id);
                $authors = get_post_meta($post_id, 'coauthor', false);
//                    $index = 0;
                foreach ($authors as $author) {
                    $user_id = get_user_by_display_name($author)->ID;
                    if ($user_id != null) {
                        $cats[$category[0]->name][$post_id]['users'][] = get_author_fields($author);
                    }
                }
                $post = get_post($post_id);
                
                $title = mb_ucfirst(mb_strtolower($post->post_title, 'UTF-8'));
                
                $cats[$category[0]->name][$post_id]['title'] = $title;
                
                // stol toggle
                if (array_pop(get_post_custom_values('stol', $post_id)) !== 'yes') {
                    $cats[$category[0]->name][$post_id]['stol'] = false;
                }else{
                    $cats[$category[0]->name][$post_id]['stol'] = true;
                }
            }
        }
        return $cats;
    }

}


function mb_ucfirst($text) {
    mb_internal_encoding("UTF-8");
    return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
}

if (!function_exists('get_array_cats_en_for_contents')) {

    function get_array_cats_en_for_contents($posts) {
        global $wpdb;

        $cats = array();

        if (!empty($posts)) {
            foreach ($posts as $post_id) {
                $category = get_field('cat_en', $post_id);
                $authors = get_post_meta($post_id, 'coauthor', false);
//                    $index = 0;
                foreach ($authors as $author) {
                    $user_id = get_user_by_display_name($author)->ID;
                    if ($user_id != null) {
                        $cats[$category][$post_id]['users'][] = get_author_fields($author);
                    }
                }
                $post = get_post($post_id);
                
                $title = ucfirst(strtolower(get_field('title_en', $post_id)));
                $cats[$category][$post_id]['title'] = $title;
                
                // stol toggle
                if (array_pop(get_post_custom_values('stol', $post_id)) !== 'yes') {
                    $cats[$category][$post_id]['stol'] = false;
                }else{
                    $cats[$category][$post_id]['stol'] = true;
                }
            }
        }
        return $cats;
    }

}


/*
 * Get User from DB by "display_name"
 * 
 * Returns: WP_User object on success, false on failure.
 * 
 */
if (!function_exists('get_user_by_display_name')) {

    function get_user_by_display_name($display_name) {
        global $wpdb;

        $value = trim($display_name);

        if (!$userdata = $wpdb->get_row($wpdb->prepare(
                        "SELECT * FROM $wpdb->users WHERE display_name = %s", $value
                ))) {
            return false;
        }

        update_user_caches($userdata);

        $user = new WP_User;

        $user->init($userdata);

        return $user;
    }

}

require_once 'hide-menus.php';
?>