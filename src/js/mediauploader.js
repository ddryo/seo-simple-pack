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
			// button: { text: '画像を選択' },
			library: { type: 'image' },
			multiple: false,
		});

		// When an image is selected in the media frame...
		customUploader.on('select', function () {
			// Get media attachment details from the frame state
			const images = customUploader.state().get('selection');

			// Get media attachment details from the frame state
			const theImage = images.first().toJSON();

			// inputタグにURLをセット
			srcInputField.val(theImage.url);
			srcInputField.change();

			// プレビューエリアを更新
			previewArea.html(
				'<img src="' + theImage.url + '" alt="" />'
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
