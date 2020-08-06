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

/**
 * メディアアップローダー
 */
(function ($) {

    var my_uploader;

    $("#media_btn").click(function (e) {

        e.preventDefault();

        if (my_uploader) {
            my_uploader.open();
            return;
        }

        //アップローダーの基本設定
        my_uploader = wp.media({

            title: "画像を選択",

            // ライブラリの一覧は画像のみにする 
            library: {
                type: "image"
            },

            //画像選択ボタンのテキスト
            button: {
                text: "画像を決定する"
            },

            // 選択できる画像は1つだけにする
            multiple: false

        });

        //画像が選択された時の処理
        my_uploader.on("select", function () {

            var images = my_uploader.state().get("selection");

            images.each(function (img) {
                //img の中に選択された画像の各種情報が入ってくる

                //テキストフォームに画像の ID・URL を表示
                //$("#media_id").val(img.id);
                $("#media_url").val(img.attributes.sizes.full.url);  //フルサイズのURL

                //プレビュー用に選択されたサムネイル画像を表示
                $("#media_preview").html('<img src="' + img.attributes.sizes.full.url + '" alt="Preview">');
                //$("#crear_btn").show();

            });
        });

        //アップローダー開く
        my_uploader.open();

    });

    // クリアボタンを押した時の処理
    $("#crear_btn").click(function () {
        
        //$("#media_id").val("");
        $("#media_url").val("");
        $("#media_preview").empty();
        //$(this).hide();

    });

})(jQuery);
