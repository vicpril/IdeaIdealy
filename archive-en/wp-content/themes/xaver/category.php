<?php get_header(); ?>

<h1><? single_cat_title('Topic: ' )?></h1>

 <div class="info">
                   <p style="float:right;display:inline;padding-right:40px;padding-top:5px" class="info-list-box2"><a href="" class="ss">A (annotation)</a><a href="" title="T" class="sss">T (text)</a><a href="" title="Р" class="ssss">C (classifier)</a><a href="" title="R" class="sssss">R (review)</a></p>

                    <div class="info-list"><ul>

	<?php if (have_posts()) : ?>
		<?php //the_meta_title();
		?>
		<?php
		$cat="";  $b=0;
		while (have_posts()) : the_post(); ?>

               		<?php
		// check for thumbnail
$yearno = get_post_meta($post->ID,'yearno','single');
$no = get_post_meta($post->ID,'no','single');
$tom = get_post_meta($post->ID,'tom','single');

			 ?>


				<?
				global $post;

					     //  echo "<strong style='color:black'>"; the_category(''); echo "</strong>";



                   ?>


					<li>
					<table border=0 class="rast"><tr><td>

					<a style='font-size:16px;font-weight:bold;text-decoration:none' href="<?php the_permalink() ?>" rel="bookmark" title="Go to text: <?php the_title(); ?>"><?php the_title() ?></a><? echo " / <div style='display:inline' class='crumbs'><a href='/archive#$yearno' title='Go to materials of this year'>Magazine ".$yearno ." year</a> &raquo; <a href='/en/nomer?yearno=$yearno&no=$no&tom=$tom' title='Go to this No.'>№" . $no . ", value " . $tom."</a></div>"; ?>
<?php if(function_exists(wt_the_coauthors_link)): wt_the_coauthors_link("<br><b>","</b>"); endif; ?><?php edit_post_link('Редактировать', '&nbsp;&laquo;&laquo;&nbsp;', ''); ?>


					<script>
						 function doit_<?=$post->ID?>(id,what)
						 {
       							if(what=='excerpt'){
						 	 $("#"+id+"_ex").toggle("slow");
						 	 }
						 	 if(what=='recen'){
						 	 $("#"+id+"_recen").toggle("slow");
						 	 }

						 	 if(what=='tags'){
						 	 $("#"+id+"_tags").toggle("slow");
						 	 }

						 }
						</script>

					<?         //print_r($post);
                         unset($excerpt,$text,$recen,$tags);  $recent=get_post_meta($post->ID,"recen",true);

                    	if(!empty($recent))
					{

						$recen["text"]=$recent;
						$recen["js"]="onClick='doit_".$post->ID."(".$post->ID.",\"recen\");return false;'";

					}
					else{
						$recen["no"]="1";
						$recen["js"]="onClick='return false;'";
					}

					if(!empty($post->post_excerpt))
					{

						$excerpt["text"]=$post->post_excerpt;
						$excerpt["js"]="onClick='doit_".$post->ID."(".$post->ID.",\"excerpt\");return false;'";
					}
					else{
						$excerpt["no"]="1";
						$excerpt["js"]="onClick='return false;'";
					}

					if(!empty($post->post_content))
					{

						$text["link"]=$post->guid;
					}
					else{
						$text["no"]="1";
						$text["js"]="onClick='return false;'";
					}

			$post_tags = get_the_tags();
            if ($post_tags):
              $tags = array();
              $i = 0;
              foreach($post_tags as $tag):
               $tags[$i] .=  '<a href="'.get_tag_link($tag->term_id).'" rel="tag" title="'.sprintf(__('%1$s (%2$s topics of the such materials)'),$tag->name,$tag->count).'">'.$tag->name.'</a>';
               $i++;
              endforeach;
              $tags["text"]= implode(', ',$tags);
			   $tags["js"]="onClick='doit_".$post->ID."(".$post->ID.",\"tags\");return false;'";
            else:
                $tags["no"]="1";
                $tags["js"]="onClick='return false;'";
            endif; ?>

                     </td><td align=right>

					<p class="info-list-box" id="<?=$post->ID?>_line"><a href="" <?=$excerpt["js"]?> title="Annotation" class="ss<?=$excerpt["no"]?>">A</a> <a href="<?=$text["link"]?>" <?=$text["js"]?> title="Text" class="sss<?=$text["no"]?>">T</a><a href="" <?=$tags["js"]?> title="Classifier" class="ssss<?=$tags["no"]?>">C</a><a href="" title="Review" <?=$recen["js"]?> class="sssss<?=$recen["no"]?>">R</a></p>
                      </td></tr><tr><td colspan=2>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_ex">Annotation: <?=$excerpt["text"]?></div>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_recen">Review: <?=$recen["text"]?></div>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none;text-transform:lowercase;" id="<?=$post->ID?>_tags">Topics: <?=$tags["text"]?></div>

					</td></tr></table><br>
					</li>



		<?php endwhile; ?>      </ul>
                                 </div>
</div>


<div style="clear: both;"></div>

<p class="pagination"><?php next_posts_link('Next page &raquo;') ?> <?php previous_posts_link('&laquo; Previous page ') ?></p>

<?php else : ?>

<h2>  No material on this link </ h2>

<p> Sorry, but this address is not material. </ p>

<?php endif; ?>

</div>

</div>


<?php get_footer(); ?>

