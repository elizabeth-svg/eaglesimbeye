=== EES Chrome ===
Contributors: eaglesimbeye
Requires at least: 6.0
Requires PHP: 8.0
Stable tag: 1.0.0
License: GPL-2.0-or-later

Site-wide header, footer and a blog-article template for eaglesimbeye.com,
rendered natively — no Elementor, no page builder.

== What it does ==

* Renders the EES / Claude Design header (wordmark, centre nav pill, "Get in
  touch") on every page via the standard `wp_body_open` hook.
* Renders the EES footer (statement, quick links, socials, copyright) on every
  page via `wp_footer`.
* Provides a styled blog-article template for single posts (featured-image
  hero, category eyebrow, title, reading time, reading-width typography, tags,
  adjacent-post navigation and a reading-progress bar).
* Carries its own fonts, styles and a tiny vanilla script. It does NOT depend
  on Elementor or on the EES Sections plugin.

It is theme-independent: it works on the current classic BlankSlate theme today
and will keep working if the site later moves to a block theme.

== Install ==

1. WordPress admin > Plugins > Add New > Upload Plugin.
2. Upload `ees-chrome.zip` and click "Install Now", then "Activate".

== Turn OFF the Elementor header/footer (important) ==

The plugin does not remove Elementor's chrome for you, so that you can compare
before committing. Once the new header/footer look right:

1. Elementor > Templates > Theme Builder.
2. Open each Header and Footer template and either delete it or set its display
   conditions to none, so it stops rendering site-wide.
   (On this site those are "Header", "Main nav", "Site footer" and the older
   footer templates.)
3. Clear LiteSpeed Cache (LiteSpeed Cache > Toolbox > Purge All).

If you see two headers or two footers for a moment, it means an Elementor Theme
Builder template is still assigned — step 2 fixes it.

== Notes ==

* Pages that still bake their own EES nav into their content (the Home rebuild,
  which contains `data-nav="1"`) are detected automatically and the plugin skips
  its header/footer on those, so you never get a double.
* Menus and social links live in `inc/helpers.php` and are filterable:
  `ees_chrome_nav_links`, `ees_chrome_footer_links`, `ees_chrome_social_links`.
* Hide the header or footer per-request with the `ees_chrome_show_header` /
  `ees_chrome_show_footer` filters. Disable the article template with
  `ees_chrome_use_article_template`.
* The "ees" wordmark uses the Rockybilly face when the EES Sections plugin has
  loaded it, and falls back to Google's "Sedgwick Ave Display" otherwise.

== Changelog ==

= 1.0.1 =
* Footer: darkened the overlay and toned the background glow down to a faint,
  blurred texture so text contrast is reliable (WCAG) and the low-res asset no
  longer reads as pixelated.
* Footer: deliberate 3-column weighting (statement leads, links group right)
  with proper tablet/mobile stacking, removing the dead gap between columns.

= 1.0.0 =
* Initial release: site-wide header, footer and blog-article template.
