<?php
use BullishElementor\Widgets\BullishElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Post_Navigation extends BullishElementorWidgetBase {

    public function get_name() {
        return 'wdt-post-navigation';
    }

    public function get_title() {
        return esc_html__('Post - Navigation', 'bullish-pro');
    }

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'bullish-pro'),
        ) );

            $this->add_control( 'el_class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Extra class name', 'bullish-pro'),
                'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'bullish-pro')
            ) );
            $this->add_control( 'navi_class', array(
                'type'        => Controls_Manager::SELECT,
                'label'       => esc_html__('Select Navigation type', 'bullish-pro'),
                'default' => 'type1',
                'options' => array(
                    'type1'  => esc_html__('Type 1', 'bullish-pro'),
                    'type2'  => esc_html__('Type 2', 'bullish-pro'),
                    'type3'  => esc_html__('Type 3', 'bullish-pro'),
                )
            ) );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

		$out = '';

        global $post;
        $post_id =  $post->ID;

        $template_args['post_ID'] = $post_id;
        $template_args['select_post_navigation'] =$navi_class;

		$out .= '<div class="entry-post-navigation-wrapper '.$el_class.'">';
            $out .= bullish_get_template_part( 'post', 'templates/post-extra/navigation', '', $template_args );
		$out .= '</div>';
		echo $out;
	}

}