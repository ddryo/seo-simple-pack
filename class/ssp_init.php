<?php

class SSP_Init {

    /**
     * The constructor
     */
    public function __construct() {

        SSP_Menu::init();
        $this->set_ssp_data();
        $this->set_hooks();
        SSP_MetaBox::init();

        //$this->set_notification(); //OFF中

    }

    /**
     * 基本データの初期化処理
     */
    private function set_ssp_data() {

        //サイト基本情報取得
        SSP_Data::$site_title        = esc_html( get_option( 'blogname' ) );
        SSP_Data::$site_catch_phrase = esc_html( get_option( 'blogdescription' ) );

        // 一般設定データ
        $db_ssp_settings = get_option( SSP_Data::DB_NAME[ 'settings' ] ) ?: [];
        SSP_Data::$settings = array_merge( SSP_Data::DEFAULT_SETTINGS, $db_ssp_settings );

        // OGPせ設定
        $db_ssp_ogp = get_option( SSP_Data::DB_NAME[ 'ogp' ] ) ?: [];
        SSP_Data::$ogp = array_merge( SSP_Data::DEFAULT_OGP, $db_ssp_ogp );

    }

    /**
     * アクションフックの登録
     */
    private function set_hooks() {

        add_action( 'init', [ 'SSP_Methods', 'add_custom_settings' ] , 999);
        add_action( 'wp', [ 'SSP_Methods', 'set_branch' ], 1 );
        add_action( 'admin_enqueue_scripts', [ 'SSP_Methods', 'include_files' ] );
        add_action( 'admin_menu', ['SSP_Menu', 'add_menus'] );
        add_action( 'wp_head', [ 'SSP_Output', 'main' ], 10 );
        add_action( 'template_redirect', [ 'SSP_Methods', 'redirect' ], 1 );

        //titleタグの除去
        remove_action('wp_head', '_wp_render_title_tag', 1);

    }

    /**
     * 更新に関する通知 :: 〜OFF中〜
     */
    private function set_notification() {

        /**
         * プラグイン更新時
         */
        if ( get_option( SSP_Data::DB_NAME[ 'notification' ] ) !== 'hide' ) {
            update_option( SSP_Data::DB_NAME[ 'notification' ], 'show' );
        }

        if ( isset($_POST['ssp_notice_close'] ) ) {
            //CLOSEボタン押されたら
            update_option( SSP_Data::DB_NAME[ 'notification' ], 'hide' );
        }

        // 以前から使用中の方へ向けてのメッセージ
        $notification_db = get_option( SSP_Data::DB_NAME[ 'notification' ] );
        if( $notification_db === 'show' ) {
            add_action( 'admin_notices', function() {
                ?>
                    <div class="notice notice-error ssp_notice">
                        <p>
                            <b>[ SEO SIMPLE PACK 更新に伴うお知らせ ]</b><br>
                            個別ページごとの <code>meta robots</code> の設定方法が新しくなりました！<br>
                            以前のバージョンで個別設定をしていた場合は、お手数ですが再度設定をお願いいたします。
                        </p>
                        <form action="" method="post">
                            <button type="submit" name="ssp_notice_close" class="notice-dismiss"><span>この通知を非表示にする</span></button>
                        </form>
                    </div>
                <?php
            } );
        }

    }

}
