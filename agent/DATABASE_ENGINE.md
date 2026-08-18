# Database Engine

Prefer WordPress APIs when they are sufficient.

For custom SQL:

- use `$wpdb`;
- use prepared statements;
- validate identifiers and dynamic clauses;
- avoid unnecessary queries;
- consider indexes for large custom tables;
- plan migrations safely;
- never destroy production data casually.
