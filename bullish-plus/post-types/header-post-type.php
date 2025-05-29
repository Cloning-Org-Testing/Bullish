<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'BullishPlusHeaderPostType' ) ) {

	class BullishPlusHeaderPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'bullish_register_cpt' ), 5 );
			add_filter ( 'template_include', array ( $this, 'bullish_template_include' ) );
		}

		function bullish_register_cpt() {

			$labels = array (
				'name'				 => __( 'Headers', 'bullish-plus' ),
				'singular_name'		 => __( 'Header', 'bullish-plus' ),
				'menu_name'			 => __( 'Headers', 'bullish-plus' ),
				'add_new'			 => __( 'Add Header', 'bullish-plus' ),
				'add_new_item'		 => __( 'Add New Header', 'bullish-plus' ),
				'edit'				 => __( 'Edit Header', 'bullish-plus' ),
				'edit_item'			 => __( 'Edit Header', 'bullish-plus' ),
				'new_item'			 => __( 'New Header', 'bullish-plus' ),
				'view'				 => __( 'View Header', 'bullish-plus' ),
				'view_item' 		 => __( 'View Header', 'bullish-plus' ),
				'search_items' 		 => __( 'Search Headers', 'bullish-plus' ),
				'not_found' 		 => __( 'No Headers found', 'bullish-plus' ),
				'not_found_in_trash' => __( 'No Headers found in Trash', 'bullish-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 25,
				'menu_icon' 			=> 'dashicons-heading',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_headers', $args );
		}

		function bullish_template_include($template) {
			if ( is_singular( 'wdt_headers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_headers.php' ) ) {
					$template = BULLISH_PLUS_DIR_PATH . 'post-types/templates/single-wdt_headers.php';
				}
			}

			return $template;
		}
	}
}

BullishPlusHeaderPostType::instance();