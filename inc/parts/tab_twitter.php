<div class="postbox">
    <h2 class="hndle">
        <span>Twitter設定</span>
    </h2>
    <div class="inside">
        <table class="form-table">
            <tbody>
<?php $table_rows = [
    'tw_active' => [
        'title'       =>'Twitter用設定を使用する',
        'reqired'     => false,
        'is_checkbox' => true,
        'prev'        => false,
        'class'       => '',
        'item'        => '',
        'desc'        => 'Twitter用のOGPタグを出力するかどうかの設定です。',
    ],
    'tw_account' => [
        'title'       => 'Twitterアカウント名',
        'reqired'     => false,
        'is_checkbox' => false,
        'prev'        => false,
        'class'       => '',
        'item'        => '',
        'desc'        => 'Twitterアカウント (@〇〇) を入力してください。',
    ],
];


SSP_Methods::output_table_rows( $table_rows, "ogp" ); ?>

<tr valign="top">
    <th scope="row">
        <label for="tw_card">カードタイプ</label>
    </th>
    <td>
        <div class="inner">
            <div class="ssp_item">
                <select id="tw_card" name="tw_card">
                    <?php
                        $cards = ['summary', 'summary_large_image'];

                        foreach ($cards as $card) {
                            if ( SSP_Data::$ogp['tw_card'] === $card ) {
                                echo '<option value="', esc_attr( $card ), '" selected>', esc_html( $card ), '</option>';
                            } else {
                                echo '<option value="', esc_attr( $card ), '">', esc_html( $card ), '</option>';
                            }
                            
                        }
                    ?>
                </select>
            </div>
            <div class="ssp_desc">
                <p>Twitterで使用するカードタイプを選択してください。</p>
            </div>
        </div>
    </td>
</tr>
            </tbody>
        </table>
    </div>
</div>
