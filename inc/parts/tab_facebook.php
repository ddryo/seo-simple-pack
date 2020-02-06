<div class="postbox">
    <h2 class="hndle">
        <span>Facebook設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
<?php $table_rows = [
    'fb_active' => [
        'title'       =>'Facebook用設定を使用する',
        'reqired'     => false,
        'is_checkbox' => true,
        'prev'        => false,
        'class'       => '',
        'item'        => '',
        'desc'        => 'Facebook用のOGPタグを出力するかどうかの設定です。',
    ],
    'fb_url' => [
        'title'       => 'Facebookページ URL',
        'reqired'     => false,
        'is_checkbox' => false,
        'prev'        => false,
        'class'       => '',
        'item'        => '',
        'desc'        => 'FacebookページのURLを入力してください。 <code>article:publisher</code> に反映されます',
    ],
    'fb_app_id' => [
        'title'       => 'fb:app_id',
        'reqired'     => false,
        'is_checkbox' => false,
        'prev'        => false,
        'class'       => '',
        'item'        => '',
        'desc'        => 'FacebookアプリID を入力してください。',
    ],
    'fb_admins' => [
        'title'       => 'fb:admins',
        'reqired'     => false,
        'is_checkbox' => false,
        'prev'        => false,
        'class'       => '',
        'item'        => '',
        'desc'        => 'アプリ管理者の FacebookID を入力してください。',
    ],
];

SSP_Methods::output_table_rows( $table_rows, "ogp" ); ?>
            </tbody>
        </table>
    </div>
</div>
