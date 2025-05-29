<?php
add_action( 'bullish_after_main_css', 'footer_style' );
function footer_style() {
    wp_enqueue_style( 'bullish-footer', get_theme_file_uri('/modules/footer/assets/css/footer.css'), false, BULLISH_THEME_VERSION, 'all');
}

add_action( 'bullish_footer', 'footer_content' );
function footer_content() {
    bullish_template_part( 'content', 'content', 'footer' );
}