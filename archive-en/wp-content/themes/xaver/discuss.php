<?php
/*
Template Name: Discuss Club
*/

get_header();

$r = new WP_Query(array('showposts' => '10', 'what_to_show' => 'posts',
           'nopaging' => 0, 'post_status' => 'publish', 'caller_get_posts' => 1));

           $r->query('meta_key=stol&meta_value=yes');
?>


<h1>Disputatio</h1>

		<?

		//The Loop
if ($r->have_posts()) : while ($r->have_posts()) : $r->the_post();
                    $i++;



                    $yearno = get_post_meta($post->ID,'yearno','single');
$no = get_post_meta($post->ID,'no','single');
$tom = get_post_meta($post->ID,'tom','single');

                   ?> <p class="info"><span class="date"><?php the_time('j F Y') ?></span> / <a style="font-size:16px;" href="<?php the_permalink() ?>" rel="bookmark" title="Go to material: <?php the_title(); ?>. Magazine <?=$yearno?> year, №<?=$no?>, value <?=$tom?>"><?php the_title() ?></a> &raquo; <? echo "<a href='/en/archive#$yearno' title='Go to this year materials'>Magazine ".$yearno ." year</a> &raquo; <a href='/en/nomer?yearno=$yearno&no=$no&tom=$tom' title='Go to this No.'>№" . $no . ", value " . $tom."</a>"; ?></p>  <?
	endwhile;

else:
 echo "No entries.";
 endif;
 ?>


<?php get_footer(); ?>

