<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Shop_Single_Metabox_Options' ) ) {
    class Bullish_Shop_Single_Metabox_Options {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'bullish_shop_product_custom_settings', array( $this, 'bullish_shop_product_custom_settings' ), 20 );
        }

        function bullish_shop_product_custom_settings( $options ) {

			$product_options = array(

				# Product New Label
					array(
						'id'         => 'product-new-label',
						'type'       => 'switcher',
						'title'      => esc_html__('Add "New" label', 'bullish-shop'),
					),

					array(
						'id'         => 'product-notes',
						'type'       => 'textarea',
						'title'      => esc_html__('Product Notes', 'bullish-shop')
					)

			);

			$options = array_merge( $options, $product_options );

			return $options;

        }

    }
}

Bullish_Shop_Single_Metabox_Options::instance();