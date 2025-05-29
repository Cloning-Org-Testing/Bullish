<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'BullishPlusCustomizerSiteFooter' ) ) {
    class BullishPlusCustomizerSiteFooter {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new Bullish_Customize_Section(
                    $wp_customize,
                    'site-footer-section',
                    array(
                        'title'    => esc_html__('Footer', 'bullish-plus'),
                        'panel'    => 'site-general-main-panel',
                        'priority' => 20,
                    )
                )
            );

                /**
                 * Option :Site Footer
                 */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[site_footer]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Bullish_Customize_Control(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[site_footer]', array(
                            'type'    => 'select',
                            'section' => 'site-footer-section',
                            'label'   => esc_html__( 'Site Footer', 'bullish-plus' ),
                            'choices' => apply_filters( 'bullish_footer_layouts', array() ),
                        )
                    )
                );

        }
    }
}

BullishPlusCustomizerSiteFooter::instance();