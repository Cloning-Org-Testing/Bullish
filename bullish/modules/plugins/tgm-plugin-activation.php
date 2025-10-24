<?php
/**
 * Recommends plugins for use with the theme via the TGMA Script
 *
 * @package Bullish WordPress theme
 */

function bullish_tgmpa_plugins_register() {

	// Get array of recommended plugins.

	$plugins_list = array(

		array(
			'name' => esc_html__('Bullish Plus', 'bullish'),
			'slug' => 'bullish-plus',
			'source' => BULLISH_MODULE_DIR . '/plugins/bullish-plus.rar',
			'required' => true,
			'version' => '1.0.1',
			'force_activation' => false,
			'force_deactivation' => false,
		),
		array(
			'name' => esc_html__('Bullish Pro', 'bullish'),
			'slug' => 'bullish-pro',
			'source' => BULLISH_MODULE_DIR . '/plugins/bullish-pro.rar',
			'required' => true,
			'version' => '1.0.0',
			'force_activation' => false,
			'force_deactivation' => false,
		),
		array(
			'name' => esc_html__('Elementor', 'bullish'),
			'slug' => 'elementor',
			'required' => true,
		),
		array(
			'name' => esc_html__('WeDesignTech Elementor Addon', 'bullish'),
			'slug' => 'wedesigntech-elementor-addon',
			'source' => BULLISH_MODULE_DIR . '/plugins/wedesigntech-elementor-addon.rar',
			'required' => true,
			'version' => '1.0.0',
			'force_activation' => false,
			'force_deactivation' => false,
		),
		array(
			'name' => esc_html__('WeDesignTech Portfolio', 'bullish'),
			'slug' => 'wedesigntech-portfolio',
			'source' => BULLISH_MODULE_DIR . '/plugins/wedesigntech-portfolio.rar',
			'required' => true,
			'version' => '1.0.0',
			'force_activation' => false,
			'force_deactivation' => false,
		),
		array(
			'name' => esc_html__('Contact Form 7', 'bullish'),
			'slug' => 'contact-form-7',
			'required' => true,
		),
		array(
			'name' => esc_html__('One Click Demo Import', 'bullish'),
			'slug' => 'one-click-demo-import',
			'required' => true,
		)
	);

    $plugins = apply_filters('bullish_required_plugins_list', $plugins_list);

	// Register notice
	tgmpa( $plugins, array(
		'id'           => 'bullish_theme',
		'domain'       => 'bullish',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => true,
		'dismissable'  => true,
	) );

}
add_action( 'tgmpa_register', 'bullish_tgmpa_plugins_register' );