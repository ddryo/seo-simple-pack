<?php
/**
 * Plugin Name: SEO SIMPLE PACK
 * Plugin URI: https://wemo.tech/1670
 * Description: A simple SEO plugin. Meta tags and OGP tags can be easily set and customized for each page type and post.
 * Version: 1.2.8
 * Author: LOOS WEB STUDIO
 * Author URI: https://loos-web-studio.com/
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: loos-ssp
*/

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * PHPバージョン5.6以上のみ使用可能の警告
 */
$phpver = phpversion();
if ( (double) $phpver < 5.6 ) {
    add_action( 'admin_notices', function() { ?>
        <div class="notice notice-error is-dismissible">
            <p>
                <b>[ SEO SIMPLE PACK ]</b><br>
                This Plugin is available in PHP since version 5.6 ! <br> (Your PHP is ver. <?php echo phpversion(); ?> )
            </p>
        </div> <?php
    } );
    return;
}


/**
 * 定数宣言
 */
if ( ! defined( 'SSP_VERSION' ) ) {
    define( 'SSP_VERSION', ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? date('mdGis') : '1.2.8');
}
if ( ! defined( 'SSP_FILE' ) ) {
    define( 'SSP_FILE', __FILE__ );
}
if ( ! defined( 'SSP_PATH' ) ) {
    define( 'SSP_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'SSP_BASENAME' ) ) {
    define( 'SSP_BASENAME', plugin_basename( SSP_FILE ) );
}
if ( ! defined( 'SSP_URL' ) ) {
    define( 'SSP_URL', plugins_url( '/', __FILE__ ) );
}


/**
 * 翻訳用のテキストドメインを定義
 */
if ( ! defined( 'LOOS_SSP_DOMAIN' ) ) {
    define( 'LOOS_SSP_DOMAIN', 'loos-ssp' );
}


/**
 * 翻訳ファイルを登録 ( 自前の翻訳ファイルを読み込む )
 */
load_textdomain( LOOS_SSP_DOMAIN, SSP_PATH . 'languages/loos-ssp-ja.mo');
// load_plugin_textdomain( LOOS_SSP_DOMAIN, false, basename( SSP_PATH ) .'/languages' );


/**
 * CLASSファイルの読み込み
 */
require_once SSP_PATH . 'class/ssp_data.php';
require_once SSP_PATH . 'class/ssp_branch.php';
require_once SSP_PATH . 'class/ssp_init.php';
require_once SSP_PATH . 'class/ssp_menu.php';
require_once SSP_PATH . 'class/ssp_methods.php';
require_once SSP_PATH . 'class/ssp_output.php';
require_once SSP_PATH . 'class/ssp_metabox.php';
require_once SSP_PATH . 'class/ssp_activate.php';


/**
 * アクティベーションフック
 */
register_activation_hook( SSP_FILE, array('SSP_Activate', 'plugin_activate') );
register_deactivation_hook( SSP_FILE, array('SSP_Activate', 'plugin_deactivate') );
register_uninstall_hook( SSP_FILE, array('SSP_Activate', 'plugin_uninstall') );


/**
 * SSP Init
 */
new SSP_Init();
