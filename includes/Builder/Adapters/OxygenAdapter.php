<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class OxygenAdapter extends GenericAdapter {
 public function id():string{return'oxygen';} public function name():string{return'Oxygen';} public function type():string{return'plugin';} public function confidence():int{return 78;}
 public function is_active():bool {
  if('CT_VERSION'!=='' && (defined('CT_VERSION') || class_exists('CT_VERSION'))) return true;
  if('oxygen/functions.php'!=='' && function_exists('is_plugin_active')) { require_once ABSPATH.'wp-admin/includes/plugin.php'; if(is_plugin_active('oxygen/functions.php')) return true; }
  if(in_array('oxygen',['avada','divi','bricks','themify'],true)){ $theme=strtolower((string)wp_get_theme()->get('Name')); $sheet=strtolower((string)get_template()); if(strpos($theme,'oxygen')!==false||strpos($sheet,'oxygen')!==false)return true; }
  return false;
 }
 public function version():?string { return ('CT_VERSION'!=='' && defined('CT_VERSION')) ? (string)constant('CT_VERSION') : null; }
 public function edition():string { if('oxygen'==='elementor') return (defined('ELEMENTOR_PRO_VERSION')||class_exists('ElementorPro\\Plugin'))?'pro':'free'; return 'unknown'; }
 public function capabilities():array { return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION]); }
}
