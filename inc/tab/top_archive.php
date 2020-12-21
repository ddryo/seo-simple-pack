<?php
/**
 * その他アーカイブ タブ
 */

// 著者アーカイブ
$the_title    = __( 'Author', 'loos-ssp' );
$quoted_title = sprintf( SSP_Data::$texts['quoted_archive_title'], $the_title );
self::output_section( $quoted_title, [
	'author_disable' => [
		'title'       => sprintf( SSP_Data::$texts['nouse'], $quoted_title ),
		'type'        => 'switch',
		'desc'        => sprintf( __( 'If you select "Yes", you will be redirected to the Home even if you access %s.', 'loos-ssp' ), $quoted_title ),
	],
	'author_noindex' => [
		'title'       => sprintf( SSP_Data::$texts['noindex'], $quoted_title ),
		'type'        => 'switch',
		'desc'        => SSP_Data::$texts['noindex_help'],
	],
	'author_title' => [
		'title'       => SSP_Data::$texts['title_tag'],
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>&lt;title&gt;</code>' ),
		'preview'     => true,
	],
	'author_desc' => [
		'title'       => SSP_Data::$texts['description_tag'],
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>meta:description</code>' ),
		'preview'     => true,
	],
] );


// 日付アーカイブ
$the_title    = __( 'Date', 'loos-ssp' );
$quoted_title = sprintf( SSP_Data::$texts['quoted_archive_title'], $the_title );
self::output_section( $quoted_title, [
	'date_noindex' => [
		'title'       => sprintf( SSP_Data::$texts['noindex'], $quoted_title ),
		'type'        => 'switch',
		'desc'        => SSP_Data::$texts['noindex_help'],
	],
	'date_title' => [
		'title'       => SSP_Data::$texts['title_tag'],
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>&lt;title&gt;</code>' ),
		'preview'     => true,
	],
	'date_desc' => [
		'title'       => SSP_Data::$texts['description_tag'],
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>meta:description</code>' ),
		'preview'     => true,
	],
] );


// カスタム投稿　タイプアーカイブ
$the_title    = __( 'Custom Post Type', 'loos-ssp' );
$quoted_title = sprintf( SSP_Data::$texts['quoted_archive_title'], $the_title );
self::output_section( $quoted_title, [
	'pt_archive_noindex' => [
		'title'       => sprintf( SSP_Data::$texts['noindex'], $quoted_title ),
		'type'        => 'switch',
		'desc'        => SSP_Data::$texts['noindex_help'],
	],
	'pt_archive_title' => [
		'title'       => SSP_Data::$texts['title_tag'],
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>&lt;title&gt;</code>' ),
		'preview'     => true,
	],
	'pt_archive_desc' => [
		'title'       => SSP_Data::$texts['description_tag'],
		'desc'        => sprintf( SSP_Data::$texts['default_output'], $quoted_title, '<code>meta:description</code>' ),
		'preview'     => true,
	],
] );
// アーカイブが無効なカスタム投稿タイプでは関係ありません。
?>
<p class="ssp-page__note">
	※ <?=esc_html__( 'It does not matter for custom post types with invalid archiving.', 'loos-ssp' )?>
</p>
