	<div class="pages-title">
		<h1>Свежий номер (№<?=$nomera?>, <?=$yearno?>г.)</h1>
	</div>
			<div class="pages">
			<div class="pages-title">
				<h1>Содержание</h1>
			</div>
			<div class="pages-list">
				<span>Том:</span>
				<ul>
					<li class="none"><a href="<?=$tom1?>" title="1">1</a></li>
					<li><a href="<?=$tom2?>" title="2">2</a></li>
				</ul>
			</div>
		</div>

            <div class="info">

		 <?php if (have_posts()) : while (have_posts()) : the_post();
		  if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts);
		 ?>

		<div class="info-list">
				<strong><?php the_category('') ?></strong>
				<ul>
					<li><b><a href=""><?php the_author() ?></a></b><a href="<?php the_permalink() ?>" rel="bookmark" title="Перейти к материалу: <?php the_title(); ?>"><?php the_title() ?></a><p class="info-list-box"><a href="" title="Анотация" class="ss">А</a> <a href="" title="Т" class="sss">Т</a><a href="" title="Р" class="ssss">Р</a><a href="" title="Р" class="sssss">Р</a><!--<?php comments_popup_link('нет комментариев', '1 комментарий', '% комментариев'); ?>--></p></li>
					<?php the_excerpt();

					print_r(get_post_custom());
					?>
				</ul>
			</div>

		<?php endwhile; ?>

		<?php else : ?>

		<h2>В данном номере журнала еще нет содержания</h2>

		<?php endif; ?>

    	</div>