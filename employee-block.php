<?php
/**
 * Plugin Name: Employee Block
 * Description: This plugins adds a new gutenberg block to display selected employees.
 * Version: 1.0
 * Author: Orkun Aybek
 * Author URI: https://github.com/orkunaybek
 **/

namespace Main;

// Exit if accessed directly
defined('ABSPATH') || exit;

if (!class_exists(\Main\Plugin::class) && is_readable(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

const EMPLOYEE_BLOCK_PLUGIN_FILE = __FILE__;

add_action(
    'plugins_loaded',
    static function () {
        // Boostrap the plugin
        if (class_exists(\Main\Plugin::class)) {
           new Plugin();
        }
    }
);

