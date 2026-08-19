# WP Kit Builder Agent v1.0.0

A lightweight, extensible builder detection and compatibility foundation for WP Kit.

## Supported builders

Gutenberg / Block Editor, Elementor, Avada, Divi, WPBakery, Bricks, Breakdance, Beaver Builder, Oxygen, Brizy, SiteOrigin, Themify, Thrive Architect, Spectra, Kadence Blocks and GenerateBlocks.

## Architecture

Builder-specific behavior is isolated behind `BuilderAdapterInterface`. WP Kit Core can work with capabilities instead of builder-specific conditionals.

## API

```php
$builders = \WPKit\Builder\BuilderDetector::detect_site();
$post_builders = \WPKit\Builder\BuilderDetector::detect_post($post_id);
$adapter = \WPKit\Builder\BuilderRegistry::get('elementor');
if ($adapter && $adapter->supports('seo_analysis')) {
    // Run WP Kit analysis.
}
```

## Third-party adapters

```php
add_action('wpkit_builder_register', function () {
    \WPKit\Builder\BuilderRegistry::register('my-builder', \MyVendor\MyBuilderAdapter::class);
});
```

> Detection support is not the same as full feature support. Each builder should be tested against real installations before being advertised as fully supported.
