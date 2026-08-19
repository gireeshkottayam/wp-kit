<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class ThemifyAdapter extends GenericAdapter {
 public function id():string{return'themify';} public function name():string{return'Themify Builder';} public function type():string{return'theme';} public function confidence():int{return 70;}
 public function is_active():bool {
  if(''!=='' && (defined('') || class_exists(''))) return true;
  if(''!=='' && function_exists('is_plugin_active')) { require_once ABSPATH.'wp-admin/includes/plugin.php'; if(is_plugin_active('')) return true; }
  if(in_array('themify',['avada','divi','bricks','themify'],true)){ $theme=strtolower((string)wp_get_theme()->get('Name')); $sheet=strtolower((string)get_template()); if(strpos($theme,'themify')!==false||strpos($sheet,'themify')!==false)return true; }
  return false;
 }
 public function version():?string { return (''!=='' && defined('')) ? (string)constant('') : null; }
 public function edition():string { if('themify'==='elementor') return (defined('ELEMENTOR_PRO_VERSION')||class_exists('ElementorPro\\Plugin'))?'pro':'free'; return 'unknown'; }
 public function capabilities():array { return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION]); }
}
