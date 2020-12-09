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
	public static $settings = '';


	/**
	 * DB[spp_ogp]用変数
	 */
	public static $ogp = '';


	/**
	 * サイト基本情報
	 */
	public static $site_title        = '';
	public static $site_catch_phrase = '';


	/**
	 * NOUNCEキー アクション名
	 */
	const NOUNCE_ACTION = '_ssp_post';


	/**
	 * NOUNCEキー name
	 */
	const NOUNCE_NAME = '_ssp_nounce';


	/**
	 * 区切り文字リスト
	 */
	const SEPARATORS = [
		'dash'  => '-',
		'line'  => '|',
		'tilde' => '~',
	];


	/**
	 * 基本設定のデフォルト値
	 */
	const DEFAULT_SETTINGS = [
		'home_title'            => '%_site_title_% %_sep_% %_phrase_%',
		'home_desc'             => '',
		'home_keyword'          => '',
		'separator'             => 'line',
		'webmaster_bing'        => '',
		'webmaster_google'      => '',
		'webmaster_baidu'       => '',
		'webmaster_yandex'      => '',
		'google_analytics_type' => 'gtag',
		'google_analytics_id'   => '',
		'post_noindex'          => false,
		'post_title'            => '%_page_title_% %_sep_% %_site_title_%',
		'post_desc'             => '%_page_contents_%',
		'page_noindex'          => false,
		'page_title'            => '%_page_title_% %_sep_% %_site_title_%',
		'page_desc'             => '%_page_contents_%',
		'attachment_disable'    => true,
		'attachment_noindex'    => true,
		'attachment_title'      => '%_page_title_% %_sep_% %_site_title_%',
		'attachment_desc'       => '%_page_contents_%',
		'cat_noindex'           => true,
		'cat_title'             => '%_cat_name_% %_sep_% %_site_title_%',
		// 'cat_desc'              => 'カテゴリー「%_cat_name_%」の一覧ページです。',
		'cat_desc'              => '%_term_description_%',
		'tag_noindex'           => true,
		'tag_title'             => '%_tag_name_% %_sep_% %_site_title_%',
		'tag_desc'              => 'タグ「%_tag_name_%」の一覧ページです。',
		'post_format_disable'   => true,
		'post_format_noindex'   => true,
		'post_format_title'     => '%_format_name_% %_sep_% %_site_title_%',
		'post_format_desc'      => '投稿フォーマット「%_format_name_%」の一覧ページです。',
		'author_disable'        => false,
		'author_noindex'        => true,
		'author_title'          => '%_author_name_% %_sep_% %_site_title_%',
		'author_desc'           => '%_author_name_% の執筆記事一覧ページです。',
		'date_noindex'          => true,
		'date_title'            => '%_date_% %_sep_% %_site_title_%', // get_localで日本語かそうでないか,
		'date_desc'             => '%_date_% の記事一覧ページです。', // get_localで日本語かそうでないか,
		'pt_archive_noindex'    => true,
		'pt_archive_title'      => '%_post_type_% %_sep_% %_site_title_%',
		'pt_archive_desc'       => '「%_post_type_%」の記事一覧ページです',
		'404_title'             => 'ページが見つかりません。 %_sep_% %_site_title_%',
		'search_title'          => '検索: %_search_phrase_% %_sep_% %_site_title_%',
	];


	/**
	 * 初回インストール時に登録するOGP設定のデフォルト値
	 */
	const DEFAULT_OGP = [
		'og_image'   => '',
		'fb_active'  => true,
		'fb_url'     => '',
		'fb_app_id'  => '',
		'fb_admins'  => '',
		'tw_active'  => true,
		'tw_account' => '',
		'tw_card'    => 'summary',
	];


	/**
	 * カスタム投稿のフォーマット形式
	 */
	const DEFAULT_PT_SETTING = [
		'noindex' => false,
		'title'   => '%_page_title_% %_sep_% %_site_title_%',
		'desc'    => '%_page_contents_%',
	];


	/**
	 * カスタムタクソノミーのフォーマット形式
	 */
	const DEFAULT_TAX_SETTING = [
		'noindex' => true,
		'title'   => '%_term_name_% %_sep_% %_site_title_%',
		'desc'    => '%_tax_name_%「%_term_name_%」の一覧ページです。',
	];


	/**
	 * Set Data
	 */
	public static function init() {

		// サイト基本情報取得
		self::$site_title        = esc_html( get_option( 'blogname' ) );
		self::$site_catch_phrase = esc_html( get_option( 'blogdescription' ) );

		// 一般設定データ
		$db_ssp_settings = get_option( self::DB_NAME['settings'] ) ?: [];
		self::$settings  = array_merge( self::DEFAULT_SETTINGS, $db_ssp_settings );

		// OGPせ設定
		$db_ssp_ogp = get_option( self::DB_NAME['ogp'] ) ?: [];
		self::$ogp  = array_merge( self::DEFAULT_OGP, $db_ssp_ogp );
	}

}
