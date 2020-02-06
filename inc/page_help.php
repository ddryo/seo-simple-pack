<div id="ssp_wrap" class="wrapp">
    <h1 id="ssp_title">ヘルプページ</h1>

    <div id="poststuff">
        <div class="ssp_help_page">
            使用可能なスニペットタグについて<br>
            <?php 
                $tags = [
                    'site_title' => 'サイトのタイトル',
                    'phrase' => 'サイトのキャッチフレーズ',
                    'description' => 'ホームのディスクリプション',
                    'page_title' => '投稿のタイトル( get_the_title() で取得できる内容が入ります )',
                    'cat_name' => 'カテゴリー名',
                    'tag_name' => 'タグ名',
                    'term_name' => 'ターム名',
                    'term_description' => 'タームの説明',
                    'tax_name' => 'タクソノミー名',
                    'post_type' => '投稿タイプ名',
                    'page_contents' => 'ページコンテンツ ( get_the_content() で取得できる内容を元にした内容が入ります )',
                    'date' => '日付アーカイブで検索中の日付',
                    'author_name' => '著者名( ニックネーム )',
                    'search_phrase' => '検索ワード',
                    'format_name' => '投稿フォーマット名',
                    'sep' => '区切り文字',
                ];
            ?>
            <table class="ssp_help_table">
                <thead>
                    <tr>
                        <th>
                            スニペットタグ
                        </th>
                        <th>
                            展開される内容
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($tags as $key => $val) {
                            echo '<tr><th>%_', $key, '_%</th><td>', $val, '</td></tr>';
                        }
                    ?>
                </tbody>
            </table>

            <p>
                「SEO SIMPLE PACK」に関する詳しい説明は <a href="https://wemo.tech/1670" target="blank_"> プラグインの使い方 </a> をご覧ください。
            </p>
        </div>
    </div>
</div>
