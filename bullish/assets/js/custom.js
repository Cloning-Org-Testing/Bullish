jQuery.noConflict();
jQuery(document).ready(function($){
    "use strict";

    /**
     * Keyboard navigation links
     */
        if( $("ul.wdt-primary-nav").length ) {
            var $children = $("ul.wdt-primary-nav").find(".menu-item-has-children a");
            var $sub_menu = $("ul.wdt-primary-nav").find(".sub-menu a");
            var $a        = $("ul.wdt-primary-nav > li > a");

            $( $a ).focus(function() {
                $(this).parent("li").addClass('focus');
            }).blur(function(){
                $(this).parent("li").removeClass('focus');
            });

            $( $children ).focus(function(){
                $(this).parents(".menu-item-has-children").addClass('focus');
            }).blur(function(){
                $(this).parents(".menu-item-has-children").removeClass('focus');
            });

            $( $sub_menu ).focus(function(){
                $(this).parent("li").addClass('focus');
            }).blur(function(){
                $(this).parent("li").removeClass('focus');
            });
        }

        jQuery(document).on('keydown', function( event ) {

            if(!jQuery('body').hasClass('nav-is-visible')) {
                return;
            }

            var tabKey = event.keyCode === 9;
			var shiftKey = event.shiftKey;
			var escKey = event.keyCode === 27;

            if(escKey) {
                jQuery('.mobile-menu-overlay').trigger('click');
            }

            var activeItem = jQuery(':focus');
            if(activeItem.parent().hasClass('menu-item')) {

                if( shiftKey && tabKey ) {

                    var activeMenuItem = activeItem.parent('.menu-item');
                    if(activeMenuItem.prev().hasClass('menu-item-has-children')) {
                        event.preventDefault();
                        activeMenuItem.prev().find('a:first').focus();
                    }

                } else if( !shiftKey && tabKey ) {

                    var activeMenuItem = activeItem.parent('.menu-item');
                    if(activeMenuItem.next().hasClass('menu-item-has-children')) {
                        event.preventDefault();
                        activeMenuItem.next().find('a:first').focus();
                    } else if(activeMenuItem.hasClass('menu-item-has-children')) {
                        event.preventDefault();
                        activeMenuItem.next().find('a:first').focus();
                    } else if(activeMenuItem.attr('class') == jQuery('.mobile-menu .menu-item:last').attr('class')) {
                        event.preventDefault();
                        jQuery('.mobile-menu').find('.close-nav:first a').focus();
                    } else if(activeMenuItem.attr('class') == activeMenuItem.parent('.sub-menu').find('.menu-item:last').attr('class')) {
                        event.preventDefault();
                        activeMenuItem.parent('.sub-menu').find('.close-nav:first a').focus();
                    }

                }

            } else {

                if( shiftKey && tabKey ) {

                    if(activeItem.parent('li').hasClass('close-nav')){
                        event.preventDefault();
                        if(activeItem.closest('.sub-menu').length){
                            activeItem.closest('.sub-menu').find('.menu-item:last a').focus();
                        } else {
                            jQuery('.mobile-menu .menu-item-depth-0:last a').focus();
                        }
                    }

                }

            }

        });

        // Header Height
        var header_container_height = $('body > .wrapper > .inner-wrapper > #header-wrapper > header');
        var header_assign_height = $('body');
        if( header_container_height.length ) {
            header_container_height.each(function(){
                var foot_height = $(this).height();
                header_assign_height.css('--header-height', foot_height+'px');
            });
        }

        // Footer Height

        var footer_container_height = $('body.wdt-fixed-footer-enabled > .wrapper > .inner-wrapper > footer');
        var footer_assign_height = $('body.wdt-fixed-footer-enabled > .wrapper > .inner-wrapper');

        if( footer_container_height.length ) {
            footer_container_height.each(function(){
                var head_height = $(this).height();
                footer_assign_height.css('--footer-height', head_height+'px');
            });
        }

    /**
     * Desktop Menu Animation
     */

        $('.animate-menu-item').parents('.menu-item').find('a')
            .mouseenter(function() {
                var animation_class = $(this).parents('.menu-item').find('.animate-menu-item').attr('data-animation');
                $(this).parents('.menu-item').find('.animate-menu-item').addClass(animation_class);
            })
            .mouseleave(function() {
                var animation_class = $(this).parents('.menu-item').find('.animate-menu-item').attr('data-animation');
                $(this).parents('.menu-item').find('.animate-menu-item').removeClass(animation_class);
            });

    /**
     * Mobile Menu
     */

        var clicked = "false";
        $('.menu-trigger').on('click', function( event ){
            event.preventDefault();

            if (clicked == "false") {
                $('html, body').css('overflow', 'hidden');
                clicked = "true";

                var menuItem = $(this).parents('.wdt-header-menu').find('.wdt-primary-nav:not(.wdt-secondary-nav)').clone();

                // Remove animation Class
                $('[data-animation]', menuItem ).each(function(ix, ele ){
                    $(ele).removeClass('animate-menu-item');
                });

                $('<div class="mobile-menu" />').appendTo( $("body") );

                menuItem.appendTo('.mobile-menu');

                $('<div class="mobile-menu-overlay"></div>').appendTo( $("body") );

                $('.mobile-menu').toggleClass('nav-is-visible');

                $('.mobile-menu-overlay').toggleClass('is-visible');

                $('body').toggleClass('nav-is-visible');

                $('.mobile-menu').find('.close-nav:first a').focus();

                // Initializing mobile nav
                initializeMobileNav();

            } else {
                closeMobNav();
            }

        });

        // Closing Mobile Nav
        function closeMobNav() {

            var scrollPos = $(window).scrollTop();

            $('html, body').css('overflow', 'auto');
            clicked = "false";

            $('.mobile-menu, .mobile-menu-overlay').removeClass('is-visible');
            $('body').removeClass('nav-is-visible');

            $('.mobile-menu').remove();
            $('.mobile-menu-overlay').remove();

            $('.menu-trigger').focus();

            $(window).scrollTop(scrollPos);
        }

        // $('.menu-trigger').on('click', function( event ){

        //     var menuItem = $(this).parents('.wdt-header-menu').find('.wdt-primary-nav:not(.wdt-secondary-nav)').clone();

        //     // Remove animation Class
        //     $('[data-animation]', menuItem ).each(function(ix, ele ){
        //         $(ele).removeClass('animate-menu-item');
        //     });

        //     $('<div class="mobile-menu" />').appendTo( $("body") );
        //     menuItem.appendTo('.mobile-menu');
        //     $('<div class="mobile-menu-overlay"></div>').appendTo( $("body") );

        //     $('.mobile-menu').toggleClass('nav-is-visible');
        //     $('.mobile-menu-overlay').toggleClass('is-visible');
        //     $('body').toggleClass('nav-is-visible');

        //     $('.mobile-menu').find('.close-nav:first a').focus();

        //     // Initializing mobile nav
        //     initializeMobileNav();

        // });

        // Closing Mobile Nav
        // function closeMobNav() {
        //     $('body').removeClass('nav-is-visible');

        //     $('.mobile-menu').remove();
        //     $('.mobile-menu-overlay').remove();

        //     $('.menu-trigger').focus();
        // }

        // Initialize mobile nav
        function initializeMobileNav() {

            $('li.close-nav').on('click', function(event) {
                closeMobNav();
            });

            $('.mobile-menu-overlay').on('click', function(event) {
                closeMobNav();
            });

            // Sub Menu in Mobile Menu
            $('.menu-item-has-children > a, .page_item_has_children > a').on('click', function(event) {
                if ( $('body').hasClass('nav-is-visible') ) {
                    event.preventDefault();
                    var a = $(this).clone();
                    $(this).next('.sub-menu').find('.see-all').html(a);
                }

                var selected = $(this);
                if( selected.next('ul').hasClass('is-hidden') ) {
                    selected.next('ul.sub-menu').removeClass('is-hidden');
                } else {
                    selected.next('ul.sub-menu').addClass('is-hidden');
                }
            });

            $('.menu-item-has-children > a, .page_item_has_children > a').on('click', function(event) {

                var selected = $(this);
                selected.next('.sub-menu:not(.is-hidden)').find('a:first').focus();

            });

            // Go Back in Mobile Menu
            $('.go-back').on('click', function(event) {
                $(this).parent('ul:not(.menu)').addClass('is-hidden');
                event.preventDefault();
                $(this).parents('.menu-item').find('a:first').focus();
            });

        }

        // For Video Post
        if( $("div.wdt-video-wrap").length ) {
           $("div.wdt-video-wrap").fitVids();
        }

        // Smart Resize
        $(window).on("resize", function() {
            // Blog Isotope
            if( $(".apply-isotope").length ) {
                $(".apply-isotope").isotope({itemSelector : '.column',transformsEnabled:false,masonry: { columnWidth: '.grid-sizer' } });
            }
        });

        $(window).on('load', function() {

            // Gallery Post Slider
            if( ($("ul.entry-gallery-post-slider").length) && ( $("ul.entry-gallery-post-slider li").length > 1 ) ){
                $("ul.entry-gallery-post-slider").bxSlider({mode: 'fade', auto:false, video:true, pager:'', autoHover:true, adaptiveHeight:false, responsive: true });
            }

            // Blog Isotope
            if( $(".apply-isotope").length ) {
                $(".apply-isotope").isotope({itemSelector : '.column',transformsEnabled:false,masonry: { columnWidth: '.grid-sizer' } });
            }

            // Blog Equal Height
            if( $('.tpl-blog-holder.apply-equal-height').length ) {
                $(".tpl-blog-holder.apply-equal-height article").matchHeight({ property:"min-height" });
            }
        });

        if( $('.single .entry-thumb.single-preview-img a.mag-pop, a.lightbox-preview-img').length ) {
            $('.single .entry-thumb.single-preview-img a.mag-pop, a.lightbox-preview-img').magnificPopup({
                type: 'image',
                closeOnContentClick: false,
                closeBtnInside: false,
                mainClass: 'mfp-with-zoom mfp-img-mobile',
                image: {
                  verticalFit: true,
                  titleSrc: function(item) {
                    return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('href')+'" target="_blank">image source</a>';
                  }
                },
                zoom: {
                  enabled: true,
                  duration: 300, // don't foget to change the duration also in CSS
                  opener: function(element) {
                    return element.find('img');
                  }
                }
            });
        }

        $("select:not(.dt-select-staff,.wdt-sf-field)").each(function() {
            $(this).select2();
        });
        $('form.wpcf7-form input').each(function(){
            $(this).parent("p").addClass('with-spinner');
        });

          // Contact form 7 Date and time picker
        $('form.wpcf7-form').each(function(){
            if (document.querySelector('.wdtDateTimePicker')) {
                flatpickr(".wdtDateTimePicker", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    disableMobile: "true"
                });
            }

            if (document.querySelector('.wdtDatePicker')) {
                flatpickr(".wdtDatePicker", {
                    enableTime: false,
                    dateFormat: "Y-m-d",
                    disableMobile: "true"
                });
            }

            if (document.querySelector('.wdtTimePicker')) {
                flatpickr(".wdtTimePicker", {
                    enableTime: true,
                    noCalendar: true,
                    disableMobile: "true",
                    dateFormat: "H:i",
                });
            }
        });

});

/* Live Search*/
jQuery( 'body' ).delegate( '.text_input', 'keypress', function(e) {

    if (jQuery('.text_input').is(":focus")) {

    var this_item = jQuery(this),
    search_val = this_item.val();
        if(search_val == "" ){
            jQuery('.quick_search_results').html("");
            jQuery('.quick_search_results').removeClass('active');
        } else {
                jQuery.ajax({
                    type:"POST",
                    url: bullish_urls.ajaxurl,
                    data: {
                        action:'bullish_search_data_fetch',
                        search_val:search_val,
                        ajax_call: true,
                        function_call: 'bullish_search_data_fetch',
                        security: ajax_object.ajax_nonce
                    },
                    success:function(data){
                        jQuery('.quick_search_results').addClass('active');
                        jQuery('.quick_search_results').html(data);
                    }
                });
            }
    }
});
//lightbox image popup loading fix
document.addEventListener("DOMContentLoaded", function () {
    function updateActiveSlideImage() {
        const activeSlide = document.querySelector(".swiper-slide.elementor-lightbox-item.swiper-slide-active");
        if (activeSlide) {
            const zoomImage = activeSlide.querySelector(".swiper-zoom-container img");
            if (zoomImage) {
                const dataSrc = zoomImage.getAttribute("data-src");
                if (dataSrc) {
                    zoomImage.setAttribute("src", dataSrc);
                    zoomImage.removeAttribute("data-src");
                    zoomImage.classList.remove("swiper-lazy");
                    zoomImage.classList.add("swiper-lazy-loaded");
                }
            }
            const lazyPreloader = activeSlide.querySelector(".swiper-lazy-preloader");
            if (lazyPreloader) {
                lazyPreloader.remove();
            }
        }
    }

    document.addEventListener("click", function () {
        const lightboxWidget = document.querySelector(".dialog-widget.dialog-lightbox-widget.dialog-type-buttons.dialog-type-lightbox.elementor-lightbox");
        if (lightboxWidget) {
            setTimeout(updateActiveSlideImage, 1000);
        }
        else {
            setTimeout(updateActiveSlideImage, 100);
        }
        setTimeout(function () {
            const activeSlide = document.querySelector(".swiper-slide.elementor-lightbox-item.swiper-slide-active");
            if (activeSlide) {
                const nextButtons = document.querySelectorAll(".elementor-swiper-button-next");
                const prevButtons = document.querySelectorAll(".elementor-swiper-button-prev");
                nextButtons.forEach(nextButton => {
                    nextButton.addEventListener("click", function () {
                        setTimeout(updateActiveSlideImage, 1000);
                    });
                });
                prevButtons.forEach(prevButton => {
                    prevButton.addEventListener("click", function () {
                        setTimeout(updateActiveSlideImage, 1000);
                    });
                });
            }
        },);
    });
});
document.addEventListener("DOMContentLoaded", function () {
    // Loop through all images on the page
    document.querySelectorAll("img").forEach(function(img) {
        function setDimensions() {
            if (
                (!img.hasAttribute("width") || img.getAttribute("width") === "0") &&
                img.naturalWidth
            ) {
                img.setAttribute("width", img.naturalWidth);
            }
            if (
                (!img.hasAttribute("height") || img.getAttribute("height") === "0") &&
                img.naturalHeight
            ) {
                img.setAttribute("height", img.naturalHeight);
            }
        }
        if (img.complete) {
            setDimensions();
        } else {
            img.addEventListener("load", setDimensions);
        }
    });
});


// Page Preloader And Lazyload for speed

jQuery(function ($) {
    const preloadThreshold = window.innerHeight + 300;
    const bgElements = [];

    // --- UTILITIES ---
    function preloadLink(href, as = "image") {
        if (!href || document.querySelector(`link[rel="preload"][href="${href}"]`)) return;
        const link = document.createElement("link");
        link.rel = "preload";
        link.as = as;
        link.href = href;
        link.fetchPriority = "high";

        // Dynamically add crossorigin attribute
        const isCrossOrigin = href.startsWith("http") && new URL(href).origin !== window.location.origin;
        if (isCrossOrigin) {
            link.crossOrigin = "anonymous";
        }

        document.head.appendChild(link);
    }

    function preconnectDomain(href) {
        try {
            const url = new URL(href);
            if (!document.querySelector(`link[rel="preconnect"][href="${url.origin}"]`)) {
                const link = document.createElement("link");
                link.rel = "preconnect";
                link.href = url.origin;
                link.crossOrigin = "anonymous";
                document.head.appendChild(link);
            }
        } catch (e) {}
    }

    function forcePreloadImage(url) {
        if (!url || url.startsWith('data:')) return;
        const img = new Image();
        img.src = url;
        img.loading = "eager";
        img.decoding = "async";
        img.setAttribute("fetchpriority", "high");
        img.style.display = "none";
        document.body.appendChild(img);
    }

    function extractUrl(styleVal) {
        const match = styleVal && styleVal.match(/url\((['"]?)(.*?)\1\)/);
        return match && match[2] ? match[2] : null;
    }

    // --- HERO BOOST (above the fold) ---
    $("section, .elementor-section, .wp-block-cover").each(function () {
        const $section = $(this);
        const style = getComputedStyle(this);
        const bgImage = extractUrl(style.backgroundImage);
        const isVisible = style.display !== "none" && $section.outerHeight() > 0;
        const rect = this.getBoundingClientRect();
        const isAboveFold = rect.top + window.scrollY < window.innerHeight;

        if (bgImage && isVisible && isAboveFold) {
            preconnectDomain(bgImage);
            preloadLink(bgImage);
            forcePreloadImage(bgImage);
            return false; // break loop on first match
        }
    });


    // --- EAGER LOAD IMAGES ABOVE FOLD ---
    $("img").each(function () {
        const $img = $(this);
        const rect = this.getBoundingClientRect();
        const top = rect.top + window.scrollY;
        const src = $img.attr("src");

        if (src) {
            preconnectDomain(src);
            if (top < preloadThreshold || $img.data("priority") === "high") {
                preloadLink(src);
                forcePreloadImage(src);
                $img.attr({
                    loading: "eager",
                    decoding: "async",
                    fetchpriority: "high"
                });
            } else {
                $img.attr({
                    loading: $img.attr("loading") || "lazy",
                    decoding: $img.attr("decoding") || "async"
                });
            }
        }
    });

    // --- BACKGROUND IMAGES ---
    $("*").each(function () {
        const el = this;
        const style = getComputedStyle(el);
        if (style.display === "none" || el.closest('.megamenu')) return;

        const rect = el.getBoundingClientRect();
        const top = rect.top + window.scrollY;
        const bgImage = extractUrl(style.backgroundImage);
        const varImage = extractUrl(style.getPropertyValue('--optional-background-image'));

        if (bgImage) {
            preconnectDomain(bgImage);
            if (top >= preloadThreshold) {
                el.dataset.lazyBg = bgImage;
                el.style.backgroundImage = "none";
                bgElements.push(el);
            } else {
                preloadLink(bgImage);
                forcePreloadImage(bgImage);
            }
        }

        if (varImage) {
            preconnectDomain(varImage);
            if (top >= preloadThreshold) {
                el.dataset.lazyVar = varImage;
                el.style.setProperty('--optional-background-image', 'none');
                bgElements.push(el);
            } else {
                preloadLink(varImage);
                forcePreloadImage(varImage);
            }
        }
    });

    // --- OBSERVE & LOAD ON VIEW ---
    if ("IntersectionObserver" in window) {
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    if (el.dataset.lazyBg) {
                        el.style.backgroundImage = `url('${el.dataset.lazyBg}')`;
                        delete el.dataset.lazyBg;
                    }
                    if (el.dataset.lazyVar) {
                        el.style.setProperty('--optional-background-image', `url('${el.dataset.lazyVar}')`);
                        delete el.dataset.lazyVar;
                    }
                    observer.unobserve(el);
                }
            });
        }, { rootMargin: "300px 0px" });

        bgElements.forEach(el => observer.observe(el));
    } else {
        // Fallback
        bgElements.forEach(el => {
            if (el.dataset.lazyBg) el.style.backgroundImage = `url('${el.dataset.lazyBg}')`;
            if (el.dataset.lazyVar) el.style.setProperty('--optional-background-image', `url('${el.dataset.lazyVar}')`);
        });
    }

    // --- GOOGLE FONTS: HIGH PRIORITY ---
    const usedFonts = new Set();
    document.querySelectorAll("*").forEach(el => {
        const family = getComputedStyle(el).fontFamily;
        if (family) {
            const primary = family.split(",")[0].replace(/['"]/g, "").trim();
            // Skip system fonts and Times New Roman (which is a system font and not available on Google Fonts)
            if (!/^system-ui|sans-serif|serif|Times New Roman$/i.test(primary)) {
                usedFonts.add(primary);
            }
        }
    });

    usedFonts.forEach(font => {
        const url = `https://fonts.googleapis.com/css2?family=${encodeURIComponent(font)}&display=swap`;
        if (!document.querySelector(`link[href="${url}"]`)) {
            const preload = document.createElement("link");
            preload.rel = "preload";
            preload.as = "style";
            preload.href = url;
            preload.crossOrigin = "anonymous";
            preload.onload = function () {
                this.rel = "stylesheet";
            };
            document.head.appendChild(preload);
        }
    });

    // --- LOG HIGH TTFB ---
    // Use PerformanceNavigationTiming instead of deprecated performance.timing
    let navEntry = performance.getEntriesByType("navigation")[0];
    if (navEntry && navEntry.responseStart - navEntry.requestStart > 1000) {
        console.warn("⚠️ High TTFB. Use full-page cache and database optimization on WP Engine.");
    }
});
