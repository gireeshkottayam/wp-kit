<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderAdapterInterface; use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class GenericAdapter implements BuilderAdapterInterface {
 public function id():string{return'generic';} public function name():string{return'Generic WordPress';} public function type():string{return'core';}
 public function version():?string{return get_bloginfo('version')?:null;} public function edition():string{return'free';} public function is_active():bool{return true;} public function confidence():int{return 20;}
 public function capabilities():array{return [BuilderCapabilities::CONTENT_READ,BuilderCapabilities::METADATA_READ,BuilderCapabilities::SEO_ANALYSIS,BuilderCapabilities::HEADING_ANALYSIS,BuilderCapabilities::IMAGE_ANALYSIS,BuilderCapabilities::INTERNAL_LINK_ANALYSIS,BuilderCapabilities::PERFORMANCE_ANALYSIS];}
 public function supports(string $capability):bool{return in_array($capability,$this->capabilities(),true);} public function get_content(int $post_id){return get_post_field('post_content',$post_id);} public function update_content(int $post_id,$content){return new \WP_Error('unsupported','Generic adapter does not write builder content.');} public function get_metadata(int $post_id):array{return[];}
}
