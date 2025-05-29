<?php

/**
 * Listing Customizer - Product Single - Default Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Shop_Customizer_Single_Default' ) ) {

    class Bullish_Shop_Customizer_Single_Default {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'bullish_woo_single_page_settings', array( $this, 'single_page_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 40);
            add_action( 'bullish_hook_content_before', array( $this, 'woo_handle_product_breadcrumb' ), 10);

        }

        function single_page_settings( $settings ) {

            $product_disable_breadcrumb                 = bullish_customizer_settings('wdt-single-product-disable-breadcrumb' );
            $settings['product_disable_breadcrumb']     = $product_disable_breadcrumb;

            $product_title_breadcrumb                 = bullish_customizer_settings('wdt-single-product-title-breadcrumb' );
            $settings['product_title_breadcrumb']     = $product_title_breadcrumb;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
            * Option : Disable Breadcrumb
            */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[wdt-single-product-disable-breadcrumb]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Bullish_Customize_Control_Switch(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[wdt-single-product-disable-breadcrumb]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Disable Breadcrumb', 'bullish-shop'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'bullish-shop' ),
                                'off' => esc_attr__( 'No', 'bullish-shop' )
                            )
                        )
                    )
                );

            /**
            * Option : Show Title in Breadcrumb
            */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[wdt-single-product-title-breadcrumb]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Bullish_Customize_Control_Switch(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[wdt-single-product-title-breadcrumb]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Product Title in Breadcrumb', 'bullish-shop'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'bullish-shop' ),
                                'off' => esc_attr__( 'No', 'bullish-shop' )
                            ),
                            'description'   => esc_html__('If you like to show title in breadcrumb section.', 'bullish-shop')
                        )
                    )
                );

        }

        function woo_handle_product_breadcrumb() {

            if(is_product() && bullish_customizer_settings('wdt-single-product-disable-breadcrumb' )) {
                remove_action('bullish_breadcrumb', 'bullish_breadcrumb_template');
            }

        }

    }

}


if( !function_exists('bullish_shop_customizer_single_default') ) {
	function bullish_shop_customizer_single_default() {
		return Bullish_Shop_Customizer_Single_Default::instance();
	}
}

bullish_shop_customizer_single_default();