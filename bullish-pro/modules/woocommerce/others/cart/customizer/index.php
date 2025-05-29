<?php

/**
 * WooCommerce - Others - Cart - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Shop_Customizer_Others_Cart' ) ) {

    class Bullish_Shop_Customizer_Others_Cart {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'bullish_woo_others_settings', array( $this, 'others_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function others_settings( $settings ) {

            $cross_sell_title              = bullish_customizer_settings('wdt-woo-cross-sell-title' );
            $settings['cross_sell_title']  = $cross_sell_title;

            $cross_sell_column             = bullish_customizer_settings('wdt-woo-cross-sell-column' );
            $settings['cross_sell_column'] = $cross_sell_column;

            $cross_sell_style_custom_template = bullish_customizer_settings('wdt-woo-cross-sell-style-template' );
            if( isset($cross_sell_style_custom_template) && !empty($cross_sell_style_custom_template) ) {
                $settings['cross_sell_style_template']        = 'custom';
                $settings['cross_sell_style_custom_template'] = $cross_sell_style_custom_template;
            }

            return $settings;

        }

        function register( $wp_customize ) {

            /**
             * Option : Cross Sell Title
             */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[wdt-woo-cross-sell-title]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    BULLISH_CUSTOMISER_VAL . '[wdt-woo-cross-sell-title]', array(
                        'type'       => 'text',
                        'section'    => 'woocommerce-others-section',
                        'label'      => esc_html__( 'Cross Sell Title', 'bullish-pro' )
                    )
                );

            /**
             * Option : Cross Sell Column
             */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[wdt-woo-cross-sell-column]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control( new Bullish_Customize_Control_Radio_Image(
                    $wp_customize, BULLISH_CUSTOMISER_VAL . '[wdt-woo-cross-sell-column]', array(
                        'type' => 'wdt-radio-image',
                        'label' => esc_html__( 'Cross Sell Column', 'bullish-pro'),
                        'section' => 'woocommerce-others-section',
                        'choices' => apply_filters( 'bullish_woo_crosssell_columns_options', array(
                            1 => array(
                                'label' => esc_html__( 'One Column', 'bullish-pro' ),
                                'path' => bullish_shop_others_cart()->module_dir_url() . 'customizer/images/one-column.png'
                            ),
                            2 => array(
                                'label' => esc_html__( 'One Half Column', 'bullish-pro' ),
                                'path' => bullish_shop_others_cart()->module_dir_url() . 'customizer/images/one-half-column.png'
                            ),
                            3 => array(
                                'label' => esc_html__( 'One Third Column', 'bullish-pro' ),
                                'path' => bullish_shop_others_cart()->module_dir_url() . 'customizer/images/one-third-column.png'
                            ),
                            4 => array(
                                'label' => esc_html__( 'One Fourth Column', 'bullish-pro' ),
                                'path' => bullish_shop_others_cart()->module_dir_url() . 'customizer/images/one-fourth-column.png'
                            )
                        ))
                    )
                ));

            /**
             * Option : Product Style Template
             */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[wdt-woo-cross-sell-style-template]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    new Bullish_Customize_Control(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[wdt-woo-cross-sell-style-template]', array(
                            'type'     => 'select',
                            'label'    => esc_html__( 'Product Style Template', 'bullish-pro'),
                            'section'  => 'woocommerce-others-section',
                            'choices'  => bullish_woo_listing_customizer_settings()->product_templates_list()
                        )
                    )
                );

        }

    }

}


if( !function_exists('bullish_shop_customizer_others_cart') ) {
	function bullish_shop_customizer_others_cart() {
		return Bullish_Shop_Customizer_Others_Cart::instance();
	}
}

bullish_shop_customizer_others_cart();