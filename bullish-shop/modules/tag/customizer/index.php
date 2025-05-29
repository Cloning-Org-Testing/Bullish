<?php

/**
 * Listing Customizer - Tag Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Shop_Listing_Customizer_Tag' ) ) {

    class Bullish_Shop_Listing_Customizer_Tag {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'bullish_woo_tag_page_default_settings', array( $this, 'tag_page_default_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 40);
            add_action( 'bullish_hook_content_before', array( $this, 'woo_handle_product_breadcrumb' ), 10);

        }

        function tag_page_default_settings( $settings ) {

            $disable_breadcrumb             = bullish_customizer_settings('wdt-woo-tag-page-disable-breadcrumb' );
            $settings['disable_breadcrumb'] = $disable_breadcrumb;

            $show_sorter_on_header              = bullish_customizer_settings('wdt-woo-tag-page-show-sorter-on-header' );
            $settings['show_sorter_on_header']  = $show_sorter_on_header;

            $sorter_header_elements             = bullish_customizer_settings('wdt-woo-tag-page-sorter-header-elements' );
            $settings['sorter_header_elements'] = (is_array($sorter_header_elements) && !empty($sorter_header_elements) ) ? $sorter_header_elements : array ();

            $show_sorter_on_footer              = bullish_customizer_settings('wdt-woo-tag-page-show-sorter-on-footer' );
            $settings['show_sorter_on_footer']  = $show_sorter_on_footer;

            $sorter_footer_elements             = bullish_customizer_settings('wdt-woo-tag-page-sorter-footer-elements' );
            $settings['sorter_footer_elements'] = (is_array($sorter_footer_elements) && !empty($sorter_footer_elements) ) ? $sorter_footer_elements : array ();

            return $settings;

        }

        function register( $wp_customize ) {

                /**
                * Option : Disable Breadcrumb
                */
                    $wp_customize->add_setting(
                        BULLISH_CUSTOMISER_VAL . '[wdt-woo-tag-page-disable-breadcrumb]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Bullish_Customize_Control_Switch(
                            $wp_customize, BULLISH_CUSTOMISER_VAL . '[wdt-woo-tag-page-disable-breadcrumb]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Disable Breadcrumb', 'bullish-shop'),
                                'section' => 'woocommerce-tag-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'bullish-shop' ),
                                    'off' => esc_attr__( 'No', 'bullish-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Show Sorter On Header
                 */
                    $wp_customize->add_setting(
                        BULLISH_CUSTOMISER_VAL . '[wdt-woo-tag-page-show-sorter-on-header]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Bullish_Customize_Control_Switch(
                            $wp_customize, BULLISH_CUSTOMISER_VAL . '[wdt-woo-tag-page-show-sorter-on-header]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Sorter On Header', 'bullish-shop'),
                                'section' => 'woocommerce-tag-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'bullish-shop' ),
                                    'off' => esc_attr__( 'No', 'bullish-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Sorter Header Elements
                 */
                    $wp_customize->add_setting(
                        BULLISH_CUSTOMISER_VAL . '[wdt-woo-tag-page-sorter-header-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Bullish_Customize_Control_Sortable(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[wdt-woo-tag-page-sorter-header-elements]', array(
                            'type' => 'wdt-sortable',
                            'label' => esc_html__( 'Sorter Header Elements', 'bullish-shop'),
                            'section' => 'woocommerce-tag-page-section',
                            'choices' => apply_filters( 'bullish_tag_header_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter - OrderBy', 'bullish-shop' ),
                                'filters_widget_area'  => esc_html__( 'Filters - Widget Area', 'bullish-shop' ),
                                'result_count'         => esc_html__( 'Result Count', 'bullish-shop' ),
                                'pagination'           => esc_html__( 'Pagination', 'bullish-shop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'bullish-shop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'bullish-shop' )
                            )),
                        )
                    ));

                /**
                 * Option : Show Sorter On Footer
                 */
                    $wp_customize->add_setting(
                        BULLISH_CUSTOMISER_VAL . '[wdt-woo-tag-page-show-sorter-on-footer]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Bullish_Customize_Control_Switch(
                            $wp_customize, BULLISH_CUSTOMISER_VAL . '[wdt-woo-tag-page-show-sorter-on-footer]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Sorter On Footer', 'bullish-shop'),
                                'section' => 'woocommerce-tag-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'bullish-shop' ),
                                    'off' => esc_attr__( 'No', 'bullish-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Sorter Footer Elements
                 */
                    $wp_customize->add_setting(
                        BULLISH_CUSTOMISER_VAL . '[wdt-woo-tag-page-sorter-footer-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Bullish_Customize_Control_Sortable(
                        $wp_customize, BULLISH_CUSTOMISER_VAL . '[wdt-woo-tag-page-sorter-footer-elements]', array(
                            'type' => 'wdt-sortable',
                            'label' => esc_html__( 'Sorter Footer Elements', 'bullish-shop'),
                            'section' => 'woocommerce-tag-page-section',
                            'choices' => apply_filters( 'bullish_tag_footer_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter', 'bullish-shop' ),
                                'result_count'         => esc_html__( 'Result Count', 'bullish-shop' ),
                                'pagination'           => esc_html__( 'Pagination', 'bullish-shop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'bullish-shop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'bullish-shop' )
                            )),
                        )
                    ));

        }

        function woo_handle_product_breadcrumb() {

            if(is_product_tag() && bullish_customizer_settings('wdt-woo-tag-page-disable-breadcrumb' )) {
                remove_action('bullish_breadcrumb', 'bullish_breadcrumb_template');
            }

        }

    }

}


if( !function_exists('bullish_shop_listing_customizer_tag') ) {
	function bullish_shop_listing_customizer_tag() {
		return Bullish_Shop_Listing_Customizer_Tag::instance();
	}
}

bullish_shop_listing_customizer_tag();