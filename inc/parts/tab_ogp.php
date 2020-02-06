
<div class="postbox">
    <h2 class="hndle">
        <span>OGPタグ 基本設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="singular_label">og:image デフォルト画像</label>
                    </th>
                    <td>
                        <input type="hidden" name="og_image" id="media_url" value="<?php echo esc_attr( SSP_Data::$ogp['og_image'] ); ?>" />
                        <div id="media_preview">
                            <?php 
                                if ( SSP_Data::$ogp['og_image'] ) {
                                    echo '<img src="', esc_url( SSP_Data::$ogp['og_image'] ), '" alt="preview">';
                                } else {
                                    echo '<div class="no_image">まだOGP画像が設定されていません。</div>';
                                }
                            ?>
                        </div>
                        <button type="button" name="media_btn" id="media_btn" class="button button-primary">画像の選択</button>
                        <button type="button" name="crear_btn" id="crear_btn" class="button">クリア</button>
                        <p class="ssp_desc">
                            <br>
                            サイト全体のデフォルト設定です。<br>
                            投稿ページ（<small>投稿・固定ページ・カスタム投稿タイプ</small>）では、「アイキャッチ画像」が優先されます。
                            <br><br>
                            Facebookでは画像サイズに1200×630pxを推奨しています。
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
