<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'BullishPlusTopHookSettings' ) ) {
    class BullishPlusTopHookSettings {
        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            add_filter( 'bullish_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);

            /**
             * Load Top Hook Content in theme.
             */
            add_action( 'bullish_hook_top', array( $this, 'hook_top_content' ) );
        }

        function default( $option ) {
            $option['enable_top_hook'] = 0;
            $option['top_hook']        = '';
            return $option;
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new Bullish_Customize_Section(
                    $wp_customize,
                    'site-top-hook-section',
                    array(
                        'title'    => esc_html__('Top Hook', 'bullish-plus'),
                        'panel'    => 'site-hook-main-panel',
                        'priority' => 5,
                    )
                )
            );

                /**
                 * Option : Enable Top Hook
                 */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[enable_top_hook]', array(
                        'type'    => 'option',
                        'default' => '',
                    )
                );

                $wp_customize->add_control(
                    new Bullish_Customize_Control_Switch(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[enable_top_hook]', array(
                            'type'        => 'wdt-switch',
                            'section'     => 'site-top-hook-section',
                            'label'       => esc_html__( 'Enable Top Hook', 'bullish-plus' ),
                            'description' => esc_html__('YES! to enable top hook.', 'bullish-plus'),
                            'choices'     => array(
                                'on'  => esc_attr__( 'Yes', 'bullish-plus' ),
                                'off' => esc_attr__( 'No', 'bullish-plus' )
                            )
                        )
                    )
                );

                /**
                 * Option : Top Hook
                 */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[top_hook]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Bullish_Customize_Control(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[top_hook]', array(
                            'type'        => 'textarea',
                            'section'     => 'site-top-hook-section',
                            'label'       => esc_html__( 'Top Hook', 'bullish-plus' ),
                            'dependency'  => array( 'enable_top_hook', '!=', '' ),
                            'description' => esc_html__('Paste your top hook, Executes after the opening &lt;body&gt; tag.', 'bullish-plus'),
                        )
                    )
                );

        }

        function hook_top_content() {
            $enable_top_hook = bullish_customizer_settings( 'enable_top_hook' );
            $top_hook        = bullish_customizer_settings( 'top_hook' );

            if( $enable_top_hook && !empty( $top_hook ) ) {
                echo do_shortcode( stripslashes( $top_hook ) );
            }
        }

    }
}

BullishPlusTopHookSettings::instance();