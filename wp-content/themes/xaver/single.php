<?php if (LANG == 'ru') {?>

<?php
 get_header();
?>


      <?php if (have_posts()) : while (have_posts()): the_post(); ?>

         <?php
$yearno = get_post_meta($post->ID,'yearno','single');
$no = get_post_meta($post->ID,'no','single');
$tom = get_post_meta($post->ID,'tom','single');
$file = get_post_meta($post->ID,'File Upload','single');




$categories = get_the_category( $post_id );
foreach($categories as $cat => $val)
{
	$cats[]=$val->name;
}
$cats=join(",",$cats);

	echo "<div class='crumbs'><a href='/archive#$yearno' title='Перейти к номерам данного года'>Журнал ".$yearno ." года</a> &raquo; <a href='/nomer?yearno=$yearno&no=$no&tom=$tom' title='Перейти к номеру журнала'>№" . $no . ", Том " . $tom."</a> &raquo; ".$cats."</div>";


         ?>

           <br>

 <?php if(function_exists('wp_print')): ?><div class="alignright"><?php print_link(); ?></div><?php endif; ?>

        <h1 class="title"><?php the_title(); ?></h1>
        
         <!--DOI-->
         
                                <?php 
                                    $doi = get_field('doi', $post->ID);
                                    if(!empty($doi)){ 
                                 ?>
         <div>
         <b>DOI: </b><a href="http://dx.doi.org/<?php echo $doi;?>" target="_blank"><?php echo $doi; ?></a>
         </div>       <br>
                    
                                <?php } ?>
                    
        <!--end DOI-->




        <?php if(function_exists(wt_the_coauthors_link)): wt_the_coauthors_link("<b>","</b><br>"); endif; ?>
              <br>            <?php edit_post_link('Редактировать', '', ''); ?>

          <?php 
		  $content=$post->post_content;
		  $content=str_replace("\n","<p>",$content);
		//  $content = apply_filters('the_content', $content);
        /*
         * Отобразить текст статьи (Из текстового редактора)
         */
		 $content=  get_field('text', $post->ID);
		 $content=str_replace("\n","<p>",$content);
         
         echo $content;
		 
		// the_content();
		   ?>


          <?php wp_link_pages(array('before' => '<div class="page-navigation"><p><strong> '.__("Pages:","mystique").' </strong>', 'after' => '</p></div>', 'next_or_number' => 'number')); ?>

          <?php

            $post_tags = get_the_tags();
            if ($post_tags): ?>    <br>
             <br>
            <div class="post-tags"><h3>Темы материала:</h3>
            <?php
              $tags = array();
              $i = 0;
              foreach($post_tags as $tag):
               $tags[$i] .=  '<a href="'.get_tag_link($tag->term_id).'" rel="tag" title="'.sprintf(__('%1$s (%2$s topics)'),$tag->name,$tag->count).'">'.$tag->name.'</a>';
               $i++;
              endforeach;
              echo implode(', ',$tags); ?>
            </div>
            <?php endif; ?>


            <?php if(!empty($file))
            {
            	echo "<br>Вы можете скачать материал по ссылке: <a href='".wp_get_attachment_url($file)."'>".basename(wp_get_attachment_url($file))."</a>";
            }

             ?>

        <!-- /post -->



       <?php endwhile; endif; ?>
          <br>
       <?php comments_template(); ?>



<?php get_footer(); ?>
<?php } else { ?>
              <?php /*
               * 
               *    English part  
               */
              ?>
          
          
          
          
     <?php
        get_header();
       ?>


             <?php if (have_posts()) : while (have_posts()): the_post(); ?>

                <?php
       $ru_id = pll_get_post_translations($post->ID);
       $ru_id = $ru_id['ru'];  
       $post_ru = get_post($ru_id);
                
       $yearno = get_post_meta($ru_id,'yearno','single');
       $no = get_post_meta($ru_id,'no','single');
       $tom = get_post_meta($ru_id,'tom','single');
       $file = get_post_meta($ru_id,'File Upload','single');

       


       $categories = get_the_category( $post_id );
       foreach($categories as $cat => $val)
       {
           $cats[]=$val->name;
       }
       $cats=join(",",$cats);

	echo "<div class='crumbs'><a href='/en/archive#$yearno' title='Go to this magazin materials'>Magazine ".$yearno ." year</a> &raquo; <a href='/en/nomer-en?yearno=$yearno&no=$no&tom=$tom' title='Go to this no.'>№" . $no . ", value " . $tom."</a> &raquo; ".$cats."</div>";


                ?>

                  <br>

        <?php if(function_exists('wp_print')): ?><div class="alignright"><?php print_link(); ?></div><?php endif; ?>

               <h1 class="title"><?php the_title(); ?></h1>

                <!--DOI-->

                                       <?php 
                                           $doi = get_field('doi', $ru_id);
                                           if(!empty($doi)){ 
                                        ?>
                <div>
                <b>DOI: </b><a href="http://dx.doi.org/<?php echo $doi;?>" target="_blank"><?php echo $doi; ?></a>
                </div>       <br>

                                       <?php } ?>

               <!--end DOI-->




               <?php if(function_exists(wt_the_coauthors_link)): wt_the_coauthors_link("<b>","</b><br>", 'en', $ru_id); endif; ?>
                     <br>            <?php edit_post_link('Edit', '', ''); ?>

                 <?php 
                 $content=$post_ru->post_content;
                 $content=str_replace("\n","<p>",$content);
               //  $content = apply_filters('the_content', $content);
               /*
                * Отобразить текст статьи (Из текстового редактора)
                */
                $content=  get_field('text', $ru_id);
                $content=str_replace("\n","<p>",$content);

                echo $content;

               // the_content();
                  ?>


                 <?php wp_link_pages(array('before' => '<div class="page-navigation"><p><strong> '.__("Pages:","mystique").' </strong>', 'after' => '</p></div>', 'next_or_number' => 'number')); ?>

                 <?php

                   $post_tags = get_the_tags();
                   if ($post_tags): ?>    <br>
                    <br>
                   <div class="post-tags"><h3>Topics:</h3>
                   <?php
                     $tags = array();
                     $i = 0;
                     foreach($post_tags as $tag):
                      $tags[$i] .=  '<a href="'.get_tag_link($tag->term_id).'" rel="tag" title="'.sprintf(__('%1$s (%2$s topics)'),$tag->name,$tag->count).'">'.$tag->name.'</a>';
                      $i++;
                     endforeach;
                     echo implode(', ',$tags); ?>
                   </div>
                   <?php endif; ?>


                   <?php if(!empty($file))
                   {
                       echo "<br>You can download this material: <a href='".wp_get_attachment_url($file)."'>".basename(wp_get_attachment_url($file))."</a>";
                   }

                    ?>

               <!-- /post -->



              <?php endwhile; endif; ?>
                 <br>
              <?php comments_template(); ?>



       <?php get_footer(); ?>     
          
          
<?php } ?>