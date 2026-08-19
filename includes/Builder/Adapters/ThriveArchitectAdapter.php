<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class ThriveArchitectAdapter extends GenericAdapter {
 public function id():string{return'thrive-architect';} public function name():string{return'Thrive Architect';} public function type():string{return'plugin';} public function confidence():int{return 70;}
 public function is_active():bool {
  if('TVA_VERSION'!=='' && (defined('TVA_VERSION') || class_exists('TVA_VERSION'))) return true;
  if('thrive-visual-editor/thrive-visual-editor.php'!=='' && function_exists('is_plugin_active')) { require_once ABSPATH.'wp-admin/includes/plugin.php'; if(is_plugin_active('thrive-visual-editor/thrive-visual-editor.php')) return true; }
  if(in_array('thrive-architect',['avada','divi','bricks','themify'],true)){ $theme=strtolower((string)wp_get_theme()->get('Name')); $sheet=strtolower((string)get_template()); if(strpos($theme,'thrive-architect')!==false||strpos($sheet,'thrive-architect')!==false)return true; }
  return false;
 }
 public function version():?string { return ('TVA_VERSION'!=='' && defined('TVA_VERSION')) ? (string)constant('TVA_VERSION') : null; }
 public function edition():string { if('thrive-architect'==='elementor') return (defined('ELEMENTOR_PRO_VERSION')||class_exists('ElementorPro\\Plugin'))?'pro':'free'; return 'unknown'; }
 public function capabilities():array { return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION]); }
}
