<?php
/**
 * Googleアナリティクス タブ
 */

$settings = [
	'webmaster_google' => [__( 'Googleサーチコンソール', 'loos-ssp' ), 'google-site-verification' ],
	'webmaster_bing'   => ['Bing', 'msvalidate.01' ],
	'webmaster_baidu'  => ['Baidu', 'baidu-site-verification' ],
	'webmaster_yandex' => ['Yandex', 'yandex-verification' ],
];

$section_args = [];
foreach ( $settings  as $key => $data ) {
	$desc = __( '埋め込まれるコード ', 'loos-ssp' ) .
		' : <code>&lt;meta name="' . $data[1] . '" content="<b>' . __( '入力コード', 'loos-ssp' ) . '</b>"&gt;</code>';

		$section_args[ $key ] = [
			'title'       => sprintf( __( '%sの認証コード', 'loos-ssp' ), $data[0] ),
			'desc'        => $desc,
			'class'       => '-wide -webmaster',
		];
}
self::output_section( __( 'ウェブマスターツール認証コード', 'loos-ssp' ), $section_args );
