<?php
use BullishElementor\Widgets\BullishElementorWidgetBase;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Header_Services extends BullishElementorWidgetBase {

    public function get_name() {
        return 'wdt-services-listing';
    }

    public function get_title() {
        return esc_html__('Services Listing', 'bullish-plus');
    }

    public function get_icon() {
		return 'eicon-header wdt-icon';
	}

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            
            'label' => esc_html__('General', 'bullish-plus'),
            'tab' => Controls_Manager::TAB_CONTENT,

        ) );

        $this->add_control( 'query_posts_by', array(
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__('Query posts by', 'bullish-plus'),
                'default' => 'category',
                'options' => array(
                    'category'  => esc_html__('From Category (for Posts only)', 'bullish-plus'),
                    'ids'       => esc_html__('By Specific IDs', 'bullish-plus'),
                )
            ) );

        $this->add_control( '_post_categories', array(
            'label'       => esc_html__( 'Categories', 'bullish-plus' ),
            'type'        => Controls_Manager:: SELECT2,
            'label_block' => true,
            'multiple'    => true,
            'options'     => $this->bullish_post_categories(),
            'condition'   => array( 'query_posts_by' => 'category' )
        ) );

        $this->add_control( '_post_ids', array(
            'label'       => esc_html__( 'Select Specific Posts', 'bullish-plus' ),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'multiple'    => true,
            'options'     => $this->bullish_post_ids(),
            'condition' => array( 'query_posts_by' => 'ids' )
        ) );

        $this->add_control( 'count', array(
            'type'        => Controls_Manager::NUMBER,
            'label'       => esc_html__('Post Counts', 'bullish-plus'),
            'default'     => '5',
            'placeholder' => esc_html__( 'Enter post count', 'bullish-plus' ),
        ) );
        $this->add_control( 'couses_excerpt_length', array(
                'type'      => Controls_Manager::NUMBER,
                'label'     => esc_html__('Excerpt Length', 'bullish-plus'),
                'default'   => '25',
        ) );
        $this->add_control( 'enable_poupup', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Poupup?', 'bullish-plus'),
                'label_on'     => esc_html__( 'Yes', 'bullish-plus' ),
                'label_off'    => esc_html__( 'No', 'bullish-plus' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );
        $this->add_control('services_type', array(
            'type'    => Controls_Manager::SELECT,
            'label'   => esc_html__('Services Type', 'bullish-plus'),
            'default' => 'type1',
            'options' => array(
                'type1'  => esc_html__('Type 1', 'bullish-plus'),
                'type2'       => esc_html__('Type 2', 'bullish-plus'),
                'type3'       => esc_html__('Type 3', 'bullish-plus')
            )
        ));
        $this->add_control('layout', array(
            'label'       => esc_html__('Layout Type', 'bigboss-pro'),
            'type'        => Controls_Manager::SELECT,
            'description' => esc_html__('Choose type that you like yo use.', 'bigboss-pro'),
            'options'     => array(
                'column' => esc_html__('Column', 'bigboss-pro'),
                'carousel' => esc_html__('Carousel', 'bigboss-pro')
            ),
            'default'     => 'column',
        ));

        $this->add_control('columns', array(
            'label'       => esc_html__('Columns', 'bigboss-pro'),
            'type'        => Controls_Manager::SELECT,
            'options'     => array(
                1  => esc_html__('I Column', 'bigboss-pro'),
                2  => esc_html__('II Columns', 'bigboss-pro'),
                3  => esc_html__('III Columns', 'bigboss-pro')
            ),
            'description' => esc_html__('Number of columns you like to display your taxonomies.', 'bigboss-pro'),
            'default'      => 3,
            'condition' => array('layout' => 'column'),
        ));
        $this->add_control('carousel_arrowpagination', array(
            'label'        => esc_html__('Enable Arrow Pagination', 'bigboss-pro'),
            'type'         => Controls_Manager::SWITCHER,
            'description'  => esc_html__('To enable arrow pagination.', 'bigboss-pro'),
            'label_on'     => esc_html__('yes', 'bigboss-pro'),
            'label_off'    => esc_html__('no', 'bigboss-pro'),
            'default'      => '',
            'return_value' => 'true',
            'condition' => array('layout' => 'carousel'),
        ));
        $slides_per_view = range(1, 5);
        $slides_per_view = array_combine($slides_per_view, $slides_per_view);

        $this->add_responsive_control('slides_to_show_opts', array(
            'type' => \Elementor\Controls_Manager::SELECT,
            'label' => esc_html__('Slides to Show', 'wdt-elementor-addon'),
            'options' => $slides_per_view,
            'desktop_default'      => 4,
            'laptop_default'       => 4,
            'tablet_default'       => 2,
            'tablet_extra_default' => 2,
            'mobile_default'       => 1,
            'mobile_extra_default' => 1,
            'frontend_available'   => true,
            'condition' => array('layout' => 'carousel')
        ));
        $this->add_responsive_control(
            'gap',
            array(
                'label' => esc_html__('Gap', 'wdt-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 20,
                    'unit' => 'dpt',
                ),
                'size_units' => array('dpt'),
                'range' => array(
                    'dpt' => array(
                        'min' => 0,
                        'step' => 1,
                        'max' => 100
                    )
                ),
                'frontend_available' => true,
                'condition' => array('layout' => 'carousel')
            )
        );
        $this->add_control('carousel_loopmode', array(
            'label'        => esc_html__('Enable Loop Mode', 'bigboss-pro'),
            'type'         => Controls_Manager::SWITCHER,
            'description'  => esc_html__('If you wish, you can enable continuous loop mode for your carousel.', 'bigboss-pro'),
            'label_on'     => esc_html__('yes', 'bigboss-pro'),
            'label_off'    => esc_html__('no', 'bigboss-pro'),
            'default'      => '',
            'return_value' => 'true',
            'condition' => array('layout' => 'carousel'),
        ));
        $this->add_control('carousel_bulletpagination', array(
            'label'        => esc_html__('Enable Bullet Pagination', 'bigboss-pro'),
            'type'         => Controls_Manager::SWITCHER,
            'description'  => esc_html__('To enable bullet pagination.', 'bigboss-pro'),
            'label_on'     => esc_html__('yes', 'bigboss-pro'),
            'label_off'    => esc_html__('no', 'bigboss-pro'),
            'default'      => '',
            'return_value' => 'true',
            'condition' => array('layout' => 'carousel'),
        ));
        $this->end_controls_section();


    }
    public function get_thumb_carousel_attributes($settings)
    {

        extract($settings);

        $slides_to_show = $slides_to_show_opts;
        $slides_to_scroll = $slides_to_show;
        $carousel_settings = array(
            'slides_to_scroll'          => $slides_to_scroll,
            'slides_to_show'             => $slides_to_show,
            'loop'                        => $carousel_loopmode,
            'arrows'                    => $carousel_arrowpagination,
            'bulletpagination'            => $carousel_bulletpagination,
            'gap'                         => isset($gap['size']) ? $gap['size'] : 20
        );

        $active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
        $breakpoint_keys = array_keys($active_breakpoints);

        $space_between_gaps = array('desktop' => isset($gap['size']) ? $gap['size'] : 20);

        $swiper_breakpoints = array();
        $swiper_breakpoints[] = array(
            'breakpoint' => 319
        );
        $swiper_breakpoints_slides = array();

        foreach ($breakpoint_keys as $breakpoint) {

            $breakpoint_show_str = 'slides_to_show_opts_' . $breakpoint;
            $breakpoint_toshow = $$breakpoint_show_str;
            if ($breakpoint_toshow == '') {
                if ($breakpoint == 'mobile') {
                    $breakpoint_toshow = 1;
                } else if ($breakpoint == 'mobile_extra') {
                    $breakpoint_toshow = 1;
                } else if ($breakpoint == 'tablet') {
                    $breakpoint_toshow = 2;
                } else if ($breakpoint == 'tablet_extra') {
                    $breakpoint_toshow = 2;
                } else if ($breakpoint == 'laptop') {
                    $breakpoint_toshow = 4;
                } else if ($breakpoint == 'widescreen') {
                    $breakpoint_toshow = 4;
                } else {
                    $breakpoint_toshow = 4;
                }
            }
            $breakpoint_toscroll = $breakpoint_toshow;

            $breakpoint_gap_str = 'gap_' . $breakpoint;
            $breakpoint_gap = $$breakpoint_gap_str;
            $breakpoint_gap = ($breakpoint_gap['size'] != '') ? $breakpoint_gap['size'] : $gap['size'];

            $space_between_gaps[$breakpoint] = $breakpoint_gap;


            array_push(
                $swiper_breakpoints,
                array(
                    'breakpoint' => $active_breakpoints[$breakpoint]->get_value() + 1
                )
            );
            array_push(
                $swiper_breakpoints_slides,
                array(
                    'toshow' => (int)$breakpoint_toshow,
                    'toscroll' => (int)$breakpoint_toscroll
                )
            );
        }

        array_push(
            $swiper_breakpoints_slides,
            array(
                'toshow' => (int)$slides_to_show,
                'toscroll' => (int)$slides_to_scroll
            )
        );

        $responsive_breakpoints = array();
        if (is_array($swiper_breakpoints) && !empty($swiper_breakpoints)) {
            foreach ($swiper_breakpoints as $key => $swiper_breakpoint) {
                $responsive_breakpoints[] = array_merge($swiper_breakpoint, $swiper_breakpoints_slides[$key]);
            }
        }

        $carousel_settings['responsive'] = $responsive_breakpoints;
        $carousel_settings['space_between_gaps'] = $space_between_gaps;
        return wp_json_encode($carousel_settings);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $excerpt_length = isset($settings['couses_excerpt_length']) ? $settings['couses_excerpt_length'] : 25;
        $carousel_arrowpagination = isset($settings['carousel_arrowpagination']) ? $settings['carousel_arrowpagination'] : '';
        $carousel_bulletpagination = isset($settings['carousel_bulletpagination']) ? $settings['carousel_bulletpagination'] : '';
        $settings_attr = $this->get_thumb_carousel_attributes($settings);
        $column_class = '';
        $swiperclass = '';
        $swiperwrapperclass = '';
        $post_count = isset($settings['count']) ? $settings['count'] : 5;
        // Determine column class
        if ($settings['layout'] == 'column') {
            if ($settings['columns'] == 1) {
                $column_class = 'column wdt-one-column';
            } else if ($settings['columns'] == 2) {
                $column_class = 'column wdt-one-half';
            } else {
                $column_class = 'column wdt-one-third';
            }
        } else {
            $swiperclass= 'swiper-container';
            $swiperwrapperclass = 'swiper-wrapper';
            $column_class = 'swiper-slide';
        }
        $args = array(
            'post_type'      => 'wdt_services',
            'posts_per_page' => $post_count
        );

        $query = new WP_Query($args);
        if ($query->have_posts()) {
            $service_type = isset($settings['services_type']) ? $settings['services_type'] : 'type1';
            echo '<div class="wdt-services-listing ' . esc_attr($service_type) . ' ' . esc_attr($swiperclass) . '" data-settings="' . esc_attr($settings_attr) . '">';
            echo '<div class="' . esc_attr($swiperwrapperclass) . '">';
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                $post_link = get_permalink($post_id);
                $service_icon = get_post_meta($post_id, 'service_icon', true);

                $service_structures = array(
                    'type1' => array(
                        'media_grp'   => array('image', 'icon', 'categories'),
                        'content_grp' => array('title', 'description', 'button')
                    ),
                    'type2' => array(
                        'media_grp'   => array('image'),
                        'content_grp' => array('icon', 'title', 'button')
                    ),
                    'type3' => array(
                        'media_grp'   => array('image'),
                        'content_grp' => array('icon', 'title', 'description', 'button')
                    )
                );

                $structure = isset($service_structures[$service_type]) ? $service_structures[$service_type] : null;

                if ($structure) {
                    echo '<div class="wdt-services-listing-column ' . htmlspecialchars($column_class) . '">';
                    echo '<div class="media-grp">';
                    foreach ($structure['media_grp'] as $field) {
                        switch ($field) {
                            case 'image':
                                if (has_post_thumbnail()) {
                                    echo '<div class="wdt-service-image"><a href="' . esc_url($post_link) . '"><img src="' . esc_url(get_the_post_thumbnail_url($post_id, 'full')) . '" alt="' . esc_attr(get_the_title()) . '" title="' . esc_attr(get_the_title()) . '"></a></div>';
                                } else {
                                    echo '<div class="wdt-service-image"><a href="' . esc_url($post_link) . '"><img src="' . esc_url(get_template_directory_uri() . '/images/default-image.jpg') . '" alt="Default Image" title="Default Image"></a></div>';
                                }
                                break;

                            case 'button':
                                echo '<button><a href="' . esc_url($post_link) . '">' . esc_html__('Read More', 'bullish-plus') . '</a></button>';
                                break;
                            case 'categories':
                                $categories = get_the_terms($post_id, 'wdt_service_category');
                                if ($categories) {
                                    echo '<div class="wdt-service-categories">';
                                    foreach ($categories as $category) {
                                        echo '<a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a>';
                                    }
                                    echo '</div>';
                                }
                                break;
                        }
                    }
                    echo '</div>';

                    echo '<div class="content-grp">';
                    if (!empty($service_icon)) {
                        echo '<div id="service_icon">';
                        $file_extension = pathinfo($service_icon, PATHINFO_EXTENSION);
                        if (strtolower($file_extension) === 'svg') {
                            echo file_get_contents($service_icon);
                        } else {
                            echo '<img src="' . esc_url($service_icon) . '" alt="' . esc_attr__('Service Icon', 'bullish-plus') . '" title="' . esc_attr__('Service Icon', 'bullish-plus') . '"/>';
                        }
                        echo '</div>';
                    }

                    if ($service_type === 'type3') {
                        echo '<div class="text-content">';
                    }

                    foreach ($structure['content_grp'] as $field) {
                        switch ($field) {
                            case 'title':
                                echo '<h2><a href="' . esc_url($post_link) . '">' . esc_html(get_the_title()) . '</a></h2>';
                                break;

                            case 'description':
                                echo '<p>' . esc_html(wp_trim_words(get_the_excerpt(), $excerpt_length, '...')) . '</p>';
                                break;

                            case 'button':
                                echo '<button><a href="' . esc_url($post_link) . '">' . esc_html__('Read More', 'bullish-plus') . '</a></button>';
                                break;
                        }
                    }

                    if ($service_type === 'type3') {
                        echo '</div>'; // Close text-content div
                    }

                    echo '</div>'; // Close content-grp div

                    echo '</div>'; // Close parent div
                }
            }
            echo '</div>';
            if ($settings['layout'] == 'carousel') {
                if ($carousel_arrowpagination == 'true') {
                    echo '<div class="services-pagination">';
                    echo '<div class="services-swiper-button-prev"></div>';
                    echo '<div class="services-swiper-button-next"></div>';
                    echo '</div>';
                } else if ($carousel_bulletpagination == 'true') {
                    echo '<div class="services-swiper-pagination"></div>';
                }
            }
            echo '</div>';
        } else {
            echo '<p>' . esc_html__('No services found.', 'bullish-plus') . '</p>';
        }

        wp_reset_postdata();
    }
}