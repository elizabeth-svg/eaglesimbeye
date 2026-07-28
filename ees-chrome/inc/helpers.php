<?php
/**
 * Shared helpers: navigation data, current-link detection, reading time.
 *
 * @package EES_Chrome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Primary navigation links (header pill).
 *
 * Filterable so the menu can be changed without touching markup.
 *
 * @return array<int,array{label:string,url:string,external:bool}>
 */
function ees_chrome_nav_links() {
	$links = array(
		array( 'label' => 'Work',      'url' => home_url( '/work/' ),                 'external' => false ),
		array( 'label' => 'About',     'url' => home_url( '/about/' ),                'external' => false ),
		array( 'label' => 'Portfolio', 'url' => 'https://portfolio.eaglesimbeye.com/', 'external' => true ),
		array( 'label' => 'Thoughts',  'url' => home_url( '/design-thinking/' ),      'external' => false ),
		array( 'label' => 'Mentoring', 'url' => home_url( '/mentor/' ),               'external' => false ),
		array( 'label' => 'Contact',   'url' => home_url( '/contact/' ),              'external' => false ),
	);

	return apply_filters( 'ees_chrome_nav_links', $links );
}

/**
 * Footer "Quick links" column.
 *
 * @return array<int,array{label:string,url:string,external:bool}>
 */
function ees_chrome_footer_links() {
	$links = array(
		array( 'label' => 'Home',           'url' => home_url( '/' ),                      'external' => false ),
		array( 'label' => 'Portfolio',      'url' => 'https://portfolio.eaglesimbeye.com/', 'external' => true ),
		array( 'label' => 'Work',           'url' => home_url( '/work/' ),                 'external' => false ),
		array( 'label' => 'About',          'url' => home_url( '/about/' ),                'external' => false ),
		array( 'label' => 'Mentoring',      'url' => home_url( '/mentor/' ),               'external' => false ),
		array( 'label' => 'Thoughts',       'url' => home_url( '/design-thinking/' ),      'external' => false ),
		array( 'label' => 'Contact',        'url' => home_url( '/contact/' ),              'external' => false ),
		array( 'label' => 'Privacy Policy', 'url' => home_url( '/privacy-policy/' ),       'external' => false ),
	);

	return apply_filters( 'ees_chrome_footer_links', $links );
}

/**
 * Footer "Socials" column.
 *
 * @return array<int,array{label:string,url:string}>
 */
function ees_chrome_social_links() {
	$links = array(
		array( 'label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/eaglesimbeye/' ),
		array( 'label' => 'Medium',   'url' => 'https://medium.com/@eaglesimbeye' ),
		array( 'label' => 'Substack', 'url' => 'https://substack.com/@eaglesimbeye' ),
	);

	return apply_filters( 'ees_chrome_social_links', $links );
}

/**
 * Whether a nav URL points at the page currently being viewed.
 *
 * @param string $url Candidate link URL.
 * @return bool
 */
function ees_chrome_is_current( $url ) {
	$current = home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) );
	$current = untrailingslashit( strtok( $current, '?' ) );
	$target  = untrailingslashit( strtok( $url, '?' ) );

	if ( '' === $target || $target === untrailingslashit( home_url( '/' ) ) ) {
		return is_front_page();
	}

	return $current === $target;
}

/**
 * Estimated reading time in whole minutes for a block of content.
 *
 * @param string $content Post content (may contain HTML).
 * @param int    $wpm     Words per minute. Default 200.
 * @return int Minutes (minimum 1).
 */
function ees_chrome_reading_time( $content, $wpm = 200 ) {
	$words = str_word_count( wp_strip_all_tags( (string) $content ) );
	return max( 1, (int) ceil( $words / max( 1, $wpm ) ) );
}

/**
 * Detect whether a post already bakes its own EES header/footer into content,
 * so we don't render the site-wide chrome twice on those pages.
 *
 * @return bool True when the current singular content already contains EES chrome.
 */
function ees_chrome_content_has_baked_chrome() {
	if ( ! is_singular() ) {
		return false;
	}

	$post = get_post();
	if ( ! $post instanceof WP_Post ) {
		return false;
	}

	// The baked Home rebuild marks its nav with data-nav="1".
	return false !== strpos( (string) $post->post_content, 'data-nav="1"' );
}
