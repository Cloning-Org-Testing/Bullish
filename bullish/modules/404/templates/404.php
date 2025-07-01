<?php
    if( isset( $enable_404message ) && ( $enable_404message == 1 || $enable_404message == true )  ) {
        $class = $notfound_style;
        $class .= ( isset( $notfound_darkbg ) && ( $notfound_darkbg == 1 ) ) ? " wdt-dark-bg" :"";
    ?>
    <div class="wrapper <?php echo esc_attr( $class );?>">
        <div class="container">
            <div class="center-content-wrapper">
                <div class="wdt-404-contents">
                    <h1>404</h1>
                    <h2><?php esc_html_e("Error Page", 'bullish'); ?></h2>
                    <h4><?php esc_html_e("Oops! Page Not Found", 'bullish'); ?></h4>
                    <p><?php esc_html_e("Whether you’re here to build muscle, find balance, or boost you’re here to find balance your our state-of the-art equipment, expert muscle.", 'bullish'); ?></p>
                    <a class="wdt-button filled small" target="_self" href="<?php echo esc_url(home_url('/'));?>"><?php esc_html_e("Back to Home",'bullish');?></a>
                </div>
            </div>
        </div>
    </div><?php
}?>