<?php
/**
 * 基本設定 タブ
 */
// phpcs:disable WordPress.WP.I18n.MissingTranslatorsComment

$general_url = admin_url( 'options-general.php' );

$img_desc = __( 'This is the default setting for the entire site.', 'loos-ssp' ) . '<br>' .
	__( 'On the Post page, "Featured Image" have priority.', 'loos-ssp' ) . '<br><br>' .
	__( 'Facebook\'s recommended size is 1200 x 630px.', 'loos-ssp' );

// OGPタグ 基本設定
self::output_section( __( 'Basic settings for OGP tags', 'loos-ssp' ), [
	'og_image' => [
		'title' => __( 'Image of "og:image"', 'loos-ssp' ),
		'type'  => 'media',
		// 'item'  => $img_item,
		'desc'  => $img_desc,
	],
], 'ogp' );
