<?php
/*
Template Name: Archives EN
*/
get_header();
?>
<style>
.cat-item a{
	font-size:16px;
	padding-left:15px;
	line-height:35px;
}

.children{
	padding-left:15px;
    font-size:14px;
}

.children  a{
	font-size:14px;
	padding-left:15px;
	line-height:20px;
}
</style>

<!--<div class="pages-title">-->
		<h1 class="ii-page-title">Archive</h1>
	<!--</div>-->
<ul style="padding-top:15px; text-align: center;">
<!--<ul style="padding-left:40px;padding-top:15px;">-->
<?php

$edit_post=current_user_can('edit_posts');

query_posts('lang=ru&meta_key=yearno&showposts=-1'); //сначала получим годы всех журналов
// далее по циклу вынесем все их в массив
$year=Array();
while (have_posts()) : the_post();
  $archive = false;
  $mykey_values = get_post_custom_values('yearno');
  foreach ( $mykey_values as $key => $value ) {
  $nomer = @array_pop(get_post_custom_values('no')); //получаем номер журнала

  	$id=(int)$post->ID;
//	if(!$nomer&&$edit_post){echo "Статья с идентификатором ".$id." - <a href='/wp-admin/post.php?action=edit&post=".$id."'>отсутствует номер журнала</a>!<br>";
	
//	}
    $year[$value][$nomer][$id]="";
    $noma[md5($nomer.$value)]=$nomer.$value; //подсчет общего кол-ва журналов для вывода автоматической последовательности номеров -> N1(3) т.3 2010
  }
endwhile;


ksort($year);
$year=array_reverse($year,true);
$noma=count($noma);
foreach($year as $key => $val)
{
    if ($key >= 2016) {
        echo "<a name='".$key."'></a><h2 style='padding:0'>".$key."</h2>";
         krsort($val);
         foreach($val as $key2 => $val2)
         {
         	echo "<h3><a href='/en/nomer-en?tom=1&yearno={$key}&no={$key2}&por={$noma}'>No. ".$key2." (".$noma--.")</a></h3>";
         }
         echo "<br>";
    } else {
        $archive = true;
    }
}

  
  if ($archive) {
      ?>
        <h2 style='padding:0'>Until 2016</h2>
        
        <h3><a class="red-link" href="<?php home_url('home')?>/archive-en/archive" title="English archive (Until 2016 year)">English Archive</a></h3>
                        
      <?php

}


  ?>
  </ul>
  <?
/*
$args = array(
    'show_option_all'    => "",
    'orderby'            => 'id',
    'order'              => 'DESC',
    'show_last_update'   => 0,
    'style'              => 'list',
    'show_count'         => 0,
    'hide_empty'         => 0,
    'use_desc_for_title' => 1,
    'child_of'           => 0,
    'feed'               => "",
    'feed_type'          => "",
    'feed_image'         => "",
    'exclude'            => "1",
    'exclude_tree'       => "",
    'include'            => "",
    'current_category'   => 0,
    'hierarchical'       => true,
    'title_li'           => "<h2>Архив журнала</h2>",
    'number'             => NULL,
    'echo'               => 1,
    'depth'              => 2 );

echo "<ul>";
wp_list_categories($args);
echo "</ul>";
   */

get_footer(); ?>
