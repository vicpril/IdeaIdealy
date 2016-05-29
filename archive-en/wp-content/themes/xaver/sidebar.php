<?php

 $r = new WP_Query(array('showposts' => '10', 'what_to_show' => 'posts',
           'nopaging' => 0, 'post_status' => 'publish', 'caller_get_posts' => 1));

           $r->query('meta_key=stol&meta_value=yes');

//query_posts('meta_key=stol&meta_value=yes');//&orderby=date&order=DESC');

?>
<!-- begin sidebar -->

<div class="right-side">
	<!--<div class="right-box obshenie">-->
	

<?php
//Reset Query
wp_reset_query();


		?>
             <!--<a style="float:right" href="/en/diskussionnye-kluby">Look for all</a>-->
	<!--</div>-->




		<!--<div class="right-box ukazatel">
		<h2>Для пользователей</h2>
	<ul>
		<?php //wp_register();
		?>
		<li><?php //wp_loginout();
		?></li>
	</ul>
	</div>  -->

<? dynamic_sidebar(); ?>

</div>









<!-- end sidebar -->
