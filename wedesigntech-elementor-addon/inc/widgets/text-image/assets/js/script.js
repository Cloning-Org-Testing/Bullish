(function ($) {

	const wdtFeatureTileHandler = function($scope, $) {
	};

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/wdt-text-image.default', wdtFeatureTileHandler);
	});

})(jQuery);