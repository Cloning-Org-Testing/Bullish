(function ($) {

    const wdtServicesWidgetHandler = function($scope, $) {

        const getFullBoxHeight = ($element) => {
            if (!$element.length) return 0;

            const el = $element[0];
            const style = window.getComputedStyle(el);

            console.log('Calculating full box height for element:' + '-->>>' + el  + style);
            

            const height = el.offsetHeight;
            const marginTop = parseFloat(style.marginTop) || 0;
            const marginBottom = parseFloat(style.marginBottom) || 0;
            const paddingTop = parseFloat(style.paddingTop) || 0;
            const paddingBottom = parseFloat(style.paddingBottom) || 0;

            return height + marginTop + marginBottom + paddingTop + paddingBottom;
        };

        // Main logic: find all type-3 items, get max description height, apply as CSS var
        const $items = $scope.find('.wdt-service-item.wdt-type-3');
        if (!$items.length) return;

        let maxHeight = 0;

        $items.each(function () {
            const $desc = $(this).find('.wdt-service-description');
            const fullHeight = getFullBoxHeight($desc);
            if (fullHeight > maxHeight) {
                maxHeight = fullHeight;
            }
        });

        if (maxHeight > 0) {
            $items.each(function () {
                $(this).css('--type3-desc-height', `${maxHeight}px`);
            });
        }


    }

    $(window).on('elementor/frontend/init', function () {
          elementorFrontend.hooks.addAction('frontend/element_ready/wdt-services.default', wdtServicesWidgetHandler);
    });

})(jQuery);