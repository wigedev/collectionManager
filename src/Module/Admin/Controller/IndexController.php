<?php

namespace Application\Module\Admin\Controller;

use Application\Utility\Authentication\CMUser;
use JasperFW\JasperFW\Module\ModuleController;

/**
 * Class IndexController
 *
 * Main controller for the admin section of the system. The admin section will be a single page application so this
 * controller will handle all actions.
 *
 * @package Application\Module\Admin\Controller
 */
class IndexController extends ModuleController
{
    public static function canView(): bool
    {
        /** @var CMUser $user */
        $user = CMUser::i();
        return ($user->getUserType() === 'admin');
    }

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Shows the page
     */
    public function indexAction()
    {
        // Static page
    }
}