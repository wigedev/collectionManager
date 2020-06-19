<?php

namespace Application\Module\Index\Controller;

use JasperFW\JasperFW\Module\ModuleController;

/**
 * Class ErrorController
 * @package Application\Module\Index\Controller
 */
class ErrorController extends ModuleController
{
    public static function canView(): bool
    {
        return true;
    }

    public function __construct()
    {
        parent::__construct();
    }
}