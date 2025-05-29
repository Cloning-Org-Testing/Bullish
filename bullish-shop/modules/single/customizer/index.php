<?php

/**
 * Customizer - Product Single Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Shop_Customizer_Single' ) ) {

    class Bullish_Shop_Customizer_Single {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Sections
                $this->load_sections();

        }

        /*
        Load Sections
        */

            function load_sections() {

                foreach( glob( BULLISH_SHOP_MODULE_PATH. 'single/customizer/sections/*.php' ) as $module ) {
                    include_once $module;
                }

            }


    }

}


if( !function_exists('bullish_shop_customizer_single') ) {
	function bullish_shop_customizer_single() {
		return Bullish_Shop_Customizer_Single::instance();
	}
}

bullish_shop_customizer_single();