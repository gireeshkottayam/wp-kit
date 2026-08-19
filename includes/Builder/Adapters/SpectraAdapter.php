<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class SpectraAdapter extends GenericAdapter {
 public function id():string{return'spectra';} public function name():string{return'Spectra';} public function type():string{return'plugin';} public function confidence():int{return 70;}
 public function is_active():bool {
  if('UAGB_VERSION'!=='' && (defined('UAGB_VERSION') || class_exists('UAGB_VERSION'))) return true;
  if('ultimate-addons-for-gutenberg/ultimate-addons-for-gutenberg.php'!=='' && function_exists('is_plugin_active')) { require_once ABSPATH.'wp-admin/includes/plugin.php'; if(is_plugin_active('ultimate-addons-for-gutenberg/ultimate-addons-for-gutenberg.php')) return true; }
  if(in_array('spectra',['avada','divi','bricks','themify'],true)){ $theme=strtolower((string)wp_get_theme()->get('Name')); $sheet=strtolower((string)get_template()); if(strpos($theme,'spectra')!==false||strpos($sheet,'spectra')!==false)return true; }
  return false;
 }
 public function version():?string { return ('UAGB_VERSION'!=='' && defined('UAGB_VERSION')) ? (string)constant('UAGB_VERSION') : null; }
 public function edition():string { if('spectra'==='elementor') return (defined('ELEMENTOR_PRO_VERSION')||class_exists('ElementorPro\\Plugin'))?'pro':'free'; return 'unknown'; }
 public function capabilities():array { return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION]); }
}
