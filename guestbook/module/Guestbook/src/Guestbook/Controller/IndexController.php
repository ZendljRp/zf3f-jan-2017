<?php
namespace Guestbook\Controller;

use Guestbook\Form\Entry as EntryForm;
use Guestbook\Service\Entry;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Guestbook\Controller
 */
class IndexController extends AbstractActionController
{
    /**
     * @var Entry
     */
    private $entryService;

    /**
     * @var EntryForm
     */
    private $entryForm;

    /**
     * IndexController constructor.
     * @param EntryForm $entryForm
     */
    public function __construct(EntryForm $entryForm, Entry $entryService)
    {
        $this->entryForm = $entryForm;
        $this->entryService = $entryService;
    }

    /**
     * @return array|\Zend\Http\Response|ViewModel
     */
    public function indexAction()
    {
        /** @var Request|RequestInterface $request */
        $request = $this->getRequest();

        if ($request->isPost()) {
            $entry = $this->entryService->add($this->params()->fromPost());
        }

        return new ViewModel([
            // 'form' => $entryForm,
            'entryForm' => $this->entryForm,
            'entries'   => $this->entryService->findAll()
        ]);
    }
}
