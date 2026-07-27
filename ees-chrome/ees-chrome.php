<?php
/**
 * Plugin Name:       EES Chrome
 * Plugin URI:        https://eaglesimbeye.com/
 * Description:        Site-wide header, footer and a blog-article template for eaglesimbeye.com, rendered natively (no Elementor). Reproduces the Claude Design system chrome and applies it across the whole site through wp_body_open / wp_footer, plus a styled single-post template.
 * Version:           1.0.1
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            Elizabeth Eagle-Simbeye
 * License:           GPL-2.0-or-later
 * Text Domain:       ees-chrome
 *
 * This plugin is intentionally theme-independent: it hooks the standard
 * wp_body_open and wp_footer actions, so it works on the current classic
 * BlankSlate theme today and will keep working if the site later moves to a
 * block theme. It carries its own markup and styles and does not depend on
 * Elementor or on the EES Sections plugin.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

define( 'EES_CHROME_VERSION', '1.0.1' );
define( 'EES_CHROME_FILE', __FILE__ );
define( 'EES_CHROME_DIR', plugin_dir_path( __FILE__ ) );
define( 'EES_CHROME_URL', plugin_dir_url( __FILE__ ) );

require_once EES_CHROME_DIR . 'inc/helpers.php';
require_once EES_CHROME_DIR . 'inc/chrome.php';
require_once EES_CHROME_DIR . 'inc/templates.php';
require_once EES_CHROME_DIR . 'inc/assets.php';

/**
 * Boot the plugin once WordPress is ready.
 */
add_action( 'init', 'ees_chrome_boot' );
function ees_chrome_boot() {
	// Fonts + stylesheet + script for the chrome and the article template.
	add_action( 'wp_enqueue_scripts', 'ees_chrome_enqueue_assets' );

	// Site-wide header, injected right after <body> opens.
	add_action( 'wp_body_open', 'ees_chrome_render_header', 5 );

	// Site-wide footer, injected just before </body>.
	add_action( 'wp_footer', 'ees_chrome_render_footer', 5 );

	// Native blog-article template for single posts.
	add_filter( 'single_template', 'ees_chrome_single_template' );

	// Tag the <body> so our CSS can scope safely.
	add_filter( 'body_class', 'ees_chrome_body_class' );
}

/**
 * Add a marker class to <body> for scoped styling.
 *
 * @param string[] $classes Existing body classes.
 * @return string[]
 */
function ees_chrome_body_class( $classes ) {
	$classes[] = 'ees-chrome-active';
	return $classes;
}
