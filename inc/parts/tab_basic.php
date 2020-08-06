<div class="postbox">
    <h2 class="hndle">
        <span><?=__('Basic setting', LOOS_SSP_DOMAIN )?></span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
<?php $table_rows = [
    'site_title' => [
        'title' => __('Site title', LOOS_SSP_DOMAIN ) . ' ('. __( 'For confirmation', LOOS_SSP_DOMAIN ) .')',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => false,
        'item' => '<input type="text" name="" value="'.esc_attr( SSP_Data::$site_title ).'" disabled>',
        'prev' => false,
        'desc' => '「<a href="'. admin_url() .'options-general.php" target="_blanc">一般設定</a>」 -> 「サイトのタイトル」の値です。<br><code>%_site_title_%</code> として扱われます。',
    ],
    'site_catch_phrase' => [
        'title' => __('Site catchphrase', LOOS_SSP_DOMAIN ) . ' ('. __( 'For confirmation', LOOS_SSP_DOMAIN ) .')',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => false,
        'item' => '<input type="text" name="" value="'. esc_attr( SSP_Data::$site_catch_phrase ) .'" disabled>',
        'prev' => false,
        'desc' => '「<a href="'. admin_url() .'options-general.php" target="_blanc">一般設定</a>」 -> 「キャッチフレーズ」の値です。<br><code>%_phrase_%</code> として扱われます。',
    ],
    'home_title' => [
        'title' => __('Home title', LOOS_SSP_DOMAIN ),
        'reqired' => false,
        'class' => '',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => sprintf(
            __( 'It is the setting of %s that is output to the home page.', LOOS_SSP_DOMAIN ), 
            '<code>&lt;title&gt;</code> '. __( 'tag', LOOS_SSP_DOMAIN )
        ),//'ホームページに出力する <code>&lt;title&gt;</code> タグの設定です。',
    ],
    'separator' => [
        'title' => __( 'Delimiter', LOOS_SSP_DOMAIN ),
        'reqired' => false,
        'class' => 'sep',
        'is_checkbox' => false,
        'item' => '',
        'prev' => false,
        'desc' => 'ここで選択した 区切り文字 は <code>%_sep_%</code> として扱われます。',
    ],
    'home_desc' => [
        'title' =>  __( 'Home description', LOOS_SSP_DOMAIN ),
        'reqired' => false,
        'class' => 'textarea',
        'is_checkbox' => false,
        'item' => '<textarea name="home_desc">'.esc_html( SSP_Data::$settings['home_desc'] ).'</textarea>',
        'prev' => false,
        'desc' => 'ホーム の <code>meta:description</code> タグの設定です。<br>入力内容が空の場合、「キャッチフレーズ」の内容が優先されます。<br>また、ここで入力された内容は <code>%_description_%</code> として扱われます。',
    ],
    'home_keyword' => [
        'title' => __( 'Keyword', LOOS_SSP_DOMAIN ),
        'reqired' => false,
        'class' => '',
        'is_checkbox' => false,
        'item' => '',
        'prev' => false,
        'desc' => '「キーワードを使用する場合は入力してください。<br>* 複数の場合は , 区切りで入力してください。',
    ],
];

//特殊なもの
foreach ( SSP_Data::SEPARATOR_LIST as $key => $sep ) {

    $checked = ( $key === SSP_Data::$settings['separator'] ) ? 'checked' : '' ;

    $table_rows['separator']['item'] .= '<input '.
                    'type="radio" '.
                    'class="sep_radio" '.
                    'id="separator-'.$key.'" '.
                    'name="separator" '.
                    'value="'.$key.'" '.$checked.'>'
.'<label class="sep_radio" for="separator-'.$key.'">'.$sep.'</label>';
}
SSP_Methods::output_table_rows( $table_rows ); ?>
            </tbody>
        </table>
    </div>
</div>

<div class="postbox">
    <h2 class="hndle">
        <span>特殊ページ設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
<?php $table_rows = [
    'search_title' => [
        'title' => '検索結果ページタイトル',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => '検索結果ページ に出力する <code>&lt;title&gt;</code> タグの設定です。',
    ],
    '404_title' => [
        'title' => '404ページタイトル',
        'reqired' => false,
        'class' => '',
        'is_checkbox' => false,
        'item' => '',
        'prev' => true,
        'desc' => '404ページ に出力する <code>&lt;title&gt;</code> タグの設定です。',
    ],
];
SSP_Methods::output_table_rows( $table_rows ); ?>
            </tbody>
        </table>
    </div>
</div>
