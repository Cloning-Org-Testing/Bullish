<?php

/**
 * Listing Framework Hooks Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Woo_Listing_Fw_Hooks_Settings' ) ) {

    class Bullish_Woo_Listing_Fw_Hooks_Settings {

        private static $_instance = null;

        private $template_hooks_page_top = false;
        private $template_hooks_page_bottom = false;
        private $template_hooks_content_top = false;
        private $template_hooks_content_bottom = false;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            $this->template_hooks_page_top = bullish_customizer_settings('wdt-woo-shop-page-template-hooks-page-top' );
            $this->template_hooks_page_bottom = bullish_customizer_settings('wdt-woo-shop-page-template-hooks-page-bottom' );
            $this->template_hooks_content_top = bullish_customizer_settings('wdt-woo-shop-page-template-hooks-content-top' );
            $this->template_hooks_content_bottom = bullish_customizer_settings('wdt-woo-shop-page-template-hooks-content-bottom' );

            add_action( 'bullish_hook_sections_before', array($this, 'woo_hook_sections_before' ), 10 );
            add_action( 'bullish_hook_sections_after', array($this, 'woo_hook_sections_after' ), 10 );

            add_action( 'bullish_woo_before_products_loop', array($this, 'woo_before_products_loop' ), 15 );
            add_action( 'bullish_woo_after_products_loop', array($this, 'woo_after_products_loop' ), 5 );

        }


        public function woo_hook_sections_before() {

            $output = '';

            if(is_shop()) {
                if(isset($this->template_hooks_page_top) && !empty($this->template_hooks_page_top)) {
                    $frontend = Elementor\Frontend::instance();
                    $output .= $frontend->get_builder_content( $this->template_hooks_page_top, true );
                }
            }

            echo bullish_html_output($output);

        }

        public function woo_hook_sections_after() {

            $output = '';

            if(is_shop()) {
                if(isset($this->template_hooks_page_bottom) && !empty($this->template_hooks_page_bottom)) {
                    $frontend = Elementor\Frontend::instance();
                    $output .= $frontend->get_builder_content( $this->template_hooks_page_bottom, true );
                }
            }

            echo bullish_html_output($output);

        }


        public function woo_before_products_loop() {

            $output = '';

            if(is_shop()) {
                if(isset($this->template_hooks_content_top) && !empty($this->template_hooks_content_top)) {
                    $frontend = Elementor\Frontend::instance();
                    $output .= $frontend->get_builder_content( $this->template_hooks_content_top, true );
                }
            }

            echo bullish_html_output($output);

        }

        public function woo_after_products_loop() {

            $output = '';

            if(is_shop()) {
                if(isset($this->template_hooks_content_bottom) && !empty($this->template_hooks_content_bottom)) {
                    $frontend = Elementor\Frontend::instance();
                    $output .= $frontend->get_builder_content( $this->template_hooks_content_bottom, true );
                }
            }

            echo bullish_html_output($output);

        }


    }

}


if( !function_exists('bullish_woo_listing_fw_hooks_settings') ) {
	function bullish_woo_listing_fw_hooks_settings() {
		return Bullish_Woo_Listing_Fw_Hooks_Settings::instance();
	}
}

bullish_woo_listing_fw_hooks_settings();