<?php
/**
 * 投稿ページ タブ
 */

// 投稿ページ
$pt_title     = __( '投稿ページ', 'loos-ssp' );
$quoted_title = sprintf( SSP_Data::$texts['quoted_title'], $pt_title );
self::output_section( $pt_title, [
	'post_noindex' => [
		'title'       => sprintf( SSP_Data::$texts['noindex'], $quoted_title ),
		'type'        => 'switch',
		'desc'        => SSP_Data::$texts['noindex_help'],
	],
	'post_title' => [
		'title'       => SSP_Data::$texts['title_tag'],
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>&lt;title&gt;</code>' ),
	],
	'post_desc' => [
		'title'       => SSP_Data::$texts['description_tag'],
		'class'       => 'sep',
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>meta:description</code>' ),
	],
] );

// 固定ページ
$pt_title     = __( '固定ページ', 'loos-ssp' );
$quoted_title = sprintf( SSP_Data::$texts['quoted_title'], $pt_title );
self::output_section( $pt_title, [
	'page_noindex' => [
		'title'       => sprintf( SSP_Data::$texts['noindex'], $quoted_title ),
		'type'        => 'switch',
		'desc'        => SSP_Data::$texts['noindex_help'],
	],
	'page_title' => [
		'title'       => SSP_Data::$texts['title_tag'],
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>&lt;title&gt;</code>' ),
	],
	'page_desc' => [
		'title'       => SSP_Data::$texts['description_tag'],
		'class'       => 'sep',
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>meta:description</code>' ),
	],
] );


// カスタム投稿タイプを取得
$post_types = get_post_types( [
	'public'   => true,
	'_builtin' => false,
], 'objects', 'and' );

if ( count( $post_types ) > 0 ) {
	foreach ( $post_types  as $pt_obj ) {

		$pt_title     = __( 'カスタム投稿タイプ', 'loos-ssp' ) . ' : ' . sprintf( __( '"%s"', 'loos-ssp' ), $pt_obj->label );
		$quoted_title = sprintf( SSP_Data::$texts['quoted_title'], $pt_obj->label );

		self::output_section( $pt_title, [
			$pt_obj->name . '_noindex' => [
				'title'       => sprintf( SSP_Data::$texts['noindex'], $quoted_title ),
				'type'        => 'switch',
				'desc'        => SSP_Data::$texts['noindex_help'],
			],
			$pt_obj->name . '_title' => [
				'title'       => SSP_Data::$texts['title_tag'],
				'preview'     => true,
				'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>&lt;title&gt;</code>' ),
			],
			$pt_obj->name . '_desc' => [
				'title'       => SSP_Data::$texts['description_tag'],
				'class'       => 'sep',
				'preview'     => true,
				'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>meta:description</code>' ),
			],
		] );
	}
}


// メディアページ
$pt_title     = __( 'メディアページ', 'loos-ssp' );
$quoted_title = sprintf( SSP_Data::$texts['quoted_title'], $pt_title );

self::output_section( $pt_title, [
	'attachment_disable' => [
		'title'       => sprintf( SSP_Data::$texts['nouse'], $quoted_title ),
		'type'        => 'switch',
		'desc'        => '「はい」を選択すると「メディア」の個別ページへアクセスしても画像URLへとリダイレクトされます。',
	],
	'attachment_noindex' => [
		'title'       => sprintf( SSP_Data::$texts['noindex'], $quoted_title ),
		'type'        => 'switch',
		'desc'        => SSP_Data::$texts['noindex_help'],
	],
	'attachment_title' => [
		'title'       => SSP_Data::$texts['title_tag'],
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>&lt;title&gt;</code>' ),
	],
	'attachment_desc' => [
		'title'       => SSP_Data::$texts['description_tag'],
		'class'       => 'sep',
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>meta:description</code>' ),
	],
] );
