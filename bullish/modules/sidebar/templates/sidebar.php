<?php
$sidebar_class   = bullish_get_secondary_classes();
$active_sidebars = bullish_get_active_sidebars();

if( $sidebar_class == 'content-full-width' || $sidebar_class == '' ) {
    return;
}

if( empty( $active_sidebars ) ) {
    return;
}?>
<!-- Secondary -->
 <?php
 $page_sidebartoggle =  bullish_customizer_settings('hide_toogle_sidebar' ); 
 $page_sidebartoggledefault =  bullish_customizer_settings('hide_sidebardisabletoogle' ); 
?>

<section id="secondary" class="<?php echo esc_attr( $sidebar_class ); ?>"><div class="wdt-sidebar-wrapper <?php if($page_sidebartoggle) { echo 'wdt-sidebartoogle-wrapper'; } ?>"><?php
    do_action( 'bullish_before_single_sidebar_wrap' );

    get_sidebar();

    do_action( 'bullish_after_single_sidebar_wrap' );?>
</div></section><!-- Secondary End -->