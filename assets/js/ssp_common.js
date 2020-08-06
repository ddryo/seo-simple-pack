(function ($) {
    //noindex switch
    $switchBox = $('.ssp_switch_box');
    $switchBox.click(function (e){
        var labelFor = $(this).attr('for');
        var p = $(this).closest('tr');
        setTimeout( function() {
            var val = $('#' + labelFor).prop('checked');
            $('input[name="' + labelFor + '"]').val( Number(val) );

            if (p.attr('data-disable') !== undefined) {
                p.attr('data-disable', Number(val));
            }
        }, 10);
    });
})(window.jQuery);