<?php
/**
 * Twitter タブ
 */
self::output_section( __( 'Twitter設定', 'loos-ssp' ), [
	'tw_active' => [
		'title' => sprintf( SSP_Data::$texts['use'], __( 'Twitter用設定', 'loos-ssp' ) ),
		'type'  => 'switch',
		'desc'  => __( 'Twitter用のOGPタグを出力するかどうかの設定です。', 'loos-ssp' ),
	],
	'tw_account' => [
		'title' => __( 'Twitterアカウント名', 'loos-ssp' ),
		'desc'  => sprintf( SSP_Data::$texts['input'], __( '<code>@xxx</code>の「xxx」部分', 'loos-ssp' ) ),
	],
	'tw_card' => [
		'title'   => __( 'カードタイプ', 'loos-ssp' ),
		'type'    => 'select',
		'choices' =>
		[
			'summary'             => 'summary',
			'summary_large_image' => 'summary_large_image',
		],
		'desc'    => __( 'SNSなどでシェアした時のカードサイズが変化します。', 'loos-ssp' ),
	],
], 'ogp' );
