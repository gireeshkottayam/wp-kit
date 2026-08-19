<?php
namespace WPKit\Builder;
if (!defined('ABSPATH')) exit;
final class CompatibilityManager {
    public static function init(): void { add_action('admin_menu',[self::class,'admin_menu']); }
    public static function admin_menu(): void { add_management_page('WP Kit Builder Compatibility','WP Kit Builders','manage_options','wpkit-builder-compatibility',[self::class,'render']); }
    public static function render(): void {
        if(!current_user_can('manage_options')) wp_die(esc_html__('Permission denied.','wp-kit-builder-agent'));
        $builders=BuilderDetector::detect_site();
        echo '<div class="wrap"><h1>WP Kit Builder Compatibility</h1><p>Detected builders and compatibility capabilities.</p><table class="widefat striped"><thead><tr><th>Builder</th><th>Version</th><th>Edition</th><th>Type</th><th>Confidence</th><th>Capabilities</th></tr></thead><tbody>';
        foreach($builders as $b){ echo '<tr><td><strong>'.esc_html($b['name']).'</strong></td><td>'.esc_html($b['version']?:'Unknown').'</td><td>'.esc_html(ucfirst($b['edition'])).'</td><td>'.esc_html(ucfirst($b['type'])).'</td><td>'.esc_html($b['confidence']).'%</td><td>'.esc_html(implode(', ',$b['capabilities'])).'</td></tr>'; }
        echo '</tbody></table></div>';
    }
}
