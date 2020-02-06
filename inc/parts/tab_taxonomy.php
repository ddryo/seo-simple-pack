<div class="postbox">
    <h2 class="hndle">
        <span>「カテゴリーアーカイブ」の設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
<?php $table_rows = [

    'cat_noindex' => [
        'title'=>'「カテゴリーアーカイブ」をインデックスさせない',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => true,
        'item' => '',
        'prev' => false,
        'desc' => '「はい」を選択すると <code>noindex</code> となります。',
    ],
    'cat_title' => [
        'title'=>'タイトルタグの形式',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => '「カテゴリーアーカイブ」に出力する <code>&lt;title&gt;</code> タグの設定です。',
    ],
    'cat_desc' => [
        'title'=>'ディスクリプションの形式',
        'reqired' => false,
        'class' => 'sep',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => '「カテゴリーアーカイブ」に出力する <code>meta:description</code> の設定です。',
    ],
];
SSP_Methods::output_table_rows( $table_rows ); ?>
            </tbody>
        </table>
    </div>
</div>

<div class="postbox">
    <h2 class="hndle">
        <span>「タグアーカイブ」の設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
<?php $table_rows = [

    'tag_noindex' => [
        'title'=>'「タグアーカイブ」をインデックスさせない',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => true,
        'item' => '',
        'prev' => false,
        'desc' => '「はい」を選択すると <code>noindex</code> となります。',
    ],
    'tag_title' => [
        'title'=>'タイトルタグの形式',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => '「タグアーカイブ」に出力する <code>&lt;title&gt;</code> タグの設定です。',
    ],
    'tag_desc' => [
        'title'=>'ディスクリプションの形式',
        'reqired' => false,
        'class' => 'sep',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => '「タグアーカイブ」に出力する <code>meta:description</code> の設定です。',
    ],
];
SSP_Methods::output_table_rows( $table_rows ); ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
    //カスタム投稿タイプを取得
    $args = array(
        'public'   => true,
        '_builtin' => false
    );
    $taxonomies = get_taxonomies( $args, 'objects', 'and' ); 

    if ( count( $taxonomies ) > 0 ) {
        foreach ( $taxonomies  as $obj ){
            echo '<div class="postbox"><h2 class="hndle"><span>タクソノミー「'.$obj->label.'」の設定</span></h2><div class="inside">';
            echo '<table class="form-table"><tbody>';

            $table_rows = [
                $obj->name.'_noindex' => [
                    'title'=>'「'.$obj->label.'」のアーカイブページをインデックスさせない',
                    'reqired' => false,
                    'class' => '',
                    'is_checkbox' => true,
                    'item' => '',
                    'prev' => false,
                    'desc' => '「はい」を選択すると <code>noindex</code> となります。',
                ],
                $obj->name.'_title' => [
                    'title'=>'タイトルタグの形式',
                    'reqired' => false,
                    'class' => '',
                    'is_checkbox' => false,
                    'item' => '',
                    'prev' => true,
                    'desc' => '「'.$obj->label.'」（ <code>'.$obj->name.'</code> ）のアーカイブページに出力する <code>&lt;title&gt;</code> タグの設定です。',
                ],
                $obj->name.'_desc' => [
                    'title'=>'ディスクリプションの形式',
                    'reqired' => false,
                    'class' => 'sep',
                    'is_checkbox' => false,
                    'item' => '',
                    'prev' => true,
                    'desc' => '「'.$obj->label.'」（ <code>'.$obj->name.'</code> ）のアーカイブページに出力する <code>meta:description</code> の設定です。',
                ],
            ];
            SSP_Methods::output_table_rows( $table_rows );

            echo '</tbody></table>';
            echo '</div></div>';
        }
    }
?>

<div class="postbox">
    <h2 class="hndle">
        <span>「投稿フォーマットアーカイブ」の設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
<?php $table_rows = [
    'post_format_disable' => [
        'title'=>'「投稿フォーマットアーカイブ」を使用しない',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => true,
        'item' => '',
        'prev' => false,
        'desc' => '「はい」を選択すると「投稿フォーマットアーカイブ」へアクセスしてもトップページへリダイレクトされます。',
    ],

    'post_format_noindex' => [
        'title'=>'「投稿フォーマットアーカイブ」をインデックスさせない',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => true,
        'item' => '',
        'prev' => false,
        'desc' => '「はい」を選択すると <code>noindex</code> となります。',
    ],
    'post_format_title' => [
        'title'=>'タイトルタグの形式',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => '「投稿フォーマットアーカイブ」に出力する <code>&lt;title&gt;</code> タグの設定です。',
    ],
    'post_format_desc' => [
        'title'=>'ディスクリプションの形式',
        'reqired' => false,
        'class' => 'sep',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => '「投稿フォーマットアーカイブ」に出力する <code>meta:description</code> の設定です。',
    ],
];
SSP_Methods::output_table_rows( $table_rows ); ?>
            </tbody>
        </table>
    </div>
</div>