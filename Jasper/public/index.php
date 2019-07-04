<?php
/**
 * Default loader for SimpleMVC site. This loader only does basic processing and setup before passing control off to
 * the framework itself for the heavy lifting.
 */

use WigeDev\SimpleMVC\Core;

/**
 * Set up relative paths. _ROOT_PATH_ is the path to the root of the application, and _SITE_PATH_ is the path to the
 * public folder.
 */
define('_ROOT_PATH_', __DIR__ . DIRECTORY_SEPARATOR . '..');

/**
 * Load the composer autoloader
 */
require_once(_ROOT_PATH_ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

/**
 * Initialize the framework.
 */
Core::_init()->run();