(function ($) {

    const wdtAnimationWidgetHandler = function($scope, $) {

      // Initialize each item with position and height

      $animation_wrapper = $scope.find('.wdt-animation-wrapper div[class*="-marqee"]');
      $animation_wrapper_width = $animation_wrapper.width();
      $animation_wrapper.css({ '--wdt-marque-width': $animation_wrapper_width+'px', '--wdt-marque-Margin-Width': '-'+$animation_wrapper_width+'px' });

      $animation_main_wrapper = $scope.find('.wdt-animation-holder.vertical .wdt-animation-wrapper');
      $animation_wrapper = $scope.find('.wdt-animation-holder.vertical .wdt-animation-wrapper div[class*="-marqee"]');
      $animation_wrapper_height = $animation_wrapper.height();
      $animation_wrapper.css({ '--wdt-marque-Margin-height': '-'+$animation_wrapper_height+'px' });
      $animation_main_wrapper.css({ '--wdt-marque-height': $animation_wrapper_height+'px'});

    };

    $(window).on('elementor/frontend/init', function () {
          elementorFrontend.hooks.addAction('frontend/element_ready/wdt-animation.default', wdtAnimationWidgetHandler);
    });

  })(jQuery);
