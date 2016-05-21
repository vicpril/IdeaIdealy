<?php
/*
 * Add JS in menu page
 */
add_action('admin_enqueue_scripts', 'add_script_for_ii');

function add_script_for_ii() {
    global $pagenow;

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = '';
    }

    if ($pagenow === 'users.php' && $page === 'redcolegia') {

        define('II_PATH', plugins_url('ii-redcolegiya'));

        wp_register_script('ii-main', II_PATH . '/ii-main.js', array('jquery'));

        wp_enqueue_script('ii-main');
    }
}

/*
 * Add menu page
 */
add_action('admin_menu', 'register_red_menu');

function register_red_menu() {
    $hook = add_submenu_page('users.php', 'Редколлегия и редсовет', 'Редколлегия и редсовет', 'manage_options', 'redcolegia', 'redcolegia_page');
}

function redcolegia_page() {
    global $wpdb;

    $table_name = $wpdb->prefix . "journal_editors";

    if (isset($_REQUEST['action'])) {
        $action = $_REQUEST['action'];
    } else {
        $action = '';
    }

    if ($action == 'save') {
        $data = $_POST['data'];

        $wpdb->query("TRUNCATE $table_name");

        foreach ($data as $groupe) {
            foreach ($groupe as $key => $user) {
                if ($user['user_id'] != "NULL") {
                    foreach ($user as $value) {
                        $value = $wpdb->escape($value);
                    }
                } else {
                    unset($groupe[$key]);
                }
            }

            foreach ($groupe as $value) {
                $success ['status'] = $wpdb->insert($table_name, $value);
                $success ['insert_id'] = $wpdb->insert_id;

                if (!$success['status']) {
                    die('Ошибка записи в БД');
                }
            }
        }
    }

    define('MAX_ROWS', 7);

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


//    var_dump($values);
//    var_dump($redakcia);
//    var_dump($sovet);
//    var_dump($int_sovet);
//    print_r($values[0]->user_id);
    ?>

    <div class="wrap">
        <h1>Список редколлегии и редсовета</h1>

        <div>
            <a href="<?php echo home_url() . '/redkollegiya'; ?>" target="_blank">Посмотреть страницу</a>
        </div>

        <form method="post" action="#">
            <p class="submit">
                <input type="submit" class="button-primary" value="Сохранить" />
            </p>

            <input type="hidden" name="action" value="save" />

            <h2>РЕДАКЦИЯ
                <input type="button" class="refresh-authors preview button" value="Обновить выпадающий список" style=""/>
                <img class="waiting preview au_loading_img"  style="display:none; vertical-align:middle; margin-right:30px;" src="images/loading.gif" alt="" />
            </h2>



            <div class="postbox">

                <table>
                    <?php
                        if (count($redakcia) > 0) {
                            $size = count($redakcia);
                        }else{
                            $size = 1;
                        }
                    
                    for ($i = 1; $i <= $size; $i++) {
                        ?>
                        <tr class="raw-user" pos="<?= $i ?>">
                            <td>
                                <input hidden="" type="text" name="data[red][<?= $i ?>][groupe]" value="редакция" raw_type="red"/>
                            </td>
                            <td>
                                <input type="text" class="post" name="data[red][<?= $i ?>][post]" pos="<?= $i ?>" style="width: 350px;" placeholder="Должность" value="<?php
                                if (isset($redakcia[0])) {
                                    echo $redakcia[0]->post;
                                } else {
                                    echo '';
                                }
                                ?>"/>
                            </td>

                            <td>
                                <select type="text" name="data[red][<?= $i ?>][user_id]" class="users" pos="<?= $i ?>" style="width: 350px; "/>

                                <?php
                                $select_options = '';
                                $selected = '';
                                $empty_option = '<option user_id="NULL" value="NULL" selected="selected">--Выберите пользователя--</option>';

                                $users = get_users('role=subscriber');
                                $link_to_edit = '';
                                $user_id = '';

                                $select = false;

                                foreach ($users as $user) {
                                    $selected = '';
                                    if (!$select) {
                                        if ($user->ID == $redakcia[0]->user_id) {
                                            $selected = 'selected="selected"';
                                            $user_id = $user->ID;
                                            $link_to_edit = '<a class="edit-link" href="' . home_url() . '/wp-admin/user-edit.php?user_id=' . $user_id . '" target="_blank">Редактировать</a>';
                                            $empty_option = '<option user_id="NULL" value="NULL" >--Выберите пользователя--</option>';
                                            array_shift($redakcia);
                                            $select = true;
                                        }
                                        if ($redakcia[0]->user_id == 0) {
                                            array_shift($redakcia);
                                        }
                                    }

                                    $select_options .= '<option user_id="' . $user->ID . '" value="' . $user->ID . '" ' . $selected . '>' . $user->display_name . '</option>';
                                }

                                echo ($empty_option . $select_options);
                                ?>
                            </td>

                            <td>
                                <input type="button" class="add-users button" pos="<?= $i ?>" style="margin-left: 20px; margin-right: 2px;" value="+"/>
                            </td>
                            <td>
                                <input type="button" class="remove-users button" pos="<?= $i ?>" style="margin-left: 2px; margin-right: 20px;" value="X"/>
                            </td>
                            <?php
                            if ($link_to_edit != '') {
                                echo "<td>$link_to_edit</td>";
                            }
                            ?>

                        </tr>
                        <?php
                    }
                    ?>


                </table>
            </div>


            <h2>РЕДАКЦИОННЫЙ СОВЕТ
                <input type="button" class="refresh-authors preview button" value="Обновить выпадающий список" style=""/>
                <img class="waiting preview au_loading_img"  style="display:none; vertical-align:middle; margin-right:30px;" src="images/loading.gif" alt="" />
            </h2>
            <div class="postbox">

                <table>
                    <?php
                    if (count($sovet) > 0) {
                            $size = count($sovet);
                        }else{
                            $size = 1;
                        }
                    for ($i = 1; $i <= $size; $i++) {
                        ?>
                        <tr class="raw-user" pos="<?= $i ?>">
                            <td>
                                <input hidden="" type="text" name="data[sov][<?= $i ?>][groupe]" value="редакционный совет" raw_type="sov"/>
                            </td>
                            <td>
                                <input type="text" class="post" name="data[sov][<?= $i ?>][post]" pos="<?= $i ?>" style="width: 350px;" placeholder="Должность" value="<?php
                                if (isset($sovet[0])) {
                                    echo $sovet[0]->post;
                                } else {
                                    echo '';
                                }
                                ?>"/>
                            </td>

                            <td>
                                <select type="text" name="data[sov][<?= $i ?>][user_id]" class="users" pos="<?= $i ?>" style="width: 350px; "/>

                                <?php
                                $select_options = '';
                                $selected = '';
                                $empty_option = '<option user_id="NULL" value="NULL" selected="selected">--Выберите пользователя--</option>';

                                $users = get_users('role=subscriber');
                                $link_to_edit = '';
                                $user_id = '';

                                $select = false;

                                foreach ($users as $user) {
                                    $selected = '';
                                    if (!$select) {
                                        if ($user->ID == $sovet[0]->user_id) {
                                            $selected = 'selected="selected"';
                                            $user_id = $user->ID;
                                            $link_to_edit = '<a class="edit-link" href="' . home_url() . '/wp-admin/user-edit.php?user_id=' . $user_id . '" target="_blank">Редактировать</a>';
                                            $empty_option = '<option user_id="NULL" value="NULL" >--Выберите пользователя--</option>';
                                            array_shift($sovet);
                                            $select = true;
                                        }
                                        if ($sovet[0]->user_id == 0) {
                                            array_shift($sovet);
                                        }
                                    }

                                    $select_options .= '<option user_id="' . $user->ID . '" value="' . $user->ID . '" ' . $selected . '>' . $user->display_name . '</option>';
                                }

                                echo ($empty_option . $select_options);
                                ?>
                            </td>

                            <td>
                                <input type="button" class="add-users button" pos="<?= $i ?>" style="margin-left: 20px; margin-right: 2px;" value="+"/>
                            </td>
                            <td>
                                <input type="button" class="remove-users button" pos="<?= $i ?>" style="margin-left: 2px; margin-right: 20px;" value="X"/>
                            </td>

                            <?php
                            if ($link_to_edit != '') {
                                echo "<td>$link_to_edit</td>";
                            }
                            ?>

                        </tr>
                        <?php
                    }
                    ?>

                </table>
            </div>


            <h2>МЕЖДУНАРОДНЫЙ РЕДАКЦИОННЫЙ СОВЕТ
                <input type="button" class="refresh-authors preview button" value="Обновить выпадающий список" style=""/>
                <img class="waiting preview au_loading_img"  style="display:none; vertical-align:middle; margin-right:30px;" src="images/loading.gif" alt="" /></h2>
            <div class="postbox">

                <table>
                    <?php
                    if (count($int_sovet) > 0) {
                            $size = count($int_sovet);
                        }else{
                            $size = 1;
                        }
                    for ($i = 1; $i <= $size; $i++) {
                        ?>
                        <tr class="raw-user" pos="<?= $i ?>">
                            <td>
                                <input hidden="" type="text" name="data[intsov][<?= $i ?>][groupe]" value="международный редакционный совет" raw_type="intsov"/>
                            </td>
                            <td>
                                <input type="text" class="post" name="data[intsov][<?= $i ?>][post]" pos="<?= $i ?>" style="width: 350px;" placeholder="Должность" value="<?php
                                if (isset($int_sovet[0])) {
                                    echo $int_sovet[0]->post;
                                } else {
                                    echo '';
                                }
                                ?>"/>
                            </td>

                            <td>
                                <select type="text" name="data[intsov][<?= $i ?>][user_id]" class="users" pos="<?= $i ?>" style="width: 350px; "/>

                                <?php
                                $select_options = '';
                                $selected = '';
                                $empty_option = '<option user_id="NULL" value="NULL" selected="selected">--Выберите пользователя--</option>';

                                $users = get_users('role=subscriber');
                                $link_to_edit = '';
                                $user_id = '';

                                $select = false;

                                foreach ($users as $user) {
                                    $selected = '';
                                    if (!$select) {
                                        if ($user->ID == $int_sovet[0]->user_id) {
                                            $selected = 'selected="selected"';
                                            $user_id = $user->ID;
                                            $link_to_edit = '<a class="edit-link" href="' . home_url() . '/wp-admin/user-edit.php?user_id=' . $user_id . '" target="_blank">Редактировать</a>';
                                            $empty_option = '<option user_id="NULL" value="NULL" >--Выберите пользователя--</option>';
                                            array_shift($int_sovet);
                                            $select = true;
                                        }
                                        if ($int_sovet[0]->user_id == 0) {
                                            array_shift($int_sovet);
                                        }
                                    }

                                    $select_options .= '<option user_id="' . $user->ID . '" value="' . $user->ID . '" ' . $selected . '>' . $user->display_name . '</option>';
                                }

                                echo ($empty_option . $select_options);
                                ?>
                            </td>

                            <td>
                                <input type="button" class="add-users button" pos="<?= $i ?>" style="margin-left: 20px; margin-right: 2px;" value="+"/>
                            </td>
                            <td>
                                <input type="button" class="remove-users button" pos="<?= $i ?>" style="margin-left: 2px; margin-right: 20px;" value="X"/>
                            </td>

                            <?php
                            if ($link_to_edit != '') {
                                echo "<td>$link_to_edit</td>";
                            }
                            ?>

                        </tr>
                        <?php
                    }
                    ?>

                </table>
            </div>



            <p class="submit">
                <input type="submit" class="button-primary" value="Сохранить" />
            </p>


        </form>

    </div>

    <?php
}
