<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (! class_exists('BullishPlusServicesPostType')) {

	class BullishPlusServicesPostType
	{

		private static $_instance = null;
		public static function instance()
		{
			if (is_null(self::$_instance)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		function __construct()
		{

			add_action('init', array($this, 'bullish_register_cpt'));
			add_filter('template_include', array($this, 'bullish_template_include'));
			add_action('add_meta_boxes', array($this, 'add_service_metabox'));
			add_action('save_post', array($this, 'save_service_metabox'));
			add_action('admin_enqueue_scripts', array($this, 'custom_media_uploader_scripts'));
			add_action('init', array($this, 'register_wdt_service_category_taxonomy'));
		}
		function custom_media_uploader_scripts($hook)
		{
			if ('post.php' !== $hook && 'post-new.php' !== $hook) {
				return;
			}
			wp_enqueue_script(
				'bullish-plus-admin-script',
				BULLISH_PLUS_DIR_URL . 'assets/js/admin-script.js',
				array('jquery', 'wp-mediaelement'),
				null,
				true
			);
			wp_localize_script('bullish-plus-admin-script', 'bullishPlusData', array(
				'uploadIconText' => __('Select an Icon', 'bullish-plus'),
				'useIconText'    => __('Use this icon', 'bullish-plus')
			));
		}
		function bullish_register_cpt()
		{

			$labels = array(
				'name'               => __('Services', 'bullish-plus'),
				'singular_name'      => __('Services', 'bullish-plus'),
				'menu_name'          => __('Services', 'bullish-plus'),
				'add_new'            => __('Add Services', 'bullish-plus'),
				'add_new_item'       => __('Add New Services', 'bullish-plus'),
				'edit'               => __('Edit Services', 'bullish-plus'),
				'edit_item'          => __('Edit Services', 'bullish-plus'),
				'new_item'           => __('New Services', 'bullish-plus'),
				'view'               => __('View Services', 'bullish-plus'),
				'view_item'          => __('View Services', 'bullish-plus'),
				'search_items'       => __('Search Services', 'bullish-plus'),
				'not_found'          => __('No Services found', 'bullish-plus'),
				'not_found_in_trash' => __('No Services found in Trash', 'bullish-plus'),
			);
			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'exclude_from_search' => false,
				'show_in_nav_menus'  => true,
				'show_in_rest'       => true,
				'menu_position'      => 26,
				'menu_icon'          => 'dashicons-editor-insertmore',
				'hierarchical'       => false,
				'supports'           => array('title', 'editor', 'author', 'revisions', 'thumbnail', 'post-formats', 'excerpt', 'page-attributes', 'custom-fields'),
				'taxonomies'          => array('wdt_service_category'),
			);
			register_post_type('wdt_services', $args);
		}
		function register_wdt_service_category_taxonomy()
		{
			$labels = array(
				'name'              => __('Service Categories', 'bullish-plus'),
				'singular_name'     => __('Service Category', 'bullish-plus'),
				'search_items'      => __('Search Service Categories', 'bullish-plus'),
				'all_items'         => __('All Service Categories', 'bullish-plus'),
				'parent_item'       => __('Parent Service Category', 'bullish-plus'),
				'parent_item_colon' => __('Parent Service Category:', 'bullish-plus'),
				'edit_item'         => __('Edit Service Category', 'bullish-plus'),
				'update_item'       => __('Update Service Category', 'bullish-plus'),
				'add_new_item'      => __('Add New Service Category', 'bullish-plus'),
				'new_item_name'     => __('New Service Category Name', 'bullish-plus'),
			);

			$args = array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array('slug' => 'service-category'),
			);

			register_taxonomy('wdt_service_category', array('wdt_services'), $args);
		}
		function add_service_metabox()
		{
			add_meta_box(
				'service_details',
				__('Service Details', 'bullish-plus'),
				array($this, 'render_service_metabox'),
				'wdt_services',
				'advanced',
				'high'
			);
			add_meta_box(
				'categorydiv',
				__('Categories', 'bullish-plus'),
				array($this, 'render_category_metabox'),
				'wdt_services',
				'side',
				'high'
			);
		}
		function render_service_metabox($post) {
            $service_icon = get_post_meta($post->ID, 'service_icon', true);
            $service_price = get_post_meta($post->ID, 'service_price', true);
            $service_button_text = get_post_meta($post->ID, 'service_button_text', true);
            $service_description = get_post_meta($post->ID, 'service_description', true);
            wp_nonce_field('save_service_metabox_nonce', 'service_metabox_nonce');
            ?>
            <div class="wdt-custom-box">
                <p>
                    <label><strong><?php esc_html_e('Service Icon', 'bullish-plus'); ?></strong></label><br>
                    <button type="button" class="button" id="upload_service_icon"><?php esc_html_e('Upload Icon', 'bullish-plus'); ?></button>
                    <input type="hidden" name="service_icon" id="service_icon_input" value="<?php echo esc_url($service_icon); ?>">
                </p>
                <div id="service_icon_preview" style="margin-top: 10px; max-height: 100px; max-width: 100px; overflow: hidden;">
                    <?php if ($service_icon): ?>
                        <?php
                        $ext = pathinfo($service_icon, PATHINFO_EXTENSION);
                        if (strtolower($ext) === 'svg') {
                            echo '<div id="service_icon">' . file_get_contents($service_icon) . '</div>';
                        } else {
                            echo '<img id="service_icon" src="' . esc_url($service_icon) . '" alt="' . esc_attr__('Service Icon', 'bullish-plus') . '" style="max-width:100%;"/>';
                        }
                        ?>
                        <br>
                        <button type="button" class="button" id="remove_service_icon"><?php esc_html_e('Remove Icon', 'bullish-plus'); ?></button>
                    <?php endif; ?>
                </div>

                <div class="services_price">
                    <label for="class_price"><strong><?php esc_html_e('Price', 'bullish-plus'); ?></strong></label><br>
                    <input type="text" id="class_price" name="service_price" value="<?php echo esc_attr($service_price); ?>" class="widefat">
                </div>
                <div class="services_button">
                    <label for="service_button_text"><strong><?php esc_html_e('Button Text', 'bullish-plus'); ?></strong></label><br>
                    <input type="text" name="service_button_text" id="service_button_text" class="widefat"
                        value="<?php echo esc_attr($service_button_text); ?>" placeholder="Learn More" />
                </div>

                <div class="services_description">
                    <label for="service_description"><strong><?php esc_html_e('Service Description', 'bullish-plus'); ?></strong></label><br>
                    <textarea name="service_description" id="service_description" rows="5" class="widefat"
                            placeholder="Enter a short description..."><?php echo esc_textarea($service_description); ?></textarea>
                </div>
            
            </div>
            <?php
        }
		function render_category_metabox($post)
		{
			$taxonomy = 'wdt_service_category';
		?>
			<div class="categorydiv">
				<h2><?php _e('Service Categories', 'bullish-plus'); ?></h2>
				<ul>
					<?php wp_terms_checklist($post->ID, array('taxonomy' => $taxonomy)); ?>
				</ul>
			</div>
        <?php
		}

		function save_service_metabox($post_id) {
            if (! isset($_POST['service_metabox_nonce']) || ! wp_verify_nonce($_POST['service_metabox_nonce'], 'save_service_metabox_nonce')) {
                return;
            }
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
            if (! current_user_can('edit_post', $post_id)) return;
        
            $service_icon = isset($_POST['service_icon']) ? esc_url_raw($_POST['service_icon']) : '';
            $price = isset($_POST['service_price']) ? sanitize_text_field($_POST['service_price']) : '';
            $button_text = isset($_POST['service_button_text']) ? sanitize_text_field($_POST['service_button_text']) : '';
            $description = isset($_POST['service_description']) ? sanitize_textarea_field($_POST['service_description']) : '';
        
            update_post_meta($post_id, 'service_icon', $service_icon);
            update_post_meta($post_id, 'service_price', $price);
            update_post_meta($post_id, 'service_button_text', $button_text);
            update_post_meta($post_id, 'service_description', $description);
        }

		function bullish_template_include($template)
		{
			if (is_singular('wdt_services')) {
				if (! file_exists(get_stylesheet_directory() . '/single-wdt_services.php')) {
					$template = BULLISH_PLUS_DIR_PATH . 'post-types/templates/single-wdt_services.php';
				}
			}
			return $template;
		}
	}
}

BullishPlusServicesPostType::instance();
