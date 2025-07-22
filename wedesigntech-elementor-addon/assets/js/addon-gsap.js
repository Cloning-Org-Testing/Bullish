//////////////////////////////////////////////////////////////////////////////
//  Wedesigntech Elementor Addon GSAP Animation

// 1. Smooth Scroller
// 2. Fade Animation
// 3. Move Animation
// 4. Elementor E-Con Sticky
// 5. Same page Hash Link Smooth Scroll





////////////////////////////////////////////////////////////////////////////
gsap.config({ nullTargetWarn: false });

// 1. Smooth Scroller

window.addEventListener("DOMContentLoaded", () => {

    if (typeof gsap !== "undefined" && typeof ScrollSmoother !== "undefined") {
        gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

        const smoother = ScrollSmoother.create({
            wrapper: "#smooth-wrapper", 
            content: "#smooth-content",
            smooth: 1, // Smoothness of the scroll
            effects: true,
        });

    // Initialize Smooth Scroller for each widget

        let resizeTimer;

        setInterval(() => {
            ScrollTrigger.refresh();
        }, 1500);


        window.addEventListener("resize", () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                ScrollTrigger.refresh();
            }, 250);
        });


    } else {
        console.warn(":warning: GSAP or ScrollSmoother not loaded properly");
    }
});



// 2. Fade Animation


function getFadeConfig(settings, widget) {
    const { 'fade-from': fadeDirection, 'data-duration': duration, 
            'fade-offset': fadeOffset, delay, ease, 'wdt-gsap-animation': animationType } = settings;
    
    const config = {
        opacity: 0,
        ease: ease,
        duration: duration,
        delay: delay,
        ...(fadeDirection === 'top' && { y: -fadeOffset }),
        ...(fadeDirection === 'bottom' && { y: fadeOffset }),
        ...(fadeDirection === 'left' && { x: -fadeOffset }),
        ...(fadeDirection === 'right' && { x: fadeOffset }),
    };

    if (animationType === 'move') {
        const { wdt_a_rotation_di: rotationDirection, wdt_a_transform_origin: transformOrigin, wdt_a_rotation: rotation } = settings;
        config.force3D = true;
        config.transformOrigin = transformOrigin;

        if (rotationDirection === 'x') {
            config.rotationX = rotation;
        } else if (rotationDirection === 'y') {
            config.rotationY = rotation;
        }

        gsap.set(widget.parentElement, { perspective: 400 });
    }

    return config;
}
function applyFadeAnimation(widget, settings) {
    const config = getFadeConfig(settings, widget);
    const breakpoint = settings.wdt_fade_animation_breakpoint || null;
    const gsap_matchMedia = gsap.matchMedia();
    
    let match_media_key = (breakpoint === 'all-device') ? 'all-device' : 
                          (settings.wdt_fade_animation_breakpoint_min_max === 'min_val') ? 
                          `(min-width: ${breakpoint}px)` : 
                          `(max-width: ${breakpoint}px)`;

    if (settings['on-scroll']) {
        config.scrollTrigger = {
            trigger: widget,
            start: 'top 85%',
            lazy: true,
        };
    }

    if (match_media_key === 'all-device') {
        gsap.from(widget, config);
    } else if (typeof gsap_matchMedia !== 'undefined') {
        gsap_matchMedia.add(match_media_key, () => {
            gsap.from(widget, config);
        });
    } else {
        console.warn("gsap_matchMedia is not defined.");
    }
}

function initializeWidgets() {
    const widgets = document.querySelectorAll('.elementor-widget');
    widgets.forEach(widget => {
        const settings = widget.dataset.settings ? JSON.parse(widget.dataset.settings) : {};

        if (settings.enable_smooth_scroller_wdt === 'true') {
            initializeSmoothScroller(widget, settings);
        }

        const animationType = settings['wdt-gsap-animation'];
        if (animationType === 'fade' || animationType === 'move') {
            applyFadeAnimation(widget, settings);
        }
    });
}

(function ($) {
    $(document).ready(function () {
        if (window.elementor && elementor.channels && elementor.channels.editor) {
            elementor.hooks.addAction('panel/open_editor/widget', function(panel, model, view) {
                const widget = view.$el;
                const widgetSettings = model.get('settings');
                const animationType = widgetSettings.attributes['wdt-gsap-animation'];

                elementor.channels.editor.on('wdt:editor:play_animation', function() {
                    if (animationType === 'fade' || animationType === 'move') {
                        applyFadeAnimation(widget[0], widgetSettings.attributes);
                    }
                });
            });
        } else {
            console.warn("Elementor editor not detected. Ensure this script runs inside the editor.");
        }
    });

    initializeWidgets();
})(jQuery);


// 4. Elementor E-Con Sticky

if (typeof gsap !== "undefined" && typeof ScrollTrigger !== "undefined") {
    gsap.registerPlugin(ScrollTrigger);

    document.querySelectorAll('.wdt-sticky-css-column').forEach(col => {
        const wrapper = document.createElement('div');
        wrapper.className = 'wdt-sticky-inner-wrapper';
        while (col.firstChild) wrapper.appendChild(col.firstChild);
        col.appendChild(wrapper);

        setTimeout(() => {
            const _stickyHeight = wrapper.clientHeight;
            const _colHeight = col.clientHeight;
            const _stopPoint = _colHeight - _stickyHeight;

            if (typeof ScrollTrigger !== "undefined" && ScrollTrigger.getAll) {
                ScrollTrigger.getAll().forEach(trigger => trigger.kill());
            } else {
                console.log("ScrollTrigger is not defined or getAll method is unavailable.");
            }
        
            gsap.to(wrapper, {
                scrollTrigger: { 
                    trigger: wrapper, 
                    start: "top 50px", 
                    end: `+=${_stopPoint}px`, 
                    pin: true, 
                    pinSpacing: false,
                    lazy: true,
                }
            });
        }, 1000);

    });
}

// 5. Same page Hash Link Smooth Scroll

if (typeof gsap !== "undefined" && typeof ScrollTrigger !== "undefined") {
    gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

    document.addEventListener("DOMContentLoaded", function () {
        
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener("click", function (e) {
                e.preventDefault(); 

                const targetID = this.getAttribute("href");
                const targetEl = document.querySelector(targetID);

                if (targetEl) {
                    gsap.to(window, {
                        duration: 1,
                        scrollTo: targetEl,
                        ease: "power2.out",
                        lazy: true,
                    });
                }
            });
        });

        document.querySelectorAll('a[href="#top"]').forEach(link => {
            link.addEventListener("click", function (e) {
                e.preventDefault(); 

                gsap.to(window, {
                    duration: 1,
                    scrollTo: 0,
                    ease: "power2.out",
                    lazy: true,
                });
            });
        });
  })

}