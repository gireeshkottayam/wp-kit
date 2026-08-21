# Changelog

## 1.0.3 — Developer Doctor Agent

### Added
- Developer Doctor Agent for WordPress developers.
- Debug log scanning for PHP fatal, parse, warning, notice, and deprecation signals.
- Runtime capture for fatal shutdowns, deprecated hooks, and `doing_it_wrong` calls.
- Environment diagnostics for PHP, WordPress, debug configuration, and memory limits.
- Component diagnostics for development/beta plugin builds and theme version metadata.
- Root-cause-oriented source classification for plugin, theme, WordPress core, and external/server files.
- Redacted incident evidence to reduce accidental exposure of tokens, passwords, API keys, and authorization values.
- Developer incident bundle copy workflow.
- Admin dashboard at **Tools → WP Kit Developer Doctor**.

### Design goals
- Complement Query Monitor rather than replace it.
- Audit first; never silently modify production code or configuration.
- Keep the AI layer optional: the deterministic incident bundle can be supplied to an AI coding agent such as OpenCode for diagnosis and patch planning.
- Remain compatible with the existing Builder Compatibility Agent and Site Doctor Agent.

## 1.0.2 — Site Doctor Agent
- Website health and launch-readiness audit foundation.

## 1.0.1 — Builder Compatibility Agent
- Multi-builder detection and adapter architecture.
