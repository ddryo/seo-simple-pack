<?php
/**
 * 基本設定 タブ
 */
// phpcs:disable WordPress.WP.I18n.MissingTranslatorsComment

$general_url = admin_url( 'options-general.php' );

$img_desc = __( 'This is the default setting for the entire site.', 'seo-simple-pack' ) . '<br>' .
	__( 'On the Post page, "Featured Image" have priority.', 'seo-simple-pack' ) . '<br><br>' .
	__( 'Facebook\'s recommended size is 1200 x 630px.', 'seo-simple-pack' );

// OGPタグ 基本設定
self::output_section( __( 'Basic settings for OGP tags', 'seo-simple-pack' ), [
	'og_image' => [
		'title' => __( 'Image of "og:image"', 'seo-simple-pack' ),
		'type'  => 'media',
		// 'item'  => $img_item,
		'desc'  => $img_desc,
	],
], 'ogp' );
