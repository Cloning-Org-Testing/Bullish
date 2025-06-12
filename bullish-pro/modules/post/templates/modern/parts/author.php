<?php if ( ! defined( 'ABSPATH' ) ) { exit; }

global $post;
$author_id = $post->post_author;
?>

<!-- Entry Author -->
<div class="single-entry-author">
	<div class="meta-author-img">
		<?php echo get_avatar($author_id, 40 );?>
	</div>
	<div class="meta-author-info">
		<span><?php esc_html_e('by', 'bullish-pro'); ?></span>
		<a href="<?php echo get_author_posts_url($author_id);?>" title="<?php esc_attr_e('View all posts by ', 'bullish-pro'); echo get_the_author_meta( 'nicename', $author_id );?>"><?php echo get_the_author_meta( 'nicename', $author_id );?></a>
    </div>
</div><!-- Entry Author -->