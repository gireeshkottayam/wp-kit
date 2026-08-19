<?php
namespace WPKit\Builder;
if (!defined('ABSPATH')) exit;
final class BuilderRegistry {
    private static array $adapters=[]; private static bool $initialized=false;
    public static function init(): void {
        if (self::$initialized) return; self::$initialized=true;
        $defaults=[
            'generic'=>Adapters\GenericAdapter::class,'gutenberg'=>Adapters\GutenbergAdapter::class,
            'elementor'=>Adapters\ElementorAdapter::class,'avada'=>Adapters\AvadaAdapter::class,
            'divi'=>Adapters\DiviAdapter::class,'wpbakery'=>Adapters\WPBakeryAdapter::class,
            'bricks'=>Adapters\BricksAdapter::class,'breakdance'=>Adapters\BreakdanceAdapter::class,
            'beaver-builder'=>Adapters\BeaverBuilderAdapter::class,'oxygen'=>Adapters\OxygenAdapter::class,
            'brizy'=>Adapters\BrizyAdapter::class,'siteorigin'=>Adapters\SiteOriginAdapter::class,
            'themify'=>Adapters\ThemifyAdapter::class,'thrive-architect'=>Adapters\ThriveArchitectAdapter::class,
            'spectra'=>Adapters\SpectraAdapter::class,'kadence-blocks'=>Adapters\KadenceBlocksAdapter::class,
            'generateblocks'=>Adapters\GenerateBlocksAdapter::class,
        ];
        foreach($defaults as $id=>$class) self::register($id,$class);
        do_action('wpkit_builder_register');
    }
    public static function register(string $id,string $class): bool {
        if(!class_exists($class)||!is_subclass_of($class,BuilderAdapterInterface::class)) return false;
        self::$adapters[sanitize_key($id)]=$class; return true;
    }
    public static function get(string $id): ?BuilderAdapterInterface { self::init(); $id=sanitize_key($id); return isset(self::$adapters[$id]) ? new self::$adapters[$id]() : null; }
    public static function all(): array { self::init(); return self::$adapters; }
}
