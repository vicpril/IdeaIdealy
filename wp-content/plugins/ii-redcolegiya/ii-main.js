/*
 * Select users
 */
jQuery(document).ready(function ($) {
    var copy_opt = jQuery('.users:last').html();


    /*
     * Prepare
     */

    prepare(jQuery('.users').parent('td').parent('tr'), copy_opt);

    /*
     * Refresh select data 
     */
    jQuery('.refresh-authors').on('click', function () {
        jQuery('.au_loading_img').show();
        jQuery.ajax({
            method: 'post',
            url: ajaxurl,
            data: {action: 'get-authors', role: 'subscriber'},
            dataType: 'json',
            success: function (response) {
                var selected_authors = [];
                jQuery('.users').children('option[selected]').each(
                        function (n) {
                            selected_authors[n] = this.value;
                        }
                );
                jQuery('.users').children(':not(option[selected])').remove();
                var new_options = '';
                for (i = 0; i < response['data'].length; i++) {
                    var name = response['data'][i]['data']['display_name'];
                    var id = response['data'][i]['data']['ID'];
                    if (!arraySearchByValue(selected_authors, name)) {
                        new_options += '<option value="' + id + '">' + name + '</option>';
                    }
                }
                jQuery('.users').append(new_options);

                jQuery('.au_loading_img').hide();
            }
        });
    });

    /*
     * Add/Remove selects & buttons
     */
    var raws = jQuery('.raw-user:not(tr[pos=1])');
    var sel = raws.children('td').children('select');
    sel.each(function () {
        if (jQuery(this).val() === 'NULL') {
            jQuery(this).parent('td').parent('tr').hide();
        }
    }
    );
});

function push_up(tbody, pos) {
    var last_visible = +jQuery(tbody).children('tr:visible:last').attr('pos');

    for (i = pos; i <= last_visible; i++) {

        var value = jQuery(tbody).children('tr').children('td').children('select[pos=' + (i + 1) + ']').val();

        var sel_1 = jQuery(tbody).children('tr').children('td').children('select[pos=' + (i) + ']');

        jQuery(sel_1).val(value).trigger("change");

        var post = jQuery(tbody).children('tr').children('td').children('input.post[pos=' + (i + 1) + ']').val();
        jQuery(tbody).children('tr').children('td').children('input.post[pos=' + (i) + ']').val(post);
        jQuery(tbody).children('tr').children('td').children('input.post[pos=' + (i + 1) + ']').val('');



    }

    jQuery(tbody).children('tr[pos=' + last_visible + ']').children('td').children('select').val('NULL').trigger('change');

}

function push_down(tbody, pos) {
    var last_visible = +jQuery(tbody).children('tr:visible:last').attr('pos');

    for (i = last_visible; i >= pos; i--) {

        var value = jQuery(tbody).children('tr').children('td').children('select[pos=' + i + ']').val();

        var sel_1 = jQuery(tbody).children('tr').children('td').children('select[pos=' + (i + 1) + ']');

        jQuery(sel_1).val(value).trigger("change");

        var post = jQuery(tbody).children('tr').children('td').children('input.post[pos=' + (i) + ']').val();
        jQuery(tbody).children('tr').children('td').children('input.post[pos=' + (i + 1) + ']').val(post);
        jQuery(tbody).children('tr').children('td').children('input.post[pos=' + (i) + ']').val('');

    }

    jQuery(tbody).children('tr[pos=' + pos + ']').children('td').children('select').val('NULL').trigger('change');

}



function arraySearchByValue(arr, val) {
    for (var i = 0; i < arr.length; i++)
        if (arr[i] === val)
            return true;
    return false;
}

function deleteLink(raw) {
    if (jQuery(raw).children('td').children('a.edit-link').length > 0) {
        jQuery(raw).children('td').children('a.edit-link').parent('td').remove();
    }
}

function addLink(raw, id) {
    var pathArray = location.href.split('/'),
            protocol = pathArray[0],
            host = pathArray[2],
            url = protocol + '//' + host;

    var link = '<td><a class="edit-link" href="' + url + '/wp-admin/user-edit.php?user_id=' + id + '" target="_blank">Редактировать</a></td>';
    jQuery(raw).append(link);
}

function prepare(items, copy_opt) {

    /*
     * Select2
     */
    jQuery(items).find('.users').select2({
        placeholder: "--Выберите пользователя--",
        "language": {
            "noResults": function () {
                return 'Такого пользователя не найдено - <a href="user-new.php" target=" _blank" class="btn btn-danger">создать нового автора</a>';
            }
        },
        escapeMarkup: function (markup) {
            return markup;
        }
    });

    /*
     * Change link
     */
    jQuery(items).find('.users').on('change', function () {
        var raw = jQuery(this).parent('td').parent('tr');
        var id = jQuery(this).children('option:selected').attr("user_id");
        deleteLink(raw);
        if (id != "NULL") {
            addLink(raw, id);
        }
    });

    //     add action on ADD button
    jQuery(items).find('.add-users').on('click', function () {
        var i = +jQuery(this).attr('pos');



        var tbody = jQuery(this).parent('td').parent('tr').parent('tbody');
        var last_position = +jQuery(tbody).children('tr:last').attr('pos');

        var last_visible = +jQuery(tbody).children('tr:visible:last').attr('pos');

        // add new raw
        var type = jQuery(this).parent('td').parent('tr').children('td:first').children('input').attr('raw_type');
        var val = jQuery(this).parent('td').parent('tr').children('td:first').children('input').val();

        temp = get_raw_template(last_position + 1, type, val, copy_opt);
        jQuery(tbody).append(temp);

        prepare(jQuery(tbody).children('tr:last'), copy_opt);


        jQuery(tbody).children('tr:last').children('td').children('select').val('NULL').trigger("change");

        push_down(tbody, i + 1);

        jQuery(tbody).children('tr[pos=' + (last_visible + 1) + ']').show();
    });

//     add action on REMOVE button
    jQuery(items).find('.remove-users').on('click', function () {
        var i = +jQuery(this).attr('pos');

        var tbody = jQuery(this).parent('td').parent('tr').parent('tbody');
        var last_visible = +jQuery(tbody).children('tr:visible:last').attr('pos');

        push_up(tbody, i);

        if (last_visible != 1) {
            jQuery(tbody).children('tr[pos=' + (last_visible) + ']').hide();
        }

    });

}

function get_raw_template(i, type, val, options) {
    temp = '<tr pos="' + i + '" class="raw-user">                            <td>                                <input type="text" hidden="" "="" value="' + val + '" raw_type="' + type + '" name="data[' + type + '][' + i + '][groupe]">                            </td>                            <td>                                <input type="text" value="" placeholder="Должность" style="width: 350px;" pos="' + i + '" name="data[' + type + '][' + i + '][post]" class="post">                            </td>                            <td>                                <select style="width: 350px; " pos="' + i + '" class="users" name="data[' + type + '][' + i + '][user_id]" type="text"> ' + options + '                </select></td>                            <td>                                <input type="button" value="+" style="margin-left: 20px; margin-right: 2px;" pos="' + i + '" class="add-users button">                            </td>                            <td>                                <input type="button" value="X" style="margin-left: 2px; margin-right: 20px;" pos="' + i + '" class="remove-users button">                            </td>                        </tr>';
    return temp;

}