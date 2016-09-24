<?php
 get_header();

?>


       <?php if(isset($_GET['author_name'])) $curauth = get_userdatabylogin($author_name); else $curauth = get_userdata(intval($author)); ?>

       <h1 class="title"><?php echo $curauth->first_name; ?></h1>

       <?php userphoto(intval($author), $before = '', $after = '', $attributes = array("vspace"=>"10px","alt"=>$curauth->first_name), $default_src = '')   ; ?>

        <p>
        <?php
        query_posts('&orderby=date&order=DESC&posts_per_page=-1meta_key=coauthor&meta_value='.$curauth->first_name);
         if($curauth->user_description<>''): echo "Curriculum vitae: <br>". str_replace("\n","<br>",$curauth->user_description);

         else: echo "This author has not yet provided biographical information.";
         endif;
        ?>
        </p>


         <?php
          if(!empty($curauth->user_email) && !eregi("localhost",$curauth->user_email)) echo '<p class="im www">Email: <a href="mailto:'.$curauth->user_email.'">'.$curauth->user_email.'</a></p>';
          if(($curauth->user_url<>'http://') && ($curauth->user_url<>'')) echo '<p class="im www">Homepage: <a href="'.$curauth->user_url.'">'.$curauth->user_url.'</a></p>';
          if($curauth->yim<>'') echo '<p class="im yahoo">Yahoo IM: <a href="ymsgr:sendIM?'.$curauth->yim.'">'.$curauth->yim.'</a></p>';
          if($curauth->jabber<>'') echo '<p class="im gtalk">Jabber/Gtalk: <a href="gtalk:chat?jid='.$curauth->jabber.'">'.$curauth->jabber.'</a></p>';
          if($curauth->aim<>'') echo '<p class="im aim">AIM: <a href="aim:goIM?screenname='.$curauth->aim.'">'.$curauth->aim.'</a></p>';
         ?>

       <br /><br />
       <h1 class="title">Proceedings of the author</h1>
      <?php if (have_posts()) : while (have_posts()) : the_post();
		  if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts);

		  $yearno = get_post_meta($post->ID,'yearno','single');
$no = get_post_meta($post->ID,'no','single');
$tom = get_post_meta($post->ID,'tom','single');
		 ?>

	<div class="info">
<div class="info-list">
<a style='font-size:16px;font-weight:bold;text-decoration:none' href="<?php the_permalink() ?>" rel="bookmark" title="Перейти к материалу: <?php the_title(); ?>"><?php the_title() ?></a><? echo " / <div style='display:inline' class='crumbs'><a href='/archive-en/archive#$yearno' title='Go to this materials'>Magazine ".$yearno ." year</a> &raquo; <a href='/archive-en/nomer?yearno=$yearno&no=$no&tom=$tom' title='Go to this No.'>№" . $no . ", vol " . $tom."</a></div>"; ?>
<?php //if(function_exists(wt_the_coauthors_link)): wt_the_coauthors_link("<br><b>","</b>"); endif;
?>
<!--<br>
Аннотация:
<?php the_excerpt(); ?> -->
</div>
</div>

		<?php endwhile; ?>


      <?  else : ?>
        <p class="error">This author has no materials.</p>
       <?php endif; ?>



<?php get_footer(); ?>

