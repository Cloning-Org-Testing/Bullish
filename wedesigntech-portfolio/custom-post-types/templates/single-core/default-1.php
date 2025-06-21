<?php
$listing_id = get_the_ID();
$listing_taxonomies = wp_get_post_terms($listing_id, 'wdt_listings_category', array ('orderby' => 'parent'));
$term_ids = array_column($listing_taxonomies, 'term_id');
$term_ids_str =  implode(',', $term_ids);
?>

<div class="wdt-portfolio-single-default ">
    <div class="wdt-portfolio-single-image-area">
            <?php echo do_shortcode('[wdt_sp_media_images_list columns="3" include_featured_image="true" with_space="true"  listing_id="'.$listing_id.'"]'); ?>
    </div>

    <div class="wdt-portfolio-single-content">
        <div class="wdt-portfolio-single-wrapper">       
            <!-- <div class="wdt-portfolio-content-group">
                <div class="wdt-sticky-wrapper">
                    <?php //echo do_shortcode('[wdt_sp_post_date with_label="true" listing_id="'.$listing_id.'"]'); ?>
                    <?php //echo do_shortcode('[wdt_sp_utils show_title="true" listing_id="'.$listing_id.'"]'); ?>
                    <?php //if (has_excerpt()) { ?>
                        <div class="wdt-portfolio-excerpt">
                            <?php //the_excerpt(); ?>
                        </div>
                    <?php //} ?>
                </div>
            </div> -->
            <div class="wdt-portfolio-taxonomy-group">
                <?php echo do_shortcode('[wdt_sp_taxonomy taxonomy="wdt_listings_category" show_categories="true" show_label="true" listing_id="'.$listing_id.'"]'); ?>
                <?php echo do_shortcode('[wdt_sp_taxonomy taxonomy="wdt_listings_amenity" show_categories="true" show_label="true" listing_id="'.$listing_id.'"]'); ?>
                <?php echo do_shortcode('[wdt_sp_social_links type="default" listing_id="'.$listing_id.'"]'); ?>
            </div>
        </div>
        <?php the_content(); ?>
    </div> 
</div>