<?php

if (! function_exists('bullish_event_breadcrumb_title')) {
    function bullish_event_breadcrumb_title($title)
    {
        if (get_post_type() == 'tribe_events' && is_single()) {
            $etitle = esc_html__('Event Detail', 'bullish');
            return '<h1>' . $etitle . '</h1>';
        } else {
            return $title;
        }
    }

    add_filter('bullish_breadcrumb_title', 'bullish_event_breadcrumb_title', 20, 1);
    add_filter('bullish_breadcrumbs', 'breadcrumbs_event_module');
    function breadcrumbs_event_module($breadcrumbs)
    {
        global $post;
        if (is_singular('tribe_events')) {
            $breadcrumbs[] = '<span class="current">' . esc_html(get_the_title($post->ID)) . '</span>';
        }
        return $breadcrumbs;
    }
}
