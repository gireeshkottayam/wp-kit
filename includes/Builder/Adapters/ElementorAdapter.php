<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class ElementorAdapter extends GenericAdapter {
 public function id():string{return'elementor';} public function name():string{return'Elementor';} public function type():string{return'plugin';} public function confidence():int{return 95;}
 public function is_active():bool {
  if('ELEMENTOR_VERSION'!=='' && (defined('ELEMENTOR_VERSION') || class_exists('ELEMENTOR_VERSION'))) return true;
  if('elementor/elementor.php'!=='' && function_exists('is_plugin_active')) { require_once ABSPATH.'wp-admin/includes/plugin.php'; if(is_plugin_active('elementor/elementor.php')) return true; }
  if(in_array('elementor',['avada','divi','bricks','themify'],true)){ $theme=strtolower((string)wp_get_theme()->get('Name')); $sheet=strtolower((string)get_template()); if(strpos($theme,'elementor')!==false||strpos($sheet,'elementor')!==false)return true; }
  return false;
 }
 public function version():?string { return ('ELEMENTOR_VERSION'!=='' && defined('ELEMENTOR_VERSION')) ? (string)constant('ELEMENTOR_VERSION') : null; }
 public function edition():string { if('elementor'==='elementor') return (defined('ELEMENTOR_PRO_VERSION')||class_exists('ElementorPro\\Plugin'))?'pro':'free'; return 'unknown'; }
 public function capabilities():array { return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION]); }
}
