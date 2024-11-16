<?php
/**
 * Facebook タブ
 */
self::output_section( __( 'Facebook settings', 'seo-simple-pack' ), [
	'fb_active' => [
		'title' => sprintf( SSP_Data::$texts['use'], __( 'meta tags for Facebook', 'seo-simple-pack' ) ),
		'type'  => 'switch',
	],
	'fb_url'    => [
		'title' => __( 'Facebook page URL', 'seo-simple-pack' ),
		'desc'  => sprintf( SSP_Data::$texts['reflect'], '<code>article:publisher</code>' ),
	],
	'fb_app_id' => [
		'title' => 'fb:app_id',
		'desc'  => sprintf( SSP_Data::$texts['input'], __( 'Facebook app ID', 'seo-simple-pack' ) ),
	],
	'fb_admins' => [
		'title' => 'fb:admins',
		'desc'  => sprintf( SSP_Data::$texts['input'], __( 'App administrator\'s Facebook ID', 'seo-simple-pack' ) ),
	],
], 'ogp' );
