<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Woo_Listing_Option_Display_Type' ) ) {

    class Bullish_Woo_Listing_Option_Display_Type extends Bullish_Woo_Listing_Option_Core {

        private static $_instance = null;

        public $option_slug;

        public $option_name;

        public $option_type;

        public $option_default_value;

        public $option_value_prefix;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->option_slug          = 'product-display-type';
            $this->option_name          = esc_html__('Display Type', 'bullish');
            $this->option_type          = array ( 'html' );
            $this->option_default_value = 'grid';
            $this->option_value_prefix  = '';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'bullish_woo_custom_product_template_common_options', array( $this, 'woo_custom_product_template_common_options'), 5, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_common_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'common';
        }

        /**
         * Setting Args
         */
        function setting_args() {
            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'select';
            $settings['title']   =  $this->option_name;
            $settings['options'] =  array (
                'grid' => esc_html__('Grid', 'bullish'),
                'list' => esc_html__('List', 'bullish'),
            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('bullish_woo_listing_option_display_type') ) {
	function bullish_woo_listing_option_display_type() {
		return Bullish_Woo_Listing_Option_Display_Type::instance();
	}
}

bullish_woo_listing_option_display_type();