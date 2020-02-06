<div class="postbox">
    <h2 class="hndle">
        <span>「投稿」のデフォルト設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
<?php $table_rows = [
    'post_noindex' => [
        'title'=>'「投稿」の記事をインデックスさせない',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => true,
        'item' => '',
        'prev' => false,
        'desc' => '「はい」を選択するとデフォルトの出力が <code>noindex</code> となります。',
    ],
    'post_title' => [
        'title'=>'タイトルタグの形式',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => '「投稿」（ <code>post</code> ）の記事に出力する <code>&lt;title&gt;</code> タグのデフォルト設定です。',
    ],
    'post_desc' => [
        'title'=>'ディスクリプションの形式',
        'reqired' => false,
        'class' => 'sep',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => '「投稿」（ <code>post</code> ）の記事に出力する <code>meta:description</code> のデフォルト設定です。',
    ],
];
SSP_Methods::output_table_rows( $table_rows ); ?>
            </tbody>
        </table>
    </div>
</div>

<div class="postbox">
    <h2 class="hndle">
        <span>「固定ページ」のデフォルト設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
<?php $table_rows = [
   'page_noindex' => [
        'title'=>'「固定ページ」の記事をインデックスさせない',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => true,
        'item' => '',
        'prev' => false,
        'desc' => '「はい」を選択するとデフォルトの出力が <code>noindex</code> となります。',
    ],
    'page_title' => [
        'title'=>'タイトルタグの形式',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => '「固定ページ」（ <code>page</code> ）の記事に出力する <code>&lt;title&gt;</code> タグのデフォルト設定です。',
    ],
    'page_desc' => [
        'title'=>'ディスクリプションの形式',
        'reqired' => false,
        'class' => 'sep',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => '「固定ページ」（ <code>page</code> ）の記事に出力する <code>meta:description</code> のデフォルト設定です。',
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
    $post_types = get_post_types( $args, 'objects', 'and' ); 

    if ( count( $post_types ) > 0 ) {

        

        foreach ( $post_types  as $obj ){
            echo '<div class="postbox"><h2 class="hndle"><span>カスタム投稿タイプ「'.$obj->label.'」のデフォルト設定</span></h2><div class="inside">';
            echo '<table class="form-table"><tbody>';
            $table_rows = [
                $obj->name.'_noindex' => [
                    'title'=>'「'.$obj->label.'」の記事をインデックスさせない',
                    'reqired' => false,
                    'class' => '',
                    'is_checkbox' => true,
                    'item' => '',
                    'prev' => false,
                    'desc' => '「はい」を選択するとデフォルトの出力が <code>noindex</code> となります。',
                ],
                $obj->name.'_title' => [
                    'title'=>'タイトルタグの形式',
                    'reqired' => false,
                    'class' => '',
                    'is_checkbox' => false,
                    'item' => '',
                    'prev' => true,
                    'desc' => '「'.$obj->label.'」（ <code>'.$obj->name.'</code> ）の記事に出力する <code>&lt;title&gt;</code> タグのデフォルト設定です。',
                ],
                $obj->name.'_desc' => [
                    'title'=>'ディスクリプションの形式',
                    'reqired' => false,
                    'class' => 'sep',
                    'is_checkbox' => false,
                    'item' => '',
                    'prev' => true,
                    'desc' => '「'.$obj->label.'」（ <code>'.$obj->name.'</code> ）の記事に出力する <code>meta:description</code> のデフォルト設定です。',
                ],
            ];
            SSP_Methods::output_table_rows($table_rows );

            echo '</tbody></table>';
            echo '</div></div>';
        }
    }
?>

<div class="postbox">
    <h2 class="hndle">
        <span>「メディア」のデフォルト設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
<?php $table_rows = [
    'media_disable' => [
        'title'=>'「メディア」を使用しない',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => true,
        'item' => '',
        'prev' => false,
        'desc' => '「はい」を選択すると「メディア」の個別ページへアクセスしても画像URLへとリダイレクトされます。',
    ],
   'media_noindex' => [
        'title'=>'「メディア」をインデックスさせない',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => true,
        'item' => '',
        'prev' => false,
        'desc' => '「はい」を選択するとデフォルトの出力が <code>noindex</code> となります。',
    ],
    'media_title' => [
        'title'=>'タイトルタグの形式',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => '「メディア」（ <code>attachment</code> ）の記事に出力する <code>&lt;title&gt;</code> タグのデフォルト設定です。',
    ],
    'media_desc' => [
        'title'=>'ディスクリプションの形式',
        'reqired' => false,
        'class' => 'sep',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => '「メディア」（ <code>attachment</code> ）の記事に出力する <code>meta:description</code> のデフォルト設定です。',
    ],
];
SSP_Methods::output_table_rows($table_rows ); ?>
            </tbody>
        </table>
    </div>
</div>
