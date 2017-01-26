<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message;
use Market\Module;
use Market\Model\ListingsTableTrait;

class PostController extends AbstractActionController
{
    use ListingsTableTrait;
    public function indexAction()
    {
        $data = $this->params()->fromPost();
        $form = $this->getServiceLocator()->get('market-post-form');
        $viewModel = new ViewModel(array('postForm' => $form, 'data' => $data));
        $viewModel->setTemplate('market/post/index.phtml');
        if ($this->getRequest()->isPost()) {
            $form->setData($data);
            $logger = $this->getServiceLocator()->get('application-logger');
            if ($form->isValid()) {
                $data = $form->getData();
                $this->sendEmailNotification($data['delete_code'], $data['title']);
                $this->listingsTable->saveData($data);
                $this->flashMessenger()->addMessage('Thanks for posting!');
                $logger->info('Posted new item: ' . $data['title']);
                $this->redirect()->toRoute('home');
            } else {
                if ($this->invalidCount()) {
                    $logger->alert('Exceeded max posting attempts');
                    return $this->redirect()->toRoute('home');
                }
                $invalidView = new ViewModel();
                $invalidView->setTemplate('market/post/invalid.phtml');
                $invalidView->addChild($viewModel, 'main');
                return $invalidView;
            }
        }
        return $viewModel;
    }

    /**
     * Checks session to see if max attempts has been exceeded
     * @return unknown
     */
    protected function invalidCount()
    {
        $invalid = FALSE;
        $session = $this->getServiceLocator()->get('application-session');
        $maxAttempts = $this->getServiceLocator()->get('market-max-attempts');
        if (isset($session->invalidCount)) {
            if ($session->invalidCount++ > $maxAttempts) {
                $session->invalidCount = 1;
                $this->flashMessenger()->addMessage('Unable to post ... please try again later');
                $invalid = TRUE;
            }
        } else {
            $session->invalidCount = 1;
        }
        return $invalid;
    }
    
    /**
     * Sends email notification
     * @param string $delCode
     * @param string $title
     */
    protected function sendEmailNotification($delCode, $title)
    {
        $emailInfo = $this->getServiceLocator()->get('application-email-info');
        $mailTransport = $this->getServiceLocator()->get('application-mail-transport');
        // send confirmation email with edit/delete code
        $emailMessage = new Message();
        // get "to" and "from" information from "email-info" service defined in email.local.php
        $emailMessage->addTo($emailInfo['to'])
        ->addFrom($emailInfo['from'])
        ->setSubject('Thanks for Posting to the Online Market!')
        ->setBody('Item posted: ' . $title . PHP_EOL
                  . 'To edit or delete your posting use this key: ' . $delCode)
        ->setEncoding('utf-8');
        return $mailTransport->send($emailMessage);          
    }
}
