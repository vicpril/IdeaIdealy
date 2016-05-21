<?php

add_action('admin_init', 'user_profile_fields_disable');

function user_profile_fields_disable() {

    global $pagenow;

    // apply only to user profile or user edit pages
    if ($pagenow !== 'profile.php' && $pagenow !== 'user-edit.php') {
        return;
    }

    // do not change anything for the administrator
//    if (current_user_can('administrator')) {
//        return;
//    }
// 
    add_action('admin_footer', 'user_profile_fields_disable_js');
}

/**
 * Disables/hide selected fields in WP Admin user profile (profile.php, user-edit.php)
 */
function user_profile_fields_disable_js() {
    ?>
    <script>
        jQuery(document).ready(function ($) {

            //replace JOB information
            var fields_to_replace = ['Job information', 'Сведения о месте работы'];
            var fields_before_replaced = ['About Yourself', 'About the user', 'О пользователе'];
            for (i = 0; i < fields_to_replace.length; i++) {
                if ($('h3:contains("' + fields_to_replace[i] + '")').length) {
                    var temp1 = $('h3:contains("' + fields_to_replace[i] + '")');
                    var temp2 = $('h3:contains("' + fields_to_replace[i] + '")').next();
                    
                    for(i = 0; i < fields_before_replaced.length; i++){
                        var field = $('h2:contains("' + fields_before_replaced[i] + '")');
                        if (field.length) {
                            field.before(temp1);
                            field.before(temp2);
                        }
                    }
                }
            }
            
            //replace personal options
            var fields_to_replace = ['Personal Options', 'Персональные настройки'];
            for (i = 0; i < fields_to_replace.length; i++) {
                if ($('h2:contains("' + fields_to_replace[i] + '")').length) {
                    var temp1 = $('h2:contains("' + fields_to_replace[i] + '")');
                    var temp2 = $('h2:contains("' + fields_to_replace[i] + '")').next();
                    $('input[name=action]').before(temp1);
                    $('input[name=action]').before(temp2);
                }
            }
            
            //replace должность
                if ($('th:contains("Должность")').length) {
                    var temp1 = $('th:contains("Должность")').parent('tr');
                    $('select#job-select').parent('td').parent('tr').after(temp1);
                }
            
            // replace button update 
            var temp_btn = $('p.submit');
            $('form').prepend(temp_btn);
            
            //rename contacts options
            var fields_to_rename = ['Contact Info', 'Контакты'];
            for (i = 0; i < fields_to_rename.length; i++) {
                if ($('h3:contains("' + fields_to_rename[0] + '")').length) {
                    $('h3:contains("' + fields_to_rename[0] + '")').text('Addition info');
                }
                if ($('h3:contains("' + fields_to_rename[1] + '")').length) {
                    $('h3:contains("' + fields_to_rename[1] + '")').text('Дополнительная информация');
                }
            }
            
            

            // hide fields
            var fields_to_disable = ['first_name', 'last_name', 'url'];
//            var fields_to_disable = ['first_name', 'last_name', 'nickname', 'display_name', 'email', 'url'];
            for (i = 0; i < fields_to_disable.length; i++) {
                if ($('#' + fields_to_disable[i]).length) {
                    $('#' + fields_to_disable[i]).parents('tr').hide();
    //                    $('#'+ fields_to_disable[i]).attr('disabled', 'disabled');
                }
            }
            
            
            
        });
    </script>
    <?php

}
?>