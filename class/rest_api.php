<?php
class SSP_RestAPI {

	private function __construct() {}

	public static function init() {
		add_action( 'rest_api_init', [ 'SSP_RestAPI', 'register_meta_fields' ] );
	}

	public static function register_meta_fields() {
		$post_types = array_merge(
			[ 'post', 'page' ],
			array_keys( get_post_types( [ 'public' => true, '_builtin' => false ], 'names', 'and' ) )
		);

		$meta_fields = [
			'ssp_meta_title'       => 'string',
			'ssp_meta_description' => 'string',
		];

		foreach ( $post_types as $post_type ) {
			foreach ( $meta_fields as $meta_key => $type ) {
				register_post_meta( $post_type, $meta_key, [
					'show_in_rest'      => true,
					'single'            => true,
					'type'              => $type,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => function() {
						return current_user_can( 'edit_posts' );
					},
				] );
			}
		}
	}
}
