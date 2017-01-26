<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Market for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Market\Model\ListingsTableTrait;

class IndexController extends AbstractActionController
{
    use ListingsTableTrait;
    public function indexAction()
    {
        $messages = array();
        if ($this->flashMessenger()->hasMessages()) {
            $messages = $this->flashMessenger()->getMessages();
        }
        $viewModel = new ViewModel(array('messages' => $messages, 'item' => $this->listingsTable->getLatestListing()));
        return $viewModel;
    }

    public function fooAction()
    {
        $data = array('name' => 'Doug', 'phone' => '111-222-3333', 'amount' => 99.99);
        $viewModel1 = new ViewModel($data);
        $viewModel1->setTemplate('market/index/foo');
        $viewModel2 = new ViewModel($data);
        $viewModel2->setTemplate('market/index/foo');
        $parentView = new ViewModel();
        $parentView->addChild($viewModel1, 'childView1');
        $parentView->addChild($viewModel2, 'childView2');
        $parentView->setTemplate('market/index/parent');
        return $parentView;
    }

}
