<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'BullishPlusCustomizerSiteLayout' ) ) {
    class BullishPlusCustomizerSiteLayout {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            add_action( 'customize_register', array( $this, 'register' ), 15 );
            add_filter( 'body_class', array( $this, 'body_class' ) );
        }

        function register( $wp_customize ) {

            /**
             * Site Layout Section
             */
            $wp_customize->add_section(
                new Bullish_Customize_Section(
                    $wp_customize,
                    'site-layout-main-section',
                    array(
                        'title'    => esc_html__('Site Layout', 'bullish-plus'),
                        'priority' => bullish_customizer_panel_priority( 'layout' )
                    )
                )
            );

                /**
                 * Option :Site Layout
                 */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[site_layout]', array(
                        'type'    => 'option',
                        'default' => 'wide'
                    )
                );

                $wp_customize->add_control(
                    new Bullish_Customize_Control(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[site_layout]', array(
                            'type'    => 'select',
                            'section' => 'site-layout-main-section',
                            'label'   => esc_html__( 'Site Layout', 'bullish-plus' ),
                            'choices' => apply_filters( 'bullish_site_layouts', array() ),
                        )
                    )
                );


            do_action('bullish_site_layout_cutomizer_options', $wp_customize );

        }

        function body_class( $classes ) {
            $layout = bullish_customizer_settings('site_layout');

            global $post;
            $id = get_the_ID();
            $settings = get_post_meta( $id, '_bullish_custom_settings', TRUE );
            $settings = is_array( $settings ) ? $settings  : array();

            if( isset($settings['show-fixed-footer']) && !empty($settings['show-fixed-footer']) ) {
                $classes[] = 'wdt-fixed-footer-enabled';
            }

            if( !empty( $layout ) ) {
                $classes[] = $layout;
            }

            return $classes;
        }
    }
}

BullishPlusCustomizerSiteLayout::instance();