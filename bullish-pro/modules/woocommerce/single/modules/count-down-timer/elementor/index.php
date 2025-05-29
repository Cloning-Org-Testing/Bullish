<?php

/**
 * WooCommerce - Elementor Single Widgets Core Class
 */

namespace BullishElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Bullish_Shop_Elementor_Single_Count_Down_Timer_Widgets {

	/**
	 * A Reference to an instance of this class
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	function __construct() {

		$this->bullish_shop_load_cbullish_modules();

		add_action( 'bullish_shop_register_widget_styles', array( $this, 'bullish_shop_register_widget_styles' ), 10, 1 );
		add_action( 'bullish_shop_register_widget_scripts', array( $this, 'bullish_shop_register_widget_scripts' ), 10, 1 );

		add_action( 'bullish_shop_preview_styles', array( $this, 'bullish_shop_preview_styles') );

	}

	/**
	 * Init
	 */
	function bullish_shop_load_cbullish_modules() {

		require bullish_shop_single_module_count_down_timer()->module_dir_path() . 'elementor/utils.php';

	}

	/**
	 * Register widgets styles
	 */
	function bullish_shop_register_widget_styles( $suffix ) {

		wp_register_style( 'wdt-shop-coundown-timer',
			bullish_shop_single_module_count_down_timer()->module_dir_url() . 'assets/css/style'.$suffix.'.css',
			array()
		);

	}

	/**
	 * Register widgets scripts
	 */
	function bullish_shop_register_widget_scripts( $suffix ) {

		wp_register_script( 'jquery-downcount',
			bullish_shop_single_module_count_down_timer()->module_dir_url() . 'assets/js/jquery.downcount'.$suffix.'.js',
			array( 'jquery' ),
			false,
			true
		);

		wp_register_script( 'wdt-shop-coundown-timer',
			bullish_shop_single_module_count_down_timer()->module_dir_url() . 'assets/js/scripts'.$suffix.'.js',
			array( 'jquery' ),
			false,
			true
		);

	}

	/**
	 * Editor Preview Style
	 */
	function bullish_shop_preview_styles() {

		wp_enqueue_style( 'wdt-shop-coundown-timer' );

	}

}

Bullish_Shop_Elementor_Single_Count_Down_Timer_Widgets::instance();