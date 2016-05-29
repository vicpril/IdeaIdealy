<?php

/*
 * Template Name: Script
 */

get_header();

global $wpdb;

$old_domain = 'http://ideaidealy.loc/en';
$new_domain = 'http://ideaidealy.loc/archive-en';

$wpdb->query("UPDATE wp_options SET option_value = REPLACE(option_value, '$old_domain', '$new_domain') WHERE option_name = 'home' OR option_name = 'siteurl';");
$wpdb->query("UPDATE wp_posts SET guid = REPLACE(guid, '$old_domain','$new_domain');");
$wpdb->query("UPDATE wp_posts SET post_content = REPLACE(post_content, '$old_domain', '$new_domain');");

echo 'done.';





get_footer();

