<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'BullishProCustomizerSiteTitle' ) ) {
    class BullishProCustomizerSiteTitle {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
            add_filter( 'bullish_google_fonts_list', array( $this, 'fonts_list' ) );
        }

        function register( $wp_customize ) {

            /**
             * Option :Site Title Typography
             */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[site_title_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Bullish_Customize_Control_Typography(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[site_title_typo]', array(
                            'type'    => 'wdt-typography',
                            'section' => 'site-title-section',
                            'label'   => esc_html__( 'Typography', 'bullish-pro'),
                        )
                    )
                );

        }

        function fonts_list( $fonts ) {
            $settings = bullish_customizer_settings( 'site_title_typo' );
            return bullish_customizer_frontend_font( $settings, $fonts );
        }

    }
}

BullishProCustomizerSiteTitle::instance();