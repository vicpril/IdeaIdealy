jQuery(document).ready(function ($) {
    
});

jQuery('#export-type').on('change', function(e){
   disable_all();
    if (jQuery(this).val() == 'rinc') {
        jQuery('.for-rinc').attr('disabled', false);
    }
    
    if (jQuery(this).val() == 'emails') {
        jQuery('.for-emails').attr('disabled', false);
    }
});

function disable_all(){
    jQuery('.for-export').attr('disabled', true);
}