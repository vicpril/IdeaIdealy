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
<br><br>

    <?php 
        $cur_uri = explode('?', $_SERVER['REQUEST_URI']); 
        $page = explode('/', $cur_uri[0]);
        $page = $page[count($page)-1];
        if (isset($_GET) && isset($_GET['tom'])) $tom = $_GET['tom']; else $tom = '';
        if (isset($_GET) && isset($_GET['yearno'])) $yearno = $_GET['yearno']; else $yearno = '';
        if (isset($_GET) && isset($_GET['no'])) $no = $_GET['no']; else $no = '';
        if (isset($_GET) && isset($_GET['por'])) $por = $_GET['por']; else $por = '';
        
//var_dump($page);
    ?>

<?php switch ($page) {
    case 'nomer' :
    case 'nomer-en':
        ?>
            <ul class="lang">
                <li class="rus"><a href="/nomer?tom=<?=$tom?>&yearno=<?=$yearno?>&no=<?=$no?>&por=<?=$por?>" title="Русский"><img alt="Русский" title="Русский" src="<?=get_template_directory_uri() . '/images/ru.png'?>"><span style="margin-left:0.3em;">Русский</span></a></li>
                <li class="eng"><a href="/en/nomer-en?tom=<?=$tom?>&yearno=<?=$yearno?>&no=<?=$no?>&por=<?=$por?>" title="English"><img alt="English" title="English" src="<?=get_template_directory_uri() . '/images/us.png'?>"><span style="margin-left:0.3em;">English</span></a></li>
            </ul>
        <?php
        break;
    
    default :
        ?>
            <ul class="lang">
                <?php 
                    pll_the_languages(array('show_flags'=>1,'show_names'=>1));
                ?>
            </ul>
        <?php
        break;
        
}
?>
       
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

