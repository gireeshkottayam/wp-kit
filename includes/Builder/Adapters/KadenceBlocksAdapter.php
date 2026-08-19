<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class KadenceBlocksAdapter extends GenericAdapter {
 public function id():string{return'kadence-blocks';} public function name():string{return'Kadence Blocks';} public function type():string{return'plugin';} public function confidence():int{return 68;}
 public function is_active():bool {
  if('KADENCE_BLOCKS_VERSION'!=='' && (defined('KADENCE_BLOCKS_VERSION') || class_exists('KADENCE_BLOCKS_VERSION'))) return true;
  if('kadence-blocks/kadence-blocks.php'!=='' && function_exists('is_plugin_active')) { require_once ABSPATH.'wp-admin/includes/plugin.php'; if(is_plugin_active('kadence-blocks/kadence-blocks.php')) return true; }
  if(in_array('kadence-blocks',['avada','divi','bricks','themify'],true)){ $theme=strtolower((string)wp_get_theme()->get('Name')); $sheet=strtolower((string)get_template()); if(strpos($theme,'kadence-blocks')!==false||strpos($sheet,'kadence-blocks')!==false)return true; }
  return false;
 }
 public function version():?string { return ('KADENCE_BLOCKS_VERSION'!=='' && defined('KADENCE_BLOCKS_VERSION')) ? (string)constant('KADENCE_BLOCKS_VERSION') : null; }
 public function edition():string { if('kadence-blocks'==='elementor') return (defined('ELEMENTOR_PRO_VERSION')||class_exists('ElementorPro\\Plugin'))?'pro':'free'; return 'unknown'; }
 public function capabilities():array { return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION]); }
}
