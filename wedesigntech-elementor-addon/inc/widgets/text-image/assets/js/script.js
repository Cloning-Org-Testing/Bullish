(function ($) {

	const wdtFeatureTileHandler = function($scope, $) {

		const $widgetId = $scope.data('id');
		const $gsapHolder = $scope.find('.wdt-track-' + $widgetId);
		const $tiles = $gsapHolder.find('.wdt-text-tile .wdt-gradient-text');

		console.log($gsapHolder + '<---Holder' + $tiles + '<-----Tilesz');

		if (typeof gsap !== "undefined" && typeof SplitText !== "undefined" && typeof ScrollTrigger !== "undefined") {
			gsap.registerPlugin(SplitText, ScrollTrigger);
			gsap.set($gsapHolder, { perspective: 400 });

			console.log('Gsap Works!');
			
			$tiles.each(function () {
				const split = new SplitText(this, { type: "chars,words" });

				// animate characters
				gsap.from(split.chars, {
					opacity: 0,
					y: 20,
					duration: 0.6,
					stagger: 0.05,
					ease: "power2.out",
					scrollTrigger: {
						trigger: this,
						start: "top 80%",
						end: "bottom 20%",
						toggleActions: "play none none reset"
					}
				});

				// animate background gradient
				gsap.fromTo(this,
					{ backgroundSize: "0% 100%" },
					{
						backgroundSize: "100% 100%",
						scrollTrigger: {
							trigger: this,
							start: "top 80%",
							end: "bottom 20%",
							scrub: true
						}
					}
				);
			});
		} else {
			console.warn("GSAP, SplitText, or ScrollTrigger not loaded.");
		}
	};

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/wdt-text-image.default', wdtFeatureTileHandler);
	});

})(jQuery);