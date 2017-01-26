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

class ViewController extends AbstractActionController
{
    use ListingsTableTrait;
        
    public function indexAction()
    {
        //$category = $this->params()->fromQuery('category');
        $category = $this->params()->fromRoute('category');
        $viewModel = new ViewModel(array('category' => $category,
                                         'list' => $this->listingsTable->getListingsByCategory($category)
        ));
        return $viewModel;
    }

    public function itemAction()
    {
        $itemId = (int) $this->params()->fromRoute('itemId');
        if (!$itemId) {
            $this->flashMessenger()->addMessage('Item Not Found');
            return $this->redirect()->toRoute('market');
        }
        return new ViewModel(array('itemId' => $itemId, 
                                   'item' => $this->listingsTable->getListingById($itemId)));
    }
}
