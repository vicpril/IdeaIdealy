<?php
if (LANG == 'ru') {
/*
 * Russian Language
 */
    get_header();

    if (isset($_GET['author_name'])) $curauth = get_userdatabylogin($author_name);
    else $curauth = get_userdata(intval($author)); ?>

    <h1 class="title"><?php echo $curauth->first_name; ?></h1>

    <?php userphoto(intval($author), $before = '', $after = '', $attributes = array("vspace" => "10px", "alt" => $curauth->first_name), $default_src = ''); ?>

    <p>
        <?php
        query_posts('&orderby=date&order=DESC&posts_per_page=-1&meta_key=coauthor&meta_value=' . $curauth->display_name);
    //         if($curauth->user_description<>''): echo "Краткая биография: <br>". str_replace("\n","<br>",$curauth->user_description);
        if ($curauth->user_description <> ''): echo str_replace("\n", "<br>", $curauth->user_description);

        else: echo "Данный автор еще не представил биографическую информацию.";
        endif;
        ?>
    </p>


    <?php
    if (!empty($curauth->user_email) && !eregi("localhost", $curauth->user_email))
        echo '<p class="im www">Электронная почта: <a href="mailto:' . $curauth->user_email . '">' . $curauth->user_email . '</a></p>';
    if (($curauth->user_url <> 'http://') && ($curauth->user_url <> ''))
        echo '<p class="im www">Домашняя страница: <a href="' . $curauth->user_url . '">' . $curauth->user_url . '</a></p>';
    if ($curauth->yim <> '')
        echo '<p class="im yahoo">Yahoo IM: <a href="ymsgr:sendIM?' . $curauth->yim . '">' . $curauth->yim . '</a></p>';
    if ($curauth->jabber <> '')
        echo '<p class="im gtalk">Jabber/Gtalk: <a href="gtalk:chat?jid=' . $curauth->jabber . '">' . $curauth->jabber . '</a></p>';
    if ($curauth->aim <> '')
        echo '<p class="im aim">AIM: <a href="aim:goIM?screenname=' . $curauth->aim . '">' . $curauth->aim . '</a></p>';
    ?>

    <br /><br />

    <?php
    if (have_posts()){ 

        ?>
            <h1 class="title">Материалы автора</h1>
        <?php

        while (have_posts()) : the_post();


            if ($post->ID == $do_not_duplicate)
                continue;
            update_post_caches($posts);

            $yearno = get_post_meta($post->ID, 'yearno', 'single');
            $no = get_post_meta($post->ID, 'no', 'single');
            $tom = get_post_meta($post->ID, 'tom', 'single');
            ?>

            <div class="info">
                <div class="info-list">
                    <a style='font-size:16px;font-weight:bold;text-decoration:none' href="<?php the_permalink() ?>" rel="bookmark" title="Перейти к материалу: <?php the_title(); ?>"><?php the_title() ?></a><? echo " / <div style='display:inline' class='crumbs'><a href='/archive#$yearno' title='Перейти к номерам данного года'>Журнал " . $yearno . " года</a> &raquo; <a href='/nomer?yearno=$yearno&no=$no&tom=$tom' title='Перейти к номеру журнала'>№" . $no . ", Том " . $tom . "</a></div>"; ?>
            <?php //if(function_exists(wt_the_coauthors_link)): wt_the_coauthors_link("<br><b>","</b>"); endif;
            ?>
                    <!--<br>
                    Аннотация:
            <?php the_excerpt(); ?> -->
                </div>
            </div>

        <?php endwhile; ?>

    <? // }else  ?>
        <!--<p class="error">У данного автора еще нет материалов.</p>-->
    <?php } 

    get_footer(); 

} 
else 
{
    /*
     * English Language
     */
    get_header();
    
    
    if (isset($_GET['author_name'])) $curauth = get_userdatabylogin($author_name);
    else $curauth = get_userdata(intval($author)); ?>

    <h1 class="title"><?php echo "$curauth->us_name_en $curauth->us_initials_en"; ?></h1>

    <?php userphoto(intval($author), $before = '', $after = '', $attributes = array("vspace" => "10px", "alt" => $curauth->nickname), $default_src = ''); ?>

    <p>
        <?php
        query_posts('lang=ru&&orderby=date&order=DESC&posts_per_page=-1&meta_key=coauthor&meta_value=' . $curauth->display_name);
    //         if($curauth->user_description<>''): echo "Краткая биография: <br>". str_replace("\n","<br>",$curauth->user_description);
        if ($curauth->user_description <> ''): echo str_replace("\n", "<br>", $curauth->user_description);

        else: echo "This author has not yet provided biographical information.";
        endif;
        ?>
    </p>


    <?php
    if (!empty($curauth->user_email) && !eregi("localhost", $curauth->user_email))
        echo '<p class="im www">E-mail: <a href="mailto:' . $curauth->user_email . '">' . $curauth->user_email . '</a></p>';
    if (($curauth->user_url <> 'http://') && ($curauth->user_url <> ''))
        echo '<p class="im www">Site: <a href="' . $curauth->user_url . '">' . $curauth->user_url . '</a></p>';
    if ($curauth->yim <> '')
        echo '<p class="im yahoo">Yahoo IM: <a href="ymsgr:sendIM?' . $curauth->yim . '">' . $curauth->yim . '</a></p>';
    if ($curauth->jabber <> '')
        echo '<p class="im gtalk">Jabber/Gtalk: <a href="gtalk:chat?jid=' . $curauth->jabber . '">' . $curauth->jabber . '</a></p>';
    if ($curauth->aim <> '')
        echo '<p class="im aim">AIM: <a href="aim:goIM?screenname=' . $curauth->aim . '">' . $curauth->aim . '</a></p>';
    ?>

    <br /><br />

    <?php
    
    
    
    if (have_posts()){ 
        $archive = false;
        ?>
            <h1 class="title">Proceedings of the author</h1>
        <?php

        while (have_posts()) : the_post();

            $yearno = get_post_meta($post->ID, 'yearno', 'single');
            
            if ($yearno >= 2016) {
                if ($post->ID == $do_not_duplicate)
                continue;
                update_post_caches($posts);


                $no = get_post_meta($post->ID, 'no', 'single');
                $tom = get_post_meta($post->ID, 'tom', 'single');

                $title =    get_field('title_en', $post->ID);
                if (empty($title)) {$title = $post->post_title; }

                $pid_en = pll_get_post_translations($post->ID);

                $permalink = get_permalink($pid_en['en']);

                ?>

                <div class="info">
                    <div class="info-list">
                        <a style='font-size:16px;font-weight:bold;text-decoration:none' href="<?=$permalink?>" rel="bookmark" title="Go to the article: <?=$title?>"><?=$title?></a>
                            <? echo " / <div style='display:inline' class='crumbs'><a href='/en/archive#$yearno' title='Go to the magazine'>Magazine " . $yearno . " year</a> &raquo; <a href='/en/nomer-en?yearno=$yearno&no=$no&tom=$tom' title='Go to this No.'>№" . $no . ", Volume " . $tom . "</a></div>"; ?>
                <?php //if(function_exists(wt_the_coauthors_link)): wt_the_coauthors_link("<br><b>","</b>"); endif;
                ?>
                        <!--<br>
                        Аннотация:
                <?php the_excerpt(); ?> -->
                    </div>
                </div>
            <?php
            }
            
            endwhile;
            
            
            
            /*
             * English archive
             */
            while (have_posts()) : the_post();

            $yearno = get_post_meta($post->ID, 'yearno', 'single');
            
            if ($yearno < 2016) {
                $archive = true;
            }
            
            endwhile;
            
            if ($archive) {
                ?>
                <!--<h1 class="title">English Archive (Until 2016 year)</h1>-->
                
                    <a class="red-link" href="<?php home_url('home')?>/archive-en/author/<?=$curauth->user_nicename?>" title="<?=$curauth->us_name_en?>'s archive (Until 2016 year)">English Archive</a>
                
                <?php
            }
            
            
            
            
            

    ?>
        <!--<p class="error">У данного автора еще нет материалов.</p>-->
    <?php } 

    get_footer(); 
    
    
    
}

