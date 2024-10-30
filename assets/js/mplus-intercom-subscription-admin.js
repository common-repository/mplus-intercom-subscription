(function($) {
    'use strict';

    jQuery(document).ready(function($) {
        $('input#mplusis_own_api_key').on('change', function(e) {
            e.preventDefault();
            if(this.checked) {
                console.debug($('textarea#mplusis_api_key').closest('tr'));
                $('textarea#mplusis_api_key').closest('tr').show();
                $('a.intercom-connect').hide();
            }else{
                $('textarea#mplusis_api_key').closest('tr').hide();
                $('a.intercom-connect').show();
            }
        });

        if($('input#mplusis_own_api_key').is(':checked')){
            $('a.intercom-connect').hide();
        }else{
            $('textarea#mplusis_api_key').closest('tr').hide();
        }
    });

})(jQuery);
