<?php
/**
 * Plugin Name:	Bullish Shop
 * Description: Adds shop features for Bullish Theme.
 * Version: 1.0.0
 * Author: the WeDesignTech team
 * Author URI: https://wedesignthemes.com/
 * Text Domain: bullish-shop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The main class that initiates and runs the plugin.
 */
final class Bullish_Shop {

	/**
	 * Instance variable
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'bullish_shop_i18n' ) );
		add_filter( 'bullish_required_plugins_list', array( $this, 'upadate_required_plugins_list' ) );
		add_action( 'plugins_loaded', array( $this, 'bullish_shop_plugins_loaded' ) );


		add_filter('woocommerce_product_data_tabs', array( $this, 'custom_ad_tab' ) );
		add_action('woocommerce_product_data_panels', array( $this, 'custom_ad_tab_content' ) );
		add_action('woocommerce_admin_process_product_object', array( $this, 'save_custom_ad_tab_fields' ) ); 
		add_action( 'woocommerce_before_single_product', array( $this, 'load_my_plugin_template' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action('init', array( $this, 'handle_feedback_form_submission' ) );
		add_action('init', array( $this, 'register_feedback_post_type' ) );
		add_action('add_meta_boxes', array( $this, 'add_feedback_meta_box' ) );



	}
	
	public function load_my_plugin_template() {
    
	
			wc_get_template(
				'offer-popup.php',
				array(),
				'',
				BULLISH_SHOP_PATH . 'templates/global/'
			);

	}
	public function custom_ad_tab($tabs) {
    $tabs['ad_settings'] = array(
        'label'    => __('Ad Settings', 'woocommerce'),
        'target'   => 'ad_settings_product_data',
        'class'    => array('show_if_simple', 'show_if_variable', 'show_if_grouped', 'show_if_external'),
        'priority' => 90,
    );
    return $tabs;
}
	 

 
	public function custom_ad_tab_content() {
    ?>
    <div id="ad_settings_product_data" class="panel woocommerce_options_panel">
        <div class="options_group">
            <?php
            woocommerce_wp_text_input(array(
                'id'          => '_ad_media_url',
                'label'       => __('Ad Image/Video URL', 'woocommerce'),
                'placeholder' => 'https://example.com/ad.mp4 or ad.jpg',
                'desc_tip'    => true,
                'description' => __('URL of the ad media to show on product page.', 'woocommerce')
            ));
            ?>
        </div>
    </div>
    	<?php
	}		

		public function save_custom_ad_tab_fields($product) {
			if (isset($_POST['_ad_media_url'])) {
				$product->update_meta_data('_ad_media_url', sanitize_text_field($_POST['_ad_media_url']));
			}
		}
		/**
          * Add Common css & javascript
        */
  
		 function enqueue_assets() { 
            wp_enqueue_style( 'bullish-shop', BULLISH_SHOP_URL . 'assets/css/shop.css', false, BULLISH_SHOP_VERSION, 'all');
			wp_enqueue_script( 'wdt-elementor-addon-core', BULLISH_SHOP_URL . 'assets/js/shop.js', array ('jquery'), BULLISH_SHOP_VERSION, true );
            do_action( 'bullish_pro_after_asset_enqueue' );
        }
		function handle_feedback_form_submission() {
				if (isset($_POST['submit_feedback']) && isset($_POST['feedback_nonce']) && wp_verify_nonce($_POST['feedback_nonce'], 'save_feedback_form')) {
					
					$feedback_data = [
						'selected_option' => sanitize_text_field($_POST['feedback_option'] ?? ''),
					];

					// Loop through dynamic answers
					foreach ($_POST as $key => $value) {
						if (strpos($key, 'answer_') === 0) {
							$feedback_data[$key] = is_array($value) ? array_map('sanitize_text_field', $value) : sanitize_text_field($value);
						}
					}

					// Save as custom post type or custom table
					$post_id = wp_insert_post([
						'post_type' => 'user_feedback',
						'post_title' => 'Feedback - ' . current_time('mysql'),
						'post_status' => 'publish',
					]);

					if ($post_id && !is_wp_error($post_id)) {
						foreach ($feedback_data as $key => $val) {
							update_post_meta($post_id, $key, $val);
						}
					}
				}
	 	}
		function register_feedback_post_type() {
   			 register_post_type('user_feedback', [
				'labels' => [
					'name' => 'User Feedback',
					'singular_name' => 'Feedback',
					'all_items' => 'All Feedback',
					'edit_item' => 'View Feedback',
				],
				'public' => false,
				'show_ui' => true,
				'show_in_menu' => true,
				'supports' => ['title'],
				'menu_icon' => 'dashicons-feedback', 
				'capability_type' => 'post',
				'capabilities' => [
					'create_posts' => 'do_not_allow',
				],
				'map_meta_cap' => true,
			]);
		} 
		function add_feedback_meta_box() {
    		add_meta_box(
            'feedback_data',
            'Feedback Details',
            array($this, 'render_feedback_meta_box'),  
            'user_feedback',
            'normal',
            'default'
        	);
		}
		

	/**
	 * Load Textdomain
	 */
		public function bullish_shop_i18n() {

			load_plugin_textdomain( 'bullish-shop', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

	/**
	 * Update required plugins list
	 */
		function upadate_required_plugins_list($plugins_list) {

            $required_plugins = array(
                array(
                    'name'				=> 'WooCommerce',
                    'slug'				=> 'woocommerce',
                    'required'			=> true,
                    'force_activation'	=> false,
                )
            );
            $new_plugins_list = array_merge($plugins_list, $required_plugins);

            return $new_plugins_list;

        }

	/**
	 * Initialize the plugin
	 */
		public function bullish_shop_plugins_loaded() {

			// Check for WooCommerce plugin
				if( !function_exists( 'is_woocommerce' ) ) {
					add_action( 'admin_notices', array( $this, 'bullish_shop_woo_plugin_req' ) );
					return;
				}

			// Check for Bullish Theme plugin
				if( !function_exists( 'bullish_pro' ) ) {
					add_action( 'admin_notices', array( $this, 'bullish_shop_dttheme_plugin_req' ) );
					return;
				}

			// Setup Constants (non-translatable ones)
			$this->bullish_shop_setup_non_translatable_constants();
			// Setup translatable constants later
			add_action('init', array($this, 'bullish_shop_setup_translatable_constants'), 11);

			// Load Modules & Helper
				$this->bullish_shop_load_modules();
                $this->load_helper();

			// Locate Module Files
				add_filter( 'bullish_woo_pro_locate_file',  array( $this, 'bullish_woo_pro_shop_locate_file' ), 10, 2 );

			// Load WooCommerce Template Files
				add_filter( 'woocommerce_locate_template',  array( $this, 'bullish_shop_woocommerce_locate_template' ), 30, 3 );

		}


	/**
	 * Admin notice
	 * Warning when the site doesn't have WooCommerce plugin.
	 */
		public function bullish_shop_woo_plugin_req() {

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				/* translators: 1: Plugin name 2: Required plugin name */
				esc_html__( '"%1$s" requires "%2$s" plugin to be installed and activated.', 'bullish-shop' ),
				'<strong>' . esc_html__( 'Bullish Shop', 'bullish-shop' ) . '</strong>',
				'<strong>' . esc_html__( 'WooCommerce - excelling eCommerce', 'bullish-shop' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

	/**
	 * Admin notice
	 * Warning when the site doesn't have Bullish Theme plugin.
	 */
		public function bullish_shop_dttheme_plugin_req() {

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				/* translators: 1: Plugin name 2: Required plugin name */
				esc_html__( '"%1$s" requires "%2$s" plugin to be installed and activated.', 'bullish-shop' ),
				'<strong>' . esc_html__( 'Bullish Shop', 'bullish-shop' ) . '</strong>',
				'<strong>' . esc_html__( 'Bullish Pro', 'bullish-shop' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

	/**
	 * Define constant if not already set.
	 */
		public function bullish_shop_define_constants( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

	/**
	 * Configure Non-Translatable Constants
	 */
	public function bullish_shop_setup_non_translatable_constants()
	{
		$this->bullish_shop_define_constants('BULLISH_SHOP_VERSION', '1.0');
		$this->bullish_shop_define_constants('BULLISH_SHOP_PATH', trailingslashit(plugin_dir_path(__FILE__)));
		$this->bullish_shop_define_constants('BULLISH_SHOP_URL', trailingslashit(plugin_dir_url(__FILE__)));

		$this->bullish_shop_define_constants('BULLISH_SHOP_MODULE_PATH', trailingslashit(plugin_dir_path(__FILE__) . 'modules'));
		$this->bullish_shop_define_constants('BULLISH_SHOP_MODULE_URL', trailingslashit(plugin_dir_url(__FILE__) . 'modules'));
	}

	/**
	 * Configure Translatable Constants
	 */
	public function bullish_shop_setup_translatable_constants()
	{
		$this->bullish_shop_define_constants('BULLISH_SHOP_NAME', esc_html__('Bullish Shop', 'bullish-shop'));
	}

	/**
	 * Load Modules
	 */
		public function bullish_shop_load_modules() {

			foreach( glob( BULLISH_SHOP_MODULE_PATH. '*/index.php' ) as $module ) {
				include_once $module;
			}

		}

	/**
	 * Locate Module Files
	 */
		public function bullish_woo_pro_shop_locate_file( $file_path, $module ) {

			$file_path = BULLISH_SHOP_PATH . 'modules/' . $module .'.php';

			$located_file_path = false;
			if ( $file_path && file_exists( $file_path ) ) {
				$located_file_path = $file_path;
			}

			return $located_file_path;

		}

	/**
	 * Override WooCommerce default template files
	 */
		public function bullish_shop_woocommerce_locate_template( $template, $template_name, $template_path ) {

			global $woocommerce;

			$_template = $template;

			if ( ! $template_path ) $template_path = $woocommerce->template_url;

			$plugin_path  = BULLISH_SHOP_PATH . 'templates/';

			// Look within passed path within the theme - this is priority
			$template = locate_template(
				array(
					$template_path . $template_name,
					$template_name
				)
			);

			// Modification: Get the template from this plugin, if it exists
			if ( ! $template && file_exists( $plugin_path . $template_name ) )
			$template = $plugin_path . $template_name;

			// Use default template
			if ( ! $template )
			$template = $_template;

			// Return what we found
			return $template;

		}

	/**
	 * Load helper
	 */
        function load_helper() {
            require_once BULLISH_SHOP_PATH . 'functions.php';
        }

}

if( !function_exists('bullish_shop_instance') ) {
	function bullish_shop_instance() {
		return Bullish_Shop::instance();
	}
}

bullish_shop_instance();