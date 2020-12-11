<?php
/**
 * 基本設定 タブ
 */
// phpcs:disable WordPress.WP.I18n.MissingTranslatorsComment

$general_url = admin_url( 'options-general.php' );

$img_desc = __( 'サイト全体のデフォルト設定です。', 'loos-ssp' ) . '<br>' .
	__( '投稿ページでは、「アイキャッチ画像」が優先されます。', 'loos-ssp' ) . '<br><br>' .
	__( 'Facebookの推奨サイズは 1200×630px です。', 'loos-ssp' );

// OGPタグ 基本設定
self::output_section( __( 'OGPタグの基本設定', 'loos-ssp' ), [
	'og_image' => [
		'title' => __( 'og:image 画像', 'loos-ssp' ),
		'type'  => 'media',
		// 'item'  => $img_item,
		'desc'  => $img_desc,
	],
], 'ogp' );
