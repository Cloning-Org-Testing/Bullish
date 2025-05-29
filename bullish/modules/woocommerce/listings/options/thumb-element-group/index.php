<?php

/**
 * Listing Options - Product Thumb Content
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Woo_Listing_Option_Thumb_Element_Group' ) ) {

    class Bullish_Woo_Listing_Option_Thumb_Element_Group extends Bullish_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-thumb-element-group';
            $this->option_name          = esc_html__('Element Group Content', 'bullish');
            $this->option_type          = array ( 'html', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = '';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {

            /* Custom Product Templates - Options */
            add_filter( 'bullish_woo_custom_product_template_thumb_options', array( $this, 'woo_custom_product_template_thumb_options'), 55, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_thumb_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'thumb';
        }

        /**
         * Setting Arguments
         */
        function setting_args() {

            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'sorter';
            $settings['title']   =  $this->option_name;
            $settings['default'] =  array (
                'enabled' => array(
                    'title' => esc_html__('Title', 'bullish'),
                    'price' => esc_html__('Price', 'bullish'),
                ),
                'disabled'         => array(
                    'cart'           => esc_html__('Cart', 'bullish'),
                    'wishlist'       => esc_html__('Wishlist', 'bullish'),
                    'compare'        => esc_html__('Compare', 'bullish'),
                    'quickview'      => esc_html__('Quick View', 'bullish'),
                    'category'       => esc_html__('Category', 'bullish'),
                    'button_element' => esc_html__('Button Element', 'bullish'),
                    'icons_group'    => esc_html__('Icons Group', 'bullish'),
                    'excerpt'        => esc_html__('Excerpt', 'bullish'),
                    'rating'         => esc_html__('Rating', 'bullish'),
                    'separator'      => esc_html__('Separator', 'bullish'),
                    'swatches'       => esc_html__('Swatches', 'bullish')
                ),
            );
            $settings['enabled_title']  =  esc_html__('Active Elements', 'bullish');
            $settings['disabled_title'] =  esc_html__('Deatcive Elements', 'bullish');

            return $settings;
        }
    }

}

if( !function_exists('bullish_woo_listing_option_thumb_element_group') ) {
	function bullish_woo_listing_option_thumb_element_group() {
		return Bullish_Woo_Listing_Option_Thumb_Element_Group::instance();
	}
}

bullish_woo_listing_option_thumb_element_group();