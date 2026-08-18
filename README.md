# WP-KIT

**WP-KIT** is an intelligent WordPress engineering agent designed to work with Antigravity, OpenCode, and compatible AI coding environments.

It helps analyze requirements, design WordPress architecture, build and improve websites, maintain project memory, audit quality, troubleshoot problems, and prepare projects for deployment.

## Quick Start

### 1. Download WP-KIT

Clone or download this repository into your development workspace.

### 2. Add WP-KIT to a WordPress project

Recommended structure:

```text
my-wordpress-site/
├── wp-admin/
├── wp-content/
├── wp-includes/
├── wp-config.php
└── .wp-kit/
```

Copy the `agent`, `rules`, `workflows`, `templates`, `scripts`, and `docs` directories from WP-KIT into your project.

### 3. Initialize project memory

Create:

```text
.wp-kit/
├── PROJECT.md
├── REQUIREMENTS.md
├── ARCHITECTURE.md
├── DESIGN.md
├── DATABASE.md
├── SEO.md
├── SECURITY.md
├── TODO.md
├── CHANGELOG.md
└── SESSION.md
```

Use the templates supplied in `templates/project-memory/`.

### 4. Open the WordPress project

Open the WordPress project folder in Antigravity or OpenCode.

The agent should read, in order:

1. `agent/SYSTEM.md`
2. `agent/IDENTITY.md`
3. `agent/OPERATING_RULES.md`
4. `agent/WORKFLOW.md`
5. the applicable workflow under `workflows/`
6. the project files under `.wp-kit/`
7. the relevant rules under `rules/`

### 5. Give the agent the task

Example:

```text
Read WP-KIT and analyze this WordPress project before making changes.

I need a premium school website with:
- responsive design
- admissions
- staff profiles
- events
- gallery
- contact forms
- SEO
- fast loading
- secure WordPress architecture

Do not start coding until you have inspected the existing project and created an implementation plan.
```

## Local WAMP Development

WP-KIT supports conventional WAMP WordPress development.

Typical location:

```text
C:\wamp64\www\my-wordpress-site
```

Typical URL:

```text
http://localhost/my-wordpress-site/
```

### Recommended setup

1. Install WAMP.
2. Start Apache.
3. Start MySQL.
4. Create a MySQL database using phpMyAdmin.
5. Install WordPress in the project directory.
6. Open the project in Antigravity or OpenCode.
7. Import/configure WP-KIT.
8. Initialize `.wp-kit` project memory.
9. Ask the agent to analyze the project.
10. Build and test locally.
11. Complete the WP-KIT quality gates before deployment.

## Updating WP-KIT

If WP-KIT is installed as a Git repository:

```powershell
git pull
```

If WP-KIT is maintained as a separate folder, update the WP-KIT directories while preserving the project's `.wp-kit/` memory.

Never overwrite project-specific memory without reviewing the changes.

## WP-KIT Project Memory

The `.wp-kit/` directory stores project-specific information.

It allows the agent to understand:

- project goals
- existing architecture
- design decisions
- database structure
- SEO requirements
- security requirements
- outstanding tasks
- previous changes
- current development session

The agent should read project memory before significant implementation work and update it after significant changes.

## Core Development Workflow

```text
Requirement
    ↓
Project Discovery
    ↓
Requirement Analysis
    ↓
Architecture
    ↓
Implementation Plan
    ↓
Development
    ↓
Self Review
    ↓
Security
    ↓
SEO
    ↓
Performance
    ↓
Accessibility
    ↓
Testing
    ↓
Documentation
    ↓
Project Memory Update
```

## Quality Standard

WP-KIT expects WordPress work to consider:

- maintainability
- security
- performance
- responsive design
- accessibility
- SEO
- semantic HTML
- clean PHP
- WordPress coding practices
- database safety
- error handling
- scalability
- user experience

## Compatibility

WP-KIT is designed to be used with:

- Antigravity
- OpenCode
- compatible AI coding agents
- terminal-based development environments
- local WAMP WordPress installations

## Repository Structure

```text
agent/       Core agent intelligence
rules/       Engineering rules
workflows/   Task-specific workflows
templates/   Project-memory templates
scripts/     Utility scripts
docs/        Usage documentation
```

## License

WP-KIT is proprietary software. Usage, redistribution, resale, and modification are subject to the license supplied with your purchase.
