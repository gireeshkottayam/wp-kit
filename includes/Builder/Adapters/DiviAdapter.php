<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class DiviAdapter extends GenericAdapter {
 public function id():string{return'divi';} public function name():string{return'Divi';} public function type():string{return'theme';} public function confidence():int{return 90;}
 public function is_active():bool {
  if('ET_CORE_VERSION'!=='' && (defined('ET_CORE_VERSION') || class_exists('ET_CORE_VERSION'))) return true;
  if(''!=='' && function_exists('is_plugin_active')) { require_once ABSPATH.'wp-admin/includes/plugin.php'; if(is_plugin_active('')) return true; }
  if(in_array('divi',['avada','divi','bricks','themify'],true)){ $theme=strtolower((string)wp_get_theme()->get('Name')); $sheet=strtolower((string)get_template()); if(strpos($theme,'divi')!==false||strpos($sheet,'divi')!==false)return true; }
  return false;
 }
 public function version():?string { return ('ET_CORE_VERSION'!=='' && defined('ET_CORE_VERSION')) ? (string)constant('ET_CORE_VERSION') : null; }
 public function edition():string { if('divi'==='elementor') return (defined('ELEMENTOR_PRO_VERSION')||class_exists('ElementorPro\\Plugin'))?'pro':'free'; return 'unknown'; }
 public function capabilities():array { return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION]); }
}
