/**
 * scripts
 */
addEventListener('DOMContentLoaded', function () {

	// 設定タブの切替処理
	(function () {
		// ページ上部へ
		window.scrollTo(0, 0);

		const tabNavs = document.querySelectorAll('.nav-tab');
		const tabContents = document.querySelectorAll('.tab-contents');

		if (location.hash) {
			const hashTarget = document.querySelector(location.hash);
			const hashTab = document.querySelector(
				'[href="' + location.hash + '"]'
			);
			const actTabNav = document.querySelector('.nav-tab.act_');
			const actTabContent = document.querySelector('.tab-contents.act_');
			if (hashTarget && hashTab && actTabNav && actTabContent) {
				actTabNav.classList.remove('act_');
				actTabContent.classList.remove('act_');
				hashTarget.classList.add('act_');
				hashTab.classList.add('act_');
			}
		}

		for (let i = 0; i < tabNavs.length; i++) {
			tabNavs[i].addEventListener('click', function (e) {
				e.preventDefault();
				const targetHash = e.target.getAttribute('href');

				// History APIでURLを書き換える（ location.hash でやると 移動してしまう)
				history.replaceState(null, null, targetHash);

				if (!tabNavs[i].classList.contains('act_')) {
					document
						.querySelector('.nav-tab.act_')
						.classList.remove('act_');
					tabNavs[i].classList.add('act_');

					document
						.querySelector('.tab-contents.act_')
						.classList.remove('act_');
					tabContents[i].classList.add('act_');
				}
			});
		}
	})();
});
