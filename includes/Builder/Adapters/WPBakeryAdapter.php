<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class WPBakeryAdapter extends GenericAdapter {
 public function id():string{return'wpbakery';} public function name():string{return'WPBakery Page Builder';} public function type():string{return'plugin';} public function confidence():int{return 88;}
 public function is_active():bool {
  if('WPB_VC_VERSION'!=='' && (defined('WPB_VC_VERSION') || class_exists('WPB_VC_VERSION'))) return true;
  if('js_composer/js_composer.php'!=='' && function_exists('is_plugin_active')) { require_once ABSPATH.'wp-admin/includes/plugin.php'; if(is_plugin_active('js_composer/js_composer.php')) return true; }
  if(in_array('wpbakery',['avada','divi','bricks','themify'],true)){ $theme=strtolower((string)wp_get_theme()->get('Name')); $sheet=strtolower((string)get_template()); if(strpos($theme,'wpbakery')!==false||strpos($sheet,'wpbakery')!==false)return true; }
  return false;
 }
 public function version():?string { return ('WPB_VC_VERSION'!=='' && defined('WPB_VC_VERSION')) ? (string)constant('WPB_VC_VERSION') : null; }
 public function edition():string { if('wpbakery'==='elementor') return (defined('ELEMENTOR_PRO_VERSION')||class_exists('ElementorPro\\Plugin'))?'pro':'free'; return 'unknown'; }
 public function capabilities():array { return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION]); }
}
