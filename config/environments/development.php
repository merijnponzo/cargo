<?php
/**
 * Configuration overrides for WP_ENV === 'development'
 */

use function Env\env;
use Roots\WPConfig\Config;

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_DISPLAY', false);
Config::define('WP_DEBUG_LOG', env('WP_DEBUG_LOG') ?? true);
Config::define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
Config::define('SCRIPT_DEBUG', true);
Config::define('DISALLOW_INDEXING', true);
Config::define('WP_MEMORY_LIMIT', '1024M');


ini_set('display_errors', '1');

Config::define('DISALLOW_FILE_MODS', false);
// Config::define('DISALLOW_INDEXING', true);
Config::define('OTGS_DISABLE_AUTO_UPDATES', false);