<?php
get_header();

echo '<section id="primary" class="' . esc_attr(bullish_get_primary_classes()) . '">';

do_action('bullish_before_single_page_content_wrap');

$args = array(
    'post_type' => 'wdt_services',
    'p' => get_the_ID()
);
$query = new WP_Query($args);

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();

        echo '<div id="post-' . get_the_ID() . '" class="' . esc_attr(implode(' ', get_post_class())) . '">';

            do_action('bullish_before_single_page_content');

            // Title
            echo '<h1 class="entry-title">' . get_the_title() . '</h1>';

            // Featured image (if exists)
            if (has_post_thumbnail()) {
                echo '<div class="services-featured-image">';
                the_post_thumbnail('large');
                echo '</div>';
            }

            // Content
            echo '<div class="service-content">';
            the_content();
            echo '</div>';

            // Meta fields
            $service_icon       = get_post_meta(get_the_ID(), 'service_icon', true);
            $service_price      = get_post_meta(get_the_ID(), 'service_price', true);
            $service_desc       = get_post_meta(get_the_ID(), 'service_description', true);
            $service_button_txt = get_post_meta(get_the_ID(), 'service_button_text', true);

            do_action('bullish_after_single_page_content');

            echo '<div class="wdt-service-meta" style="margin-top: 30px;">';

                // Service icon
                if ($service_icon) {
                    $file_extension = pathinfo($service_icon, PATHINFO_EXTENSION);
                    echo '<div class="wdt-service-icon" style="margin-bottom: 20px;">';
                    if (strtolower($file_extension) === 'svg') {
                        echo '<div id="service_icon">' . file_get_contents($service_icon) . '</div>';
                    } else {
                        echo '<img id="service_icon" src="' . esc_url($service_icon) . '" alt="' . esc_attr__('Service Icon', 'bullish-plus') . '" style="max-width:100px;" />';
                    }
                    echo '</div>';
                }

                // Service details
                echo '<div class="wdt-service-details">';
                    if (!empty($service_price)) {
                        echo '<div><strong>Price</strong>: ' . esc_html($service_price) . '</div>';
                    }
                    if (!empty($service_desc)) {
                        echo '<div><strong>Description</strong>: ' . esc_html($service_desc) . '</div>';
                    }
                    if (!empty($service_button_txt)) {
                        echo '<div><a class="button" href="#">' . esc_html($service_button_txt) . '</a></div>';
                    }
                echo '</div>';

            echo '</div>'; // .wdt-service-meta
        echo '</div><!-- #post-' . get_the_ID() . ' -->';
    }
}


wp_reset_postdata();

do_action('bullish_after_single_page_content_wrap');

echo '</section><!-- Primary End -->';

get_footer();
?>