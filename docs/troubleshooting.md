# Troubleshooting

## Agent does not read WP-KIT

Confirm `AGENTS.md` is in the project root and the WP-KIT directories are
available.

## Changes conflict with project decisions

Review `.wp-kit/ARCHITECTURE.md`, `.wp-kit/DESIGN.md`, and
`.wp-kit/REQUIREMENTS.md`.

## Local WordPress is unavailable

Confirm WAMP Apache and MySQL are running and verify the configured local URL.

## Database errors

Check database name, username, password, host, permissions, and PHP MySQL
extensions.

## PHP errors

Inspect the PHP/WordPress error log and reproduce the problem before changing
code.
