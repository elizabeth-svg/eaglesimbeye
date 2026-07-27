<?php
/**
 * Front-end assets: fonts, stylesheet, script.
 *
 * @package EES_Chrome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue the chrome fonts, stylesheet and script on the front end.
 */
function ees_chrome_enqueue_assets() {
	// Google Fonts used across the EES design system.
	$fonts = 'https://fonts.googleapis.com/css2'
		. '?family=Poppins:wght@600;700'
		. '&family=Schibsted+Grotesk:wght@400;500'
		. '&family=JetBrains+Mono:wght@400;500'
		. '&family=Instrument+Serif:ital@0;1'
		. '&family=Sedgwick+Ave+Display'
		. '&display=swap';

	wp_enqueue_style( 'ees-chrome-fonts', $fonts, array(), null );

	wp_enqueue_style(
		'ees-chrome',
		EES_CHROME_URL . 'assets/ees-chrome.css',
		array( 'ees-chrome-fonts' ),
		EES_CHROME_VERSION
	);

	wp_enqueue_script(
		'ees-chrome',
		EES_CHROME_URL . 'assets/ees-chrome.js',
		array(),
		EES_CHROME_VERSION,
		true
	);
}

/**
 * Emit preconnect hints for the Google Fonts hosts.
 *
 * @param array  $urls          Resource URLs.
 * @param string $relation_type Relation type.
 * @return array
 */
add_filter( 'wp_resource_hints', 'ees_chrome_resource_hints', 10, 2 );
function ees_chrome_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}
