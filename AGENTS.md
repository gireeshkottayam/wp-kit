# WP-KIT Agent Entry Point

When WP-KIT is present in a project, begin by reading:

1. `agent/SYSTEM.md`
2. `agent/IDENTITY.md`
3. `agent/OPERATING_RULES.md`
4. `agent/WORKFLOW.md`

Then identify the user's task and load only the relevant workflow and rules.

Before changing an existing WordPress project:

- inspect the existing architecture;
- inspect active themes and plugins;
- inspect relevant PHP, JavaScript, CSS, and template files;
- inspect project memory under `.wp-kit/`;
- identify dependencies and integrations;
- avoid destructive changes;
- produce an implementation plan when the task is substantial.

After implementation:

- review the changed code;
- check security;
- check performance;
- check responsive behavior;
- check accessibility;
- check SEO where relevant;
- update `.wp-kit/TODO.md`;
- update `.wp-kit/CHANGELOG.md`;
- update `.wp-kit/SESSION.md` when the session changes project state.

Never claim that a task was tested if it was not actually tested.
