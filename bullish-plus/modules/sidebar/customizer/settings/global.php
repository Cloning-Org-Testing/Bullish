<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'BullishPlusGlobalSibarSettings' ) ) {
    class BullishPlusGlobalSibarSettings {

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
        }

        function default( $option ) {
            $option['global_sidebar_layout'] = 'content-full-width';
            $option['global_sidebar']        = '';
            $option['hide_standard_sidebar'] = '';
             $option['hide_toogle_sidebar'] = '';
            $option['hide_sidebardisabletoogle'] = '';
            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Global Sidebar Panel
             */
            $wp_customize->add_section(
                new Bullish_Customize_Section(
                    $wp_customize,
                    'site-global-sidebar-section',
                    array(
                        'title'    => esc_html__('Global Sidebar', 'bullish-plus'),
                        'panel'    => 'site-widget-main-panel',
                        'priority' => 5
                    )
                )
            );

                /**
                 * Option: Global Sidebar Layout
                 */
                    $wp_customize->add_setting(
                        BULLISH_CUSTOMISER_VAL . '[global_sidebar_layout]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Bullish_Customize_Control_Radio_Image(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[global_sidebar_layout]', array(
                            'type'    => 'wdt-radio-image',
                            'label'   => esc_html__( 'Global Sidebar Layout', 'bullish-plus'),
                            'section' => 'site-global-sidebar-section',
                            'choices' => apply_filters( 'bullish_global_sidebar_layouts', array(
                                'content-full-width' => array(
                                    'label' => esc_html__( 'Without Sidebar', 'bullish-plus' ),
                                    'path'  =>  BULLISH_PLUS_DIR_URL . 'modules/sidebar/customizer/images/without-sidebar.png'
                                ),
                                'with-left-sidebar'  => array(
                                    'label' => esc_html__( 'With Left Sidebar', 'bullish-plus' ),
                                    'path'  =>  BULLISH_PLUS_DIR_URL . 'modules/sidebar/customizer/images/left-sidebar.png'
                                ),
                                'with-right-sidebar' => array(
                                    'label' => esc_html__( 'With Right Sidebar', 'bullish-plus' ),
                                    'path'  =>  BULLISH_PLUS_DIR_URL . 'modules/sidebar/customizer/images/right-sidebar.png'
                                ),
                            ) )
                        )
                    ) );

                /**
                 * Option : Hide Standard Sidebar
                 */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[hide_standard_sidebar]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Bullish_Customize_Control_Switch(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[hide_standard_sidebar]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'site-global-sidebar-section',
                            'label'   => esc_html__( 'Hide Standard Sidebar', 'bullish-plus' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'bullish-plus' ),
                                'off' => esc_attr__( 'No', 'bullish-plus' )
                            )
                        )
                    )
                );

                  /**
                 * Option : Hide Toggle on  Sidebar
                 */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[hide_toogle_sidebar]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new bullish_Customize_Control_Switch(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[hide_toogle_sidebar]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'site-global-sidebar-section',
                            'label'   => esc_html__( 'Enable Toggle Sidebar', 'bullish-plus' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'bullish-plus' ),
                                'off' => esc_attr__( 'No', 'bullish-plus' )
                            )
                        )
                    )
                );

                  /**
                 * Option : Disable Sidebartoggle
                 */
                $wp_customize->add_setting(
                    BULLISH_CUSTOMISER_VAL . '[hide_sidebardisabletoogle]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new bullish_Customize_Control_Switch(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[hide_sidebardisabletoogle]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'site-global-sidebar-section',
                            'description' => esc_html__( 'Enable option for toggle open', 'bullish-plus' ),
                            'label'   => esc_html__( 'Toogle View', 'bullish-plus' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'bullish-plus' ),
                                'off' => esc_attr__( 'No', 'bullish-plus' )
                            ),
                            'dependency'  => array( 'hide_toogle_sidebar', '==', 'true' ),
                        )
                    )
                );

                if ( ! defined( 'BULLISH_PRO_VERSION' ) ) {
                    $wp_customize->add_control(
                        new Bullish_Customize_Control_Separator(
                            $wp_customize, BULLISH_CUSTOMISER_VAL . '[bullish-plus-site-global-sidebar-separator]',
                            array(
                                'type'        => 'wdt-separator',
                                'section'     => 'site-global-sidebar-section',
                                'settings'    => array(),
                                'caption'     => BULLISH_PLUS_REQ_CAPTION,
                                'description' => BULLISH_PLUS_REQ_DESC,
                            )
                        )
                    );
                }

        }
    }
}

BullishPlusGlobalSibarSettings::instance();