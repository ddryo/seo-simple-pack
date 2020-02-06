<div class="postbox">
    <h2 class="hndle">
        <span>Googleアナリティクス設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">
                        <label for="google_analytics_type">コードタイプ</label>
                    </th>
                    <td>
                        <select name="google_analytics_type" id="google_analytics_type">
                        <?php 
                            if( SSP_Data::$settings[ 'google_analytics_type' ] === "gtag") {
                                echo '<option value="gtag" selected>gtag.jsでコードを埋め込む</option>
                                <option value="analytics">analytics.jsでコードを埋め込む</option>';
                            } else {
                                echo '<option value="gtag">gtag.jsでコードを埋め込む</option>
                                <option value="analytics" selected>analytics.jsでコードを埋め込む</option>';
                            }
                        ?>
                        </select>
                        <p class="ssp_desc">
                            Googleアナリティクスのトラッキングコードを、新しい<code>gtag.js</code>でのコードで埋め込むか、古い<code>analytics.js</code>によるコードで埋め込むかを選択できます。<br>
                            特に理由がなければ、gtag.jsを推奨します。
                        </p>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="google_analytics_id">トラッキング ID</label>
                    </th>
                    <td>
                        <input type="text" name="google_analytics_id" id="google_analytics_id" value="<?php echo esc_attr( SSP_Data::$settings[ 'google_analytics_id' ] ); ?>">
                        <p class="ssp_desc">
                            GoogleアナリティクスのトラッキングID( <code>UA-XXXXX-Y</code> )を入力して下さい。
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
