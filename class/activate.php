<?php

class SSP_Activate {

	/**
	 * 外部からのインスタンス化を防ぐ
	 */
	private function __construct() {}


	/**
	 * プラグイン有効化時の処理
	 * Function for the plugin activated.
	 */
	// public static function plugin_activate() {}


	/**
	 * プラグイン停止時の処理
	 * Function for the plugin deactivated.
	 */
	// public static function plugin_deactivate() {}


	/**
	 * プラグインアンインストール時の処理
	 * Function for the plugin uninstalled.
	 */
	public static function plugin_uninstall() {
		foreach ( SSP_Data::DB_NAME as $db_name ) {
			delete_option( $db_name );
		}
	}

}
