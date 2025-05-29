<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'BullishProBCTemplate' ) ) {
    class BullishProBCTemplate {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_frontend();
        }

        function load_frontend() {

            add_filter( 'bullish_google_fonts_list', array( $this, 'fonts_list' ) );

            add_filter( 'bullish_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'bullish_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'bullish_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'bullish_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );

        }

        function fonts_list( $fonts ) {
            $title = bullish_customizer_frontend_font( bullish_customizer_settings('breadcrumb_title_typo'), array() );
            if( count( $title ) ) {
                array_push( $fonts, $title[0] );
            }

            $content = bullish_customizer_frontend_font( bullish_customizer_settings('breadcrumb_typo'), array() );
            if( count( $content ) ) {
                array_push( $fonts, $content[0] );
            }

            return $fonts;
        }

        function base_style( $style ) {

            $bg                = bullish_customizer_settings('breadcrumb_background');
            $enable_overlay    = bullish_customizer_settings('breadcrumb_overlay_bg_color');
            $gradient_color    = bullish_customizer_settings('breadcrumb_background_gradient_color');
            $title_typo        = bullish_customizer_settings('breadcrumb_title_typo');
            $title_color       = bullish_customizer_settings('breadcrumb_title_color');
            $content_typo      = bullish_customizer_settings('breadcrumb_typo');
            $content_color     = bullish_customizer_settings('breadcrumb_text_color');
            $content_a_color   = bullish_customizer_settings('breadcrumb_link_color');
            $content_a_h_color = bullish_customizer_settings('breadcrumb_link_hover_color');
            $bg['gradient-background-color'] = isset($gradient_color) ? $gradient_color : '';

            $title_css  = bullish_customizer_typography_settings( $title_typo );
            $title_css .= bullish_customizer_color_settings( $title_color );
            if( !empty( $title_css ) ) {
                $style .= bullish_customizer_dynamic_style( '.dark-bg-breadcrumb .main-title-section h1,  .main-title-section h1', $title_css );
            }

            $content_css  = bullish_customizer_typography_settings( $content_typo );
            $content_css .= bullish_customizer_color_settings( $content_color );
            if( !empty( $content_css ) ) {
                $style .= bullish_customizer_dynamic_style( '.dark-bg-breadcrumb .breadcrumb, .dark-bg-breadcrumb .breadcrumb span.current, .breadcrumb, .breadcrumb span.current', $content_css );
            }

            $content_a_css = bullish_customizer_color_settings( $content_a_color );
            if( !empty( $content_a_css ) ) {
                $style .= bullish_customizer_dynamic_style( '.dark-bg-breadcrumb .breadcrumb a, .breadcrumb a', $content_a_css );
            }

            $content_a_h_css = bullish_customizer_color_settings( $content_a_h_color );
            if( !empty( $content_a_h_css ) ) {
                $style .= bullish_customizer_dynamic_style( '.dark-bg-breadcrumb .breadcrumb a:hover, .breadcrumb a:hover', $content_a_h_css );
            }

            if(is_singular()) {
                global $post;
                $post_meta = get_post_meta( $post->ID, '_bullish_breadcrumb_settings', true );
                $post_meta = is_array( $post_meta ) ? $post_meta : array();

                if(array_key_exists( 'layout', $post_meta ) && ($post_meta['layout'] == 'individual-option' || $post_meta['layout'] == 'disable') ) {
                    return $style;
                }
            }

            $bg_css = bullish_customizer_bg_settings( $bg );

            if( !empty( $bg_css ) && empty( $enable_overlay ) ) {

                $style .= bullish_customizer_dynamic_style( '.main-title-section-wrapper.overlay-wrapper.dark-bg-breadcrumb > .main-title-section-bg, .main-title-section-wrapper.overlay-wrapper > .main-title-section-bg, .main-title-section-wrapper.dark-bg-breadcrumb > .main-title-section-bg, .main-title-section-wrapper > .main-title-section-bg', $bg_css );

            } elseif( !empty( $enable_overlay ) ) {

                $overlay_color = array_key_exists( 'background-color', $bg ) ? $bg['background-color'] : '';
                $overlay_gradient_color = array_key_exists( 'gradient-background-color', $bg ) ? $bg['gradient-background-color'] : '';
                $bg['background-color'] = '';
                $bg['gradient-background-color'] = '';

                $bg_css = bullish_customizer_bg_settings( $bg );

                if( !empty( $bg_css ) ) {
                    $style .= bullish_customizer_dynamic_style( '.main-title-section-wrapper.overlay-wrapper.dark-bg-breadcrumb > .main-title-section-bg, .main-title-section-wrapper.overlay-wrapper > .main-title-section-bg, .main-title-section-wrapper.dark-bg-breadcrumb > .main-title-section-bg, .main-title-section-wrapper > .main-title-section-bg', $bg_css );
                }

                if( !empty( $overlay_color ) || !empty( $overlay_gradient_color ) ) {
                    $bg_css = bullish_customizer_bg_settings( array( 'background-color' => $overlay_color, 'gradient-background-color' => $overlay_gradient_color, 'breadcrumb_overlay_bg_color' => true ) );
                    $style .= bullish_customizer_dynamic_style( '.main-title-section-wrapper.overlay-wrapper.dark-bg-breadcrumb > .main-title-section-bg:after, .main-title-section-wrapper.overlay-wrapper > .main-title-section-bg:after, .main-title-section-wrapper.dark-bg-breadcrumb > .main-title-section-bg:after, .main-title-section-wrapper > .main-title-section-bg:after', $bg_css );
                }

            }

            return $style;
        }

        function tablet_landscape_style( $style ) {
            $title_typo     = bullish_customizer_settings('breadcrumb_title_typo');
            $title_typo_css = bullish_customizer_responsive_typography_settings( $title_typo, 'tablet-ls' );
            if( !empty( $title_typo_css) ) {
                $style .= bullish_customizer_dynamic_style( '.dark-bg-breadcrumb .main-title-section h1,  .main-title-section h1', $title_typo_css );
            }

            $content_typo     = bullish_customizer_settings('breadcrumb_typo');
            $content_typo_css = bullish_customizer_responsive_typography_settings( $content_typo, 'tablet-ls' );
            if( !empty( $content_typo_css) ) {
                $style .= bullish_customizer_dynamic_style( '.breadcrumb', $content_typo_css );
            }

            return $style;
        }

        function tablet_portrait( $style ) {
            $title_typo     = bullish_customizer_settings('breadcrumb_title_typo');
            $title_typo_css = bullish_customizer_responsive_typography_settings( $title_typo, 'tablet' );
            if( !empty( $title_typo_css) ) {
                $style .= bullish_customizer_dynamic_style( '.dark-bg-breadcrumb .main-title-section h1,  .main-title-section h1', $title_typo_css );
            }

            $content_typo     = bullish_customizer_settings('breadcrumb_typo');
            $content_typo_css = bullish_customizer_responsive_typography_settings( $content_typo, 'tablet' );
            if( !empty( $content_typo_css) ) {
                $style .= bullish_customizer_dynamic_style( '.breadcrumb', $content_typo_css );
            }

            return $style;
        }

        function mobile_style( $style ) {
            $title_typo     = bullish_customizer_settings('breadcrumb_title_typo');
            $title_typo_css = bullish_customizer_responsive_typography_settings( $title_typo, 'mobile' );
            if( !empty( $title_typo_css) ) {
                $style .= bullish_customizer_dynamic_style( '.dark-bg-breadcrumb .main-title-section h1,  .main-title-section h1', $title_typo_css );
            }

            $content_typo     = bullish_customizer_settings('breadcrumb_typo');
            $content_typo_css = bullish_customizer_responsive_typography_settings( $content_typo, 'mobile' );
            if( !empty( $content_typo_css) ) {
                $style .= bullish_customizer_dynamic_style( '.breadcrumb', $content_typo_css );
            }

            return $style;
        }

    }
}

BullishProBCTemplate::instance();