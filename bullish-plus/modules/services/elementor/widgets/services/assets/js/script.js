(function ($) {

    var dtServicesListingWidgetHandler = function ($scope, $) {
        $scope.find('.wdt-services-listing').on('hover', function (e) {
            $scope.find('.wdt-services-listing').removeClass('active');
            $(this).addClass('active');
        });
        // Swiper Initialization
        if ($scope.find('.swiper-container').length) {
            var swiperElement = $scope.find('.wdt-services-listing');
            var swiperSettings = swiperElement.data('settings');
            var loop = swiperSettings.loop === "true";
            const spaceBetweenGaps = swiperSettings.space_between_gaps;
            var deviceMode = elementorFrontend.getCurrentDeviceMode();
            const spaceBetween = spaceBetweenGaps[deviceMode] ? parseInt(spaceBetweenGaps[deviceMode]) : 0;
            var swiperConfig = {
                slidesPerView: parseInt(swiperSettings.slides_to_show),
                slidesPerGroup: parseInt(swiperSettings.slides_to_scroll),
                spaceBetween: spaceBetween,
                loop: loop,
                navigation: swiperSettings.arrows === "true" ? {
                    nextEl: ".services-swiper-button-next",
                    prevEl: ".services-swiper-button-prev"
                } : false,
                pagination: swiperSettings.bulletpagination === "true" ? {
                    el: ".services-swiper-pagination",
                    clickable: true
                } : false,
                breakpoints: {}
            };
            
            if (swiperSettings.responsive) {
                swiperSettings.responsive.forEach(bp => {
                    swiperConfig.breakpoints[bp.breakpoint] = {
                        slidesPerView: parseInt(bp.toshow),
                        slidesPerGroup: parseInt(bp.toscroll),
                        spaceBetween: spaceBetweenGaps[bp.breakpoint] ? parseInt(spaceBetweenGaps[bp.breakpoint]) : spaceBetween
                    };
                });
            }

            var swiper = new Swiper($scope.find('.swiper-container')[0], swiperConfig);
        }
        var serviceType = $scope.find('.wdt-services-listing').attr('class');
        if (serviceType.includes('type3')) {
            $scope.find('.wdt-services-listing-column').each(function () {
                var titleHeight = $(this).find('h2 a').outerHeight();
                var contentHeight = $(this).find('.content-grp').outerHeight();
                $(this).find('.content-grp').css({
                    '--title-height': `${titleHeight}px`,
                    '--text-height': `${contentHeight}px`
                });
            });
        }
        

    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/wdt-services-listing.default', dtServicesListingWidgetHandler);
    });

})(jQuery);
