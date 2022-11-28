<?php
namespace LOOS\SSP;

class Update_Action extends \SSP_Data {

	/**
	 * 外部からのインスタンス化を防ぐ
	 */
	private function __construct() {}


	/**
	 * 更新時に実行する処理
	 */
	public static function setup_at_updated( $installed_version ) {
		// メンバ変数に予めデータセット
		self::setup_data();

		// 現在のバージョン番号を保存
		update_option( self::DB_NAME['installed'], SSP_VERSION );

		// バージョンが上がった時だけの処理
		// if (version_compare( SSP_VERSION, $installed_version, '>' ) ) {}

		// 特定のバージョンより古いとこからアップデートされた時に処理する
		if ( version_compare( $installed_version, '2.2.7', '<=' ) ) {
			self::clean_meta();
		}
		if ( version_compare( $installed_version, '3.0.0', '<=' ) ) {
			self::migrate_ga_data();
		}
	}


	/**
	 * 不要なメタを削除
	 */
	public static function clean_meta() {

		// 空のカスタムフィールドを削除
		global $wpdb;

		// phpcs:disable WordPress.DB.DirectDatabaseQuery, WordPress.DB.SlowDBQuery
		foreach ( SSP_MetaBox::POST_META_KEYS as $key => $meta_key ) {
			$wpdb->delete( $wpdb->postmeta, [
				'meta_key'   => $meta_key,
				'meta_value' => '',
			] );
		}

		foreach ( SSP_MetaBox::TERM_META_KEYS as $key => $meta_key ) {
			$wpdb->delete( $wpdb->termmeta, [
				'meta_key'   => $meta_key,
				'meta_value' => '',
			] );
		}
		// phpcs:enable WordPress.DB.DirectDatabaseQuery, WordPress.DB.SlowDBQuery
	}


	/**
	 * アナリティクスをUA,GA4両方出力できるように変更するためのデータ置換
	 */
	public static function migrate_ga_data() {
		$old_id = self::get( 'settings', 'google_analytics_id' );
		if ( ! $old_id ) return;

		$is_UA = 0 === strpos( $old_id, 'UA' );

		if ( $is_UA ) {
			$new_code_key = 'google_ua_id';
		} else {
			$new_code_key = 'google_g_id';
		}

		self::update_data( 'settings', [
			"$new_code_key" => $old_id,
		]);
	}
}
