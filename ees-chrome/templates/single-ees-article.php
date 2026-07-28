<?php
/**
 * Blog article template (single post) — EES / Claude Design.
 *
 * Calls get_header() / get_footer() so the site-wide chrome (injected on
 * wp_body_open / wp_footer) renders around the article, and so wp_head /
 * wp_footer keep firing for SEO, analytics and other plugins.
 *
 * @package EES_Chrome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$cats        = get_the_category();
	$eyebrow     = ! empty( $cats ) ? $cats[0]->name : '';
	$reading     = ees_chrome_reading_time( get_the_content() );
	$has_thumb   = has_post_thumbnail();
	$thumb_url   = $has_thumb ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';
	$tags        = get_the_tags();
	$thoughts_url = home_url( '/design-thinking/' );
	?>

	<main id="ees-main" class="ees-article" role="main">

		<article <?php post_class( 'ees-article__wrap' ); ?>>

			<header class="ees-article__hero<?php echo $has_thumb ? ' has-media' : ''; ?>">
				<?php if ( $has_thumb ) : ?>
					<div class="ees-article__media">
						<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" fetchpriority="high" decoding="async">
						<div class="ees-article__media-scrim" aria-hidden="true"></div>
					</div>
				<?php endif; ?>

				<div class="ees-article__head">
					<?php if ( $eyebrow ) : ?>
						<p class="ees-article__eyebrow"><span aria-hidden="true">[</span><?php echo esc_html( $eyebrow ); ?><span aria-hidden="true">]</span></p>
					<?php endif; ?>

					<h1 class="ees-article__title"><?php the_title(); ?></h1>

					<div class="ees-article__meta">
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						<span class="ees-article__dot" aria-hidden="true">·</span>
						<span><?php
							/* translators: %d: estimated reading time in minutes. */
							printf( esc_html__( '%d min read', 'ees-chrome' ), (int) $reading );
						?></span>
					</div>
				</div>
			</header>

			<div class="ees-article__body">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="ees-article__pagination">' . esc_html__( 'Pages:', 'ees-chrome' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>

			<?php if ( $tags ) : ?>
				<div class="ees-article__tags">
					<?php foreach ( $tags as $tag ) : ?>
						<a class="ees-tag" href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"><?php echo esc_html( $tag->name ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<footer class="ees-article__cta">
				<a class="ees-btn" href="<?php echo esc_url( $thoughts_url ); ?>">
					<?php esc_html_e( 'All thoughts', 'ees-chrome' ); ?>
					<span class="ees-dot" aria-hidden="true"></span>
				</a>
			</footer>

		</article>

		<?php
		$prev = get_previous_post();
		$next = get_next_post();
		if ( $prev || $next ) :
			?>
			<nav class="ees-article__adjacent" aria-label="<?php esc_attr_e( 'More thoughts', 'ees-chrome' ); ?>">
				<?php if ( $prev ) : ?>
					<a class="ees-article__adj is-prev" href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
						<span class="ees-article__adj-label"><?php esc_html_e( 'Previous', 'ees-chrome' ); ?></span>
						<span class="ees-article__adj-title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
					</a>
				<?php endif; ?>
				<?php if ( $next ) : ?>
					<a class="ees-article__adj is-next" href="<?php echo esc_url( get_permalink( $next ) ); ?>">
						<span class="ees-article__adj-label"><?php esc_html_e( 'Next', 'ees-chrome' ); ?></span>
						<span class="ees-article__adj-title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
					</a>
				<?php endif; ?>
			</nav>
		<?php endif; ?>

	</main>

	<?php
endwhile;

get_footer();
