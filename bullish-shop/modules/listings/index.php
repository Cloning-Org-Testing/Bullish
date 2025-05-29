<?php

/**
 * Listing
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Shop_Listing' ) ) {

    class Bullish_Shop_Listing {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Update Options Location Path Array */
                add_filter( 'bullish_woo_option_locations', array($this, 'option_locations_update'), 10, 1 );

            /* Update Types Location Path Array */
                add_filter( 'bullish_woo_type_locations', array($this, 'type_locations_update'), 10, 1 );

            /* Shop Settings Menu Filter */
                add_action( 'bullish_pro_cs_framework_settings', array($this, 'woo_cs_fw_shop_settings' ), 10 );

            /* Load Modules */
                $this->load_modules();

        }

        /*
        Options Location Path Update
        */
            function option_locations_update( $paths ) {

                array_push( $paths, BULLISH_SHOP_MODULE_PATH. 'listings/options/*/index.php' );

                return $paths;

            }

        /*
        Types Location Path Update
        */
            function type_locations_update( $paths ) {

                array_push( $paths, BULLISH_SHOP_MODULE_PATH. 'listings/types/*/index.php' );

                return $paths;

            }


        /*
        Shop Settings Menu Filter
        */
            function woo_cs_fw_shop_settings() {

                $settings = array(
                    'menu_title'      => esc_html__('Bullish Settings', 'bullish-shop'),
                    'menu_type'       => 'menu',
                    'menu_slug'       => 'bullish-settings',
                    'ajax_save'       => false,
                    'show_reset_all'  => false,
                    'framework_title' => esc_html__('Bullish Settings', 'bullish-shop')
                );

                return $settings;

            }

        /*
        Load Modules
        */

            function load_modules() {

                // Product Template
                if(is_admin()) {
                    include_once BULLISH_SHOP_MODULE_PATH . 'listings/product-template/index.php';
                }

                // Product Hooks
                    include_once BULLISH_SHOP_MODULE_PATH . 'listings/product-hooks/index.php';
                // Product Swatches Hooks
                include_once BULLISH_SHOP_MODULE_PATH . 'listings/product-swatcheshooks/index.php';


                // Product Archive
                    include_once BULLISH_SHOP_MODULE_PATH . 'listings/product-archive/index.php';
                    
                    
                // Product BackUp
                    include_once BULLISH_SHOP_MODULE_PATH . 'listings/backup/index.php';

            }


    }

}

if( !function_exists('bullish_shop_listing') ) {
	function bullish_shop_listing() {
		return Bullish_Shop_Listing::instance();
	}
}

bullish_shop_listing();