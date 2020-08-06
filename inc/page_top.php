<?php 
    $is_updated = false;

    if ( $_SERVER['REQUEST_METHOD'] === 'POST' && !empty( $_POST ) && !isset( $_POST['ssp_notice_close'] ) ) {

        //$_POSTの無害化
        $P = SSP_Methods::sanitize_post_data( $_POST );

        //DBアップデート処理
        SSP_Methods::update_db( $P );

        $is_updated = true;

        //クラスインスタンス更新
        SSP_Data::$settings = get_option( SSP_Data::DB_NAME[ 'settings' ] );

    }

    $ssp_tab = SSP_Menu::$TOP_MENU_TABS;
 ?>
<div id="ssp_wrap" class="wrapp">

    <h1 id="ssp_title">SEO SIMPLE PACK <?=__('General settings', LOOS_SSP_DOMAIN )?></h1>
    <?php 
        if ( $is_updated ) {
            echo '<div id="ssp_updated" class="updated notice is-dismissible">'.
                '<p><strong>'. __('Your settings have been saved.'. LOOS_SSP_DOMAIN ) .'</strong></p>'.
                    '<button type="button" class="notice-dismiss">'.
                        '<span class="screen-reader-text">'. __('Hide this notification.', LOOS_SSP_DOMAIN ) .'</span>'.
                    '</button>'.
                '</div>';
        }
    ?>
    <div id="ssp-tabs" class="nav-tab-wrapper">
        <?php 
            foreach ( $ssp_tab as $key => $val ) {

                $nav_class = ( $val === reset( $ssp_tab ) ) ? 'nav-tab act_' : 'nav-tab';
                echo '<a href="#' . $key . '" class="' . $nav_class . '">' . $val . '</a>';

            }
        ?>
    </div>
    <div id="poststuff">
        <form action="" method="post" id="ssp_form" accept-charset="UTF-8">
            <?php 
                foreach ( $ssp_tab as $key => $val ) {

                    $tab_class = ( $val === reset( $ssp_tab ) ) ? "tab-contents act_" : "tab-contents";
                    echo '<div id="' . $key . '" class="' . $tab_class . '">';

                        //タブコンテンツ用ファイルの読み込み
                        if ( file_exists( SSP_PATH.'inc/parts/tab_'.$key.'.php' ) ) {

                            require_once SSP_PATH.'inc/parts/tab_'.$key.'.php';

                        }

                    echo '</div>';
                }
            ?>
            <input type="hidden" name="db_name" value="<?php echo esc_attr( SSP_Data::DB_NAME['settings'] ); ?>">
            <?php wp_nonce_field( SSP_Data::NOUNCE_ACTION, SSP_Data::NOUNCE_NAME ); ?>
            <button type="submit" class="button button-primary"><?=__( 'Save settings', LOOS_SSP_DOMAIN )?></button>
        </form>
    </div>
</div>


