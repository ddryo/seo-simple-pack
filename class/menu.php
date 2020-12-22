<?php
class SSP_Menu {

	use SSP\Field;

	/**
	 * トップメニューに表示するタブコンテンツ
	 */
	private static $top_menu_tabs;


	/**
	 * OGPメニューに表示するタブコンテンツ
	 */
	private static $ogp_menu_tabs;


	/**
	 * 外部からのインスタンス化を防ぐ
	 */
	private function __construct() {}


	/**
	 * init
	 */
	public static function init() {

		self::$top_menu_tabs = [
			'basic'     => __( 'Basic setting', 'loos-ssp' ),    // 基本設定
			'post_type' => __( 'Post page', 'loos-ssp' ),        // 投稿ページ
			'taxonomy'  => __( 'Taxonomy archive', 'loos-ssp' ), // タクソノミーアーカイブ
			'archive'   => __( 'Other archives', 'loos-ssp' ),   // その他アーカイブ
			'analytics' => __( 'Google Analytics', 'loos-ssp' ), // Googleアナリティクス
			'webmaster' => __( 'Webmaster tools', 'loos-ssp' ),  // ウェブマスターツール
		];

		self::$ogp_menu_tabs = [
			'basic'    => __( 'Basic setting', 'loos-ssp' ),
			'facebook' => 'Facebook',
			'twitter'  => 'Twitter',
		];

		add_action( 'admin_menu', ['SSP_Menu', 'add_menus' ] );
	}


	/**
	 * メニューの追加
	 */
	public static function add_menus() {

		// トップレベルメニュー
		$top_menu_title = 'SEO SIMPLE PACK'; // ページのタイトルタグに表示されるテキスト
		$top_menu_slug  = 'ssp_main_setting'; // このメニューを参照するスラッグ名
		$top_menu_cb    = ['SSP_Menu', 'ssp_top_menu' ]; // 呼び出す関数名

		add_menu_page(
			$top_menu_title,
			'SEO PACK',
			'manage_options', // 必要な権限
			$top_menu_slug,
			$top_menu_cb,
			'dashicons-list-view',
			81 // 位置
		);
		add_submenu_page(
			$top_menu_slug,
			$top_menu_title,
			__( 'General settings', 'loos-ssp' ), // サブ側の名前
			'administrator',       // 権限
			$top_menu_slug,
			$top_menu_cb
		);

		// サブメニュー:OGP設定
		add_submenu_page(
			'ssp_main_setting',
			__( 'OGP settings', 'loos-ssp' ), // 'OGP設定',
			__( 'OGP settings', 'loos-ssp' ), // 'OGP設定',
			'administrator',
			'ssp_ogp_setting',
			['SSP_Menu', 'ssp_ogp_menu' ]
		);

		// サブメニュー:HELP
		add_submenu_page(
			'ssp_main_setting',
			'HELP',
			'HELP',
			'administrator',
			'ssp_help',
			['SSP_Menu', 'ssp_help_menu' ]
		);
	}


	/**
	 * トップレベルメニュー 内容
	 */
	public static function ssp_top_menu() {
		require_once SSP_PATH . 'inc/page_top.php';
	}

	// サブメニュー [OGP] 内容
	public static function ssp_ogp_menu() {
		require_once SSP_PATH . 'inc/page_ogp.php';
	}

	// サブメニュー [HELP] 内容
	public static function ssp_help_menu() {
		// require_once SSP_PATH.'inc/page_ogp.php';
		require_once SSP_PATH . 'inc/page_help.php';
	}


	/**
	 * 設定保存時のメッセージ
	 */
	public static function output_saved_message() {
		?>
			<div class="ssp-page__savedMessage updated notice is-dismissible">
				<p>
					<strong><?php esc_html_e( 'Your settings have been saved.', 'loos-ssp' ); ?></strong>
				</p>
				<button type="button" class="notice-dismiss">
					<span class="screen-reader-text"><?php esc_html_e( 'Hide this notification.', 'loos-ssp' ); ?></span>
				</button>
			</div>
		<?php
	}


	/**
	 *  設定タブの出力
	 */
	public static function output_setting_tab( $tabs ) {
		foreach ( $tabs as $key => $label ) {
			$nav_class = ( reset( $tabs ) === $label ) ? 'nav-tab act_' : 'nav-tab';
			echo '<a href="#' . esc_attr( $key ) . '" class="' . esc_attr( $nav_class ) . '">' . esc_html( $label ) . '</a>';
		}
	}


	/**
	 *  設定タブコンテンツの出力
	 */
	public static function output_setting_tab_content( $tabs, $page_type ) {
		foreach ( $tabs as $key => $label ) {

			$tab_class = ( reset( $tabs ) === $label ) ? 'tab-contents act_' : 'tab-contents';
			echo '<div id="' . esc_attr( $key ) . '" class="' . esc_attr( $tab_class ) . '">';

			// タブコンテンツ用ファイルの読み込み
			if ( file_exists( SSP_PATH . 'inc/tab/' . $page_type . '_' . $key . '.php' ) ) {
				require_once SSP_PATH . 'inc/tab/' . $page_type . '_' . $key . '.php';
			}

			echo '</div>';
		}
	}

}
