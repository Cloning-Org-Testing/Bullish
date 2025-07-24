jQuery.noConflict();
jQuery(document).ready(function($) {
    "use strict";

    // Sticky Row
    
    if( $("#header-wrapper .sticky-header").length > 0 ) {

        if (typeof gsap !== "undefined" && typeof ScrollTrigger !== "undefined") { 

            gsap.registerPlugin(ScrollTrigger);

            let stickyTriggers = [];

            async function waitForSiteLoaded() {
                if (document.readyState !== "complete") {
                    await new Promise(resolve => window.addEventListener("load", resolve, { once: true }));
                }
            }

            const initStickyColumns = () => {
                stickyTriggers.forEach(trigger => trigger.kill());
                stickyTriggers = [];

                document.querySelectorAll('.sticky-header').forEach(item => {

                    setTimeout(() => {
                        const wrapperEle = item.closest('.inner-wrapper');
                        if (!wrapperEle) return;

                        const trigger = ScrollTrigger.create({
                            trigger: wrapperEle,
                            start: "top top",
                            end: "bottom top+=" + item.clientHeight,
                            pin: item,
                            pinSpacing: false,
                            lazy: true,
                            markers: false,
                            id: Math.random().toString(36).substring(2, 15),
                            onEnter: () => { 
                                item.classList.add('wdt-sticky-active');
                            },
                            onLeave: () => { 
                                item.classList.remove('wdt-sticky-active');
                            },
                        });

                        stickyTriggers.push(trigger);
                    }, 1000);


                });

                ScrollTrigger.refresh();
            };

            waitForSiteLoaded().then(() => {
                initStickyColumns();
                window.addEventListener("resize", () => {
                    initStickyColumns();
                });
            });

        } else {

            var $sticky_header_cloned = $('.sticky-header').clone();
            $sticky_header_cloned.removeClass('sticky-header').addClass('sticky-header-active');
            $( $sticky_header_cloned ).insertAfter( $('.sticky-header') );

            $('body').css('--sticky-header-height', $('.sticky-header-active').outerHeight() + 'px');

            var position = $(window).scrollTop();

            $(window).scroll(function() {
                var scroll = $(window).scrollTop();
                if((scroll > 0 && position > 0) && scroll > position) {
                    $("#header-wrapper .sticky-header-active").addClass('wdt-header-top');
                    $("#header-wrapper .sticky-header-active").addClass('wdt-header-scroll');

                    $("#header-wrapper .sticky-header-active").show();
                } else {
                    $("#header-wrapper .sticky-header-active").removeClass('wdt-header-top');
                    $("#header-wrapper .sticky-header-active").removeClass('wdt-header-scroll');
                }
                position = scroll;
            });

        }
        
    }

    // Mega Menu
    function megaMenu() {

        var $header = 0;
        var $header_width = 0;
        if( $("#header .container").length ) {
            $header = $("#header .container").offset().left;
        }
        $("li.has-mega-menu").each(function(){
            var $parent      = $(this),
                $parent_left = $parent.offset().left,
                $sub_menu    = $parent.children("ul.sub-menu"),
                $section     = $sub_menu.find('section');

            if( $section.hasClass('elementor-section-stretched') ) {

            	setTimeout(function() {
           			$sub_menu.css('left', - ( $parent_left ) );

            		var pad = $sub_menu.css('padding-left');
            		$section.css('left', - ( parseInt(pad) ) );

                    var windowWidth = $(window).width();
                    $sub_menu.css('width', parseInt( windowWidth ) );
            	}, 100);
;
            } else {
                $sub_menu.css('left', ( $header - $parent_left ) );
                if( !($("#header .container").length) ) {
                    $sub_menu.css('width', ( document.documentElement.clientWidth ) );
                }
                else
                {
                    var parentElement = document.querySelector("#header .container");
                    var parentElementWidth = parentElement.clientWidth;
                    $("li.has-mega-menu").find("ul.sub-menu").css('width',parentElementWidth);
                }
            }
        });
    }
    megaMenu();

    $(window).on("resize", function() {
        megaMenu();
    });
});