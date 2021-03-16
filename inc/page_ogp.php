<?php

/* phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotValidated */
/* phpcs:disable WordPress.Security.NonceVerification.Missing */

$is_updated = false;

if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['is_setting_form'] ) ) {

	// $_POSTの無害化
	$P = SSP_Utility::sanitize_post_data( $_POST );

	// DBアップデート処理
	SSP_Utility::update_db( $P );

	// クラスインスタンス更新（更新後の情報をセット）
	SSP_Data::$ogp = get_option( SSP_Data::DB_NAME['ogp'] );

	$is_updated = true;
}

?>
<div class="ssp-page wrap">
	<h1 class="ssp-page__title">
		<?=esc_html__( 'OGP settings', 'loos-ssp' )?>
	</h1>
	<hr class="wp-header-end">
	<?php if ( $is_updated )  self::output_saved_message(); ?>
	<div class="ssp-page__tabs">
		<div class="nav-tab-wrapper">
			<?php self::output_setting_tab( SSP_Menu::$ogp_menu_tabs ); ?>
		</div>
	</div>
	<div class="ssp-page__body">
		<form action="" method="post" id="ssp_form" accept-charset="UTF-8">
			<?php
				// nonce
				wp_nonce_field( SSP_Data::NONCE_ACTION, SSP_Data::NONCE_NAME );

				// タブコンテンツ
				self::output_setting_tab_content( SSP_Menu::$ogp_menu_tabs, 'ogp' );
			?>
			<input type="hidden" name="is_setting_form" value="1">
			<input type="hidden" name="db_name" value="<?php echo esc_attr( SSP_Data::DB_NAME['ogp'] ); ?>">
			<button type="submit" class="button button-primary"><?=esc_html__( 'Save settings', 'loos-ssp' )?></button>
		</form>
	</div>
</div>
