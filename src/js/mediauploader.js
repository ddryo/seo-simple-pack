// 画像選択処理
console.log('Loaded media-uploader.js.');

(function ($) {
	let customUploader = null;

	// 画像選択時の処理
	function mediaSelectBtnClick(btnId) {

		// プレビューエリア
		const previewid = 'preview_' + btnId;
		const previewArea = $('#' + previewid);

		// inputタグ
		const srcInputId = 'src_' + btnId;
		const srcInputField = $('#' + srcInputId);

		// Create a new media frame
		customUploader = wp.media({
			// title: '画像を選択',
			library: { type: 'image' },
			// button: { text: '画像を選択' },
			multiple: false,
		});

		// When an image is selected in the media frame...
		customUploader.on('select', function () {
			// Get media attachment details from the frame state
			const images = customUploader.state().get('selection');
			// console.log(images);

			// Get media attachment details from the frame state
			const theImage = images.first().toJSON();
			// console.log(theImage);

			// inputタグにURLをセット
			srcInputField.val(theImage.url);
			srcInputField.change();

			// プレビューエリアを更新
			// previewArea.empty();
			previewArea.html(
				'<img style="max-width:100%;" src="' + theImage.url + '" />'
			);

			// クローズ
			// $('.media-modal-close').click();
		});

		// Finally, open the modal on click
		customUploader.open();
	}

	//画像削除の処理
	function mediaClearBtnClick(btnId) {
		// プレビューエリア
		const previewid = 'preview_' + btnId;
		const previewArea = $('#' + previewid);

		// inputタグ
		const srcInputId = 'src_' + btnId;
		const srcInputField = $('#' + srcInputId);

		// inputタグのvalueをリセット
		srcInputField.val('');
		srcInputField.change();
		// srcInputField.focus(); // ブロックエディターの要素にchange()が反応しない

		// プレビューエリアをリセット
		previewArea.empty();
	}

	// 画像選択ボタンをクリックした時
	$(document).on('click', '[name=ssp-media-upload]', function (e) {
		e.preventDefault();
		const btnId = $(this).attr('data-id');
		console.log(btnId);
		mediaSelectBtnClick(btnId);
	});

	// クリアボタンを押した時
	$(document).on('click', '[name=ssp-media-clear]', function () {
		const btnId = $(this).attr('data-id');
		mediaClearBtnClick(btnId);
	});

})(window.jQuery);
