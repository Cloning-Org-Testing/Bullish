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
        $this->cc_layout = new WeDesignTech_Common_Controls_Layout('both');
        $this->cc_style = new WeDesignTech_Common_Controls_Style();

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
		if(!\Elementor\Plugin::$instance->preview->is_preview_mode()) {
			return array (
				$this->name() => $this->cc_layout->get_column_css()
			);
		}
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
                'default' => 'type-1',
                'options' => array(
                    'type-1'    => esc_html__('Type-1', 'wdt-elementor-addon'),
                    'type-2'    => esc_html__('Type-2', 'wdt-elementor-addon'),
                    'type-3'    => esc_html__('Type-3', 'wdt-elementor-addon')
                )
            ));
			$elementor_object->add_control( 'show_price', array(
				'label'   => esc_html__( 'Show Price', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'wdt-elementor-addon' ),
                'label_off'    => esc_html__( 'No', 'wdt-elementor-addon' ),
				'return_value' => 'yes',
                'default'      => ''
			) );

			$elementor_object->add_control(
				'currency_symbol',
				array(
					'label' => esc_html__( 'Currency Symbol', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'' => esc_html__( 'None', 'wdt-elementor-addon' ),
						'dollar' => '&#36; ' . _x( 'Dollar', 'Currency', 'wdt-elementor-addon' ),
						'euro' => '&#128; ' . _x( 'Euro', 'Currency', 'wdt-elementor-addon' ),
						'baht' => '&#3647; ' . _x( 'Baht', 'Currency', 'wdt-elementor-addon' ),
						'franc' => '&#8355; ' . _x( 'Franc', 'Currency', 'wdt-elementor-addon' ),
						'guilder' => '&fnof; ' . _x( 'Guilder', 'Currency', 'wdt-elementor-addon' ),
						'krona' => 'kr ' . _x( 'Krona', 'Currency', 'wdt-elementor-addon' ),
						'lira' => '&#8356; ' . _x( 'Lira', 'Currency', 'wdt-elementor-addon' ),
						'peseta' => '&#8359 ' . _x( 'Peseta', 'Currency', 'wdt-elementor-addon' ),
						'peso' => '&#8369; ' . _x( 'Peso', 'Currency', 'wdt-elementor-addon' ),
						'pound' => '&#163; ' . _x( 'Pound Sterling', 'Currency', 'wdt-elementor-addon' ),
						'real' => 'R$ ' . _x( 'Real', 'Currency', 'wdt-elementor-addon' ),
						'ruble' => '&#8381; ' . _x( 'Ruble', 'Currency', 'wdt-elementor-addon' ),
						'rupee' => '&#8360; ' . _x( 'Rupee', 'Currency', 'wdt-elementor-addon' ),
						'indian_rupee' => '&#8377; ' . _x( 'Rupee (Indian)', 'Currency', 'wdt-elementor-addon' ),
						'shekel' => '&#8362; ' . _x( 'Shekel', 'Currency', 'wdt-elementor-addon' ),
						'yen' => '&#165; ' . _x( 'Yen/Yuan', 'Currency', 'wdt-elementor-addon' ),
						'won' => '&#8361; ' . _x( 'Won', 'Currency', 'wdt-elementor-addon' ),
						'custom' => esc_html__( 'Custom', 'wdt-elementor-addon' ),
					),
					'default' => 'dollar',
					'condition' => array(
						'services_type' => 'type-2',
					)
				)
			);

			$elementor_object->add_control(
				'custom_symbol',
				array(
					'type'    => \Elementor\Controls_Manager::TEXT,
					'label'   => esc_html__('Custom Symbol', 'wdt-elementor-addon'),
					'default' => '',
					'condition' => array(
						'currency_symbol' => 'custom',
					)
				)
			);

            $elementor_object->add_control('button_text', array(
                'label'       => esc_html__('Button Text', 'wdt-elementor-addon'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__('Read More', 'wdt-elementor-addon'),
                'description' => esc_html__('This text will be used as the button label if the individual service does not have a custom button text set.', 'wdt-elementor-addon'),
            ));


        $elementor_object->end_controls_section();

		$this->cc_layout->get_controls($elementor_object);

        // Items
        $this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'item',
			'title' => esc_html__( 'Item', 'wdt-elementor-addon' ),
			'styles' => array (
				'alignment' => array (
					'field_type' => 'alignment',
                    'control_type' => 'responsive',
                    'default' => 'center',
					'selector' => array (
						'{{WRAPPER}} .wdt-service-item' => 'text-align: {{VALUE}}; justify-content: {{VALUE}};'
					),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-service-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-service-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-service-item',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-service-item',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-service-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-service-item',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-service-item:hover',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-service-item:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-service-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-service-item:hover',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

        // Image
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'image',
			'title' => esc_html__( 'Image', 'wdt-elementor-addon' ),
			'styles' => array (
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-service-item .wdt-service-image' => 'text-align: {{VALUE}}; justify-content: {{VALUE}};'
					),
					'condition' => array ()
				),
				'width' => array (
					'field_type' => 'width',
					'selector' => array (
                        '{{WRAPPER}} .wdt-service-item .wdt-service-image > a' => 'width: {{SIZE}}{{UNIT}};'
                    ),
					'condition' => array ()
				),
				'height' => array (
					'field_type' => 'height',
					'selector' => array (
                        '{{WRAPPER}} .wdt-service-item .wdt-service-image > a' => 'height: {{SIZE}}{{UNIT}};'
                    ),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-service-item .wdt-service-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-service-item .wdt-service-image > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'border' => array (
					'field_type' => 'border',
					'selector' => '{{WRAPPER}} .wdt-service-item .wdt-service-image > a',
					'condition' => array ()
				),
				'border_radius' => array (
					'field_type' => 'border_radius',
					'selector' => array (
						'{{WRAPPER}} .wdt-service-item .wdt-service-image > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'box_shadow' => array (
					'field_type' => 'box_shadow',
					'selector' => '{{WRAPPER}} .wdt-service-item .wdt-service-image > a',
					'condition' => array ()
				)
			)
		));

        // Icon
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'icon',
			'title' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
			'styles' => array (
				'font_size' => array (
					'field_type' => 'font_size',
					'selector' => array (
                        '{{WRAPPER}} .wdt-service-item .wdt-service-type-icon' => 'font-size: {{SIZE}}{{UNIT}};'
                    ),
					'condition' => array ()
				),
				'width' => array (
					'field_type' => 'width',
					'default' => array (
						'unit' => 'px'
					),
					'size_units' => array ( 'px' ),
					'range' => array (
                        'px' => array (
                            'min' => 10,
                            'max' => 500,
                        )
                    ),
					'selector' => array (
						'{{WRAPPER}} .wdt-service-item .wdt-service-type-icon' => 'width: {{SIZE}}{{UNIT}};'
					)
				),
				'height' => array (
					'field_type' => 'height',
					'default' => array (
						'unit' => 'px'
					),
					'size_units' => array ( 'px' ),
					'range' => array (
                        'px' => array (
                            'min' => 10,
                            'max' => 500,
                        )
                    ),
					'selector' => array (
						'{{WRAPPER}} .wdt-service-item .wdt-service-type-icon' => 'height: {{SIZE}}{{UNIT}};'
					)
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-service-item .wdt-service-type-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-service-item .wdt-service-type-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs_default' => array (
					'field_type' => 'tabs',
					'unique_key' => 'default',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-service-item .wdt-service-type-icon' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-service-item .wdt-service-type-icon',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-service-item .wdt-service-type-icon',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}}  .wdt-service-item .wdt-service-type-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-service-item .wdt-service-type-icon',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-service-item:hover .wdt-service-type-icon' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-service-item:hover .wdt-service-type-icon',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-service-item:hover .wdt-service-type-icon',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-service-item:hover .wdt-service-type-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-service-item:hover .wdt-service-type-icon',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

		// Title
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'title',
			'title' => esc_html__( 'Title', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-service-item .wdt-service-title h5',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-service-item .wdt-service-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-service-item .wdt-service-title h5, 
										 {{WRAPPER}} .wdt-service-item .wdt-service-title h5 > a' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-service-item:hover .wdt-service-title h5 > a:hover' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
							)
						)
					)
				)
			)
		));

        // Description
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'description',
			'title' => esc_html__( 'Description', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-service-item .wdt-service-description',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-service-item .wdt-service-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-service-item .wdt-service-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'color' => array (
					'field_type' => 'color',
					'selector' => array (
						'{{WRAPPER}} .wdt-service-item .wdt-service-description' => 'color: {{VALUE}};'
					),
					'condition' => array ()
				)
			)
		));

        // Button
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'button',
			'title' => esc_html__( 'Button', 'wdt-elementor-addon' ),
			'styles' => array (
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-service-item .wdt-service-button > a',
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
                        '{{WRAPPER}} .wdt-service-item .wdt-service-button > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-service-item .wdt-service-button > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-service-item .wdt-service-button > a' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-service-item .wdt-service-button > a',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-service-item .wdt-service-button > a',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-service-item .wdt-service-button > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-service-item .wdt-service-button > a',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-service-item:hover .wdt-service-button > a:focus, 
										 {{WRAPPER}} .wdt-service-item:hover .wdt-service-button > a:hover' => 'color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-service-item:hover .wdt-service-button > a:focus, 
									 			   {{WRAPPER}} .wdt-service-item:hover .wdt-service-button > a:hover',
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-service-item:hover .wdt-service-button > a:focus, 
												   {{WRAPPER}} .wdt-service-item:hover .wdt-service-button > a:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-service-item:hover .wdt-service-button > a:focus, 
										 {{WRAPPER}} .wdt-service-item:hover .wdt-service-button > a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-service-item:hover .wdt-service-button > a:focus, 
												   {{WRAPPER}} .wdt-service-item:hover .wdt-service-button > a:hover',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

        // Carousel
        $this->cc_layout->get_carousel_style_controls($elementor_object, array ('layout' => 'carousel'));

    }

    public function render_html($widget_object, $settings) {

        if($widget_object->widget_type != 'elementor') {
            return;
        }

        $output = '';
        $classes = array ();

        $settings['module_id']    = $widget_object->get_id();
        $settings['module_class'] = 'services';
        $settings['classes'] = $classes;
        $this->cc_layout->set_settings($settings);
        $module_layout_class = $this->cc_layout->get_item_class();
    
		
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


            $output .= $this->cc_layout->get_wrapper_start();

            while ($form_query->have_posts()) {

                $form_query->the_post();
                $service_id = get_the_ID();

                
				$service_settings = get_post_meta(get_the_ID(), '_bullish_service_settings', true);
				// echo'<pre>Serviceee'; print_r($service_settings); echo'</pre>';

				$icon  = !empty($service_settings['service_icon']) ? $service_settings['service_icon'] : '';
				$price = !empty($service_settings['service_price']) ? $service_settings['service_price'] : '';
				$offerprice = !empty($service_settings['service_offer_price']) ? $service_settings['service_offer_price'] : '';
                $service_type = isset($settings['services_type']) ? $settings['services_type'] : 'type-1';

                $output .= '<div class="'.esc_attr($module_layout_class).'">';
					$output .= '<div class="wdt-service-item wdt-' . esc_attr($service_type) . '">';

                        if ($service_type === 'type-1') {

                            $output .= '<div class="wdt-service-media-group">';
                                $output .= '<div class="wdt-service-image">';
                                	$output .= $this->render_service_image($service_id);
								$output .= '</div>';
                            $output .= '</div>';

                            $output .= '<div class="wdt-service-detail-group">';
								$output .= '<div class="wdt-service-icon">';
									$output .= $this->render_service_icon($icon);
								$output .= '</div>';
								$output .= '<div class="wdt-service-title"><h5>';
                                    $output .= '<a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a>';
                                $output .= '</h5></div>';

							if ($settings['show_price'] == true) {
								if (!empty($price) || !empty($offerprice)) {

									$currency_symbol_key = $settings['currency_symbol'] ?? '';
									$custom_symbol = $settings['custom_symbol'] ?? '';

									$symbol = ($currency_symbol_key === 'custom') ? esc_html($custom_symbol) : $this->get_currency_symbol($currency_symbol_key);
									$output .= '<div class="wdt-service-type-price-group">';
									$output .= '<div class="wdt-service-type-price">' . $symbol . esc_html($price) . '</div>';
									$output .= '<div class="wdt-service-type-offerprice">' . $symbol . esc_html($offerprice) . '</div>';
									$output .= '</div>';

								}
							}
                                $excerpt = get_the_excerpt($service_id);
                                if ( !empty($excerpt) ) {
                                    $output .= '<div class="wdt-service-description">' . esc_html($excerpt) . '</div>';
                                }                    
                                            
                                if ( !empty($settings['button_text']) ) {
                                    $output .= '<div class="wdt-service-button">';
                                        $output .= '<a href="' . esc_url(get_permalink()) . '">' . esc_html($settings['button_text']) . '</a>';
                                    $output .= '</div>';
                                }
                            $output .= '</div>';

                        } elseif ($service_type === 'type-2') {

							

                            $output .= $this->render_service_icon($icon);
                            
                            $output .= '<div class="wdt-service-title"><h5>';
                                    $output .= '<a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a>';
                                $output .= '</h5></div>';
                            
                            $excerpt = get_the_excerpt($service_id);
                            if ( !empty($excerpt) ) {
                                $output .= '<div class="wdt-service-description">' . esc_html($excerpt) . '</div>';
                            } 
							if ($settings['show_price'] == true) {
								if (!empty($price) || !empty($offerprice)) {

									$currency_symbol_key = $settings['currency_symbol'] ?? '';
									$custom_symbol = $settings['custom_symbol'] ?? '';

									$symbol = ($currency_symbol_key === 'custom') ? esc_html($custom_symbol) : $this->get_currency_symbol($currency_symbol_key);
									$output .= '<div class="wdt-service-type-price-group">';
									$output .= '<div class="wdt-service-type-price">' . $symbol . esc_html($price) . '</div>';
									$output .= '<div class="wdt-service-type-offerprice">' . $symbol . esc_html($offerprice) . '</div>';
									$output .= '</div>';

								}
							}

							if ( !empty($settings['button_text']) ) {
								$output .= '<div class="wdt-service-button">';
									$output .= '<a href="' . esc_url(get_permalink()) . '">' . esc_html($settings['button_text']) . '</a>';
								$output .= '</div>';
							}		

                        } elseif ($service_type === 'type-3') {
                            
                            
                            $output .= '<div class="wdt-service-media-group">';
								$output .= '<div class="wdt-service-image">';
                                	$output .= $this->render_service_image($service_id);
								$output .= '</div>';
                            $output .= '</div>';
                            
                            $output .= '<div class="wdt-service-detail-group">';

							$output .= '<div class="wdt-service-content-group">';
									$output .= '<div class="wdt-service-title"><h5>';
										$output .= '<a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a>';
									$output .= '</h5></div>';
									$output .= $this->render_service_icon($icon);
							$output .='</div>';
                                
                            if ($settings['show_price'] == true) {
								if (!empty($price) || !empty($offerprice)) {

									$currency_symbol_key = $settings['currency_symbol'] ?? '';
									$custom_symbol = $settings['custom_symbol'] ?? '';

									$symbol = ($currency_symbol_key === 'custom') ? esc_html($custom_symbol) : $this->get_currency_symbol($currency_symbol_key);
									$output .= '<div class="wdt-service-type-price-group">';
									$output .= '<div class="wdt-service-type-price">' . $symbol . esc_html($price) . '</div>';
									$output .= '<div class="wdt-service-type-offerprice">' . $symbol . esc_html($offerprice) . '</div>';
									$output .= '</div>';

								}
							}
                                $excerpt = get_the_excerpt($service_id);
                                if ( !empty($excerpt) ) {
                                    $output .= '<div class="wdt-service-description">' . esc_html($excerpt) . '</div>';
                                }                    
                                            
                                if ( !empty($settings['button_text']) ) {
                                    $output .= '<div class="wdt-service-button">';
                                        $output .= '<a href="' . esc_url(get_permalink()) . '">' . esc_html($settings['button_text']) . '</a>';
                                    $output .= '</div>';
                                }
                            $output .= '</div>';
                            
                        }

                    $output .= '</div>';
                $output .= '</div>';
            }


            wp_reset_postdata();
            $output .= $this->cc_layout->get_column_edit_mode_css();
            $output .= $this->cc_layout->get_wrapper_end();
        }

        return $output;
    }

    public function render_service_icon($icon) {
        
        $output = '';

        if (!empty($icon)) {
            if (strpos($icon, '.svg') !== false) {
                $svg_path = ABSPATH . str_replace(site_url('/'), '', $icon);
                if (file_exists($svg_path)) {
                    $svg_content = file_get_contents($svg_path);
                    if ($svg_content !== false) {
                        $output .= '<div class="wdt-service-type-icon svg-icon">' . $svg_content . '</div>';
                    }
                }
            } else {
                $output .= '<div class="wdt-service-type-icon"><img src="' . esc_url($icon) . '" alt="Service Icon" title="Service Icon"/></div>';
            }
        }

        return $output;
    }

    public function render_service_image($service_id) {

		if (has_post_thumbnail($service_id)) {

			$image = get_the_post_thumbnail($service_id, 'full');
			$permalink = get_permalink($service_id);

			return '<a href="' . esc_url($permalink) . '">' . $image . '</a>';

		} else {

			$title = get_the_title($service_id);
			$permalink = get_permalink($service_id);
			$img_tag = '<img src="https://dummyimage.com/1200x800/cccccc/999999.jpg?text=' . esc_attr($title) . '" alt="' . esc_attr($title) . '" />';

			return '<a href="' . esc_url($permalink) . '">' . $img_tag . '</a>';
		}

    }

	private function get_currency_symbol( $symbol_name ) {
		$symbols = [
			'dollar' => '&#36;',
            'euro' => '&#128;',
            'baht' => '&#3647;',
            'franc' => '&#8355;',
            'guilder' => '&fnof;',
            'krona' => 'kr',
            'lira' => '&#8356;',
            'peseta' => '&#8359;',
            'peso' => '&#8369;',
            'pound' => '&#163;',
            'real' => 'R$',
            'ruble' => '&#8381;',
            'rupee' => '&#8360;',
            'indian_rupee' => '&#8377;',
            'shekel' => '&#8362;',
            'yen' => '&#165;',
            'won' => '&#8361;',
		];

		return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
	}

}


if( !function_exists( 'wedesigntech_widget_base_services' ) ) {
    function wedesigntech_widget_base_services() {
        return WeDesignTech_Widget_Base_Services::instance();
    }
}