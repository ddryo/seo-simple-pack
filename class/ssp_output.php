<?php

class SSP_Output {

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
     * The constructor.
     * Genarate and output meta tags for current page.
     */
    public static function main() {

        self::generate_metas();
        self::generate_og_metas();

        echo "\n<!-- SEO SIMPLE PACK ", SSP_VERSION, " -->\n";
        self::output_metas();
        self::output_og_metas();
        self::output_codes();
        echo "<!-- / SEO SIMPLE PACK -->\n";

    }


    /**
     * Generate meta tags
     * 
     */
    private static function generate_metas() {

        self::$obj         = get_queried_object();
        self::$title       = self::generate_title( SSP_Branch::$is_ );
        self::$robots      = self::generate_robots( SSP_Branch::$is_ );
        self::$keyword     = self::generate_keyword( SSP_Branch::$is_ );
        self::$description = self::generate_description( SSP_Branch::$is_ );
        self::$canonical   = self::generate_canonical(SSP_Branch::$is_ );

    }

    /**
     * Output meta tags
     */
    private static function output_metas() {

        
        if ( !empty( self::$title ) ) {
            echo '<title>', esc_html( self::$title ), '</title>', "\n";
        }

        if ( !empty( self::$robots ) ) {
            echo '<meta name="robots" content="', esc_attr( self::$robots ), '">', "\n";
        }

        if ( !empty( self::$description ) ) {
            echo '<meta name="description" content="', esc_attr( self::$description ), '">', "\n";
        }

        if ( !empty( self::$keyword ) ) {
            echo '<meta name="keywords" content="', esc_attr( self::$keyword ), '">', "\n";
        }

        if ( !empty( self::$canonical ) ) {
            echo '<link rel="canonical" href="', esc_attr( self::$canonical ), '">', "\n";
        }

    }


    /**
     * Generate ogp tags
     * 
     */
    private static function generate_og_metas() {

        self::$og_locale   = self::generate_og_locale();
        self::$og_type     = self::generate_og_type();
        self::$og_image    = self::generate_og_image();
        self::$og_tags     = self::generate_general_ogp( );
        self::$og_facebook = self::generate_og_facebook();
        self::$og_twitter  = self::generate_og_twitter();

    }


    /**
     * Output ogp tags
     */
    private static function output_og_metas() {

        if ( !empty( self::$og_locale ) ) {
            echo '<meta property="og:locale" content="'.esc_attr( self::$og_locale ).'">'."\n";
        }

        if ( !empty( self::$og_image ) ) {
            echo '<meta property="og:image" content="'.esc_url( self::$og_image ).'">'."\n";
        }

        if ( !empty( self::$og_tags ) ) {
            echo self::$og_tags;
        }

        if ( !empty( self::$og_type ) ) {
            echo '<meta property="og:type" content="'.esc_attr( self::$og_type ).'">'."\n";
        }

        if ( !empty( self::$og_facebook ) ) {
            echo self::$og_facebook."\n";
        }

        if ( !empty( self::$og_twitter ) ) {
            echo self::$og_twitter."\n";
        }

    }


    /**
     * Generate the title tag for the current page.
     * 
     * @param array $is_  : Results of Conditional tags.
     * @return string     : The title.
     */
    private static function generate_title( $is_ ) {

        switch ( true ) {
            case $is_[ 'top' ]:

                $title = SSP_Data::$settings[ 'home_title' ];
                break;

            case $is_[ 'singular' ] :
            case $is_[ 'home' ] :
                $meta_title = get_post_meta(self::$obj->ID, SSP_MetaBox::P_METANAME['title'], true);
                if ( $meta_title ) {
                    $title = $meta_title;
                } else {
                    $pt    = self::$obj->post_type;
                    $title = SSP_Data::$settings[ $pt.'_title' ];
                }
                break;

            case $is_[ 'category' ] :

                $meta_title = get_term_meta(self::$obj->term_id, SSP_MetaBox::T_METANAME['title'], true);
                $title = $meta_title ?: SSP_Data::$settings[ 'cat_title' ];
                break;

            case $is_[ 'tag' ] :

                $meta_title = get_term_meta(self::$obj->term_id, SSP_MetaBox::T_METANAME['title'], true);
                $title = $meta_title ?: SSP_Data::$settings[ 'tag_title' ];
                break;

            case $is_[ 'tax' ] :

                $meta_title = get_term_meta(self::$obj->term_id, SSP_MetaBox::T_METANAME['title'], true);
                $term  = self::$obj->taxonomy;
                $title = $meta_title ?: SSP_Data::$settings[ $term.'_title' ];
                break;

            case $is_[ 'pt_archive' ] :

                $title = SSP_Data::$settings[ 'pt_archive_title' ];
                break;

            case $is_[ 'author' ] :

                $title = SSP_Data::$settings[ 'author_title' ];
                break;

            case $is_[ 'date' ] :

                $title = SSP_Data::$settings[ 'date_title' ];
                break;

            case $is_[ 'search' ] :

                $title = SSP_Data::$settings[ 'search_title' ];
                break;

            case $is_[ '404' ] :

                $title = SSP_Data::$settings[ '404_title' ];
                break;

            default :
                $title = SSP_Data::$site_title;
                break;
        }

        $title = self::replace_snippets( $title );
        $title = trim( strip_shortcodes( strip_tags( $title ) ) );

        return apply_filters( 'ssp_output_title', $title );
    }

    /**
     * Generate the meta:robots for the current page.
     * 
     * @param array $is_  : Results of Conditional tags.
     * @return string     : The meta:robots.
     */
    private static function generate_robots( $is_ ) {

        switch ( true ) {

            case $is_[ 'top' ]:

                $robots = "";
                break;

            case $is_[ 'singular' ] :
            case $is_[ 'home' ] :

                $meta_robots = get_post_meta(self::$obj->ID, SSP_MetaBox::P_METANAME['robots'], true);
                if ( $meta_robots ) {
                    $robots = $meta_robots;
                } else {
                    $pt         = self::$obj->post_type;
                    $is_noindex = SSP_Data::$settings[ $pt.'_noindex' ];
                    $robots     = $is_noindex ? 'noindex' : "";
                }
                break;

            case $is_[ 'category' ] :

                $meta_robots = get_term_meta(self::$obj->term_id, SSP_MetaBox::T_METANAME['robots'], true);
                if ( $meta_robots ) {
                    $robots = $meta_robots;
                } else {
                    $is_noindex = SSP_Data::$settings[ 'cat_noindex' ];
                    $robots     = $is_noindex ? 'noindex' : "";
                }
                
                break;

            case $is_[ 'tag' ] :

                $meta_robots = get_term_meta(self::$obj->term_id, SSP_MetaBox::T_METANAME['robots'], true);
                if ( $meta_robots ) {
                    $robots = $meta_robots;
                } else {
                    $is_noindex = SSP_Data::$settings[ 'tag_noindex' ];
                    $robots     = $is_noindex ? 'noindex' : "";
                }
                break;

            case $is_[ 'tax' ] :

                $meta_robots = get_term_meta(self::$obj->term_id, SSP_MetaBox::T_METANAME['robots'], true);
                if ( $meta_robots ) {
                    $robots = $meta_robots;
                } else {
                    $term = self::$obj->taxonomy;
                    $is_noindex = SSP_Data::$settings[ $term.'_noindex' ];
                    $robots     = $is_noindex ? 'noindex' : "";
                }
                break;

            case $is_[ 'pt_archive' ] :

                $is_noindex = SSP_Data::$settings[ 'pt_archive_noindex' ];
                $robots     = $is_noindex ? 'noindex' : "";
                break;

            case $is_[ 'author' ] :

                $is_noindex = SSP_Data::$settings[ 'author_noindex' ];
                $robots     = $is_noindex ? 'noindex' : "";
                break;

            case $is_[ 'date' ] :

                $is_noindex = SSP_Data::$settings[ 'date_noindex' ];
                $robots     = $is_noindex ? 'noindex' : "";
                break;

            case $is_[ 'search' ] :

                $robots = 'noindex';
                break;

            case $is_[ '404' ] :

                $robots = 'noindex';
                break;

            default :
                $robots = "";
                break;
        }


        return apply_filters( 'ssp_output_robots', $robots );
    }

    /**
     * Generate the meta:keyword for the current page.
     * 
     * @param array $is_  : Results of Conditional tags.
     * @return string     : The meta:keyword.
     */
    private static function generate_keyword( $is_ ) {

        $keyword = SSP_Data::$settings[ 'home_keyword' ];

        if ( $is_[ 'singular' ] || ( ! $is_[ 'top' ] && $is_[ 'home' ] ) ) {

            //メタボックスが入力されていれば上書きする
            $metabox_keyword = get_post_meta(self::$obj->ID, SSP_MetaBox::P_METANAME['keyword'], true);
            if ( $metabox_keyword ) {
                $keyword = $metabox_keyword;
            }

        }

        return apply_filters( 'ssp_output_keyword', $keyword );

    }


    /**
     * Generate the meta:description for the current page.
     * 

     * @param array $is_  : Results of Conditional tags.
     * @return string     : The meta:description.
     */
    private static function generate_description( $is_ ) {

        switch ( true ) {
            case $is_[ 'top' ]:

                $description = SSP_Data::$settings[ 'home_desc' ] ?: '%_phrase_%';
                break;

            case $is_[ 'singular' ] :
            case $is_[ 'home' ] :

                $metabox_desc = get_post_meta( self::$obj->ID, SSP_MetaBox::P_METANAME['description'], true );

                if ( $metabox_desc !== "" ) {
                    //メタボックスが入力されていれば優先
                    $description = $metabox_desc;
                } else {
                    $pt = self::$obj->post_type;
                    $description = SSP_Data::$settings[ $pt.'_desc' ];
                }
                break;

            case $is_[ 'category' ] :

                $meta_description = get_term_meta(self::$obj->term_id, SSP_MetaBox::T_METANAME['description'], true);
                $description = $meta_description ?: SSP_Data::$settings[ 'cat_desc' ];
                break;

            case $is_[ 'tag' ] :
                $meta_description = get_term_meta(self::$obj->term_id, SSP_MetaBox::T_METANAME['description'], true);
                $description = $meta_description ?: SSP_Data::$settings[ 'tag_desc' ];
                break;

            case $is_[ 'tax' ] :
                $term = self::$obj->taxonomy;
                $description = SSP_Data::$settings[ $term.'_desc' ];
                break;

            case $is_[ 'pt_archive' ] :

                $description = SSP_Data::$settings[ 'pt_archive_desc' ];
                break;

            case $is_[ 'author' ] :

                $description = SSP_Data::$settings[ 'author_desc' ];
                break;

            case $is_[ 'date' ] :

                $description = SSP_Data::$settings[ 'date_desc' ];
                break;

            default :
                $description = SSP_Data::$settings[ 'home_desc' ];
                break;
        }

        $description = self::replace_snippets( $description );
        return apply_filters( 'ssp_output_description', $description );

    }


    /**
     * Generate the general ogp tags for the current page.
     * 
     * @return string     : OGP tags.
     */
    private static function generate_general_ogp( ) {

        $og_title  = apply_filters('ssp_output_og_title', self::$title );
        $og_desc   = apply_filters('ssp_output_og_description', self::$description );
        $og_url    = apply_filters('ssp_output_og_url', self::$canonical );

        $ogp  = "";
        $ogp .= '<meta property="og:title" content="'.esc_attr( $og_title ).'">'."\n";
        $ogp .= '<meta property="og:description" content="'.esc_attr( $og_desc ).'">'."\n";
        $ogp .= '<meta property="og:url" content="'.esc_attr( $og_url ).'">'."\n";
        $ogp .= '<meta property="og:site_name" content="'.esc_attr( SSP_Data::$site_title ).'">'."\n";

        return $ogp;

    }


    /**
     * Generate the canonical URL for the current page.
     * 
     * @param array $is_  : Results of Conditional tags.
     * @return string     : The canonical URL.
     */
    private static function generate_canonical( $is_ ) {

        switch ( true ) {

            case $is_[ 'top' ] :

                $canonical  = home_url();
                break;

            case $is_[ 'singular' ] :

                //is_home は default
                $canonical = get_permalink();
                break;

            case $is_[ 'tax' ] || $is_[ 'tag' ] || $is_[ 'category' ] :

                $term      = self::$obj;
                $term_link = get_term_link( $term, $term->taxonomy );
                $canonical = ( is_wp_error( $term_link ) ) ? "" : $term_link;
                break;

            case $is_[ 'pt_archive' ] :

                $post_type = get_query_var( 'post_type' );
                $post_type = ( is_array( $post_type ) ) ? reset( $post_type ) : $post_type ;
                $canonical = get_post_type_archive_link( $post_type );
                break;

            case $is_[ 'author' ] :

                $canonical = get_author_posts_url( get_query_var( 'author' ), get_query_var( 'author_name' ) );
                break;

            case $is_[ 'date' ] :

                if ( $is_[ 'day' ] ) {
                    $canonical = get_day_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) );
                }
                elseif ( $is_[ 'month' ] ) {
                    $canonical = get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) );
                }
                elseif ( $is_[ 'year' ] ) {
                    $canonical = get_year_link( get_query_var( 'year' ) );
                }
                break;

            case $is_[ 'search' ] :

                $canonical = get_search_link();
                break;

            case $is_[ '404' ] :

                $canonical =  home_url()."/404";
                break;

            default :

                $obj       = self::$obj;
                $canonical = get_permalink( $obj->ID );
                
                break;
        }

        return apply_filters( 'ssp_output_canonical', $canonical );
    }


    /**
     * Generate the og:type for the current page.
     * 
     * @return string     : The og:type.
     */
    private static function generate_og_type() {
        $og_type   = 'website';
        if ( SSP_Branch::$is_[ 'singular' ] ) {
            $og_type  = 'article';
        }
        return apply_filters( 'ssp_output_og_type', $og_type );
    }


    /**
     * Generate the og:image for the current page.
     * 投稿ページ：アイキャッチ画像を優先し、なければデフォルトのOG:Image画像
     * メディアページ：自身の画像URL
     * 
     * @return string     : The og:image url.
     */
    private static function generate_og_image() {
        $is_      = SSP_Branch::$is_;
        $og_image = SSP_Data::$ogp[ 'og_image' ];

        if( $is_['attachment'] ) {
            $og_image = self::$obj->guid;
        } elseif ( $is_[ 'singular' ] || ( ! $is_[ 'top' ] && $is_[ 'home' ] ) ) {

            if ( has_post_thumbnail( self::$obj->ID ) ) {
                $thumb_id  = get_post_thumbnail_id( self::$obj->ID );
                $thumb_url = wp_get_attachment_image_src( $thumb_id, 'full' );
                $og_image  = $thumb_url[0];
            }

            
        }
        return apply_filters( 'ssp_output_og_image', $og_image );
    }


    /**
     * Generate the og:locale for the current page.
     * 
     * @return string     : The og:locale.
     */
    private static function generate_og_locale() {

        $locale = get_locale();

        // Catch some weird locales served out by WP that are not easily doubled up.
        $fix_locales = array(
            'ca' => 'ca_ES',
            'en' => 'en_US',
            'el' => 'el_GR',
            'et' => 'et_EE',
            'ja' => 'ja_JP',
            'sq' => 'sq_AL',
            'uk' => 'uk_UA',
            'vi' => 'vi_VN',
            'zh' => 'zh_CN',
        );

        if ( isset( $fix_locales[ $locale ] ) ) {
            $locale = $fix_locales[ $locale ];
        }

        // Convert locales like "es" to "es_ES", in case that works for the given locale (sometimes it does).
        if ( strlen( $locale ) === 2 ) {
            $locale = strtolower( $locale ) . '_' . strtoupper( $locale );
        }

        // These are the locales FB supports.
        $fb_valid_fb_locales = array(
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
            'ca_ES', // Catalan.
            'cb_IQ', // Sorani Kurdish.
            'ck_US', // Cherokee.
            'co_FR', // Corsican.
            'cs_CZ', // Czech.
            'cx_PH', // Cebuano.
            'cy_GB', // Welsh.
            'da_DK', // Danish.
            'de_DE', // German.
            'el_GR', // Greek.
            'en_GB', // English (UK).
            'en_IN', // English (India).
            'en_PI', // English (Pirate).
            'en_UD', // English (Upside Down).
            'en_US', // English (US).
            'eo_EO', // Esperanto.
            'es_CL', // Spanish (Chile).
            'es_CO', // Spanish (Colombia).
            'es_ES', // Spanish (Spain).
            'es_LA', // Spanish.
            'es_MX', // Spanish (Mexico).
            'es_VE', // Spanish (Venezuela).
            'et_EE', // Estonian.
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
            'ja_JP', // Japanese.
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
            'sq_AL', // Albanian.
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
            'uk_UA', // Ukrainian.
            'ur_PK', // Urdu.
            'uz_UZ', // Uzbek.
            'vi_VN', // Vietnamese.
            'wo_SN', // Wolof.
            'xh_ZA', // Xhosa.
            'yi_DE', // Yiddish.
            'yo_NG', // Yoruba.
            'zh_CN', // Simplified Chinese (China).
            'zh_HK', // Traditional Chinese (Hong Kong).
            'zh_TW', // Traditional Chinese (Taiwan).
            'zu_ZA', // Zulu.
            'zz_TR', // Zazaki.
        );

        // Check to see if the locale is a valid FB one, if not, use en_US as a fallback.
        if ( ! in_array( $locale, $fb_valid_fb_locales, true ) ) {
            $locale = strtolower( substr( $locale, 0, 2 ) ) . '_' . strtoupper( substr( $locale, 0, 2 ) );
            if ( ! in_array( $locale, $fb_valid_fb_locales, true ) ) {
                $locale = 'en_US';
            }
        }

        return apply_filters( 'ssp_output_og_locale', $locale );

    }

    /**
     * Generate the og tags for facebook. for the current page.
     * 
     * @return string     : The og tags for facebook.
     */
    private static function generate_og_facebook() {

        if ( ! SSP_Data::$ogp[ 'fb_active' ] ) {
            return "";
        }

        $og_fb = "";

        $appid     =  apply_filters( 'ssp_output_fb_appid',  SSP_Data::$ogp[ 'fb_app_id' ] );
        $admins    =  apply_filters( 'ssp_output_fb_admins', SSP_Data::$ogp[ 'fb_admins' ] );
        $publisher =  apply_filters( 'ssp_output_fb_publisher',    SSP_Data::$ogp[ 'fb_url' ] );

        if( !empty( $appid )) {
            $og_fb .= '<meta property="fb:app_id" content="'.esc_attr( $appid ).'">'."\n";
        }
        if ( !empty( $admins )) {
            $og_fb .=  '<meta property="fb:admins" content="'.esc_attr( $admins ).'">'."\n";
        }
        if ( !empty( $publisher ) && self::$og_type === "article") {
            $og_fb .= '<meta property="article:publisher" content="'.esc_attr( $publisher ).'">'."\n";
        }

        return $og_fb;

    }


    /**
     * Generate the og tags for twitter. for the current page.
     * 
     * @return string     : The og tags for twitter.
     */
    private static function generate_og_twitter() {

        if ( ! SSP_Data::$ogp[ 'tw_active' ] ) {
            return "";
        }

        $og_tw = "";

        $tw_site = apply_filters( 'ssp_output_tw_site', SSP_Data::$ogp[ 'tw_account' ] );
        $tw_card = apply_filters( 'ssp_output_tw_card', SSP_Data::$ogp[ 'tw_card' ] );

        if( !empty( $tw_card ) ) {
            $og_tw .= '<meta name="twitter:card" content="'.esc_attr( $tw_card ).'">'."\n";
        }
        if( !empty( $tw_site ) ) {
            $og_tw .= '<meta name="twitter:site" content="'.esc_attr( $tw_site ).'">'."\n";
        }

        return $og_tw;
    }


    /**
     * Analytics and Webmaster code.
     * 
     * @return echo : code.
     */
    private static function output_codes() {
        
        //meta tags for webmaster tools
        if ( SSP_Branch::$is_['top'] ) {
            $webmaster_codes = [
                'webmaster_google' => 'google-site-verification',
                'webmaster_bing'   => 'msvalidate.01',
                'webmaster_baidu'  => 'baidu-site-verification',
                'webmaster_yandex' => 'yandex-verification',
            ];
            foreach ($webmaster_codes as $key => $name) {
                
                if ( SSP_Data::$settings[ $key ] ) {
                    echo '<meta name="', esc_attr( $name ),'" content="', esc_attr( SSP_Data::$settings[ $key ] ), '">', "\n";
                }
    
            }
        }


        //google analytics code
        if ( SSP_Data::$settings[ 'google_analytics_id' ] ) {
            $gaid = SSP_Data::$settings[ 'google_analytics_id' ];

            if ( SSP_Data::$settings[ 'google_analytics_type' ] === 'gtag' ) {

                echo "<!-- Global site tag (gtag.js) - Google Analytics -->\n",
                    "<script async src='https://www.googletagmanager.com/gtag/js?id=", esc_attr( $gaid ), "'></script>\n",
                    "<script>\n",
                        "window.dataLayer = window.dataLayer || [];\n",
                        "function gtag(){dataLayer.push(arguments);}\n",
                        "gtag('js', new Date());\n",
                        "gtag('config', '", esc_attr( $gaid ), "');\n",
                    "</script>\n";
                    
            } elseif ( SSP_Data::$settings[ 'google_analytics_type' ] === 'analytics' ) {

                echo "<!-- Google Analytics -->\n",
                "<script>\n",
                "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){\n",
                "(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\n",
                "m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\n",
                "})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');\n",
                
                "ga('create', '", esc_attr( $gaid ), "', 'auto');\n",
                "ga('send', 'pageview');\n",
                "</script>\n",
                "<!-- End Google Analytics -->\n";
                
            }
        }
    }

    /**
     * 
     * Replace snippets method for self::
     * 
     *   - %_site_title_%       : サイトのタイトル
     *   - %_phrase_%           : サイトのキャッチフレーズ 
     *   - %_site_description_% : サイトの説明文
     *   - %_page_title_%       : 投稿タイトル
     *   - %_description_%      : 投稿タイトル
     *   - %_cat_name_%         : カテゴリ名
     *   - %_tag_name_%         : タグ名
     *   - %_term_name_%        : ターム名
     *   - %_tax_name_%         : タクソノミー名
     *   - %_search_phrase_%    : 検索ワード
     *   - %_post_type_%        : 投稿タイプ
     *   - %_format_name_%      : 投稿フォーマット名
     *   - %_date_%             : Y年M月D日
     *   - %_author_name_%      : 著者名ニックネーム
     *   - %_sep_%              : 区切り文字
     * 
     */
    private static function replace_snippets ( $str ) {
        
        $obj = self::$obj;
        $is_ = SSP_Branch::$is_;
        $str = str_replace ( '%_site_title_%', SSP_Data::$site_title, $str );
        $str = str_replace ( '%_phrase_%', SSP_Data::$site_catch_phrase, $str );
        $str = str_replace ( '%_description_%', SSP_Data::$settings[ 'home_desc' ], $str );

        if ( $is_['singular'] || ( ! $is_[ 'top' ] && $is_[ 'home' ] ) ) {
            //タイトル
            $title = get_the_title( $obj->ID );
            $str   = str_replace ( '%_page_title_%', $title, $str );

            if ( strpos( $str, '%_page_contents_%' ) !== false ) {

                $content = $obj->post_content;
                $content = strip_shortcodes( strip_tags( $content ) );
                $content = str_replace(array("\r\n", "\r", "\n", "&nbsp;"), '', $content);  //改行削除
                // $content = htmlspecialchars( $content, ENT_QUOTES, 'UTF-8' );  //出力時にesc_
                $content = mb_substr( $content, 0, 300 );
                $str     = str_replace ( '%_page_contents_%', $content, $str );

            }

        } elseif ( $is_['category'] || $is_['tag'] || $is_['tax'] ) {
            //タームアーカイブ
            $str = str_replace ( array('%_cat_name_%','%_tag_name_%','%_term_name_%'), $obj->name, $str );
            $str = str_replace ('%_term_description_%', strip_shortcodes( $obj->description ), $str );

            if ( strpos( $str, '%_tax_name_%' ) !== false ) {

                $taxonomy_slug = ( isset( $obj->taxonomy ) ) ? $obj->taxonomy : "";
                $taxonomy_var = get_taxonomy($taxonomy_slug);
                $taxonomy_label = ( $taxonomy_var ) ? $taxonomy_var->label : "";

                $str = str_replace ( '%_tax_name_%', $taxonomy_label, $str );
            }

        } else {
            //その他のページ
            $obj_name  = ( isset( $obj->name ) ) ? $obj->name : "";
            $obj_label = ( isset( $obj->label ) ) ? $obj->label : "";

            $str = str_replace ( '%_post_type_%', $obj_label, $str );
            $str = str_replace ( '%_format_name_%', $obj_name, $str );

            if ( strpos( $str, '%_date_%' ) !== false ) {

                $date = "";
                if ( $is_['day'] ) {
                    $date = get_query_var( 'year' )."年".get_query_var( 'monthnum' )."月".get_query_var( 'day' )."日";
                }
                elseif ( $is_['month'] ) {
                    $date = get_query_var( 'year' )."年".get_query_var( 'monthnum' )."月";
                }
                elseif ( $is_['year'] ) {
                    $date = get_query_var( 'year' )."年";
                }

                $str = str_replace ('%_date_%', $date, $str);

            }

            if ( strpos( $str, '%_author_name_%' ) !== false ) {


                $str = str_replace ( '%_author_name_%', get_user_meta( $obj->ID, 'nickname', true ), $str );

            }

            if ( strpos( $str, '%_search_phrase_%' ) !== false ) {

                $str = str_replace ( '%_search_phrase_%', get_search_query(), $str );

            }
        }

        if ( strpos( $str, '%_sep_%' ) !== false ) {

            $sep_key = SSP_Data::$settings[ 'separator' ];
            $sep_val = SSP_Data::SEPARATOR_LIST[$sep_key];
            $str     = str_replace( '%_sep_%', $sep_val, $str );

        }

        return $str;
    }

}
