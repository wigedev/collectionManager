<?php
namespace Application\Module\Index\Controller;

use Application\Utility\Authentication\CMUser;
use JasperFW\Authentication\Exceptions\AccountLockoutException;
use JasperFW\Authentication\Exceptions\AuthenticationException;
use JasperFW\JasperFW\Module\ModuleController;
use JasperFW\Validator\Constraint\Required;
use JasperFW\Validator\Exception\InvalidInputException;
use JasperFW\Validator\InputSources;
use JasperFW\Validator\ValidationSet;
use JasperFW\Validator\Validator\TextString;

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
        J()->response->setViewType('json');
        $vs = new ValidationSet();
        $vs->addValidator(new TextString('username', InputSources::POST, [new Required()]));
        $vs->addValidator(new TextString('password', InputSources::POST, [new Required()]));
        if (!$vs->isValid()) {
            J()->response->addMessage(implode(', ', $vs->getErrorMessages()));
            return;
        }
        $dbc = J()->c->get('dbc');
        try {
            CMUser::i()->authenticate($dbc, $vs->getFieldValue('username'), $vs->getFieldValue('password'));
        } catch (AccountLockoutException $e) {
            J()->response->addMessage($e->getMessage());
            return;
        } catch (AuthenticationException $e) {
            J()->response->addMessage($e->getMessage());
            return;
        } catch (InvalidInputException $e) {
            J()->response->addMessage($e->getMessage());
            return;
        }
        J()->response->setData(['username' => CMUser::i()->getUsername()]);
    }
}