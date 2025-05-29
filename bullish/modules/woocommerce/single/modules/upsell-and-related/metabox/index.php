<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Bullish_Shop_Metabox_Single_Upsell_Related' ) ) {
    class Bullish_Shop_Metabox_Single_Upsell_Related {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

			add_filter( 'bullish_shop_product_custom_settings', array( $this, 'bullish_shop_product_custom_settings' ), 10 );

		}

        function bullish_shop_product_custom_settings( $options ) {

			$ct_dependency      = array ();
			$upsell_dependency  = array ( 'show-upsell', '==', 'true');
			$related_dependency = array ( 'show-related', '==', 'true');
			if( function_exists('bullish_shop_single_module_custom_template') ) {
				$ct_dependency['dependency'] 	= array ( 'product-template', '!=', 'custom-template');
				$upsell_dependency 				= array ( 'product-template|show-upsell', '!=|==', 'custom-template|true');
				$related_dependency 			= array ( 'product-template|show-related', '!=|==', 'custom-template|true');
			}

			$product_options = array (

				array_merge (
					array(
						'id'         => 'show-upsell',
						'type'       => 'select',
						'title'      => esc_html__('Show Upsell Products', 'bullish'),
						'class'      => 'chosen',
						'default'    => 'admin-option',
						'attributes' => array( 'data-depend-id' => 'show-upsell' ),
						'options'    => array(
							'admin-option' => esc_html__( 'Admin Option', 'bullish' ),
							'true'         => esc_html__( 'Show', 'bullish'),
							null           => esc_html__( 'Hide', 'bullish'),
						)
					),
					$ct_dependency
				),

				array(
					'id'         => 'upsell-column',
					'type'       => 'select',
					'title'      => esc_html__('Choose Upsell Column', 'bullish'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'bullish' ),
						1              => esc_html__( 'One Column', 'bullish' ),
						2              => esc_html__( 'Two Columns', 'bullish' ),
						3              => esc_html__( 'Three Columns', 'bullish' ),
						4              => esc_html__( 'Four Columns', 'bullish' ),
					),
					'dependency' => $upsell_dependency
				),

				array(
					'id'         => 'upsell-limit',
					'type'       => 'select',
					'title'      => esc_html__('Choose Upsell Limit', 'bullish'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'bullish' ),
						1              => esc_html__( 'One', 'bullish' ),
						2              => esc_html__( 'Two', 'bullish' ),
						3              => esc_html__( 'Three', 'bullish' ),
						4              => esc_html__( 'Four', 'bullish' ),
						5              => esc_html__( 'Five', 'bullish' ),
						6              => esc_html__( 'Six', 'bullish' ),
						7              => esc_html__( 'Seven', 'bullish' ),
						8              => esc_html__( 'Eight', 'bullish' ),
						9              => esc_html__( 'Nine', 'bullish' ),
						10              => esc_html__( 'Ten', 'bullish' ),
					),
					'dependency' => $upsell_dependency
				),

				array_merge (
					array(
						'id'         => 'show-related',
						'type'       => 'select',
						'title'      => esc_html__('Show Related Products', 'bullish'),
						'class'      => 'chosen',
						'default'    => 'admin-option',
						'attributes' => array( 'data-depend-id' => 'show-related' ),
						'options'    => array(
							'admin-option' => esc_html__( 'Admin Option', 'bullish' ),
							'true'         => esc_html__( 'Show', 'bullish'),
							null           => esc_html__( 'Hide', 'bullish'),
						)
					),
					$ct_dependency
				),

				array(
					'id'         => 'related-column',
					'type'       => 'select',
					'title'      => esc_html__('Choose Related Column', 'bullish'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'bullish' ),
						2              => esc_html__( 'Two Columns', 'bullish' ),
						3              => esc_html__( 'Three Columns', 'bullish' ),
						4              => esc_html__( 'Four Columns', 'bullish' ),
					),
					'dependency' => $related_dependency
				),

				array(
					'id'         => 'related-limit',
					'type'       => 'select',
					'title'      => esc_html__('Choose Related Limit', 'bullish'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'bullish' ),
						1              => esc_html__( 'One', 'bullish' ),
						2              => esc_html__( 'Two', 'bullish' ),
						3              => esc_html__( 'Three', 'bullish' ),
						4              => esc_html__( 'Four', 'bullish' ),
						5              => esc_html__( 'Five', 'bullish' ),
						6              => esc_html__( 'Six', 'bullish' ),
						7              => esc_html__( 'Seven', 'bullish' ),
						8              => esc_html__( 'Eight', 'bullish' ),
						9              => esc_html__( 'Nine', 'bullish' ),
						10              => esc_html__( 'Ten', 'bullish' ),
					),
					'dependency' => $related_dependency
				)

			);

			$options = array_merge( $options, $product_options );

			return $options;

		}

    }
}

Bullish_Shop_Metabox_Single_Upsell_Related::instance();