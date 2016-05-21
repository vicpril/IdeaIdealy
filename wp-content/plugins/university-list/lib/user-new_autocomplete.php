<?php

add_action('admin_init', 'user_new_fields_autocomplete');

function user_new_fields_autocomplete() {

    global $pagenow;

    // apply only to user profile or user edit pages
    if ($pagenow !== 'user-new.php') {
        return;
    }

    // do not change anything for the administrator
//    if (current_user_can('administrator')) {
//        return;
//    }
// 
    add_action('admin_footer', 'user_new_fields_autocomplete_js');
}

/**
 * Disables/hide selected fields in WP Admin user profile (profile.php, user-edit.php)
 */
function user_new_fields_autocomplete_js() {
    ?>
    <script>
        
        // uncheck post mail
        jQuery('input#send_user_notification').attr('checked', false);
        
        // hide fields
        jQuery('input#send_user_notification').parent('label').parent('td').parent('tr').hide();
        jQuery('input#url').parent('td').parent('tr').hide();
        jQuery('input#last_name').parent('td').parent('tr').hide();
        
        // replace field
        var fields_to_replace = ['First Name', 'Имя'];
        for (i = 0; i < fields_to_replace.length; i++) {
            field = jQuery('tr:has("td input#first_name")')
            if (field) {
                jQuery('tbody:first').before(field);
            }
        }
        field = jQuery('tr:has("td input#first_name") th');
        field.html(field.html() + '<span class="description">(заполните первым)</span>');


        jQuery('input#first_name').on('focusout',
                (function (e) {
                    autocomplite_fields(e.target.value);

                })
                );

        function autocomplite_fields(name) {

            jQuery('input#user_login').val(tranaslat(name));
            // insert default email
            jQuery('input#email').val(strtr(tranaslat(name), {" ": "-", ".": "-"}) + '@localhost.lo');

            //
            // translate to lat
            //
            function tranaslat($title) {
                $gost1 = {
                    "Є": "EH", "І": "I", "і": "i", "№": "#", "є": "eh",
                    "А": "A", "Б": "B", "В": "V", "Г": "G", "Д": "D",
                    "Е": "E", "Ё": "JO", "Ж": "ZH",
                    "З": "Z", "И": "I", "Й": "JJ", "К": "K", "Л": "L",
                    "М": "M", "Н": "N", "О": "O", "П": "P", "Р": "R",
                    "С": "S", "Т": "T", "У": "U", "Ф": "F", "Х": "KH",
                    "Ц": "C", "Ч": "CH", "Ш": "Sh", "Щ": "Shh", "Ъ": "'",
                    "Ы": "Y", "Ь": "", "Э": "EH", "Ю": "YU", "Я": "YA",
                    "а": "a", "б": "b", "в": "v", "г": "g", "д": "d",
                    "е": "e", "ё": "jo", "ж": "zh",
                    "з": "z", "и": "i", "й": "jj", "к": "k", "л": "l",
                    "м": "m", "н": "n", "о": "o", "п": "p", "р": "r",
                    "с": "s", "т": "t", "у": "u", "ф": "f", "х": "kh",
                    "ц": "c", "ч": "ch", "ш": "sh", "щ": "shh", "ъ": "",
                    "ы": "y", "ь": "", "э": "eh", "ю": "yu", "я": "ya", "«": "", "»": "", "—": "-"
                };
                return strtr($title, $gost1);
            }


            function strtr(string, dictionary) {
                return string.replace(/[\s\S]/g, function (x) {
                    if (dictionary.hasOwnProperty(x))
                        return dictionary[ x ];
                    return x;
                });
            }
            ;
        }
    </script>
    <?php

}
?>