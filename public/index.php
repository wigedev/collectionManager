<?php
/**
 * Default loader for SimpleMVC site. This loader only does basic processing and setup before passing control off to
 * the framework itself for the heavy lifting.
 */

use DI\ContainerBuilder;
use JasperFW\JasperFW\Jasper;
use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\GroupHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use Monolog\Processor\WebProcessor;

use function JasperFW\JasperFW\J;

/**
 * Set up relative paths. _ROOT_PATH_ is the path to the root of the application, and _SITE_PATH_ is the path to the
 * public folder.
 */
define('_ROOT_PATH_', dirname(__DIR__));
/**
 * TODO: Set up custom logic to determine if this is production, test or development environment
 * Please note that "test" does not mean unit tests. PHPUnit should not use this file as a bootstrapper.
 */
if (!defined('ENVIRONMENT')) {
    if (isset($_SERVER['HTTP_HOST'])) {
        if ($_SERVER['HTTP_HOST'] === 'localhost') {
            /** Environment - test, cli or production */
            define('ENVIRONMENT', 'test');
        } else {
            /** Environment - test, cli or production */
            define('ENVIRONMENT', 'production');
        }
    } else {
        /** Environment - test, cli or production */
        define('ENVIRONMENT', 'cli');
    }
}
/**
 * Load the composer autoloader
 */
require_once(_ROOT_PATH_ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');
/**
 * Set up environment variables
 */
Jasper::bootstrap();
/**
 * Set up any features such as logging or dependency injection, and add them to the framework here.
 */
setUpServices();
/**
 * Add config files
 */
Jasper::addConfigurationPath(_ROOT_PATH_ . DS . 'config' . DS . 'config.php');
/**
 * Initialize the framework.
 */
Jasper::_init();
/**
 * Execute the request
 */
J()->run();

/**
 * Set up critical services in a function so that the underlying variables are kept out of public scope.
 *
 * TODO: Customize your logging, dependency injection, etc. here.
 */
function setUpServices()
{
    // Configure Monolog
    $logger = new Logger('logger');
    // Stream Handler logs entries directly to the file system
    $logPath = _ROOT_PATH_ . DS . 'logs' . DS . 'log-' . date('Y-m-d') . '.txt';
    $logHandlers = [];
    $streamHandler = new StreamHandler($logPath);
    $streamHandler->pushProcessor(new WebProcessor());
    // Finger Handler wraps StreamHangler, if a request triggers a WARNING or greater entry, the system will write all
    // entries to the file. Otherwise no entries will be generated.
    $fingerHandler = new FingersCrossedHandler($streamHandler, Logger::WARNING);
    $logHandlers[] = $fingerHandler;
    // The console handler will output log entries to the browser console IF the server is in debug mode
    if (ENVIRONMENT === 'test') {
        $consoleHandler = new BrowserConsoleHandler();
        $logHandlers[] = $consoleHandler;
    }
    // The group handler sends all generated entries to each logger in the group, so in a debug situation, entries will
    // go to the file system and to the browser.
    $groupHandler = new GroupHandler($logHandlers);
    $logger->pushHandler($groupHandler);
    $logger->pushProcessor(new PsrLogMessageProcessor());
    // Add the logger to Jasper
    Jasper::setLogger($logger);

    // Set up the dependency injection container
    $containerBuilder = new ContainerBuilder();
    // In a production environment, set up caching and use the main
    if (ENVIRONMENT === 'production' || ENVIRONMENT === 'cli') {
        $containerBuilder->enableCompilation(_ROOT_PATH_ . DS . 'ditemp');
        $containerBuilder->writeProxiesToFile(true, _ROOT_PATH_ . DS . 'ditemp' . DS . 'proxies');
        $containerBuilder->addDefinitions(_ROOT_PATH_ . DS . 'config' . DS . 'dependencies.php');
    } else {
        // You can have a seperate set of dependencies if you are running in a test environment.
        $containerBuilder->addDefinitions(_ROOT_PATH_ . DS . 'config' . DS . 'dependencies.php');
    }
    try {
        Jasper::setDIContainer($containerBuilder->build());
    } catch (Exception $e) {
        echo('Unable to run dependecy injection container. ' . $e->getMessage());
        exit();
    }
}