<?php
/*
Template Name: Archives
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

<div class="pages-title">
		<h1>Archive</h1>
	</div><ul style="padding-left:40px;padding-top:15px;">
<?



query_posts('meta_key=yearno&showposts=-1'); //сначала получим годы всех журналов
// далее по циклу вынесем все их в массив
$year=Array();
while (have_posts()) : the_post();
  $mykey_values = get_post_custom_values('yearno');
  foreach ( $mykey_values as $key => $value ) {
  $nomer = array_pop(get_post_custom_values('no')); //получаем номер журнала

  	$id=(int)$post->ID;
    $year[$value][$nomer][$id]="";
    $noma[md5($nomer.$value)]=$nomer.$value; //подсчет общего кол-ва журналов для вывода автоматической последовательности номеров -> N1(3) т.3 2010
  }
endwhile;


ksort($year);
$year=array_reverse($year,true);
$noma=count($noma);
foreach($year as $key => $val)
{
         echo "<a name='".$key."'></a><h2 style='padding:0'>".$key."</h2>";
         krsort($val);
         foreach($val as $key2 => $val2)
         {
         	echo "<h3><a href='/archive-en/nomer?tom=1&yearno={$key}&no={$key2}&por={$noma}'>No. ".$key2." (".$noma--.")</a></h3>";
         }
         echo "<br>";
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
