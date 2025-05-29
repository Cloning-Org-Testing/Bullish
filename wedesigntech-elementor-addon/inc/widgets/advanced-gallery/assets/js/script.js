(function ($) {
    const wdtGalleryHandler = function ($scope, $) {
        const $scopeItemId = $scope.data('id');
        const $scopesettings = $scope.data('settings');

        // Isotope initialization
        if ($scopesettings.enable_isotope === "true") {
            const $scopeItem = $scope.find('.wdt-grid');

            if ($($scopeItem).length) {
                $scopeItem.isotope({
                    itemSelector: '.wdt-grid-item',
                    masonry: {
                        columnWidth: '.wdt-gallery-item'
                    }
                });

                window.setTimeout(function () {
                    $scopeItem.isotope();
                }, 1400);

                $(window).on("resize", function () {
                    $scopeItem.isotope({
                        itemSelector: '.wdt-grid-item',
                        masonry: {
                            columnWidth: '.wdt-gallery-item'
                        }
                    });
                });
            }
        }

        // Hover overlay effect
        const $galleryItems = $scope.find('.wdt-gallery-item');

        const getDirection = (e, item) => {
            const rect = item.getBoundingClientRect();
            const w = rect.width;
            const h = rect.height;
            const x = (e.clientX - rect.left - w / 2) * (w > h ? h / w : 1);
            const y = (e.clientY - rect.top - h / 2) * (h > w ? w / h : 1);
            const d = Math.round((Math.atan2(y, x) * (180 / Math.PI) + 180) / 90 + 3) % 4;
            return ['top', 'right', 'bottom', 'left'][d];
        };

        const classNames = [
            'hover-in-top', 'hover-in-right', 'hover-in-bottom', 'hover-in-left',
            'hover-out-top', 'hover-out-right', 'hover-out-bottom', 'hover-out-left'
        ];

        let activeItem = null;

        $galleryItems.each(function () {
            const $item = $(this);
            const $overlay = $item.find('.wdt-hover-overlay');

            $overlay.css('pointer-events', 'none');

            let lastDir = null;

            $item.on('mouseenter', function (e) {
                if (activeItem === $item) return;
                activeItem = $item;

                lastDir = getDirection(e.originalEvent, this);

                classNames.forEach(cls => {
                    $overlay.removeClass(cls);
                });

                $overlay.addClass('hover-in-' + lastDir);
            });

            $item.on('mouseleave', function (e) {
                if (activeItem !== $item) return;
                activeItem = null;

                if (lastDir !== null) {
                    classNames.forEach(cls => {
                        $overlay.removeClass(cls);
                    });

                    const leaveDir = getDirection(e.originalEvent, this);
                    $overlay.addClass('hover-out-' + leaveDir);
                }
            });
        });

        // Magnific Popup for gallery images (optional, uncomment if needed)
        // $scope.find('.wdt-gallery-item').each(function() {
        //     $(this).magnificPopup({
        //         type: 'image',
        //         gallery: {
        //             enabled: true
        //         }
        //     });
        // });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/wdt-advanced-gallery.default', wdtGalleryHandler);
    });
})(jQuery);