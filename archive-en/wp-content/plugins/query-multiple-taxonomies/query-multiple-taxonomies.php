<?php
/*
Plugin Name: Query Multiple Taxonomies
Version: 1.1.1
Description: Filter posts through multiple custom taxonomies
Author: scribu
Author URI: http://scribu.net
Plugin URI: http://scribu.net/wordpress/query-multiple-taxonomies/
*/

class QMT_Core {

	private static $post_ids = array();
	private static $actual_query = array();
	private static $url = '';

	function init() {
		add_action('init', array(__CLASS__, 'builtin_tax_fix'));

		add_action('parse_query', array(__CLASS__, 'query'));
		
		add_action('template_redirect', array(__CLASS__, 'template'));
		add_filter('wp_title', array(__CLASS__, 'set_title'), 10, 3);

		remove_action('template_redirect', 'redirect_canonical');
	}

	function get_actual_query() {
		return self::$actual_query;
	}

	function get_canonical_url() {
		return self::$url;
	}

	function template() {
		if ( is_multitax() && $template = locate_template(array('multitax.php')) ) {
			include $template;
			die;
		}
	}

	function set_title($title, $sep, $seplocation = '') {
		if ( !is_multitax() )
			return $title;

		$newtitle[] = self::get_title();
		$newtitle[] = " $sep ";

		if ( ! empty($title) )
			$newtitle[] = $title;

		if ( 'right' != $seplocation )
			$newtitle = array_reverse($newtitle);

		return implode('', $newtitle);
	}

	function get_title() {
		$title = array();
		foreach ( self::$actual_query as $tax => $value ) {
			$key = get_taxonomy($tax)->label;
			$value = explode('+', $value);
			foreach ( $value as &$slug )
				$slug = get_term_by('slug', $slug, $tax)->name;
			$value = implode('+', $value);

			$title[] .= "$key: $value";
		}

		return implode('; ', $title);
	}

	function builtin_tax_fix() {
		$tmp = array(
			'post_tag' => 'tag',
			'category' => 'category_name'
		);

		foreach ( get_taxonomies(array('_builtin' => true), 'object') as $taxname => $taxobj )
			if ( isset($tmp[$taxname]) )
				$taxobj->query_var = $tmp[$taxname];
	}

	function query($wp_query) {
		self::$url = get_bloginfo('url');

		$post_type = apply_filters('qmt_post_type', 'post');

		$query = array();
		foreach ( get_object_taxonomies($post_type) as $taxname ) {
			$taxobj = get_taxonomy($taxname);

			if ( ! $qv = $taxobj->query_var )
				continue;

			if ( ! $value = $wp_query->get($qv) )
				continue;

			self::$actual_query[$taxname] = $value;
			self::$url = add_query_arg($qv, $value, self::$url);

			foreach ( explode(' ', $value) as $slug )
				$query[] = array($slug, $taxname);
		}

		if ( empty($query) )
			return;

		if ( ! self::find_posts($query, $post_type) )
			return $wp_query->set_404();


		$is_feed = $wp_query->is_feed;
		$paged = $wp_query->get('paged');

		$wp_query->init_query_flags();

		$wp_query->is_feed = $is_feed;
		$wp_query->set('paged', $paged);

		$wp_query->set('post_type', $post_type);
		$wp_query->set('post__in', self::$post_ids);

		$wp_query->is_multitax = true;
		$wp_query->is_archive = true;
	}

	private function find_posts($query, $post_type) {
		global $wpdb;

		// get an initial set of ids, to intersect with the others
		if ( ! $ids = self::get_objects(array_shift($query)) )
			return false;

		foreach ( $query as $qv ) {
			if ( ! $posts = self::get_objects($qv) )
				return false;

			$ids = array_intersect($ids, $posts);
		}

		if ( empty($ids) )
			return false;

		// select only published posts
		$post_type = esc_sql($post_type);
		$ids = $wpdb->get_col("
			SELECT ID FROM $wpdb->posts 
			WHERE post_type = '$post_type'
			AND post_status = 'publish' 
			AND ID IN (" . implode(',', $ids). ")
		");

		if ( empty($ids) )
			return false;

		self::$post_ids = $ids;

		return true;
	}

	private function get_objects($qv) {

		list($term_slug, $tax) = $qv;

		if ( ! $term = get_term_by('slug', $term_slug, $tax) )
			return false;

		$terms = array($term->term_id);
		
		$terms = array_merge($terms, get_term_children($term->term_id, $tax));

		$ids = get_objects_in_term($terms, $tax);

		if ( empty($ids) )
			return false;

		return $ids;
	}

	function get_terms($tax) {
		if ( empty(self::$post_ids) )
			return get_terms($tax);

		global $wpdb;

		$query = $wpdb->prepare("
			SELECT DISTINCT term_id
			FROM $wpdb->term_relationships
			JOIN $wpdb->term_taxonomy USING (term_taxonomy_id)
			WHERE taxonomy = %s
			AND object_id IN (" . implode(',', self::$post_ids) . ")
		", $tax);

		$term_ids = $wpdb->get_col($query);

		return get_terms($tax, array('include' => implode(',', $term_ids)));
	}
	
	public function get_url($key, $value, $base = '') {
		if ( empty($base) )
			$base = self::$url;

		if ( empty($value) )
			return remove_query_arg($key, $base);

		$value = trim(implode('+', $value), '+');

		return add_query_arg($key, $value, $base);
	}
}

// WP < 3.0
if ( ! function_exists('get_taxonomies') ) :
function get_taxonomies( $args = array(), $output = 'names' ) {
	global $wp_taxonomies;

	$taxonomies = array();
	foreach ( (array) $wp_taxonomies as $taxname => $taxobj )
		if ( empty($args) || array_intersect_assoc((array) $taxobj, $args) )
			$taxonomies[$taxname] = $taxobj;

	if ( 'names' == $output )
		return array_keys($taxonomies);

	return $taxonomies;
}
endif;


function _qmt_init() {
	include dirname(__FILE__) . '/scb/load.php';

	include dirname(__FILE__) . '/template-tags.php';
	include dirname(__FILE__) . '/widget.php';

	// Load translations
	load_plugin_textdomain('taxonomy-drill-down', '', basename(dirname(__FILE__)) . '/lang');

	QMT_Core::init();

	scbWidget::init('Taxonomy_Drill_Down_Widget', __FILE__, 'taxonomy-drill-down');
}
_qmt_init();

