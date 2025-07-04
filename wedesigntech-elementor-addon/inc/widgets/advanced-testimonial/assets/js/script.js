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

            const swiperInstance = new Swiper('#' + swiperID, {
                slidesPerView: 'auto',
                spaceBetween: spaceBetween,
                loop: loopEnabled,
                freeMode: false,
                speed: speed,
                centeredSlides: true, 
                grabCursor: true,

                pagination: paginationType === "bullets" ? {
                    el: $parentHolder.find('.wdt-swiper-pagination')[0],
                    clickable: true
                } : false,

                navigation: arrowsEnabled ? {
                    nextEl: $parentHolder.find('.wdt-arrow-pagination-next')[0],
                    prevEl: $parentHolder.find('.wdt-arrow-pagination-prev')[0]
                } : false,

                on: {
                    init: function () {
                        updateActiveCenterClass(this);
                    },
                    slideChangeTransitionEnd: function () {
                        updateActiveCenterClass(this);
                    }
                }
            });


            function updateActiveCenterClass(swiper) {

                const $allSlides = $thisSwiper.find('.swiper-slide');
                $allSlides.removeClass('active');

                const activeIndex = swiper.activeIndex;
                const $centerSlide = $(swiper.slides[activeIndex]);
                $centerSlide.addClass('active');

            }

        });

        // $('.wdt-advanced-testimonial-container.swiper').each(function () {
        //     const $thisSwiper = $(this);
        //     const swiperSettings = $thisSwiper.data('settings') || {};
        //     const swiperID = $thisSwiper.attr('id');
        //     const $parentHolder = $thisSwiper.closest('.wdt-advanced-testimonial-holder');

        //     if (!swiperSettings) return;

        //     var deviceMode = elementorFrontend.getCurrentDeviceMode();
        //     var spaceBetweenGaps = swiperSettings.space_between_gaps || {};
        //     var spaceBetween = spaceBetweenGaps[deviceMode] !== undefined ? parseInt(spaceBetweenGaps[deviceMode]) : 30;

        //     const loopEnabled = swiperSettings.loop === "yes";
        //     const arrowsEnabled = swiperSettings.arrows === "yes";
        //     const paginationType = swiperSettings.pagination || "none";
        //     const speed = swiperSettings.speed ? parseInt(swiperSettings.speed) : 600;

        //     const swiperInstance = new Swiper('#' + swiperID, {
        //         slidesPerView: 'auto', // Keep this for responsive behavior
        //         spaceBetween: spaceBetween,
        //         loop: loopEnabled,
        //         speed: speed,
        //         centeredSlides: true,
        //         grabCursor: true,
                
        //         // Add breakpoints for better responsive control
        //         breakpoints: {
        //             320: {
        //                 spaceBetween: 20,
        //             },
        //             768: {
        //                 spaceBetween: 30,
        //             },
        //             1024: {
        //                 spaceBetween: 40,
        //             }
        //         },

        //         pagination: paginationType === "bullets" ? {
        //             el: $parentHolder.find('.wdt-swiper-pagination')[0],
        //             clickable: true
        //         } : false,

        //         navigation: arrowsEnabled ? {
        //             nextEl: $parentHolder.find('.wdt-arrow-pagination-next')[0],
        //             prevEl: $parentHolder.find('.wdt-arrow-pagination-prev')[0]
        //         } : false,

        //         on: {
        //             init: function () {
        //                 updateActiveCenterClass(this);
        //             },
        //             slideChangeTransitionEnd: function () {
        //                 updateActiveCenterClass(this);
        //             },
        //             // Add transition start for smoother animation
        //             slideChangeTransitionStart: function () {
        //                 updateActiveCenterClass(this);
        //             }
        //         }
        //     });

        //     function updateActiveCenterClass(swiper) {
        //         const $allSlides = $thisSwiper.find('.swiper-slide');
        //         $allSlides.removeClass('active');
                
        //         // Get the actual active slide index
        //         const activeIndex = swiper.activeIndex;
        //         const $centerSlide = $(swiper.slides[activeIndex]);
                
        //         $centerSlide.addClass('active');
        //     }
        // });

    }


    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/wdt-advanced-testimonial.default', wdtAdvancedTestimonialWidgetHandler);
    });

} )( jQuery );