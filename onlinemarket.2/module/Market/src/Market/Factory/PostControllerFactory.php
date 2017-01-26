<?php
namespace Market\Factory;
use Market\Controller\PostController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class PostControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $sm = $controllerManager->getServiceLocator();
        $controller = new PostController();
        $controller->setListingsTable($sm->get('listings-table'));
        return $controller;
    }
}