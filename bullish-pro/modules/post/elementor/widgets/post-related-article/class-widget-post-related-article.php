<?php
use BullishElementor\Widgets\BullishElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Post_Related_Article extends BullishElementorWidgetBase {

    public function get_name() {
        return 'wdt-post-related-article';
    }

    public function get_title() {
        return esc_html__('Post - Related Article', 'bullish-pro');
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

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

		$out = '';

        global $post;
        $post_id =  $post->ID;

        $template_args['post_ID'] = $post_id;

        $out .= bullish_get_template_part( 'post', 'templates/post-extra/related_article', '', $template_args );

		echo $out;
	}

}