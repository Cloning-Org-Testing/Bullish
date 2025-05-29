<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */

defined( 'ABSPATH' ) || exit;

global $product; 

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
	<?php else : ?>
		<!-- <table class="variations" cellspacing="0" role="presentation">
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr>
						<th class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label></th>
						<td class="value">
							<?php
								wc_dropdown_variation_attribute_options(
									array(
										'options'   => $options,
										'attribute' => $attribute_name,
										'product'   => $product,
									)
								);
								echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
							?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table> -->
		<!-- swatches code start --> 
 
		 <?php
		 wp_enqueue_style( 'variation-swatches-css', get_theme_file_uri('/assets/css/variation-swatches.css'), false, BULLISH_THEME_VERSION, 'all');  
		 wp_enqueue_script('variation-swatches-js', get_theme_file_uri('/assets/js/variation-swatches.js'), array('jquery'), false, true); 
	 //}
	 wp_localize_script('variation-swatches-js', 'ajax_object', array(
		 'ajaxurl' => admin_url('admin-ajax.php')
	 )); 
		 global $product;

		 $product_id = get_the_ID();
 
 
		 if ($product->is_type('variable')) {
			 $attributes = $product->get_variation_attributes();
			 $available_variations = $product->get_available_variations();
			 
		  
			  
	 
	 
	 echo '<div class="attribute-swatchesselect" data-product-id="'.$product_id.'" hidden >';
	 echo '<label for="all-attributes">' . __('Choose a Variant', 'woocommerce') . '</label>';
	//  echo '<select id="all-attributes-'.$product_id.'" name="all_attributes" >';
	//  echo '<option value="">' . __('Choose an option', 'woocommerce') . '</option>'; 
	//  $options_combined = []; 
	//  $available_variations = $product->get_available_variations();
 
	//  foreach ($available_variations as $variation) {
	// 	 $formatted_attributes = [];
 
	// 	 foreach ($variation['attributes'] as $key => $value) {
	// 		 $formatted_attributes[] = ucfirst($value);
	// 	 }
 
	// 	 $option_label = implode(', ', $formatted_attributes);
	// 	 $variation_id = $variation['variation_id']; 
	// 	 if (!in_array($option_label, $options_combined)) {
	// 		 $options_combined[] = $option_label;
	// 		 echo '<option value="' . esc_attr($variation_id) . '">' .esc_html($option_label). '</option>';
	// 	 }
	//  }
 
	//  echo '</select>';
	//  echo '</div>'; 
	

echo '<select id="all-attributes-' . $product_id . '" name="all_attributes">';  
$default_price = $product->get_price();
$default_regular_price = $product->get_regular_price();
$symbol = html_entity_decode(get_woocommerce_currency_symbol());

$formatted_default = number_format((float)$default_price, 2, '.', '');
$formatted_default_regular = number_format((float)$default_regular_price, 2, '.', '');

if ($default_price == $default_regular_price || empty($default_regular_price)) {
    $default_dis_price = $symbol . $formatted_default;
} else {
    $default_dis_price = $symbol . $formatted_default . ' - ' . $symbol . $formatted_default_regular;
} 
echo '<option value="" data-price="' . esc_attr($default_dis_price) . '">' . __('Choose an option', 'woocommerce') . '</option>';


$options_combined = []; 
$available_variations = $product->get_available_variations();

foreach ($available_variations as $variation) {
    $formatted_attributes = [];

    foreach ($variation['attributes'] as $key => $value) {
        if (!empty($value)) {
            $formatted_attributes[] = ucfirst($value);
        }
    }

    if (!empty($formatted_attributes)) {
        $option_label = implode(', ', $formatted_attributes);
        $variation_id = $variation['variation_id'];

        // Use the variation ID to load the variation object
        $variation_obj = new WC_Product_Variation($variation_id);

        // Get prices
        $display_price = $variation_obj->get_price();
        $display_regular_price = $variation_obj->get_regular_price();

        // Format
        $symbol = html_entity_decode(get_woocommerce_currency_symbol());

        $formatted_regular = number_format((float)$display_regular_price, 2, '.', '');
        $formatted_price = number_format((float)$display_price, 2, '.', '');

        if ($display_price == $display_regular_price || empty($display_regular_price)) {
            $dis_price = $symbol . $formatted_price;
        } else {
            $dis_price = $symbol . $formatted_price . ' - ' . $symbol . $formatted_regular;
        }

        if (!in_array($option_label, $options_combined)) {
            $options_combined[] = $option_label;
            echo '<option data-price="' . esc_attr($dis_price) . '" value="' . esc_attr($variation_id) . '">' . esc_html($option_label) . '</option>';
        }
    }
}

echo '</select>';

echo '</div>';
 
			 echo '<div class="wdt-swatch-product-price"> </div>'; 
			 echo '<div class="variation-swatches">';  
	 
			 foreach ($attributes as $attribute_name => $options) {
				 echo '<div class="attribute-swatches attribute-swatches-'.$product_id.'">';
				 
				 
					 foreach ($options as $option) {
						 $variation_found = false;
						 foreach ($available_variations as $variation) { 
							 $variation_id = $variation['variation_id']; 
							 if (isset($variation['attributes']['attribute_' . $attribute_name]) && 
								 $variation['attributes']['attribute_' . $attribute_name] === $option) {
								 $variation_found = true;
								 break;  
							 }
						 }
			  
						 if ($variation_found) {
							 $term = get_term_by('name', $option, $attribute_name);
							 $term_id = ($term) ? $term->term_id : '';
 
				  $material_imageid = get_term_meta($term_id, 'custom_field_image', true);
 
					 if (!empty($material_imageid)) {
						 $material_image = wp_get_attachment_url($material_imageid);
						 //echo '<img src="' . esc_url($material_image) . '" alt="Material Image">';
					 }  else{ $material_image = ''; }
 
			
					 $variation_obj = new WC_Product_Variation( $variation_id );
					 $attachment_id = $variation_obj->get_image_id(); 
 
							 //echo $option;
 
							 if ($attribute_name === 'pa_color') {
								 $saved_color = get_post_meta($variation_id, 'variation_color', true);
								 
							 echo '<div style="background:'.esc_attr($option).'" class="available product_swatch proswatch-'.$product_id.' proswatch-color" data-attach-id="' .$attachment_id .'" data-attribute-id="' . esc_attr($variation_id) . '" data-product="'.esc_attr($product_id).'" data-attribute-name="' . esc_attr($attribute_name) . '" data-attribute-value="' . esc_attr($option) . '">
								 <div class="" style="background:'.esc_attr($option).'"></div></div>';
								 
								  
							 } 
							 else if ($attribute_name === 'pa_material') { 
								 $variation_material_image = get_post_meta($variation_id, 'variation_material_image', true);
 
							 echo '<div style=" background-image:url('."'".esc_attr($material_image)."'".')" class="available product_swatch proswatch-'.$product_id.' proswatch-material" data-attach-id="' .$attachment_id .'"  data-attribute-id="' . esc_attr($variation_id) . '" data-product="'.esc_attr($product_id).'" data-attribute-name="' . esc_attr($attribute_name) . '" data-attribute-value="' . esc_attr($option) . '">
								 <div class="" style=" background:url('."'".esc_attr($material_image)."'".')"></div></div>';
								 
								  
							 } 
							 else { 
								  
							 echo '<div class="available product_swatch proswatch-'.$product_id.'" data-attach-id="' .$attachment_id .'" data-attribute-id="' . esc_attr($variation_id) . '" data-product="'.esc_attr($product_id).'" data-attribute-name="' . esc_attr($attribute_name) . '" data-attribute-value="' . esc_attr($option) . '">';
							 echo esc_html($option);  
							 echo '</div>'; }
						 }
					 }
				  
			 echo '</div>';
				  
			 }  
			echo '<div class="clear_swatchespro" data-product-id ="'.$product_id.'" >clear</div>';
					echo '</div>';  
	} ?>

		<?php do_action( 'woocommerce_after_variations_table' ); ?>

		<div class="single_variation_wrap">
			<?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
	<?php endif; ?>
	
	<input type="hidden" name="variation_id" class="variation-id-field" />
	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product_id); ?>" />
	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
