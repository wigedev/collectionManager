<?php
namespace Application\Module\Index\Controller;

use JasperFW\JasperFW\Module\ModuleController;

use function JasperFW\JasperFW\J;

/**
 * Class IndexController
 *
 * Default controller for the default module.
 *
 * @package Application\Module\Index\Controller
 */
class IndexController extends ModuleController
{
    /**
     * Default action for the default controller of the default module.
     */
    public function indexAction()
    {
        // Set a value that will be displayed in the template or view file.
        J()->response->setValue('pageTitle', 'Welcome');
    }

    public function loginAction()
    {

    }
}