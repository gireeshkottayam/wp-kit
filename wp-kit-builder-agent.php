<?php
/**
 * Plugin Name: WP Kit Builder Agent
 * Description: Lightweight builder detection and compatibility adapter layer for WP Kit.
 * Version: 1.0.3
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: WP Kit
 * License: GPL-2.0-or-later
 */
if (!defined('ABSPATH')) exit;

define('WPKIT_BUILDER_AGENT_VERSION', '1.0.3');
define('WPKIT_BUILDER_AGENT_PATH', plugin_dir_path(__FILE__));

require_once WPKIT_BUILDER_AGENT_PATH . 'includes/Builder/BuilderAdapterInterface.php';
require_once WPKIT_BUILDER_AGENT_PATH . 'includes/Builder/BuilderCapabilities.php';
require_once WPKIT_BUILDER_AGENT_PATH . 'includes/Builder/BuilderRegistry.php';
require_once WPKIT_BUILDER_AGENT_PATH . 'includes/Builder/BuilderDetector.php';
require_once WPKIT_BUILDER_AGENT_PATH . 'includes/Builder/CompatibilityManager.php';
foreach (glob(WPKIT_BUILDER_AGENT_PATH . 'includes/Builder/Adapters/*.php') as $file) require_once $file;

require_once WPKIT_BUILDER_AGENT_PATH . 'includes/SiteDoctor/SiteDoctorIssue.php';
require_once WPKIT_BUILDER_AGENT_PATH . 'includes/SiteDoctor/SiteDoctorScanner.php';
require_once WPKIT_BUILDER_AGENT_PATH . 'includes/SiteDoctor/SiteDoctorScore.php';
require_once WPKIT_BUILDER_AGENT_PATH . 'includes/SiteDoctor/SiteDoctorManager.php';
require_once WPKIT_BUILDER_AGENT_PATH . 'includes/DeveloperDoctor/DeveloperIssue.php';
require_once WPKIT_BUILDER_AGENT_PATH . 'includes/DeveloperDoctor/DeveloperDoctorManager.php';
foreach (glob(WPKIT_BUILDER_AGENT_PATH . 'includes/SiteDoctor/Scanners/*.php') as $file) require_once $file;

add_action('plugins_loaded', static function () {
    \WPKit\Builder\BuilderRegistry::init();
    \WPKit\Builder\CompatibilityManager::init();
    \WPKit\SiteDoctor\SiteDoctorManager::init();
    \WPKit\DeveloperDoctor\DeveloperDoctorManager::init();
});
