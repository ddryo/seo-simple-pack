(function ($) {
	//noindex switch
	$switchBox = $('.ssp_switch_box');
	$switchBox.click(function (e){
		var labelFor = $(this).attr('for');
		var p = $(this).closest('.ssp-field');
		setTimeout( function() {
			var val = $('#' + labelFor).prop('checked');
			$('input[name="' + labelFor + '"]').val( Number(val) );

			if (p.attr('data-disable') !== undefined) {
				p.attr('data-disable', Number(val));
			} else if (p.attr('data-active') !== undefined) {
				p.attr('data-active', Number(val));
			}
		}, 10);
	});
})(window.jQuery);