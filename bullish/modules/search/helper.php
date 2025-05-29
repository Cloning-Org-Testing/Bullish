<?php

    add_action( 'bullish_after_main_css', 'search_style' );
    function search_style() {
        wp_enqueue_style( 'bullish-quick-search', get_theme_file_uri('/modules/search/assets/css/search.css'), false, BULLISH_THEME_VERSION, 'all');
    }

    add_action('wp_ajax_bullish_search_data_fetch' , 'bullish_search_data_fetch');
	add_action('wp_ajax_nopriv_bullish_search_data_fetch','bullish_search_data_fetch');
	function bullish_search_data_fetch(){
        $nonce = $_POST['security'];
        if ( ! wp_verify_nonce( $nonce, 'search_data_fetch_nonce' ) ) {
            die( 'Security check failed' );
        }
        $search_val = bullish_sanitization($_POST['search_val']);

        $the_query = new WP_Query( array( 'posts_per_page' => 5, 's' => $search_val, 'post_type' => array('post', 'product') ) );
        if( $the_query->have_posts() ) :
            while( $the_query->have_posts() ): $the_query->the_post(); ?>
                <li class="quick_search_data_item">
                    <a href="<?php echo esc_url( get_permalink() ); ?>">
                        <?php the_post_thumbnail( 'thumbnail', array( 'class' => ' ' ) ); ?>
                        <?php the_title();?>
                    </a>
                </li>
            <?php endwhile;
            wp_reset_postdata();
        else:
            echo'<p>'. esc_html__( 'No Results Found', 'bullish') .'</p>';
        endif;

        die();
}
add_action( 'wp_enqueue_scripts', 'bullish_enqueue_scripts' );
    function bullish_enqueue_scripts() {
        // Enqueue your script here
        wp_enqueue_script( 'bullish-jqcustom', get_theme_file_uri('/assets/js/custom.js'), array('jquery'), false, true );
        // Create nonce and pass it to the script
        $ajax_nonce = wp_create_nonce( 'search_data_fetch_nonce' );
        wp_localize_script( 'bullish-jqcustom', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'ajax_nonce' => $ajax_nonce ) );
    }

?>