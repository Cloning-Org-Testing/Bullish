<?php
/**
 * Archive template for wdt_services post type
 */

get_header();

echo '<section id="primary" class="' . esc_attr(bullish_get_primary_classes()) . '">';
// Get global settings
$global_settings = get_option('_bullish_service_settings', []);
$currency_symbol = esc_html($global_settings['currency_symbol'] ?? '');
$column_count = isset($global_settings['layout']) ? absint($global_settings['layout']) : 3;
$column_class = 'wdt-columns-' . max(1, min(5, $column_count));

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

?>

<div class="wdt-service-archive-wrapper <?php echo esc_attr($column_class); ?>">
    
    <?php if (have_posts()) : ?>
        
        <?php while (have_posts()) : the_post(); ?>
            <?php
            $service_id = get_the_ID();
            $meta = get_post_meta($service_id, '_bullish_service_settings', true);
            $meta = is_array($meta) ? $meta : [];

            $price = $meta['service_price'] ?? '';
            $offerprice = $meta['service_offer_price'] ?? '';
            $duration = $meta['service_price_duration'] ?? '';
            ?>
            
            <div class="wdt-service-item">

                <div class="wdt-service-media-group">
                    <div class="wdt-service-image">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('medium_large');
                        } else {
                            $title = get_the_title();
                            $placeholder_url = 'https://dummyimage.com/1200x800/cccccc/999999.jpg?text=' . esc_attr($title);
                            echo '<img src="' . esc_url($placeholder_url) . '" alt="' . esc_attr($title) . '" />';
                        }
                        ?>
                    </div>
                </div>

                <div class="wdt-service-detail-group">

                    <div class="wdt-service-content-group">
                        <div class="wdt-service-title">
                            <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                        </div>

                        <?php
                            $service_settings = get_post_meta($service_id, '_bullish_service_settings', true);
                            $icon  = !empty($service_settings['service_icon']) ? $service_settings['service_icon'] : '';
                            if (!empty($icon)) {
                                echo render_service_icon($icon);
                            }
                        ?>
                    </div>

                    <?php if (!empty($price) || !empty($offerprice)) : ?>
                        <div class="wdt-service-type-price-group">
                            <div class="wdt-service-type-price">
                                <?php
                                if (!empty($offerprice)) {
                                    echo '<del>' . esc_html($currency_symbol . $price) . '</del>';
                                } else {
                                    echo esc_html($currency_symbol . $price . ' / ' . $duration);
                                }
                                ?>
                            </div>

                            <?php if (!empty($offerprice)) : ?>
                                <div class="wdt-service-type-offerprice">
                                    <?php echo esc_html($currency_symbol . $offerprice . ' / ' . $duration); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (has_excerpt()) : ?>
                        <div class="wdt-service-description">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>

                </div>

            </div>


        <?php endwhile; ?>

        <!-- Pagination -->
        <div class="pagination booking-pagination">
            <?php
            $pagination_args = array(
                'prev_text' => '<i class="fa fa-angle-left"></i>',
                'next_text' => '<i class="fa fa-angle-right"></i>',
                'mid_size' => 2,
                'type' => 'list',
                'current' => max(1, get_query_var('paged')),
            );
            
            echo paginate_links($pagination_args);
            ?>
        </div>

    <?php else : ?>

        <p><?php esc_html_e('No services found.', 'bullish-pro'); ?></p>

    <?php endif; ?>

</div>

<?php
echo '</section><!-- Primary End -->';

    echo '<section id="secondary" class="' . esc_attr(bullish_get_secondary_classes()) . '"><div class="wdt-sidebar-wrapper">';
        do_action( 'bullish_before_single_sidebar_wrap' );

        get_sidebar();

        do_action( 'bullish_after_single_sidebar_wrap' );
    echo '</div></section><!-- Secondary End -->';

    get_footer();
?>