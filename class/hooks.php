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

		add_action( 'init', [ 'SSP_Hooks', 'add_custom_settings' ], 999 );
		add_action( 'admin_enqueue_scripts', [ 'SSP_Hooks', 'include_files' ] );
		add_action( 'template_redirect', [ 'SSP_Hooks', 'redirect' ], 1 );

		// titleタグの除去
		remove_action( 'wp_head', '_wp_render_title_tag', 1 );

		// canonicalの削除
		remove_action( 'wp_head', 'rel_canonical' );

		// self::set_notification(); //OFF中
	}


	/**
	 *  CSS Scriptの読み込み
	 */
	public static function include_files( $hook_suffix ) {

		$is_index       = 'index.php' === $hook_suffix;
		$is_editor_page = 'post.php' === $hook_suffix || 'post-new.php' === $hook_suffix;
		$is_ssp_page    = false !== strpos( $hook_suffix, 'ssp_' );

		// SSP設定ページで読み込むファイル
		if ( $is_ssp_page ) {
			wp_enqueue_media();
			wp_enqueue_script( 'ssp-media', SSP_URL . 'dist/js/mediauploader.js', ['jquery' ], SSP_VERSION, true );
			wp_enqueue_script( 'ssp-script', SSP_URL . 'assets/js/ssp.js', ['jquery' ], SSP_VERSION, true );
			wp_enqueue_style( 'ssp-css', SSP_URL . 'dist/css/ssp.css', [], SSP_VERSION );

		} elseif ( $is_editor_page ) {

			wp_enqueue_style( 'ssp-post', SSP_URL . 'dist/css/post.css', [], SSP_VERSION );

		} elseif ( 'term.php' === $hook_suffix ) {
			wp_enqueue_style( 'ssp-term', SSP_URL . 'dist/css/term.css', [], SSP_VERSION );
		}

		// 共通ファイル
		if ( $is_index || $is_editor_page || $is_ssp_page ) {
			wp_enqueue_script( 'ssp-common-script', SSP_URL . 'assets/js/ssp_common.js', ['jquery' ], SSP_VERSION, true );
			wp_enqueue_style( 'ssp-common', SSP_URL . 'dist/css/common.css', [], SSP_VERSION );
		}

	}



	/**
	 * カスタム投稿タイプ・カスタムタクソノミー用の設定を追加
	 */
	public static function add_custom_settings() {

		if ( ! is_admin() ) return;

		$added_new_data = false;
		$args           = [
			'public'   => true,
			'_builtin' => false,
		];
		$post_types     = get_post_types( $args, 'names', 'and' );
		$taxonomies     = get_taxonomies( $args, 'names', 'and' );

		// カスタム投稿 settings 追加
		foreach ( $post_types as $pt ) {
			if ( ! isset( SSP_Data::$settings[ $pt . '_noindex' ] ) ) {
				SSP_Data::$settings[ $pt . '_noindex' ] = SSP_Data::$default_pt_settings['noindex'];
				SSP_Data::$settings[ $pt . '_title' ]   = SSP_Data::$default_pt_settings['title'];
				SSP_Data::$settings[ $pt . '_desc' ]    = SSP_Data::$default_pt_settings['desc'];
				$added_new_data                         = true;
			}
		}

		// カスタムタクソノミー settings 追加
		foreach ( $taxonomies as $tax ) {
			if ( ! isset( SSP_Data::$settings[ $tax . '_noindex' ] ) ) {
				SSP_Data::$settings[ $tax . '_noindex' ] = SSP_Data::$default_tax_settings['noindex'];
				SSP_Data::$settings[ $tax . '_title' ]   = SSP_Data::$default_tax_settings['title'];
				SSP_Data::$settings[ $tax . '_desc' ]    = SSP_Data::$default_tax_settings['desc'];
				$added_new_data                          = true;
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

		$home = home_url();

		if ( is_author() && SSP_Data::$settings['author_disable'] ) {
			wp_safe_redirect( $home );
			exit;
		}
		if ( is_tax() && SSP_Data::$settings['post_format_disable'] ) {
			if ( 'post_format' === get_queried_object()->taxonomy ) {
				wp_safe_redirect( $home );
				exit;
			};
		}
		if ( is_attachment() && SSP_Data::$settings['attachment_disable'] ) {
			wp_safe_redirect( get_post()->guid );
			exit;
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
