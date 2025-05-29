<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Services {

    private static $_instance = null;

    private $cc_layout;
	private $cc_style;

    public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

    function __construct() {

		// Initialize depandant class
			$this->cc_style = new WeDesignTech_Common_Controls_Style();
            $this->cc_layout = new WeDesignTech_Common_Controls_Layout('carousel');

	}

    public function name() {
		return 'wdt-services';
	}

    public function title() {
		return esc_html__( 'Services', 'wdt-elementor-addon' );
	}

    public function icon() {
		return 'eicon-apps';
	}

    public function init_styles() {
		return array_merge(
            $this->cc_layout->init_styles(),
            array(
                $this->name() => WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/services/assets/css/style.css'
            )	
		);
	}

    public function init_inline_styles() {
		return array ();
	}

    public function init_scripts() {
        return array_merge(
            $this->cc_layout->init_scripts(),
            array()
        );
    }

    public function create_elementor_controls($elementor_object) {

        $elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Services Settings', 'wdt-elementor-addon'),
		));

            $elementor_object->add_control('services_type', array(
                'type'    => \Elementor\Controls_Manager::SELECT,
                'label'   => esc_html__('Services Type', 'wdt-elementor-addon'),
                'default' => 'type1',
                'options' => array(
                    'type_1'    => esc_html__('Type-1', 'wdt-elementor-addon'),
                    'type_2'    => esc_html__('Type-2', 'wdt-elementor-addon'),
                    'type_3'    => esc_html__('Type-3', 'wdt-elementor-addon')
                )
            ));

            $elementor_object->add_control('layout', array(
                'label'       => esc_html__('Layout Type', 'wdt-elementor-addon'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'description' => esc_html__('Choose type that you like yo use.', 'wdt-elementor-addon'),
                'options'     => array(
                    'column' => esc_html__('Column', 'wdt-elementor-addon'),
                    'carousel' => esc_html__('Carousel', 'wdt-elementor-addon')
                ),
                'default'     => 'column',
            ));

            $elementor_object->add_control('content_alignment', array(
                'label'   => esc_html__('Content Alignment', 'wdt-elementor-addon'),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => array(
                    'left'   => ['title' => esc_html__('Left', 'wdt-elementor-addon'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => esc_html__('Center', 'wdt-elementor-addon'), 'icon' => 'eicon-text-align-center'],
                    'right'  => ['title' => esc_html__('Right', 'wdt-elementor-addon'), 'icon' => 'eicon-text-align-right'],
                ),
                'default'   => 'left',
                'toggle'    => true,
                'condition' => ['layout' => 'column'],
            ));

            $elementor_object->add_control('columns', array(
                'label'       => esc_html__('Columns', 'wdt-elementor-addon'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'options'     => array(
                    1  => esc_html__('I Column', 'wdt-elementor-addon'),
                    2  => esc_html__('II Columns', 'wdt-elementor-addon'),
                    3  => esc_html__('III Columns', 'wdt-elementor-addon')
                ),
                'description' => esc_html__('Number of columns you like to display your taxonomies.', 'wdt-elementor-addon'),
                'default'      => 3,
                'condition' => array('layout' => 'column'),
            ));

        $elementor_object->end_controls_section();

		$this->cc_layout->get_controls($elementor_object);

    }

    public function render_html($widget_object, $settings) {

        if($widget_object->widget_type != 'elementor') {
            return;
        }

        $output = '';

        $settings['module_id']    = $widget_object->get_id();
        $settings['module_class'] = 'services';
        $this->cc_layout->set_settings($settings);
    
        $swiperclass = '';
        $swiperwrapperclass = '';
        $column_class = '';
        $content_align_class = '';
        $outer_wrapper_class = '';
        $inner_wrapper_start = '';
        $inner_wrapper_end = '';
        $slide_class = '';

        if ($settings['layout'] === 'column') {

            if ($settings['columns'] == 1) {
                $column_class = 'column wdt-one-column';
            } elseif ($settings['columns'] == 2) {
                $column_class = 'column wdt-one-half';
            } else {
                $column_class = 'column wdt-one-third';
            }

            if (!empty($settings['content_alignment'])) {
                $content_align_class = 'align-' . $settings['content_alignment'];
            }

            $outer_wrapper_class = 'wdt-services-column-wrapper';

        } else if ($settings['layout'] === 'carousel') {

            $module_layout_class = $this->cc_layout->get_item_class();
            $outer_wrapper_class = 'swiper-container';
            $inner_wrapper_start = '<div class="swiper-wrapper">';
            $inner_wrapper_end = '</div>';
            $slide_class = 'swiper-slide';
        }


        $service_type_class = 'wdt_type_' . str_replace('type', '', $settings['services_type']);

        // Query Arguments
        $form_args = array(
            'post_type'      => 'wdt_services',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        );

        if (!empty($settings['_post_ids'])) {
            $form_args['post__in'] = $settings['_post_ids'];
            $form_args['orderby'] = 'post__in';
        }

        $form_query = new WP_Query($form_args);

        if ($form_query->have_posts()) {


            $output .= $this->cc_layout->get_wrapper_start(array('class' => $service_type_class . ' ' . $outer_wrapper_class));
            $output .= $inner_wrapper_start;

            while ($form_query->have_posts()) {
                $form_query->the_post();
                $service_id = get_the_ID();

                $price = get_post_meta($service_id, 'service_price', true);
                $button_text = get_post_meta($service_id, 'service_button_text', true);
                $icon = get_post_meta($service_id, 'service_icon', true);
                $service_description = get_post_meta($service_id, 'service_description', true);
                $service_type = $settings['services_type'];
                
                $output .= '<div class="' . esc_attr(trim($module_layout_class . ' ' . $column_class . ' ' . $content_align_class . ' ' . $slide_class)) . ' wdt-service-types-holder">';

                if ($service_type === 'type_1') {
                    $output .= '<div class="wdt-service-type-wrapper wdt_' . esc_attr($service_type) . '">';
                    $output .= '<div class="wdt-service-type-title">' . get_the_title() . '</div>';
                    $output .= '<div class="wdt-service-type-description">' . esc_html($service_description) . '</div>';
                    $output .= '</div>';

                } elseif ($service_type === 'type_2') {
                    $output .= '<div class="wdt-service-type-wrapper wdt_' . esc_attr($service_type) . '">';
                    $output .= '<div class="wdt-service-type-icon"><img src="' . esc_url($icon) . '" alt="Service Icon" title="Service Icon"/></div>';
                    $output .= '<div class="wdt-service-type-title">' . get_the_title() . '</div>';
                    $output .= '<div class="wdt-service-type-price">$' . esc_html($price) . '</div>';
                    $output .= '</div>';

                } elseif ($service_type === 'type_3') {
                    $output .= '<div class="wdt-service-type-wrapper wdt_' . esc_attr($service_type) . '">';
                        if (has_post_thumbnail()) {
                            $output .= '<div class="wdt-service-type-thumb">';
                                $output .= get_the_post_thumbnail($service_id, 'full');
                            $output .= '</div>';
                        }
                        $output .= '<div class="wdt-service-items">';
                            if (!empty($icon)) {
                                $output .= '<div class="wdt-service-type-icon"><img src="' . esc_url($icon) . '" alt="Service Icon"  title="Service Icon"/></div>';

                            }
                            $output .= '<div class="wdt-service-type-title">' . get_the_title() . '</div>';
                            if (!empty($price)) {
                                $output .= '<div class="wdt-service-type-price">$' . esc_html($price) . '</div>';
                            }
                            if (!empty($service_description)) {
                                $output .= '<div class="wdt-service-type-service_description">' . esc_html($service_description) . '</div>';
                            }
                            if (!empty($button_text)) {
                                $output .= '<div class="wdt-service-type-btn"><a href="' . esc_url(get_permalink()) . '" class="wdt-btn">' . esc_html($button_text) . '</a></div>';
                            }
                        $output .= '</div>';
                    $output .= '</div>';
                }

                $output .= '</div>';
            }


            $output .= $inner_wrapper_end;


            wp_reset_postdata();
            $output .= $this->cc_layout->get_column_edit_mode_css();
            $output .= $this->cc_layout->get_wrapper_end();
        }

        return $output;
    }



    public function wdt_service_post_ids(){
		$posts = get_posts( array(
			'post_type'   => 'wdt_services',
			'post_status' => 'publish',
			'numberposts' => -1
		));
		$options = array();
		if ( ! empty( $posts ) && ! is_wp_error( $posts ) ){
			foreach ( $posts as $post ) {
				$options[ $post->ID ] = $post->post_title;
			}
		}

		return $options;
	}

}


if( !function_exists( 'wedesigntech_widget_base_services' ) ) {
    function wedesigntech_widget_base_services() {
        return WeDesignTech_Widget_Base_Services::instance();
    }
}