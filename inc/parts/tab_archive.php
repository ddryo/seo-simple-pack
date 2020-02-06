<div class="postbox">
    <h2 class="hndle">
        <span>「著者アーカイブ」の設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
<?php $table_rows = [
    'author_disable' => [
        'title'       => '「著者アーカイブ」を使用しない',
        'class'       => '',
        'item'        => '',
        'reqired'     => false,
        'is_checkbox' => true,
        'prev'        => false,
        'desc'        => '「はい」を選択すると「著者アーカイブ」へアクセスしてもトップページへリダイレクトされます。',
    ],
    'author_noindex' => [
        'title'       => '「著者アーカイブ」をインデックスさせない',
        'class'       => '',
        'item'        => '',
        'reqired'     => false,
        'is_checkbox' => true,
        'prev'        => false,
        'desc'        => '「はい」を選択すると <code>noindex</code> となります。',
    ],
    'author_title' => [
        'title'       => 'タイトルタグの形式',
        'class'       => '',
        'item'        => '',
        'reqired'     => false,
        'is_checkbox' => false,
        'prev'        => true,
        'desc'        => '「著者アーカイブ」ページに出力する <code>&lt;title&gt;</code> タグの設定です。',
    ],
    'author_desc' => [
        'title'       => 'ディスクリプションの形式',
        'class'       => 'sep',
        'item'        => '',
        'reqired'     => false,
        'is_checkbox' => false,
        'prev'        => true,
        'desc'        => '「著者アーカイブ」ページに出力する <code>meta:description</code> の設定です。',
    ],
];
SSP_Methods::output_table_rows( $table_rows ); ?>
            </tbody>
        </table>
    </div>
</div>

<div class="postbox">
    <h2 class="hndle">
        <span>「日付アーカイブ」の設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
<?php $table_rows = [
    'date_noindex' => [
        'title'       => '「日付アーカイブ」をインデックスさせない',
        'class'       => '',
        'item'        => '',
        'reqired'     => false,
        'is_checkbox' => true,
        'prev'        => false,
        'desc'        => '「はい」を選択すると <code>noindex</code> となります。',
    ],
    'date_title' => [
        'title'       => 'タイトルタグの形式',
        'class'       => '',
        'item'        => '',
        'reqired'     => false,
        'is_checkbox' => false,
        'prev'        => true,
        'desc'        => '「日付アーカイブ」ページに出力する <code>&lt;title&gt;</code> タグの設定です。',
    ],
    'date_desc' => [
        'title'       => 'ディスクリプションの形式',
        'class'       => 'sep',
        'item'        => '',
        'reqired'     => false,
        'is_checkbox' => false,
        'prev'        => true,
        'desc'        => '「日付アーカイブ」ページに出力する <code>meta:description</code> の設定です。',
    ],
];
SSP_Methods::output_table_rows( $table_rows ); ?>
            </tbody>
        </table>
    </div>
</div>


<div class="postbox">
    <h2 class="hndle">
        <span>「カスタム投稿アーカイブ」の設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
<?php $table_rows = [
    'pt_archive_noindex' => [
        'title'       => '「カスタム投稿アーカイブ」をインデックスさせない',
        'class'       => '',
        'item'        => '',
        'reqired'     => false,
        'is_checkbox' => true,
        'prev'        => false,
        'desc'        => '「はい」を選択すると <code>noindex</code> となります。',
    ],
    'pt_archive_title' => [
        'title'       => 'タイトルタグの形式',
        'class'       => '',
        'item'        => '',
        'reqired'     => false,
        'is_checkbox' => false,
        'prev'        => true,
        'desc'        => '「カスタム投稿アーカイブ」ページに出力する <code>&lt;title&gt;</code> タグの設定です。',
    ],
    'pt_archive_desc' => [
        'title'       => 'ディスクリプションの形式',
        'class'       => 'sep',
        'item'        => '',
        'reqired'     => false,
        'is_checkbox' => false,
        'prev'        => true,
        'desc'        => '「カスタム投稿アーカイブ」ページに出力する <code>meta:description</code> の設定です。',
    ],
];
SSP_Methods::output_table_rows( $table_rows ); ?>
            </tbody>
        </table>
        <p class="ssp_note">
            注意：カスタム投稿タイプの登録時、アーカイブを有効にする設定をしていない場合はそもそもアーカイブURLは発行されていないので注意して下さい。<br>
            例えば、「<a href="https://ja.wordpress.org/plugins/custom-post-type-ui/" target="_blank">CPT UI</a>」でカスタム投稿タイプを追加している場合、「アーカイブあり」が <code>true</code> に設定されている必要があります。
        </p>
    </div>
</div>