<?php
/**
 * Plugin Name:       EES Pattern Kit
 * Plugin URI:        https://eaglesimbeye.com/
 * Description:        Case-study section patterns for eaglesimbeye.com, built from native WordPress blocks and styled to the Claude Design system — no Elementor. Adds a "EES" category to the block inserter with a case hero, overview grid, pillars, numbered method steps, results/metrics and a next-project block.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            Elizabeth Eagle-Simbeye
 * License:           GPL-2.0-or-later
 * Text Domain:       ees-patterns
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EES_PATTERNS_VERSION', '1.0.0' );
define( 'EES_PATTERNS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load pattern styles on the front end and inside the editor, so patterns look
 * the same in both places.
 */
add_action( 'enqueue_block_assets', 'ees_patterns_styles' );
function ees_patterns_styles() {
	if ( ! wp_style_is( 'ees-patterns-fonts', 'registered' ) ) {
		$fonts = 'https://fonts.googleapis.com/css2'
			. '?family=Poppins:wght@600;700'
			. '&family=Schibsted+Grotesk:wght@400;500'
			. '&family=JetBrains+Mono:wght@400;500'
			. '&display=swap';
		wp_register_style( 'ees-patterns-fonts', $fonts, array(), null );
	}
	wp_enqueue_style( 'ees-patterns-fonts' );

	wp_enqueue_style(
		'ees-patterns',
		EES_PATTERNS_URL . 'assets/ees-patterns.css',
		array( 'ees-patterns-fonts' ),
		EES_PATTERNS_VERSION
	);
}

/**
 * Register the "EES" pattern category and the case-study patterns.
 */
add_action( 'init', 'ees_patterns_register' );
function ees_patterns_register() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	register_block_pattern_category(
		'ees',
		array( 'label' => __( 'EES — Case study', 'ees-patterns' ) )
	);

	$patterns = array(
		'case-hero'    => array( __( 'Case: Hero', 'ees-patterns' ), ees_patterns_case_hero() ),
		'case-meta'    => array( __( 'Case: Overview grid', 'ees-patterns' ), ees_patterns_case_meta() ),
		'case-pillars' => array( __( 'Case: Pillars', 'ees-patterns' ), ees_patterns_case_pillars() ),
		'case-steps'   => array( __( 'Case: Method steps', 'ees-patterns' ), ees_patterns_case_steps() ),
		'case-results' => array( __( 'Case: Results / metrics', 'ees-patterns' ), ees_patterns_case_results() ),
		'case-next'    => array( __( 'Case: Next project', 'ees-patterns' ), ees_patterns_case_next() ),
	);

	foreach ( $patterns as $slug => $data ) {
		register_block_pattern(
			'ees/' . $slug,
			array(
				'title'      => $data[0],
				'categories' => array( 'ees' ),
				'content'    => $data[1],
			)
		);
	}
}

/* -------------------------------------------------------------------------
 * Pattern markup. Core blocks + EES classes; placeholder copy is editable.
 * ---------------------------------------------------------------------- */

function ees_patterns_case_hero() {
	return <<<'HTML'
<!-- wp:group {"tagName":"section","className":"ees-case-hero","layout":{"type":"default"}} -->
<section class="wp-block-group ees-case-hero"><!-- wp:image {"sizeSlug":"full","className":"ees-case-hero__bg"} -->
<figure class="wp-block-image size-full ees-case-hero__bg"><img alt=""/></figure>
<!-- /wp:image -->
<!-- wp:group {"className":"ees-case-hero__inner","layout":{"type":"constrained","contentSize":"1440px"}} -->
<div class="wp-block-group ees-case-hero__inner"><!-- wp:paragraph {"className":"ees-case-hero__eyebrow"} -->
<p class="ees-case-hero__eyebrow">Client · Experience Strategy</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1} -->
<h1>Designing confidence in a shifting landscape</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"ees-case-hero__tagline"} -->
<p class="ees-case-hero__tagline">One line on the problem you turned into a result.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"ees-case-hero__cue"} -->
<p class="ees-case-hero__cue">Scroll to explore</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
HTML;
}

function ees_patterns_case_meta() {
	$item = function ( $label, $value ) {
		return '<!-- wp:group {"className":"ees-meta-item","layout":{"type":"default"}} -->'
			. '<div class="wp-block-group ees-meta-item">'
			. '<!-- wp:paragraph {"className":"ees-meta-item__label"} --><p class="ees-meta-item__label">' . $label . '</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph {"className":"ees-meta-item__value"} --><p class="ees-meta-item__value">' . $value . '</p><!-- /wp:paragraph -->'
			. '</div><!-- /wp:group -->';
	};

	$items = $item( 'Scope', 'Experience strategy, optimisation' )
		. $item( 'Timeline', '2025' )
		. $item( 'Industry', 'Automotive' )
		. $item( 'Location', 'Europe' )
		. $item( 'My role', 'Principal, Experience Design' )
		. $item( 'Agency', 'In-house / partner' );

	return '<!-- wp:group {"tagName":"section","className":"ees-cs ees-case-meta","layout":{"type":"default"}} -->'
		. '<section class="wp-block-group ees-cs ees-case-meta">'
		. '<!-- wp:group {"className":"ees-cs__inner","layout":{"type":"default"}} -->'
		. '<div class="wp-block-group ees-cs__inner">'
		. '<!-- wp:group {"className":"ees-case-meta__grid","layout":{"type":"default"}} -->'
		. '<div class="wp-block-group ees-case-meta__grid">' . $items . '</div>'
		. '<!-- /wp:group --></div><!-- /wp:group --></section><!-- /wp:group -->';
}

function ees_patterns_case_pillars() {
	$pillar = function ( $n, $title, $desc ) {
		return '<!-- wp:group {"className":"ees-pillar","layout":{"type":"default"}} -->'
			. '<div class="wp-block-group ees-pillar">'
			. '<!-- wp:paragraph {"className":"ees-pillar__n"} --><p class="ees-pillar__n">' . $n . '</p><!-- /wp:paragraph -->'
			. '<!-- wp:heading {"level":3,"className":"ees-pillar__title"} --><h3 class="ees-pillar__title">' . $title . '</h3><!-- /wp:heading -->'
			. '<!-- wp:paragraph {"className":"ees-pillar__desc"} --><p class="ees-pillar__desc">' . $desc . '</p><!-- /wp:paragraph -->'
			. '</div><!-- /wp:group -->';
	};

	$grid = $pillar( '01', 'Confidence', 'What the customer needed to feel before committing.' )
		. $pillar( '02', 'Insight', 'The evidence that pointed the way.' )
		. $pillar( '03', 'Consistency', 'The same story across every touchpoint.' )
		. $pillar( '04', 'Evidence', 'Proof that reduced perceived risk.' )
		. $pillar( '05', 'Momentum', 'Small wins that compounded into commitment.' );

	return '<!-- wp:group {"tagName":"section","className":"ees-cs ees-case-pillars","layout":{"type":"default"}} -->'
		. '<section class="wp-block-group ees-cs ees-case-pillars">'
		. '<!-- wp:group {"className":"ees-cs__inner","layout":{"type":"default"}} -->'
		. '<div class="wp-block-group ees-cs__inner">'
		. '<!-- wp:paragraph {"className":"ees-cs__eyebrow"} --><p class="ees-cs__eyebrow"><span class="n">01</span> / Challenge</p><!-- /wp:paragraph -->'
		. '<!-- wp:heading {"className":"ees-cs__title"} --><h2 class="ees-cs__title">What success required</h2><!-- /wp:heading -->'
		. '<!-- wp:group {"className":"ees-case-pillars__grid","layout":{"type":"default"}} -->'
		. '<div class="wp-block-group ees-case-pillars__grid">' . $grid . '</div>'
		. '<!-- /wp:group --></div><!-- /wp:group --></section><!-- /wp:group -->';
}

function ees_patterns_case_steps() {
	$step = function ( $n, $title, $desc ) {
		return '<!-- wp:group {"className":"ees-step","layout":{"type":"default"}} -->'
			. '<div class="wp-block-group ees-step">'
			. '<!-- wp:paragraph {"className":"ees-step__n"} --><p class="ees-step__n">' . $n . '</p><!-- /wp:paragraph -->'
			. '<!-- wp:heading {"level":3,"className":"ees-step__title"} --><h3 class="ees-step__title">' . $title . '</h3><!-- /wp:heading -->'
			. '<!-- wp:paragraph {"className":"ees-step__desc"} --><p class="ees-step__desc">' . $desc . '</p><!-- /wp:paragraph -->'
			. '</div><!-- /wp:group -->';
	};

	$list = $step( '01', 'Analysis', 'Quantitative insight paired with experience reviews.' )
		. $step( '02', 'Hypothesis', 'Each adjustment tied to a clear, testable hypothesis.' )
		. $step( '03', 'Testing', 'Measured carefully to ensure improved confidence.' );

	return '<!-- wp:group {"tagName":"section","className":"ees-cs ees-case-steps","layout":{"type":"default"}} -->'
		. '<section class="wp-block-group ees-cs ees-case-steps">'
		. '<!-- wp:group {"className":"ees-cs__inner","layout":{"type":"default"}} -->'
		. '<div class="wp-block-group ees-cs__inner">'
		. '<!-- wp:paragraph {"className":"ees-cs__eyebrow"} --><p class="ees-cs__eyebrow"><span class="n">02</span> / Experience strategy</p><!-- /wp:paragraph -->'
		. '<!-- wp:heading {"className":"ees-cs__title"} --><h2 class="ees-cs__title">Learning through disciplined experimentation</h2><!-- /wp:heading -->'
		. '<!-- wp:group {"className":"ees-case-steps__list","layout":{"type":"default"}} -->'
		. '<div class="wp-block-group ees-case-steps__list">' . $list . '</div>'
		. '<!-- /wp:group --></div><!-- /wp:group --></section><!-- /wp:group -->';
}

function ees_patterns_case_results() {
	$metric = function ( $figure, $label ) {
		return '<!-- wp:group {"className":"ees-metric","layout":{"type":"default"}} -->'
			. '<div class="wp-block-group ees-metric">'
			. '<!-- wp:paragraph {"className":"ees-metric__figure"} --><p class="ees-metric__figure">' . $figure . '</p><!-- /wp:paragraph -->'
			. '<!-- wp:paragraph {"className":"ees-metric__label"} --><p class="ees-metric__label">' . $label . '</p><!-- /wp:paragraph -->'
			. '</div><!-- /wp:group -->';
	};

	$grid = $metric( '+37<em>%</em>', 'Lift in confident conversion across priority markets.' )
		. $metric( '2.4<em>x</em>', 'Faster path from consideration to commitment.' )
		. $metric( '9<em> markets</em>', 'One consistent experience, shipped at European scale.' );

	return '<!-- wp:group {"tagName":"section","className":"ees-cs ees-case-results","layout":{"type":"default"}} -->'
		. '<section class="wp-block-group ees-cs ees-case-results">'
		. '<!-- wp:group {"className":"ees-cs__inner","layout":{"type":"default"}} -->'
		. '<div class="wp-block-group ees-cs__inner">'
		. '<!-- wp:paragraph {"className":"ees-cs__eyebrow"} --><p class="ees-cs__eyebrow"><span class="n">03</span> / Results</p><!-- /wp:paragraph -->'
		. '<!-- wp:heading {"className":"ees-cs__title"} --><h2 class="ees-cs__title">Commercial impact through confidence</h2><!-- /wp:heading -->'
		. '<!-- wp:group {"className":"ees-case-results__grid","layout":{"type":"default"}} -->'
		. '<div class="wp-block-group ees-case-results__grid">' . $grid . '</div>'
		. '<!-- /wp:group --></div><!-- /wp:group --></section><!-- /wp:group -->';
}

function ees_patterns_case_next() {
	return <<<'HTML'
<!-- wp:group {"tagName":"section","className":"ees-cs ees-case-next","layout":{"type":"default"}} -->
<section class="wp-block-group ees-cs ees-case-next"><!-- wp:group {"className":"ees-cs__inner","layout":{"type":"default"}} -->
<div class="wp-block-group ees-cs__inner"><!-- wp:paragraph {"className":"ees-cs__eyebrow"} -->
<p class="ees-cs__eyebrow">Next project</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"className":"ees-case-next__title"} -->
<h2 class="ees-case-next__title"><a href="/work/">The next case study title</a></h2>
<!-- /wp:heading --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
HTML;
}
