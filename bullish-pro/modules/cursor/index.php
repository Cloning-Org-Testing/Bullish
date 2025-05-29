<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'BullishProCursor' ) ) {
    class BullishProCursor {

        private static $_instance = null;

        private $enable_cursor_effect = false;
        private $cursor_type = 'type-1';
        private $cursor_link_hover_effect = '';
        private $cursor_lightbox_hover_effect = '';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->enable_cursor_effect = bullish_customizer_settings( 'enable_cursor_effect' );
            $this->cursor_type = bullish_customizer_settings( 'cursor_type' );
            $this->cursor_link_hover_effect = bullish_customizer_settings( 'cursor_link_hover_effect' );
            $this->cursor_lightbox_hover_effect = bullish_customizer_settings( 'cursor_lightbox_hover_effect' );
            $this->load_modules();
            $this->frontend();
        }

        function load_modules() {
            include_once BULLISH_PRO_DIR_PATH.'modules/cursor/customizer/index.php';
        }

        function frontend() {
            if($this->enable_cursor_effect) {
                add_action( 'bullish_after_main_css', array( $this, 'enqueue_assets' ) );
                add_action( 'bullish_hook_top', array( $this, 'load_template' ) );
            }
        }

        function enqueue_assets() {
            if($this->enable_cursor_effect) {
                wp_enqueue_style( 'bullish-cursor', BULLISH_PRO_DIR_URL . 'modules/cursor/assets/css/cursor.css', false, BULLISH_PRO_VERSION, 'all');
                wp_enqueue_script( 'bullish-cursor', BULLISH_PRO_DIR_URL . 'modules/cursor/assets/js/cursor.js', array('jquery'), BULLISH_PRO_VERSION, true );
                wp_localize_script('bullish-cursor', 'wdtCursorObjects', array (
                    'enableCursorEffect' => $this->enable_cursor_effect
                ));
            }
        }

        function load_template() {
            echo '<div class="wdt-cursor-wrapper '.esc_attr($this->cursor_type).' '.esc_attr($this->cursor_link_hover_effect).' '.esc_attr($this->cursor_lightbox_hover_effect).'">
                    <div class="wdt-cursor wdt-cursor-outer"></div>
                    <div class="wdt-cursor wdt-cursor-inner"></div>
                </div>';
        }

    }
}

BullishProCursor::instance();
