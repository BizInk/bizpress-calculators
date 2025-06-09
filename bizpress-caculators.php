<?php
/**
 * Plugin Name: BizPress Calculators
 * Description: Display business content on your website that is automatically updated by the Bizink team.
 * Plugin URI: https://bizinkonline.com
 * Author: Bizink
 * Author URI: https://bizinkonline.com
 * Version: 1.2.7
 * Requires PHP: 7.4
 * Requires at least: 5.6
 * Text Domain: bizink-client
 * Domain Path: /languages
 * Requires Plugins: bizpress-client
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
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
$myUpdateChecker->setBranch('main');

/** Load The main plugin */
if(is_plugin_active("bizpress-client/bizink-client.php")){
	require 'calculators.php';
}