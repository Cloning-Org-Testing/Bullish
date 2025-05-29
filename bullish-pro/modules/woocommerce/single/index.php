<?php

/**
 * WooCommerce - Single Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Pro_Single' ) ) {

    class Bullish_Pro_Single {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();

        }

        /*
        Load Modules
        */
        function load_modules() {

            // Sidebar Widgets
                include_once BULLISH_PRO_DIR_PATH . 'modules/woocommerce/single/sidebar/index.php';

            // Customizer
                include_once BULLISH_PRO_DIR_PATH . 'modules/woocommerce/single/customizer/index.php';

            // Metabox
                include_once BULLISH_PRO_DIR_PATH . 'modules/woocommerce/single/metabox/index.php';

        }

    }

}

if( !function_exists('bullish_single') ) {
	function bullish_single() {
		return Bullish_Pro_Single::instance();
	}
}

bullish_single();