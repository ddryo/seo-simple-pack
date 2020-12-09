<?php
class SSP_Branch {

	/**
	 * 外部からのインスタンス化を防ぐ
	 */
	private function __construct() {}

	/**
	 * 条件分岐タグの結果を取得
	 * Conditional_Tags
	 */
	public static $is_ = null;


	/**
	 * init
	 */
	public static function init() {
		add_action( 'wp', [ 'SSP_Branch', 'set_branch' ], 1 );
	}


	/**
	 * 条件分岐タグの結果を変数に代入
	 */
	public static function set_branch() {

			self::$is_ = [
				'home'       => is_home(),
				'front'      => is_front_page(),
				'single'     => is_single(),
				'page'       => is_page(),
				'singular'   => is_singular(),
				'category'   => is_category(),
				'tag'        => is_tag(),
				'tax'        => is_tax(),
				'attachment' => is_attachment(),
				'archive'    => is_archive(),
				'pt_archive' => is_post_type_archive(),
				'author'     => is_author(),
				'date'       => is_date(),
				'year'       => is_year(),
				'month'      => is_month(),
				'day'        => is_day(),
				'search'     => is_search(),
				'404'        => is_404(),
			];
			if ( is_front_page() ) {
				self::$is_['top'] = true;
			} elseif ( is_home() ) {
				if ( get_queried_object_id() === 0 ) {
					self::$is_['top'] = true;
				} else {
					self::$is_['top'] = false;
				}
			} else {
				self::$is_['top'] = false;
			}
	}
}
