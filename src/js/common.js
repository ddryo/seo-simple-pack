(function ($) {

	/**
	 * sweitch
	 */
	const switchBox = $('.ssp_switch_box');
	switchBox.click(function (e){
		const labelFor = $(this).attr('for');
		const parentField = $(this).closest('.ssp-field');
		setTimeout( function() {
			const val = $('#' + labelFor).prop('checked');
			$('input[name="' + labelFor + '"]').val( Number(val) );

			if (parentField.attr('data-disable') !== undefined) {
				parentField.attr('data-disable', Number(val));
			} else if (p.attr('data-active') !== undefined) {
				parentField.attr('data-active', Number(val));
			}
		}, 10);
	});
})(window.jQuery);