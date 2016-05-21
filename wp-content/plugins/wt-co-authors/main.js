/*
 * Javascript for post-edit.php
 */

/*
 * English cotegory autocomplete
 */
jQuery(document).ready(function ($) {

var cb = jQuery('#categorychecklist').children('li').children('label').children('input');
    jQuery(cb).change(function(e){
        if (this.checked) {
            jQuery.ajax({
                method: 'post',
                url: ajaxurl,
                data: {action: 'get-english-cat', id: e.target.value},
                dataType: 'json',
                success: function(response){
                    jQuery('input#acf-field-cat_en').val(response['data']);
                }
            });
        }
        
    });

});
/*
 * Select Authors
 */
jQuery(document).ready(function ($) {

    jQuery(".sel-authors").select2({
        placeholder: "--Выберите автора--",
        "language": {
            "noResults": function () {
                return 'Такого автора не найдено - <a href="user-new.php" target=" _blank" class="btn btn-danger">создать нового автора</a>';
            }
        },
        escapeMarkup: function (markup) {
            return markup;
        }
    });
});

/*
 * Add/Remove selects & buttons
 */

jQuery(document).ready(function ($) {
      
    
    // hide fields
//    jQuery('.sel-authors:first').attr('required', 'required');
    
    var raws = jQuery('.raw-author:not(:first)');
    var sel = raws.children('select');
    sel.each(function () {
        if (jQuery(this).val() === '') {
            jQuery(this).parent('div').hide();
        }
    }
    );

    // add acrion button
    jQuery('.add-authors').on('click', function () {
        var i = +jQuery(this).attr('pos');
        if (this.value == "+") {
            jQuery(this).val('-');
            jQuery('div.raw-author:has([pos="' + (i + 1) + '"])').show();
        } else {
            hideRaw(i);
        }
    });

});

function hideRaw(pos) {
    var pos_max = +jQuery('div.raw-author:last').attr('pos');
    for (i = pos; i < pos_max; i++) {
        var sel_1 = jQuery('select#sel-authors' + i);
        var value = jQuery('select#sel-authors' + (i + 1)).val();
        jQuery(sel_1).val(value).trigger("change");
        
        if (value == "") {
            var raw = jQuery('select#sel-authors' + i).parent('div');
            deleteLink(raw);
        }
        
    }
    jQuery('.sel-authors:last').select2("val", ""); 
    var raw = jQuery('.sel-authors:last').parent('div');
    deleteLink(raw);
    
        
    jQuery('div.raw-author:visible:last').hide();
    jQuery('.add-authors:visible:last').val('+');
    
    
}




/*
 * Refresh select data 
 */
jQuery('#refresh-authors').on('click', function () {
    jQuery('#au_loading_img').show();
    jQuery.ajax({
        method: 'post',
        url: ajaxurl,
        data: {action: 'get-authors', role: 'subscriber'},
        dataType: 'json',
        success: function (response) {
            var selected_authors = [];
            jQuery('.sel-authors').children('option[selected]').each(
                    function (n) {
                        selected_authors[n] = this.value;
                    }
            );
            jQuery('.sel-authors').children(':not(option[selected])').remove();
            var new_options = '';
            for (i = 0; i < response['data'].length; i++) {
                var name = response['data'][i]['data']['display_name'];
                if (!arraySearchByValue(selected_authors, name)) {
                    new_options += '<option value="' + name + '">' + name + '</option>';
                }
            }
            jQuery('.sel-authors').append(new_options);
            jQuery('#au_loading_img').hide();
        }
    });

});

function arraySearchByValue(arr, val) {
    for (var i = 0; i < arr.length; i++)
        if (arr[i] === val)
            return true;
    return false;
}

function deleteLink(raw){
    if (jQuery(raw).children('a.edit-link').length > 0) {
        jQuery(raw).children('a.edit-link').remove();
    }
}

function addLink(raw, id){
    var pathArray = location.href.split( '/' ),
    protocol = pathArray[0],
    host = pathArray[2],
    url = protocol + '//' + host;
    
    var link = '<a class="edit-link" href="' +  url + '/wp-admin/user-edit.php?user_id=' + id + '" target="_blank">Редактировать</a>';
    jQuery(raw).append(link); 
}

jQuery(".sel-authors").on('change', function(){
    var raw = jQuery(this).parent('div');
    var id = jQuery(this).children('option:selected').attr("user_id");
    deleteLink(raw);
    addLink(raw, id);
});