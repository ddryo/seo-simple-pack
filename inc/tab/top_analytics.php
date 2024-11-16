<?php
/**
 * Googleアナリティクス タブ
 */
$gid_desc = sprintf( SSP_Data::$texts['input'], __( 'Measurement ID (<code>G-XXXX...</code>)', 'seo-simple-pack' ) ) .
'(' . __( 'Please include <code>G-</code>.', 'seo-simple-pack' ) . ')';

$uaid_desc = sprintf( SSP_Data::$texts['input'], __( 'Tracking ID (<code>UA-XXXX...</code>)', 'seo-simple-pack' ) ) .
'(' . __( 'Please include <code>UA-</code>.', 'seo-simple-pack' ) . ')' .
'<br>' . __( 'Note: The UA will be discontinued on July 1, 2023.', 'seo-simple-pack' );

if ( 'ja' === get_locale() ) {
	$gid_desc .= '<br>「測定ID」は、Googleアナリティクスの「管理」（画面左下の歯車アイコン）→ プロパティ列の「データストリーム」→ ストリーム名を選択することで確認できます。';
}

self::output_section( __( 'Google Analytics settings', 'seo-simple-pack' ), [
	'google_g_id'  => [
		'title' => __( '"Measurement ID" for GA4', 'seo-simple-pack' ),
		'class' => '-wide',
		'desc'  => $gid_desc,
	],
	'google_ua_id' => [
		'title' => __( '"Tracking ID" for UA', 'seo-simple-pack' ),
		'class' => '-wide',
		'desc'  => $uaid_desc,
	],
] );
