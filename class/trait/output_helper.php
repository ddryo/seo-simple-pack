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
	private static function replace_snippets( $str, $context = '' ) {

		$obj      = \SSP_Output::$obj;
		$obj_type = \SSP_Output::$obj_type;

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
				case '%_phrase_%':
					$replace = \SSP_Data::$site_catch_phrase;
					break;
				case '%_tagline_%':
					$replace = \SSP_Data::$site_catch_phrase;
					break;
				case '%_description_%':
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
				case '%_cat_name_%':
				case '%_tag_name_%':
				case '%_format_name_%':
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
					$replace = \SSP_Data::SEPARATORS[ \SSP_Data::$settings['separator'] ];
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

		$str = trim( $str );
		return $str;
	}

}
