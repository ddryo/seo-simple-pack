<?php

class SSP_Activate {

    /**
     * 外部からのインスタンス化を防ぐ
     */
    private function __construct() {}


    /**
     * プラグイン有効化時の処理
     * Function for the plugin activated.
     */
    public static function plugin_activate() {

        if ( get_option( SSP_Data::DB_NAME[ 'installed' ] ) === false ) {

            //初回 or 再インストール時 : デフォルト設定取得
            $SSP_settings = SSP_Data::DEFAULT_SETTINGS;
            $SSP_ogp      = SSP_Data::DEFAULT_OGP;

            update_option( SSP_Data::DB_NAME[ 'installed' ], 1 );
            // update_option( SSP_Data::DB_NAME[ 'notification' ], 'hide' );

            //DB更新
            update_option( SSP_Data::DB_NAME[ 'settings' ], $SSP_settings );
            update_option( SSP_Data::DB_NAME[ 'ogp' ], $SSP_ogp );

        } else {

            //データが残っている場合 : 既存設定取得
            // $SSP_settings = get_option( SSP_Data::DB_NAME[ 'settings' ] );
            // $SSP_ogp      = get_option( SSP_Data::DB_NAME[ 'ogp' ] );

        }
    }


    /**
     * プラグイン停止時の処理
     * Function for the plugin deactivated.
     */
    public static function plugin_deactivate() {}


    /**
     * プラグインアンインストール時の処理
     * Function for the plugin uninstalled.
     */
    public static function plugin_uninstall() {
        foreach ( SSP_Data::DB_NAME as $db_name ) {
            delete_option( $db_name );
        }
    }

}
