<?php
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );

add_action( 'bullish_after_main_css', 'sidebar_style' );
function sidebar_style() {
    wp_enqueue_style( 'bullish-secondary', get_theme_file_uri('/modules/sidebar/assets/css/sidebar.css'), false, BULLISH_THEME_VERSION, 'all');
	wp_enqueue_script( 'bullish-secondary', get_theme_file_uri('/modules/sidebar/assets/js/sidebar.js'), array(), BULLISH_THEME_VERSION, true );
}

if( !function_exists( 'bullish_check_sidebar_has_active_widgets' ) ) {
	function bullish_check_sidebar_has_active_widgets() {

		$active_items = 0;
		$active_sidebars = bullish_get_active_sidebars();
		if(is_array($active_sidebars) && !empty($active_sidebars)) {
			foreach( $active_sidebars as $active_sidebar ) {
				if( is_active_sidebar( $active_sidebar ) ) {
					$active_items++;
				}
			}
		}

		if($active_items > 0) {
			return true;
		}

		return false;

	}
}

if( !function_exists( 'bullish_get_primary_classes' ) ) {
	function bullish_get_primary_classes() {
		$default = 'page-with-sidebar with-right-sidebar';
		if(bullish_check_sidebar_has_active_widgets()) {
			return apply_filters( 'bullish_primary_classes', $default );
		} else {
			return 'content-full-width';
		}
	}
}

if( !function_exists( 'bullish_get_secondary_classes' ) ) {
	function bullish_get_secondary_classes() {
		$default = 'secondary-sidebar secondary-has-right-sidebar';
		if(bullish_check_sidebar_has_active_widgets()) {
			return apply_filters( 'bullish_secondary_classes', $default );
		} else {
			return '';
		}
	}
}

if( !function_exists( 'bullish_get_active_sidebars' ) ) {
	function bullish_get_active_sidebars() {
		return apply_filters( 'bullish_active_sidebars', array( 'bullish-standard-sidebar-1' ) );
	}
}

add_action( 'widgets_init', 'bullish_sidebars' );
function bullish_sidebars() {
	$sidebartoggle_button = '<aside id="%1$s" class="widget %2$s">';
	if (function_exists('bullish_customizer_settings')) {
		$page_sidebartoggle =  bullish_customizer_settings('hide_toogle_sidebar' ); 
		$page_sidebartoggledefault =  bullish_customizer_settings('hide_sidebardisabletoogle' ); 
		if(isset($page_sidebartoggle)  && !empty($page_sidebartoggle) && ($page_sidebartoggle == 1) ){
			if(isset($page_sidebartoggledefault)  && !empty($page_sidebartoggledefault) ) {
				$default_ariaexpand = "false";
			} else {
				$default_ariaexpand = "true";	
			}
			$sidebartoggle_button = '<aside id="%1$s" class="widget %2$s"><div class="widget-toggle-group" aria-expanded='. $default_ariaexpand .'><div class="widget-toggle" aria-expanded='. $default_ariaexpand .'></div><i class="wdticon-chevron-down"></i></div>';
		
		} 
	}
	$sidebars = array(
		'name'          => esc_html__( 'Standard Sidebar', 'bullish' ),
		'id'            => 'bullish-standard-sidebar-1',
		'before_widget' => $sidebartoggle_button,
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>'
	);

	if( !empty( $sidebars ) ) {
		register_sidebar( $sidebars );
	}
}

add_action( 'after_switch_theme', 'bullish_update_default_widgets' );
function bullish_update_default_widgets() {

	// Add widgets programmatically

	$sidebars_widgets = get_option('sidebars_widgets');
    if(isset($sidebars_widgets['bullish-standard-sidebar-1']) && !empty($sidebars_widgets['bullish-standard-sidebar-1'])) {
        return;
    }

	$sidebars_widgets['bullish-standard-sidebar-1'] = array (
		'search-1',
		'recent-posts-1',
		'recent-comments-1',
		'archives-1',
		'categories-1',
	);
	update_option('sidebars_widgets', $sidebars_widgets);

	$search_widget_content[1]['title'] = esc_html__( 'Search', 'bullish' );
	update_option( 'widget_search', $search_widget_content );

	$rp_widget_content[1]['title'] = esc_html__( 'Recent Posts', 'bullish' );
	update_option( 'widget_recent-posts', $rp_widget_content );

	$rc_widget_content[1]['title'] = esc_html__( 'Recent Comments', 'bullish' );
	update_option( 'widget_recent-comments', $rc_widget_content );

	$archives_widget_content[1]['title'] = esc_html__( 'Archives', 'bullish' );
	update_option( 'widget_archives', $archives_widget_content );

	$categories_widget_content[1]['title'] = esc_html__( 'Categories', 'bullish' );
	$categories_widget_content[1]['hierarchical'] = 1;
	update_option( 'widget_categories', $categories_widget_content );

}