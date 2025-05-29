<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'BullishProPostSimple' ) ) {
    class BullishProPostSimple {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'bullish_post_styles', array( $this, 'add_post_styles_option' ) );
            add_action( 'bullish_hook_container_before', array( $this, 'add_post_hook_container_before' ) );
        }

        function add_post_styles_option( $options ) {
            $options['simple'] = esc_html__('Simple', 'bullish-pro');
            return $options;
        }

        function add_post_hook_container_before() {

            if(is_singular('post')) {

                $post_id = get_the_ID();
                $post_style = bullish_get_single_post_style( $post_id );

                if($post_style != 'simple') {
                    return;
                }

                $template_args['post_ID'] = $post_id;
                $template_args['post_Style'] = $post_style;
                $template_args = array_merge( $template_args, bullish_single_post_params() );

                ob_start();
                echo '<div class="post-simple post-header">';
                    bullish_template_part( 'post', 'templates/simple/parts/date', '', $template_args );
                    if( $template_args['enable_title'] ) :
                        bullish_template_part( 'post', 'templates/post-extra/title', '', $template_args );
                    endif;
                    bullish_template_part( 'post', 'templates/simple/parts/category', '', $template_args );
                echo '</div>';
                echo ob_get_clean();

            }

        }

    }
}

BullishProPostSimple::instance();