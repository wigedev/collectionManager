<?php
/**
 * Set configuration options here. Generally, service managers will look for an array element with their name. The
 * Core element is for global configurations, such as specifying the service managers that will be loaded. The default
 * configuration options present a minimal install that will allow a site to be up and running immediately.
 */

use JasperFW\JasperCore\Renderer\CLIRenderer;
use JasperFW\JasperCore\Renderer\HtmlRenderer;
use JasperFW\JasperCore\Renderer\JsonRenderer;
use JasperFW\JasperCore\Renderer\ViewHelper\MetaHelper;
use JasperFW\JasperCore\Renderer\ViewHelper\StylesheetHelper;
use JasperFW\JasperCore\Renderer\ViewHelper\TitleHelper;

return array(
    'framework' => [
        'version' => '1.0.0',
        'errorModule' => 'Index',
        'errorController' => 'Error',
    ],
    // Views control how different types of requests are displayed to the user. This lets a request for an html page, a
    // csv file and a json file all be handled by the same controller and action, and simply create the file in
    // different ways.
    'view' => array(
        'default_country' => 'us',
        'default_lang' => 'en-us',
        'default_view_type' => 'html',
        'default_layout_path' => 'layout',
        'default_layout_file' => '_default',
        'renderers' => array(
            'cli' => array( // Handler for requests from the command line
                'extensions' => array('c l i'), // A special extension that can only be hit programatically
                'handler' => CLIRenderer::class
            ),
            'html' => array(
                'extensions' => array('php', 'html', 'htm', '*'),
                'handler' => HtmlRenderer::class,
                'helpers' => array(
                    'meta' => MetaHelper::class,
                    'title' => TitleHelper::class,
                    'stylesheet' => StyleSheetHelper::class,
                )
            ),
            'json' => array(
                'extensions' => array('json'),
                'handler' => JsonRenderer::class
            ),
            //'csv' => array(
            //    'extensions' => array('csv'),
            //    'handler'    => CsvRenderer::class
            //),
        )
    ),
    // Routes
    'routes' => array(
        // For top level pages, this defaults to the Index module of the named controller.
        'default' => array(
            'route' => '/[:module:]',
            'constraints' => array(
                'module' => '[a-z]+',
            ),
            'defaults' => array(
                'module' => 'index',
                'controller' => 'index',
                'action' => 'index',
            ),
        ),
        // Error handling
        'errorHandling' => [
            'route' => '/error/error:code:',
            'constraints' => [
                'code' => '[0-9]{3}',
            ],
            'defaults' => [
                'module' => 'index',
                'controller' => 'index',
                'action' => 'error',
            ],
        ],
        // More standard, folder is the module, page is the controller, subpage can be the action.
        'mvc' => array(
            'route' => '/:module:/:controller:[/:action:]',
            'constraints' => array(
                'module' => '[a-z]+',
                'controller' => '[a-z]+',
                'action' => '[a-z]+',
            ),
            'defaults' => array(
                'module' => 'dashboard',
                'controller' => 'index',
                'action' => 'index'
            )
        ),
    ),
);