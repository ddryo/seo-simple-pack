<?php



class SSP_Menu {


    /**
     * サブメニュー「OGP設定」
     */
    private static $OGP_MENU;

    /**
     * トップメニューに表示するタブコンテンツ
     */
    private static $TOP_MENU_TABS;


    /**
     * OGPメニューに表示するタブコンテンツ
     */
    private static $OGP_MENU_TABS;


    /**
     * 外部からのインスタンス化を防ぐ
     */
    private function __construct() {}


    /**
     * init
     */
    public static function init() {

        self::$OGP_MENU = [
            'parent_slug' => 'ssp_main_setting',
            'page_title'  => __('OGP settings', LOOS_SSP_DOMAIN ), //'OGP設定',
            'menu_title'  => __('OGP settings', LOOS_SSP_DOMAIN ), //'OGP設定',
            'capability'  => 'administrator',
            'menu_slug'   => 'ssp_ogp_setting',
            'function'    => ['SSP_Menu','ssp_ogp_menu']
        ];

        self::$TOP_MENU_TABS = [
            'basic'     => __('Basic setting', LOOS_SSP_DOMAIN ), // 基本設定
            'post_type' => __('Post page', LOOS_SSP_DOMAIN ), // 投稿ページ
            'taxonomy'  => __('Taxonomy archive', LOOS_SSP_DOMAIN ), // タクソノミーアーカイブ
            'archive'   => __('Other archives', LOOS_SSP_DOMAIN ), // その他アーカイブ
            'analytics' => __('Google Analytics', LOOS_SSP_DOMAIN ), // Googleアナリティクス
            'webmaster' => __('Webmaster tools', LOOS_SSP_DOMAIN ), // ウェブマスターツール
        ];

        self::$OGP_MENU_TABS = [
            'ogp'     => __('Basic setting', LOOS_SSP_DOMAIN ), //基本設定
            'facebook' => 'Facebook',
            'twitter'  => 'Twitter',
        ];
    }


    /**
     * トップレベルメニューの設定
     */
    const TOP_MENU = [
        'page_title' => 'SEO PACK', //ページのタイトルタグに表示されるテキスト
        'menu_title' => 'SEO PACK', //メニュータイトル
        'capability' => 'manage_options', //必要な権限
        'menu_slug' => 'ssp_main_setting', //このメニューを参照するスラッグ名
        'function' => ['SSP_Menu','ssp_top_menu'], //呼び出す関数名
        //'icon_url' => SSP_URL.'assets/img/noimg.gif',      //アイコンURL
        'icon_url' => 'dashicons-list-view', //アイコンURL
        'position' => 81 //管理画面での表示位置
    ];


    

    /**
     * サブメニュー「HELP」の設定
     */
    const HELP_MENU = [
        'parent_slug' => 'ssp_main_setting',
        'page_title'  => 'HELP',
        'menu_title'  => 'HELP',
        'capability'  => 'administrator',
        'menu_slug'   => 'ssp_help',
        'function'    => ['SSP_Menu','ssp_help_menu']
    ];


    /**
     * メニューの追加
     */
    public static function add_menus() {
        //トップレベルメニュー
        add_menu_page(
            self::TOP_MENU['page_title'],
            self::TOP_MENU['menu_title'],
            self::TOP_MENU['capability'],
            self::TOP_MENU['menu_slug'],
            self::TOP_MENU['function'],
            self::TOP_MENU['icon_url'],
            self::TOP_MENU['position']
        );

        //トップレベルメニュークリック時の表示
        add_submenu_page(
            self::TOP_MENU['menu_slug'],
            self::TOP_MENU['menu_title'],
            __('General settings', LOOS_SSP_DOMAIN ), //サブ側の名前
            'administrator',       //権限
            self::TOP_MENU['menu_slug'],
            self::TOP_MENU['function']  //親と同じ関数を呼び出す
        );

        //サブメニュー SNS
        add_submenu_page(
            self::$OGP_MENU['parent_slug'],
            self::$OGP_MENU['page_title'],
            self::$OGP_MENU['menu_title'],
            self::$OGP_MENU['capability'],
            self::$OGP_MENU['menu_slug'],
            self::$OGP_MENU['function']
        );

        //サブメニュー HELP
        add_submenu_page(
            self::HELP_MENU['parent_slug'],
            self::HELP_MENU['page_title'],
            self::HELP_MENU['menu_title'],
            self::HELP_MENU['capability'],
            self::HELP_MENU['menu_slug'],
            self::HELP_MENU['function']
        );
    }


    /**
     * トップレベルメニュー 内容
     */
    public static function ssp_top_menu() {
        require_once SSP_PATH.'inc/page_top.php';
    }

    //サブメニュー [OGP] 内容
    public static function ssp_ogp_menu() {
        require_once SSP_PATH.'inc/page_ogp.php';
    }

    //サブメニュー [HELP] 内容
    public static function ssp_help_menu() {
        //require_once SSP_PATH.'inc/page_ogp.php';
        require_once SSP_PATH.'inc/page_help.php';
    }

}

