<?php
/**
 * Googleアナリティクス タブ
 */
self::output_section( __( 'Google Analytics settings', 'loos-ssp' ), [
	'google_analytics_type' => [
		'title'       => __( 'Tracking code type', 'loos-ssp' ),
		'type'        => 'select',
		'choices'     => [
			'gtag'      => __( 'gtag.js', 'loos-ssp' ),
			'analytics' => __( 'analytics.js', 'loos-ssp' ),
		],
		'desc'        => '※ ' . __( '<code>gtag.js</code> is recommended unless you have a specific reason.', 'loos-ssp' ),
	],
	'google_analytics_id' => [
		'title' => __( '"Tracking ID" or "Measurement ID"', 'loos-ssp' ),
		'desc'  => sprintf(
			SSP_Data::$texts['input'],
			__( 'Tracking ID (<code>UA-XXXX...</code>) or Measurement ID (<code>G-XXX...</code>)', 'loos-ssp' )
		),
	],
] );
