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

                        echo '<div class="wdt-service-meta-wrap">';

                            $service_price         = !empty($service_settings['service_price']) ? $service_settings['service_price'] : '';
                            $service_offer_price   = !empty($service_settings['service_offer_price']) ? $service_settings['service_offer_price'] : '';
                            $service_price_duration = !empty($service_settings['service_price_duration']) ? $service_settings['service_price_duration'] : '';

                            $duration_label = '';
                            if ($service_price_duration === 'day') {
                                $duration_label = esc_html__(' / day', 'bullish-pro');
                            } elseif ($service_price_duration === 'month') {
                                $duration_label = esc_html__(' / month', 'bullish-pro');
                            } elseif ($service_price_duration === 'year') {
                                $duration_label = esc_html__(' / year', 'bullish-pro');
                            }

                            if (!empty($service_price)) {
                                echo '<div class="wdt-service-price">';
                                echo esc_html__('Price', 'bullish-pro') . ': ';

                                if (!empty($service_offer_price)) {
                                    echo '<del>' . esc_html($service_price) . '</del> ';
                                    echo '<span>' . esc_html($service_offer_price . $duration_label) . '</span>';
                                } else {
                                    echo '<span>' . esc_html($service_price . $duration_label) . '</span>';
                                }

                                echo '</div>';
                            }


                        echo '</div>';


                    echo '</div>';

                    the_content();


                echo '</div>';

                // @SideBar Content

                echo '<div class="secondary-wrap">';
                    echo '<div class="sidebar-inner-wrap ">';

                        $services = get_posts([
                            'post_type'      => 'wdt_services',
                            'posts_per_page' => -1,
                            'post_status'    => 'publish',
                            'orderby'        => 'title',
                            'order'          => 'ASC',
                        ]);

                        if ($services) {
                            echo '<nav class="service-list-navigation">';
                            echo '<h3>' . esc_html__('All Services', 'bullish-pro') . '</h3>';
                            echo '<ul class="service-list">';
                            foreach ($services as $service) {
                                $active = (get_the_ID() === $service->ID) ? ' class="active"' : '';
                                echo '<li' . $active . '>';
                                echo '<a href="' . esc_url(get_permalink($service->ID)) . '">' . esc_html(get_the_title($service->ID)) . '</a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                            echo '</nav>';
                        }


                        echo '<div class="wdt-service-meta-wrap">';

                            // Single Feature Display
                            $service_features = $service_settings['service_features'] ?? [];

                            if (!empty($service_features)) {
                                echo '<div class="service-feature">';
                                    echo '<h3>' . esc_html__('Features', 'bullish-pro') . '</h3>';
                                    echo '<ul class="feature-list">';

                                    foreach ($service_features as $feature) {
                                        $icon        = $feature['feature_icon'] ?? '';
                                        $image       = $feature['feature_image'] ?? '';
                                        $description = $feature['feature_description'] ?? '';

                                        echo '<li class="single-feature">';

                                        if ($icon) {
                                            echo '<div class="feature-icon"><img src="' . esc_url($icon) . '" alt=""></div>';
                                        }

                                        if ($image) {
                                            echo '<div class="feature-image"><img src="' . esc_url($image) . '" alt=""></div>';
                                        }

                                        if ($description) {
                                            echo '<div class="feature-description">' . wp_kses_post($description) . '</div>';
                                        }

                                        echo '</li>';
                                    }

                                    echo '</ul>';
                                echo '</div>';
                            }
                            // Contact Info Display
                            $contact_email   = $service_settings['contact_email'] ?? '';
                            $contact_phone   = $service_settings['contact_phone'] ?? '';
                            $contact_address = $service_settings['contact_address'] ?? '';
                            $contact_socials = $service_settings['contact_socials'] ?? [];

                            if ($contact_email || $contact_phone || $contact_address || !empty($contact_socials)) {
                                echo '<div class="service-contact">';
                                    echo '<h3>' . esc_html__('Contact Info', 'bullish-pro') . '</h3>';

                                    if ($contact_email) {
                                        echo '<p><strong>' . esc_html__('Email:', 'bullish-pro') . '</strong> <a href="mailto:' . esc_attr($contact_email) . '">' . esc_html($contact_email) . '</a></p>';
                                    }

                                    if ($contact_phone) {
                                        echo '<p><strong>' . esc_html__('Phone:', 'bullish-pro') . '</strong> <a href="tel:' . esc_attr($contact_phone) . '">' . esc_html($contact_phone) . '</a></p>';
                                    }

                                    if ($contact_address) {
                                        echo '<p><strong>' . esc_html__('Address:', 'bullish-pro') . '</strong> ' . esc_html($contact_address) . '</p>';
                                    }

                                    if (!empty($contact_socials)) {
                                        echo '<h3>' . esc_html__('Social Info', 'bullish-pro') . '</h3>';
                                        echo '<div class="social-icons">';
                                            foreach ($contact_socials as $social) {
                                                $icon = $social['social_icon'] ?? '';
                                                $url  = $social['social_url'] ?? '';

                                                if (!empty($icon) && !empty($url)) {
                                                    echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer">';
                                                        if (strpos($icon, '.svg') !== false) {
                                                            $svg_path = ABSPATH . str_replace(site_url('/'), '', $icon);
                                                            if (file_exists($svg_path)) {
                                                                $svg_content = file_get_contents($svg_path);
                                                                if ($svg_content !== false) {
                                                                    echo '<div class="wdt-social-type-icon svg-icon">' . $svg_content . '</div>';
                                                                }
                                                            }
                                                        } else {
                                                            echo '<div class="wdt-social-type-icon"><img src="' . esc_url($icon) . '" alt="social Icon" title="Service Icon"/></div>';
                                                        }
                                                    echo '</a>';
                                                }
                                            }
                                        echo '</div>';
                                    }


                                echo '</div>';
                            }

                        echo '</div>';

                    echo '</div>';
                echo '</div>';
                
            echo '</div>';

            do_action('bullish_after_single_page_content');

            echo '</div><!-- #post-' . get_the_ID() . ' -->';

        endwhile;
    endif;

    do_action('bullish_after_single_page_content_wrap');

    echo '</section><!-- Primary End -->';


    get_footer();

?>