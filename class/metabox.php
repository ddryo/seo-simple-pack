<?php
class SSP_MetaBox {

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
	];

	/**
	 * Term meta
	 */
	const TERM_META_KEYS = [
		'robots'      => 'ssp_meta_robots',
		'title'       => 'ssp_meta_title',
		'description' => 'ssp_meta_description',
	];

	/**
	 * init
	 */
	public static function init() {
		// post meta
		add_action( 'add_meta_boxes', [ 'SSP_MetaBox', 'ssp_add_metabox' ], 1 );
		add_action( 'save_post', [ 'SSP_MetaBox', 'save_ssp_metabox' ] );

		// term meta
		// add_action('category_add_form_fields', [ 'SSP_MetaBox', 'ssp_add_term_fields' ]);
		// add_action('post_tag_add_form_fields', [ 'SSP_MetaBox', 'ssp_add_term_fields' ]);
		add_action( 'category_edit_form_fields', [ 'SSP_MetaBox', 'ssp_add_term_edit_fields' ], 20 );
		add_action( 'post_tag_edit_form_fields', [ 'SSP_MetaBox', 'ssp_add_term_edit_fields' ], 20 );
		add_action( 'created_term', [ 'SSP_MetaBox', 'ssp_save_term_filds' ] );  // 新規追加用 保存処理フック
		add_action( 'edited_terms', [ 'SSP_MetaBox', 'ssp_save_term_filds' ] );   // 編集ページ用 保存処理フック
	}


	/**
	 * Add metabox.
	 */
	public static function ssp_add_metabox() {
		$args       = [
			'public'   => true,
			'_builtin' => false,
		];
		$post_types = get_post_types( $args, 'names', 'and' );
		$screens    = array_merge( ['post', 'page' ], $post_types );

		add_meta_box(
			'ssp_metabox',                           // メタボックスのID名(html)
			'SEO SIMPLE PACK 設定',                                // メタボックスのタイトル
			['SSP_MetaBox', 'ssp_metabox_callback' ], // htmlを出力する関数名
			$screens,                                // 表示する投稿タイプ
			'advanced',                              // 表示場所 : 'normal', 'advanced', 'side'
			'high',                                  // 表示優先度 : 'high', 'core', 'default' または 'low'
			null                                     // $callback_args
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

		// 更新に伴う調節
		if ( $val_robots === 'noindex,follow' ) {
			update_post_meta( $post->ID, self::POST_META_KEYS['robots'], 'noindex' );
			$val_robots = 'noindex';
		} elseif ( $val_robots === 'index,nofollow' ) {
			update_post_meta( $post->ID, self::POST_META_KEYS['robots'], 'nofollow' );
			$val_robots = 'nofollow';
		}

		$robots_arr = [
			'インデックスさせる'             => 'index,follow',
			'インデックスさせない (noindex)'  => 'noindex',
			'リンクを辿らせない (nofollow)'  => 'nofollow',
			'キャッシュさせない (noarchive)' => 'noarchive',
			'noindex,nofollow'      => 'noindex,nofollow',
		];
?>
		<div id="ssp_wrap" class="ssp_metabox">

			<label for="<?=self::POST_META_KEYS['robots']?>">このページの robotsタグ (インデックスさせるかどうか)</label>
			<div class="ssp_meta_inner">
				<select name="<?=self::POST_META_KEYS['robots']?>" id="<?=self::POST_META_KEYS['robots']?>">
					<option value="">-- デフォルト設定のまま --</option>
					<?php
					foreach ( $robots_arr as $key => $value ) {
							if ( $value === $val_robots ) {
							echo '<option value="', $value ,'" selected>', $key ,'</option>';
							} else {
							echo '<option value="', $value ,'">', $key ,'</option>';
							}
						}
						?>
				</select>
				<p class="ssp_note">
					<i>
					例：「サイトマップ」など、インデックスさせたくない特別なページには「インデックスさせない(noindex)」を設定してください。
					<br>
					投稿ページの デフォルト設定 は <a href="<?=admin_url( 'admin.php?page=ssp_main_setting' )?>" target="_blank">「SEO PACK」の「一般設定」</a>から<a href="<?=admin_url( 'admin.php?page=ssp_main_setting#post_type' )?>" target="_blank">「投稿ページ」タブ</a> をご確認ください。
					</i>
				</p>
			</div>
			

			<label for="<?=self::POST_META_KEYS['title']?>">このページのタイトルタグを上書きする</label>
			<div class="ssp_meta_inner">
				<input type="text" id="<?=self::POST_META_KEYS['title']?>" name="<?=self::POST_META_KEYS['title']?>" value="<?=esc_html( $val_title )?>">
				<p class="ssp_note">
					<i><a href="<?=admin_url( 'admin.php?page=ssp_help' )?>" target="_blank">スニペットタグ</a> ( <code>%_site_title_%</code>など )が使用可能です。空白の場合、デフォルトの形式で出力されます。</i>
				</p>
			</div>

			<label for="<?=self::POST_META_KEYS['description']?>">このページのディスクリプション</label>
			<div class="ssp_meta_inner">
				<textarea id="<?=self::POST_META_KEYS['description']?>" name="<?=self::POST_META_KEYS['description']?>"><?=esc_html( $val_description )?></textarea>
				<p class="ssp_note">
					<i>空白の場合、コンテンツから自動でディスクリプションタグが生成されます。</i>
				</p>
			</div>

			<label for="<?=self::POST_META_KEYS['keyword']?>">このページのキーワード</label>
			<div class="ssp_meta_inner">
				<input type="text" id="<?=self::POST_META_KEYS['keyword']?>" name="<?=self::POST_META_KEYS['keyword']?>" value="<?=esc_html( $val_keyword )?>">
				<p class="ssp_note">
					<i>空白の場合、<a href="<?=admin_url( 'admin.php?page=ssp_main_setting' )?>" target="_blank">「SEO PACK」の「基本設定」</a>の「キーワード」設定が使用されます。</i>
				</p>
			</div>
		</div>
<?php
		// nonceフィールド追加
		wp_nonce_field( SSP_Data::NOUNCE_ACTION, SSP_Data::NOUNCE_NAME );
	}


	/**
	 * Save post meta
	 */
	public static function save_ssp_metabox( $post_id ) {

		/* デバッグ には exit() 使う */

		// var_dump( $_POST );
		// exit();

		// 新規投稿ページでも発動するので、$_POSTが空なら return させる
		if ( empty( $_POST ) ) {
			return;
		}

		// SSPのnonceキーチェック
		if ( ! isset( $_POST[ SSP_Data::NOUNCE_NAME ] ) ) {
			return;
		}

		// Verify that the nonce is valid.  nonceが正しいものか検証
		if ( ! wp_verify_nonce( $_POST[ SSP_Data::NOUNCE_NAME ], SSP_Data::NOUNCE_ACTION ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		// :: 自動保存時にはメタボックスの内容を保存しないように、ここで処理を終える
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		// :: 現在のユーザーに投稿の編集権限があるかのチェック
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
					}
		}

		/*
			OK, it's safe for us to save the data now.
			ここまでくれば大丈夫です。保存処理を開始します。
		*/

		// Make sure that it is set.
		// 保存したい情報が渡ってきているか確認
		if ( ! isset( $_POST[ self::POST_META_KEYS['robots'] ] ) ||
			! isset( $_POST[ self::POST_META_KEYS['title'] ] ) ||
			! isset( $_POST[ self::POST_META_KEYS['description'] ] ) ||
			! isset( $_POST[ self::POST_META_KEYS['keyword'] ] ) ) {
			return;
		}

		// Sanitize user input.
		// 入力された値をサニタイズ
		$meta_robots      = sanitize_text_field( $_POST[ self::POST_META_KEYS['robots'] ] );
		$meta_title       = sanitize_text_field( $_POST[ self::POST_META_KEYS['title'] ] );
		$meta_description = sanitize_text_field( $_POST[ self::POST_META_KEYS['description'] ] );
		$meta_keyword     = sanitize_text_field( $_POST[ self::POST_META_KEYS['keyword'] ] );

		// Update the meta field in the database.
		// データベースのポストメタに値を保存
		update_post_meta( $post_id, self::POST_META_KEYS['robots'], $meta_robots );
		update_post_meta( $post_id, self::POST_META_KEYS['title'], $meta_title );
		update_post_meta( $post_id, self::POST_META_KEYS['description'], $meta_description );
		update_post_meta( $post_id, self::POST_META_KEYS['keyword'], $meta_keyword );
	}


	/**
	 * ターム「新規追加」画面にフィールド追加
	 */
	public static function ssp_add_term_fields() {
		$robots_arr = [
			'インデックスさせる'             => 'index,follow',
			'インデックスさせない (noindex)'  => 'noindex',
			'リンクを辿らせない (nofollow)'  => 'nofollow',
			'キャッシュさせない (noarchive)' => 'noarchive',
			'noindex,nofollow'      => 'noindex,nofollow',
		];
		?>
		<div class="form-field">
		<label for="<?=self::TERM_META_KEYS['robots']?>">【SSP】このタームアーカイブページの robotsタグ設定</label>
			<select name="<?=self::TERM_META_KEYS['robots']?>" id="<?=self::TERM_META_KEYS['robots']?>">
				<option value="">-- デフォルト設定のまま --</option>
				<?php
				foreach ( $robots_arr as $key => $value ) {
						if ( $value === $val_robots ) {
						echo '<option value="', $value ,'" selected>', $key ,'</option>';
						} else {
						echo '<option value="', $value ,'">', $key ,'</option>';
						}
					}
					?>
			</select>
		</div>
		<div class="form-field">
			<label for="<?=self::TERM_META_KEYS['title']?>">【SSP】このタームアーカイブページの titleタグ</label>
			<input type="text" name="<?=self::TERM_META_KEYS['title']?>" id="<?=self::TERM_META_KEYS['title']?>">
		</div>
		<div class="form-field">
			<label for="<?=self::TERM_META_KEYS['description']?>">【SSP】このタームアーカイブページの descriptionタグ</label>
			<textarea name="<?=self::TERM_META_KEYS['description']?>" id="<?=self::TERM_META_KEYS['description']?>" cols="40" rows="5"></textarea>
		</div>
	<?php
	}

	/**
	 * ターム「編集」画面にフィールド追加
	 */
	public static function ssp_add_term_edit_fields( $term ) {
		$robots_arr      = [
			'インデックスさせる'             => 'index,follow',
			'インデックスさせない (noindex)'  => 'noindex',
			'リンクを辿らせない (nofollow)'  => 'nofollow',
			'キャッシュさせない (noarchive)' => 'noarchive',
			'noindex,nofollow'      => 'noindex,nofollow',
		];
		$val_robots      = get_term_meta( $term->term_id, self::TERM_META_KEYS['robots'], true );
		$val_title       = get_term_meta( $term->term_id, self::TERM_META_KEYS['title'], true );
		$val_description = get_term_meta( $term->term_id, self::TERM_META_KEYS['description'], true );
		?>
		<tr class="ssp_term_meta_title">
			<td colspan="2">
				<h2>SEO SIMPLE PACKの設定</h2>
			</td>
		</tr>
		<tr class="form-field">
			<th>
				<label for="<?=self::TERM_META_KEYS['robots']?>">このタームアーカイブページの robotsタグ</label>
			</th>
			<td>
				<select name="<?=self::TERM_META_KEYS['robots']?>" id="<?=self::TERM_META_KEYS['robots']?>">
					<option value="">-- デフォルト設定のまま --</option>
					<?php
					foreach ( $robots_arr as $key => $value ) {
							if ( $value === $val_robots ) {
							echo '<option value="', $value ,'" selected>', $key ,'</option>';
							} else {
							echo '<option value="', $value ,'">', $key ,'</option>';
							}
						}
						?>
				</select>
			</td>
		</tr>
		<tr class="form-field">
			<th>
				<label for="<?=self::TERM_META_KEYS['title']?>">このタームアーカイブページの titleタグ</label>
			</th>
			<td>
				<input type="text" name="<?=self::TERM_META_KEYS['title']?>" id="<?=self::TERM_META_KEYS['title']?>" value="<?=$val_title?>">
			</td>
		</tr>
		<tr class="form-field">
			<th>
				<label for="<?=self::TERM_META_KEYS['description']?>">このタームアーカイブページの descriptionタグ</label>
			</th>
			<td>
				<textarea name="<?=self::TERM_META_KEYS['description']?>" id="<?=self::TERM_META_KEYS['description']?>" cols="40" rows="5"><?=$val_description?></textarea>
			</td>
		</tr>
	<?php
	}


	/**
	 * Save term meta
	 */
	public static function ssp_save_term_filds( $term_id ) {
		foreach ( self::TERM_META_KEYS as $label => $keyname ) {
			if ( isset( $_POST[ $keyname ] ) ) {
				update_term_meta( $term_id, $keyname, $_POST[ $keyname ] );
			}
		}
	}
}
