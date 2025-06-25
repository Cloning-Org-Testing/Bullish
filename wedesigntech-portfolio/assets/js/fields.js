
var wdtPortfolioFields = {

	dtInit : function() {

		// Chosen JS - Social Links

			wdtPortfolioCommonUtils.wdtPortfolioChosenSelect('.wdt-social-chosen-select');


		// Features

			jQuery('body').delegate('.wdt-add-features-box', 'click', function(e) {
				e.preventDefault();

				var clone = jQuery('.wdt-features-box-item-toclone').clone();
				clone.attr('class', 'wdt-features-box-item').removeClass('hidden');

				// Fix title and image field names
				clone.find('#wdt_tab_id').attr('class', 'wdt_tab_id').removeAttr('id');
				clone.find('#wdt_features_title').attr('name', 'wdt_features_title[]').removeAttr('id');
				clone.find('#wdt_features_image').attr('name', 'wdt_features_image[]').removeAttr('id');

				// Fix counter field names
				clone.find('input[name="wdt_start_digit[]"]').attr('name', 'wdt_start_digit[]');
				clone.find('input[name="wdt_end_digit[]"]').attr('name', 'wdt_end_digit[]');
				clone.find('input[name="wdt_speed[]"]').attr('name', 'wdt_speed[]');
				clone.find('input[name="wdt_refresh_interval[]"]').attr('name', 'wdt_refresh_interval[]');
				clone.find('input[name="wdt_prefix[]"]').attr('name', 'wdt_prefix[]');
				clone.find('input[name="wdt_suffix[]"]').attr('name', 'wdt_suffix[]');

				// Clear values just to be safe
				clone.find('input[type="text"], input[type="number"], input[type="hidden"]').val('');

				clone.appendTo('.wdt-features-box-item-holder');

				// Re-index tab_id
				var $i = 0;
				jQuery('.wdt_tab_id').each(function() {
					jQuery(this).val($i);
					$i++;
				});
			});


			jQuery('body').delegate('.wdt-remove-features','click', function(e){

				jQuery(this).parents('.wdt-features-box-item').remove();
				$i = 0;
				jQuery('.wdt_tab_id').each(function() {
					jQuery(this).val($i);
					$i++;
				})
				e.preventDefault();

			});

			if (jQuery().sortable) {
				jQuery('.wdt-features-box-item-holder').sortable({
					placeholder: 'sortable-placeholder',
					update: function( event, ui ) {
						$i = 0;
						jQuery('.wdt_tab_id').each(function() {
							jQuery(this).val($i);
							$i++;
						})
					}
				});
			}


		// Social Details

			jQuery('a.wdt-add-social-details').on('click', function(e){

				var clone = jQuery('#wdt-social-details-section-to-clone').clone();

				clone.attr('class', 'wdt-social-item-section').removeClass('hidden').removeAttr('id');
				clone.find('select').attr('name', 'wdt_social_items[]').addClass('wdt-social-chosen-select');
				clone.find('input').attr('name', 'wdt_social_items_value[]');
				clone.appendTo('.wdt-social-item-details-container');

				wdtPortfolioCommonUtils.wdtPortfolioChosenSelect('.wdt-social-chosen-select');

				e.preventDefault();

			});

			jQuery('body').delegate('span.wdt-remove-social-item','click', function(e){

				jQuery(this).parents('.wdt-social-item-section').remove();
				e.preventDefault();

			});

			if (jQuery().sortable) {
				jQuery('.wdt-social-item-details-container').sortable({ placeholder: 'sortable-placeholder' });
			}

	}

};

jQuery(document).ready(function() {

	wdtPortfolioFields.dtInit();

});