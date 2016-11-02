<?php

ob_start();

get_header();
$yearno=(int)$_GET['yearno'];
$no=(int)$_GET['no'];
$noma=(int)$_GET['por'];

if($noma>0)
{
	$nomar="(".$noma.")";
}


if(isset($_GET['tom']))
{
$tom=$_GET['tom'];
}
else{
$tom=1;
}

if($tom==1)
{
	$class="class='none tom_on'";
}
else{
	$class="class='none'";
    $class2="class='tom_on'";
}

if($yearno>2000 and $no>0){
?>

	<div class="pages">
		<!--<div class="pages-title">-->
		<h1 class="ii-page-title">Ideas and Ideals №<?=$no?><?=$nomar?>, year <?=$yearno?>
        <span class="tom-paginator">Vol: 
        <ul class="tom-paginator">
					<li <?=$class?>><a href="?no=<?=$no?>&yearno=<?=$yearno?>&tom=1&por=<?=$noma?>" title="Vol 1">1</a></li>
					<li <?=$class2?>><a href="?no=<?=$no?>&yearno=<?=$yearno?>&tom=2&por=<?=$noma?>" title="Vol 2">2</a></li>
				</ul>
        
        </span>
        </h1>
        <input hidden id="no" value="<?=$no?>" />
        <input hidden id="nomar" value="<?=$nomar?>" />
        <input hidden id="yearno" value="<?=$yearno?>" />
	<!--</div>-->

			<div class="pages-title">
				<h1>Contents</h1>
			</div>





			<div class="pages-list">

				

			</div>
		</div>

<div class="info">

                      <p style="float:right;display:inline;padding-right:40px;padding-top:5px" class="info-list-box2">

                      	<!--<a href="" class="ss">A (annotation)</a><a href="" title="T" class="sss">T (text)</a>-->
                      	<!--<a href="" title="Р" class="ssss">К (классификатор)</a><a href="" title="Р" class="sssss">О (отклики)</a>--></p>
<!--<div style="float:right;padding-right:40px;"><small>Push [Аnnotation] or [Тext] <br>for watching annatation or full text of article</small></div>-->

                    <div class="info-list"><ul>
                            
                            
	<?php if (have_posts()) : ?>
		<?php // the_meta_title();
        
        
		?>
		<?php
		$cat="";  $b=0;
		while (have_posts()) : the_post(); ?>




				<?php
				global $post;
				$catnew = get_the_category( $post->ID );
				++$b;
				$allcats[$b]=$catnew["0"]->cat_ID;


                 // print_r($allcats);

                            if($allcats[($b-1)]!==$catnew["0"]->cat_ID){
                                $field = get_field('cat_en', $post->ID);
                                if (empty($field)) {
                                    $field = $catnew[0]->name;
                                }
                                $cat_en = get_term_by('name', $field, 'category');
                                $cat_link = get_term_link($cat_en, 'category');
                                if (is_wp_error($cat_link) ) {
                                    $cat_link = 'error';
                                }
//					       echo "<br><strong style='color:black'>"; the_category(''); echo "</strong>";
					       echo "<strong style='color:black'><ul class='post-categories'><li>";
//                           echo "<a rel='category tag' href='category/$cat_en->slug'>$field</a>"; 
                           echo "<a rel='category tag' href='$cat_link'>$field</a>"; 
                           echo "</li></ul></strong>";
					       }


                   ?>


					<li>
					<table border=0 class="rast"><tr><td>

					<?php
                    $pid_en = pll_get_post_translations($post->ID);
                                        
                    $permalink = get_permalink($pid_en['en']);
                    
                    $title_en = get_field('title_en', $post->ID);
                    
					 
					  ?><a class="aricle-title-link"  href="<?=$permalink?>" rel="bookmark" title="Go to the article: <?=$title_en?>"><?=$title_en?></a>     &nbsp;&nbsp;&nbsp;&nbsp;<?php edit_post_link('Edit', '&nbsp;&laquo;&laquo;&nbsp;', ''); ?>
                      
                    <br>
                    <?php 
                    //the_author();
                    $stol = get_post_custom_values('stol');
                        if (empty($stol)) {
                            $stol[] = 'no';
                        }
                    if(function_exists(wt_the_coauthors_link) && (array_pop($stol) !== 'yes')): wt_the_coauthors_link("<b>","</b>", 'en', $post->ID); endif;

                    ?>  
                    <!--DOI-->
                                <?php 
                                    $doi = get_field('doi', $post->ID);
                                    if(!empty($doi)){ 
                                 ?>
                    
                    <br>
                    <!--<b>DOI: </b><a style="color:grey; text-decoration:underline;" href="http://dx.doi.org/<?php echo $doi;?>" target="_blank"><?php echo $doi; ?></a>-->
                    <!--doi without link-->
                    <b>DOI: </b><span style="color:grey;" ><?php echo $doi; ?></span>
                    
                                <?php } ?>
                    
                    <!--end DOI-->
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
//                         unset($excerpt,$text,$recen,$tags);  $recent=get_post_meta($post->ID,"recen",true);
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
                    
                    $annotation = get_field('annotation_en', $post->ID);
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
                    
                    
                    $text['attach']=get_field('file_en', $ru_id);
                    if (empty($text['attach'])) {
                        $text['attach']=get_post_meta($post->ID,"File Upload",true);
                    }
					
                    
//					if(!empty($post->post_content) || !empty($text['attach']))
					if(!empty($text['attach']))
					{

//						$text["link"]=$post->guid;
						$text["link"]=$permalink;
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
						<a href="" <?=$excerpt["js"]?> title="Annotation" class="ss<?=$excerpt["no"]?>">Annotation</a>
					<? } ?>
					
					<? if(!isset($text['no'])){ ?>
						 <a href="<?=$text["link"]?>" <?=$text["js"]?> title="Text" class="sss<?=$text["no"]?>">Text</a>
					<? } ?>

						<!-- <a href="" <?=$tags["js"]?> title="Классификатор" class="ssss<?=$tags["no"]?>">К</a><a href="" title="Отклики" <?=$recen["js"]?> class="sssss<?=$recen["no"]?>">О</a>--></p>
                <div>     
                
                     </td><td align=right>

					</td></tr><tr><td colspan=2>
                     <?php if(get_field('udk', $post->ID)) : ?><div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_udk"><b style="margin-left:-10px">УДК:</b> <?=get_field('udk', $post->ID);?></div><?php endif; ?>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_ex"><b style="margin-left:-10px">Annotation:</b> <br><div><?=$excerpt["text"]?></div></div>
                     <?php if(get_field('keywords_en', $post->ID)) : ?><div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_kw"><b style="margin-left:-10px">Keywords:</b> <?=get_field('keywords_en', $post->ID)?></div><?php endif; ?>
                     <?php if(get_field('literatura_en', $post->ID)) : ?><div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_lit"><b style="margin-left:-10px">Literatura:</b> <br><div style="margin-left: 20px;"><?=get_field('literatura_en', $post->ID)?></div></div><?php endif; ?>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_recen"><b style="margin-left:-10px">Отклики: </b><?=$recen["text"]?></div>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none;text-transform:lowercase;" id="<?=$post->ID?>_tags"><b style="margin-left:-10px">Темы материала: </b><?=$tags["text"]?></div>

					</td></tr></table>   <?

//					 if($allcats[($b-1)]==$catnew["0"]->cat_ID){
//					       echo "<br>";
//					       }

					?>
					</li>
					<?php

					//print_r(get_post_custom());

					//if($cat!==$catnew["0"]->cat_ID)
					//{

					//}



					?>


		<?php endwhile; ?>      </ul>
                                 </div>
</div>
	<!--	<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>-->

	<?php else : ?>

		<h2 class="center">This number or numbers that have not yet emerged, or the content is not ready for it.</h2>
			<p class="center"> Try to find another no. of our magazine. </p>
		<!--<?php meta_filter_box(); ?>-->

	<?php endif; ?>

	</div>



<?php
}
else{
	wp_redirect(get_option('siteurl') . '/en/archive-2');
}

 get_footer(); ?>
