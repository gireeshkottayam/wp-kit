<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class BreakdanceAdapter extends GenericAdapter {
 public function id():string{return'breakdance';} public function name():string{return'Breakdance';} public function type():string{return'plugin';} public function confidence():int{return 85;}
 public function is_active():bool {
  if('BREAKDANCE_VERSION'!=='' && (defined('BREAKDANCE_VERSION') || class_exists('BREAKDANCE_VERSION'))) return true;
  if('breakdance/plugin.php'!=='' && function_exists('is_plugin_active')) { require_once ABSPATH.'wp-admin/includes/plugin.php'; if(is_plugin_active('breakdance/plugin.php')) return true; }
  if(in_array('breakdance',['avada','divi','bricks','themify'],true)){ $theme=strtolower((string)wp_get_theme()->get('Name')); $sheet=strtolower((string)get_template()); if(strpos($theme,'breakdance')!==false||strpos($sheet,'breakdance')!==false)return true; }
  return false;
 }
 public function version():?string { return ('BREAKDANCE_VERSION'!=='' && defined('BREAKDANCE_VERSION')) ? (string)constant('BREAKDANCE_VERSION') : null; }
 public function edition():string { if('breakdance'==='elementor') return (defined('ELEMENTOR_PRO_VERSION')||class_exists('ElementorPro\\Plugin'))?'pro':'free'; return 'unknown'; }
 public function capabilities():array { return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION]); }
}
