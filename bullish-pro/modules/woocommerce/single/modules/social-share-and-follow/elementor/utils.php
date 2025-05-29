<?php

/*
* Update Summary Options Filter
*/

if( ! function_exists( 'bullish_shop_woo_single_summary_options_ssf_render' ) ) {
	function bullish_shop_woo_single_summary_options_ssf_render( $options ) {

		$options['share_follow'] = esc_html__('Summary Share / Follow', 'bullish-pro');
		return $options;

	}
	add_filter( 'bullish_shop_woo_single_summary_options', 'bullish_shop_woo_single_summary_options_ssf_render', 10, 1 );

}


/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'bullish_shop_woo_single_summary_styles_ssf_render' ) ) {
	function bullish_shop_woo_single_summary_styles_ssf_render( $styles ) {

		array_push( $styles, 'wdt-shop-social-share-and-follow' );
		return $styles;

	}
	add_filter( 'bullish_shop_woo_single_summary_styles', 'bullish_shop_woo_single_summary_styles_ssf_render', 10, 1 );

}
