<?php
/**
 * Plugin Name:	Bullish Plus
 * Description: Adds additional features for Bullish Theme.
 * Version: 1.0.1
 * Author: the WeDesignTech team
 * Author URI: https://wedesignthemes.com/
 * Text Domain: bullish-plus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'BullishPlus' ) ) {
    class BullishPlus {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            /**
             * Before Hook
             */
            do_action( 'bullish_plus_before_plugin_load' );

                add_action('init', array($this, 'i18n'));
                add_action('init', array($this, 'define_constants_with_translations'), 11);
                add_filter( 'bullish_required_plugins_list', array( $this, 'upadate_required_plugins_list' ) );
                $this->define_constants_without_translations();
                $this->load_helper();
                $this->load_elementor();
                $this->load_customizer();
                $this->load_modules();
                $this->load_post_types();
    			add_filter( 'body_class', array( $this, 'add_body_classes' ) );
                add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );


            /**
             * After Hook
             */
            do_action( 'bullish_plus_after_plugin_load' );
        }

        function upadate_required_plugins_list($plugins_list) {

            $required_plugins = array(
                array(
                    'name'				=> 'Elementor',
                    'slug'				=> 'elementor',
                    'required'			=> false,
                    'force_activation'	=> false,
                ),
                array(
                    'name'				=> 'Contact Form 7',
                    'slug'				=> 'contact-form-7',
                    'required'			=> false,
                    'force_activation'	=> false,
                )
            );
            $new_plugins_list = array_merge($plugins_list, $required_plugins);

            return $new_plugins_list;

        }

        function i18n() {
            load_plugin_textdomain( 'bullish-plus', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        function define_constants_without_translations()
        {
            define('BULLISH_PLUS_VERSION', '1.0.0');
            define('BULLISH_PLUS_DIR_PATH', trailingslashit(plugin_dir_path(__FILE__)));
            define('BULLISH_PLUS_DIR_URL', trailingslashit(plugin_dir_url(__FILE__)));
            define('BULLISH_CUSTOMISER_VAL', 'bullish-customiser-option');
        }

        function define_constants_with_translations()
        {
            // Define constants that require translations here
            define('BULLISH_PLUS_REQ_CAPTION', esc_html__('Go Pro!', 'bullish-plus'));
            define('BULLISH_PLUS_REQ_DESC', '<p>' . esc_html__('Avtivate Bullish Pro plugin to avail additional features!', 'bullish-plus') . '</p>');
        }

        function load_helper() {
            require_once BULLISH_PLUS_DIR_PATH . 'functions.php';
        }

        function load_customizer() {
            require_once BULLISH_PLUS_DIR_PATH . 'customizer/customizer.php';
        }

        function load_elementor() {
            require_once BULLISH_PLUS_DIR_PATH . 'elementor/index.php';
        }

        function load_modules() {

            /**
             * Before Hook
             */
            do_action( 'bullish_plus_before_load_modules' );

                foreach( glob( BULLISH_PLUS_DIR_PATH. 'modules/*/index.php'  ) as $module ) {
                    include_once $module;
                }

            /**
             * After Hook
             */
            do_action( 'bullish_plus_after_load_modules' );
        }

        function load_post_types() {
            require_once BULLISH_PLUS_DIR_PATH . 'post-types/post-types.php';
        }

        function add_body_classes( $classes ) {
            $classes[] = 'bullish-plus-'.BULLISH_PLUS_VERSION;
            return $classes;
        }


        function enqueue_assets() {
            wp_enqueue_style( 'bullish-plus-common', BULLISH_PLUS_DIR_URL . 'assets/css/common.css', false, BULLISH_PLUS_VERSION, 'all');
        }

    }
}

if( !function_exists( 'bullish_plus' ) ) {
    function bullish_plus() {
        return BullishPlus::instance();
    }
}

if (class_exists ( 'BullishPlus' )) {
    bullish_plus();
}

register_activation_hook( __FILE__, 'bullish_plus_activation_hook' );
function bullish_plus_activation_hook() {
    $settings = get_option( BULLISH_CUSTOMISER_VAL );
    if(empty($settings)) {
        update_option( constant( 'BULLISH_CUSTOMISER_VAL' ), apply_filters( 'bullish_plus_customizer_default', array() ) );
    }
}