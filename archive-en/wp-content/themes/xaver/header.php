<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>


<head>
	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<BASE HREF="<?php bloginfo('url'); ?>">
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
    <a href="<?php site_url(''); ?>/en" title="<?php bloginfo('name'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/logo.jpg" alt="<?php bloginfo('name'); ?>" class="logo" /></a>
<span class="header-archive">English Archive</span>
<ul class="lang">
<li class="rus"><a href="/" title="Русский">Русский</a></li>
<li class="eng"><a href="/en" title="English">English</a></li>
</ul>
</div>
</div>

<div class="navigation">
<ul class="over">
<?php menusplus(1); ?>
</ul>
</div>

<div class="content over">

<?php get_sidebar(); ?>



<div class="left-side">
<!-- end header -->
<?php show_content();?>