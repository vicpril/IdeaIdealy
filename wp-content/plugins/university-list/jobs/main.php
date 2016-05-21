<?php
include 'uni_table_class.php';

add_action('admin_menu', 'register_jobs_menu_page');

function register_jobs_menu_page() {
    $hook = add_submenu_page('users.php', 'Работа', 'Работа', 'manage_options', 'job-list', 'jobs_menu_page');
}

function jobs_menu_page() {

    $view = (isset($_GET['view'])) ? $_GET['view'] : 'list';
    $action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : '';
//    if ($_POST['action']) {
//        $action = $_POST['action'];
//    }

    switch ($action) {
        case 'delete':
            if (isset($_GET['job_id']) && $_GET['job_id']) {
                $id = $_GET['job_id'];
                $success = delete_job(array('0' => $id));
            }
            if (isset($_POST['job_id'])) {
                $id = $_POST['job_id'];
                $success = delete_job($id);
            }
            unset( $_REQUEST['action'] );
            unset( $_REQUEST['job_id'] );
            break;

        case 'update':
            $post['id'] = (isset($_POST['id'])) ? $_POST['id'] : '';
            $post['job_name'] = (isset($_POST['job_name'])) ? $_POST['job_name'] : '';
            $post['city'] = (isset($_POST['job_city'])) ? $_POST['job_city'] : '';
            $post['adress'] = (isset($_POST['job_adress'])) ? $_POST['job_adress'] : '';
            $post['job_name_en'] = (isset($_POST['job_name_en'])) ? $_POST['job_name_en'] : '';
            $post['city_en'] = (isset($_POST['job_city_en'])) ? $_POST['job_city_en'] : '';
            $post['adress_en'] = (isset($_POST['job_adress_en'])) ? $_POST['job_adress_en'] : '';
            $success = update_job($post);
            unset( $_REQUEST['action'] );
            unset( $_REQUEST['job_id'] );
            break;
    }



    switch ($view) {

        // Страница с полями места работы
        case 'edit':
            if (isset($success['insert_id'])) {
                $job_id = $success['insert_id'];
            } else {
                $job_id = (isset($_GET['job_id'])) ? $_GET['job_id'] : '';
            }
            ?>
            <div class="wrap">
                <h1>Редактирование организации</h1>


                <form method="post" action="<?php printf('?page=job-list&view=%s&job_id=%s', 'list', $job_id); ?>">
                    <?php // wp_nonce_field('update-options');       ?>

                    <table class="form-table">

                        <tr valign="top" hidden>
                            <th scope="row">ID</th>
                            <td><input class="job-field" type="text" name="job_id" disabled="disabled" value="<?php echo $job_id; ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">Название</th>
                            <td><input class="job-field" type="text" name="job_name" required="" value="<?php echo get_job_name($job_id); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">Город</th>
                            <td><input class="job-field" type="text" name="job_city" value="<?php echo get_job_city($job_id); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">Адресс</th>
                            <td><textarea class="job-field" name="job_adress"><?php echo get_job_adress($job_id); ?></textarea></td>
                        </tr>
                        
                        <!--english fields-->
                        <tr valign="top">
                            <th scope="row">Название - eng</th>
                            <td><input class="job-field" type="text" name="job_name_en" value="<?php echo get_job_name_en($job_id); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">Город - eng</th>
                            <td><input class="job-field" type="text" name="job_city_en" value="<?php echo get_job_city_en($job_id); ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">Адресс - eng</th>
                            <td><textarea class="job-field" name="job_adress_en"><?php echo get_job_adress_en($job_id); ?></textarea></td>
                        </tr>

                    </table>

                    <input type="hidden" name="id" value="<?php echo $job_id ?>" />
                    <input type="hidden" name="action" value="update" />

                    <p class="submit">
                        <input type="submit" class="button-primary" value="Сохранить" />
                    </p>

                </form>
            </div>

            <?php
            break;

        // таблица
        case'list':
            ?>
            <h1>
                Организации
                <a href="users.php?page=job-list&view=edit" class="button button-subtle">Добавить новую</a>
            </h1>


                <?php if (isset($success['message']) && $success['message'] == 'update') : ?>
                    <div id="message" class="updated notice is-dismissible">
                        <p><strong>Организация успешно обновлена.</strong></p>
                    </div>
                <?php endif; ?>

            <?php if (isset($success['message']) && $success['message'] == 'add') : ?>
                <div id="message" class="updated notice is-dismissible">
                    <p><strong>Организация добавлена.</strong></p>
                </div>
            <?php endif; ?>

            <form method="post">

                <?php
                $uniListTable = new Uni_List_Table();

                $uniListTable->prepare_items();
                $uniListTable->search_box('search', 'search_id');

                $uniListTable->display();
                ?>
            </form>
            <?php
            break;
    }


//    include( ABSPATH . 'wp-admin/admin-footer.php' );
}
