<?php
/**
 * 投稿ページ タブ
 */

// 投稿ページ
$pt_title     = __( 'Posts', 'loos-ssp' );
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
$pt_title     = __( 'Pages', 'loos-ssp' );
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


// カスタム投稿タイプ
foreach ( SSP_Data::$custom_post_types as $pt_name => $pt_label ) {

	$pt_title     = __( 'Custom Post Type', 'loos-ssp' ) . ' : ' . sprintf( __( '"%s"', 'loos-ssp' ), $pt_label );
	$quoted_title = sprintf( SSP_Data::$texts['quoted_title'], $pt_label );

	self::output_section( $pt_title, [
		$pt_name . '_noindex' => [
			'title'       => sprintf( SSP_Data::$texts['noindex'], $quoted_title ),
			'type'        => 'switch',
			'desc'        => SSP_Data::$texts['noindex_help'],
		],
		$pt_name . '_title' => [
			'title'       => SSP_Data::$texts['title_tag'],
			'preview'     => true,
			'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>&lt;title&gt;</code>' ),
		],
		$pt_name . '_desc' => [
			'title'       => SSP_Data::$texts['description_tag'],
			'class'       => 'sep',
			'preview'     => true,
			'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>meta:description</code>' ),
		],
	] );
}


// メディアページ
$pt_title     = __( 'Media page', 'loos-ssp' );
$quoted_title = sprintf( SSP_Data::$texts['quoted_title'], $pt_title );

self::output_section( $pt_title, [
	'attachment_disable' => [
		'title'       => sprintf( SSP_Data::$texts['nouse'], $quoted_title ),
		'type'        => 'switch',
		'desc'        => sprintf( __( 'If you select "Yes", you will be redirected to the Media file even if you access %s.', 'loos-ssp' ), $quoted_title ),
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
