/**
 * EES Chrome — progressive enhancement for the header and article.
 * No dependencies. Everything degrades to a working static page.
 */
(function () {
	"use strict";

	var reduce =
		window.matchMedia &&
		window.matchMedia("(prefers-reduced-motion: reduce)").matches;

	function ready(fn) {
		if (document.readyState !== "loading") {
			fn();
		} else {
			document.addEventListener("DOMContentLoaded", fn);
		}
	}

	ready(function () {
		var nav = document.querySelector("[data-ees-nav]");

		/* Mobile menu toggle -------------------------------------------------- */
		if (nav) {
			var toggle = nav.querySelector(".ees-nav__toggle");
			if (toggle) {
				toggle.addEventListener("click", function () {
					var open = nav.classList.toggle("is-open");
					toggle.setAttribute("aria-expanded", open ? "true" : "false");
				});

				// Close the menu after following a link.
				nav.querySelectorAll(".ees-nav__link").forEach(function (link) {
					link.addEventListener("click", function () {
						nav.classList.remove("is-open");
						toggle.setAttribute("aria-expanded", "false");
					});
				});
			}

			/* Scrolled state -------------------------------------------------- */
			var onScroll = function () {
				if (window.scrollY > 24) {
					nav.classList.add("is-scrolled");
				} else {
					nav.classList.remove("is-scrolled");
				}
			};
			onScroll();
			window.addEventListener("scroll", onScroll, { passive: true });
		}

		/* Reading progress bar (article pages only) --------------------------- */
		var article = document.querySelector(".ees-article__body");
		if (article && !reduce) {
			var bar = document.createElement("div");
			bar.className = "ees-progress";
			document.body.appendChild(bar);

			var update = function () {
				var rect = article.getBoundingClientRect();
				var total = rect.height - window.innerHeight;
				var scrolled = Math.min(Math.max(-rect.top, 0), Math.max(total, 0));
				var pct = total > 0 ? scrolled / total : 0;
				bar.style.width = (pct * 100).toFixed(2) + "%";
			};
			update();
			window.addEventListener("scroll", update, { passive: true });
			window.addEventListener("resize", update, { passive: true });
		}
	});
})();
