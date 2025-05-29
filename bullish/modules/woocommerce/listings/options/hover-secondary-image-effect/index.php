<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Woo_Listing_Option_Hover_Secondary_Image_Effect' ) ) {

    class Bullish_Woo_Listing_Option_Hover_Secondary_Image_Effect extends Bullish_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-hover-secondary-image-effect';
            $this->option_name          = esc_html__('Hover Secondary Image Effect', 'bullish');
            $this->option_default_value = 'product-hover-secimage-fade';
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_value_prefix  = 'product-hover-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'bullish_woo_custom_product_template_hover_options', array( $this, 'woo_custom_product_template_hover_options'), 15, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_hover_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'hover';
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
                'product-hover-secimage-fade'         => esc_html__('Fade', 'bullish'),
                'product-hover-secimage-zoomin'       => esc_html__('Zoom In', 'bullish'),
                'product-hover-secimage-zoomout'      => esc_html__('Zoom Out', 'bullish'),
                'product-hover-secimage-zoomoutup'    => esc_html__('Zoom Out Up', 'bullish'),
                'product-hover-secimage-zoomoutdown'  => esc_html__('Zoom Out Down', 'bullish'),
                'product-hover-secimage-zoomoutleft'  => esc_html__('Zoom Out Left', 'bullish'),
                'product-hover-secimage-zoomoutright' => esc_html__('Zoom Out Right', 'bullish'),
                'product-hover-secimage-pushup'       => esc_html__('Push Up', 'bullish'),
                'product-hover-secimage-pushdown'     => esc_html__('Push Down', 'bullish'),
                'product-hover-secimage-pushleft'     => esc_html__('Push Left', 'bullish'),
                'product-hover-secimage-pushright'    => esc_html__('Push Right', 'bullish'),
                'product-hover-secimage-slideup'      => esc_html__('Slide Up', 'bullish'),
                'product-hover-secimage-slidedown'    => esc_html__('Slide Down', 'bullish'),
                'product-hover-secimage-slideleft'    => esc_html__('Slide Left', 'bullish'),
                'product-hover-secimage-slideright'   => esc_html__('Slide Right', 'bullish'),
                'product-hover-secimage-hingeup'      => esc_html__('Hinge Up', 'bullish'),
                'product-hover-secimage-hingedown'    => esc_html__('Hinge Down', 'bullish'),
                'product-hover-secimage-hingeleft'    => esc_html__('Hinge Left', 'bullish'),
                'product-hover-secimage-hingeright'   => esc_html__('Hinge Right', 'bullish'),
                'product-hover-secimage-foldup'       => esc_html__('Fold Up', 'bullish'),
                'product-hover-secimage-folddown'     => esc_html__('Fold Down', 'bullish'),
                'product-hover-secimage-foldleft'     => esc_html__('Fold Left', 'bullish'),
                'product-hover-secimage-foldright'    => esc_html__('Fold Right', 'bullish'),
                'product-hover-secimage-fliphoriz'    => esc_html__('Flip Horizontal', 'bullish'),
                'product-hover-secimage-flipvert'     => esc_html__('Flip Vertical', 'bullish')
            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('bullish_woo_listing_option_hover_secondary_image_effect') ) {
	function bullish_woo_listing_option_hover_secondary_image_effect() {
		return Bullish_Woo_Listing_Option_Hover_Secondary_Image_Effect::instance();
	}
}

bullish_woo_listing_option_hover_secondary_image_effect();