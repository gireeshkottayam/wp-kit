<?php
namespace WPKit\Builder;
if (!defined('ABSPATH')) exit;
final class BuilderCapabilities {
    public const CONTENT_READ='content_read'; public const CONTENT_WRITE='content_write';
    public const METADATA_READ='metadata_read'; public const METADATA_WRITE='metadata_write';
    public const SEO_ANALYSIS='seo_analysis'; public const SCHEMA='schema';
    public const HEADING_ANALYSIS='heading_analysis'; public const IMAGE_ANALYSIS='image_analysis';
    public const INTERNAL_LINK_ANALYSIS='internal_link_analysis'; public const TEMPLATE_DETECTION='template_detection';
    public const GLOBAL_STYLE_DETECTION='global_style_detection'; public const DYNAMIC_CONTENT_DETECTION='dynamic_content_detection';
    public const PERFORMANCE_ANALYSIS='performance_analysis';
}
