<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (! class_exists('BullishProServicesPostType')) {

	class BullishProServicesPostType
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
			add_action('init', array($this, 'register_wdt_service_category_taxonomy'));
			add_action('init', array($this, 'add_excerpt_support'));
            add_filter('cs_metabox_options', array($this, 'services_metabox'));
			add_filter('manage_wdt_services_posts_columns', array($this, 'add_price_column'));
			add_action('manage_wdt_services_posts_custom_column', array($this, 'render_price_column'), 10, 2);
        }

		function bullish_register_cpt()
		{

			$labels = array(
				'name'               => __('Services', 'bullish-pro'),
				'singular_name'      => __('Services', 'bullish-pro'),
				'menu_name'          => __('Services', 'bullish-pro'),
				'add_new'            => __('Add Services', 'bullish-pro'),
				'add_new_item'       => __('Add New Services', 'bullish-pro'),
				'edit'               => __('Edit Services', 'bullish-pro'),
				'edit_item'          => __('Edit Services', 'bullish-pro'),
				'new_item'           => __('New Services', 'bullish-pro'),
				'view'               => __('View Services', 'bullish-pro'),
				'view_item'          => __('View Services', 'bullish-pro'),
				'search_items'       => __('Search Services', 'bullish-pro'),
				'not_found'          => __('No Services found', 'bullish-pro'),
				'not_found_in_trash' => __('No Services found in Trash', 'bullish-pro'),
			);
			$args = array(
				'labels'             => $labels,
				'public' 			 => true,
			    'publicly_queryable' => true,
        		'has_archive'        => true,
        		'rewrite'            => array('slug' => 'wdt_services'),
				'exclude_from_search'=> false,
				'show_in_nav_menus'  => true,
				'show_in_rest'       => true,
				'menu_position'      => 26,
				'menu_icon'          => 'dashicons-editor-insertmore',
				'hierarchical'       => false,
				'supports'           => array('title', 'editor', 'author', 'revisions', 'thumbnail', 'post-formats', 'excerpt', 'page-attributes', 'custom-fields'),
				'taxonomies'         => array('wdt_service_category'),
			);
			register_post_type('wdt_services', $args);
		}

		function register_wdt_service_category_taxonomy()
		{
			$labels = array(
				'name'              => __('Service Categories', 'bullish-pro'),
				'singular_name'     => __('Service Category', 'bullish-pro'),
				'search_items'      => __('Search Service Categories', 'bullish-pro'),
				'all_items'         => __('All Service Categories', 'bullish-pro'),
				'parent_item'       => __('Parent Service Category', 'bullish-pro'),
				'parent_item_colon' => __('Parent Service Category:', 'bullish-pro'),
				'edit_item'         => __('Edit Service Category', 'bullish-pro'),
				'update_item'       => __('Update Service Category', 'bullish-pro'),
				'add_new_item'      => __('Add New Service Category', 'bullish-pro'),
				'new_item_name'     => __('New Service Category Name', 'bullish-pro'),
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

		function add_excerpt_support() {
        	add_post_type_support('wdt_services', 'excerpt');
    	}

		function services_metabox($options) {

			$times = array( '' => esc_html__('Select', 'bullish-pro') );
			for ( $i = 0; $i < 12; $i++ ) :
				for ( $j = 15; $j <= 60; $j += 15 ) :
					$duration = ( $i * 3600 ) + ( $j * 60 );
					$duration_output = bullish_pro_duration_to_string( $duration );
					$times[$duration] = $duration_output;
				endfor;
			endfor;

			$options[] = array(
				'id'        => '_bullish_service_settings',
				'title'     => esc_html__('Service Settings', 'bullish-pro'),
				'post_type' => 'wdt_services',
				'context'   => 'advanced',
				'priority'  => 'high',
				'sections'  => array(
					array(
						'name'   => 'service_options_section',
						'fields' => array(

							array(
								'id'    => 'service_icon',
								'type'  => 'upload',
								'title' => esc_html__('Service Icon', 'bullish-pro'),
								'desc'  => esc_html__('Upload or select a service icon.', 'bullish-pro'),
							),

							array(
								'id'      => 'service_icon_preview',
								'type'    => 'content',
								'content' => '<div id="csf-icon-preview" style="margin-top:10px;"></div>',
							),

							array(
								'id'      => 'enable_service_price',
								'type'    => 'select',
								'title'   => esc_html__('Enable Price', 'bullish-pro'),
								'options' => array(
									'no'  => esc_html__('Disable', 'bullish-pro'),
									'yes' => esc_html__('Enable', 'bullish-pro'),
								),
								'default' => 'no',
							),

							array(
								'id'         => 'service_price',
								'type'       => 'text',
								'title'      => esc_html__('Service Price', 'bullish-pro'),
								'dependency' => array('enable_service_price', '==', 'yes'),
							),

							array(
								'id'         => 'service_offer_price',
								'type'  	 => 'text',	
								'title' 	 => esc_html__('Service Offer Price', 'bullish-pro'),
								'desc'  	 => esc_html__('Optional: You can set an offer price for the service.', 'bullish-pro'),
								'dependency' => array('enable_service_price', '==', 'yes'),
							),

							array(
								'id'      => 'service-duration',
								'type'    => 'select',
								'title'   => esc_html__('Duration', 'bullish-pro'),
								'after'   => '<p class="cs-text-muted">'.esc_html__('Select time duration here', 'bullish-pro').'</p>',
								'options' => $times,
								'class'   => 'chosen'
							),

							//Service Features Section
							array(
								'type'  => 'subheading',
								'title' => esc_html__('Service Features', 'bullish-pro'),
							),

							array(
								'id'     => 'service_features',
								'type'   => 'group',
								'title'  => esc_html__('Service Features', 'bullish-pro'),
								'desc'   => esc_html__('Add multiple service features.', 'bullish-pro'),
								'button_title' => esc_html__('Add Feature', 'bullish-pro'),
								'fields' => array(
									array(
										'id'    => 'feature_icon',
										'type'  => 'upload',
										'title' => esc_html__('Feature Icon', 'bullish-pro'),
									),
									array(
										'id'    => 'feature_image',
										'type'  => 'upload',
										'title' => esc_html__('Feature Image', 'bullish-pro'),
									),
									array(
										'id'    => 'feature_description',
										'type'  => 'textarea',
										'title' => esc_html__('Feature Description', 'bullish-pro'),
									),
								),
								'clone' => true,
							),

							// Contact Details Section
							array(
								'type'  => 'subheading',
								'title' => esc_html__('Contact Details', 'bullish-pro'),
							),

							array(
								'id'       => 'contact_email',
								'type'     => 'text',
								'title'    => esc_html__('Email Address', 'bullish-pro'),
								'validate' => 'email',
							),
							array(
								'id'    => 'contact_phone',
								'type'  => 'text',
								'title' => esc_html__('Phone Number', 'bullish-pro'),
							),
							array(
								'id'    => 'contact_address',
								'type'  => 'textarea',
								'title' => esc_html__('Address', 'bullish-pro'),
							),
							array(
								'id'     => 'contact_socials',
								'type'   => 'group',
								'title'  => esc_html__('Social Icons', 'bullish-pro'),
								'desc'   => esc_html__('Add multiple social media links.', 'bullish-pro'),
								'button_title' => esc_html__('Add Social Link', 'bullish-pro'),
								'fields' => array(
									array(
										'id'    => 'social_icon',
										'type'  => 'upload',
										'title' => esc_html__('Social Icon', 'bullish-pro'),
									),
									array(
										'id'    => 'social_url',
										'type'  => 'text',
										'title' => esc_html__('Social URL', 'bullish-pro'),
										'desc'  => esc_html__('Enter full URL (e.g., https://facebook.com/yourpage)', 'bullish-pro'),
									),
								),
							),
						
						),
					),
				),
			);

			return $options;
		}

		
		function render_service_icon_metabox($post)
		{
			$service_icon = get_post_meta($post->ID, 'service_icon', true);
				wp_nonce_field('save_service_metabox_nonce', 'service_metabox_nonce');
			?>
			<div class="wdt-custom-box">
				<p>
					<label><strong><?php esc_html_e('Icon', 'bullish-pro'); ?></strong></label><br>
					<button type="button" class="button" id="upload_service_icon"><?php esc_html_e('Upload from Media Library', 'bullish-pro'); ?></button>
					<input type="text" name="service_icon" id="service_icon_input" value="<?php echo esc_url($service_icon); ?>" class="widefat" placeholder="Or paste media URL here">
				</p>

				<div id="service_icon_preview" style="margin-top: 10px; max-height: 100px; max-width: 100px; overflow: hidden;">
					<?php if ($service_icon): ?>
						<?php
							$ext = pathinfo($service_icon, PATHINFO_EXTENSION);
							if (strtolower($ext) === 'svg') {
								echo '<div class="service_icon">' . file_get_contents($service_icon) . '</div>';
							} else {
								echo '<img class="service_icon" src="' . esc_url($service_icon) . '" alt="' . esc_attr__('Service Icon', 'bullish-pro') . '" style="max-width:100%;"/>';
							}
						?>
						<br>
						<button type="button" class="button" id="remove_service_icon"><?php esc_html_e('Remove Icon', 'bullish-pro'); ?></button>
					<?php endif; ?>
				</div>
			</div>
			<?php
		}

		function render_service_price_metabox($post)
		{
			$service_price = get_post_meta($post->ID, 'service_price', true);
			$enable_price = get_post_meta($post->ID, 'enable_service_price', true);

			wp_nonce_field('save_service_metabox_nonce', 'service_metabox_nonce');
			?>
			<div class="services_price">
				<p>
					<label for="enable_service_price"><strong><?php esc_html_e('Enable Price', 'bullish-pro'); ?></strong></label><br>
					<select name="enable_service_price" id="enable_service_price" class="widefat">
						<option value="no" <?php selected($enable_price, 'no'); ?>><?php esc_html_e('Disable', 'bullish-pro'); ?></option>
						<option value="yes" <?php selected($enable_price, 'yes'); ?>><?php esc_html_e('Enable', 'bullish-pro'); ?></option>
					</select>
				</p>

				<p id="price_field_wrapper" style="<?php echo ($enable_price !== 'yes') ? 'display:none;' : ''; ?>">
					<label for="class_price"><strong><?php esc_html_e('Price', 'bullish-pro'); ?></strong></label><br>
					<input type="text" id="class_price" name="service_price" value="<?php echo esc_attr($service_price); ?>" class="widefat">
				</p>
			</div>
			<?php
		}


		function render_category_metabox($post)
		{
			$taxonomy = 'wdt_service_category';
			?>
			<div class="categorydiv">
				<h2><?php _e('Service Categories', 'bullish-pro'); ?></h2>
				<ul>
					<?php wp_terms_checklist($post->ID, array('taxonomy' => $taxonomy)); ?>
				</ul>
			</div>
        	<?php
		}

		function bullish_template_include($template)
		{
			if (is_singular('wdt_services')) {
				if (! file_exists(get_stylesheet_directory() . '/single-wdt_services.php')) {
					$template = BULLISH_PRO_DIR_PATH . 'post-types/templates/single-wdt_services.php';
				}
			}
			return $template;
		}

		function add_price_column($columns)
		{
			$price_column = [];
			foreach ($columns as $key => $value) {
				$price_column[$key] = $value;
				if ($key === 'title') {
					$price_column['service_price'] = __('Price', 'bullish-pro');
				}
			}
			return $price_column;
		}

		function render_price_column($column, $post_id)
		{
			if ($column === 'service_price') {
				$settings = get_post_meta($post_id, 'service_settings', true);
				$price = $settings['service_price'] ?? '';
				echo $price ? esc_html($price) : __('N/A', 'bullish-pro');
			}
		}

	}
}

BullishProServicesPostType::instance();