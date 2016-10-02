<?php
/*
Template Name: Authors list
*/

get_header();
require_once(ABSPATH . WPINC . '/registration.php');
?>

   <h1 class="ii-page-title">Наши авторы</h1>  <br>
<?
       global $wpdb;
     $au = $wpdb->get_results("
				SELECT post_id, meta_value,user_login FROM `wp_postmeta` left join  wp_posts on (wp_postmeta.post_id=wp_posts.ID) left join wp_users on ( REPLACE(LCASE(TRIM(wp_postmeta.meta_value)), ' ','')=REPLACE(LCASE(TRIM(wp_users.display_name)), ' ','')) where meta_key='coauthor' and post_status='publish' and post_type='post' group by meta_value order by meta_value ASC
		");
      //  print_r($au);exit;
	      foreach($au as $key=>$value)
	      {
			      //      [0] => stdClass Object
			      //  (
			       //     [post_id] => 416
			       //     [meta_value] => Айламазьян А.М.
			       //     [user_login] =>

			       if(!$value->user_login)
			       {              unset($user);
			       	//echo "Zaregi ".tranaslat($value->meta_value)."<br>";
							$user=Array
							(
							    "user_login" => tranaslat($value->meta_value),
							    "role" => 'subscriber',
							    "user_email" => 'temp@localhost.lo',
							    "user_url" => '',
							    "first_name" => $value->meta_value,
							    "comment_shortcuts" => '',
							    "use_ssl" => 0 ,
							    "user_pass" => "ideaidealynsuem",
							    "display_name" => $value->meta_value
							) ;
							$in=wp_insert_user($user);
						//		echo "<a href='/author/".$in."'>".$value->meta_value."</a><br>";

			       }
			       else{
			     //  	echo "<a href='/author/".$value->user_login."'>".$value->meta_value."</a><br>";
			       }

	        }



       echo "<ul style='line-height:25px;'>";
wp_list_authors2("optioncount=1&exclude_admin=1&show_fullname=1&hide_empty=&style=list");
echo "</ul>";
exit;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>




       <h1 class="title">Наши авторы</h1>  <br>
 <div class="info">
                   <p style="float:right;display:inline;padding-right:40px;padding-top:5px" class="info-list-box2"><a href="" class="ss">А (аннотация)</a><a href="" title="Т" class="sss">Т (текст)</a><a href="" title="Р" class="ssss">К (классификатор)</a><a href="" title="Р" class="sssss">Р (рецензия)</a></p>

                    <div class="info-list"><ul>
       <?

      // wp_list_authors2("optioncount=1&exclude_admin=1&show_fullname=1&hide_empty=&style=list");
     //SELECT * FROM `wp_postmeta` left join  wp_posts on (wp_postmeta.post_id=wp_posts.ID) where meta_key='coauthor' order by post_id
      global $wpdb;
     $au = $wpdb->get_results("
			SELECT post_id, meta_value FROM `wp_postmeta` left join  wp_posts on (wp_postmeta.post_id=wp_posts.ID) where meta_key='coauthor' and post_status='publish' and post_type='post' order by meta_value ASC
		");

      foreach($au as $key=>$value)
      {
      	$names[trim($value->meta_value)][$value->post_id]=get_post($value->post_id);
      	ksort($names[$value->meta_value]);
      }


          //  print_r($names);exit;
      foreach($names as $name => $posts)
      {
      		echo "<a href='' onClick='$(\"#".md5($name)."\").toggle(\"slow\");return false;' style='color:black;text-decoration:none;font-size:16px;padding:4px;'>".$name."</a><br>
      		<div style='padding-top:10px;padding-left:10px;display:none;border:none;' id='".md5($name)."'>";
      		foreach($posts as $post)
      		{
         			// check for thumbnail
				$yearno = get_post_meta($post->ID,'yearno','single');
				$no = get_post_meta($post->ID,'no','single');
				$tom = get_post_meta($post->ID,'tom','single');



                   ?>


					<li>
					<table border=0 class="rast"><tr><td>

					<a style='font-size:16px;font-weight:bold;text-decoration:none' href="<?php the_permalink() ?>" rel="bookmark" title="Перейти к материалу: <?php the_title(); ?>"><?php the_title() ?></a><? echo " / <div style='display:inline' class='crumbs'><a href='/archive#$yearno' title='Перейти к номерам данного года'>Журнал ".$yearno ." года</a> &raquo; <a href='/nomer?yearno=$yearno&no=$no&tom=$tom' title='Перейти к номеру журнала'>№" . $no . ", Том " . $tom."</a></div>"; ?>
<?php edit_post_link('Редактировать', '<br><b>', '</b>'); ?>


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

			$post_tags = get_the_tags($post->ID);
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

                     </td><td align=right>

					<p class="info-list-box" id="<?=$post->ID?>_line"><a href="" <?=$excerpt["js"]?> title="Анотация" class="ss<?=$excerpt["no"]?>">А</a> <a href="<?=$text["link"]?>" <?=$text["js"]?> title="Текст" class="sss<?=$text["no"]?>">Т</a><a href="" <?=$tags["js"]?> title="Классификатор" class="ssss<?=$tags["no"]?>">К</a><a href="" title="Рецензия" <?=$recen["js"]?> class="sssss<?=$recen["no"]?>">Р</a></p>
                      </td></tr><tr><td colspan=2>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_ex">Аннотация: <?=$excerpt["text"]?></div>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none" id="<?=$post->ID?>_recen">Рецензия: <?=$recen["text"]?></div>
                     <div style="padding:10px;border-bottom:dotted 1px;display:none;text-transform:lowercase;" id="<?=$post->ID?>_tags">Темы материала: <?=$tags["text"]?></div>

					</td></tr></table>
					</li>


                      <?

      		}
      		echo "</div><br>";
      }

      // print_r($names);
       ?>
      </ul>
                                 </div>
</div>


<div style="clear: both;"></div>


<?php get_footer();













function tranaslat($title) {
	$gost1 = array(
   "Є"=>"EH","І"=>"I","і"=>"i","№"=>"#","є"=>"eh",
   "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
   "Е"=>"E","Ё"=>"JO","Ж"=>"ZH",
   "З"=>"Z","И"=>"I","Й"=>"JJ","К"=>"K","Л"=>"L",
   "М"=>"M","Н"=>"N","О"=>"O","П"=>"P","Р"=>"R",
   "С"=>"S","Т"=>"T","У"=>"U","Ф"=>"F","Х"=>"KH",
   "Ц"=>"C","Ч"=>"CH","Ш"=>"Sh","Щ"=>"Shh","Ъ"=>"'",
   "Ы"=>"Y","Ь"=>"","Э"=>"EH","Ю"=>"YU","Я"=>"YA",
   "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
   "е"=>"e","ё"=>"jo","ж"=>"zh",
   "з"=>"z","и"=>"i","й"=>"jj","к"=>"k","л"=>"l",
   "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
   "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"kh",
   "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shh","ъ"=>"",
   "ы"=>"y","ь"=>"","э"=>"eh","ю"=>"yu","я"=>"ya","«"=>"","»"=>"","—"=>"-"
  );
		    return strtr($title, $gost1);
}



?>

