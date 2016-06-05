<?php
/*
 * Add user custom fields
 */

$extra_fields = array(
    array('us_full-name', 'Полное имя (ФИО)', false),
    array('us_last-name', 'Фамилия', false),
    array('us_first-name', 'Имя', false),
    array('us_patronymic', 'Отчество', false),
    array('us_initials', 'Инициалы', false),
    array('us_name_en', 'Фамилия - eng', false),
    array('us_initials_en', 'Инициалы - eng', false),
//                    array( 'us_job', __('Job'), false ),
                    array( 'us_post', 'Должность', false ),
                    array( 'us_post_en', 'Должность - eng', false ),
);

// Use the user_contactmethods to add new fields
add_filter('user_contactmethods', 'ul_add_user_contactmethods');

// Add our fields to the registration process
add_action('register_form', 'ul_register_form_display_extra_fields');
add_action('user_register', 'ul_user_register_save_extra_fields', 100);

/**
 * Add custom users custom contact methods
 *
 * @access      public
 * @since       1.0 
 * @return      void
 */
function ul_add_user_contactmethods($user_contactmethods) {

    // Get fields
    global $extra_fields;

    //Hide useless fields

    unset($user_contactmethods['aim']);
    unset($user_contactmethods['jabber']);
    unset($user_contactmethods['yim']);


    // Display each fields
    foreach ($extra_fields as $field) {
        if (!isset($contactmethods[$field[0]]))
            $user_contactmethods[$field[0]] = $field[1];
    }

    // Returns the contact methods
    return $user_contactmethods;
}

/**
 * Show custom fields on registration page
 *
 * Show custom fields on registration if field third parameter is set to true
 *
 * @access      public
 * @since       1.0 
 * @return      void
 */
function ul_register_form_display_extra_fields() {

    // Get fields
    global $extra_fields;

    // Display each field if 3th parameter set to "true"
    foreach ($extra_fields as $field) {
        if ($field[2] == true) {
            if (isset($_POST[$field[0]])) {
                $field_value = $_POST[$field[0]];
            } else {
                $field_value = '';
            }
            ?>
            <p>
                <label for="<?php echo $field[0]; ?>"><?php echo $field[1]; ?><br />
                    <input type="text" name="<?php echo $field[0]; ?>" id="<?php echo $field[0]; ?>" class="input" value="<?php echo $field_value; ?>" size="20" /></label>
            </label>
            </p>
            <?php
        } // endif
    } // end foreach
}

/**
 * Save field values
 *
 * @access      public
 * @since       1.0 
 * @return      void
 */
function ul_user_register_save_extra_fields($user_id, $password = '', $meta = array()) {

    // Get fields
    global $extra_fields;

    $userdata = array();
    $userdata['ID'] = $user_id;

    // Save each field
    foreach ($extra_fields as $field) {
        if ($field[2] == true) {
            $userdata[$field[0]] = $_POST[$field[0]];
        } // endif
    } // end foreach

    $new_user_id = wp_update_user($userdata);
}

// add job fields
function job_add_custom_user_profile_fields($user) {
    $job_id = esc_attr(get_the_author_meta('job_id', $user->ID));
    ?>
    <h3>Сведения о месте работы</h3>

    <table class="form-table">
        <tr valign="top" hidden="">
            <th scope="row"><?php _e('ID') ?></th>
            <td><input id="job_id" class="regular-text job" type="text" name="job_id" value="<?php echo $job_id ?>" /></td>
        </tr>

        <tr >
            <th scope="row">Место работы</th>
            <td>
    <!--                <input class="regular-text job" id="job_name" type="text" name="job_name" value="<?php echo get_job_name($job_id); ?>" placeholder="<?php echo _('Select Job') ?>">
                <datalist id="jobTitle">

                </datalist>-->
                <select id="job-select" name="job_name" style="width: 350px" >
<!--                    <option value="<?php // echo $job_id;  ?>" selected="selected"><?php // echo get_job_name($job_id);  ?></option>-->
                    <?php
                    $select_options = '';

                    $selected = '';
                    $not_selected = 'selected="selected"';

                    $jobs = get_data_from_db('', false, false, true);

                    foreach ($jobs as $job) {
                        if ($job['id'] == $job_id) {
                            $selected = 'selected="selected"';
                            $not_selected = '';
                        } else {
                            $selected = '';
                        }

                        $select_options .= '<option value="' . $job['id'] . '" ' . $selected . ' job_name="' . $job['job_name'] . '" job_city="' . $job['city'] . '" job_adress="' . $job['adress'] . '">' . $job['job_name'] . '</option>';
                    }

                    $default_select_options = '<option ' . $not_selected . '>--Выберите место работы--</option>';

                    echo $default_select_options . $select_options;
                    ?>
                </select>
            </td>
            <td>
                <img hidden align='left' id="loading-image" src="<?php echo plugins_url('university-list'); ?>/image/loading.gif" height="30px" />
            </td>
            <td>

                <p id="add">
                    <a id="job-add-toggle" > + Добавить новое место работы </a>
                </p>
                <div class="postbox job-postbox" style="width: 250px" hidden>
                    <div class="inside" style="pedding: 20">

                        <div id="table-add">
                            <table>
                                <tr><input id="add_job_name" class="add-job-input" type="text" name="add_job_name" placeholder="Место работы" style="width: 100%"/></tr>
                                <tr><input id="add_job_city" class="add-job-input" type="text" name="add_job_city" placeholder="Город" style="width: 100%" /></tr>
                                <tr><textarea id="add_job_adress" class="add-job-input" type="text" name="add_job_adress" placeholder="Адресс" style="width: 100%"></textarea></tr>
                                <tr><input id="add_job_name_en" class="add-job-input" type="text" name="add_job_name_en" placeholder="Место работы - eng" style="width: 100%"/></tr>
                                <tr><input id="add_job_city_en" class="add-job-input" type="text" name="add_job_city_en" placeholder="Город - eng" style="width: 100%" /></tr>
                                <tr><textarea id="add_job_adress_en" class="add-job-input" type="text" name="add_job_adress_en" placeholder="Адресс - eng" style="width: 100%"></textarea></tr>
                                
                            
                            <tr><input id="eng-fields-auto" value="Заполнить английские поля" type='button' class="button" style="width: 100%; margin-bottom: 5px;"></tr>
                            <tr><input id="add_job_submit" value="Добавить" type='button' class="button button-primary" style="width: 100%"></tr>
                                
                            </table>
                            <p id="err-message" hidden></p>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

        <tr hidden valign="top">
            <th scope="row"><?php _e('City') ?></th>
            <td><input id="job_city" class="regular-text job" type="text" name="job_city" required="" value="<?php echo get_job_city($job_id); ?>" /></td>
        </tr>

        <tr hidden valign="top">
            <th scope="row"><?php _e('Adress') ?></th>
            <td><textarea id="job_adress" class="job" name="job_adress" style="width: 350px"><?php echo get_job_adress($job_id); ?></textarea></td>
        </tr>
        
        <tr hidden valign="top">
            <th scope="row"><?php _e('Adress - en') ?></th>
            <td><textarea id="job_adress_en" class="job" name="job_adress_en" style="width: 350px"><?php echo get_job_adress_en($job_id); ?></textarea></td>
        </tr>
    </table>
    <?php
}

function job_save_custom_user_profile_fields($user_id) {

    if (!current_user_can('edit_user', $user_id))
        return FALSE;

    update_usermeta($user_id, 'job_id', $_POST['job_id']);
}

add_action('show_user_profile', 'job_add_custom_user_profile_fields');
add_action('edit_user_profile', 'job_add_custom_user_profile_fields');

add_action('personal_options_update', 'job_save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'job_save_custom_user_profile_fields');
