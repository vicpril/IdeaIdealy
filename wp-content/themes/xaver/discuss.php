<?php
/*
Template Name: Discuss Club
*/

get_header();
$edit_post=current_user_can('edit_posts');

?>


<h1>Круглые столы</h1>
<br>
<?

query_posts('meta_key=yearno&showposts=-1'); //сначала получим годы всех журналов
// далее по циклу вынесем все их в массив
$year=Array();
while (have_posts()) : the_post();
  $mykey_values = get_post_custom_values('yearno');
  foreach ( $mykey_values as $key => $value ) {
  $nomer = @array_pop(get_post_custom_values('no')); //получаем номер журнала

  	$id=(int)$post->ID;
	if(!$nomer&&$edit_post){echo "Статья с идентификатором ".$id." - <a href='/wp-admin/post.php?action=edit&post=".$id."'>отсутствует номер журнала</a>!<br>";
	
	}
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
         	$nazvanie= "<a href='/nomer?tom=1&yearno={$key}&no={$key2}&por={$noma}'>Номер ".$key2." (".$noma--.")</a>";



				         			 $args = array(
				         			 	'post_status' => 'publish',
				         			 	'meta_key' => 'stol',
				         			 	'meta_value'=>'yes',
				   'order' => 'DESC',
				   'showposts' => '-1'
				    
				 );


         	$r = new WP_Query($args);
			           	//The Loop
			if ($r->have_posts()) : while ($r->have_posts()) : $r->the_post();
			                    $i++;


			                    $yearno = get_post_meta($post->ID,'yearno','single');
			$no = get_post_meta($post->ID,'no','single');
			$tom = get_post_meta($post->ID,'tom','single');
			
			                    if($yearno==$key && $no==$key2){
			                   ?> <p class="info"><span class="date"><?=$nazvanie?></span> / <a style="font-size:16px;" href="<?php the_permalink() ?>" rel="bookmark" title="Перейти к материалу: <?php the_title(); ?>. Журнал <?=$yearno?> года, №<?=$no?>, том <?=$tom?>"><?php the_title() ?></a> &raquo; <? echo "<a href='/archive#$yearno' title='Перейти к номерам данного года'>Журнал ".$yearno ." года</a> &raquo; <a href='/nomer?yearno=$yearno&no=$no&tom=$tom' title='Перейти к номеру журнала'>№" . $no . ", Том " . $tom."</a>"; ?></p>  <?
			                    }else{
//echo $yearno."==".$key."|".$no."==".$key2."<br>";
				}
				endwhile;

			else:
			 //echo "Дискуссионных клубов нет.";
			 endif;

         }
         echo "<br>";
}




?>
		<?

	
 ?>


<?php get_footer(); ?>

