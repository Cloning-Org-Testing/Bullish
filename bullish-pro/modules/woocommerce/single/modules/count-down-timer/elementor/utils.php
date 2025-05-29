<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'bullish_shop_woo_single_summary_options_cbullish_render' ) ) {
	function bullish_shop_woo_single_summary_options_cbullish_render( $options ) {

		$options['countdown'] = esc_html__('Summary Count Down', 'bullish-pro');
		return $options;

	}
	add_filter( 'bullish_shop_woo_single_summary_options', 'bullish_shop_woo_single_summary_options_cbullish_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'bullish_shop_woo_single_summary_styles_cbullish_render' ) ) {
	function bullish_shop_woo_single_summary_styles_cbullish_render( $styles ) {

		array_push( $styles, 'wdt-shop-coundown-timer' );
		return $styles;

	}
	add_filter( 'bullish_shop_woo_single_summary_styles', 'bullish_shop_woo_single_summary_styles_cbullish_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'bullish_shop_woo_single_summary_scripts_cbullish_render' ) ) {
	function bullish_shop_woo_single_summary_scripts_cbullish_render( $scripts ) {

		array_push( $scripts, 'jquery-downcount' );
		array_push( $scripts, 'wdt-shop-coundown-timer' );
		return $scripts;

	}
	add_filter( 'bullish_shop_woo_single_summary_scripts', 'bullish_shop_woo_single_summary_scripts_cbullish_render', 10, 1 );

}