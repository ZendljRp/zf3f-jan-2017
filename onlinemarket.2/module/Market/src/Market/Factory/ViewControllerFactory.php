<?php
namespace Market\Factory;
use Market\Controller\ViewController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class ViewControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $sm = $controllerManager->getServiceLocator();
        $controller = new ViewController();
        $controller->setListingsTable($sm->get('listings-table'));
        return $controller;
    }
}