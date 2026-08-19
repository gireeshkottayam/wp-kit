# WP Kit

**The Ultimate WordPress Toolkit**

WP Kit is a modular WordPress toolkit designed to provide powerful utilities, automation, optimization, and developer-focused tools from a single WordPress plugin.

The project is designed with an extensible architecture so new features, integrations, and compatibility agents can be added without affecting the WP Kit core.

---

## 🚀 Current Version

**WP Kit v1.0.1**

### v1.0.1 — Builder Compatibility Agent

The v1.0.1 release introduces the Builder Compatibility Agent, providing the foundation for compatibility with major WordPress builders and editors.

Supported builder detection includes:

* Gutenberg / WordPress Block Editor
* Elementor
* Elementor Pro
* Avada / Avada Builder
* Divi
* WPBakery
* Bricks
* Breakdance
* Beaver Builder
* Oxygen
* Brizy
* SiteOrigin
* Themify
* Thrive Architect
* Spectra
* Kadence Blocks
* GenerateBlocks

The architecture is adapter-based and designed to allow additional builders to be integrated without modifying WP Kit Core.

---

# 📦 Installation

There are two recommended ways to install WP Kit.

## Method 1 — Install from WordPress

1. Download the latest WP Kit release ZIP from the GitHub Releases section.
2. Log in to WordPress.
3. Go to:

```text
WordPress Dashboard
→ Plugins
→ Add New Plugin
→ Upload Plugin
```

4. Select the WP Kit ZIP file.
5. Click **Install Now**.
6. Activate WP Kit.

After activation, WP Kit will initialize its core modules automatically.

---

# 💻 Method 2 — Install Using Terminal

This method is recommended for developers working with **Antigravity, OpenCode, Git, or a local WordPress development environment**.

## Requirements

Make sure the following are installed:

* Git
* PHP 7.4 or newer
* WordPress 6.0 or newer
* A working WordPress installation
* Terminal access

Check Git:

```bash
git --version
```

Check PHP:

```bash
php -v
```

---

# 🧩 Using Antigravity Terminal

Open your WP Kit project in **Antigravity**.

Open the integrated terminal:

```text
Terminal → New Terminal
```

Navigate to the directory where your WordPress plugin is located.

Example:

```bash
cd wp-content/plugins
```

Clone WP Kit:

```bash
git clone https://github.com/YOUR-GITHUB-USERNAME/wp-kit.git wp-kit
```

Replace:

```text
YOUR-GITHUB-USERNAME
```

with the actual GitHub account or organization containing the WP Kit repository.

Enter the WP Kit directory:

```bash
cd wp-kit
```

Check the current branch:

```bash
git branch
```

Check the current version:

```bash
git status
```

After cloning, activate WP Kit from:

```text
WordPress Dashboard
→ Plugins
→ Installed Plugins
→ WP Kit
→ Activate
```

---

# 🤖 Using OpenCode

Open your WP Kit project in **OpenCode**.

Open the terminal available in your development environment.

If WP Kit has not been downloaded:

```bash
cd wp-content/plugins
```

Then:

```bash
git clone https://github.com/YOUR-GITHUB-USERNAME/wp-kit.git wp-kit
```

Enter the project:

```bash
cd wp-kit
```

Start OpenCode from the project directory:

```bash
opencode
```

OpenCode should now work against the WP Kit repository.

### Recommended OpenCode workflow

Before making changes:

```bash
git status
```

Then:

```bash
git pull
```

After making changes:

```bash
git status
```

Review the changes before committing.

---

# 🔄 Updating WP Kit

Always update WP Kit from the repository instead of manually replacing individual files.

Open the terminal and navigate to your WP Kit installation:

```bash
cd wp-content/plugins/wp-kit
```

Check the current status:

```bash
git status
```

If you have no uncommitted changes, update WP Kit:

```bash
git pull
```

Git will download the latest changes from the repository.

After updating, check:

```bash
git status
```

You should see:

```text
Your branch is up to date with 'origin/main'.
```

---

# 🔄 Updating from a Specific Release

If WP Kit uses release tags, you can update to a specific version.

First fetch the latest releases:

```bash
git fetch --tags
```

List available versions:

```bash
git tag
```

Example:

```text
v1.0.0
v1.0.1
v1.0.2
```

To switch to a specific version:

```bash
git checkout v1.0.1
```

Check the current version:

```bash
git describe --tags
```

---

# ⚠️ Before Updating

If you have modified WP Kit source files locally, **do not immediately run `git pull`**.

First check:

```bash
git status
```

If you see modified files, review them.

You can temporarily store your changes:

```bash
git stash
```

Then update:

```bash
git pull
```

Restore your changes:

```bash
git stash pop
```

If Git reports conflicts, do not overwrite files blindly. Review the conflicting files before continuing.

---

# 🛠️ Development Workflow

The recommended development workflow is:

```bash
git pull
```

Make your changes using Antigravity or OpenCode.

Then:

```bash
git status
```

Review changed files:

```bash
git diff
```

Test the changes in your WordPress development environment.

Then stage the changes:

```bash
git add .
```

Commit:

```bash
git commit -m "Describe your change"
```

Push:

```bash
git push
```

---

# 🧪 Recommended Testing Before Commit

Before committing a WP Kit change, verify:

### WordPress

* WordPress loads correctly.
* WP Kit activates without errors.
* WP Kit deactivates correctly.
* No PHP fatal errors occur.
* Existing WordPress functionality continues to work.

### Builder Compatibility

If the change affects the Builder Compatibility Agent, test the relevant builder.

For example:

```text
Gutenberg
Elementor
Elementor Pro
Avada
Divi
WPBakery
Bricks
Breakdance
Beaver Builder
```

Do not mark a builder as fully supported until the functionality has been tested with a real installation.

---

# 🧠 Builder Compatibility Agent

WP Kit uses an adapter architecture for builder compatibility.

The architecture is:

```text
WP Kit Core
    │
    └── Builder Manager
          │
          ├── Builder Detector
          │
          ├── Builder Registry
          │
          ├── Compatibility Manager
          │
          └── Builder Adapters
                │
                ├── Gutenberg
                ├── Elementor
                ├── Avada
                ├── Divi
                ├── WPBakery
                ├── Bricks
                ├── Breakdance
                ├── Beaver Builder
                └── Other Builders
```

Builder-specific code should remain inside its adapter.

Do not add Elementor-specific logic directly into WP Kit Core.

---

# 🔌 Adding a New Builder

New builders should be added through the adapter system.

Create a new adapter implementing:

```php
WPKit\Builder\BuilderAdapterInterface
```

Example:

```php
class MyBuilderAdapter implements \WPKit\Builder\BuilderAdapterInterface
{
    public function id(): string
    {
        return 'my-builder';
    }

    public function name(): string
    {
        return 'My Builder';
    }

    // Implement the remaining interface methods.
}
```

Register the adapter:

```php
\WPKit\Builder\BuilderRegistry::register(
    'my-builder',
    MyBuilderAdapter::class
);
```

Do not modify existing adapters unless the change specifically applies to that builder.

---

# 🧩 Capability-Based Compatibility

WP Kit does not simply determine whether a builder is installed.

Each adapter can expose individual capabilities.

Examples:

```text
content_read
content_write
metadata_read
metadata_write
seo_analysis
schema
heading_analysis
image_analysis
internal_link_analysis
template_detection
global_style_detection
dynamic_content_detection
performance_analysis
```

A feature should first check whether the active adapter supports the required capability.

Example:

```php
if ($adapter->supports('seo_analysis')) {
    // Run SEO analysis.
}
```

If a capability is unavailable, WP Kit should gracefully skip the operation rather than breaking the site.

---

# 🔐 Security

All WP Kit development must follow WordPress security standards.

Always:

* Validate input.
* Sanitize input.
* Escape output.
* Use WordPress nonces.
* Check user capabilities.
* Avoid executing untrusted data.
* Never modify WordPress core.
* Never modify builder plugin files.
* Never modify theme files unnecessarily.
* Avoid direct database manipulation when a WordPress API is available.

---

# ⚡ Performance

WP Kit should remain lightweight.

Avoid:

* Loading every builder integration on every request.
* Scanning the entire WordPress database unnecessarily.
* Running expensive compatibility checks on every page load.
* Loading admin-only functionality on the frontend.

Use:

* Lazy loading.
* Capability checks.
* WordPress object caching where appropriate.
* Transients when suitable.
* Conditional loading.

---

# 🌿 Git Branching

The `main` branch should contain stable code.

For development, create a separate branch:

```bash
git checkout -b feature/my-feature
```

Example:

```bash
git checkout -b feature/builder-compatibility
```

After development:

```bash
git add .
git commit -m "Add builder compatibility support"
git push -u origin feature/builder-compatibility
```

Review and merge the branch into `main` when testing is complete.

---

# 🏷️ Creating a New Release

When a new version is ready:

Update the WP Kit version number in the appropriate plugin/version files.

Example:

```text
1.0.1 → 1.0.2
```

Commit:

```bash
git add .
git commit -m "Prepare WP Kit v1.0.2"
```

Push:

```bash
git push
```

Create the Git tag:

```bash
git tag -a v1.0.2 -m "WP Kit v1.0.2"
```

Push the tag:

```bash
git push origin v1.0.2
```

Then create the GitHub Release using:

```text
v1.0.2
```

Use the corresponding changelog/release notes for the release.

---

# 📥 Updating an Existing Development Installation

For an existing Git-based installation:

```bash
cd wp-content/plugins/wp-kit
```

Then:

```bash
git status
git pull
```

If you are using a specific release:

```bash
git fetch --tags
git checkout v1.0.2
```

Restart/reload your local WordPress environment if required.

Then verify:

```text
WordPress Dashboard
→ Plugins
→ WP Kit
```

and confirm that the expected version is active.

---

# 🤖 Antigravity + OpenCode Recommended Workflow

When developing WP Kit using Antigravity and OpenCode:

```text
1. Open project in Antigravity
        ↓
2. Open Terminal
        ↓
3. git status
        ↓
4. git pull
        ↓
5. Start OpenCode
        ↓
6. Give OpenCode the required development task
        ↓
7. Review generated changes
        ↓
8. Test WordPress
        ↓
9. git diff
        ↓
10. git add .
        ↓
11. git commit
        ↓
12. git push
        ↓
13. Create release when ready
```

### Important

Do not allow an AI coding agent to blindly overwrite the entire WP Kit project.

Before accepting major changes:

```bash
git status
```

and:

```bash
git diff
```

Always review important architectural, security, database, and builder compatibility changes.

---

# 🆘 Recovering From a Bad Local Change

If you have local changes that you do not want to keep and the changes have **not been committed**, you can restore the working tree:

```bash
git restore .
```

⚠️ This permanently removes uncommitted modifications.

To see what will be changed before restoring:

```bash
git diff
```

If you have already committed the change, use Git history to identify the correct commit before reverting.

---

# 📁 Project Structure

The WP Kit Builder Compatibility Agent follows this structure:

```text
wp-kit/
│
├── includes/
│   └── Builder/
│       ├── BuilderAdapterInterface.php
│       ├── BuilderCapabilities.php
│       ├── BuilderDetector.php
│       ├── BuilderRegistry.php
│       ├── CompatibilityManager.php
│       │
│       └── Adapters/
│           ├── GenericAdapter.php
│           ├── GutenbergAdapter.php
│           ├── ElementorAdapter.php
│           ├── AvadaAdapter.php
│           ├── DiviAdapter.php
│           ├── WPBakeryAdapter.php
│           ├── BricksAdapter.php
│           ├── BreakdanceAdapter.php
│           ├── BeaverBuilderAdapter.php
│           └── ...
│
├── README.md
├── CHANGELOG.md
└── wp-kit-builder-agent.php
```

---

# 📜 License

WP Kit is released under the GNU General Public License v2.0 or later unless otherwise specified by individual components.

See the `LICENSE` file for details.

---

# ❤️ Contributing

Contributions, bug reports, compatibility reports, and feature suggestions are welcome.

Before submitting a builder compatibility contribution, provide:

* Builder name
* Builder version
* WordPress version
* PHP version
* WP Kit version
* Expected behavior
* Actual behavior
* Steps to reproduce
* Relevant error messages

---

# ⚠️ Important Development Notice

WP Kit is intended to become a broad WordPress toolkit with compatibility across multiple builders.

Do not introduce builder-specific assumptions into the WP Kit Core.

The long-term architecture should remain:

```text
WP Kit Core
      ↓
Compatibility Layer
      ↓
Builder Detection
      ↓
Builder Adapter
      ↓
Builder Capabilities
      ↓
WP Kit Feature
```

This approach allows WP Kit to grow while maintaining compatibility, stability, performance, and a clean upgrade path.

---

## Current Release

**WP Kit v1.0.1**

**Feature:** Builder Compatibility Agent

**Status:** Compatibility Foundation

**Previous Release:** v1.0.0
