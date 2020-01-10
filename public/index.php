<?php
/**
 * Default loader for SimpleMVC site. This loader only does basic processing and setup before passing control off to
 * the framework itself for the heavy lifting.
 */

use WigeDev\JasperCore\Core;

use function WigeDev\JasperCore\FW;

/**
 * Set up relative paths. _ROOT_PATH_ is the path to the root of the application, and _SITE_PATH_ is the path to the
 * public folder.
 */
define('_ROOT_PATH_', dirname(__DIR__));
/**
 * Load the composer autoloader
 */
require_once(_ROOT_PATH_ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');
/**
 * Set up any features such as logging or dependency injection, and add them to the framework here.
 */
/**
 * Initialize the framework.
 */
Core::_init();
/**
 * Execute the request
 */
FW()->run();