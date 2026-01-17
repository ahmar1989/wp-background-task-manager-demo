<?php

/**
 * Plugin Name: WP Background Task Manager (Demo)
 * Description: Demonstrates a safe, chunked background task pattern using WP-Cron.
 * Version:     1.0.0
 * Author:      Ahmar Ali
 * License:     GPL-2.0+
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Plugin constants
 */
define('WPBTM_VERSION', '1.0.0');
define('WPBTM_PLUGIN_FILE', __FILE__);
define('WPBTM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WPBTM_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Load required files
 */
require_once WPBTM_PLUGIN_DIR . 'includes/class-plugin.php';
require_once WPBTM_PLUGIN_DIR . 'includes/class-task-manager.php';
require_once WPBTM_PLUGIN_DIR . 'includes/class-cron-runner.php';
require_once WPBTM_PLUGIN_DIR . 'includes/class-logger.php';

if (is_admin()) {
    require_once WPBTM_PLUGIN_DIR . 'admin/class-admin-page.php';
}

/**
 * Initialize the plugin
 */
function wpbtm_init()
{
    $plugin = new WPBTM_Plugin();
    $plugin->init();
}
add_action('plugins_loaded', 'wpbtm_init');
