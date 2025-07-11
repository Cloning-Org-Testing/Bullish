<?php if (! defined('ABSPATH')) {
	exit;
} ?>

<?php
$template_args['post_ID'] = $ID;
$template_args['post_Style'] = $Post_Style;
$template_args = array_merge($template_args, bullish_archive_blog_post_params());

if (! empty($template_args['archive_media_elements'])) {
	echo '<div class="entry-media-group">';
	if (in_array('feature_image', $template_args['archive_media_elements'])) {
		echo bullish_get_template_part('blog', 'templates/post-extra/' . 'feature_image', '', $template_args);
	}
	echo '<div class="entry-thumb-content">';
	foreach ($template_args['archive_media_elements'] as $media) {
		switch ($media) {
			case 'title':
			case 'content':
			case 'read_more':
			case 'likes_views':
			case 'social':
				bullish_template_part('blog', 'templates/post-extra/' . $media, '', $template_args);
				break;
			case 'meta_group':
				if (!empty($template_args['archive_meta_elements'])) {
					echo '<div class="entry-meta-group">';
					foreach ($template_args['archive_meta_elements'] as $meta) {
						switch ($meta) {
							case 'likes_views':
							case 'social':
								bullish_template_part('blog', 'templates/post-extra/' . $meta, '', $template_args);
								break;
							default:
								$path = bullish_get_template_part('blog', 'templates/' . $Post_Style . '/parts/' . $meta, '', $template_args);
								$path = !empty($path) ? $path : bullish_get_template_part('blog', 'templates/post-extra/' . $meta, '', $template_args);
								echo bullish_html_output($path);
								break;
						}
					}
					echo '</div>';
				}
				break;
			default:
				if ($media !== 'feature_image') {
					$path = bullish_get_template_part('blog', 'templates/' . $Post_Style . '/parts/' . $media, '', $template_args);
					$path = !empty($path) ? $path : bullish_get_template_part('blog', 'templates/post-extra/' . $media, '', $template_args);
					echo bullish_html_output($path);
				}
				break;
		}
	}
	echo '</div>';
	echo '</div>';
}

if (!empty($template_args['archive_post_elements'])) {
	echo '<div class="entry-content-group">';

	echo '<div class="entry-sub-content-group">';
		foreach ($template_args['archive_post_elements'] as $element) {

			if ($element === 'read_more') {
				continue;
			}
			switch ($element) {
				case 'title':
				case 'content':
				case 'likes_views':
				case 'social':
					bullish_template_part('blog', 'templates/post-extra/' . $element, '', $template_args);
					break;

				case 'meta_group':
					if (!empty($template_args['archive_meta_elements'])) {
						echo '<div class="entry-meta-group">';
						foreach ($template_args['archive_meta_elements'] as $meta) {
							switch ($meta) {
								case 'likes_views':
								case 'social':
									bullish_template_part('blog', 'templates/post-extra/' . $meta, '', $template_args);
									break;
								default:
									$path = bullish_get_template_part('blog', 'templates/' . $Post_Style . '/parts/' . $meta, '', $template_args);
									$path = !empty($path) ? $path : bullish_get_template_part('blog', 'templates/post-extra/' . $meta, '', $template_args);
									echo bullish_html_output($path);
									break;
							}
						}
						echo '</div>';
					}
					break;

				default:
					$path = bullish_get_template_part('blog', 'templates/' . $Post_Style . '/parts/' . $element, '', $template_args);
					$path = !empty($path) ? $path : bullish_get_template_part('blog', 'templates/post-extra/' . $element, '', $template_args);
					echo bullish_html_output($path);
					break;
			}
		}
	echo '</div>';

	if (in_array('read_more', $template_args['archive_post_elements'])) {
		echo '<div class="entry-read-more-group">';
		bullish_template_part('blog', 'templates/post-extra/read_more', '', $template_args);
		echo '</div>';
	}
	
	echo '</div>';
}


do_action('bullish_blog_post_entry_details_close_wrap');
