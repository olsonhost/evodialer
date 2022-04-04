<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://olson.host
 * @since             1.0.0
 * @package           Evodialer
 *
 * @wordpress-plugin
 * Plugin Name:       EvoDialer
 * Plugin URI:        https://evodialer.com
 * Description:       This plugin turns Wordpress into a Call Center PBX/IVR.
 * Version:           1.0.0
 * Author:            Erik Olson
 * Author URI:        https://olson.host
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       evodialer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EVODIALER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-evodialer-activator.php
 */
function activate_evodialer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-evodialer-activator.php';
	Evodialer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-evodialer-deactivator.php
 */
function deactivate_evodialer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-evodialer-deactivator.php';
	Evodialer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_evodialer' );
register_deactivation_hook( __FILE__, 'deactivate_evodialer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-evodialer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_evodialer() {

	$plugin = new Evodialer();
	$plugin->run();

}
run_evodialer();

function evodialer_options_page_html() {
	?>
	<div class="wrap">
		<h1>EVODIALER</h1>
		aaaaaaaaaaaaaaaaaaaaa
	</div>
	<?php
}

function evodialer_endpoint ( WP_REST_Request $request) {
	return "Foo!";
}
function evodialer_sms() {
	header('Content-type:  application/xml; charset=UTF-8');
	exit ('<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Message>
        I am not programmed to respond in that area.
    </Message>
</Response>');
}

function evodialer_status() {
	return true;
}

function evodialer_voice() {
	header('Content-type:  application/xml; charset=UTF-8');
	exit ('<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Say>
        I am not programmed to respond in that area.
    </Say>
</Response>');
}
// eGr5iEkRgNZKjPIUfK6jm0FDnca9SyWfh__ZaBcKbYdW - erik

add_action( 'rest_api_init', function () {

	register_rest_route('evodialer/v1', '/foo/(?P<id>\d+)', [
		'methods' => 'GET',
		'callback' => 'evodialer_endpoint',
		'permission_callback' => '__return_true'
		]);
	register_rest_route('evodialer/v1', '/sms', [
		'methods' => 'GET,POST',
		'callback' => 'evodialer_sms',
		'permission_callback' => '__return_true'
	]);
	register_rest_route('evodialer/v1', '/status', [
		'methods' => 'GET,POST',
		'callback' => 'evodialer_status',
		'permission_callback' => '__return_true'
	]);
	register_rest_route('evodialer/v1', '/voice', [
		'methods' => 'GET,POST',
		'callback' => 'evodialer_voice',
		'permission_callback' => '__return_true'
	]);

});


/*
 * Make ECT a separate plugin for Twilio.  So this plugin is mainly the front end and configurations & logic
 * whereas ECT provides the telephony
 *
 */

