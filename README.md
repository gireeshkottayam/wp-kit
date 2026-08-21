# WP Kit

**The Ultimate WordPress Toolkit**

WP Kit is a modular WordPress toolkit for developers, agencies and site owners.

## Current Version

**v1.0.3 — Developer Doctor Agent**

### What is Developer Doctor?

Developer Doctor is a developer-focused diagnostic agent that helps find runtime failures and compatibility risks without requiring a developer to manually dig through several logs and configuration screens.

It can inspect:

- PHP fatal and parse errors in `wp-content/debug.log`
- PHP warnings and deprecations
- Deprecated WordPress hooks
- `doing_it_wrong` notices
- Fatal errors captured from recent requests while WP Kit is active
- PHP and WordPress runtime versions
- Debug configuration
- PHP memory limit
- Development/beta plugin builds
- Theme version metadata
- Responsible component classification where the file path is available

### Why it exists

Query Monitor remains an excellent developer toolbox. WP Kit does not attempt to replace it. Developer Doctor adds a different layer: **incident triage and an AI-ready incident bundle** that can be copied into OpenCode or another coding assistant for diagnosis and patch planning.

### Workflow

```text
Developer Doctor
      ↓
Collect evidence
      ↓
Classify severity
      ↓
Identify likely component
      ↓
Redact secrets
      ↓
Copy incident bundle
      ↓
OpenCode / AI diagnosis
      ↓
Developer reviews patch
      ↓
Test in staging
```

Developer Doctor does **not** automatically edit PHP files, disable plugins, change server configuration, or apply risky fixes.

## Install / Update with Git

From your WordPress plugin directory:

```bash
cd wp-content/plugins
```

For a new installation:

```bash
git clone https://github.com/gireeshkottayam/wp-kit.git wp-kit
cd wp-kit
git checkout v1.0.3
```

For an existing Git installation:

```bash
cd wp-content/plugins/wp-kit
git status
git fetch --tags
git checkout v1.0.3
```

Or update the development branch:

```bash
git pull
```

Always review local changes with `git status` before updating.

## Antigravity + OpenCode

Open the WP Kit repository in Antigravity, open the terminal, and verify the working tree:

```bash
git status
git fetch --tags
git checkout v1.0.3
```

Then launch OpenCode from the repository:

```bash
opencode
```

Recommended workflow:

```text
Review → Diagnose → Patch → Test → git diff → Commit → Push
```

Do not let an AI coding agent blindly overwrite the repository. Review security, database, architecture and compatibility changes before committing.

## Existing Agents

### v1.0.1 — Builder Compatibility Agent

Provides the adapter foundation for Gutenberg, Elementor, Avada, Divi, WPBakery, Bricks, Breakdance, Beaver Builder, Oxygen, Brizy, SiteOrigin, Themify, Thrive Architect, Spectra, Kadence Blocks, GenerateBlocks and a generic WordPress fallback.

### v1.0.2 — Site Doctor Agent

Provides website health and launch-readiness auditing across SEO, AI Search Readiness, performance, security, accessibility, mobile, links, images and WordPress configuration.

### v1.0.3 — Developer Doctor Agent

Adds developer-focused runtime diagnostics and AI-ready incident triage.

## Safety

Developer Doctor is audit-first. It does not:

- edit PHP source automatically
- delete plugins/themes/content
- change DNS
- change PHP versions
- disable security plugins
- change database credentials
- modify server configuration

Important fixes should be reviewed and tested in staging.

## License

GPL-2.0-or-later.
