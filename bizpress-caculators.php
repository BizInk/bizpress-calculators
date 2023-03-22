<?php
/**
 * Plugin Name: BizPress Calculators
 * Description: Display business content on your website that is automatically updated by the Bizink team.
 * Plugin URI: https://bizinkonline.com
 * Author: Bizink
 * Author URI: https://bizinkonline.com
 * Version: 1.1
 * Requires PHP: 7.2
 * Requires at least: 5.6
 * Text Domain: bizink-client
 * Domain Path: /languages
 */

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin Updater
require 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
$myUpdateChecker = PucFactory::buildUpdateChecker('https://github.com/BizInk/bizpress-calculators',__FILE__,'bizpress-calculators');
// Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');
// Using a private repository, specify the access token 
$myUpdateChecker->setAuthentication('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');


/** Load The main plugin */
if(is_plugin_active("bizpress-client/bizink-client.php")){
	require 'calculators.php';
}