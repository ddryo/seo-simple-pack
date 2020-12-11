<?php
/**
 * 基本設定 タブ
 */
// phpcs:disable WordPress.WP.I18n.MissingTranslatorsComment
// phpcs:disable WordPress.WP.I18n.MissingArgDomain

$general_url       = admin_url( 'options-general.php' );
$general_page_link = '<a href="' . $general_url . '" target="_blanc">' .
		sprintf( SSP_Data::$texts['quoted_title'], __( 'General Settings' ) ) .
	'</a>';

// 「一般設定」 -> 「サイトのタイトル」
$general_to_title = $general_page_link . ' -> ' . sprintf( SSP_Data::$texts['quoted_title'], __( 'Site Title' ) );

// 「一般設定」 -> 「キャッチフレーズ」
$general_to_tagline = $general_page_link . ' -> ' . sprintf( SSP_Data::$texts['quoted_title'], __( 'Tagline' ) );

// 「ホームページ」
$page_title__home   = __( 'ホームページ', 'loos-ssp' );
$quoted_title__home = sprintf( SSP_Data::$texts['quoted_title'], $page_title__home );

// 基本設定
self::output_section( __( 'Basic setting', 'loos-ssp' ), [
	'site_title' => [
		'title'       => __( 'Site title', 'loos-ssp' ) . ' (' . __( 'For confirmation', 'loos-ssp' ) . ')',
		'item'        => '<input type="text" name="" value="' . esc_attr( SSP_Data::$site_title ) . '" disabled>',
		'desc'        => sprintf( __( '%sの値。', 'loos-ssp' ), $general_to_title ) .
			'<br>' .
			sprintf( SSP_Data::$texts['is_snippet'], '<code>%_site_title_%</code>' ),
	],
	'site_catch_phrase' => [
		'title'       => __( 'Site catchphrase', 'loos-ssp' ) . ' (' . __( 'For confirmation', 'loos-ssp' ) . ')',
		'item'        => '<input type="text" name="" value="' . esc_attr( SSP_Data::$site_catch_phrase ) . '" disabled>',
		'desc'        => sprintf( __( '%sの値。', 'loos-ssp' ), $general_to_tagline ) .
			'<br>' .
			sprintf( SSP_Data::$texts['is_snippet'], '<code>%_phrase_%</code>' ),
	],
	'separator' => [
		'title'       => __( 'Delimiter', 'loos-ssp' ),
		'class'       => '-separator',
		'type'        => 'radio_btn',
		'choices'     => SSP_Data::SEPARATORS,
		'desc'        => sprintf( __( 'ここで選択した文字は %s として扱われます。', 'loos-ssp' ), ' <code>%_sep_%</code>' ),
	],
	'home_title' => [
		// 'title'       => __( 'Home title', 'loos-ssp' ),
		'title'       => sprintf( SSP_Data::$texts['title_of'], $quoted_title__home ),
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title__home, '<code>&lt;title&gt;</code>' ),
	],

	'home_desc' => [
		'title'       => sprintf( SSP_Data::$texts['description_of'], $quoted_title__home ),
		// 'title'       => __( 'Home description', 'loos-ssp' ),
		'type'        => 'textarea',
		'class'       => '-wide',
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title__home, '<code>meta:description</code>' ) .
			sprintf( SSP_Data::$texts['is_snippet'], '<code>%_description_%</code>' ) .
			'<br>※ ' .
			__( '入力内容が空の場合、「キャッチフレーズ」の内容が優先されます。', 'loos-ssp' ),
	],
	'home_keyword' => [
		'title'       => sprintf( SSP_Data::$texts['keyword_of'], $quoted_title__home ),
		'class'       => '-wide',
		'desc'        => '*' . __( '複数の場合は , 区切りで入力してください。', 'loos-ssp' ),
	],
] );

// 特殊ページ設定
$page_title__s   = __( '検索結果ページ', 'loos-ssp' );
$quoted_title__s = sprintf( SSP_Data::$texts['quoted_title'], $page_title__s );

$page_title__404   = __( '404ページ', 'loos-ssp' );
$quoted_title__404 = sprintf( SSP_Data::$texts['quoted_title'], $page_title__404 );

self::output_section( __( '特殊ページ設定', 'loos-ssp' ), [
	'search_title' => [
		'title'       => sprintf( SSP_Data::$texts['title_of'], $quoted_title__s ),
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title__s, '<code>&lt;title&gt;</code>' ),
		'preview'     => true,
	],
	'404_title' => [
		'title'       => sprintf( SSP_Data::$texts['title_of'], $quoted_title__404 ),
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title__404, '<code>&lt;title&gt;</code>' ),
		'preview'     => true,
	],
] );
