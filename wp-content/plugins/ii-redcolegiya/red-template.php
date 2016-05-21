<?php
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>



        <h1><?php the_title(); ?></h1>
        <?php if (is_user_logged_in()) {
                    echo "<a class='edit-link' href='" . home_url() . "/wp-admin/users.php?page=redcolegia'>Редактировать страницу</a>";
                } ?>
        <br>
        <div class="storycontent">
            <?php
            // the_content(); 
            $table_name = $wpdb->prefix . "journal_editors";

            $values = array();

            $values = $wpdb->get_results("SELECT * FROM $table_name");

            $redakcia = array();
            $sovet = array();
            $int_sovet = array();

            foreach ($values as $value) {
                switch ($value->groupe) {
                    case 'редакция':
                        $redakcia[] = $value;
                        break;
                    case 'редакционный совет':
                        $sovet[] = $value;
                        break;
                    case 'международный редакционный совет':
                        $int_sovet[] = $value;
                        break;
                }
            }
            ?>
            <p>
            <h2>РЕДАКЦИЯ</h2>
            <ul>
                <?php
                foreach ($redakcia as $value) {
                    if ($value->user_id != 0) {
                        $user = get_user_by('ID', $value->user_id);
                        $user_meta = get_user_meta($value->user_id);

//                        var_dump($user_meta);

                        echo '<li>';
                        if ($value->post != '') {
                            echo "<em>$value->post:</em><br>";
                        }

                        $name = "<a href='" . get_author_posts_url($user->ID, $user->user_nicename) . "'>" . $user_meta['us_full-name'][0] . "</a>";

                        $edit_link = " -> <a class='edit-link' href='" . home_url() . "/wp-admin/user-edit.php?user_id=" . $user->ID . "' target='_blank' style='color: dodgerblue;'>Редактировать</a>";

                        if (isset($user_meta['us_post'][0]) && $user_meta['us_post'][0] != '') {
                            $post = ', ' . $user_meta['us_post'][0];
                        } else {
                            $post = '<br>';
                        }

                        if (is_user_logged_in()) {
                            echo $name . $edit_link . $post;
                        } else {
                            echo $name . $post;
                        }

//                echo '</li>';
                    }
                }
                ?>
            </ul>
        </p>

        <p>
        <h2>РЕДАКЦИОННЫЙ СОВЕТ</h2>
        <ul>
            <?php
            foreach ($sovet as $value) {
                if ($value->user_id != 0) {
                    $user = get_user_by('ID', $value->user_id);
                    $user_meta = get_user_meta($value->user_id);

//                        var_dump($user_meta);

                    echo '<li>';
                    if ($value->post != '') {
                        echo "<em>$value->post:</em><br>";
                        ;
                    }

                    $name = "<a href='" . get_author_posts_url($user->ID, $user->user_nicename) . "'>" . $user_meta['us_full-name'][0] . "</a>";

                        $edit_link = " -> <a class='edit-link' href='" . home_url() . "/wp-admin/user-edit.php?user_id=" . $user->ID . "' target='_blank' style='color: dodgerblue;'>Редактировать</a>";

                        if (isset($user_meta['us_post'][0]) && $user_meta['us_post'][0] != '') {
                            $post = ', ' . $user_meta['us_post'][0];
                        } else {
                            $post = '<br>';
                        }

                        if (is_user_logged_in()) {
                            echo $name . $edit_link . $post;
                        } else {
                            echo $name . $post;
                        }

//                echo '</li>';
                }
            }
            ?>
        </ul>
        </p>


        <p>    
        <h2>МЕЖДУНАРОДНЫЙ РЕДАКЦИОННЫЙ СОВЕТ</h2>
        <ul>
            <?php
            foreach ($int_sovet as $value) {
                if ($value->user_id != 0) {
                    $user = get_user_by('ID', $value->user_id);
                    $user_meta = get_user_meta($value->user_id);

//                        var_dump($user_meta);

                    echo '<li>';
                    if ($value->post != '') {
                        echo "<em>$value->post:</em>";
                    }

                    $name = "<a href='" . get_author_posts_url($user->ID, $user->user_nicename) . "'>" . $user_meta['us_full-name'][0] . "</a>";

                        $edit_link = " -> <a class='edit-link' href='" . home_url() . "/wp-admin/user-edit.php?user_id=" . $user->ID . "' target='_blank' style='color: dodgerblue;'>Редактировать</a>";

                        if (isset($user_meta['us_post'][0]) && $user_meta['us_post'][0] != '') {
                            $post = ', ' . $user_meta['us_post'][0];
                        } else {
                            $post = '<br>';
                        }

                        if (is_user_logged_in()) {
                            echo $name . $edit_link . $post;
                        } else {
                            echo $name . $post;
                        }

//                echo '</li>';
                }
            }
            ?>
        </ul>
        </p>

        </div>

        <!--<div class="feedback">
        <?php wp_link_pages(); ?>
        <?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)')); ?>
        </div>-->

        </div>

        <!--<?php comments_template(); // Get wp-comments.php template   ?>-->

    <?php
    endwhile;
else:
    ?>
    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>