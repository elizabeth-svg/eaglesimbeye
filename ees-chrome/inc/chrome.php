<?php
/**
 * Site-wide header and footer markup.
 *
 * Ported from the EES Home design (page 9069) and trimmed for global reuse:
 * the on-page section "navigator" is dropped, the wordmark rests visible, and
 * links are generated dynamically so the same chrome works on every page.
 *
 * @package EES_Chrome
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render the fixed site header (wordmark, centre nav pill, "Get in touch").
 */
function ees_chrome_render_header() {
	// Don't double up on pages that bake their own EES nav into content.
	if ( ees_chrome_content_has_baked_chrome() ) {
		return;
	}
	if ( ! apply_filters( 'ees_chrome_show_header', true ) ) {
		return;
	}

	$links       = ees_chrome_nav_links();
	$contact_url = home_url( '/contact/' );
	?>
	<a class="ees-skip" href="#ees-main"><?php esc_html_e( 'Skip to content', 'ees-chrome' ); ?></a>

	<nav class="ees-nav" data-ees-nav aria-label="<?php esc_attr_e( 'Primary', 'ees-chrome' ); ?>">
		<a class="ees-nav__mark" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Elizabeth Eagle-Simbeye, home', 'ees-chrome' ); ?>">ees</a>

		<div class="ees-nav__center">
			<div class="ees-nav__pill">
				<?php foreach ( $links as $link ) : ?>
					<a
						class="ees-nav__link<?php echo ees_chrome_is_current( $link['url'] ) ? ' is-current' : ''; ?>"
						href="<?php echo esc_url( $link['url'] ); ?>"
						<?php echo $link['external'] ? 'target="_blank" rel="noopener"' : ''; ?>
						<?php echo ees_chrome_is_current( $link['url'] ) ? 'aria-current="page"' : ''; ?>
					><?php echo esc_html( $link['label'] ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="ees-nav__corner">
			<a class="ees-nav__cta" href="<?php echo esc_url( $contact_url ); ?>">
				<?php esc_html_e( 'Get in touch', 'ees-chrome' ); ?>
				<span class="ees-dot" aria-hidden="true"></span>
			</a>
		</div>

		<button class="ees-nav__toggle" type="button" aria-expanded="false" aria-controls="ees-nav-menu" aria-label="<?php esc_attr_e( 'Menu', 'ees-chrome' ); ?>">
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
		</button>
	</nav>
	<?php
}

/**
 * Render the site footer (statement, quick links, socials, copyright).
 */
function ees_chrome_render_footer() {
	if ( ees_chrome_content_has_baked_chrome() ) {
		return;
	}
	if ( ! apply_filters( 'ees_chrome_show_footer', true ) ) {
		return;
	}

	$quick   = ees_chrome_footer_links();
	$socials = ees_chrome_social_links();
	$glow    = apply_filters( 'ees_chrome_footer_glow', home_url( '/wp-content/uploads/2026/07/footer-480.png' ) );
	$year    = esc_html( wp_date( 'Y' ) );
	?>
	<footer class="ees-footer" data-ees-footer>
		<?php if ( $glow ) : ?>
			<img class="ees-footer__glow" src="<?php echo esc_url( $glow ); ?>" alt="" width="480" height="279" loading="lazy" decoding="async" aria-hidden="true">
		<?php endif; ?>
		<div class="ees-footer__scrim" aria-hidden="true"></div>

		<div class="ees-footer__inner">
			<div class="ees-footer__grid">
				<div class="ees-footer__lead">
					<h2 class="ees-footer__statement"><?php esc_html_e( 'Based in Manchester. Available worldwide.', 'ees-chrome' ); ?></h2>
					<a class="ees-btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
						<?php esc_html_e( 'Get in touch', 'ees-chrome' ); ?>
						<span class="ees-dot" aria-hidden="true"></span>
					</a>
				</div>

				<nav class="ees-footer__col" aria-label="<?php esc_attr_e( 'Quick links', 'ees-chrome' ); ?>">
					<p class="ees-footer__label"><?php esc_html_e( 'Quick links', 'ees-chrome' ); ?></p>
					<?php foreach ( $quick as $link ) : ?>
						<a
							class="ees-footer__link<?php echo ees_chrome_is_current( $link['url'] ) ? ' is-current' : ''; ?>"
							href="<?php echo esc_url( $link['url'] ); ?>"
							<?php echo $link['external'] ? 'target="_blank" rel="noopener"' : ''; ?>
						><?php echo esc_html( $link['label'] ); ?></a>
					<?php endforeach; ?>
				</nav>

				<nav class="ees-footer__col" aria-label="<?php esc_attr_e( 'Socials', 'ees-chrome' ); ?>">
					<p class="ees-footer__label"><?php esc_html_e( 'Socials', 'ees-chrome' ); ?></p>
					<?php foreach ( $socials as $link ) : ?>
						<a class="ees-footer__link" href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener me"><?php echo esc_html( $link['label'] ); ?></a>
					<?php endforeach; ?>
				</nav>
			</div>

			<div class="ees-footer__baseline">
				<p><?php
					/* translators: %s: current year. */
					printf( esc_html__( 'All rights reserved ©%s eaglesimbeye.com', 'ees-chrome' ), $year );
				?></p>
			</div>
		</div>
	</footer>
	<?php
}
