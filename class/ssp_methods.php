<?php

class SSP_Methods {

    /**
     * 外部からのインスタンス化を防ぐ
     */
    private function __construct() {}


    /**
     * デバッグ用
     */
    public static function dump( $data, $str = "" ) {

        echo '<div class="dev_area">';
            echo '<p>'.$str.'</p>';
            var_dump($data);
        echo '</div>';
    }


    /**
     * カスタム投稿タイプ・タクソノミー用の設定を追加
     */
    public static function add_custom_settings () {

        if( !is_admin() ) {
            return;
        }

        $added_new_data = false;
        $args           = [ 'public' => true, '_builtin' => false ];
        $post_types     = get_post_types( $args, 'names', 'and' );
        $taxonomies     = get_taxonomies( $args, 'names', 'and' );

        //カスタム投稿 settings 追加
        foreach ( $post_types as $pt ) {
            if ( !isset( SSP_Data::$settings[ $pt.'_noindex' ] ) ) {
                SSP_Data::$settings[ $pt.'_noindex' ] = SSP_Data::DEFAULT_PT_SETTING[ 'noindex' ];
                SSP_Data::$settings[ $pt.'_title' ]   = SSP_Data::DEFAULT_PT_SETTING[ 'title' ];
                SSP_Data::$settings[ $pt.'_desc' ]    = SSP_Data::DEFAULT_PT_SETTING[ 'desc' ];
                $added_new_data = true;
            }
        }

        //カスタムタクソノミー settings 追加
        foreach ( $taxonomies as $tax ) {
            if ( !isset( SSP_Data::$settings[ $tax.'_noindex' ] ) ) {
                SSP_Data::$settings[ $tax.'_noindex' ] = SSP_Data::DEFAULT_TAX_SETTING[ 'noindex' ];
                SSP_Data::$settings[ $tax.'_title' ]   = SSP_Data::DEFAULT_TAX_SETTING[ 'title' ];
                SSP_Data::$settings[ $tax.'_desc' ]    = SSP_Data::DEFAULT_TAX_SETTING[ 'desc' ];
                $added_new_data = true;
            }
        }

        //新規追加項目があった場合
        if ( $added_new_data ) {
            update_option( SSP_Data::DB_NAME['settings'], SSP_Data::$settings );
        }

        return;
    }


    /**
     * 条件分岐タグの結果を変数に代入
     */
    public static function set_branch() {

            SSP_Branch::$is_ = [
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
                SSP_Branch::$is_['top'] = true;
            } elseif ( is_home() ) {
                if ( get_queried_object_id() === 0) {
                    SSP_Branch::$is_['top'] = true;
                } else {
                    SSP_Branch::$is_['top'] = false;
                }
            } else {
                SSP_Branch::$is_['top'] = false;
            }
    }


    /**
     *  CSS Scriptの読み込み
     */
    public static function include_files( $hook_suffix ) {

        $is_editor_page = 'post.php' === $hook_suffix || 'post-new.php' === $hook_suffix;
        $is_ssp_page = false !== strpos( $hook_suffix, 'ssp_' );

        if ( $is_ssp_page ) {

            wp_enqueue_media();
            wp_enqueue_script(
                'ssp-script',
                plugins_url( 'assets/js/ssp.js', SSP_FILE ),
                array('jquery'),
                SSP_VERSION,
                true
            );

        }

        // 設定ページだけでなく編集画面でも読み込みたい
        if ( $is_editor_page || $is_ssp_page ) {
            wp_enqueue_script(
                'ssp-common-script',
                plugins_url( 'assets/js/ssp_common.js', SSP_FILE ),
                array('jquery'),
                SSP_VERSION,
                true
            );
            wp_enqueue_style(
                'ssp-css',
                plugins_url( "assets/css/ssp.css", SSP_FILE ),
                array(),
                SSP_VERSION
            );
        }
    }


    /**
     *  使用しないページのリダイレクト処理
     */
    public static function redirect( $page ) {

        $home = home_url();

        if ( SSP_Branch::$is_['author'] && SSP_Data::$settings['author_disable'] ) {
            wp_safe_redirect($home);
            exit;
        }
        if ( SSP_Branch::$is_['tax'] && SSP_Data::$settings['post_format_disable'] ) {
            if (get_queried_object()->taxonomy === 'post_format') {
                wp_safe_redirect($home);
                exit;
            };
        }
        if ( SSP_Branch::$is_['attachment'] && SSP_Data::$settings['attachment_disable'] ) {
            wp_safe_redirect(get_post()->guid);
            exit;
        }
    }


    /**
     * プレビュー機能用のスニペット変換
     */
    public static function replace_snippets_forpv ( $str ) {

        $str = str_replace ('%_site_title_%', '<span>'.esc_html( SSP_Data::$site_title ).'</span>', $str);
        $str = str_replace ('%_phrase_%', '<span>'.esc_html( SSP_Data::$site_catch_phrase ).'</span>', $str);
        $str = str_replace ('%_description_%', esc_html( SSP_Data::$settings[ 'home_desc' ] ), $str);
        $str = str_replace ('%_page_title_%', '<span>投稿タイトル</span>', $str);
        $str = str_replace ('%_cat_name_%', '<span>カテゴリー名</span>', $str);
        $str = str_replace ('%_tag_name_%', '<span>タグ名</span>', $str);
        $str = str_replace ('%_term_name_%', '<span>ターム名</span>', $str);
        $str = str_replace ('%_tax_name_%', '<span>タクソノミー名</span>', $str);
        $str = str_replace ('%_author_name_%', '<span>著者名(ニックネーム)</span>', $str);
        $str = str_replace ('%_search_phrase_%', '<span>検索ワード</span>', $str);
        $str = str_replace ('%_post_type_%', '<span>投稿タイプ名</span>', $str);
        $str = str_replace ('%_page_contents_%', '<span>投稿コンテンツ</span>', $str);
        $str = str_replace ('%_date_%', '<span>日付</span>', $str);
        $str = str_replace ('%_format_name_%', '<span>フォーマット名</span>', $str);
        $str = str_replace ('%_term_description_%', '<span>タームの説明</span>', $str);
        

        if (strpos($str, '%_sep_%') !== false) {

            $sep_key = SSP_Data::$settings[ 'separator' ];
            $sep_val = SSP_Data::SEPARATOR_LIST[$sep_key];
            $str     = str_replace ('%_sep_%', '<span>'.$sep_val.'</span>', $str);

        }

        return $str;
    }

    /**
     * データを無害化して返す
     */
    public static function sanitize_post_data( $data ) {

        foreach ($data as $key => $val) {

            if ( $val === "" ) {
                continue;
            }

            // "1" , "0" => bool
            $bool_val = filter_var( $val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE );

            if ( $bool_val === null ) {

                $val = sanitize_text_field( $val );
                $val = stripslashes( $val );
                $data[ $key ] = $val;

            } else {

                $data[ $key ] = $bool_val;

            }
        }

        return $data;
    }

    /**
     * 設定更新時のDB更新処理
     */
    public static function update_db( $P ) {

        if ( empty( $P ) ) {
            exit( 'POST data was not found' );
        }

        //Check my nounce key.
        check_admin_referer( SSP_Data::NOUNCE_ACTION, SSP_Data::NOUNCE_NAME );

        //Get DB name.
        $db_name = $P[ 'db_name' ];

        //SSP用のデータベースが登録されていなければ exit 
        if ( !in_array( $db_name, SSP_Data::DB_NAME ) ) {
            exit( 'DataBase was not found' );
        }
        
        //Get DB 設定可能なデータのリストを取得
        //$db_data = get_option( $db_name );
        if ( $db_name === SSP_Data::DB_NAME['settings'] ) {

            // $db_data_key = array_keys( SSP_Data::DEFAULT_SETTINGS );
            $db_data_key = array_keys( SSP_Data::$settings );

        } elseif ( $db_name === SSP_Data::DB_NAME['ogp'] ) {

            // $db_data_key = array_keys( SSP_Data::DEFAULT_OGP );
            $db_data_key = array_keys( SSP_Data::$ogp );
            
        } else {

            exit( 'DataBase was not found' );

        }

        //Delete unexpected data form the POST data.
        //設定可能なデータだけを抽出 (送信ボタンのデータなどは削除)
        foreach ( $P as $key => $v ) {

            if ( !in_array( $key, $db_data_key) ) {

                unset( $P[ $key ] );

            }
        }

        //Update DB.
        update_option( $db_name, $P );
    }


    /**
     * 管理画面メニューのテーブル内容を出力する
     */
    public static function output_table_rows( $table_rows, $db_name = null) {

        if ( $db_name === "ogp") {

            $db = SSP_Data::$ogp;

        } else {

            $db = SSP_Data::$settings;

        }

        foreach ( $table_rows as $key => $row ) {

            $data_disable = "";

            if( $row['is_checkbox'] ) {

                if ( strpos( $key, '_disable' ) !== false ) {
                    $data_disable = 'data-disable="'.(int) $db[$key].'"';
                }

                $form_item = '<span>はい</span><label class="ssp_switch_box" for="'.$key.'">';

                $form_item .= $db[ $key ]
                                ? '<input type="checkbox" name="" id="'.$key.'" checked>'
                                : '<input type="checkbox" name="" id="'.$key.'">';
                $form_item .= '<span class="ssp_switch_box__slider -round"></span></label><span>いいえ</span>';
                $form_item .= '<input type="hidden" name="'.$key.'" value="'.esc_attr( $db[$key] ).'">';

            } else {

                $form_item = $row['item'] ?:
                    '<input type="text" name="'.$key.'" id="'.'.$key.'.'"value="'.esc_attr( $db[$key] ).'">';

            }

            if ( strpos( $key, "_desc" ) ) {
                $trclass = "tr_desc";
            } else {
                $trclass = "tr";
            }

            echo '<tr class="', $trclass ,'" valign="top" ', $data_disable, '><th scope="row">',
                    '<label for="'.$key.'">', $row['title'], '</label>',
                    $row['reqired'] ? '<span class="required">*</span>' : "" ,
                '</th>',

                '<td>',
                    '<div class="inner ', $row['class'], '">',

                        '<div class="ssp_item">', $form_item, '</div>',
                        '<div class="ssp_desc">
                            <p>', $row['desc'], '</p>',
                        '</div>',
                        $row['prev'] ? 
                                '<div class="ssp_prev">┗ '. __( 'Preview', LOOS_SSP_DOMAIN ) .' : <p>'.
                                    SSP_Methods::replace_snippets_forpv( esc_html( $db[ $key ] ) ).
                                '</p><a href="' . admin_url() . 'admin.php?page=ssp_help" target="_blank" title="使用可能なスニペットタグについて" class="ssp_help">?</a></div>' 
                            : "",
                    '</div>',
                '</td>',
            '</tr>';
        }
    }
}

