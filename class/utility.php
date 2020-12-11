<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped

class SSP_Utility {

	/**
	 * 外部からのインスタンス化を防ぐ
	 */
	private function __construct() {}


	/**
	 * データを無害化して返す
	 */
	public static function sanitize_post_data( $data ) {

		foreach ( $data as $key => $val ) {

			if ( '' === $val ) {
				continue;
			}

			// "1" , "0" => bool
			$bool_val = filter_var( $val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE );

			if ( null === $bool_val ) {

				$val          = sanitize_text_field( $val );
				$val          = stripslashes( $val );
				$data[ $key ] = $val;

			} else {

				$data[ $key ] = $bool_val;

			}
		}

		return $data;
	}


	/**
	 * 設定更新時のDB更新処理
	 *
	 * @param array $P サニタイズ後の $_POST
	 */
	public static function update_db( $P ) {

		if ( empty( $P ) ) {
			exit( 'POST data was not found' );
		}

		// nonceキー存在チェック
		if ( ! isset( $P[ SSP_Data::NONCE_NAME ] ) ) return;

		// nonceの検証
		if ( ! wp_verify_nonce( $P[ SSP_Data::NONCE_NAME ], SSP_Data::NONCE_ACTION ) ) return;

		// nonceチェック、こっちでも。
		// check_admin_referer( SSP_Data::NONCE_ACTION, SSP_Data::NONCE_NAME );

		// Get DB name.
		$db_name = isset( $P['db_name'] ) ? $P['db_name'] : '';

		// 設定可能なデータのリストを取得
		if ( SSP_Data::DB_NAME['settings'] === $db_name ) {

			$db_data_key = array_keys( SSP_Data::$settings );

		} elseif ( SSP_Data::DB_NAME['ogp'] === $db_name ) {

			$db_data_key = array_keys( SSP_Data::$ogp );

		} else {

			return;
		}

		// 保存したいデータだけを抽出 (送信ボタンのデータなど、不要なものを削除)
		foreach ( $P as $key => $v ) {

			if ( ! in_array( $key, $db_data_key, true ) ) {

				unset( $P[ $key ] );

			}
		}

		// Update
		update_option( $db_name, $P );
	}

}
