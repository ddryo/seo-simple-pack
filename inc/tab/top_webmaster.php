<?php
/**
 * Googleアナリティクス タブ
 */

$settings = [
	'webmaster_google' => [ __( 'Google Search Console', 'seo-simple-pack' ), 'google-site-verification' ],
	'webmaster_bing'   => [ 'Bing', 'msvalidate.01' ],
	'webmaster_baidu'  => [ 'Baidu', 'baidu-site-verification' ],
	'webmaster_yandex' => [ 'Yandex', 'yandex-verification' ],
];

$section_args = [];
foreach ( $settings  as $key => $data ) {
	$desc = __( 'Output code ', 'seo-simple-pack' ) .
		' : <code>&lt;meta name="' . $data[1] . '" content="<b>' . _x( 'Your code', 'input', 'seo-simple-pack' ) . '</b>"&gt;</code>';

	$section_args[ $key ] = [
		'title' => sprintf( __( 'Authentication code for %s', 'seo-simple-pack' ), $data[0] ),
		'desc'  => $desc,
		'class' => '-wide -webmaster',
	];
}
self::output_section( __( 'Webmaster Tools Certification Code', 'seo-simple-pack' ), $section_args );
