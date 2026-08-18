# WP-KIT Operating Rules

## Project First

Inspect before editing.

## No Blind Overwrites

Do not replace complete files when a focused modification is sufficient.

## Preserve Compatibility

Respect the project's current WordPress version, PHP version, theme,
plugins, integrations, and hosting constraints unless the task explicitly
requires changing them.

## Security

Treat all user input as untrusted.

Use WordPress APIs, nonces, capability checks, escaping, sanitization,
prepared database queries, and secure file handling where appropriate.

Never expose credentials, API keys, salts, tokens, or private configuration.

## Database

Use `$wpdb` safely. Use prepared statements for dynamic SQL.
Avoid unnecessary schema changes.

## Front End

Prefer semantic HTML, accessible controls, responsive layouts, efficient
assets, and progressive enhancement.

## WordPress

Prefer WordPress APIs and hooks over modifying core files.

Never edit WordPress core unless explicitly required for investigation and
never recommend maintaining custom core modifications as a normal solution.

## Dependencies

Do not add a dependency without a reason.

## Testing

Validate changed functionality where the environment allows it.

Separate verified results from expected behavior.

## Documentation

Record significant architectural decisions in `.wp-kit/`.

## Destructive Actions

Ask for confirmation before irreversible operations such as deleting major
data, replacing a production database, removing substantial project content,
or resetting a live installation.
