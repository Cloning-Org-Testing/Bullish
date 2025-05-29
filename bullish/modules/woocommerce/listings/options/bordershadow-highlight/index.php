<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Woo_Listing_Option_Border_Shadow_Highlight' ) ) {

    class Bullish_Woo_Listing_Option_Border_Shadow_Highlight extends Bullish_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-bordershadow-highlight';
            $this->option_name          = esc_html__('Border / Shadow - Highlight', 'bullish');
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = 'product-bordershadow-highlight-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'bullish_woo_custom_product_template_common_options', array( $this, 'woo_custom_product_template_common_options'), 60, 1 );
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
                ''                                       => esc_html__('None', 'bullish' ),
                'product-bordershadow-highlight-default' => esc_html__('Default', 'bullish'),
                'product-bordershadow-highlight-onhover' => esc_html__('On Hover', 'bullish'),
            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('bullish_woo_listing_option_bordershadow_highlight') ) {
	function bullish_woo_listing_option_bordershadow_highlight() {
		return Bullish_Woo_Listing_Option_Border_Shadow_Highlight::instance();
	}
}

bullish_woo_listing_option_bordershadow_highlight();