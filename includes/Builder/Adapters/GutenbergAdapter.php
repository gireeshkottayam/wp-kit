<?php
namespace WPKit\Builder\Adapters;
use WPKit\Builder\BuilderCapabilities;
if (!defined('ABSPATH')) exit;
class GutenbergAdapter extends GenericAdapter { public function id():string{return'gutenberg';} public function name():string{return'Gutenberg / Block Editor';} public function type():string{return'core';} public function confidence():int{return 95;} public function is_active():bool{return function_exists('register_block_type');} public function capabilities():array{return array_merge(parent::capabilities(),[BuilderCapabilities::CONTENT_WRITE,BuilderCapabilities::METADATA_WRITE,BuilderCapabilities::SCHEMA,BuilderCapabilities::TEMPLATE_DETECTION,BuilderCapabilities::GLOBAL_STYLE_DETECTION]);} }
