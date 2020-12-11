<?php

class SSP_Methods {

	/**
	 * 外部からのインスタンス化を防ぐ
	 */
	private function __construct() {}


	/**
	 * プレビュー機能用のスニペット変換
	 */
	public static function replace_snippets_forpv( $str ) {

		$str = str_replace( '%_site_title_%', '<span>' . esc_html( SSP_Data::$site_title ) . '</span>', $str );
		$str = str_replace( '%_phrase_%', '<span>' . esc_html( SSP_Data::$site_catch_phrase ) . '</span>', $str );
		$str = str_replace( '%_description_%', esc_html( SSP_Data::$settings['home_desc'] ), $str );
		$str = str_replace( '%_page_title_%', '<span>投稿タイトル</span>', $str );
		$str = str_replace( '%_cat_name_%', '<span>カテゴリー名</span>', $str );
		$str = str_replace( '%_tag_name_%', '<span>タグ名</span>', $str );
		$str = str_replace( '%_term_name_%', '<span>ターム名</span>', $str );
		$str = str_replace( '%_tax_name_%', '<span>タクソノミー名</span>', $str );
		$str = str_replace( '%_author_name_%', '<span>著者名(ニックネーム)</span>', $str );
		$str = str_replace( '%_search_phrase_%', '<span>検索ワード</span>', $str );
		$str = str_replace( '%_post_type_%', '<span>投稿タイプ名</span>', $str );
		$str = str_replace( '%_page_contents_%', '<span>投稿コンテンツ</span>', $str );
		$str = str_replace( '%_date_%', '<span>日付</span>', $str );
		$str = str_replace( '%_format_name_%', '<span>フォーマット名</span>', $str );
		$str = str_replace( '%_term_description_%', '<span>タームの説明</span>', $str );

		if ( strpos( $str, '%_sep_%' ) !== false ) {

			$sep_key = SSP_Data::$settings['separator'];
			$sep_val = SSP_Data::SEPARATORS[ $sep_key ];
			$str     = str_replace( '%_sep_%', '<span>' . $sep_val . '</span>', $str );

		}

		return $str;
	}

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


	/**
	 * 管理画面メニューのテーブル内容を出力する
	 */
	public static function output_table_rows( $table_rows, $db_name = null ) {

		if ( 'ogp' === $db_name ) {

			$db = SSP_Data::$ogp;

		} else {

			$db = SSP_Data::$settings;

		}

		foreach ( $table_rows as $key => $row ) {

			$data_disable = '';

			if ( $row['is_checkbox'] ) {

				if ( strpos( $key, '_disable' ) !== false ) {
					$data_disable = 'data-disable="' . (int) $db[ $key ] . '"';
				}

				$form_item = '<span>はい</span><label class="ssp_switch_box" for="' . $key . '">';

				$form_item .= $db[ $key ]
								? '<input type="checkbox" name="" id="' . $key . '" checked>'
								: '<input type="checkbox" name="" id="' . $key . '">';
				$form_item .= '<span class="ssp_switch_box__slider -round"></span></label><span>いいえ</span>';
				$form_item .= '<input type="hidden" name="' . $key . '" value="' . esc_attr( $db[ $key ] ) . '">';

			} else {

				$form_item = $row['item'] ?:
					'<input type="text" name="' . $key . '" id="' . '.$key.' . '"value="' . esc_attr( $db[ $key ] ) . '">';

			}

			if ( strpos( $key, '_desc' ) ) {
				$trclass = 'tr_desc';
			} else {
				$trclass = 'tr';
			}

			echo '<tr class="', $trclass ,'" valign="top" ', $data_disable, '><th scope="row">',
					'<label for="' . $key . '">', $row['title'], '</label>',
					$row['reqired'] ? '<span class="required">*</span>' : '' ,
				'</th>',

				'<td>',
					'<div class="inner ', $row['class'], '">',

						'<div class="ssp_item">', $form_item, '</div>',
						'<div class="ssp_desc">
							<p>', $row['desc'], '</p>',
						'</div>',
						$row['prev'] ?
								'<div class="ssp_prev">┗ ' . __( 'Preview', 'loos-ssp' ) . ' : <p>' .
									self::replace_snippets_forpv( esc_html( $db[ $key ] ) ) .
								'</p><a href="' . admin_url() . 'admin.php?page=ssp_help" target="_blank" title="使用可能なスニペットタグについて" class="ssp_help">?</a></div>'
							: '',
					'</div>',
				'</td>',
			'</tr>';
		}
	}
}
