<?php
/*
+----------------------------------------------------------------+
|																							|
|	WordPress 2.7 Plugin: WP-Print 2.50										|
|	Copyright (c) 2008 Lester "GaMerZ" Chan									|
|																							|
|	File Written By:																	|
|	- Lester "GaMerZ" Chan															|
|	- http://lesterchan.net															|
|																							|
|	File Information:																	|
|	- Printer Friendly Post/Page Template										|
|	- wp-content/plugins/wp-print/print-posts.php							|
|																							|
+----------------------------------------------------------------+
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>


<head>
	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<style type="text/css" media="screen">
		@import url( /wp-content/themes/xaver/style_print.css );
	</style>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>
	<?php wp_head(); ?>
</head>

<body>


<div class="main">





<div class="content over">
		<?php if (have_posts()): ?>
			<?php while (have_posts()): the_post();

//print_r($post);

			$yearno = get_post_meta($post->ID,'yearno','single');
$no = get_post_meta($post->ID,'no','single');
$tom = get_post_meta($post->ID,'tom','single');

//echo "<div class='crumbs'><a href='/archive#$yearno' title='Перейти к номерам данного года'>Журнал ".$yearno ." года</a> &raquo; <a href='/nomer?yearno=$yearno&no=$no&tom=$tom' title='Перейти к номеру журнала'>№" . $no . ", Том " . $tom."</a> &raquo; ".$cats."</div>";
			 ?>
					<br><h1><?php the_title(); ?></h1>
					<!--<p id="BlogDate"><?php _e('Posted By', 'wp-print'); ?> <u><?php the_author(); ?></u> <?php _e('On', 'wp-print'); ?> <?php the_time(sprintf(__('%s @ %s', 'wp-print'), get_option('date_format'), get_option('time_format'))); ?> <?php _e('In', 'wp-print'); ?> <?php print_categories('<u>', '</u>'); ?> | <u><a href='#comments_controls'><?php print_comments_number(); ?></a></u></p>-->
					<br><?php print_content(); ?>
			<?php endwhile; ?>

			<?php if(print_can('comments')): ?>
				<?php comments_template(); ?>
			<?php endif; ?>
			<p>Article of <?php bloginfo('name'); ?>: <strong dir="ltr"><?php bloginfo('url'); ?></strong></p>
			<p>Link to this article: <strong><a href="<?the_permalink();?>"><?php the_permalink(); ?></a></strong></p>
			<?php if(print_can('links')): ?>
				<p><?php print_links(); ?></p>
			<?php endif; ?>
			<p style="text-align: right;" id="print-link">Press <a href="#Print" onclick="window.print(); return false;" title="print!">here</a> to print this article.</p>
		<?php else: ?>
				<p>Material on this link is not found!</p>
		<?php endif; ?>


</div>

</div>





</body>
</html>