<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class BrizyAdapter extends GenericAdapter {
 public function id():string{return'brizy';} public function name():string{return'Brizy';} public function type():string{return'plugin';} public function confidence():int{return 78;}
 public function is_active():bool {
  if('BRIZY_VERSION'!=='' && (defined('BRIZY_VERSION') || class_exists('BRIZY_VERSION'))) return true;
  if('brizy/brizy.php'!=='' && function_exists('is_plugin_active')) { require_once ABSPATH.'wp-admin/includes/plugin.php'; if(is_plugin_active('brizy/brizy.php')) return true; }
  if(in_array('brizy',['avada','divi','bricks','themify'],true)){ $theme=strtolower((string)wp_get_theme()->get('Name')); $sheet=strtolower((string)get_template()); if(strpos($theme,'brizy')!==false||strpos($sheet,'brizy')!==false)return true; }
  return false;
 }
 public function version():?string { return ('BRIZY_VERSION'!=='' && defined('BRIZY_VERSION')) ? (string)constant('BRIZY_VERSION') : null; }
 public function edition():string { if('brizy'==='elementor') return (defined('ELEMENTOR_PRO_VERSION')||class_exists('ElementorPro\\Plugin'))?'pro':'free'; return 'unknown'; }
 public function capabilities():array { return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION]); }
}
