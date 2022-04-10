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

// Front Page
$page_title__home   = __( 'Front Page', 'loos-ssp' );
$quoted_title__home = sprintf( SSP_Data::$texts['quoted_title'], $page_title__home );

// 基本設定
self::output_section( __( 'Basic setting', 'loos-ssp' ), [
	'site_title' => [
		'title'       => __( 'Site title', 'loos-ssp' ) . ' (' . __( 'For confirmation', 'loos-ssp' ) . ')',
		'item'        => '<input type="text" name="" value="' . esc_attr( SSP_Data::$site_title ) . '" disabled>',
		'desc'        => sprintf( __( 'Contents of %s.', 'loos-ssp' ), $general_to_title ) .
			'<br>' .
			sprintf( SSP_Data::$texts['is_snippet'], '<code>%_site_title_%</code>' ),
	],
	'site_catch_phrase' => [
		'title'       => __( 'Site catchphrase', 'loos-ssp' ) . ' (' . __( 'For confirmation', 'loos-ssp' ) . ')',
		'item'        => '<input type="text" name="" value="' . esc_attr( SSP_Data::$site_catch_phrase ) . '" disabled>',
		'desc'        => sprintf( __( 'Contents of %s.', 'loos-ssp' ), $general_to_tagline ) .
			'<br>' .
			sprintf( SSP_Data::$texts['is_snippet'], '<code>%_tagline_%</code>' ),
	],
	'separator' => [
		'title'       => __( 'Delimiter', 'loos-ssp' ),
		'class'       => '-separator',
		'type'        => 'radio_btn',
		'choices'     => SSP_Data::SEPARATORS,
		'desc'        => sprintf( __( 'The character selected here is treated as %s.', 'loos-ssp' ), ' <code>%_sep_%</code>' ),
	],
	'home_title' => [
		'title'       => sprintf( SSP_Data::$texts['title_of'], $quoted_title__home ),
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title__home, '<code>&lt;title&gt;</code>' ),
	],

	'home_desc' => [
		'title'       => sprintf( SSP_Data::$texts['description_of'], $quoted_title__home ),
		'type'        => 'textarea',
		'class'       => '-wide',
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title__home, '<code>meta:description</code>' ) .
			sprintf( SSP_Data::$texts['is_snippet'], '<code>%_description_%</code>' ) .
			'<br>※ ' .
			__( 'If the input content is empty, the content of the "Site catchphrase" has priority.', 'loos-ssp' ),
	],
	'home_keyword' => [
		'title'       => sprintf( SSP_Data::$texts['keyword_of'], $quoted_title__home ),
		'class'       => '-wide',
		'desc'        => '*' . __( 'If there are multiple, enter them separated by ",".', 'loos-ssp' ),
	],
	'reuse_keyword' => [
		'class'       => '-mt-shorten',
		'type'        => 'checkbox',
		'label'       => __( 'Output the same keywords as above when the keywords setting of each post is empty', 'loos-ssp' ),
	],
] );

// 特殊ページ設定
$page_title__s   = __( 'Search result page', 'loos-ssp' );
$quoted_title__s = sprintf( SSP_Data::$texts['quoted_title'], $page_title__s );

$page_title__404   = __( '404 page', 'loos-ssp' );
$quoted_title__404 = sprintf( SSP_Data::$texts['quoted_title'], $page_title__404 );

$feed_title         = __( 'Feed page', 'loos-ssp' );
$quoted_title__feed = sprintf( SSP_Data::$texts['quoted_title'], $feed_title );

self::output_section( __( 'Particular page settings', 'loos-ssp' ), [
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
	'feed_noindex' => [
		'title'       => sprintf( SSP_Data::$texts['noindex'], $quoted_title__feed ),
		'type'        => 'switch',
		// 'desc'        => SSP_Data::$texts['noindex_help'],
	],
] );
