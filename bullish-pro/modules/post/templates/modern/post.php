<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, bullish_single_post_params() ); ?>

    <?php
    bullish_template_part( 'post', 'templates/'.$Post_Style.'/parts/category', '', $template_args );
    if( $template_args['enable_title'] ) :
        bullish_template_part( 'post', 'templates/post-extra/title', '', $template_args );
    endif;

    bullish_template_part( 'post', 'templates/'.$Post_Style.'/parts/author_bio', '', $template_args );

    bullish_template_part( 'post', 'templates/post-extra/content', '', $template_args );
    ?>

    <!-- Post Meta --><!-- Post Meta -->

    <!-- Post Dynamic -->
    <?php echo apply_filters( 'bullish_single_post_dynamic_template_part', bullish_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/dynamic', '', $template_args ) ); ?><!-- Post Dynamic -->