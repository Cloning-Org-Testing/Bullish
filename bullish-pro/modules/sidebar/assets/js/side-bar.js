(function ($) {
    "use strict";

    $(document).ready(function() {

        const _windWidth = window.innerWidth;

        if (typeof gsap !== "undefined" && typeof ScrollTrigger !== "undefined" && _windWidth > 1024) {
            gsap.registerPlugin(ScrollTrigger);

            let stickyTriggers = [];

            async function waitForSiteLoaded() {
                if (document.readyState !== "complete") {
                    await new Promise(resolve => window.addEventListener("load", resolve, { once: true }));
                }
            }

            const initStickySidebar = () => {
                stickyTriggers.forEach(trigger => trigger.kill());
                stickyTriggers = [];

                document.querySelectorAll('.secondary-sidebar').forEach(col => {

                    col.style.height = `${col.previousElementSibling.children[0].clientHeight}px`;
                    
                    setTimeout(() => {
                        const wrapperEle = col;
                        if (!wrapperEle) return;

                        const trigger = ScrollTrigger.create({
                            trigger: wrapperEle,
                            start: "top top",
                            end: "bottom top+=" + col.children[0].clientHeight,
                            pin: col.children[0],
                            pinSpacing: false,
                            lazy: true,
                            markers: false,
                            id: Math.random().toString(36).substring(2, 15),
                        });

                        stickyTriggers.push(trigger);
                    }, 1000);

                });

                ScrollTrigger.refresh();
            };

            
            jQuery(window).on('load', () => {
                waitForSiteLoaded().then(() => {
                    initStickySidebar();
                });
            });

            window.addEventListener("resize", () => {
                initStickySidebar();
            });

        } else if( $("#secondary").length ) {

            $('.secondary-sidebar').theiaStickySidebar({
                additionalMarginTop: 90,
                containerSelector: $('#primary')
            });
        }
    });
})(jQuery);