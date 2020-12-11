<?php
/**
 * タクソノミーアーカイブ タブ
 */

// カテゴリー
$tax_title    = __( 'カテゴリー', 'loos-ssp' );
$quoted_title = sprintf( SSP_Data::$texts['quoted_archive_title'], $tax_title );
self::output_section( $tax_title, [
	'cat_noindex' => [
		'title' => sprintf( SSP_Data::$texts['noindex'], $quoted_title ),
		'type'  => 'switch',
		'desc'  => SSP_Data::$texts['noindex_help'],
	],
	'cat_title' => [
		'title'       => SSP_Data::$texts['title_tag'],
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>&lt;title&gt;</code>' ),
	],
	'cat_desc' => [
		'title'       => SSP_Data::$texts['noindex'],
		'class'       => 'sep',
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>meta:description</code>' ),
	],
] );


// タグ
$tax_title    = __( 'タグ', 'loos-ssp' );
$quoted_title = sprintf( SSP_Data::$texts['quoted_archive_title'], $tax_title );
self::output_section( $tax_title, [
	'tag_noindex' => [
		'title' => sprintf( SSP_Data::$texts['noindex'], $quoted_title ),
		'type'  => 'switch',
		'desc'  => SSP_Data::$texts['noindex_help'],
	],
	'tag_title' => [
		'title'       => SSP_Data::$texts['title_tag'],
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>&lt;title&gt;</code>' ),
	],
	'tag_desc' => [
		'title'       => SSP_Data::$texts['noindex'],
		'class'       => 'sep',
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>meta:description</code>' ),
	],
] );

// カスタム投稿タイプを取得
$taxonomies = get_taxonomies( [
	'public'   => true,
	'_builtin' => false,
], 'objects', 'and' );
foreach ( $taxonomies as $tax_obj ) {

	$tax_title    = __( 'タクソノミー', 'loos-ssp' ) . ' : ' . sprintf( __( '"%s"', 'loos-ssp' ), $tax_obj->label );
	$quoted_title = sprintf( SSP_Data::$texts['quoted_archive_title'], $tax_obj->label );
	self::output_section( $tax_title, [
		$tax_obj->name . '_noindex' => [
			'title' => sprintf( SSP_Data::$texts['noindex'], $quoted_title ),
			'type'  => 'switch',
			'desc'  => SSP_Data::$texts['noindex_help'],
		],
		$tax_obj->name . '_title' => [
			'title'       => SSP_Data::$texts['title_tag'],
			'preview'     => true,
			'desc'        => sprintf(
				SSP_Data::$texts['default_output'],
				$quoted_title,
				'<code>&lt;title&gt;</code>'
			),
		],
		$tax_obj->name . '_desc' => [
			'title'       => SSP_Data::$texts['noindex'],
			'class'       => 'sep',
			'preview'     => true,
			'desc'        => sprintf(
				SSP_Data::$texts['default_output'],
				$quoted_title,
				'<code>meta:description</code>'
			),
		],
	] );
}


// 投稿フォーマット
$tax_title    = __( '投稿フォーマット', 'loos-ssp' );
$quoted_title = sprintf( SSP_Data::$texts['quoted_archive_title'], $tax_title );
self::output_section( $tax_title, [
	'post_format_disable' => [
		'title' => sprintf( SSP_Data::$texts['nouse'], $quoted_title ),
		'type'  => 'switch',
		'desc'  => '「はい」を選択すると「投稿フォーマット」のアーカイブページへアクセスしてもトップページへリダイレクトされます。',
	],
	'post_format_noindex' => [
		'title' => sprintf( SSP_Data::$texts['noindex'], $quoted_title ),
		'type'  => 'switch',
		'desc'  => SSP_Data::$texts['noindex_help'],
	],
	'post_format_title' => [
		'title'       => SSP_Data::$texts['title_tag'],
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>&lt;title&gt;</code>' ),
	],
	'post_format_desc' => [
		'title'       => SSP_Data::$texts['description_tag'],
		'class'       => 'sep',
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>meta:description</code>' ),
	],
] );
