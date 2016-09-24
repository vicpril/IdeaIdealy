<?php ob_start();?><?php
/*
Template Name: Metas
*/

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
		<div class="pages-title">
		<h1>Ideas and Ideals №<?=$no?><?=$nomar?>, year <?=$yearno?> 
        <span class="tom-paginator">Vol: 
        <ul class="tom-paginator">
					<li <?=$class?>><a href="?no=<?=$no?>&yearno=<?=$yearno?>&tom=1&por=<?=$noma?>" title="Vol 1">1</a></li>
					<li <?=$class2?>><a href="?no=<?=$no?>&yearno=<?=$yearno?>&tom=2&por=<?=$noma?>" title="Vol 2">2</a></li>
				</ul>
        
        </span>
        </h1>
	</div>

			<div class="pages-title">
				<h1>Contents</h1>
			</div>





			<div class="pages-list">


			</div>
		</div>

<div class="info">
                      <!--<p style="float:right;display:inline;padding-right:40px;padding-top:5px" class="info-list-box2"><a href="" class="ss">A (annotation)</a><a href="" title="T" class="sss">T (text)</a><a href="" title="Р" class="ssss">C (classifier)</a><a href="" title="R" class="sssss">R (review)</a></p>-->

                    <div class="info-list"><ul>

	<?php if (have_posts()) : ?>
		<?php //the_meta_title();
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
					       echo "<br><strong style='color:black'>"; the_category(''); echo "</strong>";
					       }


                   ?>


					<li>
					<table border=0 class="rast"><tr><td>

					<?php
//				if(function_exists(wt_the_coauthors_link)): wt_the_coauthors_link("<b>","</b>"); endif;
					 //the_author();
					  ?><a class="aricle-title-link" href="<?php the_permalink() ?>" rel="bookmark" title="Перейти к материалу: <?php the_title(); ?>"><?php the_title() ?></a>     &nbsp;&nbsp;&nbsp;&nbsp;<?php edit_post_link('Редактировать', '&nbsp;&laquo;&laquo;&nbsp;', ''); ?>
<!--DOI-->                      <br>
    <?php 
                                    //the_author();
                               				if(function_exists(wt_the_coauthors_link) && (array_pop(get_post_custom_values('stol')) !== 'yes')): wt_the_coauthors_link("<b>","</b>", 'en', $post->ID); endif;
     
                                    ?>
                                <?php 
                                if (function_exists("get_field")) {
                                    $doi = get_field('doi', $post->ID);
                                    if(!empty($doi)){ 
                                 ?>
                    
                                    
                    <br>
                    <b>DOI: </b><a style="color:grey; text-decoration:underline;" href="http://dx.doi.org/<?php echo $doi;?>" target="_blank"><?php echo $doi; ?></a>
                    
                    
                                    <?php }} ?>
                    
                    <!--end DOI-->

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
               $tags[$i] .=  '<a href="'.get_tag_link($tag->term_id).'" rel="tag" title="'.sprintf(__('%1$s (%2$s articles of the such materials)'),$tag->name,$tag->count).'">'.$tag->name.'</a>';
               $i++;
              endforeach;
              $tags["text"]= implode(', ',$tags);
			   $tags["js"]="onClick='doit_".$post->ID."(".$post->ID.",\"tags\");return false;'";
            else:
                $tags["no"]="1";
                $tags["js"]="onClick='return false;'";
            endif; 
            ?>
                <br><div class="info-list-box" id="<?=$post->ID?>_line">
					
					<? if(!isset($excerpt['no'])){ ?>
						<a href="" <?=$excerpt["js"]?> title="Annotation" class="ss<?=$excerpt["no"]?>">Annotation</a>
					<? } ?>
					
					<? if(!isset($text['no'])){ ?>
						 <a href="<?=$text["link"]?>" <?=$text["js"]?> title="Text" class="sss<?=$text["no"]?>">Text</a>
					<? } ?>

						<!-- <a href="" <?=$tags["js"]?> title="Классификатор" class="ssss<?=$tags["no"]?>">К</a><a href="" title="Отклики" <?=$recen["js"]?> class="sssss<?=$recen["no"]?>">О</a>--></p>
                </div>     
                        
                        
                     </td><td align=right>

					<!--<p class="info-list-box" id="<?=$post->ID?>_line"><a href="" <?=$excerpt["js"]?> title="Annotation" class="ss<?=$excerpt["no"]?>">A</a> <a href="<?=$text["link"]?>" <?=$text["js"]?> title="Text" class="sss<?=$text["no"]?>">T</a><a href="" <?=$tags["js"]?> title="Classifier" class="ssss<?=$tags["no"]?>">C</a><a href="" title="Review" <?=$recen["js"]?> class="sssss<?=$recen["no"]?>">R</a></p>-->
                      </td></tr><tr><td colspan=2>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_ex">Annotation: <?=$excerpt["text"]?></div>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_recen">Review: <?=$recen["text"]?></div>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none;text-transform:lowercase;" id="<?=$post->ID?>_tags">Topics: <?=$tags["text"]?></div>

					</td></tr></table>   <?php

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

		<h2 class="center"> This number or numbers that have not yet emerged, or the content is not ready for it. </ h2>
<p class="center"> Try to find another no. of our magazine. </ p>
		<!--<?php meta_filter_box(); ?>-->

	<?php endif; ?>

	</div>



<?php
}
else{
	wp_redirect(get_option('siteurl') . '/archive');
}

 get_footer(); ?>
<?php ob_end_flush();?>
