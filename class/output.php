<?php
class SSP_Output {

	use \SSP\Output_Helper;

	/**
	 * 外部からのインスタンス化を防ぐ
	 */
	private function __construct() {}

	/**
	 * @var object The current wp object.
	 */
	private static $obj;

	/**
	 * @var string The Title holder.
	 */
	private static $title;

	/**
	 * @var string The Description holder.
	 */
	private static $description;

	/**
	 * @var string The Description holder.
	 */
	private static $robots;

	/**
	 * @var string The Description holder.
	 */
	private static $keyword;


	/**
	 * @var string The canonical holder.
	 */
	private static $canonical;

	/**
	 * @var string The canonical holder.
	 */
	private static $og_tags;

	/**
	 * @var string The og:locale holder.
	 */
	private static $og_locale;

	/**
	 * @var string The og:type holder.
	 */
	private static $og_type;

	/**
	 * @var string The og:image holder.
	 */
	private static $og_image;

	/**
	 * @var string The og:facebook holder.
	 */
	private static $og_facebook;

	/**
	 * @var string The og:twitter holder.
	 */
	private static $og_twitter;


	/**
	 * init
	 */
	public static function init() {
		add_action( 'wp_head', [ 'SSP_Output', 'main' ], 5 );
	}


	/**
	 * Genarate and output meta tags for current page.
	 */
	public static function main() {

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

		self::$obj         = get_queried_object();
		self::$title       = self::generate_title();
		self::$robots      = self::generate_robots();
		self::$keyword     = self::generate_keyword();
		self::$description = self::generate_description();
		self::$canonical   = self::generate_canonical();

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
	 * Generate ogp tags
	 */
	private static function generate_ogp_tags() {

		self::$og_locale   = self::generate_og_locale();
		self::$og_type     = self::generate_og_type();
		self::$og_image    = self::generate_og_image();
		self::$og_tags     = self::generate_general_ogp();
		self::$og_facebook = self::generate_og_facebook();
		self::$og_twitter  = self::generate_og_twitter();

	}


	/**
	 * Output ogp tags
	 */
	private static function output_ogp_tags() {

		if ( ! empty( self::$og_locale ) ) {
			echo '<meta property="og:locale" content="' . esc_attr( self::$og_locale ) . '">' . PHP_EOL;
		}

		if ( ! empty( self::$og_image ) ) {
			echo '<meta property="og:image" content="' . esc_url( self::$og_image ) . '">' . PHP_EOL;
		}

		if ( ! empty( self::$og_tags ) ) {
			echo self::$og_tags; // phpcs:ignore
		}

		if ( ! empty( self::$og_type ) ) {
			echo '<meta property="og:type" content="' . esc_attr( self::$og_type ) . '">' . PHP_EOL;
		}

		if ( ! empty( self::$og_facebook ) ) {
			echo self::$og_facebook; // phpcs:ignore
		}

		if ( ! empty( self::$og_twitter ) ) {
			echo self::$og_twitter; // phpcs:ignore
		}

	}


	/**
	 * Generate the title tag for the current page.
	 *
	 * @return string : The title.
	 */
	private static function generate_title() {

		$settings = SSP_Data::$settings;

		switch ( true ) {
			case is_front_page():
				$title = $settings['home_title'];
				break;
			case is_singular():
			case is_home():
				$meta_title = get_post_meta( self::$obj->ID, SSP_MetaBox::POST_META_KEYS['title'], true );
				if ( $meta_title ) {
					$title = $meta_title;
				} else {
					$pt    = self::$obj->post_type;
					$title = $settings[ $pt . '_title' ];
				}
				break;

			case is_category():
				$meta_title = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['title'], true );
				$title      = $meta_title ?: $settings['cat_title'];
				break;

			case is_tag():
				$meta_title = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['title'], true );
				$title      = $meta_title ?: $settings['tag_title'];
				break;

			case is_tax():
				$meta_title = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['title'], true );
				$term       = self::$obj->taxonomy;
				$title      = $meta_title ?: $settings[ $term . '_title' ];
				break;

			case is_post_type_archive():
				$title = $settings['pt_archive_title'];
				break;

			case is_author():
				$title = $settings['author_title'];
				break;

			case is_date():
				$title = $settings['date_title'];
				break;

			case is_search():
				$title = $settings['search_title'];
				break;

			case is_404():
				$title = $settings['404_title'];
				break;

			default:
				$title = SSP_Data::$site_title;
				break;
		}

		$title = self::replace_snippets( $title );
		$title = trim( strip_shortcodes( strip_tags( $title ) ) ); // phpcs:ignore

		return apply_filters( 'ssp_output_title', $title );
	}

	/**
	 * Generate the meta:robots for the current page.
	 *
	 * @return string : The meta:robots.
	 */
	private static function generate_robots() {

		$settings = SSP_Data::$settings;

		switch ( true ) {

			case is_front_page():
				$robots = '';
				break;

			case is_singular():
			case is_home():
				$meta_robots = get_post_meta( self::$obj->ID, SSP_MetaBox::POST_META_KEYS['robots'], true );
				if ( $meta_robots ) {
					$robots = $meta_robots;
				} else {
					$pt         = self::$obj->post_type;
					$is_noindex = $settings[ $pt . '_noindex' ];
					$robots     = $is_noindex ? 'noindex' : '';
				}
				break;

			case is_category():
				$meta_robots = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['robots'], true );
				if ( $meta_robots ) {
					$robots = $meta_robots;
				} else {
					$is_noindex = $settings['cat_noindex'];
					$robots     = $is_noindex ? 'noindex' : '';
				}

				break;

			case is_tag():
				$meta_robots = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['robots'], true );
				if ( $meta_robots ) {
					$robots = $meta_robots;
				} else {
					$is_noindex = $settings['tag_noindex'];
					$robots     = $is_noindex ? 'noindex' : '';
				}
				break;

			case is_tax():
				$meta_robots = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['robots'], true );
				if ( $meta_robots ) {
					$robots = $meta_robots;
				} else {
					$term       = self::$obj->taxonomy;
					$is_noindex = $settings[ $term . '_noindex' ];
					$robots     = $is_noindex ? 'noindex' : '';
				}
				break;

			case is_post_type_archive():
				$is_noindex = $settings['pt_archive_noindex'];
				$robots     = $is_noindex ? 'noindex' : '';
				break;

			case is_author():
				$is_noindex = $settings['author_noindex'];
				$robots     = $is_noindex ? 'noindex' : '';
				break;

			case is_date():
				$is_noindex = $settings['date_noindex'];
				$robots     = $is_noindex ? 'noindex' : '';
				break;

			case is_search():
				$robots = 'noindex';
				break;

			case is_404():
				$robots = 'noindex';
				break;

			default:
				$robots = '';
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

		$keyword = '';

		if ( is_front_page() ) {

			$keyword = SSP_Data::$settings['home_keyword'];

		} elseif ( is_singular() || ( ! is_front_page() && is_home() ) ) {

			// メタボックスが入力されていれば上書きする
			$metabox_keyword = get_post_meta( self::$obj->ID, SSP_MetaBox::POST_META_KEYS['keyword'], true );
			if ( $metabox_keyword ) {
				$keyword = $metabox_keyword;
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

		switch ( true ) {
			case is_front_page():
				$description = $settings['home_desc'] ?: '%_phrase_%';
				break;

			case is_singular():
			case is_home():
				$metabox_desc = get_post_meta( self::$obj->ID, SSP_MetaBox::POST_META_KEYS['description'], true );

				if ( '' !== $metabox_desc ) {
					// メタボックスが入力されていれば優先
					$description = $metabox_desc;
				} else {
					$pt          = self::$obj->post_type;
					$description = $settings[ $pt . '_desc' ];
				}
				break;

			case is_category():
				$meta_description = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['description'], true );
				$description      = $meta_description ?: $settings['cat_desc'];
				break;

			case is_tag():
				$meta_description = get_term_meta( self::$obj->term_id, SSP_MetaBox::TERM_META_KEYS['description'], true );
				$description      = $meta_description ?: $settings['tag_desc'];
				break;

			case is_tax():
				$term        = self::$obj->taxonomy;
				$description = $settings[ $term . '_desc' ];
				break;

			case is_post_type_archive():
				$description = $settings['pt_archive_desc'];
				break;

			case is_author():
				$description = $settings['author_desc'];
				break;

			case is_date():
				$description = $settings['date_desc'];
				break;

			default:
				$description = $settings['home_desc'];
				break;
		}

		$description = self::replace_snippets( $description );
		return apply_filters( 'ssp_output_description', $description );

	}


	/**
	 * Generate the general ogp tags for the current page.
	 *
	 * @return string : OGP tags.
	 */
	private static function generate_general_ogp() {

		$og_title     = apply_filters( 'ssp_output_og_title', self::$title );
		$og_desc      = apply_filters( 'ssp_output_og_description', self::$description );
		$og_url       = apply_filters( 'ssp_output_og_url', self::$canonical );
		$og_site_name = apply_filters( 'ssp_output_og_site_name', SSP_Data::$site_title );

		$ogp  = '';
		$ogp .= '<meta property="og:title" content="' . esc_attr( $og_title ) . '">' . PHP_EOL;
		$ogp .= '<meta property="og:description" content="' . esc_attr( $og_desc ) . '">' . PHP_EOL;
		$ogp .= '<meta property="og:url" content="' . esc_attr( $og_url ) . '">' . PHP_EOL;
		$ogp .= '<meta property="og:site_name" content="' . esc_attr( $og_site_name ) . '">' . PHP_EOL;

		return $ogp;

	}


	/**
	 * Generate the canonical URL for the current page.
	 *
	 * @return string : The canonical URL.
	 */
	private static function generate_canonical() {

		switch ( true ) {

			case is_front_page():
				$canonical = home_url();
				break;

			case is_singular():
				$canonical = get_permalink();
				break;

			case is_tax() || is_tag() || is_category():
				$term      = self::$obj;
				$term_link = get_term_link( $term, $term->taxonomy );
				$canonical = ( is_wp_error( $term_link ) ) ? '' : $term_link;
				break;

			case is_post_type_archive():
				$post_type = get_query_var( 'post_type' );
				$post_type = ( is_array( $post_type ) ) ? reset( $post_type ) : $post_type;
				$canonical = get_post_type_archive_link( $post_type );
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

			case is_search():
				$canonical = get_search_link();
				break;

			case is_404():
				$canonical = home_url() . '/404';
				break;

			default:
				// is_home() もここに来る。
				$canonical = get_permalink( self::$obj->ID );

				break;
		}

		return apply_filters( 'ssp_output_canonical', $canonical );
	}


	/**
	 * Generate the og:type for the current page.
	 *
	 * @return string : The og:type.
	 */
	private static function generate_og_type() {
		$og_type = is_singular() ? 'article' : 'website';
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
		$og_image = SSP_Data::$ogp['og_image'];

		if ( is_attachment() ) {

			$og_image = self::$obj->guid;

		} elseif ( is_singular() || ( ! is_front_page() && is_home() ) ) {

			$the_id = self::$obj->ID;
			if ( has_post_thumbnail( $the_id ) ) {
				$thumb_id  = get_post_thumbnail_id( $the_id );
				$thumb_url = wp_get_attachment_image_src( $thumb_id, 'full' );
				$og_image  = $thumb_url[0];
			}
		}
		return apply_filters( 'ssp_output_og_image', $og_image );
	}


	/**
	 * Generate the og:locale for the current page.
	 *
	 * @return string : The og:locale.
	 */
	private static function generate_og_locale() {

		$locale = self::get_valid_og_locale();
		return apply_filters( 'ssp_output_og_locale', $locale );

	}

	/**
	 * Generate the og tags for facebook. for the current page.
	 *
	 * @return string : The og tags for facebook.
	 */
	private static function generate_og_facebook() {

		if ( ! SSP_Data::$ogp['fb_active'] ) return '';

		$appid     = apply_filters( 'ssp_output_fb_appid', SSP_Data::$ogp['fb_app_id'] );
		$admins    = apply_filters( 'ssp_output_fb_admins', SSP_Data::$ogp['fb_admins'] );
		$publisher = apply_filters( 'ssp_output_fb_publisher', SSP_Data::$ogp['fb_url'] );

		$og_fb = '';
		if ( ! empty( $appid ) ) {
			$og_fb .= '<meta property="fb:app_id" content="' . esc_attr( $appid ) . '">' . PHP_EOL;
		}
		if ( ! empty( $admins ) ) {
			$og_fb .= '<meta property="fb:admins" content="' . esc_attr( $admins ) . '">' . PHP_EOL;
		}
		if ( ! empty( $publisher ) && 'article' === self::$og_type ) {
			$og_fb .= '<meta property="article:publisher" content="' . esc_attr( $publisher ) . '">' . PHP_EOL;
		}

		return $og_fb;

	}


	/**
	 * Generate the og tags for twitter. for the current page.
	 *
	 * @return string : The og tags for twitter.
	 */
	private static function generate_og_twitter() {

		if ( ! SSP_Data::$ogp['tw_active'] ) return '';

		$tw_site = apply_filters( 'ssp_output_tw_site', SSP_Data::$ogp['tw_account'] );
		$tw_card = apply_filters( 'ssp_output_tw_card', SSP_Data::$ogp['tw_card'] );

		$og_tw = '';
		if ( ! empty( $tw_card ) ) {
			$og_tw .= '<meta name="twitter:card" content="' . esc_attr( $tw_card ) . '">' . PHP_EOL;
		}
		if ( ! empty( $tw_site ) ) {
			$og_tw .= '<meta name="twitter:site" content="' . esc_attr( $tw_site ) . '">' . PHP_EOL;
		}

		return $og_tw;
	}


	/**
	 * Analytics and Webmaster code.
	 */
	private static function output_codes() {

		$settings = SSP_Data::$settings;

		// meta tags for webmaster tools
		if ( is_front_page() ) {
			$webmaster_codes = [
				'webmaster_google' => 'google-site-verification',
				'webmaster_bing'   => 'msvalidate.01',
				'webmaster_baidu'  => 'baidu-site-verification',
				'webmaster_yandex' => 'yandex-verification',
			];
			foreach ( $webmaster_codes as $key => $name ) {
				if ( $settings[ $key ] ) {
					echo '<meta name="' . esc_attr( $name ) . '" content="' . esc_attr( $settings[ $key ] ) . '">' . PHP_EOL;
				}
			}
		}

		// google analytics code
		if ( $settings['google_analytics_id'] ) {

			$gaid = $settings['google_analytics_id'];

			if ( 'gtag' === $settings['google_analytics_type'] ) {

				self::echo_gtag( $gaid );

			} elseif ( 'analytics' === $settings['google_analytics_type'] ) {

				self::echo_analytics( $gaid );

			}
		}
	}
}
