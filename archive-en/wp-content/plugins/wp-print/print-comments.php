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
|	- Printer Friendly Comments Template										|
|	- wp-content/plugins/wp-print/print-comments.php					|
|																							|
+----------------------------------------------------------------+
*/
?>


<?php if($comments) : ?>
	<?php $comment_count = 1; global $text_direction; ?>
	<br><br>
	Лист комментариев: <span  id='comments_controls'><?php print_comments_number(); ?> (<a  href="#" onclick="javascript:document.getElementById('comments_box').style.display = 'block'; return false;">Открыть</a> | <a href="#" onclick="javascript:document.getElementById('comments_box').style.display = 'none'; return false;">Закрыть</a>)</span> <br>
	<div id="comments_box">

		<?php foreach ($comments as $comment) : ?>
			<p class="CommentDate">
				<strong>#<?php echo number_format_i18n($comment_count); ?> комментарий </strong> от <u><?php comment_author(); ?></u>, сделан <?php comment_date(sprintf(__('%s @ %s', 'wp-print'), get_option('date_format'), get_option('time_format'))); ?>
			</p>
			<div class="CommentContent">
				<?php if ($comment->comment_approved == '0') : ?>
					<p><em><?php _e('Your comment is awaiting moderation.', 'wp-print'); ?></em></p>
				<?php endif; ?>
				<?php print_comments_content(); ?>
			</div><br>
			<?php $comment_count++; ?>
		<?php endforeach; ?>

	</div>
<?php endif; ?>