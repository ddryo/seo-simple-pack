<?php

class SSP_Data {

	/**
	 * 外部からのインスタンス化を防ぐ
	 */
	private function __construct() {}

	/**
	 * 使用するDBの名前
	 */
	const DB_NAME = [
		'installed'    => 'ssp_installed',
		'notification' => 'ssp_notification',
		'settings'     => 'ssp_settings',
		'ogp'          => 'ssp_ogp',
	];

	/**
	 * DB[ssp_settings]用変数
	 */
	public static $settings = null;

	/**
	 * DB[spp_ogp]用変数
	 */
	public static $ogp = null;

	/**
	 * サイト基本情報
	 */
	public static $site_title        = '';
	public static $site_catch_phrase = '';

	/**
	 * 共通テキスト
	 */
	public static $texts = '';

	/**
	 * 設定のデフォルト値
	 */
	public static $default_settings     = []; // 基本設定のデフォルト値
	public static $default_ogp_settings = []; // OGP設定のデフォルト値
	public static $default_pt_settings  = []; // カスタム投稿のフォーマット形式
	public static $default_tax_settings = []; // カスタムタクソノミーのフォーマット形式

	/**
	 * カスタム投稿タイプ・カスタムタクソノミーを保持しておくための変数。
	 *   形式: [ 'name' => 'label' ]
	 */
	public static $custom_post_types = [];
	public static $custom_taxonomies = [];

	/**
	 * nonce
	 */
	const NONCE_ACTION = 'ssp_nonce_action';
	const NONCE_NAME   = 'ssp_nonce_name';

	/**
	 * 区切り文字リスト
	 */
	const SEPARATORS = [
		'dash'  => '-',
		'line'  => '|',
		'tilde' => '~',
	];


	/**
	 * Set Data
	 */
	public static function init() {

		// 共通の翻訳用テキスト
		self::$texts = [
			'quoted_title'         => __( '"%s"', 'loos-ssp' ),
			'quoted_archive_title' => __( '"%s" archive page', 'loos-ssp' ),
			'is_snippet'           => __( 'This content is treated as %s.', 'loos-ssp' ), // この内容は %s として扱われます。
			'title_of'             => __( 'Title tag of %s', 'loos-ssp' ), // %sのタイトルタグ
			'description_of'       => __( 'Description of %s', 'loos-ssp' ), // %sのディスクリプション
			'keyword_of'           => __( 'Keywords of %s', 'loos-ssp' ),
			'title_tag'            => __( 'Title tag format', 'loos-ssp' ), // タイトルタグの形式
			'description_tag'      => __( 'Description format', 'loos-ssp' ), // ディスクリプションの形式
			'use'                  => __( 'Use %s', 'loos-ssp' ), // %sを使用する
			'nouse'                => __( 'Do not use %s', 'loos-ssp' ), // を使用しない
			'noindex'              => __( 'Do not index %s', 'loos-ssp' ), // sをインデックスさせない
			'noindex_help'         => __( 'If you select "Yes", the default output will be <code>noindex</code>.', 'loos-ssp' ),
			'default_output'       => __( 'The default setting of %2$s to be output to %1$s.', 'loos-ssp' ),
			'input'                => __( 'Please enter %s.', 'loos-ssp' ),
			'reflect'              => __( 'It will be reflected in %s.', 'loos-ssp' ),
			'archive_desc'         => __( 'This is the archive page for %s.', 'loos-ssp' ),
		];

		// 設定のデフォルト値をセット
		self::set_default();

		// インストール済みバージョン情報を取得
		$installed_version = get_option( self::DB_NAME['installed'] );

		if ( false === $installed_version ) {
			// インストール時に実行する処理
			self::setup_at_installed();

		} elseif ( SSP_VERSION !== $installed_version ) {
			// バージョン更新時に実行する処理
			\LOOS\SSP\Update_Action::setup_at_updated( $installed_version );
		}

		// データセット
		self::setup_data();
	}


	/**
	 * デフォルト値をセット
	 */
	public static function set_default() {
		self::$default_settings = [
			'home_title'               => '%_site_title_% %_sep_% %_tagline_%',
			'home_desc'                => '',
			'home_keyword'             => '',
			'reuse_keyword'            => '1',
			'separator'                => 'line',
			'webmaster_bing'           => '',
			'webmaster_google'         => '',
			'webmaster_baidu'          => '',
			'webmaster_yandex'         => '',
			'google_analytics_type'    => 'gtag',
			'google_analytics_id'      => '',
			'google_g_id'              => '',
			'google_ua_id'             => '',
			'post_noindex'             => false,
			'post_title'               => '%_page_title_% %_sep_% %_site_title_%',
			'post_desc'                => '%_page_contents_%',
			'page_noindex'             => false,
			'page_title'               => '%_page_title_% %_sep_% %_site_title_%',
			'page_desc'                => '%_page_contents_%',
			'attachment_disable'       => true,
			'attachment_noindex'       => true,
			'attachment_title'         => '%_page_title_% %_sep_% %_site_title_%',
			'attachment_desc'          => '%_page_contents_%',
			'cat_noindex'              => false,
			'cat_title'                => '%_term_name_% %_sep_% %_site_title_%',
			'cat_desc'                 => '%_term_description_%',
			'tag_noindex'              => false,
			'tag_title'                => '%_term_name_% %_sep_% %_site_title_%',
			'tag_desc'                 => '%_term_description_%',
			'post_format_disable'      => false,
			'post_format_noindex'      => true,
			'post_format_title'        => '%_term_name_% %_sep_% %_site_title_%',
			'post_format_desc'         => '',
			'author_disable'           => false,
			'author_noindex'           => true,
			'author_title'             => '%_author_name_% %_sep_% %_site_title_%',
			'author_desc'              => sprintf( self::$texts['archive_desc'], '%_author_name_%' ),
			'date_noindex'             => true,
			'date_title'               => '%_date_% %_sep_% %_site_title_%',
			'date_desc'                => sprintf( self::$texts['archive_desc'], '%_date_%' ),
			'pt_archive_noindex'       => true,
			'pt_archive_title'         => '%_post_type_% %_sep_% %_site_title_%',
			'pt_archive_desc'          => sprintf( self::$texts['archive_desc'], '%_post_type_%' ),
			'404_title'                => '404: ' . __( 'Page not found', 'loos-ssp' ) . ' %_sep_% %_site_title_%',
			'search_title'             => __( 'Searched:', 'loos-ssp' ) . ' %_search_phrase_% %_sep_% %_site_title_%',
			'feed_noindex'             => false,
		];

		self::$default_ogp_settings = [
			'og_image'   => '',
			'fb_active'  => true,
			'fb_url'     => '',
			'fb_app_id'  => '',
			'fb_admins'  => '',
			'tw_active'  => true,
			'tw_account' => '',
			'tw_card'    => 'summary_large_image',
		];

		/**
		 * カスタム投稿のフォーマット形式
		 */
		self::$default_pt_settings = [
			'noindex' => false,
			'title'   => '%_page_title_% %_sep_% %_site_title_%',
			'desc'    => '%_page_contents_%',
		];

		/**
		 * カスタムタクソノミーのフォーマット形式
		 */
		self::$default_tax_settings = [
			'noindex' => true,
			'title'   => '%_term_name_% %_sep_% %_site_title_%',
			'desc'    => '%_term_description_%',
		];
	}

	/**
	 * データを変数にセット
	 */
	public static function setup_data() {
		// サイト基本情報取得
		self::$site_title        = get_option( 'blogname' );
		self::$site_catch_phrase = get_option( 'blogdescription' );

		// 一般設定データ
		$saved_settings = get_option( self::DB_NAME['settings'] ) ?: [];
		self::$settings = array_merge( self::$default_settings, $saved_settings );

		// OGP設定
		$saved_ogp_settings = get_option( self::DB_NAME['ogp'] ) ?: [];
		self::$ogp          = array_merge( self::$default_ogp_settings, $saved_ogp_settings );
	}


	/**
	 * 設定値の取得
	 */
	public static function get( $db_name, $key ) {
		if ( 'settings' === $db_name ) {
			$data = self::$settings;
		} elseif ( 'ogp' === $db_name ) {
			$data = self::$ogp;
		} else {
			return;
		}

		if ( isset( $data[ $key ] ) ) {
			return $data[ $key ];
		} else {
			return false;
		}
	}


	/**
	 * インストール時に実行する処理
	 */
	public static function setup_at_installed() {

		update_option( self::DB_NAME['installed'], SSP_VERSION );
		// update_option( SSP_Data::DB_NAME[ 'notification' ], 'hide' );

		// デフォルト設定を保存
		update_option( self::DB_NAME['settings'], self::$default_settings );
		update_option( self::DB_NAME['ogp'], self::$default_ogp_settings );
	}


	/**
	 * 設定保存時の処理ではなく、コードによる更新
	 * $db_name: 'settings' or 'ogp'
	 */
	public static function update_data( $db_name, $new_data, $delete_data = [] ) {

		$now_data = get_option( self::DB_NAME[ $db_name ] ) ?: [];
		$new_data = array_merge( $now_data, $new_data );

		// 不要になったデータを削除
		foreach ( $delete_data as $key ) {
			if ( isset( $new_data[ $key ] ) ) unset( $new_data[ $key ] );
		}

		update_option( self::DB_NAME[ $db_name ], $new_data );
	}
}
