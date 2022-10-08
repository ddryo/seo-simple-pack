<?php
class SSP_Hooks {

	/**
	 * 外部からのインスタンス化を防ぐ
	 */
	private function __construct() {}

	/**
	 * init
	 */
	public static function init() {

		add_action( 'init', [ 'SSP_Hooks', 'add_custom_settings' ], 99 ); // 確実に全部取得できるように後ろで発火
		add_action( 'admin_enqueue_scripts', [ 'SSP_Hooks', 'include_files' ] );
		add_action( 'admin_head', [ 'SSP_Hooks', 'hook_admin_head' ] );
		add_action( 'template_redirect', [ 'SSP_Hooks', 'redirect' ], 1 );

		// titleタグの除去
		remove_action( 'wp_head', '_wp_render_title_tag', 1 );

		// canonicalの削除
		remove_action( 'wp_head', 'rel_canonical' );

		// self::set_notification(); //OFF中
	}


	/**
	 * .dashicons-list-view が微妙にでかいので微調整
	 */
	public static function hook_admin_head() {
		echo '<style>.toplevel_page_ssp_main_setting .dashicons-list-view{transform: scale(.9) translateX(1px)}</style>';
	}


	/**
	 *  CSS Scriptの読み込み
	 */
	public static function include_files( $hook_suffix ) {

		$is_index       = 'index.php' === $hook_suffix;
		$is_term        = 'term.php' === $hook_suffix;
		$is_editor_page = 'post.php' === $hook_suffix || 'post-new.php' === $hook_suffix;
		$is_ssp_page    = false !== strpos( $hook_suffix, 'ssp_' );

		$ver = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? wp_date( 'mdGis' ) : SSP_VERSION;

		// SSP設定ページで読み込むファイル
		if ( $is_ssp_page ) {

			wp_enqueue_style( 'ssp-css', SSP_URL . 'dist/css/ssp.css', [], $ver );
			wp_enqueue_script( 'ssp-script', SSP_URL . 'dist/js/ssp.js', ['jquery' ], $ver, true );

		} elseif ( $is_editor_page ) {

			wp_enqueue_style( 'ssp-post', SSP_URL . 'dist/css/post.css', [], $ver );

		} elseif ( $is_term ) {

			wp_enqueue_style( 'ssp-term', SSP_URL . 'dist/css/term.css', [], $ver );
		}

		// 設定ページでの共通ファイル
		if ( $is_editor_page || $is_ssp_page || $is_term ) {
			wp_enqueue_style( 'ssp-common', SSP_URL . 'dist/css/common.css', [], $ver );

			wp_enqueue_media();
			wp_enqueue_script( 'ssp-switch', SSP_URL . 'dist/js/switch.js', [], $ver, true );
			wp_enqueue_script( 'ssp-media', SSP_URL . 'dist/js/mediauploader.js', [ 'jquery' ], $ver, true );
		}

		// ダッシュボードでも読み込むファイル
		if ( $is_index ) {
			wp_enqueue_style( 'ssp-common', SSP_URL . 'dist/css/common.css', [], $ver );
		}

	}



	/**
	 * カスタム投稿タイプ・カスタムタクソノミー用を取得し、設定を追加
	 */
	public static function add_custom_settings() {

		if ( ! is_admin() ) return;

		$added_new_data = false;
		$args           = [
			'public'   => true,
			'_builtin' => false,
		];

		$custom_post_types = get_post_types( $args, 'objects', 'and' ) ?: [];
		foreach ( $custom_post_types as $key => $obj ) {
			SSP_Data::$custom_post_types[ $key ] = $obj->label;
		}

		$custom_taxonomies = get_taxonomies( $args, 'objects', 'and' ) ?: [];
		foreach ( $custom_taxonomies as $key => $obj ) {
			SSP_Data::$custom_taxonomies[ $key ] = $obj->label;
		}

		// カスタム投稿 の設定追加
		foreach ( SSP_Data::$custom_post_types as $pt_name => $label ) {
			if ( ! isset( SSP_Data::$settings[ $pt_name . '_noindex' ] ) ) {
				SSP_Data::$settings[ $pt_name . '_noindex' ] = SSP_Data::$default_pt_settings['noindex'];
				SSP_Data::$settings[ $pt_name . '_title' ]   = SSP_Data::$default_pt_settings['title'];
				SSP_Data::$settings[ $pt_name . '_desc' ]    = SSP_Data::$default_pt_settings['desc'];

				$added_new_data = true;
			}
		}

		// カスタムタクソノミー の設定追加
		foreach ( SSP_Data::$custom_taxonomies as $tax_name => $label ) {
			if ( ! isset( SSP_Data::$settings[ $tax_name . '_noindex' ] ) ) {
				SSP_Data::$settings[ $tax_name . '_noindex' ] = SSP_Data::$default_tax_settings['noindex'];
				SSP_Data::$settings[ $tax_name . '_title' ]   = SSP_Data::$default_tax_settings['title'];
				SSP_Data::$settings[ $tax_name . '_desc' ]    = SSP_Data::$default_tax_settings['desc'];

				$added_new_data = true;
			}
		}

		// 新規追加項目があった場合
		if ( $added_new_data ) {
			update_option( SSP_Data::DB_NAME['settings'], SSP_Data::$settings );
		}

	}


	/**
	 *  使用しないページのリダイレクト処理
	 */
	public static function redirect( $page ) {

		$home = home_url( '/' );

		if ( is_author() && SSP_Data::$settings['author_disable'] ) {
			wp_safe_redirect( $home );
			exit;
		}

		// check: /type/aside
		if ( is_tax() && SSP_Data::$settings['post_format_disable'] ) {
			$obj = get_queried_object();
			if ( isset( $obj->taxonomy ) && 'post_format' === $obj->taxonomy ) {
				wp_safe_redirect( $home );
				exit;
			};
		}
		if ( is_attachment() && SSP_Data::$settings['attachment_disable'] ) {
			wp_safe_redirect( get_post()->guid );
			exit;
		}

		// feedをインデックスさせない（noidex）
		if ( is_feed() && SSP_Data::$settings['feed_noindex'] && headers_sent() === false ) {
			header( 'X-Robots-Tag: noindex, follow', true );
		}
	}


	/**
	 * 更新に関する通知 :: 〜OFF中〜
	 */
	private static function set_notification() {

		/**
		 * プラグイン更新時、notification を show にセット
		 */
		if ( get_option( SSP_Data::DB_NAME['notification'] ) !== 'hide' ) {
			update_option( SSP_Data::DB_NAME['notification'], 'show' );
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( isset( $_POST['ssp_notice_close'] ) ) {
			// CLOSEボタン押された時
			update_option( SSP_Data::DB_NAME['notification'], 'hide' );
		}

		// 以前から使用中の方へ向けてのメッセージ
		$notification_db = get_option( SSP_Data::DB_NAME['notification'] );
		if ( 'show' === $notification_db ) {
			add_action( 'admin_notices', function() {
				?>
					<div class="notice notice-error ssp-notice">
						<p>
							~ 通知したいメッセージ ~
						</p>
						<form action="" method="post">
							<button type="submit" name="ssp_notice_close" class="ssp-notice__closeBtn notice-dismiss">
								<span>この通知を非表示にする</span>
							</button>
						</form>
					</div>
				<?php
			} );
		}

	}

}
