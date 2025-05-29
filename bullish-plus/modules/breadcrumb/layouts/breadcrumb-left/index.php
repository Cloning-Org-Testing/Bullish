<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'BullishPlusBreadcrumbLeft' ) ) {
    class BullishPlusBreadcrumbLeft {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'bullish_plus_breadcrumb_layouts', array( $this, 'add_option' ) );
        }

        function add_option( $options ) {
            $options['breadcrumb-left'] = esc_html__('Breadcrumb Left', 'bullish-plus');
            return $options;
        }
    }
}

BullishPlusBreadcrumbLeft::instance();