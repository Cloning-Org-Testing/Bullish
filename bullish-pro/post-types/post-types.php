<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'BullishProPostTypes' )) {
	/**
	 *
	 * @author iamdesigning11
	 *
	 */
	class BullishProPostTypes {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			// Mega Menu Post Type
			require_once BULLISH_PRO_DIR_PATH . 'post-types/mega-menu-post-type.php';
			// Services Post Type
			require_once BULLISH_PRO_DIR_PATH . 'post-types/services-post-type.php';

		}
	}
}

BullishProPostTypes::instance();