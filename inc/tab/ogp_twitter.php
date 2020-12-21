<?php
/**
 * Twitter タブ
 */
self::output_section( __( 'Twitter settings', 'loos-ssp' ), [
	'tw_active' => [
		'title' => sprintf( SSP_Data::$texts['use'], __( 'meta tags for Twitter', 'loos-ssp' ) ),
		'type'  => 'switch',
		// 'desc'  => __( 'Twitter用のOGPタグを出力するかどうかの設定です。', 'loos-ssp' ),
	],
	'tw_account' => [
		'title' => __( 'Twitter account name', 'loos-ssp' ),
		'desc'  => sprintf( SSP_Data::$texts['input'], __( 'The "xxx" part of <code>@xxx</code>', 'loos-ssp' ) ),
	],
	'tw_card' => [
		'title'   => __( 'Card type', 'loos-ssp' ),
		'type'    => 'select',
		'choices' =>
		[
			'summary'             => 'summary',
			'summary_large_image' => 'summary_large_image',
		],
		'desc'    => __( 'The card size will change when you share it on SNS.', 'loos-ssp' ),
	],
], 'ogp' );
