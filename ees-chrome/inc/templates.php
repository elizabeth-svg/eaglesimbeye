<?php
/**
 * Template routing.
 *
 * @package EES_Chrome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Use the EES article template for single blog posts.
 *
 * Only the `post` type is redirected, and only when the plugin's template is
 * not disabled via filter. Everything else falls through to the theme.
 *
 * @param string $template Path resolved by WordPress.
 * @return string
 */
function ees_chrome_single_template( $template ) {
	if ( ! is_singular( 'post' ) ) {
		return $template;
	}
	if ( ! apply_filters( 'ees_chrome_use_article_template', true, get_post() ) ) {
		return $template;
	}

	$custom = EES_CHROME_DIR . 'templates/single-ees-article.php';

	return file_exists( $custom ) ? $custom : $template;
}
