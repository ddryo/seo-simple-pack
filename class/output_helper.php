<?php
/**
 * SSP_Output用のヘルパークラス
 */
namespace LOOS\SSP;

// phpcs:disable WordPress.WP.EnqueuedResources.NonEnqueuedScript
class Output_Helper {

	/**
	 * page を自動付与
	 */
	public static function add_page_num_to_title( $str, $sep ) {
		$paged = self::get_paged_text() ?: '';
		if ( ! $paged ) return $str;

		if ( strpos( $str, '%_site_title_%' ) ) {
			// サイトタイトルが先頭以外の場所にある時の前にページ数を表示
			return str_replace( '%_site_title_%', "$paged $sep %_site_title_%", $str );
		} else {
			// サイトタイトルがなければ最後に追加
			return $str . " $sep $paged";
		}
	}

	/**
	 * get_paged_text
	 */
	public static function get_paged_text() {

		$nums = self::get_pagenumbers();
		if ( ! $nums ) {
			return '';
		}

		/* translators: 1: current page number, 2: total number of pages. */
		return sprintf( __( 'Page %1$d of %2$d', 'loos-ssp' ), $nums['now'], $nums['max'] );
	}

	private static function get_pagenumbers() {
		global $wp_query;
		$max_num_pages = 1;
		$now_page_num  = 1;

		// アーカイブにしか効かない
		// $is_paged = $wp_query->is_paged();
		// if ( ! $is_paged ) return false;

		// 現在のページ番号
		$now_page_num = is_singular() ? get_query_var( 'page' ) : get_query_var( 'paged' );
		if ( 0 === $now_page_num || '' === $now_page_num ) {
			$now_page_num = 1;
		}

		// 1ページ目の時
		if ( $now_page_num < 2 ) {
			return false;
		}

		global $post;

		// 最大のページ番号
		if ( is_singular() && isset( $post->post_content ) ) {
			// 改ページタグをカウント
			$max_num_pages = ( substr_count( $post->post_content, '<!--nextpage-->' ) + 1 );
		} elseif ( ! is_singular() && ! empty( $wp_query->max_num_pages ) ) {
			$max_num_pages = $wp_query->max_num_pages;
		}

		return [
			'now' => $now_page_num,
			'max' => $max_num_pages,
		];
	}

}
