<?php
/**
 * Configuration overrides for WP_ENV === 'development'
 */

use Roots\WPConfig\Config;

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_DISPLAY', false);
Config::define('WP_DEBUG_LOG', true);
Config::define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
Config::define('SCRIPT_DEBUG', true);
Config::define('WP_MEMORY_LIMIT', '1024M');
Config::define('WP_MAX_MEMORY_LIMIT', '1024M');

set_time_limit(300);
Config::define('DISALLOW_FILE_MODS', false);

error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE);
ini_set("error_reporting", E_ALL & ~E_DEPRECATED);

// Enable plugin and theme updates and installation from the admin

