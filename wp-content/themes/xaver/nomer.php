<?php ob_start();?><?php
/*
Template Name: Nomer
*/
get_header();

    query_posts('meta_key=yearno&showposts=-1'); //сначала получим годы всех журналов, чтобы найти свежий год
	// далее по циклу вынесем все их в массив
	$yearno=Array();
	while (have_posts()) : the_post();
  	$mykey_values = get_post_custom_values('yearno');
		  foreach ( $mykey_values as $key => $value ) {
			  $nomer = array_pop(get_post_custom_values('no')); //получаем номер журнала
			  	$id=(int)$post->ID;
			    $yearno[$value][$nomer][$id]="";
			    $noma[md5($nomer.$value)]=$nomer.$value; //подсчет общего кол-ва журналов для вывода автоматической последовательности номеров -> N1(3) т.3 2010
		  }
		 endwhile;
        $noma=count($noma);
		krsort($yearno); //отсортируем по возрастанию
        //$yearno=array_reverse($yearno,true); // переворачиваем
		$yearno=array_slice($yearno,0,1,true); //берем свежий год





        $nomera=$yearno;
		$nomera=array_pop($nomera); //вытащим нужный нам свежий номер
        krsort($nomera); //отсортируем по возрастанию


		$yearno=array_pop(array_keys($yearno));  //год

//        $nomera=array_pop(array_keys($nomera));          //номер
            $nomera=key($nomera);

      //       echo '/nomer?tom=1&yearno='.$yearno.'&no='.$nomera;
       wp_redirect(get_option('siteurl') . '/nomer?tom=1&yearno='.$yearno.'&no='.$nomera.'&por='.$noma);


get_footer(); ?>
<?php ob_end_flush();?>
