<?php
add_action('wp_enqueue_scripts', 'bullish_child_enqueue_styles', 100);

add_theme_support('title-tag');
add_theme_support('automatic-feed-links');
// Add support for block styles and patterns
add_theme_support('wp-block-styles');
add_theme_support('responsive-embeds');

// Add support for HTML5
add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

// Add support for custom logos, headers, and backgrounds
add_theme_support('custom-logo');
add_theme_support('custom-header');
add_theme_support('custom-background');

// Add support for wide alignment
add_theme_support('align-wide');

// Add editor styling
add_editor_style();

// Add support for post thumbnails
add_theme_support('post-thumbnails');

// Enqueue comment-reply script
if (is_singular() && comments_open() && get_option('thread_comments')) {
	wp_enqueue_script('comment-reply');
}

function bullish_child_enqueue_styles()
{
	wp_enqueue_style('bullish-parent', get_theme_file_uri('/style.css'));
}
