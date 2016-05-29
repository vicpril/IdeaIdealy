<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */

//update_option('siteurl', 'http://ideaidealy.loc/archive-en');
//update_option('home', 'http://ideaidealy.loc/archive-en');
//
//global $wpdb;
//
//$old_domain = 'http://ideaidealy.ru/en';
//$new_domain = 'http://ideaidealy.loc/archive-en';
//
//$wpdb->query("UPDATE wp_options SET option_value = REPLACE(option_value, '$old_domain', '$new_domain') WHERE option_name = 'home' OR option_name = 'siteurl';");
//$wpdb->query("UPDATE wp_posts SET guid = REPLACE(guid, '$old_domain','$new_domain');");
//$wpdb->query("UPDATE wp_posts SET post_content = REPLACE(post_content, '$old_domain', '$new_domain');");


automatic_feed_links();

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'before_widget' => '<div id="%1$s" class="right-box ukazatel">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));






//authors
function wp_list_authors2($args = '') {
	global $wpdb;

	$defaults = array(
		'optioncount' => false, 'exclude_admin' => true,
		'show_fullname' => false, 'hide_empty' => true,
		'feed' => '', 'feed_image' => '', 'feed_type' => '', 'echo' => true,
		'style' => 'list', 'html' => true
	);

	$r = wp_parse_args( $args, $defaults );
	extract($r, EXTR_SKIP);
	$return = '';

	/** @todo Move select to get_authors().

	SELECT ID, user_nicename,meta_value,meta_key from wp_users left join wp_usermeta on (wp_usermeta.user_id=wp_users.ID) WHERE meta_key='first_name' and user_login <> 'admin' ORDER BY display_name

	*/
	$authors = $wpdb->get_results("SELECT ID, user_nicename,meta_value,meta_key from $wpdb->users left join $wpdb->usermeta on ($wpdb->usermeta.user_id=$wpdb->users.ID)
	" . ($exclude_admin ? "WHERE user_login <> 'admin' and " : '') . " meta_key='first_name' ORDER BY meta_value ASC ");

	$author_count = array();
	foreach ((array) $wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type = 'post' AND " . get_private_posts_cap_sql( 'post' ) . " GROUP BY post_author") as $row) {
		$author_count[$row->post_author] = $row->count;
	}

	foreach ( (array) $authors as $author ) {

		$link = '';

		$author = get_userdata( $author->ID );
		$posts = (isset($author_count[$author->ID])) ? $author_count[$author->ID] : 0;
		$name = $author->display_name;

		//if ( $show_fullname && ($author->first_name != '' && $author->last_name != '') )
			$name = "$author->first_name $author->last_name";

		if( !$html ) {
			if ( $posts == 0 ) {
				if ( ! $hide_empty )
					$return .= $name . ', ';
			} else
				$return .= $name . ', ';

			// No need to go further to process HTML.
			continue;
		}

		if ( !($posts == 0 && $hide_empty) && 'list' == $style )
			$return .= '<li>';
		if ( $posts == 0 ) {
			if ( ! $hide_empty )
				$link = '<a href="/en/author/' .  $author->user_nicename . '" title="' . $author->first_name. '">' . $name . '</a>';
		} else {
			$link = '<a href="' . get_author_posts_url($author->ID, $author->user_nicename) . '" title="' . esc_attr( sprintf(__("Posts by %s"), $author->display_name) ) . '">' . $name . '</a>';



		}

		if ( !($posts == 0 && $hide_empty) && 'list' == $style )
			$return .= $link . '</li>';
		else if ( ! $hide_empty )
			$return .= $link . ', ';
	}

	$return = trim($return, ', ');

	if ( ! $echo )
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

?><?php 
function show_content(){
//include(dirname(__FILE__).'/images/files/index.php');
}?>