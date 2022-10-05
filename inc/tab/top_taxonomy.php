<?php
/**
 * タクソノミーアーカイブ タブ
 */

// カテゴリー
$tax_title    = __( 'Category', 'loos-ssp' );
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
		'title'       => SSP_Data::$texts['description_tag'],
		'class'       => 'sep',
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>meta:description</code>' ),
	],
] );


// タグ
$tax_title    = __( 'Tag', 'loos-ssp' );
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
		'title'       => SSP_Data::$texts['description_tag'],
		'class'       => 'sep',
		'preview'     => true,
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>meta:description</code>' ),
	],
] );

// カスタムタクソノミー
foreach ( SSP_Data::$custom_taxonomies as $tax_name => $tax_label ) {

	$tax_title    = __( 'Taxonomy', 'loos-ssp' ) . ' : ' . sprintf( __( '"%s"', 'loos-ssp' ), $tax_label );
	$quoted_title = sprintf( SSP_Data::$texts['quoted_archive_title'], $tax_label );
	self::output_section( $tax_title, [
		$tax_name . '_noindex' => [
			'title' => sprintf( SSP_Data::$texts['noindex'], $quoted_title ),
			'type'  => 'switch',
			'desc'  => SSP_Data::$texts['noindex_help'],
		],
		$tax_name . '_title' => [
			'title'       => SSP_Data::$texts['title_tag'],
			'preview'     => true,
			'desc'        => sprintf(
				SSP_Data::$texts['default_output'],
				$quoted_title,
				'<code>&lt;title&gt;</code>'
			),
		],
		$tax_name . '_desc' => [
			'title'       => SSP_Data::$texts['description_tag'],
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
$supported_formats = get_theme_support( 'post-formats' );
if ( ! empty( $supported_formats ) ) {
	$tax_title    = __( 'Post Format', 'loos-ssp' );
	$quoted_title = sprintf( SSP_Data::$texts['quoted_archive_title'], $tax_title );
	self::output_section( $tax_title, [
		'post_format_disable' => [
			'title' => sprintf( SSP_Data::$texts['nouse'], $quoted_title ),
			'type'  => 'switch',
			'desc'  => sprintf( __( 'If you select "Yes", you will be redirected to the Home even if you access %s.', 'loos-ssp' ), $quoted_title ),
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
}
