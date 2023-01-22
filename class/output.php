<?php

use \LOOS\SSP\Output_Helper;

class SSP_Output {

	/**
	 * 外部からのインスタンス化を防ぐ
	 */
	private function __construct() {}

	/**
	 * @var object The current query object.
	 */
	private static $obj;

	/**
	 * @var object The type of current query object.
	 */
	private static $obj_type;

	/**
	 * @var string The meta data holders.
	 */
	private static $title;
	private static $description;
	private static $robots;
	private static $keyword;
	private static $canonical;

	/**
	 * @var string The ogp data holders.
	 */
	private static $og_tags;
	private static $og_locale;
	private static $og_type;
	private static $og_image;
	private static $og_title;
	private static $og_desc;
	private static $og_url;
	private static $og_site_name;

	/**
	 * @var string The ogp data holders for facebook.
	 */
	private static $fb_app_id;
	private static $fb_admins;
	private static $fb_url;

	/**
	 * @var string The ogp data holders for twitter.
	 */
	private static $tw_card;
	private static $tw_site;


	/**
	 * init
	 */
	public static function init() {
		add_action( 'wp_head', [ 'SSP_Output', 'main' ], 5 );
	}


	/**
	 * get method
	 */
	public static function get_meta_data( $key = '' ) {
		if ( '' !== $key ) {
			return self::$$key;
		} else {
			return false;
		}
	}


	/**
	 * $obj がどのクラスのオブジェクトかをチェック
	 */
	public static function get_obj_type( $obj ) {
		if ( ! $obj || ! is_object( $obj ) ) return;

		return get_class( $obj );
	}


	/**
	 * トップページのデータだけを取得する
	 *   （テーマや外部プラグインから構造化データ生成に使用できるようにするためのもの）
	 */
	public static function get_front_data( $target ) {
		$settings = SSP_Data::$settings;
		$return   = '';
		if ( 'title' === $target ) {
			$title  = $settings['home_title'];
			$return = wp_strip_all_tags( $title );
		} elseif ( 'description' === $target ) {
			$return = $settings['home_desc'];
		}
		return self::replace_snippets( $return, $target );
	}


	/**
	 * Genarate and output meta tags for current page.
	 */
	public static function main() {
		self::$obj      = get_queried_object();
		self::$obj_type = self::get_obj_type( self::$obj );

		// Genarate
		self::generate_meta_tags();
		self::generate_ogp_tags();

		// Output
		echo PHP_EOL . '<!-- SEO SIMPLE PACK ' . SSP_VERSION . ' -->' . PHP_EOL; // phpcs:ignore
		self::output_meta_tags();
		self::output_ogp_tags();
		self::output_codes();
		echo '<!-- / SEO SIMPLE PACK -->' . PHP_EOL . PHP_EOL;
	}


	/**
	 * Generate meta tags
	 */
	private static function generate_meta_tags() {
		self::$title       = self::generate_title();
		self::$robots      = self::generate_robots();
		self::$keyword     = self::generate_keyword();
		self::$description = self::generate_description();
		self::$canonical   = self::generate_canonical();
	}


	/**
	 * Generate ogp tags
	 */
	private static function generate_ogp_tags() {
		// Reuse meta tags
		self::$og_title     = apply_filters( 'ssp_output_og_title', self::$title );
		self::$og_desc      = apply_filters( 'ssp_output_og_description', self::$description );
		self::$og_url       = apply_filters( 'ssp_output_og_url', self::$canonical );
		self::$og_site_name = apply_filters( 'ssp_output_og_site_name', SSP_Data::$site_title );

		// Generate other ogp tags
		self::$og_locale = apply_filters( 'ssp_output_og_locale', Output_Helper::get_valid_og_locale() );
		self::$og_type   = self::generate_og_type();
		self::$og_image  = apply_filters( 'ssp_output_og_image', self::generate_og_image() );

		// Generate SNS ogp tags
		if ( SSP_Data::$ogp['fb_active'] ) {
			self::$fb_app_id = apply_filters( 'ssp_output_fb_appid', SSP_Data::$ogp['fb_app_id'] );
			self::$fb_admins = apply_filters( 'ssp_output_fb_admins', SSP_Data::$ogp['fb_admins'] );
			self::$fb_url    = apply_filters( 'ssp_output_fb_publisher', SSP_Data::$ogp['fb_url'] );
		}
		if ( SSP_Data::$ogp['tw_active'] ) {
			self::$tw_card = apply_filters( 'ssp_output_tw_card', SSP_Data::$ogp['tw_card'] );
			self::$tw_site = apply_filters( 'ssp_output_tw_site', SSP_Data::$ogp['tw_account'] );
		}
	}


	/**
	 * Output meta tags
	 */
	private static function output_meta_tags() {

		if ( ! empty( self::$title ) ) {
			echo '<title>' . esc_html( self::$title ) . '</title>' . PHP_EOL;
		}

		if ( ! empty( self::$robots ) ) {
			echo '<meta name="robots" content="' . esc_attr( self::$robots ) . '">' . PHP_EOL;
		}

		if ( ! empty( self::$description ) ) {
			echo '<meta name="description" content="' . esc_attr( self::$description ) . '">' . PHP_EOL;
		}

		if ( ! empty( self::$keyword ) ) {
			echo '<meta name="keywords" content="' . esc_attr( self::$keyword ) . '">' . PHP_EOL;
		}

		if ( ! empty( self::$canonical ) ) {
			echo '<link rel="canonical" href="' . esc_attr( self::$canonical ) . '">' . PHP_EOL;
		}
	}


	/**
	 * Output ogp tags
	 */
	private static function output_ogp_tags() {

		if ( self::$og_locale ) {
			echo '<meta property="og:locale" content="' . esc_attr( self::$og_locale ) . '">' . PHP_EOL;
		}
		if ( self::$og_type ) {
			echo '<meta property="og:type" content="' . esc_attr( self::$og_type ) . '">' . PHP_EOL;
		}
		if ( self::$og_image ) {
			echo '<meta property="og:image" content="' . esc_url( self::$og_image ) . '">' . PHP_EOL;
		}
		if ( self::$og_title ) {
			echo '<meta property="og:title" content="' . esc_attr( self::$og_title ) . '">' . PHP_EOL;
		}
		if ( self::$og_desc ) {
			echo '<meta property="og:description" content="' . esc_attr( self::$og_desc ) . '">' . PHP_EOL;
		}
		if ( self::$og_url ) {
			echo '<meta property="og:url" content="' . esc_attr( self::$og_url ) . '">' . PHP_EOL;
		}
		if ( self::$og_site_name ) {
			echo '<meta property="og:site_name" content="' . esc_attr( self::$og_site_name ) . '">' . PHP_EOL;
		}

		// for Facebook
		if ( self::$fb_app_id ) {
			echo '<meta property="fb:app_id" content="' . esc_attr( self::$fb_app_id ) . '">' . PHP_EOL;
		}
		if ( self::$fb_admins ) {
			echo '<meta property="fb:admins" content="' . esc_attr( self::$fb_admins ) . '">' . PHP_EOL;
		}
		if ( self::$fb_url && 'article' === self::$og_type ) {
			echo '<meta property="article:publisher" content="' . esc_attr( self::$fb_url ) . '">' . PHP_EOL;
		}

		// for Twitter
		if ( self::$tw_card ) {
			echo '<meta name="twitter:card" content="' . esc_attr( self::$tw_card ) . '">' . PHP_EOL;
		}
		if ( self::$tw_site ) {
			echo '<meta name="twitter:site" content="' . esc_attr( self::$tw_site ) . '">' . PHP_EOL;
		}
	}


	/**
	 * Generate the title tag for the current page.
	 *
	 * @return string : The title.
	 */
	private static function generate_title() {

		$settings = SSP_Data::$settings;

		// default
		$title = SSP_Data::$site_title;

		switch ( true ) {

			case is_front_page():
			case is_home() && null === self::$obj: // 「投稿ページ」しか設定されていないときのトップ
				$title = $settings['home_title'];
				break;

			case is_singular():
			case is_home():
				if ( ! isset( self::$obj->ID ) ) break;

				$meta_title = get_post_meta( self::$obj->ID, SSP_MetaBox::POST_META_KEYS['title'], true );
				if ( $meta_title ) {
					$title = $meta_title;
				} else {
					$pt    = isset( self::$obj->post_type ) ? self::$obj->post_type : '';
					$title = isset( $settings[ $pt . '_title' ] ) ? $settings[ $pt . '_title' ] : '';
				}
				break;

			case is_search():
				$title = $settings['search_title'];
				break;

			case is_post_type_archive():
				$title = $settings['pt_archive_title'];
				break;

			case is_category():
				if ( ! isset( self::$obj->term_id ) ) break;

				$meta_title = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['title'], true );
				$title      = $meta_title ?: $settings['cat_title'];
				break;

			case is_tag():
				if ( ! isset( self::$obj->term_id ) ) break;

				$meta_title = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['title'], true );
				$title      = $meta_title ?: $settings['tag_title'];
				break;

			case is_tax():
				if ( ! isset( self::$obj->term_id ) ) break;

				$meta_title = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['title'], true );
				$term       = self::$obj->taxonomy;
				$title      = $meta_title ?: $settings[ $term . '_title' ];
				break;

			case is_author():
				$title = $settings['author_title'];
				break;

			case is_date():
				$title = $settings['date_title'];
				break;

			case is_404():
				$title = $settings['404_title'];
				break;

			default:
				break;
		}

		$title = wp_strip_all_tags( self::replace_snippets( $title, 'title' ) );
		return apply_filters( 'ssp_output_title', $title );
	}

	/**
	 * Generate the meta:robots for the current page.
	 *
	 * @return string : The meta:robots.
	 */
	private static function generate_robots() {
		$settings = SSP_Data::$settings;

		// default
		$robots = '';
		switch ( true ) {

			case is_front_page():
			case is_home() && null === self::$obj: // 「投稿ページ」しか設定されていないときのトップ
				// ?cat=ネガティブid のページかどうか調べる
				$cat_query = (int) get_query_var( 'cat', 0 );
				if ( is_numeric( $cat_query ) && 0 > $cat_query ) {
					$robots = 'noindex';
					break;
				}

				$robots = '';
				break;

			case is_singular():
			case is_home():
				if ( ! isset( self::$obj->ID ) ) break;

				$meta_robots = get_post_meta( self::$obj->ID, SSP_MetaBox::POST_META_KEYS['robots'], true );
				if ( $meta_robots ) {
					$robots = $meta_robots;
				} else {
					$pt         = isset( self::$obj->post_type ) ? self::$obj->post_type : '';
					$is_noindex = isset( $settings[ $pt . '_noindex' ] ) ? $settings[ $pt . '_noindex' ] : false;
					$robots     = $is_noindex ? 'noindex' : '';
				}
				break;

			case is_search():
				$robots = 'noindex';
				break;

			case is_post_type_archive():
				$is_noindex = $settings['pt_archive_noindex'];
				$robots     = $is_noindex ? 'noindex' : '';
				break;

			case is_category():
				if ( ! isset( self::$obj->term_id ) ) break;

				$meta_robots = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['robots'], true );
				if ( $meta_robots ) {
					$robots = $meta_robots;
				} else {
					$is_noindex = $settings['cat_noindex'];
					$robots     = $is_noindex ? 'noindex' : '';
				}

				break;

			case is_tag():
				if ( ! isset( self::$obj->term_id ) ) break;

				$meta_robots = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['robots'], true );
				if ( $meta_robots ) {
					$robots = $meta_robots;
				} else {
					$is_noindex = $settings['tag_noindex'];
					$robots     = $is_noindex ? 'noindex' : '';
				}
				break;

			case is_tax():
				if ( ! isset( self::$obj->term_id ) ) break;

				$meta_robots = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['robots'], true );
				if ( $meta_robots ) {
					$robots = $meta_robots;
				} else {
					if ( ! isset( self::$obj->taxonomy ) ) break;

					$term       = self::$obj->taxonomy;
					$is_noindex = $settings[ $term . '_noindex' ];
					$robots     = $is_noindex ? 'noindex' : '';
				}
				break;

			case is_author():
				$is_noindex = $settings['author_noindex'];
				$robots     = $is_noindex ? 'noindex' : '';
				break;

			case is_date():
				$is_noindex = $settings['date_noindex'];
				$robots     = $is_noindex ? 'noindex' : '';
				break;

			case is_404():
				$robots = 'noindex';
				break;

			default:
				break;
		}

		return apply_filters( 'ssp_output_robots', $robots );
	}

	/**
	 * Generate the meta:keywords for the current page.
	 *
	 * @return string : The meta:keywords.
	 */
	private static function generate_keyword() {

		// default
		$keyword = '';

		if ( is_front_page() ) {
			$keyword = SSP_Data::$settings['home_keyword'];
		} else {
			if ( 'WP_Post' === self::$obj_type && isset( self::$obj->ID ) ) {
				// メタボックスが入力されていれば上書きする
				$meta_keyword = get_post_meta( self::$obj->ID, SSP_MetaBox::POST_META_KEYS['keyword'], true );
				if ( $meta_keyword ) {
					$keyword = $meta_keyword;
				}
			}

			// キーワードが空の時、かつ、フロントと同じキーワードを出力する指定があれば
			if ( ! $keyword && SSP_Data::$settings['reuse_keyword'] ) {
				$keyword = SSP_Data::$settings['home_keyword'];
			}
		}

		return apply_filters( 'ssp_output_keyword', $keyword );
	}


	/**
	 * Generate the meta:description for the current page.
	 *
	 * @return string : The meta:description.
	 */
	private static function generate_description() {

		$settings = SSP_Data::$settings;

		// default
		$description = $settings['home_desc'];

		switch ( true ) {

			case is_front_page():
			case is_home() && null === self::$obj: // 「投稿ページ」しか設定されていないときのトップ
				$description = $settings['home_desc'] ?: '%_tagline_%';
				break;

			case is_singular():
			case is_home():
				if ( ! isset( self::$obj->ID ) ) break;

				$metabox_desc = get_post_meta( self::$obj->ID, SSP_MetaBox::POST_META_KEYS['description'], true );

				if ( '' !== $metabox_desc ) {
					// メタボックスが入力されていれば優先
					$description = $metabox_desc;
				} else {
					$pt          = isset( self::$obj->post_type ) ? self::$obj->post_type : '';
					$description = isset( $settings[ $pt . '_desc' ] ) ? $settings[ $pt . '_desc' ] : '';
				}
				break;

			case is_search():
				break;

			case is_post_type_archive():
				$description = $settings['pt_archive_desc'];
				break;

			case is_category():
				if ( ! isset( self::$obj->term_id ) ) break;

				$meta_description = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['description'], true );
				$description      = $meta_description ?: $settings['cat_desc'];
				break;

			case is_tag():
				if ( ! isset( self::$obj->term_id ) ) break;

				$meta_description = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['description'], true );
				$description      = $meta_description ?: $settings['tag_desc'];
				break;

			case is_tax():
				if ( ! isset( self::$obj->term_id ) ) break;

				$meta_description = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['description'], true );
				$description      = $meta_description ?: $settings[ self::$obj->taxonomy . '_desc' ];
				break;

			case is_author():
				$description = $settings['author_desc'];
				break;

			case is_date():
				$description = $settings['date_desc'];
				break;

			default:
				break;
		}

		$description = self::replace_snippets( $description, 'description' );
		return apply_filters( 'ssp_output_description', $description );

	}


	/**
	 * Generate the canonical URL for the current page.
	 *
	 * @return string : The canonical URL.
	 */
	private static function generate_canonical() {

		// default
		$canonical = '';

		switch ( true ) {

			case is_front_page():
			case is_home() && null === self::$obj: // 「投稿ページ」しか設定されていないときのトップ
				$canonical = home_url( '/' );
				break;

			case is_singular():
			case is_home():
				if ( ! isset( self::$obj->ID ) ) break;

				$meta_canonical = get_post_meta( self::$obj->ID, SSP_MetaBox::POST_META_KEYS['canonical'], true );
				$canonical      = $meta_canonical ?: get_permalink( self::$obj->ID );
				break;

			case is_search():
				$canonical = get_search_link();
				break;

			case is_post_type_archive():
				$post_type = get_query_var( 'post_type' );
				if ( $post_type ) {
					$post_type = ( is_array( $post_type ) ) ? reset( $post_type ) : $post_type;
					$canonical = get_post_type_archive_link( $post_type );
				}
				break;

			case is_tax() || is_tag() || is_category():
				$term = self::$obj;
				if ( ! isset( $term->term_id ) ) break;

				$meta_canonical = get_term_meta( $term->term_id, SSP_MetaBox::TERM_META_KEYS['canonical'], true );
				$canonical      = $meta_canonical ?: get_term_link( $term, $term->taxonomy );

				// get_term_link() がエラーだった場合
				if ( is_wp_error( $canonical ) ) {
					$canonical = '';
				}
				break;

			case is_author():
				$canonical = get_author_posts_url( get_query_var( 'author' ), get_query_var( 'author_name' ) );
				break;

			case is_date():
				if ( is_day() ) {
					$canonical = get_day_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) );
				} elseif ( is_month() ) {
					$canonical = get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) );
				} elseif ( is_year() ) {
					$canonical = get_year_link( get_query_var( 'year' ) );
				}
				break;

			case is_404():
				$canonical = home_url( '/404' );
				break;

			default:
				break;
		}

		if ( empty( $canonical ) ) {
			$canonical = get_permalink( get_queried_object_id() ) ?: '';
		}

		return apply_filters( 'ssp_output_canonical', $canonical );
	}


	/**
	 * Generate the og:type for the current page.
	 *
	 * @return string : The og:type.
	 */
	private static function generate_og_type() {
		if ( ! is_front_page() && is_singular() ) {
			$og_type = 'article';
		} else {
			$og_type = 'website';
		}
		return apply_filters( 'ssp_output_og_type', $og_type );
	}

	/**
	 * Generate the og:image for the current page.
	 * 投稿ページ：アイキャッチ画像を優先し、なければデフォルトのOG:Image画像
	 * メディアページ：自身の画像URL
	 *
	 * @return string : The og:image url.
	 */
	private static function generate_og_image() {

		$site_ogimg = SSP_Data::$ogp['og_image'];

		// default
		$og_image = $site_ogimg;

		switch ( true ) {
			case is_front_page():
			case is_home() && null === self::$obj:
				break;

			case is_attachment():
				if ( ! isset( self::$obj->guid ) ) break;
				$og_image = self::$obj->guid ?: $site_ogimg;
				break;

			// 投稿・固定ページ
			case is_singular():
			case is_home():
				if ( ! isset( self::$obj->ID ) ) break;

				$the_id     = self::$obj->ID; // 投稿ID
				$meta_image = get_post_meta( $the_id, SSP_MetaBox::POST_META_KEYS['image'], true );

				if ( $meta_image ) {
					$og_image = $meta_image;
					break;
				} elseif ( has_post_thumbnail( $the_id ) ) {
					$thumb_id  = get_post_thumbnail_id( $the_id );
					$thumb_src = wp_get_attachment_image_src( $thumb_id, 'full' );
					if ( $thumb_src ) {
						$og_image = $thumb_src[0] ?: $site_ogimg;
						break;
					}
				}
				break;

			case is_search():
			case is_post_type_archive():
				break;

			// ターム系
			case is_tax() || is_tag() || is_category():
				if ( ! isset( self::$obj->term_id ) ) break;

				$meta_image = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['image'], true );
				$og_image   = $meta_image ?: $site_ogimg;
				break;

			default:
				break;
		}

		return apply_filters( 'ssp_output_og_image', $og_image );
	}


	/**
	 * Analytics and Webmaster code.
	 */
	private static function output_codes() {
		// meta tags for webmaster tools
		if ( is_front_page() ) {
			$webmaster_codes = [
				'webmaster_google' => 'google-site-verification',
				'webmaster_bing'   => 'msvalidate.01',
				'webmaster_baidu'  => 'baidu-site-verification',
				'webmaster_yandex' => 'yandex-verification',
			];
			foreach ( $webmaster_codes as $key => $name ) {
				$content = SSP_Data::get( 'settings', $key );
				if ( $content ) {
					echo '<meta name="' . esc_attr( $name ) . '" content="' . esc_attr( $content ) . '">' . PHP_EOL;
				}
			}
		}

		// Google analytics
		$ga_ids = [];
		$g_id   = SSP_Data::get( 'settings', 'google_g_id' );
		if ( $g_id ) {
			$ga_ids[] = $g_id;
		}

		// Google analytics - UA
		$ua_id = SSP_Data::get( 'settings', 'google_ua_id' );
		if ( $ua_id ) {
			$ga_ids[] = $ua_id;
		}

		Output_Helper::output_gtag( $ga_ids );
	}


	/**
	 * Replace snippets
	 */
	public static function replace_snippets( $str, $context = '' ) {

		$obj       = self::$obj;
		$obj_type  = self::$obj_type;
		$separator = \SSP_Data::SEPARATORS[ \SSP_Data::$settings['separator'] ];

		// タイトルにページ数を追加する ( %_page_% の位置が明示的に示されていなければ )
		if ( 'title' === $context && false === strpos( $str, '%_page_%' ) ) {
			$str = Output_Helper::add_page_num_to_title( $str, $separator );
		}

		// get snippets
		$snipets = preg_match_all( '/%_([^%]+)_%/', $str, $matched, PREG_SET_ORDER );
		if ( ! $snipets ) return $str;

		// replace each snippets
		foreach ( $matched as $snipet ) {
			$snipet_tag  = $snipet[0];
			$snipet_name = $snipet[1];
			$replace     = '';
			switch ( $snipet_tag ) {
				case '%_site_title_%':
					$replace = \SSP_Data::$site_title;
					break;
				case '%_phrase_%': // old
				case '%_tagline_%':
					$replace = \SSP_Data::$site_catch_phrase;
					break;
				case '%_description_%': // old
				case '%_front_description_%':
					$replace = \SSP_Data::$settings['home_desc'];
					break;
				case '%_search_phrase_%':
					$replace = get_search_query();
					break;
				case '%_post_type_%':
					$replace = post_type_archive_title( '', false );
					break;
				case '%_page_title_%':
					// is_home() を考慮して get_the_title() ではなく single_post_title()
					$replace = single_post_title( '', false );
					break;
				case '%_page_contents_%':
					if ( 'WP_Post' === $obj_type ) {
						$word_count = apply_filters( 'ssp_description_word_count', 120 );
						$content    = wp_strip_all_tags( strip_shortcodes( $obj->post_content ), true ); // 改行なども削除
						$replace    = mb_substr( $content, 0, $word_count );
					}
					break;
				case '%_term_name_%':
				case '%_cat_name_%': // old
				case '%_tag_name_%': // old
				case '%_format_name_%': // old
					if ( 'WP_Term' === $obj_type ) {
						$replace = $obj->name;
					}
					break;
				case '%_term_description_%':
					if ( 'WP_Term' === $obj_type ) {
						$replace = wp_strip_all_tags( strip_shortcodes( $obj->description ), true ); // 改行なども削除
					}
					break;
				case '%_tax_name_%':
					if ( 'WP_Term' === $obj_type && isset( $obj->taxonomy ) ) {
						$taxonomy_slug = $obj->taxonomy;
						$taxonomy_data = get_taxonomy( $taxonomy_slug );
						$replace       = ( $taxonomy_data ) ? $taxonomy_data->label : '';
					}
					break;
				case '%_author_name_%':
					if ( is_author() && 'WP_User' === $obj_type ) {
						$replace = get_user_meta( $obj->ID, 'nickname', true );
					}
					break;
				case '%_sep_%':
					// 区切り文字の置換
					$replace = $separator;
					break;
				case '%_date_%':
					$year     = get_query_var( 'year' );
					$monthnum = get_query_var( 'monthnum' );
					$day      = get_query_var( 'day' );

					$month = '';
					if ( $monthnum ) {
						global $wp_locale;
						$month = $wp_locale->get_month( $monthnum );
					}

					if ( is_day() ) {
						$replace = sprintf( _x( '%2$s %3$s, %1$s', 'date', 'loos-ssp' ), $year, $month, $day ); // phpcs:ignore
					} elseif ( is_month() ) {
						$replace = sprintf( _x( '%2$s %1$s', 'date', 'loos-ssp' ), $year, $month ); // phpcs:ignore
					} elseif ( is_year() ) {
						$replace = sprintf( _x( '%s', 'date', 'loos-ssp' ), $year ); // phpcs:ignore
					}
					break;
				case '%_page_%':
					$page    = Output_Helper::get_paged_text();
					$replace = $page ? "$separator $page" : '';
					break;
				default:
					// その他、SSP側で用意していないスニペットがある時、フィルターで置換できるようにする
					$filter_name = "ssp_replace_snippet_$snipet_name";
					if ( has_filter( $filter_name ) ) {
						$replace = apply_filters( $filter_name, '', $context );
					}
					break;
			}

			$str = str_replace( $snipet_tag, $replace, $str );
		} // end foreach

		// 区切り文字が続いてしまう場合は削除
		if ( 'title' === $context ) {
			$str = str_replace( "$separator $separator", $separator, $str );
		}

		// 空白が続いてる場合は1つに
		// $str = str_replace( '  ', ' ', $str );

		$str = trim( $str );
		return $str;
	}

}
