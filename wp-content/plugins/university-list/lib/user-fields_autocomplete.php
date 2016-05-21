<?php

add_action('admin_init', 'user_profile_fields_autocomplete');

function user_profile_fields_autocomplete() {

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
    add_action('admin_footer', 'user_profile_fields_autocomplete_js');
}

/**
 * Disables/hide selected fields in WP Admin user profile (profile.php, user-edit.php)
 */
function user_profile_fields_autocomplete_js() {
    ?>
    <script type="text/javascript">
        <?php require_once 'js/job-select.js'; ?>
        
        
    jQuery(document).ready(function ($) {
            
        // about autocomlite
        add_btn = '<p>\n\
                    <input id="about-auto" class="button" type="button" value="Заполнить биографию" name="autocomplite-btn">\n\
                    </p>\n\
                    <p><span style="color: red">При автозаполнении текущая информация в поле "Биография" будет потеряна</span></p>';
//        $('#description').parent('td').parent('tr').append(add_btn);
        $('#userphoto').after(add_btn);
        $('input#about-auto').on('click',
                    (function (e) {
                        autocomplite_about();
                    })
                    );
        
        // user autocomplite
            name = $('input#first_name').val();
            $('input#us_full-name').val(name);
            add_btn = '<p><input id="autocomplite-btn" class="button" type="button" value="Заполнить поля" name="autocomplite-btn"></p>';
            $('tr:has("td input#us_full-name")').append(add_btn);
            $('input#autocomplite-btn').on('click',
                    (function (e) {
                        name = $('input#us_full-name').val();
                        autocomplite_fields(name);
                    })
                    )
        });
        
        jQuery('input#us_full-name').on('focusout',
                (function (e) {
                    autocomplite_fields(e.target.value);
                })
                );
        
        // outocomplite city & adress ENG
        jQuery('input#eng-fields-auto').on('click', function(){
           var city = jQuery('input#add_job_city').val(); 
           var adress = jQuery('#add_job_adress').val(); 
           var city_en = tranaslat(city);
           var adress_en = tranaslat(adress);
           jQuery('input#add_job_city_en').val(city_en); 
           jQuery('#add_job_adress_en').val(adress_en); 
           
        });
        
        function autocomplite_about() {
            if (confirm ("Текущая биография будет потеряна. Вы действительно хотите заполнить биографию пользовотеля?")) {
                var full_name = jQuery('input#us_full-name').val();
                var post = jQuery('input#us_post').val();
                var job_adress = jQuery('textarea#job_adress').val();

                if (post) {
                    post = ', ' + post;
                }
                if (job_adress) {
                    job_adress = ', ' + job_adress;
                }
                about = full_name + post + job_adress;

//                jQuery('#description').val(about);
//                jQuery('body#tinymce').html(about);
                
//                jQuery('form#your-profile').submit();

                var editor = tinymce.get('description');
                editor.setContent(about);
                
            }
            
                
           
            
        };



        function autocomplite_fields(name) {
            var f_name, l_name, pat, ini;

            rename_fields(name);

    //            fullname_field = jQuery('input#us_full-name');
            firstname_field = jQuery('input#us_first-name');
            lastname_field = jQuery('input#us_last-name');
            patronymic_field = jQuery('input#us_patronymic');
            initials_field = jQuery('input#us_initials');
            name_en_field = jQuery('input#us_name_en');
            initials_en_field = jQuery('input#us_initials_en');
            display_name_field = jQuery('select#display_name');

            name = name.split(' ', 3);
            switch (name.length) {
                case 1:
                    l_name = name[0];
                    break;
                case 2:
                    l_name = name[0];
                    name[1] = name[1].split('.');
                    if (name[1].length == 1) {
                        f_name = name[1][0];
                        ini = (f_name.split(''))[0] + '.';
                    } else {
                        f_name = name[1][0];
                        pat = name[1][1];
                        ini = (f_name.split(''))[0] + '.' + (pat.split(''))[0] + '.';
                    }
                    break;
                case 3:
                    l_name = name[0];
                    f_name = name[1];
                    pat = name[2];
                    ini = (f_name.split(''))[0] + '.' + (pat.split(''))[0] + '.';
                    break;
            }

            if (f_name) {
                firstname_field.val(f_name);
            } else {
                firstname_field.val('');
            }

            if (l_name) {
                lastname_field.val(l_name);
                name_en = tranaslat(l_name);
                name_en_field.val(name_en);
            } else {
                lastname_field.val('');
                name_en_field.val('');
            }

            if (pat) {
                patronymic_field.val(pat);
            } else {
                patronymic_field.val('');
            }
            if (ini) {
                initials_field.val(ini);
                ini_en = tranaslat(ini);
                initials_en_field.val(ini_en);
            } else {
                initials_field.val('');
                initials_en_field.val('');
            }
            
            // change display name
            
            if(f_name){f_name = ' ' + f_name}else{f_name = ''};
            display_name_field.append('<option>'+ l_name + f_name +'</option>');
            
            if (ini){ini = ' ' + ini;}else{ini = ''};
            display_name_field.append('<option>'+ l_name + ini +'</option>');
            display_name_field.val(l_name + ini);

            // rename value hidden fields
            function rename_fields(name) {
                jQuery('input#first_name').val(name);
                jQuery('input#nickname').val(tranaslat(name));
            }

            //
            // translate to lat
            //
            
        }
        
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
        
    </script>
    <?php

}
?>