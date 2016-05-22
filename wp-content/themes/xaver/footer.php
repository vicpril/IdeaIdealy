<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
?>
<!-- begin footer -->
<?php 
    if (LANG == 'ru') {
?>


</div>

</div>

</div>

<div class="footer">
<div class="footer-bg">
<div class="footer-bg2">

<div class="design">
<p>&copy; 2010 “Идеи и Идеалы”. Все права защищены<br />Редакция: <a style="color:#016F93" href="/kontakty">форма для связи</a></p>
<p><a style="color:#016F93" href="http://xaver.ru/" title="Создание и разработка сайтов | изготовление сайтов-визиток и интернет-магазинов | Xaver.ru">Сделано в Xaver.ru</a>
<br>В разработке принимал участвие <a style="color:#016F93" href="http://www.upwork.com/o/profiles/users/_~0185a6a50ee43e772c/" title="Веб-разработчик Виктор Прилепин">Виктор Прилепин</a></p>
</div>

<div class="list">



<ul>
<li><a href="<?php bloginfo('rss2_url'); ?>" title="RSS ленты" class="rss"><?php _e('<abbr title="Really Simple Syndication">RSS лента</abbr>'); ?></a></li>
<li><a href="/kontakty" title="Контакты" class="cont">Контакты</a></li>
<li><a href="/about" title="О проекте" class="about">О проекте</a></li>
</ul>
</div>

</div>
</div>
</div>

    <?php } else { ?>

</div>

</div>

</div>

<div class="footer">
<div class="footer-bg">
<div class="footer-bg2">

<div class="design">
<p>&copy; 2010 “Ideas and Ideals”.  All rights reserved<br />Redaction: <a style="color:#016F93" href="/kontakty">Feedback form</a></p>
<p><a style="color:#016F93" href="http://xaver.ru/" title="Создание и разработка сайтов | изготовление сайтов-визиток и интернет-магазинов | Xaver.ru">made in Xaver.ru</a>
<br>and by <a style="color:#016F93" href="http://www.upwork.com/o/profiles/users/_~0185a6a50ee43e772c/" title="Web-developer Viktor Prilepin">Viktor Prilepin</a></p>
</div>

<div class="list">



<ul>
<li><a href="<?php bloginfo('rss2_url'); ?>" title="RSS feed" class="rss"><?php _e('<abbr title="Really Simple Syndication">RSS feed</abbr>'); ?></a></li>
<li><a href="/en/kontakty" title="Contacts" class="cont">Contacts</a></li>
<li><a href="/en/about-3" title="About" class="about">About</a></li>
</ul>
</div>

</div>
</div>
</div>

    <?php } ?>

<?php wp_footer(); ?>
</body>
</html>