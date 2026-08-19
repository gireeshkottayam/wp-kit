<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class GenerateBlocksAdapter extends GenericAdapter {
 public function id():string{return'generateblocks';} public function name():string{return'GenerateBlocks';} public function type():string{return'plugin';} public function confidence():int{return 68;}
 public function is_active():bool {
  if('GENERATEBLOCKS_VERSION'!=='' && (defined('GENERATEBLOCKS_VERSION') || class_exists('GENERATEBLOCKS_VERSION'))) return true;
  if('generateblocks/plugin.php'!=='' && function_exists('is_plugin_active')) { require_once ABSPATH.'wp-admin/includes/plugin.php'; if(is_plugin_active('generateblocks/plugin.php')) return true; }
  if(in_array('generateblocks',['avada','divi','bricks','themify'],true)){ $theme=strtolower((string)wp_get_theme()->get('Name')); $sheet=strtolower((string)get_template()); if(strpos($theme,'generateblocks')!==false||strpos($sheet,'generateblocks')!==false)return true; }
  return false;
 }
 public function version():?string { return ('GENERATEBLOCKS_VERSION'!=='' && defined('GENERATEBLOCKS_VERSION')) ? (string)constant('GENERATEBLOCKS_VERSION') : null; }
 public function edition():string { if('generateblocks'==='elementor') return (defined('ELEMENTOR_PRO_VERSION')||class_exists('ElementorPro\\Plugin'))?'pro':'free'; return 'unknown'; }
 public function capabilities():array { return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION]); }
}
