<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'BullishPlusFooterPostType' ) ) {

	class BullishPlusFooterPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'bullish_register_cpt' ) );
			add_filter ( 'template_include', array ( $this, 'bullish_template_include' ) );
		}

		function bullish_register_cpt() {

			$labels = array (
				'name'				 => __( 'Footers', 'bullish-plus' ),
				'singular_name'		 => __( 'Footer', 'bullish-plus' ),
				'menu_name'			 => __( 'Footers', 'bullish-plus' ),
				'add_new'			 => __( 'Add Footer', 'bullish-plus' ),
				'add_new_item'		 => __( 'Add New Footer', 'bullish-plus' ),
				'edit'				 => __( 'Edit Footer', 'bullish-plus' ),
				'edit_item'			 => __( 'Edit Footer', 'bullish-plus' ),
				'new_item'			 => __( 'New Footer', 'bullish-plus' ),
				'view'				 => __( 'View Footer', 'bullish-plus' ),
				'view_item' 		 => __( 'View Footer', 'bullish-plus' ),
				'search_items' 		 => __( 'Search Footers', 'bullish-plus' ),
				'not_found' 		 => __( 'No Footers found', 'bullish-plus' ),
				'not_found_in_trash' => __( 'No Footers found in Trash', 'bullish-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 26,
				'menu_icon' 			=> 'dashicons-editor-insertmore',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_footers', $args );
		}

		function bullish_template_include($template) {
			if ( is_singular( 'wdt_footers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_footers.php' ) ) {
					$template = BULLISH_PLUS_DIR_PATH . 'post-types/templates/single-wdt_footers.php';
				}
			}

			return $template;
		}
	}
}

BullishPlusFooterPostType::instance();