<?php
class SSP_MetaBox {

	use SSP\Field;

	/**
	 * 外部からのインスタンス化を防ぐ
	 */
	private function __construct() {}

	/**
	 * Post meta
	 */
	const POST_META_KEYS = [
		'robots'      => 'ssp_meta_robots',
		'title'       => 'ssp_meta_title',
		'description' => 'ssp_meta_description',
		'keyword'     => 'ssp_meta_keyword',
		'canonical'   => 'ssp_meta_canonical',
		'image'       => 'ssp_meta_image',
	];

	/**
	 * Term meta
	 */
	const TERM_META_KEYS = [
		'robots'      => 'ssp_meta_robots',
		'title'       => 'ssp_meta_title',
		'description' => 'ssp_meta_description',
		'canonical'   => 'ssp_meta_canonical',
		'image'       => 'ssp_meta_image',
	];

	/**
	 * @var array Setting choices
	 */
	private static $robots_options = [];


	/**
	 * init
	 */
	public static function init() {

		// Set choices
		self::$robots_options = [
			''                 => __( 'Keep default settings', 'loos-ssp' ), // デフォルト設定のまま
			'index,follow'     => __( 'Index', 'loos-ssp' ), // インデックスさせる
			'noindex'          => __( 'Don\'t index', 'loos-ssp' ) . '(noindex)', // インデックスさせない
			'nofollow'         => __( 'Don\'t follow links', 'loos-ssp' ) . '(nofollow)', // リンクを辿らせない
			'noarchive'        => __( 'Don\'t cache', 'loos-ssp' ) . '(noarchive)', // キャッシュさせない
			'noindex,nofollow' => 'noindex,nofollow',
		];

		// post meta追加
		add_action( 'add_meta_boxes', [ 'SSP_MetaBox', 'add_ssp_metabox' ], 1 );
		add_action( 'save_post', [ 'SSP_MetaBox', 'save_post_metas' ] );

		// term meta追加 -> init:99 で $custom_taxonomies セットしているのでそれよりあとで実行
		add_action( 'wp_loaded', function() {
			$tax_names = array_merge( ['category', 'post_tag' ], array_keys( SSP_Data::$custom_taxonomies ) );
			foreach ( $tax_names as $tax_name ) {
				add_action( $tax_name . '_edit_form_fields', [ 'SSP_MetaBox', 'add_term_edit_fields' ], 20 );
				// add_action( $tax_name . '_add_form_fields', [ 'SSP_MetaBox', 'add_term_fields' ] );
			}

			// 保存処理フック
			add_action( 'edited_terms', [ 'SSP_MetaBox', 'save_term_metas' ] );
			// add_action( 'created_term', [ 'SSP_MetaBox', 'save_term_metas' ] );
		});

	}


	/**
	 * Add metabox.
	 */
	public static function add_ssp_metabox() {
		$args       = [
			'public'   => true,
			'_builtin' => false,
		];
		$post_types = get_post_types( $args, 'names', 'and' );
		$screens    = array_merge( ['post', 'page' ], $post_types );

		add_meta_box(
			'ssp_metabox',                            // メタボックスのID名(html)
			__( 'SEO SIMPLE PACK Settings', 'loos-ssp' ),  // メタボックスのタイトル
			['SSP_MetaBox', 'ssp_metabox_callback' ], // htmlを出力する関数名
			$screens,                                 // 表示する投稿タイプ
			'normal',                                 // 表示場所 : 'normal', 'advanced', 'side'
			'default',                                // 表示優先度 : 'high', 'core', 'default' または 'low'
			null                                      // $callback_args
		);
	}


	/**
	 * Metabox cintents.
	 * memo: privateにするとエラーが起きる
	 */
	public static function ssp_metabox_callback( $post ) {

		$val_robots      = get_post_meta( $post->ID, self::POST_META_KEYS['robots'], true );
		$val_title       = get_post_meta( $post->ID, self::POST_META_KEYS['title'], true );
		$val_description = get_post_meta( $post->ID, self::POST_META_KEYS['description'], true );
		$val_keyword     = get_post_meta( $post->ID, self::POST_META_KEYS['keyword'], true );
		$val_canonical   = get_post_meta( $post->ID, self::POST_META_KEYS['canonical'], true );
		$val_image       = get_post_meta( $post->ID, self::POST_META_KEYS['image'], true );

		// 更新に伴う調節
		if ( 'noindex,follow' === $val_robots ) {
			update_post_meta( $post->ID, self::POST_META_KEYS['robots'], 'noindex' );
			$val_robots = 'noindex';
		} elseif ( 'index,nofollow' === $val_robots ) {
			update_post_meta( $post->ID, self::POST_META_KEYS['robots'], 'nofollow' );
			$val_robots = 'nofollow';
		}

		$ssp_page_url    = admin_url( 'admin.php?page=ssp_main_setting' );
		$ssp_page_url_pt = admin_url( 'admin.php?page=ssp_main_setting#post_type' );
		$help_page_url   = admin_url( 'admin.php?page=ssp_help' );
	?>
		<div class="ssp_metabox -post">
		<?php
			// robots
			self::output_field( self::POST_META_KEYS['robots'], [
				'title'       => __( '"robots" tag of this page', 'loos-ssp' ),
				'type'        => 'select',
				'choices'     => self::$robots_options,
				'desc'        => sprintf(
					__( 'If you want to know the default settings, see %s.', 'loos-ssp' ),
					'<a href="' . esc_url( $ssp_page_url_pt ) . '" target="_blank">' . __( '"Post page" tab in "General Settings"', 'loos-ssp' ) . '</a>'
				),
			], $val_robots );

			// title
			self::output_field( self::POST_META_KEYS['title'], [
				'title'       => __( 'Title tag of this page', 'loos-ssp' ),
				'desc'        => sprintf(
					__( '%s is available.', 'loos-ssp' ),
					'<a href="' . esc_url( $help_page_url ) . '" target="_blank">' . __( 'Snippet tags', 'loos-ssp' ) . '</a>'
				),
			], $val_title );

			// description
			self::output_field( self::POST_META_KEYS['description'], [
				'title'       => __( 'Description of this page', 'loos-ssp' ),
				'type'        => 'textarea',
				'desc'        => __( 'If blank, the description tag will be automatically generated from the content.', 'loos-ssp' ),
			], $val_description );

			// og:image
			self::output_field( self::POST_META_KEYS['image'], [
				'title'       => __( '"og:image" of this page', 'loos-ssp' ),
				'type'        => 'media',
			], $val_image );

			// canonical
			self::output_field( self::POST_META_KEYS['canonical'], [
				'title'       => __( '"canonical" URL of this page', 'loos-ssp' ),
				'desc'        => __( 'If blank, the canonical tag will be automatically generated.', 'loos-ssp' ),
			], $val_canonical );

			// keywords
			self::output_field( self::POST_META_KEYS['keyword'], [
				'title'       => __( 'Keywords of this page', 'loos-ssp' ),
				// 'desc'        => sprintf(
				// 	__( 'If blank, the "Keyword" setting of %s is used.', 'loos-ssp' ),
				// 	'<a href="' . esc_url( $ssp_page_url ) . '" target="_blank">' . __( '"Basic settings"', 'loos-ssp' ) . '</a>'
				// ),
			], $val_keyword );
		?>
		</div>
	<?php
		// Set nonce field
		wp_nonce_field( SSP_Data::NONCE_ACTION, SSP_Data::NONCE_NAME );
	}


	/**
	 * Save post meta
	 */
	public static function save_post_metas( $post_id ) {

		// 新規投稿ページでも発動するので、$_POSTが空なら return
		if ( empty( $_POST ) ) return;

		// 自動保存時
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		// nonceキー存在チェック
		if ( ! isset( $_POST[ SSP_Data::NONCE_NAME ] ) ) return;

		// nonceの検証
		$nonce_name = $_POST[ SSP_Data::NONCE_NAME ]; // phpcs:ignore
		if ( ! wp_verify_nonce( $nonce_name, SSP_Data::NONCE_ACTION ) ) return;

		foreach ( self::POST_META_KEYS as $key => $meta_key ) {

			// 保存したい情報が渡ってきているか確認
			if ( ! isset( $_POST[ $meta_key ] ) ) continue;

			// 入力された値をサニタイズ
			$meta_val = sanitize_text_field( wp_unslash( $_POST[ $meta_key ] ) );

			if ( empty( $meta_val ) ) {
				// 初期値の場合は保存しない。また、空に戻された時には削除する。
				delete_post_meta( $post_id, $meta_key );
			} else {
				// 値を保存
				update_post_meta( $post_id, $meta_key, $meta_val );
			}
		}

	}


	/**
	 * ターム「編集」画面にフィールド追加
	 */
	public static function add_term_edit_fields( $term ) {
		$val_robots      = get_term_meta( $term->term_id, self::TERM_META_KEYS['robots'], true );
		$val_title       = get_term_meta( $term->term_id, self::TERM_META_KEYS['title'], true );
		$val_description = get_term_meta( $term->term_id, self::TERM_META_KEYS['description'], true );
		$val_canonical   = get_term_meta( $term->term_id, self::TERM_META_KEYS['canonical'], true );
		$val_image       = get_term_meta( $term->term_id, self::TERM_META_KEYS['image'], true );

		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
	?>
		<tr class="ssp_term_meta_title">
			<td colspan="2">
				<h2><?=esc_html__( 'SEO SIMPLE PACK Settings', 'loos-ssp' )?></h2>
			</td>
		</tr>
		<tr class="form-field">
			<th>
				<label for="<?=self::TERM_META_KEYS['robots']?>">
					<?=esc_html__( '"robots" tag of this page', 'loos-ssp' )?>
				</label>
			</th>
			<td>
				<?php self::select_box( self::TERM_META_KEYS['robots'], $val_robots, self::$robots_options ); ?>
			</td>
		</tr>
		<tr class="form-field">
			<th>
				<label for="<?=self::TERM_META_KEYS['title']?>">
					<?=esc_html__( 'Title tag of this page', 'loos-ssp' )?>
				</label>
			</th>
			<td>
				<?php self::text_input( self::TERM_META_KEYS['title'], $val_title ); ?>
			</td>
		</tr>
		<tr class="form-field">
			<th>
				<label for="<?=self::TERM_META_KEYS['description']?>">
					<?=esc_html__( 'Description of this page', 'loos-ssp' )?>
				</label>
			</th>
			<td>
				<?php self::textarea( self::TERM_META_KEYS['description'], $val_description ); ?>
			</td>
		</tr>
		<tr class="form-field">
			<th>
				<label for="<?=self::TERM_META_KEYS['canonical']?>">
					<?=esc_html__( '"canonical" URL of this page', 'loos-ssp' )?>
				</label>
			</th>
			<td>
				<?php self::text_input( self::TERM_META_KEYS['canonical'], $val_canonical ); ?>
			</td>
		</tr>
		<tr class="form-field">
			<th>
				<label for="<?=self::TERM_META_KEYS['image']?>">
					<?=esc_html__( '"og:image" of this page', 'loos-ssp' )?>
				</label>
			</th>
			<td>
				<?php self::media_btns( self::TERM_META_KEYS['image'], $val_image ); ?>
			</td>
		</tr>
	<?php
		// phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped

		// Set nonce field
		wp_nonce_field( SSP_Data::NONCE_ACTION, SSP_Data::NONCE_NAME );
	}


	/**
	 * Save term meta
	 */
	public static function save_term_metas( $term_id ) {

		// $_POSTが空なら return
		if ( empty( $_POST ) ) return;

		// nonceキー存在チェック
		if ( ! isset( $_POST[ SSP_Data::NONCE_NAME ] ) ) return;

		// nonceの検証
		$nonce_name = $_POST[ SSP_Data::NONCE_NAME ]; // phpcs:ignore
		if ( ! wp_verify_nonce( $nonce_name, SSP_Data::NONCE_ACTION ) ) return;

		foreach ( self::TERM_META_KEYS as $key => $meta_key ) {

			// 保存したい情報が渡ってきているか確認
			if ( ! isset( $_POST[ $meta_key ] ) ) continue;

			// 入力された値をサニタイズ
			$meta_val = sanitize_text_field( wp_unslash( $_POST[ $meta_key ] ) );

			if ( empty( $meta_val ) ) {
				// 初期値の場合は保存しない。また、空に戻された時には削除する。
				delete_term_meta( $term_id, $meta_key );
			} else {
				// 値を保存
				update_term_meta( $term_id, $meta_key, $meta_val );
			}
		}
	}
}
