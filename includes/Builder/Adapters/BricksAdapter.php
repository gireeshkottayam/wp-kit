<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class BricksAdapter extends GenericAdapter {
 public function id():string{return'bricks';} public function name():string{return'Bricks';} public function type():string{return'theme';} public function confidence():int{return 88;}
 public function is_active():bool {
  if('BRICKS_VERSION'!=='' && (defined('BRICKS_VERSION') || class_exists('BRICKS_VERSION'))) return true;
  if(''!=='' && function_exists('is_plugin_active')) { require_once ABSPATH.'wp-admin/includes/plugin.php'; if(is_plugin_active('')) return true; }
  if(in_array('bricks',['avada','divi','bricks','themify'],true)){ $theme=strtolower((string)wp_get_theme()->get('Name')); $sheet=strtolower((string)get_template()); if(strpos($theme,'bricks')!==false||strpos($sheet,'bricks')!==false)return true; }
  return false;
 }
 public function version():?string { return ('BRICKS_VERSION'!=='' && defined('BRICKS_VERSION')) ? (string)constant('BRICKS_VERSION') : null; }
 public function edition():string { if('bricks'==='elementor') return (defined('ELEMENTOR_PRO_VERSION')||class_exists('ElementorPro\\Plugin'))?'pro':'free'; return 'unknown'; }
 public function capabilities():array { return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION]); }
}
