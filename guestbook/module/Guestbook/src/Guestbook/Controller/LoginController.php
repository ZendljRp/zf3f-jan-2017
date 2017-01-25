<?php
namespace Guestbook\Controller;

use Guestbook\Auth\Adapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class LoginController
 * @package Guestbook\Controller
 */
class LoginController extends AbstractActionController
{
    /**
     * @return array|\Zend\Http\Response|ViewModel
     */
    // tag::loginAction[]
    public function LoginAction()
    {
        if ($this->request->isPost()) {
            $authAdapter = new Adapter(
                $this->params()->fromPost('username'),
                $this->params()->fromPost('password')
            );
            $result = (new AuthenticationService())->authenticate($authAdapter);

            if (!$result->isValid()) {
                foreach ($result->getMessages() as $message) {
                    echo "$message\n";
                }
            } else {
                // Authentication succeeded; The identity ($username) is stored in the session
                // $result->getIdentity() === $auth->getIdentity()
                // $result->getIdentity() === $username
            }
        }
    }
    // end::loginAction[]

    // tag::checkAuthResponse[]
    public function checkAuthResponse(Result $result)
    {
        switch ($result->getCode()) {
            case Result::SUCCESS:
                // Do stuff for successful authentication
                break;
            case Result::FAILURE_IDENTITY_NOT_FOUND:
                // Do stuff for a non-existent identity
                break;
            case Result::FAILURE_CREDENTIAL_INVALID:
                // Do stuff for invalid credentials
                break;
            case Result::FAILURE_IDENTITY_AMBIGUOUS:
                // Do stuff for an ambiguous identity
                break;
            case Result::FAILURE_UNCATEGORIZED:
            default:
                // Do stuff for any other failure type

        }
    }
    // end::checkAuthResponse[]
}
