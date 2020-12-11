<?php
/**
 * Googleアナリティクス タブ
 */
self::output_section( __( 'Googleアナリティクス設定', 'loos-ssp' ), [
	'google_analytics_type' => [
		'title'       => __( 'トラッキングコードの種類', 'loos-ssp' ),
		'type'        => 'select',
		'choices'     => [
			'gtag'      => __( 'gtag.jsでコードを埋め込む', 'loos-ssp' ),
			'analytics' => __( 'analytics.jsでコードを埋め込む', 'loos-ssp' ),
		],
		'desc'        => __( '※ 特に理由がなければ<code>gtag.js</code>を推奨します。', 'loos-ssp' ),
	],
	'google_analytics_id' => [
		'title' => __( 'トラッキング ID / 測定ID', 'loos-ssp' ),
		'desc'  => sprintf(
			SSP_Data::$texts['input'],
			__( 'GoogleアナリティクスのトラッキングID( <code>UA-...</code> ) または測定ID( <code>G-...</code> )', 'loos-ssp' )
		),
	],
] );
