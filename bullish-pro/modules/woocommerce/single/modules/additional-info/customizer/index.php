<?php

/**
 * WooCommerce - Single - Module - Additional Info - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Shop_Customizer_Single_Additional_Info' ) ) {

    class Bullish_Shop_Customizer_Single_Additional_Info {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'bullish_woo_single_page_settings', array( $this, 'single_page_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function single_page_settings( $settings ) {

            $product_additional_info                   = bullish_customizer_settings('wdt-single-product-additional-info' );
            $settings['product_additional_info']       = $product_additional_info;

            $product_ai_delivery_period                = bullish_customizer_settings('wdt-single-product-ai-delivery-period' );
            $settings['product_ai_delivery_period']    = $product_ai_delivery_period;

            $product_ai_visitors_min_value             = bullish_customizer_settings('wdt-single-product-ai-visitors-min-value' );
            $settings['product_ai_visitors_min_value'] = $product_ai_visitors_min_value;

            $product_ai_visitors_max_value             = bullish_customizer_settings('wdt-single-product-ai-visitors-max-value' );
            $settings['product_ai_visitors_max_value'] = $product_ai_visitors_max_value;

            return $settings;

        }

        function register( $wp_customize ) {

             /**
            * Option : Enable Additional Info
            */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[wdt-single-product-additional-info]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    new Bullish_Customize_Control_Switch(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[wdt-single-product-additional-info]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Enable Additional Info', 'bullish-pro'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'bullish-pro' ),
                                'off' => esc_attr__( 'No', 'bullish-pro' )
                            ),
                            'description'   => esc_html__('This option is applicable only for "WooCommerce Default" single page.', 'bullish-pro')
                        )
                    )
                );

            /**
             * Option : Additional Info - Delivery Period
             */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[wdt-single-product-ai-delivery-period]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    BULLISH_CUSTOMISER_VAL . '[wdt-single-product-ai-delivery-period]', array(
                        'type'        => 'text',
                        'section'     => 'woocommerce-single-page-default-section',
                        'label'       => esc_html__( 'Additional Info - Delivery Period', 'bullish-pro' ),
                        'dependency'  => array( 'wdt-single-product-additional-info', ' == ', 1 ),
                        'description' => esc_html__('Delivery Offer: If purchased today product will be delivered in below mentioned period ( in days ).', 'bullish-pro')
                    )
                );

            /**
             * Option : Additional Info - Visitors Min Value
             */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[wdt-single-product-ai-visitors-min-value]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    BULLISH_CUSTOMISER_VAL . '[wdt-single-product-ai-visitors-min-value]', array(
                        'type'        => 'text',
                        'section'     => 'woocommerce-single-page-default-section',
                        'label'       => esc_html__( 'Additional Info - Visitors Min Value', 'bullish-pro' ),
                        'dependency'  => array( 'wdt-single-product-additional-info', ' == ', 1 ),
                        'description' => esc_html__('Real Time Visitors: Minimum value', 'bullish-pro')
                    )
                );

            /**
             * Option : Additional Info - Visitors Max Value
             */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[wdt-single-product-ai-visitors-max-value]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    BULLISH_CUSTOMISER_VAL . '[wdt-single-product-ai-visitors-max-value]', array(
                        'type'        => 'text',
                        'section'     => 'woocommerce-single-page-default-section',
                        'label'       => esc_html__( 'Additional Info - Visitors Max Value', 'bullish-pro' ),
                        'dependency'  => array( 'wdt-single-product-additional-info', ' == ', 1 ),
                        'description' => esc_html__('Real Time Visitors: Maximum value', 'bullish-pro')
                    )
                );


        }

    }

}


if( !function_exists('bullish_shop_customizer_single_additional_info') ) {
	function bullish_shop_customizer_single_additional_info() {
		return Bullish_Shop_Customizer_Single_Additional_Info::instance();
	}
}

bullish_shop_customizer_single_additional_info();