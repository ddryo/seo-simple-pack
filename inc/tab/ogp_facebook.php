<?php
/**
 * Facebook タブ
 */
self::output_section( __( 'Facebook設定', 'loos-ssp' ), [
	'fb_active' => [
		'title' => sprintf( SSP_Data::$texts['use'], __( 'Facebook用設定', 'loos-ssp' ) ),
		'type'  => 'switch',
		'desc'  => __( 'Facebook用のOGPタグを出力するかどうかの設定です。', 'loos-ssp' ),
	],
	'fb_url' => [
		'title' => __( 'FacebookページのURL', 'loos-ssp' ),
		'desc'  => sprintf( SSP_Data::$texts['reflect'], '<code>article:publisher</code>' ),
	],
	'fb_app_id' => [
		'title' => 'fb:app_id',
		'desc'  => sprintf( SSP_Data::$texts['input'], __( 'FacebookアプリID', 'loos-ssp' ) ),
	],
	'fb_admins' => [
		'title' => 'fb:admins',
		'desc'  => sprintf( SSP_Data::$texts['input'], __( 'アプリ管理者の FacebookID', 'loos-ssp' ) ),
	],
], 'ogp' );
