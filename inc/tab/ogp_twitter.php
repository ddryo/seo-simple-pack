<?php
/**
 * Twitter タブ
 */
self::output_section( __( 'Twitter settings', 'seo-simple-pack' ), [
	'tw_active'  => [
		'title' => sprintf( SSP_Data::$texts['use'], __( 'meta tags for Twitter', 'seo-simple-pack' ) ),
		'type'  => 'switch',
		// 'desc'  => __( 'Twitter用のOGPタグを出力するかどうかの設定です。', 'seo-simple-pack' ),
	],
	'tw_account' => [
		'title' => __( 'Twitter account name', 'seo-simple-pack' ),
		'desc'  => sprintf( SSP_Data::$texts['input'], __( 'The "xxx" part of <code>@xxx</code>', 'seo-simple-pack' ) ),
	],
	'tw_card'    => [
		'title'   => __( 'Card type', 'seo-simple-pack' ),
		'type'    => 'select',
		'choices' =>
		[
			'summary'             => 'summary',
			'summary_large_image' => 'summary_large_image',
		],
		'desc'    => __( 'The card size will change when you share it on SNS.', 'seo-simple-pack' ),
	],
], 'ogp' );
