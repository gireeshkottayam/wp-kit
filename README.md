# WP Kit v1.0.2

**WP Kit — Builder Compatibility + Site Doctor Agent**

WP Kit is a modular WordPress toolkit designed to understand the website environment, work across major builders and provide evidence-based website health and launch-readiness checks.

## v1.0.2 — Site Doctor Agent

The Site Doctor Agent turns WP Kit into a practical website audit and launch-readiness layer.

Go to:

```text
WordPress Dashboard → Tools → WP Kit Site Doctor
```

Run **Run Full Scan** to inspect the site and receive an overall score, category scores and actionable issues.

### Audit engines

- SEO
- AI Search Readiness
- Performance
- Security
- Accessibility
- Mobile
- Links
- Images
- WordPress configuration
- Launch readiness

### Safety model

Every issue is classified by severity and risk. The current release is intentionally audit-first: it does **not** blindly modify security, search visibility, server configuration, redirects, caching systems or content.

The architecture is prepared for future safe-fix workflows with verification and rollback.

## v1.0.1 — Builder Compatibility Agent

Supported detection/adapter foundation includes Gutenberg, Elementor, Elementor Pro detection, Avada, Divi, WPBakery, Bricks, Breakdance, Beaver Builder, Oxygen, Brizy, SiteOrigin, Themify, Thrive Architect, Spectra, Kadence Blocks and GenerateBlocks.

Builder-specific behavior is isolated behind `BuilderAdapterInterface`, allowing Site Doctor and future WP Kit features to consume capabilities rather than hard-code builder conditions.

## Development

```bash
git status
git pull
```

After changes:

```bash
git diff
git add .
git commit -m "Describe your change"
git push
```

For a tagged release:

```bash
git fetch --tags
git tag -a v1.0.2 -m "WP Kit v1.0.2"
git push origin v1.0.2
```

## Antigravity + OpenCode

Open the repository in Antigravity, open its terminal, update the repository, then launch OpenCode from the project directory.

```bash
cd wp-content/plugins/wp-kit

git status
git pull

opencode
```

Always review AI-generated changes before committing:

```bash
git diff
git status
```

## Requirements

- WordPress 6.0+
- PHP 7.4+

The code follows WordPress plugin security and API practices. urlWordPress Plugin Developer Handbookhttps://developer.wordpress.org/plugins/

## Important limitations

A Site Doctor score is an audit aid, not a guarantee of Google rankings, AI-search visibility, security, WCAG compliance or Core Web Vitals. External lab/field performance data may require dedicated tools or real-user data.

`llms.txt` is not treated as a Google Search requirement.

## License

GPL-2.0-or-later.
