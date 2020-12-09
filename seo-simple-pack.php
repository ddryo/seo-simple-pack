<?php
/**
 * Plugin Name: SEO SIMPLE PACK
 * Plugin URI: https://wemo.tech/1670
 * Description: A simple SEO plugin. Meta tags and OGP tags can be easily set and customized for each page type and post.
 * Version: 1.3.1
 * Author: LOOS WEB STUDIO
 * Author URI: https://loos-web-studio.com/
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: loos-ssp
 */
defined( 'ABSPATH' ) || exit;

/**
 * 定数宣言
 */
if ( ! defined( 'SSP_VERSION' ) ) {
	define( 'SSP_VERSION', ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? date_i18n( 'mdGis' ) : '1.3.1' );
}
if ( ! defined( 'SSP_PATH' ) ) {
	define( 'SSP_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'SSP_URL' ) ) {
	define( 'SSP_URL', plugins_url( '/', __FILE__ ) );
}


/**
 * 翻訳ファイルを登録 ( 自前の翻訳ファイルを読み込む )
 */
if ( 'ja' === determine_locale() ) {
	load_textdomain( 'loos-ssp', SSP_PATH . 'languages/loos-ssp-ja.mo' );
} else {
	load_plugin_textdomain( 'loos-ssp' );
}


/**
 * Reading class files
 */
require_once SSP_PATH . 'class/utility.php';
require_once SSP_PATH . 'class/data.php';
require_once SSP_PATH . 'class/hooks.php';
require_once SSP_PATH . 'class/menu.php';
require_once SSP_PATH . 'class/methods.php';
require_once SSP_PATH . 'class/output.php';
require_once SSP_PATH . 'class/metabox.php';
require_once SSP_PATH . 'class/activate.php';


/**
 * Activation hooks
 */
register_activation_hook( __FILE__, ['SSP_Activate', 'plugin_activate' ] );
register_deactivation_hook( __FILE__, ['SSP_Activate', 'plugin_deactivate' ] );
register_uninstall_hook( __FILE__, ['SSP_Activate', 'plugin_uninstall' ] );


/**
 * Main class
 */
class SEO_SIMPLE_PACK {
	public function __construct() {
		SSP_Data::init();
		SSP_Hooks::init();
		SSP_Menu::init();
		SSP_MetaBox::init();
		SSP_Output::init();
	}
}


/**
 * Run SEO_SIMPLE_PACK
 */
add_action( 'plugins_loaded', function() {
	new SEO_SIMPLE_PACK();
} );
