function jobFieldsReset() {
    jQuery('#job_id').val('');
    jQuery('#job_city').val('');
    jQuery('#job_adress').val('');
}

function showFieldsJob(res) {
    jQuery('#job_id').val(res['id']);
    jQuery('#job_city').val(res['city']);
    jQuery('#job_adress').val(res['adress']);
}

// действие при выборе места работы
function select_Job(job_name) {
    var data = {action: 'show', name: job_name};
    jQuery.post(ajaxurl, data,
            function (response) {
                if (response['status']) {
                    showFieldsJob(response['data'][0]);
                } else {
                    jobFieldsReset();
                    jQuery('#add_job_name').val(job_name);
                }
                show_message(response['status']);
            },
            'json'
            );
}


/*
 * job-name select
 */

jQuery(document).ready(function ($) {
//    loadStore();
});

jQuery('#job-select').select2();

jQuery('#job-select').on('change', function (e) {
    jobFieldsReset();
    if (e.target.value == 0) {
        jobFieldsReset();
    } else {
        var fields = [];
        fields['id'] = e.target.value;
        fields['city'] = jQuery(this).children('option[value='+e.target.value+']').attr('job_city');
        fields['adress'] = jQuery(this).children('option[value='+e.target.value+']').attr('job_adress');
        showFieldsJob(fields);
    }
});

var store = [];
function loadStore() {
    jQuery('#loading-image').show();
    jQuery.ajax({
        method: 'post',
        url: ajaxurl,
        data: {action: 'get-store'},
        dataType: 'json',
        success: function (response) {
            var selected_job;
            jQuery('#job-select').children('option[selected]').each(
                    function (n) {
                        selected_job = this.value;
                    }
            );
            jQuery('#job-select').children(':not(option[selected])').remove();
            var new_options = '';
//            var new_options = '<option>--Выберите место работы--</option>';
            for (i=0; i < response['data'].length; i++){
                var job = response['data'][i];
                if (!arraySearchByValue(selected_job, job)){
                    new_options += '<option value="' + job['id'] + '" job_name="' + job['job_name'] + '" job_city="' + job['city'] + '" job_adress="' + job['adress'] + '">' + job['job_name'] + '</option>';
                }
            }
            jQuery('#job-select').append(new_options);
            jQuery('#loading-image').hide();
        }
    });
}

function arraySearchById(arr, val) {
    for (var i = 0; i < arr.length; i++)
        if (arr[i]['id'] === val)
            return i;
    return false;
}

function arraySearchByValue(arr, val) {
    for (var i = 0; i < arr.length; i++)
        if (arr[i] === val)
            return true;
    return false;
}

/*
 * Add new job
 */

jQuery('#add').on('click', function () {
    var table = jQuery('.job-postbox');
    if (table.is(':visible')) {
        table.hide();
    } else {
        table.show();
    }
});
jQuery('input#add_job_submit').on('click', function ($) {
    var data = {
        action: 'new',
        id: '',
        job_name: jQuery('#add_job_name').val(),
        job_city: jQuery('#add_job_city').val(),
        job_adress: jQuery('#add_job_adress').val(),
        job_name_en: jQuery('#add_job_name_en').val(),
        job_city_en: jQuery('#add_job_city_en').val(),
        job_adress_en: jQuery('#add_job_adress_en').val()
    };
    if (data["job_name"] == '') {
        var message = 'Введите название организации';
        jQuery('#err-message').text(message);
        jQuery('#err-message').show();
    } else {
        jQuery('#err-message').hide();
        jQuery.post(ajaxurl, data,
                function (response) {
                    if (response['status']) {
//                    showFieldsJob(response['data'][0]);

                        store.push = {id: response['data']['id'], text: response['data']['job_name'], city: response['data']['city'], adress: response['data']['adress']};

                        loadStore();

                        var message = 'Место работы добавлено';
                        jQuery('#err-message').text(message);
                        jQuery('#err-message').attr('style', 'color: green');
                        jQuery('#err-message').show();
                    }
                    ;
//                    jQuery('#job-select').select2().val('3').trigger('change');
                },
                'json'
                );

    }
});