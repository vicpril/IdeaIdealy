<?php
 get_header();
?>


      <?php if (have_posts()) : while (have_posts()): the_post(); ?>

         <?
$yearno = get_post_meta($post->ID,'yearno','single');
$no = get_post_meta($post->ID,'no','single');
$tom = get_post_meta($post->ID,'tom','single');
$file = get_post_meta($post->ID,'File Upload','single');




$categories = get_the_category( $post_id );
foreach($categories as $cat => $val)
{
	$cats[]=$val->name;
}
$cats=join(",",$cats);

	echo "<div class='crumbs'><a href='/archive-en/archive#$yearno' title='Go to this magazin materials'>Magazine ".$yearno ." year</a> &raquo; <a href='/archive-en/nomer?yearno=$yearno&no=$no&tom=$tom' title='Go to this no.'>№" . $no . ", vol " . $tom."</a> &raquo; ".$cats."</div>";


         ?>

           <br>

 <?php if(function_exists('wp_print')): ?><div class="alignright"><?php print_link(); ?></div><?php endif; ?>

        <h1 class="title"><?php the_title(); ?></h1>




        <?php if(function_exists(wt_the_coauthors_link)): wt_the_coauthors_link("<b>","</b><br>"); endif; ?>
              <br>            <?php edit_post_link('Редактировать', '', ''); ?>

          <?php the_content(); ?>


          <?php wp_link_pages(array('before' => '<div class="page-navigation"><p><strong> '.__("Pages:","mystique").' </strong>', 'after' => '</p></div>', 'next_or_number' => 'number')); ?>

          <?php

            $post_tags = get_the_tags();
            if ($post_tags): ?>    <br>
             <br>
            <div class="post-tags"><h3>Topics:</h3>
            <?php
              $tags = array();
              $i = 0;
              foreach($post_tags as $tag):
               $tags[$i] .=  '<a href="'.get_tag_link($tag->term_id).'" rel="tag" title="'.sprintf(__('%1$s (%2$s topics)'),$tag->name,$tag->count).'">'.$tag->name.'</a>';
               $i++;
              endforeach;
              echo implode(', ',$tags); ?>
            </div>
            <?php endif; ?>


            <? if(!empty($file))
            {
            	echo "<br>You can download this material: <a href='".wp_get_attachment_url($file)."'>".basename(wp_get_attachment_url($file))."</a>";
            }

             ?>

        <!-- /post -->



       <?php endwhile; endif; ?>
          <br>
       <?php comments_template(); ?>



<?php get_footer(); ?>
