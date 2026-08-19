<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class BeaverBuilderAdapter extends GenericAdapter {
 public function id():string{return'beaver-builder';} public function name():string{return'Beaver Builder';} public function type():string{return'plugin';} public function confidence():int{return 82;}
 public function is_active():bool {
  if('FL_BUILDER_VERSION'!=='' && (defined('FL_BUILDER_VERSION') || class_exists('FL_BUILDER_VERSION'))) return true;
  if('beaver-builder/fl-builder.php'!=='' && function_exists('is_plugin_active')) { require_once ABSPATH.'wp-admin/includes/plugin.php'; if(is_plugin_active('beaver-builder/fl-builder.php')) return true; }
  if(in_array('beaver-builder',['avada','divi','bricks','themify'],true)){ $theme=strtolower((string)wp_get_theme()->get('Name')); $sheet=strtolower((string)get_template()); if(strpos($theme,'beaver-builder')!==false||strpos($sheet,'beaver-builder')!==false)return true; }
  return false;
 }
 public function version():?string { return ('FL_BUILDER_VERSION'!=='' && defined('FL_BUILDER_VERSION')) ? (string)constant('FL_BUILDER_VERSION') : null; }
 public function edition():string { if('beaver-builder'==='elementor') return (defined('ELEMENTOR_PRO_VERSION')||class_exists('ElementorPro\\Plugin'))?'pro':'free'; return 'unknown'; }
 public function capabilities():array { return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION]); }
}
