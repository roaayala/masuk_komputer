<?php
/**
 * Function Loader
 * @package KarsaStart
 */

if (!defined('ABSPATH')) {
  exit;
}

$autoloader = __DIR__ . '/vendor/autoload_packages.php';
if (is_file($autoloader)) {
  require_once $autoloader;
}

define('THEME_DIR', get_template_directory());
define('THEME_URI', get_template_directory_uri());
define('THEME_VERSION', '1.0.0');


// Autoload core and project
$include_dirs = [
  THEME_DIR . '/inc/core/*.php',
  THEME_DIR . '/inc/project/*.php',
];

foreach ($include_dirs as $pattern) {
  $files = glob($pattern) ?: [];
  foreach ($files as $filepath) {
    if (is_file($filepath)) {
      require_once $filepath;
    }
  }
}

