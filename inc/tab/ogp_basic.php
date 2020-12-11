<?php
/**
 * 基本設定 タブ
 */
// phpcs:disable WordPress.WP.I18n.MissingTranslatorsComment

$general_url = admin_url( 'options-general.php' );

$img_desc = __( 'サイト全体のデフォルト設定です。', 'loos-ssp' ) . '<br>' .
	__( '投稿ページでは、「アイキャッチ画像」が優先されます。', 'loos-ssp' ) . '<br><br>' .
	__( 'Facebookの推奨サイズは 1200×630px です。', 'loos-ssp' );


ob_start();

?>
<input type="hidden" name="og_image" id="media_url" value="<?php echo esc_attr( SSP_Data::$ogp['og_image'] ); ?>" />
<div id="media_preview">
	<?php
		if ( SSP_Data::$ogp['og_image'] ) {
		echo '<img src="', esc_url( SSP_Data::$ogp['og_image'] ), '" alt="preview">';
		} else {
		echo '<div class="no_image">まだ画像が設定されていません。</div>';
		}
	?>
</div>
<button type="button" name="media_btn" id="media_btn" class="button button-primary">画像の選択</button>
<button type="button" name="crear_btn" id="crear_btn" class="button">クリア</button>
<?php

$img_item = ob_get_clean();


// OGPタグ 基本設定
self::output_section( __( 'OGPタグの基本設定', 'loos-ssp' ), [
	'og_image' => [
		'title' => __( 'og:image 画像', 'loos-ssp' ),
		'type'  => 'media',
		// 'item'  => $img_item,
		'desc'  => $img_desc,
	],
], 'ogp' );
