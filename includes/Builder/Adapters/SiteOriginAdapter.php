<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class SiteOriginAdapter extends GenericAdapter {
 public function id():string{return'siteorigin';} public function name():string{return'SiteOrigin Page Builder';} public function type():string{return'plugin';} public function confidence():int{return 72;}
 public function is_active():bool {
  if('SITEORIGIN_PANELS_VERSION'!=='' && (defined('SITEORIGIN_PANELS_VERSION') || class_exists('SITEORIGIN_PANELS_VERSION'))) return true;
  if('siteorigin-panels/siteorigin-panels.php'!=='' && function_exists('is_plugin_active')) { require_once ABSPATH.'wp-admin/includes/plugin.php'; if(is_plugin_active('siteorigin-panels/siteorigin-panels.php')) return true; }
  if(in_array('siteorigin',['avada','divi','bricks','themify'],true)){ $theme=strtolower((string)wp_get_theme()->get('Name')); $sheet=strtolower((string)get_template()); if(strpos($theme,'siteorigin')!==false||strpos($sheet,'siteorigin')!==false)return true; }
  return false;
 }
 public function version():?string { return ('SITEORIGIN_PANELS_VERSION'!=='' && defined('SITEORIGIN_PANELS_VERSION')) ? (string)constant('SITEORIGIN_PANELS_VERSION') : null; }
 public function edition():string { if('siteorigin'==='elementor') return (defined('ELEMENTOR_PRO_VERSION')||class_exists('ElementorPro\\Plugin'))?'pro':'free'; return 'unknown'; }
 public function capabilities():array { return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION]); }
}
