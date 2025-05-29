<?php
namespace BullishElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Bullish_Shop_Widget_Related_Products extends Widget_Base {

	public function get_categories() {
		return [ 'wdt-shop-widgets' ];
	}

	public function get_name() {
		return 'wdt-shop-related-products';
	}

	public function get_title() {
		return esc_html__( 'Product Single - Related Products', 'bullish-pro' );
	}

	public function get_style_depends() {
		return array( 'wdt-shop-product-single-related-products' );
	}

	public function get_script_depends() {
		return array( 'related-products-jquery-swiper', 'wdt-shop-product-single-related-products' );
	}
	public function product_style_templates() {

		$shop_product_templates['admin'] = esc_html__('Admin Option', 'bullish-pro');
		$shop_product_templates = array_merge ( $shop_product_templates, bullish_woo_listing_customizer_settings()->product_templates_list() );

		return $shop_product_templates;

	}

	protected function register_controls() {

		$this->start_controls_section( 'product_featured_image_section', array(
			'label' => esc_html__( 'General', 'bullish-pro' ),
		) );

			$this->add_control( 'product_id', array(
				'label'       => esc_html__( 'Product Id', 'bullish-pro' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Provide product id for which you have to display product summary items. No need to provide ID if it is used in Product single page.', 'bullish-pro'),
			) );
			$this->add_control( 'layout', array(
				'label'       => esc_html__( 'Layout', 'bullish-pro' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array('column'=>'Column','carousel'=>'Carousel'),
				'default'     => '',
	        ) );
	
			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'bullish-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose column that you like to display upsell products.', 'bullish-pro' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
				'default'     => 4,
				'condition'   => array( 'layout' => 'column' ),
	        ) );

			$this->add_control( 'limit', array(
				'label'       => esc_html__( 'Limit', 'bullish-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose number of products that you like to display.', 'bullish-pro' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10 ),
				'default'     => 4,
	        ) );

			$this->add_control( 'product_style_template', array(
				'label'       => esc_html__( 'Product Style Template', 'bullish-pro' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose number of products that you like to display.', 'bullish-pro' ),
				'options'     => $this->product_style_templates(),
				'default'     => 'admin',
	        ) );

			$this->add_control( 'hide_title', array(
				'label'        => esc_html__( 'Hide Title', 'bullish-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish to hide title you can do it here', 'bullish-pro'),
				'label_on'     => esc_html__( 'yes', 'bullish-pro' ),
				'label_off'    => esc_html__( 'no', 'bullish-pro' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control(
				'class',
				array (
					'label' => esc_html__( 'Class', 'bullish-pro' ),
					'type'  => Controls_Manager::TEXT
				)
			);

		$this->end_controls_section();
		//carousel settings
		$this->start_controls_section( 'product_carousel_section', array(
			'label' => esc_html__( 'Carousel Settings', 'bullish-pro' ),
			'condition'   => array( 'layout' => 'carousel' ),
		) );
		$this->add_responsive_control( 'carousel_slidesperview', array(
			'label'       => esc_html__( 'Slides Per View', 'bullish-pro' ),
			'type'        => Controls_Manager::SELECT,
			'description' => esc_html__( 'Number slides of to show in view port.', 'bullish-pro' ),
			'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
			'desktop_default'      => 4,
			'laptop_default'       => 4,
			'tablet_default'       => 2,
			'tablet_extra_default' => 2,
			'mobile_default'       => 1,
			'mobile_extra_default' => 1,
			'frontend_available'   => true,
		) );

		$this->add_control( 'carousel_mousewheelcontrol', array(
			'label'        => esc_html__( 'Enable Mousewheel Control', 'bullish-pro' ),
			'type'         => Controls_Manager::SWITCHER,
			'description'  => esc_html__('If you wish, you can enable mouse wheel control for your carousel.', 'bullish-pro'),
			'label_on'     => esc_html__( 'yes', 'bullish-pro' ),
			'label_off'    => esc_html__( 'no', 'bullish-pro' ),
			'default'      => '',
			'return_value' => 'true',
		) );
		$this->add_control( 'carousel_bulletpagination', array(
			'label'        => esc_html__( 'Enable Bullet Pagination', 'bullish-pro' ),
			'type'         => Controls_Manager::SWITCHER,
			'description'  => esc_html__('To enable bullet pagination.', 'bullish-pro'),
			'label_on'     => esc_html__( 'yes', 'bullish-pro' ),
			'label_off'    => esc_html__( 'no', 'bullish-pro' ),
			'default'      => '',
			'return_value' => 'true',
		) );
		$this->add_control( 'carousel_arrowpagination', array(
			'label'        => esc_html__( 'Enable Arrow Pagination', 'bullish-pro' ),
			'type'         => Controls_Manager::SWITCHER,
			'description'  => esc_html__('To enable arrow pagination.', 'bullish-pro'),
			'label_on'     => esc_html__( 'yes', 'bullish-pro' ),
			'label_off'    => esc_html__( 'no', 'bullish-pro' ),
			'default'      => '',
			'return_value' => 'true',
		) );
		$this->add_control( 'carousel_spacebetween', array(
			'label'       => esc_html__( 'Space Between Sliders', 'bullish-pro' ),
			'type'        => Controls_Manager::TEXT,
			'description' => esc_html__('Space between sliders can be given here.', 'bullish-pro'),
		) );

	$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		if($settings['product_id'] == '' && is_singular('product')) {
			global $post;
			$settings['product_id'] = $post->ID;
		}
					$slides_to_show = $settings['carousel_slidesperview'];
					$slides_to_scroll = 1;

					extract($settings);
						// Responsive control carousel
						$carousel_settings = array (
							'carousel_slidesperview' 			=> $slides_to_show
						);
					$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
					$breakpoint_keys = array_keys($active_breakpoints);
		
					$swiper_breakpoints = array ();
					$swiper_breakpoints[] = array (
						'breakpoint' => 319
					);
					$swiper_breakpoints_slides = array ();
					
					foreach($breakpoint_keys as $breakpoint) {
						$breakpoint_show_str = 'carousel_slidesperview_'.$breakpoint;
						$breakpoint_toshow = $$breakpoint_show_str;
						if($breakpoint_toshow == '') {
							if($breakpoint == 'mobile') {
								$breakpoint_toshow = 1;
							} else if($breakpoint == 'mobile_extra') {
								$breakpoint_toshow = 1;
							} else if($breakpoint == 'tablet') {
								$breakpoint_toshow = 2;
							} else if($breakpoint == 'tablet_extra') {
								$breakpoint_toshow = 2;
							} else if($breakpoint == 'laptop') {
								$breakpoint_toshow = 4;
							} else if($breakpoint == 'widescreen') {
								$breakpoint_toshow = 4;
							} else {
								$breakpoint_toshow = 4;
							}
						}
		
						$breakpoint_toscroll = 1;
			
						array_push($swiper_breakpoints, array (
								'breakpoint' => $active_breakpoints[$breakpoint]->get_value() + 1
							)
						);
						array_push($swiper_breakpoints_slides, array (
								'toshow' => (int)$breakpoint_toshow,
								'toscroll' => (int)$breakpoint_toscroll
							)
						);
			
					}
		
					array_push($swiper_breakpoints_slides, array (
							'toshow' => (int)$slides_to_show,
							'toscroll' => (int)$slides_to_scroll
						)
					);
		
					$responsive_breakpoints = array ();
		
					if(is_array($swiper_breakpoints) && !empty($swiper_breakpoints)) {
						foreach($swiper_breakpoints as $key => $swiper_breakpoint) {
							$responsive_breakpoints[] = array_merge($swiper_breakpoint, $swiper_breakpoints_slides[$key]);
						}
					}
		
					$carousel_settings['responsive'] = $responsive_breakpoints;
		
					$carousel_settings_value = wp_json_encode($carousel_settings);
					$carousel = '';
		if($settings['product_id'] != '') {
			if($settings['layout']=='carousel') $carousel='wdt-woo-carousel';
			$output .= '<div class="wdt-product-related-products ' .$carousel .$settings['class'].'" data-carousel_mousewheelcontrol="'.$settings['carousel_mousewheelcontrol'].'" data-carousel_bulletpagination="'.$settings['carousel_bulletpagination'].'" data-carousel_arrowpagination="'.$settings['carousel_arrowpagination'].'" data-carousel_spacebetween="'.$settings['carousel_spacebetween'].'"  data-carouselslidesperview="'.$settings['carousel_slidesperview'].'" data-carouselresponsive="'.esc_js($carousel_settings_value).'" data-layout="'.$settings['layout'].'">';

				if($settings['product_style_template'] == 'admin') {
					$product_style_template = bullish_customizer_settings( 'wdt-single-product-related-style-template' );
				} else {
					$product_style_template = $settings['product_style_template'];
				}

                $settings['product_related_style_template']        = 'custom';
                $settings['product_related_style_custom_template'] = $product_style_template;


				bullish_shop_single_module_upsell_related()->woo_load_listing( $settings['product_related_style_template'], $settings['product_related_style_custom_template'] );

				wc_set_loop_prop('product_related_hide_title', $settings['hide_title']);
				wc_set_loop_prop('columns', $settings['columns']);

				ob_start();
				woocommerce_related_products( array ( 'posts_per_page' => $settings['limit'], 'columns' => $settings['columns'], 'orderby' => 'rand' ) );
				$output .= ob_get_clean();

				bullish_shop_product_style_reset_loop_prop(); /* Reset Product Style Loop Prop */
				if($settings['layout']== "carousel")
				{
					$output .= '<div class="wdt-related-product-image-gallery-pagination-holder">';

					if($settings['carousel_bulletpagination'] == 'true') {
						$output .= '<div class="wdt-related-product-image-gallery-bullet-pagination"></div>';
					}
					if($settings['carousel_arrowpagination'] == 'true') {
							$output .= '<div class="wdt-related-product-image-arrow-pagination">';
							$output .= '<a href="#" class="wdt-related-product-image-gallery-arrow-prev">'.esc_html__('Prev', 'bullish-pro').'</a>';
							$output .= '<a href="#" class="wdt-related-product-image-gallery-arrow-next">'.esc_html__('Next', 'bullish-pro').'</a>';
							$output .= '</div>';
					}

					$output .= '</div>';
				}


			$output .= '</div>';

		} else {

			$output .= esc_html__('Please provide product id to display corresponding data!', 'bullish-pro');

		}

		echo $output;

	}

}