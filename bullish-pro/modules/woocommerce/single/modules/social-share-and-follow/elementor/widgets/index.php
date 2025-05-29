<?php

namespace BullishElementor\Widgets;
use BullishElementor\Widgets\Bullish_Shop_Widget_Product_Summary;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;


class Bullish_Shop_Widget_Product_Summary_Extend extends Bullish_Shop_Widget_Product_Summary {

	function dynamic_register_controls() {

		$this->start_controls_section( 'product_summary_extend_section', array(
			'label' => esc_html__( 'Social Options', 'bullish-pro' ),
		) );

			$this->add_control( 'share_follow_type', array(
				'label'   => esc_html__( 'Share / Follow Type', 'bullish-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'share',
				'options' => array(
					''       => esc_html__('None', 'bullish-pro'),
					'share'  => esc_html__('Share', 'bullish-pro'),
					'follow' => esc_html__('Follow', 'bullish-pro'),
				),
				'description' => esc_html__( 'Choose between Share / Follow you would like to use.', 'bullish-pro' ),
			) );

			$this->add_control( 'social_icon_style', array(
				'label'   => esc_html__( 'Social Icon Style', 'bullish-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'simple'        => esc_html__( 'Simple', 'bullish-pro' ),
					'bgfill'        => esc_html__( 'BG Fill', 'bullish-pro' ),
					'brdrfill'      => esc_html__( 'Border Fill', 'bullish-pro' ),
					'skin-bgfill'   => esc_html__( 'Skin BG Fill', 'bullish-pro' ),
					'skin-brdrfill' => esc_html__( 'Skin Border Fill', 'bullish-pro' ),
				),
				'description' => esc_html__( 'This option is applicable for all buttons used in product summary.', 'bullish-pro' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

			$this->add_control( 'social_icon_radius', array(
				'label'   => esc_html__( 'Social Icon Radius', 'bullish-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'square'  => esc_html__( 'Square', 'bullish-pro' ),
					'rounded' => esc_html__( 'Rounded', 'bullish-pro' ),
					'circle'  => esc_html__( 'Circle', 'bullish-pro' ),
				),
				'condition'   => array(
					'social_icon_style' => array ('bgfill', 'brdrfill', 'skin-bgfill', 'skin-brdrfill'),
					'share_follow_type' => array ('share', 'follow')
				),
			) );

			$this->add_control( 'social_icon_inline_alignment', array(
				'label'        => esc_html__( 'Social Icon Inline Alignment', 'bullish-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'bullish-pro' ),
				'label_off'    => esc_html__( 'no', 'bullish-pro' ),
				'default'      => '',
				'return_value' => 'true',
				'description'  => esc_html__( 'This option is applicable for all buttons used in product summary.', 'bullish-pro' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

		$this->end_controls_section();

	}

}