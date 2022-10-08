<?php
/**
 * 設定フィールド出力用のtrait
 */
namespace SSP;

// phpcs:disable WordPress.WP.EnqueuedResources.NonEnqueuedScript
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
trait Field {

	/**
	 * 外部からのインスタンス化を防ぐ
	 */
	private function __construct() {}

	/**
	 *  設定セクションの出力
	 */
	public static function output_section( $title, $table_rows, $db_name = null ) {

		if ( 'ogp' === $db_name ) {
			$db = \SSP_Data::$ogp;
		} else {
			$db = \SSP_Data::$settings;
		}

	?>
		<div class="ssp-page__section">
			<h2 class="ssp-page__section__title">
				<?=esc_html( $title )?>
			</h2>
			<div class="ssp-page__section__body">
				<?php
					foreach ( $table_rows as $name => $args ) :
					$now_value = isset( $db[ $name ] ) ? $db[ $name ] : '';
					self::output_field( $name, $args, $now_value );
					endforeach;
				?>
			</div>
		</div>
	<?php
	}


	/**
	 * 旧スニペット名を置換
	 */
	public static function replace_old_snipets( $str ) {
		// 旧スニペット名を置換
		$str = str_replace( '%_cat_name_%', '%_term_name_%', $str );
		$str = str_replace( '%_tag_name_%', '%_term_name_%', $str );
		$str = str_replace( '%_format_name_%', '%_term_name_%', $str );
		$str = str_replace( '%_phrase_%', '%_tagline_%', $str );
		$str = str_replace( '%_description_%', '%_front_description_%', $str );

		return $str;
	}


	/**
	 * 各設定項目を出力する
	 */
	public static function output_field( $field_name, $args, $field_value ) {

		$args = array_merge( [
			'title'       => '',
			'reqired'     => false,
			'class'       => '',
			'type'        => 'text',
			'preview'     => false,
			'desc'        => '',
			'choices'     => [],
			'label'       => '',
			'item'        => '',
		], $args );

		$field_value = self::replace_old_snipets( $field_value );

		$add_data = '';
		if ( strpos( $field_name, '_disable' ) !== false ) {
			$add_data = ' data-disable="' . esc_attr( (int) $field_value ) . '"';
		} elseif ( strpos( $field_name, 'tw_active' ) !== false || strpos( $field_name, 'fb_active' ) !== false ) {
			$add_data = ' data-active="' . esc_attr( (int) $field_value ) . '"';
		}

		// if ( $args['reqired'] ) {
		// 	$table_title .= '<span class="required">*</span>';
		// }

		?>
			<div class="ssp-field"<?=$add_data?>>
				<?php if ( $args['title'] ) : ?>
					<label for="<?=esc_attr( $field_name )?>" class="ssp-field__title">
						<?=esc_html( $args['title'] ) ?>
					</label>
				<?php endif; ?>
				<div class="<?=esc_attr( trim( 'ssp-field__body ' . $args['class'] ) )?>">
					<div class="ssp_item ssp-field__item -<?=$args['type']?>">
						<?php
							if ( $args['item'] ) :
							echo $args['item'];
							else :
								self::the_setting_field( $field_name, $field_value, $args );
							endif;
						?>
					</div>
					<div class="ssp_desc ssp-field__desc">
						<p><?=$args['desc']?></p>
					</div>
					<?php if ( $args['preview'] ) : ?>
						<div class="ssp-field__preview">
						┗ <span class="ssp-field__preview__label">
								<?=esc_html__( 'Preview', 'loos-ssp' )?> : 
							</span>
							<div class="ssp-field__preview__content">
								<?=wp_kses_post( self::replace_snippets_forpv( $field_value ) )?>
							</div>
							<a href="<?=esc_url( admin_url( 'admin.php?page=ssp_help' ) )?>" target="_blank" title="<?=esc_html__( 'About available snippet tags', 'loos-ssp' )?>" class="ssp-helpButton">?</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php
	}


	/**
	 * 設定フィールドを取得
	 */
	public static function the_setting_field( $field_name, $field_value, $args ) {

		$type = $args['type'];

		if ( 'text' === $type ) {

			self::text_input( $field_name, $field_value );

		} elseif ( 'checkbox' === $type ) {

			self::checkbox( $field_name, $field_value, $args['label'] );

		} elseif ( 'switch' === $type ) {

			self::switch_box( $field_name, $field_value );

		} elseif ( 'select' === $type ) {

			self::select_box( $field_name, $field_value, $args['choices'] );

		} if ( 'radio_btn' === $type ) {

			self::radio_btns( $field_name, $field_value, $args['choices'] );

		} if ( 'media' === $type ) {

			self::media_btns( $field_name, $field_value );

		} elseif ( 'textarea' === $type ) {

			self::textarea( $field_name, $field_value );

		}
	}


	/**
	 * text_input
	 */
	public static function text_input( $name, $value ) {
		echo '<input type="text" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '">';
	}


	/**
	 * textarea
	 */
	public static function textarea( $name, $value, $rows = '4' ) {
		echo '<textarea name="' . esc_attr( $name ) . '" rows="' . esc_attr( $rows ) . '">' . esc_html( $value ) . '</textarea>';
	}


	/**
	 * switch_box
	 */
	public static function switch_box( $name, $is_checked ) {

		$checked = ( $is_checked ) ? 'checked' : '';
	?>
		<span><?=esc_html__( 'No', 'loos-ssp' )?></span>
		<label class="ssp_switch" for="<?=esc_attr( $name )?>">
			<input type="checkbox" name="" id="<?=esc_attr( $name )?>" <?=$checked?>>
			<span class="ssp_switch__slider -round"></span>
		</label>
		<span><?=esc_html__( 'Yes', 'loos-ssp' )?></span>
		<input type="hidden" name="<?=esc_attr( $name )?>" value="<?=esc_attr( $is_checked )?>">
	<?php
	}


	/**
	 * checkbox
	 */
	public static function checkbox( $name, $is_checked, $label ) {
	?>
		<label class="ssp_checkbox" for="<?=esc_attr( $name )?>">
			<input type="hidden" name="<?=esc_attr( $name )?>" value="">
			<input type="checkbox" name="<?=esc_attr( $name )?>" id="<?=esc_attr( $name )?>" value="1" <?php checked( $is_checked, '1' ); ?>>
			<span><?=esc_html( $label )?></span>
		</label>
	<?php
	}


	/**
	 * select_box
	 */
	public static function select_box( $name, $value, $choices ) {

		echo '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '">';
		foreach ( $choices as $key => $label ) {
			$selected = ( $key === $value ) ? 'selected' : '';
			echo '<option value="' . esc_attr( $key ) . '" ' . $selected . '>' . esc_html( $label ) . '</option>';
		}
		echo '</select>';
	}


	/**
	 * radio_btns
	 */
	public static function radio_btns( $name, $value, $choices ) {

		foreach ( $choices as $key => $label ) {

			$checked   = ( $key === $value ) ? 'checked' : '';
			$radio_key = 'radio-' . $name . '-' . $key;

			echo '<input type="radio" class="ssp-field__radioInput"' .
				' id="' . esc_attr( $radio_key ) . '"' .
				' name="' . esc_attr( $name ) . '"' .
				' value="' . esc_attr( $key ) . '"' . $checked . '>' .
				'<label class="ssp-field__radioLabel" for="' . esc_attr( $radio_key ) . '">' . esc_html( $label ) . '</label>';
		}
	}


	/**
	 * 画像アップロード
	 */
	public static function media_btns( $name = '', $value = '' ) {
	?>
		<div class="ssp-media">
			<input type="hidden" id="src_<?=esc_attr( $name )?>" name="<?=esc_attr( $name )?>" value="<?=esc_attr( $value )?>" />
			<?php if ( $value ) : ?>
				<div id="preview_<?=esc_attr( $name )?>" class="ssp-media__preview">
					<img src="<?=esc_url( $value )?>" alt="">
				</div>
			<?php else : ?>
				<div id="preview_<?=esc_attr( $name )?>" class="ssp-media__preview"></div>
			<?php endif; ?>
			<div class="ssp-media__null">
				<?=esc_html__( 'No image has been set yet.', 'loos-ssp' )?>
			</div>
			<div class="ssp-media__btns">
				<button type="button" class="button button-primary" name="ssp-media-upload" data-id="<?=esc_attr( $name )?>">
					<?=esc_html__( 'Select image', 'loos-ssp' )?>
				</button>
				<button type="button" class="button" name="ssp-media-clear" data-id="<?=esc_attr( $name )?>">
					<?=esc_html__( 'Delete image', 'loos-ssp' )?>
				</button>
			</div>
		</div>
	<?php
	}


	/**
	 * プレビュー機能用のスニペット変換
	 */
	public static function replace_snippets_forpv( $str ) {
		$str = str_replace( '%_site_title_%', '<span>' . \SSP_Data::$site_title . '</span>', $str );
		$str = str_replace( '%_tagline_%', '<span>' . \SSP_Data::$site_catch_phrase . '</span>', $str );
		$str = str_replace( '%_front_description_%', '<span>' . __( 'Front description', 'loos-ssp' ) . '</span>', $str );
		$str = str_replace( '%_page_title_%', '<span>' . __( 'Post title', 'loos-ssp' ) . '</span>', $str );
		$str = str_replace( '%_page_contents_%', '<span>' . __( 'Page content', 'loos-ssp' ) . '</span>', $str );
		$str = str_replace( '%_term_name_%', '<span>' . __( 'Term name', 'loos-ssp' ) . '</span>', $str );
		$str = str_replace( '%_term_description_%', '<span>' . __( 'Term description', 'loos-ssp' ) . '</span>', $str );
		$str = str_replace( '%_tax_name_%', '<span>' . __( 'Taxonomy name', 'loos-ssp' ) . '</span>', $str );
		$str = str_replace( '%_author_name_%', '<span>' . __( 'Author name', 'loos-ssp' ) . '</span>', $str );
		$str = str_replace( '%_search_phrase_%', '<span>' . __( 'Search word', 'loos-ssp' ) . '</span>', $str );
		$str = str_replace( '%_post_type_%', '<span>' . __( 'Post type name', 'loos-ssp' ) . '</span>', $str );
		$str = str_replace( '%_date_%', '<span>' . __( 'Date', 'loos-ssp' ) . '</span>', $str );
		if ( strpos( $str, '%_sep_%' ) !== false ) {
			$sep_key = \SSP_Data::$settings['separator'];
			$sep_val = \SSP_Data::SEPARATORS[ $sep_key ];
			$str     = str_replace( '%_sep_%', '<span>' . $sep_val . '</span>', $str );
		}
		return $str;
	}
}
