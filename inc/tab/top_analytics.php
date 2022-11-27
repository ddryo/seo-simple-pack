<?php
/**
 * Googleアナリティクス タブ
 */
$gid_desc = sprintf( SSP_Data::$texts['input'], __( 'Measurement ID (<code>G-XXXX...</code>)', 'loos-ssp' ) ) .
'(' . __( 'Please include <code>G-</code>.', 'loos-ssp' ) . ')';

$uaid_desc = sprintf( SSP_Data::$texts['input'], __( 'Tracking ID (<code>UA-XXXX...</code>)', 'loos-ssp' ) ) .
'(' . __( 'Please include <code>UA-</code>.', 'loos-ssp' ) . ')' .
'<br>' . __( 'Note: The UA will be discontinued on July 1, 2023.', 'loos-ssp' );

if ( 'ja' === get_locale() ) {
	$gid_desc .= '<br>「測定ID」は、Googleアナリティクスの「管理」（画面左下の歯車アイコン）→ プロパティ列の「データストリーム」→ ストリーム名を選択することで確認できます。';
}

self::output_section( __( 'Google Analytics settings', 'loos-ssp' ), [
	'google_g_id' => [
		'title' => __( '"Measurement ID" for GA4', 'loos-ssp' ),
		'class' => '-wide',
		'desc'  => $gid_desc,
	],
	'google_ua_id' => [
		'title' => __( '"Tracking ID" for UA', 'loos-ssp' ),
		'class' => '-wide',
		'desc'  => $uaid_desc,
	],
] );
