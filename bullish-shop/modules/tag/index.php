<?php

/**
 * Listings - Tag
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Shop_Listing_Tag' ) ) {

    class Bullish_Shop_Listing_Tag {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            /* Load Modules */
                $this->load_modules();

        }

        /*
        Load Modules
        */
            function load_modules() {

                /* Customizer */
                    include_once BULLISH_SHOP_PATH . 'modules/tag/customizer/index.php';

            }

    }

}


if( !function_exists('bullish_shop_listing_tag') ) {
	function bullish_shop_listing_tag() {
		return Bullish_Shop_Listing_Tag::instance();
	}
}

bullish_shop_listing_tag();