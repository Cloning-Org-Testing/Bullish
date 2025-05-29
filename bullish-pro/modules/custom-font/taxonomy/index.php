<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'BullishProTaxonomyCustomFont' ) ) {
    class BullishProTaxonomyCustomFont {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            add_action( 'init', array( $this, 'register_taxonomy' ) );
            add_action( 'admin_menu', array( $this, 'admin_menu' ), 150 );

            add_action( 'admin_head', array( $this, 'taxonomy_css' ) );
            add_filter( 'manage_edit-bullish_custom_fonts_columns', array( $this, 'remove_fields' ) );
            add_filter( 'upload_mimes', array( $this, 'add_fonts_to_allowed_mimes' ) );
			add_filter( 'wp_check_filetype_and_ext', array( $this, 'update_mime_types' ), 10, 3 );
            add_action( 'wp_head', array( __CLASS__, 'output_font_display_css' ) );
            add_filter( 'cs_taxonomy_options', array( $this, 'register_fields' ) );
        }

        function register_taxonomy() {

            $labels = array(
                'name'          => esc_html__('Custom Fonts', 'bullish-pro' ),
                'singular_name' => esc_html__( 'Font', 'bullish-pro' ),
                'menu_name'     => _x( 'Custom Fonts', 'Admin menu name', 'bullish-pro' ),
                'search_items'  => esc_html__( 'Search Fonts', 'bullish-pro' ),
                'all_items'     => esc_html__( 'All Fonts', 'bullish-pro' ),
                'edit_item'     => esc_html__( 'Edit Font', 'bullish-pro' ),
                'update_item'   => esc_html__( 'Update Font', 'bullish-pro' ),
                'add_new_item'  => esc_html__( 'Add New Font', 'bullish-pro' ),
                'new_item_name' => esc_html__( 'New Font Name', 'bullish-pro' ),
                'not_found'     => esc_html__( 'No fonts found', 'bullish-pro' ),
                'back_to_items' => esc_html__( 'Back to fonts', 'bullish-pro' ),
			);

            $args   = array(
				'hierarchical'      => false,
				'labels'            => $labels,
				'public'            => false,
				'show_in_nav_menus' => false,
				'show_ui'           => true,
				'capabilities'      => array( 'edit_theme_options' ),
				'query_var'         => false,
				'rewrite'           => false,
			);

            register_taxonomy( 'bullish_custom_fonts','', $args );
        }

        function admin_menu() {
            add_submenu_page( 'themes.php',
                esc_html__('DesingThemes Custom Fonts List', 'bullish-pro' ),
                esc_html__('Custom Fonts', 'bullish-pro' ),
                'edit_theme_options',
                'edit-tags.php?taxonomy=bullish_custom_fonts'
            );
        }

        function taxonomy_css() {
            global $parent_file, $submenu_file;

            if( $submenu_file == 'edit-tags.php?taxonomy=bullish_custom_fonts' ){
                $parent_file = 'themes.php';
            }

            if ( get_current_screen()->id != 'edit-bullish_custom_fonts' ) {
                return;
            }

            echo '<style>';
                echo '#addtag div.form-field.term-slug-wrap, #edittag tr.form-field.term-slug-wrap { display: none; }';
                echo '#addtag div.form-field.term-description-wrap, #edittag tr.form-field.term-description-wrap { display: none; }';
            echo '</style>';

        }

        function remove_fields( $columns ) {

            $screen = get_current_screen();

            if ( isset( $screen->base ) && 'edit-tags' == $screen->base ) {
				$old_columns = $columns;
				$columns     = array(
					'cb'   => $old_columns['cb'],
					'name' => $old_columns['name'],
				);
            }

            return $columns;
        }

        public function add_fonts_to_allowed_mimes( $mimes ) {
            $mimes['woff']  = 'application/x-font-woff';
            $mimes['woff2'] = 'application/x-font-woff2';
            $mimes['ttf']   = 'application/x-font-ttf';
            $mimes['eot']   = 'application/vnd.ms-fontobject';
            $mimes['otf']   = 'font/otf';

            return $mimes;
        }

        /**
         * Output font-display CSS property for custom fonts.
         * This should be called in wp_head or when enqueuing custom font styles.
         */
        public static function output_font_display_css() {
            $terms = get_terms( array(
                'taxonomy'   => 'bullish_custom_fonts',
                'hide_empty' => false,
            ) );

            if ( empty( $terms ) || is_wp_error( $terms ) ) {
                return;
            }

            foreach ( $terms as $term ) {
                $font_family = esc_attr( $term->name );
                $display     = get_term_meta( $term->term_id, 'display', true );
                if ( empty( $display ) ) {
                    $display = 'swap';
                }

                // Get font file URLs
                $woff  = get_term_meta( $term->term_id, 'woff', true );
                $woff2 = get_term_meta( $term->term_id, 'woff2', true );
                $ttf   = get_term_meta( $term->term_id, 'ttf', true );
                $otf   = get_term_meta( $term->term_id, 'otf', true );
                $svg   = get_term_meta( $term->term_id, 'svg', true );

                $src = array();
                if ( $woff2 ) $src[] = "url('{$woff2}') format('woff2')";
                if ( $woff )  $src[] = "url('{$woff}') format('woff')";
                if ( $ttf )   $src[] = "url('{$ttf}') format('truetype')";
                if ( $otf )   $src[] = "url('{$otf}') format('opentype')";
                if ( $svg )   $src[] = "url('{$svg}') format('svg')";

                if ( ! empty( $src ) ) {
                    echo "<style id='bullish-custom-font-{$term->term_id}'>\n";
                    echo "@font-face {\n";
                    echo "  font-family: '{$font_family}';\n";
                    echo "  src: " . implode( ",\n    ", $src ) . ";\n";
                    echo "  font-display: {$display};\n";
                    echo "}\n";
                    echo "</style>\n";
                }
            }
        }

		public function update_mime_types( $defaults, $file, $filename ) {
			if ( 'ttf' === pathinfo( $filename, PATHINFO_EXTENSION ) ) {
				$defaults['type'] = 'application/x-font-ttf';
				$defaults['ext']  = 'ttf';
			}

			if ( 'otf' === pathinfo( $filename, PATHINFO_EXTENSION ) ) {
				$defaults['type'] = 'application/x-font-otf';
				$defaults['ext']  = 'otf';
			}

			return $defaults;
		}

        function register_fields( $options ) {

            $options[] = array(
                'id'       => '_bullish_custom_font_options',
                'taxonomy' => 'bullish_custom_fonts',
                'fields'   => array(
                    array(
                        'id'       => 'woff',
                        'type'     => 'upload',
                        'title'    => esc_html__('Font .woff', 'bullish-pro' ),
                        'settings' => array(
                            'upload_type'  => 'application/x-font-woff',
                            'button_title' => esc_html__('Upload .woff file', 'bullish-pro' ),
                            'frame_title'  => esc_html__('Choose .woff font file', 'bullish-pro' ),
                            'insert_title' => esc_html__('Use File', 'bullish-pro' ),
                        )
                    ),
                    array(
                        'id'       => 'woff2',
                        'type'     => 'upload',
                        'title'    => esc_html__('Font .woff2', 'bullish-pro' ),
                        'settings' => array(
                            'upload_type'  => 'application/x-font-woff2',
                            'button_title' => esc_html__('Upload .woff2 file', 'bullish-pro' ),
                            'frame_title'  => esc_html__('Choose .woff2 font file', 'bullish-pro' ),
                            'insert_title' => esc_html__('Use File', 'bullish-pro' ),
                        )
                    ),
                    array(
                        'id'       => 'ttf',
                        'type'     => 'upload',
                        'title'    => esc_html__('Font .ttf', 'bullish-pro' ),
                        'settings' => array(
                            'upload_type'  => 'application/x-font-ttf',
                            'button_title' => esc_html__('Upload .ttf file', 'bullish-pro' ),
                            'frame_title'  => esc_html__('Choose .ttf font file', 'bullish-pro' ),
                            'insert_title' => esc_html__('Use File', 'bullish-pro' ),
                        )
                    ),
                    array(
                        'id'       => 'svg',
                        'type'     => 'upload',
                        'title'    => esc_html__('Font .svg', 'bullish-pro' ),
                        'settings' => array(
                            'upload_type'  => 'image/svg+xml',
                            'button_title' => esc_html__('Upload .svg file', 'bullish-pro' ),
                            'frame_title'  => esc_html__('Choose .svg font file', 'bullish-pro' ),
                            'insert_title' => esc_html__('Use File', 'bullish-pro' ),
                        )
                    ),
                    array(
                        'id'       => 'otf',
                        'type'     => 'upload',
                        'title'    => esc_html__('Font .otf', 'bullish-pro' ),
                        'settings' => array(
                            'upload_type'  => 'application/x-font-otf',
                            'button_title' => esc_html__('Upload .otf file', 'bullish-pro' ),
                            'frame_title'  => esc_html__('Choose .otf font file', 'bullish-pro' ),
                            'insert_title' => esc_html__('Use File', 'bullish-pro' ),
                        )
                    ),
                    array(
                        'id'      => 'display',
                        'type'    => 'select',
                        'title'   => esc_html__('Font Display', 'bullish-pro' ),
                        'options' => array(
                            'auto'     => esc_html__('Auto','bullish-pro'),
                            'block'    => esc_html__('Block','bullish-pro'),
                            'swap'     => esc_html__('Swap','bullish-pro'),
                            'fallback' => esc_html__('Fallback','bullish-pro'),
                            'optional' => esc_html__('Optional','bullish-pro'),
                        ),
                    )
                )
            );

            return $options;
        }
    }
}

BullishProTaxonomyCustomFont::instance();