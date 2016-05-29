<?php
/*
Plugin Name: Post sorting
Plugin URI: http://postmashfiltered.wordpress.com/2009/06/19/post-mash-filtered/
Description: postMash > Order Posts. Allow admin panel to filter by category/date. Allow Next/Previous posts by postMash order. Based on <a href="http://joelstarnes.co.uk" >Joel Starnes</a> postMash
Author: Selwyn Nogood
Version: 1.2.1
Author URI: http://postmashfiltered.wordpress.com

*/
#########CONFIG OPTIONS############################################
$minlevel = 7;  /*[deafult=7]*/
/* Minimum user level to access page order */

$switchDraftToPublishFeature = true;  /*[deafult=true]*/
/* Allows you to set pages not to be listed */

$ShowDegubInfo = false;  /*[deafult=false]*/
/* Show server response debug info */

###################################################################
/*
INSPIRATIONS/CREDITS:
Joel Starnes - This plugin is a modification of Joel Starnes great postMash plugin [http://joelstarnes.co.uk/postMash/]
Valerio Proietti - Mootools JS Framework [http://mootools.net/]
Stefan Lange-Hegermann - Mootools AJAX timeout class extension [http://www.blackmac.de/archives/44-Mootools-AJAX-timeout.html]
vladimir - Mootools Sortables class extension [http://vladimir.akilles.cl/scripts/sortables/]
ShiftThis - WP Page Order Plugin [http://www.shiftthis.net/wordpress-order-pages-plugin/]
Garrett Murphey - Page Link Manager [http://gmurphey.com/2006/10/05/wordpress-plugin-page-link-manager/]
*/

/*  Copyright 2008  Selwyn Nogood  (email : editor@kiwianarama.co.nz)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Pre-2.6 compatibility
if ( !defined('WP_CONTENT_URL') )
	define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if ( !defined('WP_CONTENT_DIR') )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
// Guess the location
$codeWord_path = WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__));
$postMash_url = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__));

function postMash_getPages(){
	global $wpdb, $wp_version, $switchDraftToPublishFeature;

	//get pages from database
	$date = $_GET['m'];
	$mmonth = substr($date, -2);
	$yyear = substr($date, 0, 4);
	$query_post .= "SELECT DISTINCT * FROM $wpdb->posts JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id) ";
	if (isset($_GET['cat']) && $_GET['cat'] != '0'){
									$query_post .=	"INNER JOIN $wpdb->term_relationships ON($wpdb->posts.ID = $wpdb->term_relationships.object_id)
													INNER JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
													WHERE $wpdb->term_taxonomy.term_id = " . $_GET['cat'] ;

$query_post.=" AND CASE meta_key
	WHEN 'tom' THEN meta_value = '".$_GET['tom']."'

	WHEN 'yearno' THEN meta_value = '".$_GET['yearno']."'

	WHEN 'no' THEN meta_value = '".$_GET['no']."'
	END GROUP BY wp_posts.ID HAVING COUNT(*) = 3 ";

									$query_post .=	" AND $wpdb->posts.post_type = 'post' ORDER BY menu_order ";
					}
	else {
	$query_post .= "WHERE post_type = 'post'";

	$query_post.=" AND CASE meta_key
	WHEN 'tom' THEN meta_value = '".$_GET['tom']."'

	WHEN 'yearno' THEN meta_value = '".$_GET['yearno']."'

	WHEN 'no' THEN meta_value = '".$_GET['no']."'
	END GROUP BY wp_posts.ID HAVING COUNT(*) = 3 ";

	if (isset($_GET['m']) && $_GET['m'] != '0') {$query_post .= " AND YEAR(post_date) = " . $yyear ." AND MONTH(post_date) = " . $mmonth ;}
	$query_post .= " ORDER BY menu_order " ;}

	$pageposts = $wpdb->get_results("$query_post");
              //echo $query_post;
	if ($pageposts == true){
		echo '<ul id="postMash_pages">';
		foreach ($pageposts as $page): //list pages, [the 'li' ID must be pm_'page ID'] ?>
			<li id="pm_<?php echo $page->ID; ?>"<?php if($page->post_status == "draft"){ echo ' class="remove"'; } //if page is draft, add class remove ?>>
				<span style="float:right;">
				<?php
			$tags = get_the_category($page->ID);
			if ( !empty( $tags ) ) {
				$out = array();
				foreach ( $tags as $c )
					$out[] = wp_specialchars(sanitize_term_field('cat_name', $c->cat_name, $c->term_id, 'post_tag', 'display'));
				echo join( ', ', $out );
			} else {
				_e('');
			} ?></span><span class="title"><?php echo $page->post_title;?></span>
				<span class="postMash_box">
					<span class="postMash_more">&raquo;</span>
					<span class="postMash_pageFunctions">
						id:<?php echo $page->ID;?>
						[<a href="<?php echo get_bloginfo('wpurl').'/wp-admin/post.php?action=edit&post='.$page->ID; ?>" title="Редактировать запись">редактировать</a>]
						<?php if($switchDraftToPublishFeature): ?>
							<!--[<a href="#" title="Draft|Publish" class="excludeLink" onclick="toggleRemove(this); return false">toggle-draft</a>]-->
						<?php endif; ?>
					</span>
				</span>
			</li>
		<?php endforeach;
		echo '</ul>';
		return true;
	} else {
		echo '<h3 style="margin-top:30px;" >Извините, подходящих запросу записей не найдено!</h3>';
		return false;

	}

}

function postMash_main(){
	global $switchDraftToPublishFeature, $ShowDegubInfo;
	?>
	<div id="debug_list"<?php if(false==$ShowDegubInfo) echo' style="display:none;"'; ?>></div>
	<div id="postMash" class="wrap">
		<div id="postMash_checkVersion" style="float:right; font-size:.7em; margin-top:5px;">
		    version 1.1.0
		</div>
		<h2 style="margin-bottom:0; clear:none;">Сортировка записей</h2>
		<p style="margin-top:4px;">
			Просто перетащите записи <strong>вверх</strong> или <strong>вниз</strong>, чтобы изменить их порядок в конкретном номере.
		</p><p>
					<div class="alignleft actions">

			<?php // view filters
			if ( !is_singular() ) {
			global $wpdb, $wp_locale;



			?>
			<form action="" method="get" enctype="multipart/form-data">
			<input type="hidden" name="page" value="postmash-filtered/postMash.php"  />

			Год: <input name="yearno" type="text" value="<?=$_GET['yearno']?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Номер:<input name="no" type="text" value="<?=$_GET['no']?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Том:<input name="tom" type="text" value="<?=$_GET['tom']?>">
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

		<?php postMash_getPages(); ?>

		<p class="submit">
			<div id="update_status" style="float:left; margin-left:40px; opacity:0;"></div>
				<input type="submit" id="postMash_submit" tabindex="2" style="font-weight: bold; float:right;" value="Сохранить сортировку" name="submit"/>
		</p>
		<br style="margin-bottom: .8em;" />
	</div>

	<!--<div class="wrap" style="width:160px; margin-bottom:0; padding:0;"><p><a href="#" id="postMashInfo_toggle">Show|Hide Further Info</a></p></div>
	<div class="wrap" id="postMashInfo" style="margin-top:-1px;">
		<h2>How to Use</h2>
		<p>In order to make use of postMash, you need to order your posts by "menu_order". Like this...</p>
		<p style="margin-bottom:0; font-weight:bold;">Code:</p>
		<code id="postMash_code"><span class="white">
			&lt;?php $readposts = get_posts(&#x27;orderby=menu_order&#x27;); ?&gt;<br />
			&lt;ul&gt;<br />
			&lt;?php foreach($readposts as $post) : setup_postdata($post); ?&gt;<br />
				&lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;?php the_title(); ?&gt;&lt;/a&gt;&lt;/li&gt;<br />
			&lt;?php endforeach; ?&gt;<br />
			&lt;/ul&gt;
		</span></code>
		<p><a href="http://postmashfiltered.wordpress.com/">Homepage </a></p>

		<br />
	</div>  -->
	<?php
}

function postMash_head(){
	//stylesheet & javascript to go in page header
	global $postMash_url;

	wp_enqueue_script('postMash_mootools', $postMash_url.'/nest-mootools.v1.11.js', false, false); //code is not compatible with other releases of moo
	wp_deregister_script('prototype');//remove prototype since it is incompatible with mootools
	wp_enqueue_script('postMash', $postMash_url.'/postMash.js', array('postMash_mootools'), false);
	add_action('admin_head', 'postMash_add_css', 1);

}

function postMash_add_css(){
	global $postMash_url;
	printf('<link rel="stylesheet" type="text/css" href="%s/postMash.css" />', $postMash_url);
	?>
<!-- BASED ON
	                    __  __           _
      WordPress Plugin |  \/  |         | |
  _ __  __ _  __ _  ___| \  / | __ _ ___| |__
 | '_ \/ _` |/ _` |/ _ \ |\/| |/ _` / __| '_ \
 | |_)  (_| | (_| |  __/ |  | | (_| \__ \ | | |
 | .__/\__,_|\__, |\___|_|  |_|\__,_|___/_| |_|
 | |          __/ |  Author: Joel Starnes
 |_|         |___/   URL: joelstarnes.co.uk

 >>postMash Admin Page
-->
	<?php
}

function postMash_add_pages(){
	//add menu link
	global $minlevel, $wp_version;
	if($wp_version >= 2.7){
		$page = add_submenu_page('edit.php', 'postMash: Order Posts', 'postMash', $minlevel,  __FILE__, 'postMash_main');
	}else{
		$page = add_management_page('postMash: Order Posts', 'postMash', $minlevel, __FILE__, 'postMash_main');
	}
	add_action("admin_print_scripts-$page", 'postMash_head'); //add css styles and JS code to head
}

add_action('admin_menu', 'postMash_add_pages'); //add admin menu under management tab

/**
 * Modifications to allow Next/Previous Post Link by menu_order using postMash plugin.
*/
function get_previous_post_menu($in_same_cat = false, $excluded_categories = '') {
	return get_adjacent_post_menu($in_same_cat, $excluded_categories);
}


function get_next_post_menu($in_same_cat = false, $excluded_categories = '') {
	return get_adjacent_post_menu($in_same_cat, $excluded_categories, false);
}

function previous_post_link_menu($format='&laquo; %link', $link='%title', $in_same_cat = true, $excluded_categories = '') {
	adjacent_post_link_menu($format, $link, $in_same_cat, $excluded_categories, false);
}

function next_post_link_menu($format='%link &raquo;', $link='%title', $in_same_cat = true, $excluded_categories = '') {
	adjacent_post_link_menu($format, $link, $in_same_cat, $excluded_categories, true);
}

function get_adjacent_post_menu($in_same_cat = false, $excluded_categories = '', $previous = true) {
	global $post, $wpdb;

	if( empty($post) || !is_single() || is_attachment() )
		return null;

	$current_post_date = $post->post_date;
	$current_menu_order = $post->menu_order;
	$join = '';
	$posts_in_ex_cats_sql = '';
	if ( $in_same_cat || !empty($excluded_categories) ) {
		$join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";

		if ( $in_same_cat ) {
			$cat_array = wp_get_object_terms($post->ID, 'category', 'fields=ids');
			$join .= " AND tt.taxonomy = 'category' AND tt.term_id IN (" . implode(',', $cat_array) . ")";
		}

		$posts_in_ex_cats_sql = "AND tt.taxonomy = 'category'";
		if ( !empty($excluded_categories) ) {
			$excluded_categories = array_map('intval', explode(' and ', $excluded_categories));
			if ( !empty($cat_array) ) {
				$excluded_categories = array_diff($excluded_categories, $cat_array);
				$posts_in_ex_cats_sql = '';
			}

			if ( !empty($excluded_categories) ) {
				$posts_in_ex_cats_sql = " AND tt.taxonomy = 'category' AND tt.term_id NOT IN (" . implode($excluded_categories, ',') . ')';
			}
		}
	}

	$adjacent = $previous ? 'previous' : 'next';
	$op = $previous ? '<' : '>';
	$order = $previous ? 'DESC' : 'ASC';

	$join  = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_cat, $excluded_categories );
	$where = apply_filters( "get_{$adjacent}_post_where", $wpdb->prepare("WHERE p.menu_order $op %s AND p.post_type = 'post' AND p.post_status = 'publish' $posts_in_ex_cats_sql", $current_menu_order), $in_same_cat, $excluded_categories );
	$sort  = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.menu_order $order LIMIT 1" );

	return $wpdb->get_row("SELECT p.* FROM $wpdb->posts AS p $join $where $sort");
}

function adjacent_post_link_menu($format, $link, $in_same_cat = false, $excluded_categories = '', $previous = true) {
	if ( $previous && is_attachment() )
		$post = & get_post($GLOBALS['post']->post_parent);
	else
		$post = get_adjacent_post_menu($in_same_cat, $excluded_categories, $previous);

	if ( !$post )
		return;

	$title = $post->post_title;

	if ( empty($post->post_title) )
		$title = $previous ? __('Previous Post') : __('Next Post');

	$title = apply_filters('the_title', $title, $post);
	$date = mysql2date(get_option('date_format'), $post->post_date);

	$string = '<a href="'.get_permalink($post).'">';
	$link = str_replace('%title', $title, $link);
	$link = str_replace('%date', $date, $link);
	$link = $string . $link . '</a>';

	$format = str_replace('%link', $link, $format);

	$adjacent = $previous ? 'previous' : 'next';
	echo apply_filters( "{$adjacent}_post_link", $format, $link );
}

?>