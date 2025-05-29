<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'BullishPlusServicesWidget' ) ) {
    class BullishPlusServicesWidget {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }
        function __construct() {
            add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
            add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_widget_styles' ) );
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_widget_scripts' ) );
        }

        function register_widgets( $widgets_manager ) {
            require BULLISH_PLUS_DIR_PATH. 'modules/services/elementor/widgets/services/class-widget-services.php';
            $widgets_manager->register( new \Elementor_Header_Services() );
        }

        function register_widget_styles() {
            wp_register_style( 'wdt-services-css',
                BULLISH_PLUS_DIR_URL . 'modules/services/elementor/widgets/services/assets/css/style.css', array(), BULLISH_PLUS_VERSION );
            wp_enqueue_style( 'wdt-services-css' );
        }

        function register_widget_scripts()
        {
            wp_register_script(
                'wdt-services-js',
                BULLISH_PLUS_DIR_URL . 'modules/services/elementor/widgets/services/assets/js/script.js',
                array(),
                BULLISH_PLUS_VERSION,
                true
            );
            wp_register_script(
                'wdt-services-swiper-js',
                BULLISH_PLUS_DIR_URL . 'assets/js/swiper.min.js',
                array(),
                BULLISH_PLUS_VERSION,
                true
            );
            wp_enqueue_script('wdt-services-swiper-js');
            wp_enqueue_script('wdt-services-js');
        }
        
    }
}

BullishPlusServicesWidget::instance();