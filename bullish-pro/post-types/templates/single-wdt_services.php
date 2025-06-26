<?php
    get_header();

    echo '<section id="primary" class="' . esc_attr(bullish_get_primary_classes()) . '">';

    do_action('bullish_before_single_page_content_wrap');

    if (have_posts()) :
        while (have_posts()) : the_post();

            echo '<div id="post-' . get_the_ID() . '" class="' . esc_attr(implode(' ', get_post_class())) . '">';

            do_action('bullish_before_single_page_content');

            echo '<div class="wdt_services_single-wrapper">';

                $service_settings = get_post_meta(get_the_ID(), '_bullish_service_settings', true);
                // @Main Content

                echo '<div class="primary-wrap">';
                    
                    echo '<div class="featured_image_wrap">';

                        if (has_post_thumbnail()) {
                            echo '<div class="services-featured-image">';
                            the_post_thumbnail('large');
                            echo '</div>';
                        }
                    echo '</div>';

                    echo '<div class="wdt-service-meta-wrap">';
                    
                            if ( ! empty( $service_settings['service_icon'] ) ) {
                                echo '<div class="service-icon-wrap">';
                                    echo '<img src="' . esc_url( $service_settings['service_icon'] ) . '" alt="' . esc_attr( get_the_title() ) . '" class="service-icon" />';
                                echo '</div>';
                            }

                            $service_price         = !empty($service_settings['service_price']) ? $service_settings['service_price'] : '';
                            $service_offer_price   = !empty($service_settings['service_offer_price']) ? $service_settings['service_offer_price'] : '';
                            $service_price_duration = !empty($service_settings['service_price_duration']) ? $service_settings['service_price_duration'] : '';
                            $global_settings = get_option('_bullish_service_settings', []);
                            $currency_symbol = esc_html($global_settings['currency_symbol'] ?? '');

                            $duration_label = '';
                            if ($service_price_duration === 'day') {
                                $duration_label = esc_html__(' / day', 'bullish-pro');
                            } elseif ($service_price_duration === 'month') {
                                $duration_label = esc_html__(' / month', 'bullish-pro');
                            } elseif ($service_price_duration === 'year') {
                                $duration_label = esc_html__(' / year', 'bullish-pro');
                            }

                            if (!empty($service_price)) {
                                echo '<div class="wdt-service-type-price-group">';

                                    echo '<div class="wdt-service-type-price">';
                                        if (!empty($service_offer_price)) {
                                            echo '<del>' . $currency_symbol . esc_html($service_price) . '</del>';
                                        } else {
                                            echo esc_html($currency_symbol . $service_price . $duration_label);
                                        }
                                    echo '</div>';

                                    if (!empty($service_offer_price)) {
                                        echo '<div class="wdt-service-type-offerprice">' . esc_html($currency_symbol . $service_offer_price . $duration_label) . '</div>';
                                    }

                                echo '</div>';
                            }

                            if ( ! empty( $service_settings['service_features'] ) && is_array( $service_settings['service_features'] ) ) {
                                echo '<div class="service-features-wrap">';
                                    echo '<h3>' . esc_html__('Service Features', 'bullish-pro') . '</h3>';
                                    echo '<div class="service-features-list">';

                                    foreach ( $service_settings['service_features'] as $feature ) {
                                        $icon        = ! empty( $feature['feature_icon'] ) ? esc_url( $feature['feature_icon'] ) : '';
                                        $image       = ! empty( $feature['feature_image'] ) ? esc_url( $feature['feature_image'] ) : '';
                                        $description = ! empty( $feature['feature_description'] ) ? esc_html( $feature['feature_description'] ) : '';

                                        echo '<div class="service-feature-item">';
                                            if ( $icon ) {
                                                echo '<img src="' . $icon . '" alt="Feature Icon" class="feature-icon" />';
                                            } elseif ( $image ) {
                                                echo '<img src="' . $image . '" alt="Feature Image" class="feature-image" />';
                                            }
                                            if ( $description ) {
                                                echo '<p class="feature-description">' . $description . '</p>';
                                            }
                                        echo '</div>';
                                    }

                                    echo '</div>';
                                echo '</div>';
                            }

                            if ( ! empty( $service_settings['contact_socials'] ) && is_array( $service_settings['contact_socials'] ) ) {
                                echo '<div class="wdt-service-social-icons">';
                                    echo '<h4>' . esc_html__('Follow Us', 'bullish-pro') . '</h4>';
                                    echo '<ul class="wdt-social-list">';

                                    foreach ( $service_settings['contact_socials'] as $social ) {
                                        $icon_class = isset( $social['social_icon'] ) ? esc_attr( $social['social_icon'] ) : '';
                                        $url        = isset( $social['social_url'] ) ? esc_url( $social['social_url'] ) : '';

                                        if ( $icon_class && $url ) {
                                            echo '<li><a href="' . $url . '" target="_blank" rel="noopener noreferrer">';
                                                echo '<i class="' . $icon_class . '"></i>';
                                            echo '</a></li>';
                                        }
                                    }

                                    echo '</ul>';
                                echo '</div>';
                            }

                        echo '</div>';

                    the_content();


                echo '</div>';

            echo '</div>';

            do_action('bullish_after_single_page_content');

            echo '</div><!-- #post-' . get_the_ID() . ' -->';

        endwhile;
    endif;

    do_action('bullish_after_single_page_content_wrap');

    echo '</section><!-- Primary End -->';

    echo '<section id="secondary" class="' . esc_attr(bullish_get_secondary_classes()) . '"><div class="wdt-sidebar-wrapper">';
        do_action( 'bullish_before_single_sidebar_wrap' );

        get_sidebar();

        do_action( 'bullish_after_single_sidebar_wrap' );
    echo '</div></section><!-- Secondary End -->';

    get_footer();

?>
