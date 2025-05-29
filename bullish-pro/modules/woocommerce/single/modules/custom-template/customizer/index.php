<?php

/**
 * WooCommerce - Single - Module - Custom Template - Customizer Settings
 */


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Bullish_Shop_Customizer_Single_Default_CT')) {

    class Bullish_Shop_Customizer_Single_Default_CT
    {

        private static $_instance = null;

        public static function instance()
        {

            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct()
        {

            add_filter('bullish_woo_single_page_settings', array($this, 'single_page_settings'), 10, 1);
            add_action('customize_register', array($this, 'register'), 15);
        }

        function single_page_settings($settings)
        {

            $product_default_template = bullish_customizer_settings('wdt-single-product-default-template');
            $settings['product_default_template'] = $product_default_template;

            return $settings;
        }

        function register($wp_customize)
        {

            /**
             * Option : Product Template
             */
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[wdt-single-product-default-template]',
                array(
                    'type' => 'option'
                )
            );

            $wp_customize->add_control(
                new Bullish_Customize_Control(
                        $wp_customize,
                        BULLISH_CUSTOMISER_VAL . '[wdt-single-product-default-template]',
                        array(
                            'type' => 'select',
                            'label' => esc_html__('Product Template', 'bullish-pro'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => apply_filters(
                                'bullish_shop_single_product_default_template',
                                array(
                                    'woo-default' => esc_html__('WooCommerce Default', 'bullish-pro'),
                                    'admin-template' => esc_html__('Admin Default', 'bullish-pro'),
                                    'custom-template' => esc_html__('Custom Template', 'bullish-pro')
                                )
                            ),
                            'description' => esc_html__('"Custom template" option can be used to create Single product page as per your needs with Edit with elementor and drag the product related widgets.', 'bullish-pro'),

                        )
                    )
            );
            $elementor_templates = [];
            $templates = get_posts([
                'post_type' => 'elementor_library',
                'posts_per_page' => -1,
            ]);

            if ($templates) {
                foreach ($templates as $template) {
                    $elementor_templates[$template->ID] = $template->post_title;
                }
            }
            $wp_customize->add_setting(
                BULLISH_CUSTOMISER_VAL . '[wdt-single-product-default-elementortemplate]',
                array(
                    'type' => 'option'
                )
            );
            $wp_customize->add_control(
                new Bullish_Customize_Control(
                        $wp_customize,
                        BULLISH_CUSTOMISER_VAL . '[wdt-single-product-default-elementortemplate]',
                        array(
                            'type' => 'select',
                            'section' => 'woocommerce-single-page-default-section',
                            'label' => esc_html__('Select Single product Template', 'bullish-pro'),
                            'choices' => $elementor_templates,
                            'description' => esc_html__('"Admin template" will use the same template for all products.', 'bullish-pro'),
                            'dependency' => array('wdt-single-product-default-template', "==", "admin-template")
                        )
                    )
            );
        }
    }
}


if (!function_exists('bullish_shop_customizer_single_default_ct')) {
    function bullish_shop_customizer_single_default_ct()
    {
        return Bullish_Shop_Customizer_Single_Default_CT::instance();
    }
}

bullish_shop_customizer_single_default_ct();
