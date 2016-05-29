<?php
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>



	 <h1><?php the_title(); ?></h1>
	<?php edit_post_link(__('Edit This')); ?>
          <br>
	<div class="storycontent">
		<?php the_content(); ?>
	</div>

	<!--<div class="feedback">
		<?php wp_link_pages(); ?>
		<?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)')); ?>
	</div>-->

</div>

<!--<?php comments_template(); // Get wp-comments.php template ?>-->

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>