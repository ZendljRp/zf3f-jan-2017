<?php
namespace Market\Factory;

use Market\Controller\DeleteController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DeleteControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $sm = $controllerManager->getServiceLocator();
    	$controller = new DeleteController();
        $controller->setListingsTable($sm->get('listings-table'));
        $controller->setDeleteForm($sm->get('market-delete-form'));
        $controller->setDeleteFormFilter($sm->get('market-delete-filter'));
        return $controller;
    }
}
