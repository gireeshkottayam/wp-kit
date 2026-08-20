# Changelog

## 1.0.2 - Site Doctor Agent

- Added the WP Kit Site Doctor Agent for website health and launch-readiness auditing.
- Added deterministic scanners for SEO, AI Search Readiness, performance, security, accessibility, mobile, links, images, WordPress configuration and launch readiness.
- Added weighted health scoring with critical-issue launch blocking.
- Added risk classification for safe, review-required, dangerous and manual-only actions.
- Added an admin dashboard under **Tools → WP Kit Site Doctor**.
- Added on-demand full scans with cached results and AJAX refresh.
- Added compatibility-aware architecture so future scans can consume the existing Builder Compatibility Agent.
- Added plugin-aware performance/security detection without overriding third-party plugin settings.
- Added safe, evidence-based checks; no automatic dangerous changes are performed.
- Added explicit AI Search Readiness checks without treating `llms.txt` as a Google requirement.

## 1.0.1 - Builder Compatibility Foundation

- Added the WP Kit Builder Compatibility Agent foundation.
- Added automatic builder detection.
- Added adapter architecture and capability registry.
- Added compatibility adapters for major WordPress builders and block ecosystems.
- Added safe Generic WordPress fallback.
- Added site-level and post-level detection.
- Added Builder Compatibility admin screen.
- Added third-party adapter registration support.
- No changes to WordPress core, theme files, or builder files.
