<?php

/**
 * WooCommerce - Elementor Listings Widgets Core Class
 */

namespace BullishElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Bullish_Pro_Elementor_Listings_Widgets {

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
		add_action( 'bullish_shop_preview_scripts', array( $this, 'bullish_shop_preview_scripts') );

	}

	/**
	 * Init
	 */
	function bullish_shop_load_modules() {

		require BULLISH_PRO_DIR_PATH . 'modules/woocommerce/listings/elementor/widgets/products/shortcodes.php';

	}

	/**
	 * Register widgets
	 */
	function bullish_shop_register_widgets( $widgets_manager ) {

		require BULLISH_PRO_DIR_PATH . 'modules/woocommerce/listings/elementor/widgets/products/class-widget-products.php';
		$widgets_manager->register( new Bullish_Shop_Widget_Products() );

	}

	/**
	 * Register widgets styles
	 */
	function bullish_shop_register_widget_styles( $suffix ) {

		# Swiper
			wp_register_style( 'css-swiper',
				BULLISH_PRO_DIR_URL . 'modules/woocommerce/listings/elementor/widgets/products/assets/css/swiper.min'.$suffix.'.css',
				array()
			);

		# Carousel
			wp_register_style( 'wdt-shop-products-carousel',
				BULLISH_MODULE_URI . '/woocommerce/assets/css/carousel.css',
				array()
			);

		# Products
			wp_register_style( 'wdt-shop-products',
				BULLISH_PRO_DIR_URL . 'modules/woocommerce/listings/elementor/widgets/products/assets/css/style'.$suffix.'.css',
				array()
			);

	}

	/**
	 * Register widgets scripts
	 */
	function bullish_shop_register_widget_scripts( $suffix ) {

		# Swiper
			wp_register_script( 'product-jquery-swiper',
				BULLISH_PRO_DIR_URL . 'modules/woocommerce/listings/elementor/widgets/products/assets/js/swiper.min'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

		# Products
			wp_register_script( 'wdt-shop-products',
				BULLISH_PRO_DIR_URL . 'modules/woocommerce/listings/elementor/widgets/products/assets/js/script'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

			wp_localize_script('wdt-shop-products', 'wdtShopScObjects',  array (
				'ajaxurl' => esc_url( admin_url('admin-ajax.php') )
			));


		# Products Admin
			wp_register_script( 'wdt-shop-admin',
				BULLISH_PRO_DIR_URL . 'modules/woocommerce/listings/elementor/widgets/products/assets/js/admin'.$suffix.'.js',
				array( 'jquery' ),
				false,
				true
			);

	}

	/**
	 * Editor Preview Style
	 */
	function bullish_shop_preview_styles() {

		# Products
			wp_enqueue_style( 'swiper' );
			wp_enqueue_style( 'wdt-shop-products' );

	}

	/**
	 * Editor Preview Script
	 */
	function bullish_shop_preview_scripts() {

		# Products Admin
			wp_enqueue_script( 'wdt-shop-admin' );

	}

}

Bullish_Pro_Elementor_Listings_Widgets::instance();