(function ($) {

    const wdtAdvancedTestimonialWidgetHandler = function($scope, $) {

        $('.wdt-advanced-testimonial-container.swiper').each(function () {
            const $thisSwiper     = $(this);
            const swiperSettings  = $thisSwiper.data('settings') || {};
            const swiperID        = $thisSwiper.attr('id');
            const $parentHolder   = $thisSwiper.closest('.wdt-advanced-testimonial-holder');
            const $slides         = $thisSwiper.find('.swiper-slide');

            if (!swiperSettings) return;

            var deviceMode = elementorFrontend.getCurrentDeviceMode();
            var spaceBetweenGaps = swiperSettings.space_between_gaps || {};
            var spaceBetween = spaceBetweenGaps[deviceMode] !== undefined ? parseInt(spaceBetweenGaps[deviceMode]) : 0;

            const slidesToShow     = swiperSettings.slides_to_show     ? parseInt(swiperSettings.slides_to_show) : 1;
            const loopEnabled      = swiperSettings.loop               === "yes";
            const freeModeEnabled  = swiperSettings.freemode           === "yes";
            const arrowsEnabled    = swiperSettings.arrows             === "yes";
            const paginationType   = swiperSettings.pagination         || "none";
            const speed            = swiperSettings.speed              ? parseInt(swiperSettings.speed) : 300;
            const centeredSlides   = swiperSettings.centered_slides    === "yes";

            // Default active class on second slide
            $slides.removeClass('active');
            $slides.eq(1).addClass('active');

            // Add hover behavior
            $slides.on('mouseenter', function () {
                $slides.removeClass('active');
                $(this).addClass('active');
            });

            // Init Swiper
            new Swiper('#' + swiperID, {
                slidesPerView: slidesToShow,
                spaceBetween: spaceBetween,
                loop: loopEnabled,
                freeMode: freeModeEnabled,
                speed: speed,
                centeredSlides: centeredSlides,

                pagination: paginationType === "bullets" ? {
                    el: $parentHolder.find('.wdt-swiper-pagination')[0],
                    clickable: true
                } : false,

                navigation: arrowsEnabled ? {
                    nextEl: $parentHolder.find('.wdt-arrow-pagination-next')[0],
                    prevEl: $parentHolder.find('.wdt-arrow-pagination-prev')[0]
                } : false
            });
        });

    }


    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/wdt-advanced-testimonial.default', wdtAdvancedTestimonialWidgetHandler);
    });

} )( jQuery );