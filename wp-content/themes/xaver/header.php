<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>


<head>
	<title><?php 
        if (LANG == 'ru') {
            wp_title('&laquo;', true, 'right');
            bloginfo('name'); 
        } else {
    
            // If there's an author
            if ( is_author() && ! is_post_type_archive() ) {
                $author = get_queried_object();
                if ( $author ) {
                    $title = $author->us_name_en . " " . $author->us_initials_en . ' &laquo; ';
                    echo $title;
                }
            } else {
                wp_title('&laquo;', true, 'right'); 
            }
            
            bloginfo('name'); 
        
        }
        ?>
    
    </title>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>
	<?php wp_head(); ?>
</head>

<body>


<div class="main">

<div class="header-chashka">
</div>

<div class="header">
<div class="header-bg">
    <?php 
    if (LANG == 'ru') {
        $logo = '/images/logo.jpg';
    } else {
        $logo = '/images/logo_en.jpg';
    }
    ?>
<a href="<?php bloginfo('siteurl'); ?>/" title="<?php bloginfo('name'); ?>"><img src="<?php bloginfo('template_directory'); ?><?=$logo?>" alt="<?php bloginfo('name'); ?>" class="logo" /></a>
<ul class="lang">
<li class="rus"><a href="/" title="Русский">Русский</a></li>
<li class="eng"><a href="/en" title="English">English</a></li><!--
</ul>-->
</div>
</div>

<div class="navigation">
   <?php
        wp_nav_menu(array(
            'theme-location' => 'top-menu',
            'menu_class' => 'over',
        ));
    ?>   
    
<!--<ul class="over">

</ul>--></div>

<div class="content over">

<?php get_sidebar(); ?>



<div class="left-side">
<!-- end header -->

