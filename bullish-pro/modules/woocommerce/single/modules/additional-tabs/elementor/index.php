<?php

/**
 * WooCommerce - Elementor Single Widgets Core Class
 */

namespace BullishElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Bullish_Shop_Elementor_Single_Additional_Tabs_Widgets {

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

		$this->bullish_shop_load_modules();

		add_action( 'bullish_shop_register_widgets', array( $this, 'bullish_shop_register_widgets' ), 10, 1 );

		add_action( 'bullish_shop_register_widget_styles', array( $this, 'bullish_shop_register_widget_styles' ), 10, 1 );
		add_action( 'bullish_shop_register_widget_scripts', array( $this, 'bullish_shop_register_widget_scripts' ), 10, 1 );

		add_action( 'bullish_shop_preview_styles', array( $this, 'bullish_shop_preview_styles') );

	}

	/**
	 * Init
	 */
	function bullish_shop_load_modules() {

		require bullish_shop_single_module_additional_tabs()->module_dir_path() . 'elementor/utils.php';

	}

	/**
	 * Register widgets
	 */
	function bullish_shop_register_widgets( $widgets_manager ) {

		require bullish_shop_single_module_additional_tabs()->module_dir_path() . 'elementor/widgets/product-tabs-exploded/class-product-tabs-exploded.php';
		$widgets_manager->register( new Bullish_Shop_Widget_Product_Additional_Tabs_Exploded() );

	}

	/**
	 * Register widgets styles
	 */
	function bullish_shop_register_widget_styles( $suffix ) {

		# Product Tabs Exploded

			wp_register_style( 'wdt-shop-product-single-additional-tabs-exploded',
				bullish_shop_single_module_additional_tabs()->module_dir_url() . 'assets/css/style'.$suffix.'.css',
				array()
			);

	}

	/**
	 * Register widgets scripts
	 */
	function bullish_shop_register_widget_scripts( $suffix ) {

		# Product Tabs - Exploded

			wp_register_script( 'jquery-nicescroll',
				bullish_shop_single_module_additional_tabs()->module_dir_url() . 'assets/js/jquery.nicescroll'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

			wp_register_script( 'wdt-shop-product-single-additional-tabs-exploded',
				bullish_shop_single_module_additional_tabs()->module_dir_url() . 'assets/js/scripts'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

	}

	/**
	 * Editor Preview Style
	 */
	function bullish_shop_preview_styles() {

		# Product Tabs - Exploded
			wp_enqueue_style( 'wdt-shop-product-single-additional-tabs-exploded' );

	}

}

Bullish_Shop_Elementor_Single_Additional_Tabs_Widgets::instance();