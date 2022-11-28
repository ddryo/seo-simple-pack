<?php
/**
 * SSP_Output用のヘルパークラス
 */
namespace LOOS\SSP;

// phpcs:disable WordPress.WP.EnqueuedResources.NonEnqueuedScript
class Output_Helper {


	/**
	 *  gtagコード出力
	 */
	public static function output_gtag( $ids ) {
		if ( empty( $ids ) ) return;
		$id1 = $ids[0];
		$id2 = isset( $ids[1] ) ? $ids[1] : '';
	?>
<!-- Google Analytics (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?=esc_attr( $id1 )?>"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag("js", new Date());
	gtag("config", "<?=esc_attr( $id1 )?>");
<?php if ( $id2 ) : ?>
	gtag("config", "<?=esc_attr( $id2 )?>");
<?php endif; ?>
</script>
	<?php
	}


	/**
	 *  旧アナリティクスコード出力
	 */
	public static function output_uatag( $gaid ) {
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
}
