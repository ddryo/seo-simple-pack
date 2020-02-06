<div class="postbox">
    <h2 class="hndle">
        <span>ウェブマスターツール設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
    <?php 
        $webmas = [
            'webmaster_google' => ['Google サーチコンソール', 'google-site-verification'],
            'webmaster_bing'   => ['Bing', 'msvalidate.01'],
            'webmaster_baidu'  => ['Baidu', 'baidu-site-verification'],
            'webmaster_yandex' => ['Yandex', 'yandex-verification'],
        ];
        foreach ($webmas  as $wm_key => $wm_v) {
            echo '<tr valign="top"><th scope="row">',
                    '<label for="'.$wm_key.'">', $wm_v[0], '</label>',
                '</th>',

                '<td>',
                    '<div class="inner">',
                        '<div class="ssp_item">',
                                '<input type="text" name="'.$wm_key.'" id="'.$wm_key.'" value="'.esc_attr( SSP_Data::$settings[ $wm_key ] ).'">',
                        '</div>',
                        '<div class="ssp_desc">
                            <p>', $wm_v[0], 'のウェブマスターツール認証コード<br>',
                            '埋め込まれるコード：',
                            '<code>&lt;meta name="',$wm_v[1], '" content="入力コード"&gt;</code>',
                            '</p>',
                        '</div>',
                    '</div>',
                '</td>',
            '</tr>';
        }
    ?>
            </tbody>
        </table>
    </div>
</div>