<?php
/**
 * SSP_Output用のtrait
 */
namespace SSP;

// phpcs:disable WordPress.WP.EnqueuedResources.NonEnqueuedScript

trait Output_Helper {

	/**
	 *  gtagコード出力
	 */
	public static function echo_gtag( $gaid ) {
?>
<!-- Google Analytics (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?=esc_attr( $gaid )?>"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag("js", new Date());
	gtag("config", "<?=esc_attr( $gaid )?>");
</script>
<?php
	}


	/**
	 *  旧アナリティクスコード出力
	 */
	public static function echo_analytics( $gaid ) {
?>
<!-- Google Analytics -->
<script>
	(function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,"script","https://www.google-analytics.com/analytics.js","ga");
	ga("create", "<?=esc_attr( $gaid )?>", "auto");
	ga("send", "pageview");
</script>
<?php
	}


	/**
	 *  og:locale用の有効な文字列を取得
	 */
	public static function get_valid_og_locale() {
		$locale = get_locale();

		// 少し特殊なケースの locale 文字列たちを先に変換
		$fix_locales = [
			'ca' => 'ca_ES', // Catalan.
			'en' => 'en_US', // English (US).
			'el' => 'el_GR', // Greek.
			'et' => 'et_EE', // Estonian.
			'ja' => 'ja_JP', // Japanese.
			'sq' => 'sq_AL', // Albanian.
			'uk' => 'uk_UA', // Ukrainian.
			'vi' => 'vi_VN', // Vietnamese.
			'zh' => 'zh_CN', // Simplified Chinese (China).
		];

		if ( isset( $fix_locales[ $locale ] ) ) {
			return $fix_locales[ $locale ];
		}

		// Convert locales like "es" to "es_ES".
		if ( strlen( $locale ) === 2 ) {
			$locale = strtolower( $locale ) . '_' . strtoupper( $locale );
		}

		// These are the locales FB supports.
		$fb_valid_locales = [
			'af_ZA', // Afrikaans.
			'ak_GH', // Akan.
			'am_ET', // Amharic.
			'ar_AR', // Arabic.
			'as_IN', // Assamese.
			'ay_BO', // Aymara.
			'az_AZ', // Azerbaijani.
			'be_BY', // Belarusian.
			'bg_BG', // Bulgarian.
			'bn_IN', // Bengali.
			'br_FR', // Breton.
			'bs_BA', // Bosnian.
			// 'ca_ES',
			'cb_IQ', // Sorani Kurdish.
			'ck_US', // Cherokee.
			'co_FR', // Corsican.
			'cs_CZ', // Czech.
			'cx_PH', // Cebuano.
			'cy_GB', // Welsh.
			'da_DK', // Danish.
			'de_DE', // German.
			// 'el_GR',
			'en_GB', // English (UK).
			'en_IN', // English (India).
			'en_PI', // English (Pirate).
			'en_UD', // English (Upside Down).
			// 'en_US',
			'eo_EO', // Esperanto.
			'es_CL', // Spanish (Chile).
			'es_CO', // Spanish (Colombia).
			'es_ES', // Spanish (Spain).
			'es_LA', // Spanish.
			'es_MX', // Spanish (Mexico).
			'es_VE', // Spanish (Venezuela).
			// 'et_EE',
			'eu_ES', // Basque.
			'fa_IR', // Persian.
			'fb_LT', // Leet Speak.
			'ff_NG', // Fulah.
			'fi_FI', // Finnish.
			'fo_FO', // Faroese.
			'fr_CA', // French (Canada).
			'fr_FR', // French (France).
			'fy_NL', // Frisian.
			'ga_IE', // Irish.
			'gl_ES', // Galician.
			'gn_PY', // Guarani.
			'gu_IN', // Gujarati.
			'gx_GR', // Classical Greek.
			'ha_NG', // Hausa.
			'he_IL', // Hebrew.
			'hi_IN', // Hindi.
			'hr_HR', // Croatian.
			'hu_HU', // Hungarian.
			'hy_AM', // Armenian.
			'id_ID', // Indonesian.
			'ig_NG', // Igbo.
			'is_IS', // Icelandic.
			'it_IT', // Italian.
			// 'ja_JP',
			'ja_KS', // Japanese (Kansai).
			'jv_ID', // Javanese.
			'ka_GE', // Georgian.
			'kk_KZ', // Kazakh.
			'km_KH', // Khmer.
			'kn_IN', // Kannada.
			'ko_KR', // Korean.
			'ku_TR', // Kurdish (Kurmanji).
			'ky_KG', // Kyrgyz.
			'la_VA', // Latin.
			'lg_UG', // Ganda.
			'li_NL', // Limburgish.
			'ln_CD', // Lingala.
			'lo_LA', // Lao.
			'lt_LT', // Lithuanian.
			'lv_LV', // Latvian.
			'mg_MG', // Malagasy.
			'mi_NZ', // Maori.
			'mk_MK', // Macedonian.
			'ml_IN', // Malayalam.
			'mn_MN', // Mongolian.
			'mr_IN', // Marathi.
			'ms_MY', // Malay.
			'mt_MT', // Maltese.
			'my_MM', // Burmese.
			'nb_NO', // Norwegian (bokmal).
			'nd_ZW', // Ndebele.
			'ne_NP', // Nepali.
			'nl_BE', // Dutch (Belgie).
			'nl_NL', // Dutch.
			'nn_NO', // Norwegian (nynorsk).
			'ny_MW', // Chewa.
			'or_IN', // Oriya.
			'pa_IN', // Punjabi.
			'pl_PL', // Polish.
			'ps_AF', // Pashto.
			'pt_BR', // Portuguese (Brazil).
			'pt_PT', // Portuguese (Portugal).
			'qu_PE', // Quechua.
			'rm_CH', // Romansh.
			'ro_RO', // Romanian.
			'ru_RU', // Russian.
			'rw_RW', // Kinyarwanda.
			'sa_IN', // Sanskrit.
			'sc_IT', // Sardinian.
			'se_NO', // Northern Sami.
			'si_LK', // Sinhala.
			'sk_SK', // Slovak.
			'sl_SI', // Slovenian.
			'sn_ZW', // Shona.
			'so_SO', // Somali.
			// 'sq_AL',
			'sr_RS', // Serbian.
			'sv_SE', // Swedish.
			'sw_KE', // Swahili.
			'sy_SY', // Syriac.
			'sz_PL', // Silesian.
			'ta_IN', // Tamil.
			'te_IN', // Telugu.
			'tg_TJ', // Tajik.
			'th_TH', // Thai.
			'tk_TM', // Turkmen.
			'tl_PH', // Filipino.
			'tl_ST', // Klingon.
			'tr_TR', // Turkish.
			'tt_RU', // Tatar.
			'tz_MA', // Tamazight.
			// 'uk_UA',
			'ur_PK', // Urdu.
			'uz_UZ', // Uzbek.
			// 'vi_VN',
			'wo_SN', // Wolof.
			'xh_ZA', // Xhosa.
			'yi_DE', // Yiddish.
			'yo_NG', // Yoruba.
			// 'zh_CN',
			'zh_HK', // Traditional Chinese (Hong Kong).
			'zh_TW', // Traditional Chinese (Taiwan).
			'zu_ZA', // Zulu.
			'zz_TR', // Zazaki.
		];

		// FBでサポートされていない locale だった場合、en_US を返す
		if ( ! in_array( $locale, $fb_valid_locales, true ) ) {
			return 'en_US';
		}

		return $locale;
	}


	/**
	 * Replace snippets
	 */
	private static function replace_snippets( $str ) {

		$obj = \SSP_Output::$obj;

		// 共通項目の置換
		$str = str_replace( '%_site_title_%', \SSP_Data::$site_title, $str );
		$str = str_replace( '%_phrase_%', \SSP_Data::$site_catch_phrase, $str );
		$str = str_replace( '%_tagline_%', \SSP_Data::$site_catch_phrase, $str );
		$str = str_replace( '%_description_%', \SSP_Data::$settings['home_desc'], $str );

		if ( is_singular() || ( ! is_front_page() && is_home() ) ) {

			// title
			if ( isset( $obj->ID ) ) {
				$title = get_the_title( $obj->ID );
				$str   = str_replace( '%_page_title_%', $title, $str );

				// description
				if ( false !== strpos( $str, '%_page_contents_%' ) ) {
					$word_count = apply_filters( 'ssp_description_word_count', 120 );
					$content    = wp_strip_all_tags( do_shortcode( $obj->post_content ), true ); // 改行なども削除
					$content    = mb_substr( $content, 0, $word_count );
					$str        = str_replace( '%_page_contents_%', $content, $str );
				}
			}
		} elseif ( is_search() ) {
			if ( false !== strpos( $str, '%_search_phrase_%' ) ) {
				$str = str_replace( '%_search_phrase_%', get_search_query(), $str );
			}
		} elseif ( is_category() || is_tag() || is_tax() ) {

			// title
			$str = str_replace( ['%_cat_name_%', '%_tag_name_%', '%_term_name_%', '%_format_name_%' ], $obj->name, $str );

			// description
			$term_desc = wp_strip_all_tags( do_shortcode( $obj->description ), true ); // 改行なども削除
			$str       = str_replace( '%_term_description_%', $term_desc, $str );

			// タクソノミー名
			if ( false !== strpos( $str, '%_tax_name_%' ) ) {

				$taxonomy_slug  = ( isset( $obj->taxonomy ) ) ? $obj->taxonomy : '';
				$taxonomy_var   = get_taxonomy( $taxonomy_slug );
				$taxonomy_label = ( $taxonomy_var ) ? $taxonomy_var->label : '';

				$str = str_replace( '%_tax_name_%', $taxonomy_label, $str );
			}
		} else {
			// その他のページ
			// $obj_name  = ( isset( $obj->name ) ) ? $obj->name : '';
			$obj_label = ( isset( $obj->label ) ) ? $obj->label : '';

			$str = str_replace( '%_post_type_%', $obj_label, $str );

			if ( strpos( $str, '%_date_%' ) !== false ) {

				$date_str = '';
				$year     = get_query_var( 'year' );
				$month    = '';
				$monthnum = get_query_var( 'monthnum' );
				$day      = get_query_var( 'day' );

				if ( $monthnum ) {
					global $wp_locale;
					$month = $wp_locale->get_month( $monthnum );
				}

				if ( is_day() ) {
					$date_str = sprintf( _x( '%2$s %3$s, %1$s', 'date', 'loos-ssp' ), $year, $month, $day ); // phpcs:ignore
				} elseif ( is_month() ) {
					$date_str = sprintf( _x( '%2$s %1$s', 'date', 'loos-ssp' ), $year, $month ); // phpcs:ignore
				} elseif ( is_year() ) {
					$date_str = sprintf( _x( '%s', 'date', 'loos-ssp' ), $year ); // phpcs:ignore
				}

				$str = str_replace( '%_date_%', $date_str, $str );

			}

			if ( false !== strpos( $str, '%_author_name_%' ) ) {

				$str = str_replace( '%_author_name_%', get_user_meta( $obj->ID, 'nickname', true ), $str );

			}
		}

		if ( false !== strpos( $str, '%_sep_%' ) ) {

			$sep_key = \SSP_Data::$settings['separator'];
			$sep_val = \SSP_Data::SEPARATORS[ $sep_key ];
			$str     = str_replace( '%_sep_%', $sep_val, $str );

		}

		return $str;
	}

}
