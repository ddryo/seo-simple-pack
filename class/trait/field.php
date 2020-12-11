<?php
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
	 * 各設定項目を出力する
	 */
	public static function output_field( $name, $args = [], $now_value ) {

			$args = array_merge( [
				'title'       => '',
				'reqired'     => false,
				'class'       => '',
				'type'        => 'text',
				'preview'     => false,
				'desc'        => '',
				'choices'     => [],
				'item'        => '',
			], $args );

			$data_disable = '';
			if ( strpos( $name, '_disable' ) !== false ) {
				$data_disable = 'data-disable="' . (int) $now_value . '"';
			}

			// if ( $args['reqired'] ) {
			// 	$table_title .= '<span class="required">*</span>';
			// }

		?>
			<div class="ssp-field" <?=( $data_disable )?>>
				<label for="<?=esc_attr( $name )?>" class="ssp-field__title">
					<?=esc_html( $args['title'] ) ?>
				</label>
				<div class="<?=trim( 'ssp-field__body ' . $args['class'] )?>">
					<div class="ssp_item ssp-field__item -<?=$args['type']?>">
						<?php
							if ( $args['item'] ) :
							echo $args['item'];
							else :
								self::the_setting_field( $name, $now_value, $args['type'], $args['choices'] );
							endif;
						?>
					</div>
					<div class="ssp_desc ssp-field__desc">
						<p><?=$args['desc']?></p>
					</div>
					<?php if ( $args['preview'] ) : ?>
						<div class="ssp-field__preview">
							<span class="ssp-field__preview__label">
								┗ <?=esc_html__( 'Preview', 'loos-ssp' )?> : 
							</span>
							<div class="ssp-field__preview__content">
								<?=\SSP_Methods::replace_snippets_forpv( esc_html( $now_value ) )?>
							</div>
							<a href="<?=admin_url( 'admin.php?page=ssp_help' )?>" target="_blank" title="使用可能なスニペットタグについて" class="ssp-helpButton">?</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php
	}

	/**
	 * 設定フィールドを取得
	 */
	public static function the_setting_field( $name, $now_value, $type, $choices ) {

		if ( 'text' === $type ) {

			self::text_input( $name, $now_value );

		} elseif ( 'switch' === $type ) {

			self::switch_box( $name, $now_value );

		} elseif ( 'select' === $type ) {

			self::select_box( $name, $now_value, $choices );

		} if ( 'radio_btn' === $type ) {

			echo self::radio_btns( $name, $now_value, $choices );

		} if ( 'media' === $type ) {

			echo self::media_btns( $name, $now_value );

		} elseif ( 'textarea' === $type ) {

			echo '<textarea name="' . esc_attr( $name ) . '">' . esc_html( $now_value ) . '</textarea>';

		}
	}


	/**
	 * text_input
	 */
	public static function text_input( $name, $now_value ) {
		echo '<input type="text" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" value="' . esc_attr( $now_value ) . '">';
	}


	/**
	 * textarea
	 */
	public static function textarea( $name, $now_value, $rows = '4' ) {
		echo '<textarea name="' . esc_attr( $name ) . '" rows="' . esc_attr( $rows ) . '">' . esc_html( $now_value ) . '</textarea>';
	}


	/**
	 * switch_box
	 */
	public static function switch_box( $name, $is_checked ) {

		$checked = ( $is_checked ) ? 'checked' : '';
	?>
		<span><?=__( 'はい', 'loos-ssp' )?></span>
			<label class="ssp_switch_box" for="<?=esc_attr( $name )?>">
				<input type="checkbox" name="" id="<?=esc_attr( $name )?>" <?=$checked?>>
				<span class="ssp_switch_box__slider -round"></span>
			</label>
			<span><?=__( 'いいえ', 'loos-ssp' )?></span>
			<input type="hidden" name="<?=esc_attr( $name )?>" value="<?=esc_attr( $is_checked )?>">
	<?php
	}


	/**
	 * select_box
	 */
	public static function select_box( $name, $now_value, $choices ) {

		echo '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '">';
		foreach ( $choices as $key => $label ) {
			$selected = ( $key === $now_value ) ? 'selected' : '';
			echo '<option value="' . esc_attr( $key ) . '" ' . $selected . '>' . esc_html( $label ) . '</option>';
		}
		echo '</select>';
	}


	/**
	 * radio_btns
	 */
	public static function radio_btns( $name, $now_value, $choices ) {

		foreach ( $choices as $key => $label ) {

			$checked   = ( $key === $now_value ) ? 'checked' : '';
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
	public static function media_btns( $name = '', $src = '' ) {
	?>
		<div class="ssp-media">
			<input type="hidden" id="src_<?=$name?>" name="<?=$name?>" value="<?=esc_attr( $src )?>" />
			<div id="preview_<?=$name?>" class="ssp-media__preview">
				<?php if ( $src ) : ?>
					<img src="<?=esc_url( $src )?>" alt="">
				<?php endif; ?>
			</div>
			<div class="ssp-media__btns">
				<input class="button" type="button" name="ssp-media-upload" data-id="<?=$name?>" value="<?=__( 'Select image', 'loos-ssp' )?>" />
				<input class="button" type="button" name="ssp-media-clear" value="<?=__( 'Delete image', 'loos-ssp' )?>" data-id="<?=$name?>" />
			</div>
		</div>
	<?php
	}
}
