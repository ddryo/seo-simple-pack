
//switchCheckbox の動作
function setSwitchEvent () {
	const switchBtns = document.querySelectorAll('.ssp_switch');
	switchBtns.forEach(theBtn => {
		const targetId = theBtn.getAttribute('for');
		const tagetCheckbox = document.getElementById(targetId);
		const targetInput = document.querySelector('[name="' + targetId + '"]');

		if (null === tagetCheckbox) return;
		if (null === targetInput) return;

		const changeParentAttrData = (val) => {
			const parentField = theBtn.closest('.ssp-field');
			if (null === parentField) return;

			// 「〇〇のアーカイブページを使用しない」系
			if (parentField.getAttribute('data-disable') !== null) {
				parentField.setAttribute('data-disable', val);
				return;
			}
			
			// 「Facebook/Twitter用のメタタグを使用するかどうか」
			if (parentField.getAttribute('data-active') !== null) {
				parentField.setAttribute('data-active', val);
			}
		}

		theBtn.addEventListener('click', function (e) {
			setTimeout(() => {
				const val = Number(tagetCheckbox.checked);
				targetInput.setAttribute('value', val);
				
				//親フィールドに対する処理
				changeParentAttrData(val);
			}, 10);
		});
	});
}

document.addEventListener('DOMContentLoaded', setSwitchEvent);
