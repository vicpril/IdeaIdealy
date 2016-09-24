<?php 
if (LANG == 'en') {
    include_once 'tag_en.php';
} else {
 ?>



<?php get_header(); ?>

<h1><? single_cat_title('Тема ' )?></h1>



<div class="info">
<!--                   <p style="float:right;display:inline;padding-right:40px;padding-top:5px" class="info-list-box2">
                       <a href="" class="ss">А (аннотация)</a>
                       <a href="" title="Т" class="sss">Т (текст)</a>
                   </p>-->

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

					<a style='font-size:16px;font-weight:bold;text-decoration:none' href="<?php the_permalink() ?>" rel="bookmark" title="Перейти к материалу: <?php the_title(); ?>"><?php the_title() ?></a><? echo " / <div style='display:inline' class='crumbs'><a href='/archive#$yearno' title='Перейти к номерам данного года'>Журнал ".$yearno ." года</a> &raquo; <a href='/nomer?yearno=$yearno&no=$no&tom=$tom' title='Перейти к номеру журнала'>№" . $no . ", Том " . $tom."</a></div>"; ?>
<?php if(function_exists(wt_the_coauthors_link)): wt_the_coauthors_link("<br><b>","</b>"); endif; ?><?php edit_post_link('Редактировать', '&nbsp;&laquo;&laquo;&nbsp;', ''); ?>


					<script>
						 function doit_<?=$post->ID?>(id,what)
						 {
       							if(what=='excerpt'){
						 	 $("#"+id+"_udk").toggle("slow");
						 	 $("#"+id+"_ex").toggle("slow");
						 	 $("#"+id+"_kw").toggle("slow");
						 	 $("#"+id+"_lit").toggle("slow");
						 	 }
						 	 if(what=='recen'){
						 	 $("#"+id+"_recen").toggle("slow");
						 	 }

						 	 if(what=='tags'){
						 	 $("#"+id+"_tags").toggle("slow");
						 	 }

						 }
						</script>

					<?php         //print_r($post);
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
                    
                    $annotation = get_field('annotation', $post->ID);
                    if ($annotation) {
                        $excerpt["text"]=$annotation;
						$excerpt["js"]="onClick='doit_".$post->ID."(".$post->ID.",\"excerpt\");return false;'";
                    }
					elseif(!empty($post->post_excerpt))
					{

						$excerpt["text"]=$post->post_excerpt;
						$excerpt["js"]="onClick='doit_".$post->ID."(".$post->ID.",\"excerpt\");return false;'";
					}
					else{
						$excerpt["no"]="1";
						$excerpt["js"]="onClick='return false;'";
					}

					$text['attach']=get_post_meta($post->ID,"File Upload",true);
                    
//					if(!empty($post->post_content) || !empty($text['attach']))
					if(!empty($text['attach']))
					{

//						$text["link"]=$post->guid;
						$text["link"]=get_permalink();
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
               $tags[$i] .=  '<a href="'.get_tag_link($tag->term_id).'" rel="tag" title="'.sprintf(__('%1$s (%2$s тем подобного материала)'),$tag->name,$tag->count).'">'.$tag->name.'</a>';
               $i++;
              endforeach;
              $tags["text"]= implode(', ',$tags);
			   $tags["js"]="onClick='doit_".$post->ID."(".$post->ID.",\"tags\");return false;'";
            else:
                $tags["no"]="1";
                $tags["js"]="onClick='return false;'";
            endif; ?>

                        <br><div class="info-list-box" id="<?=$post->ID?>_line">
					
					<? if(!isset($excerpt['no'])){ ?>
						<a href="" <?=$excerpt["js"]?> title="Анотация" class="ss<?=$excerpt["no"]?>">Аннотация</a>
					<? } ?>
					
					<? if(!isset($text['no'])){ ?>
						 <a href="<?=$text["link"]?>" <?=$text["js"]?> title="Текст" class="sss<?=$text["no"]?>">Текст</a>
					<? } ?>

						<!-- <a href="" <?=$tags["js"]?> title="Классификатор" class="ssss<?=$tags["no"]?>">К</a><a href="" title="Отклики" <?=$recen["js"]?> class="sssss<?=$recen["no"]?>">О</a>--></p>
                      </div>
                        
                     </td><td align=right>

					</td></tr><tr><td colspan=2>
                     <?php if(get_field('udk', $post->ID)) : ?><div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_udk"><b style="margin-left:-10px">УДК:</b> <?=get_field('udk', $post->ID);?></div><?php endif; ?>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_ex"><b style="margin-left:-10px">Аннотация:</b> <br><div><?=$excerpt["text"]?></div></div>
                     <?php if(get_field('keywords', $post->ID)) : ?><div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_kw"><b style="margin-left:-10px">Ключевые слова:</b> <?=get_field('keywords', $post->ID)?></div><?php endif; ?>
                     <?php if(get_field('literatura', $post->ID) || get_field('literatura_en', $post->ID)) : ?><div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_lit"><b style="margin-left:-10px">Список литературы:</b> <br><div style="margin-left: 20px;"><?=get_field('literatura', $post->ID)?><br><?=get_field('literatura_en', $post->ID)?></div></div><?php endif; ?>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_recen"><b style="margin-left:-10px">Отклики: </b><?=$recen["text"]?></div>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none;text-transform:lowercase;" id="<?=$post->ID?>_tags"><b style="margin-left:-10px">Темы материала: </b><?=$tags["text"]?></div>

					</td></tr></table><br>
					</li>



		<?php endwhile; ?>      </ul>
                                 </div>
</div>

<!--End Post-->





<div style="clear: both;"></div>

<p class="pagination"><?php previous_posts_link('&laquo; Предыдущая страница ') ?>   <?php next_posts_link('Следующая страница &raquo;') ?></p>

<?php else : ?>

<h2 >Нет материала по данной ссылке</h2>

<p>Извините, но по данному адресу материала нет.</p>

<?php endif; ?>

</div>

</div>


<?php get_footer(); ?>

<?php } ?>