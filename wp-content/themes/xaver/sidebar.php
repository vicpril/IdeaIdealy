<div class="right-side">

<?php
if (LANG != 'en') { 
    
 $r = new WP_Query(array('showposts' => '10', 'what_to_show' => 'posts',
           'nopaging' => 0, 'post_status' => 'publish', 'caller_get_posts' => 1));
//
           $r->query('meta_key=stol&meta_value=yes');

//query_posts('meta_key=stol&meta_value=yes');//&orderby=date&order=DESC');


           
?>
<!-- begin sidebar -->


    <?php 
        //query
//        query_posts(array('post_type' => 'post','lang' => 'ru', 'meta_key' => 'stol', 'meta_value' => 'yes',))
        ?>
	<div class="right-box obshenie">
        <h2><?php if(is_plugin_active('polylang/polylang.php')) {pll_e('ДИСКУССИОННЫЙ КЛУБ');} else { echo 'ДИСКУССИОННЫЙ КЛУБ';} ?></h2>

		<?php
        //The Loop
            if ($r->have_posts()) : while ($r->have_posts()) : $r->the_post();
                                $i++;
                                if($i>4)break;
                                
                                $yearno =   get_post_meta($post->ID,'yearno','single');
                                $no =       get_post_meta($post->ID,'no','single');
                                $tom =      get_post_meta($post->ID,'tom','single');
                                
                                switch (LANG){
                                    case 'en':
                                        $title =    get_field('title_en', $post->ID);
                                        if (empty($title)) {$title = $post->post_title; }
                                        
                                        if(is_plugin_active('polylang\polylang.php')) {
                                            $pid_en = pll_get_post_translations($post->ID);
                                        }
                                        $permalink = get_permalink($pid_en['en']);
                                        
                                        break;
                                    default:
                                        $title =    $post->post_title;
                                        $permalink = get_permalink();
                                        break;
                                }
                            
//                                echo $permalink;
                                

                               ?> <p><span class="date"><?php the_time('j F Y') ?> /</span><a style='font-size:12px;color:#980000;text-decoration:none' href="<?=$permalink?>" rel="bookmark" title="Перейти к материалу: <?php the_title(); ?>. Журнал <?=$yearno?> года, №<?=$no?>, том <?=$tom?>"><?=$title?></a></p>  <?php
                endwhile;

            else: if(is_plugin_active('polylang/polylang.php')) {
                echo pll__("Дискуссионных клубов нет.");
            } else {
                echo "Дискуссионных клубов нет.";
            }
             endif;
        
//Reset Query
wp_reset_query();


		?>
             <a style="float:right" href="/diskussionnye-kluby"><?php if(is_plugin_active('polylang/polylang.php')) { pll_e('Посмотреть все'); }; ?></a>
	</div>

    <?php } ?>


		<!--<div class="right-box ukazatel">
		<h2>Для пользователей</h2>
	<ul>
		<?php //wp_register();
		?>
		<li><?php //wp_loginout();
		?></li>
	</ul>
	</div>  -->

<?php dynamic_sidebar(); ?>

</div>





<!-- end sidebar -->